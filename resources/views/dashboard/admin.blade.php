@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <h1 class="text-3xl font-bold mb-4 text-gray-800">Admin Dashboard</h1>
        
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card bg-primary text-white p-4 shadow-sm hover:scale-105 transition-transform">
                    <h3>Total Users</h3>
                    <p class="h2">{{ \App\Models\User::count() }}</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-success text-white p-4 shadow-sm hover:scale-105 transition-transform">
                    <h3>Total Tickets</h3>
                    <p class="h2">{{ \App\Models\Ticket::count() }}</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-warning text-dark p-4 shadow-sm hover:scale-105 transition-transform">
                    <h3>Open Tickets</h3>
                    <p class="h2">{{ \App\Models\Ticket::where('status', 'open')->count() }}</p>
                </div>
            </div>
        </div>

        <div class="mt-4">
            <a href="{{ route('users.index') }}" class="btn btn-dark btn-lg shadow-sm">
                <i class="bi bi-people-fill"></i> Manage Users
            </a>
        </div>
    </div>
</div>
@endsection
