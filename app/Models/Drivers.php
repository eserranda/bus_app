<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Drivers extends Model
{
    use HasFactory;

    protected $table = 'data_driver';
    protected $fillable = ['fullname', 'gender', 'driver_type', 'phone', 'entry_year', 'address', 'status'];
    public $timestamps = false;
}
