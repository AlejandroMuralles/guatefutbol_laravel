<?php

namespace App\App\Repositories;

use App\App\Entities\Version;

class VersionRepo extends BaseRepo{

	public function getModel()
	{
		return new Version;
	}

    public function getVersion()
    {
        return Version::find(1);
    }

}