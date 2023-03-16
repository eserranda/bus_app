<?php

namespace App\Http\Controllers;

use App\Models\Tiket;
use Illuminate\Http\Request;


class TiketController extends Controller
{
    public function index()
    {
        // Tidak di pakai
        // Tidak di pakai
        // Tidak di pakai
        // Tidak di pakai
        // Tidak di pakai
        // Tidak di pakai
        // Tidak di pakai
        // Tidak di pakai

        $tiket = Tiket::all();
        return view('admin.data_tiket', ['tiketList' => $tiket,]);
    }
}
