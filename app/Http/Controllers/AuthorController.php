<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthorGetByIdRequest;
use App\Http\Requests\CreateAuthorRequest;
use App\Http\Requests\PostGetAllForAuthorId;
use App\Http\Resources\AuthorResource;
use App\Http\Resources\PostResource;
use App\Models\Author;
use App\Models\Post;

class AuthorController extends BaseController
{
    public function store(CreateAuthorRequest $request)
    {
        $path = $request->image->store('images');

        Author::create([
            'name' => $request->name,
            'avatar' => $path
        ]);

        return redirect('/authors');
    }

    public function getAll()
    {
        $data = Author::paginate(7);

        return view('authors')->with('authors', $data)->with('title', 'Authors');
    }


    public function getById(AuthorGetByIdRequest $request)
    {
        $data = Author::find($request->id);
        $posts = Post::where('author_id', '=', $data->id)->paginate(5);
        return view('author')->with('author', $data)->with('title', $data->name)->with('posts', $posts);
    }

    public function apiGetAll()
    {
        $data = Author::all();

        if ($data->isEmpty()) {
            return $this->sendError('List is empty');
        }

        return $this->sendResponse(AuthorResource::collection($data), 'List len: ' . $data->count());
    }

    public function apiStore(CreateAuthorRequest $request)
    {
        $path = $request->image->store('images');

        $data = Author::create([
            'name' => $request->name,
            'avatar' => $path
        ]);

        return $this->sendResponse($data, 'OK');
    }

    public function apiGetById(AuthorGetByIdRequest $request)
    {
        $data = Author::find($request->id);
        $posts = Post::where('author_id', '=', $data->id)->get();

        if ($posts->isEmpty()) {
            return $this->sendError('List is empty');
        }

        $response = [
            'author' => new AuthorResource($data),
            'posts' => PostResource::collection($posts)
        ];

        return $this->sendResponse($response, 'Posts: ' . $posts->count());
    }
}
