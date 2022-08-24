@php
use App\Components\SearchQueryComponent;
@endphp
@extends('layouts.admin')
@section('content')
    <div class="container">
        <div class="fade-in">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <label>Danh sách công ty</label>
                            <div class="box-action">
                                <a href="{{ route('company.create') }}" class="btn btn-primary btn-action">
                                    <i class="fa fa-plus"></i>Thêm công ty
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
{{--                            <div class="row">--}}
{{--                                <div class="col-md-12 col-sm-12 col-xs-12">--}}
{{--                                    <div class="searchFrom pull-right">--}}
{{--                                        <form action="{{ route('admin.company.index') }}" class="form-inline">--}}
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
                            @if (!$companyList->isEmpty())
                                <div class="row">
                                    <div class="col-md-5 col-sm-5 col-xs-12 group-select-page d-flex">
                                        <limit-page-option :limit-page-option="{{ json_encode([20, 50, 100]) }}"
                                                           :new-size-limit="{{ $newSizeLimit }}"></limit-page-option>
                                    </div>
                                    <div class="col-md-7 col-sm-7 col-xs-12 group-paginate">
                                        {{ $companyList->appends(SearchQueryComponent::alterQuery($request))->links('vendor.pagination.bootstrap-4') }}
                                    </div>
                                </div>
                                <table class="table table-responsive-sm table-striped">
                                    <thead class="table-dark">
                                    <tr>
                                        <th>Code</th>
                                        <th>Name</th>
                                        <th>Telephone</th>
                                        <th>Address</th>
                                        <th class="w-100">
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($companyList as $company)
                                        <tr>
                                            <td>{{$company->code }}</td>
                                            <td>{{$company->name }}</td>
                                            <td>{{$company->telephone }}</td>
                                            <td>{{$company->address }}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-primary dropdown-toggle" id="action"
                                                            type="button" data-coreui-toggle="dropdown"
                                                            aria-expanded="false">Tùy chọn
                                                    </button>
                                                    <ul class="dropdown-menu" aria-labelledby="action">
                                                        <li>
                                                            <a class="dropdown-item"
                                                               href="{{ route('company.edit', $company->id) }}"
                                                               class="dropdown-item">
                                                                <i class="fa fa-eye"></i>Sửa
                                                            </a>
                                                        </li>
                                                        <li class="dropdown-divider"></li>
                                                        <li>
                                                            <btn-delete-confirm
                                                                :message-confirm="{{ json_encode('Bạn có chắc chắn muốn xóa？') }}"
                                                                :delete-action="{{ json_encode(route('company.destroy', $company->id)) }}">
                                                            </btn-delete-confirm>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <div class="group-paginate">
                                    {{ $companyList->appends(SearchQueryComponent::alterQuery($request))->links('vendor.pagination.bootstrap-4') }}
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
