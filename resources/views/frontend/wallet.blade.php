@extends('frontend.layouts.app')
@section('nav-title', 'Wallet')
@section('content')
    <div class="row mb-5">
        <div class="col-md-8 offset-md-2 justify-content-center">
            <div class="row">
                <div class="card col-10 offset-1">
                    <div class="row ">
                        <img class="col-md-4 col-12" src="{{ asset('frontend/svg/Wallet_Flatline.svg') }}"
                            alt="Card image cap">
                        <div class="col-md-8 col-12 card-body ">
                            <h5 class="text-dark">Account Name</h5>
                            <p class="card-text ">{{ $wallet->user->name }}</p>
                            <h5 class="text-dark">Account Number</h5>
                            <p class="card-text">{{ $wallet->account_number }}</p>
                            <h5 class="text-dark">Balance</h5>
                            <p class="card-text">{{ $wallet->amount }}<small> kyat</small></p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
