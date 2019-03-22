<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Capital extends MY_Controller {

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
		$this->load->model('Outcashfull_model','outcashfull');
    }
	
    public function index()//账号充值
	{
	    $db = $this-> getServerInfo();
	    $db['page'] = isset($_GET['page']) ? $_GET['page'] : 0;
	    $condition = '';
	    $condition .= !empty($_GET['BeginDate']) ? ' AND addtime > ' . strtotime($_GET['BeginDate']) : '';
	    $condition .= !empty($_GET['EndDate']) ? ' AND addtime < ' . strtotime($_GET['EndDate']) : '';
	    $start = $db['page'] * 10;
	    $sql = 'SELECT * FROM zxjy_recharge WHERE userid = ' . $this -> uid . $condition . ' ORDER BY id DESC LIMIT ' . $start . ', 10';
        $db['list'] = $this -> db -> query($sql) -> result();
        $sql = 'SELECT count(1) as has FROM zxjy_recharge WHERE userid = ' . $this -> uid . $condition;
        $db['count'] = $this -> db -> query($sql) -> first_row() -> has;
        $db['newinfo']=$this -> article -> getinfo(45);
		$this->load->view('recharge',$db);
	}

	/*
	 * 生成商家自动充值码
	 */
	public function createRechargeID()
    {
        if (isset($_POST['recharge_nickname']) && isset($_POST['recharge_money']))
        {
            if ($_POST['recharge_money'] % 500 == 0)
            {
                $insert = [
                    'userid' => $this -> uid,
                    'payment_nickname' => $_POST['recharge_nickname'],
                    'payment_Money' => $_POST['recharge_money'],
                    'receipt_nickname' => '邹坤',
                    'receipt_account' =>'1921688860@qq.com',
                    'addtime' => time(),
                ];
                if ($this -> db -> insert('zxjy_recharge', $insert))
                {
                    $insert['ID'] = $this -> db -> insert_id();
                    $insert['addtime'] = date('Y-m-d H:i:s', $insert['addtime']);
                    show(1, '生成充值码成功', $insert);
                }
                else
                    show(0, '生成充值码失败，请稍后再试');
            }
            else
                show(0, '充值金额必须为500的整数倍');
        }
        else
            show(0, '参数错误');
    }

    public function ecPayErrorHandle($tradeNo, $err_msg)
    {
        file_put_contents('./recharge_error.txt', date('Y-m-d H:i:s') . ': 【 ' . $tradeNo . '】' . $err_msg . "\r\n", FILE_APPEND);
        echo $err_msg;
    }

    /*
     * 商家自动充值到账
     */
    public function ecPaycallback()
    {
        $key = 'jyursxpay';
        extract($_POST);
        if(strtoupper(md5("$tradeNo|$desc|$time|$username|$userid|$amount|$status|$key")) == $sig)  //验证签名通过
        {
            $sql = 'SELECT COUNT(1) as num FROM zxjy_recharge where tradeNo = "' . $tradeNo . '"';
            if ($this -> db -> query($sql) -> first_row() -> num == 0)  //无重复交易号
            {
                if (is_numeric($desc))  //充值码格式备注无误
                {
                    sleep(15);  //预防主从延迟
                    $sql = 'SELECT userid FROM zxjy_recharge WHERE id = ' . $desc;
                    if (!empty($user_info = $this -> db -> query($sql) -> first_row()))  //查询到对应充值码记录
                    {
                        $sql = 'UPDATE zxjy_recharge set recharge_time = "' . strtotime($time) . '", tradeNo = "' . $tradeNo . '" WHERE id = ' . $desc . ' AND payment_Money = "' . $amount . '" AND tradeNo IS NULL';
                        if ($this -> db -> query($sql) !== false && $this -> db -> affected_rows() === 1)  //更新充值表字段
                        {
                            $userid = $user_info -> userid;
                            $post_data = json_encode([
                                'UserID' => $userid,
                                "Money" => $amount,
                                "PaySN" => $tradeNo,
                                "PayProvider" => '支付宝',
                                "Remark" => '商家充值自动到账',
                                "optUserID" => '-1',
                            ]);
                            $url = BKC_URL . "?ActionTag=User_Recharge";
                            $ch = curl_init();
                            curl_setopt($ch, CURLOPT_URL, $url);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($ch, CURLOPT_USERAGENT, "qianyunlai.com's CURL Example beta");
                            $rs_data = curl_exec($ch);
                            $rs_json = json_decode($rs_data);
                            $curl_error = curl_error($ch);
                            $retries = 4;  //重试次数
                            while (($curl_error || !$rs_json -> IsOK) && $retries--)  //请求有误，重试
                            {
                                $rs_json = json_decode(curl_exec($ch));
                                $curl_error = curl_error($ch);
                            }
                            curl_close($ch);
                            if (empty($curl_error))  //控制台请求成功
                            {
                                if ($rs_json->IsOK)  //控制台写流水记录成功
                                {
                                    $sql = 'SELECT value FROM zxjy_system WHERE id = 101';
                                    $service_charge = $this->cacheSqlQuery('service_charge', $sql, 0, true, 'first_row')->value;  //服务费
                                    $sql = 'SELECT COUNT(1) as has FROM zxjy_user WHERE (pay_time IS NULL OR UNIX_TIMESTAMP(NOW()) - pay_time > 60 * 60 * 24 *30) AND isagent = 0 AND id = ' . $userid;
                                    $true_recharge = $amount;  //实际更新到用户表money字段的值
                                    if ($service_charge && $this->db->query($sql)->first_row()->has && $amount >= $service_charge)  //需要扣除服务费，并且该商家服务费已经过期,并且充值金额大于设定的服务费额度
                                    {
                                        $post_data = json_encode([
                                            'UserID' => $userid,
                                            "Money" => '-' . $service_charge,
                                            "PaySN" => $tradeNo,
                                            "Remark" => '商家充值自动到账，扣除商家服务费',
                                            "optUserID" => -1,
                                        ]);
                                        $url = BKC_URL . "?ActionTag=User_Recharge_Cancel";
                                        $ch = curl_init();
                                        curl_setopt($ch, CURLOPT_URL, $url);
                                        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
                                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                        curl_setopt($ch, CURLOPT_USERAGENT, "qianyunlai.com's CURL Example beta");
                                        $rs_data = curl_exec($ch);
                                        $rs_json = json_decode($rs_data);
                                        curl_close($ch);
                                        if ($rs_json->IsOK)
                                        {
                                            $update_user_sql = 'UPDATE zxjy_user SET service_charge = ' . $service_charge . ', pay_time = ' . time() . ' WHERE id = ' . $userid;
                                            if ($this -> db -> query($update_user_sql) !== false)
                                            {
                                                echo 'ok, 扣除商家服务费成功';
                                            }
                                            else
                                                $this->ecPayErrorHandle($tradeNo, '账户已到账，服务费已扣除，但是更新商家扣除服务费状态失败, 对应商家ID为：' . $userid);
                                        }
                                        else
                                            $this->ecPayErrorHandle($tradeNo, '账户已到账， 但扣除服务费的时候控制台执行失败，原因为：' . $rs_json -> Description);
                                    }
                                    else
                                        echo 'OK, 该商家暂时无需扣除服务费';
                                    RedisCache::del('server_info_' . $userid);
                                }
                                else
                                    $this->ecPayErrorHandle($tradeNo, '控制台返回错误, 内容： ' . $rs_json->Description);
                            }
                            else
                                $this->ecPayErrorHandle($tradeNo, '请求控制台失败, 错误：' . $curl_error);
                        }
                        else
                            $this->ecPayErrorHandle($tradeNo, '更新充值表字段失败');
                    }
                    else
                        $this->ecPayErrorHandle($tradeNo, '商家账户自动到账失败,未查询到对应的充值码记录');
                }
                else
                    $this -> ecPayErrorHandle($tradeNo, '商家未正确备注充值码，为空或者非纯数字');
            }
            else
                $this -> ecPayErrorHandle($tradeNo, '交易号重复插入，已拦截');
        }
        else
            $this -> ecPayErrorHandle($tradeNo, '签名错误');
    }
	
	
	/*
	 *  未到账反馈
	 */
	public function transfer()//转账管理 ---  未到账反馈
	{
	    $db = $this -> getServerInfo();
	    $db['page'] = isset($_GET['page']) ? $_GET['page'] : 0;
	    $sql = 'select count(1) as sum from zxjy_transfercash where merchantid = ' . $this -> uid . ' AND transferstatus = 4';
        $db['count'] = $this -> db -> query($sql) -> first_row() -> sum;
        $start = $db['page'] * 10;
        $sql = 'SELECT tc.id, tc.ordersn, tc.money, tc.truename, tc.transferstatus, tc.addtime, bl.bankAccount, bl.bankName, bl.subbranch, u.TrueName FROM zxjy_transfercash as tc
                LEFT JOIN zxjy_usertask as ut on ut.id = tc.usertaskid
                LEFT JOIN zxjy_user as u on u.id = ut.userid
                LEFT JOIN zxjy_banklist as bl on bl.id = tc.bankid
                WHERE tc.merchantid = ' . $this -> uid . ' AND transferstatus = 4 ORDER BY tc.id desc LIMIT ' . $start . ', 10';  //zxjy_transfercash中的userid不可取
        $db['list'] = $this -> db -> query($sql) -> result();
        $db['search']=false;
        $this->load->view('back',$db);

//	    $page = @$_GET['page']==''?0:@$_GET['page'];
//	    $id = $this->session->userdata('sellerid');
//	    $db['info'] = $this->user->getInfo($id);
//	    $db['showcontent'] =1 ;
//	    $db['service1'] = $this->system->getInfo(87);
//	    $db['service2'] = $this->system->getInfo(88);
// 	    $db['list'] = $this->transfer->getNoInfo($id,10,10*$page);
//	    $db['count'] = $this->transfer->getNoInfoCount($id);
//	    $db['page'] = $page;
//	    if(count($db['list'])!=0){
//	        $arr=array();
//	        foreach($db['list'] as $key=>$vdbl){
//	            $arr[$key]=$vdbl->bankid;
//	        }
//	        $db['bankID'] = $this->blank->getArr($arr);
//	    }
//	    $db['search']=false;
//	    $this->load->view('back',$db);
	}

	/*
	 * 未到账反馈搜索
	 */
	public function seacrhNo()
    {
        $db = $this -> getServerInfo();
        //获取查询列表的内容信息
        $db['PlatformOrderNumber']=$ordersn = $_POST['PlatformOrderNumber'];
        $db['BeginDate2']=$start = $_POST['BeginDate2']==''?0:@strtotime($_POST['BeginDate2']);
        $db['EndDate2']=$end = $_POST['EndDate2']==''?0:@strtotime($_POST['EndDate2']);
        if($start!=0 && $end!=0){
            if($end < $start){
                echo "<script>alert('开始时间不能大于结束时间');history.back();</script>";
                exit;
            }
        }
        // $this->transfer->rename();
        $db['list'] =$this -> transfer -> getSearchTime($this -> uid, 4, $ordersn, $start, $end);
        $db['search'] = true;
        $db['start'] = $start==0?'':@date('Y-m-d H:i:s',$start);
	    $db['end'] = @$end==0?'':@date('Y-m-d H:i:s',$end);
        $db['ordersn']=$ordersn = $_POST['PlatformOrderNumber'];
        $this->load->view('back',$db);

//	    $page = @$_GET['page']==''?0:@$_GET['page'];
//	    $id = $this->session->userdata('sellerid');
//	    $db['info'] = $this->user->getInfo($id);
//	    $db['showcontent'] =1 ;
//	    $db['service1'] = $this->system->getInfo(87);
//	    $db['service2'] = $this->system->getInfo(88);
//
//	    $db['ordersn']=$ordersn = $_POST['PlatformOrderNumber'];
//	    $start = $_POST['BeginDate2']==''?0:@strtotime($_POST['BeginDate2']);
//	    $end = $_POST['EndDate2']==''?0:@strtotime($_POST['EndDate2']);
//	    $db['list'] = $this->transfer->getNoList($id,10,10*$page,$ordersn,$start,$end);
//	    $db['count'] = $this->transfer->getNoCount($id,$ordersn,$start,$end);
//
//
//	    $db['page'] = $page;
//	    if(count($db['list'])!=0){
//	        $arr=array();
//	        foreach($db['list'] as $key=>$vdbl){
//	            $arr[$key]=$vdbl->bankid;
//	        }
//	        $db['bankID'] = $this->blank->getArr($arr);
//	    }
//	    $db['search']=true;
//	    $db['start'] = $start==0?'':@date('Y-m-d H:i:s',$start);
//	    $db['end'] = @$end==0?'':@date('Y-m-d H:i:s',$end);
//	    $this->load->view('back',$db);
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
	
	/*
     * 商家充值报警接口
     */
    public function ecPayAlarm()
    {
		file_put_contents('./test_alarm.txt', http_build_query($_GET));
        $post_data = json_encode([
            'Mobile' => 13725661523,
            "Msg" => '充值软件超过120秒未刷新，账号：' . @$_POST['account'] . '，最后刷新时间：' . @date('Y-m-d H:i:s', @$_POST['lastrefresh']) . '【二师兄威客网】',
            //"Msg" => '充值软件超过120秒未刷新，账号：25358，最后刷新时间：52478【二师兄威客网】',
        ]);
        $curl_result = $this -> consoleCurlHandle('Send_ShortMsg', $post_data);
    }

	/*
	 * 上传凭证，解冻账号
	 */
	public function editTransferDB()
    {
        if (count($_FILES['fileimage']['type']) == 1)
        {
            $images = $this -> uploadFile($_FILES['fileimage']);
            if($images)  //上传成功
            {
                $tran_sql = 'UPDATE zxjy_transfercash SET transferstatus = 2, transferimg = "' . unserialize($images)[0] . '" WHERE id = ' . $_POST['id'];
                if ($this -> db -> query($tran_sql) !== false)  //凭证上传成功
                {
//                    $sql = 'SELECT COUNT(1) as sum FROM zxjy_transfercash WHERE transferstatus = 4 AND merchantid = ' . $this -> uid;
//                    if (!$this -> db -> query($sql) -> first_row() -> sum)  //所以未到账反馈已处理完
//                    {
//                        $sql = @"SELECT COUNT(1) as CC FROM  zxjy_user A INNER JOIN zxjy_transfercash B ON A.id=B.merchantid
//                                WHERE  B.transferstatus <= 1  AND  UNIX_TIMESTAMP(DATE_FORMAT(FROM_UNIXTIME(B.addtime + 60 * 60 *24), '%Y-%m-%d 12:00:00')) < UNIX_TIMESTAMP(NOW())
//                                AND B.merchantid IS NOT NULL  And   A.opend= 1  AND A.id='{$this -> uid}';" ;
//                        $dbRs =  $this->db->query($sql)->row() ;
//                        $rsCount = $dbRs->CC;
//                        if($rsCount == false || $rsCount == 0)
//                        {
//                            $sql = 'UPDATE zxjy_user SET Status = 0 WHERE id = ' . $this -> uid;
//                            $this -> db -> query($sql) !== false && RedisCache::del('server_info_' . $this -> uid) ? show(1, '凭证提交成功, 您的账户已解冻') : show(0, '账户解冻失败, 请重新上传凭证');
//                        }
//                        else
//                            show(1, '凭证提交成功');
//                            //show(1, '凭证提交成功，但由于您还有未完成的待转账记录，解冻失败');
//                    }
                    show(1, '凭证提交成功');
                    //show(1, '凭证已提交成功, 账号尚未解冻');
                }
                else
                    show(0, '数据插入失败，请稍后再试');
            }
            else
                show(0, '图片上传失败，请检查文件大小或者格式是否正确');
        }
        else
            show(0, '只允许上传一张凭证');
	}

	/*
	 * 转账失败反馈界面--标志记录为未转账
	 */
	public function FailInfo()
    {
	    if (isset($_POST['key']))
        {
            $sql = 'update zxjy_transfercash set transferstatus = 3 where id = ' . $_POST['key'] . ' AND merchantid = ' . $this -> uid;
            $this -> db -> query($sql) ? show(1, '该笔记录已成功标志为：未到账') : show(0, '记录更新失败，请刷新后重试');
        }
        else
            show(0, '请勿测试错误的请求方式');


//	    $key = $_GET['key']==''?0:$_GET['key'];
//	    if($key==0){
//	        echo "<sript>alert('请不要测试错误链接。');history.back();</script>";
//	    }else{
//            $db['info'] = $this->transfer->getInfo($key);
//            if($db['info']!=null){
//                $dbs['transferstatus'] = 3;
//                $re = $this->transfer->updata($db['info']->id,$dbs);
//    	        if($re){
//    	            echo '<script>alert("状态已修改成功！！");</script>';
//    	            $this->transfer();
//    	        }else{
//    	            echo "<script>alert('系统正在繁忙中，请稍后重试！');history.back();</script>";
//    	        }
//	        }else{
//	            echo "<script>alert('您要查看的信息已经消失在二次元空间了，刷新页面后查看内容！');history.back();</script>";
//	        }
//	    }
	}
	public function refund()//转账管理 ---  买家退款
	{
	    $db = $this -> getServerInfo();
	    $id = $this->session->userdata('sellerid');
	    $db['list']=$this->usertask->getlist($id,'all');
	    $this->load->view('refund', $db);
	}

	/*
	 * 转账管理/转账结果
	 */
	public function result()
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
	/*
	 * 转账管理/等待转账
	 */
	public function wait()
	{
	    $db = $this -> getServerInfo();
        $db['page'] = isset($_GET['page']) ? $_GET['page'] : 0;
        $start = $db['page'] * 10;
        $sql = 'SELECT bw.wangwang, tc.id, tc.ordersn, tc.money, tc.truename, tc.transferstatus, tc.addtime, bl.bankAccount, bl.bankName, bl.subbranch, u.TrueName FROM zxjy_transfercash as tc
                LEFT JOIN zxjy_usertask as ut on ut.id = tc.usertaskid
                LEFT JOIN zxjy_user as u on u.id = ut.userid
                LEFT JOIN zxjy_banklist as bl on bl.id = tc.bankid
                LEFT JOIN zxjy_blindwangwang as bw on bw.userid = u.id
                WHERE tc.merchantid = ' . $this -> uid . ' ORDER BY tc.id desc LIMIT ' . $start . ', 10';  //zxjy_transfercash中的userid不可取
//        print_r($sql);
        $no_account_sql = 'SELECT COUNT(1) as num FROM zxjy_transfercash WHERE merchantid = ' . $this -> uid . ' AND transferstatus = 4';
        $db['list'] = $this -> db -> query($sql) -> result();
        $db['no_account_num'] = $this -> db -> query($no_account_sql) -> first_row() -> num;
        $db['userbank'] = $this -> blank -> getOne($this -> uid);
        $db['count'] = $this -> transfer -> CountList($this -> uid);
        $db['search'] = false;
        $this->load->view('wait', $db);

//	    $page = @$_GET['page']==''?0:@$_GET['page'];
//	    $id = $this->session->userdata('sellerid');
//	    $db['info'] = $this->user->getInfo($id);
//	    $db['showcontent'] =1 ;
//	    $db['service1'] = $this->system->getInfo(87);
//	    $db['service2'] = $this->system->getInfo(88);
//	    // 获取会员绑定的银行卡
//	    $db['userbank'] = $this->blank->getOne($id);
//	    //var_dump($db['userbank']);
//	    $db['list'] = $this->transfer->getList($id,10,10*$page);
//	    $db['page'] = $page;
//	    $db['count'] = $this->transfer->CountList($id);
//	    $arr=array();$n=0;
//	    foreach($db['list'] as $vd){
//	        $arr[$n++] = $vd->bankid;
//	    }
//	    //var_dump($arr);
//	    if(count($arr)!=0){
//	       $db['banks']=$this->blank->getArr($arr);
//	    }
//	    $db['search'] = false;
//        var_dump($db);
//	    $this->load->view('wait',$db);
	}

	/*
	 * 搜索
	 */
	public function search()
    {
        $db = $this -> getServerInfo();
	    //获取查询列表的内容信息
        $db['page'] = isset($_GET['page']) ? $_GET['page'] : 0;
        $start_page = $db['page'] * 10;
	    $db['TransferStatus']=$exceloutstatus=$_GET['TransferStatus'];
	    $db['PlatformOrderNumber']=$ordersn = $_GET['PlatformOrderNumber'];
	    $db['BeginDate2']=$start = $_GET['BeginDate2']==''?0:@strtotime($_GET['BeginDate2']);
	    $db['EndDate2']=$end = $_GET['EndDate2']==''?0:@strtotime($_GET['EndDate2']);
	    if($start!=0 && $end!=0){
	        if($end < $start){
	            echo "<script>alert('开始时间不能大于结束时间');history.back();</script>";
	            exit;
	        }
	    }
	   // $this->transfer->rename();
	    $tf_infos =$this->transfer->getSearchTime($this -> uid, $exceloutstatus, $ordersn, $start, $end, $start_page);
        $db['list'] = $tf_infos['list'];
        $db['count'] = $tf_infos['count'];
	    $db['search'] = true;
        $db['userbank'] = $this -> blank -> getOne($this -> uid);
//	    $arr=array();$n=0;
//	    foreach($db['list'] as $vd){
//	        $arr[$n++] = $vd->bankid;
//	    }
//	    //var_dump($arr);
//	    if(count($arr)!=0){
//	        $db['banks']=$this->blank->getArr($arr);
//	    }
	    $this->load->view('wait',$db);
	}

	/*
	 * 转账
	 */
	public function Transfercash()
    {
        if (isset($_POST['key']))
        {
            if ($bank = $this -> blank -> getOne($this -> uid))
            {
                $id_arr = array_filter(explode(',', $_POST['key']));
                $datas = [
                    'transferstatus' => 2,
                    'transferbank' => $bank -> bankAccount,
                    'transfername' => $bank -> truename,
                    'updatetime' => time(),
                ];
                if ($this -> transfer -> updataPass($id_arr, $datas))
                {
                    $affected_rows = $this -> db -> affected_rows();
                    if ($affected_rows)
                    {
                         $black = array('21879','21937','21436');
						 in_array($this -> uid, $black)?'':$this->Update_UserStatusIfTransferCashIsOK($this -> uid);
                        show(1, '所选记录已成功转账');
                    }
                    else
                        show(0, '暂无需要确认转账的记录');
                }
                else
                    show(0, '数据更新失败，请稍后再试');
            }
            else
                show(0, '请先绑定您的银行卡，当前无法继续操作');
        }
        else
            show(0, '请求无效，请刷新页面后重试');

//	    $key =$_GET['key']==''?0:$_GET['key'];
//	    //echo "<script>alert(".$key.");</script>";
//	    if($key==0){
//	        echo "<script>alert('请不要尝试错误链接！');history.back();</script>";
//	    }else{
//    	     $id = $this->session->userdata('sellerid');
//    	     $userbank = $this->blank->getOne($id);
//    	    // var_dump($userbank);
//    	    // exit;
//        	  if($userbank!=null){
//        	         $arrkey=explode(',', $key);
//        	         $arrkey=array_filter($arrkey);
//        	        // echo '<script>alert("'.var_dump($arrkey).'");</script>';
//        	         $db['transferstatus']=2;
//        	         $db['transferbank']=$userbank->bankAccount;
//        	         $db['transfername']=$userbank->truename;
//        	         $db['updatetime']=time();
//
//        	         $re=$this->transfer->updataPass($arrkey,$db);
//        	         if($re){
//
//        	         	$this->Update_UserStatusIfTransferCashIsOK($id) ;
//
//        	             echo '<script>alert("提交成功了！");</script>';
//        	             $this->wait();
//        	         }else{
//        	             echo "<script>alert('系统现在繁忙中，请稍后重试');history.back();</script>";
//        	         }
//    	      }else{
//    	           echo "<script>alert('请先绑定您的转账银行卡');history.back();</script>";
//    	      }
//	    }
	}

	/*
	 * 所有确认转账
	 */
	public function AllTransfercash()
    {
        $condition = '';
        $condition .= !empty($_POST['TransferStatus']) ? ' AND transferstatus = ' . $_POST['TransferStatus'] : '';
        $condition .= !empty($_POST['PlatformOrderNumber']) ? ' AND ordersn like "%' . $_POST['PlatformOrderNumber'] . '%"' : '';
        $condition .= !empty($_POST['BeginDate2']) ? ' AND addtime >= ' . strtotime($_POST['BeginDate2']) : '';
        $condition .= !empty($_POST['EndDate2']) ? ' AND addtime <= ' . strtotime($_POST['EndDate2']) : '';
        if ($bank = $this -> blank -> getOne($this -> uid))  //商家是否有绑定银行卡
        {
//            $sql = 'update zxjy_transfercash set transferstatus = 2, transferbank = "' . $bank->bankAccount . '", transfername = "' . $bank->truename . '", updatetime = "' . time()
//                . '" where merchantid = ' . $this->uid . ' AND transferstatus in (0, 1, 3)';
            $sql = 'update zxjy_transfercash set transferstatus = 2, transferbank = "' . $bank->bankAccount . '", transfername = "' . $bank->truename . '", updatetime = "' . time()
                . '" where merchantid = ' . $this->uid . $condition;
            $this -> db -> query($sql);
            if ($this -> db -> affected_rows())
            {
                $black = array('21879','21937','21436');
                in_array($this -> uid, $black)?'':$this->Update_UserStatusIfTransferCashIsOK($this -> uid);
                show(1, '所筛选记录已标注转账成功');
            }
            else
                show(0, '您当前没有需要转账的记录');
        }
        else
            show(0, '请先绑定您的银行卡，当前无法继续操作');
	}

	/*
	 * 为所选记录标志转账失败
	 */
	public function FailTransfercash()
    {
        if (isset($_POST['key']))
        {
            if ($bank = $this -> blank -> getOne($this -> uid))
            {
                $id_arr = array_filter(explode(',', $_POST['key']));
                $datas = [
                    'transferstatus' => 3,
                    'transferbank' => $bank -> bankAccount,
                    'transfername' => $bank -> truename,
                    'updatetime' => time(),
                ];
                $this -> transfer -> updataPass($id_arr, $datas) ? show(1, '所选记录已全部标志转账失败') : show(0, '数据更新失败，请稍后再试');
            }
            else
                show(0, '请先绑定您的银行卡，当前无法继续操作');
        }
        else
            show(0, '请求无效，请刷新页面后重试');
//
//	    $key =$_GET['key']==''?0:$_GET['key'];
//	   // echo "<script>alert(".$key.");</script>";
//	    if($key==0){
//	        echo "<script>alert('请不要尝试错误链接！');history.back();</script>";
//	    }else{
//    	     $id = $this->session->userdata('sellerid');
//    	     $userbank = $this->blank->getOne($id);
//    	    // var_dump($userbank);
//    	    // exit;
//    	    if($userbank !=null){
//    	         $arrkey=explode(',', $key);
//    	         $arrkey=array_filter($arrkey);
//    	         $db['transferstatus']=3;
//    	         $db['transferbank']=$userbank->bankAccount;
//    	         $db['transfername']=$userbank->truename;
//    	         $db['updatetime']=time();
//    	         $re=$this->transfer->updataPass($arrkey,$db);
//    	         if($re){
//    	             echo '<script>alert("提交成功了！");</script>';
//    	             $this->wait();
//    	         }else{
//    	             echo "<script>alert('系统现在繁忙中，请稍后重试');history.back();</script>";
//    	         }
//    	    }else{
//    	        echo "<script>alert('请先绑定转账的银行卡！否则无法提交信息！ ^ ^');history.back();</script>";
//    	    }
//	    }
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
    	        RedisCache::del('blank_info_' . $db['userid']);
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

    /**
     * 检查银行卡信息
     * @param $number  银行卡号
     * @param $user  用户名
     * @return bool|string|void  匹配返回true，否则直接报错
     */
	public function checkBankInfo($number, $user)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'https://ccdcapi.alipay.com/validateAndCacheCardInfo.json?_input_charset=utf-8&cardNo=' . $number . '&cardBinCheck=true');
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
        @curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 1); // 从证书中检查SSL加密算法是否存在
        curl_setopt($curl, CURLOPT_SSLVERSION, 3);
        curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器
        curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
        curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
        curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
        $tmpInfo = curl_exec($curl); // 执行操作
        curl_close($curl); // 关闭CURL会话
        $tmpInfo = file_get_contents('https://ccdcapi.alipay.com/validateAndCacheCardInfo.json?_input_charset=utf-8&cardNo=' . $number . '&cardBinCheck=true');
        if (!@curl_error($curl))  //curl无错误
        {
            //return json_decode($tmpInfo) -> validated ? true : show(0, '查询无此银行卡信息，请审查后重新提交，有问题反馈给客服');
            if (json_decode($tmpInfo) -> validated)
            {
                return preg_match('/^([\xe4-\xe9][\x80-\xbf]{2}){2,4}$/', $user) ? true : show(0, '开户人信息错误，请输入正确的中文名字');
            }
            else
                show(0, '查询无此银行卡信息，请审查后重新提交，有问题反馈给客服');
        }
        else
            show(0, curl_error($curl));

    }

	/*
	 * 修改商家默认银行卡入库
	 */
	public function editBankDB()
    {
        $info = $this -> user -> getInfo($this -> uid);
        if ($info -> SafePwd == md5($_POST['PayWord']))  //安全码正确
        {
            $this -> checkBankInfo($_POST['CardNumber'], $_POST['AccountName']);  //检查银行卡信息是否正确
            $db = [
                'userid' => $this -> uid,
                'bankName' => $_POST['BankName'],
                'truename' => $_POST['AccountName'],
                'bankAccount' => $_POST['CardNumber'],
                'status' => 1,
                'isdefault' => 1
            ];
            if ($this -> blank -> updata($_POST['bankid'], $db))
            {
                RedisCache::del('blank_info_' . $this -> uid);
                show(1, '新银行卡绑定成功');
            }
            else
                show(0, '数据更新失败，请稍后再试');
        }
        else
            show(0, '支付密码错误');

//	    $safepwd = $_POST['PayWord'];
//	    $bankid = $_POST['bankid'];
//	    $db['userid'] = $_POST['id'];
//	    $info = $this -> user -> getInfo($db['userid']);
//	    if($info->SafePwd== md5($safepwd)){
//    	    $db['bankName'] = $_POST['BankName'];
//    	    $db['truename'] = $_POST['AccountName'];
//    	    $db['bankAccount'] = $_POST['CardNumber'];
//    	    $db['status'] = 1;
//    	    //$db['time'] = time();
//    	    $db['isdefault']= 1;
//    	    $re = $this->blank->updata($bankid,$db);
//    	    if($re){
//    	        echo "<script>alert('新银行卡绑定成功！');parent.location.reload();</script>";
//    	    }else{
//    	        echo "<script>alert('系统现在繁忙中，请稍后重试！');history.back();</script>";
//    	    }
//	    }else{
//	        echo "<script>alert('您的支付密码错误，请重新输入！');history.back();</script>";
//	    }
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

	/*
	 * 资金管理
	 */
	public function fund()
	{
		 $id = $this->session->userdata('sellerid');
	    $db = $this -> getServerInfo();
        $db['page'] = isset($_GET['page']) ? $_GET['page'] : 0;
        $start = $db['page'] * 10;
        $sql = 'SELECT cl.id, cl.type, cl.increase, cl.remoney, cl.beizhu, cl.addtime, s.shopname  from zxjy_cashlog as cl
                LEFT JOIN zxjy_shop as s on s.sid = cl.shopid
                where cl.userid = ' . $this -> uid . ' ORDER BY id DESC LIMIT ' . $start . ', 10';
        $db['list'] = $this -> db -> query($sql) -> result();
        $sql = 'select count(1) as sum from zxjy_cashlog where userid = ' . $this -> uid;
        $db['count'] = $this -> db -> query($sql) -> first_row() -> sum;
        $db['search']=0;
		//查询是否存在全额体现
        $sql = "SELECT * FROM `zxjy_outcashfull` where  userid = {$id}";
        $outcashfull = $this->db->query($sql)->result_array();
        if($outcashfull){
            $db['outcashfull'] = $outcashfull[0];
        }else{
            $db['outcashfull'] = 0;
        }
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
	public function outpart(){
        $this->load->view('GetPart');
    }
	
	public function getallDB(){
        if (1)
        {
            $id = $this->session->userdata('sellerid');
            $info = $this->user->getInfo($id);
            if (1)
            {   //查询是否存在未完结的任务
                $usertask  = $this->usertask->getNowUser($id,0);
                $msg='';
                if($usertask[0]['num']!=0){
                    $msg['status'] = false;
                    $msg['info'] = '您还有未完结的任务，请待所有任务都完结后再来申请！感谢您对我们工作的理解与支持!';
                }else{
                    //查询是否开通全额提现权限
                    if($info->alloutcash !=1){
                        show(0, '联系客服开通全额提现的权限');
                    }
                    //用户是否被冻结
                    if($info->Status ==1){
                        show(0, '账号被冻结');
                    }
                    //用户的账户总额
                    $sql = "select sum(increase) as moneyall from zxjy_cashlog where userid = ".$id;
                    $moneyall = $this->db->query($sql)->result_array();
                    $money = $moneyall[0]['moneyall'];
                    if(empty($money) || $money ==""){
                        show(0, '账号余额为：0');
                    }
                    if(round(($money- $info->Money),0) > 0){
                        show(0, '无法全额体现需要联系客服！'.($money- $info->Money));
                    }
					if($_POST['name']=="" || empty($_POST['name'])){
                        show(0, '收款人不为空');
                    }
                    if($_POST['bank']=="" || empty($_POST['bank'])){
                        show(0, '开户银行不为空');
                    }
                    $tt=preg_match('/^[\x{4e00}-\x{9fa5}]+$/u',$_POST['name']);

                    if($tt== 0 ){
                        show(0, '收款人必须全中文');
                    }
                    $ttt=preg_match('/^[\x{4e00}-\x{9fa5}]+$/u',$_POST['bank']);
                    if($ttt== 0 ){
                        show(0, '开户银行必须全中文');
                    }
                    //查询是否存在全额体现
                    $sql = "SELECT count(id) as num FROM `zxjy_outcashfull` where  userid = {$id}";
                    $outcashfull = $this->db->query($sql)->result_array();
                    $outcashf = $outcashfull[0]['num'];
                    if($outcashf>0){
                        show(0, '已存在全额提现！');
                    }
					
                    $db['money'] = round($money,0);
                    $db['cashtype'] = 1;
                    $db['bankaccount'] = @$_POST['card'];
                    $db['addtime'] = time();
                    $db['status'] = "待确认";
                    $db['userid'] = $id;
                    $db['name'] =  @$_POST['name'] ;;
                    $db['bank'] = @$_POST['bank'] ;
                    $re = $this->outcashfull->add($db);
                    if($re){
                        $sb['Status'] = 1;
                        $sb['ispromoter'] = 0;
                        $sb['iscommission'] = 0;
                        $res = $this->user->updata($id,$sb);
                        if($res){
                            $msg['status'] = true;
                            $msg['info'] = '您的申请以及提交了！我们的工作人员会尽快处理您的申请信息！';
                        }else{
                            $msg['status'] = true;
                            $msg['info'] = '您的申请以及提交了！我们的工作人员会尽快处理您的申请信息！未冻结';
                        }

                    }else{
                        $msg['status'] = false;
                        $msg['info'] = '全额体现不成公需要联系客服';
                    }
                }
                show($msg['status'], $msg['info']);
            }
            else
                show(0, '余额不足');
        }
        else
            show(0, '参数错误');
//	    echo json_encode($msg);
    }
	
	public function getallDB123(){
	    $id = $this->session->userdata('sellerid');
	    $info = $this->user->getInfo($id);
	    $usertask  = $this->usertask->getlist($id,2,0,0);
	    $msg='';
	    if(count($usertask)!=0){
	        $msg['status'] = false;
	        $msg['info'] = '您还有未完结的任务，请待所有任务都完结后再来申请！感谢您对我们工作的理解与支持!';
	    }else{
	        $thisinfo = $this->getall->getMySend($id);
	       // echo $thisinfo;
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
                        RedisCache::del('server_info_' . $id);
                        $msg['status'] = true;
                        $msg['info'] = '您的申请以及提交了！我们的工作人员会尽快处理您的申请信息！';
                        $dbcashlog['type'] = '申请提现';
                        $dbcashlog['remoney'] = 0;
                        $dbcashlog['increase'] = '-'.$info->Money;
                        $dbcashlog['beizhu'] = '您申请把账户中保证金以及账户余额提现';
                        $dbcashlog['addtime'] = time();
                        $dbcashlog['userid'] = $id;
                        $this->cashlog->add($dbcashlog);
                    }else{
                        $msg['status'] = false;
                        $msg['info'] = '现在系统繁忙中，请稍后重试！';
                    }
                }
            }
	    }
        show($msg['status'], $msg['info']);
//	    echo json_encode($msg);
	}
    public function getpartDB(){
        if (isset($_POST['money']) && is_numeric($_POST['money']) )
        {
            $id = $this->session->userdata('sellerid');
            $info = $this->user->getInfo($id);
           // $dbs = $this-> getServerInfo();
           // $wer = $dbs['cash_deposit'] ;
            if (($info -> Money - $_POST['money'])>1000)
            {
                $usertask  = $this->usertask->getlist($id,2,0,0);
                $msg='';
                if(count($usertask)!=0){
                    $msg['status'] = false;
                    $msg['info'] = '您还有未完结的任务，请待所有任务都完结后再来申请！感谢您对我们工作的理解与支持!';
                }else{
                    $thisinfo = $this->getall->getMySend($id);
                    // echo $thisinfo;
                    if(count($thisinfo) != 0){
                        $msg['status'] = false;
                        $msg['info'] = '您的申请已经提交了，请不要重复提交，给我们的工作人员造成不需要的麻烦，感谢您的谅解！';
                    }else{
                        $db['userid'] = $id;
                        $db['addtime'] = @strtotime(@date('Y-m-d H:i:s'));
                        $db['getall'] =  @$_POST['money'];
                        $db['status'] = 0 ;
                        $db['remark'] = '部分提现' ;
                        $db['type'] = @$_POST['type'] ;
                        $db['name'] = @$_POST['name'] ;
                        $db['bank'] = @$_POST['bank'] ;
                        $db['card'] = @$_POST['card'] ;
                        if($info->Money==0){
                            $msg['status'] = false ;
                            $msg['info'] = '您的账户里面没有余额哦···';
                        }else{
                            $user['Money'] = $info->Money - @$_POST['money'];
                            $this->user->updata($id,$user);
                            $re = $this->getall->add($db);
                            if($re){
                                RedisCache::del('server_info_' . $id);
                                $msg['status'] = true;
                                $msg['info'] = '您的申请以及提交了！我们的工作人员会尽快处理您的申请信息！';
                                $dbcashlog['type'] = '申请部分提现';
                                $dbcashlog['remoney'] = $info->Money - @$_POST['money'];
                                $dbcashlog['increase'] = '-' .  @$_POST['money'];
                                $dbcashlog['beizhu'] = '您申请把账户余额部分提现';
                                $dbcashlog['addtime'] = time();
                                $dbcashlog['userid'] = $id;
                                $this->cashlog->add($dbcashlog);
                            }else{
                                $msg['status'] = false;
                                $msg['info'] = '现在系统繁忙中，请稍后重试！';
                            }
                        }
                    }
                }
                show($msg['status'], $msg['info']);
            }
            else
                show(0, '提现金额后不能少于保证金');
        }
        else
            show(0, '参数错误');
//	    echo json_encode($msg);
    }	
	public function searchinfo(){
        $db = $this -> getServerInfo();
        $db['page'] = isset($_GET['page']) ? $_GET['page'] : 0;
        $start = $db['page'] * 10;
        $sql = 'SELECT cl.id, cl.type, cl.increase, cl.remoney, cl.beizhu, cl.addtime, s.shopname  from zxjy_cashlog as cl
                LEFT JOIN zxjy_shop as s on s.sid = cl.shopid
                where ';
        $condition = ' cl.userid = ' . $this -> uid;
        if (!empty($_GET['BeginDate']))
        {
            $db['begintime'] = strtotime($_GET['BeginDate']);
            $condition .= ' AND cl.addtime > ' . $db['begintime'];
        }
        if (!empty($_GET['EndDate']))
        {
            $db['endtime'] = strtotime($_GET['EndDate']);
            $condition .= ' AND cl.addtime < ' . $db['endtime'];
        }
		if (!empty($_GET['type']))
        {
            $condition .= ' AND cl.type ="' . $_GET['type'] . '"';
        }
        $sql .= $condition . ' ORDER BY id DESC LIMIT ' . $start . ', 10';
        $db['list'] = $this -> db -> query($sql) -> result();
        $search_sql = 'select count(1) as sum from zxjy_cashlog as cl where ' . $condition;
        $db['count'] = $this -> db -> query($search_sql) -> first_row() -> sum;
        $db['search']=1;
        //var_dump($db['list']);
        $this->load->view('list',$db);




//	    $id = $this->session->userdata('sellerid');
//	    $db['info'] = $this->user->getInfo($id);
//	    $db['showcontent'] =1 ;
//	    $db['service1'] = $this->system->getInfo(87);
//	    $db['service2'] = $this->system->getInfo(88);
//	    //获取完成所有已发布任务所需金额
//	    $modellist = $this->task->getModel($db['info']->id);
//	    $countmoney=0;
//	    foreach($modellist as $vml){
//	        if($vml->number > ($vml->takenumber + $vml->del)){
//	            $countmoney += ($vml->number- $vml->takenumber -$vml->del)*$vml->commission;
//	        }
//	    }
//	    // 获取所有的置顶费用信息
//	    $counttop =0;
//	    $tasklist = $this->task->getUserid($db['info']->id);
//	    foreach($tasklist as $vtl){
//	        if($vtl->number > ($vtl->qrnumber + $vtl->del)){
//	            $counttop += ($vtl->number - $vtl->qrnumber - $vtl->del) * $vtl->top;
//	        }
//	    }
//	    $db['need'] = $countmoney + $counttop;
//
//
//	    $begintime = $_POST['BeginDate']==''?0:$_POST['BeginDate'];
//	    $endtime = $_POST['EndDate']==''?0:$_POST['EndDate'];
//
//	    $db['list'] =$this->cashlog->getListSearch($id,@strtotime($begintime),@strtotime($endtime));
//
//	    $db['search']=1;
//	    $db['begintime']=$begintime==0?'':@strtotime($begintime);
//	    $db['endtime']=$endtime==0?'':@strtotime($endtime);
//	    if(count($db['list'])!=0){
//	        $n=0;
//	        foreach ($db['list'] as $vl){
//	            $arrshop[$n]=$vl->shopid;
//	            $n++;
//	        }
//	        // 数组去重
//	        if(count($arrshop)!=0){
//    	        $shoparr = array_unique($arrshop);
//    	        $db['shoparr'] = $this->shop->getArr($shoparr);
//	        }else{
//	            echo "<script>alert('没有找到对应的店铺信息');history.back();</script>";
//	            exit;
//	        }
//	    }
//	    $this->load->view('list',$db);
	}

	/*
	 * 资金管理 -- 订单信息
	 */
	public function order()//订单信息
	{
	    $db = $this -> getServerInfo();
        $db['page'] = isset($_GET['page']) ? $_GET['page'] : 0;
        $start = $db['page'] * 10;
        $sql = 'SELECT tf.money, ut.updatetime, t.tasktype, t.keyword, ut.tasksn, ut.ordersn, p.commodity_abbreviation, p.commodity_id, tm.commission FROM zxjy_transfercash as tf
                LEFT JOIN zxjy_usertask as ut on ut.id = tf.usertaskid
                LEFT JOIN zxjy_product as p on p.id = ut.proid
                LEFT JOIN zxjy_task as t on t.id = ut.taskid
                LEFT JOIN zxjy_taskmodel as tm on tm.id = ut.taskmodelid
                WHERE tf.merchantid = ' . $this -> uid . ' AND ut.id is NOT NULL ORDER BY tf.id desc LIMIT ' . $start . ', 10';
        $db['list'] = $this -> db -> query($sql) -> result();
        $count_sql = 'select count(1) as sum from zxjy_transfercash as tf LEFT JOIN zxjy_usertask as ut on ut.id = tf.usertaskid where  tf.merchantid = ' . $this -> uid . ' AND ut.id is NOT NULL';
        $db['count'] = $this -> db -> query($count_sql) -> first_row() -> sum;
        $db['search'] = false;
        $this->load->view('FShopPayList', $db);

//
//	    $page=@$_GET['page']==''?0:@$_GET['page'];
//	    $id = $this->session->userdata('sellerid');
//	    $db['info'] = $this->user->getInfo($id);
//	    $db['showcontent'] =1 ;
//	    $db['service1'] = $this->system->getInfo(87);
//	    $db['service2'] = $this->system->getInfo(88);
//
//	    $db['page']=$page;
//	    $db['all'] = $this->transfer->getListAll($id);
//	    $db['list'] = $this->transfer->getList($id,10,10*$page);
//	    $db['count'] = $this->transfer->CountList($id);
//
//	    $arrtask = array();$n=0;
//	    $alltask = array();
//	    foreach($db['list'] as $vl){
//	        $arrtask[$n++] = $vl->usertaskid;
//	    }
//	    //array_unique($array);
//	    if(count($arrtask)==0){
//	        echo "<script>alert('暂无数据');history.back();</script>";
//	        exit;
//	    }else{
//    	    $db['usertask'] = $this->usertask->getArr(array_unique($arrtask));
//    	    $product=array();$m=0;
//    	    $model =array();
//    	    foreach($db['usertask'] as $vut){
//    	        $alltask[$m] = $vut->taskid;
//    	        $model[$m] = $vut->taskmodelid;
//    	        $product[$m++] = $vut->proid;
//    	    }
//    	    if(count($product)!=0){
//        	    $db['product'] = $this->pro->getArr(array_unique($product));
//        	    $db['task'] = $this->task->getArr(array_unique($alltask));
//        	    $db['model'] = $this->task->getModelArr(array_unique($model));
//    	    }else{
//	           echo "<script>alert('暂无数据');history.back();</script>";
//	           exit;
//    	    }
//
//    	   // print_r($db['model']);
//    	    $db['search'] = false;
//    	    $this->load->view('FShopPayList',$db);
//	    }
	}


	/*
	 * 订单信息搜索
	 */
	public function searchOrder()
    {
        $db = $this -> getServerInfo();
        $db['page'] = isset($_GET['page']) ? $_GET['page'] : 0;
        $start = $db['page'] * 10;
        $sql = 'SELECT tf.money, ut.updatetime, t.tasktype, t.keyword, ut.tasksn, ut.ordersn, p.commodity_abbreviation, p.commodity_id, tm.commission FROM zxjy_transfercash as tf
                LEFT JOIN zxjy_usertask as ut on ut.id = tf.usertaskid
                LEFT JOIN zxjy_product as p on p.id = ut.proid
                LEFT JOIN zxjy_task as t on t.id = ut.taskid
                LEFT JOIN zxjy_taskmodel as tm on tm.id = ut.taskmodelid
                WHERE tf.merchantid = ' . $this -> uid . ' AND ut.id is NOT NULL';
        $condition = '';
        if (!empty($_GET['BeginDate']))
        {
            $db['BeginDate'] = strtotime($_GET['BeginDate']);
            $condition .= ' AND ut.updatetime > ' . $db['BeginDate'];
        }
        if (!empty($_GET['EndDate']))
        {
            $db['EndDate'] = strtotime($_GET['EndDate']);
            $condition .= ' AND ut.updatetime < ' . $db['EndDate'];
        }
        $sql .= $condition . ' ORDER BY tf.id desc LIMIT ' . $start . ', 10';
        $db['list'] = $this -> db -> query($sql) -> result();
        $count_sql = 'select count(1) as sum from zxjy_transfercash as tf LEFT JOIN zxjy_usertask as ut on ut.id = tf.usertaskid where  tf.merchantid = ' . $this -> uid . ' AND ut.id is NOT NULL' . $condition;
        $db['count'] = $this -> db -> query($count_sql) -> first_row() -> sum;
        $db['search'] = true;
        $this->load->view('FShopPayList', $db);


//	    $id = $this->session->userdata('sellerid');
//	    $db['info'] = $this->user->getInfo($id);
//	    $db['showcontent'] =1 ;
//	    $db['service1'] = $this->system->getInfo(87);
//	    $db['service2'] = $this->system->getInfo(88);
//
//	    $start = @$_POST['BeginDate']==''?0:@$_POST['BeginDate'];
//        $end = @$_POST['EndDate']==''?0:@$_POST['EndDate'];
//	    $db['list'] = $this->transfer->getListSearch($id,strtotime($start),strtotime($end));
//
//	   // var_dump($db['all']);
//	    $arrtask = array();$n=0;
//	    $alltask = array();
//	    foreach($db['list'] as $vl){
//	        $arrtask[$n++] = $vl->usertaskid;
//	    }
//	    //array_unique($array);
//	    if(count($arrtask)==0){
//	        echo "<script>alert('暂无数据');history.back();</script>";
//	        exit;
//	    }else{
//	        $db['usertask'] = $this->usertask->getArr(array_unique($arrtask));
//	        $product=array();$m=0;
//	        $model =array();
//	        foreach($db['usertask'] as $vut){
//	            $alltask[$m] = $vut->taskid;
//	            $model[$m] = $vut->taskmodelid;
//	            $product[$m++] = $vut->proid;
//	        }
//	        if(count($product)!=0){
//	            $db['product'] = $this->pro->getArr(array_unique($product));
//	            $db['task'] = $this->task->getArr(array_unique($alltask));
//	            $db['model'] = $this->task->getModelArr(array_unique($model));
//	        }else{
//	            echo "<script>alert('暂无数据');history.back();</script>";
//	            exit;
//	        }
//    	    $db['search'] = true;
//    	    $db['start'] = $start==0?'':@strtotime($start);
//    	    $db['end'] = $end==0?'':@strtotime($end);
//    	    $this->load->view('FShopPayList',$db);
//	    }
	}

	public function test()
    {
        $this -> excel('测试', '标题', ['第一列', '第二列', '第三列'], [['a' => 'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA', 'b' => 'B', 'c' => 'C',], ['a' => 'A', 'b' => 'B', 'c' => 'C',]], false, ['b', 'a', 'c']);
    }

    /**
     * 导出excel
     * @param $save_name  导出之后保存的文件名
     * @param $title  设置表格的标题
     * @param $set_list  设置表格的列名
     * @param $datas  要导出的数据
     * @param bool $is_pure  true--datas数组中的所有数据与设置好的列明正好匹配。false需要设置下一个字段已指定对应列名的键值
     * @param array $filed  若is_prue为flase，需要传入该值确认要导入的键名所对应的值
     * @param bool $auto_size  列宽是否自适应，如果为flase，此时$set_list需设置成关联数组['列名' => '宽度']
     * @throws PHPExcel_Reader_Exception
     */
	public function excel($save_name, $title, $set_list, $datas, $is_pure = true, $filed = [], $auto_size = false)
    {
        $this -> load -> library('Classes/PHPExcel/IOFactory');
        $this -> load -> library('Classes/PHPExcel');
        $excel = new PHPExcel();
        $save_name = is_null($save_name) ? time() : iconv('UTF-8', 'gbk', $save_name);  //防止文件名中文乱码
        $key = 0;
        $excel_attr = $excel -> getActiveSheet();  //设置excel的属性
        $excel -> setActiveSheetIndex(0);  //设置当前的sheet
        $excel_attr -> setTitle($title);  //设置excel标题
        if ($auto_size)  //自适应单元宽度
        {
            foreach ($set_list as $v)  //设置表头
            {
                $char = chr(65 + ($key++));
                $excel_attr -> getColumnDimension($char) -> setAutoSize(true);  //设置自适应单元宽度
                $excel_attr -> setCellValue($char . '1', $v);  //设置表头值
                $excel_attr -> getStyle($char . '1') -> getAlignment() -> setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);  //表头字段垂直居中
            }
        }
        else  //单独设置每个列的宽度，此时$set_list需设置成关联数组['列名' => '宽度']
        {
            foreach ($set_list as $k => $v)  //设置表头
            {
                $char = chr(65 + ($key++));
                $excel_attr -> getColumnDimension($char) -> setWidth($v);
                $excel_attr -> setCellValue($char . '1', $k);
                $excel_attr -> getStyle($char . '1') -> getAlignment() -> setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);  //表头字段垂直居中
            }
        }
        $key = 2;
        foreach ($datas as $v)  //导入数据
        {
            $pos = 0;
            foreach ($v as $v2)
            {
                $v2 = $is_pure ? $v2 : $v -> $filed[$pos];   //导入的数据是否为一对一关系
                $excel_attr -> setCellValue(chr(65 + ($pos++)) . $key, ' ' . $v2);
            }
            $key++;
        }
        //ob_end_clean();//清除缓冲区,避免乱码
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename=' . $save_name . '.xls');
        header('Cache-Control: max-age=0');
        $objWriter = IOFactory::createWriter($excel, 'Excel5');
        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')  //ajax请求
        {
            $file_path = './uploads/excel/' . $save_name . '.xls';
            $objWriter -> save($file_path);
            show(1, '导出数据成功', ltrim(iconv('gbk', 'UTF-8', $file_path), '.'));  //将保存的路径转码为utf-8格式，因为ajax下载方式为先保存文件，客户端跳转以下载，这里需要将路径设置成utf-8的格式才能下载，否则传过去的值为null
        }
        else  //直接输出下载
            $objWriter -> save('php://output');
    }
	
	/**
     * 返回字符串的毫秒数时间戳
     */
    function get_total_millisecond()
    {
        $time = explode (" ", microtime () );
        $time = $time [1] . ($time [0] * 1000);
        $time2 = explode ( ".", $time );
        $time = $time2 [0];
        return $time;
    }

   /*
     * 导出指定条件的记录
     */
    public function excelout()
    {

        $outbanknumber = $this->blank->getOne($this -> uid);
        $save_name = substr($outbanknumber -> bankAccount, -4) . '转账管理记录-' . $this -> get_total_millisecond();
        if ($outbanknumber)
        {
            $condition = '';
            $condition .= !empty($_GET['EndDate2']) ? ' AND tc.addtime > ' . strtotime($_GET['BeginDate2']) : '';
            $condition .= !empty($_GET['EndDate2']) ? ' AND tc.addtime < ' . strtotime($_GET['EndDate2']) : '';
            $condition .= !empty($_GET['sid']) ? ' AND s.sid = ' . $_GET['sid'] : '';
            $condition .= ' AND tc.transferstatus = "' . ($_GET['TransferStatus'] != '' ? $_GET['TransferStatus'] : 1) . '"';
            if ($_GET['out_way'] == 1)  //招行
            {
                $sql = 'SELECT bl.bankAccount, 
                    IF(bl.truename = "", u.TrueName, bl.truename) as truenam,
                    tc.money, tc.ordersn, bl.bankName, bl.subbranch, tc.transferstatus, bw.wangwang, bl.bankAddress FROM zxjy_transfercash as tc
                    LEFT JOIN zxjy_usertask as ut on ut.id = tc.usertaskid
                    LEFT JOIN zxjy_user as u on u.id = ut.userid
                    LEFT JOIN zxjy_banklist as bl on bl.id = tc.bankid
                    LEFT JOIN zxjy_blindwangwang as bw on bw.userid = u.id
                    LEFT JOIN zxjy_shop as s on s.sid = ut.shopid
                    WHERE tc.merchantid = ' . $this -> uid . ' AND tc.ordersn like "%' . @$_GET['PlatformOrderNumber'] . '%"' . $condition . ' ORDER BY tc.id desc';
                $list = $this -> db -> query($sql) -> result();
                if ($list)
                {
                    foreach ($list as &$v)
                    {
                        switch($v -> transferstatus)
                        {
                            case 1:
                                $v -> transferstatus = '等待转账';
                                break;
                            case 2:
                                $v -> transferstatus = '已转账';
                                break;
                            case 3:
                                $v -> transferstatus = '转账失败';
                                break;
                            case 4:
                                $v -> transferstatus = '未到账';
                                break;
                        }
                        $bankAddress = array_filter(explode('  ', $v -> bankAddress));
                        $v -> ordersn = $v -> wangwang . ' | ' .  $v -> transferstatus . ' | ' . $v -> ordersn;
                        unset($v -> transferstatus);
                        unset($v -> wangwang);
                        unset($v -> bankAddress);
                        $province_suffix = strpos(@$bankAddress[0], '省') ? '省' : (strpos(@$bankAddress[0], '市') ? '市' : '');
                        $v -> province = !empty($province_suffix) ? substr(@$bankAddress[0], 0, strpos(@$bankAddress[0], $province_suffix)) : @$bankAddress[0];
                        $city_suffix = strpos(@$bankAddress[1], '市') ? '市' : '';
                        $v -> city = !empty($city_suffix) ? substr(@$bankAddress[1], 0, strpos(@$bankAddress[1], $city_suffix)) : @$bankAddress[1];
                    }
                    $set_list = [
                        '收款账户列' => 25,
                        '收款户名列' => 15,
                        '转账金额列' => 13,
                        '备注列' => 50,
                        '收款银行列' => 25,
                        '收款银行支行列' => 25,
                        '收款省/直辖市列' => 15,
                        '收款市县列' => 10,
                    ];
                    $this -> excel($save_name, '等待转账记录', $set_list, $list, true, [], false);
                }
                else
                    show(0, '暂时没有等待转账的记录可以导出');

            }
            elseif ($_GET['out_way'] == 2)  //兴业
            {
                $sql = 'SELECT tc.id, bl.bankAccount, 
                        IF(bl.truename = "", u.TrueName, bl.truename) as truenam,
                        bl.bankName, bl.subbranch, bl.bankAddress, tc.money FROM zxjy_transfercash as tc
                        LEFT JOIN zxjy_usertask as ut on ut.id = tc.usertaskid
                        LEFT JOIN zxjy_user as u on u.id = ut.userid
                        LEFT JOIN zxjy_banklist as bl on bl.id = tc.bankid
                        LEFT JOIN zxjy_shop as s on s.sid = ut.shopid
                        WHERE tc.merchantid = ' . $this -> uid . ' AND tc.ordersn like "%' . @$_GET['PlatformOrderNumber'] . '%"' . $condition . ' ORDER BY tc.id desc';
                $list = $this -> db -> query($sql) -> result();
                if ($list)
                {
                    foreach ($list as &$v)
                    {
						$v -> id = '';
                        $v -> is_xy = strpos($v -> bankName, '兴业') ? '是' : '否';
                        $v -> bankName = $v -> bankName . ' ' . $v -> subbranch;
                        $v -> same_city = '否';
                        $bankAddress = array_filter(explode('  ', $v -> bankAddress));
                        $province_suffix = strpos(@$bankAddress[0], '省') ? '省' : (strpos(@$bankAddress[0], '市') ? '市' : '');
                        $province = !empty($province_suffix) ? substr(@$bankAddress[0], 0, strpos(@$bankAddress[0], $province_suffix) + 3) : @$bankAddress[0];
                        $city_suffix = strpos(@$bankAddress[1], '市') ? '市' : '';
                        $city = !empty($city_suffix) ? substr(@$bankAddress[1], 0, strpos(@$bankAddress[1], $city_suffix) + 3) : @$bankAddress[1];
                        $v -> bankAddress = $province . $city;
                        $v -> purpose = '转账';
                        unset($v -> subbranch);
                    }
                    $set_list = [
                        '序号' => 10,
                        '是否兴业银行账户' => 15,
                        '收款账号' => 50,
                        '收款户名' => 20,
                        '收款银行及营业网点' => 35,
                        '是否同城' => 10,
                        '汇入地址' => 18,
                        '转账金额' => 10,
                        '转账用途' => 10,
                    ];
                    $this -> excel($save_name, '等待转账记录', $set_list, $list, false, ['id', 'is_xy', 'bankAccount', 'truenam', 'bankName', 'same_city', 'bankAddress', 'money', 'purpose'], false);
                }
                else
                    show(0, '暂时没有等待转账的记录可以导出');
            }
        }
        else
            show(0, '您尚未绑定银行卡，无法导出数据');
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

	/*
	 * 导出流水信息
	 */
	public function DetailedExcel()
    {
        $sql = 'SELECT cl.type, cl.increase, cl.remoney, cl.beizhu, FROM_UNIXTIME(cl.addtime) from zxjy_cashlog as cl
                LEFT JOIN zxjy_shop as s on s.sid = cl.shopid
                where ';
        $condition = ' cl.userid = ' . $this -> uid;
        if (!empty($_POST['begin']))
            $condition .= ' AND cl.addtime > ' . strtotime($_POST['begin']);
        if (!empty($_POST['end']))
            $condition .= ' AND cl.addtime < ' . strtotime($_POST['end']);
        if (empty($_POST['begin']) || empty($_POST['end']))
            $condition .= ' AND cl.addtime > ' . (time() - 60 * 60 * 24 * 35);
        $sql .= $condition . ' ORDER BY id DESC';
        $list = $this -> db -> query($sql) -> result();
        if ($list)
        {
            $save_name = '收支流水明细记录';
            $set_list = [
                '类型' => 25,
                '变动情况' => 15,
                '变动后金额' => 20,
                '备注信息' => 55,
                '消费时间' => 50,
            ];
            $this -> excel($save_name, '收支流水明细记录', $set_list, $list);
        }
        else
            show(0, '暂时无收支流水明细需要导出');
//
//
//
//        $start = @strtotime(@date('Y-m-d'))-60*60*24*35;
//	    $id = $this->session->userdata('sellerid');
//	    $list = $this->cashlog->OutExcel($id,$start);
//	    if(count($list)!=0)
//	    {
//	        $n=0;
//	        foreach ($list as $vl){
//	            $arrshop[$n]=$vl->shopid;
//	            $n++;
//	        }
//	        if(count($arrshop)==0){
//	            echo "<script>alert('您导出的信息没有店铺数据库哦！');</script>";
//	        }else{
//    	        $shoparr = array_unique($arrshop);
//    	        $shoplist = $this->shop->getArr($shoparr);
//	        }
//	    }
//
//
//	    $this->load->library('Classes/PHPExcel');
//	    $reader = new PHPExcel();
//
//	    /* 可不配置的东西
//	     *  $reader->getProperties()->setCreator("ctos")
//	     ->setLastModifiedBy("ctos")
//	     ->setTitle("Office 2007 XLSX Test Document")
//	     ->setSubject("Office 2007 XLSX Test Document")
//	     ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
//	     ->setKeywords("office 2007 openxml php")
//	    ->setCategory("Test result file"); */
//
//	    // 修改导出以后每个单元格的宽度
//	    $reader->getActiveSheet()->getColumnDimension('A')->setWidth(25);
//	    $reader->getActiveSheet()->getColumnDimension('B')->setWidth(15);
//	    $reader->getActiveSheet()->getColumnDimension('C')->setWidth(40);
//	    $reader->getActiveSheet()->getColumnDimension('D')->setWidth(20);
//	    $reader->getActiveSheet()->getColumnDimension('E')->setWidth(50);
//
//
//	    $reader->getActiveSheet()->mergeCells('A1:E1');
//	    $reader->setActiveSheetIndex(0)
//	    ->setCellValue('A1', '等待转账数据汇总  时间:' . @date('Y-m-d H:i:s'))
//	    ->setCellValue('A2', '类型')
//	    ->setCellValue('B2', '变动情况')
//	    ->setCellValue('C2', '变动后金额')
//	    ->setCellValue('D2', '变动前金额')
//	    ->setCellValue('E2', '时间');
//
//	     $i=0;
//	    foreach ($list as $res) {
//	        if(substr($res->increase, 0,1)=='-'){
//	            $money =  $res->remoney + sprintf($res->increase);
//	        }else{
//	            $money =  $res->remoney + sprintf($res->increase);
//	        }
//	        $reader->getActiveSheet(0)->setCellValue('A' . ($i + 3), $res->type);
//	        $reader->getActiveSheet(0)->setCellValue('B' . ($i + 3), " ".$res->increase);
//	        $reader->getActiveSheet(0)->setCellValue('C' . ($i + 3), " ".$money);
//	        $reader->getActiveSheet(0)->setCellValue('D' . ($i + 3), " ".$res->remoney);
//	        $reader->getActiveSheet(0)->setCellValue('E' . ($i + 3), @date('Y-m-d H:i:s',$res->addtime));
//	        $i++;
//	    }
//
//
//	    $reader->getActiveSheet()->setTitle('转账汇总表');
//
//	    // Set active sheet index to the first sheet, so Excel opens this as the first sheet
//	    $reader->setActiveSheetIndex(0);
//
//	    // Redirect output to a client’s web browser (Excel5)
//	    // ob_end_clean();//清除缓冲区,避免乱码
//	    header('Content-Type: application/vnd.ms-excel');
//	    header('Content-Disposition: attachment;filename="等待转账汇总表(' . @date('Y-m-d H:i:s') . ').xls"');
//	    header('Cache-Control: max-age=0');
//
//	    $objWriter = PHPExcel_IOFactory::createWriter($reader, 'Excel5');
//	    $objWriter->save('php://output');
	}


	public function outExcelNoPay()
    {
        $sql = 'SELECT u.id, u.Username FROM zxjy_usertask as ut
                LEFT JOIN zxjy_user as u on u.id = ut.merchantid
                LEFT JOIN zxjy_task as t on t.id = ut.taskid
                WHERE taskid in (
                SELECT t.id FROM zxjy_task as t
                LEFT JOIN zxjy_taskmodel as tm on tm.pid = t.mark
                WHERE commission = 0
                ) GROUP BY merchantid';
        $uid = $this -> db -> query($sql) -> result_array();
        foreach ($uid as $v)
        {
            if (!empty($v['id']))
            {
                $sql = 'SELECT ut.tasksn, ut.ordersn, t.keyword, tm.price, tm.auction, FROM_UNIXTIME(ut.addtime), 
                        CASE WHEN t.tasktype < 4 THEN
                        CASE WHEN ut.commission = 7 THEN 15
                                 WHEN ut.commission = 8 THEN 16
                                 WHEN ut.commission = 11 THEN 20
                                 WHEN ut.commission = 12 THEN 22
                                 WHEN ut.commission = 13 THEN 24
                        END
                        ELSE
                        CASE WHEN ut.commission = 8 THEN 17
                                 WHEN ut.commission = 9 THEN 18
                                 WHEN ut.commission = 12 THEN 22
                                 WHEN ut.commission = 13 THEN 24
                                 WHEN ut.commission = 14 THEN 29
                        END
                      END
                    FROM zxjy_usertask as ut
                    LEFT JOIN zxjy_taskmodel as tm on tm.id = ut.taskmodelid
                    LEFT JOIN zxjy_task as t on t.id = ut.taskid
                    WHERE merchantid = ' . $v['id'] . ' AND tm.commission = 0';
                $infos = $this -> db -> query($sql) -> result();
                $save_name = '核对表格--' . $v['Username'];
                $set_list = [
                    '任务编号' => 15,
                    '订单编号' => 40,
                    '关键词' => 20,
                    '设置单间价格' => 50,
                    '设置拍下件数' => 40,
                    '接单时间' => 20,
                    '漏扣金额' => 20,
                ];
                $this -> excel($save_name, '订单信息导出', $set_list, $infos);
            }
        }
    }

	/*
	 * 导出订单信息
	 */
	public function outExcel()
    {
        $sql = 'SELECT ut.tasksn, ut.ordersn, p.commodity_abbreviation, p.commodity_id, t.keyword, tf.money, tm.commission FROM zxjy_transfercash as tf
                LEFT JOIN zxjy_usertask as ut on ut.id = tf.usertaskid
                LEFT JOIN zxjy_product as p on p.id = ut.proid
                LEFT JOIN zxjy_task as t on t.id = ut.taskid
                LEFT JOIN zxjy_taskmodel as tm on tm.id = ut.taskmodelid
                WHERE tf.merchantid = ' . $this -> uid . ' AND ut.id is NOT NULL';
        $condition = '';
        if (!empty($_POST['statr']))
        {
            $condition .= ' AND tf.addtime > ' . strtotime($_POST['statr']);
        }
        if (!empty($_POST['end']))
        {
            $condition .= ' AND tf.addtime < ' . strtotime($_POST['end']);
        }
        $sql .= $condition . ' ORDER BY tf.id desc';
        $list = $this -> db -> query($sql) -> result();
        if ($list)
        {
            $save_name = '订单信息记录导出' . $this -> uid;
            $set_list = [
                '任务号' => 15,
                '订单编号' => 40,
                '商品简称' => 20,
                '商品ID' => 50,
                '关键字' => 40,
                '产品金额' => 20,
                '任务佣金' => 20,
            ];
            $this -> excel($save_name, '订单信息导出', $set_list, $list);
        }
        else
            show(0, '暂无订单信息需要导出');

//        $id = $this->session->userdata('sellerid');
//        $list = $this->transfer->getList($id,0,0);
//        $arrtask = array();$n=0;
//        $alltask = array();
//        foreach($list as $vl){
//            $arrtask[$n++] = $vl->usertaskid;
//        }
//        //array_unique($array);
//        if(count($arrtask)==0){
//            echo "<script>alert('暂无数据');history.back();</script>";
//            exit;
//        }else {
//            $usertask = $this->usertask->getArr(array_unique($arrtask));
//            $product = array();
//            $m = 0;
//            $model = array();
//            foreach ($usertask as $vut) {
//                $alltask[$m] = $vut->taskid;
//                $model[$m] = $vut->taskmodelid;
//                $product[$m++] = $vut->proid;
//            }
//            if (count($product) != 0) {
//                $product = $this->pro->getArr(array_unique($product));
//                $task = $this->task->getArr(array_unique($alltask));
//                $model = $this->task->getModelArr(array_unique($model));
//
//                $this->load->library('Classes/PHPExcel');
//                $reader = new PHPExcel();
//
//                // 修改导出以后每个单元格的宽度
//                $reader->getActiveSheet()->getColumnDimension('A')->setWidth(25);
//                $reader->getActiveSheet()->getColumnDimension('B')->setWidth(15);
//                $reader->getActiveSheet()->getColumnDimension('C')->setWidth(40);
//                $reader->getActiveSheet()->getColumnDimension('D')->setWidth(20);
//                $reader->getActiveSheet()->getColumnDimension('E')->setWidth(50);
//                $reader->getActiveSheet()->getColumnDimension('F')->setWidth(20);
//                $reader->getActiveSheet()->getColumnDimension('G')->setWidth(20);
//
//
//                $reader->getActiveSheet()->mergeCells('A1:G1');
//                $reader->setActiveSheetIndex(0)
//                    ->setCellValue('A1', '订单信息汇总表  导出时间:' . @date('Y-m-d H:i:s'))
//                    ->setCellValue('A2', '任务号')
//                    ->setCellValue('B2', '订单编号')
//                    ->setCellValue('C2', '商品简称')
//                    ->setCellValue('D2', '商品ID')
//                    ->setCellValue('E2', '关键字')
//                    ->setCellValue('F2', '产品金额')
//                    ->setCellValue('G2', '任务佣金');
//
//                $i=0;
//                foreach($list as $vl) {
//                    $taskNumber = '';
//                    $orderNumber = '';
//                    foreach($usertask as $vu){
//                        if($vu->id==$vl->usertaskid){
//                            $taskNumber = $vu->tasksn;
//                            $orderNumber = $vu->ordersn;
//                        }
//                    }
//                    $productInfo ='';
//                    $productInfoID ='';
//                    foreach($usertask as $vu){
//                        if($vu->id==$vl->usertaskid){
//                            foreach($product as $vp){
//                                if($vp->id == $vu->proid){
//                                    $productInfo = $vp->commodity_abbreviation;
//                                    $productInfoID = $vp->commodity_id;
//                                }
//                            }
//                        }
//                    }
//                    $keyWords = '';
//                    foreach($usertask as $vu){
//                        if($vu->id==$vl->usertaskid){
//                            foreach($task as $vp){
//                                if($vp->id == $vu->taskid){
//                                    $keyWords = $vp->keyword;
//                                }
//                            }
//                        }
//                    }
//                    $proMoney = '';
//                    foreach($usertask as $vu){
//                        if($vu->id==$vl->usertaskid){
//                            foreach($model as $vm){
//                                if($vm->id == $vu->taskmodelid){
//                                    $proMoney = $vm->commission;
//                                }
//                            }
//                        }
//                    }
//
//                    $reader->getActiveSheet(0)->setCellValue('A' . ($i + 3), " ".$taskNumber);
//                    $reader->getActiveSheet(0)->setCellValue('B' . ($i + 3), " ".$orderNumber);
//                    $reader->getActiveSheet(0)->setCellValue('C' . ($i + 3), " ".$productInfo);
//                    $reader->getActiveSheet(0)->setCellValue('D' . ($i + 3), " ".$productInfoID);
//                    $reader->getActiveSheet(0)->setCellValue('E' . ($i + 3), " ".$keyWords);
//                    $reader->getActiveSheet(0)->setCellValue('F' . ($i + 3), " ".$vl->money);
//                    $reader->getActiveSheet(0)->setCellValue('G' . ($i + 3), " ".$proMoney);
//                    $i++;
//                }
//
//                $reader->getActiveSheet()->setTitle('转账汇总表');
//
//                // Set active sheet index to the first sheet, so Excel opens this as the first sheet
//                $reader->setActiveSheetIndex(0);
//
//                // Redirect output to a client’s web browser (Excel5)
//                // ob_end_clean();//清除缓冲区,避免乱码
//                header('Content-Type: application/vnd.ms-excel');
//                header('Content-Disposition: attachment;filename="等待转账汇总表(' . @date('Y-m-d H:i:s') . ').xls"');
//                header('Cache-Control: max-age=0');
//
//                $objWriter = PHPExcel_IOFactory::createWriter($reader, 'Excel5');
//                $objWriter->save('php://output');
//            } else {
//                echo "<script>alert('产品数据表报错了，可能是因为您删除了您已经放单的产品造成的。');history.back();</script>";
//                exit;
//            }
//        }

    }



    //=================================================
    //对提交转换后的检查商家是否全部本金转账，则对其用户状态解冻
	/*
    public  function  Update_UserStatusIfTransferCashIsOK( $userID )
    {
        if ($this -> uid != 2)
        {
            $sql = @"SELECT COUNT(1) as CC FROM  zxjy_user A INNER JOIN zxjy_transfercash B ON A.id=B.merchantid
    	WHERE  B.transferstatus <= 1  AND  UNIX_TIMESTAMP(DATE_FORMAT(FROM_UNIXTIME(B.addtime + 60 * 60 *24), '%Y-%m-%d 12:00:00')) < UNIX_TIMESTAMP(NOW())
    	AND B.merchantid IS NOT NULL  And   A.opend= 1  AND A.id='{$userID}';" ;
            sleep(10);
            $dbRs =  $this->db->query($sql)->row() ;
            $rsCount = $dbRs->CC;
            if($rsCount == false || $rsCount == 0)
            {
                $sql= "UPDATE zxjy_user SET Status=0 WHERE id='{$userID}' ;" ;
                $num = 4;
                $up_res = $this->db->query($sql);
                while(!$up_res && $num--)
                {
                    $up_res = $this->db->query($sql);
                }
                if ($up_res)
                {
                    RedisCache::del('server_info_' . $this -> uid);
                    return true;
                }
                else
                {
                    file_put_contents('./transfercash.txt', date('Y-m-d H:i:s') . ' -- ' . $this -> uid . '：自动解冻失败--' . $rsCount . "\r\n", FILE_APPEND);
                    show(0, '自动解冻失败，请联系客服进行解冻');
                }
            }
            else
                file_put_contents('./transfercash.txt', date('Y-m-d H:i:s') . ' -- ' . $this -> uid . '：未进入解冻模块--' . $rsCount . "\r\n", FILE_APPEND);
        }
    }
	*/
	
	public  function  Update_UserStatusIfTransferCashIsOK( $userID )
    {
        $db2_config = [
            'dsn'	=> '',
            'hostname' => '172.16.16.7',
            'username' => 'amoeba',
            'password' => '123456',
			'database' => 'aaa',
			'dbdriver' => 'mysqli',
			'dbprefix' => 'zxjy_',
			'pconnect' => FALSE,
			'db_debug' => (ENVIRONMENT !== 'production'),
			'cache_on' => FALSE,
			'cachedir' => '',
			'char_set' => 'utf8',
			'dbcollat' => 'utf8_general_ci',
			'swap_pre' => '',
			'encrypt' => FALSE,
			'compress' => FALSE,
			'stricton' => FALSE,
			'failover' => array(),
			'save_queries' => TRUE
        ];
        $master = $this -> load -> database($db2_config, TRUE);  //连接主库，预防主从同步延迟导致的解冻失败
        $sql = @"SELECT COUNT(1) as CC FROM  zxjy_user A INNER JOIN zxjy_transfercash B ON A.id=B.merchantid
    	WHERE  B.transferstatus <= 1  AND  UNIX_TIMESTAMP(DATE_FORMAT(FROM_UNIXTIME(B.addtime + 60 * 60 *24), '%Y-%m-%d 12:00:00')) < UNIX_TIMESTAMP(NOW())
    	AND B.merchantid IS NOT NULL  And   A.opend= 1  AND A.id='{$userID}';" ;
        $dbRs =  $master -> query($sql) -> row();
        $rsCount = $dbRs->CC;
        if($rsCount == false || $rsCount == 0)
        {
            $sql= "UPDATE zxjy_user SET Status=0 WHERE id='{$userID}' ;" ;
            $num = 4;
            $up_res = $master -> query($sql);
            while(!$up_res && $num--)
            {
                $up_res = $master -> query($sql);
            }
            if ($up_res)
            {
                RedisCache::del('server_info_' . $this -> uid);
                return true;
            }
            else
            {
                file_put_contents('./transfercash.txt', date('Y-m-d H:i:s') . ' -- ' . $this -> uid . '：自动解冻失败--' . $rsCount . "\r\n", FILE_APPEND);
                show(0, '自动解冻失败，请联系客服进行解冻');
            }
        }
        else
            file_put_contents('./transfercash.txt', date('Y-m-d H:i:s') . ' -- ' . $this -> uid . '：未进入解冻模块--' . $rsCount . "\r\n", FILE_APPEND);
    }
	
	
	public function  test22()
    {
        $db2_config = [
            'dsn'	=> '',
            'hostname' => '172.16.16.7',
            'username' => 'amoeba',
            'password' => '123456',
            'database' => 'aaa',
            'dbdriver' => 'mysqli',
            'dbprefix' => 'zxjy_',
            'pconnect' => FALSE,
            'db_debug' => (ENVIRONMENT !== 'production'),
            'cache_on' => FALSE,
            'cachedir' => '',
            'char_set' => 'utf8',
            'dbcollat' => 'utf8_general_ci',
            'swap_pre' => '',
            'encrypt' => FALSE,
            'compress' => FALSE,
            'stricton' => FALSE,
            'failover' => array(),
            'save_queries' => TRUE
        ];
        $master = $this -> load -> database($db2_config, TRUE);  //连接主库，预防主从同步延迟导致的解冻失败
        $sql = @"SELECT COUNT(1) as CC FROM  zxjy_user A INNER JOIN zxjy_transfercash B ON A.id=B.merchantid
    	WHERE  B.transferstatus <= 1  AND  UNIX_TIMESTAMP(DATE_FORMAT(FROM_UNIXTIME(B.addtime + 60 * 60 *24), '%Y-%m-%d 12:00:00')) < UNIX_TIMESTAMP(NOW())
    	AND B.merchantid IS NOT NULL  And   A.opend= 1  AND A.id='{$userID}';" ;
        $dbRs =  $master -> query($sql) -> row();
        $rsCount = $dbRs->CC;
        var_dump($rsCount);
    }
	
	public function statistics1111()
    {
        $sql = 'SELECT id, uid, estimate_data FROM zxjy_1111survey';
        $estimate_data = $this -> db -> query($sql) -> result();
		$estimate = [
			'2018-11-07' => 0,
			'2018-11-08' => 0,
			'2018-11-09' => 0,
			'2018-11-10' => 0,
			'2018-11-11' => 0,
		];
		$i = 0;
		foreach($estimate_data as $v)
		{
			if (!in_array($v -> id, [172, 237]))
			{
				$infos = RedisCache::get('server_info_' . $v -> uid);
				if (!$infos)
				{
					//RedisCache::del('statistics1111_' . $v -> uid);
					$sql = "SELECT maxtask FROM zxjy_user WHERE id = {$v -> uid}";
					$infos['info'] = $this -> cacheSqlQuery('statistics1111_' . $v -> uid, $sql, 60 * 60, true, 'first_row');
				}
				if ($infos)
				{
					$maxtask = $infos['info'] -> maxtask;
					$temp = unserialize($v -> estimate_data);
					$estimate['2018-11-07'] = $temp[0] <= $maxtask ? $estimate['2018-11-07'] + $temp[0] : $estimate['2018-11-07'];
					$estimate['2018-11-08'] = $temp[1] <= $maxtask ? $estimate['2018-11-08'] + $temp[1] : $estimate['2018-11-08'];
					$estimate['2018-11-09'] = $temp[2] <= $maxtask ? $estimate['2018-11-09'] + $temp[2] : $estimate['2018-11-09'];
					$estimate['2018-11-10'] = $temp[3] <= $maxtask ? $estimate['2018-11-10'] + $temp[3] : $estimate['2018-11-10'];
					$estimate['2018-11-11'] = $temp[4] <= $maxtask ? $estimate['2018-11-11'] + $temp[4] : $estimate['2018-11-11'];
				}
				else
					$i++;
				
				//$data = unserialize(preg_replace('!s:(\d+):"(.*?)";!se', '"s:".strlen("$2").":\"$2\";"', $v -> estimate_data));
			}
			
		}
		foreach ($estimate as $k => $v)
		{
			echo $k . ':  ' . $v . '单<br/>';
		}
		echo $i;
    }
	
	
	/*
     * 导出指定条件的记录
     */
    public function excelout2()
    {
        $outbanknumber = $this->blank->getOne($this -> uid);
        $save_name = substr($outbanknumber -> bankAccount, -4) . '转账管理记录-' . $this -> get_total_millisecond();
        if ($outbanknumber)
        {
            $sql = 'SELECT bl.bankAccount, 
                    IF(bl.truename = "", u.TrueName, bl.truename) as truenam,
                    tc.money, tc.ordersn, bl.bankName, bl.subbranch, tc.transferstatus, bw.wangwang, bl.bankAddress, ut.orderprice FROM zxjy_transfercash as tc
                    LEFT JOIN zxjy_usertask as ut on ut.id = tc.usertaskid
                    LEFT JOIN zxjy_user as u on u.id = ut.userid
                    LEFT JOIN zxjy_banklist as bl on bl.id = tc.bankid
                    LEFT JOIN zxjy_blindwangwang as bw on bw.userid = u.id
                    LEFT JOIN zxjy_shop as s on s.sid = ut.shopid
                    WHERE tc.merchantid = ' . $this -> uid . ' AND usertaskid in (SELECT id FROM zxjy_usertask WHERE taskid in (
                        SELECT id FROM zxjy_task WHERE tasktype = 4
                    ) AND status >= 4)';
            $list = $this -> db -> query($sql) -> result();
            if ($list)
            {
                foreach ($list as &$v)
                {
                    switch($v -> transferstatus)
                    {
                        case 1:
                            $v -> transferstatus = '等待转账';
                            break;
                        case 2:
                            $v -> transferstatus = '已转账';
                            break;
                        case 3:
                            $v -> transferstatus = '转账失败';
                            break;
                        case 4:
                            $v -> transferstatus = '未到账';
                            break;
                    }
					$v -> money = $v -> orderprice - $v -> money;
                    $bankAddress = array_filter(explode('  ', $v -> bankAddress));
                    $v -> ordersn = $v -> wangwang . ' | ' .  $v -> transferstatus . ' | ' . $v -> ordersn;
                    unset($v -> transferstatus);
                    unset($v -> wangwang);
                    unset($v -> bankAddress);
                    unset($v -> orderprice);
                    $province_suffix = strpos(@$bankAddress[0], '省') ? '省' : (strpos(@$bankAddress[0], '市') ? '市' : '');
                    $v -> province = !empty($province_suffix) ? substr(@$bankAddress[0], 0, strpos(@$bankAddress[0], $province_suffix)) : @$bankAddress[0];
                    $city_suffix = strpos(@$bankAddress[1], '市') ? '市' : '';
                    $v -> city = !empty($city_suffix) ? substr(@$bankAddress[1], 0, strpos(@$bankAddress[1], $city_suffix)) : @$bankAddress[1];
                }
                $set_list = [
                    '收款账户列' => 25,
                    '收款户名列' => 15,
                    '转账金额列' => 13,
                    '备注列' => 50,
                    '收款银行列' => 25,
                    '收款银行支行列' => 25,
                    '收款省/直辖市列' => 15,
                    '收款市县列' => 10,
                ];
                $this -> excel($save_name, '等待转账记录', $set_list, $list, true, [], false);
            }
            else
                show(0, '暂时没有等待转账的记录可以导出');
        }
        else
            show(0, '您尚未绑定银行卡，无法导出数据');
    }
















}
