<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;

class UserController extends Controller
{
	public function getUser($id)
	{
		$user = User::find($id);

		return $user;
	}

    public function update(Request $request)
    {
    	$request->validate([
    		'name' => 'max: 20',
    		'email' => 'email',
    		'tagline' => 'max: 50'
    	]);

    	$user = Auth::user();
    	$user->name = $request->get('name');
    	$user->email = $request->get('email');
    	$user->tagline = $request->get('tagline');

    	if ($request->get('profilepicURL')) {
    		$exploded = explode(',', $request->get('profilepicURL'));
	    	$decoded = base64_decode($exploded[1]);
	    	$extension = str_contains($exploded[0], 'jpeg') ? 'jpg' : 'png';
	    	$filename = str_random().'.'.$extension;
	    	$path = public_path().'/images/uploads/profilepic/'.$filename;
	    	file_put_contents($path, $decoded);
	    	$user->profilepic = $filename;
    	}
	    
    	$user->save();

    	return response(json_encode($user));
    }
}
