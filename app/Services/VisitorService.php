<?php

namespace App\Services;

use App\Models\Visitor;
use Illuminate\Support\Facades\Auth;

class VisitorService
{
    public function addVisitorAsUser($visitor_id, $post_id)
    {
        return Visitor::findOrNew([
            'visitor_id' => $visitor_id,
            'post_id' => $post_id
        ]);
    }

    public function addVisitorAsAnonymous($post_id)
    {
        return Visitor::create([
            'visitor_id' => null,
            'post_id' => $post_id
        ]);
    }

    public function getVisitorsCount($post_id)
    {
        return Visitor::where('post_id', $post_id)->get()->count();
    }
}
