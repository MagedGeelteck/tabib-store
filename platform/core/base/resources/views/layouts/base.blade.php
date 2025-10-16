<!DOCTYPE html>
<!--[if IE 8]>
<html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]>
<html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    @php
        $title = page_title()->getTitle();
        // Append a short keyword phrase for the homepage server-side so crawlers see it without JS
        try {
            if (request()->routeIs('public.index')) {
                $kw = ' - Online Pharmacy & Health Products in Jordan';
                if (strpos($title, $kw) === false) {
                    $title .= $kw;
                }
            }
        } catch (\Exception $e) {
            // ignore
        }
    @endphp
    <title>{{ $title }}</title>
    @php
        // Build a canonical URL for crawlers: use current path and exclude the `page` query param
        try {
            $query = request()->query();
            if (array_key_exists('page', $query)) {
                unset($query['page']);
            }
            $canonical = url()->current();
            if (!empty($query)) {
                $canonical .= '?' . http_build_query($query);
            }
        } catch (\Exception $e) {
            $canonical = url()->current();
        }
    @endphp
    <link rel="canonical" href="{{ $canonical }}">

    {{-- Basic SEO meta tags --}}
    <meta name="keywords" content="online pharmacy, health products, medicines, medical supplies, Amman, Jordan, tabib">
    <meta property="og:title" content="{{ $title }}">
    <meta property="og:url" content="{{ $canonical }}">
    <meta property="og:site_name" content="{{ setting('admin_title', config('core.base.general.base_name')) }}">
    <meta property="og:type" content="website">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $title }}">
    <meta name="twitter:description" content="{{ strip_tags(trans('core/base::layouts.copyright', ['year' => now()->format('Y'), 'company' => setting('admin_title', config('core.base.general.base_name')), 'version' => get_cms_version()])) }}">

    <meta name="robots" content="noindex,follow"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @if (setting('admin_logo') || config('core.base.general.logo'))
        <meta property="og:image" content="{{ setting('admin_logo') ? RvMedia::getImageUrl(setting('admin_logo')) : url(config('core.base.general.logo')) }}">
    @endif
    <meta name="description" content="{{ strip_tags(trans('core/base::layouts.copyright', ['year' => now()->format('Y'), 'company' => setting('admin_title', config('core.base.general.base_name')), 'version' => get_cms_version()])) }}">
    <meta property="og:description" content="{{ strip_tags(trans('core/base::layouts.copyright', ['year' => now()->format('Y'), 'company' => setting('admin_title', config('core.base.general.base_name')), 'version' => get_cms_version()])) }}">

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
</head>
<body @if (BaseHelper::adminLanguageDirection() == 'rtl') dir="rtl" @endif class="@yield('body-class', 'page-sidebar-closed-hide-logo page-content-white page-container-bg-solid') {{ session()->get('sidebar-menu-toggle') ? 'page-sidebar-closed' : '' }}" style="@yield('body-style')">

    {!! apply_filters(BASE_FILTER_HEADER_LAYOUT_TEMPLATE, null) !!}

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
