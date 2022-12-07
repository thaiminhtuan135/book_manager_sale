<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Book\BookInterface;
use Illuminate\Http\Request;

class YourController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    private $book;

    public function __construct(BookInterface $book)
    {
        $this->book = $book;
    }

    public function __invoke(Request $request)
    {
        $books = $this->book->get($request);
        return response()->json([
            $books
        ]);
    }

    public function __tuandeptrai(Request $request)
    {
        dd('echo');
    }
}
