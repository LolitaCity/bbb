<?php require_once('include/header.php')?>     
    <script src="<?=base_url()?>style/md5.js" type="text/javascript"></script>
    <script src="<?=base_url()?>style/jquery.jBox-2.3.min.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>style/jbox.css">

    <script src="<?=base_url()?>style/laydate.js" type="text/javascript"></script>
	<link type="text/css" rel="stylesheet" href="<?=base_url()?>style/laydate.css">
	<link type="text/css" rel="stylesheet" href="<?=base_url()?>style/laydate(1).css" id="LayDateSkin">
    <script type="text/javascript">
        //查看买号信息
        function LookBuyNumberInfo(id) {

            $.openWin(380, 450, '<?=site_url('sales/buyerinfo')?>' +'?buyer='+ id);
        }
        //查看任务截图
        function GetPictures(taskID) {
            $.openWin(580, 1000, '<?=site_url('sales/seepic')?>' +'?key='+ taskID);
            document.getElementById('back'+taskID).style.background = "#666";
            document.getElementById('back'+taskID).value = "已查看";
        }

        function GetEvaluatePictures(taskID){
            $.openWin(580, 1000, '<?=site_url('sales/seeEvaluatePics')?>' +'?key='+ taskID);
            document.getElementById('back'+taskID).style.background = "#666";
            document.getElementById('back'+taskID).value = "已查看";
        }
    </script>

<body style="background: #fff;">
   <?php require_once('include/nav.php')?>  
    <!--daohang-->
    
    
    <!-- 内容-->
    <div class="sj-fprw">
<form action="<?=site_url('sales/searchtask')?>" enctype="multipart/form-data" id="fm" method="post">            <!-- tab切换-->
            <div class="tab1" id="tab1">
                <div class="menu">
                    <ul>
                        <li id="one2" onclick="location.href='<?=site_url('sales')?>'">发布任务</li>
                        <li id="one3" onclick="location.href='<?=site_url('sales/taskno')?>'">未接任务</li>
                        <li id="one1" class="off" onclick="location.href='<?=site_url('sales/taskyes')?>'">已接任务</li>
                        <li id="one0" onclick="location.href='<?=site_url('sales/evaluation')?>'">评价管理</li>
                    </ul>
                </div>
                <div class="menudiv">
                    <div id="con_one_2">
                        <div class="fpgl-ss">
                            <p>                                
                                <select class="select_215" id="taskCategroy" name="taskCategroy" style="width:120px;">
                                    <option value="0">任务分类</option>
                                    <option value="1">销量任务</option>
                                    <option value="2">店铺复购任务</option>
                                </select>
                                <select class="select_215" id="status" name="status" style="width:120px;">
                                    <option value="0">全部任务</option>
                                    <option value="1">进行中</option>
                                    <option value="2">待发货</option>
                                    <option value="6">待评价</option>
                                    <option value="3">待完成</option>
                                    <option value="4">已完成</option>
                                </select>
                                <select class="select_215" id="selSearch" name="selSearch" style="width:120px;">
                                    <option value="tasksn">任务编号</option>
                                    <option value="ordersn">订单编号</option>
                                    <option value="expressnum">运单号</option>
                                    <option value="shopid">店铺名称</option>
                                </select>
                            </p>
                            <p><input class="input_417" id="txtSearch" name="txtSearch" style="width:90px;" type="text" value="<?=$skey=='0'?'':$txtSearch?>"></p>
                            <p>
                                发布时间:
                                <input class="laydate-icon" id="BeginDate" maxlength="16" name="BeginDate" onclick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm:ss'})" style="width:118px;height:34px;margin-left:5px;" type="text" value="<?=$skey=='0'?'':($start==0?'':$start)?>" >
                                ~
                                <input class="laydate-icon" id="EndDate" maxlength="16" name="EndDate" onclick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm:ss'})" style="width:118px;height:34px;" type="text" value="<?=$skey=='0'?'':($end==0?'':$end)?>">
                            </p>
                            <p><input class="input-butto100-ls" style="width: 80px" type="submit" value="查询"></p>
                            <p><input class="input-butto100-hs" style="width:80px" type="button" value="刷新" onclick="location.reload();"></p>
                            <p><input class="input-butto100-hs" style="width:80px" type="button" value="一键发货" onclick="SendAll()"></p>
                            <p></p>
                            <div class="clearfix"></div>
                            <script>
                     	　　    $("#taskCategroy").val("<?=$skey=='all'?'0':$types?>");
                   	　　                $("#status").val("<?=$skey=='all'?'0':$status?>");
     	　　                                                    $("#selSearch").val("<?=$skey=='0'?'0':$selSearch?>");
       	　　                                                	 function SendAll(){
          	　　                                                          if(confirm("确认一键发货所有已提交的订单吗？")){
            	　　                                                        	//alert('1');
              	　　                                                              window.location.href='<?=site_url('sales/SendAll')?>';       
              	　　                                              }
              	　　                              }
       	　　                                                	 function GiveAll(){
        	　　                                                          if(confirm("确认一键支付所有待付款的订单的佣金吗？")){
            	　　                                                              window.location.href='<?=site_url('sales/GiveAll')?>';       
            	　　                                              }
            	　　                              }
                            </script>
                            
                        </div>
                        <!-- 搜索-->
                        <!-- 表格-->
                        <div class="fprw-pg">
                            <table>
                                <tbody>
                                <tr align="center">
                                    <th width="100"><center>任务分类</center></th>
                                    <th width="280"><center>任务/订单编号</center></th>
                                    <th width="220"><center>买号/商品信息</center></th>
                                    <th width="220"><center>商品价格/发布点</center></th>
                                    <th width="232"><center>任务状态</center></th>
                                    <th width="132"><center><input class="input-butto100-hs" style="width:100px" type="button" value="一键支付佣金" onclick="GiveAll()"></center></th>
                                </tr>
                                <?php foreach($list as $vl):?>
                                    <tr>
                                        <td>
                                            <p class="fpgl-td-rw"> <?=$vl->typeinfo==1?'销量任务':'复购任务'?></p>
                                        </td>
                                        <td>
                                            <p class="fpgl-td-rw">任务编号：<?=$vl->tasksn?></p>
                                            <p class="fpgl-td-rw">订单编号：<?=$vl->ordersn?></p>
                                            <?php if($vl->status > 2):?>
                                                <p class="fpgl-td-rw"><?=substr($vl->expressnum,0,strrpos($vl->expressnum,'&'));?> ：<?=str_replace('&','',strstr($vl->expressnum,"&"))?></p>
                                            <?php endif;?>
                                        </td>
                                        <td class="fpgl-td-zs">
                                             <p class="fpgl-td-rw"> 买号：<?php foreach($taskbind as $vtb){ if($vtb->userid == $vl->userid){ echo $vtb->wangwang;} }?></p>
                                             <p class="fpgl-td-rw">
                                                 <strong><a href="javascript:viod(0)" onclick="LookBuyNumberInfo('<?=$vl->buyerid?>')" style="color: #5ca7f5">查看买号信息</a></strong>
                                             </p>
                                            <p class="fpgl-td-rw">
                                                店铺名称：<?php foreach($taskshop as $vts){ if($vts->sid == $vl->shopid){ echo $vts->shopname;}}?></p>
                                            <p class="fpgl-td-rw">
                                                <strong><a href="javascript:viod(0)" onclick="GetTaskDatailInfo('<?=$vl->id?>')" style="color: #5ca7f5">查看任务详情</a></strong>
                                                <strong><a href="javascript:viod(0)" onclick="TaskRemark('<?=$vl->id?>')" style="color: #5ca7f5;padding-left:15px;">备注信息</a></strong>
                                            </p>
                                        </td>
                                        <td class="fpgl-td-zs">
                                            <center>
                                                <p class="fpgl-td-rw"> 商品单价：<?php foreach($taskmodel as $vtm){ if($vtm->id == $vl->taskmodelid){ echo $vtm->price;}}?> 元</p>
                                                <p class="fpgl-td-rw"> 快递费：<?php foreach($taskmodel as $vtm){ if($vtm->id == $vl->taskmodelid){ echo $vtm->express;}}?> 元</p>
                                                <p class="fpgl-td-rw"> 佣金：<?php foreach($taskmodel as $vtm){ if($vtm->id == $vl->taskmodelid){ echo $vtm->commission;}}?> 元</p>
                                            </center>
                                        </td>
                                        <td class="fpgl-td-zs">
                                            <p class="fpgl-td-rw" style="text-align: center">
                                                <strong>
                                                    <?php
                                                        switch ($vl->status){
                                                            case 0:
                                                                echo "<a href='javascript:void(0)' style='color: #5ca7f5'>正在进行</a>"; break;
                                                            case 1:
                                                                echo "<a href='javascript:void(0)' style='color: #5ca7f5'>待发货</a>"; break;
                                                            case 2:
                                                                echo "<a href='javascript:void(0)' tyle='color: #5ca7f5'>待收货</a>"; break;
                                                            case 3:
                                                                echo "<a href='javascript:void(0)' style='color: #5ca7f5'>收货完成</a>"; break;
                                                            case 4:
                                                                echo "<a href='javascript:void(0)' style='color: #5ca7f5'>可添加评价</a>"; break;
                                                            case 5:
                                                                echo "<a href='javascript:void(0)' style='color: #5ca7f5'>待评价</a>"; break;
                                                            case 6:
                                                                echo "<a href='javascript:void(0)' style='color: #5ca7f5'>确认评价</a>"; break;
                                                            case 7:
                                                                echo "<a href='javascript:void(0)' style='color: #5ca7f5'>全部完成</a>"; break;
                                                        }
                                                        ?>
                                                </strong>
                                            </p>
                                            <p class="fpgl-td-rw"><strong>发布时间：</strong><?=@date("Y-m-d H:i",$vl->typeaddtime)?></p>
                                            <p class="fpgl-td-rw"><strong>接手时间：</strong><?=@date('Y-m-d H:i',$vl->addtime)?></p>
                                            <p class="fpgl-td-rw"><a href="javascript:void()" onclick="$.openAlter('','处罚原因')"><span style="color: red"> </span></a></p>
                                        </td>
                                        <td>
                                            <?php if($vl->status==0):?>
                                                <p class="fpgl-td-mtop"><input class="input-butto100-xls" type="button" value="正在进行" readonly="readonly" style=" cursor: text;background: #666;"></p>
                                            <?php elseif($vl->status==1):?>
                                                <p class="fpgl-td-mtop"><input onclick="ShopFaHuo('<?=$vl->id?>')" class="input-butto100-xls" type="button" value="发货"></p>
                                            <?php elseif($vl->status==2):?>
                                                <p class="fpgl-td-mtop"><input class="input-butto100-xls" type="button" value="等待收货" readonly="readonly" style=" cursor: text; background: #666;"></p>
                                            <?php elseif($vl->status==3):?>
                                                <p class="fpgl-td-mtop"><input onclick="InfoOk('<?=$vl->id?>')" class="input-butto100-xls" type="button" value="确认付款"></p>
                                            <?php elseif($vl->status==4):?>
                                                <p class="fpgl-td-mtop"><input onclick="AddEvaluate('<?=$vl->id?>')" class="input-butto100-xls" type="button" value="发布评价任务"></p>
                                            <?php elseif($vl->status==5):?>
                                                <p class="fpgl-td-mtop"><input class="input-butto100-xls" type="button" value="等待评价" style=" cursor: text; background: #666;"></p>
                                            <?php elseif($vl->status==6):?>
                                                <p class="fpgl-td-mtop"><input onclick="OKEvaluate('<?=$vl->id?>')" class="input-butto100-xls" type="button" value="确认评价"></p>
                                            <?php endif;?>
                                            <?php if($vl->status>0):?>
                                                <?php if($vl->status != 4 || $vl->status != 6):?>
                                                    <?php if($vl->status < 4):?>
                                                        <p class="fpgl-td-mtop">
                                                            <input onclick="GetPictures('<?=$vl->id?>')" id="back<?=$vl->id?>" style="<?=$vl->showpicbtn=='1'?'background:#666':''?>" class="input-butto100-zsls" type="button" value="<?=$vl->showpicbtn=='1'?'已查看':'查看截图'?>">
                                                        </p>
                                                    <?php else:?>
                                                        <p class="fpgl-td-mtop">
                                                            <input onclick="GetEvaluatePictures('<?=$vl->id?>')" id="back<?=$vl->id?>" style="<?=$vl->showpicbtn=='1'?'background:#666':''?>" class="input-butto100-zsls" type="button" value="<?=$vl->showpicbtn=='1'?'已查看':'查看截图'?>">
                                                        </p>
                                                    <?php endif;?>
                                                <?php endif;?>
                                            <?php endif;?>
                                            <?php if($vl->complaint==1):?>    
                                                <p class="fpgl-td-mtop"><input class="input-butto100-xls" type="button" value="已提交工单" readonly="readonly" style=" cursor: text; background: #666;"></p>
                                            <?php else:?>
                                                <p class="fpgl-td-mtop"><input onclick="CreateTaskError('<?=$vl->id?>')" class="input-butto100-xhs" type="button" value="客服介入"></p>
                                            <?php endif;?>
                                        </td>
                                    </tr>
                                <?php endforeach;?>
                                </tbody>
                            </table>
                        </div>
<script type="text/javascript">

        /**验证页码*/
        function validationPageIndex(t, maxCount) {
            ifPageSize(maxCount);
        }

        /**跳转到指定页*/
        function redirectPage(url, maxCount) {
            url = url.replace('.html','');
            var pageIndex = $("#PageIndex").val();
            if (ifPageSize(maxCount))
                window.location = url + "?page=" + (pageIndex - 1);
        }

        /*下一页*/
        function nextPage(url, pageIndex, maxCount) {
            if (parseInt(pageIndex) >= parseInt(maxCount)) {
                $.openAlter("没有了", "提示", { height: 210, width: 350 });
                return;
            }
            window.location = url + "?page=" + (parseInt(pageIndex) + parseInt(1));
        }

        /*上一页*/
        function prePage(url, pageIndex, maxCount) {
            if (pageIndex <= 0) {
                $.openAlter("没有了", "提示", { height: 210, width: 350 });
                return;
            }
            window.location = url + "?page=" + (pageIndex - 1);
        }

        function ifPageSize(maxCount) {

            var pageIndex = $("#PageIndex").val();
            if (pageIndex == '' || isNaN(pageIndex) || parseInt(pageIndex) < 1) {
                $.openAlter("请正确输入页码", "提示", { height: 210, width: 350 });
                return false;
            }
            if (parseInt(pageIndex) > maxCount) {
                $.openAlter("输入的页码不能大于总页码", "提示", { height: 210, width: 350 });
                return false;
            }
            return true;
        }

        function submitPage(event, maxCount) {
            var pageIndex = $("#PageIndex").val();
            if (pageIndex == '' || isNaN(pageIndex) || parseInt(pageIndex) < 1) {
                return false;
            }
            if (parseInt(pageIndex) > maxCount) {
                return false;
            }
            var e = event || window.event || arguments.callee.caller.arguments[0];
            if (e && e.keyCode == 13) { // enter 键
                //要做的事情
                $("#paRedirect").click();
            }
        }
    </script>

    <div class="yyzx_1">
        <p class="yyzx_2">
            <a href="javascript:" onclick="prePage('<?=$search?site_url('sales/searchtask'):site_url('sales/taskyes')?>','<?=$page?>','<?=ceil($count/10)?>')"></a>
        </p>
        <p style="margin-left: 5px; margin-right: 5px;"><?=$page+1?>/<?=ceil($count/10)?></p>
        <p class="yyzx_3">
            <a href="javascript:" onclick="nextPage('<?=$search?site_url('sales/searchtask'):site_url('sales/taskyes')?>','<?=$page?>','<?=ceil($count/10)-1?>')"></a>
        </p>
        <p style="margin-left: 12px; margin-right: 8px;">
            <input type="text" name="PageIndex" class="input_58" id="PageIndex" value="1" onkeyup="value=value.replace(/[^0-9]/g,'');submitPage(event,'<?=ceil($count/10)?>')" maxlength="9">
        </p>
        <p class="ymfw-right-zgj_7">
            <a href="javascript:" id="paRedirect" onclick="redirectPage('<?=$search?site_url('sales/searchtask'):site_url('sales/taskyes')?>','<?=ceil($count/10)?>')">
                跳转</a></p>
    </div>
                        <!-- 表格-->
                    </div>
                </div>
            </div>
            <!-- tab切换-->
</form>    </div>
    <!-- 内容-->
   <script>
       function TaskRemark(taskid){
           $.openWin(280, 500, '<?=site_url('sales/remark')?>' +'?key='+ taskid);
       }
       function ShopFaHuo(taskid){
           $.openWin(500, 500, '<?=site_url('sales/sendGoods')?>' +'?key='+ taskid);
       }

       function InfoOk(taskid){
           if(confirm("确认支付佣金？")){
               $.openWin(0, 0, '<?=site_url('sales/sendMoney')?>' +'?key='+ taskid);
               //$.closeWin();
               $.openAlter("支付成功！");

               
               location.reload();

               
           }else{
               $.openAlter("取消佣金支付");
           }
          // $.openWin(500, 500, '<?=site_url('sales/sendMoney')?>' +'?key='+ taskid);
       }
       function OKEvaluate(taskid){
           if(confirm("确认支付佣金？")){
               $.openWin(0, 0, '<?=site_url('sales/saveEvaluateMoney')?>' +'?key='+ taskid);
               //$.closeWin();
               $.openAlter("支付成功！");
               location.reload();
           }else{
               $.openAlter("取消佣金支付");
           }
       }

       function  GetTaskDatailInfo(taskid){
           $.openWin(680, 750, '<?=site_url('sales/taskInfoDetail')?>' +'?key='+ taskid);
       }
       function AddEvaluate(taskid){
           $.openWin(550, 750, '<?=site_url('sales/AddEvaluate')?>' +'?key='+ taskid);
       }
       function CreateTaskError(taskid){
           $.openWin(550, 600, '<?=site_url('sales/CreateTaskError')?>' +'?key='+ taskid);
    	   
       }

   </script>
<script language="javascript" type="text/javascript">
$(function(){
 

if(screen.width<1440)
{  
     var height = document.body.clientHeight;  

         $("#onlineService").css("margin-top", "300px"); 
         $("#online_qq_tab").css("margin-top","300px"); 
    // 拖拉事件计算foot div高度  
    $(window).scroll(function () {  
        var scrollDiff = document.body.scrollTop //  拖拉处的位移  
        $("#onlineService").css("margin-top", "300px"); 
         $("#online_qq_tab").css("margin-top","300px"); // 重计算底部位置  
    });  
}
else if(screen.width == 1024){
         $("#onlineService").css("margin-top", "260px"); 
         $("#online_qq_tab").css("margin-top","260px");

            $(window).scroll(function () {  
        var scrollDiff = document.body.scrollTop //  拖拉处的位移  
        $("#onlineService").css("margin-top", "260px"); 
         $("#online_qq_tab").css("margin-top","260px"); // 重计算底部位置  
    });  
 }
 else
 {
  $("#onlineService").css("margin-top", "420px"); 
         $("#online_qq_tab").css("margin-top","420px"); 
    // 拖拉事件计算foot div高度  
    $(window).scroll(function () {  
        var scrollDiff = document.body.scrollTop //  拖拉处的位移  
        $("#onlineService").css("margin-top", "420px"); 
         $("#online_qq_tab").css("margin-top","420px"); // 重计算底部位置  
    });  
 }
          // 拖拉事件计算foot div高度  
 
});


</script>
<?php require_once('include/footer.php')?>  

</body></html>