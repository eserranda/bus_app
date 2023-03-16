<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Rute;
use App\Models\GajiDriver;
use Illuminate\Http\Request;
use App\Models\LaporanKeuangan;
use App\Models\PanjarDriver;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Session;

class GajiDriverController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $status = $request->input('filter');

            $start_date = $request->input('start_date');
            $end_date = $request->input('end_date');

            $query = GajiDriver::select('id', 'date', 'kode_gaji', 'to_city', 'from_city', 'id_driver', 'driver_type', 'salary', 'down_payment', 'status')
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
                    $data->salary = 'Rp' . number_format($data->salary, 0, ',', '.');
                    if ($data->status == 0) {
                        $status = '<span class="badge text-bg-danger">Belum Lunas</span>';
                    } elseif ($data->status == 1) {
                        $status = '<span class="badge text-bg-success">Lunas</span>';
                    } else {
                        $status = '<span class="badge text-bg-warning">Arsip</span>';
                    }
                    $nilai_status =  $data->status;
                    return [
                        'id'        => $data->id,
                        'kode_gaji' => $data->kode_gaji,
                        'date'      => $data->date,
                        'id_driver' => $data->driver->fullname . " / " .  $data->driver->driver_type,
                        'rute'      => $data->from_city . " - " . $data->to_city,
                        'salary'    => $data->salary,
                        'status'    => $data->status,
                        'nilai_status'     => $nilai_status
                    ];
                });

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('opsi', function ($row) {
                    if ($row['nilai_status'] == 0) {
                        $actionBtn = '<a class="btn btn-info btn-sm" onclick="ambil_gaji(\'' . $row['id'] . '\', $(this).closest(\'tr\').find(\'td:eq(3)\').text(),$(this).closest(\'tr\').find(\'td:eq(5)\').text())">Ambil Gaji</a>';

                        $actionBtn .= '<a class="btn btn-light text-danger btn-sm" onclick="deleteData(\'' . $row['id'] . '\', $(this).closest(\'tr\').find(\'td:eq(3)\').text())"> <i class="fa-regular fa-trash-can"></i></a>';
                        return $actionBtn;
                    } elseif ($row['nilai_status'] == 1) {
                        $actionBtn = '<a class="btn btn-light text-primary btn-sm financial-save"  onclick="financial_save(\'' . $row['id'] . '\')"><i  class="fa-solid fa-file-medical"></i></a>';
                        return $actionBtn;
                    } else {
                        $actionBtn = '<span class="badge text-bg-warning">Arsip</span>';
                        return $actionBtn;
                    }
                })
                ->rawColumns(['opsi'])
                ->make(true);


            // if (isset($start_date) && isset($end_date)) {
            //     $data = GajiDriver::select('id', 'kode_gaji', 'date', 'to_city', 'from_city', 'id_driver', 'driver_type', 'salary', 'down_payment', 'status')
            //         ->whereBetween('date', [$start_date, $end_date])
            //         ->orderBy('date', 'asc')
            //         ->get()
            //         ->map(function ($data) {
            //             $data->date = Carbon::createFromFormat('Y-m-d', $data->date)->format('d-m-Y');
            //             $data->salary = 'Rp' . number_format($data->salary, 0, ',', '.');
            //             return [
            //                 'id'        => $data->id,
            //                 'date'      => $data->date,
            //                 'kode_gaji' => $data->kode_gaji,
            //                 'id_driver' => $data->driver->fullname . " / " .  $data->driver->driver_type,
            //                 'rute'      => $data->from_city . " - " . $data->to_city,
            //                 'salary'    => $data->salary,
            //                 'status'    => $data->status,
            //             ];
            //         });

            //     return Datatables::of($data)
            //         ->addIndexColumn()
            //         ->addColumn('opsi', function ($row) {
            //             if ($row['status'] == null) {
            //                 $actionBtn = '<a class="btn btn-info btn-sm" onclick="ambil_gaji(\'' . $row['id'] . '\', $(this).closest(\'tr\').find(\'td:eq(2)\').text(),$(this).closest(\'tr\').find(\'td:eq(4)\').text())">Ambil Gaji</a>';

            //                 $actionBtn .= '<a class="btn btn-light text-danger btn-sm" onclick="deleteData(\'' . $row['id'] . '\', $(this).closest(\'tr\').find(\'td:eq(2)\').text())"> <i class="fa-regular fa-trash-can"></i></a>';
            //                 return $actionBtn;
            //             } elseif ($row['status'] == 1) {
            //                 $actionBtn = '<a class="btn btn-light text-primary btn-sm financial-save"  onclick="financial_save(\'' . $row['id'] . '\')"><i  class="fa-solid fa-file-medical"></i></a>';
            //                 return $actionBtn;
            //             }
            //         })
            //         ->rawColumns(['opsi'])
            //         ->make(true);
            // } else {
            //     $today = Carbon::now();
            //     $data = GajiDriver::whereMonth('date', $today->month)
            //         ->whereYear('date', $today->year)
            //         ->orderBy('date', 'asc')
            //         ->get()
            //         ->map(function ($data) {
            //             $data->date = Carbon::createFromFormat('Y-m-d', $data->date)->format('d-m-Y');
            //             $data->salary = 'Rp' . number_format($data->salary, 0, ',', '.');
            //             return [
            //                 'id'        => $data->id,
            //                 'kode_gaji' => $data->kode_gaji,
            //                 'date'      => $data->date,
            //                 'id_driver' => $data->driver->fullname . " / " .  $data->driver->driver_type,
            //                 'rute'      => $data->from_city . " - " . $data->to_city,
            //                 'salary'    => $data->salary,
            //                 'status'    => $data->status,
            //             ];
            //         });
            //     return Datatables::of($data)
            //         ->addIndexColumn()
            //         ->addColumn('opsi', function ($row) {
            //             if ($row['status'] == null) {
            //                 $actionBtn = '<a class="btn btn-info btn-sm" onclick="ambil_gaji(\'' . $row['id'] . '\', $(this).closest(\'tr\').find(\'td:eq(3)\').text(),$(this).closest(\'tr\').find(\'td:eq(5)\').text())">Ambil Gaji</a>';

            //                 $actionBtn .= '<a class="btn btn-light text-danger btn-sm" onclick="deleteData(\'' . $row['id'] . '\', $(this).closest(\'tr\').find(\'td:eq(3)\').text())"> <i class="fa-regular fa-trash-can"></i></a>';
            //                 return $actionBtn;
            //             } elseif ($row['status'] == 1) {
            //                 $actionBtn = '<a class="btn btn-light text-primary btn-sm financial-save"  onclick="financial_save(\'' . $row['id'] . '\')"><i  class="fa-solid fa-file-medical"></i></a>';
            //                 return $actionBtn;
            //             }
            //         })
            //         ->rawColumns(['opsi'])
            //         ->make(true);
            // }
        }
        return view('pimpinan.driver.gaji_driver');
    }
    // $gajiDriver = GajiDriver::with('driver')
    //     ->get()
    //     ->map(function ($gajiDriver) {
    //         $gajiDriver->date = Carbon::createFromFormat('Y-m-d', $gajiDriver->date)->format('d-m-Y');
    //         $gajiDriver->salary = 'Rp' . number_format($gajiDriver->salary, 0, ',', '.');
    //         return $gajiDriver;
    //     });
    // return view('pimpinan.driver.gaji_driver', ['gajiDriver' => $gajiDriver]);



    public function ambilgaji($id)
    {
        $data = GajiDriver::findOrFail($id);

        $panjar = 0;
        $down_payments = PanjarDriver::where('id_driver', $data->id_driver)
            ->where(function ($query) {
                $query->where('status', 1)
                    ->orWhere('status', 0);
            })->get();


        if ($down_payments->count() > 0) {
            $panjar = $down_payments->sum('down_payment');
        }

        $status = PanjarDriver::where('id_driver', $data->id_driver)
            ->latest('id')
            ->value('status');

        if ($panjar != null) {
            $data_down_payment = "Rp" . number_format($panjar, 0, ',', '.');
            return response()->json(['data' => $data_down_payment, 'down_payment' => $panjar, 'statusdata' => $status]);
        } else {
            return response()->json(['nodata' => 'panjar tidak di temukan']);
        }
    }


    public function update($id)
    {
        $get_data = GajiDriver::findOrFail($id);

        $id_driver   = $get_data->id_driver;

        $tidak = request('no');

        if ($tidak == true) {
            $get_data->update([
                'status' => 1,
            ]);
        } elseif (!$tidak == true) {
            $panjar = PanjarDriver::where('id_driver', $id_driver)->get();

            $total_down_payment = $panjar->sum('down_payment');

            $panjar->each(function ($item) {
                $item->update([
                    'status' => 2,
                ]);
            });

            $get_data->update([
                'status' => 1,
                'down_payment' => $total_down_payment,
            ]);
        }


        if ($get_data) {
            return response()->json(['success' => 'Update sukses']);
        } else {
            return response()->json(['errors' => 'Gagal update']);
        }
    }

    public function financial_save(Request $request)
    {
        $id = request('id');
        $get_data = GajiDriver::findOrFail($id);

        $kode        = $get_data->kode_gaji;
        $date        = $get_data->date;
        $driver_name = $get_data->driver->fullname;
        $debet       = $get_data->salary;

        $total_saldo = LaporanKeuangan::latest('created_at')->first();

        $total_debet = $total_saldo->total_dana - $debet;

        $insert_data = LaporanKeuangan::create([
            'date'           =>  $date,
            'kode_transaksi' =>  $kode,
            'keterangan'     =>  "Pengambilan Gaji $driver_name Tanggal $date",
            'debet'         =>  $debet,
            'total_dana'     =>  $total_debet,
        ]);

        $get_data->update([
            'status' => 2,  //status 2 berarti telah di input ke laopran keuangan
        ]);


        if ($insert_data && $get_data) {
            return response()->json(['sukses' => 'Data Berhasil di simpan']);
        } else {
            return response()->json(['Gagal' => 'Terjadi Kesalahan'], 404);
        }

        // return redirect('pimpinan/perawatan-armada')->with('status', 'Data berhasil di update!');
    }

    public function destroy($id)
    {
        $delete = GajiDriver::findOrFail($id);
        $delete->delete();

        if ($delete) {
            return response()->json(['sukses' => 'Data Berhasil di simpan']);
        } else {
            return response()->json(['Gagal' => 'Terjadi Kesalahan'], 404);
        }
    }
}
