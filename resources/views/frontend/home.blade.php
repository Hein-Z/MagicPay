@extends('frontend.layouts.app')
@section('nav-title', 'Magic Pay')

@section('content')

    <div class="row mb-5">
        <div class="col-md-8 offset-md-2 ">
            <div class="row">
                <img src="https://ui-avatars.com/api/?name={{ auth()->guard('web')->user()->name }}"
                    class="col-4 offset-4 col-md-2 offset-md-5 rounded-circle" alt="">
                <div class="col-12">
                    <div class="row pt-1">
                        <div class="col-12  col-md-6 offset-md-3 h5 text-bold ">
                            <div class="row">
                                <div class="col-12 text-center h4">
                                    Name :
                                    {{ auth()->guard('web')->user()->name }}
                                </div>
                                <br>
                                <div class="text-center h4 col-12">
                                    Amount :
                                    {{ auth()->guard('web')->user()->wallet->amount }} Ks
                                </div>
                            </div>
                        </div>



                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class=" col-lg-8 col-12 offset-lg-2">
                    <div class="row mx-3">
                        <a href="{{ route('scan') }}" class="text-dark"
                            style="display: contents; text-decoration: none">
                            <div class="card col-lg-5 col-6">
                                <div class="row  p-2 h5">
                                    <div class="col-sm-4 col-3">
                                        <img src="{{ asset('frontend/svg/qr-code-scan.svg') }}" width="40" alt="">
                                    </div>
                                    <div class="col-8 pr-1   mt-sm-2">Scan & Pay</div>
                                </div>
                            </div>
                        </a>
                        <a href="{{ route('qr-code') }}" class="text-dark"
                            style="display: contents; text-decoration: none">
                            <div class="card col-lg-5 col-6 offset-lg-2">
                                <div class="row p-2 h5">
                                    <div class="col-sm-4 col-3">
                                        <img src="{{ asset('frontend/svg/qr-code.svg') }}" width="40">
                                    </div>

                                    <div class="col-8 pr-1   mt-sm-2"> Receive QR</div>
                                </div>
                            </div>
                        </a>

                    </div>
                </div>
            </div>
            <div class="row mt-2 mx-3">
                <div class="card col-12  col-md-8 offset-md-2 mb-3" style="width: 18rem;">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <a href="{{ route('transfer') }}" class="text-dark" style="text-decoration: none">
                                <div class="d-flex justify-content-between">
                                    <div class="d-flex justify-content-start">
                                        <div><img class="img-thumbnail"
                                                src="{{ asset('frontend/svg/money-transfer (1).png') }}" width="40"
                                                alt=""></div>
                                        <div class="m-2 h5">Transfer</div>
                                    </div>
                                    <div><i class="fas fa-chevron-right"></i></div>
                                </div>
                            </a>
                        </li>
                        <li class="list-group-item">
                            <a href="{{ route('wallet') }}" class="text-dark" style="text-decoration: none">
                                <div class="d-flex justify-content-between">
                                    <div class="d-flex justify-content-start">
                                        <div><img src="{{ asset('frontend/svg/wallet.png') }}" width="40" alt=""></div>
                                        <div class="m-2 h5">Wallet</div>
                                    </div>
                                    <div><i class="fas fa-chevron-right"></i></div>
                                </div>
                            </a>
                        </li>
                        <li class="list-group-item">
                            <a href="{{ route('home') }}" class="text-dark" style="text-decoration: none">
                                <div class="d-flex justify-content-between">
                                    <div class="d-flex justify-content-start">
                                        <div><img src="{{ asset('frontend/svg/lending.png') }}" width="40" alt=""></div>
                                        <div class="m-2 h5">Transcation</div>
                                    </div>
                                    <div><i class="fas fa-chevron-right"></i></div>
                                </div>
                            </a>
                        </li>

                    </ul>
                </div>
            </div>
        </div>

    </div>

@endsection

