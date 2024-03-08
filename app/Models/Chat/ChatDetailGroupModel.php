<?php

namespace App\Models\Chat;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatDetailGroupModel extends Model
{
    use HasFactory;
    protected $table = 'chat_detail_group';
    protected $guarded = [];

    function userRelation(){
        return $this->hasOne(User::class,'id','user_id');
    }
}
