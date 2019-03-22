
   <?php require_once('include/header.php')?> 
    
    
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
    function ToExcel(){
        if(confirm("导出所有转账订单？？")){
            window.location.href='<?=site_url('capital/OutExcelAll')?>';       
        }
    }
    </script>


<body style="background: #fff;">
      <?php require_once('include/nav.php')?> 
    <!--daohang-->
    
    <div class="sj-zjgl">
        <div class="zjgl-left">
            <h2 style="background: url(<?=base_url()?>style/images/hygl.png) no-repeat 22px 22px;">
                资金管理</h2>
            <ul>
                <li><a href="<?=site_url('capital')?>">账号充值</a> </li>
                <li><a href="<?=site_url('capital/wait')?>" style="background: #eee;color: #ff9900;">转账管理</a> </li>
                <li><a href="<?=site_url('capital/fund')?>">资金管理</a> </li>
                <li><a href="<?=site_url('capital/order')?>">订单信息</a> </li>
            </ul>
        </div>
        
    <div class="zjgl-right">
<form action="<?=site_url('capital/searchResult')?>" enctype="multipart/form-data" id="fm" method="post">            
        <div class="wrap">
                <div class="navlist cmtab">
                    <span onclick="WaitTransfer()">等待转账</span> 
                    <span class="cur" onclick="TransferResult()">转账结果</span> 
                    <span id="backResult" onclick="BackResult()">未到账反馈</span>
                </div>
                <div class="Cgbox cmqh">
                    <!-- 转账结果页面 -->
                    <div class="Flcont Flcont1">
                        <div class="cmqh">
                            <!--内容区域-->
                            <div class="Cash_state">
                                <label>订单编号：</label>
                                <input class="input_140 right_5" id="PlatformOrderNumber" name="PlatformOrderNumber" type="text" value="<?=$search?$ordersn:''?>">
                                <label> 转账状态：</label>
                                    <select class="input_100 right_5" id="TransferStatus" name="TransferStatus" style="background:#fff">
                                        <option value="0">请选择</option>
                                        <option value="2">转账成功</option>
                                        <option value="3">转账失败</option>
                                        <option value="4">未到账</option>
                                    </select>
                                    <script>
                                    $("#TransferStatus").val('<?=$search?$TransferStatus:'0'?>');
                                    </script>
                                <label> 转账时间：</label>
                                <input class="fpgl_1" id="BeginDate2" maxlength="16" name="BeginDate2" onclick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm'})" type="text" value="<?=$search?$start:''?>">
                                <label>~</label>
                                <input class="fpgl_1" id="EndDate2" maxlength="16" name="EndDate2" onclick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm'})" type="text" value="<?=$search?$end:''?>">
                                <a href="javascript:void(0)" class="b_4882f0 anniu_60" onclick="Search()">查询</a>
                                <a href="javascript:void(0)" class="f90 anniu_60" onclick="location.reload()">刷新</a> 
                                <a href="javascript:void(0)" class="b_52cc89 anniu_60" onclick="ToExcel()" id="export">导出</a> 
                                <a href="javascript:void(0);" class="b_52cc89 anniu_60" onclick="" id="exporting" style="display: none;">导出中..</a>
                            </div>
                            <div class="Cash_table">
                                <table>
                                    <tbody><tr>
                                        <th width="150px">
                                            订单编号
                                        </th>
                                        <th width="124px">
                                            转账金额
                                        </th>
                                        <th width="150px">
                                            转账人银行卡
                                        </th>
                                        <th width="150px">
                                            提现人银行卡
                                        </th>
                                        <th width="130px">
                                            提现人姓名
                                        </th>
                                        <th width="100px">
                                            转账状态
                                        </th>
                                        <th width="170px">
                                            转账时间
                                        </th>
                                    </tr>
                                        <?php if(count($list)==0):?>
                                            <tr>
                                                <td colspan="7" align="center">暂无数据  </td>
                                            </tr>
                                        <?php else:?>
                                            <?php foreach($list as $vls):?>
                                                 <tr>
                                                    <td><?=$vls->ordersn?></td>
                                                    <td><em class="t_red"><?=$vls->money?></em></td>
                                                    <td><?php foreach ($shopbank as $vsb){if($vsb->userid ==$vls->merchantid ){echo $vsb->bankName;}}?> 尾号<span><?php foreach ($shopbank as $vsb){if($vsb->userid ==$vls->merchantid ){echo substr($vsb->bankAccount, -4);}}?></span></td>
                                                    <td><?php foreach($ssbank as $vss){if($vss->id == $vls->bankid)echo $vss->bankAccount;}?></td>
                                                    <td><?php foreach($ssbank as $vssb){if($vssb->id == $vls->bankid)echo $vssb->truename;}?></td>
                                                    <td><label>
                                                        <?php 
                                                            switch ($vls->transferstatus){
                                                                case 0:echo '等待转账'; break;
                                                                case 1:echo '申请转账'; break;
                                                                case 2:echo '已转账'; break;
                                                                case 3:echo '转账失败'; break;
                                                                case 4:echo '未到账'; break;
                                                                default:echo '错误数据！';break;
                                                            }
                                                        ?>
                                                    </label></td>
                                                    <td><?=@date('Y-m-d H:i:s',$vls->addtime)?></td>
                                                </tr>                                           
                                            <?php endforeach;?>
                                        <?php endif;?>                      
                                    </tbody>
                                </table>
                            </div>
                            <!--内容区域-->
                        </div>
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
            <a href="javascript:" onclick="prePage('<?=site_url('capital/result')?>','<?=$page?>','<?=ceil($count/10)?>')"></a>
        </p>
        <p style="margin-left: 5px; margin-right: 5px;"><?=$page+1?>/<?=ceil($count/10)?></p>
        <p class="yyzx_3">
            <a href="javascript:" onclick="nextPage('<?=site_url('capital/result')?>','<?=$page?>','<?=ceil($count/10)-1?>')"></a>
        </p>
        <p style="margin-left: 12px; margin-right: 8px;">
            <input type="text" name="PageIndex" class="input_58" id="PageIndex" value="1" onkeyup="value=value.replace(/[^0-9]/g,'');submitPage(event,'<?=ceil($count/10)?>')" maxlength="9">
        </p>
        <p class="ymfw-right-zgj_7">
            <a href="javascript:" id="paRedirect" onclick="redirectPage('<?=site_url('capital/result')?>','<?=ceil($count/10)?>')">
                跳转</a></p>
    </div>
    <?php endif;?>
                    </div>
                    <!-- 转账结果页面 -->
                </div>
            </div>
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
}else if(screen.width == 1024){
         $("#onlineService").css("margin-top", "260px"); 
         $("#online_qq_tab").css("margin-top","260px");

            $(window).scroll(function () {  
        var scrollDiff = document.body.scrollTop //  拖拉处的位移  
        $("#onlineService").css("margin-top", "260px"); 
         $("#online_qq_tab").css("margin-top","260px"); // 重计算底部位置  
    });  
 }else{
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
</body>
</html>