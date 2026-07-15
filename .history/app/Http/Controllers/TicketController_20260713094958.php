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
        // 3. Create the ticket record
        Ticket::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'branch_location' => $validated['branch_location'],
            'priority' => $validated['priority'],
            'status' => 'Open',
            'category' => 'Hardware Outage', // <-- Add this line to satisfy the database constraint
            'user_id' => $teller ? $teller->id : 1,
            'assigned_to' => null,
        ]);

        // 4. Redirect back to the dashboard with a success banner notice
        return redirect()->route('dashboard')->with('success', 'Incident ticket logged successfully into central systems!');
    }
}
