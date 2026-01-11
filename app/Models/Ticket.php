<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_number',
        'title',
        'description',
        'status',
        'priority_id',
        'category_id',
        'client_id',
        'assigned_to',
        'due_date',
        'resolved_at',
        'closed_at'
    ];

    protected $casts = [
        'due_date' => 'date',
        'resolved_at' => 'datetime',
        'closed_at' => 'datetime',
    ];

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function staff()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function priority()
    {
        return $this->belongsTo(Priority::class);
    }

    public function comments()
    {
        return $this->hasMany(TicketComment::class);
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }

    public function activities()
    {
        return $this->hasMany(TicketActivity::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'ticket_tags');
    }

    public function slaLog()
    {
        return $this->hasOne(SlaLog::class);
    }
}
