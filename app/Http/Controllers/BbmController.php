<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Bbm;
use App\Models\Bus;
use Illuminate\Http\Request;
use App\Models\LaporanKeuangan;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class BbmController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $status = $request->input('filter');
            $start_date = $request->input('start_date');
            $end_date = $request->input('end_date');

            $query = Bbm::select('id', 'date', 'kode_transaksi', 'id_bus', 'jumlah_liter', 'total_harga', 'status')
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
                        'id'               => $data->id,
                        'date'             => $data->date,
                        'kode_transaksi'   => $data->kode_transaksi,
                        'id_bus'           => $data->bus->type . " | " .  $data->bus->plat,
                        'jumlah_liter'     => $data->jumlah_liter,
                        'total_harga'      => $data->total_harga,
                        'status'           => $status,
                        'nilai_status'     => $nilai_status
                    ];
                });

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('opsi', function ($row) {
                    if ($row['nilai_status'] == 0) {
                        $actionBtn = '<a class="btn btn-light text-danger btn-sm" onclick="deleteData(\'' . $row['id'] . '\', $(this).closest(\'tr\').find(\'td:eq(3)\').text())"> <i class="fa-regular fa-trash-can"></i></a>';
                        $actionBtn .= '<a class="btn btn-light text-dark btn-sm" href="/pimpinan/panjar-edit/' . $row['id'] . '"><i class="fa-solid fa-pen-to-square"></i></a>';
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
        return view('pimpinan.bop.bbm');
    }


    public function create()
    {
        $data = Bus::all();
        return view('pimpinan.bop.add_bbm', ['ListData' => $data]);
    }

    public function store(Request $request)
    {
        $latestData = Bbm::latest('kode_transaksi')->first();
        if ($latestData) {
            $parts = explode('-', $latestData->kode_transaksi);
            $code = $parts[0];
            $num = intval($parts[1]);
            if ($num == 999) {
                $new_code = ++$code;
                $num = 1000;
            } else {
                $num++;
                $new_code = $code;
            }
            $new_kode_transaksi = $new_code . '-' . str_pad($num, 3, '0', STR_PAD_LEFT);
        } else {
            $new_kode_transaksi = "BBM-001";
        }


        $save_data = Bbm::create([
            'kode_transaksi' => $new_kode_transaksi,
            'date' => request('date'),
            'id_bus' => request('id_bus'),
            'jumlah_liter' => request('jumlah_liter'),
            'total_harga' => request('total_harga'),

        ]);

        if ($save_data) {
            Session::flash('status');
        }

        return redirect('/pimpinan/bbm');
    }

    public function add_multiple()
    {
        $latestData = Bbm::latest('kode_transaksi')->first();
        if ($latestData) {
            $parts = explode('-', $latestData->kode_transaksi);
            $code = $parts[0];
            $num = intval($parts[1]);
            if ($num == 999) {
                $new_code = ++$code;
                $num = 1000;
            } else {
                $num++;
                $new_code = $code;
            }
            $new_kode_transaksi = $new_code . '-' . str_pad($num, 3, '0', STR_PAD_LEFT);
        } else {
            $new_kode_transaksi = "BBM-001";
        }

        $databus = Bus::all();

        return view('pimpinan.bop.add_multiple_bbm', ['kode' => $new_kode_transaksi, 'ListBus' => $databus]);
    }


    function multiple_save(Request $request)
    {
        // $data = $request->all();
        $data = [
            'kode_transaksi' => request('kode_transaksi'),
            'date' => request('date'),
            'id_bus' => request('id_bus'),
            'jumlah_liter' => request('jumlah_liter'),
            'total_harga' => request('total_harga'),
        ];

        foreach ($data['kode_transaksi'] as $key => $value) {
            $newData = [
                'kode_transaksi'    => $value,
                'date'              => $data['date'][$key],
                'id_bus'            => $data['id_bus'][$key],
                'jumlah_liter'      => $data['jumlah_liter'][$key],
                'total_harga'       => $data['total_harga'][$key]
            ];

            $save_data = Bbm::create($newData);
        }
        // if ($save_data) {
        //     return response()->json(['sukses' => 'Data Berhasil di simpan']);
        // } else {
        //     return response()->json(['Gagal' => 'Terjadi Kesalahan'], 404);
        // }

        if ($save_data) {
            Session::flash('status', 'success');
            Session::flash('message', 'Data berhasil disimpan!');
        }
        return redirect('pimpinan/bbm');
    }

    public function show(Bbm $bbm)
    {
        //
    }

    public function edit(Bbm $bbm, $id)
    {
        $data = Bbm::findOrFail($id);

        $bus_id = $data->id_bus;

        $bus = Bus::whereNotIn('id', [$bus_id])->get();

        return view('pimpinan.bop.edit_bbm', ['ListData' => $data, 'ListBus' => $bus]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $get_data = Bbm::findOrFail($id);
        $get_data->update($request->all());

        if ($get_data) {
            Session::flash('success');
        }
        return redirect('pimpinan/bbm');
    }

    public function financial_save(Request $request)
    {
        $id = request('id');
        $get_data = Bbm::findOrFail($id);

        $kode           = $get_data->kode_transaksi;
        $date           = $get_data->date;
        $id_bus         = $get_data->bus->type;
        $debet          = $get_data->total_harga;

        $total_saldo = LaporanKeuangan::latest('created_at')->first();
        $total_debet = $total_saldo->total_dana - $debet;

        try {
            DB::beginTransaction();
            LaporanKeuangan::create([
                'date' => $date,
                'kode_transaksi' => $kode,
                'keterangan' => "Pemebelian BBM Bus $id_bus Tanggal $date",
                'debet'         =>   $debet,
                'total_dana'     =>  $total_debet,
            ]);
            $get_data->update([
                'status' => 1,
            ]);
            DB::commit();
            return response()->json(['sukses' => 'Data Berhasil di simpan']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['gagal' => 'Terjadi Kesalahan'], $e);
        }

        // $id = request('id');
        // $get_data = Bbm::findOrFail($id);

        // $kode           = $get_data->kode_transaksi;
        // $date           = $get_data->date;
        // $id_bus         = $get_data->bus->type;
        // $debet          = $get_data->total_harga;

        // $total_saldo = LaporanKeuangan::latest('created_at')->first();

        // $total_debet = $total_saldo->total_dana - $debet;

        // $insert_data = LaporanKeuangan::create([
        //     'date'           =>  $date,
        //     'kode_transaksi' =>  $kode,
        //     'keterangan'     =>  "Pemebelian BBM Bus $id_bus Tanggal $date",
        //     'debet'         =>   $debet,
        //     'total_dana'     =>  $total_debet,
        // ]);

        // $get_data->update([
        //     'status' => true,  //status true berarti telah di input ke laopran keuangan
        // ]);


        // if ($insert_data && $get_data) {
        //     return response()->json(['sukses' => 'Data Berhasil di simpan']);
        // } else {
        //     return response()->json(['Gagal' => 'Terjadi Kesalahan'], 404);
        // }
    }

    public function destroy(Bbm $bbm, $id)
    {
        $id = Bbm::findOrFail($id);
        $id->delete();

        if ($id) {
            return response()->json(['sukses' => 'Data Berhasil di simpan']);
        } else {
            return response()->json(['Gagal' => 'Terjadi Kesalahan'], 404);
        }
    }
}
