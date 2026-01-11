@extends('layouts.app')

@section('content')
<div class="row mb-4">
    <div class="col-md-6">
        <h2 class="text-2xl font-bold">Tickets</h2>
    </div>
    <div class="col-md-6 text-end">
        <a href="{{ route('tickets.create') }}" class="btn btn-primary">Create New Ticket</a>
    </div>
</div>

<div class="card shadow-sm mb-4">
    <div class="card-header bg-white fw-bold py-3">
        Active Tickets
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="bg-light">
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Status</th>
                        <th>Priority</th>
                        <th>Category</th>
                        <th>Created</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($openTickets as $ticket)
                        <tr>
                            <td>{{ $ticket->ticket_number }}</td>
                            <td class="fw-bold">{{ $ticket->title }}</td>
                            <td>
                                <span class="badge bg-success">Open</span>
                            </td>
                            <td>
                                <span class="badge" style="background-color: {{ $ticket->priority->color }}">
                                    {{ $ticket->priority->name }}
                                </span>
                            </td>
                            <td>{{ $ticket->category->name }}</td>
                            <td>{{ $ticket->created_at->diffForHumans() }}</td>
                            <td>
                                <a href="{{ route('tickets.show', $ticket) }}" class="btn btn-sm btn-outline-primary">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">No open tickets found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer">
        {{ $openTickets->links() }}
    </div>
</div>

@if($closedTickets->count() > 0)
    <div class="text-center mb-4">
        <button class="btn btn-outline-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#closedTicketsSection">
            Show Closed Tickets <span class="badge bg-secondary ms-1">{{ $closedTickets->count() }}</span>
        </button>
    </div>

    <div class="collapse" id="closedTicketsSection">
        <div class="card shadow-sm border-secondary opacity-75">
            <div class="card-header bg-light fw-bold py-3 text-muted">
                Closed Tickets History
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Status</th>
                                <th>Priority</th>
                                <th>Category</th>
                                <th>Created</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($closedTickets as $ticket)
                                <tr class="table-light text-muted">
                                    <td>{{ $ticket->ticket_number }}</td>
                                    <td>{{ $ticket->title }}</td>
                                    <td>
                                        <span class="badge bg-secondary">Closed</span>
                                    </td>
                                    <td>
                                        <span class="badge" style="background-color: {{ $ticket->priority->color }}">
                                            {{ $ticket->priority->name }}
                                        </span>
                                    </td>
                                    <td>{{ $ticket->category->name }}</td>
                                    <td>{{ $ticket->created_at->diffForHumans() }}</td>
                                    <td>
                                        <a href="{{ route('tickets.show', $ticket) }}" class="btn btn-sm btn-outline-secondary">View</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endif

@endsection
