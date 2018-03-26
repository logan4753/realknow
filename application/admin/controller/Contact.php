<?php
namespace app\admin\controller;
use app\admin\model\Contact as ContactModel;
use app\admin\controller\Base;
class Contact extends Base
{
	
    public function lst()
    {
    	$model= new ContactModel();
    	$list = ContactModel::paginate(15);
    	$this->assign('list',$list);
        return $this->fetch();
    }

    public function del(){
        $id = input('id');
        if(db('contact')->delete($id)){
            $this->success('用户注销成功！','lst');
        }else{
            $this->error('用户注销失败！');
        }
    }

    

}
