
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

        function GetRemark(id) {
            $.openWin(250, 380, '<?=site_url('capital/show')?>'+'?id=' + id);
        }
        function Search() {
            $("#loading").show();
            $("#loading2").hide();
            $("#fm").submit();
        }
        function showinfo(){
        	$.openWin(400, 500, '<?=site_url('capital/outall')?>');
        }
        function ToExcel(){
            if(confirm("确认导出最近35天的数据吗？？？")){
          	     location.href='<?=site_url('capital/DetailedExcel')?>';
             }        	
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
        
<form action="<?=site_url('capital/searchinfo');?>" id="fm" method="post">        
        <div class="zjgl-right">
            <div class="errorbox" id="clientValidation" style="display: none; width: 95%; height: 25px;">
                <ol style="list-style-type: decimal" id="clientValidationOL">
                </ol>
            </div>            
        <div style=" margin-bottom:10px;">
            账户余额：<span style=" padding:0 10px; color:red;"><?=$info->Money?></span>元
            <span style=" padding:0 10px; color:blue;">其中有<strong style=" padding:0 10px; color:forestgreen;"><?=$info->bond?></strong>元为账户保证金（若账户中金额少于保证金的话将无法发布任务）</span><br>
            完成已发布任务所需佣金:<span style="padding:0 10px; color:red"><?=$need?></span>元<br>
            <?php if($need==0):?><a href="javascript:void(0)" onclick="showinfo()"  class="getallbtn">申请账户保证金与账户余额</a><?php endif;?>
           <style>
            .getallbtn{ background:#4782EF; color:#FFF; padding:10px 15px; display: inline-block}
            .getallbtn:hover{ color:#ff9900;}
            </style>
        </div>
            <div class="menu">
                <ul>
                    <li class="off">收支流水明细</li>
                </ul>
            </div>
            <div class="sk-hygl">
                <div class="fpgl-ss">
                    <p>
                        统计时间：<input class="laydate-icon" id="BeginDate" maxlength="16" name="BeginDate" onclick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm'})" style="width:150px;height:34px;margin-left:5px;" type="text" value="<?=$search=='1'?@date('Y-m-d H:i:s',$begintime):'';?>">
                        ~
                        <input class="laydate-icon" id="EndDate" maxlength="16" name="EndDate" onclick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm'})" style="width:150px;height:34px;" type="text" value="<?=$search=='1'?@date('Y-m-d H:i:s',$endtime):'';?>">
                    </p>
                    <p style="line-height:35px;">若开始时间，结束时间都为空，则读取所有数据</p>
                    <p id="loading2">
                        <input class="input-butto100-ls" type="button" id="btnSearch" value="查询" onclick="Search()" style="width: 60px;"></p>
                    <div class="loading_div" style="float: left; margin-right: 5px; display: none;" id="loading">
                        <input class="input-butto100-ls" type="button" value="" onclick="">
                        <div class="loading">
                            <img src="<?=base_url()?>style/images/laoding2.png"></div>
                    </div>
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
                            <th>原存款</th>
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
                                        <div style="word-break: break-all;"><?php foreach($shoparr as $vsa){ if($vsa->sid ==  $vl->shopid){ echo $vsa->shopname; } }?></div>
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
                                        <div style="width: 70px; word-break: break-all;"><?php if(substr($vl->increase, 0,1)=='-'){ echo $vl->remoney + sprintf($vl->increase);}else{ echo $vl->remoney + sprintf($vl->increase);}?></div>
                                    </td>
                                    <td align="center">
                                        <p><input class="button-c" type="button" value="查看备注" onclick="GetRemark('<?=$vl->id?>')"></p>
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
    <?php if($search=='0'):?>
    <div class="yyzx_1">
        <p class="yyzx_2">
            <a href="javascript:" onclick="prePage('<?=$search=='1'?site_url('capital/searchinfo'):site_url('capital/fund')?>','<?=$page?>','<?=ceil($count/10)?>')"></a>
        </p>
        <p style="margin-left: 5px; margin-right: 5px;"><?=$page+1?>/<?=ceil($count/10)?></p>
        <p class="yyzx_3">
            <a href="javascript:" onclick="nextPage('<?=$search=='1'?site_url('capital/searchinfo'):site_url('capital/fund')?>','<?=$page?>','<?=ceil($count/10)-1?>')"></a>
        </p>
        <p style="margin-left: 12px; margin-right: 8px;">
            <input type="text" name="PageIndex" class="input_58" id="PageIndex" value="1" onkeyup="value=value.replace(/[^0-9]/g,'');submitPage(event,'<?=ceil($count/10)?>')" maxlength="9">
        </p>
        <p class="ymfw-right-zgj_7">
            <a href="javascript:" id="paRedirect" onclick="redirectPage('<?=$search=='1'?site_url('capital/searchinfo'):site_url('capital/fund')?>','<?=ceil($count/10)?>')">跳转</a>
         </p>
    </div>
    <?php endif;?>
            </div>
        </div>
</form>
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