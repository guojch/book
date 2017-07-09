<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/9
 * Time: 18:42
 */

namespace app\common\services;


class ConstantMapService{
    public static $status_default = -1;
    public static $status_mapping = [
        1 => '正常',
        0 => '已删除'
    ];
}