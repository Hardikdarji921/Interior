@extends('layouts.app')

@section('title', 'Material Cost Calculator - Staging')

@section('content')

@include('components.breadcrumb', ['title' => 'Cost Calculator'])

<!-- Calculator Section Begin -->
<section class="calculator spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="calculator__wrapper">
                    <div class="section-title mb-4">
                        <span>Estimate Your Project</span>
                        <h2>Material Cost Calculator</h2>
                    </div>

                    <!-- Category Tabs -->
                    <div class="calculator__tabs">
                        <ul class="nav nav-tabs" id="calcTab" role="tablist">
                            @foreach($categories as $index => $category)
                            <li class="nav-item">
                                <a class="nav-link {{ $index === 0 ? 'active' : '' }}" 
                                   id="tab-{{ $category->slug }}" 
                                   data-toggle="tab" 
                                   href="#{{ $category->slug }}" 
                                   role="tab"
                                   data-category="{{ $category->id }}"
                                   data-has-colors="{{ $category->has_color_options ? '1' : '0' }}">
                                    <i class="fa {{ $category->icon ?? 'fa-cube' }}"></i>
                                    {{ $category->name }}
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Calculator Forms -->
                    <div class="tab-content calculator__content" id="calcTabContent">
                        @foreach($categories as $index => $category)
                        <div class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}" 
                             id="{{ $category->slug }}" 
                             role="tabpanel">
                            
                            <form class="calculator-form" data-category="{{ $category->slug }}">
                                @csrf
                                
                                <!-- Material Selection -->
                                <div class="form-group">
                                    <label>Select {{ $category->name }} Type</label>
                                    <select name="material_id" class="form-control material-select" required>
                                        <option value="">Choose {{ $category->name }}...</option>
                                        @foreach($category->materials as $material)
                                        <option value="{{ $material->id }}" 
                                                data-base-price="{{ $material->base_price }}"
                                                data-has-colors="{{ $category->has_color_options ? '1' : '0' }}">
                                            {{ $material->name }} - ₹{{ number_format($material->base_price, 2) }}/{{ $category->unit_type }}
                                            @if($material->brand) ({{ $material->brand }}) @endif
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Color Selection (if applicable) -->
                                @if($category->has_color_options)
                                <div class="form-group color-selection" style="display: none;">
                                    <label>Choose Color</label>
                                    <div class="color-options row">
                                        @foreach($category->colorOptions as $color)
                                        <div class="col-md-3 col-6 mb-3">
                                            <div class="color-card" data-color-id="{{ $color->id }}">
                                                <div class="color-preview" 
                                                     style="background-color: {{ $color->hex_code }}; 
                                                            width: 100%; 
                                                            height: 60px; 
                                                            border-radius: 8px;
                                                            border: 3px solid transparent;
                                                            cursor: pointer;
                                                            box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                                </div>
                                                <div class="color-info mt-2 text-center">
                                                    <small class="d-block font-weight-bold">{{ $color->name }}</small>
                                                    <small class="text-muted">{{ $color->finish_type }}</small>
                                                    <small class="d-block text-primary">{{ $color->price_display }}</small>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    <input type="hidden" name="color_option_id" class="selected-color-id">
                                </div>
                                @endif

                                <!-- Dimensions (for Paint/Wall covering) -->
                                @if($category->slug === 'paint' || $category->slug === 'wallpaper')
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Width (feet)</label>
                                            <input type="number" name="width" class="form-control" 
                                                   placeholder="e.g., 10" step="0.1" min="0">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Height (feet)</label>
                                            <input type="number" name="height" class="form-control" 
                                                   placeholder="e.g., 12" step="0.1" min="0">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Coats</label>
                                            <select name="coats" class="form-control">
                                                <option value="1">1 Coat</option>
                                                <option value="2" selected>2 Coats</option>
                                                <option value="3">3 Coats</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Or Total Area (sq ft)</label>
                                    <input type="number" name="quantity" class="form-control area-input" 
                                           placeholder="Total square feet" step="0.01" min="0">
                                </div>
                                @else
                                <!-- Quantity for other categories -->
                                <div class="form-group">
                                    <label>Quantity ({{ $category->unit_type }})</label>
                                    <div class="input-group">
                                        <input type="number" name="quantity" class="form-control" 
                                               placeholder="Enter quantity" step="0.01" min="0.01" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text">{{ $category->unit_type }}</span>
                                        </div>
                                    </div>
                                </div>
                                @endif

                                <!-- Project Name (Optional) -->
                                <div class="form-group">
                                    <label>Project Name (Optional)</label>
                                    <input type="text" name="project_name" class="form-control" 
                                           placeholder="e.g., Living Room Renovation">
                                </div>

                                <button type="submit" class="site-btn w-100">
                                    <i class="fa fa-calculator"></i> Calculate Cost
                                </button>
                            </form>
                        </div>
                        @endforeach
                    </div>

                    <!-- Results Section -->
                    <div id="calculation-result" class="mt-4" style="display: none;">
                        <!-- Results loaded via AJAX -->
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Quick Info -->
                <div class="calculator__sidebar">
                    <div class="calculator__tips">
                        <h5>💡 Calculation Tips</h5>
                        <ul>
                            <li><i class="fa fa-check"></i> Measure dimensions carefully</li>
                            <li><i class="fa fa-check"></i> Add 10% extra for wastage</li>
                            <li><i class="fa fa-check"></i> Consider multiple coats for paint</li>
                            <li><i class="fa fa-check"></i> Prices include GST</li>
                        </ul>
                    </div>

                    <!-- Recent Calculations -->
                    @if($history->count() > 0)
                    <div class="calculator__history mt-4">
                        <h5>Recent Calculations</h5>
                        @foreach($history as $calc)
                        <div class="history-item">
                            <div class="d-flex justify-content-between">
                                <strong>{{ $calc->material->name }}</strong>
                                <span>₹{{ number_format($calc->total_cost, 2) }}</span>
                            </div>
                            <small class="text-muted">
                                {{ $calc->quantity }} {{ $calc->material->category->unit_type }}
                                @if($calc->colorOption)
                                • {{ $calc->colorOption->name }}
                                @endif
                            </small>
                        </div>
                        @endforeach
                        <a href="{{ route('calculator.history') }}" class="primary-btn mt-3 d-block text-center">
                            View All History
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Comparison Section -->
        <div class="row mt-5">
            <div class="col-lg-12">
                <div class="calculator__compare">
                    <h3>Compare Materials</h3>
                    <p>Select up to 4 materials to compare prices for the same quantity.</p>
                    <button class="site-btn" onclick="openCompareModal()">
                        <i class="fa fa-exchange"></i> Compare Materials
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Calculation Result Modal -->
<div class="modal fade" id="resultModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cost Estimation</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body" id="resultModalBody">
                <!-- Content loaded dynamically -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="saveCalculation()">
                    <i class="fa fa-save"></i> Save to Project
                </button>
                <button type="button" class="btn btn-success" onclick="printCalculation()">
                    <i class="fa fa-print"></i> Print
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
.calculator__tabs .nav-link {
    border: none;
    color: #666;
    font-weight: 600;
    padding: 15px 25px;
    border-radius: 0;
    border-bottom: 3px solid transparent;
}

.calculator__tabs .nav-link.active {
    color: #dfa667;
    border-bottom-color: #dfa667;
    background: transparent;
}

.calculator__tabs .nav-link i {
    margin-right: 8px;
}

.calculator__content {
    padding: 30px;
    background: #f8f9fa;
    border-radius: 0 0 10px 10px;
}

.color-card {
    cursor: pointer;
    transition: transform 0.2s;
}

.color-card:hover {
    transform: translateY(-2px);
}

.color-card.selected .color-preview {
    border-color: #dfa667 !important;
    box-shadow: 0 4px 8px rgba(0,0,0,0.2) !important;
}

.calculator__tips {
    background: #fff;
    padding: 25px;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.calculator__tips ul {
    list-style: none;
    padding: 0;
    margin: 15px 0 0;
}

.calculator__tips li {
    padding: 8px 0;
    color: #666;
}

.calculator__tips li i {
    color: #28a745;
    margin-right: 10px;
}

.calculator__history {
    background: #fff;
    padding: 25px;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.history-item {
    padding: 12px 0;
    border-bottom: 1px solid #eee;
}

.history-item:last-child {
    border-bottom: none;
}

.calculation-result-box {
    background: #fff;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 2px 15px rgba(0,0,0,0.1);
}

.cost-breakdown {
    margin: 20px 0;
}

.cost-row {
    display: flex;
    justify-content: space-between;
    padding: 10px 0;
    border-bottom: 1px dashed #ddd;
}

.cost-row.total {
    border-top: 2px solid #dfa667;
    border-bottom: none;
    font-size: 1.2em;
    font-weight: bold;
    color: #dfa667;
    margin-top: 10px;
    padding-top: 15px;
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Color selection
    $('.color-card').click(function() {
        $(this).siblings().removeClass('selected');
        $(this).addClass('selected');
        $(this).closest('.color-selection').find('.selected-color-id').val($(this).data('color-id'));
    });

    // Show color selection when material selected
    $('.material-select').change(function() {
        const hasColors = $(this).find(':selected').data('has-colors') === '1';
        if (hasColors) {
            $(this).closest('form').find('.color-selection').slideDown();
        } else {
            $(this).closest('form').find('.color-selection').slideUp();
        }
    });

    // Form submission
    $('.calculator-form').submit(function(e) {
        e.preventDefault();
        
        const form = $(this);
        const btn = form.find('button[type="submit"]');
        const originalText = btn.html();
        
        btn.html('<i class="fa fa-spinner fa-spin"></i> Calculating...').prop('disabled', true);
        
        $.ajax({
            url: '{{ route("calculator.calculate") }}',
            method: 'POST',
            data: form.serialize(),
            success: function(response) {
                if (response.success) {
                    $('#resultModalBody').html(response.html);
                    $('#resultModal').modal('show');
                    
                    // Also show inline result
                    $('#calculation-result').html(response.html).slideDown();
                }
            },
            error: function(xhr) {
                alert('Error: ' + (xhr.responseJSON?.message || 'Calculation failed'));
            },
            complete: function() {
                btn.html(originalText).prop('disabled', false);
            }
        });
    });

    // Auto-calculate area from dimensions
    $('input[name="width"], input[name="height"], input[name="coats"]').on('input', function() {
        const form = $(this).closest('form');
        const width = parseFloat(form.find('input[name="width"]').val()) || 0;
        const height = parseFloat(form.find('input[name="height"]').val()) || 0;
        const coats = parseInt(form.find('select[name="coats"]').val()) || 1;
        
        if (width > 0 && height > 0) {
            const area = (width * height * coats).toFixed(2);
            form.find('.area-input').val(area);
        }
    });
});

function openCompareModal() {
    // Implementation for comparison modal
    alert('Comparison feature - Select materials to compare');
}

function printCalculation() {
    window.print();
}

function saveCalculation() {
    @guest
        alert('Please login to save calculations');
    @else
        alert('Calculation saved to your account!');
    @endguest
}
</script>
@endpush