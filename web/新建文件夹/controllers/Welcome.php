<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
    public function __construct(){
        parent::__construct();
        $this->load->model('User_model','user');
        $this->load->model('Sys_model','sys');
        $this->load->model('Article_model','article');
        $this->load->model('System_model','system');
    }   
	public function index()
	{
	    $db['showcontent'] =0 ;
	    $db['service1'] = $this->system->getInfo(87);
	    $db['service2'] = $this->system->getInfo(88);
		$this->load->view('login',$db);
	}
	public function err(){
	    $this->load->view('errors/404.htm');
	}
	public function loginout(){
	    $this->session->unset_userdata('sellername');
	    $this->session->unset_userdata('sellernick');
	    $this->session->unset_userdata('sellerid');
	    $this->session->unset_userdata('sellershowcontent');
	    //$this->session->unset_userdata('language');
	    redirect('');
	    exit;
	}
	public function regist(){//注册
	    $key = @$_GET['key'];
        if($key == '' ){
            echo "<script>alert('错误的网址链接！');window.close();</script>";
        }else{
            $db['id'] = substr($key,0,strrpos($key,'@'));
            $db['key'] = str_replace('@','',strstr($key,"@"));
            $userinfo = $this->user->UseID($db['id']);
            if($userinfo != null){
                $this->load->view('regist',$db);
            }else{
                echo "<script>alert('请不要访问错误链接！');window.close();</script>";
            }

        }
	}
	public function registDB(){
	    $db['Phon']=$db['UserName']=@$_POST['phonenum'];
	    $password=@$_POST['pwd'];
	    $db['PassWord']=md5($password);
	    $db['QQToken']=@$_POST['qq'];
        $db['Email']=@$_POST['email'];
        $db['parentid']=@$_POST['id'];
	    $db['RegIp']=$this->sys->GetIp();
	    $db['ispromoter'] = 0;
        $db['ShowStatus'] = 1;
	    $db['Opend']=1;
	    $db['maxtask']=10;
	    $db['bond']=1000;
	    $db['parentid']=@$_POST['idkey'];
	    $list=$this->user->getAll();
	    $n=0;
	    foreach($list as $vl){
	        if($vl->Username == $db['UserName']){
    	        $n=1;
	        }
	    }
	    if($n==0){
    	    $db['RegTime']=@strtotime(@date('Y-m-d H:i:s'));;
    	    $re=$this->user->add($db);
    	    $show='';
    	    if($re){
    	        $show['status']=true;
    	        $show['content']='注册成功！'.$db['parentid'];
    	    }else{
    	        $show['status']=false;
    	        $show['content']='系统繁忙中，请稍后重试！'.$db['parentid'];
    	    }
	    }else{
    	    $show['status']=false;
    	    $show['content']='该手机已经注册过了，请使用其他的手机号码注册'.$db['parentid'];
	    }
	    echo json_encode($show);
	}
	public function register(){// 找回密码
            $this->load->view('forgetPassword');
	}
	public function registerDB(){
	   $UserName = @$_POST['username'];
	   $Email = @$_POST['email'];
	   $re = $this->user->userthis($UserName,$Email);
	   $data='';
 	   if($re!=null){
	      if( $this->SendEmail($re->id ,$re->Email, @strtotime(@date("Y-m-d H:i:s",@strtotime("+1 day"))) )){
	           $data['status']=false;
	           $data['msg']='系统现在正在繁忙中，请稍后重试！邮件';
	       }else{
	           $db['forget']=1;
	           $reedit = $this->user->updata($re->id,$db);
	           if($reedit){
	               $data['status'] = true;
	               $data['msg'] = '申请提交成功！请注意查收邮件！注：邮件在24小时之内有效（过期无效）并只能修改一次密码，请及时查收邮件以及修改您的密码';
	           }else{
	               $data['status'] = false;
	               $data['msg'] = '系统繁忙中，请稍后重试！';
	           }
	       }
	   }else{
	       $data['status']=false;
	       $data['msg']='登录名跟邮箱不匹配！';
	   } 
	   echo json_encode($data);
	}
	public function SendEmail($username,$email,$time){
//	public function SendEmail(){
	    //$username=83;$email='532587280@qq.com';$time=strtotime(date("Y-m-d H:i:s",strtotime("+1 day")));
    
	    
	    $this->load->library('email');
	    $config['protocol'] = 'smtp';
	    $config['smtp_host'] = 'smtp.163.com';
	    $config['smtp_user'] = 'our_two_senior@163.com';
	    $config['smtp_pass'] = 'senior123';//如果是qq邮箱，这里是独立密码
	    $config['smtp_port'] = '25';
	    $config['smtp_timeout'] = '5';
	    $config['newline'] = "\r\n";
	    $config['crlf'] = "\r\n";
	    $config['mailtype'] ='html';
	    $this->email->initialize($config);
	     
	    $this->email->from('our_two_senior@163.com');
	    $this->email->to($email);
	    $this->email->subject('商家登录密码找回');
	    $this->email->message('<p>该邮件24小时之内有效，并且只能修改一次密码。（请不要回复该邮件！谢谢）</p><a target="_blank" href="'.site_url('welcome/setforget/'.$username.'/'.$time).'">点击找回密码</a>');
	    $this->email->send();
	     if($this->email->send()){
	         return true;
	     }else{
	         return false;
	     }
	   // echo $this->email->print_debugger();
	    
	   // ECHO  $this->email->send();
	}
	public function setforget($useid=0,$time=0){
	    $thistime = @strtotime(@date('Y-m-d H:i:s'));
	    if($time > $thistime){
    	    if($useid==0){
    	        echo "<script>alert('您需要访问的网址出错了。');window.close()</script>";
    	    }else{
    	        $db['user']=$user= $this->user->getInfo($useid);
    	        if($user != null){
    	            if($user->forget == 1){
    	                $this->load->view('reset',$db);
    	            }else{
    	                echo "<script>alert('连接地址已经失效，若需重置密码请重新申请找回！谢谢您的合作！');window.close()</script>";
    	            }
    	        }else{
    	            echo "<script>alert('您需要访问的网址出错了。');window.close()</script>";
    	        }
    	    }
	    }else{
	        echo "<script>alert('连接地址已经失效，若需重置密码，请重新申请！谢谢您的合作！');window.close()</script>";
	    }
	}
	public function resetDB(){
	    $id = $_POST['userid'];
	    $password = $_POST['password'];
	    $db['PassWord'] = md5($password);
	    $db['forget']  = 0;
	    $re = $this->user->updata($id,$db);
	    $data='';
	    if($re){
	        $data['status']= true;
	        $data['msg'] ='密码重置成功！';
	    }else{
	        $data['status'] =false;
	        $data['msg'] = '密码重置失败了，请稍后尝试！';
	    }
	    echo json_encode($data);
	}
	public function login(){//登录
	    $username = $_POST['Name']==''?'':$_POST['Name'];
	    $password = $_POST['Password']==''?'':$_POST['Password'];
 	    $info = $this->user->userlogin($username,md5($password));
	    if($info != null){
	        $db['LoginIp'] = $this->sys->GetIp();
            $db['LoginTime']=@strtotime(@date('Y-m-d H:i:s'));
	        $re = $this->user->updata($info->id,$db);
            if($re){
    	        $this->session->set_userdata('sellername',$info->Username);
    	        $this->session->set_userdata('sellernick',$info->NickName);
    	        $this->session->set_userdata('sellerid',$info->id);
	            echo true;
            }else{
                echo false;
            }
	    }else{
	        echo false;
	    } 
	}
	
	
	//定时任务执行方法
	public function contal(){
	    // 判断转账情况，是否需要把某部分商家的账号冻结
	    $this->load->model('Transfercash_model','transfer');
	    $time = @strtotime(@date("Y-m-d",@strtotime("-1 day")));
	    $list = $this->transfer->TimeOut($time);
	    $arr=array();
	    foreach($list as $key=>$vl){
	        $arr[$key]=$vl->merchantid;
	    }
	    $db['Status']=1;
	    $arr=array_unique($arr);
	    if(count($arr) != 0 ){
    	    $this->user->updataArr($arr,$db);
    	    //var_dump(array_unique($arr));
	    }
	    
	    
	    //判断是否付清佣金
	    $this->load->model('Usertask_model','usertask');
	    $taskstats = $this->usertask->getAllToday();
	    $arrtask=array();
	    foreach($taskstats as $key=>$val){
	        $arrtask[$key]=$val->merchantid;
	    }
	    $dsb['ShowStatus']=1;
	    $arrtask=array_unique($arrtask);
	    if(count($arrtask) != 0){
	       $this->user->updataArr($arrtask,$dsb);
	    }
	}
}
