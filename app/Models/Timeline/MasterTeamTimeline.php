<?php

namespace App\Models\Timeline;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterTeamTimeline extends Model
{
    use HasFactory;
    protected $table = 'master_team_timeline';
    protected $guarded = [];

    function userRelation() {
        return $this->hasMany(User::class,'id','user_id');
    }
    function detailRelation() {
        return $this->hasMany(DetailTeamTimeline::class,'team_id','id');
    }
}
