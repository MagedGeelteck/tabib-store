@php
    // Ensure SeoHelper has a keyword-aware title before rendering meta tags.
    try {
        $siteName = theme_option('site_title') ?: setting('admin_title');
        $currentTitle = rescue(fn() => \Botble\SeoHelper\Facades\SeoHelper::getTitle()) ?: page_title()->getTitle(false) ?: $siteName;
        $currentDescription = rescue(fn() => \Botble\SeoHelper\Facades\SeoHelper::getDescription());

        $keywords = [
            'online pharmacy', 'pharmacy', 'Tabib', 'Jordan', 'Amman',
            'medicines', 'buy medicines', 'health products', 'medical supplies', 'vitamins', 'supplements',
            'sugar-free', 'keto', 'diet', 'gluten free', 'lactose free', 'sports nutrition', 'high protein', 'low protein',
            'صيدلية', 'ادوية', 'منتجات صحية', 'منتجات غذائية خاصة', 'خالي سكر', 'الرياضيين', 'دايت', 'كيتو',
            'خالي من الجلوتين', 'خالي من اللاكتوز', 'نباتي', 'نباتية', 'عالية البروتين', 'قليل البروتين', 'عمان', 'الاردن'
        ];

        $hasKeyword = false;
        foreach ($keywords as $k) {
            if (!empty($k) && stripos($currentTitle, $k) !== false) {
                $hasKeyword = true;
                break;
            }
        }

        // If title is short or missing keywords, append a natural phrase once.
        if (! $hasKeyword || mb_strlen(strip_tags($currentTitle)) < 30) {
            $append = ' - Online Pharmacy & Health Products in Jordan';
            $newTitle = trim($currentTitle);
            if (stripos($newTitle, trim($append)) === false) {
                $newTitle .= $append;
            }
            if (stripos($newTitle, $siteName) === false) {
                $newTitle .= ' | ' . $siteName;
            }
            \Botble\SeoHelper\Facades\SeoHelper::setTitle($newTitle);
            if (empty($currentDescription)) {
                \Botble\SeoHelper\Facades\SeoHelper::setDescription($siteName . ' - Your online source for trusted medicines and health products in Jordan.');
            }
        }
    } catch (\Exception $e) {
        // fail silently
    }
@endphp

{!! \Botble\SeoHelper\Facades\SeoHelper::render() !!}

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
