@extends('layouts.admin')

@section('title','States')

@section('content')
<h3>States</h3>

@can('states.create')
<a href="{{ route('admin.states.create') }}" class="btn btn-primary mb-2">
    Add State
</a>
@endcan

<table class="table table-bordered" id="states-table">
    <thead>
        <tr>
            <th>Id</th>
            <th>State</th>
            <th>Country</th>

            @canany(['states.edit','states.delete','states.view'])
                <th>Action</th>
            @endcanany
        </tr>
    </thead>
</table>

<!-- ============ VIEW MODAL ============ -->
<div class="modal fade" id="viewModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="stateTitle">
                    🏴 State Details
                </h5>
                <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body" id="stateData">
                <!-- dynamic -->
            </div>

        </div>
    </div>
</div>
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

            @canany(['states.edit','states.delete','states.view'])
            { data:'action', orderable:false, searchable:false }
            @endcanany
        ]
    });

    // DELETE (UNCHANGED)
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

    // RESTORE (UNCHANGED)
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

    // ========== VIEW STATE ==========
    $(document).on('click','.view-btn',function () {

        let id = $(this).data('id');

        $('#stateData').html('<p class="text-muted">Loading...</p>');

        $.get("{{ url('admin/states') }}/"+id, function(res){

            let state = res.data;

            $('#stateTitle').html(
                ` State : <b>${state.name}</b>
                 <br><small class="text-light"> Country : ${state.country.name}</small>`
            );

            let html = '';

            if (!state.cities || state.cities.length === 0) {
                html += `
                    <div class="alert alert-warning text-center">
                        ❌ No City found
                    </div>
                `;
            } else {

                html += `
                <div class="border rounded p-2">
                    <div class="fw-bold mb-2">
                        🏙️ Cities
                    </div>
                    <ul class="ms-3">
                `;

                state.cities.forEach(city=>{
                    html += `<li>${city.name}</li>`;
                });

                html += `
                    </ul>
                </div>
                `;
            }

            $('#stateData').html(html);
            $('#viewModal').modal('show');
        });
    });

});
</script>
@endpush
