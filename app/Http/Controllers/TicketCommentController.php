<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\TicketComment;
use App\Models\Attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TicketCommentController extends Controller
{
    public function store(Request $request, Ticket $ticket)
    {
        $request->validate([
            'message' => 'required|string',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:10240', // 10MB max
        ]);

        $comment = TicketComment::create([
            'ticket_id' => $ticket->id,
            'user_id' => Auth::id(),
            'message' => $request->message,
            'is_internal' => false, // Default to false for now, can add checkbox later for staff
        ]);

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $originalName = $file->getClientOriginalName();
            $path = $file->store('attachments', 'public');
            
            Attachment::create([
                'ticket_id' => $ticket->id,
                'comment_id' => $comment->id,
                'user_id' => Auth::id(),
                'original_filename' => $originalName,
                'stored_filename' => basename($path),
                'file_path' => $path,
                'file_size' => $file->getSize(),
                'mime_type' => $file->getMimeType(),
                'upload_type' => 'comment',
            ]);
        }

        return back()->with('success', 'Reply posted successfully.');
    }
}
