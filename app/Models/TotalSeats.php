<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TotalSeats extends Model
{
    use HasFactory;

    protected $table = 'total_seats';
    protected $fillable = ['date', 'id_bus', 'seats_total'];

    public function bus_name()
    {
        return $this->belongsTo(Bus::class, 'id_bus', 'id');
    }
}
