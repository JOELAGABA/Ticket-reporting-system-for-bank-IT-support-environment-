<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * Display the IT Support Dashboard.
     */
    public function index()
    {
        $tickets = Ticket::with(['creator', 'assignee'])->orderBy('priority', 'desc')->get();
        return view('dashboard', compact('tickets'));
    }

    /**
     * Store a newly created incident ticket in the database.
     */
    public function store(Request $request)
    {
        // 1. Validate the incoming form data
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'branch_location' => 'required|string|max:255',
            'priority' => 'required|in:Low,Medium,High,Critical',
        ]);

        // 2. Mock the currently logged-in creator for the prototype.
        // We will default this to Sarah (the Teller user we seeded) to simulate a branch reporting it.
        $teller = User::where('role', 'Teller')->first();

        // 3. Create the ticket record
        Ticket::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'branch_location' => $validated['branch_location'],
            'priority' => $validated['priority'],
            'status' => 'Open',
            'category' => 'Hardware Outage',
            'user_id' => $teller ? $teller->id : 1,
            'assigned_to' => null,
        ]);

        // 4. Redirect back to the dashboard with a success banner notice
        return redirect()->route('dashboard')->with('success', 'Incident ticket logged successfully into central systems!');
    }

    /**
     * Update the operational status of an existing incident ticket inline.
     */
    public function updateStatus(Request $request, Ticket $ticket)
    {
        // 1. Validate that the incoming status is one of our allowed lifecycle steps
        $validated = $request->validate([
            'status' => 'required|in:Open,In Progress,Resolved',
        ]);

        // 2. If the ticket is being worked on or resolved, assign it to the IT technician.
        // We will default this to the IT Support user for simulation purposes.
        if ($validated['status'] !== 'Open' && !$ticket->assigned_to) {
            $itStaff = User::where('role', 'IT Support')->first();
            $ticket->assigned_to = $itStaff ? $itStaff->id : null;
        } elseif ($validated['status'] === 'Open') {
            // If flipped back to open, clear the assignee
            $ticket->assigned_to = null;
        }

        // 3. Save the status change
        $ticket->update([
            'status' => $validated['status']
        ]);

        // 4. Redirect back to monitor view with a notification
        return redirect()->route('dashboard')->with('success', "Ticket #INC-" . str_pad($ticket->id, 4, '0', STR_PAD_LEFT) . " lifecycle status modified!");
    }
}
