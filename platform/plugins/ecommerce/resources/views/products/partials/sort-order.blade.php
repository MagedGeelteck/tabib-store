@php 
$count=DB::table('ec_order_product')->where('product_id',$item->id)->count('product_id');
$categories=DB::table('ec_product_category_product')->where('product_id',$item->id)->get();


@endphp 


<p><small><b></b></small></p>

@if($item->status!='published')
<a href="products/update-status/{{$item->id}}" class="btn btn-danger w-100"><b><i class="fa fa-ban" ></i> Disable</b></a>
@else
<a href="products/update-status/{{$item->id}}" class="btn btn-success w-100"><b><i class="fa fa-check" ></i> Activate</b></a>
@endif

@foreach($categories as $category)

@php $category_names=DB::table('ec_product_categories')->where('id',$category->category_id)->first();@endphp 


<span class="label-primary status-label w-100">{{$category_names->name}}</span>

@endforeach

<br><br><p><small><b>Orders Count : <span class="text text-success">{{$count}}</span></b></small></p>





