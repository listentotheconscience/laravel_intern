<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthorGetByIdRequest;
use App\Http\Requests\CreateAuthorRequest;
use App\Http\Requests\PostGetAllForAuthorId;
use App\Http\Resources\AuthorResource;
use App\Http\Resources\PostResource;
use App\Models\Author;
use App\Models\Post;
use App\Repositories\AuthorRepository;
use App\Services\PostService;

class AuthorController extends BaseController
{
    public function __construct()
    {
        $this->repository = new AuthorRepository();
        $this->posts = new PostService();
    }

    public function store(CreateAuthorRequest $request)
    {
        $path = $request->image->store('images');

        $this->repository->store($request->name, $path);

        return redirect('/authors');
    }

    public function getAll()
    {
        $data = $this->repository->paginate(7);

        return view('authors')->with('authors', $data)->with('title', 'Authors');
    }


    public function getById(AuthorGetByIdRequest $request)
    {
        $data = $this->repository->getById($request->id);

        $posts = $this->posts->getAllPostsByAuthorWithPagination($data->id, 5);

        return view('author')->with('author', $data)->with('title', $data->name)->with('posts', $posts);
    }

    public function apiGetAll()
    {
        $data = $this->repository->all();

        if ($data->isEmpty()) {
            return $this->sendError('List is empty');
        }

        return $this->sendResponse(AuthorResource::collection($data), 'List len: ' . $data->count());
    }

    public function apiStore(CreateAuthorRequest $request)
    {
        $path = $request->image->store('images');

        $data = $this->repository->store($request->name, $path);

        return $this->sendResponse($data, 'OK');
    }

    public function apiGetById(AuthorGetByIdRequest $request)
    {
        $data = $this->repository->getById($request->id);

        $posts = $this->posts->getAllPostsByAuthorWithPagination($data->id, 5);

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
