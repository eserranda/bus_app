<?php

namespace App\Http\Controllers;

use App\Models\Tiket;
use Illuminate\Http\Request;
use App\Models\Keberangkatan;
use App\Models\TransaksiTiket;
use App\Models\LaporanKeuangan;
use Illuminate\Support\Facades\DB;

class TransaksiTiketController extends Controller
{


    // public function index()
    // {
    // $tiket = TransaksiTiket::all();
    // return view('pimpinan.laporan.transaksi_tiket', ['tiketList' => $tiket,]);
    // return view('pimpinan.laporan.transaksi_tiket');
    // }


    // public function trasaksi_tiket()
    // {
    //     $dates = Keberangkatan::whereNotNull('departure_code')->get();
    //     if (count($dates) > 0) {
    //         $response = array();
    //         foreach ($dates as $mydata) {
    //             $response[] = [
    //                 'id'              => $mydata->id,
    //                 'departure_code'  => $mydata->departure_code,
    //                 'date'            => $mydata->departure_date,
    //                 'from_city'       => $mydata->from_city,
    //                 'to_city'         => $mydata->to_city,
    //                 'total_ticket'    => $mydata->total_passenger,
    //                 'total_price'     => $mydata->total_price,
    //                 'status'          => $mydata->status,
    //             ];
    //         }


    // foreach ($response as $data) {
    //     TransaksiTiket::updateOrCreate(
    //         ['departure_code' => $data['departure_code']],
    //         [
    //             'id'           => $data['id'],
    //             'date'         => $data['date'],
    //             'from_city'    => $data['from_city'],
    //             'to_city'      => $data['to_city'],
    //             'total_ticket' => $data['total_ticket'],
    //             'total_price'  => $data['total_price'],
    //             'status'       => $data['status']
    //         ]
    //     );
    // }
    //         return response()->json($response);
    //     } else {
    //         return response()->json(404);
    //     }
    // }

    // public function financial_tiket_save()
    // {
    //     $id = request('id');
    //     $get_data = TransaksiTiket::findOrFail($id);

    //     $harga = $get_data->harga;
    //     $date = $get_data->date;
    //     $kode = $get_data->kode_transaksi;
    //     $keterangan = $get_data->jenis_pengeluaran;

    //     $total_saldo = LaporanKeuangan::latest('created_at')->first();
    //     $credit = $total_saldo->total_dana - $harga;

    //     try {
    //         DB::beginTransaction();
    //         LaporanKeuangan::create([
    //             'date' => $date,
    //             'kode_transaksi' => $kode,
    //             'keterangan' => $keterangan,
    //             'debet' => $harga,
    //             'total_dana' => $credit,
    //         ]);
    //         $get_data->update([
    //             'status' => 1,
    //         ]);
    //         DB::commit();
    //         return response()->json(['sukses' => 'Data Berhasil di simpan']);
    //     } catch (\Exception $e) {
    //         DB::rollback();
    //         return response()->json(['Gagal' => 'Terjadi Kesalahan'], 404);
    //     }
    // }

    // public function create()
    // {

    // }

    // /**
    //  * Store a newly created resource in storage.
    //  */
    // public function store(Request $request)
    // {
    //     //
    // }

    // /**
    //  * Display the specified resource.
    //  */
    // public function show(TransaksiTiket $transaksiTiket)
    // {
    //     //
    // }

    // /**
    //  * Show the form for editing the specified resource.
    //  */
    // public function edit(TransaksiTiket $transaksiTiket)
    // {
    //     //
    // }

    // /**
    //  * Update the specified resource in storage.
    //  */
    // public function update(Request $request, TransaksiTiket $transaksiTiket)
    // {
    //     //
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  */
    // public function destroy(TransaksiTiket $transaksiTiket)
    // {
    //     //
    // }
}
