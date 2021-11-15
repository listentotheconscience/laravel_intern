<?php

namespace App\Repositories;

use App\Models\Author;

class AuthorRepository
{
    public function all()
    {
        return Author::all();
    }

    public function store($name, $image_path)
    {
        return Author::create([
            'name' => $name,
            'avatar' => $image_path
        ]);
    }

    public function paginate($per_page)
    {
        return Author::paginate($per_page);
    }

    public function getById($id)
    {
        return Author::find($id);
    }
}
