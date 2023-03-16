<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersenanGaji extends Model
{
    use HasFactory;

    protected $table = 'persenan_gaji';
    protected $fillable = ['sopir_utama', 'sopir_bantu', 'kondektur', 'from_city', 'to_city'];
}