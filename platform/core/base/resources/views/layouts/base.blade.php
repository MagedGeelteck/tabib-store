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
                @php
                    // Minimal SEO: prefer SeoHelper rendering if available; otherwise fall back to a simple canonical tag.
                    try {
                        if (class_exists(\Botble\SeoHelper\Facades\SeoHelper::class)) {
                            // Let SeoHelper output title/meta/og tags if it's available
                            echo \Botble\SeoHelper\Facades\SeoHelper::render();
                            $metaUrl = rescue(fn() => \Botble\SeoHelper\Facades\SeoHelper::meta()->getUrl());
                        } else {
                            $metaUrl = null;
                        }
                    } catch (\Exception $e) {
                        $metaUrl = null;
                    }

                    $canonical = isset($canonical) ? $canonical : ($metaUrl ?: url()->full());
                @endphp
                <link rel="canonical" href="{{ rtrim($canonical, '/') ?: 'https://tabib-jo.com' }}">
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
