<div class="shipment-info-panel hide-print">
    <div hidden class="shipment-info-header">
        <a target="_blank" href="{{ route('ecommerce.shipments.edit', $shipment->id) }}">
            <h4>{{ get_shipment_code($shipment->id) }}</h4>
        </a>
        <span class="label carrier-status carrier-status-{{ $shipment->status }}">{{ $shipment->status->label() }}</span>
    </div>

    <div class="pd-all-20 pt10">
        <div hidden class="flexbox-grid-form flexbox-grid-form-no-outside-padding rps-form-767 pt10">
            <div class="flexbox-grid-form-item ws-nm">
                <span>{{ trans('plugins/ecommerce::shipping.shipping_method') }}: <span><i>{{ $shipment->order->shipping_method_name }}</i></span></span>
            </div>
            <div hidden class="flexbox-grid-form-item rps-no-pd-none-r ws-nm">
                <span>{{ trans('plugins/ecommerce::shipping.weight_unit', ['unit' => ecommerce_weight_unit()]) }}:</span> <span><i>{{ $shipment->weight }} {{ ecommerce_weight_unit() }}</i></span>
            </div>
        </div>
        <div hidden class="flexbox-grid-form flexbox-grid-form-no-outside-padding rps-form-767 pt10">
            <div class="flexbox-grid-form-item ws-nm">
                <span>{{ trans('plugins/ecommerce::shipping.updated_at') }}:</span> <span><i>{{ $shipment->updated_at }}</i></span>
            </div>
            @if ((float)$shipment->cod_amount)
                <div class="flexbox-grid-form-item ws-nm rps-no-pd-none-r">
                    <span>{{ trans('plugins/ecommerce::shipping.cod_amount') }}:</span>
                    <span><i>{{ format_price($shipment->cod_amount) }}</i></span>
                </div>
            @endif
        </div>

        @if ($shipment->note)
            <div class="flexbox-grid-form flexbox-grid-form-no-outside-padding rps-form-767 pt10">
                <div class="flexbox-grid-form-item ws-nm rps-no-pd-none-r">
                    <span>{{ trans('plugins/ecommerce::shipping.delivery_note') }}:</span>
                    <strong><i>{{ $shipment->note }}</i></strong>
                </div>
            </div>
        @endif
    </div>
                        <div class="wrapper-content bg-gray-white mb20 text-center">
                            <div class="pd-all-20">
                         
                         
                              @php $ec_shipments=DB::table('ec_shipments')->where('order_id',$order->id)->first();@endphp
                               
                                @if($ec_shipments->status=="delivered" && $ec_shipments->date_shipped!=null)
                                
                                <a href="{{ route('orders.update-shipping-status', ['id' => $order->id]) }}" class="btn btn-warning me-2"><i class="fas fa-shipping-fast"></i> <b>Set Shipping As Pending</b></a>&nbsp;
                                @else
                                 <a href="{{ route('orders.update-shipping-status', ['id' => $order->id]) }}" class="btn btn-success me-2"><i class="fas fa-shipping-fast"></i> <b>Set Shipping As Delivered</b></a>&nbsp;
                                @endif
                                <br><br>
                                @if($order->status=="completed" && $order->completed_at!=null)
                                <a href="{{ route('orders.update-status', ['id' => $order->id]) }}" class="btn btn-danger me-2"><i class="fa fa-ban"></i> <b>Set Order As Pending</b></a>&nbsp;
                                @else
                                 <a href="{{ route('orders.update-status', ['id' => $order->id]) }}" class="btn btn-success me-2"><i class="fa fa-check-circle"></i> <b>Set Order As Completed</b></a>&nbsp;
                                @endif
                                <br><br>
                                @if ($order->canBeCanceledByAdmin())
                                    <a href="#" class="btn btn-danger btn-trigger-cancel-order me-2" data-target="{{ route('orders.cancel', $order->id) }}"><i class="fa fa-trash"></i> Cancel Order</a>
                                @endif

                                <a href="{{ route('orders.reorder', ['order_id' => $order->id]) }}" class="btn btn-info me-2"><i class="fa fa-refresh"></i> {{ trans('plugins/ecommerce::order.reorder') }}</a>&nbsp;
                                <br><br>
                                @if (in_array($shipment->status, [\Botble\Ecommerce\Enums\ShippingStatusEnum::PENDING, \Botble\Ecommerce\Enums\ShippingStatusEnum::PENDING]))
                                    <button hidden type="button" class="btn btn-secondary btn-destroy btn-cancel-shipment" data-action="{{ route('orders.cancel-shipment', $shipment->id) }}"><i class="fa fa-times"></i> {{ trans('plugins/ecommerce::shipping.cancel_shipping') }}</button>
                                @endif
            
                                <button hidden class="btn btn-warning ml10 btn-trigger-update-shipping-status me-2"><i class="fas fa-shipping-fast"></i> {{ trans('plugins/ecommerce::shipping.update_shipping_status') }}</button>
                                 
                                 <a href="{{ route('orders.generate-invoice', $order->id) }}?type=print" class="btn btn-primary me-2" target="_blank">
                                 <i class="fa fa-print"></i> {{ trans('plugins/ecommerce::order.print_invoice') }}</a>
                                 <a href="{{ route('orders.generate-invoice', $order->id) }}" class="btn btn-dark">
                                 <i class="fa fa-download"></i> {{ trans('plugins/ecommerce::order.download_invoice') }}</a>

                            </div>
                        </div>
                        
</div>
