<?php

namespace App\Http\Controllers;

use App\Models\Drivers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\DataTables;

class DriverController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $status = $request->input('filter');

            $query = Drivers::select('id', 'fullname', 'gender', 'driver_type', 'phone', 'entry_year', 'address', 'status')
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
                        'id'           => $data->id,
                        'fullname'     => $data->fullname,
                        'gender'       => $data->gender,
                        'driver_type'  => $data->driver_type,
                        'phone'        => $data->phone,
                        'entry_year'   => $data->entry_year,
                        'address'      => $data->address,
                        'status'       =>  $status,
                    ];
                });

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('opsi', function ($row) {
                    $actionBtn = '<a class="btn btn-light text-danger btn-icon btn-sm" onclick="deleteData(\'' . $row['id'] . '\', $(this).closest(\'tr\').find(\'td:eq(1)\').text())"> <i class="fa-regular fa-trash-can"></i></a>';
                    $actionBtn .= '<a class="btn btn-light text-dark btn-icon btn-sm" href="/pimpinan/driver-edit/' . $row['id'] . '"><i class="fa-solid fa-pen-to-square"></i></a>';
                    return $actionBtn;
                })
                ->rawColumns(['opsi', 'status'])
                ->make(true);
        }
        return view('pimpinan.driver.data_driver');
    }

    public function store(Request $request)
    {
        $driver = Drivers::create($request->all());
        if ($driver) {
            Session::flash('status', 'success');
            Session::flash('message', 'Data berhasil Ditambah!');
        }
        return redirect('pimpinan/data-driver');
    }

    public function add()
    {
        return view('pimpinan.driver.add_driver');
    }

    public function edit(Request $request, $id)
    {
        $driver = Drivers::findOrFail($id);

        return view('pimpinan.driver.edit_driver', ['dataDriver' => $driver]);
    }

    public function update(Request $request, $id)
    {
        $driver = Drivers::findOrFail($id);
        $driver->update($request->all());
        if ($driver) {
            Session::flash('status', 'success');
            Session::flash('message', 'Data berhasil Diupdate!');
        }
        return redirect('pimpinan/data-driver')->with('status', 'Data berhasil di update!');
    }

    public function delete($id)
    {
        $delete = Drivers::findOrFail($id);
        $delete->delete();

        if ($delete) {
            return response()->json(['sukses' => 'Data Berhasil dihapus']);
        } else {
            return response()->json(['Gagal' => 'Terjadi kesalahan saat menghapus data'], 404);
        }

        // return redirect('admin/data-driver');
    }
}
