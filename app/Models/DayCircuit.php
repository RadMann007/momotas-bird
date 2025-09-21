<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DayCircuit extends Model
{
    protected $fillable = [
        'title', 
        'description', 
        'circuit_id', 
        'image', 
        'distance',
        'start',
        'end',
        'hotel_name',
        'hotel_description',
        'day'
    ];

    public function circuit()
    {
        return $this->belongsTo(Circuit::class);
    }
}