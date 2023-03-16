@extends('layouts.master')
@section('title', ' Data Users')

@section('content')
    <div class="card text-white mb-4">
        <table class="table table-striped ml-2">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nim</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Program Studi</th>
                    <th scope="col">Hp</th>
                    <th scope="col">Opsi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row">1</th>
                    <td>1234567890</td>
                    <td>Eliaser randa</td>
                    <td>Teknik Informatika</td>
                    <td>0812 3033 2000</td>
                    <td>
                        <div class="btn btn-info py-1"><i class="fa-solid fa-circle-info"></i></div>
                        <div class="btn btn-primary py-1"><i class="fa-solid fa-pen-to-square"></i></div>
                        <div class="btn btn-danger py-1"><i class="fa-solid fa-trash-can"></i></div>
                </tr>
                <tr>
                    <th scope="row">2</th>
                    <td>1234567890</td>
                    <td>Eliaser randa</td>
                    <td>Teknik Informatika</td>
                    <td>0812 3033 2000</td>
                    <td>
                        <div class="btn btn-info py-1"><i class="fa-solid fa-circle-info"></i></i></div>
                        <div class="btn btn-primary py-1"><i class="fa-solid fa-pen-to-square"></i></div>
                        <div class="btn btn-danger py-1"><i class="fa-solid fa-trash-can"></i></div>
                    </td>
                </tr>

            </tbody>
        </table>
    </div>

@endsection
