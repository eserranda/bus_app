@extends('layouts.master')

@section('content')
    <div class="row">
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

    <div class="row">
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
                pointer-events: none;
            }

            .dipilih {
                background-color: green;
                pointer-events: none;
            }

            .pilih {
                align-item: center;
            }
        </style>

        <div class="row mb-5">
            <div class="text-center mb-4">
                <h2>Real Live Monitoring</h2>
                <p class="fw-bold">12 Juni 2023</p>
            </div>

            <div class="col-xl-3 col-md-6">
                <p class="text-center fw-bold mt-4 mb-1">Toraja - Makassar</p>
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


            <div class="col-xl-3 col-md-6">
                <p class="text-center fw-bold mt-4 mb-1">Palopo - Makassar</p>
                <h5 class="text-center fw-bold mt-0">SLEEPER</h5>
                <div class="card">
                    <div class="card-body">
                        <div class="bis">
                            <p class="fw-bold">Depan</p>
                            <div class="baris">
                                <div class="pintu-driver">Pintu</div>
                                <div class="kursi lorong"></div>
                                <div class="kursi-driver"><i class="fa-solid fa-dharmachakra"></i></div>
                            </div>
                            <div class="baris">
                                <div class="kursi terisi">1</div>
                                <div class="kursi terisi">2</div>
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
                                <div class="jalan">Pintu</div>
                                <div class="kursi lorong"></div>
                                <div class="kursi">11</div>
                                <div class="kursi">12</div>
                            </div>
                            <div class="baris">

                                <div class="kursi terisi">9</div>
                                <div class="kursi">10</div>
                                <div class="kursi lorong"></div>
                                <div class="kursi">19</div>
                                <div class="kursi">20</div>
                            </div>
                            <div class="baris">
                                <div class="kursi">21</div>
                                <div class="kursi">22</div>
                                <div class="kursi lorong"></div>
                                <div class="kursi terisi">23</div>
                                <div class="kursi terisi">24</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <p class="text-center mt-4 fw-bold">Makassar - Palopo</p>
                <div class="card">
                    <div class="card-body">
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
                                <div class="kursi terisi">9</div>
                                <div class="kursi">10</div>
                                <div class="kursi lorong"></div>
                                <div class="kursi">11</div>
                                <div class="kursi">12</div>
                            </div>
                            <div class="baris">
                                <div class="jalan">Pintu</div>
                                <div class="kursi lorong"></div>
                                <div class="kursi">19</div>
                                <div class="kursi">20</div>
                            </div>
                            <div class="baris">
                                <div class="kursi">21</div>
                                <div class="kursi">22</div>
                                <div class="kursi lorong"></div>
                                <div class="kursi">23</div>
                                <div class="kursi">24</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <p class="text-center mt-4 fw-bold">Toraja - Makassar</p>
                <div class="card">
                    <div class="card-body">
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
                                <div class="kursi terisi">9</div>
                                <div class="kursi">10</div>
                                <div class="kursi lorong"></div>
                                <div class="kursi">11</div>
                                <div class="kursi">12</div>
                            </div>
                            <div class="baris">
                                <div class="jalan">Pintu</div>
                                <div class="kursi lorong"></div>
                                <div class="kursi">19</div>
                                <div class="kursi">20</div>
                            </div>
                            <div class="baris">
                                <div class="kursi">21</div>
                                <div class="kursi">22</div>
                                <div class="kursi lorong"></div>
                                <div class="kursi">23</div>
                                <div class="kursi">24</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>





    <script>
        function sendValue(value) {
            document.getElementById("kursi").value = value;
            alert(value)
        }

        let kursi = document.querySelectorAll('.kursi');
        // const defaultColor = kursi.style.backgroundColor;
        kursi.forEach(function(el) {
            el.addEventListener('click', function() {
                var spinner = document.createElement('i');
                el.classList.add('dipilih');
                el.textContent = "";
                spinner.classList.add('fa-solid', 'fa-spinner');
                el.appendChild(spinner);
            });
        });
    </script>
@endsection
