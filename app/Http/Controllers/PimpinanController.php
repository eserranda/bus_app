<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PimpinanController extends Controller
{
    function index()
    {
        // $role = Auth::user()->role;
        // $nama = Auth::user()->name;

        $role = Auth::user()->role;
        $nama = Auth::user()->name;
        if (session('role') === 'pimpinan') {
            return view('pimpinan.dashboard.index', ['nama' => $nama, 'role' => $role]);
        } else if (session('role') === 'pegawai') {
            return view('admin.pemesanan_tiket', ['nama' => $nama, 'role' => $role]);
        }
    }
}