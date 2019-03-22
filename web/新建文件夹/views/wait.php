<?php require_once('include/header.php')?>
    
    <link href="<?=base_url()?>style/style.css" rel="stylesheet" type="text/css">
    <script src="<?=base_url()?>style/laydate.js"></script>
	<link type="text/css" rel="stylesheet" href="<?=base_url()?>style/laydate.css">
	<link type="text/css" rel="stylesheet" href="<?=base_url()?>style/laydate(1).css" id="LayDateSkin">
    <link href="<?=base_url()?>style/fabe.css" rel="stylesheet" type="text/css">
    <script src="<?=base_url()?>style/md5.js" type="text/javascript"></script>
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
	$.openWin(500, 530, '<?=site_url('capital/editBank')?>');	
}
function TransferConfirm(){
	 var checks = $("input[name='id']:checkbox:checked");
     if (checks.length > 0) { 
         var strid = '';
         for(i=0;i<checks.length;i++){
        	 strid = strid +  checks.eq(i).attr("id")+',';
         }
         //alert(strid);
         if(confirm("确认为默认账号转账？")){
     	     location.href='<?=site_url('capital/Transfercash')?>'+'?key='+strid;
         }
     }else{
    	 $.openAlter('先选择数据','提示'); 
     }
}
function OutExcel(){
    if(confirm("确认导出等待转账数据？？？")){
	     location.href='<?=site_url('capital/excelout')?>';
   }
}
function AllTransferConfirm(){
    if(confirm("您确认好该账号下的所有信息都转账成功了么？")){
	     location.href='<?=site_url('capital/AllTransfercash')?>';
   }
}
function TransferFail(){
	 var checks = $("input[name='id']:checkbox:checked");
     if (checks.length > 0) { 
         var strid = '';
         for(i=0;i<checks.length;i++){
        	 strid = strid +  checks.eq(i).attr("id")+',';
         }
         if(confirm("确认为转账失败？")){
     	     location.href='<?=site_url('capital/FailTransfercash')?>'+'?key='+strid;
         }
     }else{
    	 $.openAlter('先选择数据','提示'); 
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
<form action="<?=site_url('capital/search')?>" enctype="multipart/form-data" id="fm" method="post">            
        <div class="wrap">
                <div class="navlist cmtab">
                    <span class="cur" onclick="WaitTransfer()">等待转账</span> 
                    <span onclick="TransferResult()">转账结果</span> 
                    <span id="backResult" onclick="BackResult()">未到账反馈</span>
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
                                        <li>1、必须在每天中午<em class="t_red">12：00前</em>完成前一天的所有转账，否则任务将被隐藏；</li>
                                        <li>2、严禁使用支付宝转账，一经发现将终止合作；</li>
                                        <li>3、对于超时未转账的订单，买家有权申请退款；</li>
                                        <li>4、对于多次超时的卖家，平台有权终止合作。</li>
                                        <li>转账操作流程：导出转账信息—进行转账操作—返回平台<b class="t_red" style="font-weight: 900">标记转账失败订单</b>—再<b class="t_red" style="font-weight: 900">标记转账成功订单</b>。</li>
                                   </ul>
                                </div>
                            </div>
                            <div class="Cash_sz">
                                    <?php if($userbank !=null):?>
                                        <div class="p_float">
                                            <span>默认转账银行卡：</span><span><?=$userbank->bankName?> 尾号<em class="t_red"><?=substr($userbank->bankAccount, -4)?></em></span>
                                            <span>开户人：</span><span><?=$userbank->truename?></span> <a href="javascript:void(0);" onclick="EditDefaultBank()" class="b_4882f0 anniu">修改</a>
                                        </div>
                                    <?php else:?>
                                        <div class="p_float">
                                            <a href="javascript:void(0);" onclick="AddDefaultBank()" class="b_4882f0 anniu">绑定银行卡</a>
                                        </div>
                                    <?php endif;?>
                                <div class="Cash_state">
                                    <label>转账状态：</label>
                                    <select class="input_120 right_15" id="TransferStatus" name="TransferStatus">
                                        <option value="-1">请选择</option>
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
                                    <a href="javascript:void(0);" style="width: 110px" class="b_4882f0 anniu" onclick="AllTransferConfirm()">全部转账成功</a> 
                                    <a href="javascript:void(0)" class="f90 anniu" onclick="TransferFail()">转账失败</a> 
                                    <a href="javascript:void(0);" class="f90 anniu" onclick="OutExcel()" id="export">批量导出</a> 
                                </div>
                                <div class="Cash_table ">
                                    <table>
                                        <tbody><tr>
                                            <th width="15px">
                                                <input type="checkbox" name="OrderAll" id="btnCheckAll" value="">
                                            </th>
                                            <th width="130px">订单编号</th>
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
                                                    <tr>
                                                        <td  align="center">
                                                            <span><input type='checkbox' name='id' id="<?=$vl->id;?>"/></span>
                                                        </td>
                                                        <td  align="center">
                                                            <span><?=$vl->ordersn?></span>
                                                        </td>
                                                        <td  align="center">
                                                            <span><?=$vl->money?></span>
                                                        </td>
                                                        <td  align="center">
                                                            <span><?php foreach($banks as $vb){ if($vb->id == $vl->bankid){echo $vb->truename;}}?></span>
                                                        </td>
                                                        <td  align="center">
                                                            <span><?php foreach($banks as $vb){ if($vb->id == $vl->bankid){echo $vb->bankAccount;}}?></span>
                                                        </td>
                                                        <td  align="center">
                                                            <span><?php foreach($banks as $vb){ if($vb->id == $vl->bankid){echo $vb->bankName;}}?></span>
                                                        </td>
                                                        <td  align="center">
                                                            <span><?php foreach($banks as $vb){ if($vb->id == $vl->bankid){echo $vb->subbranch;}}?></span>
                                                        </td>
                                                        <td  align="center">
                                                            <span>
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
                                                            <span>
                                                                <?=@date('Y-m-d H:i:s',@strtotime(@date('Y-m-d',$vl->addtime))+36*60*60)?>
                                                            </span>
                                                        </td>
                                                    </tr>
                                                <?php endforeach;?>
                                            <?php endif;?>
                                    </tbody></table>
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
    <?php if (!$search):?>
    <div class="yyzx_1">
        <p class="yyzx_2">
            <a href="javascript:" onclick="prePage('<?=site_url('capital/wait')?>','<?=$page?>','<?=ceil($count/10)?>')"></a>
        </p>
        <p style="margin-left: 5px; margin-right: 5px;"><?=$page+1?>/<?=ceil($count/10)?></p>
        <p class="yyzx_3">
            <a href="javascript:" onclick="nextPage('<?=site_url('capital/wait')?>','<?=$page?>','<?=ceil($count/10)-1?>')"></a>
        </p>
        <p style="margin-left: 12px; margin-right: 8px;">
            <input type="text" name="PageIndex" class="input_58" id="PageIndex" value="1" onkeyup="value=value.replace(/[^0-9]/g,'');submitPage(event,'<?=ceil($count/10)?>')" maxlength="9">
        </p>
        <p class="ymfw-right-zgj_7">
            <a href="javascript:" id="paRedirect" onclick="redirectPage('<?=site_url('capital/wait')?>','<?=ceil($count/10)?>')">
                跳转</a></p>
    </div>
    <?php endif;?>
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