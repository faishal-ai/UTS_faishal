<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar User',
            'list' => ['Data Master', 'User']
        ];

        $page = (object) [
            'title' => 'Daftar user yang terdaftar dalam sistem'
        ];

        $activeMenu = 'user';

        $user = Users::all();

        return view('user.index', compact('breadcrumb', 'page', 'activeMenu', 'user'));
    }

    public function data(Request $request)
    {
        $users = Users::all();

        return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('aksi', function ($user) {
                $btn = '<button onclick="modalAction(\'' . url('/user/' . $user->user_id .
                    '') . '\')" class="btn btn-outline-primary btn-sm"><i class="fa fa-eye"></i> Detail</button>  ';
                $btn .= '<button onclick="modalAction(\'' . url('/user/' . $user->user_id .
                    '/edit') . '\')" class="btn btn-outline-warning btn-sm"><i class="fa fa-edit"></i> Edit</button>  ';
                $btn .= '<button onclick="modalAction(\'' . url('/user/' . $user->user_id .
                    '/delete') . '\')" class="btn btn-outline-danger btn-sm"><i class="fa fa-trash"></i> Hapus</button>  ';

                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create()
    {
        return view('user.create');
    }

    public function store(Request $request)
    {

        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'name' => 'required|string|min:3',
                'email' => 'required|string|max:100|unique:users,email',
                'password' => 'required|min:5'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            $data = $request->all();
            $data['password'] = bcrypt($request->password);

            Users::create($data);

            return response()->json([
                'status' => true,
                'message' => 'Data user berhasil disimpan'
            ]);
        }

        return redirect('/');
    }

    public function show(string $id)
    {

        $user = Users::find($id);

        $breadcrumb = (object) [
            'title' => 'Detail User',
            'list' => ['Home', 'User', 'Detail']
        ];
        $page = (object) [
            'title' => 'Detail user'

        ];

        $activeMenu = 'user';

        return view('user.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'user' => $user, 'activeMenu' => $activeMenu]);
    }

    public function edit($id)
    {
        $user = Users::find($id);
        // dd($user);
        return view('user.edit', ['user' => $user]);
    }

    // Update data user
    public function update(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'email' => 'required|max:20|unique:users,email,' . $id . ',user_id',
                'name' => 'required|max:100',
                'password' => 'nullable|min:6|max:20'
            ];
            // use Illuminate\Support\Facades\Validator;
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false, // respon json, true: berhasil, false: gagal
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors() // menunjukkan field mana yang error
                ]);
            }
            $check = Users::find($id);
            if ($check) {
                if (!$request->filled('password')) { // jika password tidak diisi, maka hapus dari
                    $request->request->remove('password');
                }
                $check->update($request->all());
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diupdate'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/user');
    }

    public function confirm(string $id)
    {
        $user = Users::find($id);

        return view('user.confirm', ['user' => $user]);
    }

    public function delete(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $user = Users::find($id);
            if ($user) {
                $user->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil dihapus'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'

                ]);
            }
        }

        return redirect('/user');
    }
}
