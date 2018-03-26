<?php
namespace app\index\validate;
use think\Validate;
class Contact extends Validate
{
    protected $rule = [
        'username'  =>  'require|unique:contact',
        'usermail' =>  'require|unique:contact',
        'userpass' =>  'require',
    ];

    protected $message  =   [
        'username.require' => '用户名必须填写',
        'username.unique' => '该用户名已注册',
        'usermail.unique' => '该邮箱已注册',
        'password.require' => '密码必须填写',

    ];

    protected $scene = [
        'add'  =>  ['username'=>'require|unique:contact','password','usermail'=>'require|unique:contact'],
    ];




}
