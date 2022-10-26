@php
    use App\Components\SearchQueryComponent;

@endphp
@extends('layouts.admin')
@section('content')
    <div class="container-fluid">
        <div class="fade-in">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <label>Danh sách sách</label>
                            <div class="box-action">
                                <a href="{{ route('book.create') }}" class="btn btn-primary btn-action">
                                    <i class="fa fa-plus"></i>Thêm sách
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
{{--                            <div class="row">--}}
{{--                                <div class="col-md-12 col-sm-12 col-xs-12">--}}
{{--                                    <div class="searchFrom pull-right">--}}
{{--                                        <form action="{{ route('book.index') }}" class="form-inline">--}}
{{--                                            <div>--}}
{{--                                                <input name="search_input" class="form-control" placeholder="検索"--}}
{{--                                                       value="{{ $request->search_input }}" autocomplete="off" type="control"--}}
{{--                                                       id="search_input">--}}
{{--                                                <button type="submit" class="btn btn-primary w-100"><i--}}
{{--                                                        class="fa fa-search"></i> &nbsp; 検索</button>--}}
{{--                                            </div>--}}
{{--                                        </form>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
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
                                        <th class="w-100">
                                        </th>
                                        <th class="w-100">
                                        </th>
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
                                            <td>{{$book->image }}</td>
                                            <td>
                                                <a class="btn btn-primary"
                                                   href="{{ route('book.edit', $book->id) }}"
                                                   >
                                                    <i class="fa fa-eye"></i>Sửa
                                                </a>
                                            </td>
                                            <td>
                                                <btn-delete-confirm
                                                    :message-confirm="{{ json_encode('Bạn có chắc chắn muốn xóa？') }}"
                                                    :delete-action="{{ json_encode(route('book.destroy', $book->id)) }}">
                                                </btn-delete-confirm>
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
@endsection
