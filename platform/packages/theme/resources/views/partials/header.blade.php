@php
    // Get what SeoHelper already has (if anything)
    $seoTitle = rescue(fn() => SeoHelper::getTitle());
    $seoDescription = rescue(fn() => SeoHelper::getDescription());

    // Compute a friendly, localized fallback if SeoHelper didn't provide one.
    $siteName = theme_option('site_title') ?: setting('admin_title', config('core.base.general.base_name'));

    // Minimal keyword set for detection (kept concise to avoid excessive checks)
    $keywords = ['online pharmacy', 'pharmacy', 'health products', 'Tabib', 'Amman', 'صيدلية', 'منتجات صحية', 'عمان'];

    $titleSource = $seoTitle ?: page_title()->getTitle();

    $hasKeyword = false;
    foreach ($keywords as $k) {
        if (! empty($k) && stripos($titleSource, $k) !== false) {
            $hasKeyword = true;
            break;
        }
    }

    $containsArabic = preg_match('/[\x{0600}-\x{06FF}]/u', $titleSource) || app()->getLocale() === 'ar';
    $primaryAppendEn = ' - Online Pharmacy & Health Products in Jordan';
    $primaryAppendAr = ' - متجر طبيب للمنتجات الصحية في الأردن';
    $primaryAppend = $containsArabic ? $primaryAppendAr : $primaryAppendEn;

    $computedTitle = trim($titleSource ?: $siteName);
    if (! $hasKeyword || mb_strlen(strip_tags($computedTitle)) < 30) {
        if (stripos($computedTitle, trim($primaryAppend)) === false) {
            $computedTitle = $computedTitle . $primaryAppend;
        }
        if (stripos($computedTitle, $siteName) === false) {
            $computedTitle = $computedTitle . ' | ' . $siteName;
        }
    } else {
        if (stripos($computedTitle, $siteName) === false) {
            $computedTitle = $computedTitle . ' | ' . $siteName;
        }
    }

    // Description fallback
    if ($seoDescription) {
        $computedDescription = $seoDescription;
    } else {
        $primaryKeysEn = 'Online pharmacy, health products, fast delivery in Amman';
        $primaryKeysAr = 'صيدلية أونلاين، منتجات صحية، توصيل سريع في عمان';
        $pk = $containsArabic ? $primaryKeysAr : $primaryKeysEn;
        $computedDescription = $pk . '. ' . ($containsArabic ? 'محل مختص بالاغذية الخاصة وتوصيل داخل عمان والاردن.' : "Trusted medicines and health products with fast delivery across Jordan.");
        if (mb_strlen($computedDescription) > 160) {
            $computedDescription = mb_substr($computedDescription, 0, 157) . '...';
        }
    }
@endphp

{{-- If SeoHelper didn't render a title/description, output our computed ones. --}}
@if (empty(rescue(fn() => SeoHelper::getTitle())))
    <title>{{ e($computedTitle) }}</title>
@endif

@if (empty(rescue(fn() => SeoHelper::getDescription())))
    <meta name="description" content="{{ e($computedDescription) }}">
@endif

{!! SeoHelper::render() !!}

@php
    // If SeoHelper didn't render OpenGraph image/title/description, output minimal defaults
    try {
        $ogTitle = rescue(fn() => SeoHelper::openGraph()->getProperty('title'));
        $ogDescription = rescue(fn() => SeoHelper::openGraph()->getProperty('description'));
        $ogImage = rescue(fn() => SeoHelper::openGraph()->getProperty('image'));
        $ogUrl = rescue(fn() => SeoHelper::openGraph()->getProperty('url')) ?: url()->current();
        $ogSiteName = rescue(fn() => SeoHelper::openGraph()->getProperty('site_name')) ?: theme_option('site_title') ?: setting('admin_title');
    } catch (\Exception $e) {
        $ogTitle = null;
        $ogDescription = null;
        $ogImage = null;
        $ogUrl = url()->current();
        $ogSiteName = theme_option('site_title') ?: setting('admin_title');
    }
@endphp

@if (empty($ogTitle))
    <meta property="og:title" content="{{ e(page_title()->getTitle() ?: $ogSiteName) }}">
@endif

@if (empty($ogDescription) && $description = rescue(fn() => SeoHelper::getDescription()))
    <meta property="og:description" content="{{ e($description) }}">
@endif

{{-- Meta keywords (fallback using user-provided Arabic keywords) --}}
<meta name="keywords" content="محل مختص بالاغذية الخاصة, خالي سكر, الرياضيين, دايت الكيتو, خالي من الجلوتين, خالي من اللاكتوز, النباتية, عالية البروتين, قليل البروتين, Tabib Store">

@if (empty($ogImage) && $default = theme_option('seo_og_image'))
    <meta property="og:image" content="{{ RvMedia::url($default) }}">
@elseif(!empty($ogImage))
    <meta property="og:image" content="{{ e($ogImage) }}">
@endif

<meta property="og:url" content="{{ e($ogUrl) }}">
<meta property="og:site_name" content="{{ e($ogSiteName) }}">

@if ($favicon = theme_option('favicon'))
    <link rel="shortcut icon" href="{{ RvMedia::getImageUrl($favicon) }}">
@endif

@if (Theme::has('headerMeta'))
    {!! Theme::get('headerMeta') !!}
@endif

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebSite",
  "name": "{{ rescue(fn() => SeoHelper::openGraph()->getProperty('site_name')) }}",
  "url": "{{ url('') }}"
}
</script>

{!! Theme::asset()->styles() !!}
{!! Theme::asset()->container('after_header')->styles() !!}
{!! Theme::asset()->container('header')->scripts() !!}

{!! apply_filters(THEME_FRONT_HEADER, null) !!}

<script>
    window.siteUrl = "{{ route('public.index') }}";
</script>
