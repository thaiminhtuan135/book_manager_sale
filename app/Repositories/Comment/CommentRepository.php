<?php

namespace App\Repositories\Comment;

use App\Models\Comment;
use App\Http\Controllers\BaseController;
use App\Repositories\Comment\CommentInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CommentRepository extends BaseController implements CommentInterface
{
    private Comment $comment;
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    public function get($request)
    {
        $comments = $this->comment->with('users')->where('book_id', $request->book_id)
            ->orderBy('id','desc')
            ->get();
        return $comments;
    }

    public function getById($id)
    {
        // TODO: Implement getById() method.
    }

    public function store($request)
    {
        DB::beginTransaction();
        $this->comment->body = $request->comment;
        $this->comment->book_id = $request->book_id;
        $this->comment->user_id = Auth::guard('user')->id();
        $this->comment->is_published = 1;

        if ($this->comment->save()) {
            DB::commit();
            return $this->comment;
        }
        DB::rollBack();
        return false;
    }

    public function update($request, $id)
    {
        // TODO: Implement update() method.
    }

    public function destroy($id)
    {
        // TODO: Implement destroy() method.
    }


}
