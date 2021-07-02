<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{ protected $fillable=[
    'photo_type'
];
    use HasFactory;

    public function photoable()
    {
        return $this->morphTo();
    }

}
