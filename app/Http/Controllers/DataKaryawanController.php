<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\DataKaryawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\DataTables;

class DataKaryawanController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $status = $request->input('filter');

            $query = DataKaryawan::select('id', 'fullname', 'username', 'email', 'gender', 'phone', 'address', 'position', 'entry_year', 'status', 'images')
                ->orderBy('fullname', 'asc');
            if (isset($status)) {
                $query->where('status', $status);
            }
            $data = $query->get()
                ->map(function ($data) {
                    if ($data->status == 0) {
                        $status = '<span class="badge text-bg-danger">Tidak Aktif</span>';
                    } else {
                        $status = '<span class="badge text-bg-success">Aktif</span>';
                    }
                    return [
                        'id'          => $data->id,
                        'fullname'    => $data->fullname,
                        'username'    => $data->username,
                        'email'       => $data->email,
                        'gender'      => $data->gender,
                        'phone'       => $data->phone,
                        'address'     => $data->address,
                        'position'    => $data->position,
                        'entry_year'  => $data->entry_year,
                        'status'      => $status,
                        'images'      => $data->images,
                    ];
                });

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('opsi', function ($row) {
                    $actionBtn = '<a class="btn btn-light text-danger btn-sm" onclick="deleteData(\'' . $row['id'] . '\', $(this).closest(\'tr\').find(\'td:eq(1)\').text())"> <i class="fa-regular fa-trash-can"></i></a>';
                    $actionBtn .= '<a class="btn btn-light text-dark btn-sm" href="/pimpinan/data-karyawan-edit/' . $row['id'] . '"><i class="fa-solid fa-pen-to-square"></i></a>';
                    return $actionBtn;
                })
                ->rawColumns(['opsi', 'status'])
                ->make(true);
        }
        return view('pimpinan.karyawan.data_karyawan');
    }

    public function create()
    {
        return view('pimpinan.karyawan.add_data_karyawan');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $save_data = DataKaryawan::create($request->all());

        if ($save_data) {
            Session::flash('status', 'success');
        }
        return redirect('pimpinan/data-karyawan');
    }

    /**
     * Display the specified resource.
     */
    public function show(DataKaryawan $dataKaryawan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $karyawan = DataKaryawan::findOrFail($id);
        return view('pimpinan.karyawan.edit_data_karyawan', ['ListData' => $karyawan]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DataKaryawan $dataKaryawan, $id)
    {
        $update = DataKaryawan::findOrFail($id);

        $update->update($request->all());

        if ($update) {
            Session::flash('status', 'success');
        } else {
            Session::flash('error', 'error');
        }

        return redirect('pimpinan/data-karyawan');
    }

    /**
     * Remove the specified resource from storage. 
     */
    public function destroy(DataKaryawan $dataKaryawan, $id)
    {
        $delete = DataKaryawan::findOrFail($id);
        $delete->delete();

        if ($delete) {
            return response()->json(['sukses' => 'Data Berhasil dihapus']);
        } else {
            return response()->json(['Gagal' => 'Terjadi kesalahan saat menghapus data'], 404);
        }
    }
}