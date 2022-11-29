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
                            <label>{{__('List book')}}</label>
                            <div class="box-action d-flex">
                                <a href="{{ route('book.create') }}" class="btn btn-primary btn-action">
                                    <i class="fa fa-plus"></i>{{__('Add book')}}
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="searchFrom pull-right">
                                        <form action="{{ route('book.index') }}" class="form-inline">
                                            <div>
                                                <input name="search_input" class="form-control" placeholder="Tìm kiếm"
                                                       value="{{ $request->search_input }}" autocomplete="off"
                                                       type="control"
                                                       id="search_input">
                                                <button type="submit" class="btn btn-primary w-120"><i
                                                        class="fa fa-search"></i> &nbsp; {{__('Search')}}</button>
                                            </div>
                                            <book-export
                                                :data="{{json_encode([
                                                    'url' => route('bookExport'),
                                                    'request' => $request->all(),
                                                    'message' => __('Download'),
                                               ])}}"
                                            ></book-export>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @if (!$bookList->isEmpty())
                                <div class="row">
                                    <div class="col-md-7 col-sm-7 col-xs-12 group-paginate">
                                        {{ $bookList->links('vendor.pagination.bootstrap-5') }}
                                    </div>
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
                                        <th class="w-110">
                                        </th>
                                        <th class="w-110">
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($bookList as $book)
                                        <tr>
                                            <td>{{$book->title }}</td>
                                            <td>{{$book->author }}</td>
                                            <td style="width: 300px">{{$book->description }}</td>
                                            <td>{{$book->category }}</td>
                                            <td>{{$book->release_date }}</td>
                                            <td>{{$book->number_page }}</td>
                                            @if($book->image)
                                                <td>
                                                    <img src="{{ url($book->image) }}" alt="" width="100" height="120">
                                                </td>
                                            @else
                                            <td>
                                                Không có ảnh
                                            </td>
                                            @endif
                                            <td style="width: 110px">
                                                <a class="btn btn-primary" href="{{ route('book.edit', $book->id) }}">
                                                    <i class="fa fa-eye"></i>{{__('Edit')}}
                                                </a>
                                            </td>
                                            <td style="width: 110px">
                                                <btn-delete-confirm
                                                    :message-confirm="{{ json_encode(__('DeleteBook')) }}"
                                                    :delete-action="{{ json_encode(route('book.destroy', $book->id)) }}"
                                                    :data="{{json_encode([
                                                        'Delete' => __('Delete'),
                                                        'yes' => __('Yes'),
                                                        'no' => __('No'),
                                                        'can' => __('Cancel')
                                                    ])}}">
                                                </btn-delete-confirm>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <div class="group-paginate justify-content-center d-flex">
                                    {{ $bookList->links('vendor.pagination.bootstrap-4') }}
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
