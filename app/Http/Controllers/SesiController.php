<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SesiController extends Controller
{
    function index()
    {
        return view('auth.login');
    }

    function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ], [
            'email.required' => 'Email  Harus di isi',
            'password.required' => 'Password harus di isi'
        ]);

        $infologin = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($infologin)) {
            $request->session()->put('role', Auth::user()->role);
            $request->session()->put('nama', Auth::user()->name);
            if (session('role') === 'pimpinan') {
                return view('pimpinan.chart.data_chart');
            } else if (session('role') === 'pegawai') {
                return view('admin.index');
            }
            // return redirect()->intended('pimpinan');

            // return redirect('pimpinan');
            // // echo 'sukses';
            // exit();
        } else {
            return redirect('login')->withErrors('Username dan password tidak sesuai')->withInput();
        }
    }

    function logout()
    {
        session()->flush();
        Auth::logout();
        return redirect('login');
    }
}