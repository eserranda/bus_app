<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;



class GajiDriver extends Model
{
    use HasFactory;

    protected $table = 'gaji_driver';
    protected $fillable = ['to_city', 'kode_gaji', 'departure_code', 'down_payment', 'from_city', 'date', 'id_driver', 'driver_type', 'salary', 'status'];


    public function driver()
    {
        return $this->belongsTo(Drivers::class, 'id_driver', 'id');
    }
}
