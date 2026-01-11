<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SlaLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_id', 'priority_id', 'expected_response_time', 
        'expected_resolution_time', 'actual_response_time', 
        'actual_resolution_time', 'response_breached', 'resolution_breached'
    ];

    protected $casts = [
        'expected_response_time' => 'datetime',
        'expected_resolution_time' => 'datetime',
        'actual_response_time' => 'datetime',
        'actual_resolution_time' => 'datetime',
        'response_breached' => 'boolean',
        'resolution_breached' => 'boolean',
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
