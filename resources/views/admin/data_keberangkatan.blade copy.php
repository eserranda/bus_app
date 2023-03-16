@extends('layouts.master')
@section('title', 'Keberangkatan')

@section('content')

    @if (Session::has('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ Session::get('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="my-1">
        <p>Data Keberangkatan <b>{{ $departure_date }}</b></p>
    </div>
    <div class="card mt-1" id="card_table">
        <div class="table-responsive m-1">
            <table class="table">

                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tanggal</th>
                        <th>Rute</th>
                        <th>Bus</th>
                        <th>Driver</th>
                        <th>Kondektur</th>
                        <th>Total Penumpang</th>
                        <th>Status</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($listKeberangkatan as $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $row->departure_date }}</td>
                            <td>{{ $row->from_city }} - {{ $row->to_city }}</td>
                            <td>{{ $row->bus->type }}</td>
                            <td>{{ $row->sopirUtama->fullname }} / {{ $row->sopirBantu->fullname }}</td>
                            <td>{{ $row->Kondektur->fullname }}</td>
                            <td class="text-center">{{ $row->total_passenger }} </td>
                            <td>
                                @if ($row->status == 1)
                                    <span class="badge text-bg-warning">Berangkat</span>
                                @elseif ($row->status == 3)
                                    <span class="badge text-bg-success"> Tiba di {{ $row->to_city }} </span>
                                @endif
                            </td>
                            <td>
                                @if ($row->status == 0)
                                    <a class="btn btn-info btn-sm  border-0"
                                        href="/admin/keberangkatan-setberangkat/{{ $row->id }}">Berangkat</a>
                                @elseif ($row->status == 1)
                                    <a class="btn border-0 btn-sm btn-primary"
                                        href="/admin/keberangkatan-rollback/{{ $row->id }}">
                                        <i class="fa-solid fa-arrow-rotate-left"></i></a>
                                @endif

                                <a class="btn border-0 btn-secondary btn-sm d-inline-block"
                                    onclick="printManifest('{{ $row->id }}')">
                                    <i class="fa-solid fa-print"></i> Manifest
                                </a>



                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>

    <style>
        .hidden {
            display: none;
        }

        @media print {
            body * {
                visibility: hidden;
            }

            .container {
                margin: 0;
                padding: 0;
            }

            #table-wrapper {
                width: 100%;
            }

            #data_manifest {

                width: 100%;
            }
        }


        #header,
        #footer,
        .no-print {
            display: none;
        }

        #data_manifest,
        #data_manifest * {
            visibility: visible;
        }
    </style>


    <table class="table table-bordered hidden" id="data_manifest">
        <thead>
            <tr>
                <th>Nama Penumpang</th>
                <th>Nomor Telepon</th>
                <th>Kursi</th>
                <th>Alamat Penjemputan</th>
                <th>Check</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>

    <script>
        function printManifest(id) {
            // Sembunyikan tabel terlebih dahulu
            // $('#data_manifest').css('display', 'none');

            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                type: "post",
                url: "/admin/keberangkatan-manifest/" + id,
                dataType: "json",

                success: function(data) {
                    var url =
                        "{{ route('admin.manifest', ['data' => '']) }}"; // ganti "admin.manifest" dengan nama route yang sesuai
                    url += encodeURIComponent(JSON.stringify(data
                        .data)); // encode data JSON dan tambahkan ke URL

                    window.open(url, '/admin/manifest'); // buka halaman baru dengan URL yang dibuat
                },

                // success: function(data) {
                //     console.log(data.data);
                //     for (var i = 0; i < data.data.length; i++) {
                //         var row = $("<tr>");
                //         row.append($("<td>").text(data.data[i].customer_name));
                //         row.append($("<td>").text(data.data[i].customers_phone_number));
                //         row.append($("<td>").text(data.data[i].seats_number));
                //         row.append($("<td>").text(data.data[i].customers_address));
                //         row.append($("<td>").append($('<input type="checkbox">')));
                //         tableBody.append(row);
                //     }
                // },
                error: function(xhr, ajaxOptions, thrownError) {
                    swal("Oops...", "Terjadi kesalahan saat mengupdate data!", "error");
                    console.log(
                        xhr.status + "\n" + xhr.responseText + "\n" + thrownError
                    );
                },
            });
        }
    </script>

    {{-- @push('script')
        <script src="{{ asset('assets') }}/js/print-manifest.js"></script>
    @endpush --}}
@endsection
