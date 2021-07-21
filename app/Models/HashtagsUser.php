<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class HashtagsUser extends Pivot
{
    protected $table = 'hashtagables';
    public $timestamps = false;
    use HasFactory;
}
