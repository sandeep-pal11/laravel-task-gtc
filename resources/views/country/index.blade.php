@extends('layouts.admin')

@section('title','Countries')

@section('content')
<h3>Countries</h3>

@can('countries.create')
<a href="{{ route('admin.countries.create') }}" class="btn btn-primary mb-2">
    Add Country
</a>
@endcan

<table class="table table-bordered" id="countries-table">
    <thead>
        <tr>
            <th>#</th>
            <th>Country</th>

            @canany(['countries.edit','countries.delete','countries.view'])
                <th>Action</th>
            @endcanany
        </tr>
    </thead>
</table>

<!-- ================= VIEW MODAL ================= -->
<div class="modal fade" id="viewModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="countryTitle">
                    🌍 Country Details
                </h5>
                <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body" id="countryData">
                <!-- dynamic data -->
            </div>

        </div>
    </div>
</div>
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

            @canany(['countries.edit','countries.delete','countries.view'])
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
                $.post("{{ url('admin/countries') }}/"+id+"/restore", {
                    _token: "{{ csrf_token() }}"
                }, function(){
                    table.ajax.reload();
                });
            }
        });
    });

    // ================= VIEW BUTTON =================
    $(document).on('click','.view-btn',function () {

        let id = $(this).data('id');

        $('#countryData').html('<p class="text-muted">Loading...</p>');

        $.get("{{ url('admin/countries') }}/"+id, function(res){

            let country = res.data;

            // COUNTRY LABEL
            $('#countryTitle').html('🌍 Country : <b>' + country.name + '</b>');

            let html = '';

            // NO STATE DATA
            if (!country.states || country.states.length === 0) {
                html += `
                    <div class="alert alert-warning text-center">
                        ❌ No State / City data found
                    </div>
                `;
            } else {

                country.states.forEach(state => {

                    html += `
                    <div class="border rounded mb-2">

                        <!-- STATE HEADER -->
                        <div class="bg-light p-2 fw-bold d-flex justify-content-between align-items-center state-toggle"
                             style="cursor:pointer">
                            <span>🏴 State : ${state.name}</span>
                            <span class="arrow">⬇️</span>
                        </div>

                        <!-- CITY BOX -->
                        <div class="cities p-2" style="display:none">
                            <div class="fw-semibold mb-1">🏙️ Cities :</div>
                    `;

                    // NO CITY
                    if (!state.cities || state.cities.length === 0) {
                        html += `<div class="text-muted ms-3">No city found</div>`;
                    } else {
                        html += `<ul class="ms-3">`;
                        state.cities.forEach(city=>{
                            html += `<li>${city.name}</li>`;
                        });
                        html += `</ul>`;
                    }

                    html += `
                        </div>
                    </div>`;
                });
            }

            $('#countryData').html(html);
            $('#viewModal').modal('show');
        });
    });

    // TOGGLE ARROW + CITY
    $(document).on('click','.state-toggle',function(){
        $(this).next('.cities').slideToggle();
        let arrow = $(this).find('.arrow');
        arrow.text(arrow.text() === '⬇️' ? '⬆️' : '⬇️');
    });

});
</script>
@endpush
