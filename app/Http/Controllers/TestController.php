<?php

namespace App\Http\Controllers;
use Storage;

use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Str;

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

    //добавить новый проект пустой
    public function addNewProject()
    {
        $project = new Project;

        $title = "New Project " . rand(100,999);
        $project->project_title = $title;
        $project->project_url = "http://192.168.0.105:8000/";
        $project->is_home = 0;
        $project->order = Project::where('is_home', 0)->max('order') + 1;
        $project->slug = Str::slug($title);
        $project->save();

        return response()->json(null, 400);
    }
}
