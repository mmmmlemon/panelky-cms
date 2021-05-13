<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
    
}
