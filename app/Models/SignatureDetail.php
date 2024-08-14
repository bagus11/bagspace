<?php

namespace App\Models;

use App\Models\Sign\MasterSignature;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SignatureDetail extends Model
{
    use HasFactory;
    protected $table = 'signature_detail';
    protected $guarded = [];
    public function userRelation()
    {
        return $this->hasOne(User::class, 'id','user_id');
    }
    function signatureRelation() {
        return $this->hasOne(MasterSignature::class,'user_id', 'user_id');
    }
}
