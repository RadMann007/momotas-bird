<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bird extends Model
{
    protected $fillable = [
        'name',
        'type',
        'description',
        'image'
    ];

    public function images()
    {
        return $this->morphMany(ImageDay::class, 'imageable');
    }
}
