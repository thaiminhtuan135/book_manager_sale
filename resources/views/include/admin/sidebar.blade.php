@php
$routeName = \Route::currentRouteName();

$routeCompanies=[
    'company.index',
];
$routeBook=[
    'book.index',
];
$routeHome=[
    'homePage',
];


@endphp
    <!-- Main Sidebar Container -->
<div class="sidebar sidebar-fixed sidebar-lg-show" id="sidebar">
    <div class="sidebar-brand d-none d-md-flex">
    </div>
    <ul class="sidebar-nav" data-coreui="navigation" data-simplebar="init">
        <div class="simplebar-wrapper" style="margin: 0px;">
            <div class="simplebar-height-auto-observer-wrapper">
                <div class="simplebar-height-auto-observer"></div>
            </div>
            <div class="simplebar-mask">
                <div class="simplebar-offset">
                    <div class="simplebar-content-wrapper">
                        <div class="simplebar-content">
                            <li class="nav-item">
                                <a class="nav-link {{ in_array($routeName, $routeBook) ? 'active' : '' }}" href="{{ route('book.index') }}">
                                    <i class="nav-icon fa fa-money" aria-hidden="true"></i>
                                    {{__('List book')}}
                                </a>
                           </li>
                            <li class="nav-item">
                                <a class="nav-link {{ in_array($routeName, $routeHome) ? 'active' : '' }}" href="{{ route('homePage') }}">
                                    <i class="nav-icon fa fa-money" aria-hidden="true"></i>
                                    Trang chủ
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
