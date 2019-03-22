<?php require_once('include/header.php')?>      
    <script src="<?=base_url()?>style/md5.js" type="text/javascript"></script>
    <script src="<?=base_url()?>style/jquery.jBox-2.3.min.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>style/jbox.css">

    <script src="<?=base_url()?>style/laydate.js" type="text/javascript"></script>
    <link type="text/css" rel="stylesheet" href="<?=base_url()?>style/laydate.css">
    <link type="text/css" rel="stylesheet" href="<?=base_url()?>style/laydate(1).css" id="LayDateSkin">
    
    <script type="text/javascript">
        //提示
        function ShowMsg() {
            $.openAlter("买手已经在进行好评，不能再修改好评内容，如有紧急情况请联系平台管理员。", "温馨提示");
        }
        function ShowAddMsg() {
            $.openAlter("买手已经在进行追评，不能再修改追评内容，如有紧急情况请联系平台管理员。", "温馨提示");
        }
        function ShowSetMsg() {
            $.openAlter("买手付款四天后，商家才可以设置好评内容。", "温馨提示");
        }


    </script>

<body style="background: #fff;">
    <?php require_once('include/nav.php')?>  
    <!--daohang-->
    
    
    <!-- 内容-->
    <div class="sj-fprw">
<form action="<?=site_url('sales/evaluationSearch')?>" enctype="multipart/form-data" id="fm" method="post">            <!-- tab切换-->
            <div class="tab1" id="tab1">
                <?php require_once('include/sale_task_menu.php')?> 
                <div class="menudiv">
                    <div id="con_one_2">
                        <div class="fpgl-ss">
                            <p>
                                
                                <select class="select_215" id="status" name="status" style="width:120px;">
                                    <option value="">所有任务</option>
                                    <option value="0">等待评价</option>
                                    <option value="1">商家待审核评价</option>
                                    <option value="2">完成评价</option>
                                    <option value="3">已取消评价</option>
                                </select>
                                <select class="select_215" id="selSearch" name="selSearch" style="width:120px;">
                                    <option value="tasksn">任务编号</option>
                                    <option value="ordersn">订单编号</option>
                                    <option value="shopid">店铺名称</option>
                                    <option value="proid">商品ID</option>
                                </select>
                                <script>
                                $("#status").val("<?=$search?$status:''?>"); 
                                $("#selSearch").val("<?=$search?$selSearch:'tasksn'?>"); 
                                </script>
                            </p>
                            <p>
                                <input class="input_417" id="txtSearch" name="txtSearch" style="width:150px;" type="text" value="<?=$search?$txtSearch:''?>">
                                </p>
                            <p>支付时间:
                                <input class="laydate-icon" id="BeginDate" maxlength="16" name="BeginDate" onclick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm'})" style="width:128px;height:34px;margin-left:5px;" type="text" value="">
                                ~
                                <input class="laydate-icon" id="EndDate" maxlength="16" name="EndDate" onclick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm'})" style="width:128px;height:34px;" type="text" value="">
                            </p>
                            <p><input class="input-butto100-ls" style="width: 85px" type="submit" value="查询"></p>
                            <p><input class="input-butto100-hs" style="width:85px" type="button" value="刷新" onclick="javascript:location.reload();"></p>
                            <?php if($countall >0):?>
                            <p><input class="input-butto100-xxshs" style="width:100px" type="button" onclick="passAll(this)" value="一键审核(<?=$countall?>)" id="btnAuditAll"></p>
                            <?php endif;?>
                        </div>
                        <script>
                        function passAll($this)
                        {
                        	dialog.confirm('确认通过所有任务吗?', '确认通过', '退出', function(){
                        		public.ajax('<?=site_url('sales/PassAll')?>', '', function(datas){
                        			if (datas.status)
                        			{
                        				dialog.success(datas.message);
                        				$($this).val('一键审核');
                        			}
                        			else
                        			{
                        				dialog.error(datas.message);
                        			}
                        		});
                        	});
//                          if(confirm("确认通过所有任务吗？")){
//                              $.openWin(0, 0, '<?=site_url('sales/PassAll')?>');
//                              //$.closeWin();
//                              $.openAlter("支付成功！");
//                              location.reload();
//                          }else{
//                              $.openAlter("取消佣金支付");
//                          }
                        }
                        </script>
                        <!-- 搜索-->
                        <!-- 表格-->
                        <div class="fprw-pg">
                            <table>
                                <tbody><tr align="center">
                                    <th width="250">
                                        <center>任务/订单编号</center>
                                    </th>
                                    <th width="232">
                                        <center>买号/商品信息</center>
                                    </th>
                                    <th width="232">
                                        <center>好评内容</center>
                                    </th>
                                    <th width="232">
                                        <center>图片信息</center>
                                    </th>
                                    <th width="232">
                                        <center>任务状态</center>
                                    </th>
                                    <th width="132">
                                        <center>操作按钮</center>
                                    </th>
                                </tr>
                                <?php foreach($list as $vl):?>
                                        <tr class="info_body">
                                            <td>
                                                <p class="fpgl-td-rw">
                                                    任务编号：<?=$vl->tasksn?> </p>
                                                    <p class="fpgl-td-rw">
                                                        订单编号：<?=$vl->ordersn?></p>
                                            </td>
                                            <td class="fpgl-td-zs">
                                                    <p class="fpgl-td-rw">
                                                        买号：							<?=$vl->wangwang?></p>
                                                    <!--<p class="fpgl-td-rw">
                                                        信誉值：<?=unserialize($vl->account_info)['xy_val']?>
                                                    </p>-->
                                                <p class="fpgl-td-rw">
                                                    店铺名称：<?=$vl->shopname?></p>
                                                <p class="fpgl-td-rw">
                                                    商品简称：<?=$vl -> commodity_abbreviation?>
                                                </p>
                                            </td>
                                            <td class="fpgl-td-zs wenhao_dis" style="word-break: break-all">
                                                <center>
                                                        <b>文字好评</b>
                                                        <br>
                                                        <p class="fpgl-td-rw">
                                                                <label title="<?=$vl->content?>">
                                                                    文字内容：<?=$vl->content?></label>
                                                        </p>
                                                </center>
                                            </td>
                                            <td class="fpgl-td-zs wenhao_dis" style="word-break: break-all">
                                                <center>
                                                        <p style="margin-top: 50px">
                                                            <?php if($vl->status==0):?>
                                                            未设置图片内容
                                                            <?php else:?>
                                                            <?php foreach (unserialize($vl->imgcontent) as $vimg):?>
															<?php $vimg= str_replace ( 'pk1172' , '18zang' , $vimg );  ?>	
                                                            <a href="<?=$vimg?>" target="_blank"><img src="<?=$vimg?>" width="50" height="50"></a>
                                                            <?php endforeach;?>
                                                            <?php endif;?>
                                                            </p>
                                                </center>
                                            </td>
                                            <td class="fpgl-td-zs">
                                                <p class="fpgl-td-rw" style="text-align: center">
                                                    <strong id='state_<?=$vl->id?>'><?php switch ($vl->doing){
                                                        case 0: echo '任务已发布'; break;
                                                        case 1: echo '评价已提交'; break;
                                                        case 2: echo '评价完成'; break;
                                                        case 3: echo '评价任务已放弃'; break;
                                                        default: echo '未知状态'; break;
                                                    }?></strong></p>
                                                <p class="fpgl-td-rw">
                                                    <strong>发布时间:</strong><?=@date('Y-m-d H:i:s',$vl->addtime)?></p>
                                                </td>
                                                <td>
                                                    <?php if($vl->doing == 0):?>
                                                        <p class="fpgl-td-mtop"><input class="input-butto100-xls" type="button" value="取消评价任务"  onclick="CancelEvaluate('<?=$vl->id?>', this)" style="background: red;"></p>
                                                    <?php elseif( $vl->doing == 1):?>
                                                        <p class="fpgl-td-mtop"><input onclick="OKEvaluate('<?=$vl->usertaskid?>', '<?=$vl->id?>', this)" class="input-butto100-xls" type="button" value="确认评价"></p>
                                                    <?php elseif($vl ->doing == 2):?>
                                                    	<p class="fpgl-td-mtop"><input onclick="dialog.showImg('<?=$vl -> postimg?>')" class="input-butto100-xls" type="button" value="查看图片"></p>
                                                	<?php endif;?>
                                                </td>
                                        </tr>
                                    <?php endforeach;?>
                                </tbody>
                            </table>
                        </div>
                        <!-- 表格-->
<script type="text/javascript">
function CancelEvaluate(obj, $this){
	dialog.confirm('确认取消当前评价任务吗？', '确认', '退出', function(){
		public.ajax('<?=site_url('sales/CancelOne')?>', {key: obj}, function(datas){
			if(datas.status)
			{
				dialog.success(datas.message);
				$($this).remove();
				$('strong#state_' + obj).html('评价任务已放弃');
			}
			else
			{
				dialog.error(datas.message);
			}
		});
	});
//  if(confirm("确认取消当前评价任务吗？？？")){
//	     location.href='<?=site_url('sales/CancelOne')?>'+'?key='+obj;
// }  
}
function OKEvaluate(key, obj, $this){
	dialog.confirm('确认支付佣金?', '确认', '退出', function(){
		public.ajax('<?=site_url('sales/saveEvaluateMoney')?>', {key: key}, function(datas){
			if(datas.status)
			{
				dialog.success(datas.message);
				$($this).remove();
				$('strong#state_' + obj).html('评价完成');
			}
			else
			{
				dialog.error(datas.message);
			}
		});
	});
//  if(confirm("确认支付佣金？")){
//      $.openWin(0, 0, '<?=site_url('sales/saveEvaluateMoney')?>' +'?key='+ key);
//      //$.closeWin();
//      $.openAlter("支付成功！");
//      location.reload();
//  }else{
//      $.openAlter("取消佣金支付");
//  }
}

                                                    
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
            	return dialog.error('无更多信息');
                //$.openAlter("没有了", "提示", { height: 210, width: 350 });
            }
            window.location = url + "?page=" + (parseInt(pageIndex) + parseInt(1));
        }
        /*上一页*/
        function prePage(url, pageIndex, maxCount) {
            if (pageIndex <= 0) {
            	return dialog.error('无更多信息');
                //$.openAlter("没有了", "提示", { height: 210, width: 350 });
            }
            window.location = url + "?page=" + (pageIndex - 1);
        }
        function ifPageSize(maxCount) {

            var pageIndex = $("#PageIndex").val();
            if (pageIndex == '' || isNaN(pageIndex) || parseInt(pageIndex) < 1) {
                //$.openAlter("请正确输入页码", "提示", { height: 210, width: 350 });
                return dialog.error('请正确输入页码');
            }
            if (parseInt(pageIndex) > maxCount) {
                //$.openAlter("输入的页码不能大于总页码", "提示", { height: 210, width: 350 });
                return dialog.error('输入的页码不能大于总页码');
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
            <a href="javascript:" onclick="prePage('<?=$search?site_url('sales/evaluationSearch'):site_url('sales/evaluation')?>','<?=$page?>','<?=ceil($count/10)?>')"></a>
        </p>
        <p style="margin-left: 5px; margin-right: 5px;"><?=$page+1?>/<?=ceil($count/10)?></p>
        <p class="yyzx_3">
            <a href="javascript:" onclick="nextPage('<?=$search?site_url('sales/evaluationSearch'):site_url('sales/evaluation')?>','<?=$page?>','<?=ceil($count/10)-1?>')"></a>
        </p>
        <p style="margin-left: 12px; margin-right: 8px;">
            <input type="text" name="PageIndex" class="input_58" id="PageIndex" value="<?=$page + 1?>" onkeyup="value=value.replace(/[^0-9]/g,'');submitPage(event,'<?=ceil($count/10)?>')" maxlength="9">
        </p>
        <p class="ymfw-right-zgj_7">
            <a href="javascript:" id="paRedirect" onclick="redirectPage('<?=$search?site_url('sales/evaluationSearch'):site_url('sales/evaluation')?>','<?=ceil($count/10)?>')">
                跳转</a></p>
    </div>
                    </div>
                </div>
            </div>
            <!-- tab切换-->
</form>    </div>
    <!-- 内容-->

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