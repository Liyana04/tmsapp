<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    //public can call from outside of the class
    public function index()
    {
        $title='Welcome To Tailor Management System';//passing a single value
        //return view('pages.index',compact('title'));//method 1)adding 2nd parameter
        return view('pages.index')->with('title',$title);//method2//adding ->with $title(to call a variable inside of the view)
        //return 'INDEX';
        //return view('pages.index');
    }

    public function about()
    {
        $title='About Us';
        return view('pages.about')->with('title',$title);
        //return view('pages.about');
    }

    public function services()
    {//multiple value
        $data=array(
            'title'=>'Services',
            'services'=>['Ordering','Measuring','Fashion']
        );
        return view('pages.services')->with($data);
        //return view('pages.services');
    }
}
