<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Settings;
use App\Models\Project;

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

    //getProjectsList
    //получить список проектов, Админка
    public function getProjectsList()
    {
        $projects = Project::all();

        $response = [];

        foreach($projects as $project)
        {
           array_push($response, ['id' => $project->id,'title' => $project->project_title]);
        }

        return response()->json($response);
    }

    //getFirstProjectId
    //получить id первого проекта в списке, Админка
    public function getFirstProjectId()
    {
        $firstProject = Project::firstOrFail()->id;

        return response()->json($firstProject);
    }

    //getProject
    //получить проект для превью, Админка
    public function getProject($id)
    {
        $project = Project::findOrFail($id);
        
        return response()->json($project);
    }

    //getFullProjectsList
    //получить полный список проектов для главной страницы
    public function getFullProjectList()
    {
        $projects = Project::all();

        if(count($projects) == 0)
        { return response()->json(false); }
        else
        { return response()->json($projects);  }

    }

}
