<?php

namespace App\Models;

use App\Models\Timeline\MasterTeamTimeline;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class logTimelineHistoryDate extends Model
{
    use HasFactory;
    protected $table = 'log_timeline_history_date';
    protected $guarded = [];
    function teamRelation() {
        return $this->hasOne(MasterTeamTimeline::class,'id','team_id');
    }
    function picRelation(){
        return $this->hasOne(User::class,'id','user_id');
    }
}
