@php

$tag_ids=DB::table('ec_product_tag_product')->where(['product_id'=>$product->id])->pluck('tag_id');
$tags=DB::table('ec_product_tags')->whereIn('id', $tag_ids)->get();

@endphp

@if($tags)
<div class="summary-meta">
@foreach($tags as $tag)

                <div class="product-stock in-stock d-inline-block">
                {{$tag->name}}
            </div>

@endforeach
</div>
@endif