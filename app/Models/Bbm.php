<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bbm extends Model
{
    use HasFactory;

    protected $fillable = ['date', 'jenis_bbm', 'kode_transaksi', 'id_bus', 'jumlah_liter', 'total_harga', 'status'];

    public function bus()
    {
        return $this->belongsTo(Bus::class, 'id_bus', 'id');
    }
}