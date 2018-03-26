<?php
namespace app\admin\controller;
use app\admin\model\Experiences as ExperiencesModel;
use app\admin\controller\Base;
class Experiences extends Base
{
	
    public function lst()
    {
    	$list = ExperiencesModel::paginate(5);
    	$this->assign('list',$list);
        return $this->fetch();
    }

    public function add()
    {
    	if(request()->isPost()){
    		$data = [
    			'title'=>input('title'),
    			'author'=>input('author'),
                'cateid'=>input('cateid'),
                'desc'=>input('desc'),
                'content'=>input('content'),
                'status'=>input('status'),
                'time'=>time()
    		];
    		if($_FILES['img']['tmp_name']){
    			$file = request()->file('img');
    			$info = $file->move(ROOT_PATH . 'public' . DS . 'static/uploads');
    			$data['img']='/uploads/'.$info->getSaveName();
    		}
    		//dump($data);die;
    		$validate = \think\Loader::validate('Experiences');
    		if(!$validate->scene('add')->check($data)){
    			$this->error($validate->getError());die;
    		}
    		if(db('experiences')->insert($data)){
    			return $this->success('心得添加成功！','lst');
    		}else{
    			return $this->error('心得添加失败！');
    		}
    	}else{
            $cates = db('cates')->select();
            $this->assign('cates',$cates);
    		return $this->fetch();
    	}   	
    }

    public function edit()
    {
    	$id = input('id');
    	$row = db('experiences')->find($id);
    	if(request()->isPost()){
    		$data = [
                'id'=>input("id"),
                'title'=>input('title'),
                'author'=>input('author'),
                'cateid'=>input('cateid'),
                'desc'=>input('desc'),
                'content'=>input('content'),
                'status'=>input('status'),
                'time'=>time()
            ];
            if($_FILES['img']['tmp_name']){
                $file = request()->file('img');
                $info = $file->move(ROOT_PATH . 'public' . DS . 'static/uploads');
                $data['img']='/uploads/'.$info->getSaveName();
            }
            //dump($data);die;
            $validate = \think\Loader::validate('Experiences');
            if(!$validate->scene('edit')->check($data)){
                $this->error($validate->getError());die;
            }
            if(db('experiences')->update($data)){
                return $this->success('心得编辑成功！','lst');
            }else{
                return $this->error('心得编辑失败！');
            }
    	}
        $cates = db('cates')->select();
        $this->assign('cates',$cates);
    	$this->assign('row',$row);
    	return $this->fetch();
    }

    public function del(){
    	$id = input('id');
		if(db('experiences')->delete($id)){
			$this->success('心得删除成功！','lst');
		}else{
			$this->error('心得删除失败！');
		}
    }


}
