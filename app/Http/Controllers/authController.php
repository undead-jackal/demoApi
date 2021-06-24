<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helper\DataPayload;

class authController extends Controller{
    public function package(Request $request){
        $method = $request->input("method");
        if($method == 'login'){
            return response()->json([
                'return' => $this->login($request),
            ]);
        }

        if ($method == 'register') {
            return response()->json([
                'return' => $this->register($request),
            ]);
        }
    }

    public function login($request){
        $data = DataPayload::getData(array(
            'table' => 'person',
            'select'=>array('id','email','fname','lname','role'),
            'where' => array(
                'email' => $request->input('email'),
                "password" => $request->input('password'),
                "status" => 0
            ),
        ));
        if (count($data) != 0) {
            return $data[0];
        }else{
            return "error";
        }
    }

    public function register($request){
        return DataPayload::insertData('person',
            array(
                'username'=>$request->input('username'),
                'password'=>$request->input('password'),
                'fname'=>$request->input('fname'),
                'lname'=>$request->input('lname'),
                'email'=>$request->input('email'),
                'role'=>$request->input('role'),
            )                
        );
    }
}
