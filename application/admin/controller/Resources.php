<?php
namespace app\admin\controller;
use app\admin\model\Resources as ResourcesModel;
use app\admin\controller\Base;
class Resources extends Base
{
	
    public function lst()
    {
    	$model= new ResourcesModel();
    	$list = ResourcesModel::paginate(5);
    	$this->assign('list',$list);
        return $this->fetch();
    }

    public function add()
    {
    	if(request()->isPost()){
    		$data = [
    			'resname'=>input('resname'),
    			'resadd'=>input('resadd'),
                'resdesc'=>input('resdesc'),
    		];
            $files = request()->file('resimg');
            $arr = array();
            foreach($files as $k => $file){
                $info = $file->move(ROOT_PATH . 'public' . DS . 'static/uploads');
                $arr[]='/uploads/'.$info->getSaveName(); 
            }
    		//dump($data);dump($arr);die;
            $data['resimg'] = implode(',',$arr);
    		$validate = \think\Loader::validate('resources');
    		if(!$validate->scene('add')->check($data)){
    			$this->error($validate->getError());die;
    		}
    		if(db('resources')->insert($data)){
    			return $this->success('资源分享添加成功！','lst');
    		}else{
    			return $this->error('资源分享添加失败！');
    		}
    	}else{
    		return $this->fetch();
    	}   	
    }

    public function edit()
    {
    	$id = input('id');
    	$row = db('resources')->find($id);
    	if(request()->isPost()){
    		$data = [
                'id'=>input('id'),
                'resname'=>input('resname'),
                'resadd'=>input('resadd'),
                'resdesc'=>input('resdesc'),
            ];
			if($_FILES['resimg']){
    			$files = request()->file('resimg');
                $arr = array();
                foreach($files as $k => $file){
                    $info = $file->move(ROOT_PATH . 'public' . DS . 'static/uploads');
                    $arr[]='/uploads/'.$info->getSaveName(); 
                }
                //dump($data);dump($arr);die;
                $data['resimg'] = implode(',',$arr);
    		}
			$validate = \think\Loader::validate('resources');
    		if(!$validate->scene('edit')->check($data)){
			   $this->error($validate->getError()); die;
			}
			$save=db('resources')->update($data);
    		if($save !== false){
    			$this->success('资源分享编辑成功！','lst');
    		}else{
    			$this->error('资源分享编辑失败！');
    		}
    		return;
    	}
        $imgarr = explode(',',$row['resimg']);
        $this->assign('imgarr',$imgarr);
    	$this->assign('row',$row);
    	return $this->fetch();
    }

    public function del(){
    	$id = input('id');
		if(db('resources')->delete($id)){
			$this->success('资源分享删除成功！','lst');
		}else{
			$this->error('资源分享删除失败！');
		}
    }


}
