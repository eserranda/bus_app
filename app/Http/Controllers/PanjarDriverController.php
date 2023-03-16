<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Drivers;
use App\Models\PanjarDriver;
use Illuminate\Http\Request;
use App\Models\LaporanKeuangan;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


class PanjarDriverController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $status = $request->input('filter');
            $query = PanjarDriver::select('*')
                ->orderBy('date', 'asc');

            if (isset($status)) {
                if ($status === 'all_data') {
                    // Jika filter == 'all_data', tampilkan seluruh data
                } else {
                    // Jika filter == '1' atau '2', tampilkan data sesuai status
                    $query->where('status', $status);
                }
            } else {
                // Jika tidak ada filter yang diberikan, tampilkan data bulan ini
                $query->whereMonth('date', Carbon::now()->month);
            }
            $data = $query->get()
                ->map(function ($data) {
                    $data->date = Carbon::createFromFormat('Y-m-d', $data->date)->format('d-m-Y');
                    $data->down_payment = 'Rp' . number_format($data->down_payment, 0, ',', '.');
                    if ($data->status == 0) {
                        $status = '<span class="badge text-bg-danger">Belum Lunas</span>';
                    } elseif ($data->status == 2) {
                        $status = '<span class="badge text-bg-success">Lunas</span>';
                    } elseif ($data->status == 3) {
                        $status = '<span class="badge text-bg-warning">Arsip</span>';
                    } elseif ($data->status == 1) {
                        $status = '<span class="badge text-bg-danger">Belum Lunas</span>';
                    }
                    $nilai_status =  $data->status;
                    return [
                        'id'             => $data->id,
                        'kode_panjar'    => $data->kode_panjar,
                        'date'           => $data->date,
                        'id_driver'      => $data->driver->fullname . " / " .  $data->driver->driver_type,
                        'down_payment'   => $data->down_payment,
                        'keterangan'     => $data->keterangan,
                        'status'         => $status,
                        'nilai_status'   => $nilai_status
                    ];
                });

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('opsi', function ($row) {
                    if ($row['nilai_status'] == 0) {
                        $actionBtn = '<a class="btn btn-light text-danger btn-sm" onclick="deleteData(\'' . $row['id'] . '\', $(this).closest(\'tr\').find(\'td:eq(3)\').text())"> <i class="fa-regular fa-trash-can"></i></a>';
                        $actionBtn .= '<a class="btn btn-light text-dark btn-sm mx-1" href="/pimpinan/panjar-edit/' . $row['id'] . '"><i class="fa-solid fa-pen-to-square"></i></a>';
                        // $actionBtn .=  '<a class="btn btn-light text-dark btn-sm financial-save"  onclick="lunas(\'' . $row['id'] . '\', $(this).closest(\'tr\').find(\'td:eq(3)\').text())"> Lunas </a>';
                        $actionBtn .= '<a class="btn btn-light text-primary btn-sm financial-save"  onclick="financial_down_payment_save(\'' . $row['id'] . '\')"><i  class="fa-solid fa-file-medical"></i></a>';
                        return $actionBtn;
                    } elseif ($row['nilai_status'] == 1) {
                        $actionBtn =  '<a class="btn btn-light text-dark btn-sm financial-save"  onclick="lunas(\'' . $row['id'] . '\', $(this).closest(\'tr\').find(\'td:eq(3)\').text())"> Lunasi </a>';
                        return $actionBtn;
                    } elseif ($row['nilai_status'] == 2) {
                        $actionBtn = '<a class="btn btn-light text-primary btn-sm financial-save"  onclick="financial_save(\'' . $row['id'] . '\')"><i  class="fa-solid fa-file-medical"></i></a>';
                        return $actionBtn;
                    }
                })
                ->rawColumns(['opsi', 'status'])
                ->make(true);
        }
        return view('pimpinan.driver.panjar_driver');
    }

    // $data = PanjarDriver::orderBy('status', 'asc')->get()
    //     ->map(function ($data) {
    //         $data->date = Carbon::createFromFormat('Y-m-d', $data->date)->format('d-m-Y');
    //         $data->down_payment = 'Rp' . number_format($data->down_payment, 0, ',', '.');
    //         return $data;
    //     });;
    // return view('pimpinan.driver.panjar_driver', ['ListData' => $data]);


    public function create()
    {
        // mengambil data yang belum ada 

        // $drivers = Drivers::whereNotIn('id', function ($query) {
        //     $query->select('id_driver')
        //         ->from('panjar_drivers');
        // })->get();

        // mengambil semua data 

        $drivers = Drivers::all();
        return view('pimpinan.driver.add_panjar_driver', ['ListDriver' => $drivers]);
    }

    public function store(Request $request)
    {
        $latestData = PanjarDriver::latest('kode_panjar')->first();
        if ($latestData) {
            $parts = explode('-', $latestData->kode_panjar);
            $code = $parts[0];
            $num = intval($parts[1]);
            if ($num == 999) {
                $num = 1;
            } else {
                $num++;
            }
            $new_kode_panjar = $code . '-' . str_pad($num, 3, '0', STR_PAD_LEFT);
        } else {
            $new_kode_panjar = "KPD-001";
        }

        $save_data = PanjarDriver::create([
            'kode_panjar'  => $new_kode_panjar,
            'date'         => request('date'),
            'id_driver'    => request('id_driver'),
            'down_payment' => request('down_payment'),
            'keterangan'   => "Pengambilan Panjar",
            'status'       => false,
        ]);

        if ($save_data) {
            return redirect('/pimpinan/panjar-driver');
        }
    }

    public function show(PanjarDriver $panjarDriver)
    {
        //
    }

    public function edit(PanjarDriver $panjarDriver, $id)
    {
        $data = PanjarDriver::findOrFail($id);

        $driver_id = $data->id_driver;

        $drivers = Drivers::whereNotIn('id', [$driver_id])->get();

        return view('pimpinan.driver.edit_panjar_driver', ['ListPanjar' => $data, 'ListDriver' => $drivers]);
    }

    public function update(Request $request, $id)
    {
        $get_data = PanjarDriver::findOrFail($id);
        $get_data->update($request->all());
        if ($get_data) {
            Session::flash('success');
        }
        return redirect('pimpinan/panjar-driver')->with('status', 'Data berhasil di update!');
    }

    public function repaymend(Request $request)
    {
        $id = request('id');
        $get_data = PanjarDriver::findOrFail($id);

        $get_data->update([
            'status' => 2,  //status 2 berarti telah di lunasi
        ]);

        if ($get_data) {
            return response()->json(['sukses' => 'Data Berhasil di simpan']);
        } else {
            return response()->json(['Gagal' => 'Terjadi Kesalahan'], 404);
        }
    }

    public function financial_down_payment_save(Request $request) //ini yang pertamana, yeah!
    {
        $id = request('id');
        $get_data = PanjarDriver::findOrFail($id);

        $kode          = $get_data->kode_panjar;
        $date          = $get_data->date;
        $driver_name   = $get_data->driver->fullname;
        $debet         = $get_data->down_payment;

        $total_saldo = LaporanKeuangan::latest()->first();

        if ($total_saldo != null) {
            $total_debet = $total_saldo->total_dana - $debet;
        } else {
            $total_debet = $debet;
        }

        try {
            DB::beginTransaction();
            LaporanKeuangan::create([
                'date'           =>  $date,
                'kode_transaksi' =>  $kode,
                'keterangan'     =>  "Panjar $driver_name Tanggal $date",
                'debet'          =>  $debet,
                'total_dana'     =>  $total_debet,
            ]);
            $get_data->update([
                'status' => 1, //status 1 berarti telah di input ke laopran keuangan
            ]);
            DB::commit();
            return response()->json(['sukses' => 'Data Berhasil di simpan']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['Gagal' => 'Terjadi Kesalahan'], 404);
        }

        // return redirect('pimpinan/perawatan-armada')->with('status', 'Data berhasil di update!');
    }

    public function financial_save(Request $request) // ini yang terahkir.. tolong lah
    {
        $id = request('id');
        $get_data = PanjarDriver::findOrFail($id);

        $date          = $get_data->date;
        $driver_name   = $get_data->driver->fullname;
        $driver_id     = $get_data->id_driver;
        $credit        = $get_data->down_payment;

        $total_saldo = LaporanKeuangan::latest()->first();

        if ($total_saldo != null) {
            $total_credit = $total_saldo->total_dana + $credit;
        } else {
            $total_credit = $credit;
        }

        $latestData = PanjarDriver::latest('kode_panjar')->first();
        if ($latestData) {
            $parts = explode('-', $latestData->kode_panjar);
            $code = $parts[0];
            $num = intval($parts[1]);
            if ($num == 999) {
                $num = 1;
            } else {
                $num++;
            }
            $new_kode_panjar = $code . '-' . str_pad($num, 3, '0', STR_PAD_LEFT);
        } else {
            $new_kode_panjar = "KPD-001";
        }

        try {
            DB::beginTransaction();
            LaporanKeuangan::create([
                'date'           =>  $date,
                'kode_transaksi' =>  $new_kode_panjar,
                'keterangan'     =>  "Pelunasan Panjar $driver_name Tanggal $date",
                'credit'         =>  $credit,
                'total_dana'     =>  $total_credit,
            ]);

            PanjarDriver::create([
                'kode_panjar'  => $new_kode_panjar,
                'date'         =>  $date,
                'id_driver'    => $driver_id,
                'down_payment' => $credit,
                'keterangan'   => "Pelunasan Panjar",
                'status'       => 3,
            ]);

            $get_data->update([
                'status' => 3, //status 2 berarti telah di input ke laopran keuangan
            ]);
            DB::commit();
            return response()->json(['sukses' => 'Data Berhasil di simpan']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['Gagal' => 'Terjadi Kesalahan'], 404);
        }
        return response()->json(['Gagal' => 'Terjadi Kesalahan'], 404);


        // return redirect('pimpinan/perawatan-armada')->with('status', 'Data berhasil di update!');
    }




    public function destroy(PanjarDriver $panjarDriver, $id)
    {
        $id = PanjarDriver::findOrFail($id);
        $id->delete();

        if ($id) {
            return response()->json(['sukses' => 'Data Berhasil di simpan']);
        } else {
            return response()->json(['Gagal' => 'Terjadi Kesalahan'], 404);
        }
    }
}
