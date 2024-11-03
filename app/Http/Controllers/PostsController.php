<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Post;
use DB;//to use sql statement

class PostsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {//if want to block some function from guest
        $this->middleware('auth',['except'=>['index','show']]);
    }

    /**THIS IS ORIGINAL POSTSCONTROLLER
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //fetch all the data 
        //$posts = Post::all();
        //return Post::where('title','Post Two')->get();
        //$posts = DB::select('Select *from posts');//this is sql statement
        //below this to display only 1 post
        //$posts = Post::orderBy('id','desc')->take(1)->get();//follow the file name in Providers
        //$posts = Post::orderBy('title','desc')->get();//follow the file name in Providers

        $posts = Post::orderBy('created_at','desc')->paginate(3);//follow the file name in Providers
        return view('posts.index')->with('posts',$posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //take request and id
        $this->validate($request,[
            'title'=>'required',
            'body'=> 'required',
            'cover_image'=>'image|nullable|max:1999'
        ]);
        //handle file upload
        if($request->hasFile('cover_image')){
        //how to ge a file name with extension
        $fileNameWithExt = $request->file('cover_image')->getClientOriginalName();
        //get just filename
        $filename = pathinfo($fileNameWithExt,PATHINFO_FILENAME);
        //get just ext
        $extension = $request->file('cover_image')->getClientOriginalExtension();
       //file name to store
       $fileNameToStore = $filename.'_'.time().'.'.$extension;//not to overide any file,means ada same files
        //upload image
        $path = $request->file('cover_image')->storeAs('public/my_images',$fileNameToStore);//my_images is a folder that will be created 
        } else{
                $fileNameToStore = 'noimage.jpg';
            }
        //Create post
        $post = new Post;
        //to add field, get whatever sent to the form
        $post->title=$request->input('title');
        $post->body=$request->input('body');
        $post->user_id = auth()->user()->id;
        $post->cover_image =$fileNameToStore;
        $post->save();
        //success message from success.blade.php
        return redirect('/posts')->with('success','Post Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //going to get the id from the url(eloquent)
        $post = Post::find($id);
        return view('posts.show')->with('post',$post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);
        //check for correct user
        if(auth()->user()->id !==$post->user_id){
            return redirect('/posts')->with('error','Unauthorize Page');
        }return view('posts.edit')->with('post',$post);

        
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //take request and id
        $this->validate($request,[
            'title'=>'required',
            'body'=> 'required'
        ]);

        if($request->hasFile('cover_image')){
            //how to ge a file name with extension
            $fileNameWithExt = $request->file('cover_image')->getClientOriginalName();
            //get just filename
            $filename = pathinfo($fileNameWithExt,PATHINFO_FILENAME);
            //get just ext
            $extension = $request->file('cover_image')->getClientOriginalExtension();
           //file name to store
           $fileNameToStore = $filename.'_'.time().'.'.$extension;//not to overide any file,means ada same files
            //upload image
            $path = $request->file('cover_image')->storeAs('public/my_images',$fileNameToStore);//my_images is a folder that will be created 
            }
        //Find post
        $post = Post::find($id);
        //to add field, get whatever sent to the form
        $post->title=$request->input('title');
        $post->body=$request->input('body');
        //if user really upload a new image
        if($request->hasFile('cover_image'))
        {
            $post->cover_image=$fileNameToStore;
        }
        $post->save();
        
        
        //success message from success.blade.php
        return redirect('/posts')->with('success','Post Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);

        //check for correct user
        if(auth()->user()->id !==$post->user_id){
            return redirect('/posts')->with('error','Unauthorize Page');
        }
        if($post->cover_image !='noimage.jpg')
        {
            //delete image
            Storage::delete('public/my_images/'.$post->cover_image);
        }
        $post->delete();
        return redirect('/posts')->with('success','Post Removed');
    }
}