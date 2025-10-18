<div class="product-gallery product-gallery--with-images row">
    <div class="product-gallery__wrapper">
        @php
            $identifier = $product->sku ?: $product->id;
        @endphp
        @forelse ($productImages as $key=> $img)
            @php
                $originalUrl = RvMedia::getImageUrl($img, null, false, RvMedia::getDefaultImage());
                $filename = basename(parse_url($originalUrl, PHP_URL_PATH));

                // Candidate relative paths (in priority order). First prefer compressed images,
                // then fall back to the original uploads location(s).
                $candidates = [
                    "storage/products-images/{$identifier}/{$filename}",
                    // some installs store uploads without per-sku folders
                    "storage/products-images/{$filename}",
                    // also try at the root of public storage (in case files were moved)
                    "public/storage/products-images/{$identifier}/{$filename}",
                    "public/storage/products-images/{$filename}",
                ];

                $foundPath = '';
                $foundUrl = '';
                $width = $height = null;
                foreach ($candidates as $rel) {
                    $p = public_path($rel);
                    if (file_exists($p)) {
                        $foundPath = $p;
                        $foundUrl = asset($rel);
                        try {
                            $size = @getimagesize($p);
                            if (!empty($size)) {
                                $width = $size[0];
                                $height = $size[1];
                            }
                        } catch (\Exception $e) {
                            // ignore
                        }
                        break;
                    }
                }

                // Fallback to RvMedia URL if none of the local files were found
                $imgUrl = $foundUrl ?: RvMedia::getImageUrl($img);
                $thumbUrl = $foundUrl ?: RvMedia::getImageUrl($img, 'thumb');
            @endphp
            <div class="product-gallery__imag item">
                <a class="img-fluid-eq" data-bs-toggle="modal" data-bs-target="#exampleModal{{$key}}">
                    <div class="img-fluid-eq__dummy"></div>
                    <div class="img-fluid-eq__wrap">
                        <img
                            class="mx-auto lazyload"
                            title="{{ $product->name }}"
                            src="{{ image_placeholder($imgUrl) }}"
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
                $nameOnly = pathinfo($thumbFilename, PATHINFO_FILENAME);
                foreach (['jpg', 'jpeg', 'png', 'webp'] as $tryExt) {
                    $candidates[] = $nameOnly . '.' . $tryExt;
                }

                // Try the same candidate paths we used for the main slides
                $thumbUrl = RvMedia::getImageUrl($img, 'thumb');
                foreach (array_unique($candidates) as $candidate) {
                    $tryList = [
                        "storage/images/products-images/{$identifier}/{$candidate}",
                        "storage/products-images/{$identifier}/{$candidate}",
                        "storage/products-images/{$candidate}",
                        "public/storage/products-images/{$identifier}/{$candidate}",
                        "public/storage/products-images/{$candidate}",
                    ];
                    foreach ($tryList as $rel) {
                        $p = public_path($rel);
                        if (file_exists($p)) {
                            $thumbUrl = asset($rel);
                            break 2;    
                        }
                    }
                }
            @endphp
            <div class="item">
                <div class="border p-1 m-1">
                    <img class="mx-auto lazyload" title="{{ $product->name }}" src="{{ image_placeholder($thumbUrl) }}" data-src="{{ $thumbUrl }}" data-lazy="{{ $thumbUrl }}">
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
    $compressedRelative = "storage/products-images/{$identifier}/{$filename}";
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
