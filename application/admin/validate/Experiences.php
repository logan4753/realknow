<?php
namespace app\admin\validate;
use think\Validate;
class Experiences extends Validate
{
    protected $rule = [
        'title'  =>  'require',
        'cateid' =>  'require',
        'author' =>  'require',
        'content' =>  'require',
        'status' =>  'require',
        'time' =>  'require',
    ];

    protected $message  =   [
        'title.require'  =>  '文章标题必须填写',
        'cateid.require' =>  '文章分类必须填写',
        'author.require' =>  '文章作者必须填写',
        'content.require' =>  '文章内容必须填写',
        'status.require' =>  '文章推荐必须填写',
        'time.require' =>  '发布时间必须填写',
    ];

    protected $scene = [
        'add'  =>  ['title','cateid','author','content','status','time'],
        'edit'  =>  ['title','cateid','author','content','status','time'],
    ];


}
