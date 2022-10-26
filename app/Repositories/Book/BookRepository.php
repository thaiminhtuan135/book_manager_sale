<?php

namespace App\Repositories\Book;

use App\Models\Book;
use App\Http\Controllers\BaseController;
use App\Repositories\Book\BookInterface;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
//        DB::beginTransaction();
//        $this->company->code = $request->code;
//        $this->company->name = $request->name;
//        $this->company->telephone = $request->telephone;
//        $this->company->address = $request->address;
//        if ($this->company->save()) {
//            DB::commit();
//            return true;
//        }
//        DB::rollBack();
//        return false;
    }

    public function update($request, $id)
    {
//        $companyInfo = $this->book->where('id', $id)->first();
//        if (!$companyInfo) {
//            return false;
//        }
//        DB::beginTransaction();
//        $companyInfo->code = $request->code;
//        $companyInfo->name = $request->name;
//        $companyInfo->telephone = $request->telephone;
//        $companyInfo->address = $request->address;
//        if ($companyInfo->save()) {
//            DB::commit();
//            return true;
//        }
//        DB::rollBack();
//        return false;
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
