<?php
namespace app\admin\controller;
use app\admin\model\News as NewsModel;
use app\admin\controller\Base;
class News extends Base
{
	
    public function lst()
    {
    	$model= new NewsModel();
    	$list = NewsModel::paginate(5);
    	$this->assign('list',$list);
        return $this->fetch();
    }

    public function add()
    {
    	if(request()->isPost()){
    		$data = [
    			'title'=>input('title'),
    			'content'=>input('content'),
                'desc'=>input('desc'),
    		];
    		if($_FILES['image']['tmp_name']){
    			$file = request()->file('image');
    			$info = $file->move(ROOT_PATH . 'public' . DS . 'static/uploads');
    			$data['image']='/uploads/'.$info->getSaveName();
    		}
    		//dump($data);die;
    		$validate = \think\Loader::validate('News');
    		if(!$validate->scene('add')->check($data)){
    			$this->error($validate->getError());die;
    		}
    		if(db('news')->insert($data)){
    			return $this->success('科技动态添加成功！','lst');
    		}else{
    			return $this->error('科技动态添加失败！');
    		}
    	}else{
    		return $this->fetch();
    	}   	
    }

    public function edit()
    {
    	$id = input('id');
    	$row = db('news')->find($id);
    	if(request()->isPost()){
    		$data = [
                'id'=>input('id'),
                'title'=>input('title'),
                'content'=>input('content'),
                'desc'=>input('desc'),
            ];
            if($_FILES['image']['tmp_name']){
                $file = request()->file('image');
                $info = $file->move(ROOT_PATH . 'public' . DS . 'static/uploads');
                $data['image']='/uploads/'.$info->getSaveName();
            }
            //dump($data);die;
            $validate = \think\Loader::validate('News');
            if(!$validate->scene('edit')->check($data)){
                $this->error($validate->getError());die;
            }
            if(db('news')->update($data)){
                return $this->success('科技动态编辑成功！','lst');
            }else{
                return $this->error('科技动态编辑失败！');
            }
    	}
    	$this->assign('row',$row);
    	return $this->fetch();
    }

    public function del(){
    	$id = input('id');
		if(db('news')->delete($id)){
			$this->success('科技动态删除成功！','lst');
		}else{
			$this->error('科技动态删除失败！');
		}
    }


}
