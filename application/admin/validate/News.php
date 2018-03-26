<?php
namespace app\admin\validate;
use think\Validate;
class News extends Validate
{
    protected $rule = [
        'title'  =>  'require',
        'image' =>  'require',
        'content' =>  'require',
        'desc' =>  'require',
    ];

    protected $message  =   [
        'title.require' => '文章标题必须填写',
        'image.require' => '缩略图必须',
        'content.require' => '文章内容必须填写',
        'desc.require' => '文章描述必须填写',

    ];

    protected $scene = [
        'add'  =>  ['title','image','content','desc'],
        'edit'  =>  ['title','content','desc'],
    ];




}
