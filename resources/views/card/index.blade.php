@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="fade-in">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <label>Giỏ hàng</label>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="searchFrom pull-right">
                                        <form action="{{ route('card.index') }}" class="form-inline">
                                            <div>
                                                <input name="search_input" class="form-control" placeholder="Tìm kiếm"
                                                       value="{{ $request->search_input }}" autocomplete="off"
                                                       type="control"
                                                       id="search_input">
                                                <button type="submit" class="btn btn-primary w-120"><i
                                                        class="fa fa-search"></i> &nbsp; Tìm kiếm</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @if (!$products->isEmpty())
                                <div class="row">
                                    <div class="col-md-7 col-sm-7 col-xs-12 group-paginate">
                                        {{ $products->links('vendor.pagination.bootstrap-5') }}
                                    </div>
                                </div>
                                <table class="table table-responsive-sm table-striped">
                                    <thead class="table-dark">
                                    <tr>
                                        <th>Sách</th>
                                        <th>Tác giả</th>
                                        <th>Số lượng</th>
                                        <th class="w-100"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($products as $product)
                                        <tr>
                                            <td>
                                                <img src="{{ url($product->books->image) }}" alt="" width="100" height="120">
                                            </td>
                                            <td>{{$product->books->author }}</td>
                                            <td>{{$product->amount }}</td>
                                            <td style="width: 110px">
                                                <btn-delete-confirm
                                                    :message-confirm="{{ json_encode('Bạn có chắc chắn muốn xóa ?') }}"
                                                    :delete-action="{{ json_encode(route('card.destroy', $product->id)) }}"
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
                                    {{ $products->links('vendor.pagination.bootstrap-4') }}
                                </div>
                            @else
                                <data-empty></data-empty>
                            @endif
                        </div>
                        <div>
                            <button class="btn btn-success w-25 pull-right mb-2" style="margin-right: 20px;">Thanh toán</button>
                            <a href="{{route('product.index')}}" class="pull-right btn btn-primary" style="margin-right: 20px;">Tiếp tục mua hàng</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<comment-grid>

</comment-grid>
@endsection
