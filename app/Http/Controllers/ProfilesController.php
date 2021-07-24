<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\User;
use Intervention\Image\ImageManagerStatic as Image;

class ProfilesController extends Controller
{
    // first 2 function introduce different methods for getting user's details

    public function index($user)
    {
      
        $user=User::findOrFAil($user);
        $follows = (auth()->user()) ? auth()->user()->following->contains($user->id) : false;

        $postsCount=Cache::remember(
            'count.posts.'.$user->id,
             now()->addSeconds(30),
            function() use ($user){
            return $user->posts->count();
        });

        $followersCount=Cache::remember(
            'count.followers.'.$user->id,
             now()->addSeconds(30),
            function() use ($user){
            return $user->profile->followers->count();
        });

        $followingsCount=Cache::remember(
            'count.following.'.$user->id,
             now()->addSeconds(30),
            function() use ($user){
            return $user->following->count();
        });

        return view('layouts.profiles.index',['user'=> $user,'follows'=>$follows,'postsCount'=>$postsCount,'followersCount'=>$followersCount,'followingsCount'=>$followingsCount]);
    }

    public function edit(User $user)
    { 
        //allow only the owner of the profile to update
        $this->authorize('update', $user->profile);
        return view('layouts.profiles.edit',compact('user'));
    }


    
    public function update(User $user)
    { 

        $this->authorize('update', $user->profile);

        $data=request()->validate([
            'title'=>'required',
            'description'=>'required',
            'url'=>'url',
            'image'=>''
        ]);

        $imagePath='';
        if(request('image'))
        {
            $imagePath = request('image')->store('profile', 'public');

            $image = Image::make(public_path("storage/{$imagePath}"))->fit(1000, 1000);
            $IMAGE=[ 'image'=>$imagePath];
            $image->save();
        }

        auth()->user()->profile->update(array_merge(
            $data,
            $IMAGE ?? []
        ));

        return redirect('/profile/' . auth()->user()->id);
    }
      
   

}
