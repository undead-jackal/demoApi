<?php

namespace App\Helper;
use Illuminate\Support\Facades\DB;

class DataPayload{
    public static function getData($params = array(), $toSql = false){
        $query = DB::table($params['table']);
        if (array_key_exists('select',$params)) {
            $query->select($params['select']);
        }

        if (array_key_exists('where',$params)) {
            $query->where($params['where']);
        }
        if (array_key_exists('join',$params)) {
            foreach($params['join'] as $join){
                $query->join($join[0], $join[1], $join[2], $join[3]);
            }
        }
        if (array_key_exists('orWhere', $params)) {
                $query->orWhere($params['orWhere']);
        }
        if(array_key_exists('desc', $params)){
            foreach($params['desc'] as $desc){
                $query->orderBy($desc[0], $desc[1]);
            }
        }
        if(array_key_exists('offset', $params)){
            $query->offset($params['offset']);
        }
        if(array_key_exists('limit', $params)){
            $query->limit($params['limit']);
        }
        if ($toSql) {
            return $query->toSql();
        }else{
            return $query->get();
        }

    }
    // use one line to save space DataModel::insertData("sampletable",array())
    public static function insertData($table, $data, $toSql = false){
        return DB::table($table)
            ->insertGetId($data);
    }

    public static function updateData($table,$data,$where){
        return DB::table($table)
                ->where($where)
                ->update($data);
    }

    public static function updateOrInsertData($table, $data,$where){
        return DB::table($table)
        ->updateOrInsert(
            $data,
            $where
        );
    }
}
