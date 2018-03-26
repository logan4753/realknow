<?php
namespace app\admin\controller;
use app\admin\model\Cates as CatesModel;
use app\admin\controller\Base;
class Cates extends Base
{
	
    public function lst()
    {
    	$model= new CatesModel();
    	$list = CatesModel::paginate(5);
    	$this->assign('list',$list);
        return $this->fetch();
    }

    public function add()
    {
    	if(request()->isPost()){
    		$data = [
    			'catename'=>input('catename'),
    			'desc'=>input('desc')
    		];
    		//dump($data);die;
    		$validate = \think\Loader::validate('cates');
    		if(!$validate->scene('add')->check($data)){
    			$this->error($validate->getError());die;
    		}
    		if(db('cates')->insert($data)){
    			return $this->success('分类添加成功！','lst');
    		}else{
    			return $this->error('分类添加失败！');
    		}
    	}else{
    		return $this->fetch();
    	}   	
    }

    public function edit()
    {
    	$id = input('id');
    	$row = db('cates')->find($id);
    	if(request()->isPost()){
    		$data = [
				'id'=>input('id'),
				'catename'=>input('catename'),
                'desc'=>input('desc')
			];
			$validate = \think\Loader::validate('cates');
    		if(!$validate->scene('edit')->check($data)){
			   $this->error($validate->getError()); die;
			}
			$save=db('cates')->update($data);
    		if($save !== false){
    			$this->success('分类信息修改成功！','lst');
    		}else{
    			$this->error('分类信息修改失败！');
    		}
    		return;
    	}
    	$this->assign('row',$row);
    	return $this->fetch();
    }

    public function del(){
    	$id = input('id');
		if(db('cates')->delete($id)){
			$this->success('分类删除成功！','lst');
		}else{
			$this->error('分类删除失败！');
		}
    }


}
