<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Username extends Model
{
    use HasFactory;
    public function user() : BelongsTo{
        return $this->belongsTo(User::class);
    }
}
