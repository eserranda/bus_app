<!-- @extends('layouts.master')
@section('title', ' Data Chart')
{{-- @section('submenu', 'show') --}}

@section('content')

    <div class="card col-md-6">
        <div class="card-header">
            Grafik Pemasukan dan Pengeluaran
        </div>

        <canvas id="myChart"></canvas>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    {{-- <script>
        var ctx = document.getElementById('myChart').getContext('2d');
        var pemasukan = @json($pemasukan);
        var pengeluaran = @json($pengeluaran);

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

        pemasukan.forEach(function(item) {
            chartData.labels.push(item.year + '-' + item.month);
            chartData.datasets[0].data.push(item.total_credit);
        });

        pengeluaran.forEach(function(item) {
            chartData.datasets[1].data.push(item.total_debit);
        });

        var myChart = new Chart(ctx, {
            type: 'bar',
            data: chartData,
            options: {
                responsive: false,
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    </script> --}}



    <script>
        $(document).ready(function() {
            $.ajax({
                url: "/pimpinan/chartDataBar",
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    // console.log(data.pemasukan)
                    // console.log(data.pengeluaran)
                    console.log(data.Pendaptan_bulanan)

                    var pemasukan = data.pemasukan
                    var pengeluaran = data.pengeluaran

                    var ctx = document.getElementById('myChart').getContext('2d');
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

                    var myChart = new Chart(ctx, {
                        type: 'bar',
                        data: chartData,
                        debug: true,
                        options: {
                            responsive: true,
                            // scales: {
                            //     yAxes: [{
                            //         ticks: {
                            //             beginAtZero: false
                            //         }
                            //     }]
                            // }
                        }
                    });

                }
            });
        });
    </script>

@endsection -->

@extends('layouts.master')
@section('title', ' Data Chart')
{{-- @section('submenu', 'show') --}}

@section('content')
<div class="row">
    <div class="col-xl-6 col-md-6">
        <div class="card  ">
            <div class="card-header">
                Grafik Pemasukan dan Pengeluaran
            </div>
            <canvas id="myChart"></canvas>
        </div>
    </div>
    <div class="col-xl-6 col-md-6">
        <div class="card ">
            <div class="card-header">
                Grafik Line Pendapatan Bulanan
            </div>
            <canvas id="LineChart"></canvas>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
function fetchData() {
    $.ajax({
        url: "/pimpinan/chartDataBar",
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            var pemasukan = data.pemasukan
            var pengeluaran = data.pengeluaran
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
            myChart.update();
        }
    });
}
setInterval(fetchData, 5000); // mengambil data setiap 5 detik

$(document).ready(function() {
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

    $.ajax({
        url: "/pimpinan/chartDataBar",
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            var pemasukan = data.pemasukan
            var pengeluaran = data.pengeluaran

            var ctx = document.getElementById('myChart').getContext('2d');

            // var chartData = {
            //     labels: [],
            //     datasets: [{
            //         label: 'Pemasukan',
            //         data: [],
            //         backgroundColor: 'rgba(75, 192, 192, 0.2)',
            //         borderColor: 'rgba(75, 192, 192, 1)',
            //         borderWidth: 1
            //     }, {
            //         label: 'Pengeluaran',
            //         data: [],
            //         backgroundColor: 'rgba(255, 99, 132, 0.2)',
            //         borderColor: 'rgba(255, 99, 132, 1)',
            //         borderWidth: 1
            //     }]
            // };

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

            var myChart = new Chart(ctx, {
                type: 'bar',
                data: chartData,
                debug: true,
                options: {
                    responsive: true,
                    // scales: {
                    // yAxes: [{
                    //     ticks: {
                    //         beginAtZero: true
                    //     }
                    // }]
                    // }
                }
            });
        }

    });



    $.ajax({
        url: "/pimpinan/chartDataLine",
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            var chartDataLineer = data.chartData;
            // console.log(data.chartData)
            var ctx = document.getElementById('LineChart').getContext('2d');
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

            chartDataLineer.forEach(function(item) {
                const tanggal = new Date(item.tahun + '-' + item.bulan + '-01');
                const namaBulan = tanggal.toLocaleString('default', {
                    month: 'long'
                });
                chartDataLine.labels.push(namaBulan + ' - ' + item.tahun);
                chartDataLine.datasets[0].data.push(item.keuntungan);
            });

            var myChart = new Chart(ctx, {
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
        }
    });

});


function fetchData() {
    $.ajax({
        url: "/pimpinan/chartDataBar",
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            var pemasukan = data.pemasukan
            var pengeluaran = data.pengeluaran
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
            myChart.update();
        }
    });
}
setInterval(fetchData, 5000); // mengambil data setiap 5 detik
</script>

@endsection

<script>
// $.ajax({
//     url: "/pimpinan/chartDataLine",
//     type: 'GET',
//     dataType: 'json',
//     success: function(data) {
//         var chartData = data.chartData;
//         // console.log(data.chartData)
//         var labels = Object.keys(chartData).map(function(key) {
//             var parts = key.split('-');
//             var year = parts[0];
//             var month = parts[1];
//             return month + '/' + year;
//         });
//         var keuntungan = Object.values(chartData);

//         var ctx = document.getElementById('LineChart').getContext('2d');
//         var myChart = new Chart(ctx, {
//             type: 'line',
//             data: {
//                 labels: labels,
//                 datasets: [{
//                     label: 'Grafik persentase pendapatan Bulanan',
//                     data: keuntungan,
//                     borderColor: 'rgba(255, 99, 132, 1)',
//                     borderWidth: 1,
//                     fill: false
//                 }]
//             },
//             options: {
//                 responsive: true,
//                 // scales: {
//                 //     yAxes: [{
//                 //         ticks: {
//                 //             beginAtZero: true
//                 //         }
//                 //     }]
//                 // }
//             }
//         });
//     }

// });
</script>



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
</script>