<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DayCircuit extends Model
{
    protected $fillable = ['title', 'description', 'circuit_id'];

    public function circuit()
    {
        return $this->belongsTo(Circuit::class);
    }

    public function images()
    {
        return $this->hasMany(ImageDay::class);
    }
}
