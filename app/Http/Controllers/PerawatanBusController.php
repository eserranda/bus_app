<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\PerawatanBus;
use Illuminate\Http\Request;
use App\Models\LaporanKeuangan;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;



class PerawatanBusController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $status = $request->input('filter');
            $start_date = $request->input('start_date');
            $end_date = $request->input('end_date');

            $query = PerawatanBus::select('*')
                ->orderBy('date', 'asc');

            if (isset($status)) {
                if ($status === 'all_data') {
                    // Jika filter == 'all_data', tampilkan seluruh data
                } else {
                    // Jika filter == '1' atau '2', tampilkan data sesuai status
                    $query->where('status', $status);
                }
            } elseif (isset($start_date) && isset($end_date)) {
                $query->whereBetween('date', [$start_date, $end_date]);
            } else {
                // Jika tidak ada filter yang diberikan, tampilkan data bulan ini
                $query->whereMonth('date', Carbon::now()->month);
            }

            $data = $query->get()
                ->map(function ($data) {
                    $data->date = Carbon::createFromFormat('Y-m-d', $data->date)->format('d-m-Y');
                    $data->total_harga = 'Rp' . number_format($data->total_harga, 0, ',', '.');
                    if ($data->status == 0) {
                        $status = '<span class="badge text-bg-danger">Belum Lunas</span>';
                    } elseif ($data->status == 1) {
                        $status = '<span class="badge text-bg-success">Lunas</span>';
                    } else {
                        $status = '<span class="badge text-bg-warning">Arsip</span>';
                    }
                    $nilai_status =  $data->status;
                    return [
                        'id'                => $data->id,
                        'kode_transaksi'    => $data->kode_transaksi,
                        'date'              => $data->date,
                        'jenis_pengeluaran' => $data->jenis_pengeluaran,
                        'harga'             => $data->harga,
                        'status'            => $status,
                        'nilai_status'      => $nilai_status
                    ];
                });

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('opsi', function ($row) {
                    if ($row['nilai_status'] == 0) {
                        $actionBtn = '<a class="btn btn-light text-danger btn-sm" onclick="deleteData(\'' . $row['id'] . '\', $(this).closest(\'tr\').find(\'td:eq(2)\').text())">  <i class="fa-regular fa-trash-can"></i>  </a>';
                        $actionBtn .= '<a class="btn btn-light text-dark btn-sm mx-1" href="/pimpinan/perawatan-armada-edit/' . $row['id'] . '"><i class="fa-solid fa-pen-to-square"></i></a>';
                        $actionBtn .= '<a class="btn btn-light text-primary btn-sm financial-save" data-toggle="tooltip" title="Input ke laporan Keuangan" onclick="financial_save(\'' . $row['id'] . '\')"><i class="fa-solid fa-file-medical"></i></a>';
                        return $actionBtn;
                    } else {
                        $actionBtn = '<span class="badge text-bg-warning">Arsip</span>';
                        return $actionBtn;
                    }
                })
                ->rawColumns(['opsi', 'status'])
                ->make(true);
        }
        return view('pimpinan.bop.perawatan_bus');
    }



    public function create()
    {
        $latestData = PerawatanBus::latest('kode_transaksi')->first();
        if ($latestData) {
            $parts = explode('-', $latestData->kode_transaksi);
            $code = $parts[0];
            $num = intval($parts[1]);
            if ($num == 999) {
                $num = 1;
            } else {
                $num++;
            }
            $new_no_kode = $code . '-' . str_pad($num, 3, '0', STR_PAD_LEFT);
        } else {
            $new_no_kode = "BOP-001";
        }

        return view('pimpinan.bop.add_perawatan_bus', ['kode' => $new_no_kode]);
    }

    public function add_multiple()
    {
        $latestData = PerawatanBus::latest('kode_transaksi')->first();
        if ($latestData) {
            $parts = explode('-', $latestData->kode_transaksi);
            $code = $parts[0];
            $num = intval($parts[1]);
            if ($num == 999) {
                $num = 1;
            } else {
                $num++;
            }
            $new_no_ticket = $code . '-' . str_pad($num, 3, '0', STR_PAD_LEFT);
        } else {
            $new_no_ticket = "BOP-001";
        }
        return view('pimpinan.bop.add_multiple_perawatan_bus', ['kode' => $new_no_ticket]);
    }

    function multiple_save(Request $request)
    {
        $data = $request->all();

        foreach ($data['kode_transaksi'] as $key => $value) {
            $newData = [
                'kode_transaksi' => $value,
                'date' => $data['date'][$key],
                'jenis_pengeluaran' => $data['jenis_pengeluaran'][$key],
                'harga' => $data['harga'][$key]
            ];

            $save_data =  PerawatanBus::create($newData);
        }
        // return response()->json(['message' => 'Data berhasil disimpan.']);

        // if ($save_data) {
        //     return response()->json(['sukses' => 'Data Berhasil di simpan']);
        // } else {
        //     return response()->json(['Gagal' => 'Terjadi Kesalahan'], 404);
        // }

        if ($save_data) {
            Session::flash('status', 'success');
        } else {
            Session::flash('error', 'Data Gagal di simpan');
        }
        return redirect('pimpinan/perawatan-armada');
    }


    public function store(Request $request)
    {
        $driver = PerawatanBus::create($request->all());

        $total_saldo = LaporanKeuangan::latest('created_at')->first();

        $debet = $total_saldo->total_dana - request('harga');

        LaporanKeuangan::create([
            'date'           =>  request('date'),
            'kode_transaksi' =>  request('kode_transaksi'),
            'keterangan'     =>  request('jenis_pengeluaran'),
            'debet'          =>  request('harga'),
            'total_dana'     =>   $debet
        ]);


        if ($driver) {
            Session::flash('status', 'success');
            Session::flash('message', 'Data berhasil Ditambah!');
        }
        return redirect('pimpinan/perawatan-armada');
    }


    public function show(PerawatanBus $perawatanBus, $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PerawatanBus $perawatanBus, $id)
    {
        $data = PerawatanBus::findOrFail($id);

        return view('pimpinan.bop.edit_perawatan_bus', [
            'ListData' => $data,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $Get_data = PerawatanBus::findOrFail($id);

        $Get_data->update($request->all());


        if ($Get_data) {
            Session::flash('status', 'success');
            Session::flash('message', 'Data berhasil Diupdate!');
        }
        return redirect('pimpinan/perawatan-armada')->with('status', 'Data berhasil di update!');
    }

    public function financial_save(Request $request,)
    {

        $id = request('id');
        $get_data = PerawatanBus::findOrFail($id);

        $harga = $get_data->harga;
        $date = $get_data->date;
        $kode = $get_data->kode_transaksi;
        $keterangan = $get_data->jenis_pengeluaran;

        $total_saldo = LaporanKeuangan::latest('created_at')->first();
        $credit = $total_saldo->total_dana - $harga;

        try {
            DB::beginTransaction();
            LaporanKeuangan::create([
                'date' => $date,
                'kode_transaksi' => $kode,
                'keterangan' => $keterangan,
                'debet' => $harga,
                'total_dana' => $credit,
            ]);
            $get_data->update([
                'status' => 1,
            ]);
            DB::commit();
            return response()->json(['sukses' => 'Data Berhasil di simpan']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['Gagal' => 'Terjadi Kesalahan'], 404);
        }

        // $id = request('id');
        // $get_data = PerawatanBus::findOrFail($id);

        // $harga      = $get_data->harga;
        // $date       = $get_data->date;
        // $kode       = $get_data->kode_transaksi;
        // $keterangan = $get_data->jenis_pengeluaran;

        // $total_saldo = LaporanKeuangan::latest('created_at')->first();

        // $credit = $total_saldo->total_dana - $harga;

        // $insert_data = LaporanKeuangan::create([
        //     'date'           =>  $date,
        //     'kode_transaksi' =>  $kode,
        //     'keterangan'     =>  $keterangan,
        //     'debet'          =>  $harga,
        //     'total_dana'     =>  $credit,
        // ]);

        // $get_data->update([
        //     'status' => 1,
        // ]);


        // if ($insert_data) {
        //     return response()->json(['sukses' => 'Data Berhasil di simpan']);
        // } else {
        //     return response()->json(['Gagal' => 'Terjadi Kesalahan'], 404);
        // }

        // return redirect('pimpinan/perawatan-armada')->with('status', 'Data berhasil di update!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PerawatanBus $perawatanBus, $id)
    {
        $id = PerawatanBus::findOrFail($id);
        $id->delete();

        if ($id) {
            return response()->json(['sukses' => 'Data Berhasil di simpan']);
        } else {
            return response()->json(['Gagal' => 'Terjadi Kesalahan'], 404);
        }
        // return redirect('pimpinan/perawatan-armada');
    }
}
