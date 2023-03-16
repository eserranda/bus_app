<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GajiKaryawan extends Model
{
    use HasFactory;

    protected $fillable = ['date', 'kode_gaji_karyawan', 'id_karyawan', 'month', 'jabatan', 'gaji_pokok', 'bonus', 'potongan', 'potongan', 'total_gaji', 'status'];

    public function karyawan()
    {
        return $this->belongsTo(DataKaryawan::class, 'id_karyawan', 'id');
    }
}