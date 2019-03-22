<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends MY_Controller {

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
        $this->load->model('Complaint_model','complaint');
        $this->load->model('System_model','system');
    }
    public function index($page=0)//账号充值
	{
        $db =$this -> getServerInfo();
        $db['page'] = isset($_GET['page']) ? $_GET['page'] : 0;
        $start = $db['page'] * 10;
        $condition = '';
        $condition .= !empty($_GET['Category1ID']) ? ' AND type.id = ' . $_GET['Category1ID'] : '';
        $condition .= !empty($_GET['Category2ID']) ? ' AND question.id = ' . $_GET['Category2ID'] : '';
        $condition .= !empty($_GET['TaskID']) ? ' AND ut.tasksn like "' . $_GET['TaskID'] . '"' : '';
        $condition .= !empty($_GET['PlatformOrderNumber']) ? ' AND ut.ordersn like "' . $_GET['PlatformOrderNumber'] . '"' : '';
        $id = $this->session->userdata('sellerid');
        $db['type'] = $this->complaint->getAll();
        $sql = 'SELECT s.*, type.typename as type, question.typename as question FROM zxjy_schedual as s
                LEFT JOIN zxjy_schedualtype as type on type.id = s.typeid
                LEFT JOIN zxjy_schedualtype as question on question.id = s.questionid
                LEFT JOIN zxjy_usertask as ut on ut.id = s.usertaskid
               WHERE s.merchantid = ' . $this -> uid . $condition . ' ORDER BY s.addtime desc limit ' . $start . ' , 10';
        $db['list'] = $this -> db -> query($sql) -> result();
        $sql = 'SELECT count(1) as has FROM zxjy_schedual as s
                LEFT JOIN zxjy_schedualtype as type on type.id = s.typeid
                LEFT JOIN zxjy_schedualtype as question on question.id = s.questionid
                LEFT JOIN zxjy_usertask as ut on ut.id = s.usertaskid
                WHERE s.merchantid = ' . $this -> uid . $condition;
        $db['count'] = $this -> db -> query($sql) -> first_row() -> has;
        $this->load->view('SchedualList',$db);
	}
	public function reback(){
	    $key=@$_GET['key']==''?0:@$_GET['key'];
	    if($key==0){
	        echo "<script>alert('请不要测试错误的链接，谢谢');history.back();</script>";
	    }else{
	        $db['status'] = 4;
	        $re = $this->complaint->updata($key,$db);
	        if($re){
	            echo "<script>alert('工单撤销成功！');</script>";
	            $this->index();
	        }else{
	            echo "<script>alert('系统现在繁忙中，请稍后重试！');history.back();</script>";
	        }	        
	    }
	}
	public function showdetail(){
	    $key = @$_GET['key']==''?0:@$_GET['key'];
	    if($key==0){
	        echo "<script>alert('请不要测试错误链接，谢谢');history.back();</script>";
	    }else{
    	    $id = $this->session->userdata('sellerid');
    	    $db = $this -> getServerInfo();
	        $db['cominfo'] = $this->complaint->getInfo($key);
	       // var_dump($db['cominfo']);
	        if($db['cominfo'] != null){
                $db['type'] = $this->complaint->getAll();
                $db['list'] = $this->complaint->getTalkList($key);
	            $this->load->view('GetSchedualDetail',$db);
	        }else{
	            echo "<script>alert('您要查看的数据不见了，请刷新页面后重新查看。');history.back();</script>";
	        }
	    }	    
	}
	public function sendone(){
	    $db['schedualid'] = $_POST['WorkOrderID'];
	    $db['content'] = $_POST['Answer'];
	    $db['sellerid'] = $_POST['sellerid'];
	    
	    $files = $_FILES['multiple'];
	    $arr = array();
	    //var_dump(empty($_FILES['multiple']));
	    if($files['error'][0] == 0){
	        $saveway = "./uploads/".@date('Y').'/'.@date('m').'/';
	        if(!file_exists("./uploads/".@date('Y').'/'.@date('m'))){
	            mkdir("./uploads/".@date('Y').'/'.@date('m'),0777,true);
	        }
	        //$files=array_filter($files,'check');
	        // $array = array_filter($_FILES['inputimage']['name'],'check');
	         
	        $n=0;
	        $m=0;
	        foreach($_FILES['multiple']['tmp_name'] as $k=>$v){
	            if( ($_FILES['multiple']['type'][$k]=="image/gif") || ($_FILES['multiple']['type'][$k]=="image/jpeg") || ($_FILES['multiple']['type'][$k]=="image/png")   ){
	                if($_FILES['multiple']['type'][$k] < 2048000){
	                    if(is_uploaded_file($_FILES['multiple']['tmp_name'][$k])){
	                        $oldname = explode('.',$_FILES['multiple']['name'][$k]);
	                        $savename = uniqid().$n++.'.'.$oldname[1];
	                        if(move_uploaded_file($_FILES['multiple']['tmp_name'][$k],$saveway.$savename)){
	                            $arr[$m++] = site_url().$saveway.$savename;
	                            //echo $saveway.$savename;
	                             
	                        }
	                    }
	                }else{
	                    echo "<script>alert('上传的文件超出限制大小！(单张图片文件大小不大于2M)');history.back();</script>";
	                    exit;
	                }
	            }else{
	                echo "<script>alert('请上传文件格式为 gif/png/jpg 的图片。否则无法保存！');history.back();</script>";
	                exit;
	            }
	        }
	    }
	    $db['contentimg']= serialize($arr);
	    $db['addtime'] = time();
	    $db['status'] =0;
	    $re = $this->complaint->addTalk($db);
	    if($re){
	        echo "<script>alert('信息提交成功！');</script>";
	        echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=./showdetail.html?key=".$db['schedualid']."\" >";
	    }else{
	        echo "<script>alert('系统现在正在繁忙中，请稍后重试！');history.back();</script>";
	    }
	}
	
}
