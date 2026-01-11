<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Priority extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'level', 'color', 'response_time_hours', 'resolution_time_hours', 'description'];

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
