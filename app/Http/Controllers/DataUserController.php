<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Session;

class DataUserController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = User::select('id', 'name', 'email', 'gender', 'role',)
                ->orderBy('name', 'asc');

            $data = $query->get()
                ->map(function ($data) {
                    return [
                        'id'          => $data->id,
                        'name'        => $data->name,
                        'email'       => $data->email,
                        'gender'      => $data->gender,
                        'role'        => $data->role,
                    ];
                });

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('opsi', function ($row) {
                    $actionBtn = '<a class="btn btn-light text-danger btn-sm" onclick="deleteData(\'' . $row['id'] . '\', $(this).closest(\'tr\').find(\'td:eq(1)\').text())"> <i class="fa-regular fa-trash-can"></i></a>';
                    // $actionBtn .= '<a class="btn btn-light text-dark btn-sm" href="/pimpinan/data-karyawan-edit/' . $row['id'] . '"><i class="fa-solid fa-pen-to-square"></i></a>';
                    return $actionBtn;
                })
                ->rawColumns(['opsi'])
                ->make(true);
        }
        return view('pimpinan.karyawan.data_user');
    }

    public function store(Request $request)
    {
        $save_data = User::create([
            'name'       => request('name'),
            'email'      => request('email'),
            'password'   => bcrypt(request('password')),
            'gender'     => request('gender'),
            'role'       => request('role'),
        ]);

        if ($save_data) {
            return redirect('pimpinan/data-user');
        }
    }

    public function destroy($id)
    {
        $delete = User::findOrFail($id);
        $delete->delete();

        if ($delete) {
            return response()->json(['sukses' => 'Data Berhasil dihapus']);
        } else {
            return response()->json(['Gagal' => 'Terjadi kesalahan saat menghapus data'], 404);
        }
    }
}