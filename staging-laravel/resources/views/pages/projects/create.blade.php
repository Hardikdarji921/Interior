@extends('layouts.app')

@section('title', 'Create New Project - Staging')

@section('content')

@include('components.breadcrumb', ['title' => 'Create Project'])

<section class="project-create spad">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="project-form-wrapper">
                    <div class="section-title mb-4">
                        <span>Start New Project</span>
                        <h2>Create Project</h2>
                    </div>

                    <form action="{{ route('projects.store') }}" method="POST" class="project-form">
                        @csrf
                        
                        <div class="form-group">
                            <label>Project Name *</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name') }}" required placeholder="e.g., Living Room Renovation">
                            @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description" class="form-control" rows="3" 
                                      placeholder="Brief description of the project">{{ old('description') }}</textarea>
                        </div>

                        <h5 class="mt-4 mb-3">Client Information (Optional)</h5>
                        
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Client Name</label>
                                    <input type="text" name="client_name" class="form-control" 
                                           value="{{ old('client_name') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Client Email</label>
                                    <input type="email" name="client_email" class="form-control" 
                                           value="{{ old('client_email') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Client Phone</label>
                                    <input type="text" name="client_phone" class="form-control" 
                                           value="{{ old('client_phone') }}">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Project Address</label>
                            <textarea name="project_address" class="form-control" rows="2">{{ old('project_address') }}</textarea>
                        </div>

                        <div class="form-group">
                            <label>Quote Valid Until</label>
                            <input type="date" name="valid_until" class="form-control" 
                                   value="{{ old('valid_until', now()->addDays(30)->format('Y-m-d')) }}">
                        </div>

                        <div class="form-group mt-4">
                            <button type="submit" class="site-btn w-100">
                                <i class="fa fa-plus"></i> Create Project & Add Items
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection