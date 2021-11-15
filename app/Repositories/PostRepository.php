<?php

namespace App\Repositories;

use App\Models\Post;

class PostRepository
{
    public function all()
    {
        return Post::all();
    }

    public function create($title, $description, $image_path, $author_id)
    {
        return Post::create([
            'title' => $title,
            'description' => $description,
            'image' => $image_path,
            'author_id' => $author_id
        ]);
    }

    public function getByHash($hash)
    {
        return Post::where('hashed_link', $hash)->first();
    }

    public function delete($id)
    {
        return Post::find($id)->delete();
    }

    public function paginate($per_page)
    {
        return Post::paginate($per_page);
    }
}
