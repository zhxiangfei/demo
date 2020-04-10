<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/09/07 0011
 * Time: 09:07
 */

return[
   // +----------------------------------------------------------------------
    // | 会话设置
    // +----------------------------------------------------------------------

    'session'                => [
        'id'             => '',
        // SESSION_ID的提交变量,解决flash上传跨域
        'var_session_id' => '',
        // SESSION 前缀
        'prefix'         => '',
        // 驱动方式 支持redis memcache memcached
        'type'           => '',
        // 是否自动开启 SESSION
        'auto_start'     => true,
        //设置过期时间
        'expire'         => 7200,
    ],

    // | 数据库配置
    'adr1DB'=>[
        'type'           => 'mysql',
        'hostname'       => '127.0.0.1',
        'database'       => 'adr1',
        'username'       => 'root',
        'password'       => 'root',
        'hostport'       => '3306',
        // 数据库表前缀
        'prefix'          => 'adr1_',
    ],
    'adr6DB'=>[
        'type'           => 'mysql',
        'hostname'       => '127.0.0.1',
        'database'       => 'adr6',
        'username'       => 'root',
        'password'       => 'root',
        'hostport'       => '3306',
        // 数据库表前缀
        'prefix'          => 'adr6_',
    ],
    'sunganyanjiuDB'=>[
        'type'           => 'mysql',
        'hostname'       => '127.0.0.1',
        'database'       => 'sunganyanjiu',
        'username'       => 'root',
        'password'       => 'root',
        'hostport'       => '3306',
        // 数据库表前缀
        'prefix'          => 'sungan_',
    ],
    'yaowuxinglinchuangyanjiu4DB'=>[
        'type'           => 'mysql',
        'hostname'       => '127.0.0.1',
        'database'       => 'yaowuxinglinchuangyanjiu4',
        'username'       => 'root',
        'password'       => 'root',
        'hostport'       => '3306',
        // 数据库表前缀
        'prefix'          => 'yaowu4_',
    ],
    'yaowuxinglinchuangyanjiu3DB'=>[
        'type'           => 'mysql',
        'hostname'       => '127.0.0.1',
        'database'       => 'yaowuxinglinchuanyanjiu3',
        'username'       => 'root',
        'password'       => 'root',
        'hostport'       => '3306',
        // 数据库表前缀
        'prefix'          => 'yaowu3_',
    ],  
    

];