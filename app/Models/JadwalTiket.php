<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class JadwalTiket extends Model
{
    use HasFactory;

    // protected $table = 'jadwal_tikets';
    protected $fillable = ['departure_date', 'departure_code', 'departure_time', 'id_bus', 'to_city', 'from_city', 'sopir_utama', 'sopir_bantu', 'kondektur', 'price', 'status'];

    public function bus()
    {
        return $this->belongsTo(Bus::class, 'id_bus', 'id');
    }
    public function driver()
    {
        return $this->belongsTo(Drivers::class, 'sopir_utama', 'id');
    }
    public function sopirBantu()
    {
        return $this->belongsTo(Drivers::class, 'sopir_bantu', 'id');
    }
    public function Kondektur()
    {
        return $this->belongsTo(Drivers::class, 'kondektur', 'id');
    }
}