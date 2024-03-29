<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Settings;
use App\Models\Contact;
use Illuminate\Support\Facades\Mail;
use App\Mail\MessageMail;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    //index
    //домашаняя страница сайта
    public function index()
    {

        $settings = Settings::get()[0];
        $site_title = $settings->site_title;
        
        $bgSettings = [
            'bg_first_color' => $settings->bg_first_color,
            'bg_second_color' => $settings->bg_second_color,
        ];

        $firstColor = $settings->bg_first_color;
        $secondColor = $settings->bg_second_color;

        $style = 'background: linear-gradient(to right top, '.$firstColor.', '.$secondColor.');';

        $style .= ' background-size: 400%; background-repeat: no-repeat; background-attachment: fixed;';

        $style .= ' animation: backgroundGradient 30s ease-in-out infinite;';

        return view('index', compact('site_title', 'style'));
    }

    // sendEmailMessage
    public function sendEmailMessage(Request $request){
        //получить список e-mail'ов
        $emails = Contact::select('contact_url')->where('contact_type', 'email')->get();
        
        foreach($emails as $email){
            //send email
            Mail::to($email->contact_url)->send(new MessageMail($request->messageEmail, $request->pickedProject, $request->messageText));
        }

         return true;

    }
}
