<?php
namespace app\common\services;

use app\common\services\BaseService;

use app\models\City;
use Yii;

class AreaService extends BaseService {
	//可以考虑加入缓存
    public static function getProvinceCityTree($province_id, $use_cache = true){
        $zhixiashi_city_id = [110000,120000,310000,500000];

        $key = "pro_city_distr_{$province_id}";
        $city_list = City::find()
            ->where(['province_id' => $province_id ])
            ->orderBy(['id' => SORT_ASC])
            ->all();

        $city_tree = [
            "city" => [],
            "district" => []
        ];
        if ($city_list) {
            foreach ($city_list as $_city_item) {
                if( in_array( $province_id,$zhixiashi_city_id ) ){
                    if( $_city_item['city_id'] == 0  ){
                        $city_tree['city'][] = [
                            'id' => $_city_item['id'],
                            'name' => $_city_item['name']
                        ];
                    }else{
                        $city_tree['district'][$province_id][] = [
                            'id' => $_city_item['id'],
                            'name' => $_city_item['name']
                        ];
                    }
                }else{
                    if( $_city_item['city_id'] == 0  ){
                        continue;
                    }

                    if( $_city_item['area_id'] == 0 ){
                        $city_tree['city'][] = [
                            'id' => $_city_item['id'],
                            'name' => $_city_item['name']
                        ];
                    }else{
                        $tmp_prefix_key = $_city_item['city_id'];
                        if( !isset( $city_tree['district'][$tmp_prefix_key] ) ){
                            $city_tree['district'][$tmp_prefix_key] = [];
                        }

                        $city_tree['district'][$tmp_prefix_key ][] = [
                            'id' => $_city_item['id'],
                            'name' => $_city_item['name']
                        ];
                    }
                }

            }
        }

        return $city_tree;
    }

    public static function format($city_infos,$city_id){
        $data = [];
        if(!$city_infos){
            return $data;
        }
        $tmp_district = [];
        $tmp_area = [];
        foreach($city_infos['district'] as  $district_info){
            $district_id = $district_info['key'];
            $tmp_district_id = str_replace("{$city_id}-","",$district_id);
            $tmp_district[] = ['id' => $tmp_district_id,'name'=>$district_info['name']];
            foreach($district_info['areas'] as $area_info){
                if($area_info['key'] == $district_id){
                    continue;
                }
                $tmp_area_id = str_replace("{$district_id}-","",$area_info['key']);
                $tmp_area[$district_id][] = ['id' => $tmp_area_id,'name' => $area_info['name']];
            }
        }
        $data['district'] = $tmp_district;
        $data['area'] = $tmp_area;
        return $data;
    }

    public static function getProvinceMapping() {
        $ret = [];
        $province_list = City::find()->where(['city_id' => 0])->orderBy("id asc")->all();
        if( $province_list ){
            foreach( $province_list as $_province_info ){
                $ret[ $_province_info['id'] ] = $_province_info['province'];
            }
        }
        return $ret;
    }

    public static function getCityInfo( $id, $use_cache = true ){
        $key = "city_rc_item_{$id}";

        $info = City::find()->where([ 'id' => $id ])->limit(1)->one();
        $data = [];
        if( $info ){
            $data = [
               "province_id" =>  $info['province_id'],
               "province_name" =>  $info['province'],
               "city_id" =>  $info['city_id'],
               "city_name" =>  $info['city'],
               "area_id" =>  $info['area_id'],
               "area_name" =>  $info['area'],
               "region_id" =>  $info['region_id'],
               "region_name" =>  $info['region_name'],
               "address" =>  [
                   $info['province'],
                   $info['city']
               ]
            ];

            if( $info['area_id'] ){
                $data['address']['area'] = $info['area'];
            }
        }

        return $data;
    }

}