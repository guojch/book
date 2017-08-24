<?php
/**
 * 统一上传
 */

namespace app\common\services;


use app\models\Images;

class UploadService extends  BaseService{

    protected static $allow_file_type = ["jpg","gif","bmp","jpeg","png"];//设置允许上传文件的类型

	/**
	 * $bucket = book,avatar,brand
	 */
    public static function uploadByFile($filename,$filepath,$bucket = ''){
        if( !$filename ){
            return self::_err("参数文件名是必要参数~~");
        }

        if( !$filepath || !file_exists($filepath) ){
            return self::_err("请传入合法的参数filepath~~");
        }

        $date_now = date("Y-m-d H:i:s");
        $tmp_file_extend = explode(".", $filename);
        $file_type = strtolower( end($tmp_file_extend) );

        if( !in_array( $file_type ,self::$allow_file_type) ){
            return self::_err("非图片格式必须指定参数hask_key~~");
        }

        $upload_config = \Yii::$app->params['upload'];
        if( !isset( $upload_config[ $bucket ] ) ){
			return self::_err("指定的bucket不存在或者没有配置~~");
		}

		$hash_key = md5( file_get_contents( $filepath ) );

		$upload_dir_path = UtilService::getRootPath()."/web".$upload_config[ $bucket ]."/";
        $folder_name = date( "Ymd",strtotime($date_now) );
        $upload_dir = $upload_dir_path.$folder_name;

        if( !file_exists($upload_dir) ){
            mkdir($upload_dir,0777);
            chmod($upload_dir,0777);
        }

        $upload_file_name = "{$folder_name}/{$hash_key}.".$file_type;

        if( is_uploaded_file($filepath) ){
            if(!move_uploaded_file($filepath,$upload_dir_path.$upload_file_name) ){
                return self::_err("上传失败！！系统繁忙请稍后再试~~");
            }
        }else{
            file_put_contents( $upload_dir_path.$upload_file_name,file_get_contents($filepath) );
        }

        self::saveImage( $bucket,$upload_file_name );

        return[
            'code' => 200,
            'path' => $upload_file_name,
			'prefix' => $upload_config[ $bucket ]."/"
        ];
    }

	/**
	 * $bucket = book,avatar,brand
	 */
	public static function uploadByUrl( $url,$bucket = ''){
		if( !$url ){
			return self::_err("参数文件名是必要参数~~");
		}


		$date_now = date("Y-m-d H:i:s");
		$file_type = "jpg";

		if( !in_array( $file_type ,self::$allow_file_type) ){
			return self::_err("非图片格式必须指定参数hask_key~~");
		}

		ini_set("user_agent","Mozilla/4.0 (compatible; MSIE 5.00; Windows 98)");
		$data_content = file_get_contents( $url );

		$upload_config = \Yii::$app->params['upload'];
		if( !isset( $upload_config[ $bucket ] ) ){
			return self::_err("指定的bucket不存在或者没有配置~~");
		}

		$hash_key = md5( $data_content );

		$upload_dir_path = UtilService::getRootPath()."/web".$upload_config[ $bucket ]."/";
		$folder_name = date( "Ymd",strtotime($date_now) );
		$upload_dir = $upload_dir_path.$folder_name;

		if( !file_exists($upload_dir) ){
			mkdir($upload_dir,0777);
			chmod($upload_dir,0777);
		}

		$upload_file_name = "{$folder_name}/{$hash_key}.".$file_type;

		file_put_contents( $upload_dir_path.$upload_file_name,$data_content );

		return [
			'code' => 200,
			'path' => $upload_file_name,
		];
	}

	private static function saveImage($bucket = '',$file_key = '' ){
		$model_image = new Images();
		$model_image->bucket = $bucket;
		$model_image->file_key = $file_key;
		$model_image->created_time = date("Y-m-d H:i:s");
		return $model_image->save( 0 );
	}
} 