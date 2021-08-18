<?php

namespace App\Models;

use App\Events\ReplyDeletedEvent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Reply extends Pivot
{
    use HasFactory;
    protected $table = 'replies';
    protected $dispatchesEvents = [
        'deleting' => ReplyDeletedEvent::class
    ];
}
