<?php

namespace App\Http\Controllers;

use App\Models\JadwalTiket;
use Carbon\Carbon;
use App\Models\Tiket;
use Illuminate\Http\Request;
use App\Models\Keberangkatan;
use App\Models\LaporanKeuangan;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class KeberangkatanController extends Controller
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

            $query = Keberangkatan::select('*')
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
                $query->where('departure_date', $today)
                    ->orderBy('status', 'ASC');
            }
            $data = $query->get()
                ->map(function ($data) {
                    $data->departure_date = Carbon::createFromFormat('Y-m-d', $data->departure_date)->format('d-m-Y');
                    $data->total_price = 'Rp' . number_format($data->total_price, 0, ',', '.');

                    $status = '';
                    switch ($data->status) {
                        case 1:
                            $status = '<span class="badge text-bg-Info">Berangkat</span>';
                            break;
                        case 2:
                            $status = '<span class="badge text-bg-success"> Tiba di ' . $data->to_city . ' </span>';
                            break;
                        case 3:
                            $status = '<span class="badge text-bg-warning">Arsip</span>';
                            break;
                        default:
                            $status = ' - ';
                            break;
                    }
                    $nilai_status =  $data->status;
                    return [
                        'id'              => $data->id,
                        'departure_date'  => $data->departure_date . " / " . $data->departure_time,
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
                    if ($row['nilai_status'] == 0) {
                        $actionBtn = ' <a class="btn btn-info" href="/admin/keberangkatan-setberangkat/' . $row['id'] . '">Berangkat</a>';
                        $actionBtn .= '<a class="btn btn-secondary mx-1"
                        onclick="printManifest(\'' . $row['id'] . '\')">  <i class="fa-solid fa-print"></i> Manifest  </a>';
                        return $actionBtn;
                    } elseif ($row['nilai_status'] == 1) {
                        $actionBtn = '<a class="btn btn-primary btn-icon" href="/admin/keberangkatan-rollback/' . $row['id'] . '"> <i class="fa-solid fa-arrow-rotate-left"></i></a>';
                        $actionBtn .= '<a class="btn btn-secondary "
                        onclick="printManifest(\'' . $row['id'] . '\')">  <i class="fa-solid fa-print"></i> Manifest  </a>';
                        return $actionBtn;
                    } else {
                        $actionBtn = '<a class="btn btn-secondary"
                        onclick="printManifest(\'' . $row['id'] . '\')">  <i class="fa-solid fa-print"></i> Manifest  </a>';
                        return $actionBtn;
                    }
                })
                ->rawColumns(['opsi', 'status'])
                ->make(true);
        }
        return view('admin.data_keberangkatan');
    }

    public function SetBerangkat(Request $request, $id)
    {
        $set_berangkat = Keberangkatan::findOrFail($id);
        $departure_code = $set_berangkat->departure_code;

        $data_jadwal = JadwalTiket::where('departure_code', $departure_code);

        $data_jadwal->update([
            'status' => 1,
        ]);

        $set_berangkat->update([
            'status' => 1,
        ]);

        if ($set_berangkat) {
            Session::flash('status', 'success');
            Session::flash('message', 'Data berhasil Diupdate!');
        }
        return redirect('/admin/keberangkatan');
    }

    public function Rollback(Request $request, $id)
    {
        $rollback = Keberangkatan::findOrFail($id);

        $departure_code = $rollback->departure_code;

        $data_jadwal = JadwalTiket::where('departure_code', $departure_code);

        $data_jadwal->update([
            'status' => 0,
        ]);

        $rollback->update([
            'status' => 0,
        ]);

        if ($rollback) {
            Session::flash('status', 'success');
            Session::flash('message', 'Bus Batal Berangkat!');
        }
        return redirect('/admin/keberangkatan');
    }

    public function manifest($id)
    {
        $data = Keberangkatan::findOrFail($id);

        $departure_code = $data->departure_code;
        $total_passenger = $data->total_passenger;
        $departure_time = $data->departure_time;

        $tiket = Tiket::where('departure_code', $departure_code)
            ->get();

        $firstTiket = $tiket->first();

        $date = Carbon::createFromFormat('Y-m-d', $firstTiket->date);
        $dayName = $date->locale('id')->translatedFormat('l');

        $data = [
            'from_city'         => $firstTiket->from_city,
            'to_city'           => $firstTiket->to_city,
            'bus'               => $firstTiket->bus_name->type,
            'plat'              => $firstTiket->bus_name->plat,
            'date'              => $date->format('d-m-Y'),
            'day_name'          => $dayName,
            'total_passenger'   => $total_passenger,
            'time'              => $departure_time
        ];
        return response()->json(['data' => $tiket, 'rute' => $data]);
    }

    public function data_transaksi_tiket()
    {
        return view('pimpinan.laporan.transaksi_tiket');
    }

    public function trasaksi_tiket()
    {
        $dates = Keberangkatan::whereNotNull('departure_code')->get();
        if (count($dates) > 0) {
            $response = array();
            foreach ($dates as $mydata) {
                $response[] = [
                    'id'              => $mydata->id,
                    'departure_code'  => $mydata->departure_code,
                    'date'            => $mydata->departure_date,
                    'from_city'       => $mydata->from_city,
                    'to_city'         => $mydata->to_city,
                    'total_ticket'    => $mydata->total_passenger,
                    'total_price'     => $mydata->total_price,
                    'status'          => $mydata->status,
                ];
            }
            return response()->json($response);
        } else {
            return response()->json(404);
        }
    }

    public function financial_tiket_save()
    {
        $id = request('id');
        $get_data = Keberangkatan::findOrFail($id);

        $kode         = $get_data->departure_code;
        $InputDate    = $get_data->departure_date;
        $fromCity     = $get_data->from_city;
        $toCity       = $get_data->to_city;
        $total_price  = $get_data->total_price;

        $data_jadwal = JadwalTiket::where('departure_code', $kode);

        $dateformat = Carbon::createFromFormat('Y-m-d', $get_data->departure_date)->format('d-m-Y');
        $total_saldo = LaporanKeuangan::latest()->first();

        if ($total_saldo != null) {
            $credit = $total_saldo->total_dana + $total_price;
        } else {
            $credit = $total_price;
        }

        try {
            DB::beginTransaction();
            LaporanKeuangan::create([
                'date'           =>  $InputDate,
                'kode_transaksi' =>  $kode,
                'keterangan'     =>  "Rute $fromCity - $toCity, Tanggal $dateformat",
                'credit'         =>  $total_price,
                'total_dana'     =>  $credit
            ]);
            $get_data->update([
                'status' => 3,
            ]);

            $data_jadwal->update([
                'status' => 3,
            ]);

            DB::commit();
            return response()->json(['sukses' => 'Data Berhasil di simpan']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'Terjadi Kesalahan: ' . $e->getMessage()], 500);
        }
    }
}
