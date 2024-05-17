<?php

namespace App\Models\Timeline;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimelineSubDetail extends Model
{
    use HasFactory;
    protected $table = 'timeline_sub_detail';
    protected $guarded = [];

    function userRelation(){
        return $this->hasOne(User::class, 'id','pic');
    }
    function detailRelation() {
        return $this->hasOne(TimelineDetail::class,'detail_code','detail_code');
    }
    function headerRelation() {
        return $this->hasOne(TimelineHeader::class,'request_code','request_code');
    }


}
