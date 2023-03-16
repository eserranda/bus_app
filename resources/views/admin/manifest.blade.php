<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Manifest PO. Sinar Muda Makassar</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>

<body class="sb-nav-fixed ">
    <div class="container px-4">
        <h1 class="text-center fw-normal display-5 mb-0">PO. Sinar Muda Makassar</h1>
        <p class="text-center fw-bold mb-0 mt-0" style="font-size: 35px">{{ $rute['from_city'] }} -
            {{ $rute['to_city'] }}
        </p>
        <p class="text-center fw-normal mb-0 mt-0 " style="font-size: 25px">
            {{ $rute['day_name'] }}, {{ $rute['date'] }} / {{ $rute['time'] }} WITA
        </p>
        <div class="d-flex align-items-center my-1 col-md-12">
            <input class="form-control" value="Armada Bus : {{ $rute['bus'] }} | {{ $rute['plat'] }}">
            <label class="me-3"></label>
            <input class="form-control" value="Total Penumpang : {{ $rute['total_passenger'] }} Orang">
        </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama Penumpang</th>
                    <th>Nomor Telepon</th>
                    <th>Kursi</th>
                    <th>Alamat Penjemputan</th>
                    <th class="text-center">Check</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $key => $row)
                    <tr>
                        <td>{{ $row['customer_name'] }}</td>
                        <td>{{ $row['customers_phone_number'] }}</td>
                        <td>{{ $row['seats_number'] }}</td>
                        <td>{{ $row['customers_address'] }}</td>
                        <td class="text-center"><input type="checkbox"></td>
                    </tr>
                    @if ($key == 20 && count($data) > 20)
                        @php
                            $remaining_rows = 5 - ($key - 20 + 1);
                        @endphp
                        @for ($i = 0; $i < $remaining_rows; $i++)
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td class="text-center"><input type="checkbox"></td>
                            </tr>
                        @endfor
                    @break
                @endif
            @endforeach

        </tbody>

    </table>
</div>

<script>
    $(document).ready(function() {
        window.print();
    });
</script>
</body>

</html>
