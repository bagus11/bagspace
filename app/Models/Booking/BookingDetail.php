<?php

namespace App\Models\Booking;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingDetail extends Model
{
    use HasFactory;
    protected $table = 'booking_detail';
    protected $guarded = [];

    function userRelation(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
