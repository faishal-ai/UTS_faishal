@empty($book)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Kesalahan</h5>

                <button type="button" class="close" data-dismiss="modal" aria- label="Close"><span
                        aria-hidden="true">&times;</span></button>

            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                    Data yang anda cari tidak ditemukan
                </div>
                <a href="{{ url('/books') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Data Buku</h5>

                <button type="button" class="close" data-dismiss="modal" aria- label="Close"><span
                        aria-hidden="true">&times;</span></button>

            </div>
            <div class="modal-body">
                <table class="table table-sm table-bordered table-striped w-100">
                    <tr>
                        <th class="text-right col-3">Title</th>
                        <td>:</td>
                        <td class="col-9">{{ $book->title }}</td>
                    </tr>

                    <tr>
                        <th class="text-right col-3">Author</th>
                        <td>:</td>
                        <td class="col-9">{{ $book->author }}</td>
                    </tr>

                    <tr>
                        <th class="text-right col-3">Stock</th>
                        <td>:</td>
                        <td class="col-9">{{ $book->stock }}</td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">

                <button type="button" data-dismiss="modal" class="btn btn-warning">Tutup</button>
            </div>
        </div>
    </div>
@endempty
