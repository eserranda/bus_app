@extends('layouts.master')

@section('content')
    <style>
        .card {
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 2px 2px rgba(0, 0, 0, 0.2);
        }


        .bis {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            margin-right: 90px */
        }

        .baris {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 20px;
        }

        .kursi-driver {
            width: 50px;
            height: 30px;
            border-radius: 10%;
            background-color: #eee;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-left: 20px;
            margin-right: 20px;
            cursor: pointer;
            font-size: 12px;
            pointer-events: none;
        }

        .pintu-driver {
            width: 70px;
            height: 30px;
            border-radius: 10%;
            background-color: #444040;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-right: 10px;
            margin-left: 10px;
            cursor: pointer;
            font-size: 12px;
            color: rgb(76, 220, 211);
            pointer-events: none;
        }

        .jalan {
            width: 70px;
            height: 30px;
            border-radius: 10%;
            background-color: #444040;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-right: 10px;
            cursor: pointer;
            font-size: 12px;
            color: rgb(76, 220, 211);
            pointer-events: none;
        }

        .kursi {
            width: 30px;
            height: 30px;
            border-radius: 10%;
            background-color: #eee;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-right: 10px;
            cursor: pointer;
            font-size: 12px;
        }

        .kursi:hover {
            background-color: #aaa;
        }

        .lorong {
            visibility: hidden;
            pointer-events: none;
        }

        .terisi {
            background-color: rgb(230, 133, 133);
            /* pointer-events: none; */
            cursor: not-allowed;
        }

        .dipilih {
            background-color: green;
            pointer-events: none;
        }

        .kursi.selected {
            background-color: green;
        }
    </style>

    <div class="card mb-4">
        <div class="row m-3 lg-mb-5">
            <div class="col-sm">
                <h5 class="mt-2">Kota Asal</h5>
                <select class="form-select" id="autoSizingSelect" name="driver" required>
                    <option value="">Pilih Kota</option>
                    <option value="Laki-laki">Makassar</option>
                    <option value="perempuan">Toraja</option>
                    <option value="perempuan">Malili</option>
                </select>
            </div>

            <div class="col-sm">
                <h5 class="mt-2">Kota Tujuan</h5>
                <select class="form-select" id="autoSizingSelect" name="driver" required>
                    <option value="">Mau ke mana?</option>
                    <option value="Laki-laki">Toraja</option>
                    <option value="perempuan">Malili</option>
                    <option value="perempuan">Sorowako</option>
                </select>
            </div>
            <div class="col-sm">
                <h5 class="mt-2">Pergi</h5>
                <input type="date" class="form-control" aria-label="State">
            </div>
            <div class="col-sm">
                <h5 class="mt-2">Penumpang</h5>
                <input type="number" class="form-control" placeholder="Jumlah" aria-label="Zip">
            </div>
            <div class="col-sm m-lg-4 text-center">
                <button class="btn btn-info m-3 ">Cari Tiket</button>
            </div>
        </div>
    </div>


    <div class="row mb-5">
        <div class="col-xl-3 col-md-6">
            <p class="text-center fw-bold mb-1">Makassar - Toraja</p>
            <h5 class="text-center fw-bold mt-0">MERCY</h5>
            <div class="card">
                <form action="#" method="POST">
                    <div class="card-body text-center">
                        <div class="bis">
                            <p class="fw-bold">Depan</p>
                            <div class="baris">
                                <div class="pintu-driver">Pintu</div>
                                <div class="kursi lorong"></div>
                                <div class="kursi-driver"><i class="fa-solid fa-dharmachakra"></i></div>
                            </div>

                            <div class="baris">
                                <div class="kursi">1</div>
                                <div class="kursi">2</div>
                                <div class="kursi lorong"></div>
                                <div class="kursi">3</div>
                                <div class="kursi">4</div>
                            </div>
                            <div class="baris">
                                <div class="kursi">5</div>
                                <div class="kursi">6</div>
                                <div class="kursi lorong"></div>
                                <div class="kursi">7</div>
                                <div class="kursi">8</div>
                            </div>
                            <div class="baris">
                                <div class="kursi">9</div>
                                <div class="kursi">10</div>
                                <div class="kursi lorong"></div>
                                <div class="kursi">11</div>
                                <div class="kursi">12</div>
                            </div>
                            <div class="baris">
                                <div class="kursi terisi">13</div>
                                <div class="kursi">14</div>
                                <div class="kursi lorong"></div>
                                <div class="kursi">15</div>
                                <div class="kursi">16</div>
                            </div>
                            <div class="baris">
                                <div class="jalan">Pintu</div>
                                <div class="kursi lorong"></div>
                                <div class="kursi">17</div>
                                <div class="kursi">18</div>
                            </div>
                            <div class="baris">
                                <div class="kursi">19</div>
                                <div class="kursi">20</div>
                                <div class="kursi lorong"></div>
                                <div class="kursi">21</div>
                                <div class="kursi">22</div>
                            </div>
                        </div>

                        <button type="button" class="btn btn-primary pilih">Pilih</button>
                    </div>
                    {{-- <div class="card-footer text-center bg-light">
                        <button type="button" class="btn btn-primary pilih">Pilih</button>
                    </div> --}}
                </form>
            </div>
        </div>
    </div>

    {{-- <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body">Primary Card</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="#">View Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6">
            <div class="card bg-warning text-white mb-4">
                <div class="card-body">Warning Card</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="#">View Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6">
            <div class="card bg-success text-white mb-4">
                <div class="card-body">Success Card</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="#">View Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-danger text-white mb-4">
                <div class="card-body">Danger Card</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="#">View Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        swal("Selamat Datang!");
    </script> --}}


    <script>
        // Ambil semua elemen kursi menggunakan querySelectorAll
        var kursi = document.querySelectorAll('.kursi');

        // Loop melalui semua elemen kursi dan tambahkan event listener 'click' pada masing-masing elemen
        kursi.forEach(function(el) {
            el.addEventListener('click', function() {
                // Jika elemen memiliki class 'terisi', tidak melakukan apa-apa saat diklik
                if (el.classList.contains('terisi')) {
                    return;
                }

                // Jika elemen tidak memiliki class 'terisi', ubah warna latar belakang saat diklik
                if (el.classList.contains('selected')) {
                    el.classList.remove('selected');
                } else {
                    el.classList.add('selected');
                }
            });
        });
    </script>
@endsection
