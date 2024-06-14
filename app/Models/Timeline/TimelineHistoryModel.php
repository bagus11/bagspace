<?php

namespace App\Models\Timeline;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimelineHistoryModel extends Model
{
    use HasFactory;
    protected $table = 'timeline_header';
    protected $guarded = [];
}
