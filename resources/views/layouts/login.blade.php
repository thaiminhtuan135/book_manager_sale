<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}">
    @if (isset($title))
        <title>{{ $title }}</title>
    @endif
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
    <script src="{{ asset('js/adminApp.js') }}" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css"
          integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <script src="https://yubinbango.github.io/yubinbango/yubinbango.js" charset="UTF-8"></script>
    @yield('css')
    <script>
        window.Laravel = {!!json_encode([
                'csrfToken' => csrf_token(),
                'baseUrl' => url('/'),
            ], JSON_UNESCAPED_UNICODE)!!};
    </script>
</head>

<body>
<div id="app">
    {{--    @include('include.admin.headerRegister')--}}
    {{--    <div class="c-wrapper">--}}
    {{--        <div class="c-body">--}}
    {{--            <main class="c-main">--}}
    {{--                @yield('content')--}}
    {{--            </main>--}}

{{--            <img class="" src="{{ url('/assets/img/avatars/bg-2.jpg') }}">--}}
    {{--        </div>--}}
    {{--    </div>--}}
    <div class="full-page">

        <div class="navbar">
            <div>
                <a href="#">Seek Coding</a>
            </div>
            <nav>
                <ul id='MenuItems'>
                    <li><a href='#'>Home</a></li>
                    <li><a href='#'>About Us</a></li>
                    <li><a href='#'>Services</a></li>
                    <li><a href='#'>Contact</a></li>
                </ul>
            </nav>
        </div>

        <div class="c-body">
            <main class="c-main">
                @yield('content')
            </main>
        </div>
    </div>

    @if (session()->get('Message.flash'))
        <popup-alert :data="{{json_encode(session()->get('Message.flash')[0])}}"></popup-alert>
    @endif
    @php
        session()->forget('Message.flash');
    @endphp
</div>
<div class="loading-div hidden">
    <div class="loader-img"></div>
</div>


<script src="{{ asset('js/coreui.bundle.min.js') }}"></script>
<script src="https://unpkg.com/vue-demi@0.12.1/lib/index.iife.js"></script>

<!-- Then load vue-recaptcha -->
<script src="https://unpkg.com/vue-recaptcha@^2/dist/vue-recaptcha.js"></script>
<!-- Minify -->
<script src="https://unpkg.com/vue-recaptcha@^2/dist/vue-recaptcha.min.js"></script>

@yield('javascript')
</body>
</html>
