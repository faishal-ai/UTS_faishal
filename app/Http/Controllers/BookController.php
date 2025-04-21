<?php

namespace App\Http\Controllers;

use App\Models\Books;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class BookController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Buku',
            'list' => ['Data Master', 'Buku']
        ];

        $page = (object) [
            'title' => 'Daftar buku yang tersedia dalam sistem'
        ];

        $activeMenu = 'books';

        $books = Books::all();

        return view('book.index', compact('breadcrumb', 'page', 'activeMenu', 'books'));
    }

    public function data(Request $request)
    {
        $books = Books::all();

        return DataTables::of($books)
            ->addIndexColumn()
            ->addColumn('aksi', function ($book) {
                $btn = '<button onclick="modalAction(\'' . url('/books/' . $book->book_id .
                    '') . '\')" class="btn btn-outline-primary btn-sm"><i class="fa fa-eye"></i> Detail</button>  ';
                $btn .= '<button onclick="modalAction(\'' . url('/books/' . $book->book_id .
                    '/edit') . '\')" class="btn btn-outline-warning btn-sm"><i class="fa fa-edit"></i> Edit</button>  ';
                $btn .= '<button onclick="modalAction(\'' . url('/books/' . $book->book_id .
                    '/delete') . '\')" class="btn btn-outline-danger btn-sm"><i class="fa fa-trash"></i> Hapus</button>  ';

                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create()
    {
        return view('book.create');
    }

    public function store(Request $request)
    {

        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'title' => 'required|string',
                'author' => 'required|string',
                'stock' => 'required'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            Books::create($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Data Buku berhasil disimpan'
            ]);
        }

        return redirect('/books');
    }

    public function show(string $id)
    {

        $book = Books::find($id);

        $breadcrumb = (object) [
            'title' => 'Detail Buku',
            'list' => ['Home', 'Books', 'Detail']
        ];
        $page = (object) [
            'title' => 'Detail book'

        ];

        $activeMenu = 'books';

        return view('book.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'book' => $book, 'activeMenu' => $activeMenu]);
    }

    public function edit($id)
    {
        $book = Books::find($id);
        // dd($book);
        return view('book.edit', ['book' => $book]);
    }

    public function update(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'title' => 'required|string',
                'author' => 'required|string',
                'stock' => 'required'
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false, 
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors() 
                ]);
            }

            $check = Books::find($id);

            if ($check) {
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
        return redirect('/');
    }

    public function confirm(string $id)
    {
        $book = Books::find($id);

        return view('book.confirm', ['book' => $book]);
    }

    public function delete(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $book = Books::find($id);
            if ($book) {
                $book->delete();
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
