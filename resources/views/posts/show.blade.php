@extends('layouts.app')

@section('content')
<br>
    <a href="/posts" class="btn btn-primary">Return</a>
    <h1>{{$post->title}}</h1><!--curly breces not gonna post html-->
    <img style="width:100%" src="/storage/my_images/{{$post->cover_image}}">
    <br><br>
    <!--check for the post if available or not, $posts variab;e follow in PostsController]
    
    -->
    <small>Written on {{$post->created_at}}</small>
<div>
    {!!$post->body!!}
</div>
<hr>
<small>Written on {{$post->created_at}} , added by {{$post->user->name}}</small>
<hr>
@if(!Auth::guest())
@if(Auth::user()->id==$post->user_id)
        <a href="/posts/{{$post->id}}/edit" class="btn btn-primary">Edit</a>

        {!!Form::open(['action' => ['PostsController@destroy', $post->id], 'method' => 'POST','onsubmit' => 'return confirmDelete()'])!!}
            {{Form::hidden('_method', 'DELETE')}}
            {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
        {!!Form::close()!!}   
@endif
@endif
@endsection

<script>
function confirmDelete() {
var result = confirm('Are you sure you want to delete?');

if (result) {
        return true;
    } else {
        return false;
    }
}   
</script>