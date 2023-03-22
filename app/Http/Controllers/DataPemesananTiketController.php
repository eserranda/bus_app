<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Bus;
use App\Models\JadwalTiket;
use App\Models\Tiket;
use Illuminate\Http\Request;
use App\Models\Keberangkatan;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\DataTables;

class DataPemesananTiketController extends Controller
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

            $query = Tiket::select('id', 'no_ticket', 'departure_code', 'date', 'bus', 'from_city', 'to_city', 'price', 'seats_number', 'total_seats', 'customer_name', 'customers_phone_number', 'customers_address', 'payment_methods', 'status')
                ->orderBy('date', 'asc');

            if (isset($status)) {
                if ($status === 'all_data') {
                } elseif ($status == 1) {
                    $query->whereBetween('date', [$startOfWeek, $endOfWeek]);
                } else if ($status == null) {
                    $query->whereMonth('date', Carbon::now()->month);
                }
            } elseif (isset($start_date) && isset($end_date)) {
                $query->whereBetween('date', [$start_date, $end_date]);
            } else {
                $query->where('date', $today)->latest()->get();
            }
            $data = $query->get()
                ->map(function ($data) {
                    $data->date = Carbon::createFromFormat('Y-m-d', $data->date)->format('d-m-Y');
                    $data->price = 'Rp' . number_format($data->price, 0, ',', '.');
                    if ($data->status == 0) {
                        $status = '<span class="badge text-bg-danger">Belum Lunas</span>';
                    } else {
                        $status = '<span class="badge text-bg-success">Lunas</span>';
                    }
                    // $nilai_status =  $data->status;
                    return [
                        'id'                     => $data->id,
                        'departure_code'         => $data->departure_code,
                        'no_ticket'              => $data->no_ticket,
                        'date'                   => $data->date,
                        'rute'                   => $data->from_city . " - " . $data->to_city,
                        'bus'                    => $data->bus_name->type . " | " .  $data->bus_name->plat,
                        'customer_name'          => $data->customer_name,
                        'customers_phone_number' => $data->customers_phone_number,
                        'seats_number'           => $data->seats_number,
                        'price'                  => $data->price,
                        'status'                 => $status,
                        // 'nilai_status'           => $nilai_status
                    ];
                });

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('opsi', function ($row) {
                    $actionBtn = '<a class="btn btn-light text-danger btn-sm btn-icon" onclick="deleteData(\'' . $row['id'] . '\', $(this).closest(\'tr\').find(\'td:eq(1)\').text())"> <i class="fa-regular fa-trash-can"></i></a>';
                    $actionBtn .= '<a class="btn btn-light btn-sm mx-1 btn-icon text-info" href="/admin/pemesanan-tiket-info/' . $row['id'] . '"><i class="fa-solid fa-circle-info"></i></a>';
                    $actionBtn .= '<a class="btn btn-sm btn-light btn-icon" href="/admin/pemesanan-tiket-edit/' . $row['id'] . '"><i class="fa-solid fa-pen-to-square"></i></a>';
                    return $actionBtn;
                })
                ->rawColumns(['opsi', 'status'])
                ->make(true);
        }
        return view('admin.data_pemesanan_tiket');
    }
    // $data_pemesanan = Tiket::all()
    //     ->map(function ($data_pemesanan) {
    //         $data_pemesanan->date = Carbon::createFromFormat('Y-m-d', $data_pemesanan->date)->format('d-m-Y');
    //         $data_pemesanan->price = 'Rp' . number_format($data_pemesanan->price, 0, ',', '.');
    //         return $data_pemesanan;
    //     });
    public function edit($id)
    {
        $data = Tiket::findOrFail($id);
        $d_code = $data->departure_code;

        $price = JadwalTiket::select('price')
            ->where('departure_code', $d_code)
            ->first();

        $priceValue = $price->price;

        $data->price = 'Rp' . number_format($data->price, 0, ',', '.');
        return view('admin.edit_pemesanan_tiket', ['ListData' => $data, 'DataPrice' => $priceValue]);
    }



    public function destroy($id)
    {
        $Get_data = Tiket::findOrFail($id);
        $Get_data->delete();

        $date      = $Get_data->date;
        $bus       = $Get_data->bus;
        $from_city = $Get_data->from_city;
        $to_city   = $Get_data->to_city;

        $total_tiket = Tiket::where('date', $date)
            ->where('bus', $bus)
            ->where('from_city', $from_city)
            ->where('to_city', $to_city)
            ->sum('total_seats');

        $total_price = Tiket::where('date', $date)
            ->where('bus', $bus)
            ->where('from_city', $from_city)
            ->where('to_city', $to_city)
            ->sum('price');

        $update_data = Keberangkatan::where('id_bus', $bus)
            ->where('departure_date', $date)
            ->where('from_city', $from_city)
            ->where('to_city',  $to_city)
            ->first();
        if ($update_data) {
            $update_data->update([
                'total_passenger' => $total_tiket,
                'total_price' => $total_price
            ]);
        }

        if ($Get_data) {
            return response()->json(['sukses' => 'Data Berhasil di simpan']);
        } else {
            return response()->json(['Gagal' => 'Terjadi Kesalahan'], 404);
        }
        // if ($Get_data) {
        //     Session::flash('status', 'success');
        //     Session::flash('message', 'Data berhasil Dihapus!');
        // }
        // return redirect('admin/data-pemesanan-tiket');
    }
}
