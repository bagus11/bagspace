<?php

namespace App\Models\Booking;

use App\Models\Setting\MasterLocation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApprovalModel extends Model
{
    use HasFactory;
    protected $table = 'approval_model';
    protected $guarded = [];

    function locationRelation(){
        return $this->hasOne(MasterLocation::class,'id','location_id');
    }
    function approvalRelation() {
        return $this->hasOne(User::class,'id','user_id');
    }
}
