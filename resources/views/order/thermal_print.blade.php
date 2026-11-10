<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS Receipt - #{{ $order['order_id'] ?? $order['id'] }}</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Courier New', Courier, monospace, 'Segoe UI', Tahoma, sans-serif;
        }
        body {
            background-color: #f3f4f6;
            display: flex;
            justify-content: center;
            padding: 20px;
        }
        .receipt-container {
            width: 80mm;
            background: #fff;
            padding: 12px 14px;
            border: 1px solid #ddd;
            box-shadow: 0 4px 10px rgba(0,0,0,0.06);
            color: #000;
            font-size: 12px;
            line-height: 1.35;
        }
        .header {
            text-align: center;
            border-bottom: 1px dashed #000;
            padding-bottom: 8px;
            margin-bottom: 8px;
        }
        .store-title {
            font-size: 16px;
            font-weight: 800;
            text-transform: uppercase;
            margin-bottom: 2px;
        }
        .store-sub {
            font-size: 11px;
            color: #333;
        }
        .meta-table {
            width: 100%;
            margin-bottom: 8px;
            font-size: 11px;
        }
        .meta-table td {
            padding: 2px 0;
        }
        .divider {
            border-top: 1px dashed #000;
            margin: 6px 0;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin: 6px 0;
            font-size: 11px;
        }
        .items-table th {
            text-align: left;
            border-bottom: 1px solid #000;
            padding: 4px 0;
            font-weight: 700;
        }
        .items-table td {
            padding: 4px 0;
            vertical-align: top;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .summary-table {
            width: 100%;
            margin-top: 6px;
            font-size: 11px;
        }
        .summary-table td {
            padding: 2px 0;
        }
        .grand-total {
            font-size: 14px;
            font-weight: 900;
            border-top: 1px dashed #000;
            border-bottom: 1px dashed #000;
            padding: 4px 0;
        }
        .courier-box {
            margin-top: 8px;
            padding: 6px;
            border: 1px solid #000;
            text-align: center;
            font-size: 11px;
            font-weight: 700;
            background: #fafafa;
        }
        .barcode {
            margin: 10px auto 4px auto;
            text-align: center;
            letter-spacing: 4px;
            font-size: 15px;
            font-weight: 900;
        }
        .footer {
            text-align: center;
            margin-top: 10px;
            font-size: 10px;
            color: #444;
            border-top: 1px dashed #000;
            padding-top: 8px;
        }
        .no-print {
            position: fixed;
            top: 15px;
            right: 15px;
            display: flex;
            gap: 10px;
            z-index: 999;
        }
        .btn-print {
            background: #10b981;
            color: #fff;
            border: none;
            padding: 10px 18px;
            border-radius: 6px;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .btn-close-window {
            background: #6b7280;
            color: #fff;
            border: none;
            padding: 10px 18px;
            border-radius: 6px;
            font-weight: 700;
            cursor: pointer;
        }
        @media print {
            body {
                background: #fff;
                padding: 0;
            }
            .no-print {
                display: none !important;
            }
            .receipt-container {
                width: 100% !important;
                border: none !important;
                box-shadow: none !important;
                padding: 0 !important;
            }
            @page {
                size: 80mm auto;
                margin: 0;
            }
        }
    </style>
</head>
<body>

    <div class="no-print">
        <button class="btn-print" onclick="window.print()">🖨️ প্রিন্ট করুন (Print POS)</button>
        <button class="btn-close-window" onclick="window.close()">বন্ধ করুন (Close)</button>
    </div>

    <div class="receipt-container">
        <!-- Store Header -->
        <div class="header">
            <div class="store-title">{{ $store->name ?? 'eCommerceGo Store' }}</div>
            <div class="store-sub">{{ $store->email ?? '' }}</div>
            <div class="store-sub">মেমো / ক্যাশ রসিদ (Cash Memo)</div>
        </div>

        <!-- Order & Customer Details -->
        <table class="meta-table">
            <tr>
                <td><strong>ইনভয়েস:</strong> #{{ $order['order_id'] ?? $order['id'] }}</td>
                <td class="text-right"><strong>তারিখ:</strong> {{ date('d-m-Y h:i A', strtotime($order['created_at'])) }}</td>
            </tr>
            @php
                $delivery = is_array($order['delivery_informations']) ? $order['delivery_informations'] : [];
                $billing = is_array($order['billing_informations']) ? $order['billing_informations'] : [];
                $custName = $delivery['name'] ?? ($billing['name'] ?? 'অনলাইন গ্রাহক');
                $custPhone = $delivery['phone'] ?? ($delivery['billing_user_telephone'] ?? ($billing['phone'] ?? ''));
                $custAddress = $delivery['address'] ?? ($billing['address'] ?? '');
                $custCity = $delivery['city'] ?? ($billing['city'] ?? '');
            @endphp
            <tr>
                <td colspan="2"><strong>গ্রাহক:</strong> {{ $custName }}</td>
            </tr>
            <tr>
                <td colspan="2"><strong>মোবাইল:</strong> {{ $custPhone }}</td>
            </tr>
            <tr>
                <td colspan="2"><strong>ঠিকানা:</strong> {{ $custAddress }} {{ $custCity ? '('.$custCity.')' : '' }}</td>
            </tr>
            <tr>
                <td><strong>পেমেন্ট:</strong> {{ $order['paymnet_type'] ?? 'Cash on Delivery (COD)' }}</td>
                <td class="text-right"><strong>স্ট্যাটাস:</strong> {{ $order['order_status_text'] ?? 'পেন্ডিং' }}</td>
            </tr>
        </table>

        <!-- Itemized Products -->
        <table class="items-table">
            <thead>
                <tr>
                    <th style="width: 50%;">পণ্য</th>
                    <th class="text-center" style="width: 15%;">পরিমাণ</th>
                    <th class="text-right" style="width: 35%;">মোট (৳)</th>
                </tr>
            </thead>
            <tbody>
                @if(!empty($order['product']))
                    @foreach($order['product'] as $prod)
                        <tr>
                            <td>
                                <strong>{{ $prod['name'] ?? 'Product' }}</strong>
                                @if(!empty($prod['variant_name']))
                                    <div style="font-size: 10px; color: #555;">({{ $prod['variant_name'] }})</div>
                                @endif
                            </td>
                            <td class="text-center">{{ $prod['quantity'] ?? 1 }}</td>
                            <td class="text-right">৳{{ number_format(($prod['price'] ?? 0) * ($prod['quantity'] ?? 1), 2) }}</td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>

        <!-- Summary Totals -->
        <div class="divider"></div>
        <table class="summary-table">
            <tr>
                <td>সাবটোটাল (Subtotal):</td>
                <td class="text-right">৳{{ number_format($order['sub_total'] ?? 0, 2) }}</td>
            </tr>
            @if(!empty($order['coupon_price']) && $order['coupon_price'] > 0)
            <tr>
                <td>ডিসকাউন্ট (Discount):</td>
                <td class="text-right">-৳{{ number_format($order['coupon_price'], 2) }}</td>
            </tr>
            @endif
            <tr>
                <td>ডেলিভারি চার্জ (Delivery):</td>
                <td class="text-right">৳{{ number_format($order['delivered_charge'] ?? 0, 2) }}</td>
            </tr>
            <tr class="grand-total">
                <td><strong>সর্বমোট আদায় (COD Collectible):</strong></td>
                <td class="text-right"><strong>৳{{ number_format($order['final_price'] ?? 0, 2) }}</strong></td>
            </tr>
        </table>

        <!-- Courier Details if Assigned -->
        @if(!empty($order['courier_name']))
            <div class="courier-box">
                <div>কুরিয়ার পার্টনার: <strong>{{ $order['courier_name'] }}</strong></div>
                @if(!empty($order['courier_tracking_code']))
                    <div>ট্র্যাকিং আইডি: <strong>{{ $order['courier_tracking_code'] }}</strong></div>
                @endif
            </div>
        @endif

        <!-- Barcode / Reference -->
        <div class="barcode">
            *ORD-{{ $order['order_id'] ?? $order['id'] }}*
        </div>

        <!-- Footer -->
        <div class="footer">
            <div>আমাদের সাথে কেনাকাটা করার জন্য ধন্যবাদ!</div>
            <div>যেকোনো প্রয়োজনে যোগাযোগ করুন: {{ $store->email ?? '' }}</div>
            <div style="margin-top: 4px; font-size: 9px; color: #888;">Powered by edokanpro Cloud SaaS</div>
        </div>
    </div>

    <script>
        // Auto trigger print when loaded
        window.onload = function() {
            setTimeout(function() {
                window.print();
            }, 400);
        };
    </script>
</body>
</html>

