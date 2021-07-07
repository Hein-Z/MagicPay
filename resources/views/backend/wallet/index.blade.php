@extends('backend.layouts.app')
@section('title', 'Magic Pay | Admin Panel')
@section('icon')
    <i class="pe-7s-users icon-gradient bg-mean-fruit">
    </i>
@endsection
@section('dashboard-title', 'Wallets Management')
@section('card-header', 'Wallets')
@section('content')
    <button class="btn btn-danger mx-4 my-2" id='delete-multiple-btn'>Delete Selected</button>
    <div class="m-3">
        <table id="data" class="display " style="width:100%">
            <thead>
                <tr>
                    <th>Select</th>
                    <th>Account Number</th>
                    <th>User Account</th>
                    <th>Amount</th>
                    <th>Created At</th>
                    <th>Updated At</th>
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
                ajax: "/admin/wallets/database/ssd",
                columns: [{
                        data: 'select',
                        name: 'select'
                    },
                    {
                        data: 'account_number',
                        name: 'account_number'
                    },
                    {
                        data: 'user_account',
                        name: 'user_account'
                    },
                    {
                        data: 'amount',
                        name: 'amount'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        searchable: false,
                        sortable: false
                    },
                    {
                        data: 'updated_at',
                        name: 'updated_at',
                        searchable: false,
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
                            url: '/admin/wallets/' + id,
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
                            url: '/admin/wallets/delete-selected',
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
