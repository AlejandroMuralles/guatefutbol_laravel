<?php

namespace App\Http\Controllers;

use Controller, Redirect, Input, Auth, View, Socialize;
use Facebook\Facebook as Facebook;

class FacebookController extends BaseController {

	public function facebook_redirect() {
		return \Socialize::with('facebook')->scopes(['manage_pages','publish_pages'])->redirect();
		//dd('hola facebook redirect');
		//return Socialize::with('facebook')->redirect();
	}

  	public function facebook() {
  		$fanPageId = env('FB_FANPAGE_ID');
  		try{
            //dd($fanPageId);
    		$facebookUser = Socialize::driver('facebook')->user();
            //dd($facebookUser);
            $loginUser = Auth::user(); //dd($facebookUser->user());
            $loginUser->facebook_user = $facebookUser->user['name'];
            //dd($facebookUser);
            $loginUser->save();
    	}
    	catch (\Exception $e) {
            dd($e);
    		\Session::flash('error', 'No se autorizó el registro vía facebook');
            $loginUser = Auth::user();
            $loginUser->facebook_user = null;
            $loginUser->save();
    		return Redirect::back();
    	}

	    $config = array(
 			'app_id' => env('FB_API_KEY'),
         	'app_secret' => env('FB_API_SECRET'),
        	'allowSignedRequest' => false
    	);

    	$facebook = new Facebook($config);
    	if (isset($facebookUser->id)) {
        	try {
            	$likes = $facebook->get('/'. $fanPageId . '?fields=access_token', $facebookUser->token);
              //dd($likes);
            	$decodedBody = $likes->getDecodedBody();
            	if (!empty($decodedBody['access_token'])) // if user has liked the page then $likes['data'] wont be empty otherwise it will be empty
            	{
            		\Session::put('access_token', $decodedBody['access_token']);
            		\Session::flash('success','Se conectó correctamente a Facebook');
            		return Redirect::back();
            	}
           		else {
           			\Session::flash('error','No se pudo conectar con facebook.');
            		return Redirect::back();
                }
            }
            catch(\Exception $ex)
            {
            	\Session::flash('error', 'ERROR DE FACEBOOK: ' . $ex->getMessage());
            	return Redirect::back();
            }
        }
  	}
}