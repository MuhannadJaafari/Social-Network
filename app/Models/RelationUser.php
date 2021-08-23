<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class RelationUser extends Pivot
{
    use HasFactory;
    protected $table = 'relation_user';
    protected $appends = array('sender_id');
    public $senderId;
    protected $hidden = [
        'user1_id',
        'user2_id',
        'created_at',
        'updated_at'
    ];
    public function getSenderIdAttribute(){
        return $this->senderId;
    }

}
