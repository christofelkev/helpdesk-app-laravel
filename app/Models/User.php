<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'avatar',
        'phone',
        'department',
        'job_title',
        'is_active',
        'last_login_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean',
        'last_login_at' => 'datetime',
    ];

    // Relationships
    public function ticketsAsClient()
    {
        return $this->hasMany(Ticket::class, 'client_id');
    }

    public function ticketsAsStaff()
    {
        return $this->hasMany(Ticket::class, 'assigned_to');
    }

    public function comments()
    {
        return $this->hasMany(TicketComment::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    // Helpers
    public function isAdmin() { return $this->role === 'admin'; }
    public function isStaff() { return $this->role === 'staff'; }
    public function isClient() { return $this->role === 'client'; }
}
