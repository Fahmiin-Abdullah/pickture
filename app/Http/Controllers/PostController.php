<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Post;
use App\Category;
use App\Like;
use App\Favourite;
use Auth;

class PostController extends Controller
{
    public function getPosts($id)
    {
        $posts = Post::withCount('likes')->withCount('favourites')->where('user_id', $id)->orderBy('id', 'desc')->paginate(6);

        return response(json_encode($posts));
    }

    public function getPost($id)
    {
        $post = Post::with('user')->find($id);

        return response(json_encode($post));
    }

    public function discover()
    {
        $posts = Post::with('user')->withCount('likes')->withCount('favourites')->inRandomOrder()->paginate(24);

        return response(json_encode($posts));
    }

    public function search(Request $request, $query = null)
    {
         $posts = Post::with('user')->withCount('likes')->withCount('favourites')->where('title', 'like', '%'.$query.'%')->paginate(6);

         return response(json_encode($posts));
    }

    public function create(Request $request)
    {
    	$request->validate([
    		'title' => 'required|max:50',
    		'description' => 'required|max:200',
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

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|max:50',
            'description' => 'required|max:200',
            'category' => 'required'
        ]);

        $user = Auth::user();
        $post = Post::find($id);
        $post->title = $request->get('title');
        $post->description = $request->get('description');
        $post->category = $request->get('category');

        $user->posts()->save($post);

        return response(json_encode($post));
    }

    public function delete($id)
    {
        $post = Post::find($id);
        $likes = Like::find('post_id', $id)->get();
        $favourites = Favourite::find('post_id', $id)->get();

        foreach ($likes as $like) {
            $like->delete();
        }

        foreach ($favourites as $favourite) {
            $favourite->delete();
        }

        $post->delete();

        return response('success');
    }
}
