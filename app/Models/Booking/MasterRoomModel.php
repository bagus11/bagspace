<?php

namespace App\Models\Booking;

use App\Models\Setting\MasterLocation;
use App\Models\User;
use GuzzleHttp\Psr7\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterRoomModel extends Model
{
    use HasFactory;
    protected $table = 'master_room';
    protected $guarded = [];

    function locationRelation() {
        return $this->hasOne(MasterLocation::class,'id','location');
    }
    function userRelation() {
        return $this->hasOne(User::class,'id','user_id');
    }
}
