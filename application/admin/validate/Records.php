<?php
namespace app\admin\validate;
use think\Validate;
class Records extends Validate
{
    protected $rule = [
        'reccont'  =>  'require',
    ];

    protected $message  =   [
        'reccont.require' => '说说内容必须填写',

    ];

    protected $scene = [
        'add'  =>  ['reccont'=>'require'],
        'edit'  =>  ['reccont'=>'require'],
    ];


}
