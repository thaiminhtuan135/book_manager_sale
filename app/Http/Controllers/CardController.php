<?php

namespace App\Http\Controllers;

use App\Enums\StatusCode;
use App\Repositories\Product\ProductRepository;
use Illuminate\Http\Request;

class CardController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $product;

    public function __construct(ProductRepository $product)
    {
        $this->product = $product;
    }

    public function index(Request $request)
    {
//        dd($this->product->getCardDetail($request));
        return view('card.index', [
            'title' => 'Chi tiết giỏ hàng',
            'request' => $request,
            'products' => $this->product->getCardDetail($request),
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!$this->product->destroy($id)) {
            return response()->json([
                'message' => 'Xóa thất bại',
                'status' => StatusCode::OK
            ], StatusCode::INTERNAL_ERR);
        }
        return response()->json([
            'message' => 'Xóa thành công',
            'status' => StatusCode::OK
        ], StatusCode::OK);
    }
}
