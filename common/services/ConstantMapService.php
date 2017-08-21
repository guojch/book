<?php

namespace app\common\services;


class ConstantMapService{

    public static $status_default = -1;

    public static $status_mapping = [
        1 => '正常',
        0 => '已删除'
    ];

    public static $sex_mapping = [
        1 => '男',
        2 => '女',
        0 => '未填写'
    ];

    public static $pay_status_mapping = [
        1 => '已支付',
        -8 => '待支付',
        0 => '已关闭'
    ];

    public static $default_avatar = "default_avatar";
    public static $default_password = '******';

    public static $default_syserror = '系统繁忙，请稍后再试~~';
}