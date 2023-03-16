<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use App\Models\BusSeat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class BusController extends Controller
{
    public function index()
    {
        $bus = Bus::all();
        return view('admin.data_bus', ['busList' => $bus]);
    }

    public function store(Request $request)
    {
        $bus = Bus::create($request->all());

        if ($bus) {
            Session::flash('status', 'success');
            Session::flash('message', 'Data berhasil Ditambah!');
        }
        return redirect('admin/data-armada');
    }

    public function edit(Request $request, $id)
    {
        $bus = Bus::findOrFail($id);
        return view('admin.edit_bus', ['dataBus' => $bus]);
    }

    public function update(Request $request, $id)
    {
        $driver = Bus::findOrFail($id);
        $driver->update($request->all());
        if ($driver) {
            Session::flash('status', 'success');
            Session::flash('message', 'Data berhasil Diupdate!');
        }
        return redirect('admin/data-armada')->with('status', 'Data berhasil di update!');
    }

    public function delete($id)
    {
        $driver = Bus::findOrFail($id);
        $driver->delete();
        if ($driver) {
            Session::flash('status', 'success');
            Session::flash('message', 'Data berhasil Dihapus!');
        }
        return redirect('admin/data-armada');
    }
}
