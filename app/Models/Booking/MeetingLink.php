<?php

namespace App\Models\Booking;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeetingLink extends Model
{
    use HasFactory;
    protected $table = 'meeting_room_model';
    protected $guarded = [];
}
