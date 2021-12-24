<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use File;
use App\Models\Settings;
use App\Models\Project;
use App\Models\Order;
use App\Models\ProjectSlide;
use App\Models\Contact;
use App\Models\SocialMediaLibrary;
use App\Models\Link;
use Image;

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
        
        $site_title = Settings::get()[0]->site_title . " - Панель управления";
        return view('indexAdmin', compact('site_title'));
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
        
        $response = [];

        $project = Project::find($request->id);
        if($request->hasFile('projectIcon'))
        { 

            if($project->project_icon != null){
                unlink(storage_path(str_replace('storage','/app/public', $project->project_icon)));
            }

            $fileIcon = $request->projectIcon; 
            $filename = md5(time().rand(0,9)).".".$fileIcon->getClientOriginalExtension();
            $path = "app/public/projectsImages/".$filename;
            $img = Image::make(file_get_contents($fileIcon))->widen(100);
            $img->save(storage_path($path), 100);
            // Storage::put($path, file_get_contents($fileIcon));

            //удаление старой картинки перед сохранением ссылки на новую
            Storage::disk('public')->delete(str_replace('storage/','',$project->project_icon));
            $project->project_icon = "storage/projectsImages/".$filename;
            $project->save();

            $response['icon'] = asset($project->project_icon);
        }

        if($request->hasFile('projectImage'))
        { 
            if($project->project_image != null){
                unlink(storage_path(str_replace('storage','/app/public', $project->project_image)));
            }

            $fileImage = $request->projectImage; 
            $filename = md5(time().rand(0,9)).".".$fileImage->getClientOriginalExtension();
            $path = "app/public/projectsImages/".$filename;
            $img = Image::make(file_get_contents($fileImage))->widen(800);
            $img->save(storage_path($path), 100);
            // Storage::put($path, file_get_contents($fileImage));

            //удаление старой картинки перед сохранением ссылки на новую
            Storage::disk('public')->delete(str_replace('storage/', '', $project->project_image));
            $project->project_image = "storage/projectsImages/".$filename;
            $project->save();

            $response['image'] = asset($project->project_image);
        }

        if($fileIcon == null && $fileImage == null)
        { return response()->json(null, 422); }

        // $response = ['icon' => asset($project->project_icon), 'image' => asset($project->project_image)];

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
                $path = "app/public/projectsImages/".$filename;
                $img = Image::make(file_get_contents(storage_path('app/public/temp/'.$request->randomFolderName."/".$request->project_icon)))->widen(100);
                $img->save(storage_path($path), 100);
                $project->project_icon = "storage/projectsImages/".$filename;
            }

            if($request->project_image != null)
            {
                $filename = md5(time().rand(0,9)).".png";
                $path = "app/public/projectsImages/".$filename;
                $img = Image::make(file_get_contents(storage_path('app/public/temp/'.$request->randomFolderName."/".$request->project_image)))->widen(800);
                $img->save(storage_path($path), 100);
                // Storage::put($path, file_get_contents(storage_path('app/public/temp/'.$request->randomFolderName."/".$request->project_image)));
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
        { return response()->json(null, 200); }
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

        //удаление картинок
        if($project->project_icon != null)
        { unlink(storage_path(str_replace('storage','/app/public', $project->project_icon))); }

        if($project->project_image != null)
        { unlink(storage_path(str_replace('storage','/app/public', $project->project_image))); }

        $id = $project->id;
        Project::find($id)->delete();
        return response()->json(true, 200);
    }

    //setNewOrderForHomeProjects
    //установить новый порядок для Главных проектов
    public function setNewOrderForHomeProjects(Request $request){
        
        $newOrder = json_decode($request->newOrder);

        $count = count($newOrder) - 1;

        foreach($newOrder as $item)
        {
            $project = Project::where('slug', $item->slug)->get()[0];
            $project->order = $count;
            $project->save();
            $count--;
        }

        return response()->json($newOrder, 200);
    }

    //editLink
    //сохранить изменения для ссылок
    public function editLink(Request $request)
    {
        $this->validate($request, [
            'link_title' => 'required|string|max:50',
            'link_url' => 'url|max:500|required',
        ]);

        $link = Link::where('slug', $request->slug)->get()[0];

        $link->link_title = $request->link_title;
        $link->link_url = $request->link_url;

        $link->save();

        return response()->json(true, 200);
    }

    //addLink
    //добавить ссылку
    public function addLink(Request $request)
    {
        $this->validate($request, [
            'link_title' => 'required|string|max:50',
            'link_url' => 'url|max:500|required',
        ]);

        $link = new Link;

        $link->link_title = $request->link_title;
        $link->link_url = $request->link_url;
        $link->slug = Str::slug($request->link_title);
        $link->order = Link::orderBy('order', 'desc')->max('order') + 1;

        $link->save();

        return response()->json(true, 200);
       
    }

    //deleteLink
    //удалить ссылку
    public function deleteLink(Request $request)
    {
        $link = Link::where('slug', $request->slug)->get()[0];

        $id = $link->id;
        Link::find($id)->delete();
        return response()->json(true, 200);
    }

    //setNewOrderForLinks
    //установить новый порядок для ссылок
    public function setNewOrderForLinks(Request $request){
        
        $newOrder = json_decode($request->newOrder);

        $count = count($newOrder) - 1;

        foreach($newOrder as $item)
        {
            $link = Link::where('slug', $item->slug)->get()[0];
            $link->order = $count;
            $link->save();
            $count--;
        }

        return response()->json($newOrder, 200);
    }

    //editEmail
    //сохранить изменения в Email
    public function editEmail(Request $request)
    {
        $this->validate($request, [
            'email' => 'email|max:150|nullable',
        ]);

        $settings = Settings::get()[0];
        $settings->contact_email = $request->email;
        $settings->save();
        return response()->json(true, 200);
    }

    //saveBasicSettings
    //сохранить базовые настройки
    public function saveBasicSettings(Request $request)
    {
        $this->validate($request, [
            'site_title' => 'string|max:255|required',
            'public_access_message' => 'string|max:500|nullable'
        ]);

        $settings = Settings::get()[0];

        $settings->site_title = $request->site_title;
        $settings->public_access = $request->public_access;
        if($request->public_access_message === 'null')
        {  $settings->public_access_message = null; }
        else
        { $settings->public_access_message = $request->public_access_message; }

        $settings->save();

        return response()->json(true, 200);

    }

    //saveHomeSettings
    //сохранить настройки для главного экрана
    public function saveHomeSettings(Request $request)
    {   
        $settings = Settings::get()[0];
        
        $settings->side_nav = $request->side_nav;
        $settings->order = $request->order;
        $settings->about = $request->about;
        $settings->site_owner = $request->site_owner;
        $settings->projects = $request->projects;
        $settings->footer = $request->footer;
        $settings->cookies = $request->cookiesSetting;

        $settings->save();

        return response()->json(true, 200);
    }

    //saveBgColors
    //сохранить настройки цветов фона
    public function saveBgColors(Request $request)
    {
        $settings = Settings::get()[0];

        $settings->bg_first_color = $request->bg_first_color;
        $settings->bg_second_color = $request->bg_second_color;

        $settings->save();

        return response()->json(true, 200);
    }

    //saveAboutSiteText
    //сохранить форму 
    public function saveAboutSiteText(Request $request)
    {
        $settings = Settings::get()[0];

        $settings->about_site_text = $request->about_site_text;
        $settings->save();

        return response()->json(true, 200);
    }

    //saveProjectSlide
    //сохранить слайд для проекта
    public function saveProjectSlide(Request $request)
    {
        $this->validate($request, [
            'slideMedia' => 'mimes:jpeg,jpg,png,mp4,gif',
            'slideComment'=>'string|max:500|nullable',
            'projectId' => 'int',
        ]);

        //путь до папки с медиа для слайдов
        $path = "app/public/projectsSlideMedia/";

        //проверка, есть ли папка projectsImages
        $check = File::exists(storage_path($path));

        //если нет, то создаём её
        if($check == false)
        { Storage::disk('public')->makeDirectory("projectsSlideMedia"); }

        $slideMedia = null;

        $response = [];

        if($request->hasFile('slideMedia'))
        {   
            // сохраняем медиа файл
            $mediaFile = $request->slideMedia;
            $filename = md5(time().rand(0,9)).".".$mediaFile->getClientOriginalExtension();
            $path = "public/projectsSlideMedia/".$filename;
            Storage::put($path, file_get_contents($mediaFile));

            // сохраняем запись в БД
            // если слайд вертикальный или горизонтальный
            if($request->slideVisibility != 'all')
            {
                $slide = new ProjectSlide;
                $slide->media_url = "storage/projectsSlideMedia/".$filename;
                $slide->visibility = $request->slideVisibility;
                $slide->commentary = $request->slideComment;
                $slide->project_id = $request->projectId;
                $slide->order = ProjectSlide::where('project_id', $request->projectId)->orderBy('order', 'desc')->min('order') - 1;
                $slide->save();
            } 
            // если слайд горизонтальный\вертикальный, то сохраняем две записи
            else {
                $slideHorizontal = new ProjectSlide;
                $slideHorizontal->media_url = "storage/projectsSlideMedia/".$filename;
                $slideHorizontal->visibility = 'horizontal';
                $slideHorizontal->commentary = $request->slideComment;
                $slideHorizontal->project_id = $request->projectId;
                $slideHorizontal->order = ProjectSlide::where('project_id', $request->projectId)->orderBy('order', 'desc')->min('order') - 1;
                $slideHorizontal->save();

                $slideVertical = new ProjectSlide;
                $slideVertical->media_url = "storage/projectsSlideMedia/".$filename;
                $slideVertical->visibility = 'vertical';
                $slideVertical->commentary = $request->slideComment;
                $slideVertical->project_id = $request->projectId;
                $slideVertical->order = ProjectSlide::where('project_id', $request->projectId)->orderBy('order', 'desc')->min('order') - 1;
                $slideVertical->save();
            }
        }

        return response()->json(true, 200);
    }

    //deleteProjectSlide
    //удалить слайд из проекта
    public function deleteProjectSlide(Request $request)
    {
        $projectSlide = ProjectSlide::find($request->slideId);

        $mediaUrl = $projectSlide->media_url;

        $countSlides = count(ProjectSlide::where('media_url', $mediaUrl)->get());
        
        if($countSlides == 1)
        {
            Storage::disk('public')->delete(str_replace('storage/', '', $mediaUrl));
        }

        $projectSlide->delete();

        //удаление медиа
        return response()->json(true, 200);
    }

    //setNewOrderForHorizontalSlides
    // изменить порядок для горизонтальных слайдов
    public function setNewOrderForSlides(Request $request)
    {   
    
        $newOrder = json_decode($request->newOrder);

        $count = count($newOrder) - 1;

        foreach($newOrder as $item)
        {
            $project = ProjectSlide::where('id', $item->id)->get()[0];
            $project->order = $count;
            $project->save();
            $count--;
        }

        return response()->json($newOrder, 200);
    }

    //saveSlideChanges
    // сохранить изенения для слайда
    public function saveSlideChanges(Request $request)
    {   
        $projectSlide = ProjectSlide::find($request->slideId);

        if($request->slideCommentary === 'null'){
            $projectSlide->commentary = null;
        } else{
            $projectSlide->commentary = $request->slideCommentary;
        }
        
        $projectSlide->save();

        return response()->json(true, 200);
    }

    //getSocialMediaLibrary
    // получить список соц.сетей для контактов
    public function getSocialMediaLibrary(Request $request)
    {
        $socialMediaLibrary = SocialMediaLibrary::all();

        return response()->json($socialMediaLibrary, 200);
    }

    // addContact
    // добавит контакт
    public function addContact(Request $request)
    {
        $this->validate($request, [
            'contact_url' => 'required|string|max:200'
        ]);

        $contact = new Contact;

        $contact->contact_type = $request->contact_type;
        $contact->contact_tooltip = $request->contact_tooltip;
        $contact->contact_url = $request->contact_url;
        $contact->contact_insertion = $request->contact_insertion;
        $contact->order = Contact::orderBy('order', 'desc')->min('order') - 1;

        $contact->save();

        return response()->json(true, 200);
    }

    // editContact
    // редактировать контакт
    public function editContact(Request $request)
    {
        $this->validate($request, [
            'contact_url' => 'required|string|max:200'
        ]);
        
        $contact = Contact::find($request->contact_id);
        
        $contact->contact_type = $request->contact_type;
        $contact->contact_tooltip = $request->contact_tooltip;
        $contact->contact_url = $request->contact_url;
        $contact->contact_insertion = $request->contact_insertion;

        $contact->save();
    }

    // deleteContact
    // удалить контакт
    public function deleteContact(Request $request)
    {
        $contact = Contact::find($request->contact_id)->delete();

        return response()->json(true, 200);
    }

    //setNewOrderForContacts
    //установить новый порядок для контактов
    public function setNewOrderForContacts(Request $request){
        
        $newOrder = json_decode($request->newOrder);

        $count = count($newOrder) - 1;

        foreach($newOrder as $item)
        {
            $contact = Contact::where('id', $item->id)->get()[0];
            $contact->order = $count;
            $contact->save();
            $count--;
        }

        return response()->json($newOrder, 200);
    }

    // getCookiesMessage
    // получить текст сообщения о Cookies
    public function getCookiesMessage(){
        $cookiesMessage = Settings::get()[0]->cookies_message;

        return response()->json($cookiesMessage, 200);
    }

    // saveCookiesMessage
    // сохранить изменения в сообщении о Cookies
    public function saveCookiesMessage(Request $request)
    {
        $settings = Settings::get()[0];
        $settings->cookies_message = $request->cookiesMessage;
        $settings->save();
        return response()->json(true, 200);
    }

    // addNewOrderType
    // добавить новый тип заказа
    public function addNewOrderType(Request $request){
        
        $this->validate($request, [
            'order_name' => 'required|string|max:255',
            'order_desc' => 'required|string|max:1555',
            'order_bootstrap_icon' => 'string|max:255|nullable',
            'price_range' => 'string|max:255|nullable',
            'time_range' => 'string|max:255|nullable',
            'color_style' => 'string|max:255|nullable',
        ]);

        $order = new Order;

        $order_type = Str::slug($request->order_name);

        $checkOrderTypeUniqueness = count(Order::where('order_type', $order_type)->get());

        if($checkOrderTypeUniqueness > 0){
            $order_type = $order_type . strval(rand(0,9999));
        }

        $order->order_type = $order_type;
        $order->order_name = $request->order_name;
        $order->order_desc = $request->order_desc;
        $order->order_bootstrap_icon = $request->order_bootstrap_icon;
        $order->price_range = $request->price_range;
        $order->time_range = $request->time_range;
        $order->color_style = $request->color_style;

        $order->save();

        return response()->json(true, 200);
        

    }

    // getOrderType
    // получить тип заказа 
    public function getOrderType($slug){

        $order = Order::where('order_type', $slug)->get()[0];

        return response()->json($order);

    }

    // saveOrderType
    // изменить тип заказа
    public function saveOrderType(Request $request){

        $this->validate($request, [
            'order_name' => 'required|string|max:255',
            'order_desc' => 'required|string|max:1555',
            'order_bootstrap_icon' => 'string|max:255|nullable',
            'price_range' => 'string|max:255|nullable',
            'time_range' => 'string|max:255|nullable',
            'color_style' => 'string|max:255|nullable',
        ]);

        $order = Order::where('order_type', $request->order_type)->get()[0];

        $order->order_name = $request->order_name;
        $order->order_desc = $request->order_desc;
        $order->order_bootstrap_icon = $request->order_bootstrap_icon;
        $order->time_range = $request->time_range;
        $order->price_range = $request->price_range;
        $order->color_style = $request->color_style;

        $order->save();

        return response()->json(true, 200);
    }

    // deleteOrder
    // удалить тип заказа
    public function deleteOrder(Request $request){
        
        $order = Order::where('order_type', $request->order_type)->get()[0];

        $order->delete();

        return response()->json(true, 200);

    }

}
