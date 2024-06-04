<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SignatureHeader extends Model
{
    use HasFactory;
    protected $table = "signature_header";
    protected $guarded = [];
}
