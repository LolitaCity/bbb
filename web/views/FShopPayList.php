
   <?php require_once('include/header.php')?> 
    <script src="<?=base_url()?>style/laydate.js" type="text/javascript"></script>
    <link type="text/css" rel="stylesheet" href="<?=base_url()?>style/laydate.css">
    <link type="text/css" rel="stylesheet" href="<?=base_url()?>style/laydate(1).css" id="LayDateSkin">
    
<body style="background: #fff;" class="laydate_body">
    
   <?php require_once('include/nav.php')?> 
    <!--daohang-->
    
    <div class="sj-zjgl">
    
        <div class="zjgl-left">	
            <h2 style="background: url(<?=base_url()?>style/images/hygl.png) no-repeat 22px 22px;">资金管理</h2>
            <ul>
                <li><a href="<?=site_url('capital')?>">账号充值</a> </li>
                <li><a href="<?=site_url('capital/transfer')?>">转账管理</a> </li>
                <li><a href="<?=site_url('capital/fund')?>" >资金管理</a> </li>
                <li><a href="<?=site_url('capital/order')?>" style="background: #eee;color: #ff9900;">订单信息</a> </li>
            </ul>
        </div>
 <script>
 function Search(){
	 $("#fm").submit();
 }
 
 /*
  * 搜索订单信息
  */
 function Export()
 {
 	$post = {
 		statr: $('input#BeginDate').val(),
 		end: $('input#EndDate').val(),
 	};
 	if($post.statr && $post.end)
 	{
 		$msg = '确认导出当前时间端的订单信息吗?';
 	}
 	else
 	{
 		$msg = '确认导出所有的订单信息吗? 选择一个时间段可导出对应信息';

 	}
	 	dialog.confirm($msg, '确认导出', '取消', function(){
	 		public.ajax('<?=site_url('capital/outExcel')?>', $post, function(datas){
	 			if(datas.status)
	 			{
	 				dialog.success(datas.message);
	 				location.href = datas.data;
	 			}
	 			else
	 			{
	 				dialog.error(datas.message);
	 			}
	 		});
	 	});
//   if(confirm("确认导出所有的记录数据吗？？？")){
//       location.href='<?=site_url('capital/outExcel')?>';
//   }
 }
 </script>       
<form action="<?=site_url('capital/searchOrder')?>" id="fm" method="get">        
<div class="zjgl-right">
<style>
    .infobox
    {
        background-color: #fff9d7;
        border: 1px solid #e2c822;
        color: #333333;
        padding: 5px;
        padding-left: 30px;
        font-size: 13px;
        --font-weight: bold;
        margin: 0 auto;
        margin-top: 10px;
        margin-bottom: 10px;
        width: 85%;
        text-align: left;
    }
    .errorbox
    {
        background-color: #ffebe8;
        border: 1px solid #dd3c10;
        margin: 0 auto;
        margin-top: 10px;
        margin-bottom: 10px;
        color: #333333;
        padding: 5px;
        padding-left: 30px;
        font-size: 13px;
        --font-weight: bold;
        width: 85%;
    }
</style>
            <div class="errorbox" id="clientValidation" style="display: none; width: 95%; height: 25px;">
                <ol style="list-style-type: decimal" id="clientValidationOL">
                </ol>
            </div>
            <div class="menu">
                <ul>
                  <a href="javascript:void(0);">
                   <li class="off">销量任务订单详情信息</li></a>
                </ul>
            </div>
            <div style="color: Red;">
                此表格用于记录所有销量任务已支付的订单信息</div>
                <div class="sk-hygl">
                    <div class="fpgl-ss">
                        <p>
                            统计时间：<input class="laydate-icon" id="BeginDate" maxlength="16" name="BeginDate" onclick="laydate({istime: true, format: &#39;YYYY-MM-DD hh:mm:ss&#39;})" style="width:150px;height:34px;margin-left:5px;" type="text" value="<?=$search && !empty($BeginDate)?@date('Y-m-d H:i:s',$BeginDate):'';?>">
                            ~
                            <input class="laydate-icon" id="EndDate" maxlength="16" name="EndDate" onclick="laydate({istime: true, format: &#39;YYYY-MM-DD hh:mm:ss&#39;})" style="width:150px;height:34px;" type="text" value="<?=$search && !empty($EndDate)?@date('Y-m-d H:i:s',$EndDate):'';?>">
                        </p>
                        <p>
                            <input class="input-butto100-ls" type="button" id="btnSearch" value="查询" onclick="Search()"></p>
                        <p>
                            <input class="input-butto100-hs" id="export" type="button" value="导出" onclick="Export()">
                            <input class="input-butto100-hs" type="button" style="display: none;" id="exporting" value="导出中,请稍后..."></p>
                    </div>
                    <div class="zjgl-right_2">
                        <table style="width: 100%;">
                            <tbody><tr>
                                <th>任务号</th>
                                <th>订单编号</th>
                                <th>商品简称</th>
                                <th>商品ID</th>
                                <th>任务类型</th>
                                <th>关键字</th>
                                <th>实际金额</th>
                                <th>任务佣金</th>
                                <th>支付时间</th>
                            </tr>
                                <tr>
                                    <td align="center">
                                        <span style="color: Red;">汇总：</span>
                                    </td>
                                    <td align="center">
                                    </td>
                                    <td align="center">
                                    </td>                                    
                                    <td align="center">
                                    </td>
                                    <td align="center">
                                    </td>
                                    <td align="center">
                                    </td>                                   
                                    <td align="center">
                                        <div style="color: Red; word-break: break-all;">
                                            <?php $totle=0;
                                            foreach($list as $v){
                                                $totle += $v->money;
                                            }
                                            echo $totle;
                                            ?>
                                        </div>
                                    </td>
                                    <td align="center">
                                        <div style="color: Red; word-break: break-all;">
                                            <?php 
                                            	$totletask =0;
                                            	foreach($list as $v)
                                            	{
                                            		$totletask += $v->commission;
                                            	}
//                                           foreach($list as $vl){
//                                               foreach($usertask as $vu){
//                                                   if($vu->id==$vl->usertaskid){
//                                                       foreach($model as $vm){
//                                                           if($vm->id == $vu->taskmodelid){
//                                                               $totletask += $vm->commission;
//                                                           }
//                                                       }
//                                                   }
//                                               }                                                
//                                           }
                                             echo $totletask;
                                             ?>
                                        </div>
                                    </td>
                                    <td align="center">
                                    </td>
                                </tr>
                                <?php foreach($list as $vl):?>
                                    <tr>
                                        <td align="center">
                                            <div style="width: 90px; word-break: break-all;">
                                            <?=$vl->tasksn?>
                                            </div>
                                        </td>
                                        <td align="center">
                                            <div style="width: 70px; word-break: break-all;"><?=$vl->ordersn?></div>
                                        </td>
                                        <td align="center">
                                            <div style="width: 50px; word-break: break-all;"><?=$vl->commodity_abbreviation?></div>
                                        </td>                                       
                                        <td align="center">
                                            <div style="width: 80px; word-break: break-all;"><?=$vl->commodity_id?>
                                            </div>
                                        </td><td align="center">
                                            <div style="width: 80px; word-break: break-all;"><?=$vl->tasktype==1 ? '销量任务' : ($vl->tasktype== 5 ? '预约单' : '预订单')?>
                                            </div>
                                        </td><td align="center">
                                            <div style="width: 80px; word-break: break-all;"><?=$vl->keyword?>
                                            </div>
                                        </td>                                    
                                        <td align="center">
                                            <div style="width: 50px; word-break: break-all;"><?=$vl->money?>
                                            </div>
                                        </td>
                                        <td align="center">
                                            <div style="width: 50px; word-break: break-all;"><?=$vl->commission?>
                                            </div>
                                        </td>
                                        <td align="center">
                                            <div style="width: 70px; word-break: break-all;">
                                            	<?=$vl->updatetime==''?'':@date('Y-m-d H:i:s',$vl->updatetime)?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach;?>                               
                        </tbody>
                        </table>
                    </div>
		<?php require_once('include/page.php')?> 
                </div>
        </div>
</form>
    </div>

<style type="text/css">
        /* online */
        #online_qq_tab a, .onlineMenu h3, .onlineMenu li.tli, .newpage
        {
            background: url(style/images/float_s.gif) no-repeat;
        }
        #onlineService, .onlineMenu, .btmbg
        {
            background: url(style/images/float_bg.gif) no-repeat;
        }
        
        #online_qq_layer
        {
            z-index: 9999;
            position: fixed;
            right: 0px;
            top: 0;
            margin: 150px 0 0 0;
        }
        *html, *html body
        {
            background-image: url(about:blank);
            background-attachment: fixed;
        }
        *html #online_qq_layer
        {
            position: absolute;
            top: expression(eval(document.documentElement.scrollTop));
        }
        
        #online_qq_tab
        {
            width: 28px;
            float: left;
            margin: 403px 0 0 0;
            position: relative;
            z-index: 9;
        }
        #online_qq_tab a
        {
            display: block;
            height: 118px;
            line-height: 999em;
            overflow: hidden;
        }
        #online_qq_tab a#floatShow
        {
            background-position: -30px -374px;
        }
        #online_qq_tab a#floatHide
        {
            background-position: 0 -374px;
        }
        
        #onlineService
        {
            display: inline;
            margin-left: -1px;
            float: left;
            width: 130px;
            background-position: 0 0;
            padding: 10px 0 0 0;
            margin-top:400px
        }
        .onlineMenu
        {
            background-position: -262px 0;
            background-repeat: repeat-y;
            padding: 0 15px;
        }
        .onlineMenu h3
        {
            height: 36px;
            line-height: 999em;
            overflow: hidden;
            border-bottom: solid 1px #ACE5F9;
        }
        .onlineMenu h3.tQQ
        {
            background-position: 0 10px;
        }
        .onlineMenu h3.tele
        {
            background-position: 0 -47px;
        }
        .onlineMenu li
        {
            height: 36px;
            line-height: 36px;
            border-bottom: solid 1px #E6E5E4;
            text-align: center;
        }
        .onlineMenu li.tli
        {
            padding: 0 0 0 28px;
            font-size: 12px;
            text-align: left;
        }
        .onlineMenu li.zixun
        {
            background-position: 0px -131px;
        }
        .onlineMenu li.fufei
        {
            background-position: 0px -190px;
        }
        .onlineMenu li.phone
        {
            background-position: 0px -244px;
        }
        .onlineMenu li a.newpage
        {
            display: block;
            height: 36px;
            line-height: 999em;
            overflow: hidden;
            background-position: 5px -100px;
        }
        .onlineMenu li img
        {
            margin: 8px 0 0 0;
        }
        .onlineMenu li.last
        {
            border: 0;
        }
        
        .wyzx
        {
            padding: 8px 0 0 5px;
            height: 57px;
            overflow: hidden;
            background: url(style/images/webZx_bg.jpg) no-repeat;
        }
        
        .btmbg
        {
            height: 12px;
            overflow: hidden;
            background-position: -131px 0;
        }
    </style>
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