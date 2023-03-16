<?php

use App\Models\PerawatanBus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BbmController;
use App\Http\Controllers\BusController;
use App\Http\Controllers\webController;
use App\Http\Controllers\RuteController;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\TiketController;
use App\Http\Controllers\DriverController;
use Symfony\Component\Routing\RouteCompiler;
use App\Http\Controllers\GajiDriverController;
use App\Http\Controllers\KedatanganController;
use App\Http\Controllers\JadwalTiketController;
use App\Http\Controllers\DataKaryawanController;
use App\Http\Controllers\GajiKaryawanController;
use App\Http\Controllers\PanjarDriverController;
use App\Http\Controllers\PerawatanBusController;
use App\Http\Controllers\PersenanGajiController;
use App\Http\Controllers\KeberangkatanController;
use App\Http\Controllers\PemesananTiketController;
use App\Http\Controllers\TransaksiTiketController;
use App\Http\Controllers\LaporanKeuanganController;
use App\Http\Controllers\DataPemesananTiketController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


// Route::get('/manifest', function (Request $request) {
//     $data = json_decode($request->query('data'), true);
//     $rute = json_decode($request->query('rute'), true);

//     return view('admin.manifest', ['data' => $data, 'rute' => $rute]);
// })->name('admin.manifest');

Route::get('/manifest', function (Request $request) {
    $data = json_decode($request->query('data'), true);
    $rute = json_decode($request->query('rute'), true);

    return view('admin.manifest', compact('data', 'rute'));
})->name('admin.manifest');


Route::get('/', function () {
    return view('welcome');
});

// pimpinan Zone
Route::controller(ChartController::class)->group(function () {
    Route::get('pimpinan/chart', 'index')->name('index.data.chart');
    Route::get('pimpinan/chartDataBar', 'chartDataBar')->name('chart.chartDataBar');
    Route::get('pimpinan/chartDataLine', 'chartDataLine')->name('chart.chartDataLine');
});

Route::controller(DriverController::class)->group(function () {
    Route::get('pimpinan/data-driver', 'index')->name('index.data.drivers');
    Route::get('pimpinan/add-driver', 'add');
    Route::post('pimpinan/driver-save', 'store');
    Route::get('pimpinan/driver-edit/{id}', 'edit');
    Route::put('pimpinan/driver-update/{id}', 'update');
    Route::delete('pimpinan/driver-delete/{id}', 'delete');
});

Route::controller(DataKaryawanController::class)->group(function () {
    Route::get('pimpinan/data-karyawan', 'index')->name('index.data.karyawan');
    Route::get('pimpinan/add-data-karyawan', 'create');
    Route::post('pimpinan/data-karyawan-save', 'store');
    Route::get('pimpinan/data-karyawan-edit/{id}', 'edit');
    Route::put('pimpinan/data-karyawan-update/{id}', 'update');
    Route::delete('pimpinan/data-karyawan-delete/{id}', 'destroy')->name('bbm_delete_data');
});

Route::controller(BbmController::class)->group(function () {
    Route::get('pimpinan/bbm', 'index')->name('index.bbm');
    Route::get('pimpinan/bbm-add', 'create');
    Route::post('pimpinan/bbm-save', 'store');
    Route::get('pimpinan/bbm-add-multiple', 'add_multiple');
    Route::post('pimpinan/bbm-save-multiple', 'multiple_save')->name('bbm-multiple-save');
    Route::get('pimpinan/bbm-edit/{id}', 'edit');
    Route::put('pimpinan/bbm-update/{id}', 'update');
    Route::post('pimpinan/bbm-financial-save', 'financial_save')->name('bbm-financial-save');
    Route::delete('pimpinan/bbm-delete/{id}', 'destroy')->name('bbm_delete_data');
});

Route::controller(GajiKaryawanController::class)->group(function () {
    Route::get('pimpinan/gaji-karyawan', 'index');
    Route::get('pimpinan/add-gaji-karyawan', 'create');
    Route::post('pimpinan/gaji-karyawan-save', 'store');
    Route::get('pimpinan/gaji-karyawan-edit/{id}', 'edit');
    Route::put('pimpinan/gaji-karyawan-update/{id}', 'update');
    Route::post('pimpinan/gaji-karyawan-financial-save', 'financial_save')->name('gaji-karyawan-financial-save');
    Route::delete('pimpinan/gaji-karyawan-delete/{id}', 'destroy');
});


Route::controller(PanjarDriverController::class)->group(function () {
    Route::get('pimpinan/panjar-driver', 'index')->name('index.panjar.driver');
    Route::get('pimpinan/panjar-add', 'create');
    Route::post('pimpinan/panjar-save', 'store');
    Route::get('pimpinan/panjar-edit/{id}', 'edit');
    Route::put('pimpinan/panjar-update/{id}', 'update');
    Route::put('pimpinan/panjar-repaymend/', 'repaymend')->name('panjar-repaymend');
    Route::post('pimpinan/panjar-financial-save', 'financial_save')->name('panjar-financial-save');
    Route::post('pimpinan/panjar-fdown-payment-financial-save', 'financial_down_payment_save')->name('down-payment-financial-save');
    Route::delete('pimpinan/panjar-delete/{id}', 'destroy')->name('delete_data');
});



Route::controller(PerawatanBusController::class)->group(function () {
    Route::get('pimpinan/perawatan-armada', 'index')->name('data_perwatan_bus');
    Route::get('pimpinan/perawatan-armada-add', 'create');
    Route::get('pimpinan/perawatan-armada-add-multiple', 'add_multiple');
    Route::post('pimpinan/perawatan-armada-multiple-save', 'multiple_save')->name('perawatan_multiple_save');
    Route::post('pimpinan/perawatan-armada-save', 'store');
    Route::delete('pimpinan/perawatan-armada-delete/{id}', 'destroy')->name('delete_data');
    Route::get('pimpinan/perawatan-armada-edit/{id}', 'edit');
    Route::put('pimpinan/perawatan-armada-update/{id}', 'update');
    Route::post('pimpinan/perawatan-armada-financial-save', 'financial_save')->name('financial-save');
});

Route::controller(LaporanKeuanganController::class)->group(function () {
    Route::get('pimpinan/laporan-keuangan', 'index')->name('blogs.index');
});

Route::controller(GajiDriverController::class)->group(function () {
    Route::get('pimpinan/gaji-driver', 'index')->name('index.gaji.driver');
    Route::delete('pimpinan/gaji-driver-delete/{id}', 'destroy');
    Route::put('pimpinan/gaji-driver-update/{id}', 'update');
    Route::get('pimpinan/ambil-gaji/{id}', 'ambilgaji');
    Route::post('pimpinan/gaji-driver-financial-save', 'financial_save')->name('gaji-driver-financial-save');
});

Route::controller(PersenanGajiController::class)->group(function () {
    Route::get('pimpinan/persenan-gaji', 'index');
    Route::get('pimpinan/persenan-gaji-add', 'add');
    Route::post('pimpinan/persenan-gaji-toCity', 'toCity')->name('persenan_toCity');
    Route::get('pimpinan/persenan-gaji-edit/{id}', 'edit');
    Route::post('pimpinan/driver/persenan-save', 'store');
    Route::put('pimpinan/driver/persenan-update/{id}', 'update');
    Route::get('pimpinan/driver/persenan-delete/{id}', 'delete');
});



// admin/pegawai Zone

Route::controller(DataPemesananTiketController::class)->group(function () {
    Route::get('admin/data-pemesanan-tiket', 'index')->name('index.data.tiket');
    Route::get('admin/pemesanan-tiket-edit/{id}', 'edit');
    Route::delete('admin/pemesanan-tiket-delete/{id}', 'destroy');
});

// Route::controller(TransaksiTiketController::class)->group(function () {
// Route::get('pimpinan/transaksi-tiket', 'index');
// Route::get('pimpinan/trasaksi-tiket', 'trasaksi_tiket')->name('transaksi_tiket');
// Route::get('pimpinan/financial-tiket-save', 'financial_tiket_save')->name('financial_tiket_save');
// });

Route::controller(KeberangkatanController::class)->group(function () {
    Route::get('admin/keberangkatan', 'index')->name('admin.keberangkatan');
    Route::get('admin/keberangkatan-setberangkat/{id}', 'SetBerangkat');
    Route::get('admin/keberangkatan-rollback/{id}', 'Rollback');
    Route::post('admin/keberangkatan-manifest/{id}', 'manifest')->name('manifest');
    // Kenapa di letakkan di sini? ini untuk data real time transaksi penjualan tiket, untuk di pantau pimpinan  maupun admin/pegawai
    Route::get('pimpinan/transaksi-tiket', 'data_transaksi_tiket');
    Route::get('pimpinan/trasaksi-tiket', 'trasaksi_tiket')->name('transaksi_tiket');
    Route::post('pimpinan/financial-tiket-save', 'financial_tiket_save')->name('financial_tiket_save');
});

Route::controller(KedatanganController::class)->group(function () {
    Route::get('admin/kedatangan', 'index')->name('admin.kedatangan');
    Route::get('admin/kedatangan-tiba/{id}', 'SetTiba');
    // Route::get('admin/keberangkatan-setberangkat/{id}', 'SetBerangkat');
});

Route::get('admin/verifikasi', function () {
    return view('admin.verifikasi_tiket');
});

Route::controller(PemesananTiketController::class)->group(function () {
    Route::get('admin/pemesanan-tiket', 'index');
    Route::post('admin/ajax_req_all_data', 'req_all_data')->name('req_all_data');
    Route::post('admin/ajax_send_date', 'send_date')->name('send_date');
    Route::post('admin/get_to_City', 'toCity')->name('to_city');
    Route::post('admin/get_id_bus', 'id_bus')->name('get_id_bus');
    Route::post('admin/get_seats_bus', 'bus_seats')->name('get_seats_bus');
    Route::post('admin/pemesanan-tiket-save', 'store')->name('store');
    Route::put('admin/pemesanan-tiket-update/{id}', 'update');
});

Route::controller(JadwalTiketController::class)->group(function () {
    Route::get('admin/jadwal-tiket', 'index')->name('admin.jadwal.tiket');
    Route::post('admin/toCity', 'toCity');
    Route::get('admin/add-jadwal-tiket', 'add');
    Route::post('admin/jadwal-tiket-save', 'store');
    Route::get('admin/jadwal-tiket-edit/{id}', 'edit');
    Route::put('admin/jadwal-tiket-update/{id}', 'update');
    Route::get('admin/jadwal-tiket-delete/{id}', 'delete');
});

Route::controller(RuteController::class)->group(function () {
    Route::get('admin/data-rute', 'index');
    Route::get('admin/add-rute', 'add');
    Route::post('admin/rute-save', 'store');
    Route::get('admin/rute-edit/{id}', 'edit');
    Route::put('admin/rute-update/{id}', 'update');
    Route::get('admin/rute-delete/{id}', 'delete');
});



Route::get('admin/add-bus', function () {
    return view('admin.add_bus');
});

Route::get('admin/data-armada', [BusController::class, 'index']);
Route::post('admin/bus-save', [BusController::class, 'store']);
Route::get('admin/bus-edit/{id}', [BusController::class, 'edit']);
Route::put('admin/bus-update/{id}', [BusController::class, 'update']);
Route::get('admin/bus-delete/{id}', [BusController::class, 'delete']);
Route::get('admin/data-tiket', [TiketController::class, 'index']);
