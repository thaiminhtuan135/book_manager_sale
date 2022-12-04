<?php

namespace App\Http\Controllers;

use App\Repositories\Book\BookRepository;
use App\Repositories\Product\ProductRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $book;

    private $product;

    public function __construct(BookRepository $book, ProductRepository $product)
    {
        $this->book = $book;
        $this->product = $product;
    }

    public function index(Request $request)
    {
        $newSizeLimit = $this->newListLimit($request);
        return view('product.product', [
            'title' => 'Sản phẩm',
            'request' => $request,
            'bookList' => $this->book->get($request),
            'newSizeLimit' => $newSizeLimit,
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
        if ($this->product->store($request)) {
            $this->setFlash(__('Thêm giỏ hàng thành công'));

            return redirect(route('card.index'));
        }
        $this->setFlash(__('Thêm giỏ hàng thất bại'), 'error');

        return redirect()->route('card.index', $request->book_id);

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
        //
    }

    public function bookDetail(Request $request, $id)
    {
        $bookInfo = $this->book->getById($id);
        return view('product.book_detail', [
            'title' => 'Chi tiết sản phẩm',
            'book' => $bookInfo,
        ]);
    }
}
