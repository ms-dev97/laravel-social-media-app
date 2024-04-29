<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Post;

class HomeController extends Controller
{
    public function index() {
        $posts = Post::with('user')->latest()->paginate(10);
        return Inertia::render('Home', [
            'posts' => $posts,
        ]);
    }
}
