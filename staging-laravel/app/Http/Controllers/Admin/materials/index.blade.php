@extends('layouts.app')

@section('title', 'Manage Materials - Admin')

@section('content')

<section class="admin-materials spad">
    <div class="container">
        <div class="row mb-4">
            <div class="col-lg-6">
                <h2>Materials Management</h2>
            </div>
            <div class="col-lg-6 text-right">
                <a href="{{ route('admin.materials.create') }}" class="site-btn">
                    <i class="fa fa-plus"></i> Add New Material
                </a>
            </div>
        </div>

        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Brand</th>
                        <th>Base Price</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($materials as $material)
                    <tr>
                        <td>
                            @if($material->image)
                            <img src="{{ asset('storage/' . $material->image) }}" width="50" alt="">
                            @else
                            <span class="text-muted">No image</span>
                            @endif
                        </td>
                        <td>{{ $material->name }}</td>
                        <td>{{ $material->category->name }}</td>
                        <td>{{ $material->brand ?? '-' }}</td>
                        <td>₹{{ number_format($material->base_price, 2) }}</td>
                        <td>
                            <span class="badge badge-{{ $material->is_active ? 'success' : 'danger' }}">
                                {{ $material->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.materials.edit', $material) }}" class="btn btn-sm btn-primary">
                                <i class="fa fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.materials.destroy', $material) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this material?')">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{ $materials->links() }}
    </div>
</section>

@endsection