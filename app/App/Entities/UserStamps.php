<?php

namespace App\App\Entities;

use Carbon\Carbon;

trait UserStamps
{

	protected static function boot()
    {
    	parent::boot();

        static::creating(function ($model) {
            $user = \Auth::user();
            if($user){
                $username = $user->username;
            }
            else{
                $username = "admin";
            }
            $model->created_by = $username;
            $model->updated_by = $username;
        });

        static::updating(function ($model) {
            $model->updated_by = \Auth::user()->username;
        });
    }

}