@extends('layouts.master')
@section('title', 'Tambah Armada Bus')
@section('submenu', 'show')

@section('content')

    <div class="col-xl-8 col-md-6">
        <div class="card">
            <form action="bus-save" class="row g-3 m-2" method="POST">
                @csrf
                <div class="col-md-6">
                    <label for="name" class="form-label">Jenis Bus<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="name" name="type" placeholder="Jenis Bus"
                        required>
                </div>


                <div class="col-md-6">
                    <label for="plat" class="form-label">Nomor Plat<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="plat" name="plat" placeholder="DP 1234 ER"
                        required>
                </div>

                <div class="col-md-6">
                    <label for="Bus_seats" class="form-label">Jumlah Kursi<span class="text-danger">*</span></label>
                    <input type="number" class="form-control" id="bus_seats" name="bus_seats" placeholder="Jumlah Kursi"
                        required>
                </div>

                <div class="col-md-6">
                    <label for="description" class="form-label">Keterangan</label>
                    <textarea class="form-control" id="description" name="description" rows="2"></textarea>
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-primary mb-1"><i class="fa-solid fa-plus"></i> Tambah</button>
                    <a href="data-armada" class="btn btn-warning mb-1"><i class="fa-solid fa-angles-left"></i> Kembali</a>

                </div>
            </form>
        </div>
    </div>

@endsection
