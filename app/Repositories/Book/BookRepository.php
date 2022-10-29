<?php

namespace App\Repositories\Book;

use App\Components\CommonComponent;
use App\Models\Book;
use App\Http\Controllers\BaseController;
use App\Repositories\Book\BookInterface;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function PHPUnit\Framework\fileExists;

class BookRepository extends BaseController implements BookInterface
{
    private Book $book;

    public function __construct(Book $book)
    {
        $this->book = $book;
    }

    public function get($request)
    {
//        $books = $this->book->get();

        $newSizeLimit = $this->newListLimit($request);

        $bookBuilder = $this->book;
        $books = $bookBuilder->paginate($newSizeLimit);
        if ($this->checkPaginatorList($books)) {
            Paginator::currentPageResolver(function () {
                return 1;
            });
            $books = $bookBuilder->paginate($newSizeLimit);
        }
        return $books;
//        return $books;
    }

    public function getById($id)
    {
        return $this->book->where('id', $id)->first();
    }

    public function store($request)
    {
        if ($request->hasFile('image')) {
            $fileWeb = $request->file('image');
            $extensionWeb = $fileWeb->getClientOriginalExtension(); // lay .png
            $fileNameWeb = CommonComponent::uploadFileName($extensionWeb);
            $pathWeb = CommonComponent::uploadFile('image-media', $fileWeb, $fileNameWeb);
            $fileWeb->move('imgBook/', $fileNameWeb);
        }
        DB::beginTransaction();
        $this->book->title = $request->title;
        $this->book->author = $request->author;
        $this->book->category = $request->category;
        $this->book->release_date = $request->release_date;
        $this->book->number_page = $request->number_page;
        $this->book->image = $fileNameWeb ?? '';

        if ($this->book->save()) {
            DB::commit();
            return true;
        }
        DB::rollBack();
        return false;
    }

    public function update($request, $id)
    {

        $bookInfo = $this->book->where('id', $id)->first();
        if (!$bookInfo) {
            return false;
        }
        $pathWeb = '';
        if ($request->hasFile('image')) {
            $fileWeb = $request->file('image');
            $extensionWeb = $fileWeb->getClientOriginalExtension(); // lay .png
            $fileNameWeb = CommonComponent::uploadFileName($extensionWeb);
            $pathWeb = CommonComponent::uploadFile('image-media', $fileWeb, $fileNameWeb);
//            dd($pathWeb);
            $fileWeb->move('imgBook/', $fileNameWeb);
        }
        DB::beginTransaction();
        $bookInfo->title = $request->title;
        $bookInfo->author = $request->author;
        $bookInfo->category = $request->category;
        $bookInfo->release_date = $request->release_date;
        $bookInfo->number_page = $request->number_page;
        $bookInfo->image = $fileNameWeb ?? '';
        if ($bookInfo->save()) {
            DB::commit();
            return true;
        }
        DB::rollBack();
        return false;

    }

    public function destroy($id)
    {
        $bookInfo = $this->book->where('id', $id)->first();
        if (!$bookInfo) {
            return false;
        }
        return $bookInfo->delete();
    }
}


