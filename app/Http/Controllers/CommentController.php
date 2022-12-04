<?php

namespace App\Http\Controllers;

use App\Enums\StatusCode;
use App\Models\Comment;
use App\Repositories\Comment\CommentRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $comment;
    public function __construct(CommentRepository $comment)
    {
        $this->comment = $comment;
    }

    public function index(Request $request)
    {
        //
    }

    // public function handleSelect(Request $request)
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
//        $comment = Comment::created([
//            'body' => $request->body,
//            'user_id' => Auth::guard('user')->user()->id,
//            'is_published' => 1,
//            'book_id' => $request->id,
//        ]);
//        return response($comment, 201);
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

     public function handleAddComment(Request $request)
     {

         $comment = $this->comment->store($request);

         if ($comment) {
             return response()->json([
                 'valid' => $comment,
             ], StatusCode::OK);
         }

         return response()->json([
             'success' => false,
         ], StatusCode::BAD_REQUEST);
     }

    public function handleGetComment(Request $request)
    {
        $comments = $this->comment->get($request);
        if ($comments) {
            return response()->json([
                'valid' => $comments,
            ], StatusCode::OK);
        }

        return response()->json([
            'success' => false,
        ], StatusCode::BAD_REQUEST);
     }

}
