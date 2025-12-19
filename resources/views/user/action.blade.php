@can('users.edit')
<a href="{{ route('admin.users.edit', $u) }}" class="btn btn-sm btn-warning">
    Edit
</a>
@endcan

@can('users.delete')
<button class="btn btn-sm btn-danger delete-btn"
        data-id="{{ $u->id }}">
    Delete
</button>

<form id="delete-form-{{ $u->id }}"
      action="{{ route('admin.users.destroy', $u) }}"
      method="POST" class="d-none">
    @csrf
    @method('DELETE')
</form>
@endcan
