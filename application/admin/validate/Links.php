<?php
namespace app\admin\validate;
use think\Validate;
class Links extends Validate
{
    protected $rule = [
        'linkname'  =>  'require|unique:links',
        'linkurl' =>  'require',
    ];

    protected $message  =   [
        'linkname.require' => '链接名称必须填写',
        'linkname.unique' => '链接名称不得重复',
        'linkurl.require' => '链接地址必须填写',

    ];

    protected $scene = [
        'add'  =>  ['linkname'=>'require|unique:links','linkurl'],
        'edit'  =>  ['linkname'=>'require|unique:links','linkurl'],
    ];




}
