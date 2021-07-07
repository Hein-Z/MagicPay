@extends('frontend.layouts.app')
@section('nav-title', 'Confrim Transfer')
@section('content')
    <div class="row mb-5">
        <div class="col-md-8 offset-md-2 justify-content-center">
            <div class="row mt-2">
                <div class="card col-12  col-md-8 offset-md-2" style="width: 18rem;">
                    <form action="{{ route('transfer') }}" id="confrim_form" style="display: contents" method="POST">
                        @csrf
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <div class="form-group row">
                                    <label for="from" class="col-sm-4 col-form-label">From</label>
                                    <div class="col-sm-8">
                                        <input type="number" class="form-control " id="from" name="from"
                                            value="{{ $data['from_phone'] }}" readonly="readonly">
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="form-group row">
                                    <label for="to_phone" class="col-sm-4 col-form-label">To User Name<span
                                            id="user-name"></span></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control " id="to_name" name="to_phone"
                                            placeholder="Phone Number" value="{{ $data['to_name'] }}" readonly>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="form-group row">
                                    <label for="to_phone" class="col-sm-4 col-form-label">To Phone Number<span
                                            id="user-name"></span></label>
                                    <div class="col-sm-8">
                                        <input type="number" class="form-control " id="to_phone" name="to_phone"
                                            placeholder="Phone Number" value="{{ $data['to_phone'] }}" readonly>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="form-group row">
                                    <label for="amount" class="col-sm-4 col-form-label">Amount</label>
                                    <div class="col-sm-8">
                                        <input type="number" class="form-control" id="amount" name="amount"
                                            placeholder="...Ks" value="{{ $data['amount'] }}" readonly>

                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="form-group row">
                                    <label for="description" class="col-sm-4 col-form-label">Description</label>
                                    <div class="col-sm-8">
                                        <textarea name="description" class="form-control" id="description"
                                            readonly>{{ $data['description'] }}</textarea>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <button class="btn-block btn-success btn" type="submit">Confirm</button>
                            </li>
                        </ul>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script2')
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\TransferRequest') !!}

    <script>
        $(document).ready(function() {
            let is_password_true;
            is_password_true = false;

            $("#confrim_form").on('submit', function(event) {

                if (!is_password_true) {
                    event.preventDefault();

                    Swal.fire({
                        title: 'Enter Your Password',
                        input: 'password',
                        showCancelButton: true,
                        confirmButtonText: 'Confirm',
                        showLoaderOnConfirm: true,
                        preConfirm: (password) => {

                            return $.ajax({
                                url: '/check-password',
                                type: "POST",
                                data: 'password=' + password,
                                success: function(data) {
                                    return data;
                                },
                                error: function(data) {
                                    throw new Error(data);
                                }
                            });
                        },
                        allowOutsideClick: () => !Swal.isLoading()
                    }).then((result) => {
                        if (!result.isConfirmed)
                            return
                        if (result.value.confirmed) {
                            is_password_true = true;
                            $("#confrim_form").submit();
                        } else if (!result.value.confirmed)
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Wrong Password',
                            })
                    }).catch(result => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong!',
                        })
                    });
                }
            });
        });
    </script>

@endsection
