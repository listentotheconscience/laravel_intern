<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentCreateRequest;
use App\Http\Requests\CommentDeleteRequest;
use App\Http\Requests\CommentShowRequest;
use App\Models\Author;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CommentController extends BaseController
{
    public function store(CommentCreateRequest $request)
    {
        Comment::create([
            'text' => $request->text,
            'author_id' => $request->author_id,
            'post_id' => $request->post_id,
            'commentable_type' => User::class,
            'commentable_id' => Auth::id(),
            'parent_id' => $request->parent_id
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
        if (Auth::guest())
        {
            $data = Comment::create([
                'text' => $request->text,
                'author_id' => $request->author_id,
                'post_id' => $request->post_id,
                'commentable_type' => Author::class,
                'commentable_id' => Post::find($request->post_id)->author_id,
                'parent_id' => $request->parent_id
            ]);
        }
        else
        {
            $data = Comment::create([
                'text' => $request->text,
                'author_id' => $request->author_id,
                'post_id' => $request->post_id,
                'commentable_type' => User::class,
                'commentable_id' => Auth::user()->id,
                'parent_id' => $request->parent_id
            ]);
        }
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
