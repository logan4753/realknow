<?php
namespace app\admin\controller;
use app\admin\model\Admin as AdminModel;
use app\admin\controller\Base;
class Admin extends Base
{
	
    public function lst()
    {
    	$model= new AdminModel();
    	$list = AdminModel::paginate(5);
    	$this->assign('list',$list);
        return $this->fetch();
    }

    public function add()
    {
    	if(request()->isPost()){
    		$data = [
    			'username'=>input('username'),
    			'password'=>md5(input('password'))
    		];
    		if($_FILES['image']['tmp_name']){
    			$file = request()->file('image');
    			$info = $file->move(ROOT_PATH . 'public' . DS . 'static/uploads');
    			$data['image']='/uploads/'.$info->getSaveName();
    		}
    		//dump($data);die;
    		$validate = \think\Loader::validate('Admin');
    		if(!$validate->scene('add')->check($data)){
    			$this->error($validate->getError());die;
    		}
    		if(db('admin')->insert($data)){
    			return $this->success('管理员添加成功！','lst');
    		}else{
    			return $this->error('管理员添加失败！');
    		}
    	}else{
    		return $this->fetch();
    	}   	
    }

    public function edit()
    {
    	$id = input('id');
    	$row = db('admin')->find($id);
    	if(request()->isPost()){
    		$data = [
				'id'=>input('id'),
				'username'=>input('username'),
			];
			if(input('password')){
				$data['password']=md5(input('password'));
			}else{
				$data['password']=$row['password'];
			}
			if($_FILES['image']['tmp_name']){
    			$file = request()->file('image');
    			$info = $file->move(ROOT_PATH . 'public' . DS . 'static/uploads');
    			$data['image']='/uploads/'.$info->getSaveName();
    		}
			$validate = \think\Loader::validate('Admin');
    		if(!$validate->scene('edit')->check($data)){
			   $this->error($validate->getError()); die;
			}
			$save=db('admin')->update($data);
    		if($save !== false){
    			$this->success('管理员信息修改成功！','lst');
    		}else{
    			$this->error('管理员信息修改失败！');
    		}
    		return;
    	}
    	$this->assign('row',$row);
    	return $this->fetch();
    }

    public function del(){
    	$id = input('id');
    	if($id!=1){
			if(db('admin')->delete($id)){
				$this->success('管理员删除成功！','lst');
			}else{
				$this->error('管理员删除失败！');
			}
		}else{
			$this->error('超级管理员不能删除！！！');
		}
    }


}
