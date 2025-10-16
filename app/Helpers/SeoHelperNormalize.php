<?php

if (!function_exists('normalize_seo_title')) {
    /**
     * Normalize a page title for SEO: prepend a keyword phrase if short or missing keywords, append site name.
     *
     * @param string $title
     * @param string $siteName
     * @param string $routeName
     * @param string $locale
     * @return string
     */
    function normalize_seo_title($title, $siteName, $routeName, $locale = null)
    {
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
        $containsArabic = preg_match('/[\x{0600}-\x{06FF}]/u', $title) || ($locale === 'ar');
        // Page-type-specific keyword phrase
        if ($routeName === 'public.index') {
            $primaryPhrase = $containsArabic ? 'محل مختص بالاغذية الخاصة' : 'Online Pharmacy & Health Products';
        } elseif ($routeName === 'public.products' || $routeName === 'public.product') {
            $primaryPhrase = $containsArabic ? 'منتجات صحية في الأردن' : 'Health Products in Jordan';
        } elseif ($routeName === 'public.cart' || $routeName === 'public.profile') {
            $primaryPhrase = $containsArabic ? 'منتجات صحية، أدوية، توصيل سريع' : 'Medicines, Health Products, Fast Delivery';
        } else {
            $primaryPhrase = $containsArabic ? 'منتجات صحية' : 'Health Products';
        }
        if (!$hasKeyword || mb_strlen(strip_tags($title)) < 30) {
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
        return $title;
    }
}
