@extends('backend.layouts.app')
@section('title', 'Magic Pay | Admin Panel')
@section('icon')
    <i class="pe-7s-users icon-gradient bg-mean-fruit">
    </i>
@endsection
@section('dashboard-title', 'User Management')
@section('card-header', 'Users')
@section('content')
    <a class="btn-primary btn my-2 mx-3 text-white" href="/admin/users/create"><i class="fas fa-plus-circle mr-2"></i>Create
        New User</a>
    <button class="btn btn-danger ml-2" id='delete-multiple-btn'>Delete Selected</button>
    <div class="m-3">
        <table id="data" class="display text-center" style="width:100%">
            <thead>
                <tr>
                    <th>Select</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>IP</th>
                    <th>User Agent</th>
                    <th>Login At</th>
                    <th>Action</th>
                </tr>


            </thead>

        </table>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            var table = $('#data').DataTable({
                processing: true,
                serverSide: true,
                ajax: "/admin/users/database/ssd",
                columns: [{
                        data: 'select',
                        name: 'select'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'phone',
                        name: 'phone'
                    },
                    {
                        data: 'ip',
                        name: 'ip'
                    },
                    {
                        data: 'user_agent',
                        name: 'user_agent',
                        searchable: false,
                        sortable: false
                    },
                    {
                        data: 'login_at',
                        name: 'login_at',
                        sortable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        searchable: false,
                        sortable: false
                    }
                ]
            });

            // Delete single user
            $(document).on('click', '.delete', function(e) {
                e.preventDefault();
                var id = $(this)[0].id;
                Swal.fire({
                    title: 'Do you want to delete this user?',
                    showCancelButton: true,
                    confirmButtonText: `Delete`,
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/admin/users/' + id,
                            type: 'DELETE',
                            success: function(res) {
                                table.ajax.reload();

                                Swal.fire('Successfully deleted')
                            },
                            error: function(data) {
                                Swal.fire('Something Wrong')
                            }
                        })
                    }
                })
            })


            // Delete multiple users
            var selected = [];

            $('#delete-multiple-btn').on('click', function(e) {
                selected = [];

                Swal.fire({
                    title: 'Do you want to delete selected users?',
                    showCancelButton: true,
                    confirmButtonText: `Delete`,
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('input[type=checkbox]').each(function() {
                            if ($(this).is(":checked")) {
                                if ($(this).attr('id'))
                                    selected.push($(this).attr('id'));
                            }
                        });

                        $.ajax({
                            url: '/admin/users/delete-selected',
                            type: 'DELETE',
                            data: 'ids=' + selected.join(','),
                            success: function(data) {
                                table.ajax.reload();
                                Swal.fire('Successfully deleted')
                            },
                            error: function(data) {
                                Swal.fire('Something Wrong')
                            }
                        });
                    }
                });



            })

        });
    </script>

@endsection
