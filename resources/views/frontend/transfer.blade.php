@extends('frontend.layouts.app')
@section('nav-title', 'Transfer')

@section('content')
    <div class="row mb-5">
        <div class="col-md-8 offset-md-2 justify-content-center">
            <div class="row mt-2">
                <div class="card col-12  col-md-8 offset-md-2" style="width: 18rem;">
                    <form action="{{ route('transfer-confirmation') }}" style="display: contents" method="POST">
                        @csrf
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <div class="form-group row">
                                    <label for="from" class="col-sm-4 col-form-label">From</label>
                                    <div class="col-sm-8">
                                        <input type="number" class="form-control " id="from" name="from"
                                            value="{{ $auth->phone }}" readonly>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="form-group row">
                                    <label for="to_phone" class="col-sm-4 col-form-label">To <span
                                            id="user-name"></span><span class="text-success "> (
                                            {{ isset($to_user) ? $to_user->name : '' }} )</span></label>
                                    <div class="col-sm-8">
                                        <div class="input-group mb-3">
                                            <input type="number"
                                                class="form-control @error('to_phone') is-invalid @enderror" id="to_phone"
                                                name="to_phone" placeholder="Phone Number"
                                                value="{{ isset($to_user) ? $to_user->phone : old('to_phone') }}" @if (isset($to_user)) readonly @endif>
                                            @if (!isset($to_user))
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-secondary" id="check-user"
                                                        type="button"><i class="fas fa-check-circle"></i></button>
                                                </div>
                                            @endif

                                            @error('to_phone')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="form-group row">
                                    <label for="amount" class="col-sm-4 col-form-label">Amount</label>
                                    <div class="col-sm-8">
                                        <input type="number" class="form-control  @error('amount') is-invalid @enderror"
                                            id="amount" name="amount" placeholder="...Ks"
                                            max="{{ round($auth->wallet->amount) }}" min="0"
                                            value="{{ old('amount') }}">
                                        @error('amount')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <small>You Current Amount is {{ $auth->wallet->amount }} Ks</small>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="form-group row">
                                    <label for="description" class="col-sm-4 col-form-label">Description</label>
                                    <div class="col-sm-8">
                                        <textarea name="description" class="form-control" id="description"
                                            placeholder="Enter Description">{{ old('description') }}</textarea>
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
        $('#check-user').click(function() {

            var to_phone = $('#to_phone').val();

            $.ajax({
                url: '/check-user',
                data: {
                    "to_phone": to_phone
                },
                type: 'post',
                success: function(result) {
                    if (result.success) {
                        $('#user-name').addClass('text-success').removeClass('text-danger');
                    } else {
                        $('#user-name').addClass('text-danger').removeClass('text-success');
                    }
                    $('#user-name').text('(' + result.user + ')').fadeIn(700);
                }
            });
        });
    </script>
@endsection
