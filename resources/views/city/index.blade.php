@extends('admin.layout')

@section('content')
<h3>Cities</h3>

@can('cities.create')
<a href="{{ route('admin.cities.create') }}"
   class="btn btn-primary mb-2">
    Add City
</a>
@endcan

<table class="table table-bordered" id="cities-table">
    <thead>
        <tr>
            <th>#</th>
            <th>City</th>
            <th>State</th>
            <th>Country</th>

            @canany(['cities.edit','cities.delete'])
                <th>Action</th>
            @endcanany
        </tr>
    </thead>
</table>
@endsection

@push('scripts')
<script>
$(function () {

    let table = $('#cities-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.cities.index') }}",

        dom: 'Bfrtip',
        buttons: [
            { extend:'csvHtml5', title:'Cities', className:'btn btn-secondary btn-sm' },
            { extend:'pdfHtml5', title:'Cities', className:'btn btn-danger btn-sm' }
        ],

        columns: [
            { data:'DT_RowIndex', orderable:false, searchable:false },
            { data:'name' },
            { data:'state' },
            { data:'country' },
            @canany(['cities.edit','cities.delete'])
            { data:'action', orderable:false, searchable:false }
            @endcanany
        ]
    });

    // 🔴 delete
    $(document).on('click','.delete-btn',function () {
        let form = $(this).closest('form');

        Swal.fire({
            title: 'Delete?',
            icon: 'warning',
            showCancelButton: true
        }).then(res=>{
            if(res.isConfirmed){
                $.post(form.attr('action'), form.serialize(), function(){
                    table.ajax.reload();
                });
            }
        });
    });

    // ♻ restore
    $(document).on('click','.restore-btn',function () {
        let id = $(this).data('id');

        Swal.fire({
            title: 'Restore?',
            icon: 'question',
            showCancelButton: true
        }).then(res=>{
            if(res.isConfirmed){
                $.post("{{ url('admin/cities') }}/"+id+"/restore", {
                    _token: "{{ csrf_token() }}"
                }, function(){
                    table.ajax.reload();
                });
            }
        });
    });

});
</script>
@endpush
