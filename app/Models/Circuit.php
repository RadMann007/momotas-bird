<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Circuit extends Model
{
    protected $fillable = ['title', 'duration', 'description', 'image'];

    public function days()
    {
        return $this->hasMany(DayCircuit::class);
    }
}
