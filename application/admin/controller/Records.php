<?php
namespace app\admin\controller;
use app\admin\model\Records as RecordsModel;
use app\admin\controller\Base;
class Records extends Base
{
	
    public function lst()
    {
    	$model= new RecordsModel();
    	$list = RecordsModel::paginate(5);
    	$this->assign('list',$list);
        return $this->fetch();
    }

    public function add()
    {
    	if(request()->isPost()){
    		$data = [
    			'reccont'=>input('reccont'),
                'rectime'=>time()
    		];
    		$validate = \think\Loader::validate('Records');
    		if(!$validate->scene('add')->check($data)){
    			$this->error($validate->getError());die;
    		}
    		if(db('records')->insert($data)){
    			return $this->success('说说发布成功！','lst');
    		}else{
    			return $this->error('说说发布失败！');
    		}
    	}else{
    		return $this->fetch();
    	}   	
    }

    public function edit()
    {
    	$id = input('id');
    	$row = db('records')->find($id);
    	if(request()->isPost()){
    		$data = [
				'id'=>input('id'),
				'reccont'=>input('reccont'),
                'rectime'=>time()
			];
			$validate = \think\Loader::validate('Records');
    		if(!$validate->scene('edit')->check($data)){
			   $this->error($validate->getError()); die;
			}
			$save=db('records')->update($data);
    		if($save !== false){
    			$this->success('说说编辑成功！','lst');
    		}else{
    			$this->error('说说编辑失败！');
    		}
    		return;
    	}
    	$this->assign('row',$row);
    	return $this->fetch();
    }

    public function del(){
    	$id = input('id');
		if(db('records')->delete($id)){
			$this->success('说说删除成功！','lst');
		}else{
			$this->error('说说删除失败！');
		}
    }


}
