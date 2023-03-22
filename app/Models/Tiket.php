<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tiket extends Model
{
    use HasFactory;
    protected $table = 'data_tiket';
    protected $fillable = ['no_ticket', 'departure_code',  'departure_time', 'date', 'bus', 'from_city', 'to_city', 'price', 'seats_number', 'total_seats', 'customer_name', 'customers_phone_number', 'customers_address', 'payment_methods', 'status'];

    protected $casts = [
        'seats_number' => 'array',
    ];

    public function bus_name()
    {
        return $this->belongsTo(Bus::class, 'bus', 'id');
    }
}
