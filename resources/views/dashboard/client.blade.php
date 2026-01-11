@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-3xl font-bold text-gray-800">My Dashboard</h1>
        <a href="{{ route('tickets.create') }}" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-circle"></i> New Ticket
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <p class="text-muted">You have submitted {{ \App\Models\Ticket::where('client_id', auth()->id())->count() }} tickets.</p>
        </div>
    </div>
</div>
@endsection
