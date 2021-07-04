<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use HasFactory;
    protected $hidden = [
        'photoable_type',
        'photoable_id'
        ];
    public $timestamps = false;

    public function photoable()
    {
        return $this->morphTo();
    }
    public function photoType(){
        return $this->hasOne(PhotoType::class);
    }
}
