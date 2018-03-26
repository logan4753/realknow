<?php
namespace app\admin\validate;
use think\Validate;
class Cates extends Validate
{
    protected $rule = [
        'catename'  =>  'require|unique:cates',
    ];

    protected $message  =   [
        'catename.require' => '分类名称必须填写',
    ];

    protected $scene = [
        'add'  =>  ['catename'=>'require|unique:cates'],
        'edit'  =>  ['catename'=>'require|unique:cates'],
    ];




}
