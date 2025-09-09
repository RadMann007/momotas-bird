<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImageDay extends Model
{
    protected $fillable = ['path', 'caption', 'day_circuit_id'];

    public function dayCircuit()
    {
        return $this->belongsTo(DayCircuit::class);
    }
}
