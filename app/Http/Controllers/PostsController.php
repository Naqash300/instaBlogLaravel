<?php

namespace App\Http\Controllers;

use App\Post;
use App\User;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth"/*, ['except' => ['index']]*/);

    }

    public function index()
    {
        $users = auth()->user()->following()->pluck('profiles.user_id');
       $posts = Post::whereIn('user_id',$users)->with('user')->latest()->paginate(5);

        if (!$posts || $posts == '')
        {
        $posts = Post::latest()->paginate(5);

        }

        //return response()->json($posts);
//        dd($posts);
        //$posts = Post::all()->sortBy("created_at");
        return view("posts.index", ['posts' => $posts]);
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
