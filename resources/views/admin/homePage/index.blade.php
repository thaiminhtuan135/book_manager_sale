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
                <button class="header-toggler px-md-0 me-md-3" type="button"
                        onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()">
                    <i class="icon icon-lg fa fa-bars" aria-hidden="true"></i>
                </button>
                <a style="text-decoration: none;" href="{{route('login.index')}}">
                    <button class="btn btn-primary">Đăng nhập</button>
                </a>
                <a style="text-decoration: none;" href="{{route('register.index')}}">
                    <button style="" class="btn btn-success">Đăng ký</button>
                </a>

            </div>
            <div class="header-divider"></div>
            <div class="container-fluid">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb border-0 m-0">
                        {{--                <li class="breadcrumb-item"><a href="{{ route('Admin.dashboard.index') }}">ホーム</a></li>--}}
                        @if (isset($breadcrumbs))
                            @foreach ($breadcrumbs as $key => $breadcrumb)
                                @if ($key != count($breadcrumbs) - 1)
                                    <li class="breadcrumb-item">
                                        <a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['name'] }}</a>
                                    </li>
                                @else
                                    <li class="breadcrumb-item active">{{ $breadcrumb }}</li>
                                @endif
                            @endforeach
                        @endif
                    </ol>
                </nav>
            </div>
        </header>

        <div class="body">
            <div class="container-fluid">
                <div class="fade-in">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <label>Danh sách</label>
                                </div>
                                <div class="card-body">
                                    @if (!$bookList->isEmpty())
                                        <div class="row">
                                            <div class="col-md-5 col-sm-5 col-xs-12 group-select-page d-flex">
                                                <limit-page-option :limit-page-option="{{ json_encode([10, 20, 30]) }}"
                                                                   :new-size-limit="{{ $newSizeLimit }}"></limit-page-option>
                                            </div>
                                            <div class="col-md-7 col-sm-7 col-xs-12 group-paginate">
                                                {{ $bookList->appends(SearchQueryComponent::alterQuery($request))->links('vendor.pagination.bootstrap-4') }}
                                            </div>
                                        </div>
                                        <table class="table table-responsive-sm table-striped">
                                            <thead class="table-dark">
                                            <tr>
                                                <th>Tiêu đề</th>
                                                <th>Tác giả</th>
                                                <th>Thể loại</th>
                                                <th>Ngày phát hành</th>
                                                <th>Số trang</th>
                                                <th>Ảnh</th>

                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($bookList as $book)
                                                <tr>
                                                    <td>{{$book->title }}</td>
                                                    <td>{{$book->author }}</td>
                                                    <td>{{$book->category }}</td>
                                                    <td>{{$book->release_date }}</td>
                                                    <td>{{$book->number_page }}</td>
                                                    <td>
                                                        <img src="{{ url('/imgBook/'.$book->image) }}" alt="" width="100"
                                                             height="100">
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                        <div class="group-paginate">
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



