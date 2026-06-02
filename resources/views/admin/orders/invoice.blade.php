<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice {{ $order->order_number }}</title>
    <style>
        body { font-family: Arial, sans-serif; color: #1e293b; max-width: 800px; margin: 2rem auto; padding: 2rem; }
        .header { display: flex; justify-content: space-between; align-items: start; border-bottom: 2px solid #dc2626; padding-bottom: 1rem; }
        .brand { font-size: 24px; font-weight: bold; color: #dc2626; }
        h1 { font-size: 18px; margin: 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 1.5rem; font-size: 13px; }
        th, td { border-bottom: 1px solid #e2e8f0; padding: 10px; text-align: left; }
        th { background: #f8fafc; font-size: 11px; text-transform: uppercase; color: #64748b; }
        .totals { width: 280px; margin-left: auto; margin-top: 1rem; font-size: 13px; }
        .totals .row { display: flex; justify-content: space-between; padding: 4px 0; }
        .totals .total { font-weight: bold; font-size: 15px; border-top: 2px solid #1e293b; padding-top: 6px; margin-top: 6px; }
        .meta { display: flex; justify-content: space-between; margin-top: 1.5rem; font-size: 13px; }
        .meta div { width: 48%; }
        .print { margin-top: 2rem; }
        @media print { .print { display: none; } }
    </style>
</head>
<body>
    <div class="header">
        <div>
            <div class="brand">{{ \App\Models\Setting::get('site_name', 'Vehicle Battery Store') }}</div>
            <p style="font-size: 12px; color: #64748b; margin: 4px 0;">{{ \App\Models\Setting::get('site_tagline', '') }}</p>
        </div>
        <div style="text-align: right;">
            <h1>INVOICE</h1>
            <p style="font-size: 12px; margin: 4px 0;">#{{ $order->order_number }}</p>
            <p style="font-size: 11px; color: #64748b; margin: 0;">{{ $order->created_at->format('d M Y') }}</p>
        </div>
    </div>

    <div class="meta">
        <div>
            <p style="font-size: 11px; text-transform: uppercase; color: #64748b; margin: 0;">Bill to</p>
            <p style="margin: 4px 0; font-weight: bold;">{{ $order->billing_name }}</p>
            <p style="margin: 0; font-size: 12px;">{{ $order->billing_phone }}</p>
            @if($order->billing_email)<p style="margin: 0; font-size: 12px;">{{ $order->billing_email }}</p>@endif
            <p style="margin-top: 4px; font-size: 12px;">
                {{ $order->billing_line1 }}@if($order->billing_line2)<br>{{ $order->billing_line2 }}@endif<br>
                {{ $order->billing_city }}, {{ $order->billing_state }} {{ $order->billing_pincode }}
            </p>
        </div>
        <div>
            <p style="font-size: 11px; text-transform: uppercase; color: #64748b; margin: 0;">Ship to</p>
            <p style="margin: 4px 0; font-weight: bold;">{{ $order->shipping_name }}</p>
            <p style="margin: 0; font-size: 12px;">{{ $order->shipping_phone }}</p>
            <p style="margin-top: 4px; font-size: 12px;">
                {{ $order->shipping_line1 }}@if($order->shipping_line2)<br>{{ $order->shipping_line2 }}@endif<br>
                {{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_pincode }}
            </p>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Item</th>
                <th style="text-align: center; width: 80px;">Qty</th>
                <th style="text-align: right; width: 100px;">Price</th>
                <th style="text-align: right; width: 110px;">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
                <tr>
                    <td>
                        <strong>{{ $item->product_name }}</strong><br>
                        <span style="font-size: 11px; color: #64748b;">{{ $item->product_sku }}</span>
                    </td>
                    <td style="text-align: center;">{{ $item->quantity }}</td>
                    <td style="text-align: right;">₹{{ number_format((float) ($item->offer_price ?? $item->price), 2) }}</td>
                    <td style="text-align: right;">₹{{ number_format((float) $item->total, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="totals">
        <div class="row"><span>Subtotal</span><span>₹{{ number_format((float) $order->subtotal, 2) }}</span></div>
        @if((float) $order->exchange_discount > 0)<div class="row"><span>Exchange discount</span><span>-₹{{ number_format((float) $order->exchange_discount, 2) }}</span></div>@endif
        @if((float) $order->discount > 0)<div class="row"><span>Coupon ({{ $order->coupon_code }})</span><span>-₹{{ number_format((float) $order->discount, 2) }}</span></div>@endif
        <div class="row"><span>Delivery</span><span>{{ (float) $order->delivery_charge > 0 ? '₹' . number_format((float) $order->delivery_charge, 2) : 'Free' }}</span></div>
        @if((float) $order->tax_amount > 0)<div class="row"><span>Tax</span><span>₹{{ number_format((float) $order->tax_amount, 2) }}</span></div>@endif
        <div class="row total"><span>Total</span><span>₹{{ number_format((float) $order->total, 2) }}</span></div>
        <div class="row" style="margin-top: 6px;"><span style="color: #64748b;">Payment</span><span>{{ strtoupper($order->payment_method) }} · {{ ucfirst($order->payment_status) }}</span></div>
    </div>

    <div style="margin-top: 3rem; font-size: 11px; color: #64748b; text-align: center; border-top: 1px solid #e2e8f0; padding-top: 1rem;">
        Thank you for your business.
    </div>

    <div class="print">
        <button onclick="window.print()" style="background: #dc2626; color: white; border: 0; padding: 8px 16px; border-radius: 6px; cursor: pointer;">Print invoice</button>
    </div>
</body>
</html>
