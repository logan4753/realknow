<?php
namespace app\admin\controller;
use app\admin\model\Comments as CommentsModel;
use app\admin\controller\Base;
class Comments extends Base
{
	
    public function lst()
    {
    	$model= new CommentsModel();
    	$list = CommentsModel::paginate(10);
    	$this->assign('list',$list);
        return $this->fetch();
    }

    public function del(){
        $id = input('id');
        if(db('comments')->delete($id)){
            $this->success('留言删除成功！','lst');
        }else{
            $this->error('留言删除失败！');
        }
    }

    public function reply()
    {
        $id = input('id');
        $row = db('comments')->find($id);
        if(request()->isPost()){
            $data = [
                'id'=>input('id'),
                'reply'=>input('reply'),
                'replytime'=>time()
            ];
            if(db('comments')->update($data)){
                return $this->success('留言回复成功！','lst');
            }else{
                return $this->error('留言回复失败！');
            }
        }
        $this->assign('row',$row);
        return $this->fetch();
    }

}
