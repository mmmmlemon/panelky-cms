<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Settings;
use App\Models\Project;

//APIController
//функции API, получение информации из БД
class APIController extends Controller
{
    //ВЛАДЕЛЕЦ САЙТА
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

    //ПРОЕКТЫ
    //getProjectsList
    //получить список проектов, Админка
    public function getProjectsList()
    {
        //получаем список проектов отсортированный по полю order
        $projects = Project::where('is_home',1)->orderBy('order', 'desc')->get();

        if(count($projects) > 0)
        {
            $response = [];

            //фильтруем результат, нам нужны только поля id и title
            foreach($projects as $project)
            {
               array_push($response, ['slug' => $project->slug,'title' => $project->project_title]);
            }
    
            return response()->json($response);
        }
        else
        { return response()->json(false);}
    }

    //getFirstProjectSlug
    //получить Slug первого проекта в списке проектов
    public function getFirstProjectSlug()
    {
        $projects = Project::where('is_home', 1)->orderBy('order','desc')->get();

        if(count($projects) > 0)
        { return response()->json($projects[0]->slug); }
        else
        { return response()->json(false); }
    }

    //getProject
    //получить проект для превью (мини-превью или полное превью)
    public function getProject($slug, $type)
    {
        $project = Project::where('slug', $slug)->get()[0];

        if($project->project_icon != null)
        $project->project_icon = asset($project->project_icon);
        if($project->project_image != null)
        $project->project_image = asset($project->project_image);
        
        //полное превью
        if($type == "full")
        { return response()->json($project); }
        //мини-превью
        else if ($type == "mini")
        {   
            return response()->json(['slug' => $project->slug, 
                                    'project_title' => $project->project_title, 
                                    'project_subtitle' => $project->project_subtitle, 
                                    'project_icon' => $project->project_icon]); 
                                }
        else
        { return response()->json(false); }
    }

    //getFullProjectsList
    //получить полный список проектов для главной страницы со всей информацией
    public function getFullProjectList()
    {
        $homeProjects = Project::where('is_home', 1)->orderBy('order', 'desc')->get();
        $otherProjects = Project::where('is_home', 0)->orderBy('slug','asc')->get();

        //если в БД нет ни одного проекта, то возвращаем false
        if(count($homeProjects) == 0)
        { return response()->json(false); }
        else
        { return response()->json(['home' => $homeProjects, 'other' => $otherProjects]);  }
    }

    //getStockImages
    //получить стоковые изображения
    public function getStockImages()
    {
          $response = [
            'icon' => asset('/storage/stock/stock_icon.png'),
            'image' => asset('/storage/stock/stock_image.png')
        ];

        return response()->json($response);
    }

    //getAllProjects
    //получить все проекты
    public function getAllProjects()
    {
        $homeProjects = Project::where('is_home', 1)->orderBy('order','desc')->get();

        $otherProjects = Project::where('is_home', 0)->orderBy('order', 'desc')->get();

        $response = ['home' => $homeProjects, 'other' => $otherProjects];

        return response()->json($response);
    }

    //setProjectStatus
    //поменять поле is_home у проекта
    public function setProjectStatus(Request $request)
    {
        $project = Project::where('slug', $request->slug)->get()[0];

        
        if($project->is_home == 0)
        {   
            $max = Project::where('is_home', 1)->max('order') + 1;
            $project->is_home = 1; 
            $project->order = $max;
        }
        else
        {    
            $max = Project::where('is_home', 0)->max('order') + 1;
            $project->is_home = 0; 
            $project->order = $max;
        }

        $project->save();

        return response()->json(null, 200);
    }
}
