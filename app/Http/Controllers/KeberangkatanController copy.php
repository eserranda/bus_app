<?php

namespace App\Http\Controllers;

use App\Models\JadwalTiket;
use App\Models\Tiket;
use Carbon\Carbon;
use Illuminate\Http\Request;

class KeberangkatanController extends Controller
{
    public function index()
    {

        $today = Carbon::today();
        $keberangkatan = JadwalTiket::whereDate('departure_date', $today)
            ->orderBy('departure_date', 'asc')
            ->get();

        $id_bus = JadwalTiket::whereDate('departure_date', $today)
            ->pluck('id_bus');

        $tiket  = Tiket::where('date', $today)
            ->whereIn('bus', $id_bus)
            ->get();

        $seats = $tiket->map(function ($t) {
            return explode(',', $t->seats_number);
        });

        $seats_merged = array_merge(...$seats->toArray());
        $total_seats = count($seats_merged);

        return view('admin.data_keberangkatan', ['listKeberangkatan' => $keberangkatan], ['total' => $total_seats]);
    }
}
