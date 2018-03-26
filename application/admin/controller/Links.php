<?php
namespace app\admin\controller;
use app\admin\model\Links as LinksModel;
use app\admin\controller\Base;
class Links extends Base
{
	
    public function lst()
    {
    	$model= new LinksModel();
    	$list = LinksModel::paginate(5);
    	$this->assign('list',$list);
        return $this->fetch();
    }

    public function add()
    {
    	if(request()->isPost()){
    		$data = [
    			'linkname'=>input('linkname'),
                'desc'=>input('desc'),
    			'linkurl'=>input('linkurl')
    		];
    		$validate = \think\Loader::validate('Links');
    		if(!$validate->scene('add')->check($data)){
    			$this->error($validate->getError());die;
    		}
    		if(db('links')->insert($data)){
    			return $this->success('友情链接添加成功！','lst');
    		}else{
    			return $this->error('友情链接添加失败！');
    		}
    	}else{
    		return $this->fetch();
    	}   	
    }

    public function edit()
    {
    	$id = input('id');
    	$row = db('links')->find($id);
    	if(request()->isPost()){
    		$data = [
				'id'=>input('id'),
                'desc'=>input('desc'),
				'linkname'=>input('linkname'),
                'linkurl'=>input('linkurl'),
			];
			$validate = \think\Loader::validate('Links');
    		if(!$validate->scene('edit')->check($data)){
			   $this->error($validate->getError()); die;
			}
			$save=db('links')->update($data);
    		if($save !== false){
    			$this->success('友情链接修改成功！','lst');
    		}else{
    			$this->error('友情链接修改失败！');
    		}
    		return;
    	}
    	$this->assign('row',$row);
    	return $this->fetch();
    }

    public function del(){
    	$id = input('id');
		if(db('links')->delete($id)){
			$this->success('友情链接删除成功！','lst');
		}else{
			$this->error('友情链接删除失败！');
		}
    }


}
