<?php

namespace App\Models;

use App\Models\Setting\MasterLocation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LibraryModel extends Model
{
    use HasFactory;
    protected $table = 'library_model';
    protected $guarded = [];

    function locationRelation() {
            return $this->hasOne(MasterLocation::class,'id', 'location');
    }
    function departmentRelation() {
            return $this->hasOne(MasterDepartment::class,'id', 'department');
    }
    function userRelation() {
            return $this->hasOne(User::class,'id', 'user_id');
    }
}
