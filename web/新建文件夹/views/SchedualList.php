<?php require_once('include/header.php')?>   
    <script src="<?=base_url()?>style/md5.js" type="text/javascript"></script>
    <script src="<?=base_url()?>style/jquery.jBox-2.3.min.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>style/jbox.css"> 
    <script src="<?=base_url()?>style/laydate.js" type="text/javascript"></script>
	<link type="text/css" rel="stylesheet" href="<?=base_url()?>style/laydate.css">
	<link type="text/css" rel="stylesheet" href="<?=base_url()?>style/laydate(1).css" id="LayDateSkin">
    <script type="text/javascript">
            
        function GetLink(id) {
            window.location.href="<?=site_url('customer/showdetail')?>"+'?key='+id;
        }       
     
    </script>

<body style="background: #fff;">
    <?php require_once('include/nav.php')?>
    <!--daohang-->
    
    
    <!-- 内容-->
    <div class="sj-fprw">
<form action="<?=site_url('cusomer/say')?>" enctype="multipart/form-data" id="fm" method="post">            
    <div class="menu" style="margin-bottom: 20px;">
                <ul>                    
                    <li class="off" onclick="javascript:window.location.href='<?=site_url('customer')?>'">
                        新客服工单<label id="lblNewTotal"></label></li>
                </ul>
            </div>
            <!-- tab切换-->
            <div class="tab1" id="tab1">
                <input data-val="true" data-val-number="字段 WorkOrderType 必须是一个数字。" id="WorkOrderType" name="WorkOrderType" type="hidden" value="1">
                 <div class="menudiv">
                    <div id="con_one_2">
                        <div class="fpgl-ss">
                            <p>
                               <span id="spOne">工单类型：<select class="select_215" onchange="changechild(this.options[this.selectedIndex].value)" id="Category1ID" name="Category1ID" style="width:150px">
                                <option value="0">请选择</option>
                                <?php foreach($type as $vt):?>
                                    <?php if($vt->pid == 0):?>
                                <option value="<?=$vt->id?>"><?=$vt->typename?></option>
                                    <?php endif;?>
                                <?php endforeach;?>
                                </select>&nbsp;&nbsp;</span> 
                               <span id="spTwo"> 问题分类：
                               <select class="select_215" id="Category2ID" name="Category2ID" style="width:150px">
                               <option value="0">请选择</option>                         
                                <?php foreach($type as $vc):?>
                                    <?php if($vc->pid != 0):?>
                                        <option class="valhide valshow<?=$vc->pid?>" value="<?=$vc->id?>"><?=$vc->typename?></option>
                                    <?php endif;?>
                                <?php endforeach;?>                               
                               </select>&nbsp;&nbsp;</span>
                                任务编号：<input type="text" id="TaskID" name="TaskID" style="width: 150px;" class="input_417">&nbsp;&nbsp;
                                订单编号：<input type="text" id="PlatformOrderNumber" name="PlatformOrderNumber" style="width: 150px;" class="input_417">
                            </p>

                    <script>
                     $(".valhide").hide();
                     function changechild(obj){
                        // alert(obj);
                        $(".valhide").hide();
                        $("#Category2ID").val('0');
                        $(".valshow"+obj).show();
                     }
                    </script>  
                            <p>
                                <input class="input-butto100-ls" style="width: 80px" type="button" onclick="search()" value="查询"></p>
                            <p>
                                <input class="input-butto100-hs" style="width: 80px" type="button" value="刷新" onclick="Refresh()"></p>
                            <span id="lblTime" style="float: right; display: none;">
                                <input class="laydate-icon" id="BeginDate" maxlength="16" name="BeginDate" onclick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm'})" style="width:128px;height:34px;margin-left:5px;" type="text" value="">
                                ~
                                <input class="laydate-icon" id="EndDate" maxlength="16" name="EndDate" onclick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm'})" style="width:128px;height:34px;" type="text" value="">
                                <input type="button" value="确定" id="btnOK" class="button-c" onclick="SearchByTime()">
                            </span>
                        </div>
                        <!-- 搜索-->
                        <!-- 表格-->
                        <div class="fprw-pg">
                            <table>
                                    <tbody><tr align="center">
                                        <th width="232">
                                            <center>
                                                任务编号</center>
                                        </th>
                                        <th width="232">
                                            <center>
                                                订单编号</center>
                                        </th>
                                        <th width="232">
                                            <center>
                                                工单类型
                                            </center>
                                        </th>
                                        <th width="232">
                                            <center>
                                                问题分类
                                            </center>
                                        </th>
                                        <th width="232">
                                            <center>
                                                处罚金额</center>
                                        </th>
                                        <th width="232">
                                            <center>
                                                <select id="orderStatus" name="orderStatus" onchange="GetOrderStatus()" style="height:25px;"><option value="">工单状态</option>
<option value="0">待处理</option>
<option value="1">跟进中</option>
<option value="3">待执行</option>
<option value="2">处理完成</option>
<option value="-2">已撤销</option>
<option value="-1">拒绝处理</option>
</select></center>
                                        </th>
                                        <th width="232">
                                            <center>
                                                <select id="DateType" name="DateType" onchange="ChangeTime()" style="height: 25px;"><option value="">创建时间</option>
<option value="0">今天</option>
<option value="1">昨天</option>
<option value="2">本周</option>
<option value="3">上周</option>
<option value="4">本月</option>
<option value="5">上月</option>
<option value="6">本年</option>
<option value="7">自定义</option>
</select></center>
                                        </th>
                                        <th width="132">
                                            <center>
                                                操作</center>
                                        </th>
                                    </tr>
                                    <?php foreach($list as $vl):?>
                                    <tr>
                                        <td>
                                            <?=$vl->tasksn?>
                                        </td>
                                        <td>
                                            <?=$vl->ordersn?>
                                        </td>
                                        <td>
                                            <?php 
                                            foreach($type as $vt){
                                               if($vt->id == $vl->typeid){
                                                   echo $vt->typename;   
                                               }
                                            }?>
                                        </td>
                                        <td>                                            
                                            <?php 
                                            foreach($type as $vt){
                                               if($vt->id == $vl->questionid){
                                                   echo $vt->typename;   
                                               }
                                            }?>
                                        </td>
                                        <td>
                                            <?=$vl->penaltymoney==''?0:$vl->penaltymoney?>
                                        </td>
                                        <td>
                                        <?php switch ($vl->status){
                                            case 0:echo '待处理';break;
                                            case 1:echo '更进中';break;
                                            case 2:echo '待执行';break;
                                            case 3:echo '处理完成';break;
                                            case 4:echo '已撤销';break;
                                            case 5:echo '拒绝处理';break;
                                            default:echo '出错了';break;
                                        }?>
                                        </td>
                                        <td>
                                            <?=@date('Y-m-d H:i:s',$vl->addtime);?>
                                        </td>
                                        <td height="27">
                                            <p class="fpgl-td-mtop">
                                                    <input onclick="GetLink('<?=$vl->id?>')" class="input-butto100-xls" type="button" value="查看">
                                                    <input onclick="BackLink('<?=$vl->id?>')" class="input-butto100-xls" type="button" value="撤销" style="margin-top:5px;">
                                            </p>
                                        </td>
                                    </tr>
                                    <?php endforeach;?>
                                    
                            </tbody></table>
                        </div>
                        <!-- 表格-->
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
                window.location = url+'/'+(parseInt(pageIndex)-1)+'.html' ;
        }

        /*下一页*/
        function nextPage(url, pageIndex, maxCount) {
            if (pageIndex > maxCount) {
                $.openAlter("没有了", "提示", { height: 210, width: 350 });
                return;
            }
            window.location = url ;
        }

        /*上一页*/
        function prePage(url, pageIndex, maxCount) {
            if (pageIndex <= 0) {
                $.openAlter("没有了", "提示", { height: 210, width: 350 });
                return;
            }
            window.location = url ;
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
            <a href="javascript:" onclick="prePage('<?=site_url('customer/index/'.($page-1))?>','<?=$page?>','<?=ceil($count/10)?>')"></a>
        </p>
        <p style="margin-left: 5px; margin-right: 5px;"><?=$page+1?>/<?=ceil($count/10)?></p>
        <p class="yyzx_3">
            <a href="javascript:" onclick="nextPage('<?=site_url('customer/index/'.($page+1))?>','<?=$page?>','<?=ceil($count/10)-1?>')"></a>
        </p>
        <p style="margin-left: 12px; margin-right: 8px;">
            <input type="text" name="PageIndex" class="input_58" id="PageIndex" value="1" onkeyup="value=value.replace(/[^0-9]/g,'');submitPage(event,'<?=ceil($count/10)?>')" maxlength="9">
        </p>
        <p class="ymfw-right-zgj_7">
            <a href="javascript:" id="paRedirect" onclick="redirectPage('<?=site_url('customer/index')?>','<?=ceil($count/10)?>')">
                跳转</a></p>
    </div>
                    </div>
                </div>
            </div>
            <!-- tab切换-->
</form>    </div>
    <div id="fade" class="black_overlay">
    </div>
    <!-- 内容-->


<script language="javascript" type="text/javascript">

function BackLink(obj){
	 var a=confirm("您确定要撤销工单么？撤销后将不能再次发起该订单工单!");
	 if(a==true){		 
		 location.href="<?=site_url('customer/reback')?>"+'?key='+obj;
	 }
}
                                        
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