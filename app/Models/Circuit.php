<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Circuit extends Model
{
    protected $fillable = [
        'title', 
        'duration', 
        'description', 
        'image', 
        'start', 
        'end',
        'distance', 
        'truck_disponibility', 
        'price_3_pers', 
        'price_6_pers', 
        'price_max_pers'
];

    public function days()
    {
        return $this->hasMany(DayCircuit::class);
    }
}
