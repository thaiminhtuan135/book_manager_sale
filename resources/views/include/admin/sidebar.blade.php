@php
$routeName = \Route::currentRouteName();

$routeCompanies=[
    'company.index',
];
$routeBook=[
    'user.book.index',
];

@endphp
    <!-- Main Sidebar Container -->
<div class="sidebar sidebar-dark sidebar-fixed sidebar-lg-show" id="sidebar">
    <div class="sidebar-brand d-none d-md-flex">
{{--        <img class="sidebar-brand-full" src="{{ url('images/logo.png') }}" width="55" height="46">--}}
{{--        <img class="sidebar-brand-narrow" src="{{ url('images/logo.png') }}" width="55" height="46">--}}
    </div>
    <ul class="sidebar-nav" data-coreui="navigation" data-simplebar="init">
        <div class="simplebar-wrapper" style="margin: 0px;">
            <div class="simplebar-height-auto-observer-wrapper">
                <div class="simplebar-height-auto-observer"></div>
            </div>
            <div class="simplebar-mask">
                <div class="simplebar-offset">
                    <div class="simplebar-content-wrapper">
{{--                        <div class="simplebar-content">--}}
{{--                            <li class="nav-item">--}}
{{--                                <a class="nav-link" href="{{ route('Admin.dashboard.index') }}">--}}
{{--                                    <i class="nav-icon fa fa-home" aria-hidden="true"></i>--}}
{{--                                    ホーム--}}
{{--                                </a>--}}
{{--                            </li>--}}
{{--                        </div>--}}
                        <div class="simplebar-content">
                            <li class="nav-item">
                                <a class="nav-link {{ in_array($routeName, $routeCompanies) ? 'active' : '' }}" href="{{ route('company.index') }}">
                                    <i class="nav-icon fa fa-money" aria-hidden="true"></i>
                                    Danh sách
                                </a>
                           </li>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </ul>

    <button class="sidebar-toggler" type="button" data-coreui-toggle="unfoldable"></button>
</div>
