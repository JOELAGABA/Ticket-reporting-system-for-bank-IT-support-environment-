<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'category', 'priority', 'status', 'branch_location', 'user_id', 'assigned_to'
    ];

    // The Teller who created the ticket
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // The IT Support Staff assigned to it
    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    // The comments attached to this ticket
    public function comments(): HasMany
    {
        return $this->hasMany(TicketComment::class);
    }
}
