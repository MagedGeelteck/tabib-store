<?php
// Removed inline JS redirects that caused immediate client-side navigation.
// Redirects should be handled server-side (controller/middleware) to avoid interfering with UI interactions.
?>
@foreach ($menus = dashboard_menu()->getAll() as $menu)
    @php $menu = apply_filters(BASE_FILTER_DASHBOARD_MENU, $menu); @endphp
    <li class="nav-item @if ($menu['active']) active @endif " id="{{ $menu['id'] }}">
        @php $hasChildren = isset($menu['children']) && count($menu['children']); @endphp
        <a href="{{ $hasChildren ? 'javascript:void(0)' : $menu['url'] }}" data-href="{{ $menu['url'] }}" class="nav-link nav-toggle"  @if ($menu['active'])  style="color:#000;" @endif>
            <b><i class="{{ $menu['icon'] }}"></i></b>
            <span class="title" style="font-size:18px;"><b>
                {{ !is_array(trans($menu['name'])) ? trans($menu['name']) : null }}
                {!! apply_filters(BASE_FILTER_APPEND_MENU_NAME, null, $menu['id']) !!}</b></span>
            @if (isset($menu['children']) && count($menu['children'])) <span class="arrow @if ($menu['active']) open @endif"></span> @endif
        </a>
        @if ($hasChildren)
            <ul class="sub-menu @if (!$menu['active']) hidden-ul @endif">
                @foreach ($menu['children'] as $item)
                    <li class="nav-item @if ($item['active']) active @endif" id="{{ $item['id'] }}">
                        <a href="{{ $item['url'] }}" class="nav-link" style="font-size:16px;">
                            <i class="{{ $item['icon'] }}"></i>
                            <b>{{ trans($item['name']) }}</b>
                            {!! apply_filters(BASE_FILTER_APPEND_MENU_NAME, null, $item['id']) !!}
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif
    </li>
@endforeach
