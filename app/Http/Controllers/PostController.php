<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StorePostRequest;
use App\Models\Post;

class PostController extends Controller
{
    public function store(StorePostRequest $request) {
        $data = $request->validated();
        $data['user_id'] = auth()->user()->id;
        
        Post::create($data);

        return back();
    }
}
