<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Like extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['user_id'];
    protected $hidden = [
        'likeable_type',
        'likeable_id'
    ];

    public function likeable()
    {
        return $this->morphTo();
    }


}
