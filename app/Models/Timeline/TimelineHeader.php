<?php

namespace App\Models\Timeline;

use App\Models\Setting\MasterLocation;
use App\Models\User;
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
}
