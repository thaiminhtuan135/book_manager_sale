@php
    use App\Components\SearchQueryComponent;
@endphp

    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}">
    @if (isset($title))
        <title>{{ $title }}</title>
    @endif
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/all.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
          integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
          crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css"
          integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <script src="{{ asset('js/adminApp.js') }}" defer></script>
    <script src="https://yubinbango.github.io/yubinbango/yubinbango.js" charset="UTF-8"></script>

    @yield('css')
    <script>
        window.Laravel = {!!json_encode([
            'csrfToken' => csrf_token(),
            'baseUrl' => url('/'),
        ], JSON_UNESCAPED_UNICODE)!!};
    </script>
</head>

<body class="c-app">
<div id="app">

    <div class="wrapper d-flex flex-column min-vh-100 bg-light">
        <header class="header header-sticky mb-2">
            <div class="container-fluid">
                {{--                <button class="header-toggler px-md-0 me-md-3" type="button"--}}
                {{--                        onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()">--}}
                {{--                    <i class="icon icon-lg fa fa-bars" aria-hidden="true"></i>--}}
                {{--                </button>--}}
                <div class="pull-right">
                    <a style="text-decoration: none; margin-right: 10px;" href="{{route('login.index')}}">
                        <button class="btn btn-primary">{{__('Log in')}}</button>
                    </a>
                    <a style="text-decoration: none;" href="{{route('register.index')}}">
                        <button style="" class="btn btn-success">{{__('Sign up')}}</button>
                    </a>
                </div>


            </div>
            <div class="header-divider"></div>
            <div class="container-fluid">
                <div class="dropdown">
                    <button class="btn btn-warning dropdown-toggle" id="action" type="button"
                            data-coreui-toggle="dropdown" aria-expanded="false">
                        {{__('Choose language')}}
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="action">
                        <li>
                            <a class="dropdown-item" href="{{route('language.index',['vi'])}}">
                                <i class=""></i>Tiếng việt
                            </a>
                        </li>
                        <li class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item" href="{{route('language.index',['en'])}}">
                                <i class="flag-icon flag-icon-us"></i>English
                            </a>
                        </li>

                    </ul>
                </div>
            </div>
        </header>

        <div class="body">
            <div class="container-fluid">
                <div class="fade-in">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <button class="btn btn-outline-success">
                                        @if(Auth::guard('user')->user())
                                            <a href="{{route('product.index')}}" style="text-decoration: none;">Mua sách</a>
                                        @else
                                            <a href="{{route('login.index')}}" style="text-decoration: none;">Mua sách</a>
                                        @endif
                                    </button>
                                    <div class="d-flex justify-content-between">
                                        <swiper-slide></swiper-slide>
{{--                                        <swiper-slide></swiper-slide>--}}
                                    </div>
                                    <div class="text-center">
                                        <label class="mt-2">{{__('List book')}}</label>
                                    </div>
                                </div>
                                <div class="card-body">
                                    @if (!$bookList->isEmpty())
                                        <div class="row">
                                            <div class="col-md-5 col-sm-5 col-xs-12 group-select-page d-flex">
{{--                                                <limit-page-option :limit-page-option="{{ json_encode([10, 20, 30]) }}"--}}
{{--                                                                   :new-size-limit="{{ $newSizeLimit }}"--}}
{{--                                                                   :data="{{json_encode(['message' => __('Results show')])}}">--}}

{{--                                                </limit-page-option>--}}
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-center group-paginate">
                                            {{ $bookList->appends(SearchQueryComponent::alterQuery($request))->links('vendor.pagination.bootstrap-4') }}
                                        </div>
                                        <table class="table table-responsive-sm table-striped">
                                            <thead class="table-dark">
                                            <tr>
                                                <th>{{__('Title')}}</th>
                                                <th>{{__('Author')}}</th>
                                                <th>{{__('Description')}}</th>
                                                <th>{{__('Category')}}</th>
                                                <th>{{__('Release_date')}}</th>
                                                <th>{{__('Number_page')}}</th>
                                                <th>{{__('Image')}}</th>

                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($bookList as $book)
                                                <tr>
                                                    <td>{{$book->title }}</td>
                                                    <td style="width: 150px;">{{$book->author }}</td>
                                                    <td style="width: 350px">{{$book->description }}</td>
                                                    <td>{{$book->category }}</td>
                                                    <td>{{$book->release_date }}</td>
                                                    <td>{{$book->number_page }}</td>
                                                    <td><img src="{{ $book->image }}" alt="Không có ảnh" width="100" height="100">
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                        <div class="justify-content-center align-items-center d-flex group-paginate">
                                            {{ $bookList->appends(SearchQueryComponent::alterQuery($request))->links('vendor.pagination.bootstrap-4') }}
                                        </div>
                                    @else
                                        <data-empty></data-empty>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('include.admin.footer')
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
@yield('javascript')
</body>
</html>



