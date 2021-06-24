<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helper\DataPayload;

class apiController extends Controller{
    public function package(Request $request){
        $method = $request->input('method');
        if($method == "getAll"){
            return response()->json([
                'return' => $this->getAllEmployee($request),
                'total' => count($this->getTotalEmp($request))
            ]);
        }

        if($method == "addEmployee"){
            return response()->json([
                'return' => $this->addEmployee($request),
            ]);
        }

        if($method == "getSpecEmployee"){
            return response()->json([
                'return' => $this->getSpecEmp($request),
            ]);
        }

        if($method == "updateStatus"){
            return response()->json([
                'return' => $this->updateStatus($request),
            ]);
        }

        if ($method == "updEmployee") {
            return response()->json([
                'return' => $this->updateEmployee($request),
            ]);
        }
    }

    public function updateEmployee($request){
        $update = DataPayload::updateOrInsertData(
            'employee',
            array(
                "id"=>$request->input("id"),
            ),
            array(
                'fname'=>$request->input('fname'),
                'lname'=>$request->input('lname'),
                'email'=>$request->input('email'),
                'contact'=>$request->input('contact'),
                'position'=>$request->input('position'),
            )
        );
        return $update;        
    }

    public function updateStatus($request){
        $update = DataPayload::updateOrInsertData(
            'employee',
            array(
                "id"=>$request->input("id"),
            ),
            array(
                'status'=>1,
            )
        );
        return $update;
    }

    public function getSpecEmp($request){
        return DataPayload::getData(array(
            'table' => 'employee',
            'where' => array(
                array('id','=',$request->input("id"))
            )
        ));
    }

    public function getAllEmployee($request){
        $where = array(
            array('status','=',0),
        );
        if ($request->input('search') != null) {
            $where = array(
                array('status','=',0),
                array('employeeId','=',$request->input('search')),
            );
        }
        
        return DataPayload::getData(array(
            'table' => 'employee',
            'where' => $where,
            'offset' => $request->input('offset'),
            'limit' => $request->input('limit')
        ));
    }

    public function getTotalEmp($request){
        $where = array(
            array('status','=',0),
        );
        if ($request->input('search') != null) {
            $where = array(
                array('status','=',0),
                array('employeeId','=',$request->input('search')),
            );
        }
        return DataPayload::getData(array(
            'table' => 'employee',
            'where' => $where,
        ));
    }

    public function addEmployee($request){
        return DataPayload::insertData('employee',
            array(
                'employeeId' =>"cf".uniqid(),
                'fname'=>$request->input('fname'),
                'lname'=>$request->input('lname'),
                'email'=>$request->input('email'),
                'contact'=>$request->input('contact'),
                'position'=>$request->input('position'),
                'credentials'=>$request->input('credentials'),
            )                
        );
    }
}
