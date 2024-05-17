<?php

namespace App\Models\Timeline;

use App\Models\Setting\MasterLocation;
use App\Models\User;
use CreateTimelineSubDetailsTable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimelineHeader extends Model
{
    use HasFactory;
    protected $table = 'timeline_header';
    protected $guarded = [];

    function officeRelation(){
        return $this->hasOne(MasterLocation::class,'id','office_id');
    }
    function teamRelation() {
        return $this->hasOne(MasterTeamTimeline::class,'id','team_id');
    }
    function picRelation(){
        return $this->hasOne(User::class,'id','user_id');
    }
    function taskRelation() {
        return $this->hasMany(TimelineSubDetail::class,'request_code', 'request_code');
    }
    function detailRelation() {
        return $this->hasMany(TimelineDetail::class,'request_code','request_code');
    }
    function typeRelation() {
        return $this->hasOne(MasterTypeTimeline::class,'id','type_id');
    }
}
