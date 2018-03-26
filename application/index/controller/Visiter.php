<?php
namespace app\index\controller;
use app\index\controller\Base;
use \think\Session;
class Visiter extends Base
{
    public function index(){
    	if(request()->isPost()){
    		$data = [
    			'username'=>input('username'),
    			'usermail'=>input('usermail'),
    			'userpass'=>md5(input('password'))
    		];
    		$validate = \think\Loader::validate('contact');
    		if(!$validate->scene('add')->check($data)){
    			$this->error($validate->getError());die;
    		}
    		if(db('contact')->insert($data)){
                $userid = db('contact')->getLastInsID();
                session('user.id',$userid);
                session('user.name',$data['username']);
    			return $this->success('注册成功！','index/index');
    		}else{
    			return $this->error('注册失败，请重新注册！');
    		}
    	}else{
    		return $this->fetch();
    	} 
    }
		
    public function login(){
    	$data=[
    		'username'=>input('user'),
    		'userpass'=>input('pass')
    	];
    	$user=db('contact')->where('username','=',$data['username'])->find();
    	if(!$user){
    		return $this->error('用户名不存在！','index/index');
    	}else{
    		if($user['userpass'] == md5($data['userpass'])){
                session('user.id',$user['id']);
				session('user.name',$user['username']);
				return $this->success('登录成功！','index/index');
			}else{
				return $this->error('密码错误！','index/index');
			}
    	}
    }

    public function logout(){
    	session(null);
        $this->success('退出成功！','index/index');
    }




}