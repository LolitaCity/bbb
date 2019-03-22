<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

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
        $this->memberlogin = true;
        parent::__construct();
        $this->load->model('User_model','user');
        $this->load->model('Sys_model','sys');
        $this->load->model('System_model','system');
        $this->load->model('Article_model','article');
        $this->load->model('Blindwangwang_model','blind');
        $this->load->model('Shop_model','shop');
        $this->load->model('Product_model','pro');
    }
	public function index()
	{	    
	    $id = $this->session->userdata('sellerid');
	    $db['info'] = $this->user->getInfo($id);
	    $db['showcontent'] =1 ;
	    $db['infocount'] = $this->shop->getcount($id);
	    $db['procount'] = $this->pro->getListPro($id,'all','','');
	    $db['service1'] = $this->system->getInfo(87);
	    $db['service2'] = $this->system->getInfo(88);
		$this->load->view('index',$db);
	}
	public function showinfo(){    
	    $db['info']=$this->article->getinfo(48);
	    $db['service1'] = $this->system->getInfo(87);
	    $db['service2'] = $this->system->getInfo(88);
	    $this->load->view('GetContentIndex',$db);
	}
	public function changesession($session){
	    if($session==0){
	       $this->session->set_userdata('sellershowcontent','1');
	    }else{
	       $this->session->set_userdata('sellershowcontent','0');
	    }
	}
	public function changeStatus(){
	    $id  = $this->session->userdata('sellerid');
        $info = $this->user->getInfo($id);
	    if($info->ShowStatus==0){
            $db['ShowStatus'] = 1;
        }else{
	        $db['ShowStatus'] = 0;
        }
        $re = $this->user->Updata($id,$db);
	    $msg = '';
	    $msg['staticinfo'] = $db['ShowStatus'];
	    if($re){
            $msg['status'] = true;
            $msg['info'] = '状态改变成功！';
        }else{
	        $msg['status'] = false;
	        $msg['info'] = '系统现在繁忙中，请稍后重试！';
        }
        echo  json_encode($msg);
    }
}
