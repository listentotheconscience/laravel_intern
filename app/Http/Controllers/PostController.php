<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostCreateRequest;
use App\Http\Requests\PostDeleteRequest;
use App\Http\Requests\PostGetByHashRequest;
use App\Http\Requests\PostGetByIdRequest;
use App\Http\Requests\PostRequest;
use App\Http\Resources\PostResource;
use App\Http\Resources\PostWithCommentsResource;
use App\Models\Author;
use App\Models\Comment;
use App\Models\Post;

class PostController extends BaseController
{
    public function getAll()
    {
        $data = Post::paginate(3);

        return view('posts')->with('posts', $data)->with('title', 'Posts');
    }

    public function store(PostCreateRequest $request)
    {
        $path = $request->image->store('images');

        Post::create([
            'title'=> $request->title,
            'description' => $request->description,
            'image' => $path,
            'author_id' => $request->author_id
        ]);

        return redirect('/posts');
    }

    public function createPost()
    {
        $authors = Author::all();
        return view('create_post')->with('title', 'Create Post')->with('authors', $authors);
    }

    public function deletePost(int $id)
    {
        Post::find($id)->delete();

        return redirect('/posts');
    }

    public function getByHash(PostGetByHashRequest $request)
    {
        $post = Post::where('hashed_link', $request->hash)->first();
        $comments = Comment::where('post_id', $post->id)->orderBy('created_at','desc')->paginate(5);

        return view('item')->with('title', $post->title)->with('post', $post)->with('comments', $comments);
    }

    public function apiGetAll()
    {
        $data = Post::all();

        if ($data->isEmpty()) {
            return $this->sendError('List is empty');
        }

        return $this->sendResponse(PostResource::collection($data), 'List len: ' . $data->count());
    }

    public function apiStore(PostCreateRequest $request)
    {
        $path = $request->image->store('images');

        $post = Post::create([
            'title'=> $request->title,
            'description' => $request->description,
            'image' => $path,
            'author_id' => $request->author_id
        ]);

        return $this->sendResponse($post, "OK");
    }

    public function apiDelete(PostDeleteRequest $request)
    {
        $input = $request->all();

        Post::find($input['id'])->delete();

        return $this->sendResponse([], "OK");
    }

    public function apiGetByHash(PostGetByHashRequest $request)
    {
        return $this->sendResponse(
            new PostWithCommentsResource(Post::where('hashed_link', $request->hash)->first()), "OK"
        );
    }
}
