<div class="calculation-result-box">
    <div class="row">
        <div class="col-md-8">
            <h4>{{ $calc['material_name'] }}</h4>
            <p class="text-muted">{{ $calc['category'] }}</p>
            
            @if($calc['color'])
            <div class="selected-color-info mb-3">
                <span class="badge" style="background-color: {{ $calc['color']['hex_code'] }}; color: #fff; padding: 5px 15px;">
                    {{ $calc['color']['name'] }} ({{ $calc['color']['finish_type'] }})
                </span>
            </div>
            @endif
        </div>
        <div class="col-md-4 text-right">
            <h2 class="text-primary">₹{{ number_format($calc['total_cost'], 2) }}</h2>
            <small class="text-muted">Total Estimated Cost</small>
        </div>
    </div>

    <hr>

    <div class="cost-breakdown">
        <div class="cost-row">
            <span>Quantity:</span>
            <span>{{ number_format($calc['quantity'], 2) }} {{ $calc['unit'] }}</span>
        </div>
        <div class="cost-row">
            <span>Rate per {{ $calc['unit'] }}:</span>
            <span>₹{{ number_format($calc['unit_price'], 2) }}</span>
        </div>
        <div class="cost-row">
            <span>Subtotal:</span>
            <span>₹{{ number_format($calc['subtotal'], 2) }}</span>
        </div>
        <div class="cost-row">
            <span>GST ({{ $calc['tax_rate'] }}%):</span>
            <span>₹{{ number_format($calc['tax_amount'], 2) }}</span>
        </div>
        <div class="cost-row total">
            <span>Total Cost:</span>
            <span>₹{{ number_format($calc['total_cost'], 2) }}</span>
        </div>
    </div>

    <div class="calculation-notes mt-4">
        <small class="text-muted">
            <i class="fa fa-info-circle"></i> 
            This is an estimate. Actual costs may vary based on site conditions and final measurements.
            Prices are inclusive of all taxes.
        </small>
    </div>
</div>