<?php

namespace App\Http\Controllers;

use App\Profile;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\Facades\Image;
use function foo\func;

class ProfilesController extends Controller
{

    public function index($user)
    {
        $follows = auth()->user() ? auth()->user()->following->contains($user) : false;
        $user = User::findOrFail($user);
        $postCount = Cache::remember(
            'count.posts.' . $user->id,
            now()->addMinutes(45),
            function () use ($user) {
            return $user->posts->count();
        });
        return view('profiles.index', [
            'user' => $user,
            'follows' => $follows,
            'postCount' => $postCount,
        ]);

    }

    public function edit(User $user)
    {
        $this->authorize('update', $user->profile);
        return view('profiles.edit', compact('user'));
    }

    public function update(Profile $user)
    {
        //$this->authorize('update', $user->profile);
        $data = request()->validate([
            'title' => 'required',
            'description' => 'required',
            'url' => 'url',
            'image' => 'image'
        ]);
        //dd($user);

        if (request('image')) {
            $image_path = (request('image')->store("profile", 'public'));
            $image = Image::make(public_path("storage/{$image_path}"))->fit(1000, 1000);
            $image->save();
            array_merge(
                $data, ['image' => $image_path,]
            );
        }
        auth()->user()->profile->update($data);

        //dd($data);

        return redirect("/profile/{$user->id}");
    }
}
