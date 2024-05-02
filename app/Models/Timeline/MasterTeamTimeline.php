<?php

namespace App\Models\Timeline;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterTeamTimeline extends Model
{
    use HasFactory;
    protected $table = 'master_team_timeline';
    protected $guarded = [];
}
