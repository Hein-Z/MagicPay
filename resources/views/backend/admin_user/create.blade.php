@extends('backend.layouts.app')
@section('title', 'Magic Pay | Admin Panel')
@section('icon')
    <i class="pe-7s-users icon-gradient bg-mean-fruit">
    </i>
@endsection
@section('dashboard-title', 'Add New Admin User')
@section('card-header', 'Add Admin User')
@section('content')
    <div class="px-3 pt-2">
        <form method="POST" action="/admin/admin-users" id="create">
            @csrf
            <div class="form-group row">
                <label for="name" class="col-sm-2 col-form-label">Name</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="name" id="name" placeholder="Name"
                        value="{{ old('name') }}">
                </div>
            </div>
            <div class="form-group row">
                <label for="email" class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-10">
                    <input type="email" class="form-control" name="email" id="email" placeholder="Email"
                        value="{{ old('email') }}">
                </div>
            </div>
            <div class="form-group row">
                <label for="phone" class="col-sm-2 col-form-label">Phone</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control" name="phone" id="phone" placeholder="Phone Number"
                        value="{{ old('phone') }}">
                </div>
            </div>
            <div class="form-group row">
                <label for="password" class="col-sm-2 col-form-label">Password</label>
                <div class="col-sm-10">
                    <input type="password" name="password" class="form-control" id="password" placeholder="Password"
                        value="{{ old('password') }}">
                </div>
            </div>

            <div class=" d-flex align-content-center justify-content-center">
                <div class="mb-3">
                    <button type="submit" class="btn btn-lg btn-primary mr-3">Confirm</button>
                    <a class="btn btn-warning btn-lg back text-dark" href="/admin/admin-users">Back</a>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('script')
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\AdminUserStoreRequest', '#create') !!}

@endsection
