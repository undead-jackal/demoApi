<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helper\DataPayload;
use Illuminate\Support\Facades\DB;


class demoController extends Controller{
    public function package(Request $request){
        $method = $request->input('method');
        if($method == "addProject"){
            return response()->json([
                'return' => $this->addProject($request),
            ]);
        }

        if($method == "getAll"){
            return response()->json([
                'return' => $this->getProject($request),
            ]);
        }

        if ($method == "getAProject") {
            return response()->json([
                'return' => $this->viewProject($request)[0],
            ]);
        }

        if ($method == "getPersons") {
            return response()->json([
                'return' => $this->getPersons($request),
            ]);
        }

        if ($method == "assignData") {
            return response()->json([
                'return' => $this->assignUser($request),
            ]);
        }

        if ($method == "activityStart") {
            return response()->json([
                'return' => $this->activityStart($request),
            ]);
        }

        if ($method == "activityUpdate") {
            return response()->json([
                'return' => $this->activityUpdate($request),
            ]);
        }

        if ($method == "wallet") {
            return response()->json([
                'return' => $this->wallet($request),
            ]);
        }
    }

    public function wallet($request){
        return DataPayload::getData(array(
            'table' => 'activity',
            'select' => array('amount'),
            'where' => array(
                array('user_id','=',$request->input('myId'))
            )
        ));
    }

    public function activityUpdate($request){
        $update = DataPayload::updateOrInsertData(
            'activity',
            array(
                "id"=>$request->input("id"),
            ),
            array(
                'ended'=>$request->input('ended'),
                'hrs_spent'=>$request->input('hrs_spents'),
                'amount'=>$request->input('pay'),
            )
        );
        return $update;
    }

    public function activityStart($request){
        return DataPayload::insertData('activity',
            array(
                'project_id'=>$request->input('project_id'),
                'user_id'=>$request->input('user_id'),
                'started'=>$request->input('started'),
                'hrs_spent'=>$request->input('hrs'),
            )                
        );
    }

    public function assignUser($request){
        $update = DataPayload::updateOrInsertData(
            'project',
            array(
                "id"=>$request->input("id"),
            ),
            array(
                'assigned_to'=>$request->input("emp"),
            )
        );
        return $update;
    }

    public function getPersons($request){
        return DataPayload::getData(array(
            'table' => 'person',
            'select' => array('id','fname','lname'),
            'where' => array(
                array('role','=',1)
            )
        ));
    }

    public function viewProject($request){
        return DataPayload::getData(array(
            'table' => 'project',
            'where' => array(
                array('id','=',$request->input("id"))
            )
        ));
    }

    public function addProject($request){
        return DataPayload::insertData('project',
            array(
                'title'=>$request->input('title'),
                'pay'=>$request->input('pay'),
                'instruction'=>$request->input('instruction'),
            )                
        );
    }

    public function getProject($request){
        $where = array();
        if ($request->input('myId') != null) {
            $where = array(
                array('assigned_to','=',$request->input('myId')),
            );
        }

        
        return DataPayload::getData(array(
            'table' => 'project',
            'select'=>array('id','title','pay',
            DB::raw("(select fname from person where id = project.assigned_to) as fname"),
            DB::raw("(select lname from person where id = project.assigned_to) as lname"),
            DB::raw("(select SUM(hrs_spent) from activity where project_id = project.id) as total_hrs"),
            DB::raw("(select SUM(amount) from activity where project_id = project.id) as total_amount")

            ),
            'where' => $where,
            'offset' => $request->input('offset'),
            'limit' => $request->input('limit')
        ));
    }
}
