@extends('layouts.app')

@section('content')
    @foreach($posts as $post)
        <div class="container p-5">
            <div class="row align-items-center offset-3">
                <div class="col-6 align-items-center">

                    <a href="/profile/{{$post->user->id}}"> <img src="/storage/{{$post->image}}"
                                                                 class="w-100 img-fluid"></a>
                </div>
                <div class="row">
                </div>
                <div class="col-8 pt-4 align-items-center">
                    <div>
                        <div class="d-flex align-items-center">
                            <div class="pr-3">
                                <img src="{{$post->user->profile->profileImage()}}" class="w-100 rounded-circle "
                                     style="max-width: 50px; max-height:50px;">
                            </div>
                            <div>
                                <div class="font-weight-bolder">
                                    <a href="/profile/{{$post->user->profile->id}}"> <span
                                            class="text-dark"> {{$post->user->username}} </span></a>
                                </div>
                            </div>
                        </div>
                        <hr>

                        <p><span class="font-weight-bolder"><a href="/profile/{{$post->user->profile->id}}">  <span
                                        class="text-dark"> {{$post->user->username}} </span> </a></span>{{$post->caption}}
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <hr class="border-dark col-10">

    @endforeach

        <div class="pl-xl-5 ml-xl-auto"    style=" margin:auto;
                                  width:20%;
                                  text-align:center;">
            {{$posts->links()}}
        </div>
@endsection
