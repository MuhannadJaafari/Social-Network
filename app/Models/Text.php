<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Text extends Model
{
    use HasFactory;
    protected $fillable = [
        'body'
    ];
    public $timestamps = false;
    public function textable(){
        return $this->morphTo();
    }
}
