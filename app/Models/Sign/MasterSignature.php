<?php

namespace App\Models\Sign;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterSignature extends Model
{
    use HasFactory;
    protected $table = 'master_signature';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }
}
