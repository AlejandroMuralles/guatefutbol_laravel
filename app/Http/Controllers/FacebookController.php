<?php

namespace App\Http\Controllers;

use Controller, Redirect, Input, Auth, View, Socialize;
use Facebook\Facebook as Facebook;

class FacebookController extends BaseController {

	public function facebook_redirect() 
	{
		$rutaRedirect = request()->get('ruta_redirect');
		session()->put('ruta_redirect',$rutaRedirect);
		return \Socialize::with('facebook')->scopes(['pages_manage_posts'])->redirect();
	}

  	public function facebook() {
  		$fanPageId = env('FB_FANPAGE_ID');
  		try{
    		$facebookUser = Socialize::driver('facebook')->user();
            $loginUser = Auth::user(); //dd($facebookUser->user());
            $loginUser->facebook_user = $facebookUser->user['name'];
            $loginUser->save();
    	}
    	catch (\Exception $e) {
    		session()->flash('error', 'No se autorizó el registro vía facebook');
            $loginUser = Auth::user();
            $loginUser->facebook_user = null;
            $loginUser->save();
    		return redirect()->to(session()->get('ruta_redirect'));
    	}

	    $config = array(
 			'app_id' => env('FB_API_KEY'),
         	'app_secret' => env('FB_API_SECRET'),
			'allowSignedRequest' => false,
			'default_graph_version' => env('FB_GRAPH_VERSION'),
    	);

    	$facebook = new Facebook($config);
		if (!is_null($facebookUser)) 
		{
        	try {
            	$likes = $facebook->get('/'. $fanPageId . '?fields=access_token', $facebookUser->token);
            	$decodedBody = $likes->getDecodedBody();
            	if (!empty($decodedBody['access_token'])) // if user has liked the page then $likes['data'] wont be empty otherwise it will be empty
            	{
            		session()->put('access_token', $decodedBody['access_token']);
            		session()->flash('success','Se conectó correctamente a Facebook');
            		return redirect()->to(session()->get('ruta_redirect'));
            	}
           		else {
           			session()->flash('error','No se pudo conectar con facebook.');
					   return redirect()->to(session()->get('ruta_redirect'));
                }
            }
            catch(\Exception $ex)
            {
            	session()->flash('error', 'ERROR DE FACEBOOK: ' . $ex->getMessage());
            	return redirect()->to(session()->get('ruta_redirect'));
            }
        }
  	}
}