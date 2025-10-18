<!DOCTYPE html>
<!--[if IE 8]>
<html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]>
<html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<head>
    {{-- Compute safe fallbacks for title and canonical so templates that include this
         layout before our normalization logic don't trigger undefined variable errors. --}}
    @php
        // Safe title: prefer already-set $title, else SeoHelper, page_title(), or site name
        $safeTitle = null;
        try {
            if (isset($title) && $title) {
                $safeTitle = $title;
            } elseif (class_exists(\Botble\SeoHelper\Facades\SeoHelper::class)) {
                $safeTitle = \Botble\SeoHelper\Facades\SeoHelper::getTitle();
            } elseif (function_exists('page_title')) {
                $safeTitle = page_title()->getTitle();
            } else {
                $safeTitle = setting('admin_title', config('core.base.general.base_name'));
            }
        } catch (\Exception $e) {
            $safeTitle = setting('admin_title', config('core.base.general.base_name'));
        }

        // Safe canonical: if $canonical is set use it, otherwise use current URL
        $safeCanonical = isset($canonical) ? $canonical : (request() ? url()->full() : 'https://tabib-jo.com');
    @endphp

    <title>{{ e($safeTitle) }}</title>
    <link rel="canonical" href="{{ rtrim($safeCanonical, '/') ?: 'https://tabib-jo.com' }}">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    @php
        // Detect admin area early so we can avoid running front-end SEO normalization during admin requests.
        $siteName = setting('admin_title', config('core.base.general.base_name'));
        $routeName = optional(request()->route())->getName();
        $locale = app()->getLocale();
        $isAdmin = request()->is('admin*') || request()->routeIs('admin.*');

        if ($isAdmin) {
            // Admin pages: keep existing title/description and avoid normalization.
            try {
                if (class_exists(\Botble\SeoHelper\Facades\SeoHelper::class)) {
                    $title = \Botble\SeoHelper\Facades\SeoHelper::getTitle() ?: page_title()->getTitle();
                    $description = \Botble\SeoHelper\Facades\SeoHelper::getDescription();
                } else {
                    $title = page_title()->getTitle();
                    $description = null;
                }
            } catch (\Exception $e) {
                $title = page_title()->getTitle();
                $description = null;
            }
        } else {
            // Frontend pages: run SEO normalization
            require_once base_path('app/Helpers/SeoHelperNormalize.php');
            try {
                if (class_exists(\Botble\SeoHelper\Facades\SeoHelper::class)) {
                    $existingTitle = \Botble\SeoHelper\Facades\SeoHelper::getTitle();
                    $rawTitle = $existingTitle ?: page_title()->getTitle();
                    $description = \Botble\SeoHelper\Facades\SeoHelper::getDescription();
                } else {
                    $rawTitle = page_title()->getTitle();
                    $description = null;
                }
            } catch (\Exception $e) {
                $rawTitle = page_title()->getTitle();
                $description = null;
            }

            $routeName = optional(request()->route())->getName();
            $locale = app()->getLocale();
            $title = normalize_seo_title($rawTitle, $siteName, $routeName, $locale);

            // Keywords & phrasing
            $keywords = [
                'online pharmacy', 'pharmacy', 'Tabib', 'Jordan', 'Amman',
                'medicines', 'buy medicines', 'health products', 'medical supplies', 'vitamins', 'supplements',
                'sugar-free', 'keto', 'diet', 'gluten free', 'lactose free', 'sports nutrition', 'high protein', 'low protein',
                'صيدلية', 'ادوية', 'منتجات صحية', 'منتجات غذائية خاصة', 'خالي سكر', 'الرياضيين', 'دايت', 'كيتو',
                'خالي من الجلوتين', 'خالي من اللاكتوز', 'نباتي', 'نباتية', 'عالية البروتين', 'قليل البروتين', 'عمان', 'الاردن'
            ];

            $hasKeyword = false;
            foreach ($keywords as $k) {
                if (!empty($k) && stripos($title, $k) !== false) {
                    $hasKeyword = true;
                    break;
                }
            }

            $containsArabic = preg_match('/[\x{0600}-\x{06FF}]/u', $title) || app()->getLocale() === 'ar';

            if (request()->routeIs('public.index')) {
                $primaryPhrase = $containsArabic ? 'محل مختص بالاغذية الخاصة' : 'Online Pharmacy & Health Products';
            } elseif (request()->routeIs('public.products') || request()->routeIs('public.product')) {
                $primaryPhrase = $containsArabic ? 'منتجات صحية في الأردن' : 'Health Products in Jordan';
            } elseif (request()->routeIs('public.cart') || request()->routeIs('public.profile')) {
                $primaryPhrase = $containsArabic ? 'منتجات صحية، أدوية، توصيل سريع' : 'Medicines, Health Products, Fast Delivery';
            } else {
                $primaryPhrase = $containsArabic ? 'منتجات صحية' : 'Health Products';
            }

            if (! $hasKeyword || mb_strlen(strip_tags($title)) < 30) {
                if ($title && stripos($title, $primaryPhrase) === false) {
                    $title = $primaryPhrase . ' — ' . trim($title);
                }
                if (stripos($title, $siteName) === false) {
                    $title = $title . ' | ' . $siteName;
                }
            } else {
                if (stripos($title, $siteName) === false) {
                    $title = trim($title) . ' | ' . $siteName;
                }
            }

            if (empty($description)) {
                $primaryKeywordsEn = 'Online pharmacy, health products, fast delivery in Amman';
                $primaryKeywordsAr = 'صيدلية أونلاين، منتجات صحية، توصيل سريع في عمان';

                $containsArabic = preg_match('/[\x{0600}-\x{06FF}]/u', request()->getPathInfo()) || app()->getLocale() === 'ar';

                $arabicSiteDescription = 'محل مختص بالاغذية الخاصة: منتجات (خالي سكر، الرياضيين، دايت الكيتو، خالي من الجلوتين، خالي من اللاكتوز، النباتية، عالية البروتين، قليل البروتين) Tabib Store';

                if (request()->routeIs('public.index')) {
                    if ($containsArabic) {
                        $description = "{$primaryKeywordsAr} — {$arabicSiteDescription} " . $siteName;
                    } else {
                        $description = "{$primaryKeywordsEn}. Trusted medicines and health products at {$siteName}. Fast delivery across Jordan.";
                    }
                } else {
                    if ($containsArabic) {
                        $description = "{$primaryKeywordsAr} — {$arabicSiteDescription} " . $siteName;
                    } else {
                        $description = "{$primaryKeywordsEn}. Shop trusted medicines and medical supplies at {$siteName}. Fast delivery in Jordan.";
                    }
                }

                if (mb_strlen($description) > 160) {
                    $description = mb_substr($description, 0, 157) . '...';
                }
            }
        }
    @endphp
    @php 
        // Build a canonical URL for crawlers.
        // Priority: use SeoHelper meta URL if set (page-specific canonical), otherwise use current URL.
        // Always force canonical host/scheme to the canonical host to avoid www/http duplicates.
        try {
            $canonicalHost = 'tabib-jo.com';

            // Prefer SeoHelper meta URL when available
            if (class_exists(\Botble\SeoHelper\Facades\SeoHelper::class)) {
                $metaUrl = rescue(fn() => \Botble\SeoHelper\Facades\SeoHelper::meta()->getUrl());
            } else {
                $metaUrl = null;
            }

            $source = $metaUrl ?: url()->full();

            // Parse and rebuild to ensure canonical host + https
            $parts = parse_url($source ?: url()->current());

            $path = isset($parts['path']) ? $parts['path'] : '/';
            $query = [];
            if (isset($parts['query'])) {
                parse_str($parts['query'], $query);
            } else {
                $query = request()->query();
            }

            // Remove pagination query param from canonical
            if (array_key_exists('page', $query)) {
                unset($query['page']);
            }

            // Normalize accidental /public/ in path
            if (strpos($path, '/public/') === 0) {
                $path = substr($path, 7) ?: '/';
            }

            $canonical = 'https://' . $canonicalHost . $path;
            if (! empty($query)) {
                $canonical .= '?' . http_build_query($query);
            }
        } catch (\Exception $e) {
            $canonical = url()->current();
        }
    @endphp
    <link rel="canonical" href="{{ rtrim($canonical, '/') ?: 'https://tabib-jo.com' }}">

    {{-- Always output a fallback meta keywords tag for SEO tools --}}
    <meta name="keywords" content="محل مختص بالاغذية الخاصة, خالي سكر, الرياضيين, دايت الكيتو, خالي من الجلوتين, خالي من اللاكتوز, النباتية, عالية البروتين, قليل البروتين, Tabib Store, online pharmacy, health products, Jordan, Amman, medicines, supplements, vitamins, pharmacy">

    {{-- SeoHelper will render meta / open graph / twitter tags via the theme header partial --}}
    {{-- Keep only description/robots/viewport/csrf here as base tags --}}
    @if ($isAdmin)
        <meta name="robots" content="noindex,follow"/>
    @else
        <meta name="robots" content="index,follow"/>
    @endif
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @if (setting('admin_favicon') || config('core.base.general.favicon'))
        <link rel="icon shortcut" href="{{ setting('admin_favicon') ? RvMedia::getImageUrl(setting('admin_favicon'), 'thumb') : url(config('core.base.general.favicon')) }}">
    @endif

    <link rel="preconnect" href="{{ BaseHelper::getGoogleFontsURL() }}">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="{{ BaseHelper::getGoogleFontsURL() }}/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">

    <!-- Preload main theme stylesheet (non-blocking) -->
    <link rel="preload" href="{{ asset('themes/farmart/css/style.css') }}" as="style" onload="this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="{{ asset('themes/farmart/css/style.css') }}"></noscript>

    <!-- Preload main woff2 font to speed up text rendering -->
    <link rel="preload" href="{{ asset('themes/farmart/plugins/font-awesome/fonts/fontawesome-webfont.woff2') }}" as="font" type="font/woff2" crossorigin>

    {!! Assets::renderHeader(['core']) !!}

    <script>
        window.siteUrl = "{{ url('') }}";
        window.siteEditorLocale = "{{ apply_filters('cms_site_editor_locale', App::getLocale()) }}";
    </script>

    @if (BaseHelper::adminLanguageDirection() == 'rtl')
        <link rel="stylesheet" href="{{ asset('vendor/core/core/base/css/rtl.css') }}">
    @endif

    @yield('head')

    @stack('header')
    
    <style>
    .language-header{
        display:none;
    }
    .buttons-reload{
      max-width:150px;
    }
    .delete-icon > li:first-child:before {
           content: "";
    }
*{
    font-size:16px;
}    
    /* Critical CSS for above-the-fold: reserve hero/slider space to avoid layout shift
       - Gives slider a stable aspect ratio so the LCP image can be loaded and painted
       without causing a reflow. object-fit keeps the image cover-style.
    */
    .section-slides-wrapper,
    .slide-item__image {
        width: 100%;
        aspect-ratio: 16 / 9;
        min-height: 220px; /* fallback for very old browsers */
        overflow: hidden;
        display: block;
        background-color: #f6f6f6; /* neutral background while image loads */
    }

    .slide-item__image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    </style>
    {{-- Allow themes/packages to inject additional head HTML (e.g. SeoHelper::render()) --}}
    {!! apply_filters(BASE_FILTER_HEADER_LAYOUT_TEMPLATE, null) !!}
</head>
<body @if (BaseHelper::adminLanguageDirection() == 'rtl') dir="rtl" @endif class="@yield('body-class', 'page-sidebar-closed-hide-logo page-container-bg-solid') {{ session()->get('sidebar-menu-toggle') ? 'page-sidebar-closed' : '' }}" style="@yield('body-style')">

    <div id="app">
        @yield('page')
    </div>

    @include('core/base::elements.common')

    {!! Assets::renderFooter() !!}

    @yield('javascript')

    <div id="stack-footer">
        @stack('footer')
    </div>

    {!! apply_filters(BASE_FILTER_FOOTER_LAYOUT_TEMPLATE, null) !!}
       
    
</body>


</html>
