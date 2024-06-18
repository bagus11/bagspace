<?php

namespace App\Models\Timeline;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimelineSubDetailLog extends Model
{
    use HasFactory;
    protected $table = 'timeline_sub_detail_log';
    protected $guarded = [];

    function userRelation(){
        return $this->hasOne(User::class, 'id','pic');
    }
    function creatorRelation(){
        return $this->hasOne(User::class, 'id','user_id');
    }
}
