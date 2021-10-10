@extends('frontend.layouts.app')
@section('nav-title', 'Transaction History')
@section('content')
    <div class="row mb-5">
        <div class="col-md-8 offset-md-2 col-10 offset-1 ">
            @forelse($transactions as $transaction )
                @if($transaction->type==2)
                    <div class=" bg-success   row rounded mb-2">
                        <div class="col-12 justify-content-center"><h4 class="text-center">Expense</h4></div>
                        <div class="col-12 justify-content-center">To : {{$transaction->source_user->phone}}</div>
                        <div class="col-12 justify-content-center">Amount : {{$transaction->amount}}</div>
                        <div class="col-12 justify-content-center">Amount : {{$transaction->description}}</div>
                        <div class="col-12 justify-content-center">Transaction Id : {{$transaction->trx_id}}</div>
                    </div>@endif
                @if($transaction->type==1)
                    <div class=" bg-primary row rounded mb-2">
                        <div class="col-12 justify-content-center"><h4 class="text-center">Income</h4></div>
                        <div class="col-12 justify-content-center">From : {{$transaction->source_user->phone}}</div>
                        <div class="col-12 justify-content-center">Amount : {{$transaction->amount}}</div>
                        <div class="col-12 justify-content-center">Description : {{$transaction->description}}</div>
                        <div class="col-12 justify-content-center">Transaction Id : {{$transaction->trx_id}}</div>
                    </div>
                @endif
            @empty
                <div class="bg-warning">
                    There is no Transaction History
                </div>
            @endforelse
        </div>
    </div>
@endsection
