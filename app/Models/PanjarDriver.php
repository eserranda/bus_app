<?php

namespace App\Models;

use App\Models\Drivers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class PanjarDriver extends Model
{
    use HasFactory;
    protected $fillable = ['kode_panjar', 'date', 'id_driver', 'down_payment', 'status', 'keterangan'];

    public function driver()
    {
        return $this->belongsTo(Drivers::class, 'id_driver', 'id');
    }
}
