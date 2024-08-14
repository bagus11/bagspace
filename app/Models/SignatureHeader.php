<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SignatureHeader extends Model
{
    use HasFactory;
    protected $table = "signature_header";
    protected $guarded = [];

    public function SignatureDetail()
    {
        return $this->hasMany(SignatureDetail::class, 'signature_id', 'id');
    }
    function userRelation() {
        return $this->hasOne(User::class,'id','user_id');
    }
}
