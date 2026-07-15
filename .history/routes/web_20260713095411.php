<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketController;

Route::get('/', function () {
    return view('welcome');
});

// The main IT dashboard view route
Route::get('/dashboard', [TicketController::class, 'index'])->name('dashboard');
// Route for submitting a new IT incident ticket
Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');
// Route for updating an incident's operational status inline
Route::patch('/tickets/{ticket}/status', [TicketController::class, 'updateStatus'])->name('tickets.updateStatus');
