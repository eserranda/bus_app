<script>
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


    var myChartLine = null; // variabel myChart didefinisikan dengan nilai awal null

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

                var myChartLine = new Chart(ctx, {
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
                myChartLine.update(); // panggil myChart.update() setelah melakukan pembaruan data
            }
        });
    });

    setInterval(fetchDataLine, 5000); // mengambil data setiap 5 detik

    function fetchDataLine() {
        $.ajax({
            url: "/pimpinan/chartDataLine",
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                var penghasilan = data.chartData;

                chartDataLine.labels = [];
                chartDataLine.datasets[0].data = [];


                pemasukan.forEach(function(item) {
                    const tanggal = new Date(item.year + '-' + item.month + '-01');
                    const namaBulan = tanggal.toLocaleString('default', {
                        month: 'long'
                    });
                    chartDataLine.labels.push(namaBulan + ' - ' + item.year);
                    chartDataLine.datasets[0].data.push(item.total_credit);
                });

                pengeluaran.forEach(function(item) {
                    chartDataLine.datasets[1].data.push(item.total_debet);
                });

                myChartLine.update(); // panggil myChart.update() setelah melakukan pembaruan data
            }
        });
    }
</script>
