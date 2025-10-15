@extends('plugins/ecommerce::orders.master')
@section('title')
    {{ __('Order successfully. Order number :id', ['id' => $order->code]) }}
@stop
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-12 pt-2" style="margin-top:100px;">

                <div class="thank-you">
                    <i class="fa fa-check-circle" aria-hidden="true"></i>
                    <div class="d-inline-block">
                        <h3 class="thank-you-sentence">
                            {{ __('Your order is successfully placed') }}
                        </h3>
                        <p>{{ __('Thank you for purchasing our products!') }}</p>
                    </div>
                </div>

                @include('plugins/ecommerce::orders.thank-you.customer-info', compact('order'))

                <a href="{{ route('public.index') }}" class="btn payment-checkout-btn w-100 btn-success"> {{ __('Continue shopping') }} </a>
            </div>

        </div>
    </div>
@stop
