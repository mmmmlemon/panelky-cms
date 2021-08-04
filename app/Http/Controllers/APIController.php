<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Settings;
use App\Models\Project;
use App\Models\ProjectSlide;
use App\Models\Link;

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

        return response()->json($response, 200);
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
               array_push($response, ['slug' => $project->slug,
                                      'title' => $project->project_title]);
            }
    
            return response()->json($response, 200);
        }
        else
        { return response()->json(false, 200);}
    }

    //getFirstProjectSlug
    //получить Slug первого проекта в списке проектов
    public function getFirstProjectSlug()
    {
        $projects = Project::where('is_home', 1)->orderBy('order','desc')->get();

        if(count($projects) > 0)
        { return response()->json($projects[0]->slug, 200); }
        else
        { return response()->json(false, 200); }
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
        {   
            // получаем слайды проекта
            $projectSlides = ProjectSlide::select('id', 'media_url', 'commentary', 'visibility')->where('project_id', $project->id)->get();
     
            foreach($projectSlides as $slide)
            {
                $slide->media_url = asset($slide->media_url);
            }

            $slidesDesktop = [];
            $slidesMobile = [];

            foreach($projectSlides as $slide)
            {
                if($slide->visibility == 'desktop')
                { array_push($slidesDesktop, $slide); }
                else if ($slide->visibility == 'mobile')
                { array_push($slidesMobile, $slide); }
                else {
                    array_push($slidesDesktop, $slide);
                    array_push($slidesMobile, $slide);
                }  
            }

            $project->slides = ['desktop' => $slidesDesktop, 'mobile' => $slidesMobile];
            return response()->json($project, 200); 
        }
        //мини-превью
        else if ($type == "mini")
        {   
            return response()->json(['slug' => $project->slug, 
                                    'project_title' => $project->project_title, 
                                    'project_subtitle' => $project->project_subtitle, 
                                    'project_icon' => $project->project_icon,
                                    'is_home' => $project->is_home], 200); 
        }
        else
        { return response()->json(false, 422); }
    }

    //getFullProjectsList
    //получить полный список проектов для главной страницы со всей информацией
    public function getFullProjectList()
    {
        $homeProjects = Project::where('is_home', 1)->orderBy('order', 'desc')->get();
        $otherProjects = Project::where('is_home', 0)->orderBy('slug','asc')->get();

        //добавление параметра orientation 
        //для поочередного вывода "левых" и "правых" карточек на главной странице

        for($i = 0; $i <= count($homeProjects)-1; $i++)
        {
            if($i % 2 != 0)
            { $homeProjects[$i]->orientation = "right"; }
            else
            { $homeProjects[$i]->orientation = "left"; }
        }

        //добавление слайдов к homeProjects

        foreach($homeProjects as $project)
        {
            $projectSlides = ProjectSlide::select('id', 'media_url', 'commentary', 'visibility')->where('project_id', $project->id)->get();
            foreach($projectSlides as $slide)
            {
                $slide->media_url = asset($slide->media_url);
            }

            $slidesDesktop = [];
            $slidesMobile = [];

            foreach($projectSlides as $slide)
            {
                if($slide->visibility == 'desktop')
                { array_push($slidesDesktop, $slide); }
                else if ($slide->visibility == 'mobile')
                { array_push($slidesMobile, $slide); }
                else {
                    array_push($slidesDesktop, $slide);
                    array_push($slidesMobile, $slide);
                }  
            }

            $project->slides = ['desktop' => $slidesDesktop, 'mobile' => $slidesMobile];
        }

        //если в БД нет ни одного проекта, то возвращаем false
        if(count($homeProjects) == 0)
        { return response()->json(['home' => false, 'other' => false], 200); }
        else
        { return response()->json(['home' => $homeProjects, 'other' => $otherProjects], 200);  }
    }

    //getStockImages
    //получить плейсхолдеры картинок для проекта
    public function getStockImages()
    {
          $response = [
            'icon' => asset('/storage/stock/stock_icon.png'),
            'image' => asset('/storage/stock/stock_image.png')
        ];

        return response()->json($response, 200);
    }

    //getAllProjects
    //получить все проекты
    public function getAllProjects()
    {
        $homeProjects = Project::where('is_home', 1)->orderBy('order','desc')->get();
        $otherProjects = Project::where('is_home', 0)->orderBy('order', 'desc')->get();

        $response = ['home' => $homeProjects, 'other' => $otherProjects];

        return response()->json($response, 200);
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

    //getLinks
    //получить ссылки
    public function getLinks()
    {
        $links = Link::select('link_title','link_url', 'slug')->orderBy('order', 'desc')->get();

        if(count($links) > 0)
        { return response()->json($links, 200); }
        else
        { return response()->json(false, 200); }

    }

    //getEmail
    //получить E-mail
    public function getEmail()
    {
        $email = Settings::get()[0]->contact_email;

        if($email == '')
        { $email = null; }

        return response()->json(['email'=>$email], 200);
    }

    //getBasicSettings
    //получить базовые настройки сайта
    public function getBasicSettings()
    {
        $settings = Settings::get()[0];
        $publicAccessMessage = '';
        if($settings->public_access_message != null)
        { $publicAccessMessage = $settings->public_access_message; }
        $basicSettings = ['site_title' => $settings->site_title, 
                          'public_access' => $settings->public_access,
                           'public_access_message' => $publicAccessMessage];

        return response()->json($basicSettings, 200);

    }

    //getAccessStatus
    //получить статус доступа к сайту
    public function getAccessStatus()
    {
        $settings = Settings::get()[0];
        
        return response()->json($settings->public_access, 200);
    }

    //getPublicAccessMessage
    //получить сообщение о закрытии сайта
    public function getPublicAccessMessage()
    {
        $settings = Settings::get()[0];
        
        return response()->json($settings->public_access_message, 200);
    }

    //getHomeSettings
    //настройки главной страницы
    public function getHomeSettings()
    {
        $settings = Settings::get()[0];

        $homeSettings = [
            'side_nav' => $settings->side_nav,
            'about' => $settings->about,
            'site_owner' => $settings->site_owner,
            'projects' => $settings->projects,
            'footer' => $settings->footer,
        ];

        return response()->json($homeSettings, 200);
    }

    //getBgColors
    //получить цвета фона
    public function getBgColors()
    {
        $settings = Settings::get()[0];

        $bgSettings = [
            'bg_first_color' => $settings->bg_first_color,
            'bg_second_color' => $settings->bg_second_color,
        ];

        return response()->json($bgSettings, 200);
    }


    //getAboutSiteText
    //получить текст из раздела "О сайте"
    public function getAboutSiteText()
    {
        $settings = Settings::get()[0];

        return response()->json($settings->about_site_text, 200);
    }
}


