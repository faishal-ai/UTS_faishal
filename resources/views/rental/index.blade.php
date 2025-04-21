@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools">
            <button onclick="modalAction('{{ url('rentals/create') }}')" class="btn btn-sm btn-info mt-1">Tambah</button>
        </div>
    </div>
    <div class="card-body">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <table class="table table-bordered table-striped table-hover table-sm" id="table-rentals">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Penyewa</th>
                    <th>Book</th>
                    <th>Rental Date</th>
                    <th>Return Date</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
<div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static"
    data-keyboard="false" data-width="75%" aria-hidden="true"></div>
@endsection

@push('js')
<script>
    function modalAction(url = '') {
        $('#myModal').load(url, function() {
            $('#myModal').modal('show');
        });
    }

    var dataRentals;
    $(document).ready(function() {
        dataRentals = $('#table-rentals').DataTable({
            serverSide: true,
            ajax: {
                'url': "{{ url('rentals/data') }}",
                'dataType': "json",
                'type': "GET",
            },
            columns: [
                { data: 'DT_RowIndex', className: 'text-center', orderable: false, searchable: false },
                { data: 'nama_penyewa', className: '', orderable: true, searchable: true },
                { data: 'books.title', className: '', orderable: true, searchable: true },
                { data: 'rental_date', className: '', orderable: true, searchable: true },
                { data: 'return_date', className: '', orderable: true, searchable: true },
                { data: 'status', className: '', orderable: true, searchable: true },
                { data: 'aksi', className: '', orderable: false, searchable: false }
            ]
        });
    });
</script>
@endpush
