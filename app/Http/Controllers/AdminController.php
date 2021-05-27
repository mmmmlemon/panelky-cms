<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
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
            'name' => 'required|string|max:255',
            'occupation' => 'required|string|max:255',
            'aboutMe' => 'required|string',
            'bottomText' => 'required|string|max:255'
        ]);

        $settings = Settings::firstOrFail();

        $settings->site_owner_name = $request->name;
        $settings->site_owner_occupation = $request->occupation;
        $settings->site_owner_about = $request->aboutMe;
        $settings->site_owner_bottom = $request->bottomText;

        $settings->save();

        return response()->json(true, 200);
    }

    //saveProjectBasic
    //редактирование, сохранить общую информацию о проекте
    public function saveProjectBasic(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
            'project_title' => 'required|string|max:255',
            'project_subtitle' => 'string|nullable|max:255',
            'project_desc' => 'string|nullable',
            'project_bottomText' => 'string|nullable|max:255',
            'project_url' => 'url|max:500'
        ]);

        $project = Project::find($request->id);

        $project->project_title = $request->project_title;
        $project->project_subtitle = $request->project_subtitle;
        $project->project_desc = $request->project_desc;
        $project->project_bottomText = $request->project_bottomText;
        $project->project_url = $request->project_url;

        $project->save();

        return response()->json(true, 200);
    }

    //saveProjectImages
    //редактирование, сохранить изображения для проекта
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
        

        $project = Project::find($request->id);
        if($request->hasFile('projectIcon'))
        { 
            $fileIcon = $request->projectIcon; 
            $filename = md5(time().rand(0,9)).".".$fileIcon->getClientOriginalExtension();
            $path = "public/projectsImages/".$filename;
            Storage::put($path, file_get_contents($fileIcon));

        
            //удаление старой картинки перед сохранением ссылки на новую
            Storage::disk('public')->delete(str_replace('storage/','',$project->project_icon));
            $project->project_icon = "storage/projectsImages/".$filename;
            $project->save();
        }

        if($request->hasFile('projectImage'))
        { 
            $fileImage = $request->projectImage; 
            $filename = md5(time().rand(0,9)).".".$fileImage->getClientOriginalExtension();
            $path = "public/projectsImages/".$filename;
            Storage::put($path, file_get_contents($fileImage));

            //удаление старой картинки перед сохранением ссылки на новую
            Storage::disk('public')->delete(str_replace('storage/', '', $project->project_image));
            $project->project_image = "storage/projectsImages/".$filename;
            $project->save();
        }

        if($fileIcon == null && $fileImage == null)
        { return response()->json(null, 422); }

        $response = ['icon' => asset($project->project_icon), 'image' => asset($project->project_image)];

        return response()->json($response, 200);
    }   

    //deleteImageFromProject
    //редактирование, удалить иконку\изображение из проекта
    public function deleteImageFromProject(Request $request)
    {
        $project = Project::find($request->id);

        if($request->type == 'icon')
        {
            Storage::disk('public')->delete(str_replace('storage/', '', $project->project_icon));
            $project->project_icon = null;
        }
        else if($request->type == 'image')
        {
            Storage::disk('public')->delete(str_replace('storage/', '', $project->project_image));
            $project->project_image = null;  
        }
        else
        { return response()->json(null, 422); }
    
        $project->save();   

        return response()->json(true, 200);
    }

    //addNewProject
    //добавить новый проект в БД
    public function addNewProject(Request $request)
    {
        $this->validate($request, [
            'project_title' => 'required|string|max:255',
            'project_subtitle' => 'string|max:255',
            'project_desc' => 'string',
            'project_bottomText' => 'string|max:255',
            'project_url' => 'url|max:500|required',
            'icon' => 'mimes:jpeg,jpg,png|nullable',
            'image' => 'mimes:jpeg,jpg,png|nullable',
        ]);

        $project = new Project;

        $project->project_title = $request->project_title;
        $project->project_subtitle = $request->project_subtitle;
        $project->project_desc = $request->project_desc;
        $project->project_bottomText = $request->project_bottomText;
        $project->project_url = $request->project_url;
        $project->is_home = 0;
        //получаем максимальное значение order у проектов не добавленных в Главные и делаем +1
        $project->order = Project::where('is_home', 0)->max('order') + 1;

        //сгенерировать slug
        $slug = Str::slug($request->project_title);
        //если проект с таким slug'ом уже есть, то добавляем случайные символы в конец
        if(count(Project::where('slug', $slug)->get()) > 0)
        {   
            $str = base_convert(rand(100000,999999), 10, 36);
            $slug .= "-" . strval($str);
        }

        $project->slug = $slug;
        
        //перемещаем файлы картинок из temp в projectsImages
        if(File::exists(storage_path("app/public/temp/".$request->randomFolderName)))
        {
            //иконка и скриншот
            $tempFiles = File::files(storage_path("app/public/temp/".$request->randomFolderName));
            
            if($request->project_icon != null)
            {
                $filename = md5(time().rand(0,9)).".png";
                $path = "public/projectsImages/".$filename;
                Storage::put($path, file_get_contents(storage_path('app/public/temp/'.$request->randomFolderName."/".$request->project_icon)));
                $project->project_icon = "storage/projectsImages/".$filename;
            }

            if($request->project_image != null)
            {
                $filename = md5(time().rand(0,9)).".png";
                $path = "public/projectsImages/".$filename;
                Storage::put($path, file_get_contents(storage_path('app/public/temp/'.$request->randomFolderName."/".$request->project_image)));
                $project->project_image = "storage/projectsImages/".$filename;
            }
        }

        $project->save();

        return response()->json(true, 200); 
    }

    //saveImageToTemp
    //сохранить изображение в temp
    public function saveImageToTemp(Request $request)
    {   
        $path = "temp/".$request->randomFolderName."/";
        $check = File::exists(storage_path($path));

        if($check == false)
        { Storage::disk('public')->makeDirectory($path); }

        if($request->hasFile('file'))
        {
            $filename = $request->filename;
            Storage::put("/public/".$path.$filename, file_get_contents($request->file));
            return response()->json(asset("storage/".$path.$filename), 200);
        }
        else
        { return response()-json(null, 500); }
    }

    //removeFolderFromTemp
    //удалить временную папку из temp
    public function removeFolderFromTemp(Request $request)
    {
        Storage::disk('public')->deleteDirectory('/temp/'.$request->randomFolderName);
        return response()->json(true, 200);
    }

    //deleteProject
    //удалить проект
    public function deleteProject(Request $request)
    {
        $project = Project::where('slug', $request->slug)->get()[0];
        $id = $project->id;
        Project::find($id)->delete();
        return response()->json(true, 200);
    }
}
