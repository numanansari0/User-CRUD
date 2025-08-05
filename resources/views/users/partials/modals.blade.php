<!-- ADD USER MODAL -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div data-bs-dismiss="modal" aria-label="Close" class="close_btn">
                <button type="button" class="btn p-0" data-bs-dismiss="modal" aria-label="Close">
                  <i class="bi bi-x" style="font-size: 25px;"></i>
                </button>
            </div>
            <div class="modal-body p-4">
                <h5 class="modal-title mb-3" id="addUserModalLabel">Add New User</h5>

                <form id="addUserForm" class="border-0">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" placeholder="Enter name" autocomplete="off">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" placeholder="Enter email" autocomplete="off">
                    </div>

                    <div class="mb-2 position-relative">
                        <label class="form-label">Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" name="password" id="addPassword" autocomplete="off"
                                   placeholder="Enter password">
                            <button type="button" class="btn btn_outline_primary toggle-password" data-target="addPassword">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                        <small class="text-muted d-block mt-1">
                            • Min 6 characters<br>
                            • At least 1 uppercase<br>
                            • At least 1 number<br>
                            • At least 1 special character
                        </small>
                    </div>
                </form>

                <div class="mt-3 d-flex justify-content-end">
                    <button type="submit" class="btn_primary" form="addUserForm">Submit</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- EDIT USER MODAL -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div data-bs-dismiss="modal" aria-label="Close" class="close_btn">
                <button type="button" class="btn p-0" data-bs-dismiss="modal" aria-label="Close">
                  <i class="bi bi-x" style="font-size: 25px;"></i>
                </button>
              </div>
            <div class="modal-body p-4">
                <h5 class="modal-title mb-3">Update User</h5>

                <form id="editUserForm">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" id="editName" placeholder="Enter name">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" id="editEmail" placeholder="Enter email">
                    </div>

                    <div class="mb-2 position-relative">
                        <label class="form-label">Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" name="password" id="editPassword" autocomplete="off"
                                   placeholder="New Password (optional)">
                            <button type="button" class="btn btn_outline_primary toggle-password" data-target="editPassword">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                        <small class="text-muted d-block mt-1">
                            • Min 6 characters<br>
                            • At least 1 uppercase<br>
                            • At least 1 number<br>
                            • At least 1 special character
                        </small>
                    </div>
                </form>

                <div class="mt-3 d-flex justify-content-end">
                    <button type="submit" class="btn_primary" form="editUserForm">Submit</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- DELETE USER MODAL -->
<div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div data-bs-dismiss="modal" aria-label="Close" class="close_btn">
                <button type="button" class="btn p-0" data-bs-dismiss="modal" aria-label="Close">
                  <i class="bi bi-x" style="font-size: 25px;"></i>
                </button>
              </div>
            <div class="modal-body text-center p-4">
                <h5 class="mb-3">Are you sure?</h5>
                <p>This action will permanently delete the user.</p>
                <div class="d-flex justify-content-center gap-3 mt-4">
                    <button class="btn_primary" data-bs-dismiss="modal">Cancel</button>
                    <button id="confirmDeleteUser" class="btn btn-danger">Yes, Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>
