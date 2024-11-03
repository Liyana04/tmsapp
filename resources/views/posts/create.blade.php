@extends('layouts.app')

@section('content')
    <h1>Add new product</h1>
    {!! Form::open(['action'=>'PostsController@store','method'=>'POST','enctype'=>'multipart/form-data']) !!}<!--can use url here open(['url' => 'foo/bar']).'enctype' is file upload button-->
    <div class="form-group">
        {{Form::label('title','Title')}}
        {{Form::text('title','',['class'=>'form-control','placeholder'=>'Title'])}}<!--it's going to be a create form so, no need input, next to 'title',''/to attribute, use class-->
    </div>
    <div class="form-group">
            {{Form::label('body','Body')}}
            {{Form::textarea('body','',['id'=>'article-ckeditor','class'=>'form-control','placeholder'=>'Body Text'])}}<!--it's going to be a create form so, no need input, next to 'title',''/to attribute, use class-->
    </div>
    <div class="form-group"><!--file field 'cover_image'-->
        {{Form::file('cover_image')}}
    </div>
    {{Form::submit('Submit',['class'=>'btn btn-primary'])}}
    {!! Form::close() !!}
@endsection