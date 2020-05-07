@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-5 p-5 "><img class="rounded-circle w-100"
                                         src="{{$user->profile->profileImage()}} "
                style="max-height: 150px; max-width: 150px">
            </div>
            <div class="col-7 pt-5">
                <div class="d-flex  align-items-baseline">
                    <h1 class="pr-3"> {{$user->username}}</h1>
                    <follow-button user-id="{{$user->id}} " follows="{{$follows}}"></follow-button>
                    @can('update',$user->profile)
                        <a href="/p/create" class="pl-5 ml-5">Add New Post</a>
                    @endcan
                </div>
                @can('update',$user->profile)
                    <a href="/profile/{{$user->id}}/edit">Edit profile</a>
                @endcan
                <div class="row">
                    <div class="col-3"><strong>{{ $postCount }}</strong> posts</div>
                    <div class="col-3"><strong>{{$user->profile->followers->count()}}</strong> followers</div>
                    <div class="col-3"><strong>{{$user->following->count()}}</strong> following</div>
                </div>
                <div class="link pt-2 ">
                    {{$user->profile->title}}
                </div>
                <div class="align-content-end card-img " style=" width: 30%">{{$user->profile->description}}
                </div>
                <div><a href="#">{{$user->profile->url ?? "N/A"}}</a></div>
            </div>
        </div>
        <div class="row ">
            @foreach($user->posts as $post)
                <div class="col-4">
                    <a href="/p/{{$post->id}}">
                        <img class="img-thumbnail w-100 h-100"
                             src="/storage/{{$post->image}}">
                    </a>
                </div>
            @endforeach


        </div>
    </div>
@endsection
