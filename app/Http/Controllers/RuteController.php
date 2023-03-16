<?php

namespace App\Http\Controllers;

use App\Models\Rute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class RuteController extends Controller
{
    public function index()
    {
        $rute = Rute::all();
        return view('admin.data_rute', ['ruteList' => $rute]);
    }

    public function add()
    {
        return view('admin.add_rute');
    }

    public function store(Request $request)
    {
        $rute = Rute::create($request->all());
        if ($rute) {
            Session::flash('status', 'success');
            Session::flash('message', 'Data berhasil Ditambah!');
        }
        return redirect('admin/data-rute');
    }

    public function edit(Request $request, $id)
    {
        $rute = Rute::findOrFail($id);
        return view('admin.edit_rute', ['dataRute' => $rute]);
    }

    public function update(Request $request, $id)
    {
        $rute = Rute::findOrFail($id);
        $rute->update($request->all());
        if ($rute) {
            Session::flash('status', 'success');
            Session::flash('message', 'Data berhasil Diupdate!');
        }
        return redirect('admin/data-rute');
    }

    public function delete($id)
    {
        $rute = Rute::findOrFail($id);
        $rute->delete();
        if ($rute) {
            Session::flash('status', 'success');
            Session::flash('message', 'Data berhasil Dihapus!');
        }
        return redirect('admin/data-rute');
    }
}
