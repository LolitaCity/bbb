<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sales extends CI_Controller {

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
        $this->load->model('Task_model','task');
        $this->load->model('Usertask_model','usertask');
        $this->load->model('Blindwangwang_model','bindwangwang');
        $this->load->model('Buyer_model','buyer');
        $this->load->model('Taskevaluate_model','taskevaluate');
        $this->load->model('Complaint_model','complaint');
        $this->load->model('System_model','system');
        
    }
    public function _include(){
        $id = $this->session->userdata('sellerid');
        $db['info'] = $this->user->getInfo($id);
        $db['showcontent'] = 1 ;
	    $db['service1'] = $this->system->getInfo(87);
	    $db['service2'] = $this->system->getInfo(88);
        return $db;
    }
    public function index(){//发布任务		    
	    $db=$this->_include();
	    if($db['info']->Status==0){
            $id = @$_GET['id']==''?0:@$_GET['id'];
            $db['myint'] = $id;
            $proid = @$_GET['proid']==''?0:@$_GET['proid'];
            if($proid!=0){
               $db['proinfo']=$this->product->getInfo($proid);
            }
            $db['proid']=$proid;
            $db['shop']=$this->shop->getlist($db['info']->id,1,0,0,0);
            
            $this->session->set_userdata('typepage',$id);
            setcookie('typepage',$id);
            
            if($id==3){
               $time = @strtotime(@date("Y-m-d",@strtotime("+1 month")));
               $db['counttask'] = $this->usertask->getCount($time,$id);
                //var_dump($db['proinfo']);
                // $this->load->view('rebuy', $db);
                 //$db['counttask'] =50;
                 
                 if($db['counttask'] !=0) {
                     $this->load->view('rebuy', $db);
                 }else{
                     echo "<script>alert('您还没有潜在用户可以接到您的复购任务哦！');</script>";
                     echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=sales\" >";
                 }
            }else{
               $this->load->view('release',$db);
            }
        }else{
	        echo "<script>alert('您的账户已经被冻结了，不能发布任务！');</script>";
	        echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=../user\" >";
        }
	    
	}
	public function infoshow(){ // 弹窗先选类型···
	    $db=$this->_include();
	    $this->load->view('MsgTaskType');
	}
	public function choosepro(){
	    $db=$this->_include();	    
	    $this->load->view('SelectProduct',$db);
	}
	public function SelectProduct($key=0){// 选产品信息
	    if($key==0){
	        echo "<script>alert('请不要测试错误链接！谢谢！');history.back();</script>";
	    }else{
    	    $db=$this->_include();
    	    $db['shopid']=@$_GET['ShopID']==''?'0':@$_GET['ShopID']; 
    	    $db['serachtype']=@$_GET['SelSearch']==''?'':@$_GET['SelSearch']; 
    	    $db['TxtSearch']=@$_GET['TxtSearch']==''?'':@$_GET['TxtSearch']; 
    	    if($db['shopid']==0){
    	        $shopid='all';
    	    }else{
    	        $shopid=$db['shopid'];
    	    }    
            $db['pros'] = $this->product->getListPro($db['info']->id,$shopid,$db['serachtype'],$db['TxtSearch']);
            $db['shops'] = $this->shop->getlist($db['info']->id,1,0,0,0);//这里是获取店铺信息的
            $db['infoint'] = $key;
            $this->load->view('SelectProduct',$db);
	    }
	}
	public function taskno(){
	    $db=$this->_include();
	    
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
	    
	    
        $db['list'] = $this->task->getNoArr($db['info']->id);
        $db['listmodel'] = $this->task->getNoModelArr($db['info']->id);
        $db['listtime'] = $this->task->getNoTimeArr($db['info']->id);
        $db['shoplist'] = $this->shop->getlist($db['info']->id,'all',0,0,0);
        $db['prolist'] = $this->product->getList($db['info']->id,'all','all','all',0,0,0);
        $this->load->view('taskno',$db);
    }

    public function CloseOne(){
        $key = @$_POST['keys']==''?0:@$_POST['keys'];
        $json = 0;
       // echo json_encode($key);
        if($key==0){
            $json = 1;
        }else{
            $info = $this->task->getInfo($key);
            if($info!=null){
                $dbtask['del'] = $info->del + $info->number - $info->qrnumber; //总表信息删除
                
                //修改model表信息
                $dbmodel = $this->task->getBuyPidModel($info->mark);
                foreach($dbmodel as $vdm){
                    if($vdm->number > ($vdm->del + $vdm->takenumber)){
                        $dbmodels['del'] = $vdm->del + $vdm->number - $vdm->takenumber;
                        $this->task->updatamodel($vdm->id,$dbmodels);
                    }
                }
                
                //修改时间表信息
                $dbtime = $this->task->getBuyPidTime($info->mark);
                foreach($dbtime as $vdt){
                    if($vdt->number > ($vdt->del + $vdt->takenumber)){
                        $dbtimes['del'] = $vdt->del + $vdt->number - $vdt->takenumber;
                        $this->task->updatatime($vdt->id,$dbtimes);
                    }
                }
                
                //修改任务总表信息
                $re = $this->task->updata($info->id,$dbtask);
                if($re){
                   $json = 0;
                }else{
                    $json = 3;
                }
            }else{
                $json = 2;
            }
        }
        echo json_encode($json); 
    }
    
    public function hideOne(){
        $key = @$_POST['keys']==''?0:@$_POST['keys'];
        $json = 0;
        if($key==0){
            $json = 1;
        }else{
            $info = $this->task->getInfo($key);
            if($info!=null){
                if($info->status == 1){
                    $db['status'] =0;
                }else{
                    $db['status'] =1;
                }
                $re = $this->task->updata($info->id,$db);
                if($re){
                    $json =0;
                }else{
                    $json =3;
                }
            }else{
                $json = 2;
            }
        }
        echo json_encode($json);
    }



    public function closeTaskAll(){
	    $key = $_POST['key'];
	    $json ='';
	    if($key==0 || $key ==''){
            $json= 1;
        }else{
            $userinfo = $this->user->getInfo($key);
            if($userinfo != null){
                $list = $this->task->getNoArr($key);
                $listmodel = $this->task->getNoModelArr($key);
                $listtime = $this->task->getNoTimeArr($key);
                foreach($list as $vl){
                    if($vl->number > ($vl->qrnumber + $vl->del)){
                        $db['del'] = $vl->number - $vl->qrnumber;
                        $this->task->updata($vl->id,$db);
                    }
                }
                foreach($listmodel as $vlm){
                    if($vlm->number > ($vlm->takenumber + $vlm->del)){
                        $db['del'] = $vlm->number - $vlm->takenumber;
                        $this->task->updatamodel($vlm->id,$db);
                    }
                }
                foreach($listtime as $vlt){
                    if($vlt->number > ($vlt->takenumber + $vlt->del)){
                        $db['del'] = $vlt->number - $vlt->takenumber;
                        $this->task->updatatime($vlt->id,$db);
                    }
                }
                $json= 0;
            }else{
                $json = 2;
            }
        }
        echo json_decode($json);
    }
	public function taskyes(){
	    
	    $db=$this->_include();
        $page = @$_GET['page']==''?0:@$_GET['page'];
	    $db['list'] = $this->usertask->getlist($db['info']->id,'all',10,$page*10);
	    $db['count'] = $this->usertask->getListCount($db['info']->id,'all');
	    //echo $db['count'];
	    $db['page'] = $page;

        $arrtaskmodel = array();$a=0;
        $arrtask = array();
	    foreach($db['list'] as $vv){
            $arrtask[$a] = $vv->taskid;
            $arrBind[$a] = $vv->userid;
            $arrShop[$a] = $vv->shopid;
            $arrtaskmodel[$a++] = $vv->taskmodelid;
        }
        if(count($arrtask)==0){
            echo "<script>alert('暂无数据');history.back();</script>";
        }else{
            $db['taskmodel'] =  $this->task->getModelArr($arrtaskmodel);
            $db['taskbind'] =  $this->bindwangwang->getArr($arrBind);// 旺旺号
            $db['taskshop'] =  $this->shop->getArr($arrShop);// 店铺号
            //$db['taskbind'] =  $this->bindwangwang->getArr($arrBind);
    
            $db['skey']=0;
    	   // $db['model'] = $this->task->
            $db['search']=false;
    	    $this->load->view('task',$db);
        }
	}
	public function searchtask(){
	    $db=$this->_include();
	    $page = @$_GET['page']==''?0:@$_GET['page'];
	    $db['types']=$types=@$_POST['taskCategroy']==0?'all':@$_POST['taskCategroy'];
	    $db['status']=$status=@$_POST['status']==0?'all':@$_POST['status'];
	    $db['selSearch']=$selSearch=@$_POST['selSearch'];
	    $db['txtSearch']=$txtSearch=@$_POST['txtSearch'];

	    $db['start']=$start=@$_POST['BeginDate']==''?0:@$_POST['BeginDate'];
	    $db['end']=$end=@$_POST['EndDate']==''?0:@$_POST['EndDate'];

	    if(@strtotime($start) > ($end==0?time():@strtotime($end))){
	        echo "<script>alert('开始时间不能大于结束时间/当前时间');</script>";
	        echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=../sales/taskyes.html\" >";
	        exit;
	    }
	   //echo $selSearch.'<-->'.$txtSearch;
    	$db['list'] = $this->usertask->searchList($db['info']->id,$status,$selSearch,$txtSearch,@strtotime($start),@strtotime($end),10,$page*10,$types);
    	//var_dump($db['list']);
    	$db['count'] = $this->usertask->searchCount($db['info']->id,$status,$selSearch,$txtSearch,$start,$end,$types);
    	if($db['count']!=0){
        	$arrtaskmodel = array();$a=0;
        	$arrtask = array();
        	foreach($db['list'] as $vv){
        	    $arrtask[$a] = $vv->taskid;
        	    $arrBind[$a] = $vv->userid;
        	    $arrShop[$a] = $vv->shopid;
        	    $arrtaskmodel[$a++] = $vv->taskmodelid;
        	}
        	//var_dump($arrtaskmodel);
        	if(count($arrtask)!=0 && count($arrBind)!=0 && count($arrShop)!=0 && count($arrtaskmodel)!=0){
            	$db['taskmodel'] = $this->task->getModelArr($arrtaskmodel); // 获取型号的信息            	
            	$db['taskbind'] = $this->bindwangwang->getArr($arrBind); // 旺旺号
            	$db['taskshop'] = $this->shop->getArr($arrShop); // 店铺号
            	$db['page'] = $page;
            	$db['skey'] = 1;
            	$db['search']=true;
            	$this->load->view('task',$db);
        	}else{
        	    echo "<script>alert('暂无数据');</script>";
	            echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=../sales/taskyes.html\" >";        	    
        	}        	
    	}else{
    	    echo "<script>alert('暂无数据！');history.back();</script>";
	        echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=../sales/taskyes.html\" >";
    	}
	}
	
	public function buyerinfo(){
	    $buyer = $_GET['buyer']==''?0:$_GET['buyer'];
        if($buyer==0){
            echo "<script>alert('读取刷手信息出错，稍后重试！');history.back();</script>";
        }else{
            $buyerinfo = $this->buyer->getInfo($buyer);
            if($buyerinfo != null){
                $db['buyerinfo'] = $buyerinfo;
                $db['userinfo'] = $this->user->UseID($buyerinfo->userid);
                $db['wangwang'] = $this->bindwangwang->getInfo($buyerinfo->wangwangid);
                $this->load->view('GetDetailInfo',$db);
            }else{
                echo "<script>alert('买号信息获取失败！');history.back();</script>";
            }
        }
    }
    public function seepic(){
	    $id = $_GET['key']==''?0:$_GET['key'];
	    if($id==0){
            echo "<script>alert('请不要尝试错误链接谢谢！');history.back();</script>";
        }else{
	        $info = $this->usertask->getInfo($id);
	        if($info != null){
	            $up['showpicbtn'] =1;
	            $this->usertask->updata($info->id,$up);
	            $db['info'] = $this->usertask->getInfo($info->id);
	            $db['proinfo'] = $this->task->getInfo($db['info']->taskid);
                $this->load->view('GetPictures',$db);
            }else{
	            echo "<script>alert('您要查看的信息数据不存在了，请重新加载页面后尝试！');history.back();</script>";
            }
        }
    }
    public function remark(){
        $id = $_GET['key']==''?0:$_GET['key'];
        if($id ==0 ){
            echo "<script>alert('请不要尝试错误链接');history.back();</script>";
        }else{
            $info = $this->usertask->getInfo($id);
            if($info != null) {
                $db['info'] = $info;
                $this->load->view('EditTaskRemark',$db);
            }else{
                echo "<script>alert('您要查看的信息数据不存在了，请重新加载页面后尝试！');history.back();</script>";
            }
        }
    }
    public function remarkDB(){
        $id = @$_POST['id'];
        $TaskID = @$_POST['tasksnid'];
        $db['remark'] = $_POST['TaskRemark'];
        $reinfo = $this->usertask->checked($id,$TaskID);
        if($reinfo != null){
            $re = $this->usertask->updata($id,$db);
            if($re){
                echo "<script>alert('提交成功！'); parent.location.reload();</script>";
            }else{
                echo "<script>alert('系统现在繁忙中，请稍后重试！');parent.location.reload();</script>";
            }
        }else{
            echo "<script>alert('错误链接信息！');parent.location.reload();</script>";
        }
    }

    public function sendGoods(){
        $id = $_GET['key']==''?0:$_GET['key'];
        if($id==0){
            echo "<script>alert('请不要尝试错误链接');history.back();</script>";
        }else{
            $info = $this->usertask->getInfo($id);
            if($info!=null){
                $db['info'] = $info;
                $this->load->view('FaHuo',$db);
            }else{
                echo "<script>alert('错误连接信息！');history.back();</script>";
            }
        }
    }
     public function sendGoodsDB(){
        $id = @$_POST['id']==''?0:$_POST['id'];
        if($id ==0 ){
            echo "<script>alert('请不要尝试错误链接！');parent.location.reload();</script>";
        }else{
            $re = $this->usertask->getInfo($id);
            if($re!=null){
                $company = $_POST['ExpressCompany'];
                $express = $_POST['ExpressNumber'];
                $db['expressnum'] = $company.'&'.$express;
                $db['status'] = 2;
                $re = $this->usertask->updata($id,$db);
                if($re){
                    echo "<script>alert('提交成功！');parent.location.reload();</script>";
                }else{
                    echo "<script>alert('系统繁忙中，请稍后重试！');parent.location.reload();</script>";
                }
            }else{
                echo "<script>alert('错误链接信息！');parent.location.reload();</script>";
            }
        }
     }

     public function taskInfoDetail(){
         $key = @$_GET['key']==''?0:@$_GET['key'];
         if($key==0){
              echo "<script>alert('请不要尝试错误链接谢谢！');history.back();</script>";
         }else{
             $usertask = $this->usertask->getInfo($key);
             if($usertask!=null){
                 $db['taskinfo'] = $usertask;
                 $db['tasktime'] = $this->task->getInfoTime($usertask->tasktimeid);
                 $db['taskmodel'] = $this->task->getInfoModel($usertask->taskmodelid);
                 $db['task'] = $this->task->getInfo($usertask->taskid);
                 $db['product'] = $this->product->getInfo($usertask->proid);
                 $this->load->view('GetTaskDatailInfo',$db);
             }else{
                 echo "<script>alert('获取数据失败了，请时刷新页面后重新尝试!');history.back();</script>";
             }
         }
     }


     public function sendMoney(){
         $key = @$_GET['key']==''?0:@$_GET['key'];
         if($key ==0){
             echo "<script>alert('请不要尝试错误链接谢谢！');history.back();</script>";
         }else{
             $info = $this->usertask->getInfo($key);
             if($info != null){
                 $dbusertask['Status'] = 4;                 
                 $this->usertask->updata($info->id,$dbusertask);

                 $shuashou = $this->user->getInfo($info->userid);
                 $db['Money'] = $shuashou->Money + $info->commission;
                 $db['Score'] = $shuashou->Score + 10;
                 // 修改刷手获取佣金
                                                 
                 
                 $reuser = $this->user->updata($info->userid,$db);
                 if($reuser){
                     $this->load->model('Cash_model','cashlog');
                     // 现金记录
                     $dbcls['type'] = '任务佣金';
                     $dbcls['remoney'] = $shuashou->Money + $info->commission;
                     $dbcls['increase'] = '+'.$info->commission;
                     $dbcls['beizhu'] = '完成任务获取';
                     $dbcls['addtime'] = @strtotime(@date('Y-m-d H:i:s'));
                     $dbcls['userid'] = $info->userid;
                     $dbcls['usertaskid'] = $info->id;
                     $dbcls['proid'] = $info->proid;
                     $dbcls['shopid'] = $info->shopid;
                     $this->cashlog->add($dbcls);
                     
                     //刷手积分
                     $this->load->model('Score_model','sc');
                     $sc['userid'] = $shuashou->id;
                     $sc['original_score'] = $shuashou->Score;
                     $sc['score_info'] = '+10';
                     $sc['score_now'] = $db['Score'];
                     $sc['description'] = '完成任务获得积分';
                     $sc['add_time'] = @strtotime(@date('Y-m-d H:i:s'));
                     $this->sc->add($sc);
                     
                     

                     //计算刷手获取推广金
                     $this->load->model('System_model','system');
                     if($shuashou->IdNumber != ''){
                         $getcommissionuser = $this->user->getInfo($shuashou->IdNumber);
                         if($getcommissionuser->iscommission=='1' && $getcommissionuser->ispromoter=='1' ){ // 获取佣金
                             $shuashoutuiguang = $this->system->getInfo(83);// 推广需要添加的费用
                             $gcum['Money'] = $getcommissionuser->Money + $shuashoutuiguang->value;
                             $this->user->updata($getcommissionuser->id,$gcum);

                             $dbcl['type'] = '任务佣金';
                             $dbcl['remoney'] = $getcommissionuser->Money+$shuashoutuiguang->value;
                             $dbcl['increase'] = '+'.$shuashoutuiguang->value;
                             $dbcl['beizhu'] = '推广人员完成任务返现';
                             $dbcl['addtime'] = @strtotime(@date('Y-m-d H:i:s'));
                             $dbcl['userid'] = $getcommissionuser->id;
                             $dbcl['usertaskid'] = $info->id;
                             $dbcl['proid'] = $info->proid;
                             $dbcl['shopid'] = $info->shopid;
                             $this->cashlog->add($dbcl);

                         } //不用返还佣金
                     }// 没有佣金情况

                     

                     //商家推广获取推广金
                     $thisshop = $this->user->getInfo($info->merchantid);//商家信息
                     if($thisshop->parentid != ''){
                         $parentshop = $this->user->getInfo($thisshop->parentid );// 商家上级信息
                         if($parentshop->iscommission=='1' && $parentshop->ispromoter=='1' ){
                             $shoptuiguangjin = $this->system->getInfo(82);// 推广需要添加的费用
                             $pcum['Money'] = $parentshop->Money + $shoptuiguangjin->value;
                             $this->user->updata($parentshop->id,$pcum);


                             $dbsl['type'] = '任务佣金';
                             $dbsl['remoney'] = $pcum['Money'];
                             $dbsl['increase'] = '+'.$shoptuiguangjin->value;
                             $dbsl['beizhu'] = '推广商家完成发布任务获得';
                             $dbsl['addtime'] = @strtotime(@date('Y-m-d H:i:s'));
                             $dbsl['userid'] = $parentshop->id;
                             $dbsl['usertaskid'] = $info->id;
                             $dbsl['proid'] = $info->proid;
                             $dbsl['shopid'] = $info->shopid;
                             $this->cashlog->add($dbsl);
                         }
                     }
                     
                     
                 }else{
                     echo "<script>alert('系统现在正在繁忙中，请稍后再来确认吧！');history.back();</script>";
                 } 
             }else{
                 echo "<script>alert('错误链接信息！');history.back();</script>";
             }
         }
     }

     public function AddEvaluate(){
         $key = @$_GET['key']==''?0:@$_GET['key'];
         if($key==0){
             echo "<script>alert('请不要尝试错误链接谢谢！');history.back();</script>";
         }else{
             $usertask = $this->usertask->getInfo($key);
             if($usertask!=null){
                 $db['info'] = $usertask;
                 $this->load->model('System_model','system');
                 $db['word'] =$this->system->getInfo(84);
                 $db['pic'] =$this->system->getInfo(85);
                 $this->load->view('AddEvaluate',$db);
             }else{
                 echo "<script>alert('获取数据失败了，请时刷新页面后重新尝试!');history.back();</script>";
             }
         }
     }
     public function addEvaluateDB(){
         $usertaskid = @$_POST['id'];
         $usertaskinfo = $this->usertask->getInfo($usertaskid);
         $db['usertaskid'] = $usertaskinfo->id;
         $db['addtime'] = @strtotime(@date('Y-m-d H:i:s'));
         $db['doid'] = $usertaskinfo->userid;
         $db['sellerid'] = $usertaskinfo->merchantid;
         $this->load->model('System_model','system');
         $db['content'] = $_POST['content'];
         $db['status'] = $_POST['picstatus'];
         $db['doing'] = 0;
         if($db['status']==0){
             $iscommission = $this->system->getInfo(83);
             $db['iscommission'] =$iscommission->value;
         }else{
             $iscommission = $this->system->getInfo(84);
             $db['iscommission'] =$iscommission->value;
              //图片评价任务
             // 获取上传的多图信息
             $files = $_FILES['inputimage'];
             //var_dump($_FILES['inputimage']);
             if($files['error'][0] == 0){
                 $saveway = "./uploads/".@date('Y').'/'.@date('m').'/';
                 if(!file_exists("./uploads/".@date('Y').'/'.@date('m'))){
                    mkdir("./uploads/".@date('Y').'/'.@date('m'),0777,true);
                 }
                 //$files=array_filter($files,'check');
                // $array = array_filter($_FILES['inputimage']['name'],'check');

                 $n=0;
                 $m=0; $arr = array();
                 foreach($_FILES['inputimage']['tmp_name'] as $k=>$v){
                     if( ($_FILES['inputimage']['type'][$k]=="image/gif") || ($_FILES['inputimage']['type'][$k]=="image/jpeg") || ($_FILES['inputimage']['type'][$k]=="image/png")   ){
                         if($_FILES['inputimage']['type'][$k] < 2048000){
                             if(is_uploaded_file($_FILES['inputimage']['tmp_name'][$k])){
                                  $oldname = explode('.',$_FILES['inputimage']['name'][$k]);
                                  $savename = uniqid().$n++.'.'.$oldname[1];
                                  if(move_uploaded_file($_FILES['inputimage']['tmp_name'][$k],$saveway.$savename)){
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
             }else{
                 echo "<script>alert('选择发布带图片的评价任务，请把需要的图片提供给到买手！否则无法提交成功！');history.back();</script>";
                 exit;
             }
             $db['imgcontent'] = serialize($arr);
         }
         //exit;


         $sellerinfo = $this->user->getInfo($db['sellerid']);
         $dbseller['Money'] = $sellerinfo->Money - $db['iscommission'];
         if($dbseller['Money'] > $sellerinfo->bond){
             $this->user->updata($sellerinfo->id,$dbseller);// 扣钱成功

             $this->load->model('Cash_model','cash');
             $dbcash['type'] = '评价任务佣金';
             $dbcash['remoney'] = $sellerinfo->Money;
             $dbcash['increase'] = '-'.$db['iscommission'];
             $dbcash['beizhu'] = '发布评价任务扣除佣金';
             $dbcash['addtime'] = @strtotime(@date('Y-m-d H:i:s'));
             $dbcash['userid'] = $sellerinfo->id;
             $dbcash['usertaskid'] = $usertaskinfo->id;
             $dbcash['proid'] = $usertaskinfo->proid;
             $dbcash['shopid'] =  $usertaskinfo->shopid;

             $this->cash->add($dbcash);

             if($db['status']==1){
                $usertask['showpicbtn'] = 0;
             }
             $usertask['status'] = 5;
             $this->usertask->updata($usertaskid,$usertask);

            // $this->usertask->updata($usertask->id,$up);


             $re = $this->taskevaluate->add($db);
             if($re){
                 echo "<script>alert('评价任务提交成功！');parent.location.reload();</script>";
             }else{
                 echo "<script>alert('系统现在正在繁忙中，请稍后重试！');history.back();</script>";
             }
         }else{
             echo "<script>alert('账户余额不足，请充值！');</script>";
             $this->taskyes();
         }

         //alert('添加评价任务信息');
     }


    public function seeEvaluatePics(){
        $id = $_GET['key']==''?0:$_GET['key'];
        if($id==0){
            echo "<script>alert('请不要尝试错误链接谢谢！');history.back();</script>";
        }else{
            $info = $this->usertask->getInfo($id);
            if($info != null){
                $up['showpicbtn'] =1;
                $this->usertask->updata($info->id,$up);
                $db['info'] = $this->usertask->getInfo($info->id);
                $db['proinfo'] = $this->task->getInfo($db['info']->taskid);
                $db['evaluateinfo'] = $this->taskevaluate->getInfoT($info->id);
                //var_dump($info->id);
                $this->load->view('GetEvaluatePictures',$db);
            }else{
                echo "<script>alert('您要查看的信息数据不存在了，请重新加载页面后尝试！');history.back();</script>";
            }
        }
    }

    //确认支付信息
    public function saveEvaluateMoney(){
        $id = $_GET['key']==''?0:$_GET['key'];
        if($id==0){
            echo "<script>alert('请不要尝试错误链接谢谢！');history.back();</script>";
        }else{
            $usertask = $this->usertask->getInfo($id);
            if($usertask != null){
                //修改任务表
                $dbtask['status'] = 7;
                $re = $this->usertask->updata($usertask->id,$dbtask);
                if($re){
                    //修改评价任务表
                    $eval = $this->taskevaluate->getInfoT($usertask->id);
                    $dbevaluate['doing'] =2;
                    $this->taskevaluate->updata($eval->id,$dbevaluate);

                    //给刷手加钱
                    $shuashouinfo = $this->user->getInfo($usertask->userid);
                    $dbshuashou['Money'] = $shuashouinfo->Money + $eval->iscommission;
                    $this->user->updata($shuashouinfo->id,$dbshuashou);

                    // 给刷手添加资金记录
                    $this->load->model('Cash_model','cashlog');
                    $dbsl['type'] = '评价佣金';
                    $dbsl['remoney'] = $shuashouinfo->Money+$eval->iscommission;
                    $dbsl['increase'] = '+'.$eval->iscommission;
                    $dbsl['beizhu'] = '完成评价任务获取任务佣金';
                    $dbsl['addtime'] = @strtotime(@date('Y-m-d H:i:s'));
                    $dbsl['userid'] = $eval->doid;
                    $dbsl['usertaskid'] = $eval->sellerid;
                    $dbsl['proid'] = $usertask->proid;
                    $dbsl['shopid'] = $usertask->shopid;
                    $this->cashlog->add($dbsl);


                }else{
                    echo "<script>alert('系统繁忙中，请稍后重试！'); history.back();</script>";
                }
            }else{
                echo "<script>alert('您要查看的数据不存在，请重新加载页面后尝试');history.back();</script>";
            }
        }
    }

	public function countSenvenDay(){
	    $db=$this->_include();
	    $start=@strtotime(@date('Y-m-d'))-1;
	    $end=@strtotime("+7 day")+1;	  
	    $id = $this->session->userdata('sellerid');  
	    $db['list']=$this->task->SevenDay($start,$end,$id);
	   // var_dump($db['list']);
	    $this->load->view('GetDayTaskCount',$db);
	}
	public function taskStepOne(){
	   $proid = @$_POST['proid']==''?0:@$_POST['proid'];
	   $SearchType = @$_POST['SearchType'];// 入口
	   $SearchKey = @$_POST['SearchKey'];// 关键字
	   $KeyWordCount = @$_POST['KeyWordCount'];// 数量
	   $IDdelOrder = @$_POST['order'];// 排序方式
	   $IDdelPrice = @$_POST['price'];// 价格区间
	   $IDdelAddress = @$_POST['address'];// 发货地
	   $IDdelOther = @$_POST['other'];// 其他条件
	  // echo $proid;	  
	   /*   
	  $arrSearchType=implode('&',$SearchType);
	  $arrSearchKey=implode('&',$SearchKey);	  
	  $arrKeyWordCount=implode('&',$KeyWordCount);
	  $arrIDdelOrder=implode('&',$IDdelOrder);
	  $arrIDdelPrice=implode('&',$IDdelPrice);
	  $arrIDdelAddress=implode('&',$IDdelAddress);
	  $arrIDdelOther=implode('&',$IDdelOther); 
	  */
	  setcookie('proid',$proid);
	  setcookie('SearchType',implode('&',$SearchType));
	  setcookie('SearchKey',implode('&',$SearchKey));
	  setcookie('KeyWordCount',implode('&',$KeyWordCount));
	  setcookie('IDorder',implode('&',$IDdelOrder));
	  setcookie('IDprice',implode('&',$IDdelPrice));
	  setcookie('IDaddress',implode('&',$IDdelAddress));
	  setcookie('IDother',implode('&',$IDdelOther));
 
	  if($proid==0){
	      echo "<script>alert('页面数据加载错误！');</script>";
	      $this->index();
	  }else{
	      $db=$this->_include();
	      $db['proinfo']=$this->product->getInfo($proid);
	      $db['searchtype']=$SearchType;
	      $db['KeyWordCount']=$KeyWordCount;
          $db['shops'] = $this->shop->getlist($db['info']->id,1,0,0,0);
	      $start=@strtotime(@date('Y-m-d'))-1;
	      $end=@strtotime("+7 day")+1;	  
	      $db['list']=$this->task->SevenDay($start,$end,$db['info']->id);
	      $value = $this->system->getInfo(90);
	      $db['arr'] =$value->value;
	      $this->load->view('VipTaskTwo',$db);
	  }
	}
/*     public function retaskStepOne(){
        $proid = @$_POST['proid']==''?0:@$_POST['proid'];
        $SearchType = @$_POST['SearchType'];// 入口
        $SearchKey = @$_POST['SearchKey'];// 关键字
        $KeyWordCount = @$_POST['KeyWordCount'];// 数量
        $IDdelOrder = @$_POST['order'];// 排序方式
        $IDdelPrice = @$_POST['price'];// 价格区间
        $IDdelAddress = @$_POST['address'];// 发货地
        $IDdelOther = @$_POST['other'];// 其他条件

        setcookie('proid',$proid);
        setcookie('SearchType',implode('&',$SearchType));
        setcookie('SearchKey',implode('&',$SearchKey));
        setcookie('KeyWordCount',implode('&',$KeyWordCount));
        setcookie('IDorder',implode('&',$IDdelOrder));
        setcookie('IDprice',implode('&',$IDdelPrice));
        setcookie('IDaddress',implode('&',$IDdelAddress));
        setcookie('IDother',implode('&',$IDdelOther));

        if($proid==0){
            echo "<script>alert('页面数据加载错误！');</script>";
            $this->index();
        }else {
            $db=$this->_include();
            $db['proinfo']=$this->product->getInfo($proid);
            $db['searchtype']=$SearchType;
            $db['KeyWordCount']=$KeyWordCount;
            $db['shops'] = $this->shop->getlist($db['info']->id,1,0,0,0);
            $start=strtotime(@date('Y-m-d'))-1;
            $end=strtotime("+7 day")+1;
            $db['list']=$this->task->SevenDay($start,$end,$db['info']->id);

            $value = $this->system->getInfo(90);
            $db['arr'] =$value->value;
           /*  $arr = explode('|', $value->value);
            $money =array();$point=array();
             foreach($arr as $key=>$va){
                 $money[$key] = $vamoney = substr($va, 0,strpos($va,'='));
                 $point[$key] = $vapoint = substr($va, strpos($va,'=')+1);
             }
             sort($money);           
            $this->load->view('reVipTaskTwo', $db);
        }
    } */
  

	public function taskStepTwo(){
	    $db=$this->_include();
	    $proid = @$_POST['proid'];
	    $db['proinfo']=$this->product->getInfo($proid);
	    if(!empty($_COOKIE['SearchType'])){
            $searchtype= $_COOKIE['SearchType'];
            $db['searchtype']=explode('&',$searchtype);
        }else{
            echo "<script>alert('数据出错了，请重新发布任务！');</script>";
            $this->index();
        }
        if(!empty($_COOKIE['KeyWordCount'])){
            $KeyWordCount= $_COOKIE['KeyWordCount'];
            $db['KeyWordCount']=explode('&',$KeyWordCount);
        }else{
            echo "<script>alert('数据出错了，请重新发布任务！');</script>";
            $this->index();
        }
        //基本判断条件
        $IsSingleModel = @$_POST['IsSingleModel']==''?0:@$_POST['IsSingleModel']; // 发布任务是否为不同型号        
        //获取单个产品价格数组
        $SingleProductPrice = @$_POST['SingleProductPrice']==''?0:@$_POST['SingleProductPrice'];
        //获取单个快递费价格数组
        $ExpressCharge = @$_POST['ExpressCharge']==''?0:@$_POST['ExpressCharge'];
        //获取单个产品型号数组
        //echo "<script>alert(".$IsSingleModel.");</script>";;
        if($IsSingleModel==2){ // 如果为多型号产品，读取该数据
            $ProductModel = @$_POST['ProductModel']==''?0:@$_POST['ProductModel'];
            //var_dump($ProductModel);
            setcookie('ProductModel',implode('&',$ProductModel));
        }
        //获取单个产品任务购买产品数量数组
        $BuyProductCount = @$_POST['BuyProductCount']==''?0:@$_POST['BuyProductCount'];
        //获取单个产品任务数量数组
        $ProductPriceListCount = @$_POST['ProductPriceListCount']==''?0:@$_POST['ProductPriceListCount'];
        //获取单模型任务的价格！
        $ProCommission = @$_POST['inputcomm']==''?0:@$_POST['inputcomm'];
        

        /*
         *  添加了多条任务信息的cookie操作
         * */
        if($IsSingleModel!=0){
            setcookie('IsSingleModel',$IsSingleModel);
        }
        if($SingleProductPrice!=0){
            setcookie('SingleProductPrice',implode('&',$SingleProductPrice));
        }
        if($ExpressCharge!=0){
            setcookie('ExpressCharge',implode('&',$ExpressCharge));
	    }
	    if($BuyProductCount!=0){
            setcookie('BuyProductCount',implode('&',$BuyProductCount));
	    }
	    if($ProductPriceListCount!=0){
            setcookie('ProductPriceListCount',implode('&',$ProductPriceListCount));
	    }
	    $thistaskcomm = 0;
	    if($ProCommission!=0){
            setcookie('ProCommission',implode('&',$ProCommission));
            // 当前任务所需佣金
            foreach ($ProCommission as $key=>$procom){
                $thistaskcomm += $procom * $ProductPriceListCount[$key];
            }
	    }else{
	        $ProductPriceListCount = explode('&', $_COOKIE['ProductPriceListCount']);
	        $ProCommission = explode('&', $_COOKIE['ProCommission']);
	        foreach ($ProCommission as $key=>$procom){
	            $thistaskcomm += $procom * $ProductPriceListCount[$key];
	        }
	    }        

        $TaskPlanType = @$_POST['TaskPlanType']==''?-1:@$_POST['TaskPlanType'];//发布任务时间类型
        $StrDate=@strtotime(@date('Y-m-d H:i:s'));
        $TaskDate = @$_POST['Date']==''?0:@$_POST['Date'];//日期

        $TaskDate = @$_POST['Date']==''?0:@$_POST['Date'];//日期
        $TaskPlanBeginTimeH = @$_POST['TaskPlanBeginTimeH'];//开始时间小时
        $TaskPlanBeginTimeM = @$_POST['TaskPlanBeginTimeM'];//开始时间分钟
        $TaskPlanEndTimeH = @$_POST['TaskPlanEndTimeH'];//结束时间小时
        $TaskPlanEndTimeTimeM = @$_POST['TaskPlanEndTimeTimeM'];//结束时间分钟
        $TimeoutTimeH = @$_POST['TimeoutTimeH'];//关闭时间小时
        $TimeoutTimeM = @$_POST['TimeoutTimeM'];//关闭时间分钟
        //echo $_COOKIE['typepage'];
        

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
                $countmoney += ($vml->number- $vml->takenumber -$vml->del)*$vml->commission;
            }
        }
        //单件置顶费用信息
        $counttop =0;
        foreach($tasklist as $vtl){
            if($vtl->number > ($vtl->qrnumber + $vtl->del)){
                $counttop = ($vtl->number - $vtl->qrnumber - $vtl->del) * $vtl->top;
            }
        }
        $countmoney = $countmoney + $counttop;
        
        if($db['info']->Money < ( $countmoney + $thistaskcomm + $db['info']->bond) ){
       // if($db['info']->Money < $db['info']->bond + $thistaskcomm ){
            echo "<script>alert('账户内余额不足以支付所有已发布的任务了！请充值、减少需要发布的任务数量或取消已发布的任务后再发布任务！');</script>";
            $this->index();
        }else{
            if($TaskPlanType == -1){            
                $db['shops'] = $this->shop->getlist($db['info']->id,1,0,0,0);//店铺名称
                if(!empty($_COOKIE['proid'])){
                    $db['proinfo']=$this->product->getInfo($_COOKIE['proid']);
                }else{
                    echo "<script>alert('数据出错了，请重新发布任务！');</script>";
                    $this->index();
                }
                $db['TaskPlanCount'] = explode('&',$_COOKIE['TaskPlanCount']);
                if($TaskDate!=0){
                    $db['StrTaskPlan'] = implode('&',$TaskDate);
                }else{
                    $db['StrTaskPlan'] = $_COOKIE['TaskPlanCount'];
                }
                if(empty($_COOKIE['SearchType'])){
                    $db['SearchType'] = $_COOKIE['SearchType'];
                    $db['searchtype'] = explode('&',$db['SearchType']);
                }else{}

                $db['SearchType'] = $_COOKIE['SearchType'];
                $db['searchtype'] = explode('&',$db['SearchType']);
                $db['KeyWordCount'] = $_COOKIE['KeyWordCount'];
                //var_dump($_COOKIE['starttime']);

                if($SingleProductPrice != 0){
                    $db['SingleProductPrice']=$SingleProductPrice;
                }else{
                    $db['SingleProductPrice']=explode('&', $_COOKIE['SingleProductPrice']);
                }
                if($ExpressCharge != 0){
                    $db['ExpressCharge']=$ExpressCharge;
                }else{
                    $db['ExpressCharge']=explode('&', $_COOKIE['ExpressCharge']);
                }
                if($BuyProductCount != 0){
                    $db['BuyProductCount']=$BuyProductCount;
                }else{
                    $db['BuyProductCount']=explode('&', $_COOKIE['BuyProductCount']);
                }
                if($ProductPriceListCount != 0){
                    $db['ProductPriceListCount']=$ProductPriceListCount;
                }else{
                    $db['ProductPriceListCount']=explode('&', $_COOKIE['ProductPriceListCount']);
                }
                if($TaskDate != 0){
                    $db['TaskDate']=$TaskDate;
                }else{
                    $db['TaskDate']=explode('&', $_COOKIE['TaskDate']);
                }
                if($TaskDate != 0){
                    $db['ProCommission']=$ProCommission;
                }else{
                    $db['ProCommission']=explode('&', $_COOKIE['ProCommission']);
                }

                $db['ProductPriceListCount']=$ProductPriceListCount;

                $db['reload']=1;
                

                $this->load->view('VipTaskThree',$db);

                
            }else{//直接下一步到这里执行代码段            
                if($TaskPlanType==2){        
                    $TaskPlanCount = @$_POST['TaskPlanCount']==''?0:@$_POST['TaskPlanCount'];;// 任务数量  
                   // var_dump($TaskPlanCount);
                    $starttime=array();
                    $endtime=array();
                    $closetime=array();
                    for($n=0;$n<7;$n++){
                        $starttime[$n] = $TaskDate[$n].' '.($TaskPlanBeginTimeH[$n]==''?'00':$TaskPlanBeginTimeH[$n]).':'.($TaskPlanBeginTimeM[$n]==''?'00':$TaskPlanBeginTimeM[$n]).':00';
                        $endtime[$n] = $TaskDate[$n].' '.($TaskPlanEndTimeH[$n]==''?'00':$TaskPlanEndTimeH[$n]).':'.($TaskPlanEndTimeTimeM[$n]==''?'00':$TaskPlanEndTimeTimeM[$n]).':00';
                        $closetime[$n] = $TaskDate[$n].' '.($TimeoutTimeH[$n]==''?'23':$TimeoutTimeH[$n]).':'.($TimeoutTimeM[$n]==''?'59:59':$TimeoutTimeM[$n]);
                    }
                    $Starttime=implode('&',$starttime);
                    $Endtime=implode('&',$endtime);
                    $Closetime=implode('&',$closetime);
                    $StrTaskPlan=implode('&',$closetime);
                    $TaskPlanCount=implode('&',$TaskPlanCount);
                }else{
                    $TaskPlanCount=0;
                    foreach ($ProductPriceListCount as $v){
                        $TaskPlanCount += $v;
                    }
                    $StrTaskPlan=$TaskPlanCount;
                    if($TaskPlanType==0){
                        $Starttime=@date('Y-m-d H:i:s',$StrDate);
                        $Endtime=@date('Y-m-d').' 23:59:59';
                        $Closetime=$TaskDate[0].' '.($TimeoutTimeH[0]==''?'23':$TimeoutTimeH[0]).':'.($TimeoutTimeM[0]==''?'59:59':$TimeoutTimeM[0]);
                    }else{
                        $Starttime=$TaskDate[0].' '.$TaskPlanBeginTimeH[0].':'.$TaskPlanBeginTimeM[0].':00';
                        $Endtime = $TaskDate[0].' '.$TaskPlanEndTimeH[0].':'.$TaskPlanEndTimeTimeM[0].':00';
                        $Closetime = $TaskDate[0].' '.($TimeoutTimeH[0]==''?'23':$TimeoutTimeH[0]).':'.($TimeoutTimeM[0]==''?'59:59':$TimeoutTimeM[0]);
                    }
                }
                setcookie('TaskPlanType',$TaskPlanType);
                setcookie('TaskDate',implode('&',$TaskDate));
                setcookie('TaskPlanCount',$TaskPlanCount);
                setcookie('starttime',$Starttime);
                setcookie('endtime',$Endtime);
                setcookie('closetime',$Closetime);
    
                $db['shops'] = $this->shop->getlist($db['info']->id,1,0,0,0);//店铺名称
                if(!empty($_COOKIE['proid'])){
                    $db['proinfo']=$this->product->getInfo($_COOKIE['proid']);
                }else{
                    echo "<script>alert('数据出错了，请重新发布任务！');</script>";
                    $this->index();
                }
                $db['TaskPlanCount']=explode('&',$TaskPlanCount);
                $db['StrTaskPlan']=implode('&',$TaskDate);
                $db['SearchType']=$_COOKIE['SearchType'];
                $db['searchtype']=explode('&',$db['SearchType']);
                $db['KeyWordCount']=$_COOKIE['KeyWordCount'];
                //var_dump($_COOKIE['starttime']);
                
                $db['SingleProductPrice']=$SingleProductPrice;
                $db['ExpressCharge']=$ExpressCharge;
                $db['BuyProductCount']=$BuyProductCount;
                $db['ProductPriceListCount']=$ProductPriceListCount;
                $db['ProCommission']=$ProCommission;
                $db['TaskDate']=$TaskDate;
    
                $db['reload']=0;
                
                
                $this->load->view('VipTaskThree',$db);
            }
        }
	}
	public function taskStepDB(){
	    $safePWD=$_POST['TradersPassword'];
	    $id = $this->session->userdata('sellerid');
	    $db['info'] = $this->user->getInfo($id);
	    $db['service1'] = $this->system->getInfo(87);
	    $db['service2'] = $this->system->getInfo(88);
	    if(md5($safePWD)==$db['info']->SafePwd){
            $userid=$db['info']->id;
	        $tasktype = $_COOKIE['typepage'];
            if($tasktype==0){
               $tasktype=$this->session->userdata('typepage');
            }
	        
	        //var_dump($dbtask['tasktype']);
	        $proid = $_COOKIE['proid'];
	        
	        $proinfo = $this->product->getInfo($_COOKIE['proid']);
	        $shopid = $proinfo->shopid;// 需要根据proid来获取
	        $intlet = explode('&', $_COOKIE['SearchType']);
	        $keyword = empty($_COOKIE['SearchKey'])?array(''):explode('&', $_COOKIE['SearchKey']);
	        $number = explode('&', $_COOKIE['KeyWordCount']);        
	        $order = explode('&', $_COOKIE['IDorder']);        
	        $price = explode('&', $_COOKIE['IDprice']);
	        $sendaddress = explode('&', $_COOKIE['IDaddress']);
	        $other = explode('&', $_COOKIE['IDother']);

	        $top = $_POST['AddToPoint'];
	        $remark = $_POST['remark'];
	        $addtime = time();
	        $status = $db['info']->ShowStatus;// 任务是否影藏需要根据用户状态获取   0正常（显示）  1 冻结（隐藏）
	        
	        $model = $_COOKIE['IsSingleModel'];
	        $gettime = $_COOKIE['TaskPlanType'];


	        /* 这里存储为总任务表信息*/
	        $dbtask=array();
	        $m=0;
	        $mark=time().$this->generate_password();
	        //echo $mark;
	        foreach ($intlet as $vi){
	           $dbtask[$m]['userid']=$userid;
	           $dbtask[$m]['tasktype']=$tasktype;
	           $dbtask[$m]['proid']=$proid;
	           $dbtask[$m]['shopid']=$shopid;
	           $dbtask[$m]['intlet']=$vi;
	           $dbtask[$m]['keyword']=$keyword[$m];
	           $dbtask[$m]['number']=$number[$m];
	           $dbtask[$m]['order']=$order[$m];
	           $dbtask[$m]['price']=$price[$m];
	           $dbtask[$m]['sendaddress']=$sendaddress[$m];
	           $dbtask[$m]['other']=$other[$m];
	           $dbtask[$m]['top']=$top;
	           $dbtask[$m]['remark']=$remark;
	           $dbtask[$m]['addtime']=$addtime;
	           $dbtask[$m]['status']=$status;
	           $dbtask[$m]['model']=$model;
	           $dbtask[$m]['gettime']=$gettime;
	           $dbtask[$m]['mark']=$mark;
	           $m++;
	        }
	        $this->db->insert_batch('zxjy_task', $dbtask);//这个可以直接添加多行数据


	        /* model 分表*/

	       //echo $model;
	        //echo $_COOKIE['ProductModel'];
            if($model==2){
                $modelname = explode('&', $_COOKIE['ProductModel']);
                //var_dump($modelname);
            }
            $price = explode('&', $_COOKIE['SingleProductPrice']);
            $auction = explode('&', $_COOKIE['BuyProductCount']);
            $express = explode('&', $_COOKIE['ExpressCharge']);
            $number = explode('&', $_COOKIE['ProductPriceListCount']);
            $commission = explode('&', $_COOKIE['ProCommission']);


            $dbtaskmodel=array();
            $n=0;
            foreach($price as $vp){
                $dbtaskmodel[$n]['pid']=$mark;
                if($model==2){
                    $dbtaskmodel[$n]['modelname']=$modelname[$n];
                }
                $dbtaskmodel[$n]['price']=$price[$n];
                $dbtaskmodel[$n]['auction']=$auction[$n];
                $dbtaskmodel[$n]['express']=$express[$n];
                $dbtaskmodel[$n]['number']=$number[$n];
                $dbtaskmodel[$n]['userid']=$id;
                $dbtaskmodel[$n]['commission']=$commission[$n];
                $n++;
            }
            $this->db->insert_batch('zxjy_taskmodel', $dbtaskmodel);
	        
	        
	        /* 时间分表  */
	        $starttime = explode('&', $_COOKIE['starttime']);
	        $endtime = explode('&', $_COOKIE['endtime']);
	        $closetime = explode('&', $_COOKIE['closetime']);
	        $date = explode('&', $_COOKIE['TaskDate']);
	        $number = explode('&', $_COOKIE['TaskPlanCount']);
	        
	        $dbtasktime =array();
	        $t=0;
	        foreach ($number as $key=>$vn){
	            if($vn!=0){
	                $dbtasktime[$t]['pid']=$mark;
	                $dbtasktime[$t]['start']=@strtotime($starttime[$key]);
	                $dbtasktime[$t]['end']=@strtotime($endtime[$key]);
	                $dbtasktime[$t]['close']=@strtotime($closetime[$key]);
	                $dbtasktime[$t]['date']=@strtotime($date[$key]);
	                $dbtasktime[$t]['number']=$number[$key];
	                $dbtasktime[$t]['userid']=$id;	
	                $t++;                
	            }
	        }
	        $this->db->insert_batch('zxjy_tasktime', $dbtasktime);

	        echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=../sales/taskno.html\" >";
	    }else{
	        echo "<script>alert('支付密码错误！');</script>";
	        echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=../sales/taskStepTwo.html\" >";
	    }
    }
	public function evaluation(){
	    $page = @$_GET['page'] ==''?0:@$_GET['page'];	    
	    $id = $this->session->userdata('sellerid');
	    $db['info'] = $this->user->getInfo($id);
	    $db['showcontent'] =1 ;
	    $db['service1'] = $this->system->getInfo(87);
	    $db['service2'] = $this->system->getInfo(88);
	    $db['countall'] = count($this->taskevaluate->WillPass($id));
	    $db['list'] = $this->taskevaluate->getList($id,10,10*$page);
	    $db['count'] = $this->taskevaluate->getcount($id);
	    $db['page'] = 0;
	    $arr=array();$m=0;
        $arrdo=array();
	    foreach($db['list'] as $vdbl){
	        $arrdo[$m]=$vdbl->doid;
	        $arr[$m++] = $vdbl->usertaskid;
	    }
	    if(count($db['list']) != 0){
    	    $db['usertask'] = $this->usertask->getArr($arr);
    	    // 买手信息
    	    $db['wangwangs'] = $this->bindwangwang->getArr($arrdo);
    	    $db['buyers'] = $this->buyer->getArr($arrdo);
    	   // var_dump($db['wangwangs']);
    	    //商品信息
    	    $arrgoods=array();
    	    foreach($db['usertask'] as $key=>$vut){
    	        $arrgoods[$key]=$vut->proid;
    	    }
    	    if(count($arrgoods)!=0){
        	    $db['goods'] = $this->product->getArr($arrgoods);
        	    $arrshop=array();$arrpro=array();$n=0;
        	    if(count($db['usertask'])!=0){
            	    foreach($db['usertask'] as $vdu){
            	        $arrshop[$n] = $vdu->shopid;
            	        $arrpro[$n++] = $vdu->proid;
            	    }
            	    //var_dump($arrpro);
            	    $db['shop'] = $this->shop->getArr($arrshop);
            	    $db['product'] = $this->product->getArr($arrpro);
            	    //var_dump($db['product']);
	                $db['search']=false;
            		$this->load->view('evaluation',$db);
        	    }else{
        	        echo "<script>alert('暂无数据信息');history.back();</script>";
        	    }
    	    }else{
    	        echo "<script>alert('数据丢失！');history.back();</script>";
    	    }
	    }else{
	        echo "<script>alert('暂无数据信息');history.back();</script>";
	    }
	}
	public function evaluationSearch(){
	    $page = @$_GET['page'] ==''?0:@$_GET['page'];
	    $id = $this->session->userdata('sellerid');
	    $db['info'] = $this->user->getInfo($id);
	    $db['showcontent'] =1 ;
	    $db['service1'] = $this->system->getInfo(87);
	    $db['service2'] = $this->system->getInfo(88);
	    $db['countall'] = count($this->taskevaluate->WillPass($id));

	    $db['status']=$status = @$_POST['status'];
	    $db['selSearch']=$selSearch = @$_POST['selSearch'];
	    $db['txtSearch']=$txtSearch = @$_POST['txtSearch'];
	    $BeginDate = @$_POST['BeginDate']==''?0:@strtotime(@$_POST['BeginDate']);
	    $EndDate = @$_POST['EndDate']==''?0:@strtotime(@$_POST['EndDate']);

	   // echo "<script>alert('".$selSearch."');</script>";
	    
	    $db['BeginDate'] = $BeginDate==0?'':$BeginDate;
	    $db['EndDate'] = $EndDate==0?'':$EndDate;
	                                                 //  $doing,$start,$end,$selSearch,$txtSearch,$userid,$limit,$offset
	    $db['list'] = $this->taskevaluate->SearchList($status,$BeginDate,$EndDate,$selSearch,$txtSearch,$id,10,10*$page);
	    $db['count'] = $this->taskevaluate->SearchCount($status,$BeginDate,$EndDate,$selSearch,$txtSearch,$id);
	    
	    
	    $db['page'] = 0;
	    $arr=array();$m=0;
	    $arrdo=array();
	    foreach($db['list'] as $vdbl){
	        $arrdo[$m]=$vdbl->doid;
	        $arr[$m++] = $vdbl->usertaskid;
	    }
	    if(count($db['list']) != 0){
	        $db['usertask'] = $this->usertask->getArr($arr);
	        // 买手信息
	        $db['wangwangs'] = $this->bindwangwang->getArr($arrdo);
	        $db['buyers'] = $this->buyer->getArr($arrdo);
	        // var_dump($db['wangwangs']);
	        //商品信息
	        $arrgoods=array();
	        foreach($db['usertask'] as $key=>$vut){
	            $arrgoods[$key]=$vut->proid;
	        }
	        if(count($arrgoods)!=0){
	            $db['goods'] = $this->product->getArr($arrgoods);
	            $arrshop=array();$arrpro=array();$n=0;
	            if(count($db['usertask'])!=0){
	                foreach($db['usertask'] as $vdu){
	                    $arrshop[$n] = $vdu->shopid;
	                    $arrpro[$n++] = $vdu->proid;
	                }
	                //var_dump($arrpro);
	                $db['shop'] = $this->shop->getArr($arrshop);
	                $db['product'] = $this->product->getArr($arrpro);
	                //var_dump($db['product']);
	                $db['search']=true;
	                $this->load->view('evaluation',$db);
	            }else{
	                echo "<script>alert('暂无数据信息');</script>";
	                echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=../sales/evaluation.html\" >";
	            }
	        }else{
	            echo "<script>alert('数据丢失！');</script>";
	            echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=../sales/evaluation.html\" >";
	        }
	    }else{
	        echo "<script>alert('暂无数据信息');</script>";
	        echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=../sales/evaluation.html\" >";
	    }
	}	
	public function CancelOne(){
	    $key = @$_GET['key']==''?0:@$_GET['key'];
	    if($key==0){
	        echo "<script>alert('请不要尝试错误链接');history.back();</script>";
	    }else{
	        $info = $this->taskevaluate->getInfo($key);
	        if($info!=null){
	            $dbut['status'] = 7;
	            $usertaskinfo = $this->usertask->getInfo($info->usertaskid);
	            $this->usertask->updata($usertaskinfo->id,$dbut);
	            $db['doing'] = 3;
	            $re = $this->taskevaluate->updata($info->id,$db);
	            if($re){
	                echo "<script>alert('任务放弃成功');</script>";
	                echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=../sales/evaluation.html\" >";
	            }else{
	                echo "<script>alert('系统现在正在繁忙中，请稍后重试！');history.back();</script>";
	            }
	        }else{
	            echo "<script>alert('您要查找的数据不见了，请重试尝试！');history.back();</script>";
	        }
	    }
	}
	public function PassAll(){
	    $id = $this->session->userdata('sellerid');
	    $getall = $this->taskevaluate->WillPass($id);
	    $arr= array();
	    $n=0;
	    $arrtask=array();
	    foreach($getall as $vga){
	        $arrtask[$n] = $vga->usertaskid;
	        $arr[$n++] = $vga->id;
	    }
	    $db['doing'] = 2;
	    $this->taskevaluate->updataPass($arr,$db);
	    $dbusertask['status'] = 6;
	    $this->usertask->upDataPass($arrtask,$dbusertask);	    
	}
	public function CreateTaskError(){
	    $key = @$_GET['key']==''?0:@$_GET['key'];
	    if($key==0){
	        echo "<script>alert('请不要尝试错误链接！');history.back();</script>";
	    }else{
	        $usertask = $this->usertask->getInfo($key);
	        if($usertask!=null){
	            $db['classify'] = $this->complaint->getAll();
	            $db['taskinfo'] = $usertask;
	            $this->load->view('CreateTaskError',$db);
	        }else{
	            echo '<script>alert("数据出错了，请刷新页面后重新尝试！");history.back();</script>';
	        }
	    }
	}
	public function CreateTaskErrorDB(){
	    $db['usertaskid'] = $_POST['TaskID'];
	    $db['typeid'] =$_POST['Category1ID'];
	    $db['questionid'] =$_POST['Category2ID'];
	    $usertask = $this->usertask->getInfo($db['usertaskid']);
	    $db['merchantid'] = $usertask->merchantid;
	    $db['buyerid'] = $usertask->userid;
	    
	    $db['tasksn'] = $usertask->tasksn;
	    $db['ordersn'] = $usertask->ordersn;
	    $db['status'] = 0;
	    $db['addtime'] = time();
	    $db['mark'] = time().$this->generate_password();
	    $this->complaint->add($db);
	    $com=$this->complaint->getInfoByMark($db['mark']);
	    
	    $dbusertask['complaint']=1;
	    $this->usertask->updata($usertask->id,$dbusertask);
	    
	    $dbt['schedualid'] = $com->id;
	    $dbt['addtime']=time();
	    $dbt['status'] =0;
	    $dbt['content'] =$_POST['Content'];
	    $dbt['sellerid'] = $usertask->merchantid;
	    
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
	    //var_dump($arr);
	   // if(count($arr) != 0){
           $dbt['contentimg']= serialize($arr);
	    //}
        
        $re = $this->complaint->addTalk($dbt);
        if($re){
            echo "<script>alert('工单信息已经提交到后台。我们的工作人员会尽快处理！');parent.location.reload();</script>";
        }else{
            echo "<script>alert('系统现在繁忙中，请稍后重试！');history.back();</script>";
        }
           
	    
	}
	
	public function SendAll(){
	    $id = $this->session->userdata('sellerid');
	    $list = $this->usertask->getlist($id,1,0,0);
	    $allwaitsend = array();
	    if(count($list) ==0){
	        echo "<script>alert('暂无需要发货的信息');history.back();</script>";
	        exit;
	    }
	    foreach ($list as $key=>$vl){
	        $allwaitsend[$key] = $vl->id; 
	    }	    
        $db['Status'] = 2;
        $this->usertask->upDataPass($allwaitsend,$db);
        
        
	    echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=../sales/taskyes.html\" >";
	}
	public function GiveAll(){
	    $id = $this->session->userdata('sellerid');
	    $list = $this->usertask->getlist($id,3,0,0);
	    $allwaitsend = array();
	    if(count($list) ==0){
	        echo "<script>alert('暂无需要付款信息');history.back();</script>";
	        exit;
	    }
	    foreach ($list as $key=>$info){
	        //$allwaitsend[$key] = $vl->id; 
            $dbusertask['Status'] = 4;                 
            $this->usertask->updata($info->id,$dbusertask);
            
            //刷手获取佣金 +积分
	        $shuashou = $this->user->getInfo($info->userid);
	        $db['Money'] = $shuashou->Money + $info->commission;
	        $db['Score'] = $shuashou->Score + 10;
	        $reuser = $this->user->updata($info->userid,$db);
	        if($reuser){
	            $this->load->model('Cash_model','cashlog');
	            // 现金记录
	            $dbcls['type'] = '任务佣金';
	            $dbcls['remoney'] = $shuashou->Money + $info->commission;
	            $dbcls['increase'] = '+'.$info->commission;
	            $dbcls['beizhu'] = '完成任务获取';
	            $dbcls['addtime'] = @strtotime(@date('Y-m-d H:i:s'));
	            $dbcls['userid'] = $info->userid;
	            $dbcls['usertaskid'] = $info->id;
	            $dbcls['proid'] = $info->proid;
	            $dbcls['shopid'] = $info->shopid;
	            $this->cashlog->add($dbcls);
	             
	            //刷手积分
	            $this->load->model('Score_model','sc');
	            $sc['userid'] = $shuashou->id;
	            $sc['original_score'] = $shuashou->Score;
	            $sc['score_info'] = '+10';
	            $sc['score_now'] = $db['Score'];
	            $sc['description'] = '完成任务获得积分';
	            $sc['add_time'] = @strtotime(@date('Y-m-d H:i:s'));
	            $this->sc->add($sc);
	             
	             
	            
	            //计算刷手获取推广金
	            $this->load->model('System_model','system');
	            if($shuashou->IdNumber != ''){
	                $getcommissionuser = $this->user->getInfo($shuashou->IdNumber);
	                if($getcommissionuser->iscommission=='1' && $getcommissionuser->ispromoter=='1' ){ // 获取佣金
	                    $shuashoutuiguang = $this->system->getInfo(83);// 推广需要添加的费用
	                    $gcum['Money'] = $getcommissionuser->Money + $shuashoutuiguang->value;
	                    $this->user->updata($getcommissionuser->id,$gcum);
	            
	                    $dbcl['type'] = '任务佣金';
	                    $dbcl['remoney'] = $getcommissionuser->Money+$shuashoutuiguang->value;
	                    $dbcl['increase'] = '+'.$shuashoutuiguang->value;
	                    $dbcl['beizhu'] = '推广人员完成任务返现';
	                    $dbcl['addtime'] = @strtotime(@date('Y-m-d H:i:s'));
	                    $dbcl['userid'] = $getcommissionuser->id;
	                    $dbcl['usertaskid'] = $info->id;
	                    $dbcl['proid'] = $info->proid;
	                    $dbcl['shopid'] = $info->shopid;
	                    $this->cashlog->add($dbcl);
	            
	                } //不用返还佣金
	            }// 没有佣金情况
	            
	             
	            
	            //商家推广获取推广金
	            $thisshop = $this->user->getInfo($info->merchantid);//商家信息
	            if($thisshop->parentid != ''){
	                $parentshop = $this->user->getInfo($thisshop->parentid );// 商家上级信息
	                if($parentshop->iscommission=='1' && $parentshop->ispromoter=='1' ){
	                    $shoptuiguangjin = $this->system->getInfo(82);// 推广需要添加的费用
	                    $pcum['Money'] = $parentshop->Money + $shoptuiguangjin->value;
	                    $this->user->updata($parentshop->id,$pcum);
	            
	            
	                    $dbsl['type'] = '任务佣金';
	                    $dbsl['remoney'] = $pcum['Money'];
	                    $dbsl['increase'] = '+'.$shoptuiguangjin->value;
	                    $dbsl['beizhu'] = '推广商家完成发布任务获得';
	                    $dbsl['addtime'] = @strtotime(@date('Y-m-d H:i:s'));
	                    $dbsl['userid'] = $parentshop->id;
	                    $dbsl['usertaskid'] = $info->id;
	                    $dbsl['proid'] = $info->proid;
	                    $dbsl['shopid'] = $info->shopid;
	                    $this->cashlog->add($dbsl);
	                }
	            }
	        }else{
                echo "<script>alert('系统现在正在繁忙中，请稍后再来确认吧！');</script>";
                echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=../sales/taskyes.html\" >";
                exit;
            } 
	    }
        
	    echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=../sales/taskyes.html\" >";	    
	}
	
	function generate_password( $length = 6 ) {
	    // 密码字符集，可任意添加你需要的字符
	    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()-_[]{}<>~+=/?|';
	    $password = '';
	    for ( $i = 0; $i < $length; $i++ )
    	{
    	    // 这里提供两种字符获取方式
    	    // 第一种是使用 substr 截取$chars中的任意一位字符；
    	    // 第二种是取字符数组 $chars 的任意元素
    	    // $password .= substr($chars, mt_rand(0, strlen($chars) – 1), 1);
    	    $password .= $chars[ mt_rand(0, strlen($chars) - 1) ];
    	}
	    return $password;
	}
}
