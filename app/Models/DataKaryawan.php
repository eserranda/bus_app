<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataKaryawan extends Model
{
    use HasFactory;

    protected $fillable = ['fullname', 'username', 'password', 'email', 'gender', 'phone', 'address', 'position', 'entry_year', 'status', 'images'];
}