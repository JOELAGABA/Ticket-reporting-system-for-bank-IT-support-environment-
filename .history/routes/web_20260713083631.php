<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketController;

Route::get('/', function () {
    return view('welcome');
});

// The main IT dashboard view route
Route::get('/dashboard', [TicketController::class, 'index'])->name('dashboard');
