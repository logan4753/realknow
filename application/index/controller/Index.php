<?php
namespace app\index\controller;
use app\index\controller\Base;
use \think\Session;
class Index extends Base
{
    public function index()
    {
    	$news=db('news')->order('id desc')->limit(5)->select();
    	$this->assign('news',$news);
    	$shows=db('experiences')->order('id desc')->limit(5)->select();
    	$this->assign('shows',$shows);
    	$nshow=db('experiences')->where(array("status"=>"1"))->order('id desc')->limit(5)->select();
    	$this->assign('nshow',$nshow);
    	$links = db('links')->select();
    	$this->assign('links',$links);
    	$resources=db('resources')->order('id desc')->limit(5)->select();
    	$this->assign('resources',$resources);
        $theuser = $this->getuser();
        $this->assign('theuser',$theuser);
        return $this->fetch();
    }

    public function aboutme()
    {
        $theuser = $this->getuser();
        $this->assign('theuser',$theuser);
        return $this->fetch();
    }

    public function getuser(){
        $theuser = Session::get('user.name');
        return $theuser;
    }

    public function newlist()
    {
        $theuser = $this->getuser();
        $this->assign('theuser',$theuser);
    	$news=db('news')->order('id desc')->paginate(5);
    	$this->assign('news',$news);
    	$shows=db('experiences')->order('id desc')->limit(5)->select();
    	$this->assign('shows',$shows);
        return $this->fetch();
    }

    public function news()
    { 
        $theuser = $this->getuser();
        $this->assign('theuser',$theuser);
        $id=input('id');
		$row = db('news')->find($id);
    	$this->assign('row',$row);
    	$news=db('news')->order('id desc')->limit(5)->select();
    	$this->assign('news',$news);
    	$shows=db('experiences')->order('id desc')->limit(5)->select();
    	$this->assign('shows',$shows);
    	$prev= db('news')->where('id','<',$id)->order('id desc')->limit(1)->field('id,title')->find();
        $next= db('news')->where('id','>',$id)->order('id asc')->limit(1)->field('id,title')->find();  
        $this->assign('prev',$prev);  
        $this->assign('next',$next); 
        return $this->fetch();
    }

    public function moodlist()
    {
        $theuser = $this->getuser();
        $this->assign('theuser',$theuser);
    	$records=db('records')->order('id desc')->paginate(5);
    	$this->assign('records',$records);
        return $this->fetch();
    }

    public function share()
    {
        $theuser = $this->getuser();
        $this->assign('theuser',$theuser);
    	$resources=db('resources')->order('id desc')->paginate(5);
    	$this->assign('resources',$resources);
    	$news=db('news')->order('id desc')->limit(5)->select();
    	$this->assign('news',$news);
    	$shows=db('experiences')->order('id desc')->limit(5)->select();
    	$this->assign('shows',$shows);
        return $this->fetch();
    }

    public function knowledge()
    {
        $theuser = $this->getuser();
        $this->assign('theuser',$theuser);
    	$cateid=input('cateid');
    	if(!$cateid){
    		$where=array();
    	}else{
    		$where=array("cateid"=>"$cateid");
    	}
    	$knows=db('experiences')->where($where)->order('id desc')->paginate(5);
    	$this->assign('knows',$knows);
    	$news=db('news')->order('id desc')->limit(5)->select();
    	$this->assign('news',$news);
    	$shows=db('experiences')->order('id desc')->limit(5)->select();
    	$this->assign('shows',$shows);
    	$cates = db('cates')->select();
    	$cate = array();
    	foreach($cates as $k => $v){
    		$cate[$v['id']] = $v;
    	}
    	$this->assign('cates',$cate);
        return $this->fetch();
    }

    public function knows(){
        $theuser = $this->getuser();
        $this->assign('theuser',$theuser);
    	$id = input('id');
    	$row=db("experiences")->find($id);
    	db('experiences')->where('id','=',$id)->setInc('click');
    	$this->assign('row',$row);
    	$news=db('news')->order('id desc')->limit(5)->select();
    	$this->assign('news',$news);
    	$shows=db('experiences')->order('id desc')->limit(5)->select();
    	$this->assign('shows',$shows);
    	$prev= db('experiences')->where('id','<',$id)->order('id desc')->limit(1)->field('id,title')->find();
        $next= db('experiences')->where('id','>',$id)->order('id asc')->limit(1)->field('id,title')->find();  
        $this->assign('prev',$prev);  
        $this->assign('next',$next);
        return $this->fetch();
    }

    public function comments()
    {        
        $theuser = $this->getuser();
        $this->assign('theuser',$theuser);
        if(request()->isPost()){
            $status = Session::has('user');
            if(!$status){
                $this->redirect('visiter/index'); 
            }else{
                $data = [
                    'content'=>input('content'),
                    'contactid'=>Session::get('user.id'),
                    'time'=>time()
                ];
                if(db('comments')->insert($data)){
                    return $this->success('留言成功！','index');
                }else{
                    return $this->error('留言失败！');
                }
            }
        }else{
            $lists = db('comments')->order('id desc')->select();
            foreach($lists as $k => $v){
                $user = db('contact')->where(array('id'=>$v['contactid']))->field('username')->find();
                $lists[$k]['contact'] = $user['username'];
            }
            $this->assign('lists',$lists);
            return $this->fetch(); 
        }                
    }


}
