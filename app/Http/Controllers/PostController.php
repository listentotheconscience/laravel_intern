<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostCreateRequest;
use App\Http\Requests\PostDeleteRequest;
use App\Http\Requests\PostGetByHashRequest;
use App\Http\Requests\PostPagedRequest;
use App\Http\Resources\PostPagedResource;
use App\Http\Resources\PostResource;
use App\Http\Resources\PostWithCommentsResource;
use App\Models\Author;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Visitor;
use App\Nova\User;
use App\Repositories\AuthorRepository;
use App\Repositories\CommentRepository;
use App\Repositories\Interfaces\PostRepositoryInterface;
use App\Repositories\PostRepository;
use App\Repositories\UserRepository;
use App\Services\PostService;
use App\Services\VisitorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends BaseController
{

    public function __construct()
    {
        $this->repository = new PostRepository();
        $this->vistor = new VisitorService();
        $this->comments = new CommentRepository();
        $this->author = new AuthorRepository();
        $this->users = new UserRepository();
        $this->posts = new PostService();
    }

    public function getAll()
    {
        $data = $this->repository->paginate(3);

        return view('posts')->with('posts', $data)->with('title', 'Posts');
    }

    public function store(PostCreateRequest $request)
    {
        $path = $request->image->store('images');

        $this->repository->create(
            $request->title,
            $request->description,
            $path,
            $request->author_id
        );

        return redirect('/posts');
    }

    public function createPost()
    {
        $authors = $this->author->all();
        return view('create_post')->with('title', 'Create Post')->with('authors', $authors);
    }

    public function deletePost(int $id)
    {
        $this->repository->delete($id);

        return redirect('/posts');
    }

    public function getByHash(PostGetByHashRequest $request)
    {
        $post = $this->repository->getByHash($request->hash);
        $comments = $this->comments->getParentCommentAndPaginate($post->id, 5);

        // Create a unique visitor
        if ($this->users->getCurrentUser())
        {
            $this->vistor->addVisitorAsUser(Auth::id(), $post->id);
        } else {
            $this->vistor->addVisitorAsAnonymous($post->id);
        }

        $visitors_count = $this->vistor->getVisitorsCount($post->id);

        return view('item')
            ->with('title', $post->title)
            ->with('post', $post)
            ->with('comments', $comments)
            ->with('visitors', $visitors_count);
    }

    public function apiGetAll(PostPagedRequest $request)
    {
        $data = $this->repository->all();
        $result = $this->posts->getPostWithPagination($data, $request);

        if ($data->isEmpty()) {
            return $this->sendError('List is empty');
        }

        return $this->sendResponse(new PostPagedResource($result), 'List len: ' . $data->count());
    }

    public function apiStore(PostCreateRequest $request)
    {
        $path = $request->image->store('images');

        $post = $this->repository->create(
            $request->title,
            $request->description,
            $path,
            $request->author_id
        );


        return $this->sendResponse($post, "OK");
    }

    public function apiDelete(PostDeleteRequest $request)
    {

        $this->repository->delete($request->id);

        return $this->sendResponse([], "OK");
    }

    public function apiGetByHash(PostGetByHashRequest $request)
    {
        return $this->sendResponse(
            new PostWithCommentsResource($this->repository->getByHash($request->hash)), "OK"
        );
    }
}
