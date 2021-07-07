@extends('frontend.layouts.app')
@section('nav-title', 'Profile')
@section('script')
    {{-- sweet alert2 --}}
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
@section('content')
    <div class="row profile">
        <div class="col-md-8 offset-md-2 justify-content-center">
            <div class="row">
                <img src="https://ui-avatars.com/api/?name={{ auth()->guard('web')->user()->name }}"
                    class="col-4 offset-4 col-md-2 offset-md-5" alt="">
            </div>
            <div class="row mt-2">
                <div class="card col-12  col-md-8 offset-md-2" style="width: 18rem;">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between">
                                <div>Name</div>
                                <div>{{ auth()->guard('web')->user()->name }}</div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between">
                                <div>Email</div>
                                <div>{{ auth()->guard('web')->user()->email }}</div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between">
                                <div>Phone</div>
                                <div>{{ auth()->guard('web')->user()->phone }}</div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="row mt-2">
                <div class="card col-12  col-md-8 offset-md-2 pb-3" style="width: 18rem;">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <a href="{{ route('update-password') }}" class="text-dark" style="text-decoration: none">
                                <div class="d-flex justify-content-between">
                                    <div>Update Password</div>
                                    <div><i class="fas fa-chevron-right"></i></div>
                                </div>
                            </a>
                        </li>
                        <li class="list-group-item">
                            <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                             Swal.fire({
                                    title: 'Do you want to delete selected users?',
                                    showCancelButton: true,
                                    confirmButtonText: `Confirm`,
                                }).then((result) => {
                                    if (result.isConfirmed)
                                     document.getElementById('logout-form').submit();})
                                                                   " class="text-dark" style="text-decoration: none">
                                <div class="d-flex justify-content-between">
                                    <div>Logout</div>
                                    <div><i class="fas fa-sign-out-alt"></i></div>
                                </div>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
