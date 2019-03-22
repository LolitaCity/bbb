<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Member extends CI_Controller {

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
	    $id = $this->session->userdata('sellerid');
	    $db['info'] = $this->user->getInfo($id);
	    $db['showcontent'] =1 ;
	    $db['service1'] = $this->system->getInfo(87);
	    $db['service2'] = $this->system->getInfo(88);

	    $db['shops']=$this->shop->getcountlist($id,'all');
        //echo $db['info']->Money.'<br>';//当前账户金额
        $countmoney=0;//获取到已发任务的佣金金额
        // 获取到时间表
        $timelist = $this->task->getThisTime($db['info']->id);
        // 获取到模型表
        $modellist = $this->task->getModel($db['info']->id);
        //获取任务总表信息
        $tasklist = $this->task->getUserid($db['info']->id);
        //var_dump($oldtasklist);
        $thistime = @strtotime(@date('Y-m-d H:i:s'));


        foreach($timelist as $vo){
            if($vo->close < $thistime){
                if($vo->number > ($vo->takenumber+$vo->del)){
                    $needdeltask =$needdelmodel = $dbt['del'] = $vo->number - $vo->takenumber ;
                    $this->task->updatatime($vo->id,$dbt);
                    /*修改模型表数据*/
                    foreach ($modellist as $vml){
                        if($vml->pid == $vo->pid){
                            if($vml->number > ($vml->takenumber+$vml->del) ){
                                // 需要删除数量    $needdelmodel
                                if($needdelmodel>0){
                                    $delmodel = $vml->number-($vml->takenumber+$vml->del);
                                    if($needdelmodel > $delmodel){
                                        $needdelmodel = $needdelmodel-$delmodel;
                                        $dbm['del']=$delmodel+$vml->del;
                                    }else{
                                        $dbm['del']=$needdelmodel+$vml->del;
                                        $needdelmodel=0;
                                    }
                                    $this->task->updatamodel($vml->id,$dbm);
                                }
                            }
                        }
                       // echo $dbt['del'].'<br>';
                    }
                    /*模型表修改完成*/
                    /* 修改任务总表信息*/
                    foreach($tasklist as $vtl){
                        if($vo->pid == $vtl->mark){
                            if($vtl->number > ($vtl->qrnumber+$vtl->del) ){
                                $deltask = $vtl->number - $vtl->qrnumber - $vtl->del;
                                if($needdeltask > $deltask){
                                    $needdeltask = $needdeltask - $deltask;
                                    $dba['del'] = $deltask + $vtl->del;
                                }else{
                                    $dba['del'] = $needdeltask+$vtl->del;
                                }
                                $this->task->updata($vtl->id,$dba);
                            }
                        }
                    }
                    /* 任务总表修改完成 */
                }
            }
        }
        //获取完成所有已发布任务所需金额
        $countmoney=0;
        foreach($modellist as $vml){
            if($vml->number > ($vml->takenumber + $vml->del)){
                $countmoney += ($vml->number- $vml->takenumber -$vml->del)*$vml->commission +  ($vml->number- $vml->takenumber -$vml->del) * $vml->express  ;
            }
        }
        // 获取所有的置顶费用信息
        $counttop =0;
        foreach($tasklist as $vtl){
            if($vtl->number > ($vtl->qrnumber + $vtl->del)){
                $counttop += ($vtl->number - $vtl->qrnumber - $vtl->del) * $vtl->top;
            }
        }
        $db['faburenwuyongjin'] = $countmoney + $counttop;

		$this->load->view('membase',$db);
	}
	public function editPWD(){
	    $id = $this->session->userdata('sellerid');
	    $db['info'] = $this->user->getInfo($id);
	    $db['service1'] = $this->system->getInfo(87);
	    $db['service2'] = $this->system->getInfo(88);
	    $this->load->view('EditPwd',$db);
	}
	public function editPwdDB(){
	    $check=$_POST['safePwd'];
	    $id = $this->session->userdata('sellerid');
	    $info = $this->user->getInfo($id);
	    $db['service1'] = $this->system->getInfo(87);
	    $db['service2'] = $this->system->getInfo(88);
	    $db='';
	    if($info->SafePwd == md5($check)){
	        $dbs['PassWord']= md5(@$_POST['newPwd']);
	        $re=$this->user->updata($id,$dbs);
	        if($re){
	            $db['status']=true;
	            $db['info']='登录密码修改成功!';
	        }else{
	            $db['status']=false;
	            $db['info']='系统繁忙中，请稍后重试！';
	        }
	    }else{
	        $db['status']=false;
	        $db['info']='验证支付密码错误！';
	    }
	    echo json_encode($db);
	}
	public function editSafePwdDB(){
	    $check=@$_POST['pwd'];
	    $id = $this->session->userdata('sellerid');
	    $info = $this->user->getInfo($id);
	    $db='';
	    if($info->PassWord == md5($check)){
	        $dbs['SafePwd']=md5(@$_POST['newSafePwd']);
	        $re=$this->user->updata($id,$dbs);
	        if($re){
	            $db['status']=true;
	            $db['info']='支付密码修改成功!';
	        }else{
	            $db['status']=false;
	            $db['info']='系统繁忙中，请稍后重试！';
	        } 
	    }else{
	        $db['status']=false;
	        $db['info']='验证登录密码错误！';
	    }
        $db['pwd'] = $info->PassWord;
	    $db['show'] = $check;
	    $db['new'] = md5($check);
	    echo json_encode($db);
	}
	public function editQQDB(){
	    $id = $this->session->userdata('sellerid');
	    $info = $this->user->getInfo($id);
	    $db['service1'] = $this->system->getInfo(87);
	    $db['service2'] = $this->system->getInfo(88);
	    $check=@$_POST['safePwd'];
	    $db='';
        if($info->SafePwd == md5($check)){
	        $dbs['QQToken']=@$_POST['newQQ'];
	        $re=$this->user->updata($id,$dbs);
	        if($re){
	            $db['status']=true;
	            $db['info']='登录密码修改成功!';
	        }else{
	            $db['status']=false;
	            $db['info']='系统繁忙中，请稍后重试！';
	        } 
	        $db['status']=true;
	        $db['info']='登录密码修改成功!';
	    }else{
	        $db['status']=false;
	        $db['info']='请重新输入支付密码！';
	    }
	    echo json_encode($db);  
	}
	public function editWehat(){
	    $id = $this->session->userdata('sellerid');
	    $info = $this->user->getInfo($id);
	    $db['service1'] = $this->system->getInfo(87);
	    $db['service2'] = $this->system->getInfo(88);
	    $check=@$_POST['safePwd'];
	    $db='';
	    if($info->PassWord == md5($check)){
	        $dbs['wechat']=@$_POST['newQQ'];
	        $re=$this->user->updata($id,$dbs);
	        if($re){
	            $db['status']=true;
	            $db['info']='登录密码修改成功!';
	        }else{
	            $db['status']=false;
	            $db['info']='系统繁忙中，请稍后重试！';
	        }
	        $db['status']=true;
	        $db['info']='登录密码修改成功!';
	    }else{
	        $db['status']=false;
	        $db['info']='请重新输入支付密码！';
	    }
	    echo json_encode($db);
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
	    $page=@$_GET['page']==''?0:@$_GET['page'];
	    $id=$this->session->userdata('sellerid');
	    $db['info']=$this->user->getInfo($id);
	    $db['showcontent']=1;
	    $db['service1'] = $this->system->getInfo(87);
	    $db['service2'] = $this->system->getInfo(88);
	    $db['countshop']=$this->shop->getcount($id);
	    $db['list']=$this->shop->getlist($id,'all',1,4,4*$page);
	    $db['count']=$this->shop->getcountlist($id,'all');
	    $db['pageno']=ceil($db['count']/4);
	    $db['page']=$page;
		$this->load->view('shop',$db);
	}
    public function addShop()//添加店铺
	{	    
	    $id = $this->session->userdata('sellerid');
	    $db['info'] = $this->user->getInfo($id);
	    $db['showcontent'] =1 ;
	    $db['service1'] = $this->system->getInfo(87);
	    $db['service2'] = $this->system->getInfo(88);
		$this->load->view('addshop',$db);
	}
	public function addShopDB(){
	    $db['userid']=$_POST['userid'];
	    $db['type']=$_POST['ChildPlatformType'];
	    $db['manager_num']=$_POST['PlatformNoID'];
	    $db['shopname']=$_POST['ShopName'];
	    $db['nature']=$_POST['ShopNature'];
	    $db['sendname']=$_POST['SenderName'];
	    $db['sendphone']=$_POST['SenderTel'];
	    $db['sendprovince']=$_POST['cmbProvince'];
	    $db['sendcity']=$_POST['cmbCity'];
	    $db['senddistrict']=$_POST['cmbArea'];
	    $db['sendarea']=$db['sendprovince'].$db['sendcity'].$db['senddistrict'];
	    $db['sendaddress']=$_POST['DetailAddress'];
	    $images=$this->sys->upFile('upfile1');
	    $db['addtime']=@strtotime(@date('Y-m-d H:i:s'));
	    $db['addIP']=$this->sys->GetIp();
	    $db['status']=0;
	    $db['auditing']=0;
	    if($db['manager_num']==''){
	        echo "<script>alert('掌柜号不能为空！');history.back();</script>";
	        exit;
	    }
	    if($db['shopname']==''){
	        echo "<script>alert('店铺名称不能为空！');history.back();</script>";
	        exit;
	    }
	    if($db['sendname']==''){
	        echo "<script>alert('发货人姓名不能为空！');history.back();</script>";
	        exit;
	    }
	    if(!$this->checkphone($db['sendphone'])){
	        echo "<script>alert('手机号码格式不真确，请认真填写');history.back();</script>";
	        exit;
	    }
	    if($db['sendaddress']==''){
	        echo "<script>alert('发货详细地址不能为空！');history.back();</script>";
	        exit;
	    }
	    if($images){
	        $db['images'] = site_url().$images;
	        $re = $this->shop->add($db);
	        if($re){
	            echo "<script>alert('店铺添加成功！等待审核后方可以使用！'); parent.location.reload();</script>";
	        }else{
	            echo "<script>alert('添加失败了，再来一次试试！');history.back();</script>";
	        }
	    }else{
	        echo "<script>alert('请先上传图片！或上传的图片过大（这里只能上传文件大小不超过2M的图片）');history.back();</script>";
	    }
	}
	public function editShop($id=0){
	    if($id==0){
	        echo "<script>alert('请不要尝试错误链接！谢谢。');history.back();</script>";
	    }else{
	        $db['info']=$this->shop->getInfo($id);
	        if($db['info']!=null){
		        $this->load->view('seeshop',$db);
	        }else{
	            echo "<script>alert('您要查看的信息已经消失在二次元空间了，刷新页面后查看内容！');history.back();</script>";
	        }	    
	    }
	}
	public function editShopInfoDB(){
	    $db['type']=$_POST['ChildPlatformType'];
	    $db['manager_num']=$_POST['PlatformNoID'];
	    $db['shopname']=$_POST['ShopName'];
	    $db['nature']=$_POST['ShopNature'];
	    $db['sendname']=$_POST['SenderName'];
	    $db['sendphone']=$_POST['SenderTel'];
	    $db['sendprovince']=$_POST['cmbProvince'];
	    $db['sendcity']=$_POST['cmbCity'];
	    $db['senddistrict']=$_POST['cmbArea'];
	    $db['sendarea']=$db['sendprovince'].$db['sendcity'].$db['senddistrict'];
	    $db['sendaddress']=$_POST['DetailAddress'];
	    $images=$this->sys->upFile('upfile1');
	    $db['addtime']=@strtotime(@date('Y-m-d H:i:s'));
	    $db['addIP']=$this->sys->GetIp();
	    $db['status']=0;
	    $db['auditing']=0;
	    if($images){
	        $db['images'] = site_url().$images;	        
	    }
	    $id=$_POST['userid'];

	    if($db['manager_num']==''){
	        echo "<script>alert('掌柜号不能为空！');history.back();</script>";
	        exit;
	    }
	    if($db['shopname']==''){
	        echo "<script>alert('店铺名称不能为空！');history.back();</script>";
	        exit;
	    }
	    if($db['sendname']==''){
	        echo "<script>alert('发货人姓名不能为空！');history.back();</script>";
	        exit;
	    }
	    if(!$this->checkphone($db['sendphone'])){
	        echo "<script>alert('手机号码格式不真确，请认真填写');history.back();</script>";
	        exit;
	    }
	    if($db['sendaddress']==''){
	        echo "<script>alert('发货详细地址不能为空！');history.back();</script>";
	        exit;
	    }
	    
	    $re = $this->shop->updata($id,$db);
	    if($re){
	        echo "<script>alert('店铺信息编辑成功！等待审核后方可以使用！'); parent.location.reload();</script>";
	        //$this->store();
	    }else{
	        echo "<script>alert('修改失败了，再来一次试试！');history.back();</script>";
	    }
	    
	}
    public function delShop()//删除店铺
	{	    
	    $key=$_GET['id']==''?0:$_GET['id'];
	    if($key==0){
	        echo "<script>alert('请不要测试错误链接！');history.back();</script>";
	    }else{
	        $id = $this->session->userdata('sellerid');
	        $list = $this->product->getListCount($id,$key,'all','all');
	        if($list==0){
    	        $re=$this->shop->getInfo($key);
    	        if($re!=null){
    	            $redel=$this->shop->del($key);
    	            if($redel){
        	            echo "<script>alert('删除成功了！');</script>";
        	            $this->store();
    	            }else{
    	                echo "<script>alert('系统繁忙中，请稍后重试！');history.back();</script>";
    	            }
    	        }else{
    	            echo "<script>alert('您要删除的数据已经消失在二次元空间！请刷新页面后重新操作！');history.back();</script>";
    	        }
	        }else{
	            echo "<script>alert('该店铺下有很多产品。不能直接删除店铺的哦！');history.back();</script>";
	        }
	    }
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
	public function detailShop($key=0){// 店铺详细信息
	    $id = $this->session->userdata('sellerid');
	    $db['service1'] = $this->system->getInfo(87);
	    $db['service2'] = $this->system->getInfo(88);
	    //$db['info'] = $this->user->getInfo($id);
	    if($key==0){
	        echo "<script>alert('请不要尝试错误链接，谢谢！');history.back();</script>";
	    }else{
        	$db['info']=$this->shop->getInfo($key);
	        if($db['info']!=null){
        		$this->load->view('shopInfo',$db);
	        }else{
	            echo "<script>alert('您查找的店铺信息已经消失在二次元空间了！');history.back();</script>";
	        }
	    }
	}
	
    public function product()// 商品管理
	{	    
	    $page = @$_GET['page']==''?0:@$_GET['page'];
	    $id = $this->session->userdata('sellerid');
	    $db['info'] = $this->user->getInfo($id);
	    $db['showcontent'] =1 ;
	    $db['service1'] = $this->system->getInfo(87);
	    $db['service2'] = $this->system->getInfo(88);
	    $db['shoplist'] = $this->shop->getlist($id,1,0,0,0);
	    $db['proname']='';
	    $db['proid']='';
	    $db['shopid']='';
	    $db['product']=$this->product->getList($id,'all','all','all',1,10,10*$page);	
	    $db['page']=$page;
	    $db['count'] = $this->product->getListCount($id,'all','all','all');
	    $db['search'] =false;
		$this->load->view('producta',$db);
	}
	public function search(){
	    $id = $this->session->userdata('sellerid');
	    $db['info']=$this->user->getInfo($id);
	    $db['showcontent']=1;
	    $db['service1'] = $this->system->getInfo(87);
	    $db['service2'] = $this->system->getInfo(88);
	    $db['shoplist']=$this->shop->getlist($id,1,0,0,0);
	    $db['proname']=@$_POST['Name']==''?'':@$_POST['Name'];
	    $db['proid']=@$_POST['ProductPlatformID']==''?'':@$_POST['ProductPlatformID'];
	    $db['shopid']=@$_POST['PlatformNoID']==''?'':@$_POST['PlatformNoID'];
	    $db['search'] = true;
	    $db['product']=$this->product->getList($id,$db['shopid']=='0'?'all':$db['shopid'],$db['proid']==''?'all':$db['proid'],$db['proname']==''?'all':$db['proname'],0,0,0);
	    
		$this->load->view('producta',$db);
	}
	public function proadd(){
	    $id = $this->session->userdata('sellerid');
	    $db['info'] = $this->user->getInfo($id);
	    $db['showcontent'] =1 ;
	    $db['service1'] = $this->system->getInfo(87);
	    $db['service2'] = $this->system->getInfo(88);
	    $db['shoplist']=$this->shop->getlist($id,1,0,0,0);
	    
		$this->load->view('Create',$db);
	}
	public function proAddDB(){
	    $db['userid']=$_POST['userid'];
	    $db['shopid']=$_POST['PlatformNoID'];
	    $db['commodity_id']=$_POST['ID'];
	    $db['commodity_abbreviation']=$_POST['ShortName'];
	    $db['commodity_title']=$_POST['FullName'];
	    $db['commodity_url']=$_POST['Url'];
	    $db['status']=0;
	    $db['peostatus']=0;
	    $db['addtime']=@strtotime(@date('Y-m-d H:i:s'));
	    $db['addIP']=$this->sys->GetIp();

	    $commodity_image=$this->sys->upFile('product');
	    $qrcode=$this->sys->upFile('qrcode');
	    if($db['shopid']==0){
	        echo "<script>alert('请先选择产品所属店铺。');history.back();</script>";
	        exit;
	    }
	    if($db['commodity_url']==''){
	        echo "<script>alert('请填写好产品的完整网址');history.back();</script>";
	        exit;
	    }
	    if($db['commodity_title']==''){
	        echo "<script>alert('请填写好产品的名称');history.back();</script>";
	        exit;
	    }
	    if($db['commodity_abbreviation']==''){
	        echo "<script>alert('请填写好产品的简称！');history.back();</script>";
	        exit;
	    }
	    if($db['commodity_id']==''){
	        echo "<script>alert('请填写好产品的淘宝ID号，方便管理产品！');history.back();</script>";
	        exit;
	    }
	    if($commodity_image){
	        $db['commodity_image']=site_url().$commodity_image;
	    }else{
	        echo "<script>alert('请先上传产品主图');history.back();</script>";
	        exit;
	    }
	    if($qrcode){
	        $db['qrcode']=site_url().$qrcode;
	    }else{
	        echo "<script>alert('请先上传产品二维码图片');history.back();</script>";
	        exit;
	    }
	    $re = $this->product->add($db);
	    if($re){
	        echo "<script>alert('产品上传成功！');</script>";
	        echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=../member/product.html\" >";
	    }else{
	        echo "<script>alert('产品上传失败了，重新尝试一下！');history.back();</script>";
	    }
	    
	}
	public function editpro($key=0){
	    if($key==0){
	        echo "<script>alert('请不要测试错误链接');history.back();</script>";
	    }else{
	        $id = $this->session->userdata('sellerid');
	        $db['info'] = $this->user->getInfo($id);
	        $db['showcontent'] =1 ;
    	    $db['service1'] = $this->system->getInfo(87);
    	    $db['service2'] = $this->system->getInfo(88);
    	    $db['shoplist']=$this->shop->getlist($id,1,0,0,0);
    	    $db['proinfo'] = $this->product->getInfo($key);
    		$this->load->view('Editpro',$db);
	    }
	}
	public function editDB(){
	    $id=$_POST['proid'];
	    $db['shopid']=$_POST['PlatformNoID'];
	    $db['commodity_id']=$_POST['ID'];
	    $db['commodity_abbreviation']=$_POST['ShortName'];
	    $db['commodity_title']=$_POST['FullName'];
	    $db['commodity_url']=$_POST['Url'];
	    $db['status']=0;
	    $db['addtime']=@strtotime(@date('Y-m-d H:i:s'));
	    $db['addIP']=$this->sys->GetIp();
	    $commodity_image=$this->sys->upFile('product');
	    $qrcode=$this->sys->upFile('qrcode');
	    
	    if($db['shopid']==0){
	        echo "<script>alert('请先选择产品所属店铺。');history.back();</script>";
	        exit;
	    }
	    if($db['commodity_url']==''){
	        echo "<script>alert('请填写好产品的完整网址');history.back();</script>";
	        exit;
	    }
	    if($db['commodity_title']==''){
	        echo "<script>alert('请填写好产品的名称');history.back();</script>";
	        exit;
	    }
	    if($db['commodity_abbreviation']==''){
	        echo "<script>alert('请填写好产品的简称！');history.back();</script>";
	        exit;
	    }
	    if($db['commodity_id']==''){
	        echo "<script>alert('请填写好产品的淘宝ID号，方便管理产品！');history.back();</script>";
	        exit;
	    }
	    if($commodity_image){
	        $db['commodity_image']=site_url().$commodity_image;
	    }
	    if($qrcode){
	        $db['qrcode']=site_url().$qrcode;
	    }
	    
	    $re = $this->product->updata($id,$db);
	    if($re){
	        echo "<script>alert('产品信息修改成功！');</script>";
	        $this->product();
	    }else{
	        echo "<script>alert('还差那么一点点就编辑成功了，再尝试一次不一定就成功了呢！');history.back();</script>";
	    }
	    
	}
	public function delpro(){
	    $key=@$_GET['id']==''?0:@$_GET['id'];
	    if($key==0){
	        echo "<script>alert('请不要测试错误链接！');history.back();</script>";
	    }else{
	        $list = $this->task->Prodel($this->session->userdata('sellerid'),$key);
	        if($list != 0){
	            echo "<script>alert('当前产品还有发布了的任务-- 不能直接删除商品哦！ 若需删除商品，请待系统清除任务数据后删除！谢谢您的理解');history.back();</script>";
	        }else{
    	        $db['info']=$this->product->getInfo($key);
    	        if($db['info']!=null){
    	            $re=$this->product->delete($key);
    	            if($re){
    	                echo "<script>alert('删除成功！');</script>";
    	                $this->product();
    	            }else{
    	                echo "<script>alert('距离成功只还差一步，您再尝试一次或许就成功了！');history.back();</script>";
    	            }
    	        }else{
    	            echo "<script>alert('您要删除的信息已经不存在了，请刷新页面后查看最新信息！');history.back();</script>";
    	        }
    	    }
	    }
	}
	public function delarr(){
	    $arr=$_GET['arr'];
	    $arr = explode(",", $arr);
	    if(count($arr)==0){
	        echo "<script>alert('警告，警告，警告！错误操作！');history.back();</script>";
	    }else{
	        $re = $this->product->deleteArr($arr);
	        if($re){
	            echo "<script>alert('删除成功！');</script>";
	            $this->product();
	        }else{
	            echo "<script>alert('系统繁忙中，清稍后重试！');history.back();</script>";
	        }
	    }
	}
	public function seepro($id=0){
	    if($id==0){
	        echo "<script>alert('请不要测试错误链接，谢谢！');history.back();</script>";
	    }else{
	        $db['proinfo']=$this->product->getInfo($id);
	        if($db['proinfo']!=null){
        	    $id = $this->session->userdata('sellerid');
        	    $db['info'] = $this->user->getInfo($id);
    	        $db['shoplist']=$this->shop->getlist($id,1,0,0,0);
        	    $db['showcontent'] =1 ;
        	    $db['service1'] = $this->system->getInfo(87);
        	    $db['service2'] = $this->system->getInfo(88);
        	    $this->load->view('DetailsProduct',$db);
	        }else{
	            echo "<script>alert('您要查看的信息已经消失在二次元空间，请刷新页面更新到所有数据以后尝试！');history.back();</script>";
	        }
	    }
	}
	public function sitepro(){
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
	public function siteproDB(){
	    $id=$_POST['ProductID'];
	    $db['status']=1;
	    $sex['man']=$sexman=$_POST['PercentPlatformNoSexMale'];
	    $sex['woman']=$sexwomen=$_POST['PercentPlatformNoSexFemale'];
	    $age['younger']=$agel=$_POST['PercentPlatformNoAge18_24'];
	    $age['middle']=$agem=$_POST['PercentPlatformNoAge25_29'];
	    $age['older']=$ageo=$_POST['PercentPlatformNoAge30_34'];
	    $area=$_POST['RegionIds'];
	    //数组序列化储存到数据库
	    $db['sex']=serialize($sex);
	    $db['age']=serialize($age);
	    $db['region']=serialize($area);
	    $re=$this->product->updata($id,$db);
	    if($re){
	        echo "<script>alert('设置成功！');parent.location.reload();</script>";	        
	    }else{
	        echo "<script>alert('还差那么一点点就可以设置成功了，再来一次吧！');history.back();</script>";
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
	    if($re){
	        echo "<script>alert('设置成功！');parent.location.reload();</script>";	        
	    }else{
	        echo "<script>alert('还差那么一点点就可以设置成功了，再来一次吧！');history.back();</script>";
	    } 
	    
	}
	public function notice()// 平台公告
	{	    
	    $page=@$_GET['page']==''?0:@$_GET['page'];
	    $id = $this->session->userdata('sellerid');
	    $db['info'] = $this->user->getInfo($id);
	    $db['showcontent'] =1 ;

	    $db['service1'] = $this->system->getInfo(87);
	    $db['service2'] = $this->system->getInfo(88);
	    $db['lists']=$this->article->getList(38,10,$page*10);
	    $db['count']=$this->article->getCount(38);
	    $db['page']=$page;
	    
		$this->load->view('notice',$db);
	}
	public function detailnotice($key=0){
	    //echo $key;
	    if($key===0){
	        echo "<script>alert('请不要测试错误链接！');history.back();</script>";
	        exit;
	    }else{
    	    $id = $this->session->userdata('sellerid');
    	    $db['info'] = $this->user->getInfo($id);
    	    $db['showcontent'] =1 ;
    	    $db['service1'] = $this->system->getInfo(87);
    	    $db['service2'] = $this->system->getInfo(88);
    	    $db['newinfo']=$this->article->getInfos($key);
	        $this->load->view('noticeinfo',$db);
	    }
	}
	public function transferShow(){
    	$id = $this->session->userdata('sellerid');
    	$db['info'] = $this->user->getInfo($id);
    	$db['showcontent'] =1 ;
    	$db['service1'] = $this->system->getInfo(87);
    	$db['service2'] = $this->system->getInfo(88);
    	$db['newinfo']=$this->article->getInfosOne(47);
	    $this->load->view('noticeinfo',$db);
	}
    public function edit()// 调整单量
	{	    
	    $id = $this->session->userdata('sellerid');
	    $db['info'] = $this->user->getInfo($id);
	    $db['showcontent'] =1 ;
	    $db['service1'] = $this->system->getInfo(87);
	    $db['service2'] = $this->system->getInfo(88);
	    $db['infocount'] = $this->shop->getcount($id);	
		$this->load->view('edit',$db);
	}
	public function join(){
	    $page=@$_GET['page']==''?0:@$_GET['page'];
	    $id = $this->session->userdata('sellerid');
	    $db['info'] = $this->user->getInfo($id);
	    $db['showcontent'] =1 ;
	    $db['service1'] = $this->system->getInfo(87);
	    $db['service2'] = $this->system->getInfo(88);
	    $db['userlist'] = $this->user->UserPid($id,10,10*$page);
	    $db['count'] = $this->user->CountUserPid($id);
	    $db['page'] = $page;
	    $this->load->view('Join',$db);
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

}
