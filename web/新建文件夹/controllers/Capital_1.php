<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Capital extends CI_Controller {

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
        $this->load->model('Deposit_model','deposit');
        $this->load->model('Usertask_model','usertask');
        $this->load->model('Task_model','task');
        $this->load->model('Getall_model','getall');
        $this->load->model('Flow_model','flow');
        $this->load->model('Article_model','article');
        $this->load->model('Cash_model','cashlog');
        $this->load->model('Shop_model','shop');
        $this->load->model('Product_model','pro');
        $this->load->model('Transfercash_model','transfer');
        $this->load->model('System_model','system');
        $this->load->model('Blank_model','blank');
    }
    public function index()//账号充值
	{	    
	    $id = $this->session->userdata('sellerid');
	    $db['info'] = $this->user->getInfo($id);
	    $db['showcontent'] =1 ;
	    $db['service1'] = $this->system->getInfo(87);
	    $db['service2'] = $this->system->getInfo(88);
        $db['newinfo']=$this->article->getinfo(45);
		$this->load->view('recharge',$db);
	}
	public function transfer()//转账管理 ---  未到账反馈
	{
	    $page = @$_GET['page']==''?0:@$_GET['page'];
	    $id = $this->session->userdata('sellerid');
	    $db['info'] = $this->user->getInfo($id);
	    $db['showcontent'] =1 ;
	    $db['service1'] = $this->system->getInfo(87);
	    $db['service2'] = $this->system->getInfo(88);
 	    $db['list'] = $this->transfer->getNoInfo($id,10,10*$page);
	    $db['count'] = $this->transfer->getNoInfoCount($id);
	    $db['page'] = $page;
	    if(count($db['list'])!=0){
	        $arr=array();
	        foreach($db['list'] as $key=>$vdbl){
	            $arr[$key]=$vdbl->bankid;
	        }
	        $db['bankID'] = $this->blank->getArr($arr);
	    } 	    
	    $db['search']=false;
	    $this->load->view('back',$db);
	}
	public function seacrhNo(){
	    $page = @$_GET['page']==''?0:@$_GET['page'];
	    $id = $this->session->userdata('sellerid');
	    $db['info'] = $this->user->getInfo($id);
	    $db['showcontent'] =1 ;
	    $db['service1'] = $this->system->getInfo(87);
	    $db['service2'] = $this->system->getInfo(88);
	    
	    $db['ordersn']=$ordersn = $_POST['PlatformOrderNumber'];
	    $start = $_POST['BeginDate2']==''?0:@strtotime($_POST['BeginDate2']);
	    $end = $_POST['EndDate2']==''?0:@strtotime($_POST['EndDate2']);
	    $db['list'] = $this->transfer->getNoList($id,10,10*$page,$ordersn,$start,$end);
	    $db['count'] = $this->transfer->getNoCount($id,$ordersn,$start,$end);
	    
	    
	    $db['page'] = $page;
	    if(count($db['list'])!=0){
	        $arr=array();
	        foreach($db['list'] as $key=>$vdbl){
	            $arr[$key]=$vdbl->bankid;
	        }
	        $db['bankID'] = $this->blank->getArr($arr);
	    }
	    $db['search']=true;
	    $db['start'] = $start==0?'':@date('Y-m-d H:i:s',$start);
	    $db['end'] = @$end==0?'':@date('Y-m-d H:i:s',$end);
	    $this->load->view('back',$db);
	}
	public function upDataInfo(){
	    $key=$_GET['key']==''?0:$_GET['key'];
	    if($key==0){
	        echo "<sript>alert('请不要测试错误链接。');history.back();</script>";
	    }else{
            $db['info'] = $this->transfer->getInfo($key);
            if($db['info']!=null){
	            $this->load->view('editTransfer',$db);
	        }else{
	            echo "<script>alert('您要查看的信息已经消失在二次元空间了，刷新页面后查看内容！');history.back();</script>";
	        }
	    }
	}
	public function editTransferDB(){
	    $id =$_POST['id'];
	    $images = $this->sys->upFile('fileimage');
	    if($images){
	        $db['transferimg'] = base_url().$images;
	        $re = $this->transfer->updata($id,$db);
	        if($re){
	            echo '<script>alert("凭证已上传！");parent.location.reload();</script>';
	        }else{
	            echo "<script>alert('系统正在繁忙中，请稍后重试！');history.back();</script>";
	        }
	    }else{
	        echo "<script>alert('您还没有上传图片');history.back();</script>";
	    }	    
	}
	public function FailInfo(){
	    $key = $_GET['key']==''?0:$_GET['key'];
	    if($key==0){
	        echo "<sript>alert('请不要测试错误链接。');history.back();</script>";
	    }else{
            $db['info'] = $this->transfer->getInfo($key);
            if($db['info']!=null){
                $dbs['transferstatus'] = 3;
                $re = $this->transfer->updata($db['info']->id,$dbs);
    	        if($re){
    	            echo '<script>alert("状态已修改成功！！");</script>';
    	            $this->transfer();
    	        }else{
    	            echo "<script>alert('系统正在繁忙中，请稍后重试！');history.back();</script>";
    	        }
	        }else{
	            echo "<script>alert('您要查看的信息已经消失在二次元空间了，刷新页面后查看内容！');history.back();</script>";
	        }
	    }
	}
	public function refund()//转账管理 ---  买家退款
	{
	    $id = $this->session->userdata('sellerid');
	    $db['info'] = $this->user->getInfo($id);
	    $db['showcontent'] =1 ;
	    $db['service1'] = $this->system->getInfo(87);
	    $db['service2'] = $this->system->getInfo(88);
	    $db['list']=$this->usertask->getlist($id,'all');
	    $this->load->view('refund',$db);
	}
	public function result()//转账管理 ---  转账结果
	{
	    $page = @$_GET['page']==''?0:@$_GET['page'];
	    $id = $this->session->userdata('sellerid');
	    $db['info'] = $this->user->getInfo($id);
	    $db['showcontent'] =1 ;
	    $db['service1'] = $this->system->getInfo(87);
	    $db['service2'] = $this->system->getInfo(88);
	    
	    $db['list']=$this->transfer->getResult($id,10,10*$page);
	    $db['count']=$this->transfer->getCountResult($id);
	    $db['page']=$page;
	    if(count($db['list'])!=0){
	        $arr=array();
	        $ssarr = array();
	        foreach($db['list'] as $key=>$vdl){
	            $arr[$key]=$vdl->merchantid;
	            $ssarr[$key]=$vdl->bankid;
	        }
	        $db['shopbank'] = $this->blank->getArr($arr);
	        $db['ssbank'] = $this->blank->getArr($ssarr);
	    }
	    $db['search']=false;
	    $this->load->view('result',$db);
	}
	public function searchResult(){
	    $page = @$_GET['page']==''?0:@$_GET['page'];
	    $id = $this->session->userdata('sellerid');
	    $db['info'] = $this->user->getInfo($id);
	    $db['showcontent'] =1 ;
	    $db['service1'] = $this->system->getInfo(87);
	    $db['service2'] = $this->system->getInfo(88);
	     
	    //获取提交的条件信息
	    $ordersn = $_POST['PlatformOrderNumber'];
	    $statustype = $_POST['TransferStatus'];
	    $start = $_POST['BeginDate2']==''?0:@strtotime($_POST['BeginDate2']);
	    $end = $_POST['EndDate2']==''?0:@strtotime($_POST['EndDate2']);
	    if($start!=0 && $end!=0){
	        if($start>time()){
	           echo "<script>alert('开始时间不能大于当前时间');</script>";
	           exit;
	        }
	        if($end>$start){
	            echo "<script>alert('开始时间不能大于结束时间');</script>";
	            exit;
	        }
	    }
	  //  echo $ordersn.'<br>'.$statustype.'<br>'.$start.'<br>'.$end;
	    //exit;
	    $db['list']=$this->transfer->getSearchResult($id,10,10*$page,$ordersn,$statustype,$start,$end);
	    $db['count']=$this->transfer->getCountSearchResult($id,$ordersn,$statustype,$start,$end);
	    //var_dump($db['list']);
	    $db['page']=$page;
	    if(count($db['list'])!=0){
	        $arr=array();
	        $ssarr = array();
	        foreach($db['list'] as $key=>$vdl){
	            $arr[$key]=$vdl->merchantid;
	            $ssarr[$key]=$vdl->bankid;
	        }
	        $db['shopbank'] = $this->blank->getArr($arr);
	        $db['ssbank'] = $this->blank->getArr($ssarr);
	    }
	    $db['search']=true;
	    $db['ordersn'] = $ordersn;
	    $db['type'] = $statustype;
	    $db['start'] = $start==0?'':@date('Y-m-d H:i:s',$start);
	    $db['end'] = $end==0?'':@date('Y-m-d H:i:s',$end);
	    $this->load->view('result',$db);
	}
	public function wait()//转账管理 ---  等待转账
	{
	    $page = @$_GET['page']==''?0:@$_GET['page'];
	    $id = $this->session->userdata('sellerid');
	    $db['info'] = $this->user->getInfo($id);
	    $db['showcontent'] =1 ;
	    $db['service1'] = $this->system->getInfo(87);
	    $db['service2'] = $this->system->getInfo(88);
	    // 获取会员绑定的银行卡
	    $db['userbank'] = $this->blank->getOne($id);
	    //var_dump($db['userbank']);
	    $db['list'] = $this->transfer->getList($id,10,10*$page);
	    $db['page'] = $page;
	    $db['count'] = $this->transfer->CountList($id);
	    $arr=array();$n=0;
	    foreach($db['list'] as $vd){
	        $arr[$n++] = $vd->bankid;
	    }
	    //var_dump($arr);
	    if(count($arr)!=0){
	       $db['banks']=$this->blank->getArr($arr);
	    }
	    $db['search'] = false;
	    
	    $this->load->view('wait',$db);
	}	
	public function search(){
	    $id = $this->session->userdata('sellerid');
	    $db['info'] = $this->user->getInfo($id);
	    $db['showcontent'] =1 ;
	    $db['service1'] = $this->system->getInfo(87);
	    $db['service2'] = $this->system->getInfo(88);	    
	    $db['userbank'] = $this->blank->getOne($id);
	    //获取查询列表的内容信息
	    $db['TransferStatus']=$exceloutstatus=$_POST['TransferStatus'];
	    $db['PlatformOrderNumber']=$ordersn = $_POST['PlatformOrderNumber'];
	    $db['BeginDate2']=$start = $_POST['BeginDate2']==''?0:@strtotime($_POST['BeginDate2']);
	    $db['EndDate2']=$end = $_POST['EndDate2']==''?0:@strtotime($_POST['EndDate2']);
	    if($start!=0 && $end!=0){
	        if($end < $start){
	            echo "<script>alert('开始时间不能大于结束时间');history.back();</script>";
	            exit;
	        }
	    }
	    $db['list'] =$this->transfer->getSearchTime($id,$exceloutstatus,$ordersn,$start,$end);

	    
	    $db['search'] = true;
	    $arr=array();$n=0;
	    foreach($db['list'] as $vd){
	        $arr[$n++] = $vd->bankid;
	    }
	    //var_dump($arr);
	    if(count($arr)!=0){
	        $db['banks']=$this->blank->getArr($arr);
	    }
	    $this->load->view('wait',$db);
	}
	public function Transfercash(){
	    $key =$_GET['key']==''?0:$_GET['key'];
	    //echo "<script>alert(".$key.");</script>";
	    if($key==0){
	        echo "<script>alert('请不要尝试错误链接！');history.back();</script>";
	    }else{
    	     $id = $this->session->userdata('sellerid');	    
    	     $userbank = $this->blank->getOne($id);
    	    // var_dump($userbank);
    	    // exit;
        	  if($userbank!=null){
        	         $arrkey=explode(',', $key);
        	         $arrkey=array_filter($arrkey);
        	         $db['transferstatus']=2;
        	         $db['transferbank']=$userbank->bankAccount;
        	         $db['transfername']=$userbank->truename;
        	         $db['updatetime']=time();
        	         
        	         $re=$this->transfer->updataPass($arrkey,$db);
        	         if($re){
        	             echo '<script>alert("提交成功了！");</script>';
        	             $this->wait();
        	         }else{
        	             echo "<script>alert('系统现在繁忙中，请稍后重试');history.back();</script>";
        	         }
    	       }else{
    	           echo "<script>alert('请先绑定您的转账银行卡');history.back();</script>";
    	       }
	    }
	}
	public function AllTransfercash(){
    	$id = $this->session->userdata('sellerid');	    
    	$userbank = $this->blank->getOne($id);
    	if($userbank !=null){
        	$list = $this->transfer->getListAllNo($id);
        	//var_dump($list);
        	if(count($list)==0){
        	    echo "<script>alert('暂时没有数据需要转账的需求哦！');history.back();</script>";
        	}else{
        	    $arrkey = array();
        	    $n=0;
        	    foreach ($list as $key=>$vl){
        	        $arrkey[$n++]=$vl->id;
        	    }
        	    $db['transferstatus']=2;
        	    $db['transferbank']=$userbank->bankAccount;
        	    $db['transfername']=$userbank->truename;
    	        $db['updatetime']=time();
    	        //var_dump($arrkey);
        	    $re=$this->transfer->updataPass($arrkey,$db);
        	    if($re){
        	        echo '<script>alert("提交成功了！");</script>';
        	        $this->wait();
        	    }else{
        	        echo "<script>alert('系统现在繁忙中，请稍后重试');history.back();</script>";
        	    }
        	}
    	}else{
    	    echo "<script>alert('请先绑定转账的银行卡！否则无法转账成功！ ^ ^');history.back();</script>";
    	}
	}
	public function FailTransfercash(){
	    $key =$_GET['key']==''?0:$_GET['key'];
	   // echo "<script>alert(".$key.");</script>";
	    if($key==0){
	        echo "<script>alert('请不要尝试错误链接！');history.back();</script>";
	    }else{
    	     $id = $this->session->userdata('sellerid');	    
    	     $userbank = $this->blank->getOne($id);
    	    // var_dump($userbank);
    	    // exit;
    	    if($userbank !=null){
    	         $arrkey=explode(',', $key);
    	         $arrkey=array_filter($arrkey);
    	         $db['transferstatus']=3;
    	         $db['transferbank']=$userbank->bankAccount;
    	         $db['transfername']=$userbank->truename;
    	         $db['updatetime']=time();
    	         $re=$this->transfer->updataPass($arrkey,$db);
    	         if($re){
    	             echo '<script>alert("提交成功了！");</script>';
    	             $this->wait();
    	         }else{
    	             echo "<script>alert('系统现在繁忙中，请稍后重试');history.back();</script>";
    	         }
    	    }else{
    	        echo "<script>alert('请先绑定转账的银行卡！否则无法提交信息！ ^ ^');history.back();</script>";
    	    }
	    }
	}
	public function addBank(){
	    $id = $this->session->userdata('sellerid');
	    $db['info'] = $this->user->getInfo($id);
	    $db['userbank'] = $this->blank->getOne($id);
	    $this->load->view('AddDefaultBank',$db);	    
	}
	public function addBankDB(){
	    $safepwd = $_POST['PayWord'];	
	    $db['userid'] = $_POST['id'];
	    $info = $this->user->getInfo($db['userid']);
	    if($info->SafePwd== md5($safepwd)){
    	    $db['bankName'] = $_POST['BankName'];
    	    $db['truename'] = $_POST['AccountName'];
    	    $db['bankAccount'] = $_POST['CardNumber'];
    	    $db['status'] = 1;
    	    $db['time'] = time();
    	    $db['isdefault']= 1;
    	    $re = $this->blank->add($db);
    	    if($re){
    	        echo "<script>alert('银行卡绑定成功！');parent.location.reload();</script>";
    	    }else{
    	        echo "<script>alert('系统现在繁忙中，请稍后重试！');history.back();</script>";
    	    }
	    }else{
	        echo "<script>alert('您的支付密码错误，请重新输入！');history.back();</script>";
	    }
	}
	public function editBank(){
	    $id = $this->session->userdata('sellerid');
	    $db['info'] = $this->user->getInfo($id);
	    $db['userbank'] = $this->blank->getOne($id);
	    $this->load->view('EditDefaultBank',$db);	    
	}
	public function editBankDB(){
	    $safepwd = $_POST['PayWord'];
	    $bankid = $_POST['bankid'];
	    $db['userid'] = $_POST['id'];
	    $info = $this->user->getInfo($db['userid']);
	    if($info->SafePwd== md5($safepwd)){
    	    $db['bankName'] = $_POST['BankName'];
    	    $db['truename'] = $_POST['AccountName'];
    	    $db['bankAccount'] = $_POST['CardNumber'];
    	    $db['status'] = 1;
    	    //$db['time'] = time();
    	    $db['isdefault']= 1;
    	    $re = $this->blank->updata($bankid,$db);
    	    if($re){
    	        echo "<script>alert('新银行卡绑定成功！');parent.location.reload();</script>";
    	    }else{
    	        echo "<script>alert('系统现在繁忙中，请稍后重试！');history.back();</script>";
    	    }
	    }else{
	        echo "<script>alert('您的支付密码错误，请重新输入！');history.back();</script>";
	    }	    
	}
	public function change()//发布点兑换
	{
	    $id = $this->session->userdata('sellerid');
	    $db['info'] = $this->user->getInfo($id);
	    $db['showcontent'] =1 ;
	    $db['service1'] = $this->system->getInfo(87);
	    $db['service2'] = $this->system->getInfo(88);
	    $this->load->view('change',$db);
	}
	public function changeDB(){
	    $id=$_POST['id'];
	    $MinLi=$_POST['txtPrice'];
	    $Money=$_POST['txtPoint'];
	    $txtDHType=$_POST['DHType'];
	    $userinfo=$this->user->getInfo($id);
	    if($txtDHType==0){//钱转点
	        if($userinfo->Money >= $MinLi){
	            $db['Money']=$userinfo->Money-$MinLi;
	            $db['MinLi']=$userinfo->MinLi+$MinLi;
	            $re=$this->user->updata($id,$db);
	            if($re){
	                echo "<script>alert('资金余额转换成发布点成功！');</script>";
	                $this->change();
	            }else{
	                echo "<script>alert('还差一点点就成功了，再尝试一次吧！');history.back();</script>";
	            }
	        }else{
	            echo "<script>alert('您的系统中没有足够的资金余额来转换成发布点');history.back();</script>";
	        }
	    }else{//点转钱
	        if(($userinfo->MinLi-1000)>$Money){
	            $db['Money'] = $userinfo->Money+$Money;
	            $db['MinLi'] = $userinfo->MinLi-$Money;
	            $re=$this->user->updata($id,$db);
	            if($re){
	                echo "<script>alert('发布点转换成资金余额成功！');</script>";
	                $this->change();
	            }else{
	                echo "<script>alert('还差一点点就成功了，再尝试一次吧！');history.back();</script>";
	            }
	        }else{
	            echo "<script>alert('您的发布点不足，确认您有足够的发布点来兑换成存款哦！PS:若需取出所有发布点请点击页面最下方的申请取出所有发布点包含保证金！');history.back();</script>";
	        }
	    }
	    $this->change();
	}
	public function apply(){//申请取出保证发布点
	    $id=$this->session->userdata('sellerid');
	    
	    //需要判断一下还有没有为完成的任务！ 如果有提示有任务有可能会存在纠纷信息，故提交失败！
	    // 若无任务在进行，则可以执行以下代码	    
	    
	    $userinfo =$this->user->getInfo($id);
	    $db['Minli']=$userinfo->MinLi();
	    $db['memberid']=$id;
	    $db['status']=0;
	    $db['addtime']=@strtotime(@date('Y-m-d H:i:s'));
	    $userdb['MinLi']=0;
	    $reuser=$this->user->updata($id,$userdb);
	    if($reuser){
    	    $re=$this->deposit->add($db);
    	    if($re){
    	        echo "<script>alert('申请成功了，等待工作人员审批！');</script>";
    	        $this->change();
    	    }else{
    	        echo "<script>alert('系统现在繁忙中，请稍后申请！给你造成的不便敬请原谅！');history.back();</script>";
    	    }
	    }else{
	        echo "<script>alert('系统繁忙中，申请失败了，请稍后重试！');history.back();</script>";
	    }
	}
	public function fund()//资金管理
	{
	    $page = @$_GET['page']==''?0:@$_GET['page'];
	    $id = $this->session->userdata('sellerid');
	    $db['info'] = $this->user->getInfo($id);
	    $db['showcontent'] =1 ;
	    $db['service1'] = $this->system->getInfo(87);
	    $db['service2'] = $this->system->getInfo(88);

	    //获取完成所有已发布任务所需金额
        $modellist = $this->task->getModel($db['info']->id);
	    $countmoney=0;
	    foreach($modellist as $vml){
	        if($vml->number > ($vml->takenumber + $vml->del)){
	            $countmoney += ($vml->number- $vml->takenumber -$vml->del)*$vml->commission;
	        }
	    }
        // 获取所有的置顶费用信息
        $counttop =0;
        $tasklist = $this->task->getUserid($db['info']->id);
        foreach($tasklist as $vtl){
            if($vtl->number > ($vtl->qrnumber + $vtl->del)){
                $counttop += ($vtl->number - $vtl->qrnumber - $vtl->del) * $vtl->top;
            }
        }
	    $db['need'] = $countmoney + $counttop;
	    $db['page']=$page;
	    
	     //资金流动记录
	    $db['list'] = $this->cashlog->getInfoList($id,10,10*$page);
	    $db['count'] = $this->cashlog->getCount($id);

	    if(count($db['list'])!=0){
	       $n=0;
    	    foreach ($db['list'] as $vl){
    	        $arrshop[$n]=$vl->shopid;
    	        //$arrpro[$n]=$vl->proid;
    	        //$arrusertask[$n]=$vl->usertask;
    	        $n++;	        
    	    }
            // 数组去重
            if(count($arrshop)!=0){
        	    $shoparr = array_unique($arrshop);
        	    //$db['arrpro'] = array_unique($arrpro);
        	    //$db['arrusertask'] = array_unique($arrusertask);
        	    $db['shoparr'] = $this->shop->getArr($shoparr);
        	   // var_dump($db['shoparr']);
            }else{
                echo "<script>alert('找不到店铺了！');history.back();</script>";
                exit;
            }
	    }
	    $db['search']=0;
	    $this->load->view('list',$db);	    
	}
	function show(){
	    $key = @$_GET['id']==''?0:@$_GET['id'];
	    if($key == 0){
	        echo "<script>alert('请不要测试错误链接！');history.back();</script>";
	    }else{
	       $db['info'] = $this->cashlog->getInfo($key);
	       if($db['info'] != null){
	           $db['shop'] = $this->shop->getInfo($db['info']->shopid);
	           $this->load->view('ShopGetRemark',$db);
	       }else{
	           echo "<script>alert('错误信息！');history.back();</script>";
	       }
	    }
	}
	public function outall(){
	   $this->load->view('GetAll');	    
	}
	public function getallDB(){
	    $id = $this->session->userdata('sellerid');
	    $info = $this->user->getInfo($id);
	    $usertask  = $this->usertask->getlist($id,2,0,0);
	    $msg='';
	    if(count($usertask)!=0){
	        $msg['status'] = false;
	        $msg['info'] = '您还有未完结的任务，请待所有任务都完结后再来申请！感谢您对我们工作的理解与支持!';  
	    }else{
	        $thisinfo = $this->getall->getMySend($id);
	        echo $thisinfo;
	        if(count($thisinfo) != 0){
                $msg['status'] = false;
                $msg['info'] = '您的申请已经提交了，请不要重复提交，给我们的工作人员造成不需要的麻烦，感谢您的谅解！';
            }else{
                $db['userid'] = $id;
                $db['addtime'] = @strtotime(@date('Y-m-d H:i:s'));
                $db['getall'] = $info->Money;
                $db['status'] = 0 ;
                $db['type'] = @$_POST['type'] ;
                $db['name'] = @$_POST['name'] ;
                $db['bank'] = @$_POST['bank'] ;
                $db['card'] = @$_POST['card'] ;
                if($info->Money==0){
                    $msg['status'] = false ;
                    $msg['info'] = '您的账户里面没有余额哦···';
                }else{
                    $user['Money'] = 0;
                    $this->user->updata($id,$user);
                    $re = $this->getall->add($db);
                    if($re){
                        $msg['status'] = true;
                        $msg['info'] = '您的申请以及提交了！我们的工作人员会尽快处理您的申请信息！';
                    }else{
                        $msg['status'] = false;
                        $msg['info'] = '现在系统繁忙中，请稍后重试！';
                    }
                }
            }
	    }
	    echo json_encode($msg);
	}
	public function searchinfo(){
	    
	    $id = $this->session->userdata('sellerid');
	    $db['info'] = $this->user->getInfo($id);
	    $db['showcontent'] =1 ;
	    $db['service1'] = $this->system->getInfo(87);
	    $db['service2'] = $this->system->getInfo(88);
	    //获取完成所有已发布任务所需金额
	    $modellist = $this->task->getModel($db['info']->id);
	    $countmoney=0;
	    foreach($modellist as $vml){
	        if($vml->number > ($vml->takenumber + $vml->del)){
	            $countmoney += ($vml->number- $vml->takenumber -$vml->del)*$vml->commission;
	        }
	    }
	    // 获取所有的置顶费用信息
	    $counttop =0;
	    $tasklist = $this->task->getUserid($db['info']->id);
	    foreach($tasklist as $vtl){
	        if($vtl->number > ($vtl->qrnumber + $vtl->del)){
	            $counttop += ($vtl->number - $vtl->qrnumber - $vtl->del) * $vtl->top;
	        }
	    }
	    $db['need'] = $countmoney + $counttop;
	    
	    
	    $begintime = $_POST['BeginDate']==''?0:$_POST['BeginDate'];
	    $endtime = $_POST['EndDate']==''?0:$_POST['EndDate'];
	    
	    $db['list'] =$this->cashlog->getListSearch($id,@strtotime($begintime),@strtotime($endtime));
	  
	    $db['search']=1;
	    $db['begintime']=$begintime==0?'':@strtotime($begintime);
	    $db['endtime']=$endtime==0?'':@strtotime($endtime);
	    if(count($db['list'])!=0){
	        $n=0;
	        foreach ($db['list'] as $vl){
	            $arrshop[$n]=$vl->shopid;
	            $n++;
	        }
	        // 数组去重
	        if(count($arrshop)!=0){
    	        $shoparr = array_unique($arrshop);
    	        $db['shoparr'] = $this->shop->getArr($shoparr);
	        }else{
	            echo "<script>alert('没有找到对应的店铺信息');history.back();</script>";
	            exit;
	        }
	    }
	    $this->load->view('list',$db);
	}
	public function order()//订单信息
	{
	    $page=@$_GET['page']==''?0:@$_GET['page'];
	    $id = $this->session->userdata('sellerid');
	    $db['info'] = $this->user->getInfo($id);
	    $db['showcontent'] =1 ;
	    $db['service1'] = $this->system->getInfo(87);
	    $db['service2'] = $this->system->getInfo(88);

	    $db['page']=$page;
	    $db['all'] = $this->transfer->getListAll($id);
	    $db['list'] = $this->transfer->getList($id,10,10*$page);
	    $db['count'] = $this->transfer->CountList($id);

	    $arrtask = array();$n=0;
	    $alltask = array();
	    foreach($db['list'] as $vl){
	        $arrtask[$n++] = $vl->usertaskid;	        
	    }
	    //array_unique($array);
	    if(count($arrtask)==0){
	        echo "<script>alert('暂无数据');history.back();</script>";
	        exit;
	    }else{
    	    $db['usertask'] = $this->usertask->getArr(array_unique($arrtask));
    	    $product=array();$m=0;
    	    $model =array();
    	    foreach($db['usertask'] as $vut){
    	        $alltask[$m] = $vut->taskid;
    	        $model[$m] = $vut->taskmodelid;
    	        $product[$m++] = $vut->proid;
    	    }
    	    if(count($product)!=0){
        	    $db['product'] = $this->pro->getArr(array_unique($product));
        	    $db['task'] = $this->task->getArr(array_unique($alltask));
        	    $db['model'] = $this->task->getModelArr(array_unique($model));
    	    }else{
	           echo "<script>alert('暂无数据');history.back();</script>";
	           exit;
    	    }
    	    
    	   // print_r($db['model']);
    	    $db['search'] = false;
    	    $this->load->view('FShopPayList',$db);
	    }
	}
	public function searchOrder(){
	    $id = $this->session->userdata('sellerid');
	    $db['info'] = $this->user->getInfo($id);
	    $db['showcontent'] =1 ;
	    $db['service1'] = $this->system->getInfo(87);
	    $db['service2'] = $this->system->getInfo(88);

	    $start = @$_POST['BeginDate']==''?0:@$_POST['BeginDate'];
        $end = @$_POST['EndDate']==''?0:@$_POST['EndDate'];
	    $db['list'] = $this->transfer->getListSearch($id,$start,$end);
	    
	   // var_dump($db['all']);
	    $arrtask = array();$n=0;
	    $alltask = array();
	    foreach($db['list'] as $vl){
	        $arrtask[$n++] = $vl->usertaskid;
	    }
	    //array_unique($array);
	    if(count($arrtask)==0){
	        echo "<script>alert('暂无数据');history.back();</script>";
	        exit;
	    }else{
	        $db['usertask'] = $this->usertask->getArr(array_unique($arrtask));
	        $product=array();$m=0;
	        $model =array();
	        foreach($db['usertask'] as $vut){
	            $alltask[$m] = $vut->taskid;
	            $model[$m] = $vut->taskmodelid;
	            $product[$m++] = $vut->proid;
	        }
	        if(count($product)!=0){
	            $db['product'] = $this->pro->getArr(array_unique($product));
	            $db['task'] = $this->task->getArr(array_unique($alltask));
	            $db['model'] = $this->task->getModelArr(array_unique($model));
	        }else{
	            echo "<script>alert('暂无数据');history.back();</script>";
	            exit;
	        }
    	    $db['search'] = true;
    	    $db['start'] = $start==0?'':@strtotime($start);
    	    $db['end'] = $end==0?'':@strtotime($end);
    	    $this->load->view('FShopPayList',$db);
	    }
	}

	
	public function excelout(){ //导出
	    $id = $this->session->userdata('sellerid');
	    $list = $this->transfer->OutExcel($id);
	    if(count($list)!=0){
    	    $this->load->library('Classes/PHPExcel');
    	    $reader = new PHPExcel();
    	     
    	    /* 可不配置的东西
    	     *  $reader->getProperties()->setCreator("ctos")
    	     ->setLastModifiedBy("ctos")
    	     ->setTitle("Office 2007 XLSX Test Document")
    	     ->setSubject("Office 2007 XLSX Test Document")
    	     ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
    	     ->setKeywords("office 2007 openxml php")
    	    ->setCategory("Test result file"); */
    	
    	    // 修改导出以后每个单元格的宽度
    	    $reader->getActiveSheet()->getColumnDimension('A')->setWidth(25);
    	    $reader->getActiveSheet()->getColumnDimension('B')->setWidth(15);
    	    $reader->getActiveSheet()->getColumnDimension('C')->setWidth(40);
    	    $reader->getActiveSheet()->getColumnDimension('D')->setWidth(20);
    	    $reader->getActiveSheet()->getColumnDimension('E')->setWidth(50);
    	    $reader->getActiveSheet()->getColumnDimension('F')->setWidth(10);
    	    $reader->getActiveSheet()->getColumnDimension('G')->setWidth(30);
    	
    	
    	    $reader->getActiveSheet()->mergeCells('A1:G1');
    	    $reader->setActiveSheetIndex(0)
    	    ->setCellValue('A1', '等待转账数据汇总  时间:' . @date('Y-m-d H:i:s'))
    	    ->setCellValue('A2', '订单编号')
    	    ->setCellValue('B2', '提现人')
    	    ->setCellValue('C2', '银行卡号')
    	    ->setCellValue('D2', '开户行')
    	    ->setCellValue('E2', '支行名称')
    	    ->setCellValue('F2', '转账金额')
    	    ->setCellValue('G2', '转账截止时间   ');
    
    
    	    $arr=array();$n=0;
    	    foreach($list as $vd){
    	        $arr[$n++] = $vd->bankid;
    	    }
    	    //var_dump($arr);
    	    if(count($arr)!=0){
    	        $banks=$this->blank->getArr($arr);
    	    }else{
    	        echo "<script>alert('获取银行卡信息失败了，稍后重试！');history.back();</script>";
    	        exit;
    	    }
    	    $i=0;
    	    foreach ($list as $res) {
    	        foreach($banks as $vb){ 
    	            if($vb->id == $res->bankid){
    	                $name = $vb->truename;
    	                $bankaccount = $vb->bankAccount;
    	                $bankname = $vb->bankName;
    	                $subbranch = $vb->subbranch;
    	            }
    	        }
    	        $reader->getActiveSheet(0)->setCellValue('A' . ($i + 3), ' '.$res->ordersn);
    	        $reader->getActiveSheet(0)->setCellValue('B' . ($i + 3), $name);
    	        $reader->getActiveSheet(0)->setCellValue('C' . ($i + 3), ' '.$bankaccount);
    	        $reader->getActiveSheet(0)->setCellValue('D' . ($i + 3), $bankname);
    	        $reader->getActiveSheet(0)->setCellValue('E' . ($i + 3), $subbranch);
    	        $reader->getActiveSheet(0)->setCellValue('F' . ($i + 3), ' '.$res->money);
    	        $reader->getActiveSheet(0)->setCellValue('G' . ($i + 3), @date('Y-m-d H:i:s',@strtotime(@date('Y-m-d',$res->addtime))+36*60*60));
    	        $i++;
    	    } 
    	
    	
    	    $reader->getActiveSheet()->setTitle('转账汇总表');
    	
    	    // Set active sheet index to the first sheet, so Excel opens this as the first sheet
    	    $reader->setActiveSheetIndex(0);
    	
    	    // Redirect output to a client’s web browser (Excel5)
    	    // ob_end_clean();//清除缓冲区,避免乱码
    	    header('Content-Type: application/vnd.ms-excel');
    	    header('Content-Disposition: attachment;filename="等待转账汇总表(' . @date('Y-m-d H:i:s') . ').xls"');
    	    header('Cache-Control: max-age=0');
    	
    	    $objWriter = PHPExcel_IOFactory::createWriter($reader, 'Excel5');
    	    $objWriter->save('php://output');
	    }else{
	        echo "<script>alert('暂无数据需要导出哦！');history.back();</script>";
	    }
	}
	public function OutExcelAll(){

	    $id = $this->session->userdata('sellerid');
	    $list = $this->transfer->OutExcelAll($id);
	    if(count($list)!=0){
	        $this->load->library('Classes/PHPExcel');
	        $reader = new PHPExcel();
	    	         
	        // 修改导出以后每个单元格的宽度
	        $reader->getActiveSheet()->getColumnDimension('A')->setWidth(25);
	        $reader->getActiveSheet()->getColumnDimension('B')->setWidth(15);
	        $reader->getActiveSheet()->getColumnDimension('C')->setWidth(40);
	        $reader->getActiveSheet()->getColumnDimension('D')->setWidth(20);
	        $reader->getActiveSheet()->getColumnDimension('E')->setWidth(50);
	        $reader->getActiveSheet()->getColumnDimension('F')->setWidth(10);
	        $reader->getActiveSheet()->getColumnDimension('G')->setWidth(30);
	        $reader->getActiveSheet()->getColumnDimension('H')->setWidth(30);
	        $reader->getActiveSheet()->getColumnDimension('I')->setWidth(30);
	         
	         
	        $reader->getActiveSheet()->mergeCells('A1:I1');
	        $reader->setActiveSheetIndex(0)
	        ->setCellValue('A1', '等待转账数据汇总  时间:' . @date('Y-m-d H:i:s'))
	        ->setCellValue('A2', '订单编号')
	        ->setCellValue('B2', '提现人')
	        ->setCellValue('C2', '银行卡号')
	        ->setCellValue('D2', '开户行')
	        ->setCellValue('E2', '支行名称')
	        ->setCellValue('F2', '转账金额')
	        ->setCellValue('G2', '转账截止时间   ')
	        ->setCellValue('H2', '转账状态 ')
	        ->setCellValue('I2', '转账状态 ');
	    
	    
	        $arr=array();$n=0;
	        foreach($list as $vd){
	            $arr[$n++] = $vd->bankid;
	        }
	        //var_dump($arr);
	        if(count($arr)!=0){
	            $banks=$this->blank->getArr($arr);
	        }else{
	            echo "<script>alert('获取银行卡信息失败了，稍后重试！');history.back();</script>";
	            exit;
	        }
	        $i=0;
	        foreach ($list as $res) {
	            foreach($banks as $vb){
	                if($vb->id == $res->bankid){
	                    $name = $vb->truename;
	                    $bankaccount = $vb->bankAccount;
	                    $bankname = $vb->bankName;
	                    $subbranch = $vb->subbranch;
	                }
	            }
	            $reader->getActiveSheet(0)->setCellValue('A' . ($i + 3), ' '.$res->ordersn);
	            $reader->getActiveSheet(0)->setCellValue('B' . ($i + 3), $name);
	            $reader->getActiveSheet(0)->setCellValue('C' . ($i + 3), ' '.$bankaccount);
	            $reader->getActiveSheet(0)->setCellValue('D' . ($i + 3), $bankname);
	            $reader->getActiveSheet(0)->setCellValue('E' . ($i + 3), $subbranch);
	            $reader->getActiveSheet(0)->setCellValue('F' . ($i + 3), ' '.$res->money);
	            $reader->getActiveSheet(0)->setCellValue('G' . ($i + 3), @date('Y-m-d H:i:s',@strtotime(@date('Y-m-d',$res->addtime))+36*60*60));
	            $reader->getActiveSheet(0)->setCellValue('H' . ($i + 3), $res->arrivestatus=='0'?'未到账':'到账了');	            
	            $reader->getActiveSheet(0)->setCellValue('I' . ($i + 3), $res->transferstatus=='0'?'等待转账':($res->transferstatus=='1'?'已申请转账 ':($res->transferstatus=='2'?'已转账':($res->transferstatus=='3'?'转账失败':($res->transferstatus=='4'?'未到账':'找不到数据')))));
	            $i++;
	        }
	         
	         
	        $reader->getActiveSheet()->setTitle('转账汇总表');
	         
	        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
	        $reader->setActiveSheetIndex(0);
	         
	        // Redirect output to a client’s web browser (Excel5)
	        // ob_end_clean();//清除缓冲区,避免乱码
	        header('Content-Type: application/vnd.ms-excel');
	        header('Content-Disposition: attachment;filename="等待转账汇总表(' . @date('Y-m-d H:i:s') . ').xls"');
	        header('Cache-Control: max-age=0');
	         
	        $objWriter = PHPExcel_IOFactory::createWriter($reader, 'Excel5');
	        $objWriter->save('php://output');
	    }else{
	        echo "<script>alert('暂无数据需要导出哦！');history.back();</script>";
	    }
	}
	
	public function DetailedExcel(){  //资金流水明细导出(最近35天的信息)
        $start = @strtotime(@date('Y-m-d'))-60*60*24*35;
	    $id = $this->session->userdata('sellerid');
	    $list = $this->cashlog->OutExcel($id,$start);
	    if(count($list)!=0){
	        $n=0;
	        foreach ($list as $vl){
	            $arrshop[$n]=$vl->shopid;
	            $n++;
	        }
	        if(count($arrshop)==0){
	            echo "<script>alert('您导出的信息没有店铺数据库哦！');</script>";
	        }else{
    	        $shoparr = array_unique($arrshop);
    	        $shoplist = $this->shop->getArr($shoparr);
	        }
	    }
	    
	    
	    $this->load->library('Classes/PHPExcel');
	    $reader = new PHPExcel();
	    
	    /* 可不配置的东西
	     *  $reader->getProperties()->setCreator("ctos")
	     ->setLastModifiedBy("ctos")
	     ->setTitle("Office 2007 XLSX Test Document")
	     ->setSubject("Office 2007 XLSX Test Document")
	     ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
	     ->setKeywords("office 2007 openxml php")
	    ->setCategory("Test result file"); */
	     
	    // 修改导出以后每个单元格的宽度
	    $reader->getActiveSheet()->getColumnDimension('A')->setWidth(25);
	    $reader->getActiveSheet()->getColumnDimension('B')->setWidth(15);
	    $reader->getActiveSheet()->getColumnDimension('C')->setWidth(40);
	    $reader->getActiveSheet()->getColumnDimension('D')->setWidth(20);
	    $reader->getActiveSheet()->getColumnDimension('E')->setWidth(50);
	     
	     
	    $reader->getActiveSheet()->mergeCells('A1:E1');
	    $reader->setActiveSheetIndex(0)
	    ->setCellValue('A1', '等待转账数据汇总  时间:' . @date('Y-m-d H:i:s'))
	    ->setCellValue('A2', '类型')
	    ->setCellValue('B2', '变动情况')
	    ->setCellValue('C2', '变动后金额')
	    ->setCellValue('D2', '变动前金额')
	    ->setCellValue('E2', '时间');

	     $i=0;
	    foreach ($list as $res) {	        
	        if(substr($res->increase, 0,1)=='-'){ 
	            $money =  $res->remoney + sprintf($res->increase);
	        }else{ 
	            $money =  $res->remoney + sprintf($res->increase);
	        }	         
	        $reader->getActiveSheet(0)->setCellValue('A' . ($i + 3), $res->type);
	        $reader->getActiveSheet(0)->setCellValue('B' . ($i + 3), " ".$res->increase);
	        $reader->getActiveSheet(0)->setCellValue('C' . ($i + 3), " ".$money);
	        $reader->getActiveSheet(0)->setCellValue('D' . ($i + 3), " ".$res->remoney);
	        $reader->getActiveSheet(0)->setCellValue('E' . ($i + 3), @date('Y-m-d H:i:s',$res->addtime));
	        $i++;
	    } 
	     
	     
	    $reader->getActiveSheet()->setTitle('转账汇总表');
	     
	    // Set active sheet index to the first sheet, so Excel opens this as the first sheet
	    $reader->setActiveSheetIndex(0);
	     
	    // Redirect output to a client’s web browser (Excel5)
	    // ob_end_clean();//清除缓冲区,避免乱码
	    header('Content-Type: application/vnd.ms-excel');
	    header('Content-Disposition: attachment;filename="等待转账汇总表(' . @date('Y-m-d H:i:s') . ').xls"');
	    header('Cache-Control: max-age=0');
	     
	    $objWriter = PHPExcel_IOFactory::createWriter($reader, 'Excel5');
	    $objWriter->save('php://output');
	}
}
