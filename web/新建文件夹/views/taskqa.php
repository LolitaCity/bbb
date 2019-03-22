<?php require_once('include/header.php')?>
    
    <script src="<?=base_url()?>style/md5.jsstyle" type="text/javascript"></script>
    <script src="<?=base_url()?>style/jquery.jBox-2.3.min.jsstyle" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>style/jbox.css">

    <script src="<?=base_url()?>style/laydate.jsstyle" type="text/javascript"></script>
    <link type="text/css" rel="stylesheet" href="<?=base_url()?>style/laydate.css">
    <link type="text/css" rel="stylesheet" href="<?=base_url()?>style/laydate(1).css" id="LayDateSkin">

    <script>
        function setTab(name, cursel) {
            cursel_0 = cursel;
            for (var i = 1; i <= links_len; i++) {
                var menu = document.getElementById(name + i);
                var menudiv = document.getElementById("con_" + name + "_" + i);
                if (i == cursel) {
                    menu.className = "off";
                    menudiv.style.display = "block";
                }
                else {
                    menu.className = "";
                    menudiv.style.display = "none";
                }
            }
        }
        function Next() {
            cursel_0++;
            if (cursel_0 > links_len) cursel_0 = 1
            setTab(name_0, cursel_0);
        }
        var name_0 = 'one';
        var cursel_0 = 1;
        var links_len, iIntervalId;
        onload = function () {
            var links = document.getElementById("tab1").getElementsByTagName('li')
            links_len = links.length;
            for (var i = 0; i < links_len; i++) {
                links[i].onmouseover = function () {
                    clearInterval(iIntervalId);
                    this.onmouseout = function () {
                        iIntervalId = setInterval(Next, ScrollTime); ;
                    }
                }
            }
            document.getElementById("con_" + name_0 + "_" + links_len).parentNode.onmouseover = function () {
                clearInterval(iIntervalId);
                this.onmouseout = function () {
                    iIntervalId = setInterval(Next, ScrollTime); ;
                }
            }
            setTab(name_0, cursel_0);
            iIntervalId = setInterval(Next, ScrollTime);
        }
        function Timesa(id, hour, minute, second) {
            if (hour == "0" && minute == "0" && second == "0") {
                $("#date-" + id + "").html("0");
                $("#time-" + id + "").html("0");
                $("#second-" + id + "").html("0");
                return false;
            }
            second--;
            if (second <= -1 && minute > 0) {
                second = 59;
                minute--;
            }
            if (minute <= 0) {
                minute = 0;
                hour--;
            }
            if (hour <= 0) {
                hour = 0;
            }
            if (minute <= 0 && second <= 0) {
                minute = 0;
                second = 0;
            }
            if (hour == 0 && minute == 0 && second == 1) {
                $("#second-" + id).html(0);
                return false;
            }

            $("#date-" + id + "").html(hour);
            $("#time-" + id + "").html(minute);
            $("#second-" + id + "").html(second);
            setTimeout("Timesa('" + id + "'," + hour + "," + minute + "," + second + ")", 1000);
        }
    </script>
    <style type="text/css">
        .fpgl-td-rw
        {
            padding: 5px 0px;
            text-align: left;
        }
    </style>
    <script type="text/javascript">

        //设置回答内容
        function SetTaskQA(id) {
            $.openWin(670, 600, '/Fine/VTaskQA/SetTaskQA?id=' + id);
        }
        function ShopAuditQA(id) {
            $.openWin(600, 700, '/Fine/VTaskQA/ShopAudit?id=' + id);
        }
        function RefuseSetAnswer(id) {
            $.openWin(300, 500, '/Fine/VTaskQA/RefuseSetAnswer?id=' + id);
        }
        //查看任务日志
        function ShowOptLog(id) {
            $.openWin(500, 850, '/Fine/VTaskQA/GetOALogList?id=' + id);
        }
        //提示
        function ShowMsg() {
            $.openAlter("买手已经查看，不能再修改内容，如有紧急情况请联系平台管理员。", "温馨提示");
        }

        //修改回答内容
        function EditTaskQA(id) {
            $.openWin(680, 600, '/Fine/VTaskQA/EditTaskQA?id=' + id);
        }
        //查看评价内容
        function ShowCondition(id, type) {
            $.openWin(440, 500, '/Fine/VTaskQA/LookCondition?id=' + id + '&type=' + type);
        }
        //查看任务截图
        function GetPictures(id) {
            $.openWin(580, 1000, '/Fine/VTaskQA/GetPictures?id=' + id);
        }
    </script>

<body style="background: #fff;">
    <?php require_once('include/nav.php')?>
    <!--daohang-->
    
    
    <!-- 内容-->
    <div class="sj-fprw">
<form action="https://qqq.wkquan.com/Fine/VTaskQA" enctype="multipart/form-data" id="fm" method="post">            <!-- tab切换-->
            <div class="tab1" id="tab1">
                <div class="menu">
                    <ul>
                        <li id="one2" onclick="location.href='<?=site_url('saler')?>'">发布任务</li>
                        <li id="one1" onclick="location.href='<?=site_url('saler/task')?>'">任务管理</li>
                        <li id="one0" class="off" onclick="location.href='<?=site_url('saler/evaluation')?>'">评价管理</li>
                    </ul>
                </div>
                <div class="menu1" style="margin-top: 20px">
                    <ul>
                        <li id="two2" onclick="location.href='<?=site_url('saler/evaluation')?>'">评价任务<b style="color: red">(0)</b></li>
                        
                    </ul>
                </div>
                <div class="menudiv">
                    <div id="con_one_2">
                        <div class="fpgl-ss">
                            <p>                                
                                <select class="select_215" id="status" name="status" style="width:120px;"><option value="">所有任务</option>
<option value="1">等待设置回答</option>
<option value="2">等待刷客回答</option>
<option value="3">完成回答</option>
<option value="4">已取消</option>
<option value="5">商家待审核</option>
<option value="6">管理员待审核</option>
<option value="7">回答不通过</option>
</select>
                                <select class="select_215" id="selSearch" name="selSearch" style="width:120px;"><option value="TaskID">任务编号</option>
<option value="OrderID">订单编号</option>
<option value="WaybillNumber">运单号</option>
<option value="ShopName">店铺名称</option>
<option value="PlatformNumber">买号</option>
<option value="ShortName">商品简称</option>
</select>
                            </p>
                            <p>
                                <input class="input_417" id="txtSearch" name="txtSearch" style="width:150px;" type="text" value="">
                                </p>
                            <p>
                                支付时间:<input class="laydate-icon" id="BeginDate" maxlength="16" name="BeginDate" onclick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm'})" style="width:128px;height:34px;margin-left:5px;" type="text" value="">
                                ~
                                <input class="laydate-icon" id="EndDate" maxlength="16" name="EndDate" onclick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm'})" style="width:128px;height:34px;" type="text" value="">
                            </p>
                            <p>
                                <input class="input-butto100-ls" type="submit" value="查询"></p>
                            <p>
                                <input class="input-butto100-hs" type="button" value="刷新" onclick="location.href='/Fine/VTaskQA'"></p>
                        </div>
                        <!-- 搜索-->
                        <!-- 表格-->
                        <div class="fprw-pg">
                            <table>
                                <tbody><tr align="center">
                                    <th width="232">
                                        <center>
                                            任务/订单编号</center>
                                    </th>
                                    <th width="232">
                                        <center>
                                            买号/商品信息</center>
                                    </th>
                                    <th width="232">
                                        <center>
                                            提问与回答</center>
                                    </th>
                                    <th width="232">
                                        <center>
                                            任务状态</center>
                                    </th>
                                    <th width="132">
                                        <center>
                                            操作按钮</center>
                                    </th>
                                </tr>
                                    <tr>
                                        <td colspan="5" align="center">
                                            <span style="width: 20px; color: Red; font-size: 16px;">找不到相关数据</span>
                                        </td>
                                    </tr>
                            </tbody></table>
                        </div>
                        <!-- 表格-->
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
</body>
</html>