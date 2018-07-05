<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Post;
use Image;

class PostController extends Controller
{
    public function create(Request $request)
    {
    	$request->validate([
    		'title' => 'required|max:20',
    		'description' => 'required|max:100',
    		'category' => 'required',
    		'postphoto' => 'required|file'
    	]);

    	$post = new Post;
    	$post->title = $request->get('title');
    	$post->description = $request->get('description');
    	$post->category = $request->get('category');

    	if ($request->hasFile('postphoto')) {
    		$postphoto = $request->file('postphoto');
    		$filename = time().'.'.$postphoto->getClientOriginalExtension();
    		Image::make($postphoto)->save(public_path('/uploads/postphoto/'.$filename));
    	}

    	$post->postphoto = $filename;
    	$post->save();

    	return response(json_encode($post));
    }
}
