<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusCode;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\BookRequest;
use App\Repositories\Book\BookInterface;
use App\Repositories\Company\CompanyInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        return view('admin.book.index', [
            'title' => __('Book Manager'),
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

        return view('admin.book.create', ['title' => __('Add book')]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(BookRequest $request)
    {
//        dd($request->all());
        if ($this->book->store($request)) {
            $this->setFlash(__('AddBookSuceesful'));
            return redirect(route('book.index'));
        }
        $this->setFlash(__('Thêm sách thất bại'));
        return redirect()->route('book.create');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $book = $this->book->getById($id);
        if (!$book) {
            return redirect(route('book.index'));
        }
        return view('admin.book.edit', [
            'title' => __('EditBook'),
            'book' => $book,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(BookRequest $request, $id)
    {
        if ($this->book->update($request, $id)) {
            $this->setFlash(__('Success'));
            return redirect(route('book.index'));
        }
        $this->setFlash(__('Fail'));
        return redirect(route('book.update', $id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!$this->book->destroy($id)) {
            return response()->json([
                'message' => __('DeleteFail'),
                'status' => StatusCode::OK
            ], StatusCode::INTERNAL_ERR);
        }
        return response()->json([
            'message' => __('DeleteSuccess'),
            'status' => StatusCode::OK
        ], StatusCode::OK);
    }

    public function homeList(Request $request)
    {
        $newSizeLimit = $this->newListLimit($request);
        return view('admin.homePage.index', [
            'title' => __('Book Manager'),
            'request' => $request,
            'bookList' => $this->book->get($request),
            'newSizeLimit' => $newSizeLimit,
        ]);
    }

    public function export(Request $request)
    {
        $books = $this->book->export($request);
        $fileName = 'book'. Carbon::now()->format('YmdHis') . '.csv';
        $header = [
            'ID',
            'Tác giả',
            'Mô tả',
            'Thể loại',
            'Ngày phát hành',
            'Số trang',
        ];
        if (! file_exists(public_path() . '/export_csv')) {
            mkdir(public_path() . '/export_csv', 0777, true);
        }
        $localPath = public_path().'/export_csv/'.$fileName;
        $file = fopen($localPath, 'w');
        fwrite($file, "\xEF\xBB\xBF");
        fputcsv($file, $header);
        foreach ($books as $key => $book) {
            $row = [
                $book->id,
                $book->author,
                $book->description,
                $book->category,
                Carbon::parse($book->release_date)->format('d/m/Y'),
                $book->number_page,
            ];
            fputcsv($file, $row);
        }
        fclose($file);

        return response()->json([
            'path' => url('/export_csv/').'/'.$fileName,
        ]);
    }

    public function checkNameBook(Request $request)
    {
        return response()->json([
            'valid' => $this->book->checkNameBook($request),
        ], StatusCode::OK);
    }
}
