<?php

namespace App\Http\Controllers;

use App\Mail\ContactEmail;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class januController extends Controller
{
    public function package(Request $request){
        $method = $request->input('method');
        if ($method == 'send') {
            return $this->send($request);
        }
    }

    public function send($request){
        $data = array(
            "name" => $request->input('name'),
            "email" => $request->input('email'),
            "message" => $request->input('message')
        );
        
        Mail::to("enrickejanu@gmail.com")->send(new ContactEmail($data));
        return true;
    }
}
