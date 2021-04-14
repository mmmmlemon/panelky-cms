<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Settings;

//APIController
//функции API, получение информации из БД
class APIController extends Controller
{
    //getSiteOwnerInfo
    //получить информацию о владельце сайта
    public function getSiteOwnerInfo()
    {   
        $settings = Settings::firstOrFail();

        $response = [
            'name' => $settings->site_owner_name,
            'occupation' => $settings->site_owner_occupation,
            'aboutMe' => $settings->site_owner_about,
            'bottomText' => $settings->site_owner_bottom
        ];

        return response()->json($response);
    }

}
