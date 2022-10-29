<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusCode;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\BookRequest;
use App\Repositories\Book\BookInterface;
use App\Repositories\Company\CompanyInterface;
use Illuminate\Http\Request;

class BookController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $book;

    public function __construct(BookInterface $book)
    {
        $this->book = $book;
    }

    public function index(Request $request)
    {
//        dd($this->book->get($request));

        $newSizeLimit = $this->newListLimit($request);
        return view('admin.book.index',[
            'title'=> 'Quản lý sách',
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
        return view('admin.book.create', ['title' => 'Thêm sách']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BookRequest $request)
    {
//        dd($request->all());
        if ($this->book->store($request)) {
            $this->setFlash(__('Thêm sách thành công'));
            return redirect(route('book.index'));
        }
        $this->setFlash(__('Thêm sách thất bại'));
        return redirect()->route('book.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $book = $this->book->getById($id);
        if (!$book) {
            return redirect(route('book.index'));
        }
        return view('admin.book.edit', [
            'title' => 'Sửa sách',
            'book' => $book,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BookRequest $request, $id)
    {
        if ($this->book->update($request,$id)) {
            $this->setFlash(__('Sửa thành công'));
            return redirect(route('book.index'));
        }
        $this->setFlash(__('Sửa thất bại'));
        return redirect(route('book.update', $id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!$this->book->destroy($id)) {
            return response()->json([
                'message' => 'エラーが発生しました。',
                'status' => StatusCode::OK
            ], StatusCode::INTERNAL_ERR);
        }
        return response()->json([
            'message' => 'Xóa thành công',
            'status' => StatusCode::OK
        ], StatusCode::OK);
    }

    public function homeList(Request $request)
    {
        $newSizeLimit = $this->newListLimit($request);
        return view('admin.homePage.index',[
            'title'=> 'Quản lý sách',
            'request' => $request,
            'bookList' => $this->book->get($request),
            'newSizeLimit' => $newSizeLimit,
        ]);
    }
}
