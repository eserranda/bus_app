<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\LaporanKeuangan;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\Datatables;

class LaporanKeuanganController extends Controller
{
    public function index(Request $request)
    {
        $data = LaporanKeuangan::all()->map(function ($item) {
            if ($item->total_dana != null) {
                $item->total_dana = 'Rp' . number_format($item->total_dana, 0, ',', '.');
            }
            if ($item->debet != null) {
                $item->debet = 'Rp' . number_format($item->debet, 0, ',', '.');
            }
            if ($item->credit != null) {
                $item->credit = 'Rp' . number_format($item->credit, 0, ',', '.');
            }
            return $item;
        });

        // // mengambil data laporan keuangan pada setiap bulan
        // $data = LaporanKeuangan::select(DB::raw('YEAR(date) year, MONTH(date) month, SUM(debet) total_debet'))
        //     ->groupBy('year', 'month')
        //     ->get();

        // // menghitung total debet pada setiap bulan
        // $totalDebetPerBulan = [];
        // foreach ($data as $item) {
        //     $totalDebetPerBulan[$item->year . '-' . $item->month] = $item->total_debet;
        // }

        // // output total debet pada setiap bulan
        // foreach ($totalDebetPerBulan as $bulan => $totalDebet) {
        //     echo "Total debet pada bulan $bulan adalah $totalDebet <br>";
        // }



        $count = LaporanKeuangan::all();

        $totalDebet  = $count->sum('debet');
        $totalCredit = $count->sum('credit');

        $totalDebetFormatted  = 'Rp' . number_format($totalDebet, 0, ',', '.');
        $totalCreditFormatted = 'Rp' . number_format($totalCredit, 0, ',', '.');

        $total = $totalCredit - $totalDebet;

        $totalFormatted = 'Rp' . number_format($total, 0, ',', '.');

        return view('pimpinan.laporan.laporan_keuangan', [
            'DataKeuangan' => $data, 'TotalDebet' =>  $totalDebetFormatted, 'TotalCredit' => $totalCreditFormatted, 'Total' => $totalFormatted, 'DateToday' => Carbon::today()->format('d-m-Y')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(LaporanKeuangan $laporanKeuangan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LaporanKeuangan $laporanKeuangan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LaporanKeuangan $laporanKeuangan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LaporanKeuangan $laporanKeuangan)
    {
        //
    }
}