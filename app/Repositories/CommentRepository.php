<?php

namespace App\Repositories;

use App\Models\Comment;

class CommentRepository
{
    public function all()
    {
        return Comment::all();
    }

    public function getParentCommentAndPaginate($post_id, $per_page)
    {
        return Comment::where('post_id', $post_id)
            ->whereNull('parent_id')
            ->orderBy('created_at', 'desc')
            ->paginate($per_page);
    }
}
