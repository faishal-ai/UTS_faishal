<form action="{{ url('/rentals/create') }}" method="POST" id="form-tambah-rental">
    @csrf
    <div id="modal-rental" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title">Tambah Data Rental</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="card m-4 p-2 bg-light">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Nama Penyewa</label>
                                    <input type="text" name="nama_penyewa" id="nama_penyewa" class="form-control"
                                        required>
                                    <small id="error-nama_penyewa" class="error-text form-text text-danger"></small>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Nama Buku</label>
                                    <select name="book_id" id="book_id" class="form-control" required>
                                        <option value="">Pilih Buku</option>
                                        @foreach ($books as $book)
                                            <option value="{{ $book->book_id }}">{{ $book->title }}</option>
                                        @endforeach
                                    </select>
                                    <small id="error-book_id" class="error-text form-text text-danger"></small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Tanggal Pinjam</label>
                                    <input type="date" name="rental_date" id="rental_date" class="form-control"
                                        required>
                                    <small id="error-rental_date" class="error-text form-text text-danger"></small>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Tanggal Kembali</label>
                                    <input type="date" name="return_date" id="return_date" class="form-control"
                                        required>
                                    <small id="error-return_date" class="error-text form-text text-danger"></small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>User</label>
                                    <select name="user_id" id="user_id" class="form-control" required>
                                        <option value="">- Pilih User -</option>
                                        @foreach ($user as $l)
                                            <option value="{{ $l->user_id }}">{{ $l->name }}</option>
                                        @endforeach
                                    </select>
                                    <small id="error-user_id" class="error-text form-text text-danger"></small>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Keterangan</label>
                                    <select name="status" id="status" class="form-control" required>
                                        <option value="">- Pilih User -</option>
                                        <option value="dipinjam">Dipinjam</option>
                                        <option value="dikembalikan">Dikembalikan</option>
                                    </select>
                                    <small id="error-status" class="error-text form-text text-danger"></small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
    </div>
</form>

<script>
    $(document).ready(function() {
        $("#form-tambah-rental").validate({
            rules: {
                nama_penyewa: {
                    required: true,
                    minlength: 3,
                    maxlength: 100,
                },
                book_id: {
                    required: true,
                },
                rental_date: { 
                    required: true,
                    date: true,
                },
                return_date: { 
                    required: true,
                    date: true,
                },
                user_id: {
                    required: true,
                },
                status: {
                    required: true,
                }
            },

            submitHandler: function(form) {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    success: function(response) {
                        if (response.status) {
                            $('#myModal').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message
                            });
                            dataRentals.ajax.reload();
                        } else {
                            $('.error-text').text('');
                            $.each(response.msgField, function(prefix, val) {
                                $('#error-' + prefix).text(val[0]);
                            });
                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadi Kesalahan',
                                text: response.message
                            });
                        }
                    }
                });
                return false;
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
    });
</script>
