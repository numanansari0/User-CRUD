@extends('layout')

@section('content')
    <div class="card">
        <div class="d-flex justify-content-between align-items-center px-4">
            <h4>Users Table</h4>
            <button class="btn_primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                <i class="bi bi-plus"></i> Add Users
            </button>
        </div>
        <div class="bdr"></div>

        <div class="table-responsive">
            <table id="userTable" class="table mt-4" style="width:100%"></table>
        </div>
    </div>

    @include('users.partials.modals')
@endsection

@push('scripts')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        let editUserId = null;
        let deleteUserId = null;

        // Toggle password visibility
        $(document).on('click', '.toggle-password', function() {
            const inputId = $(this).data('target');
            const input = document.getElementById(inputId);
            const icon = $(this).find('i');

            if (input.type === 'password') {
                input.type = 'text';
                icon.removeClass('bi-eye').addClass('bi-eye-slash');
            } else {
                input.type = 'password';
                icon.removeClass('bi-eye-slash').addClass('bi-eye');
            }
        });


        // Toastr configuration
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": "4000"
        };

        const userTable = $('#userTable').DataTable({
            ajax: {
                url: '{{ route('users.index') }}',
                dataSrc: '',
            },
            columns: [{
                    data: 'id',
                    title: 'Id',
                    className: 'text-start',
                    width: '5%'
                },
                {
                    data: 'name',
                    title: 'Name',
                    className: 'text-start',
                    width: '25%',
                    render: function(data, type, row) {
                        const initial = row.name.charAt(0).toUpperCase();
                        const bgColors = ['#e3f2fd', '#e8f5e9', '#fff3e0', '#f3e5f5', '#ede7f6'];
                        const textColors = ['#2196f3', '#4caf50', '#fb8c00', '#9c27b0', '#5e35b1'];
                        const i = row.id % bgColors.length;

                        return `
                        <div class="d-flex align-items-center">
                            <div style="
                                width: 36px; height: 36px; border-radius: 50%;
                                background: ${bgColors[i]}; color: ${textColors[i]};
                                display: flex; align-items: center; justify-content: center;
                                font-weight: 600; text-transform: uppercase; font-size: 14px;
                                margin-right: 10px;">
                                ${initial}
                            </div>
                            ${row.name}
                        </div>`;
                    }
                },
                {
                    data: 'email',
                    title: 'Email',
                    className: 'text-center',
                    width: '25%'
                },
                {
                    data: 'created_at',
                    title: 'Created Date',
                    className: 'text-center',
                    width: '25%',
                    render: function(data) {
                        const options = {
                            year: 'numeric',
                            month: 'short',
                            day: '2-digit'
                        };
                        return new Date(data).toLocaleDateString('en-US', options);
                    }
                },
                {
                    data: null,
                    title: 'Actions',
                    className: 'text-end',
                    width: '25%',
                    orderable: false,
                    render: function(data) {
                        return `<div class="d-inline-flex gap-2">
                            <button class="btn-edit editUser" data-id="${data.id}" data-name="${data.name}" data-email="${data.email}"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit font-small-4"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></button>
                            <button data-id="${data.id}" class="btn-delete deleteUser openDeleteModal"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 font-small-4 me-50"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></button>
                        </div>`;
                    }
                }
            ],
            language: {
                paginate: {
                    previous: '<i class="bi bi-chevron-left"></i>',
                    next: '<i class="bi bi-chevron-right"></i>'
                }
            }
        });

        // Add User
        $('#addUserForm').submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: '{{ route('users.store') }}',
                method: 'POST',
                data: $(this).serialize(),
                success: function(res) {
                    $('#addUserModal').modal('hide');
                    $('#addUserForm')[0].reset();
                    userTable.ajax.reload();
                    toastr.success(res.message);
                },
                error: function(xhr) {
                    if (xhr.responseJSON?.errors) {
                        Object.values(xhr.responseJSON.errors).forEach(e => toastr.error(e));
                    }
                }
            });
        });

        // Open Edit Modal
        $(document).on('click', '.editUser', function() {
            editUserId = $(this).data('id');
            $('#editName').val($(this).data('name'));
            $('#editEmail').val($(this).data('email'));
            $('#editUserModal').modal('show');
        });

        // Update User
        $('#editUserForm').submit(function(e) {
            e.preventDefault();
            let formData = $(this).serialize() + '&_method=PUT';

            $.ajax({
                url: `/users/${editUserId}`,
                method: 'POST', // Use POST and spoof PUT
                data: formData,
                success: function(res) {
                    $('#editUserModal').modal('hide');
                    $('#editUserForm')[0].reset();
                    userTable.ajax.reload();
                    toastr.success(res.message);
                },
                error: function(xhr) {
                    if (xhr.responseJSON?.errors) {
                        Object.values(xhr.responseJSON.errors).forEach(e => toastr.error(e));
                    }
                }
            });

        });

        // Open Delete Modal
        $(document).on('click', '.openDeleteModal', function() {
            deleteUserId = $(this).data('id');
            $('#deleteUserModal').modal('show');
        });

        // Confirm Delete
        $('#confirmDeleteUser').click(function() {
            $.ajax({
                url: `/users/${deleteUserId}`,
                method: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(res) {
                    $('#deleteUserModal').modal('hide');
                    userTable.ajax.reload();
                    toastr.success(res.message);
                },
                error: function() {
                    toastr.error('Failed to delete user.');
                }
            });
        });
    </script>
@endpush
