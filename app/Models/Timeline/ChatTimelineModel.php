<?php

namespace App\Models\Timeline;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatTimelineModel extends Model
{
    use HasFactory;
    protected $table = 'chat_timeline_model';
    protected $guarded = [];
    function userRelation(){
        return $this->hasOne(User::class,'id','user_id');
    }
}
