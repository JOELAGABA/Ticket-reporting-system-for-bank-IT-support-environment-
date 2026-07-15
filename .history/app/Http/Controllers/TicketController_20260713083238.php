<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * Display the IT Support Dashboard.
     */
    public function index()
    {
        // Fetch all tickets with their related creators and assignees to avoid N+1 query issues
        $tickets = Ticket::with(['creator', 'assignee'])->orderBy('priority', 'desc')->get();

        // Pass the tickets data to the dashboard view
        return view('dashboard', compact('tickets'));
    }
}
