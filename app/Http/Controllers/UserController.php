<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Social;

class UserController extends Controller
{
	public function getUser($id)
	{
		$user = User::find($id);

		return $user;
	}

    public function getSocial($id)
    {
        $socials = Social::where('user_id', $id)->get();

        return response(json_encode($socials));
    }

    public function update(Request $request, $id)
    {
    	$request->validate([
    		'name' => 'max: 20',
    		'email' => 'email',
    		'tagline' => 'max: 50'
    	]);

    	$user = User::find($id);
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

        foreach($request->get('socials') as $fab) {
            $has_social = Social::where('user_id', $id)->where('social', $fab['social'])->first();
            if ($fab['link']) {
                if ($has_social) {
                    $has_social->link = $fab['link'];
                    $has_social->save();
                } else {
                    $social = new Social;
                    $social->user_id = $id;
                    $social->social = $fab['social'];
                    $social->link = $fab['link'];
                    $social->save();
                }
            } else {
                if ($has_social != null) {
                    $has_social->delete();
                }
            }
        }

    	$user->save();

    	return response($user);
    }
}
