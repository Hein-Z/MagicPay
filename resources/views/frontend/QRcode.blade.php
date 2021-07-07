@extends('frontend.layouts.app')
@section('nav-title', 'Receive QR')
@section('content')
    <div class="row mb-5">
        <div class="col-md-8 offset-md-2 ">
            <div class="row">
                <div class="col-12 text-center h4 mb-3">QR Scan to pay me</div>
                <div class="col-12 text-center">
                    {!! SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')->size(260)->generate(
        auth()->guard('web')->user()->phone,
    ) !!}
                </div>
                <div class="col-12 text-center h4 mt-2">{{ auth()->guard('web')->user()->name }}</div>
                <div class="col-12 text-center h5">{{ auth()->guard('web')->user()->phone }}</div>
            </div>
        </div>
    </div>
@endsection
