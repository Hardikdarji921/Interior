@extends('layouts.app')

@section('title', $project->name . ' - Project Details')

@section('content')

@include('components.breadcrumb', ['title' => $project->name])

<section class="project-details spad">
    <div class="container">
        <!-- Project Header -->
        <div class="row mb-4">
            <div class="col-lg-8">
                <h2>{{ $project->name }}</h2>
                <p class="text-muted">{{ $project->description }}</p>
                <span class="badge badge-{{ $project->status_badge }}">{{ ucfirst($project->status) }}</span>
            </div>
            <div class="col-lg-4 text-right">
                <div class="project-actions">
                    <a href="{{ route('projects.quotation', $project) }}" class="site-btn mb-2" target="_blank">
                        <i class="fa fa-file-pdf-o"></i> View Quotation
                    </a>
                    <form action="{{ route('projects.status', $project) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <select name="status" class="form-control d-inline-block w-auto" onchange="this.form.submit()">
                            <option value="draft" {{ $project->status == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="quoted" {{ $project->status == 'quoted' ? 'selected' : '' }}>Quoted</option>
                            <option value="approved" {{ $project->status == 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="completed" {{ $project->status == 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                    </form>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Left Column: Add Items -->
            <div class="col-lg-4">
                <div class="add-item-card">
                    <h4><i class="fa fa-plus-circle"></i> Add Item</h4>
                    
                    <form action="{{ route('projects.items.add', $project) }}" method="POST" id="addItemForm">
                        @csrf
                        
                        <div class="form-group">
                            <label>Category</label>
                            <select class="form-control" id="categorySelect">
                                <option value="">Select Category...</option>
                                @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" data-has-colors="{{ $cat->has_color_options }}">
                                    {{ $cat->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Material</label>
                            <select name="material_id" class="form-control" id="materialSelect" required disabled>
                                <option value="">First select category...</option>
                            </select>
                        </div>

                        <div class="form-group color-group" style="display: none;">
                            <label>Color</label>
                            <select name="color_option_id" class="form-control" id="colorSelect">
                                <option value="">Default / No color</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Quantity</label>
                            <div class="input-group">
                                <input type="number" name="quantity" class="form-control" step="0.01" min="0.01" required>
                                <div class="input-group-append">
                                    <span class="input-group-text unit-label">units</span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Room/Area</label>
                            <input type="text" name="room_name" class="form-control" placeholder="e.g., Master Bedroom">
                        </div>

                        <div class="form-group">
                            <label>Notes</label>
                            <textarea name="notes" class="form-control" rows="2"></textarea>
                        </div>

                        <button type="submit" class="site-btn w-100">
                            <i class="fa fa-plus"></i> Add to Project
                        </button>
                    </form>
                </div>

                <!-- Coupon Section -->
                @if(!$project->coupon)
                <div class="coupon-card mt-4">
                    <h5><i class="fa fa-tag"></i> Apply Coupon</h5>
                    <form action="{{ route('projects.coupon.apply', $project) }}" method="POST">
                        @csrf
                        <div class="input-group">
                            <input type="text" name="coupon_code" class="form-control" placeholder="Enter code">
                            <div class="input-group-append">
                                <button class="btn btn-outline-primary" type="submit">Apply</button>
                            </div>
                        </div>
                    </form>
                </div>
                @else
                <div class="alert alert-success mt-4">
                    <i class="fa fa-check-circle"></i> 
                    Coupon <strong>{{ $project->coupon->code }}</strong> applied!
                    <br>Discount: ₹{{ number_format($project->discount_amount, 2) }}
                </div>
                @endif
            </div>

            <!-- Right Column: Items List -->
            <div class="col-lg-8">
                <div class="project-items-card">
                    <h4>Project Items ({{ $project->items_count }})</h4>
                    
                    @if($project->items->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Specs</th>
                                    <th>Qty</th>
                                    <th>Rate</th>
                                    <th>Amount</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($project->items as $item)
                                <tr>
                                    <td>
                                        <strong>{{ $item->material->name }}</strong>
                                        @if($item->colorOption)
                                        <br><small style="color: {{ $item->colorOption->hex_code }}">
                                            <i class="fa fa-circle"></i> {{ $item->colorOption->name }}
                                        </small>
                                        @endif
                                    </td>
                                    <td>
                                        @if($item->specifications)
                                            @if(isset($item->specifications['room']))
                                                <small class="d-block text-muted">Room: {{ $item->specifications['room'] }}</small>
                                            @endif
                                        @endif
                                        @if($item->notes)
                                            <small class="d-block text-muted">{{ Str::limit($item->notes, 30) }}</small>
                                        @endif
                                    </td>
                                    <td>{{ number_format($item->quantity, 2) }} {{ $item->unit_type }}</td>
                                    <td>₹{{ number_format($item->unit_price, 2) }}</td>
                                    <td>₹{{ number_format($item->total_price, 2) }}</td>
                                    <td>
                                        <form action="{{ route('projects.items.remove', [$project, $item]) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Remove this item?')">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="font-weight-bold">
                                <tr>
                                    <td colspan="4" class="text-right">Subtotal:</td>
                                    <td>₹{{ number_format($project->subtotal, 2) }}</td>
                                    <td></td>
                                </tr>
                                @if($project->discount_amount > 0)
                                <tr class="text-success">
                                    <td colspan="4" class="text-right">Discount:</td>
                                    <td>-₹{{ number_format($project->discount_amount, 2) }}</td>
                                    <td></td>
                                </tr>
                                @endif
                                <tr>
                                    <td colspan="4" class="text-right">GST (18%):</td>
                                    <td>₹{{ number_format($project->tax_amount, 2) }}</td>
                                    <td></td>
                                </tr>
                                <tr class="text-primary" style="font-size: 1.2em;">
                                    <td colspan="4" class="text-right">TOTAL:</td>
                                    <td>₹{{ number_format($project->total_amount, 2) }}</td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    @else
                    <div class="alert alert-info">
                        No items added yet. Use the form on the left to add materials.
                    </div>
                    @endif
                </div>

                <!-- Client Info Card -->
                @if($project->client_name)
                <div class="client-info-card mt-4">
                    <h5>Client Information</h5>
                    <p><strong>{{ $project->client_name }}</strong></p>
                    @if($project->client_email)<p><i class="fa fa-envelope"></i> {{ $project->client_email }}</p>@endif
                    @if($project->client_phone)<p><i class="fa fa-phone"></i> {{ $project->client_phone }}</p>@endif
                    @if($project->project_address)<p><i class="fa fa-map-marker"></i> {{ $project->project_address }}</p>@endif
                </div>
                @endif
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
$(document).ready(function() {
    const materialsData = @json($categories->mapWithKeys(function($cat) {
        return [$cat->id => [
            'materials' => $cat->materials,
            'has_colors' => $cat->has_color_options,
            'colors' => $cat->colorOptions,
            'unit_type' => $cat->unit_type
        ]];
    }));

    $('#categorySelect').change(function() {
        const catId = $(this).val();
        const materialSelect = $('#materialSelect');
        const colorGroup = $('.color-group');
        
        materialSelect.empty().append('<option value="">Select Material...</option>');
        
        if (catId && materialsData[catId]) {
            const data = materialsData[catId];
            
            data.materials.forEach(function(mat) {
                materialSelect.append(`<option value="${mat.id}">${mat.name} (₹${mat.base_price}/${data.unit_type})</option>`);
            });
            
            materialSelect.prop('disabled', false);
            $('.unit-label').text(data.unit_type);
            
            // Handle colors
            if (data.has_colors && data.colors.length > 0) {
                const colorSelect = $('#colorSelect');
                colorSelect.empty().append('<option value="">Default / No color</option>');
                data.colors.forEach(function(color) {
                    colorSelect.append(`<option value="${color.id}">${color.name} (${color.price_display})</option>`);
                });
                colorGroup.slideDown();
            } else {
                colorGroup.slideUp();
            }
        } else {
            materialSelect.prop('disabled', true);
            colorGroup.slideUp();
        }
    });
});
</script>
@endpush