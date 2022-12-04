<header class="header header-sticky mb-2">
    <div class="container-fluid">
{{--        <button class="header-toggler px-md-0 me-md-3" type="button"--}}
{{--            onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()">--}}
{{--            <i class="icon icon-lg fa fa-bars" aria-hidden="true"></i>--}}
{{--        </button>--}}
        <div class="dropdown pull-right">
            <button class="btn btn-warning dropdown-toggle" id="action" type="button" data-coreui-toggle="dropdown" aria-expanded="false">
                {{__('Choose language')}}
            </button>
            <ul class="dropdown-menu" aria-labelledby="action">
                <li>
                    <a class="dropdown-item" href="{{route('language.index',['en'])}}">
                        <i class="flag-icon flag-icon-us"></i>English
                    </a>
                </li>
                <li class="dropdown-divider"></li>
                <li>
                    <a class="dropdown-item" href="{{route('language.index',['vi'])}}">
                        <i class=""></i>Tiếng việt
                    </a>
                </li>
            </ul>
        </div>
        <ul class="header-nav ms-3">
            <li class="nav-item dropdown">
                <a class="nav-link py-0" data-coreui-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <div class="avatar avatar-md">
                        <img class="avatar-img" src="{{ url('/assets/img/avatars/6.jpeg') }}">
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end pt-0">
                    <div class="dropdown-header bg-light py-2">
                        <div class="fw-semibold">Account</div>
                    </div>
                    <a class="dropdown-item" href="{{route('logout')}}">
                        <i class="icon me-2 fa fa-sign-out" aria-hidden="true"></i>
                        Đăng xuất
                    </a>
                    <a class="dropdown-item" href="{{route('register.index')}}">
                        <i class="icon me-2 fa fa-sign-out" aria-hidden="true"></i>
                        Đăng ký
                    </a>
                </div>
            </li>
            <li>
                <a class="nav-link py-0" data-coreui-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <div class="avatar avatar-md">
                        <a style="text-decoration: none" href="{{route('card.index')}}">
                        <i class="fa-solid fa-cart-flatbed"></i>
                        </a>

                    </div>
                </a>
            </li>
        </ul>
        </div>
{{--    <div class="header-divider"></div>--}}

</header>
