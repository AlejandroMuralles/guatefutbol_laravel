<?php

namespace App\App\Repositories;

use App\App\Entities\UserApp;

class UserAppRepo extends BaseRepo{

	public function getModel()
	{
		return new UserApp;
    }
    
    function getByUUID($uuid)
    {
        return UserApp::where('uuid',$uuid)->first();
    }

}