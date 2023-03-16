@extends('layouts.master')
{{-- @section('title', 'Edit Pemesanan Tiket') --}}
{{-- @section('submenu', 'show') --}}

@section('content')
    <style>
        .form-inline {
            display: flex;
            align-items: center;
        }

        .form-group {
            display: flex;
            align-items: center;
        }
    </style>
    <div class="alert alert-danger d-none" id="alert-danger"></div>

    <div class="alert alert-success d-none" id="alert-success"></div>
    <div class="row">
        <div class="col-xl-7 col-md-6">
            <div class="card shadow">
                <div class="m-3">
                    <h4 class="text-center mb-1">Edit Data Pemesanan Tiket</h4>
                    <div class="row my-2">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Tanggal Berangkat<span
                                    class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="departure_date" name="date" required
                                min="{{ date('Y-m-d', strtotime('today')) }}" value="{{ $ListData->date }}">

                            {{-- onchange="sendDate()" --}}
                        </div>

                        <div class="col-md-6">
                            <label for="driver" class="form-label">Jumlah Penumpang</label>
                            <input type="text" class="form-control" id="total_passeger" name="total_passeger"
                                placeholder="Jumlah Penumpang" value="{{ $ListData->total_seats }}" readonly>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label for="driver" class="form-label">Kota Asal<span class="text-danger">*</span></label>
                            <select class="form-select" id="from_city" name="from_city" required>
                                <option value="" selected>{{ $ListData->from_city }}</option>

                            </select>
                        </div>

                        <div class="col-md-6 mt-2 mt-md-0">
                            <label for="to_city" class="form-label">Kota Tujuan<span class="text-danger">*</span></label>
                            <select class="form-select" id="to_city" name="to_city" required>
                                <option value="" selected>{{ $ListData->to_city }}</option>

                            </select>
                        </div>
                    </div>

                    <div class="row mt-2 mb-3">
                        <div class="col-md-6">
                            <label for="bus" class="form-label">Bus & Harga<span class="text-danger">*</span></label>
                            <select class="form-select" id="id_bus" name="bus" required>
                                {{-- <option value="" selected>{{ $ListData->bus_name->type }} - {{ $ListData->price }}
                                </option> --}}

                            </select>
                        </div>

                        <div class="col-md-6  mt-2 mt-md-0">
                            <label for="name" class="form-label">Nomor Kursi<span class="text-danger">*</span></label>
                            <select class="form-control kursi m-2" style="width:100% " id="bus_seats" name="seats_number[]"
                                multiple="multiple" required>
                            </select>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="Bus_seats" class="form-label">Nama<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="tiket_customer_name" name="tiket_customer_name"
                                placeholder="Nama" required value="{{ $ListData->customer_name }}">
                        </div>
                        <div class="col-md-6">
                            <label for="Bus_seats" class="form-label">Hp/Wa<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="tiket_customers_phone_number"
                                name="tiket_customers_phone_number" placeholder="Nomor Hp/Wa"
                                value="{{ $ListData->customers_phone_number }}" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6  mt-2  ">
                            <label for="description" class="form-label">Alamat/Penjemputan</label>
                            <textarea class="form-control" id="tiket_costumers_address" name="tiket_costumers_address" rows="2">{{ $ListData->customers_address }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-xl-5 col-md-6 mt-3 mt-md-0 mb-5">
            <div class="card shadow p-3">
                <form id="form-input-tiket">
                    <h4 class="text-center">Detail Pemesanan Tiket</h4>

                    <div class="mb-0 row">
                        <label for="no_ticket" class="col-sm-3 col-form-label">No tiket</label>
                        <div class="col-sm-8">
                            <input type="text" readonly class="form-control-plaintext fw-bold" id="no_ticket"
                                name="no_ticket" value="{{ $ListData->no_ticket }}">
                            <input type="hidden" readonly class="form-control-plaintext" id="id_tiket" name="id_tiket"
                                value="{{ $ListData->id }}">
                        </div>
                    </div>

                    <div class="mb-0 row">
                        <label for="staticEmail" class="col-sm-3 col-form-label">Tanggal</label>
                        <div class="col-sm-8">
                            <input type="text" readonly class="form-control-plaintext fw-bold" id="date"
                                value="{{ $ListData->date }}">
                        </div>
                    </div>
                    <div class="mb-0 row">
                        <label for="tiket" class="col-sm-3 col-form-label">Rute</label>
                        <div class="col-sm-8 form-inline">
                            <div class="form-group">
                                <input type="text" readonly class="form-control-plaintext fw-bold"
                                    id="tiket_from_city" value="{{ $ListData->from_city }}">
                                <label style="text-align: center;"><i class="fa-solid fa-arrow-right"></i></label>
                                <input type="text" readonly class="form-control-plaintext fw-bold"
                                    style="text-align: center;" id="tiket_to_city" value="{{ $ListData->to_city }}">
                                <input type="hidden" readonly class="form-control-plaintext" id="tiket_departure_code"
                                    value="{{ $ListData->departure_code }}">
                            </div>
                        </div>
                    </div>

                    <div class="mb-0 row">
                        <label for="tiket_id_bus" class="col-sm-3 col-form-label">Bus </label>
                        <div class="col-sm-8">
                            <input type="hidden" readonly class="form-control-plaintext fw-bold" id="tiket_id_bus"
                                value="{{ $ListData->bus }}">
                            <input type="text" readonly class="form-control-plaintext fw-bold" id="tiket_id_bus"
                                value="{{ $ListData->bus_name->type }} | {{ $ListData->bus_name->plat }} ">
                        </div>
                    </div>

                    <div class="mb-0 row">
                        <label for="inputPassword" class="col-sm-3 col-form-label">No. Kursi</label>
                        <div class="col-sm-8">
                            <input type="text" readonly class="form-control-plaintext fw-bold" id="seats_number"
                                value="{{ $ListData->seats_number }}">
                        </div>
                    </div>
                    <div class="mb-0 row">
                        <label for="customer_name" class="col-sm-3 col-form-label">Nama</label>
                        <div class="col-sm-8">
                            <input type="text" readonly class="form-control-plaintext fw-bold" id="customer_name"
                                value="{{ $ListData->customer_name }}">
                        </div>
                    </div>
                    <div class="mb-0 row">
                        <label for="phone_number" class="col-sm-3 col-form-label">Hp</label>
                        <div class="col-sm-8">
                            <input type="text" readonly class="form-control-plaintext fw-bold"
                                id="customers_phone_number" value="{{ $ListData->customers_phone_number }}" required>
                        </div>
                    </div>
                    <div class="mb-0 row">
                        <label for="customers_address" class="col-sm-3 col-form-label">Alamat</label>
                        <div class="col-sm-8">
                            <input type="text" readonly class="form-control-plaintext fw-bold" id="customers_address"
                                value="{{ $ListData->customers_address }}">
                        </div>
                    </div>
                    <hr class="mb-0">
                    <div class="mb-0 row">
                        <label for="customers_address" class="col-md-4 col-form-label">Detail </label>
                        <div class="col-sm-8">
                            <input type="text" readonly class="form-control-plaintext fw-bold" id="harga_tiket"
                                value="{{ $DataPrice }}">
                        </div>
                    </div>

                    <div class=" row">
                        <label for="total_bayar" class="col-sm-4 col-form-label">Total
                            Bayar</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control-plaintext fw-bold" style="font-size: 18px"
                                id="total_bayar" readonly value="{{ $ListData->price }}">
                        </div>
                    </div>
                    <hr class="mb-0 mt-0">
                    <div class="mb-0 row">
                        <label for="customers_address" class="col-md-5 col-form-label">Biaya Tambahan </label>
                        <div class="col-sm-6">
                            <input type="hidden" readonly class="form-control-plaintext" name="payment_methods"
                                id="payment_methods" value="{{ $ListData->payment_methods }}">
                            <input type="text" readonly class="form-control-plaintext fw-bold" style="font-size: 24px"
                                id="biaya_tambahan">

                        </div>
                    </div>
                    <div id="Payment" style="display:none;">
                        <div class="form-check form-check-inline mt-2">
                            <input class="form-check-input" type="radio" name="payment_method" id="tunai"
                                value="tunai">
                            <label class="form-check-label" for="radio1">Tunai</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="payment_method" id="transfer"
                                value="transfer">
                            <label class="form-check-label" for="radio2">Transfer Bank</label>
                        </div>
                    </div>

                </form>
                <div class="col-12 mt-3">
                    <button type="submit" id="update" class="btn btn-primary mb-1 update"><i
                            class="fa-solid fa-plus"></i> Update Tiket</button>

                    <button class="btn btn-primary d-none" type="button" id="loading" disabled>
                        <span class="spinner-border spinner-border-sm " role="status" aria-hidden="true"></span>
                        <span class="visually-hidden">Loading...</span>
                    </button>
                </div>

            </div>
        </div>

    </div>

    @push('script')
        <script src="{{ asset('assets') }}/js/edit-ticket-booking.js"></script>
    @endpush
@endsection
