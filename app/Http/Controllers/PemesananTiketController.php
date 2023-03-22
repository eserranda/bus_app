<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Bus;
use App\Models\Rute;
use App\Models\Tiket;
use App\Models\BusSeat;
use App\Models\TotalSeats;
use App\Models\JadwalTiket;
use Illuminate\Http\Request;
use App\Models\Keberangkatan;
use App\Models\PemesananTiket;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class PemesananTiketController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        return view('admin.pemesanan_tiket', compact('today'));
    }

    public function req_all_data(Request $request)
    {
        $data = JadwalTiket::select('from_city')
            ->where('departure_date', request('departure_date')) //departure_code
            ->distinct()
            ->get();

        return response()->json(['data_city' => $data]);
    }

    public function send_date(Request $request)
    {
        $data = JadwalTiket::select('from_city')
            ->where('departure_date', request('departure_date')) //departure_code
            ->distinct()
            ->get();

        return response()->json($data);
    }

    public function toCity(Request $request)
    {
        $get_data = JadwalTiket::select('to_city')
            ->where('from_city', request('from_city'))
            ->Where('departure_date', request('departure_date'))
            ->distinct()
            ->get();

        return response()->json($get_data);
    }

    public function id_bus(Request $request)
    {
        // $kode = Keberangkatan::select('status')
        //     ->where('to_city', request('to_city'))
        //     ->where('from_city', request('from_city'))
        //     ->where('departure_date', request('departure_date'))
        //     ->where('status', 0) // ambil id bus yang statusnya masih null/0, true = bus belum berangkat/bus ready 
        //     ->first();

        $kode = JadwalTiket::select('id_bus', 'price', 'departure_code')
            ->where('to_city', request('to_city'))
            ->where('from_city', request('from_city'))
            ->where('departure_date', request('departure_date'))
            ->where('status', 0) // ambil id bus yang statusnya masih null/0, true = bus belum berangkat/bus ready 
            ->distinct()
            ->get();

        if ($kode) {
            $bus_data = [];
            foreach ($kode as $data) {
                $bus_data[] = [
                    'id_bus'            => $data->bus->id,
                    'bus_name'          => $data->bus->type,
                    'plat'              => $data->bus->plat,
                    'price'             => $data->price,
                    'departure_code'    => $data->departure_code,
                ];
            }
            return response()->json($bus_data);
        } else {
            return response()->json(['errors' => 'No schedule available']);
        }
    }

    public function bus_seats(Request $request)
    {
        // $price = JadwalTiket::select('price')
        // ->where('');
        // Ambil nomor kursi yang sudah terpesan dari database
        $tiket = Tiket::select('seats_number')
            ->where('bus', request('bus_id'))
            ->where('date', request('departure_date'))
            ->where('from_city', request('from_city'))
            ->where('to_city', request('to_city'))
            ->get();

        $seats_numbers = array(); // Buat array kosong untuk menyimpan nomor kursi yang sudah terpesan

        // Looping untuk mengambil nomor kursi dari setiap tiket
        foreach ($tiket as $t) {
            $seats = explode(',', $t->seats_number); // Pisahkan nomor kursi dengan koma menjadi array
            foreach ($seats as $s) {
                $seats_numbers[] = intval($s); // Tambahkan nomor kursi ke dalam array
            }
        }
        // Ambil jumlah kursi dari data bus
        $jumlah_kursi_data = Bus::where('id', request('bus_id'))
            ->pluck('bus_seats')
            ->first();

        // Buat array nomor kursi untuk semua kursi pada bus
        $nomor_kursi = range(1, $jumlah_kursi_data);
        sort($nomor_kursi); // Urutkan nomor kursi

        // Ambil nomor kursi yang tersedia, yaitu nomor kursi yang tidak terpesan
        $available_seats = array_diff($nomor_kursi, $seats_numbers);

        // Buat array kosong untuk menyimpan nomor kursi yang tersedia
        $result = [];

        // Looping untuk memasukkan nomor kursi yang tersedia ke dalam array $result
        foreach ($available_seats as $value) {
            $result[] = $value;
        }

        // Kembalikan nomor kursi yang tersedia dalam format JSON
        return response()->json(['kursi' => $result]);
    }

    public function store(Request $request)
    {
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

        $validator = Validator::make($request->all(), [
            'no_ticket' => 'unique:tikets',
            'date' => 'required',
            'bus' => 'required',
            'from_city' => 'required',
            'to_city' => 'required',
            'price' => 'required',
            'seats_number' => 'required',
            'customers_phone_number' => 'required',
            'customer_name' => 'required',
            'payment_methods' => 'required',
            'total_seats' => 'required',
            'departure_code' => 'required',
        ], [
            'no_ticket.unique'        => 'Nomor tiket sudah ada',
            'date.required'           => 'Tanggal belum diisi',
            'bus.required'            => 'Armada Bus belum dipilih',
            'from_city.required'      => 'Asal kota belum dipilih',
            'to_city.required'        => 'Kota tujuan belum dipilih',
            'price.required'          => 'Harga tiket belum diisi',
            'seats_number.required'   => 'Nomor kursi belum dipilih',
            'departure_code.required'   => 'Kode keberangkatan tidak diketahui!',
            'customers_phone_number.required'  => 'Nomor Handphone belum diisi!',
            'customer_name.required'           => 'Nama belum diisi',
            'customers_phone_number.required'  => 'Nomor Hp belum diisi',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        } else {
            $paymet_method = request('payment_methods');
            if ($paymet_method == 'tunai') {
                $keterangan = true;
            } else if ($paymet_method == 'transfer') {
                $keterangan = false;
            }
            Tiket::create([
                'no_ticket'              => $new_no_ticket,
                'date'                   => request('date'),
                'bus'                    => request('bus'),
                'from_city'              => request('from_city'),
                'to_city'                => request('to_city'),
                'price'                  => request('price'),
                'seats_number'           => request('seats_number'),
                'customer_name'          => request('customer_name'),
                'customers_phone_number' => request('customers_phone_number'),
                'customers_address'      => request('customers_address'),
                'payment_methods'        => request('payment_methods'),
                'total_seats'            => request('total_seats'),
                'departure_code'         => request('departure_code'),
                'status'                 => $keterangan
            ]);

            $total_tiket = Tiket::where('date', request('date'))
                ->where('bus', request('bus'))
                ->where('from_city', request('from_city'))
                ->where('to_city', request('to_city'))
                ->sum('total_seats');

            $total_price = Tiket::where('date', request('date'))
                ->where('bus', request('bus'))
                ->where('from_city', request('from_city'))
                ->where('to_city', request('to_city'))
                ->sum('price');

            $update_data = Keberangkatan::where('id_bus', request('bus'))
                ->where('departure_date', request('date'))
                ->where('from_city', request('from_city'))
                ->where('to_city',  request('to_city'))
                ->first();

            $update_data->update([
                'total_passenger' => $total_tiket,
                'total_price'     => $total_price
            ]);

            return response()->json(['success' => "Pembelian tiket berhasil"]);
        }
    }

    public function update(Request $request, $id)
    {
        $get_data = Tiket::find($id);
        $price              = request('price');
        $biaya_tambahan     = request('biaya_tambahan');

        if ($biaya_tambahan != null) {
            $total_price = $price + $biaya_tambahan;
        } else {
            $total_price =  request('price');
        }

        $validator = Validator::make($request->all(), [
            'date' => 'required',
            'bus' => 'required',
            'from_city' => 'required',
            'to_city' => 'required',
            'price' => 'required',
            'seats_number' => 'required',
            'customers_phone_number' => 'required',
            'customer_name' => 'required',
            'payment_methods' => 'required',
            'total_seats' => 'required',
        ], [
            'date.required'           => 'Tanggal belum diisi',
            'bus.required'            => 'Armada Bus belum dipilih',
            'from_city.required'      => 'Asal kota belum dipilih',
            'to_city.required'        => 'Kota tujuan belum dipilih',
            'price.required'          => 'Harga tiket belum diisi',
            'seats_number.required'   => 'Nomor kursi belum dipilih',
            'customers_phone_number.required' => 'Nomor Handphone belum di isi',
            'customer_name.required'  => 'Nama belum diisi',
            'customers_phone_number.required'  => 'Nomor Hp belum diisi',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        } else {
            $get_data->update([
                'no_ticket'              => request('no_ticket'),
                'departure_code'         => request('departure_code'),
                'date'                   => request('date'),
                'bus'                    => request('bus'),
                'from_city'              => request('from_city'),
                'to_city'                => request('to_city'),
                'price'                  =>  $total_price,
                'seats_number'           => request('seats_number'),
                'total_seats'            => request('total_seats'),
                'customer_name'          => request('customer_name'),
                'customers_phone_number' => request('customers_phone_number'),
                'customers_address'      => request('customers_address'),
                'payment_methods'        => request('payment_methods'),
            ]);


            $total_tiket = Tiket::where('departure_code', request('departure_code'))
                ->sum('total_seats');

            $total_price = Tiket::where('departure_code', request('departure_code'))
                ->sum('price');

            $update_data = Keberangkatan::where('departure_code', request('departure_code'))
                ->first();

            $update_data->update([
                'total_passenger' => $total_tiket,
                'total_price'     => $total_price
            ]);

            $update_old_dcode = Keberangkatan::where('departure_code', request('old_departure_code'))
                ->first();

            $new_total_passenger = Tiket::where('departure_code', request('old_departure_code'))
                ->sum('total_seats');

            $new_total_price = Tiket::where('departure_code', request('old_departure_code'))
                ->sum('price');

            $update_old_dcode->update([
                'total_passenger' => $new_total_passenger,
                'total_price'     => $new_total_price
            ]);

            return response()->json(['success' => "Update tiket berhasil"]);
        }
    }
}
