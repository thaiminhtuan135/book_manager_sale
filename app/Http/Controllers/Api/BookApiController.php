<?php

namespace App\Http\Controllers\Api;

use App\Enums\StatusCode;
use App\Http\Controllers\Controller;
use App\Repositories\Book\BookRepository;
use Illuminate\Http\Request;

class BookApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $book;
    public function __construct(BookRepository $book)
    {
        $this->book = $book;
    }

    public function index(Request $request)
    {
        $books = $this->book->get($request);
        if (!$books) {
            return response()->json([
                'message' => 'Not found',

            ],StatusCode::INTERNAL_ERR);
        }
        return response()->json([
            'data' => $books,
//            'dsada' => 'dsa',
        ], StatusCode::OK);
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        $this->book->store($request);
        if ($this->book->store($request)) {
            return response()->json([
                'message' => 'Thêm thành công',
            ], 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
//    /**
//     * @OA\Get(
//     *      path="/api/auth/book/{id}",
//     *      tags={"User Bukken"},
//     *      summary="Get user bukken detail",
//     *      security={{"bearerAuth":{}}},
//     *      @OA\Parameter(
//     *          name="id",
//     *          in="path",
//     *          required=true,
//     *          @OA\Schema(
//     *              type="integer",
//     *              example="1"
//     *          )
//     *      ),
//     *      @OA\Response(
//     *          response=200,
//     *          description="Success",
//     *          @OA\MediaType(
//     *              mediaType="application/json",
//     *          )
//     *      ),
//     *      @OA\Response(
//     *          response=400,
//     *          description="Invalid request"
//     *      ),
//     *      @OA\Response(
//     *          response=401,
//     *          description="Unauthorized"
//     *      ),
//     *      @OA\Response(
//     *          response=500,
//     *          description="Internal Server Error"
//     *      ),
//     *  )
//     **/
    public function show($id)
    {
        $book = $this->book->getById($id);
        return response()->json([
            'book' => $book
        ],StatusCode::OK);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
