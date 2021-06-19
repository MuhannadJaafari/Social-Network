<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class RelationUser extends Pivot
{
    use HasFactory;
    protected $table = 'relation_user';
    protected $hidden = [
        'user1_id',
        'user2_id'
    ];

}
