@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                    <h2 class="h5 mb-0 fw-bold">
                        <span class="text-muted">#{{ $ticket->ticket_number }}</span> {{ $ticket->title }}
                    </h2>
                    <span class="badge bg-{{ $ticket->status == 'open' ? 'success' : 'secondary' }}">{{ ucfirst($ticket->status) }}</span>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <p class="text-gray-700 whitespace-pre-line">{{ $ticket->description }}</p>
                    </div>

                    @if($ticket->attachments->where('comment_id', null)->count() > 0)
                        <div class="mb-3">
                            <h6 class="fw-bold fs-sm">Attachments:</h6>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach($ticket->attachments->where('comment_id', null) as $att)
                                    <a href="{{ Storage::url($att->file_path) }}" target="_blank" class="btn btn-sm btn-outline-secondary">
                                        <i class="bi bi-paperclip"></i> {{ $att->original_filename }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
                <div class="card-footer bg-light text-muted fs-sm">
                    Submitted by <span class="fw-bold text-dark">{{ $ticket->client->name }}</span> 
                    {{ $ticket->created_at->diffForHumans() }}
                </div>
            </div>

            <h4 class="mb-3">Conversation</h4>
            
            <div class="mb-4">
                @forelse($ticket->comments as $comment)
                    <div class="d-flex mb-3 {{ $comment->user_id == auth()->id() ? 'justify-content-end' : '' }}">
                        <div class="card border-0 shadow-sm" style="max-width: 80%; background-color: {{ $comment->user_id == auth()->id() ? '#eef2ff' : '#fff' }}">
                            <div class="card-body p-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="fw-bold small {{ $comment->user_id == auth()->id() ? 'text-primary' : 'text-gray-600' }}">
                                        {{ $comment->user->name }}
                                        @if($comment->user->role != 'client') 
                                            <span class="badge bg-secondary ms-1" style="font-size: 0.6rem">{{ ucfirst($comment->user->role) }}</span>
                                        @endif
                                    </span>
                                    <small class="text-muted ms-3">{{ $comment->created_at->format('M d, H:i') }}</small>
                                </div>
                                <p class="mb-0 text-sm">{{ $comment->message }}</p>
                                
                                @if($comment->attachments->count() > 0)
                                    <div class="mt-2 pt-2 border-top">
                                        @foreach($comment->attachments as $att)
                                            @if(Str::startsWith($att->mime_type, 'image/'))
                                                <img src="{{ Storage::url($att->file_path) }}" alt="{{ $att->original_filename }}" class="img-fluid rounded mb-1" style="max-height: 200px">
                                            @else
                                                <a href="{{ Storage::url($att->file_path) }}" target="_blank" class="d-block small text-decoration-none">
                                                    <i class="bi bi-file-earmark"></i> {{ $att->original_filename }}
                                                </a>
                                            @endif
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-muted">No comments yet.</p>
                @endforelse
            </div>

            <div class="card shadow-sm">
                <div class="card-body">
                    <form action="{{ route('tickets.comments.store', $ticket) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold">Reply</label>
                            <textarea name="message" class="form-control" rows="3" placeholder="Type your message here..." required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-sm">Attachment (Optional - Images supported)</label>
                            <input type="file" name="attachment" class="form-control form-control-sm">
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-send"></i> Send Reply
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white fw-bold">Ticket Details</div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span class="text-muted">Status</span>
                        {{-- Show status dropdown for Admin or Ticket Owner (Client) --}}
                        @if((auth()->user()->isAdmin() || auth()->id() == $ticket->client_id))
                            <form action="{{ route('tickets.update', $ticket) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PUT')
                                <div class="input-group input-group-sm">
                                    <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                        <option value="open" {{ $ticket->status == 'open' ? 'selected' : '' }}>Open</option>
                                        <option value="closed" {{ $ticket->status == 'closed' ? 'selected' : '' }}>Closed</option>
                                    </select>
                                </div>
                            </form>
                        @else
                            <span class="badge bg-{{ $ticket->status == 'open' ? 'success' : 'secondary' }}">{{ ucfirst($ticket->status) }}</span>
                        @endif
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span class="text-muted">Priority</span>
                        <span class="badge" style="background-color: {{ $ticket->priority->color }}">{{ $ticket->priority->name }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span class="text-muted">Category</span>
                        <span>{{ $ticket->category->name }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span class="text-muted">Assigned To</span>
                        <span>{{ $ticket->staff ? $ticket->staff->name : 'Unassigned' }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
