   <?php require_once('include/header.php')?>      
</head>
    
    <link href="<?=base_url()?>style/style.css" rel="stylesheet" type="text/css">
    <script src="<?=base_url()?>style/laydate.js"></script>
    <link type="text/css" rel="stylesheet" href="<?=base_url()?>style/laydate.css">
    <link type="text/css" rel="stylesheet" href="<?=base_url()?>style/laydate(1).css" id="LayDateSkin">
    <link href="<?=base_url()?>style/fabe.css" rel="stylesheet" type="text/css">
    <script type="text/javascript">
        
    function Search() {
        $("#fm").submit();
    }



    function WaitTransfer(){
            window.location="<?=site_url('capital/wait');?>"; 
        }
    function TransferResult(){
        window.location="<?=site_url('capital/result');?>"; 
    }    
    function BackResult(){
        window.location="<?=site_url('capital/transfer');?>"; 
    }
    
    </script>


<body style="background: #fff;">
     <?php require_once('include/nav.php')?>     
    <!--daohang-->
    
    <div class="sj-zjgl">
        <div class="zjgl-left">
            <h2 style="background: url(<?=base_url()?>style/images/hygl.png) no-repeat 22px 22px;">资金管理</h2>
            <ul>
                <li><a href="<?=site_url('capital')?>">账号充值</a> </li>
                <li><a href="<?=site_url('capital/wait')?>" style="background: #eee;color: #ff9900;">转账管理</a> </li>
                <li><a href="<?=site_url('capital/fund')?>">资金管理</a> </li>
                <li><a href="<?=site_url('capital/order')?>">订单信息</a> </li>
            </ul>
        </div>
        
    <div class="zjgl-right">
<form action="<?=site_url('capital/seacrhNo')?>" enctype="multipart/form-data" id="fm" method="post">           
             <div class="wrap">
                <div class="navlist cmtab">
                    <span onclick="WaitTransfer()">等待转账</span> 
                    <span onclick="TransferResult()">转账结果</span>
                    <span id="backResult" class="cur" onclick="BackResult()">未到账反馈</span>
                </div>
                <div class="Cgbox cmqh">
                    <!-- 未到账反馈 -->
                    <div class="Flcont Flcont3">
                        <div class="cmqh">
                            <!--内容区域-->
                            <div class="h_35" style="height: 150px; font-size: 14px;">
                                <ul>
                                    <li>下方表格记录的是买家提交的提现未到账反馈，请复制订单编号到网银核实该笔订单的转账情况：</li>
                                    <li>1、若经核实，该笔订单显示为“转账成功”，请在上传凭证窗口<em class="t_red">提交</em>该笔订单的<em class="t_red">成功转账凭证</em>;</li>
                                    <li>2、若经核实，实际上<em class="t_red">未对该订单进行转账</em>，请在上传凭证窗口点击<em class="t_red">【转账失败】</em>按钮，将该笔订单的状态变更为转账失败；</li>
                                    <li><span class="t_red">温馨提示：</span>请务必在<em class="t_red">每日中午12点前</em>对需要上传凭证的订单进行操作，否则<em class="t_red">任务将被隐藏</em>。</li>
                                </ul>
                            </div>
                            <div class="Cash_state">
                                <label>订单编号：</label>
                                <input class="input_140 right_15" id="PlatformOrderNumber" name="PlatformOrderNumber" type="text" value="<?=$search?$ordersn:''?>">
                                <label> 转账截止时间：</label>
                                <input class="fpgl_w120" id="BeginDate2" maxlength="16" name="BeginDate2" onclick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm'})" type="text" value="<?=$search?$start:''?>">
                                <label>~</label>
                                <input class="fpgl_w120" id="EndDate2" maxlength="16" name="EndDate2" onclick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm'})" type="text" value="<?=$search?$end:''?>">
                                <a href="javascript:void(0)" class="b_4882f0 anniu_70" onclick="Search()">查询</a>
                                <a href="javascript:void(0)" class="f90 anniu_70" onclick="location.reload()">刷新</a>
                            </div>
                            <div class="Cash_table">
                                <table>
                                    <tbody><tr>
                                        <th width="150px">订单编号</th>
                                        <th width="68px">转账金额</th>
                                        <th width="60px">提现人</th>
                                        <th width="170px">银行卡号</th>
                                        <th width="80px">开户行</th>
                                        <th width="170px">支行名称</th>
                                        <th width="80px">转账状态</th>
                                        <th width="100px">转账截止时间</th>
                                        <th width="80px">操作按钮</th>
                                    </tr>
                                    <?php if(count($list)==0):?>
                                        <tr>
                                            <td colspan="9" align="center">
                                                <span style="width: 20px; font-weight: bolder; color: Red; font-size: 16px;">无相关记录</span>
                                            </td>
                                        </tr>
                                    <?php else:?>
                                        <tr>
                                            <?php foreach($list as $vl):?>
                                            <td><?=$vl->ordersn?></td>
                                            <td><?=$vl->money?></td>
                                            <td><?=$vl->truename?></td>
                                            <td><?php foreach($bankID as $vbi){ if($vbi->id==$vl->bankid)echo $vbi->bankAccount;}?></td>
                                            <td><?php foreach($bankID as $vbi){ if($vbi->id==$vl->bankid)echo $vbi->bankName;}?></td>
                                            <td><?php foreach($bankID as $vbi){ if($vbi->id==$vl->bankid)echo $vbi->subbranch;}?></td>
                                            <td><?php switch ($vl->transferstatus){
                                                case 0:echo '等待转账'; break;
                                                case 1:echo '申请转账'; break;
                                                case 2:echo '已转账'; break;
                                                case 3:echo '转账失败'; break;
                                                case 4:echo '未到账'; break;
                                                default:echo '数据出错';break;
                                            }?></td>
                                            <td><?=@date('Y-m-d H:i:s',@strtotime(@date('Y-m-d',$vl->addtime))+36*60*60)?></td>
                                            <td>
                                                  <p class="fpgl-td-mtop"><input class="input-butto100-xls" type="button" value="提交凭证" style=" cursor: text; " onclick="Update(<?=$vl->id?>)"></p>
                                                  <p class="fpgl-td-mtop"><input class="input-butto100-xhs" type="button" value="转账失败" style=" cursor: text; " onclick="Failthis(<?=$vl->id?>)"></p>
                                           </td>
                                            <?php endforeach;?>
                                        </tr>
                                    <?php endif;?>
                                </tbody></table>
                            </div>
                            <!--内容区域-->
                               <script type="text/javascript">

        /**验证页码*/
        function validationPageIndex(t, maxCount) {
            ifPageSize(maxCount);
        }

        /**跳转到指定页*/
        function redirectPage(url, maxCount) {
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
    <?php if(!$search):?>
    <div class="yyzx_1">
        <p class="yyzx_2">
            <a href="javascript:" onclick="prePage('<?=site_url('capital/transfer')?>','<?=$page?>','<?=ceil($count/10)?>')"></a>
        </p>
        <p style="margin-left: 5px; margin-right: 5px;"><?=$page+1?>/<?=ceil($count/10)?></p>
        <p class="yyzx_3">
            <a href="javascript:" onclick="nextPage('<?=site_url('capital/transfer')?>','<?=$page?>','<?=ceil($count/10)-1?>')"></a>
        </p>
        <p style="margin-left: 12px; margin-right: 8px;">
            <input type="text" name="PageIndex" class="input_58" id="PageIndex" value="1" onkeyup="value=value.replace(/[^0-9]/g,'');submitPage(event,'<?=ceil($count/10)?>')" maxlength="9">
        </p>
        <p class="ymfw-right-zgj_7">
            <a href="javascript:" id="paRedirect" onclick="redirectPage('<?=site_url('capital/transfer')?>','<?=ceil($count/10)?>')">
                跳转</a></p>
    </div>
    <?php endif;?>
                        </div>
                    </div>
                    <!-- 未到账反馈 -->
                </div>
            </div>
</form>    </div>
<script>
function Update(lineid){
	$.openWin(500, 500, '<?=site_url('capital/upDataInfo')?>' +'?key='+ lineid);
}
function Failthis(lineid){
	if(confirm("确定修改成转账失败？？？")){
		  location.href='<?=site_url('capital/FailInfo')?>' +'?key='+ lineid;	
	}
}
</script>
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
   <?php require_once('include/footer.php')?>  


</body></html>