<div class="product-gallery product-gallery--with-images row">
    <div class="product-gallery__wrapper">
        @forelse ($productImages as $key=> $img)
            <div class="product-gallery__imag item">
                <a class="img-fluid-eq" data-bs-toggle="modal" data-bs-target="#exampleModal{{$key}}">
                    <div class="img-fluid-eq__dummy"></div>
                    <div class="img-fluid-eq__wrap">
                        <img class="mx-auto" title="{{ $product->name }}" src="{{ image_placeholder($img) }}" data-lazy="{{ RvMedia::getImageUrl($img) }}">
                    </div>
                </a>
            </div>
        @empty
          
        @endforelse
    </div>
    <div class="product-gallery__variants px-1 py-1">
        @forelse ($productImages as $img)
            <div class="item">
                <div class="border p-1 m-1">
                    <img class="lazyload" title="{{ $product->name }}" src="{{ image_placeholder($img, 'thumb') }}" data-src="{{ RvMedia::getImageUrl($img, 'thumb') }}">
                </div>
            </div>
        @empty
           
        @endforelse
    </div>
</div>

@forelse ($productImages as $key=> $img)
<div class="modal fade" id="exampleModal{{$key}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg photo-galery-with-zoom">
    <div class="modal-content"> 
      <div class="modal-header text-center">
        <button type="button" class="btn btn-dark"  data-bs-dismiss="modal" aria-label="Close" style="z-index:100; margin-top:-400px!important; font-size:16px; border:1px solid red;">Close <i class="fa fa-window-close-o" aria-hidden="true"></i></button>
      </div>
      <div class="modal-body gallery-modal-body">
     <img  class="lazyload" title="{{ $product->name }}" src="{{ image_placeholder($img, 'thumb') }}" data-src="{{ RvMedia::getImageUrl($img, 'thumb') }}">

      </div>
    </div>
  </div>
</div>
@empty
@endforelse
