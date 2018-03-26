<?php
namespace app\Admin\controller;
use think\Controller;
use app\admin\model\Admin;
use \think\Session;
class Login extends Controller
{
    public function index()
    {
        if(request()->isPost()){
            $admin=new Admin();
            $data=input('post.');
            $num=$admin->login($data);
            if($num==3){
                session('username',$data['username']);
                $this->success('登录成功，正在为您跳转...','index/index');
            }elseif($num==4){
                $this->error('验证码错误');
            }
            else{
                $this->error('用户名或者密码错误');
            }

        }
        return $this->fetch('login');
    }

    public function logout(){
    	session(null);
        $this->success('退出成功！','Login/index');
    }



}
