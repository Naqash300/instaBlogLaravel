<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store()
    {
        $data = \request()->validate([
            'caption' => 'required',
            'image' => ['required', 'image'],
        ]);

        $image_path = (request('image')->store("uploads", 'public'));
        $image = Image::make(public_path("storage/{$image_path}"))->fit(1200, 1200);
        $image->save();
        // auth()->user()->posts()->create($data);
        auth()->user()->posts()->create([

            'caption' => $data['caption'],
            'image' => $image_path,
        ]);
        return redirect("/profile/" . auth()->user()->id);
        // \App\Post::create($data);
    }

    public function show(Post $post)
    {

        return view("posts.show", ['post' => $post]);
    }
}
