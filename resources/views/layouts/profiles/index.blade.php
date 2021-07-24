@extends('layouts.app')

@section('content')
<div class="container">
   <div class="row">
       <div class="col-3 p-5">
        <img src="{{$user->profile->ProfileImage()}}"  class="rounded-circle w-100"/> 
       </div>
       <div class="col-9 pt-5">
           <div class="d-flex justify-content-between align-items-baseline"> <h1>{{$user->username}}<h1> 
            
           <follow-button user-id="{{ $user->id }}" follows="{{ $follows }}"></follow-button>

           
           </div>

           <div >
            @can('update', $user->profile)
                    <a href="/p/create">Add New Post</a>
            @endcan
           </div>
           @can('update',$user->profile)
              <a href="/profile/{{ $user->id }}/edit"> Edit Profile</a>
            @endcan 


           <div class="d-flex"> 
               <div class="pr-5"> <strong >{{ $postsCount }} </strong> posts</div>
               <div class="pr-5"> <strong >{{ $followersCount }} </strong> followers</div>
               <div class="pr-5"> <strong >{{ $followingsCount }} </strong> following</div>
           </div>
           <div class="pt-4">{{ $user->profile->title}}</div>
           <div class="pt-4">{{ $user->profile->description }}</div>
           <div> <a href="#">{{$user->profile->url }}</a></div>
       </div>
   </div>
   <div class="row pt-5">
       @foreach($user->posts as $post)
       <div class="col-4 pb-5">
           <a href="/p/{{$post->id}}">
             <img src=/storage/{{ $post->image }}  class="w-100"/> 
           </a>
       </div>
       @endforeach
       
     
   </div>
</div>
@endsection
