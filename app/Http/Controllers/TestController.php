<?php

namespace App\Http\Controllers;
use Storage;

use Illuminate\Http\Request;

//TestController
//контроллер для тестирования функционала сайта
class TestController extends Controller
{
    //saveJson
    public function saveJson()
    {
        $json = [];

        for($i = 0; $i < 50; $i++)
        {
            $randomNum = rand(0,100);

            array_push($json, $randomNum);
        }
    
        try {
            Storage::disk('local')->put('saveJson.json', json_encode($json));
        } catch (Throwable $e) {
            report($e);
    
            return "not success";
        }

        return "success";
    }

    //readJson
    public function readJson()
    {
        try { 
            $json = Storage::disk('local')->get('saveJson.json');
        } catch (Throwable $e) {
            return "not success";
        }

        dd(json_decode($json));
    }

    //submit form
    public function submitForm(Request $request){
        
        $this->validate($request, [
            'name' => 'required|string',
            'occupation' => 'required|string',
            'aboutMe' => 'required|string',
            'footerText' => 'required|string'
        ]);

        return response()->json(null, 200);

    }
}
