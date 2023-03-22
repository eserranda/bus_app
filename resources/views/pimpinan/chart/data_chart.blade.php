@extends('layouts.master')

{{-- @section('submenu', 'show') --}}

@section('content')
    <div class="row">
        <div class="col-xl-6 col-md-6">
            <div class="card  ">
                <div class="card-header">
                    Grafik Pemasukan dan Pengeluaran
                </div>
                <canvas class="m-3" id="myChart"></canvas>
            </div>
        </div>
        <div class="col-xl-6 col-md-6">
            <div class="card">
                <div class="card-header">
                    Grafik Pendapatan Bulanan
                </div>
                <canvas class="m-3" id="LineChart"></canvas>
            </div>
        </div>
    </div>

    @push('script')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <script>
            var chartData = {
                labels: [],
                datasets: [{
                    label: 'Pemasukan',
                    data: [],
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }, {
                    label: 'Pengeluaran',
                    data: [],
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }]
            };
            var myChart = null; // variabel myChart didefinisikan dengan nilai awal null

            $(document).ready(function() {
                $.ajax({
                    url: "/pimpinan/chartDataBar",
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        var pemasukan = data.pemasukan
                        var pengeluaran = data.pengeluaran

                        var ctx = document.getElementById('myChart').getContext('2d');

                        pemasukan.forEach(function(item) {
                            const tanggal = new Date(item.year + '-' + item.month + '-01');
                            const namaBulan = tanggal.toLocaleString('default', {
                                month: 'long'
                            });
                            chartData.labels.push(namaBulan + ' - ' + item.year);
                            chartData.datasets[0].data.push(item.total_credit);
                        });
                        // chartData.labels.push(item.month + ' - ' + item.year);
                        pengeluaran.forEach(function(item) {
                            chartData.datasets[1].data.push(item.total_debet);
                        });

                        myChart = new Chart(ctx, {
                            type: 'bar',
                            data: chartData,
                            debug: true,
                            options: {
                                responsive: true,
                                scales: {
                                    yAxes: [{
                                        ticks: {
                                            beginAtZero: true
                                        }
                                    }]
                                }
                            }
                        });
                        myChart.update(); // panggil myChart.update() setelah melakukan pembaruan data
                    }
                });
            });

            setInterval(fetchData, 5000); // mengambil data setiap 5 detik

            function fetchData() {
                $.ajax({
                    url: "/pimpinan/chartDataBar",
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        var pemasukan = data.pemasukan
                        var pengeluaran = data.pengeluaran

                        chartData.labels = [];
                        chartData.datasets[0].data = [];
                        chartData.datasets[1].data = [];

                        pemasukan.forEach(function(item) {
                            const tanggal = new Date(item.year + '-' + item.month + '-01');
                            const namaBulan = tanggal.toLocaleString('default', {
                                month: 'long'
                            });
                            chartData.labels.push(namaBulan + ' - ' + item.year);
                            chartData.datasets[0].data.push(item.total_credit);
                        });
                        pengeluaran.forEach(function(item) {
                            chartData.datasets[1].data.push(item.total_debet);
                        });
                        myChart.update(); // panggil fungsi update pada objek chart
                    }
                });
            }

            var chartDataLine = {
                labels: [],
                datasets: [{
                    label: 'Pendapatan Bulanan',
                    data: [],
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            };

            var myChartLine = null;

            $(document).ready(function() {
                $.ajax({
                    url: "/pimpinan/chartDataLine",
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        var penghasilan = data.chartData;

                        var ctx = document.getElementById('LineChart').getContext('2d');

                        penghasilan.forEach(function(item) {
                            const tanggal = new Date(item.tahun + '-' + item.bulan +
                                '-01');
                            const namaBulan = tanggal.toLocaleString('default', {
                                month: 'long'
                            });
                            chartDataLine.labels.push(namaBulan + ' - ' + item.tahun);
                            chartDataLine.datasets[0].data.push(item.keuntungan);
                        });

                        myChartLine = new Chart(ctx, {
                            type: 'line',
                            data: chartDataLine,
                            debug: true,
                            options: {
                                responsive: true,
                                scales: {
                                    yAxes: [{
                                        ticks: {
                                            beginAtZero: true
                                        }
                                    }]
                                }
                            }
                        });

                        myChartLine.update();
                    }
                });
            });

            setInterval(fetchDataLine, 2000); // mengambil data setiap 5 detik

            function fetchDataLine() {
                $.ajax({
                    url: "/pimpinan/chartDataLine",
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        var penghasilan = data.chartData;

                        chartDataLine.labels = [];
                        chartDataLine.datasets.data = []

                        penghasilan.forEach(function(item) {
                            const tanggal = new Date(item.tahun + '-' + item.bulan +
                                '-01');
                            const namaBulan = tanggal.toLocaleString('default', {
                                month: 'long'
                            });
                            chartDataLine.labels.push(namaBulan + ' - ' + item.tahun);
                            chartDataLine.datasets[0].data.push(item.keuntungan);
                        });
                        myChartLine.update(); // panggil myChart.update() setelah melakukan pembaruan data
                    }
                });
            }
        </script>
    @endpush
@endsection
