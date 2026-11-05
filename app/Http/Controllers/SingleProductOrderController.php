<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\Order;
use App\Models\OrderBillingDetail;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Utility;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class SingleProductOrderController extends Controller
{
    /**
     * Handle fast 1-click Cash on Delivery orders from Single Product Landing Page
     */
    public function fastOrder(Request $request, $storeSlug = null)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:30',
            'delivery_address' => 'required|string|max:1000',
        ]);

        // Find store
        $store = null;
        if (!empty($storeSlug)) {
            $store = Store::where('slug', $storeSlug)->first();
        }
        if (!$store) {
            $store = getStore($storeSlug);
        }
        if (!$store) {
            $store = Store::first();
        }

        if (!$store) {
            if ($request->ajax()) {
                return response()->json(['status' => 'error', 'message' => 'স্টোর পাওয়া যায়নি।'], 404);
            }
            return redirect()->back()->with('error', 'Store not found.');
        }

        // Find product
        $productId = $request->product_id;
        $product = null;
        if (!empty($productId)) {
            $product = Product::where('store_id', $store->id)->where('id', $productId)->first();
        }
        if (!$product) {
            $product = Product::where('store_id', $store->id)->first();
        }

        // Determine price
        $basePrice = 950;
        $productName = 'প্রিমিয়াম অর্গানিক পণ্য';
        $coverImage = '';

        if ($product) {
            $productName = $product->name;
            $coverImage = $product->cover_image_url ?? $product->cover_image_path ?? '';
            $basePrice = !empty($product->sale_price) && $product->sale_price > 0 ? (float)$product->sale_price : (float)$product->price;
            if ($basePrice <= 0) {
                $basePrice = (float)$product->price > 0 ? (float)$product->price : 950;
            }
        }

        // Package Calculation
        $qty = (int)($request->order_package ?? 1);
        if ($qty < 1) $qty = 1;

        if ($qty == 2) {
            // Special deal: 2 packs with 100 Tk discount
            $subtotal = ($basePrice * 2) - 100;
        } else {
            $subtotal = $basePrice * $qty;
        }

        // Delivery Charge
        $shippingArea = $request->shipping_area ?? 'dhaka';
        $themeSettings = getThemeSetting($store->id, $store->theme_id);
        $dhakaCost = (float)($themeSettings['delivery_charge_dhaka'] ?? 70);
        $outsideCost = (float)($themeSettings['delivery_charge_outside'] ?? 130);
        $deliveryCost = ($shippingArea == 'outside_dhaka') ? $outsideCost : $dhakaCost;

        $grandTotal = $subtotal + $deliveryCost;

        // Generate Order ID
        $orderIdStr = '0' . date('YmdHis') . rand(10, 99);

        // Product JSON
        $productItems = [
            [
                'product_id' => $product->id ?? 1,
                'product_name' => $productName,
                'image' => $coverImage,
                'price' => $basePrice,
                'qty' => $qty,
                'subtotal' => $subtotal,
            ]
        ];

        // Create Order
        $order = new Order();
        $order->product_order_id = $orderIdStr;
        $order->order_date = Carbon::now();
        $order->customer_id = 0;
        $order->is_guest = 1;
        $order->product_id = (string)($product->id ?? 1);
        $order->product_json = json_encode($productItems);
        $order->product_price = $subtotal;
        $order->coupon_price = 0;
        $order->delivery_price = $deliveryCost;
        $order->tax_price = 0;
        $order->final_price = $grandTotal;
        $order->payment_comment = 'Single Product Fast 1-Click COD Order';
        $order->payment_type = 'cod';
        $order->payment_status = 'Unpaid';
        $order->product_order_status = 0; // Pending
        $order->delivered_status = 0; // Pending
        $order->delivery_id = 0;
        $order->delivery_comment = ($shippingArea == 'outside_dhaka') ? 'ঢাকার বাইরে ক্যাশ অন ডেলিভারি' : 'ঢাকার ভেতরে হোম ডেলিভারি';
        $order->additional_note = 'প্যাকেজ: ' . ($qty == 2 ? '২টি (ডাবল প্যাক)' : '১টি (সিঙ্গেল প্যাক)');
        $order->store_id = $store->id;
        $order->save();

        // Create Billing / Delivery Detail
        $billing = new OrderBillingDetail();
        $billing->order_id = $order->id;
        $billing->product_order_id = $order->product_order_id;
        $billing->first_name = $request->customer_name;
        $billing->last_name = '';
        $billing->email = $request->customer_email ?? ($request->customer_phone . '@guest.customer');
        $billing->telephone = $request->customer_phone;
        $billing->address = $request->delivery_address;
        $billing->delivery_address = $request->delivery_address;
        $billing->country = 'Bangladesh';
        $billing->delivery_country = 'Bangladesh';
        $billing->state = ($shippingArea == 'outside_dhaka') ? 'Outside Dhaka' : 'Dhaka';
        $billing->delivery_state = ($shippingArea == 'outside_dhaka') ? 'Outside Dhaka' : 'Dhaka';
        $billing->city = ($shippingArea == 'outside_dhaka') ? 2 : 1;
        $billing->delivery_city = ($shippingArea == 'outside_dhaka') ? 2 : 1;
        $billing->save();

        // Reduce stock if enabled
        if ($product && $product->track_stock == 1 && $product->product_stock > 0) {
            $product->product_stock = max(0, $product->product_stock - $qty);
            $product->save();
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'আপনার অর্ডারটি সফলভাবে সম্পন্ন হয়েছে!',
                'order_id' => $order->product_order_id,
                'total_amount' => $order->final_price,
                'customer_name' => $request->customer_name,
                'customer_phone' => $request->customer_phone,
            ]);
        }

        return redirect()->route('order.complete', [
            'storeSlug' => $store->slug,
            'data' => ['order_id' => $order->id]
        ])->with('success', 'আপনার অর্ডারটি সফলভাবে সম্পন্ন হয়েছে!');
    }
}

