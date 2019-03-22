
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
        function Search() {
            $("#loading").show();
            $("#loading2").hide();
            $("#fm").submit();
        }
        function showinfo(){
        	$.openWin(400, 500, '<?=site_url('capital/outall')?>');
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
                <li><a href="<?=site_url('capital/transfer')?>">转账管理</a> </li>
                <li><a href="<?=site_url('capital/fund')?>" >资金管理</a> </li>
                <li><a href="<?=site_url('capital/order')?>" style="background: #eee;color: #ff9900;">订单信息</a> </li>
            </ul>
        </div>
        
<form action="<?=site_url('capital/searchinfo')?>" id="fm" method="post">        
        <div class="zjgl-right">
            <div class="errorbox" id="clientValidation" style="display: none; width: 95%; height: 25px;">
                <ol style="list-style-type: decimal" id="clientValidationOL">
                </ol>
            </div>            

            <div class="menu">
                <ul>
                    <li class="off">任务订单信息</li>
                </ul>
            </div>
            <div class="sk-hygl">
                <div class="fpgl-ss">
                    <p>
                        统计时间：<input class="laydate-icon" id="BeginDate" maxlength="16" name="BeginDate" onclick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm'})" style="width:110px;height:34px;margin-left:5px;" type="text" value="">
                        ~
                        <input class="laydate-icon" id="EndDate" maxlength="16" name="EndDate" onclick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm'})" style="width:110px;height:34px;" type="text" value="">
                    </p>
                    <p>
                        类型：<select class="select_215" id="FinanceType" name="FinanceType" style="width:130px;">
                <option value="0">请选择</option>
                <option value="1">销量任务</option>
                <option value="2">复购任务</option>
                <option value="3">充值</option>
                <option value="4">工单处罚</option>
                <option value="5">购买评价</option>
                <option value="6">推广获取</option>
            </select>
                    </p>
                    <p>
                        <select class="select_215" id="SelectValue" name="SelectValue" style="width:100px;">
                            <option value="0">请选择</option>
                            <option value="FinanceKey">任务编号</option>
                            <option value="ShopName">店铺名称</option>
                            <option value="ProductPlatformID">商品ID</option>
                        </select>
                    </p>
                    <p>
                        <input class="select_215" id="InputText" name="InputText" style="width:110px;" type="text" value="">
                    </p>
                    <p id="loading2">
                        <input class="input-butto100-ls" type="button" id="btnSearch" value="查询" onclick="Search()" style="width: 60px;"></p>
                    <div class="loading_div" style="float: left; margin-right: 5px; display: none;" id="loading">
                        <input class="input-butto100-ls" type="button" value="" onclick="">
                        <div class="loading">
                            <img src="<?=base_url()?>style/images/laoding2.png"></div>
                    </div>
                    <p>
                        <input class="input-butto100-hs" id="export" type="button" value="导出" onclick="ToExcel()" style="width: 60px;">
                        <input class="input-butto100-hs" id="exporting" type="button" value="导出中..." onclick="" style="width: 80px; display: none;"></p>
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
                            <tr>
                                <td align="center">
                                    <div style="word-break: break-all;">sandyjack旗舰店</div>
                                </td>
                                <td align="center">
                                    <span style="color: Red">购买智能助手基础版</span>
                                </td>
                                <td align="center">
                                    <div style="width: 60px; word-break: break-all;">-100.00</div>
                                </td>
                                <td align="center">
                                    <div style="width: 70px; word-break: break-all;">233.70</div>
                                </td>
                                <td align="center">
                                    <div style="width: 70px; word-break: break-all;">133.70</div>
                                </td>
                                <td align="center">
                                    <p><input class="button-c" type="button" value="查看备注" onclick="GetRemark('sandyjack旗舰店','购买智能助手【收费版一个月】')"></p>
                                </td>
                                <td align="center">
                                    <div style="width: 70px; word-break: break-all;">2017/9/30 17:04:28</div>
                                </td>
                            </tr>                            
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
                window.location = url + "&page=" + (pageIndex - 1);
        }

        /*下一页*/
        function nextPage(url, pageIndex, maxCount) {
            if (pageIndex > maxCount) {
                $.openAlter("没有了", "提示", { height: 210, width: 350 });
                return;
            }
            window.location = url + "&page=" + (pageIndex - 1);
        }

        /*上一页*/
        function prePage(url, pageIndex, maxCount) {
            if (pageIndex <= 0) {
                $.openAlter("没有了", "提示", { height: 210, width: 350 });
                return;
            }
            window.location = url + "&page=" + (pageIndex - 1);
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
            <a href="javascript:" onclick="prePage('<?=site_url('member/join/'.($page-1))?>','<?=$page?>','<?=ceil($count/10)?>')"></a>
        </p>
        <p style="margin-left: 5px; margin-right: 5px;"><?=$page+1?>/<?=ceil($count/10)?></p>
        <p class="yyzx_3">
            <a href="javascript:" onclick="nextPage('<?=site_url('member/join/'.($page+1))?>','<?=$page?>','<?=ceil($count/10)-1?>')"></a>
        </p>
        <p style="margin-left: 12px; margin-right: 8px;">
            <input type="text" name="PageIndex" class="input_58" id="PageIndex" value="1" onkeyup="value=value.replace(/[^0-9]/g,'');submitPage(event,'<?=ceil($count/10)?>')" maxlength="9">
        </p>
        <p class="ymfw-right-zgj_7">
            <a href="javascript:" id="paRedirect" onclick="redirectPage('<?=site_url('member/join')?>','<?=ceil($count/10)?>')">
                跳转</a></p>
    </div>
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
    $(document).ready(function () {
        var loginName='<?=$info->Username?>';
        var memberType='商家';
        var member='商家';
        if(member==memberType){
            $("#consultLi").show();
//            $("#online_qq_tab").css("margin-top","420px");
        }
        else {
            $("#consultLi").hide();
        }
        $("#online_qq_layer").show();
        
        $("#floatShow").bind("click", function () {
            
            $("#onlineService").animate({ width: "show", opacity: "show" }, "normal", function () {
                $("#onlineService").show();
            });

            $("#floatShow").attr("style", "display:none");
            $("#floatHide").attr("style", "display:block");
            return false;
        });

        $("#floatHide").bind("click", function () {

            $("#onlineService").animate({ width: "hide", opacity: "hide" }, "normal", function () {
                $("#onlineService").hide();
            });
            $("#floatShow").attr("style", "display:block");
            $("#floatHide").attr("style", "display:none");
            return false;
        });
    });
    $(window)

</script>

<?php require_once('include/footer.php')?>  


</body></html>