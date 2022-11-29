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

        if (isset($request['search_input'])) {
            $bookBuilder = $bookBuilder->where(function ($q) use ($request) {
                $q->orWhere('author', 'like', '%' . $request["search_input"] . '%');
                $q->orWhere('category', 'like', '%' . $request["search_input"] . '%');
                $q->orWhere('number_page', 'like', '%' . $request["search_input"] . '%');
                $q->orWhere('release_date', 'like', '%' . $request["search_input"] . '%');
            });
        }

        $books = $bookBuilder->paginate(10);
//        if ($this->checkPaginatorList($books)) {
//            Paginator::currentPageResolver(function () {
//                return 1;
//            });
//            $books = $bookBuilder->paginate($newSizeLimit);
//        }
        return $books;
//        return $books;
    }

    public function getById($id)
    {
        return $this->book->where('id', $id)->first();
    }

    public function store($request)
    {
//        dd($request->all());

        DB::beginTransaction();
        $this->book->title = $request->title;
        $this->book->author = $request->author;
        $this->book->description = $request->description;
        $this->book->category = $request->category;
        $this->book->release_date = $request->release_date;
        $this->book->number_page = $request->number_page;
//        $this->book->image = '/imgBook/' . $fileNameWeb ?? null;

        if ($request->hasFile('image')) {
            $fileWeb = $request->file('image');
            $extensionWeb = $fileWeb->getClientOriginalExtension(); // lay .png
            $fileNameWeb = CommonComponent::uploadFileName($extensionWeb);
            $pathWeb = CommonComponent::uploadFile('image-media', $fileWeb, $fileNameWeb);
            $fileWeb->move('imgBook/', $fileNameWeb);
            $this->book->image = '/storage/' . $pathWeb;
        }
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

        DB::beginTransaction();
        $bookInfo->title = $request->title;
        $bookInfo->author = $request->author;
        $bookInfo->description = $request->description;
        $bookInfo->category = $request->category;
        $bookInfo->release_date = $request->release_date;
        $bookInfo->number_page = $request->number_page;

        if ($bookInfo->image) {
            if (!$request->hasFile('image')) {
                $filename = explode('/', $bookInfo->image);
                CommonComponent::deleteFile('image-media', $filename[3]);
                $bookInfo->image = null;

            }
        }

        if ($bookInfo->image) {
            if ($request->hasFile('image')) {
                $fileWeb = $request->file('image');
                $extensionWeb = $fileWeb->getClientOriginalExtension(); // lay .png
                $fileNameWeb = CommonComponent::uploadFileName($extensionWeb);
                $pathWeb = CommonComponent::uploadFile('image-media', $fileWeb, $fileNameWeb);
//                $fileWeb->move('imgBook/', $fileNameWeb);
                $filename = explode('/', $bookInfo->image);
                CommonComponent::deleteFile('image-media', $filename[3]);
                $bookInfo->image = '/storage/' . $pathWeb;
            }
        }
        elseif ($request->hasFile('image')) {
            $fileWeb = $request->file('image');
            $extensionWeb = $fileWeb->getClientOriginalExtension(); // lay .png
            $fileNameWeb = CommonComponent::uploadFileName($extensionWeb);
            $pathWeb = CommonComponent::uploadFile('image-media', $fileWeb, $fileNameWeb);
            $fileWeb->move('imgBook/', $fileNameWeb);
            $bookInfo->image = '/storage/' . $pathWeb;
        }
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

    public function export($request)
    {
        DB::statement("SET SQL_MODE=''");
        return Book::all();
    }

    public function checkNameBook($request)
    {
        return !$this->book->where('title', $request['value'])->exists();
    }
}


