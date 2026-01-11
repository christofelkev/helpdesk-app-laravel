<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Priority;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $query = Ticket::with(['priority', 'category', 'client', 'staff']);

        if ($user->isAdmin()) {
            // Admin sees all
        } elseif ($user->isStaff()) {
            // Staff sees all currently
        } else {
            // Client sees own
            $query->where('client_id', $user->id);
        }

        $openTickets = (clone $query)->where('status', 'open')->latest()->paginate(10);
        $closedTickets = (clone $query)->where('status', 'closed')->latest()->get();

        return view('tickets.index', compact('openTickets', 'closedTickets'));
    }

    public function create()
    {
        $priorities = Priority::all();
        $categories = Category::where('is_active', true)->get();
        // Fetch users who are staff or admin to be assigned
        $staffMembers = \App\Models\User::whereIn('role', ['admin', 'staff'])->get();
        
        return view('tickets.create', compact('priorities', 'categories', 'staffMembers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'priority_id' => 'required|exists:priorities,id',
            'category_id' => 'required|exists:categories,id',
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        $ticket = Ticket::create([
            'ticket_number' => 'TICKET-' . strtoupper(uniqid()),
            'title' => $request->title,
            'description' => $request->description,
            'status' => 'open',
            'priority_id' => $request->priority_id,
            'category_id' => $request->category_id,
            'client_id' => Auth::id(),
            'assigned_to' => $request->assigned_to,
        ]);

        return redirect()->route('tickets.index')->with('success', 'Ticket created successfully.');
    }

    public function show(Ticket $ticket)
    {
        // Authorization check: only own ticket or staff/admin
        $user = Auth::user();
        if ($user->isClient() && $ticket->client_id !== $user->id) {
            abort(403);
        }

        return view('tickets.show', compact('ticket'));
    }

    public function update(Request $request, Ticket $ticket)
    {
        $user = Auth::user();
        
        // Authorization: Only Admin or Ticket Owner (Client) can update status
        // User requested "people who make the ticket" (Client) not "the giver" (Assignee)
        if (!$user->isAdmin() && $user->id !== $ticket->client_id) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'status' => 'required|in:open,closed',
        ]);

        $ticket->update([
            'status' => $request->status,
            'closed_at' => $request->status == 'closed' ? now() : null,
        ]);

        return back()->with('success', 'Ticket status updated successfully.');
    }
}
