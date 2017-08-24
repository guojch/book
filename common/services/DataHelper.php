<?php

namespace app\common\services;

class DataHelper {
	/**
     * 根据某个字段 in  查询
     */
    public static function getDicByRelateID($data,$relate_model,$id_column,$pk_column,$name_columns = [])
    {
        $_ids = [];
        $_names = [];
        foreach($data as $_row)
        {
            $_ids[] = $_row[$id_column];
        }
        $rel_data = $relate_model::findAll([$pk_column => array_unique($_ids)]);
        foreach($rel_data as $_rel)
        {
            $map_item = [];
            if($name_columns && is_array($name_columns)){
                foreach($name_columns as $name_column){
                    $map_item[$name_column] = $_rel->$name_column;
                }
            }
            $_names[$_rel->$pk_column] = $map_item;
        }
        return $_names;
    }


}
