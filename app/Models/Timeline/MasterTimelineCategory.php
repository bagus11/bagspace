<?php

namespace App\Models\Timeline;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterTimelineCategory extends Model
{
    use HasFactory;
    protected $table = 'master_timeline_category';
    protected $guarded = [];

    function typeRelation() {
        return $this->hasOne(MasterTypeTimeline::class,'id','type_id');
    }
}
