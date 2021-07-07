@extends('frontend.layouts.app')
@section('nav-title', 'Update password')
@section('script')
    {{-- sweet alert2 --}}
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
@section('content')
    <div class="row mb-5">
        <div class="col-md-8 offset-md-2 justify-content-center">
            <div class="row">
                <img src="{{ asset('frontend/svg/undraw_security_o890.svg') }}"
                    class="col-6 offset-3 col-md-4 offset-md-4" alt="">
            </div>
            <div class="row mt-2">
                <div class="card col-12  col-md-8 offset-md-2" style="width: 18rem;">
                    <form action="{{ route('update-password') }}" style="display: contents" method="POST">
                        @csrf
                        @method('PATCH')
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <div class="form-group row">
                                    <label for="oldPassword" class="col-sm-4 col-form-label">Old Password</label>
                                    <div class="col-sm-8">
                                        <input type="password"
                                            class="form-control @error('old-password') is-invalid @enderror"
                                            id="oldPassword" name="old_password" placeholder="Password">
                                        @error('old-password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">New Password</label>
                                    <div class="col-sm-8">
                                        <input type="password" class="form-control" id="inputPassword" name="password"
                                            placeholder="Password">
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="form-group row">
                                    <label for="confirm" class="col-sm-4 col-form-label">Confirm Password</label>
                                    <div class="col-sm-8">
                                        <input type="password" name="password_confirmation" class="form-control"
                                            id="confirm" placeholder="Confirm Password">
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <button class="btn-block btn-success btn">Confirm</button>
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
    {!! JsValidator::formRequest('App\Http\Requests\UpdatePasswordRequest') !!}

@endsection
