<?php
namespace app\index\controller;
use app\index\controller\Base;
use phpmailer\PHPMailer; 
use \think\Session;
class Getpass extends Base
{
	public function pass1(){
		return $this->fetch();
	}

	public function pass(){
		$mail=input('mail');
		if(!$mail){
			return $this->error('请填写正确的邮箱！');	
		}else{
			$email = stripslashes(trim($mail));
			$row = db("contact")->where(array("usermail"=>$email))->find();
			if(!$row){
				return ["msg"=>"nomsg"];exit;
			}else{
				$getpasstime = time(); 
			    $token = md5($row['id'].$row['username'].$row['userpass']);//组合验证码 
			    $url = $_SERVER['SERVER_NAME']."/public/index/getpass/pass3.html?email=".$email."&token=".$token;//构造URL 
			    $time = date('Y-m-d H:i');
			    $result = $this->sendmail($time,$email,$url);   
			    if($result==1){//邮件发送成功
			        //更新数据发送时间 
			        $data = [
						'id'=>$row['id'],
						'getpasstime'=>$getpasstime,
					];
			        db('contact')->update($data); 
			        session('getpass.id',$row['id']);
    				Session::set('getpass.email',$email);
			        return ["msg"=>1];exit;
			    }else{ 
			        return ["msg"=>$result];exit;
			    } 
			}
		}
	}

	public function pass2(){
		$theemail = Session::get('getpass.email');
		$this->assign("email",$theemail);
		return $this->fetch();
	}

	public function pass3(){
		$token = stripslashes(trim($_GET['token'])); 
		$email = stripslashes(trim($_GET['email']));
		$row = db("contact")->where(array("usermail"=>$email))->find();
		if(!$row){ 
			$msg =  '错误的链接！'; 
			$this->error('错误的链接！','index/index');
		}else{ 
		    $mt = md5($row['id'].$row['username'].$row['userpass']); 
		    if($mt!==$token){ 
		    	$msg =  '无效的链接';
		    	$this->error('无效的链接！','index/index');
		    }else{ 
		        if(time()-$row['getpasstime']>24*60*60){ 
		            $msg = '该链接已过期！'; 
		            $this->error('该链接已失效！','index/index');
		        }else{ 
		            //重置密码... 
		            $this->assign("email",$email);
		            return $this->fetch();
		        }
		    }    
		}		
	}

	public function sendmail($time,$email,$url){ 
	    $mail = new PHPMailer();
	    $mail->isSMTP();// 使用SMTP服务
	    $mail->CharSet = "utf8";// 编码格式为utf8，不设置编码的话，中文会出现乱码  
        $mail->Host = "smtp.163.com";// 发送方的SMTP服务器地址  
        $mail->SMTPAuth = true;// 是否使用身份验证
        $mail->Username = "logan47537@163.com";//发送方的163邮箱用户名，就是你申请163的SMTP服务使用的163邮箱
        $mail->Password = "wlg19930530w";//发送方的邮箱密码，注意用163邮箱这里填写的是“客户端授权密码”！
	    $mail->SMTPSecure = 'ssl';//设置使用ssl加密方式登录鉴权
	    $mail->Port = 994;// 163邮箱的ssl协议方式端口号是465/994
	    $mail->setFrom("logan47537@163.com","Mailer");// 设置发件人信息，如邮件格式说明中的发件人，这里会显示为Mailer(xxxx@163.com），Mailer是当做名字显示
	    $mail->addAddress($email,'Wang');//设置收件人信息，如邮件格式说明的收件人，这里显示Liang(yyyy@163.com)
	    $mail->addReplyTo("logan47537@163.com","Reply");// 设置回复人信息，指的是收件人收到邮件，回复邮件将发送到的邮箱地址
	    $mail->Subject = "甄博知 - 找回密码";// 邮件标题  
        $data = $mail->Body = "亲爱的".$email."：
        您在".$time."提交了找回密码请求。请点击下面的链接重置密码
（按钮24小时内有效）。
		".$url."
		如果您的邮箱不支持链接点击，请将以上链接地址拷贝到你的浏览器地址栏中。
		如果您没有提交找回密码请求，请忽略此邮件。";// 邮件正文
	    $status = $mail->send();
	    return $status; 
	} 

	public function newpassword(){
		$row = db("contact")->where(array("usermail"=>input('email')))->find();
		$result = db('contact')->where("id",$row['id'])->setField('userpass', md5(input('password')));
		if($result){
			return $this->success('密码修改成功！','visiter/index');
		}else{
			return $this->error('密码修改失败！','getpass/pass1');
		}
	}

}