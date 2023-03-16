<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerawatanBus extends Model
{
    use HasFactory;

    protected $table    = 'perawatan_bus';
    protected $fillable = ['date', 'kode_transaksi', 'jenis_pengeluaran', 'harga', 'status'];
}
