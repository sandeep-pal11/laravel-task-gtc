@extends('admin.layout')

@section('content')
<h3>States</h3>

@can('states.create')
<a href="{{ route('admin.states.create') }}"
   class="btn btn-primary mb-2">
    Add State
</a>
@endcan

<table class="table table-bordered" id="states-table">
    <thead>
        <tr>
            <th>#</th>
            <th>State</th>
            <th>Country</th>

            @canany(['states.edit','states.delete'])
                <th>Action</th>
            @endcanany
        </tr>
    </thead>
</table>
@endsection

@push('scripts')
<script>
$(function () {

    let table = $('#states-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.states.index') }}",

        dom: 'Bfrtip',
        buttons: [
            { extend:'csvHtml5', title:'States', className:'btn btn-secondary btn-sm' },
            { extend:'pdfHtml5', title:'States', className:'btn btn-danger btn-sm' }
        ],

        columns: [
            { data:'DT_RowIndex', orderable:false, searchable:false },
            { data:'name' },
            { data:'country' },
            @canany(['states.edit','states.delete'])
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
                $.post("{{ url('admin/states') }}/"+id+"/restore", {
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
