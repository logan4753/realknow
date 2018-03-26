<?php
namespace app\admin\validate;
use think\Validate;
class Resources extends Validate
{
    protected $rule = [
        'resname'  =>  'require|unique:resources',
        'resadd' =>  'require',
    ];

    protected $message  =   [
        'resname.require' => '链接名称必须填写',
        'resname.unique' => '链接名称不得重复',
        'resadd.require' => '链接地址必须填写',

    ];

    protected $scene = [
        'add'  =>  ['resname'=>'require|unique:resources','resadd'],
        'edit'  =>  ['resname'=>'require|unique:resources','resadd'],
    ];


}
