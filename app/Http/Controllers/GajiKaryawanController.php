<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\GajiDriver;
use App\Models\DataKaryawan;
use App\Models\GajiKaryawan;
use Illuminate\Http\Request;
use App\Models\LaporanKeuangan;
use Illuminate\Support\Facades\Session;

class GajiKaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = GajiKaryawan::all()
            ->map(function ($data) {
                $data->date = Carbon::createFromFormat('Y-m-d', $data->date)->format('d-m-Y');
                $data->month = Carbon::createFromFormat('Y-m',  $data->month)
                    ->locale('id') // set bahasa Indonesia sebagai locale
                    ->isoFormat('MMMM Y'); // gunakan format MMMM Y untuk bulan dan tahun
                $data->gaji_pokok  = 'Rp' . number_format($data->gaji_pokok, 0, ',', '.');
                $data->bonus       = 'Rp' . number_format($data->bonus, 0, ',', '.');
                $data->potongan    = 'Rp' . number_format($data->potongan, 0, ',', '.');
                $data->total_gaji  = 'Rp' . number_format($data->total_gaji, 0, ',', '.');

                return $data;
            });
        return view('pimpinan.bop.gaji_karyawan', ['ListData' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $karyawan = DataKaryawan::all();
        return view('pimpinan.bop.add_gaji_karyawan', ['ListKaryawan' => $karyawan]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $id_karyawan = request('id_karyawan');

        $get_data = DataKaryawan::where('id', $id_karyawan)->first();

        $jabatan = $get_data->position;

        $latestData = GajiKaryawan::latest('kode_gaji_karyawan')->first();
        if ($latestData) {
            $parts = explode('-', $latestData->kode_gaji_karyawan);
            $code = $parts[0];
            $num = intval($parts[1]);
            if ($num == 999) {
                $new_code = ++$code;
                $num = 1000;
            } else {
                $num++;
                $new_code = $code;
            }
            $new_kode_gaji = $new_code . '-' . str_pad($num, 3, '0', STR_PAD_LEFT);
        } else {
            $new_kode_gaji = "KGK-001";
        }

        $save_data = GajiKaryawan::create([
            'date'               => request('date'),
            'kode_gaji_karyawan' =>  $new_kode_gaji,
            'id_karyawan'        => request('id_karyawan'),
            'month'              => request('month'),
            'jabatan'            => $jabatan,
            'gaji_pokok'         => request('gaji_pokok'),
            'bonus'              => request('bonus'),
            'potongan'           => request('potongan'),
            'total_gaji'         => request('total_gaji'),
            'status'             => false,
        ]);
        if ($save_data) {
            Session::flash('status', 'success');
        }
        return redirect('pimpinan/gaji-karyawan');
    }

    /**
     * Display the specified resource.
     */
    public function show(GajiKaryawan $gajiKaryawan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GajiKaryawan $gajiKaryawan, $id)
    {
        //whereNotIn() Tipe data yang di terima harus berupa Array
        $edit = GajiKaryawan::findOrFail($id);

        $id_karyawan = $edit->id_karyawan;

        $karyawan = DataKaryawan::whereNotIn('id', [$id_karyawan])->get();

        return view('pimpinan.bop.edit_gaji_karyawan', ['ListData' => $edit, 'ListKaryawan' => $karyawan]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $get_data = GajiKaryawan::findOrFail($id);

        $jabatan = $get_data->jabatan;

        $get_data->update([
            'date'                  => request('date'),
            'kode_gaji_karyawan'    => request('kode_gaji_karyawan'),
            'id_karyawan'           => request('id_karyawan'),
            'month'                 => request('month'),
            'jabatan'               => $jabatan,
            'gaji_pokok'            => request('gaji_pokok'),
            'bonus'                 => request('bonus'),
            'potongan'              => request('potongan'),
            'total_gaji'            => request('total_gaji'),
            'status'                => false,
        ]);

        if ($get_data) {
            Session::flash('status', 'success');
            Session::flash('message', 'Data berhasil Dihapus!');
        }
        return redirect('pimpinan/gaji-karyawan');
    }

    public function financial_save(Request $request)
    {
        $id = request('id');

        $get_data = GajiKaryawan::findOrFail($id);

        $kode           = $get_data->kode_gaji_karyawan;
        $date           = $get_data->date;

        $newmonth = Carbon::createFromFormat('Y-m', $get_data->month)
            ->locale('id')
            ->isoFormat('MMMM Y');

        $id_karyawan    = $get_data->karyawan->fullname;
        $debet          = $get_data->total_gaji;

        $total_saldo = LaporanKeuangan::latest('created_at')->first();

        $total_debet = $total_saldo->total_dana - $debet;

        $insert_data = LaporanKeuangan::create([
            'date'           =>  $date,
            'kode_transaksi' =>  $kode,
            'keterangan'     =>  "Gaji $id_karyawan Bulan $newmonth",
            'debet'          =>   $debet,
            'total_dana'     =>  $total_debet,
        ]);

        $get_data->update([
            'status' => true,
        ]);


        if ($insert_data && $get_data) {
            return response()->json(['sukses' => 'Data Berhasil di simpan']);
        } else {
            return response()->json(['Gagal' => 'Terjadi Kesalahan'], 404);
        }
    }

    public function destroy(GajiKaryawan $gajiKaryawan, $id)
    {
        $delete = GajiKaryawan::findOrFail($id);
        $delete->delete();

        if ($delete) {
            return response()->json(['sukses' => 'Data Berhasil di simpan']);
        } else {
            return response()->json(['Gagal' => 'Terjadi Kesalahan'], 404);
        }
    }
}