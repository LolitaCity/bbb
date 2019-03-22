
   <?php require_once('include/header.php')?>  
    
    <script src="<?=base_url()?>style/laydate.js" type="text/javascript"></script>
    <link type="text/css" rel="stylesheet" href="<?=base_url()?>style/laydate.css">
    <link type="text/css" rel="stylesheet" href="<?=base_url()?>style/laydate(1).css" id="LayDateSkin">
    <script language="javascript" type="text/javascript">
        $(document).ready(function () {
             $("#ShopPay").addClass("#ShopPay");
            $("#MemberRecord").addClass("a_on");
        })

        function selectTag(id) {
            if (id == "0")
                window.location.href = "GetRecordList";
            else if (id == "1")
                window.location.href = "QueryStatic";
            else if (id == "2")
                window.location.href = "ShopPayList";
            else if (id == "3")
                window.location.href = "BrushPayList";
        }

		/*
		 * 查看备注
		 */
        function GetRemark($ID, $content) 
        {
        	layer.open({
			  type: 1,
			  shade: false,
			  area: '300px',
			  title: false,
			  content: '<div style="padding: 10%"><h3>消费ID：' + $ID + '</h3><h3>备注信息：' + $content + '</h3></div>',
			});
            //$.openWin(250, 380, '<?=site_url('capital/show')?>'+'?id=' + id);
        }
        function Search() {
            $("#fm").submit();
        }
        
        /*
         * 申请提出保证金
         */
        function showinfo()
        {
        	dialog.iframe('<?=site_url('capital/outall')?>', 500, 380, '申请取出保证金');
        	//$.openWin(400, 500, '<?=site_url('capital/outall')?>');
        }
		/*
         * 部分提现（保留保证金）
         */
        function showinfopart()
        {
            dialog.iframe('<?=site_url('capital/outpart')?>', 500, 380, '申请取出部分金额');
            //$.openWin(400, 500, '<?=site_url('capital/outpart')?>');
        }
        function ToExcel()
        {
        	$post = {
        		begin: $('input#BeginDate').val(),
        		end: $('input#EndDate').val(),
        	};
        	if($post.begin && $post.end)
        	{
        		$msg = '确认当初该时间段内的数据吗?';
        	}
        	else
        	{
        		$msg = '确认导出最近35天的数据吗?';
        	}
        	dialog.confirm($msg, '确认导出', '取消', function(){
        		public.ajax('<?=site_url('capital/DetailedExcel')?>', $post, function(datas){
        			if(datas.status)
					{
						dialog.success(datas.message);
						document.location.href = (datas.data)
					}
					else
					{
						dialog.error(datas.message);
					}
        		});
        	})
//          if(confirm("确认导出最近35天的数据吗？？？")){
//        	     location.href='<?=site_url('capital/DetailedExcel')?>';
//           }        	
        }
    </script>

<body style="background: #fff;">    
   <?php require_once('include/nav.php')?>  
    <!--daohang-->
    <div class="sj-zjgl">
        <div class="zjgl-left">
            <h2 style="background: url(<?=base_url()?>/images/hygl.png) no-repeat 22px 22px;">资金管理</h2>
            <ul>
                <li><a href="<?=site_url('capital')?>">账号充值</a> </li>
                <li><a href="<?=site_url('capital/wait')?>" >转账管理</a> </li>
                <li><a href="<?=site_url('capital/fund')?>" style="background: #eee;color: #ff9900;">资金管理</a> </li>
                <li><a href="<?=site_url('capital/order')?>">订单信息</a> </li>
            </ul>
        </div>
        
<form action="<?=site_url('capital/searchinfo');?>" id="fm" method="get">        
        <div class="zjgl-right">
            <div class="errorbox" id="clientValidation" style="display: none; width: 95%; height: 25px;">
                <ol style="list-style-type: decimal" id="clientValidationOL">
                </ol>
            </div>            
        <?PHP if($outcashfull){ ?>
				<div style=" margin-bottom:10px;">
								 		<sqan style="color:red">尊敬的会员，你的全额提现清单：<br>提现到银行卡：<?PHP echo $outcashfull['bankaccount'];?>，<BR>被提现的总金额为：<?PHP echo $outcashfull['money'];?>，<BR>提现进度：<?PHP echo $outcashfull['status'];?>,<BR>提交时间：<?PHP echo  date('Y-m-d',$outcashfull['addtime'])?></sqan>
				</div>
				<?PHP }else{?>
				 <div style=" margin-bottom:10px;">
				 		账户余额：<span style=" padding:0 10px; color:red;"><?=$info->Money?></span>元
				 		<?php if($cash_deposit ->value > 0 && $info->alloutcash==1):?>
				 			<span style=" padding:0 10px; color:blue;">其中有<strong style=" padding:0 10px; color:forestgreen;"><?=$info->bond?></strong>元为账户保证金（若账户中金额少于保证金的话将无法发布任务）</span><br>
				 			<!--完成已发布任务所需佣金:<span style="padding:0 10px; color:red"><?=$need?></span>元--><br>
				 			<a href="javascript:void(0)" onclick="showinfo()" class="getallbtn">申请提现账户保证金与账户余额</a>
				 		<?php else:?>
				 			<a href="javascript:void(0)" onclick="showinfopart()" class="getallbtn">申请提现账户余额</a>
				 		<?php endif;?>
				 	<style>
				 		.getallbtn{ background:#4782EF; color:#FFF; padding:10px 15px; display: inline-block}
				 		.getallbtn:hover{ color:#ff9900;}
				 		</style>
				 </div>
		<?PHP }?>
            <div class="menu">
                <ul>
                    <li class="off">收支流水明细</li>
                </ul>
            </div>
            <div class="sk-hygl">
                <div class="fpgl-ss">
                    <p>
                        统计时间：<input class="laydate-icon" id="BeginDate" maxlength="16" name="BeginDate" onclick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm'})" style="width:150px;height:34px;margin-left:5px;" type="text" value="<?=!empty($begintime)?@date('Y-m-d H:i:s',$begintime):'';?>">
                        ~
                        <input class="laydate-icon" id="EndDate" maxlength="16" name="EndDate" onclick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm'})" style="width:150px;height:34px;" type="text" value="<?=!empty($endtime)?@date('Y-m-d H:i:s',$endtime):'';?>">
                    </p>
                    </select> <select class="select_215" id="type" name="type" style="width: 120px; float: left; margin-right: 1%;">
						<option value="">请选择流水类型</option>
						<option value="取消评价任务">取消评价任务</option>
						<option value="后台充值">后台充值</option>
						<option value="工单处罚">工单处罚</option>
						<option value="平台佣金">平台佣金</option>
						<option value="提现">提现</option>
						<option value="提现驳回">提现驳回</option>
						<option value="撤消或充减">撤消或充减</option>
						<option value="用户转账">用户转账</option>
						<option value="申请提现">申请提现</option>
						<option value="评价任务佣金">评价任务佣金</option>
						<option value="返还佣金">返还佣金</option>
						<option value="返还评价佣金">返还评价佣金</option>
						<option value="置顶费">置顶费</option>
					</select>
                    <p id="loading2">
                        <input class="input-butto100-ls" type="button" id="btnSearch" value="查询" onclick="Search()" style="width: 60px;"></p>
                    <p>
                        <input class="input-butto100-hs" id="export" type="button" value="导出" onclick="ToExcel()" style="width: 60px;">
               </div>
                <div class="zjgl-right_2">
                    <table style="width: 100%;">
                        <tbody>
                        <tr>
                            <th>消费ID</th>
                            <th>类型</th>
                            <th>消费存款</th>
                            <th>剩余存款</th>
                            <th>备注</th>
                            <th>消费时间</th>
                        </tr>
                        <?php if(count($list)==0):?>
                            <tr>
                                <td colspan="7" align="center"> 暂无数据</td>
                            </tr>
                        <?php else:?>
                            <?php foreach($list as $vl):?>
                                <tr>
                                    <td align="center">
                                        <div style="word-break: break-all;"><?=$vl->shopname?></div>
                                    </td>
                                    <td align="center">
                                        <span style="color: Red"><?=$vl->type?></span>
                                    </td>
                                    <td align="center">
                                        <div style="width: 60px; word-break: break-all;"><?=$vl->increase?></div>
                                    </td>
                                    <td align="center">
                                        <div style="width: 70px; word-break: break-all;"><?=$vl->remoney?></div>
                                    </td>
                                    <td align="center">
                                        <p><input class="button-c" type="button" value="查看备注" onclick="GetRemark('<?=$vl->shopname?>', '<?=$vl->beizhu?>')"></p>
                                    </td>
                                    <td align="center">
                                        <div style="width: 70px; word-break: break-all;"><?=@date('Y-m-d H:i:s',$vl->addtime)?></div>
                                    </td>
                                </tr> 
                            <?php endforeach; ?>  
                        <?php endif;?>                         
                        </tbody>
                    </table>
                </div>
      <?php require_once('include/page.php')?>  
            </div>
        </div>
</form>
    </div>

<script language="javascript" type="text/javascript">
$(function(){
$('#type').val("<?=$_GET['type']?>");

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