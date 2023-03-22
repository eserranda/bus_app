<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Bus;
use App\Models\Rute;
use App\Models\Drivers;
use App\Models\JadwalTiket;
use Illuminate\Http\Request;
use App\Models\Keberangkatan;
use App\Models\Tiket;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class JadwalTiketController extends Controller

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

            $query = JadwalTiket::select('*')
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
                    $data->price = 'Rp' . number_format($data->price, 0, ',', '.');
                    // if ($data->status == 1) {
                    //     $status = '<span class="badge text-bg-warning">Berangkat</span>';
                    // } elseif ($data->status == 2) {
                    //     $status = '<span class="badge text-bg-success"> Tiba di ' . $data->to_city . ' </span>';
                    // } elseif ($data->status == null) {
                    //     $status =  '';
                    // }
                    $nilai_status =  $data->status;

                    if ($data->sopir_utama == null) {
                        $sopir_utama = '-';
                    } else {
                        $sopir_utama =  $data->driver->fullname;
                    };
                    if ($data->sopir_bantu == null) {
                        $sopir_bantu = '-';
                    } else {
                        $sopir_bantu =  $data->sopirBantu->fullname;
                    };
                    if ($data->kondektur == null) {
                        $kondektur = '-';
                    } else {
                        $kondektur =  $data->Kondektur->fullname;
                    };
                    return [
                        'id'              => $data->id,
                        'departure_code'  => $data->departure_code,
                        'departure_date'  => $data->departure_date,
                        'bus'             => $data->bus->type . " | " . $data->bus->plat,
                        'rute'            => $data->from_city . " - " . $data->to_city,
                        'sopir_utama'     => $sopir_utama,
                        'sopir_bantu'     => $sopir_bantu,
                        'kondektur'       => $kondektur,
                        'price'           => $data->price,
                        'nilai_status'    => $nilai_status
                    ];
                });

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('opsi', function ($row) {
                    // $actionBtn =  '<a class="btn btn-info btn-icon  btn-sm" href="/admin/jadwal-tiket-edit/' . $row['id'] . '">
                    // <i class="fa-solid fa-pen-to-square"></i></a>';
                    // $actionBtn .= '<a class="btn btn-danger btn-icon btn-sm" onclick="deleteData(\'' . $row['id'] . '\', $(this).closest(\'tr\').find(\'td:eq(1)\').text())"> <i class="fa-regular fa-trash-can"></i></a>';
                    // // $actionBtn .= '<a class="btn btn-danger btn-icon btn-sm" href="/admin/jadwal-tiket-delete/' . $row['id'] . '"> <i class="fa-solid fa-trash-can"></i></a>';
                    // return $actionBtn;
                    if ($row['nilai_status'] == 0) {
                        $actionBtn =  '<a class="btn btn-info btn-icon  btn-sm" href="/admin/jadwal-tiket-edit/' . $row['id'] . '">
                    <i class="fa-solid fa-pen-to-square"></i></a>';
                        $actionBtn .= '<a class="btn btn-danger btn-icon btn-sm mx-1" onclick="deleteData(\'' . $row['id'] . '\', $(this).closest(\'tr\').find(\'td:eq(1)\').text())"> <i class="fa-regular fa-trash-can"></i></a>';
                        return $actionBtn;
                    } elseif ($row['nilai_status'] == 1) {
                        $actionBtn = '<span class="badge text-bg-secondary">Bus Berangkat</span>';
                        return $actionBtn;
                    } elseif ($row['nilai_status'] == 2) {
                        $actionBtn = '<span class="badge text-bg-info">Telah tiba</span>';
                        return $actionBtn;
                    } elseif ($row['nilai_status'] == 3) {
                        $actionBtn = '<span class="badge text-bg-warning">Arsip</span>';
                        return $actionBtn;
                    }
                })
                ->rawColumns(['opsi'])
                ->make(true);
        }
        return view('admin.jadwal_tiket');
    }
    // $today = Carbon::today();
    // $jadwal = JadwalTiket::whereDate('departure_date', '>=', $today)
    //     ->orderBy('departure_date', 'asc')
    //     ->get()
    //     ->map(function ($jadwal) {
    //         $jadwal->departure_date = Carbon::createFromFormat('Y-m-d', $jadwal->departure_date)->format('d-m-Y');
    //         $jadwal->price = 'Rp ' . number_format($jadwal->price, 0, ',', '.');
    //         return $jadwal;
    //     });




    public function add()
    {
        $bus  = Bus::all();
        $city = Rute::all();

        $utama     = "Utama";
        $bantu     = "Bantu";
        $kondektur = "Kondektur";

        $driver_utama = Drivers::select('fullname', 'id')
            ->where('driver_type', $utama)
            ->get();

        $driver_bantu = Drivers::select('fullname', 'id')
            ->where('driver_type', $bantu)
            ->get();

        $kondektur = Drivers::select('fullname', 'id')
            ->where('driver_type', $kondektur)
            ->get();

        return view('admin.add_jadwal_tiket', ['busList' => $bus, 'ruteList' => $city, 'driverUtama' => $driver_utama,  'driverBantu' => $driver_bantu,  'kondektur' => $kondektur]);
    }

    public function toCity(Request $request)
    {
        $from_city = $request->input('from_city');
        $rute = Rute::where('city', '!=', $from_city)->get();

        return response()->json($rute);
    }

    public function store(Request $request)
    {
        $latestData = JadwalTiket::latest('departure_code')->first();
        if ($latestData) {
            $parts = explode('-', $latestData->departure_code); // memisahkan string menjadi 2 bagian
            $code = $parts[0]; // kode awal atau ambil angka awalan sebelum -
            $num = intval($parts[1]); // nomor urut
            if ($num == 999) {
                $num = 1; // jika nomor urut sudah mencapai batas maka kembali ke 1
            } else {
                $num++; // jika belum mencapai batas maka increment seperti biasa
            }
            $departure_code = $code . '-' . str_pad($num, 3, '0', STR_PAD_LEFT); // menggabungkan kembali string
        } else {
            $departure_code = "DPC-001";
        }

        $store = JadwalTiket::create([
            'departure_code' => $departure_code,
            'departure_date' => request('departure_date'),
            'departure_time' => request('departure_time'),
            'id_bus'         => request('id_bus'),
            'from_city'      => request('from_city'),
            'to_city'        => request('to_city'),
            'sopir_utama'    => request('sopir_utama'),
            'sopir_bantu'    => request('sopir_bantu'),
            'kondektur'      => request('kondektur'),
            'price'          => request('price'),
        ]);

        Keberangkatan::create([
            'departure_code' => $departure_code,
            'departure_date' => request('departure_date'),
            'departure_time' => request('departure_time'),
            'id_bus'         => request('id_bus'),
            'from_city'      => request('from_city'),
            'to_city'        => request('to_city'),
            'sopir_utama'    => request('sopir_utama'),
            'sopir_bantu'    => request('sopir_bantu'),
            'kondektur'      => request('kondektur'),
        ]);

        if ($store) {
            Session::flash('status', 'success');
            Session::flash('message', 'Data berhasil Ditambah!');
        }
        return redirect('admin/jadwal-tiket');
    }

    public function edit(Request $request, $id)
    {
        $edit = JadwalTiket::findOrFail($id);

        $data_id            = $edit->id_bus;
        $dataFrom_city      = $edit->from_city;
        $data_sopir_utama   = $edit->sopir_utama; //data berupa id
        $data_sopir_bantu   = $edit->sopir_bantu;
        $data_kondektur     = $edit->kondektur;

        $utama      = "Utama";
        $bantu      = "Bantu";
        $kondekturs = "Kondektur";

        $bus  = Bus::where('id', '!=', $data_id)->get();
        $city = Rute::where('city', '!=', $dataFrom_city)->get();

        $driver_utama = Drivers::select('id', 'fullname')
            ->where('driver_type', $utama)
            ->where('id', '!=', $data_sopir_utama)
            ->get();

        $driver_bantu = Drivers::select('id', 'fullname')
            ->where('driver_type', $bantu)
            ->where('id', '!=', $data_sopir_bantu)
            ->get();

        $kondektur = Drivers::select('id', 'fullname')
            ->where('driver_type', $kondekturs)
            ->where('id', '!=', $data_kondektur)
            ->get();

        // $driver_utama = Drivers::select('fullname', 'id')
        //     ->whereNotIn('driver_type', $utama)
        //     ->get();

        // $driver_bantu = Drivers::select('fullname', 'id')
        //     ->whereNotIn('driver_type', $bantu)
        //     ->get();

        // $kondektur = Drivers::select('fullname', 'id')
        //     ->whereNotIn('driver_type', $kondektur)
        //     ->get();


        return view('admin.edit_jadwal_tiket', [
            'dataJadwal'  => $edit,
            'busList'     => $bus,
            'ruteList'    => $city,
            'driverUtama' => $driver_utama,
            'driverBantu' => $driver_bantu,
            'kondektur'   => $kondektur
        ]);
    }

    public function update(Request $request, $id)
    {
        $price =  request('price');

        $data_price = str_replace('.', '', $price);

        $update_jadwal_tiket = JadwalTiket::find($id);

        $departure_code = $update_jadwal_tiket->departure_code;

        $update_data_tiket    = Tiket::where('departure_code', $departure_code);
        $update_keberangkatan = Keberangkatan::where('departure_code', $departure_code);
        // $update_old_dcode     = Keberangkatan::where('departure_code', request('old_departure_code'));

        try {
            DB::beginTransaction();

            $update_data_tiket->update([
                'date'           =>  request('departure_date'),
                'departure_time' =>  request('departure_time'),
                'bus'            =>  request('id_bus'),
                'from_city'      =>  request('from_city'),
                'to_city'        =>  request('to_city'),
            ]);

            $update_keberangkatan->update([
                'departure_date' =>  request('departure_date'),
                'departure_time' =>  request('departure_time'),
                'id_bus'         =>  request('id_bus'),
                'from_city'      =>  request('from_city'),
                'to_city'        =>  request('to_city'),
                'sopir_utama'    =>  request('sopir_utama'),
                'sopir_bantu'    =>  request('sopir_bantu'),
                'kondektur'      =>  request('kondektur'),
            ]);

            $update_jadwal_tiket->update([
                'price'          => $data_price,
                'departure_date' =>  request('departure_date'),
                'departure_time' =>  request('departure_time'),
                'id_bus'         =>  request('id_bus'),
                'from_city'      =>  request('from_city'),
                'to_city'        =>  request('to_city'),
                'sopir_utama'    =>  request('sopir_utama'),
                'sopir_bantu'    =>  request('sopir_bantu'),
                'kondektur'      =>  request('kondektur'),
            ]);

            DB::commit();
            Session::flash('status', 'success');
            Session::flash('message', 'Data berhasil Diupdate!');
            return redirect('admin/jadwal-tiket');
        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('error', 'errors');
            Session::flash(['message', 'Data gagal di update' . $e->getMessage()], 500);
            return redirect('admin/jadwal-tiket');
        }
    }

    public function destroy($id)
    {
        $bus_id = JadwalTiket::findOrFail($id);
        $kode  = $bus_id->departure_code;

        $passenger = Keberangkatan::where('departure_code', $kode)
            ->first();

        $total = $passenger->total_passenger;

        if ($total != null) {
            return response()->json(['passenger' => 'Terdapat tiket yang telah terjual']);
        } else {
            try {
                DB::beginTransaction();

                $bus_id->delete();

                $passenger->delete();

                DB::commit();
                return response()->json(['success' => 'Data Berhasil di hapus']);
            } catch (\Exception $e) {
                DB::rollback();
                return response()->json(['error' => 'Terjadi Kesalahan: ' . $e->getMessage()], 500);
            }
        }
        // if ($passenger) {
        //     return response()->json(['passenger' => 'Terdapat tiket yang telah terjual']);
        // } else {
        //     try {
        //         DB::beginTransaction();

        //         $bus_id->delete();

        //         $passenger->delete();

        //         DB::commit();
        //         return response()->json(['success' => 'Data Berhasil di hapus']);
        //     } catch (\Exception $e) {
        //         DB::rollback();
        //         return response()->json(['error' => 'Terjadi Kesalahan: ' . $e->getMessage()], 500);
        //     }
        // }
    }
}
