<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiTiket extends Model
{
    use HasFactory;

    protected $fillable = ['date', 'departure_code', 'from_city', 'to_city', 'total_ticket', 'total_price'];
}
