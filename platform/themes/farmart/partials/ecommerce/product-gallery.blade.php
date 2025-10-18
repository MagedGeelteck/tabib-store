<div class="product-gallery product-gallery--with-images row">
    <div class="product-gallery__wrapper">
        @php
            $identifier = $product->sku ?: $product->id;
        @endphp
        @forelse ($productImages as $key=> $img)
            @php
                $originalUrl = RvMedia::getImageUrl($img, null, false, RvMedia::getDefaultImage());
                $filename = basename(parse_url($originalUrl, PHP_URL_PATH));
                $compressedRelative = "storage/compressed-images/products-images/{$identifier}/{$filename}";
                $compressedPath = public_path($compressedRelative);

                $useCompressed = false;
                $compressedUrl = '';
                $width = $height = null;
                if (file_exists($compressedPath)) {
                    $useCompressed = true;
                    $compressedUrl = asset($compressedRelative);
                    try {
                        $size = @getimagesize($compressedPath);
                        if (!empty($size)) {
                            $width = $size[0];
                            $height = $size[1];
                        }
                    } catch (\Exception $e) {
                        // ignore
                    }
                }

                $imgUrl = $useCompressed ? $compressedUrl : RvMedia::getImageUrl($img);
                $thumbUrl = $useCompressed ? $compressedUrl : RvMedia::getImageUrl($img, 'thumb');
            @endphp
            <div class="product-gallery__imag item">
                <a class="img-fluid-eq" data-bs-toggle="modal" data-bs-target="#exampleModal{{$key}}">
                    <div class="img-fluid-eq__dummy"></div>
                    <div class="img-fluid-eq__wrap">
                        <img
                            class="mx-auto"
                            title="{{ $product->name }}"
                            src="{{ image_placeholder($img) }}"
                            data-src="{{ $imgUrl }}"
                            data-lazy="{{ $imgUrl }}"
                            @if($width && $height) width="{{ $width }}" height="{{ $height }}" @endif
                            @if ($loop->first) loading="eager" fetchpriority="high" @else loading="lazy" @endif
                            decoding="async"
                        >
                    </div>
                </a>
            </div>
        @empty
          
        @endforelse
    </div>
    <div class="product-gallery__variants px-1 py-1">
        @forelse ($productImages as $img)
            @php
                $originalThumb = RvMedia::getImageUrl($img, null, false, RvMedia::getDefaultImage());
                $thumbFilename = basename(parse_url($originalThumb, PHP_URL_PATH));
                // Try multiple common extensions in case compressed files were generated with a different extension
                $candidates = [];
                $candidates[] = $thumbFilename;
                $ext = pathinfo($thumbFilename, PATHINFO_EXTENSION);
                $nameOnly = pathinfo($thumbFilename, PATHINFO_FILENAME);
                foreach (['jpg', 'jpeg', 'png', 'webp'] as $tryExt) {
                    $candidates[] = $nameOnly . '.' . $tryExt;
                }

                $t = RvMedia::getImageUrl($img, 'thumb');
                $found = false;
                foreach (array_unique($candidates) as $candidate) {
                    $compressedThumbRelative = "storage/compressed-images/products-images/{$identifier}/{$candidate}";
                    $compressedThumbPath = public_path($compressedThumbRelative);
                    if (file_exists($compressedThumbPath)) {
                        $t = asset($compressedThumbRelative);
                        $found = true;
                        break;
                    }
                }
                // leave $t as RvMedia thumb if none of the compressed files found
            @endphp
            <div class="item">
                <div class="border p-1 m-1">
                    <img class="mx-auto" title="{{ $product->name }}" src="{{ $t }}" data-src="{{ $t }}" data-lazy="{{ $t }}">
                </div>
            </div>
        @empty
           
        @endforelse
    </div>
</div>

@forelse ($productImages as $key=> $img)
@php
    $originalUrl = RvMedia::getImageUrl($img, null, false, RvMedia::getDefaultImage());
    $filename = basename(parse_url($originalUrl, PHP_URL_PATH));
    $compressedRelative = "storage/compressed-images/products-images/{$identifier}/{$filename}";
    $compressedPath = public_path($compressedRelative);
    $modalSrc = file_exists($compressedPath) ? asset($compressedRelative) : RvMedia::getImageUrl($img, 'thumb');
@endphp
<div class="modal fade" id="exampleModal{{$key}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg photo-galery-with-zoom">
    <div class="modal-content"> 
      <div class="modal-header text-center">
        <button type="button" class="btn btn-dark"  data-bs-dismiss="modal" aria-label="Close" style="z-index:100; margin-top:-400px!important; font-size:16px; border:1px solid red;">Close <i class="fa fa-window-close-o" aria-hidden="true"></i></button>
      </div>
      <div class="modal-body gallery-modal-body">
     <img  class="lazyload" title="{{ $product->name }}" src="{{ image_placeholder($modalSrc, 'thumb') }}" data-src="{{ $modalSrc }}">

      </div>
    </div>
  </div>
</div>
@empty
@endforelse
