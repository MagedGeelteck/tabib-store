<div class="page-header navbar navbar-static-top" style="min-height:100px;  margin-bottom: 20px  !important; background:#15292B;">
    <div class="page-header-inner">
        <div class="page-logo">
            @if (setting('admin_logo') || config('core.base.general.logo'))
                <a href="{{ route('dashboard.index') }}">
                    <img style="height:80px;" src="{{ setting('admin_logo') ? RvMedia::getImageUrl(setting('admin_logo')) : url(config('core.base.general.logo')) }}" alt="logo" class="logo-default" />
                </a>
            @endif

            @auth
                <div class="menu-toggler sidebar-toggler">
                    <span></span>
                </div>
            @endauth
        </div>

        @auth
            <a href="javascript:" class="menu-toggler responsive-toggler" data-bs-toggle="collapse" data-bs-target=".navbar-collapse">
                <span></span>
            </a>
        @endauth

        @include('core/base::layouts.partials.top-menu')
    </div>
</div>
