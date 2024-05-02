<?php

namespace App\Models\Timeline;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTeamTimeline extends Model
{
    use HasFactory;
    protected $table = 'detail_team_timeline';
    protected $guarded = [];

    function userRelation(){
        return $this->hasOne(User::class,'id','user_id');
    }
 

}
