@extends('layouts.admin')

@section('title','Tasks')

@section('content')
<h3>Tasks</h3>

<a href="{{ route('admin.tasks.create') }}" class="btn btn-primary mb-3">
    + Assign Task
</a>

<table class="table table-bordered" id="tasks-table">
    <thead>
        <tr>
            <th>#</th>
            <th>Title</th>
            <th>User</th>
            <th>Assigned By</th>
            <th>Start</th>
            <th>Due</th>
            <th>Status</th>
            <th width="200">Action</th>
        </tr>
    </thead>
</table>

<!-- ================= VIEW TASK MODAL (PREMIUM) ================= -->
<div class="modal fade" id="taskViewModal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content shadow">

      <div class="modal-header">
        <h5 class="modal-title fw-bold">Task Details</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body px-4">

        <!-- TITLE -->
        <div class="mb-3">
            <label class="text-muted small">Title</label>
            <div class="fs-5 fw-semibold" id="v_title"></div>
        </div>

        <!-- DESCRIPTION -->
        <div class="mb-3">
            <label class="text-muted small">Description</label>
            <div class="p-3 bg-light rounded border" id="v_details"></div>
        </div>

        <!-- ASSIGN INFO -->
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="text-muted small">Assigned To</label>
                <div class="fw-semibold" id="v_assigned_to"></div>
            </div>
            <div class="col-md-6 mb-3">
                <label class="text-muted small">Assigned By</label>
                <div class="fw-semibold" id="v_assigned_by"></div>
            </div>
        </div>

        <!-- STATUS & DATES -->
        <div class="row align-items-center">
            <div class="col-md-4 mb-3">
                <label class="text-muted small">Status</label><br>
                <span id="v_status" class="badge"></span>
            </div>
            <div class="col-md-4 mb-3">
                <label class="text-muted small">Start Date</label>
                <div class="fw-semibold" id="v_start"></div>
            </div>
            <div class="col-md-4 mb-3">
                <label class="text-muted small">Due Date</label>
                <div class="fw-semibold" id="v_due"></div>
            </div>
        </div>

        <!-- CREATED -->
        <div class="mt-2">
            <label class="text-muted small">Created</label>
            <div class="fw-semibold" id="v_created"></div>
        </div>

      </div>

      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">
            Close
        </button>
      </div>

    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
$(function () {

    $('#tasks-table').DataTable({
        processing:true,
        serverSide:true,
        ajax:"{{ route('admin.tasks.index') }}",
        columns:[
            {data:'DT_RowIndex',orderable:false,searchable:false},
            {data:'title'},
            {data:'user'},
            {data:'created_by'},
            {data:'start_date'},
            {data:'due_date'},
            {data:'status',orderable:false,searchable:false},
            {data:'action',orderable:false,searchable:false},
        ]
    });

    // ================= VIEW TASK =================
    $(document).on('click','.view-btn',function(){

        let id = $(this).data('id');

        $.get("{{ url('admin/tasks') }}/"+id,function(res){

            $('#v_title').text(res.title);
            $('#v_details').text(res.details);
            $('#v_assigned_to').text(res.assigned_to);
            $('#v_assigned_by').text(res.assigned_by);
            $('#v_start').text(res.start_date);
            $('#v_due').text(res.due_date);
            $('#v_created').text(res.created_at);

            // STATUS BADGE
            let cls = res.status === 'Completed'
                ? 'bg-success'
                : 'bg-warning text-dark';

            $('#v_status')
                .text(res.status)
                .removeClass()
                .addClass('badge '+cls);

            $('#taskViewModal').modal('show');
        });
    });

    // ================= DELETE ALERT =================
   // ================= DELETE CONFIRMATION =================
$(document).on('submit','.delete-form',function (e) {
    e.preventDefault();

    const form = this;

    Swal.fire({
        title: 'Confirm Deletion',
        text: 'Are you sure you want to permanently delete this task? This action cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete task',
        cancelButtonText: 'Cancel',
        confirmButtonColor: '#d33',
        reverseButtons: true,
        focusCancel: true
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
});


});
</script>
@endpush
