<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keberangkatan extends Model
{
    use HasFactory;

    protected $table = 'keberangkatan';

    protected $fillable = ['departure_date', 'departure_time', 'total_price', 'departure_code', 'id_bus', 'from_city', 'to_city', 'departure_time', 'sopir_utama', 'sopir_bantu', 'kondektur', 'total_passenger', 'status'];

    public function bus()
    {
        return $this->belongsTo(Bus::class, 'id_bus', 'id');
    }

    public function sopirUtama()
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
