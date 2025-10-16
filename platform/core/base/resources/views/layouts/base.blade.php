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
        // Prefer SeoHelper values when present (Botble SeoHelper integration)
        $siteName = setting('admin_title', config('core.base.general.base_name'));
        try {
            if (class_exists(\Botble\SeoHelper\Facades\SeoHelper::class)) {
                // If controllers or plugins set an SEO title, normalize it here so
                // short titles like "Shopping Cart" receive a localized, keyword-rich
                // append and the site name for consistent branding.
                $existingTitle = \Botble\SeoHelper\Facades\SeoHelper::getTitle();
                $title = $existingTitle ?: page_title()->getTitle();
                $description = \Botble\SeoHelper\Facades\SeoHelper::getDescription();
            } else {
                $title = page_title()->getTitle();
                $description = null;
            }
        } catch (\Exception $e) {
            $title = page_title()->getTitle();
            $description = null;
        }

        // Ensure we only modify frontend pages (skip admin area)
        $isAdmin = request()->is('admin*') || request()->routeIs('admin.*');

    if (! $isAdmin) {
                // A broader, practical set of keywords and natural-language fallbacks.
                // These are used to detect whether a page title already contains relevant terms.
                // Curated keyword set (English + Arabic) — concise, natural phrases to avoid stuffing
                $keywords = [
                    // English keywords
                    'online pharmacy', 'pharmacy', 'Tabib', 'Jordan', 'Amman',
                    'medicines', 'buy medicines', 'health products', 'medical supplies', 'vitamins', 'supplements',
                    'sugar-free', 'keto', 'diet', 'gluten free', 'lactose free', 'sports nutrition', 'high protein', 'low protein',
                    // Arabic keywords (natural phrases)
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

                // Strategy: if the title is short (< 30 chars) or lacks any of the keywords,
                // add a single, natural localized phrase that includes primary keywords + the site name.
                // Detect Arabic content in the title or current locale to choose the right phrase
                $containsArabic = preg_match('/[\x{0600}-\x{06FF}]/u', $title) || app()->getLocale() === 'ar';

                $primaryAppendEn = ' - Online Pharmacy & Health Products in Jordan';
                $primaryAppendAr = ' - متجر طبيب للمنتجات الصحية في الأردن';

                $primaryAppend = $containsArabic ? $primaryAppendAr : $primaryAppendEn;

                if (! $hasKeyword || mb_strlen(strip_tags($title)) < 30) {
                    // Only append once and avoid duplicating the site name
                    if ($title && stripos($title, trim($primaryAppend)) === false) {
                        $title = trim($title) . $primaryAppend;
                    }

                    // Ensure site name appears once at the end for branding
                    if (stripos($title, $siteName) === false) {
                        $title = trim($title) . ' | ' . $siteName;
                    }
                } else {
                    // Has a keyword: still ensure the site name is appended for branding
                    if (stripos($title, $siteName) === false) {
                        $title = trim($title) . ' | ' . $siteName;
                    }
                }

                // If SeoHelper didn't set a description, provide a friendly default for the homepage
                // and a concise generic description for other pages missing one.
                if (empty($description)) {
                    // Primary keywords to place early in description (localized)
                    $primaryKeywordsEn = 'Online pharmacy, health products, fast delivery in Amman';
                    $primaryKeywordsAr = 'صيدلية أونلاين، منتجات صحية، توصيل سريع في عمان';

                    $containsArabic = preg_match('/[\x{0600}-\x{06FF}]/u', request()->getPathInfo()) || app()->getLocale() === 'ar';

                    // Use the Arabic site description provided by the user for the homepage
                    $arabicSiteDescription = 'محل مختص بالاغذية الخاصة: منتجات خالي سكر، الرياضيين، دايت الكيتو، خالي من الجلوتين، خالي من اللاكتوز، نباتية، عالية البروتين.';

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

                    // Ensure description is not overly long (truncate softly)
                    if (mb_strlen($description) > 160) {
                        $description = mb_substr($description, 0, 157) . '...';
                    }
                }
        }
    @endphp
    @php
        // If SeoHelper is available, push our computed title/description into it and
        // let SeoHelper::render() (hooked by the theme header) output the final
        // <title> and all meta tags. Otherwise, fall back to a plain <title>.
        if (class_exists(\Botble\SeoHelper\Facades\SeoHelper::class)) {
            try {
                // Re-set the normalized title back into SeoHelper so any earlier
                // controller-set titles are improved.
                \Botble\SeoHelper\Facades\SeoHelper::setTitle($title)->setDescription($description);
            } catch (\Exception $e) {
                // if something goes wrong, fallback to printing title directly below
                echo '<title>' . e($title) . '</title>';
            }
        } else {
            echo '<title>' . e($title) . '</title>';
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
