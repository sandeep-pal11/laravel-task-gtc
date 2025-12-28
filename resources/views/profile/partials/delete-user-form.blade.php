<form id="deleteAccountForm"
      method="POST"
      action="{{ route('profile.destroy') }}">
    @csrf
    @method('delete')

    <div class="alert alert-danger">
        <h6 class="alert-heading mb-1">
            <i class="fas fa-exclamation-triangle me-1"></i>
            Delete Account
        </h6>
        <p class="mb-0 small">
            Once your account is deleted, all your data will be permanently removed.
            This action cannot be undone.
        </p>
    </div>

    <div class="mb-3">
        <label class="form-label fw-semibold text-danger">
            Confirm your password
        </label>
        <input
            type="password"
            id="deletePassword"
            name="password"
            class="form-control"
            placeholder="Enter your password to confirm">
    </div>

    <button type="button"
            onclick="confirmDeleteAccount()"
            class="btn btn-danger">
        <i class="fas fa-trash me-1"></i>
        Permanently Delete Account
    </button>
</form>
