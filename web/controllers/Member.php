<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Member extends MY_Controller {

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
        $this->load->model('Shop_model','shop');
        $this->load->model('Product_model','product');
        $this->load->model('Article_model','article');
        $this->load->model('Task_model','task');
        $this->load->model('System_model','system');
    }

    public function index()// 基本资料
	{
	    $db = $this -> getServerInfo();
	    $sql = 'select count(1) as sum from zxjy_shop where userid = ' . $this -> uid;
	    $db['shops'] = $this -> cacheSqlQuery('shop_count_', $sql, 60 * 60 * 24 * 30, false, 'first_row') -> sum;  //缓存30天
        $sql = 'SELECT value FROM zxjy_system WHERE id = 101';
        $db['service_charge_info'] = $this -> cacheSqlQuery('service_charge_info', $sql, 0, true, 'first_row') -> value;
        $this -> load -> view('membase',$db);
	}

	/*
	 * 修改密码页面
	 */
	public function editPWD()
    {
	    $db = $this -> getServerInfo();
	    $this->load->view('EditPwd',$db);
	}

	public function test()
    {
        $Mobile = '13725661523';
        $Msg = 'ces';
        $fp = fopen(BKC_URL . "?ActionTag=Send_ShortMsg&Mobile={$Mobile}&Msg={$Msg}", 'r');
        $strJson = '';
        while (!feof($fp)) {
            $line = fgets($fp, 1024); // 每读取一行
            $strJson = $strJson . $line;
        }
        fclose($fp);
        if (empty ($strJson) == false) {
            $jsonObject = json_decode($strJson);
            if ($jsonObject->IsOK == true) {
                $this->redirect_message('操作成功', 'success', 1, $this->createUrl('task/taskmanage01'));
            } else {
                $this->redirect_message('操作失败:' . $jsonObject->Description, 'failed', 1, $this->createUrl('task/taskmanage01'));
            }
        }
    }

	/*
	 * 修改密码入库
	 */
	public function editPwdDB()
    {
        $db = $this -> getServerInfo();
        if (!empty($_POST['save_pwd']) && !empty($_POST['passwd']))
        {
            if ($db['info'] -> SafePwd == md5($_POST['save_pwd']))
            {
                if ($this -> user -> updata($this -> uid, ['PassWord' => md5($_POST['passwd'])]))  //登陆成功，清除登陆信息，全站退出
                {
                    $this->session->unset_userdata('sellername');
                    $this->session->unset_userdata('sellernick');
                    $this->session->unset_userdata('sellerid');
                    $this->session->unset_userdata('sellershowcontent');
                    RedisCache::del('server_info_' . $this -> uid);
                    show(1, '修改登陆密码成功，3秒后全站退出');
                }
                else
                    show(0, '数据更新失败，请稍后再试');
            }
            else
                show(0, '身份验证错误，请输入正确的密码');
        }
        else
            show(0, '参数提供错误');
//        if ($db['info'] -> SafePwd == md5($_POST['']))

//	    $check=$_POST['safePwd'];
//	    $id = $this->session->userdata('sellerid');
//	    $info = $this->user->getInfo($id);
//	    $db['service1'] = $this->system->getInfo(87);
//	    $db['service2'] = $this->system->getInfo(88);
//	    $db='';
//	    if($info->SafePwd == md5($check)){
//	        $dbs['PassWord']= md5(@$_POST['newPwd']);
//	        $re=$this -> user -> updata($id, $dbs);
//	        if($re){
//	            $db['status']=true;
//	            $db['info']='登录密码修改成功!';
//	        }else{
//	            $db['status']=false;
//	            $db['info']='系统繁忙中，请稍后重试！';
//	        }
//	    }else{
//	        $db['status']=false;
//	        $db['info']='验证支付密码错误！';
//	    }
//	    echo json_encode($db);
	}

	/*
	 * 修改支付密码
	 */
	public function editSafePwdDB()
    {
        $db = $this -> getServerInfo();
        if (!empty($_POST['save_pwd']) && !empty($_POST['passwd']))
        {
            if ($db['info'] -> PassWord == md5($_POST['save_pwd']))
            {
                if ($this -> user -> updata($this -> uid, ['SafePwd' => md5($_POST['passwd'])]))  //登陆成功，清除用户信息缓存，全站退出
                {
                    RedisCache::del('server_info_' . $this -> uid);
                    show(1, '支付密码修改成功');
                }
                else
                    show(0, '数据更新失败，请稍后再试');
            }
            else
                show(0, '身份验证错误，请输入正确的密码');
        }
        else
            show(0, '参数提供错误');
	}

	/*
	 * 修改绑定的qq
	 */
	public function editQQDB()
    {
        $db = $this -> getServerInfo();
        if (!empty($_POST['save_pwd']) && !empty($_POST['new_qq']))
        {
            if ($db['info'] -> SafePwd == md5($_POST['save_pwd']))
            {
                if ($this -> user -> updata($this -> uid, ['QQToken' => $_POST['new_qq']]))  //登陆成功，清除用户信息缓存，全站退出
                {
                    RedisCache::del('server_info_' . $this -> uid);
                    show(1, '换绑QQ成功');
                }
                else
                    show(0, '数据更新失败，请稍后再试');
            }
            else
                show(0, '身份验证错误，请输入正确的密码');
        }
        else
            show(0, '参数提供错误');
	}

	/*
	 * 修改微信
	 */
	public function editWehat()
    {
        $db = $this -> getServerInfo();
        if (!empty($_POST['save_pwd']) && !empty($_POST['new_wechat']))
        {
            if ($db['info'] -> SafePwd == md5($_POST['save_pwd']))
            {
                if ($this -> user -> updata($this -> uid, ['wechat' => $_POST['new_wechat']]))  //登陆成功，清除用户信息缓存，全站退出
                {
                    RedisCache::del('server_info_' . $this -> uid);
                    show(1, '换绑微信成功');
                }
                else
                    show(0, '数据更新失败，请稍后再试');
            }
            else
                show(0, '身份验证错误，请输入正确的密码');
        }
        else
            show(0, '参数提供错误');
	}

    public function intelligence()// 智能助手
	{	    
	    $id = $this->session->userdata('sellerid');
	    $db['info'] = $this->user->getInfo($id);
	    $db['showcontent'] =1 ;
	    $db['service1'] = $this->system->getInfo(87);
	    $db['service2'] = $this->system->getInfo(88);
		$this->load->view('orderlist',$db);
		//$this->load->view('memhelp',$db);//单页面内容
	}

    public function store()// 店铺管理
	{
	    $db = $this -> getServerInfo();
        $sql = 'select * from zxjy_shop where userid = ' . $this -> uid . ' ORDER BY sid desc';
        //$db['list'] = $this -> cacheSqlQuery('shop_list_', $sql, 60 * 60 * 24 * 30);
        $db['list'] = $this -> db -> query($sql) -> result();
        $sql = 'select count(1) as sum from zxjy_shop where userid = ' . $this -> uid;
        //$db['count'] = $this -> cacheSqlQuery('shop_count_', $sql, 60 * 60 * 24 * 30, false, 'first_row') -> sum;
        $db['count'] = count($db['list']);
		$db['max_num'] = in_array($this-> session -> userdata('sellername'), $this->config->item('BIND3SHOP')) || PLATFORM == 'xkq' ? 3 : 1;
        $this->load->view('shop',$db);

//	    $page=@$_GET['page']==''?0:@$_GET['page'];
//	    $id=$this->session->userdata('sellerid');
//	    $db['info']=$this->user->getInfo($id);
//	    $db['showcontent']=1;
//	    $db['service1'] = $this->system->getInfo(87);
//	    $db['service2'] = $this->system->getInfo(88);
//	    $db['countshop']=$this->shop->getcount($id);
//	    $db['list']=$this->shop->getlist($id,'all',1,4,4*$page);
//	    $db['count']=$this->shop->getcountlist($id,'all');
//	    $db['pageno']=ceil($db['count']/4);
//	    $db['page']=$page;
//		$this->load->view('shop',$db);
	}

	/*
	 * 添加店铺
	 */
    public function addShop()
	{
	    $db = $this -> getServerInfo();
        $this->load->view('addshop', $db);
	}

	/*
	 * 添加店铺信息入库
	 */
	public function addShopDB()
    {
        $sql = 'SELECT COUNT(1) as count FROM zxjy_shop WHERE userid = ' . $this -> uid;
        $max_num = in_array($this-> session -> userdata('sellername'), $this->config->item('BIND3SHOP')) || PLATFORM == 'xkq' ? 3 : 1;
        if (in_array($this-> session -> userdata('sellername'), ['18951252102', '13812343565', '13236338629', '15240305932', '13217658559']) || $this -> db -> query($sql) -> row() -> count < $max_num)
        {
            $file_path = $this -> uploadFile($_FILES['upfile1']);
            $db = [
                'userid' => $_POST['userid'],
                'type' => $_POST['ChildPlatformType'],
                'manager_num' => $_POST['PlatformNoID'],  //掌柜号
                'shopname' => trim($_POST['ShopName']),
                'nature' => $_POST['ShopNature'],  //店铺性质
                'addtime' => time(),
                'addIP' => $this -> sys -> GetIp(),
                'status' => 0,
                'auditing' => 0,
                'images' => $file_path ? unserialize($file_path)[0] : '',  //加[0]的原因，封装的上传函数只识别多数组上传，所以在页面需要‘name=aaa[]’, 这里反序列化之后是个数组，需要取第一个值
            ];
            if (!in_array('', $db, true))  //所有必须参数已填
            {
                $sql = 'SELECT COUNT(1) as sum FROM zxjy_shop WHERE shopname = "' . trim($db['shopname']) . '"';
                if (!$this -> db -> query($sql) -> first_row() -> sum)  //一号一店铺
                {
                    if ($this -> shop -> add($db))
                    {
                        RedisCache::del('shop_list_' . $this -> uid);
                        RedisCache::del('shop_count_' . $this -> uid);
                        show(1, '店铺添加成功, 等待审核后方可以使用', ['sid' => $this -> db -> insert_id()]);
                    }
                    else
                        show(0, '数据插入失败，请稍后再试');
                }
                else
                    show(0, '该店铺已被绑定');
            }
            else  //有未填参数
                show(0, '参数错误，请检查是否有必填参数漏填');
        }
        else
            show(0, '一个账户最多能绑定' . $max_num . '个店铺');
	}

	/*
	 * 编辑店铺
	 */
	public function editShop($id=0){
	    if($id==0){
	        echo "<script>alert('请不要尝试错误链接！谢谢。');history.back();</script>";
	    }else{
	        $db = $this -> getServerInfo();
	        $db['info']=$this->shop->getInfo($id);
	        if($db['info']!=null){
		        $this->load->view('seeshop',$db);
	        }else{
	            echo "<script>alert('您要查看的信息已经消失在二次元空间了，刷新页面后查看内容！');history.back();</script>";
	        }	    
	    }
	}

	/*
	 * 修改店铺信息入库
	 */
	public function editShopInfoDB()
    {
        $db = [
            'type' => $_POST['ChildPlatformType'],
            'manager_num' => $_POST['PlatformNoID'],  //掌柜号
            'shopname' => $_POST['ShopName'],
            'nature' => $_POST['ShopNature'],  //店铺性质
            'addtime' => time(),
        ];
        if (!empty($_FILES['upfile1']))
        {
            $file_path = $this -> uploadFile($_FILES['upfile1']);
            $db['images'] = $file_path ? unserialize($file_path)[0] : '';
        }
        if (!in_array('', $db, true))  //所有必须参数已填
        {
            if ($this -> shop -> updata($_POST['userid'], $db))
            {
                RedisCache::del('shop_list_' . $this -> uid);
//                RedisCache::del('shop_count_' . $this -> uid);
                show(1, '店铺信息修改成功');
            }
            else
                show(0, '数据插入失败，请稍后再试');
        }
        else  //有未填参数
            show(0, '参数错误，请检查是否有必填参数漏填');

//	    $db['type']=$_POST['ChildPlatformType'];
//	    $db['manager_num']=$_POST['PlatformNoID'];
//	    $db['shopname']=$_POST['ShopName'];
//	    $db['nature']=$_POST['ShopNature'];
//	    $db['sendname']=$_POST['SenderName'];
//	    $db['sendphone']=$_POST['SenderTel'];
//	    $db['sendprovince']=$_POST['cmbProvince'];
//	    $db['sendcity']=$_POST['cmbCity'];
//	    $db['senddistrict']=$_POST['cmbArea'];
//	    $db['sendarea']=$db['sendprovince'].$db['sendcity'].$db['senddistrict'];
//	    $db['sendaddress']=$_POST['DetailAddress'];
//	    $images=$this->sys->upFile('upfile1');
//	    $db['addtime']=@strtotime(@date('Y-m-d H:i:s'));
//	    $db['addIP']=$this->sys->GetIp();
//	    $db['status']=0;
//	    $db['auditing']=0;
//	    if($images){
//	        $db['images'] = site_url().$images;
//	    }
//	    $id=$_POST['userid'];
//
//	    if($db['manager_num']==''){
//	        echo "<script>alert('掌柜号不能为空！');history.back();</script>";
//	        exit;
//	    }
//	    if($db['shopname']==''){
//	        echo "<script>alert('店铺名称不能为空！');history.back();</script>";
//	        exit;
//	    }
//	    if($db['sendname']==''){
//	        echo "<script>alert('发货人姓名不能为空！');history.back();</script>";
//	        exit;
//	    }
//	    if(!$this->checkphone($db['sendphone'])){
//	        echo "<script>alert('手机号码格式不真确，请认真填写');history.back();</script>";
//	        exit;
//	    }
//	    if($db['sendaddress']==''){
//	        echo "<script>alert('发货详细地址不能为空！');history.back();</script>";
//	        exit;
//	    }
//
//	    $re = $this->shop->updata($id,$db);
//	    if($re){
//	        echo "<script>alert('店铺信息编辑成功！等待审核后方可以使用！'); parent.location.reload();</script>";
//	        //$this->store();
//	    }else{
//	        echo "<script>alert('修改失败了，再来一次试试！');history.back();</script>";
//	    }
	    
	}

	/*
	 * 删除店铺
	 */
    public function delShop()//删除店铺
	{	    
	    if (!empty($_POST['id']))
        {
            if (!$this -> product -> getListCount($this -> uid, $_POST['id'], 'all', 'all'))
            {
                $sql = 'SELECT COUNT(1) as sum FROM zxjy_usertask WHERE shopid = ' . $_POST['id'] . ' AND TO_DAYS(NOW()) - TO_DAYS(FROM_UNIXTIME(addtime)) < 30 ORDER BY id ASC';
                if (!$this -> db -> query($sql) -> first_row() -> sum)
                {
                    if ($this -> shop -> del($this -> uid, $_POST['id']))
                    {
                        RedisCache::del('shop_list_' . $this -> uid);
                        RedisCache::del('shop_count_' . $this -> uid);
                        show(1, '所选店铺删除成功');
                    }
                    else
                        show(0, '数据库操作失败，请稍后再试');
                }
                else
                    show(0, '该店铺存在30内的任务信息，无法删除');
            }
            else
                show(0, '该店铺下有很多商品, 请先删除对应商品');

        }
        else
            show(0, '参数错误，请刷新后重试');

//	    $key=$_GET['id']==''?0:$_GET['id'];
//	    if($key==0){
//	        echo "<script>alert('请不要测试错误链接！');history.back();</script>";
//	    }else{
//	        $id = $this->session->userdata('sellerid');
//	        $list = $this->product->getListCount($id,$key,'all','all');
//	        if($list==0){
//    	        $re=$this->shop->getInfo($key);
//    	        if($re!=null){
//    	            $redel=$this->shop->del($key);
//    	            if($redel){
//        	            echo "<script>alert('删除成功了！');</script>";
//        	            $this->store();
//    	            }else{
//    	                echo "<script>alert('系统繁忙中，请稍后重试！');history.back();</script>";
//    	            }
//    	        }else{
//    	            echo "<script>alert('您要删除的数据已经消失在二次元空间！请刷新页面后重新操作！');history.back();</script>";
//    	        }
//	        }else{
//	            echo "<script>alert('该店铺下有很多产品。不能直接删除店铺的哦！');history.back();</script>";
//	        }
//	    }
	}

    public function editShopOwner($id=0)//编辑店铺发货人信息
	{	    
	    if($id==0){
	        echo "<script>alert('请不要尝试错误链接！谢谢。');history.back();</script>";
	    }else{
	        $db['info']=$this->shop->getInfo($id);
	        if($db['info']!=null){
		        $this->load->view('editSendInfo',$db);
	        }else{
	            echo "<script>alert('您要查看的信息已经消失在二次元空间了，刷新页面后查看内容！');history.back();</script>";
	        }
	    }
	}
	public function editShopDB(){
	    $id=$_POST['PlatformNoID'];
	    $db['sendname']=$_POST['SenderName'];
	    $db['sendphone']=$_POST['SenderTel'];
	    $db['sendprovince']=$_POST['cmbProvince'];
	    $db['sendcity']=$_POST['cmbCity'];
	    $db['senddistrict']=$_POST['cmbArea'];
	    $db['sendarea']=$db['sendprovince'].$db['sendcity'].$db['senddistrict'];
	    $db['sendaddress']=$_POST['DetailAddress'];
	    $re=$this->shop->updata($id,$db);
	    if($db['sendname']==''){
	        echo "<script>alert('发货人姓名不能为空');history.back();</script>";
	        exit;
	    }
	    if(!$this->checkphone($db['sendphone'])){
	        echo "<script>alert('电话号码格式不真确，请认真填写');history.back();</script>";
	        exit;
	    }
	    if($db['sendaddress']==''){
	        echo "<script>alert('发货人详细地址不能为空，请认真填写！');history.back();</script>";
	        exit;
	    }
	    if($re){
	        echo "<script>alert('编辑资料成功！'); parent.location.reload();</script>";
	    }else{
	        echo "<script>alert('修改失败！');history.back();</script>";
	    }
	}

	/*
	 * 查看店铺信息
	 */
	public function detailShop($key=0)
    {
        $db = $this -> getServerInfo();
        if ($key)
        {
            $db['info'] = $this -> shop -> getInfo($key);
            if($db['info']!=null)
                $this->load->view('shopInfo',$db);
            else
                show(0, '您查找的店铺信息已经消失在二次元空间了');
//                echo "<script>alert('您查找的店铺信息已经消失在二次元空间了！');history.back();</script>";
        }
        else
            show(0, '参数错误');

//	    $id = $this->session->userdata('sellerid');
//	    $db['service1'] = $this->system->getInfo(87);
//	    $db['service2'] = $this->system->getInfo(88);
//	    //$db['info'] = $this->user->getInfo($id);
//	    if($key==0){
//	        echo "<script>alert('请不要尝试错误链接，谢谢！');history.back();</script>";
//	    }else{
//        	$db['info']=$this->shop->getInfo($key);
//	        if($db['info']!=null){
//        		$this->load->view('shopInfo',$db);
//	        }else{
//	            echo "<script>alert('您查找的店铺信息已经消失在二次元空间了！');history.back();</script>";
//	        }
//	    }
	}

	/*
	 * 商品管理
	 */
    public function product()
	{
        $db = $this -> getServerInfo();
        $db['page'] = isset($_GET['page']) ? $_GET['page'] : 0;

//	    $page = @$_GET['page']==''?0:@$_GET['page'];
	    $id = $this->session->userdata('sellerid');
//	    $db['info'] = $this->user->getInfo($id);
//	    $db['showcontent'] =1 ;
//	    $db['service1'] = $this->system->getInfo(87);
//	    $db['service2'] = $this->system->getInfo(88);
	    $db['shoplist'] = $this->shop->getlist($id,1,0,0,0);
	    $db['proname']='';
	    $db['proid']='';
	    $db['shopid']='';
	    $db['product']=$this->product->getList($id,'all','all','all',1,10,10*$db['page']);
	    $db['count'] = $this->product->getListCount($id,'all','all','all');
	    $db['search'] =false;
		$this->load->view('producta',$db);
	}
	public function search(){
        $db = $this -> getServerInfo();
	    $id = $this->session->userdata('sellerid');
	    $db['shoplist']=$this->shop->getlist($id,1,0,0,0);
	    $db['proname']=@$_POST['Name']==''?'':@$_POST['Name'];
	    $db['proid']=@$_POST['ProductPlatformID']==''?'':@$_POST['ProductPlatformID'];
	    $db['shopid']=@$_POST['PlatformNoID']==''?'':@$_POST['PlatformNoID'];
	    $db['search'] = true;
	    $db['product']=$this->product->getList($id,$db['shopid']=='0'?'all':$db['shopid'],$db['proid']==''?'all':$db['proid'],$db['proname']==''?'all':$db['proname'],0,0,0);
	    
		$this->load->view('producta',$db);
	}

	/*
	 * 添加商品
	 */
	public function proadd()
    {
        $db = $this -> getServerInfo();
        $sql = 'select * from zxjy_shop where userid = ' . $this -> uid . ' AND auditing = 1 ' . 'ORDER BY sid desc';
        $db['shoplist'] = $this -> db -> query($sql) -> result();
        $this -> load -> view('Create', $db);
	}

	/*
	 * 添加商品信息入库
	 */
	public function proAddDB()
    {
        $server_infos = $this -> getServerInfo();
        $use_helper = $server_infos['use_helper'];
		if ($use_helper -> value && !isset($_POST['product'])) show(0, '获取参数失败，请尝试更换浏览器重新提交');
        $db = [
            'commodity_image' => $use_helper -> value ? $_POST['product'] : unserialize($this -> uploadFile($_FILES['product']))[0],
			'app_img' => !empty($_FILES['app_img']) ? unserialize($this -> uploadFile($_FILES['app_img']))[0] : NULL,  //无线端商品主图
            'qrcode' => !empty($_FILES['qrcode']) ? unserialize($this -> uploadFile($_FILES['qrcode']))[0] : NULL,
            'through_train_1' => !empty($_FILES['through_train_1']) ? unserialize($this -> uploadFile($_FILES['through_train_1']))[0] : NULL,
            'through_train_2' => !empty($_FILES['through_train_2']) ? unserialize($this -> uploadFile($_FILES['through_train_2']))[0] : NULL,
            'through_train_3' => !empty($_FILES['through_train_3']) ? unserialize($this -> uploadFile($_FILES['through_train_3']))[0] : NULL,
            'through_train_4' => !empty($_FILES['through_train_4']) ? unserialize($this -> uploadFile($_FILES['through_train_4']))[0] : NULL,
            'userid' => $_POST['userid'],
            'shopid' => $_POST['PlatformNoID'],
            'commodity_id' => $_POST['ID'],
            'commodity_abbreviation' => $_POST['ShortName'],
            'commodity_title' => $_POST['FullName'],
            'commodity_url' => $_POST['Url'],
            'status' => 0,
            'peostatus' => 0,
            'addtime' => time(),
            'addIP' => $this -> sys -> GetIp(),
        ];
        if (!in_array('', $db, true))
        {
            if ($this -> product -> add($db))
            {
                RedisCache::del('pro_model_getListPro_' . $this -> uid);
                show(1, '新增商品成功');
            }
            else
                show(0, '数据库写入失败，请稍后再试');
        }
        else
            show(0, '参数错误');

//	    $db['userid']=$_POST['userid'];
//	    $db['shopid']=$_POST['PlatformNoID'];
//	    $db['commodity_id']=$_POST['ID'];
//	    $db['commodity_abbreviation']=$_POST['ShortName'];
//	    $db['commodity_title']=$_POST['FullName'];
//	    $db['commodity_url']=$_POST['Url'];
//	    $db['status']=0;
//	    $db['peostatus']=0;
//	    $db['addtime']=@strtotime(@date('Y-m-d H:i:s'));
//	    $db['addIP']=$this->sys->GetIp();
//
//	    $commodity_image=$this->sys->upFile('product');
//	    $qrcode=$this->sys->upFile('qrcode');
//	    if($db['shopid']==0){
//	        echo "<script>alert('请先选择产品所属店铺。');history.back();</script>";
//	        exit;
//	    }
//	    if($db['commodity_url']==''){
//	        echo "<script>alert('请填写好产品的完整网址');history.back();</script>";
//	        exit;
//	    }
//	    if($db['commodity_title']==''){
//	        echo "<script>alert('请填写好产品的名称');history.back();</script>";
//	        exit;
//	    }
//	    if($db['commodity_abbreviation']==''){
//	        echo "<script>alert('请填写好产品的简称！');history.back();</script>";
//	        exit;
//	    }
//	    if($db['commodity_id']==''){
//	        echo "<script>alert('请填写好产品的淘宝ID号，方便管理产品！');history.back();</script>";
//	        exit;
//	    }
//	    if($commodity_image){
//	        $db['commodity_image']=site_url().$commodity_image;
//	    }else{
//	        echo "<script>alert('请先上传产品主图');history.back();</script>";
//	        exit;
//	    }
//	    if($qrcode){
//	        $db['qrcode']=site_url().$qrcode;
//	    }else{
//	        echo "<script>alert('请先上传产品二维码图片');history.back();</script>";
//	        exit;
//	    }
//	    $re = $this->product->add($db);
//	    if($re){
//	        echo "<script>alert('产品上传成功！');</script>";
//	        echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=../member/product.html\" >";
//	    }else{
//	        echo "<script>alert('产品上传失败了，重新尝试一下！');history.back();</script>";
//	    }
	    
	}

	/*
	 * 编辑商品信息
	 */
	public function editpro($key=0)
    {
        if ($key)
        {
            RedisCache::del('pro_info_' . $key . $this -> uid);
            $db = $this -> getServerInfo();
            $sql = 'SELECT p.id, p.shopid, p.commodity_abbreviation, p.commodity_url, p.commodity_title, p.commodity_id, p.commodity_image, p.qrcode, p.app_img, p.through_train_1, p.through_train_2, p.through_train_3, p.through_train_4, s.shopname, s.sid from zxjy_product as p
                    LEFT JOIN zxjy_shop as s on s.sid = p.shopid
                    where p.userid = ' . $this -> uid . ' AND p.id = ' . $key;
            $db['proinfo'] = $this -> cacheSqlQuery('pro_info_' . $key, $sql, 60 * 60 * 24 * 30, false, 'first_row');
            $sql = 'select * from zxjy_shop where userid = ' . $this -> uid . ' ORDER BY sid desc';
            $db['shoplist'] = $this -> db -> query($sql) -> result();
//            $db['shoplist'] = $this -> cacheSqlQuery('shop_list_', $sql, 60 * 60 * 24 * 30);
            $db['proinfo'] ? $this -> load -> view('Editpro', $db) : show(0, '商品信息丢失');
        }
        else
            show(0, '参数错误');

//	    if($key==0){
//	        echo "<script>alert('请不要测试错误链接');history.back();</script>";
//	    }else{
//	        $id = $this->session->userdata('sellerid');
//	        $db['info'] = $this->user->getInfo($id);
//	        $db['showcontent'] =1 ;
//    	    $db['service1'] = $this->system->getInfo(87);
//    	    $db['service2'] = $this->system->getInfo(88);
//    	    $db['shoplist']=$this->shop->getlist($id,1,0,0,0);
//    	    $db['proinfo'] = $this->product->getInfo($key);
//    		$this->load->view('Editpro',$db);
//	    }
	}

	/*
	 * 修改商品信息入库
	 */
	public function editDB()
    {
        $server_infos = $this -> getServerInfo();
        $use_helper = $server_infos['use_helper'];
        $db = $use_helper -> value ? [
            'commodity_abbreviation' => $_POST['ShortName'],
            'addIP' => $this -> sys -> GetIp(),
            'commodity_title' => $_POST['FullName'],
            'commodity_url' => $_POST['Url'],
            'commodity_image' => $_POST['master_img'],
        ] : [
            'shopid' => $_POST['PlatformNoID'],
            'commodity_id' => $_POST['ID'],
            'commodity_abbreviation' => $_POST['ShortName'],
            'commodity_title' => $_POST['FullName'],
            'commodity_url' => $_POST['Url'],
            'addIP' => $this -> sys -> GetIp(),
        ];
        if (!empty($_FILES['product']))
            $db['commodity_image'] = unserialize($this -> uploadFile($_FILES['product']))[0];
        if (!empty($_FILES['qrcode']))
            $db['qrcode'] = unserialize($this -> uploadFile($_FILES['qrcode']))[0];
		if (!empty($_FILES['app_img']))
            $db['app_img'] = unserialize($this -> uploadFile($_FILES['app_img']))[0];
        if (!empty($_FILES['through_train_1']))
            $db['through_train_1'] = unserialize($this -> uploadFile($_FILES['through_train_1']))[0];
        if (!empty($_FILES['through_train_2']))
            $db['through_train_2'] = unserialize($this -> uploadFile($_FILES['through_train_2']))[0];
        if (!empty($_FILES['through_train_3']))
            $db['through_train_3'] = unserialize($this -> uploadFile($_FILES['through_train_3']))[0];
        if (!empty($_FILES['through_train_4']))
            $db['through_train_4'] = unserialize($this -> uploadFile($_FILES['through_train_4']))[0];
        if (!in_array('', $db, true))
        {
            if ($this -> product -> updata($_POST['proid'], $db))
            {
                RedisCache::del('pro_info_' . $_POST['proid'] . $this -> uid);
                RedisCache::del('pro_model_getInfo_' . $_POST['proid'] . '_' . $this -> uid);
                RedisCache::del('pro_model_getListPro_' . $this -> uid);
                show(1, '修改商品信息成功');
            }
            else
                show(0, '数据库写入失败，请稍后再试');
        }
        else
            show(0, '参数错误');

//	    $id=$_POST['proid'];
//	    $db['shopid']=$_POST['PlatformNoID'];
//	    $db['commodity_id']=$_POST['ID'];
//	    $db['commodity_abbreviation']=$_POST['ShortName'];
//	    $db['commodity_title']=$_POST['FullName'];
//	    $db['commodity_url']=$_POST['Url'];
//	    $db['status']=0;
//	    $db['addtime']=@strtotime(@date('Y-m-d H:i:s'));
//	    $db['addIP']=$this->sys->GetIp();
//	    $commodity_image=$this->sys->upFile('product');
//	    $qrcode=$this->sys->upFile('qrcode');
//
//	    if($db['shopid']==0){
//	        echo "<script>alert('请先选择产品所属店铺。');history.back();</script>";
//	        exit;
//	    }
//	    if($db['commodity_url']==''){
//	        echo "<script>alert('请填写好产品的完整网址');history.back();</script>";
//	        exit;
//	    }
//	    if($db['commodity_title']==''){
//	        echo "<script>alert('请填写好产品的名称');history.back();</script>";
//	        exit;
//	    }
//	    if($db['commodity_abbreviation']==''){
//	        echo "<script>alert('请填写好产品的简称！');history.back();</script>";
//	        exit;
//	    }
//	    if($db['commodity_id']==''){
//	        echo "<script>alert('请填写好产品的淘宝ID号，方便管理产品！');history.back();</script>";
//	        exit;
//	    }
//	    if($commodity_image){
//	        $db['commodity_image']=site_url().$commodity_image;
//	    }
//	    if($qrcode){
//	        $db['qrcode']=site_url().$qrcode;
//	    }
//
//	    $re = $this->product->updata($id,$db);
//	    if($re){
//	        echo "<script>alert('产品信息修改成功！');</script>";
//	        $this->product();
//	    }else{
//	        echo "<script>alert('还差那么一点点就编辑成功了，再尝试一次不一定就成功了呢！');history.back();</script>";
//	    }
	    
	}

	/*
	 * 删除商品信息
	 */
	public function delpro()
    {
        if (isset($_POST['id']))
        {
            $sql = 'SELECT COUNT(1) as sum FROM zxjy_usertask WHERE proid = ' . $_POST['id'] . ' AND TO_DAYS(NOW()) - TO_DAYS(FROM_UNIXTIME(addtime)) < 30';
            if (!$this -> db -> query($sql) -> first_row() -> sum)
            {
                if ($this -> product -> delete($_POST['id']))
                {
                    $this -> delCache(['pro_info_' . $_POST['id'], 'pro_model_getListPro_']);
                    RedisCache::del('pro_model_getInfo_' . $_POST['id'] . '_' . $this -> uid);
                    show(1, '删除商品记录成功');
                }
                else
                    show(0, '数据库删除记录失败，请稍后再试');
            }
            else
                show(0, '该商品存在30天内的任务记录，无法删除');
        }
        else
            show(0, '参数错误');

//	    $key=@$_GET['id']==''?0:@$_GET['id'];
//	    if($key==0){
//	        echo "<script>alert('请不要测试错误链接！');history.back();</script>";
//	    }else{
//	        $list = $this->task->Prodel($this->session->userdata('sellerid'),$key);
//	        if($list != 0){
//	            echo "<script>alert('当前产品还有发布了的任务-- 不能直接删除商品哦！ 若需删除商品，请待系统清除任务数据后删除！谢谢您的理解');history.back();</script>";
//	        }else{
//    	        $db['info']=$this->product->getInfo($key);
//    	        if($db['info']!=null){
//    	            $re=$this->product->delete($key);
//    	            if($re){
//    	                echo "<script>alert('删除成功！');</script>";
//    	                $this->product();
//    	            }else{
//    	                echo "<script>alert('距离成功只还差一步，您再尝试一次或许就成功了！');history.back();</script>";
//    	            }
//    	        }else{
//    	            echo "<script>alert('您要删除的信息已经不存在了，请刷新页面后查看最新信息！');history.back();</script>";
//    	        }
//    	    }
//	    }
	}

	/*
	 * 批量删除商品信息
	 */
	public function delarr()
    {
        if (isset($_POST['pids']))
        {
            $pids = rtrim($_POST['pids'], ',');
            $sql = 'SELECT count(1) as sum from zxjy_task where proid in (' . $pids . ')';
            $has_task = $this -> db -> query($sql) -> first_row() -> sum;
            if (!$has_task)
            {
                $sql = 'DELETE from zxjy_product where id in (' . $pids . ')';
                $this -> db -> query($sql);
                if ($this -> db -> affected_rows())
                {
                    $this -> delCache(['pro_model_getListPro_']);
                    show(1, '删除所选商品信息成功');
                }
                else
                    show(0, '数据库操作失败，请稍后再试');
            }
            else
                show(0, '所选商品中有关联未结束的已发布任务,请审查后再试');
        }
        else
            show(0, '参数错误');

//	    $arr=$_GET['arr'];
//	    $arr = explode(",", $arr);
//	    if(count($arr)==0){
//	        echo "<script>alert('警告，警告，警告！错误操作！');history.back();</script>";
//	    }else{
//	        $re = $this->product->deleteArr($arr);
//	        if($re){
//	            echo "<script>alert('删除成功！');</script>";
//	            $this->product();
//	        }else{
//	            echo "<script>alert('系统繁忙中，清稍后重试！');history.back();</script>";
//	        }
//	    }
	}

	/*
	 * 查看商品详情
	 */
	public function seepro($id=0)
    {
        if ($id)
        {
            $db = $this -> getServerInfo();
            $sql = 'SELECT p.id, p.shopid, p.commodity_abbreviation, p.commodity_url, p.commodity_title, p.commodity_id, p.commodity_image, p.qrcode, p.through_train_1, p.through_train_2, p.through_train_3, p.through_train_4, s.sid, s.shopname from zxjy_product as p
                    LEFT JOIN zxjy_shop as s on s.sid = p.shopid
                    where p.userid = ' . $this -> uid . ' AND p.id = ' . $id;
            $db['proinfo'] = $this -> cacheSqlQuery('pro_info_' . $id, $sql, 60 * 60 * 24 * 30, false, 'first_row');
            $db['proinfo'] ? $this -> load -> view('DetailsProduct', $db) : show(0, '商品信息丢失');
        }
        else
            show(0, '参数错误');
//	    if($id==0){
//	        echo "<script>alert('请不要测试错误链接，谢谢！');history.back();</script>";
//	    }else{
//	        $db['proinfo']=$this->product->getInfo($id);
//	        if($db['proinfo']!=null)
//	        {
//	            $db = $this -> getServerInfo();
//                $db['shoplist']=$this->shop->getlist($id,1,0,0,0);
//        	    $id = $this->session->userdata('sellerid');
//        	    $db['info'] = $this->user->getInfo($id);
//    	        $db['shoplist']=$this->shop->getlist($id,1,0,0,0);
//        	    $db['showcontent'] =1 ;
//        	    $db['service1'] = $this->system->getInfo(87);
//        	    $db['service2'] = $this->system->getInfo(88);
//        	    $this->load->view('DetailsProduct',$db);
//	        }else{
//	            echo "<script>alert('您要查看的信息已经消失在二次元空间，请刷新页面更新到所有数据以后尝试！');history.back();</script>";
//	        }
//	    }
	}

	/*
	 * 目标客户设置页
	 */
	public function sitepro()
    {
	    $id=@$_GET['id']==''?0:@$_GET['id'];
	    if($id==0){
	       echo "<script>alert('请不要测试错误链接！');history.back();</script>";
	    }else{
	        $db['info']=$this->product->getInfo($id);
	        if($db['info']!=null){
	           $this->load->view('NewTargetSet',$db);
	        }else{
	            echo "<script>alert('您要设置的产品信息已经消失在二次元空间了，请在返回后刷新页面更新数据！');history.back();</script>";
	        }
	    }
	}
	public function siteproDB()
    {
	    $id=$_POST['ProductID'];
	    $db['status']=1;
	    $sex['man']=$sexman=$_POST['PercentPlatformNoSexMale'];
	    $sex['woman']=$sexwomen=$_POST['PercentPlatformNoSexFemale'];
	    $age['younger']=$agel=$_POST['PercentPlatformNoAge18_24'];
	    $age['middle']=$agem=$_POST['PercentPlatformNoAge25_29'];
	    $age['older']=$ageo=$_POST['PercentPlatformNoAge30_34'];
	    $age['older_more']=$ageo_more=$_POST['PercentPlatformNoAge46_59'];
	    $area=$_POST['RegionIds'];
	    //数组序列化储存到数据库
	    $db['sex']=serialize($sex);
	    $db['age']=serialize($age);
	    $db['region']=serialize($area);
	    $re=$this->product->updata($id,$db);
	    if($re){
	        RedisCache::del('pro_model_getInfo_' . $id . '_' . $this -> uid);
	        $this -> delCache(['pro_model_getListPro_']);
	        show(1, '设置成功');
//	        echo "<script>alert('设置成功！');parent.location.reload();</script>";
	    }else{
	        show(0, '数据库操作失败，请稍后再试');
	        //echo "<script>alert('还差那么一点点就可以设置成功了，再来一次吧！');history.back();</script>";
	    } 
	}
	public function setpro(){
	    $id=@$_GET['id']==''?0:@$_GET['id'];
	    if($id==0){
	       echo "<script>alert('请不要测试错误链接！');history.back();</script>";
	    }else{
	        $db['info']=$this->product->getInfo($id);
	        if($db['info']!=null){
	           $this->load->view('BuyNoBehavior',$db);
	        }else{
	            echo "<script>alert('您要设置的产品信息已经消失在二次元空间了，请在返回后刷新页面更新数据！');history.back();</script>";
	        }
	    }
	}
	public function setproDB(){
	    $id=$_POST['ProductID'];
	   // $info=
	    $db['peostatus']=1;
	    $ShopCollect = $_POST['ShopCollect']; //收藏店铺
	    $ProductCollect = $_POST['ProductCollect']; // 收藏商品
	    $BeforeBuyTalk = $_POST['BeforeBuyTalk']; // 拍前聊
	    //货比N家
	    $about['not'] = $_POST['ProductCompareNot'];
	    $about['com1'] = $_POST['ProductCompare1'];
	    $about['com2'] = $_POST['ProductCompare2'];
	    $about['com3'] = $_POST['ProductCompare3'];
	    //浏览深度
	    $deep['net'] = $_POST['BrowseShopPNot'];
	    $deep['shop1'] = $_POST['BrowseShopP1'];
	    $deep['shop2'] = $_POST['BrowseShopP2'];
	    $deep['shop3'] = $_POST['BrowseShopP3'];
	    //停留时间
	    $stay['not'] = $_POST['InsideShopStayNot'];
	    $stay['stay5'] = $_POST['InsideShopStay5'];
	    $stay['stay10'] = $_POST['InsideShopStay10'];
	    
	    $ShopCollect = $_POST['ShopCollect'];
	    //数组序列化储存到数据库
	    $db['bookmark']=$ShopCollect;
	    $db['c_goods']=$ProductCollect;
	    $db['talk']=$BeforeBuyTalk;

	    $db['x_home']=serialize($about);
	    $db['deep']=serialize($deep);
	    $db['sitetime']=serialize($stay);
	    
	    $re=$this->product->updata($id,$db);
//	    if($re){
//	        echo "<script>alert('设置成功！');parent.location.reload();</script>";
//	    }else{
//	        echo "<script>alert('还差那么一点点就可以设置成功了，再来一次吧！');history.back();</script>";
//	    }
        if($re){
            $this -> delCache(['pro_model_getInfo_' . $id . '_']);
            show(1, '设置买号购买行为成功');
//	        echo "<script>alert('设置成功！');parent.location.reload();</script>";
        }else{
            show(0, '数据库操作失败，请稍后再试');
            //echo "<script>alert('还差那么一点点就可以设置成功了，再来一次吧！');history.back();</script>";
        }

    }

    /*
     * 购买单量
     */
    public function buyTask()
    {
        $db = $this -> getServerInfo();
        $db['page'] = isset($_GET['page']) ? $_GET['page'] : 0;
        $start = $db['page'] * 15;
        $db['buy'] = $this -> getGrads();  //单量购买梯度
        $db['infocount'] = $this -> shop -> getcount($this -> uid);
        $sql = 'SELECT number, price, reason, addtime, updatetime, true_price, 
                    CASE state
                        WHEN 0 THEN "待审核"
                        WHEN 1 THEN "审核通过"
                        WHEN 2 THEN "已驳回"
                    END as state
                FROM zxjy_buytasknum WHERE uid = ' . $this -> uid. ' ORDER BY id DESC LIMIT ' . $start . ', 15';
        $count_sql = 'select count(1) as sum from zxjy_buytasknum where  uid = ' . $this -> uid ;
        $db['lists'] = $this -> db -> query($sql) -> result();
        $db['count'] = $this -> cacheSqlQuery('buyTask_page_' . $this -> uid, $count_sql, 60 * 60 * 24, '', 'first_row') -> sum;
        $this -> load -> view('buyTask', $db);
    }


    /*
     * 获取购买单量梯度
     */
    public function getGrads()
    {
        $res = [];
        foreach (explode('|', BUY_GRA) as $v)
        {
            $arr = explode('=', $v);
            $res[$arr[0]] = $arr[1];
        }
        return $res;
    }

    /*
     * 申请购买单量
     */
    public function applyBuyTask()
    {
        if (isset($_POST['tasknum']) && is_numeric($_POST['tasknum']))
        {
            $user_info = $this -> getServerInfo()['info'];
            $grads = $this -> getGrads();
            if ($grads[$_POST['tasknum']] <= $user_info -> Money - $user_info -> bond)
            {
                $sql = 'SELECT count(1) as sum FROM zxjy_buytasknum WHERE uid = ' . $this -> uid . ' AND state = 0 ORDER BY id DESC LIMIT 1';
                if (!$this -> db -> query($sql) -> first_row() -> sum)
                {
                    $now = time();
                    $inster = [
                        'uid' => $this -> uid,
                        'number' => $_POST['tasknum'],
                        'price' => $grads[$_POST['tasknum']],
                        'addtime' => $now,
                    ];
                    if ($this -> db -> insert('zxjy_buyTaskNum', $inster))
                    {
                        $inster['addtime'] = date('Y-m-d H:i:s', $now);
                        show(1, '申请购买成功, 请耐心等待审核结果', $inster);
                    }
                    else
                        show(0, '插入记录失败, 请联系客服');
                }
                else
                    show(0, '您当前还有一笔申请正在等待审核，请不要重复提交哦');
            }
            else
                show(0, '减去保证金，您的账户余额不足以支付此次购买,请充值后再试');
        }
        else
            show(0, '参数错误');
    }


	public function notices()// 平台公告
	{
		//exit('<script>location.href= "/user"</script>');
	    $db = $this -> getServerInfo();
	    $page=@$_GET['page']==''?0:@$_GET['page'];
	    $id = $this->session->userdata('sellerid');
	    $db['info'] = $this->user->getInfo($id);
	    $db['showcontent'] =1 ;
	    $db['lists']=$this->article->getList(38,10,$page*10);
	    $db['count']=$this->article->getCount(38);
		$db['search'] = 1;
	    $db['page']=$page;
	    
		$this->load->view('notice',$db);
	}
	public function detailnotice($key=0){
	    //echo $key;
	    if($key===0){
	        echo "<script>alert('请不要测试错误链接！');history.back();</script>";
	        exit;
	    }else{
            $db = $this -> getServerInfo();
    	    $id = $this->session->userdata('sellerid');
    	    $db['info'] = $this->user->getInfo($id);
    	    $db['showcontent'] =1 ;
    	    $db['newinfo']=$this->article->getInfos($key);
	        $this->load->view('noticeinfo',$db);
	    }
	}
	public function transferShow(){
        $db = $this -> getServerInfo();
    	$id = $this->session->userdata('sellerid');
    	$db['newinfo']=$this->article->getInfosOne(47);
	    $this->load->view('noticeinfo',$db);
	}
    public function edit()// 调整单量
	{
	    $db = $this -> getServerInfo();
	    $id = $this->session->userdata('sellerid');
	    $db['showcontent'] =1 ;
	    $db['infocount'] = $this->shop->getcount($id);	
		$this->load->view('edit',$db);
	}
	public function join()
    {
        $db = $this -> getServerInfo();
        $db['page'] = isset($_GET['page']) ? $_GET['page'] : 0;
        $start = $db['page'] * 10;
        $condition = !empty($_GET['BeginDate']) ? ' AND addtime between ' . strtotime ( $_GET ['BeginDate'] ) . ' AND ' . (strtotime ( $_GET ['BeginDate'] ) + 24 * 3600 - 1) :
            ' AND FROM_UNIXTIME(addtime, "%Y-%m-%d") = DATE_ADD(CURDATE(),INTERVAL "-1" DAY)';
        //$condition = '';
        $sql = 'SELECT u.id, u.Username, u.Status, u.QQToken,
                CASE WHEN 1 ' . $condition . ' THEN COUNT(t.id) ELSE 0 END as has
                FROM zxjy_user as u
                LEFT JOIN zxjy_usertask as t on t.merchantid = u.id AND t.status >= 4' . $condition .
                ' where parentid = ' . $this -> uid . ' GROUP BY u.id order by has desc limit ' . $start . ', 10';
        $db['userlist'] = $this -> db -> query($sql) -> result();
        $db['shoptuiguangjin'] = $this->system->getInfo ( 82 ); // 推广需要添加的费用
        //$db['userlist'] = $this->user->UserPid($this -> uid, 10, 10 * $db['page']);
        $db['count'] = $this->user->CountUserPid($this -> uid);
        $sql = 'SELECT SUM(increase) as a FROM zxjy_cashlog where beizhu = "推广商家完成发布任务获得" AND userid = ' . $this -> uid;
        $db['all'] = $this -> db -> query($sql) -> first_row();
        $db['condition'] = $condition;
        $db['currenid'] = $this -> uid;
        $sql = 'SELECT u1.Truename, u1.Username FROM zxjy_user as u1
                LEFT JOIN zxjy_user as u2 on  u1.id = u2.parentid
                WHERE u2.id = ' . $this -> uid;
        $db['has_yqr'] = $this -> db -> query($sql) -> first_row();
        $this->load->view('Join',$db);

//	    $page=@$_GET['page']==''?0:@$_GET['page'];
//	    $id = $this->session->userdata('sellerid');
//	    $db['info'] = $this->user->getInfo($id);
//	    $db['showcontent'] =1 ;
//	    $db['service1'] = $this->system->getInfo(87);
//	    $db['service2'] = $this->system->getInfo(88);
//	    $db['userlist'] = $this->user->UserPid($id,10,10*$page);
//	    $db['count'] = $this->user->CountUserPid($id);
//	    $db['page'] = $page;
//	    $this->load->view('Join',$db);
	}
	public function JoinDB(){
	    $phone =$_POST['phon'];
	    $id = $this->session->userdata('sellerid');
	    $urlkey = site_url('welcome/regist').'?key='.$id.'@'.MD5($phone);
	    echo $urlkey;
	}
	public function updataMaxTransfer(){
	    $id = $this->session->userdata('sellerid');
	    $db['info'] = $this->user->getInfo($id);     
	    $this->load->view('UpdataTransfer',$db);
	}
	public function updataTransferDB(){
	    $this->load->model('Taskinfo_model','taskinfofuck');
	    $id = $this->session->userdata('sellerid');
	    $info = $this->user->getInfo($id);	
	    $db['userid'] = $_POST['userid'];
	    $db['tranfer'] = $_POST['SenderTel'];
	    $db['mark'] = $_POST['DetailAddress'];
	    $db['status'] = 0;
	    $db['username'] = $info->Username;
	    $db['addtime'] = time();
	    $time = @date("Y-m-d",@strtotime("-1 week"));	    
	    $list = $this->taskinfofuck->getListWeek($time,$id);
	    if(count($list) != 0){
	        echo "<script>alert('您在一周内提交过申请了哟！');parent.location.reload();</script>";
	        exit;
	    }
	    $re=$this->taskinfofuck->add($db);
	    if($re){
	        echo "<script>alert('您的申请已经提交，我们的工作人员会尽快处理！');parent.location.reload();</script>";
	    }else{
	        echo "<script>alert('系统现在正在繁忙中，请稍后重试！');history.back();</script>";
	    }
	}
	
	public function checkphone($str){
	    return (preg_match("/^1[34578]\d{9}$/",$str))?true:false;	    
	}

	/*
	 * 订单小助手
	 */



	/*
	 * 进入小助手页面
	 */
	public function smartSettings()
    {
        $db = $this -> getServerInfo();
        $sql = 'select * from zxjy_shop where userid = ' . $this -> uid . ' AND status = 1 AND auditing = 1 ORDER BY sid desc';
        $db['list'] = $this -> db -> query($sql) -> result();
        $sql = 'SELECT ut.id, ut.ordersn, s.shopname, bw.wangwang, FROM_UNIXTIME(ut.updatetime) as updatetime FROM zxjy_usertask as ut
                left join zxjy_shop as s on s.sid = ut.shopid
                LEFT JOIN zxjy_blindwangwang as bw on bw.userid = ut.userid
                WHERE mark_lose = 1 AND  merchantid = ' . $this -> uid;
        $db['mark_lose'] = $this -> db -> query($sql) -> result();
        $this -> load -> view('smartSettings', $db);
    }


    /*
     * 授权的时候，获取服务接口post过来的店铺信息
     */
    public function getOrderhelperApiPostInfos()
    {
        $error_file = './authorization_err.txt';
        if (isset($_GET['Userid']))
        {
            extract($_GET);
            $sql = 'SELECT manager_num FROM zxjy_shop WHERE sid = ' . $sid;
            $shop = $this -> db -> query($sql) -> first_row();
            if (!empty($shop) && $shop -> manager_num == $Nick)
            {
                $update = [
                    'seller_userid' => $Userid,
                    'seller_nickname' => $Nick,
                    'seller_shopid' => $Shopid,
                    'api_expiration_time' => strtotime($EndTime),
                ];
                $exe = $this -> db -> update('zxjy_shop', $update, 'userid = ' . $uid . ' AND sid = ' . $sid);
                $log = $exe ? '店铺[' . $sid . ']绑定服务成功, seller_userid = ' . $Userid : '更新授权数据失败, 对应的店铺ID为：' . $sid;
                file_put_contents($error_file, date('Y-m-d H:i:s') . ' | ' . $log . "\r\n", FILE_APPEND);
            }
            else
                file_put_contents($error_file, date('Y-m-d H:i:s') . ' | 店铺ID: ' . $sid . '授权失败，掌柜号不一致, ' . $Nick . ' / ' . $shop -> manager_num . ')' . "\r\n",  FILE_APPEND);
        }
        else
            file_put_contents($error_file, date('Y-m-d H:i:s') . ' | 参数错误' . "\r\n", FILE_APPEND);
//        $error_file = './authorization_err.txt';
//        if (isset($_POST['Userid']) && isset($_POST['Userid']) && isset($_POST['sid']))
//        {
//            extract($_POST);
//            $update = [
//                'seller_userid' => $Userid,
//                'seller_nickname' => $Nick,
//                'seller_shopid' => $Shopid,
//                'api_expiration_time' => strtotime($EndTime),
//            ];
//            $exe = $this -> db -> update('zxjy_shop', $update, 'userid = ' . $uid . ' AND sid = ' . $sid);
//            if (!$exe)
//            {
//                file_put_contents($error_file, date('Y-m-d H:i:s') . ' | 更新授权数据失败, 对应的店铺ID为：' . $sid, FILE_APPEND);
//            }
//        }
//        else
//            file_put_contents($error_file, date('Y-m-d H:i:s') . ' | 参数错误', FILE_APPEND);
    }
	
	
	/*
     * 清除授权信息
     */
    public function  clearAuth()
    {
        if (isset($_POST['sid']))
        {
            $sql = 'UPDATE zxjy_shop SET seller_userid = "", seller_nickname = "", seller_shopid = "", api_expiration_time = "" WHERE sid = ' . $_POST['sid'];
            if ($this -> db -> query($sql))
            {
                RedisCache::del('server_info_' . $this -> uid);
				RedisCache::del('pro_model_getListPro_' . $this -> uid);  //清理选择商品信息缓存
                show(1, '清除成功');
            }
            else
                show(0, '清除失败，请稍后再试');
        }
        else
            show(0, '参数错误');
    }

    /*
     * 展示订单插旗设置页面
     */
    public function orderRemarkView()
    {
        if (isset($_GET['sid']))
        {
            $sql = 'SELECT sid, is_mark, mark_val, mark_comment FROM zxjy_shop WHERE api_expiration_time > UNIX_TIMESTAMP(NOW()) AND sid = ' . $_GET['sid'];
            $mark_infos = $this -> db -> query($sql) -> row();
            if (!empty($mark_infos))
            {
                $this -> load -> view('orderMark', [
                    'showcontent' => 1,
                    'mark_infos' => $mark_infos,
                ]);
            }
            else
                echo '您尚未授权订单小助手服务，或者该服务已经过期了';
        }
        else
            echo '参数错误';
    }

    /*
     * 存储订单标志设置
     */
    public function orderRemarkSave()
    {
        if (isset($_POST['sid']))
        {
            $update = [
                'is_mark' => isset($_POST['is_mark']) ? 1 : 0,
                'mark_val' => $_POST['mark_val'],
                'mark_comment' => trim($_POST['mark_comment']),
            ];
            $this -> db -> update('zxjy_shop', $update, 'sid = ' . $_POST['sid'] . ' AND userid = ' . $this -> uid) ? show(1, '订单备注设置成功') : show(0, '订单备注设置是爱');
        }
        else
            show(0, '参数错误');
    }

	
	/*
     * 商家发布任务的时候检查商品信息
     */
    public function checkProductPrice()
    {
        $set_price = $_POST['price'];
        $sql = 'SELECT commodity_id, p.addtime, seller_userid, api_expiration_time FROM zxjy_product as p
                LEFT JOIN zxjy_shop as s on s.sid = p.shopid
                WHERE p.id = ' . $_POST['proid'];
        $pro_infos = $this -> db -> query($sql) -> first_row();
        if (!empty($pro_infos -> seller_userid))  //如果是上线小助手之后添加的商品，则进行准确的价格判断
        {
            $curl_args = [
                'numIid' => $pro_infos -> commodity_id,
                'fields' => 'price'
            ];
            $curl_exe = $this -> curlApi($pro_infos -> seller_userid, $curl_args, 'getCommodityDetail');
            extract($curl_exe);
            if (!$curl_error && isset($tmpInfo -> code) && $tmpInfo -> code == 1)  //curl无错误
            {
                $set_price == $tmpInfo -> data -> price ? show(1) : show(0, '检测到您设置的商品单价与淘宝有效的单价不一致，请确认是否无误，发布之后将无法更改价格');
            }
        }
        $sql = 'SELECT orderprice FROM zxjy_usertask WHERE proid = ' . $_POST['proid'] . ' GROUP BY orderprice ORDER BY COUNT(1) DESC';
        $prices = $this -> db -> query($sql) -> result();
        if (!empty($prices))
        {
            foreach ($prices as $v)
            {
                if ($set_price == $v -> orderprice)
                {
                    show(1);
                }
            }
            show(0, '检测到您设置的商品单价与历史设置价格不一致，请确认是否无误，发布之后将无法更改价格');
        }
        else
            $set_price <= 10 ? show(0, '您设置的商品单价过小，请确认是否无误, 发布之后将无法更改价格') : show(1);
    }

    /*
     * 当商家新增商品时, 获取商品信息
     */
    public function getProductInfos()
    {
        if (isset($_POST['sid']) && isset($_POST['num_iid']))
        {
            $sql = 'SELECT seller_userid FROM zxjy_shop WHERE api_expiration_time > UNIX_TIMESTAMP(NOW()) AND sid = ' . $_POST['sid'];
            $shop_infos = $this -> db -> query($sql) -> row();
            if (!empty($shop_infos))
            {
                $curl_args = [
                    'numIid' => $_POST['num_iid'],
                    'fields' => 'detail_url,title,pic_url',
                ];
                $curl_exe = $this -> curlApi($shop_infos -> seller_userid, $curl_args, 'getCommodityDetail');
                extract($curl_exe);
                if (!$curl_error)  //curl无错误
                {
                    if (isset($tmpInfo -> code))  //有效请求
                    {
                        $tmpInfo -> code != 1 ? show(0, '无法获取商品信息：' .$tmpInfo -> code . $tmpInfo -> msg . TOP_APPID) : show(1, '', $tmpInfo -> data);
                    }
                    else
                        show(0, $tmpInfo -> msg);
                }
                else
                    show(0, $curl_error);
            }
            else
                show(0, '您尚未授权淘宝接口服务，或者该服务已经过期了');
        }
        else
            show(0, '参数错误');
    }
}
