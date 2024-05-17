<?php

namespace App\Models\Timeline;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterTypeTimeline extends Model
{
    use HasFactory;
    protected $table = 'master_type_timeline';
    protected $guarded = [];
}
