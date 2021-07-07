<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('frontend/js/app.js') }}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <!-- Styles -->
    <link href="{{ asset('frontend/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/custom.css') }}" rel="stylesheet">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @yield('script')
</head>

<body>
    <div id="app" style="max-height: 100vh">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm sticky-top">
            <div class="container d-flex justify-content-md-around justify-content-between" style="min-height: 40px">
                <div class="h4 mt-1">
                    <a href="#" class="text-success" onclick="history.go(-1)"><i class="fas fa-arrow-left "></i></a>
                </div>
                <div>
                    <a class="navbar-brand" href="{{ url('/') }}">
                        @yield('nav-title','Magic Pay')
                    </a>
                </div>
                <div class="h4 mt-1">
                    <a href="#" class="text-success"><i class="fas fa-bell"></i></a>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
            @auth

                @include('frontend.layouts.bottom_nav')
            @endauth
        </main>
    </div>

    @yield('script2')
    <script>
        $(document).ready(function() {
            let token = document.head.querySelector('meta[name=csrf-token]');
            if (token) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF_TOKEN': token.content
                    }
                });
            }
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });
            @if (session('message'))
                Toast.fire({
                icon: 'success',
                title: "{{ session('message') }}"
                });
            @endif
            @if (session('fail'))
                Toast.fire({
                icon: 'error',
                title: "{{ session('fail') }}"
                });
            @endif
        });
    </script>
</body>

</html>
