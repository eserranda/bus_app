<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LaporanKeuangan;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller

{
    public function index(Request $request)
    {
        return view('pimpinan.chart.data_chart');
    }

    public function chartDataBar()
    {
        // mengambil data laporan keuangan pada setiap bulan
        $pemasukan = LaporanKeuangan::select(DB::raw('YEAR(date) year, MONTH(date) month, SUM(credit) total_credit'))
            ->groupBy('year', 'month')
            ->get();

        $pengeluaran = LaporanKeuangan::select(DB::raw('YEAR(date) year, MONTH(date) month, SUM(debet) total_debet'))
            ->groupBy('year', 'month')
            ->get();

        $pemasukan->sum('total_credit');
        $pengeluaran->sum('total_debet');

        // $total_pemasukan = $pemasukan->sum('total_credit');
        // $total_pengeluaran = $pengeluaran->sum('total_debet');

        // Menghitung pendapatan bulanan
        // $Pendapatan_bulanan = $total_pemasukan - $total_pengeluaran;

        // $total_keuntungan = $keuntungan->sum('keuntungan');

        return response()->json([
            'pemasukan' => $pemasukan,
            'pengeluaran' => $pengeluaran,
            // 'Pendaptan_bulanan' => $keuntungan
        ]);
    }
    public function chartDataLine()
    {

        $pemasukan = LaporanKeuangan::select(DB::raw('YEAR(date) year, MONTH(date) month, SUM(credit) total_credit'))
            ->groupBy('year', 'month')
            ->get();

        $pengeluaran = LaporanKeuangan::select(DB::raw('YEAR(date) year, MONTH(date) month, SUM(debet) total_debet'))
            ->groupBy('year', 'month')
            ->get();

        $keuntungan = collect([]);

        foreach ($pemasukan as $key => $value) {
            $bulan = $value->month;
            $tahun = $value->year;

            $pemasukan_bulan = $value->total_credit;
            $pengeluaran_bulan = $pengeluaran->where('month', $bulan)->where('year', $tahun)->first()->total_debet ?? 0;

            $keuntungan_bulan = $pemasukan_bulan - $pengeluaran_bulan;

            $keuntungan->push([
                'bulan' => $bulan,
                'tahun' => $tahun,
                'keuntungan' => $keuntungan_bulan,
            ]);
        }
        // mengambil data laporan keuangan pada setiap bulan
        // $pemasukan = LaporanKeuangan::select(DB::raw('YEAR(date) year, MONTH(date) month, SUM(credit) total_credit'))
        //     ->groupBy('year', 'month')
        //     ->get();

        // $pengeluaran = LaporanKeuangan::select(DB::raw('YEAR(date) year, MONTH(date) month, SUM(debet) total_debet'))
        //     ->groupBy('year', 'month')
        //     ->get();

        // $selisih = [];
        // foreach ($pemasukan as $p) {
        //     $year = $p->year;
        //     $month = $p->month;
        //     $credit = $p->total_credit;
        //     $debit = 0;
        //     foreach ($pengeluaran as $pg) {
        //         if ($pg->year == $year && $pg->month == $month) {
        //             $debit = $pg->total_debet;
        //             break;
        //         }
        //     }
        //     $selisih["$year-$month"] = $credit - $debit;
        // }
        return response()->json([
            'chartData' => $keuntungan
        ]);
    }
}