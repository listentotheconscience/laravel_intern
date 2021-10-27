<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentCreateRequest;
use App\Http\Requests\CommentDeleteRequest;
use App\Http\Requests\CommentShowRequest;
use App\Models\Comment;

class CommentController extends BaseController
{
    public function store(CommentCreateRequest $request)
    {
        Comment::create([
           'text' => $request->text,
           'author_id' => $request->author_id,
           'post_id' => $request->post_id
        ]);

        return redirect()->back();
    }

    public function delete(CommentDeleteRequest $request)
    {
        Comment::find($request->id)->delete();

        return redirect()->back();
    }

    public function apiStore(CommentCreateRequest $request)
    {
        $data = Comment::create([
            'text' => $request->text,
            'author_id' => $request->author_id,
            'post_id' => $request->post_id
        ]);

        return $this->sendResponse($data, "OK");
    }

    public function apiDelete(CommentDeleteRequest $request)
    {
        Comment::find($request->id)->delete();

        return $this->sendResponse([], 'OK');
    }

    public function apiShowComments(CommentShowRequest $request)
    {
        $data = Comment::where('post_id', $request->post_id)->get();

        return $this->sendResponse($data, 'List len: ' . $data->count());
    }
}
