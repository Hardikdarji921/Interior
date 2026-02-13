<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Quotation #{{ $quote_number }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; line-height: 1.6; color: #333; }
        .header { border-bottom: 3px solid #dfa667; padding-bottom: 20px; margin-bottom: 30px; }
        .logo { font-size: 24px; font-weight: bold; color: #dfa667; }
        .company-info { text-align: right; font-size: 11px; }
        .quote-title { font-size: 20px; color: #dfa667; margin: 20px 0; }
        .info-grid { display: table; width: 100%; margin-bottom: 20px; }
        .info-cell { display: table-cell; width: 50%; vertical-align: top; }
        .label { font-weight: bold; color: #666; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th { background: #dfa667; color: white; padding: 10px; text-align: left; }
        td { padding: 10px; border-bottom: 1px solid #ddd; }
        .text-right { text-align: right; }
        .totals { margin-top: 20px; width: 300px; margin-left: auto; }
        .totals td { border: none; padding: 5px 10px; }
        .grand-total { font-size: 16px; font-weight: bold; color: #dfa667; border-top: 2px solid #dfa667; }
        .footer { margin-top: 50px; padding-top: 20px; border-top: 1px solid #ddd; font-size: 10px; color: #666; text-align: center; }
        .color-box { display: inline-block; width: 12px; height: 12px; border-radius: 50%; margin-right: 5px; vertical-align: middle; }
    </style>
</head>
<body>
    <div class="header">
        <table width="100%">
            <tr>
                <td>
                    <div class="logo">{{ $company['name'] }}</div>
                    <p>Interior Design & Architecture</p>
                </td>
                <td class="company-info">
                    {{ $company['address'] }}<br>
                    Phone: {{ $company['phone'] }}<br>
                    Email: {{ $company['email'] }}<br>
                    {{ $company['website'] }}
                </td>
            </tr>
        </table>
    </div>

    <div class="quote-title">QUOTATION #{{ $quote_number }}</div>

    <div class="info-grid">
        <div class="info-cell">
            <p><span class="label">Quote Date:</span> {{ $quote_date }}</p>
            <p><span class="label">Valid Until:</span> {{ $valid_until }}</p>
            <p><span class="label">Status:</span> {{ ucfirst($project->status) }}</p>
        </div>
        <div class="info-cell">
            @if($project->client_name)
            <p><span class="label">Prepared For:</span><br>
            {{ $project->client_name }}<br>
            {{ $project->client_email }}<br>
            {{ $project->client_phone }}<br>
            {{ $project->project_address }}</p>
            @endif
        </div>
    </div>

    <h3>Project: {{ $project->name }}</h3>
    @if($project->description)<p>{{ $project->description }}</p>@endif

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Item Description</th>
                <th>Specifications</th>
                <th class="text-right">Qty</th>
                <th class="text-right">Unit Price</th>
                <th class="text-right">Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($project->items as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>
                    <strong>{{ $item->material->name }}</strong>
                    <br><small>{{ $item->material->category->name }}</small>
                </td>
                <td>
                    @if($item->colorOption)
                    <span class="color-box" style="background-color: {{ $item->colorOption->hex_code }};"></span>
                    {{ $item->colorOption->name }} ({{ $item->colorOption->finish_type }})
                    <br>
                    @endif
                    @if($item->specifications)
                        @if(isset($item->specifications['room']))Room: {{ $item->specifications['room'] }}<br>@endif
                    @endif
                    {{ $item->notes }}
                </td>
                <td class="text-right">{{ number_format($item->quantity, 2) }} {{ $item->unit_type }}</td>
                <td class="text-right">₹{{ number_format($item->unit_price, 2) }}</td>
                <td class="text-right">₹{{ number_format($item->total_price, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <table class="totals">
        <tr>
            <td class="label">Subtotal:</td>
            <td class="text-right">₹{{ number_format($project->subtotal, 2) }}</td>
        </tr>
        @if($project->discount_amount > 0)
        <tr>
            <td class="label">Discount:</td>
            <td class="text-right">-₹{{ number_format($project->discount_amount, 2) }}</td>
        </tr>
        @endif
        <tr>
            <td class="label">GST (18%):</td>
            <td class="text-right">₹{{ number_format($project->tax_amount, 2) }}</td>
        </tr>
        <tr class="grand-total">
            <td>TOTAL:</td>
            <td class="text-right">₹{{ number_format($project->total_amount, 2) }}</td>
        </tr>
    </table>

    <div style="margin-top: 30px;">
        <h4>Terms & Conditions:</h4>
        <ol>
            <li>This quotation is valid until {{ $valid_until }}.</li>
            <li>50% advance payment required to commence work.</li>
            <li>Prices are inclusive of all taxes unless specified otherwise.</li>
            <li>Final measurements may affect total cost.</li>
            <li>Delivery timeline: 4-6 weeks from order confirmation.</li>
        </ol>
    </div>

    <div class="footer">
        <p>Thank you for choosing {{ $company['name'] }}!</p>
        <p>This is a computer-generated quotation and does not require signature.</p>
    </div>
</body>
</html>