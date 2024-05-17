<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LibraryBackup extends Model
{
    use HasFactory;
    protected $table = 'library_backup';
    protected $guarded = [];

    function userRelation() {
        return $this->hasOne(User::class,'id','user_id');
    }
}
