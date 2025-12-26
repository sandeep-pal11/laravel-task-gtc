@extends('layouts.admin')

@section('title','Cities')

@section('content')
<h3>Cities</h3>

@can('cities.create')
<a href="{{ route('admin.cities.create') }}" class="btn btn-primary mb-2">
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

            @canany(['cities.edit','cities.delete','cities.view'])
                <th>Action</th>
            @endcanany
        </tr>
    </thead>
</table>

<!-- ============ VIEW MODAL ============ -->
<div class="modal fade" id="viewModal" tabindex="-1">
    <div class="modal-dialog modal-md modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="cityTitle">
                    🏙️ City Details
                </h5>
                <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body" id="cityData">
                <!-- dynamic -->
            </div>

        </div>
    </div>
</div>
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

            @canany(['cities.edit','cities.delete','cities.view'])
            { data:'action', orderable:false, searchable:false }
            @endcanany
        ]
    });

    // DELETE (AS IT IS)
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

    // RESTORE (AS IT IS)
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

    // ========== VIEW CITY ==========
    $(document).on('click','.view-btn',function () {

        let id = $(this).data('id');

        $('#cityData').html('<p class="text-muted">Loading...</p>');

        $.get("{{ url('admin/cities') }}/"+id, function(res){

            let city = res.data;

            $('#cityTitle').html(`🏙️ City : <b>${city.name}</b>`);

            let html = `
                <div class="border rounded p-3">
                    <p><b>🏙️ City :</b> ${city.name}</p>
                    <p><b>🏴 State :</b> ${city.state?.name ?? '-'}</p>
                    <p><b>🌍 Country :</b> ${city.state?.country?.name ?? '-'}</p>
                </div>
            `;

            if (!city.state || !city.state.country) {
                html = `
                    <div class="alert alert-warning text-center">
                        ❌ No related State / Country found
                    </div>
                `;
            }

            $('#cityData').html(html);
            $('#viewModal').modal('show');
        });
    });

});
</script>
@endpush
