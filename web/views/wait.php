<?php require_once('include/header.php')?>
    
    <link href="<?=base_url()?>style/style.css" rel="stylesheet" type="text/css">
    <script src="<?=base_url()?>style/laydate.js"></script>
	<link type="text/css" rel="stylesheet" href="<?=base_url()?>style/laydate.css">
	<link type="text/css" rel="stylesheet" href="<?=base_url()?>style/laydate(1).css" id="LayDateSkin">
    <link href="<?=base_url()?>style/fabe.css" rel="stylesheet" type="text/css">
    <script src="<?=base_url()?>style/md5.js" type="text/javascript"></script>
    <style>	
    	.badge {
		    display: inline-block;
		    min-width: 10px;
		    padding: 3px 7px;
		    font-size: 12px;
		    font-weight: 700;
		    line-height: 1;
		    color: #fff;
		    text-align: center;
		    white-space: nowrap;
		    vertical-align: middle;
		    background-color: red;
		    border-radius: 10px;
		}
    </style>
<script>
function WaitTransfer(){
    window.location="<?=site_url('capital/wait');?>"; 
}
function TransferResult(){
    window.location="<?=site_url('capital/result');?>"; 
}    
function BackResult(){
    window.location="<?=site_url('capital/transfer');?>"; 
}
function AddDefaultBank(){
	$.openWin(450, 530, '<?=site_url('capital/addBank')?>');	
}
function EditDefaultBank(){
	dialog.iframe('<?=site_url('capital/editBank')?>', 530, 500, '修改默认转账银行卡');
//	$.openWin(500, 530, '<?=site_url('capital/editBank')?>');	
}
function TransferConfirm()
{
	 var checks = $("input[name='id']:checkbox:checked");
     if (checks.length > 0) { 
         var strid = '';
         for(i=0; i<checks.length; i++)
         {
        	 strid = strid +  checks.eq(i).attr("id")+',';
         }
         dialog.confirm('确认为所选记录转账吗？', '确认', '取消', function(){
         	public.ajax('<?=site_url('capital/Transfercash')?>', {key: strid}, function(datas){
         		if(datas.status)
         		{
         			dialog.success(datas.message);
         			for(i=0; i<checks.length; i++)
			        {
			        	checks.eq(i).parents('tr.info_tr').find('.state_info').html('已转账');
			        }
         		}
         		else
         		{
         			dialog.error(datas.message);
         		}
         	});
         });
         //alert(strid);
//       if(confirm("确认为默认账号转账？")){
//   	     location.href='<?=site_url('capital/Transfercash')?>'+'?key='+strid;
//       }
     }else{
     	 dialog.error('请先选择需要转账的记录');
    	 //$.openAlter('先选择数据','提示'); 
     }
}
function OutExcel()
{
	dialog.confirm('确认导出上述条件的转账数据吗？默认导出等待转账记录', '确认导出', '取消', function(){
		public.ajaxSubmit('fm', function(datas){
			if(datas.status)
			{
				dialog.success(datas.message);
				document.location.href = (datas.data)
			}
			else
			{
				dialog.error(datas.message);
			}
		}, '<?=site_url('capital/excelout')?>');
		//location.href='<?=site_url('capital/excelout')?>';
	});
//  if(confirm("确认导出等待转账数据？？？")){
//	     location.href='<?=site_url('capital/excelout')?>';
// }
}
function AllTransferConfirm(){
	dialog.confirm('您确认为所筛选的转账记录标注为转账成功吗？', '确认', '退出', function(){
		public.ajax('<?=site_url('capital/AllTransfercash')?>', $('#fm').serialize(), function(datas){
			if(datas.status)
			{
				dialog.success(datas.message);
				Search();
				//$('.state_info').html('已转账');
			}
			else
			{
				dialog.error(datas.message);
			}
		});
	});
//  if(confirm("您确认好该账号下的所有信息都转账成功了么？")){
//	     location.href='<?=site_url('capital/AllTransfercash')?>';
// }
}
function TransferFail(){
	 var checks = $("input[name='id']:checkbox:checked");
     if (checks.length > 0) { 
         var strid = '';
         for(i=0;i<checks.length;i++)
         {
        	 strid = strid +  checks.eq(i).attr("id")+',';
         }
         dialog.confirm('确认所选记录均为转账失败吗？', '确认', '退出', function(){
         	public.ajax('<?=site_url('capital/FailTransfercash')?>', {key: strid}, function(datas){
         		if(datas.status)
         		{
         			dialog.success(datas.message);
         			for(i=0; i<checks.length; i++)
			        {
			        	checks.eq(i).parents('tr.info_tr').find('.state_info').html('转账失败');
			        }
         		}
         		else
         		{
         			dialog.error(datas.message);
         		}
         	});
         });
//       if(confirm("确认为转账失败？")){
//   	     location.href='<?=site_url('capital/FailTransfercash')?>'+'?key='+strid;
//       }
     }else{
     	dialog.error('清先选择转账失败的记录');
    	 //$.openAlter('先选择数据','提示'); 
     }
}
function Refresh(){
	location.reload();
}
function Search(){
	$("#fm").submit();
}
</script>
<body style="background: #fff;">
   <?php require_once('include/nav.php')?>
    <!--daohang-->
    
    <div class="sj-zjgl">
        <div class="zjgl-left">
            <h2 style="background: url(<?=base_url()?>style/images/hygl.png) no-repeat 22px 22px;"> 资金管理</h2>
            <ul>
                <li><a href="<?=site_url('capital')?>">账号充值</a></li>
                <li><a href="<?=site_url('capital/wait')?>" style="background: #eee;color: #ff9900;">转账管理</a></li>
                <li><a href="<?=site_url('capital/fund')?>">资金管理</a></li>
                <li><a href="<?=site_url('capital/order')?>">订单信息</a></li>
            </ul>
        </div>
    <div class="zjgl-right">
        <!--常见问题-->
<form action="<?=site_url('capital/search')?>" enctype="multipart/form-data" id="fm" method="get">            
        <div class="wrap">
                <div class="navlist cmtab">
                    <span class="cur" onclick="WaitTransfer()">转账管理</span> 
                    <!--<span onclick="TransferResult()">转账结果</span>--> 
                    <span id="backResult" onclick="BackResult()">未到账反馈<?=$no_account_num > 0 ? '&nbsp;&nbsp;&nbsp;<em class="badge">' . $no_account_num . '</em>' : ''?></span>
                </div>
                <div class="Cgbox cmqh">
                    <!-- 等待转账 -->
                    <div class="Flcont Flcont1" style="display: block">
                        <div class="cmqh">
                            <!--内容区域-->
                            <div class="Cash_bz" style="height:180px;">
                                <div class="Cash_bzfl" style="width:auto; height:auto;">
                                    <h3 class="t_red">关于转账的平台规定：</h3>
                                    <ul>
                                        <li>1、必须在每天中午<em class="t_red">14：00前</em>完成前一天的所有转账，否则任务将被隐藏；</li>
                                        <li>2、严禁使用支付宝转账，一经发现将终止合作；</li>
                                        <li>3、对于超时未转账的订单，买家有权申请退款；</li>
                                        <li>4、对于多次超时的卖家，平台有权终止合作。</li>
                                        <li>转账操作流程：导出转账信息—进行转账操作—返回平台<b class="t_red" style="font-weight: 900">标记</b><b class="t_red" style="font-weight: 900">即可转账成功</b>。</li>
                                   </ul>
                                </div>
                            </div>
                            <div class="Cash_sz">
                                    <?php if($userbank !=null):?>
                                        <div class="p_float">
                                            <span>默认转账银行卡：</span><span id="bankname"><?=$userbank->bankName?> 尾号<em id="tail" class="t_red"><?=substr($userbank->bankAccount, -4)?></em></span>
                                            <span>开户人：</span><span id="truename"><?=$userbank->truename?></span> <a href="javascript:void(0);" onclick="EditDefaultBank()" class="b_4882f0 anniu">修改</a>
                                        </div>
                                    <?php else:?>
                                        <div class="p_float">
                                            <a href="javascript:void(0);" onclick="AddDefaultBank()" class="b_4882f0 anniu">绑定银行卡</a>
                                        </div>
                                    <?php endif;?>
                                <div class="Cash_state">
                                    <label>转账状态：</label>
                                    <select class="input_120 right_15" id="TransferStatus" name="TransferStatus">
                                        <option value="">请选择</option>
                                        <option value="1">等待转账</option>
                                        <option value="2">已转账</option>
                                        <option value="3">转账失败</option>
                                        <option value="4">未到账</option>
                                    </select>
                                    <script>
                                    $("#TransferStatus").val('<?=$search?$TransferStatus:'-1'?>');
                                    </script>
                                    <label> 订单编号：</label>
                                    <input class="input_120 right_15" id="PlatformOrderNumber" name="PlatformOrderNumber" type="text" value="<?=$search?$PlatformOrderNumber:''?>">
                                    <label>转账截止时间：</label>
                                    <input class="fpgl_w120" id="BeginDate2" maxlength="16" name="BeginDate2" onclick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm:ss'})" type="text" value="<?=$search?($BeginDate2==0?'':@date('Y-m-d H:i:s',$BeginDate2)):''?>">
                                    <label>~</label>
                                    <input class="fpgl_w120" id="EndDate2" maxlength="16" name="EndDate2" onclick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm:ss'})" type="text" value="<?=$search?($EndDate2==0?'':@date('Y-m-d H:i:s',$EndDate2)):''?>">
                                    <a href="javascript:void(0);" class="b_4882f0 anniu_70" onclick="Search()">查询</a>
                                    <a href="javascript:void(0);" class="f90 anniu_70" onclick="Refresh()">刷新</a>
                                </div>
                                <div class="p_float" id="dBtnOpt">
                                    <span>操作按钮：</span> 
                                    <a href="javascript:void(0);" class="b_4882f0 anniu" onclick="TransferConfirm()">转账成功</a> 
                                    <a href="javascript:void(0);" style="width: 110px" class="b_4882f0 anniu" onclick="AllTransferConfirm()">按条件标志成功</a>  
                                    <a href="javascript:void(0)" class="f90 anniu" onclick="TransferFail()">转账失败</a> 
                                    <a href="javascript:void(0);" style="width: 120px;" class="f90 anniu" onclick="OutExcel()" id="export">导出当前条件记录</a>
									<div style="padding-top: 3.5px;">
                                    	<label style="margin-left: 15px; color: red;">转账格式：</label>
	                                    <select class="input_120 right_15" id="out_way" name="out_way">
	                                        <option value="1">请选择</option>
	                                        <option value="1">招行</option>
	                                        <option value="2">兴业</option>
	                                    </select>
                                    </div>
                                </div>
                                <div class="Cash_table ">
                                    <table>
                                        <tbody>
                                        	<tr>
                                            <th width="15px">
                                                <input type="checkbox" name="OrderAll" id="btnCheckAll" value="">
                                            </th>
                                            <th width="130px">订单编号</th>
                                            <th width="100px">买号</th>
                                            <th width="60">转账金额</th>
                                            <th width="60px">提现人</th>
                                            <th width="160px">银行卡号</th>
                                            <th width="80px">开户行</th>
                                            <th width="170px">支行名称</th>
                                            <th width="70px"> 转账状态</th>
                                            <th width="150px">转账截止时间</th>
                                        </tr>
                                            <?php if(count($list)==0):?>
                                            <tr>
                                                <td colspan="9" align="center">
                                                    <span style="width: 20px; font-weight: bolder; color: Red; font-size: 16px;">无相关记录</span>
                                                </td>
                                            </tr>
                                            <?php else:?>
                                                <?php foreach($list as $vl):?>
                                                    <tr class="info_tr">
                                                        <td  align="center">
                                                            <span><input type='checkbox' name='id' id="<?=$vl->id;?>"/></span>
                                                        </td>
                                                        <td  align="center">
                                                            <span><?=$vl->ordersn?></span>
                                                        </td>
                                                        <td  align="center">
                                                            <span><?=$vl->wangwang?></span>
                                                        </td>
                                                        <td  align="center">
                                                            <span><?=$vl->money?></span>
                                                        </td>
                                                        <td  align="center">
                                                            <span><?=$vl->truename ? $vl->truename : $vl->TrueName  ?> </span>
                                                        </td>
                                                        <td  align="center">
                                                            <span><?=$vl->bankAccount?></span>
                                                        </td>
                                                        <td  align="center">
                                                            <span><?=$vl->bankName?></span>
                                                        </td>
                                                        <td  align="center">
                                                            <span><?=$vl->subbranch?></span>
                                                        </td>
                                                        <td  align="center">
                                                            <span class="state_info">
                                                                <?php switch ($vl->transferstatus){
                                                                    case 0:echo '等待转账';break;
                                                                    case 1:echo '等待转账';break;
                                                                    case 2:echo '已转账';break;
                                                                    case 3:echo '转账失败';break;
                                                                    case 4:echo '未到账';break;
                                                                    default:echo '数据出错了';break;
                                                                }?>
                                                            </span>
                                                        </td>
                                                        <td  align="center">
                                                            <span title="提现申请时间:<?=date('Y-m-d H:i:s', $vl->addtime)?>">
                                                                <?=@date('Y-m-d H:i:s',@strtotime(@date('Y-m-d',$vl->addtime))+38*60*60)?>
                                                            </span>
                                                        </td>
                                                    </tr>
                                                <?php endforeach;?>
                                            <?php endif;?>
                                    </tbody></table>
                                </div>
								<?php require_once('include/page.php')?> 
                            </div>
                        </div>
                    </div>
                    <!-- 等待转账 -->
<Script>
$("#btnCheckAll").click(function (){
	  var CheckBox = $("input[name='id']");
	 for(i=0;i<CheckBox.length;i++){
         if(CheckBox[i].checked==true){
             CheckBox[i].checked=false;
         }else{
             CheckBox[i].checked=true
         }                    
     }
});

	</Script>                    
                </div>
            </div>

            <!--常见问题-->
</form>    </div>

    </div>

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
<?php require_once('include/header.php')?>


</body></html>