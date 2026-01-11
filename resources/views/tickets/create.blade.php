@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-white py-3">
                <h3 class="mb-0 fw-bold">Submit New Ticket</h3>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('tickets.store') }}">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Title</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Category</label>
                            <select name="category_id" class="form-select" required>
                                <option value="">Select Category</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Priority</label>
                            <select name="priority_id" class="form-select" required>
                                <option value="">Select Priority</option>
                                @foreach($priorities as $p)
                                    <option value="{{ $p->id }}">{{ $p->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Assign To (Optional)</label>
                        <select name="assigned_to" class="form-select">
                            <option value="">-- System Automatic Assignment --</option>
                            @foreach($staffMembers as $staff)
                                <option value="{{ $staff->id }}">{{ $staff->name }} ({{ ucfirst($staff->role) }})</option>
                            @endforeach
                        </select>
                        <div class="form-text">Select a specific staff member or leave blank for automatic assignment.</div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Description</label>
                        <textarea name="description" class="form-control" rows="5" required></textarea>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">Submit Ticket</button>
                        <a href="{{ route('tickets.index') }}" class="btn btn-light">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
