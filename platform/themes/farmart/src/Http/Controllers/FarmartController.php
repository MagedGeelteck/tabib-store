<?php

namespace Theme\Farmart\Http\Controllers;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Ecommerce\Models\Product;
use Botble\Ecommerce\Repositories\Interfaces\FlashSaleInterface;
use Botble\Ecommerce\Repositories\Interfaces\ProductCategoryInterface;
use Botble\Ecommerce\Repositories\Interfaces\ProductInterface;
use Botble\Ecommerce\Repositories\Interfaces\WishlistInterface;
use Botble\Ecommerce\Services\Products\GetProductService;
use Botble\Theme\Http\Controllers\PublicController;
use Cart;
use EcommerceHelper;
use EmailHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Theme;
use Theme\Farmart\Http\Resources\BrandResource;
use Theme\Farmart\Http\Resources\ProductCategoryResource;
use Theme\Farmart\Http\Resources\ReviewResource;
use DB;
use Session;
use SlugHelper;
use BaseHelper;
use RvMedia;
use File;
use Image;

class FarmartController extends PublicController
{
    protected BaseHttpResponse $httpResponse;

    public function __construct(BaseHttpResponse $response)
    {
        $this->httpResponse = $response;

        $this->middleware(function ($request, $next) {
            if (! $request->ajax()) {
                return $this->httpResponse->setNextUrl(route('public.index'));
            }

            return $next($request);
        })->only([
            'ajaxGetProducts',
            'ajaxGetFeaturedProductCategories',
            'ajaxGetFeaturedBrands',
            'ajaxGetFlashSale',
            'ajaxGetFeaturedProducts',
            'ajaxGetProductsByCategoryId',
            'ajaxCart',
            'ajaxGetQuickView',
            'ajaxAddProductToWishlist',
            'ajaxGetRelatedProducts',
            'ajaxSearchProducts',
            'ajaxGetProductReviews',
            'ajaxGetProductCategories',
            'ajaxGetRecentlyViewedProducts',
            'ajaxContactSeller',
        ]);
    }
    
    public function getProductByCategory(Request $request , $category_id)
    {
        
    $all_categories = get_featured_product_categories();
    $categories=false;  
    $parent=false;
    $products_array=[];
    $third_subcats=false; 
    $parent_sub=false;
    $subcats=false;
    $product_categories_ids=DB::table('ec_product_category_product')->where('category_id',$category_id)->pluck('product_id');
    $products =DB::table('ec_products')->where(['status'=>'published'])->whereIn('id',$product_categories_ids)->orderBy('name','asc')->paginate(24);
    
    $check_if_category_has_child=DB::table('ec_product_categories')->where('parent_id',$category_id)->first();
    $main_cat=DB::table('ec_product_categories')->where('id',$category_id)->first();

    
    if($main_cat->parent_id==0){
    $subcats=DB::table('ec_product_categories')->where('parent_id',$category_id)->orderBy('order','asc')->get();
    $parent=$category_id;    

    }else{
    
    if(empty($check_if_category_has_child)){
    $main_cat=DB::table('ec_product_categories')->where('id',$category_id)->first();
    $main_cat_id=DB::table('ec_product_categories')->where('id',$main_cat->parent_id)->first();
    if(!empty($main_cat_id)){
    if($main_cat_id->parent_id==0){
    $all_categories=[];
    }}
    $subcats=DB::table('ec_product_categories')->where('parent_id',$main_cat_id->parent_id)->orderBy('order','asc')->get();
    $third_subcats=DB::table('ec_product_categories')->where('parent_id',$main_cat->parent_id)->orderBy('order','asc')->get();
    $parent=$main_cat_id->parent_id;
    $parent_sub=$main_cat->parent_id; 

    }else{
    $subcats=DB::table('ec_product_categories')->where('parent_id',$category_id)->orderBy('order','asc')->get();
    if($subcats){
    $main_cat=DB::table('ec_product_categories')->where('id',$category_id)->first();
    if($main_cat->parent_id!=0){
    $parent=$main_cat->parent_id;    
    $subcats=DB::table('ec_product_categories')->where('parent_id',$main_cat->parent_id)->orderBy('order','asc')->get();
    $third_subcats=DB::table('ec_product_categories')->where('parent_id',$category_id)->orderBy('order','asc')->get();
    }}}
    }

   $links = $products->links();
     $start=0;
    foreach($products as $product){
       $start++; 
     $products_images=$product->images;
     $products_images = json_decode($products_images, TRUE);

     $slug=DB::table('slugs')->where(['prefix'=>'products','reference_id'=>$product->id])->first();
     $endingURL = config('core.base.general.public_single_ending_url');
     $product->url='/products/'.$slug->key.$endingURL;

     if(BaseHelper::siteLanguageDirection() != 'rtl'){
     $ec_products_translations=DB::table('ec_products_translations')->where(['lang_code'=>'en_US','ec_products_id'=>$product->id])->first();
     $product->name=$ec_products_translations->name;}
     
     if(!empty($products_images[0])){
     $product->image=$products_images[0];
     }
     
     $or_path=public_path('storage/'.$product->image);
     $new_path = public_path('storage/compressed-images/'.$product->image);     
     if(!file_exists($new_path) && file_exists($or_path)){
     File::makeDirectory(dirname($new_path), $mode = 0777, true, true);
     $check=compress($or_path,$new_path,100);
     if($check)
     Image::make($new_path)->fit(170, 170)->save($new_path);
     }
     
     array_push($products_array,$product);
     }
    $products =$products_array;

    return Theme::scope('views.productCategory',compact('parent_sub','third_subcats','products','links','subcats','all_categories','parent'))->render();
        
    }
    
   

    public function index(Request $request)
    {
        
    $categories = get_featured_product_categories();
    $all_categories = get_featured_product_categories();
    $subcats=false;
    
    
    $products_array=[];
    $products =DB::table('ec_products')->where(['status'=>'published'])->orderBy('name','asc')->paginate(24);

    $links = $products->links();

    foreach($products as $product){
        
     $products_images=$product->images;
     $products_images = json_decode($products_images, TRUE);

     $slug=DB::table('slugs')->where(['prefix'=>'products','reference_id'=>$product->id])->first();
     $endingURL = config('core.base.general.public_single_ending_url');
     $product->url='/products/'.$slug->key.$endingURL;

     if(BaseHelper::siteLanguageDirection() != 'rtl'){
     $ec_products_translations=DB::table('ec_products_translations')->where(['lang_code'=>'en_US','ec_products_id'=>$product->id])->first();
     $product->name=$ec_products_translations->name;}
     
     if(!empty($products_images[0])){
     $product->image=$products_images[0];
     }
     
     $or_path=public_path('storage/'.$product->image);
     $new_path = public_path('storage/compressed-images/'.$product->image);     
     if(!file_exists($new_path) && file_exists($or_path)){
     File::makeDirectory(dirname($new_path), $mode = 0777, true, true);
     $check=compress($or_path,$new_path,100);
     if($check)
     Image::make($new_path)->fit(170, 170)->save($new_path);
     }
     
     array_push($products_array,$product);
     }
    $products =$products_array;

    return Theme::scope('views.index',compact('products','links','categories','all_categories'))->render();
        
    }
    
    
    
    protected function getWishlistIds(array $productIds = []): array
    {
        if (! EcommerceHelper::isWishlistEnabled()) {
            return [];
        }

        if (auth('customer')->check()) {
            return auth('customer')->user()->wishlist()->whereIn('product_id', $productIds)->pluck('product_id')->all();
        }

        return collect(Cart::instance('wishlist')->content())
            ->sortBy([['updated_at', 'desc']])
            ->whereIn('id', $productIds)
            ->pluck('id')
            ->all();
    }

    public function ajaxGetProducts(Request $request)
    {
        $products = get_products_by_collections([
                'collections' => [
                    'by' => 'id',
                    'value_in' => [$request->integer('collection_id')],
                ],
                'take' => $request->integer('limit', 10),
                'with' => [
                    'slugable',
                    'variations',
                    'productCollections',
                    'variationAttributeSwatchesForProductList',
                ],
            ] + EcommerceHelper::withReviewsParams());

        $wishlistIds = $this->getWishlistIds($products->pluck('id')->all());

        $data = [];
        foreach ($products as $product) {
            $data[] = Theme::partial('ecommerce.product-item', compact('product', 'wishlistIds'));
        }

        return $this->httpResponse->setData($data);
    }

    public function ajaxGetFeaturedProductCategories()
    {
        $categories = get_featured_product_categories(['take' => null]);

        return $this->httpResponse->setData(ProductCategoryResource::collection($categories));
    }

    public function ajaxGetFeaturedBrands()
    {
        $brands = get_featured_brands();

        return $this->httpResponse->setData(BrandResource::collection($brands));
    }

    public function ajaxGetFlashSale(int|string $id, FlashSaleInterface $flashSaleRepository)
    {
        $flashSale = $flashSaleRepository->getModel()
            ->notExpired()
            ->where('id', $id)
            ->where('status', BaseStatusEnum::PUBLISHED)
            ->with([
                'products' => function ($query) {
                    $reviewParams = EcommerceHelper::withReviewsParams();

                    if (EcommerceHelper::isReviewEnabled()) {
                        $query->withAvg($reviewParams['withAvg'][0], $reviewParams['withAvg'][1]);
                    }

                    return $query
                        ->where('status', BaseStatusEnum::PUBLISHED)
                        ->withCount($reviewParams['withCount']);
                },
            ])
            ->first();

        if (! $flashSale) {
            return $this->httpResponse->setData([]);
        }

        $data = [];
        $isFlashSale = true;
        $wishlistIds = $this->getWishlistIds($flashSale->products->pluck('id')->all());

        foreach ($flashSale->products as $product) {
            if (! EcommerceHelper::showOutOfStockProducts() && $product->isOutOfStock()) {
                continue;
            }

            $data[] = Theme::partial('ecommerce.product-item', compact('product', 'flashSale', 'isFlashSale', 'wishlistIds'));
        }

        return $this->httpResponse->setData($data);
    }

    public function ajaxGetFeaturedProducts(Request $request)
    {
        $data = [];

        $products = get_featured_products([
                'take' => $request->integer('limit', 10),
                'with' => [
                    'slugable',
                    'variations',
                    'productCollections',
                    'variationAttributeSwatchesForProductList',
                ],
            ] + EcommerceHelper::withReviewsParams());

        $wishlistIds = $this->getWishlistIds($products->pluck('id')->all());

        foreach ($products as $product) {
            $data[] = Theme::partial('ecommerce.product-item', compact('product', 'wishlistIds'));
        }

        return $this->httpResponse->setData($data);
    }

    public function ajaxGetProductsByCategoryId(
        Request $request,
        ProductInterface $productRepository,
        ProductCategoryInterface $productCategoryRepository
    ) {
        $categoryId = $request->input('category_id');

        if (! $categoryId) {
            return $this->httpResponse;
        }

        $category = $productCategoryRepository->findOrFail($categoryId);

        $products = $productRepository->getProductsByCategories([
                'categories' => [
                    'by' => 'id',
                    'value_in' => array_merge([$category->id], $category->activeChildren->pluck('id')->all()),
                ],
                'take' => $request->integer('limit', 10),
            ] + EcommerceHelper::withReviewsParams());

        $wishlistIds = $this->getWishlistIds($products->pluck('id')->all());

        $data = [];
        foreach ($products as $product) {
            $data[] = Theme::partial('ecommerce.product-item', compact('product', 'wishlistIds'));
        }

        return $this->httpResponse->setData($data);
    }

    public function ajaxCart()
    {
        return $this->httpResponse->setData([
            'count' => Cart::instance('cart')->count(),
            'total_price' => format_price(Cart::instance('cart')->rawSubTotal() + Cart::instance('cart')->rawTax()),
            'html' => Theme::partial('cart-mini.list'),
        ]);
    }

    public function ajaxGetQuickView(Request $request, int|string|null $id = null)
    {
        if (! $id) {
            $id = $request->integer('product_id');
        }

        $product = null;

        if ($id) {
            $product = get_products([
                    'condition' => [
                        'ec_products.id' => $id,
                        'ec_products.status' => BaseStatusEnum::PUBLISHED,
                    ],
                    'take' => 1,
                    'with' => [
                        'slugable',
                        'tags',
                        'tags.slugable',
                        'options' => function ($query) {
                            return $query->with('values');
                        },
                    ],
                ] + EcommerceHelper::withReviewsParams());
        }

        if (! $product) {
            return $this->httpResponse->setError()->setMessage(__('This product is not available.'));
        }

        [$productImages, $productVariation, $selectedAttrs] = EcommerceHelper::getProductVariationInfo($product);

        $wishlistIds = $this->getWishlistIds([$product->id]);

        return $this
            ->httpResponse
            ->setData(Theme::partial('ecommerce.quick-view', compact('product', 'selectedAttrs', 'productImages', 'productVariation', 'wishlistIds')));
    }

    public function ajaxAddProductToWishlist(Request $request, ProductInterface $productRepository, WishlistInterface $wishlistRepository, $productId = null)
    {
        if (! EcommerceHelper::isWishlistEnabled()) {
            abort(404);
        }
        if (! $productId) {
            $productId = $request->input('product_id');
        }

        if (! $productId) {
            return $this->httpResponse->setError()->setMessage(__('This product is not available.'));
        }
        $product = $productRepository->findOrFail($productId);

        $messageAdded = __('Added product :product successfully!', ['product' => $product->name]);
        $messageRemoved = __('Removed product :product from wishlist successfully!', ['product' => $product->name]);

        if (! auth('customer')->check()) {
            $duplicates = Cart::instance('wishlist')->search(function ($cartItem) use ($productId) {
                return $cartItem->id == $productId;
            });

            if (! $duplicates->isEmpty()) {
                $added = false;
                Cart::instance('wishlist')->search(function ($cartItem, $rowId) use ($productId) {
                    if ($cartItem->id == $productId) {
                        Cart::instance('wishlist')->remove($rowId);

                        return true;
                    }

                    return false;
                });
            } else {
                $added = true;
                Cart::instance('wishlist')
                    ->add($productId, $product->name, 1, $product->front_sale_price)
                    ->associate(Product::class);
            }

            return $this->httpResponse
                ->setMessage($added ? $messageAdded : $messageRemoved)
                ->setData([
                    'count' => Cart::instance('wishlist')->count(),
                    'added' => $added,
                ]);
        }

        $customer = auth('customer')->user();

        if (is_added_to_wishlist($productId)) {
            $added = false;
            $wishlistRepository->deleteBy([
                'product_id' => $productId,
                'customer_id' => $customer->getKey(),
            ]);
        } else {
            $added = true;
            $wishlistRepository->createOrUpdate([
                'product_id' => $productId,
                'customer_id' => $customer->getKey(),
            ]);
        }

        return $this->httpResponse
            ->setMessage($added ? $messageAdded : $messageRemoved)
            ->setData([
                'count' => $customer->wishlist()->count(),
                'added' => $added,
            ]);
    }

    public function ajaxGetRelatedProducts(
        int|string $id,
        Request $request,
        ProductInterface $productRepository
    ) {
        $product = $productRepository->findOrFail($id);

        $products = get_related_products($product, $request->input('limit'));

        $data = [];
        foreach ($products as $product) {
            $data[] = Theme::partial('ecommerce.product-item', compact('product'));
        }

        return $this->httpResponse->setData($data);
    }

    public function ajaxSearchProducts(Request $request, GetProductService $productService)
    {
        $request->merge(['num' => 12]);

        $with = [
            'slugable',
            'variations',
            'productCollections',
            'variationAttributeSwatchesForProductList',
        ];

        $products = $productService->getProduct($request, null, null, $with);

        $queries = $request->input();
        foreach ($queries as $key => $query) {
            if (! $query || $key == 'num' || (is_array($query) && ! Arr::get($query, 0))) {
                unset($queries[$key]);
            }
        }

        $total = $products->count();
        $message = $total != 1 ? __(':total Products found', compact('total')) : __(':total Product found', compact('total'));

        return $this->httpResponse
            ->setData(Theme::partial('ajax-search-results', compact('products', 'queries')))
            ->setMessage($message);
    }

    public function ajaxGetProductReviews(
        int|string $id,
        Request $request,
        ProductInterface $productRepository
    ) {
        $product = $productRepository->getFirstBy([
            'id' => $id,
            'status' => BaseStatusEnum::PUBLISHED,
            'is_variation' => 0,
        ], [], ['variations']);

        if (! $product) {
            abort(404);
        }

        $star = $request->integer('star');
        $perPage = $request->integer('per_page', 10);

        $reviews = EcommerceHelper::getProductReviews($product, $star, $perPage);

        if ($star) {
            $message = __(':total review(s) ":star star" for ":product"', [
                'total' => $reviews->total(),
                'product' => $product->name,
                'star' => $star,
            ]);
        } else {
            $message = __(':total review(s) for ":product"', [
                'total' => $reviews->total(),
                'product' => $product->name,
            ]);
        }

        return $this->httpResponse
            ->setData(ReviewResource::collection($reviews))
            ->setMessage($message)
            ->toApiResponse();
    }

    public function ajaxGetProductCategories(
        Request $request,
        BaseHttpResponse $response,
        ProductCategoryInterface $productCategoryRepository
    ) {
        $categoryIds = $request->input('categories', []);
        if (empty($categoryIds)) {
            return $response;
        }

        $categories = $productCategoryRepository->advancedGet([
            'condition' => [
                'status' => BaseStatusEnum::PUBLISHED,
                ['id', 'IN', $categoryIds],
            ],
            'with' => ['slugable'],
        ]);

        return $response->setData(ProductCategoryResource::collection($categories));
    }

    public function ajaxGetRecentlyViewedProducts(ProductInterface $productRepository)
    {
        if (! EcommerceHelper::isEnabledCustomerRecentlyViewedProducts()) {
            abort(404);
        }

        $queryParams = [
                'with' => ['slugable'],
                'take' => 12,
            ] + EcommerceHelper::withReviewsParams();

        if (auth('customer')->check()) {
            $products = $productRepository->getProductsRecentlyViewed(auth('customer')->id(), $queryParams);
        } else {
            $products = collect();

            $itemIds = collect(Cart::instance('recently_viewed')->content())
                ->sortBy([['updated_at', 'desc']])
                ->take(12)
                ->pluck('id')
                ->all();

            if ($itemIds) {
                $products = $productRepository->getProductsByIds($itemIds, $queryParams);
            }
        }

        return $this->httpResponse
            ->setData(Theme::partial('ecommerce.recently-viewed-products', compact('products')));
    }

    public function ajaxContactSeller(Theme\Farmart\Http\Requests\ContactSellerRequest $request, BaseHttpResponse $response)
    {
        $name = $request->input('name');
        $email = $request->input('email');

        if (auth('customer')->check()) {
            $name = auth('customer')->user()->name;
            $email = auth('customer')->user()->email;
        }

        EmailHandler::setModule(Theme::getThemeName())
            ->setVariableValues([
                'contact_message' => $request->input('content'),
                'customer_name' => $name,
                'customer_email' => $email,
            ])
            ->sendUsingTemplate('contact-seller', $email, [], false, 'themes');

        return $response->setMessage(__('Send message successfully!'));
    }
}
