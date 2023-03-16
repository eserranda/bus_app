<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Rute;
use App\Models\Tiket;
use App\Models\BusSeat;
use App\Models\TotalSeats;
use App\Models\JadwalTiket;
use App\Models\Keberangkatan;
use Illuminate\Http\Request;
use App\Models\PemesananTiket;
use Illuminate\Support\Facades\Session;

class PemesananTiketController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        // $jadwal = JadwalTiket::whereDate('departure_date', '>=', $today)
        //     ->orderBy('departure_date', 'asc')
        //     ->with('bus')
        //     ->get()
        //     ->map(function ($jadwal) {
        //         $jadwal->departure_date = Carbon::createFromFormat('Y-m-d', $jadwal->departure_date)->format('d-m-Y');
        //         $jadwal->price = 'Rp ' . number_format($jadwal->price, 0, ',', '.');
        //         return $jadwal;
        //     });

        return view('admin.pemesanan_tiket');
    }

    public function send_date(Request $request)
    {
        $departure_date = $request->input('departure_date'); //tanggal
        $data = JadwalTiket::select('from_city')
            ->where('departure_date', $departure_date)
            ->distinct()
            ->get();

        return response()->json($data);
    }

    public function toCity(Request $request)
    {
        $departure_date = $request->input('departure_date'); //Tanngal
        $from_city = $request->input('from_city'); //Asal Kota\

        $get_data = JadwalTiket::select('to_city')
            ->where('from_city', $from_city)
            ->Where('departure_date', $departure_date)
            ->distinct()
            ->get();

        return response()->json($get_data);
    }

    public function id_bus(Request $request)
    {
        $get_data = JadwalTiket::select('id_bus', 'price')
            ->where('to_city', request('to_city'))
            ->where('from_city', request('from_city'))
            ->where('departure_date', request('departure_date'))
            ->with('bus')
            ->distinct()
            ->get();
        // ->map(function ($get_data) {
        //     $get_data->price = number_format($get_data->price, 0, ',', '.');
        //     return $get_data;
        // });

        $bus_data = [];
        foreach ($get_data as $data) {
            $bus_data[] = [
                'id_bus'   => $data->bus->id,
                'bus_name' => $data->bus->type,
                'price'    => $data->price
            ];
        }
        return response()->json($bus_data);
    }

    public function bus_seats(Request $request)
    {
        $tiket = Tiket::select('seats_number')
            ->where('bus', request('bus_id'))
            ->where('date', request('departure_date'))
            ->where('from_city', request('from_city'))
            ->where('to_city', request('to_city'))
            ->get();

        $seats_numbers = array();
        foreach ($tiket as $t) {
            $seats = explode(',', $t->seats_number);
            foreach ($seats as $s) {
                $seats_numbers[] = intval($s);
            }
        }

        $get_data = BusSeat::select('nomor_kursi')
            ->where('id_bus', request('bus_id'))
            ->whereNotIn('nomor_kursi', $seats_numbers)
            ->distinct()
            ->get();

        return response()->json($get_data);
    }


    public function store(Request $request)
    {
        // $data_idBus = $request->input('bus');

        $exploded = explode(' - ',  request('bus'));
        $id_bus = $exploded[0];
        // $str = $id_bus;
        // $arr = explode(" - ", $str);
        // $num = $arr[0];

        $price      = $request->input('price');
        $data_price = preg_replace('/\D/', '', $price);

        $seats_number = array_map('intval', $request->input('seats_number'));
        $seats_array  = implode(',', $seats_number);

        // dd($seats_array);
        $seats1 =  $seats_array;
        $total = explode(",", $seats1);
        $total_seats = count($total);

        // Pemisahan nilai kursi
        // $seats = explode(',', $seats_array);
        // $seat_1 = intval($seats[0]);

        // // Pengecekan jumlah data di $seats
        // if (count($seats) > 1) {
        //     $seat_2 = intval($seats[1]);
        // } else {
        //     $seat_2 = null;
        // }

        // $data_seats = $seat_1;

        // if ($seat_2) {
        //     $data_seats .= ', ' . $seat_2;
        // }



        $latestData = Tiket::latest('no_ticket')->first();
        if ($latestData) {
            $parts = explode('-', $latestData->no_ticket); // memisahkan string menjadi 2 bagian
            $code = $parts[0]; // kode awal atau ambil angka awalan sebelum -
            $num = intval($parts[1]); // nomor urut
            if ($num == 999) {
                $num = 1; // jika nomor urut sudah mencapai batas maka kembali ke 1
            } else {
                $num++; // jika belum mencapai batas maka increment seperti biasa
            }
            $new_no_ticket = $code . '-' . str_pad($num, 3, '0', STR_PAD_LEFT); // menggabungkan kembali string
        } else {
            $new_no_ticket = "TKC-001";
        }

        Tiket::create([
            'no_ticket'    => $new_no_ticket,
            'date'         => $request->input('date'),
            'bus'          => $id_bus,
            'from_city'    => $request->input('from_city'),
            'to_city'      => $request->input('to_city'),
            'price'        => $data_price,
            'seats_number' => $seats_array,
            'total_seats'  => $total_seats,
        ]);

        $total_tiket = Tiket::where('date', request('date'))
            ->where('bus', request('bus'))
            ->where('from_city', request('from_city'))
            ->where('to_city', request('to_city'))
            ->sum('total_seats');



        // $totalSeats = TotalSeats::where('id_bus', $id_bus)->first();
        // if ($totalSeats !== null) {
        //     $totalSeats->update(['seats_total' => $total_tiket]);
        // } else {
        //     $totalSeats = TotalSeats::create([
        //         'date' => $request->input('date'),
        //         'id_bus' =>  $id_bus,
        //         'seats_total' => $total_tiket,
        //     ]);
        // }

        $totalSeats = Keberangkatan::where('id_bus', $id_bus)
            ->where('departure_date', request('date'))
            ->where('from_city', request('from_city'))
            ->where('to_city',  request('to_city'))
            ->first();

        if ($totalSeats !== null) {
            $totalSeats->update(['total_passenger' => $total_tiket]);
        }
        return redirect('admin/pemesanan-tiket');
    }
}