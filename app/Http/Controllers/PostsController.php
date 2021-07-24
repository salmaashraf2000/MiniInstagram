<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;

class PostsController extends Controller
{
    //to make all functions authorized (must login)
    public function __construct()
    {
       $this->middleware('auth');
    }

    public function index()
    {
        $users= auth()->user()->following()->pluck('Profiles.user_id');
        //get all posts with ids in $users
        //can use latest() instead of order by
        //$posts= Post::whereIn('user_id',$users)->orderBy('created_at','DESC')->get();
        
        //get 5 records in page
        //in the view $post->links() gets 5 posts only in each page
        //with('user') to use relation of users with post
        $posts= Post::whereIn('user_id',$users)->with('user')->latest()->paginate(5);

        return view('layouts.posts.index',compact('posts'));
    }

    public function create()
    {
        
        return view('layouts.posts.create');
    }

    public function store()
    {
       
        $data = request()->validate([
            'caption' => 'required',
            'image' => ['required', 'image'],
        ]);

        $imagePath = request('image')->store('uploads', 'public');

        $image = Image::make(public_path("storage/{$imagePath}"))->fit(1200, 1200);
        $image->save();
        
        auth()->user()->posts()->create([
            'caption' => $data['caption'],
            'image' => $imagePath,
        ]);

        return redirect('/profile/' . auth()->user()->id);
    }
    
    //\App\Post $post to fetch all data of post
   
    public function show(\App\Models\Post $post)
    {
       //compact to match the fields 'post'=$post
       return view('layouts.posts.show',compact('post'));
    }
}
