<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class User extends MY_Controller
{

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
		$uid = $this->session->userdata('sellerid');
		$cache_name= 'update_money_' . $this -> uid;
		if (!RedisCache::has($cache_name))  //每半小时更新一次用户表money字段
        {
            $sql = "SELECT  SUM(increase) as usermoney FROM zxjy_cashlog WHERE userid='{$uid}'";
            $dbRs =  $this->db->query($sql)->row();
            $usermoney = $dbRs->usermoney;
            if($usermoney)
            {
                $sql  ="UPDATE zxjy_user SET Money ={$usermoney} WHERE id='{$uid}'" ;
                $dbRs =  $this->db->query($sql) ;
            }
            RedisCache::del('server_info_' . $this -> uid);
            RedisCache::set($cache_name, 1, 60 * 60 * 30);  //半小时有效期期
        }
		$db = $this -> getServerInfo();
		$sql = "SELECT TO_DAYS(FROM_UNIXTIME(api_expiration_time)) - TO_DAYS(NOW()) as residue, FROM_UNIXTIME(api_expiration_time) as exp_time FROM zxjy_shop WHERE userid = {$this -> uid}";
        $db['shop_helper_state'] = $this -> db -> query($sql) -> row();
	    $db['infocount'] = $this->shop->getcount($uid);
	    $db['procount'] = $this->pro->getListPro($uid,'all','','');
	    $sql = 'SELECT COUNT(1) as num FROM zxjy_shop WHERE is_mark = 1 AND (mark_comment = "" OR mark_comment IS NULL) AND userid = ' . $this -> uid;
	    $db['has_mark_comment_null'] = $this -> db -> query($sql) -> row() -> num;
//        var_dump(RedisCache::has('test'));
//	    var_dump($db);
//	    exit(0);
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
        $sql = 'update zxjy_user  set ShowStatus = !ShowStatus where id = ' . $id;
        $this -> db -> query($sql);
        if ($this->db -> affected_rows())
        {
            RedisCache::del('server_info_' . $id);
            show(1, '更新该任务状态成功');
        }
        else
            show(0, '更新该任务状态失败，请稍后再试');
//        $info = $this->user->getInfo($id);
//	    if($info->ShowStatus==0){
//            $db['ShowStatus'] = 1;
//        }else{
//	        $db['ShowStatus'] = 0;
//        }
//        $re = $this->user->Updata($id,$db);
//	    $msg = '';
//	    $msg['staticinfo'] = $db['ShowStatus'];
//	    if($re){
//	        RedisCache::del('server_info_' . $id);
//            $msg['status'] = true;
//            $msg['info'] = '状态改变成功！';
//        }else{
//	        $msg['status'] = false;
//	        $msg['info'] = '系统现在繁忙中，请稍后重试！';
//        }
//        echo  json_encode($msg);
    }
	
	public function survey()
    {
        $sql = "SELECT COUNT(1) as has FROM zxjy_1111survey WHERE uid = {$this -> uid}";
        $has = $this -> db -> query($sql) -> first_row() ->  has;
        !$has ? $this -> load -> view('1111survey') : exit('您已经提交过了，谢谢您的参与');
    }

    public function submit_survey()
    {
        $post = $_POST['estimate'];
        $insert_data = [
            'uid' => $this -> uid,
            'estimate_data' => serialize($post),
            'addtime' => time(),
        ];
        $this -> db -> insert('zxjy_1111survey', $insert_data) ? show(1, '提交成功') : show(0, '提交失败，请重新提交');
    }
}
