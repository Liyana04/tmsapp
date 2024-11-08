@extends('layouts.app')

@section('content')
    <h1>Posts</h1>
    <!--check for the post if available or not, $posts variab;e follow in PostsController-->
    @if(count($posts))<!--can also just do (count($posts))-->
        @foreach($posts as $post)
        <div class="card card-body bg-light">
            <div class="row">
                <div class="col-md-4 col-sm-4">
                <img style="width:100%" src="/storage/my_images/{{$post->cover_image}}">
                </div>
                <div class="col-md-8 col-sm-8">
                    <h3><a href="/posts/{{$post->id}}">{{$post->title}}</a></h3>
                    <small>Written on {{$post->created_at}} , added by {{$post->user->name}}</small>            
                </div>
            </div>
        </div>
        </br>
        @endforeach
        {{$posts->links()}}
    @else
        <p>No posts found</p>
    @endif
@endsection