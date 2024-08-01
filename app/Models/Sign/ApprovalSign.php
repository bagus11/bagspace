<?php

namespace App\Models\Sign;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApprovalSign extends Model
{
    use HasFactory;
    protected $table = 'approval_sign';
    protected $guarded = [];

    public function userRelation()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
