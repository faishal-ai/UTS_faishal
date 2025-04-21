<?php

namespace App\Http\Controllers;

use App\Models\Rentals;
use App\Models\Books;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class RentalController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Peminjaman',
            'list' => ['Data Master', 'Peminjaman']
        ];

        $page = (object) [
            'title' => 'Daftar data peminjaman buku'
        ];

        $activeMenu = 'rentals';

        $rentals = Rentals::all();

        return view('rental.index', compact('breadcrumb', 'page', 'activeMenu', 'rentals'));
    }

    public function data(Request $request)
    {
        $rentals = Rentals::with('books', 'user')->get();

        return DataTables::of($rentals)
            ->addIndexColumn()
            ->addColumn('aksi', function ($rental) {
                $btn = '<button onclick="modalAction(\'' . url('/rentals/' . $rental->rentals_id) . '\')" class="btn btn-outline-primary btn-sm"><i class="fa fa-eye"></i> Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/rentals/' . $rental->rentals_id . '/edit') . '\')" class="btn btn-outline-warning btn-sm"><i class="fa fa-edit"></i> Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/rentals/' . $rental->rentals_id . '/delete') . '\')" class="btn btn-outline-danger btn-sm"><i class="fa fa-trash"></i> Hapus</button>';

                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create()
    {
        $books = Books::all();
        $user = Users::all();
        return view('rental.create', compact('books', 'user'));
    }

    public function store(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'user_id' => 'required',
                'book_id' => 'required',
                'nama_penyewa' => 'required',
                'rental_date' => 'required|date',
                'return_date' => 'required|date|after_or_equal:rental_date',
                'status' => 'required|string'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            Rentals::create($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Data peminjaman berhasil disimpan'
            ]);
        }

        return redirect('/rentals');
    }

    public function show($id)
    {
        $rental = Rentals::with('books', 'user')->find($id);

        $breadcrumb = (object) [
            'title' => 'Detail Peminjaman',
            'list' => ['Home', 'Rentals', 'Detail']
        ];
        $page = (object) [
            'title' => 'Detail rental'
        ];

        $activeMenu = 'rentals';

        return view('rental.show', compact('breadcrumb', 'page', 'rental', 'activeMenu'));
    }

    public function edit($id)
{
    $rental = Rentals::find($id);
    $books = Books::all();
    $users = Users::all();
    return view('rental.edit', compact('rental', 'books', 'users'));
}

public function update(Request $request, $id)
{
    if ($request->ajax() || $request->wantsJson()) {
        $rules = [
            'nama_penyewa' => 'required|string|min:3|max:100',
            'book_id' => 'required',
            'rental_date' => 'required|date',
            'return_date' => 'required|date|after_or_equal:rental_date',
            'user_id' => 'required',
            'status' => 'required|string'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal.',
                'msgField' => $validator->errors()
            ]);
        }

        $rental = Rentals::find($id);

        if ($rental) {
            $rental->update([
                'nama_penyewa' => $request->nama_penyewa,
                'book_id' => $request->book_id,
                'rental_date' => $request->rental_date,
                'return_date' => $request->return_date,
                'user_id' => $request->user_id,
                'status' => $request->status,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Data peminjaman berhasil diperbarui.'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan.'
            ]);
        }
    }

    return redirect('/rentals');
}


    public function confirm($id)
    {
        $rental = Rentals::find($id);
        return view('rental.confirm', compact('rental'));
    }

    public function delete(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rental = Rentals::find($id);
            if ($rental) {
                $rental->delete();
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

        return redirect('/');
    }
}
