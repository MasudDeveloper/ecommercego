<?php

namespace App\Http\Controllers;

use App\Models\AbandonedCart;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbandonedCartController extends Controller
{
    /**
     * API: Auto-Capture Leads when customer types phone on landing page checkout
     */
    public function captureLead(Request $request)
    {
        $phone = preg_replace('/[^0-9]/', '', (string)$request->input('phone', ''));
        if (strlen($phone) < 11) {
            return response()->json(['success' => false, 'message' => 'Invalid phone number']);
        }

        $storeSlug = $request->input('store_slug');
        $store = Store::where('slug', $storeSlug)->first();
        $storeId = $store ? $store->id : (getCurrentStore() ?: 1);

        $name = trim((string)$request->input('name', ''));
        $address = trim((string)$request->input('address', ''));
        $productName = trim((string)$request->input('product_name', ''));
        $price = (float)$request->input('price', 0);

        $cart = AbandonedCart::updateOrCreate(
            [
                'store_id' => $storeId,
                'customer_phone' => $phone,
                'status' => 'abandoned',
            ],
            [
                'customer_name' => !empty($name) ? $name : 'অনলাইন ভিজিটর',
                'customer_address' => $address,
                'product_name' => !empty($productName) ? $productName : 'স্টোর পণ্য',
                'product_price' => $price,
                'ip_address' => $request->ip(),
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Lead captured successfully',
            'cart_id' => $cart->id,
        ]);
    }

    /**
     * Merchant Dashboard: List Abandoned Carts
     */
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $storeId = getCurrentStore() ?: 1;
        $carts = AbandonedCart::where('store_id', $storeId)
            ->latest()
            ->paginate(15);

        $totalAbandoned = AbandonedCart::where('store_id', $storeId)->where('status', 'abandoned')->count();
        $totalRecovered = AbandonedCart::where('store_id', $storeId)->where('status', 'recovered')->count();

        return view('abandoned_carts.index', compact('carts', 'totalAbandoned', 'totalRecovered'));
    }

    /**
     * Mark Abandoned Cart as Recovered
     */
    public function markRecovered($id)
    {
        $cart = AbandonedCart::findOrFail($id);
        $cart->update(['status' => 'recovered']);

        return back()->with('success', 'লিডটি সফলভাবে "রিকভার্ড (Recovered)" হিসেবে চিহ্নিত করা হয়েছে!');
    }

    /**
     * Delete Abandoned Cart Record
     */
    public function destroy($id)
    {
        $cart = AbandonedCart::findOrFail($id);
        $cart->delete();

        return back()->with('success', 'রেকর্ডটি সফলভাবে মুছে ফেলা হয়েছে।');
    }
}

