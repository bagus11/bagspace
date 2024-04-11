<?php

namespace App\Models\Booking;

use App\Models\Setting\MasterLocation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingHeader extends Model
{
    use HasFactory;
    protected $table = 'booking_header';
    protected $guarded = [];

    function locationRelation(){
        return $this->hasOne(MasterLocation::class,'id','location_id');
    }
    function userRelation() {
        return $this->hasOne(User::class,'id','user_id');
    }
    function approverRelation() {
        return $this->hasOne(User::class,'id','approval_id');
    }
    function roomRelation() {
        return $this->hasOne(MasterRoomModel::class,'id','room_id');
    }
}
