<?php

namespace App\Models\Booking;

use App\Models\Setting\MasterLocation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterApproval extends Model
{
    use HasFactory;
    protected $table = 'master_approval';
    protected $guarded = [];
    function locationRelation(){
        return $this->hasOne(MasterLocation::class,'id','location_id');
    }
}
