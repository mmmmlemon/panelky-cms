<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use File;
use App\Models\Settings;
use App\Models\Project;

//AdminController
//функции админки
class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    //index
    //показать layout админки
    public function index() {
        
        return view('indexAdmin');
    }

    //saveSiteOwnerInfo
    //сохранить информацию о владельце сайта
    public function saveSiteOwnerInfo(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'occupation' => 'required|string',
            'aboutMe' => 'required|string',
            'bottomText' => 'required|string'
        ]);

        $settings = Settings::firstOrFail();

        $settings->site_owner_name = $request->name;
        $settings->site_owner_occupation = $request->occupation;
        $settings->site_owner_about = $request->aboutMe;
        $settings->site_owner_bottom = $request->bottomText;

        $settings->save();

        return response()->json(null, 200);
    }

    //saveProjectBasic
    //сохранить общую информацию о проекте
    public function saveProjectBasic(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
            'project_title' => 'required|string',
            'project_subtitle' => 'string',
            'project_desc' => 'string',
            'project_bottomText' => 'string',
            'project_url' => 'required|url'
        ]);

        $project = Project::find($request->id);

        $project->project_title = $request->project_title;
        $project->project_subtitle = $request->project_subtitle;
        $project->project_desc = $request->project_desc;
        $project->project_bottomText = $request->project_bottomText;
        $project->project_url = $request->project_url;

        $project->save();

        return response()->json(null, 200);
    }

    //saveProjectImages
    //сохранить изображения для проекта
    public function saveProjectImages(Request $request)
    {
        $this->validate($request, [
            'projectIcon' => 'mimes:jpeg,jpg,png|nullable',
            'projectImage' => 'mimes:jpeg,jpg,png|nullable'
        ]);
        
        //путь до папки с картинками проектов
        $path = "app/public/projectsImages/";

        //проверка, есть ли папка projectsImages
        $check = File::exists(storage_path($path));
        
        //если нет, то создаём её
        if($check == false)
        { Storage::disk('public')->makeDirectory("projectsImages"); }

        $fileIcon = null;
        $fileImage = null;
   
        if($request->hasFile('projectIcon'))
        { 
            $fileIcon = $request->projectIcon; 
            $filename = md5(time()).".".$fileIcon->getClientOriginalExtension();
            $path = "public/projectsImages/".$filename;
            Storage::put($path, file_get_contents($fileIcon));
            $project = Project::find($request->id);
            $project->project_icon = "storage/projectsImages/".$filename;
            $project->save();
        }

        if($request->hasFile('projectImage'))
        { 
            $fileImage = $request->projectImage; 
            $filename = md5(time()).".".$fileImage->getClientOriginalExtension();
            $path = "public/projectsImages/".$filename;
            Storage::put($path, file_get_contents($fileImage));
            $project = Project::find($request->id);
            $project->project_image = "storage/projectsImages/".$filename;
            $project->save();
        }

        if($fileIcon == null && $fileImage == null)
        { return response()->json(null, 422); }

        return response()->json(null, 200);
    }
    
}
