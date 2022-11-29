{{--<header class="header header-sticky mb-2">--}}
{{--    <div class="container-fluid">--}}
{{--        <div class="dropdown">--}}
{{--            <button class="btn btn-warning dropdown-toggle" id="action" type="button" data-coreui-toggle="dropdown" aria-expanded="false">--}}
{{--                {{__('Choose language')}}--}}
{{--            </button>--}}
{{--            <ul class="dropdown-menu" aria-labelledby="action">--}}
{{--                <li>--}}
{{--                    <a class="dropdown-item" href="{{route('language.index',['en'])}}">--}}
{{--                        <i class="flag-icon flag-icon-us"></i>English--}}
{{--                    </a>--}}
{{--                </li>--}}
{{--                <li class="dropdown-divider"></li>--}}
{{--                <li>--}}
{{--                    <a class="dropdown-item" href="{{route('language.index',['vi'])}}">--}}
{{--                        <i class=""></i>Tiếng việt--}}
{{--                    </a>--}}
{{--                </li>--}}
{{--            </ul>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</header>--}}
<div style="display: flex; align-items: center; padding: 20px; padding-left: 50px; padding-right: 30px; padding-top: 50px;">
    <div>
    </div>
    <nav style="flex: 1; text-align: right;">
        <ul style="  display: inline-block; list-style: none;" id='MenuItems'>
            <li style="display: inline-block; margin-right: 70px;">
                <a style="text-decoration: none; font-size: 20px; color: white; font-family: sans-serif;" href={{route('homePage')}}>Home</a>
            </li>

            <li style="display: inline-block; margin-right: 70px;">
{{--                <a style="text-decoration: none; font-size: 20px; color: white; font-family: sans-serif;" href='#'>About Us</a>--}}
                <div class="dropdown">
                    <p role="button" style="text-decoration: none; font-size: 20px; color: white; font-family: sans-serif;" class="dropdown-toggle" id="action" type="button" data-coreui-toggle="dropdown" aria-expanded="false">
                        {{__('Choose language')}}
                    </p>
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
            </li>

            <li style="display: inline-block; margin-right: 70px;">
                <a style="text-decoration: none; font-size: 20px; color: white; font-family: sans-serif;" href={{route('book.index')}}>Manager</a>
            </li>
            <li style="display: inline-block; margin-right: 70px;">
                <a style="text-decoration: none; font-size: 20px; color: white; font-family: sans-serif;" href='#'>Contact</a>
            </li>
        </ul>
    </nav>
</div>
