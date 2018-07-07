<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Post;
use App\Category;
use Auth;

class PostController extends Controller
{
    public function getPosts($id)
    {
        $posts = Post::where('user_id', $id)->orderBy('id', 'desc')->paginate(6);

        return response(json_encode($posts));
    }

    public function getPost($id)
    {
        $post = Post::find($id);

        return response(json_encode($post));
    }

    public function create(Request $request)
    {
    	$request->validate([
    		'title' => 'required|max:20',
    		'description' => 'required|max:100',
    		'category' => 'required'
    	]);

        $user = Auth::user();
    	$post = new Post;
    	$post->title = $request->get('title');
    	$post->description = $request->get('description');
        $post->category = $request->get('category');

        $exploded = explode(',', $request->get('postphotoURL'));
        $decoded = base64_decode($exploded[1]);
        $extension = str_contains($exploded[0], 'jpeg') ? 'jpg' : 'png';
        $filename = str_random().'.'.$extension;
        $path = public_path().'/images/uploads/postphoto/'.$filename;
        file_put_contents($path, $decoded);
        $post->postphoto = $filename;

        $user->posts()->save($post);

    	return response(json_encode($post));
    }
}
