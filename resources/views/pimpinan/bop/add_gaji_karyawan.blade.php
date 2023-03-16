@extends('layouts.master')
@section('title', 'Gaji Karyawan')
@section('submenu', 'show')

@section('content')

    <div class="col-xl-8 col-md-12">
        <div class="card">
            <form action="/pimpinan/gaji-karyawan-save" class="row g-2 m-2" method="POST">
                @csrf
                <div class="col-md-6">
                    <label for="date" class="form-label">Tanggal<span class="text-danger">*</span></label>
                    <input type="date" class="form-control" id="date" name="date" placeholder="Jenis Bus"
                        required>
                </div>

                <div class="col-md-6">
                    <label for="id_karyawan" class="form-label">Nama<span class="text-danger">*</span></label>
                    <select class="form-select" name="id_karyawan" id="id_karyawan" required>
                        <option value="" selected disabled>Pilih Nama Karyawan</option>
                        @foreach ($ListKaryawan as $row)
                            <option value="{{ $row->id }}">{{ $row->fullname }} ({{ $row->position }}) </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="month" class="form-label">Gaji Bulan<span class="text-danger">*</span></label>
                    <input type="month" class="form-control" id="month" name="month"
                        placeholder="Jumlah liter yang di beli" required>
                </div>


                <div class="col-md-6">
                    <label for="gaji_pokok" class="form-label">Gaji Pokok<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="gaji_pokok" name="gaji_pokok" placeholder="Gaji Pokok">
                </div>

                <div class="col-md-6">
                    <label for="bonus" class="form-label">Bonus</label>
                    <input type="text" class="form-control" id="bonus" name="bonus" placeholder="Bonus">
                </div>

                <div class="col-md-6">
                    <label for="potongan" class="form-label">Potongan</label>
                    <input type="text" class="form-control" id="potongan" name="potongan" placeholder="Potongan">
                </div>

                <div class="col-md-6">
                    <label for="total_gaji" class="form-label">Total Gaji<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="total_gaji" name="total_gaji" placeholder="Total Gaji"
                        required readonly>
                </div>

                <div class="col-12 mt-3">
                    <button type="submit" class="btn btn-primary mb-1 save" id="save">
                        <i class="fa-solid fa-floppy-disk"></i> Simpan</button>
                    <a href="/pimpinan/gaji-karyawan" class="btn btn-warning mb-1"><i class="fa-solid fa-angles-left"></i>
                        Kembali</a>
                </div>
            </form>

        </div>
    </div>


    <script>
        function formatRupiah(angka) {
            var isNegative = false;
            if (angka < 0) {
                isNegative = true;
                angka = Math.abs(angka);
            }

            var number_string = angka.toString().replace(/[^,\d]/g, ''),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;

            if (isNegative) {
                rupiah = '-' + rupiah;
            }

            return rupiah;
        }


        $(document).ready(function(e) {
            // fungsi untuk menghapus semua karakter selain angka
            function removeNonNumeric(str) {
                return str.replace(/\D/g, '');
            }

            // mendefinisikan variabel-variabel yang diperlukan
            var gaji_pokok = 0;
            var bonus = 0;
            var potongan = 0;

            // mengambil input dari pengguna dan memprosesnya
            $('#gaji_pokok').on('input', function() {
                var value = removeNonNumeric($(this).val());
                gaji_pokok = parseInt(value);
                $(this).val(formatRupiah(value));
                updateTotalGaji();
            });

            $('#bonus').on('input', function() {
                var value = removeNonNumeric($(this).val());
                bonus = parseInt(value);
                $(this).val(formatRupiah(value));
                updateTotalGaji();
            });

            $('#potongan').on('input', function() {
                var value = removeNonNumeric($(this).val());
                potongan = parseInt(value);
                $(this).val(formatRupiah(value));
                updateTotalGaji();
            });

            // memperbarui nilai total gaji
            function updateTotalGaji() {
                var total_gaji = gaji_pokok + bonus - potongan;
                $('#total_gaji').val(formatRupiah(total_gaji.toString()));
            }

            $('#save').click(function() {
                $('input[type="text"]').each(function() {
                    var value = $(this).val().replace(/[^\d-]/g, '');
                    $(this).val(value);
                });
            });

            // $('#save').click(function() {
            //     var gaji_pokok = $('#gaji_pokok').val();
            //     var bonus = $('#bonus').val();
            //     var potongan = $('#potongan').val();
            //     var total = $('#total_gaji').val();
            //     var numeric_gaji_pokok = gaji_pokok.replace(/\D/g, '');
            //     var numeric_bonus = bonus.replace(/\D/g, '');
            //     var numeric_potongan = potongan.replace(/\D/g, '');
            //     var numeric_total = total.replace(/[^\d-]/g, '');
            //     $('#gaji_pokok').val(numeric_gaji_pokok);
            //     $('#bonus').val(numeric_bonus);
            //     $('#potongan').val(numeric_potongan);
            //     $('#total_gaji').val(numeric_total);
            // });
        });
    </script>
@endsection
