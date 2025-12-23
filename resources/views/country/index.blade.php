@extends('admin.layout')

@section('content')
<h3>Countries</h3>

@can('countries.create')
<a href="{{ route('admin.countries.create') }}"
   class="btn btn-primary mb-2">
    Add Country
</a>
@endcan

<table class="table table-bordered" id="countries-table">
    <thead>
        <tr>
            <th>Id</th>
            <th>Country</th>

            {{-- Action header --}}
            @canany(['countries.edit','countries.delete'])
                <th>Action</th>
            @endcanany
        </tr>
    </thead>
</table>
@endsection
@push('scripts')
<script>
$(function () {

    let table = $('#countries-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.countries.index') }}",

        dom: 'Bfrtip',
        buttons: [
            { extend:'csvHtml5', title:'Countries', className:'btn btn-secondary btn-sm' },
            { extend:'pdfHtml5', title:'Countries', className:'btn btn-danger btn-sm' }
        ],

        columns: [
            { data:'DT_RowIndex', orderable:false, searchable:false },
            { data:'name' },
            @canany(['countries.edit','countries.delete'])
            { data:'action', orderable:false, searchable:false }
            @endcanany
        ]
    });

    //  delete
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

    //  restore
    $(document).on('click','.restore-btn',function () {
        let id = $(this).data('id');

        Swal.fire({
            title: 'Restore?',
            icon: 'question',
            showCancelButton: true
        }).then(res=>{
            if(res.isConfirmed){
                $.post("{{ url('admin/countries') }}/"+id+"/restore", {
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

