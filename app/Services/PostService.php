<?php

namespace App\Services;

use App\Models\Post;
use App\Repositories\AuthorRepository;
use App\Repositories\PostRepository;

class PostService
{
    const PER_PAGE = 3;
    protected $postRepository;
    protected $authorRepository;

    public function __construct()
    {
        $this->postRepository = new PostRepository();
        $this->authorRepository = new AuthorRepository();
    }

    public function getAllPostsByAuthorWithPagination($author_id, $per_page)
    {
        return Post::where('author_id', '=', $author_id)->paginate($per_page);
    }

    public function getPostWithPagination($posts, $request)
    {
        $page = $request->page ?: 1;
        $postsForPage = $posts->forPage($page, self::PER_PAGE);
        $isMorePages = ceil(count($posts)/ self::PER_PAGE) > $page ? true : false;

        return [
            'posts' => $postsForPage,
            'isMorePages' => $isMorePages
        ];
    }

    public function shuffleAuthors()
    {
        $authors = $this->authorRepository->all()->count();
        $posts = $this->postRepository->all();

        foreach ($posts as $post) {
            $post->author_id = random_int(1, $authors);
            $post->save();
        }
    }
}
