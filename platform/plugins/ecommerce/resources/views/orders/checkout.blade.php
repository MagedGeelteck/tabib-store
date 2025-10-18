

@php

foreach($products as $product){
if($product->images[0])
DB::table('ec_products')->where('id',$product->id)->update(['image'=>$product->images[0]]);
}
@endphp
@extends('plugins/ecommerce::orders.master')
@section('title')
    {{ __('Checkout') }}
@stop
@section('content')

    @if (Cart::instance('cart')->count() > 0)
        @if (is_plugin_active('payment'))
            @include('plugins/payment::partials.header')
        @endif

        {!! Form::open(['route' => ['public.checkout.process', $token], 'class' => 'checkout-form payment-checkout-form', 'id' => 'checkout-form']) !!}
            <input type="hidden" name="checkout-token" id="checkout-token" value="{{ $token }}">

            <div class="container" id="main-checkout-product-info">
                <div class="row">
                    <div class="col-12" style="min-height:10vh!important; padding-top:25px!important; max-width:100%!important;">

                        <div class="form-checkout" id="verify">
                            
                    <div class="order-1 order-md-2 col-12">

                        <div  @if(Session::get('otp')) hidden @endif id="cart-item" class="position-relative">

                            <div class="payment-info-loading" style="display: none;">
                                <div class="payment-info-loading-content">
                                    <i class="fas fa-spinner fa-spin"></i>
                                </div>
                            </div>

                            {!! apply_filters(RENDER_PRODUCTS_IN_CHECKOUT_PAGE, $products) !!}

                            @php
                                $rawTotal = Cart::instance('cart')->rawTotal();
                                $orderAmount = max($rawTotal - $promotionDiscountAmount - $couponDiscountAmount, 0);
                                $orderAmount += (float)$shippingAmount;
                            @endphp

                            <div class="mt-2 p-2">
                                <div class="row">
                                    <div class="col-6">
                                        <p>{{ __('Subtotal') }}:</p>
                                    </div>
                                    <div class="col-6">
                                        <p class="price-text sub-total-text text-end"> {{ format_price(Cart::instance('cart')->rawSubTotal()) }} </p>
                                    </div>
                                </div>
                                @if (EcommerceHelper::isTaxEnabled())
                                    <div class="row">
                                        <div class="col-6">
                                            <p>{{ __('Tax') }}:</p>
                                        </div>
                                        <div class="col-6 float-end">
                                            <p class="price-text tax-price-text">{{ format_price(Cart::instance('cart')->rawTax()) }}</p>
                                        </div>
                                    </div>
                                @endif
                                @if (session('applied_coupon_code'))
                                    <div hidden class="row coupon-information">
                                        <div class="col-6">
                                            <p>{{ __('Coupon code') }}:</p>
                                        </div>
                                        <div class="col-6">
                                            <p class="price-text coupon-code-text"> {{ session('applied_coupon_code') }} </p>
                                        </div>
                                    </div>
                                @endif
                                @if ($couponDiscountAmount > 0)
                                    <div hidden class="row price discount-amount">
                                        <div class="col-6">
                                            <p>{{ __('Coupon code discount amount') }}:</p>
                                        </div>
                                        <div class="col-6">
                                            <p class="price-text total-discount-amount-text"> {{ format_price($couponDiscountAmount) }} </p>
                                        </div>
                                    </div>
                                @endif
                                @if ($promotionDiscountAmount > 0)
                                    <div hidden class="row">
                                        <div class="col-6">
                                            <p>{{ __('Promotion discount amount') }}:</p>
                                        </div>
                                        <div class="col-6">
                                            <p class="price-text"> {{ format_price($promotionDiscountAmount) }} </p>
                                        </div>
                                    </div>
                                @endif
                                @if (!empty($shipping) && Arr::get($sessionCheckoutData, 'is_available_shipping', true))
                                    <div class="row">
                                        <div class="col-6">
                                            <p>{{ __('Shipping fee') }}:</p>
                                        </div>
                                        <div class="col-6 float-end">
                                            <p class="price-text shipping-price-text">{{ format_price($shippingAmount) }}</p>
                                        </div>
                                    </div>
                                @endif

                                <div class="row">
                                    <div class="col-6">
                                        <p><strong>{{ __('Total') }}</strong>:</p>
                                    </div>
                                    <div class="col-6 float-end">
                                        <p class="total-text raw-total-text"
                                            data-price="{{ format_price($rawTotal, null, true) }}"> {{ format_price($orderAmount) }} </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div hidden class="mt-3 mb-5">
                            @include('plugins/ecommerce::themes.discounts.partials.form')
                        </div>
                    </div>
                            
                            @if (! is_plugin_active('marketplace'))
                                @if (Arr::get($sessionCheckoutData, 'is_available_shipping', true))
                                    <div  @if(Session::get('otp')) hidden  @endif id="shipping-method-wrapper">
                                        <h5 class="checkout-payment-title">{{ __('Shipping method') }}</h5>
                                        <div class="shipping-info-loading" style="display: none;">
                                            <div class="shipping-info-loading-content">
                                                <i class="fas fa-spinner fa-spin"></i>
                                            </div>
                                        </div>
                                        @if (!empty($shipping))
                                            <div class="payment-checkout-form">
                                                <input type="hidden" name="shipping_option" value="{{ old('shipping_option', $defaultShippingOption) }}">
                                                <ul class="list-group list_payment_method">
                                                    @foreach ($shipping as $shippingKey => $shippingItems)
                                                        @foreach($shippingItems as $shippingOption => $shippingItem)
                                                            @include('plugins/ecommerce::orders.partials.shipping-option', [
                                                                'shippingItem' => $shippingItem,
                                                                'attributes' =>[
                                                                    'id' => 'shipping-method-' . $shippingKey . '-' . $shippingOption,
                                                                    'name' => 'shipping_method',
                                                                    'class' => 'magic-radio shipping_method_input',
                                                                    'checked' => old('shipping_method', $defaultShippingMethod) == $shippingKey && old('shipping_option', $defaultShippingOption) == $shippingOption,
                                                                    'disabled' => Arr::get($shippingItem, 'disabled'),
                                                                    'data-option' => $shippingOption,
                                                                ],
                                                            ])
                                                        @endforeach
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @else
                                            <p>{{ __('No shipping methods available!') }}</p>
                                        @endif
                                    </div>
                                    <br>
                                @endif
                            @endif

                            
                            
                            
                            
                            @if ($isShowAddressForm)
                                <div>
                                    <h5  @if(Session::get('otp')) hidden  @endif class="checkout-payment-title">{{ __('Shipping information') }}</h5>
                                    <input type="hidden" value="{{ route('public.checkout.save-information', $token) }}" id="save-shipping-information-url">
                                    @include('plugins/ecommerce::orders.partials.address-form', compact('sessionCheckoutData'))
                                </div>
                                <br>
                            @endif

                            @if (EcommerceHelper::isBillingAddressEnabled())
                                <div>
                                    <h5 class="checkout-payment-title">{{ __('Billing information') }}</h5>
                                    @include('plugins/ecommerce::orders.partials.billing-address-form', compact('sessionCheckoutData'))
                                </div>
                                <br>
                            @endif

                            
                            @if (is_plugin_active('payment'))
                                <div hidden class="position-relative">
                                    <div class="payment-info-loading" style="display: none;">
                                        <div class="payment-info-loading-content">
                                            <i class="fas fa-spinner fa-spin"></i>
                                        </div>
                                    </div>
                                    <h5 class="checkout-payment-title">{{ __('Payment method') }}</h5>
                                    <input type="hidden" name="amount" value="{{ format_price($orderAmount, null, true) }}">
                                    <input type="hidden" name="currency" value="{{ strtoupper(get_application_currency()->title) }}">
                                    @if (is_plugin_active('payment'))
                                        {!! apply_filters(PAYMENT_FILTER_PAYMENT_PARAMETERS, null) !!}
                                    @endif
                                    <ul class="list-group list_payment_method">
                                        @if ($orderAmount)
                                            {!! apply_filters(PAYMENT_FILTER_ADDITIONAL_PAYMENT_METHODS, null, [
                                                'amount' => format_price($orderAmount, null, true),
                                                'currency' => strtoupper(get_application_currency()->title),
                                                'name' => null,
                                                'selected' => PaymentMethods::getSelectedMethod(),
                                                'default' => PaymentMethods::getDefaultMethod(),
                                                'selecting' => PaymentMethods::getSelectingMethod(),
                                            ]) !!}

                                            {!! PaymentMethods::render() !!}
                                        @endif
                                    </ul>
                                </div>
                                <br>
                            @else
                                <input type="hidden" name="amount" value="{{ format_price($orderAmount, null, true) }}">
                            @endif

                            <div hidden @if(Session::get('otp')) hidden @endif class="form-group mb-3 @if ($errors->has('description')) has-error @endif">
                                <label for="description" class="control-label">{{ __('Order notes') }}</label>
                                <br>
                                <textarea name="description" id="description" rows="3" class="form-control" placeholder="{{ __('Notes about your order, e.g. special notes for delivery.') }}">{{Session::get('description')}}</textarea>
                                {!! Form::error('description', $errors) !!}
                            </div>

                            @if (EcommerceHelper::getMinimumOrderAmount() > Cart::instance('cart')->rawSubTotal())
                                <div class="alert alert-warning">
                                    {{ __('Minimum order amount is :amount, you need to buy more :more to place an order!', ['amount' => format_price(EcommerceHelper::getMinimumOrderAmount()), 'more' => format_price(EcommerceHelper::getMinimumOrderAmount() - Cart::instance('cart')->rawSubTotal())]) }}
                                </div>
                            @endif

                            @if(Session::get('otp'))

                            <div  class="form-group mb-3 mt-0 pt-0">
                                <div class="row">
                                 <div class="col-md-2 checkout-button-group mt-0 pt-0"></div>
                                    <div class="col-md-8 d-none d-md-block" style="line-height: 53px">
                                        <button type="submit" class="btn btn-dark payment-checkout-btn payment-checkout-btn-step float-end w-100" 
                                            data-processing-text="{{ __('Verifying. Please wait...') }}" data-error-header="{{ __('Error') }}">
                                            {{ __('تأكيد') }}</button>
                                    </div>
                                    <div class="col-md-2 checkout-button-group mt-0 pt-0"></div>
                                </div>
                                <div class="d-block d-md-none back-to-cart-button-group">
                                    <button type="submit" class="btn btn-dark payment-checkout-btn payment-checkout-btn-step float-end w-100" 
                                            data-processing-text="{{ __('Verifying. Please wait...') }}" data-error-header="{{ __('Error') }}">
                                            {{ __('تأكيد') }}</button>
                                </div>
                            </div>
                                     <div class="col-md-3" style="line-height: 53px">
                                        
                                     <a href="#" onclick="switchVisible();"/> لم تتلق الرمز؟ أعد الإرسال  !</a>
   
                                        
                                    </div>

                            @else
                            <div  class="form-group mb-3">
                                <div class="row">
                                    <div class="col-md-6 d-none d-md-block" style="line-height: 53px">
                                        <a class="text-info" href="{{ route('public.cart') }}"><i class="fas fa-long-arrow-alt-left"></i> <span class="d-inline-block back-to-cart">{{ __('Back to cart') }}</span></a>
                                    </div>
                                    <div class="col-md-6 checkout-button-group">
                                        @if (EcommerceHelper::isValidToProcessCheckout())
                                        
                                            <button type="submit" class="btn btn-dark payment-checkout-btn payment-checkout-btn-step float-end" 
                                            data-processing-text="{{ __('Processing. Please wait...') }}" data-error-header="{{ __('Error') }}">
                                            {{ __('Checkout') }}</button>

                                        @else
                                            <span class="btn payment-checkout-btn-step float-end disabled">
                                                {{ __('Checkout') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="d-block d-md-none back-to-cart-button-group">
                                    <a class="text-info" href="{{ route('public.cart') }}">
                                        <i class="fas fa-long-arrow-alt-left"></i>
                                        <span class="d-inline-block">{{ __('Back to cart') }}</span>
                                    </a>
                                </div>
                            </div>
 
                            @endif 
 
 
 
                        </div>
                    </div>
                </div>
            </div>
        {!! Form::close() !!}
        
        @if(Session::get('otp'))
        {!! Form::open(['route' => ['public.checkout.process', $token], 'class' => 'checkout-form payment-checkout-form', 'id' => 'checkout-form']) !!}
            <input type="hidden" name="checkout-token" id="checkout-token" value="{{ $token }}">
            <input type="hidden" name="SendCodeAgain" value="1">
                            @if (is_plugin_active('payment'))
                                <div hidden class="position-relative">
                                    <div class="payment-info-loading" style="display: none;">
                                        <div class="payment-info-loading-content">
                                            <i class="fas fa-spinner fa-spin"></i>
                                        </div>
                                    </div>
                                    <h5 class="checkout-payment-title">{{ __('Payment method') }}</h5>
                                    <input type="hidden" name="amount" value="{{ format_price($orderAmount, null, true) }}">
                                    <input type="hidden" name="currency" value="{{ strtoupper(get_application_currency()->title) }}">
                                    @if (is_plugin_active('payment'))
                                        {!! apply_filters(PAYMENT_FILTER_PAYMENT_PARAMETERS, null) !!}
                                    @endif
                                    <ul class="list-group list_payment_method">
                                        @if ($orderAmount)
                                            {!! apply_filters(PAYMENT_FILTER_ADDITIONAL_PAYMENT_METHODS, null, [
                                                'amount' => format_price($orderAmount, null, true),
                                                'currency' => strtoupper(get_application_currency()->title),
                                                'name' => null,
                                                'selected' => PaymentMethods::getSelectedMethod(),
                                                'default' => PaymentMethods::getDefaultMethod(),
                                                'selecting' => PaymentMethods::getSelectingMethod(),
                                            ]) !!}

                                            {!! PaymentMethods::render() !!}
                                        @endif
                                    </ul>
                                </div>
                                <br>
                            @else
                                <input type="hidden" name="amount" value="{{ format_price($orderAmount, null, true) }}">
                            @endif
                            
                            
                             @if (! is_plugin_active('marketplace'))
                                @if (Arr::get($sessionCheckoutData, 'is_available_shipping', true))
                                    <div  @if(Session::get('otp')) hidden  @endif id="shipping-method-wrapper">
                                        <h5 class="checkout-payment-title">{{ __('Shipping method') }}</h5>
                                        <div class="shipping-info-loading" style="display: none;">
                                            <div class="shipping-info-loading-content">
                                                <i class="fas fa-spinner fa-spin"></i>
                                            </div>
                                        </div>
                                        @if (!empty($shipping))
                                            <div class="payment-checkout-form">
                                                <input type="hidden" name="shipping_option" value="{{ old('shipping_option', $defaultShippingOption) }}">
                                                <ul class="list-group list_payment_method">
                                                    @foreach ($shipping as $shippingKey => $shippingItems)
                                                        @foreach($shippingItems as $shippingOption => $shippingItem)
                                                            @include('plugins/ecommerce::orders.partials.shipping-option', [
                                                                'shippingItem' => $shippingItem,
                                                                'attributes' =>[
                                                                    'id' => 'shipping-method-' . $shippingKey . '-' . $shippingOption,
                                                                    'name' => 'shipping_method',
                                                                    'class' => 'magic-radio shipping_method_input',
                                                                    'checked' => old('shipping_method', $defaultShippingMethod) == $shippingKey && old('shipping_option', $defaultShippingOption) == $shippingOption,
                                                                    'disabled' => Arr::get($shippingItem, 'disabled'),
                                                                    'data-option' => $shippingOption,
                                                                ],
                                                            ])
                                                        @endforeach
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @else
                                            <p>{{ __('No shipping methods available!') }}</p>
                                        @endif
                                    </div>
                                    <br>
                                @endif
                            @endif
                           
        <div @if(Session::get('otp')) hidden @endif class="form-group mb-3 @error('address.name') has-error @enderror">
            <div class="form-input-wrapper">
                <input type="text" name="address[name]" id="address_name"
                       class="form-control"
                       required
                       value="{{Session::get('name')}}">
                <label for='address_name'>{{ __('Full Name') }}</label>
            </div>
            {!! Form::error('address.name', $errors) !!}
        </div>
                            
                            

            <div class="container pt-0 mt-0" style="display:none;" id="sendAgain">
                <div class="row">
                    <div class="col-12" style="min-height:10vh!important; padding-top:25px!important;">

                            <div  class="form-group mb-3">
                                <div class="row">
                                    
                  <div class="col-2 checkout-button-group"></div>                                     
                  <div class="col-12 checkout-button-group">
                                                     
                <div class="form-group @error('phone') has-error @enderror">
                    <div class="form-input-wrapper">
                        <input type="tel" name="address[phone]" id="address_phone" max="10"
                               class="form-control"
                               value="{{Session::get('phone')}}">
                        <label for='address_phone'>{{ __('Phone') }} (079xxxxxxxx)</label>
                    </div>
                    {!! Form::error('address.phone', $errors) !!}
                </div>
            </div><div class="col-2 checkout-button-group"></div>                                                          

                                   
        <div @if(Session::get('otp')) hidden @endif class="form-group mb-3 @error('address.address') has-error @enderror">
            <div class="form-input-wrapper">
                <input id="address_address" type="text" class="form-control" required name="address[address]" value="{{Session::get('address')}}" autocomplete="false">
                <label for='address_address'>{{ __('Address') }}</label>
            </div>
            {!! Form::error('address.address', $errors) !!}
        </div>
        
        
                                    <div class="col-12 checkout-button-group">

                                            <button type="submit" name="SendSmsAgain" id="SendSmsAgain" value="1" class="btn btn-dark payment-checkout-btn payment-checkout-btn-step w-100" 
                                            data-processing-text="{{ __('Sending. Please wait...') }}" data-error-header="{{ __('Error') }}">
                                            <b>{{ __('ارسل الرمز مجددا') }}</b></button>

                                    </div>

                                </div></div></div> </div></div>
                            
         {!! Form::close() !!}

@endif

        @if (is_plugin_active('payment'))
            @include('plugins/payment::partials.footer')
        @endif
    @else
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="alert alert-warning my-5">
                        <span>{!! __('No products in cart. :link!', ['link' => Html::link(route('public.index'), __('Back to shopping'))]) !!}</span>
                    </div>
                </div>
            </div>
        </div>
    @endif
@stop

@push('footer')
    <script type="text/javascript" src="{{ asset('vendor/core/core/js-validation/js/js-validation.js')}}"></script>
    {!! JsValidator::formRequest(\Botble\Ecommerce\Http\Requests\SaveCheckoutInformationRequest::class, '#checkout-form'); !!}
    
    <script>
 function switchVisible() {
            if (document.getElementById('verify')) {

                if (document.getElementById('verify').style.display == 'none') {
                    document.getElementById('verify').style.display = 'block';
                    document.getElementById('sendAgain').style.display = 'none';
                }
                else {
                    document.getElementById('verify').style.display = 'none';
                    document.getElementById('sendAgain').style.display = 'block';
                }
            }
}   
    
    </script>
@endpush