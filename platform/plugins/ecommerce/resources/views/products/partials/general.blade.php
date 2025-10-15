{!! apply_filters('ecommerce_product_variation_form_start', null, $product) !!}
<div class="row price-group">
    <input type="hidden"
           value="{{ old('sale_type', $product ? $product->sale_type : 0) }}"
           class="detect-schedule hidden"
           name="sale_type">

    <div class="col-lg-4 col-md-4">
        <div class="form-group mb-3 @if ($errors->has('sku')) has-error @endif">
            <label class="text-title-field required">{{ trans('plugins/ecommerce::products.sku') }}</label>
            {!! Form::text('sku', old('sku', $product ? $product->sku : null), ['class' => 'next-input', 'id' => 'sku','required'=>'required']) !!}
        </div>
        @if (($isVariation && !$product) || ($product && $product->is_variation && !$product->sku))
            <div class="form-group mb-3">
                <label required class="text-title-field required"></label>
                    <input type="hidden" name="auto_generate_sku" value="0"  required="required">
                    <input type="checkbox" name="auto_generate_sku" value="1" required="required">
                    &nbsp;{{ trans('plugins/ecommerce::products.form.auto_generate_sku') }}
            </div>
        @endif
    </div>

    <div class="col-lg-4 col-md-4">
        <div class="form-group mb-3">
            <label required class="text-title-field required">{{ trans('plugins/ecommerce::products.form.price') }}</label>
            <div class="next-input--stylized">
                <span class="next-input-add-on next-input__add-on--before">{{ get_application_currency()->symbol }}</span>
                <input name="price"
                       class="next-input input-mask-number regular-price next-input--invisible required"
                       data-thousands-separator="{{ EcommerceHelper::getThousandSeparatorForInputMask() }}" data-decimal-separator="{{ EcommerceHelper::getDecimalSeparatorForInputMask() }}"
                       step="any"
                       value="{{ old('price', $product ? $product->price : ($originalProduct->price ?? '')) }}"
                       type="text" required="required">
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-4">
        <div class="form-group mb-3">
            <label class="text-title-field">
                <span>{{ trans('plugins/ecommerce::products.form.price_sale') }}</span>
                <a href="javascript:;"
                   class="turn-on-schedule @if (old('sale_type', $product ? $product->sale_type : ($originalProduct->sale_type ?? 0)) == 1) hidden @endif">{{ trans('plugins/ecommerce::products.form.choose_discount_period') }}</a>
                <a href="javascript:;"
                   class="turn-off-schedule @if (old('sale_type', $product ? $product->sale_type : ($originalProduct->sale_type ?? 0)) == 0) hidden @endif">{{ trans('plugins/ecommerce::products.form.cancel') }}</a>
            </label>
            <div class="next-input--stylized">
                <span class="next-input-add-on next-input__add-on--before">{{ get_application_currency()->symbol }}</span>
                <input name="sale_price"
                       class="next-input input-mask-number sale-price next-input--invisible"
                       data-thousands-separator="{{ EcommerceHelper::getThousandSeparatorForInputMask() }}" data-decimal-separator="{{ EcommerceHelper::getDecimalSeparatorForInputMask() }}"
                       value="{{ old('sale_price', $product ? $product->sale_price : ($originalProduct->sale_price ?? null)) }}"
                       type="text">
            </div>
        </div>
    </div>
    
    
<hr/>

{!! apply_filters('ecommerce_product_variation_form_middle', null, $product) !!}

<div class="form-group mb-1">
    <div class="storehouse-management">
        <div class="mt5">
            <input type="hidden" name="with_storehouse_management" value="0">
            <label><input type="checkbox" class="storehouse-management-status" value="1" name="with_storehouse_management" @if (old('with_storehouse_management', $product ? $product->with_storehouse_management : ($originalProduct->with_storehouse_management ?? 0)) == 1) checked @endif> {{ trans('plugins/ecommerce::products.form.storehouse.storehouse') }}</label>
        </div>
    </div>
</div>
<div class="storehouse-info @if (old('with_storehouse_management', $product ? $product->with_storehouse_management : ($originalProduct->with_storehouse_management ?? 0)) == 0) hidden @endif">
    <div class="form-group mb-1">
        <label class="text-title-field">{{ trans('plugins/ecommerce::products.form.storehouse.quantity') }}</label>
        <input type="text"
               class="next-input input-mask-number input-medium"
               value="{{ old('quantity', $product ? $product->quantity : ($originalProduct->quantity ?? 0)) }}"
               name="quantity">
    </div>
</div>

<div class="form-group stock-status-wrapper @if (old('with_storehouse_management', $product ? $product->with_storehouse_management : ($originalProduct->with_storehouse_management ?? 0)) == 1) hidden @endif">
    <label class="text-title-field">{{ trans('plugins/ecommerce::products.form.stock_status') }}</label>
    {!! Form::customSelect('stock_status', \Botble\Ecommerce\Enums\StockStatusEnum::labels(), $product ? $product->stock_status : null) !!}
</div>



    <div class="row">
        
       <div hidden class="col-md-6">
           <div class="form-group mb-3">
               <label class="text-title-field">{{ trans('plugins/ecommerce::products.form.cost_per_item') }}</label>
               <div class="next-input--stylized">
                   <span class="next-input-add-on next-input__add-on--before">{{ get_application_currency()->symbol }}</span>
                   <input name="cost_per_item"
                          class="next-input input-mask-number regular-price next-input--invisible"
                          step="any"
                          value="{{ old('cost_per_item', $product ? $product->cost_per_item : ($originalProduct->cost_per_item ?? 0)) }}"
                          type="text"
                          placeholder="{{ trans('plugins/ecommerce::products.form.cost_per_item_placeholder') }}">
               </div>
               {!! Form::helper(trans('plugins/ecommerce::products.form.cost_per_item_helper')) !!}
           </div>
       </div>
        <input type="hidden" value="{{ $product->id ?? null }}" name="product_id">
        <div hidden class="col-md-6">
            <div class="form-group mb-3">
                <label class="text-title-field">{{ trans('plugins/ecommerce::products.form.barcode') }}</label>
                <div class="next-input--stylized">
                    <input name="barcode"
                           class="next-input next-input--invisible"
                           step="any"
                           value="{{ old('barcode', $product ? $product->barcode : ($originalProduct->barcode ?? null)) }}"
                           type="text"
                           placeholder="{{ trans('plugins/ecommerce::products.form.barcode_placeholder') }}">
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 scheduled-time @if (old('sale_type', $product ? $product->sale_type : ($originalProduct->sale_type ?? 0)) == 0) hidden @endif">
        <div class="form-group mb-3">
            <label class="text-title-field">{{ trans('plugins/ecommerce::products.form.date.start') }}</label>
            <input name="start_date"
                   class="next-input form-date-time"
                   value="{{ old('start_date', $product ? $product->start_date : ($originalProduct->start_date ?? null)) }}"
                   type="text">
        </div>
    </div>
    <div class="col-md-6 scheduled-time @if (old('sale_type', $product ? $product->sale_type : ($originalProduct->sale_type ?? 0)) == 0) hidden @endif">
        <div class="form-group mb-3">
            <label class="text-title-field">{{ trans('plugins/ecommerce::products.form.date.end') }}</label>
            <input name="end_date"
                   class="next-input form-date-time"
                   value="{{ old('end_date', $product ? $product->end_date : ($originalProduct->end_date ?? null)) }}"
                   type="text">
        </div>
    </div>
</div>


{!! apply_filters('ecommerce_product_variation_form_middle', null, $product) !!}



<div hidden class="form-group stock-status-wrapper @if (old('with_storehouse_management', $product ? $product->with_storehouse_management : ($originalProduct->with_storehouse_management ?? 0)) == 1) hidden @endif">
    <label class="text-title-field">{{ trans('plugins/ecommerce::products.form.stock_status') }}</label>
    {!! Form::customSelect('stock_status', \Botble\Ecommerce\Enums\StockStatusEnum::labels(), $product ? $product->stock_status : null) !!}
</div>




@if (EcommerceHelper::isEnabledSupportDigitalProducts() &&
    ((!$product && !$originalProduct && request()->input('product_type') == Botble\Ecommerce\Enums\ProductTypeEnum::DIGITAL) ||
        ($originalProduct && $originalProduct->isTypeDigital()) ||
        ($product && $product->isTypeDigital())))
    <div class="mb-3 product-type-digital-management">
        <label for="product_file">{{ trans('plugins/ecommerce::products.digital_attachments.title') }}</label>
        <table class="table border">
            <thead>
                <tr>
                    <th width="40"></th>
                    <th>{{ trans('plugins/ecommerce::products.digital_attachments.file_name') }}</th>
                    <th width="100">{{ trans('plugins/ecommerce::products.digital_attachments.file_size') }}</th>
                    <th width="100">{{ trans('core/base::tables.created_at') }}</th>
                    <th class="text-end" width="100"></th>
                </tr>
            </thead>
            <tbody>
                @if ($product)
                    @foreach ($product->productFiles as $file)
                        <tr>
                            <td>
                                {!! Form::checkbox('product_files[' . $file->id . ']', 0, true, ['class' => 'd-none']) !!}
                                {!! Form::checkbox('product_files[' . $file->id . ']', $file->id, true, ['class' => 'digital-attachment-checkbox']) !!}
                            </td>
                            <td>
                                <div>
                                    <i class="fas fa-paperclip"></i>
                                    <span>{{ $file->basename }}</span>
                                </div>
                            </td>
                            <td>{{ BaseHelper::humanFileSize($file->file_size) }}</td>
                            <td>{{ BaseHelper::formatDate($file->created_at) }}</td>
                            <td class="text-end"></td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
        <div class="digital_attachments_input">
            <input type="file" name="product_files_input[]" data-id="{{ Str::random(10) }}">
        </div>
        <div class="mt-2">
            <a href="#" class="digital_attachments_btn">{{ trans('plugins/ecommerce::products.digital_attachments.add') }}</a>
        </div>
    </div>
    <script type="text/x-custom-template" id="digital_attachment_template">
        <tr data-id="__id__">
            <td>
                <a class="text-danger remove-attachment-input"><i class="fas fa-minus-circle"></i></a>
            </td>
            <td>
                <i class="fas fa-paperclip"></i>
                <span>__file_name__</span>
            </td>
            <td>__file_size__</td>
            <td>-</td>
            <td class="text-end">
                <span class="text-warning">{{ trans('plugins/ecommerce::products.digital_attachments.unsaved') }}</span>
            </td>
        </tr>
    </script>
@endif

{!! apply_filters('ecommerce_product_variation_form_end', null, $product) !!}
