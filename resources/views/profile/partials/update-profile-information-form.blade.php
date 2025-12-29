<form id="profileUpdateForm"
      method="POST"
      action="{{ route('profile.update') }}"
      enctype="multipart/form-data">
    @csrf
    @method('patch')

    <div class="text-center mb-3">
        <img src="{{ $user->profile_photo ? asset('storage/'.$user->profile_photo) : asset('images/default-user.png') }}"
             class="rounded-circle"
             style="width:120px;height:120px;object-fit:cover;">
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <label class="form-label">Name</label>
            <input type="text" name="name" value="{{ $user->name }}" class="form-control">
        </div>

        <div class="col-md-6">
            <label class="form-label">Email</label>
            <input type="email" value="{{ $user->email }}" disabled class="form-control">
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label">Profile Photo</label>
        <input type="file" name="profile_photo" class="form-control">
    </div>

    <button class="btn btn-primary">Save Changes</button>
</form>

@if(session('success'))
<script>
Swal.fire({
    icon: 'success',
    title: 'Profile Updated',
    text: "{{ session('success') }}",
    confirmButtonColor: '#0d6efd'
});
</script>
@endif
