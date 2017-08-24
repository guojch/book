<?php

return [
    'title' => '图书商城',
    'domain' => [
        'www' => 'http://book.guojch.com',
        'm' => 'http://book.guojch.com/m',
        'web' => 'http://book.guojch.com/web'
    ],
    'upload' => [
        'avatar' => '/uploads/avatar',
        'brand' => '/uploads/brand',
        'book' => '/uploads/book'
    ],
    'weixin' => [
        'appid' => 'wxd68bb46341e27798',
        'sk' => '5c3a786a667f7c13f04b3b314ab0e15e',//app_secret
        'token' => 'guojch',
        'aeskey' => '根据实际情况填写',
        'pay' => [
            'key' => '根据实际情况填写',
            'mch_id' => '根据实际情况填写',
            'notify_url' => [
                'm' => '/pay/callback'
            ]
        ]
    ]
];
