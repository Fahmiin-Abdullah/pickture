<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Post;
use App\Like;
use App\Favourite;
use Auth;

class ActionsController extends Controller
{
    public function like($id)
    {
        $user = Auth::user();
        $post = Post::find($id);
        $is_liked = Like::where('user_id', $user->id)->where('post_id', $id)->first();
        if ($is_liked) {
            $is_liked->delete();

            return response(0);
        } else {
            $like = new Like;
            $like->user_id = $user->id;
            $post->likes()->save($like);

            return response(1);
        }
    }

    public function isLiked($id)
    {
        $user = Auth::user();
        $is_liked = Like::where('user_id', $user->id)->where('post_id', $id)->first();
        $res = $is_liked == null ? 0 : 1;

        return response($res);
    }

     public function fav($id)
    {
        $user = Auth::user();
        $post = Post::find($id);
        $is_faved = Favourite::where('user_id', $user->id)->where('post_id', $id)->first();
        if ($is_faved) {
            $is_faved->delete();

            return response(0);
        } else {
            $fav = new Favourite;
            $fav->user_id = $user->id;
            $post->favourites()->save($fav);

            return response(1);
        }
    }

    public function isFaved($id)
    {
        $user = Auth::user();
        $is_faved = Favourite::where('user_id', $user->id)->where('post_id', $id)->first();
        $res = $is_faved == null ? 0 : 1;
        
        return response($res);
    }
}
