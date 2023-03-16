<?php

namespace App\Http\Controllers;

use App\Models\GajiDriver;
use Carbon\Carbon;
use App\Models\Tiket;
use Illuminate\Http\Request;
use App\Models\Keberangkatan;
use App\Models\LaporanKeuangan;
use App\Models\PersenanGaji;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\DataTables;


class KedatanganController extends Controller
{
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $status = $request->input('filter');

            $start_date = $request->input('start_date');
            $end_date = $request->input('end_date');

            // tanggal awal minggu ini
            $startOfWeek = Carbon::now()->startOfWeek();
            // tanggal akhir minggu ini
            $endOfWeek = Carbon::now()->endOfWeek();
            // hari ini
            $today = Carbon::now()->toDateString();

            $query = Keberangkatan::select('id', 'departure_code', 'from_city', 'to_city', 'id_bus', 'departure_date', 'departure_time', 'sopir_utama', 'sopir_bantu', 'kondektur', 'total_passenger', 'total_price', 'status')
                ->orderBy('departure_date', 'asc');

            if (isset($status)) {
                if ($status === 'all_data') {
                } elseif ($status == 1) {
                    $query->whereBetween('departure_date', [$startOfWeek, $endOfWeek]);
                } else if ($status == null) {
                    $query->whereMonth('departure_date', Carbon::now()->month);
                }
            } elseif (isset($start_date) && isset($end_date)) {
                $query->whereBetween('departure_date', [$start_date, $end_date]);
            } else {
                $query->where('departure_date', $today);
            }
            $data = $query->get()
                ->map(function ($data) {
                    $data->departure_date = Carbon::createFromFormat('Y-m-d', $data->departure_date)->format('d-m-Y');
                    $data->total_price = 'Rp' . number_format($data->total_price, 0, ',', '.');
                    $status = '';
                    switch ($data->status) {
                        case 1:
                            $status = '<span class="badge text-bg-info">Dalam Perjalanan</span>';
                            break;
                        case 2:
                            $status = '<span class="badge text-bg-success">Telah Tiba</span>';
                            break;
                        case 3:
                            $status = '<span class="badge text-bg-warning">Arsip</span>';
                            break;
                        default:
                            $status = '<span class="badge text-bg-warning">Nothing</span>';
                            break;
                    }

                    $nilai_status =  $data->status;
                    return [
                        'id'              => $data->id,
                        'departure_date'  => $data->departure_date,
                        'rute'            => $data->from_city . " - " . $data->to_city,
                        'bus'             => $data->bus->type . " | " . $data->bus->plat,
                        'id_driver'       => $data->sopirUtama->fullname . " / " .  $data->sopirBantu->fullname,
                        'kondektur'       => $data->Kondektur->fullname,
                        'total_passenger' => $data->total_passenger,
                        'status'          => $status,
                        'nilai_status'    => $nilai_status
                    ];
                });

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('opsi', function ($row) {
                    if ($row['nilai_status'] == 1) {
                        $actionBtn = ' <a class="btn border-0 btn-sm btn-info" href="/admin/kedatangan-tiba/ ' . $row['id'] . '">Tiba</a>';
                        return $actionBtn;
                    } elseif ($row['nilai_status'] == 2) {
                        $actionBtn = '<a class="btn btn-light text-primary btn-sm financial-save"  onclick="financial_save(\'' . $row['id'] . '\')"><i  class="fa-solid fa-file-medical"></i></a>';
                        return $actionBtn;
                    } elseif ($row['nilai_status'] == null) {
                        $actionBtn =  '';
                        return $actionBtn;
                    }
                })
                ->rawColumns(['opsi', 'status'])
                ->make(true);
        }
        return view('admin.data_kedatangan');
        // $kedatangan = Keberangkatan::whereDate('departure_date', Carbon::today())
        //     ->orderBy('departure_date', 'asc')
        //     ->get()
        //     ->map(function ($jadwal) {
        //         $jadwal->departure_date = Carbon::createFromFormat('Y-m-d', $jadwal->departure_date)->format('d-m-Y');
        //         $jadwal->price = 'Rp ' . number_format($jadwal->price, 0, ',', '.');
        //         return $jadwal;
        //     });

        // $departure_date = Carbon::now()->format('d-m-Y');
        // return view('admin.data_kedatangan', ['listKedatangan' => $kedatangan, 'departure_date' => $departure_date]);
    }

    public function SetTiba(Request $request, $id)
    {
        $keberangkatan = Keberangkatan::findOrFail($id);
        $keberangkatan->update([
            'status' => 2,
        ]);

        $id_bus     = $keberangkatan->id_bus;
        // $kode       = $keberangkatan->departure_code;
        $InputDate  = $keberangkatan->departure_date;
        $sopirUtama = $keberangkatan->sopir_utama;
        $sopirBantu = $keberangkatan->sopir_bantu;
        $fromCity   = $keberangkatan->from_city;
        $toCity     = $keberangkatan->to_city;

        $total_tiket = Tiket::where('date', $InputDate)
            ->where('from_city', $fromCity)
            ->where('to_city', $toCity)
            ->where('bus', $id_bus)
            ->sum('price');

        // $total_saldo = LaporanKeuangan::latest('created_at')->first();

        // $credit = $total_saldo->total_dana + $total_tiket;

        // LaporanKeuangan::create([
        //     'date'           =>  $InputDate,
        //     'kode_transaksi' =>  $kode,
        //     'keterangan'     =>  "Rute $fromCity - $toCity",
        //     'credit'         =>  $total_tiket,
        //     'total_dana'     =>  $credit
        // ]);

        $persenan = PersenanGaji::select('sopir_utama', 'sopir_bantu')
            ->where('from_city', $fromCity)
            ->where('to_city', $toCity)
            ->first();

        $persenanSopirUtama = $persenan->sopir_utama;
        $persenanSopirBantu = $persenan->sopir_bantu;

        $GajisopirUtama      = $persenanSopirUtama / 100;
        $totalGajiSopirUtama = $total_tiket * $GajisopirUtama;

        $GajisopirBantu      = $persenanSopirBantu / 100;
        $totalGajiSopirBantu = $total_tiket * $GajisopirBantu;

        if ($sopirUtama) {
            $gajiDriver = GajiDriver::where('id_driver', $sopirUtama)
                ->where('date', $InputDate)
                ->where('to_city', $toCity)
                ->where('from_city', $fromCity)
                ->first();

            if (!$gajiDriver) {

                $latestData = GajiDriver::latest('kode_gaji')->first();

                if ($latestData) {
                    $parts = explode('-', $latestData->kode_gaji);
                    $code = $parts[0];
                    $num = intval($parts[1]);
                    if ($num == 999) {
                        $num = 1;
                    } else {
                        $num++;
                    }
                    $kode_sopir_utama = $code . '-' . str_pad($num, 3, '0', STR_PAD_LEFT);
                } else {
                    $kode_sopir_utama = "PGDU-001";
                }

                GajiDriver::create([
                    'id_driver'   =>  $sopirUtama,
                    'kode_gaji'   =>  $kode_sopir_utama,
                    'to_city'     =>  $toCity,
                    'from_city'   =>  $fromCity,
                    'date'        =>  $InputDate,
                    'salary'      =>  $totalGajiSopirUtama,
                    'driver_type' =>  $sopirUtama,
                ]);
            }
        }

        if ($sopirBantu) {
            $gajiDriver = GajiDriver::where('id_driver', $sopirBantu)
                ->where('date', $InputDate)
                ->where('to_city', $toCity)
                ->where('from_city', $fromCity)
                ->first();

            if (!$gajiDriver) {

                $latestData = GajiDriver::latest('kode_gaji')->first();

                if ($latestData) {
                    $parts = explode('-', $latestData->kode_gaji);
                    $code = $parts[0];
                    $num = intval($parts[1]);
                    if ($num == 999) {
                        $num = 1;
                    } else {
                        $num++;
                    }
                    $kode_supir_bantu = $code . '-' . str_pad($num, 3, '0', STR_PAD_LEFT);
                }
                // else {
                //     $kode_supir_bantu = "PGDB-001";
                // }

                GajiDriver::create([
                    'id_driver'   =>  $sopirBantu,
                    'kode_gaji'   =>  $kode_supir_bantu,
                    'to_city'     =>  $toCity,
                    'from_city'   =>  $fromCity,
                    'date'        =>  $InputDate,
                    'salary'      =>  $totalGajiSopirBantu,
                    'driver_type' =>  $sopirBantu,
                ]);
            }
        }

        return redirect('/admin/kedatangan');
    }
}
