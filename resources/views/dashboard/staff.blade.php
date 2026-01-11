@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-3xl font-bold mb-4 text-gray-800">Staff Dashboard</h1>
    
    <div class="alert alert-info border-l-4 border-blue-500">
        Welcome, Staff Member. You have {{ \App\Models\Ticket::where('assigned_to', auth()->id())->where('status', '!=', 'closed')->count() }} active tickets assigned.
    </div>
</div>
@endsection
