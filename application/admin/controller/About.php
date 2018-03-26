<?php
namespace app\admin\controller;
use app\admin\model\About as AboutModel;
use app\admin\controller\Base;
class About extends Base
{
	
    public function lst()
    {
    	$model= new AboutModel();
    	$list = AboutModel::paginate(5);
    	$this->assign('list',$list);
        return $this->fetch();
    }

    public function add()
    {
    	if(request()->isPost()){
    		$data = [
                'title'=>input('title'),
                'status'=>input('status'),
    			'cont'=>input('cont')
    		];
    		if(db('about')->insert($data)){
    			return $this->success('个人信息添加成功！','lst');
    		}else{
    			return $this->error('个人信息添加失败！');
    		}
    	}else{
    		return $this->fetch();
    	}   	
    }

    public function edit()
    {
    	$id = input('id');
    	$row = db('about')->find($id);
    	if(request()->isPost()){
    		$data = [
				'id'=>input('id'),
				'title'=>input('title'),
                'status'=>input('status'),
                'cont'=>input('cont')
			];
			$save=db('about')->update($data);
    		if($save !== false){
    			$this->success('个人信息修改成功！','lst');
    		}else{
    			$this->error('个人信息修改失败！');
    		}
    		return;
    	}
    	$this->assign('row',$row);
    	return $this->fetch();
    }

    public function del(){
    	$id = input('id');
		if(db('about')->delete($id)){
			$this->success('个人信息删除成功！','lst');
		}else{
			$this->error('个人信息删除失败！');
        }
    }


}
