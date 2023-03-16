<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use App\Models\Rute;
use App\Models\PersenanGaji;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PersenanGajiController extends Controller
{
    public function index(Request $request)
    {

        $persenan = PersenanGaji::orderBy('from_city', 'asc')->get();

        return view('pimpinan.driver.persenan_gaji', ['listPersenan' => $persenan]);
    }

    public function add(Request $request)
    {
        $rute = Rute::all();
        return view('pimpinan.driver.add_persenan_gaji', ['ruteList' => $rute,]);
    }

    public function toCity(Request $request)
    {
        $from_city = $request->input('from_city');
        $rute = Rute::where('city', '!=', $from_city)->get();

        return response()->json($rute);
    }

    public function edit(Request $request, $id)
    {
        $persenan = PersenanGaji::findOrFail($id);

        $id_city = $persenan->from_city;

        $rute = Rute::whereNotIn('city', [$id_city])->get();
        // dd($rute);
        return view('pimpinan.driver.edit_persenan_gaji', ['listDataPersenan' => $persenan, 'ListRute' => $rute]);
    }
    public function update(Request $request, $id)
    {
        $Get_data = PersenanGaji::findOrFail($id);

        $Get_data->update($request->all());

        if ($Get_data) {
            Session::flash('status', 'success');
            Session::flash('message', 'Data berhasil Diupdate!');
        }
        return redirect('/pimpinan/persenan-gaji');
    }
    public function store(Request $request)
    {
        // $persenanGaji = PersenanGaji::all();
        // if ($persenanGaji->count() > 0) {
        //     $persenanGaji->first()->delete();
        // }

        $store = PersenanGaji::create($request->all());

        if ($store) {
            Session::flash('status', 'success');
            Session::flash('message', 'Data berhasil disimpan!');
        }
        return redirect('pimpinan/persenan-gaji');
    }

    public function delete($id)
    {
        $delete = PersenanGaji::findOrFail($id);
        $delete->delete();
        if ($delete) {
            Session::flash('status', 'success');
            Session::flash('message', 'Data berhasil Dihapus!');
        }
        return redirect('pimpinan/persenan-gaji');
    }
}