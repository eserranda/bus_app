<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Bus;
use App\Models\Rute;
use App\Models\Drivers;
use App\Models\JadwalTiket;
use App\Models\Keberangkatan;
use App\Models\TransaksiTiket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\DataTables;

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
                $query->where('departure_date', $today);
            }
            $data = $query->get()
                ->map(function ($data) {
                    $data->departure_date = Carbon::createFromFormat('Y-m-d', $data->departure_date)->format('d-m-Y');
                    $data->total_price = 'Rp' . number_format($data->total_price, 0, ',', '.');
                    // if ($data->status == 1) {
                    //     $status = '<span class="badge text-bg-warning">Berangkat</span>';
                    // } elseif ($data->status == 2) {
                    //     $status = '<span class="badge text-bg-success"> Tiba di ' . $data->to_city . ' </span>';
                    // } elseif ($data->status == null) {
                    //     $status =  '';
                    // }
                    // $nilai_status =  $data->status;
                    return [
                        'id'              => $data->id,
                        'departure_date'  => $data->departure_date,
                        'bus'             => $data->bus->type . " | " . $data->bus->plat,
                        'rute'            => $data->from_city . " - " . $data->to_city,
                        'id_driver'       => $data->driver->fullname,
                        'sopir_bantu'     => $data->sopirBantu->fullname,
                        'kondektur'       => $data->Kondektur->fullname,
                        'price'           => $data->price,
                        // 'nilai_status'    => $nilai_status
                    ];
                });

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('opsi', function ($row) {
                    $actionBtn =  '<a class="btn btn-light text-primary btn-sm" href="/admin/jadwal-tiket-edit/' . $row['id'] . '">
                    <i class="fa-solid fa-pen-to-square"></i></a>';
                    // $actionBtn .= '<a class="btn btn-light text-danger btn-sm" href="/admin/jadwal-tiket-delete/' . $row['id'] . '"> <i class="fa-solid fa-trash-can"></i></a>';
                    return $actionBtn;
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

        $keberangkatan = Keberangkatan::create([
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

        $utama     = "Utama";
        $bantu     = "Bantu";
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
        $update = JadwalTiket::findOrFail($id);

        $price =  request('price');

        $data_price = str_replace('.', '', $price);

        $update->update([
            'price'          => $data_price,
            'departure_date' =>  request('departure_date'),
            'id_bus'         =>  request('id_bus'),
            'from_city'      =>  request('from_city'),
            'to_city'        =>  request('to_city'),
            'sopir_utama'    =>  request('sopir_utama'),
            'sopir_bantu'    =>  request('sopir_bantu'),
            'kondektur'      =>  request('kondektur'),
        ]);

        // $update->update($request->all());

        if ($update) {
            Session::flash('status', 'success');
            Session::flash('message', 'Data berhasil Diupdate!');
        }
        return redirect('admin/jadwal-tiket');
    }



    public function delete($id)
    {
        $bus_id = JadwalTiket::findOrFail($id);

        $kode  = $bus_id->departure_code;

        Keberangkatan::where('departure_code', $kode)
            ->delete();

        TransaksiTiket::where('departure_code', $kode)
            ->delete();

        $delete = JadwalTiket::findOrFail($id);
        $delete->delete();

        if ($delete) {
            Session::flash('status', 'success');
            Session::flash('message', 'Data berhasil Dihapus!');
        }
        return redirect('/admin/jadwal-tiket');
    }
}