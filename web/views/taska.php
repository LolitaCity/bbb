<?php require_once('include/header.php')?>

    
    <script src="<?=base_url()?>style/laydate.js" type="text/javascript"></script>
    <link type="text/css" rel="stylesheet" href="<?=base_url()?>style/laydate.css">
    <link type="text/css" rel="stylesheet" href="<?=base_url()?>style/laydate(1).css" id="LayDateSkin">
    <script src="<?=base_url()?>style/Custom.js" type="text/javascript"></script>
    <script src="<?=base_url()?>style/jquery.jBox-2.3.min.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>style/jbox.css">

    <script type="text/javascript">
        $(function(){
        $("#VipTask").addClass("#VipTask");
        })
        function Timesa(id, hour, minute, second) {
            if (hour == "0" && minute == "0" && second == "0") {
                $("#date-" + id + "").html("0");
                $("#time-" + id + "").html("0");
                $("#second-" + id + "").html("0");
                return false;
            }
            second--;
            if (second <= 0) {
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


        function Timesa1(id, day, hour, minute, second) {
            if (day == "0" && hour == "0" && minute == "0" && second == "0") {
                //$("#day1-" + id + "").html("0");
                $("#date1-" + id + "").html("0");
                $("#time1-" + id + "").html("0");
                $("#second1-" + id + "").html("0");
                return false;
            }
            if (parseInt(day) > 0) {
                hour = parseInt(day) * 24 + parseInt(hour);
                day = 0;
            }
            second--;
            if (second <= 0) {
                second = 59;
                minute--;
            }
            if (minute <= 0 && hour > 0) {
                minute = 59;
                hour--;
            }
            else if (minute <= 0) {
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
                $("#second1-" + id).html(0);
                return false;
            }

            $("#date1-" + id + "").html(hour);
            $("#time1-" + id + "").html(minute);
            $("#second1-" + id + "").html(second);
            setTimeout("Timesa1('" + id + "'," + day + "," + hour + "," + minute + "," + second + ")", 1000);
        }

        $(document).ready(function () {
            $("#All").click(function () {
                if ($(this).attr("checked") == "checked") {
                    $("input[type='checkbox']").attr("checked", true);
                }
                else {
                    $("input[type='checkbox']").attr("checked", false);
                }
            });
            $("#price li").click(function () {
                $("#price li").removeClass("off");
                $(this).attr("class", "off");
                var status = $(this).attr("Name");
                if (status == "10") {
                    location.href = "GetATHOShopList?status=10&page=0";
                }
                else {
                    var sort = $("#stOrderType").val();
                    location.href = "TaskIndex?status=" + status + "&sort=" + sort;
                }
            });

            var status = request("status");
            var search = request("search");
            var value = request("value");
            if (value != "" && value != null)
                value = decodeURI(value);
            //$("#selSearch").val(search);
            //$("#txtSearch").val(value);
            $("#price li").each(function (e, item) {
                if ($(item).attr("Name") == status) {
                    $("#price li").removeClass("off");
                    $(item).addClass("off");
                }
            });

            if ($("#serviceValidation").attr("class")) {
                var info = $("#serviceValidation").children().children().text();
                if (info == "客服已介入，请留意待办事项中的处理结果反馈") {
                    $("#serviceValidation").hide();
                    $.jBox.alert(info, '提示', { width: 300, top: 200, height: 50 });
                }
            }
        })

        function Search() {
            var value = $("#txtSearch").val();
            var search = $("#selSearch").val();
            var status = request("status");
            var DateType = "7";
            var beginDate = $("#BeginDate").val();
            var endDate = $("#EndDate").val();
            location.href = "TaskIndex?selSearch=" + search + "&txtSearch=" + encodeURI(value) + "&status=" + status + "&DateType=" + DateType + "&BeginDate=" + beginDate + "&EndDate=" + endDate;
        }

        function request(paras) {
            var url = location.href;
            var paraString = url.substring(url.indexOf("?") + 1, url.length).split("&");
            var paraObj = {};
            for (var i = 0; j = paraString[i]; i++) {
                paraObj[j.substring(0, j.indexOf("=")).toLowerCase()] = j.substring(j.indexOf("=") + 1, j.length);
            }
            var returnValue = paraObj[paras.toLowerCase()];
            if (typeof (returnValue) == "undefined") {
                return "";
            } else {
                return returnValue;
            }
        }
        function ShowProductInfo(taskId, productId, taskType) {
            $.openWin(620, 700, '/Shop/Task/DetailsProduct?taskId=' + taskId);
        }

        function CreateDifference(url)
        {
           $.openWin(520, 520, url);
        }
        function CreateWorkOrder(url) {
         
            $.openWin(580, 520, url);
        }
        //        function CreateWorkOrder(id) {
        //            $.jBox('iframe:/Schedual/Schedual/CreateWorkOrder?id=' + id + "&type=1", {
        //                title: "客服介入",
        //                width: 500,
        //                height: 400,
        //                top: 100,
        //                buttons: {},
        //                closed: function () {
        //                }
        //            });
        //        }

        function ShowBuyRequire(id) {
            $.openWin(280, 450, '/Shop/Task/GetBuyNoRequire?taskId=' + id);

        }

        function EditMsg(id) {
            $.openWin(300, 450, '/Shop/Task/EditRemark?taskId=' + id);
        }

        function EditContent(id) {
            $.openWin(520, 450, '/Shop/Task/EditContent?taskId=' + id);
        }

        function CancelTask(id) {
            $.openWin(250, 450, '/Shop/Task/CancelTask?taskId=' + id);
        }

        function EditAddGoods(id) {
            $.openWin(520, 520, '/Shop/Task/EditAddGoods?taskID=' + id);
        }

        function CancelAcceptAndHideTask(id, BuyNumber) {
            $.openWin(350, 450, '/Shop/Task/CancelAcceptAndHideTask?taskId=' + id+"&taobaoName=" + BuyNumber);
        }

        function CancelAcceptTask(id) {
            $("#serviceValidation").remove();
            $("#clientValidationOL").html("");
            var submit = function (v, h, f) {
                if (v == true) {
                    $.ajax({
                        type: "post",
                        url: "CancelAcceptTask",
                        dataType: "text",
                        data: { taskId: id },
                        error: function (XmlHttpRequest, textStatus, errorThrown) {
                            var $errorPage = XmlHttpRequest.responseText;
                            $("<li>" + $errorPage + "</li>").appendTo($("#clientValidationOL"));
                            $("#clientValidation").show();
                        },
                        success: function (data) {
                            if (data == "OK") {
                                window.location.reload();
                            }
                            else {
                                $("<li>" + data + "</li>").appendTo($("#clientValidationOL"));
                                $("#clientValidation").show();
                            }
                        }
                    });
                }
                else
                { }
                return true;
            };

            jBox.confirm("确认要取消该任务<span style='font-weight:bolder;font-size:larger;color:red'>[" + id + "]</span>的接手?", "提示", submit, { id: 'hahaha', showScrolling: true, buttons: { '确定': true, '取消': false} });
        }

        function HideTask(id) {
            $("#serviceValidation").remove();
            $("#clientValidationOL").html("");
            document.getElementById('light1').style.display='none';
            document.getElementById('fade').style.display='none';
            $.ajax({
                        type: "post",
                        url: "HideTask",
                        dataType: "text",
                        data: { taskId: id },
                        error: function (XmlHttpRequest, textStatus, errorThrown) {
                            var $errorPage = XmlHttpRequest.responseText;
                            $("<li>" + $errorPage + "</li>").appendTo($("#clientValidationOL"));
                            $("#clientValidation").show();
                        },
                        success: function (data) {
                            if (data == "OK") {
                                window.location.reload();
                            }
                            else {
                                $("<li>" + data + "</li>").appendTo($("#clientValidationOL"));
                                $("#clientValidation").show();
                            }
                        }
            });
        }
        function ConfirmBuyAddGoods(TaskID, PlatformType) {
            ShowLayOut("fade","light1");

            document.getElementById('light1').style.display = 'block';
            document.getElementById('fade').style.display = 'block';

            var point = 0;
            $.ajaxSetup({
                async: false
            });
            $.post('/Shop/Task/Get', { platformType: PlatformType }, function (result) {
                point = result;
            });

            $("#lblRemark").text("要求买手追加评论将消耗["+point+"]个发布点，请问是否确认购买追评？？");
            $("#lTitle").text("提示");
            $("#btnSubmit").attr("onclick","BuyAddGoods('"+TaskID+"','"+PlatformType+"')");
        }

        function BuyAddGoods(TaskID, PlatformType) {
            document.getElementById('light1').style.display = 'none';
            document.getElementById('fade').style.display = 'none';
            $.post('/Shop/Task/BuyAddGoods', { taskID: TaskID }, function (result) {
                        if (result == "OK") {
                            window.location.reload();
                        }
                        else {
                            $("<li>" + data + "</li>").appendTo($("#clientValidationOL"));
                                $("#clientValidation").show();
                        }
           });
        }

        function ShowTask(taskId) {
            $("#serviceValidation").remove();
            $("#clientValidationOL").html("");
            document.getElementById('light1').style.display='none';
            document.getElementById('fade').style.display='none';
            $.ajax({
                        type: "post",
                        url: "ShowTask",
                        dataType: "text",
                        data: { taskId: taskId },
                        error: function (XmlHttpRequest, textStatus, errorThrown) {
                            var $errorPage = XmlHttpRequest.responseText;
                            $("<li>" + $errorPage + "</li>").appendTo($("#clientValidationOL"));
                            $("#clientValidation").show();
                        },
                        success: function (data) {

                            if (data == "OK") {
                                window.location.reload();
                            }
                            else {
                                $("<li>" + data + "</li>").appendTo($("#clientValidationOL"));
                                $("#clientValidation").show();
                            }
                        }
           });
        }



        function PiCancel() {

            var value = "";
            var box = $(".fprw-pg input[type='checkbox']");

            for (var i = 0; i < box.length; i++) {
                if (box[i].checked && box[i].id != "All" && box[i].style.display != "none") { //判断复选框是否选中
                    value = value + box[i].value + ",";
                }
            }

            $("#serviceValidation").remove();
            $("#clientValidationOL").html("");
            var taskIds = value;

            if (taskIds == "" || taskIds == null) {
                $("<li>请选择要取消的任务编号！</li>").appendTo($("#clientValidationOL"));
                $("#clientValidation").show();
                return;
            }
            $.openWin(250, 450, '/Shop/Task/CancelTask?taskId=' + taskIds);
        }

        function FaHuo(taskId) {
            $.openWin(540, 550, '/Shop/Task/FaHuo?taskId=' + taskId);
        }

        function GetPictures(taskId) {
            $.openWin(550, 800, '/Shop/Task/GetPictures?taskId=' + taskId);
        }

        function GetLink(taskId) {
            $.openWin(550, 650, '/Shop/Task/GetLink?taskId=' + taskId);
        }

        function GetHighOptionPictures(taskId) {
            $.openWin(550, 800, '/Shop/Task/GetHighOptionPicture?taskId=' + taskId);
        }
        function ShowTaskOptLog(taskID) {
            $.openWin(450, 800, '/Shop/Task/TaskOptLogList?taskID=' + taskID);
        }

        function ConfirmReceiveRemind(taskId)
        {
            ShowLayOut("fade","light1");

            document.getElementById('light1').style.display = 'block';
            document.getElementById('fade').style.display = 'block';
            $("#lblRemark").text("确定发送确认收货提醒["+taskId+"]？");
            $("#lTitle").text("提示");
            $("#btnSubmit").attr("onclick","ReceiveRemind('"+taskId+"')");
            
        }

        //确认收货提醒
        function ReceiveRemind(taskId) {
            document.getElementById('light1').style.display = 'none';
            document.getElementById('fade').style.display = 'none';

            $("#" + taskId + taskId).val("处理中...");
            $("#" + taskId + taskId).removeAttr("onclick");
            $("#serviceValidation").remove();
            $("#clientValidationOL").html("");
            $("#clientValidation").hide();
            $.ajax({
                        type: "post",
                        url: "ReceiveRemind",
                        dataType: "text",
                        data: { taskId: taskId },
                        error: function (XmlHttpRequest, textStatus, errorThrown) {
                            var $errorPage = XmlHttpRequest.responseText;
                            $("<li>" + $errorPage + "</li>").appendTo($("#clientValidationOL"));
                            $("#clientValidation").show();
                        },
                        success: function (data) {
                            $("#" + taskId + taskId).val("收货提醒");
                            $("#" + taskId + taskId).attr("onclick", "ConfirmReceiveRemind('" + taskId + "')");
                            if (data == "OK") {
                                window.location.reload();
                            }
                            else {
                                $("<li>" + data + "</li>").appendTo($("#clientValidationOL"));
                                $("#clientValidation").show();
                            }
                        }
                    });
        }

        function ConfirmFinish(taskId)
        {
            ShowLayOut("fade","light1");
            document.getElementById('light1').style.display = 'block';
            document.getElementById('fade').style.display = 'block';
            $("#lblRemark").text("你确定买家已经在淘宝平台对您进行了好评["+taskId+"]？");
            $("#lTitle").text("提示");
            $("#btnSubmit").attr("onclick","Finish('"+taskId+"')");
            
        }

        function Finish(taskId) {
            document.getElementById('light1').style.display = 'none';
            document.getElementById('fade').style.display = 'none';

            $("#" + taskId + taskId).val("处理中...");
            $("#" + taskId + taskId).removeAttr("onclick");
            $("#serviceValidation").remove();
            $("#clientValidationOL").html("");
            $("#clientValidation").hide();
            $.ajax({
                        type: "post",
                        url: "TaskFinish",
                        dataType: "text",
                        data: { taskId: taskId },
                        error: function (XmlHttpRequest, textStatus, errorThrown) {
                            var $errorPage = XmlHttpRequest.responseText;
                            $("<li>" + $errorPage + "</li>").appendTo($("#clientValidationOL"));
                            $("#clientValidation").show();
                        },
                        success: function (data) {
                            $("#" + taskId + taskId).val("审核通过");
                            $("#" + taskId + taskId).attr("onclick", "ConfirmFinish('" + taskId + "')");
                            if (data == "OK") {
                                window.location.reload();
                            }
                            else {
                                $("<li>" + data + "</li>").appendTo($("#clientValidationOL"));
                                $("#clientValidation").show();
                            }
                        }
                    });
        }

        function ShowLog(taskId) {
            $.jBox("iframe:OptionLog?taskId=" + taskId, {
                title: "查看状态",
                width: 800,
                height: 550,
                top: 120,
                buttons: {},
                closed: function () {
                }
            });
        }

        function NoSet() {
            $.openAlter("客官别急，快递尚未反馈空包单号，请稍后再发货~", "提示");
        }

        function ChangeTime() {
            if ($("#DateType").val() == "7") {
                $("#lblTime").show();
            }
            else
                $("#lblTime").hide();
        }

        function Refresh() {
            var status = request("status");
            window.location.href="/Shop/Task/TaskIndex?status=" + status;
        }

        function HideOrShowTask(type,taskID) {
            ShowLayOut("fade","light1");

            document.getElementById('light1').style.display = 'block';
            document.getElementById('fade').style.display = 'block';

            
            if(type=="show")
            {
                $("#lblRemark").text("确定要显示该任务["+taskID+"]？");
                $("#lTitle").text("显示任务");
                $("#btnSubmit").attr("onclick","ShowTask('"+taskID+"')");
            }
            if(type=="hide")
            {
                $("#lblRemark").text("确定要隐藏该任务["+taskID+"]？");
                $("#lTitle").text("隐藏任务");
                $("#btnSubmit").attr("onclick","HideTask('"+taskID+"')");
            }
        }

        function PunishRemark(remark)
        {
            $.openAlter(remark, "处罚原因");
        }
    </script>

<body style="background: #fff;">
    <?php require_once('include/nav.php')?>
    <!--daohang-->
    
<form action="https://qqq.wkquan.com/Shop/Task/TaskIndex" enctype="multipart/form-data" id="fm" method="post">        <div class="sj-fprw">
            <div class="errorbox" id="clientValidation" style="display: none; width: 95%; height: 30px;
                margin-left: 20px">
                <ol style="list-style-type: decimal" id="clientValidationOL">
                </ol>
            </div>
            <div class="tab1">
                <div class="menu">
                    <ul>
                        <li onclick="javascript:window.location.href='<?=site_url('saler')?>'">
                            发布任务</li>
                        <li class="off" onclick="javascript:window.location.href='<?=site_url('saler/task')?>'">
                            发布管理</li>
                    </ul>
                </div>
                <div class="menu1" id="price" style="margin-top: 20px;">
                    <ul>
                        <li name="All" class="off">全部</li>
                        <li name="6">隐藏</li>
                        <li name="0">待接手</li>
                        <li name="1">进行中</li>
                        <li name="2">待发货</li>
                        <li name="3">待评价</li>
                        <li name="4">待完成</li>
                        <li name="5">已完成</li>
                        <li name="10">追评任务</li>
                        <li name="7">已取消</li>
                    </ul>
                </div>
                <div class="menudiv">
                    <div id="con_one_1" class="sj-fpgl">
                        <!-- 搜索-->
                        <div class="fpgl-ss">
                            <p>
                                <select class="select_215" id="selSearch" name="selSearch"><option value="OrderID">订单编号</option>
<option value="TaskID">任务编号</option>
<option value="ProductName">商品名称</option>
<option value="WaybillNumber">运单号</option>
<option value="ProductId">商品ID</option>
<option value="PlatformNumber">掌柜号</option>
<option value="BuyNum">买号</option>
</select>
                            </p>
                            <p>
                                <input class="input_417" id="txtSearch" name="txtSearch" style="width: 200px" type="text" value="">
                            </p>
                            <p>
                                发布时间:<input class="laydate-icon" id="BeginDate" maxlength="16" name="BeginDate" onclick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm'})" style="width:128px;height:34px;margin-left:5px;" type="text" value="">
                                ~
                                <input class="laydate-icon" id="EndDate" maxlength="16" name="EndDate" onclick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm'})" style="width:128px;height:34px;" type="text" value="">
                            </p>
                            <p>
                                <input class="input-butto100-ls" type="button" value="查询" onclick="Search()"></p>
                            <p>
                                <input class="input-butto100-hs" type="button" value="刷新" onclick="Refresh()"></p>
                        </div>
                        <!-- 搜索-->
                        <!-- 表格-->
                        <div class="fprw-pg" style="width: 99%;">
                            <table>
                                <tbody><tr>
                                    <th width="280">
                                        <input type="checkbox" id="All">
                                        <input type="button" class="input-butto100-xls" id="btnCancel" value="批量取消" onclick="PiCancel()" style="height: 30px; width: 70px">
                                        任务编号
                                    </th>
                                    <th width="222">
                                        掌柜号
                                    </th>
                                    <th width="252">
                                        商品名称/地址
                                    </th>
                                    <th width="182">
                                        价格及发布点
                                    </th>
                                    <th width="222">
                                        发布时间
                                    </th>
                                    <th width="210">
                                        接手人信息
                                    </th>
                                    <th width="192">
                                        好评要求
                                    </th>
                                    <th width="242">
                                        任务状态
                                    </th>
                                    <th width="232">
                                        操作
                                    </th>
                                </tr>
                                    <tr>
                                        <td colspan="9" align="center">
                                            <span style="width: 20px; font-weight: bolder; color: Red; font-size: 16px;">找不到相关数据</span>
                                        </td>
                                    </tr>
                            </tbody></table>
                        </div>
                        <!-- 表格-->
                    </div>
                </div>
            </div>
        </div>
        <div id="light1" class="ycgl_tc yctc_498">
            <!--列表 -->
            <div class="htyg_tc">
                <ul>
                    <li class="htyg_tc_1" id="lTitle"></li>
                    <li class="htyg_tc_2"><a href="javascript:void(0)" onclick="document.getElementById('light1').style.display='none';document.getElementById('fade').style.display='none'">
                        <img src="style/sj-tc.png"></a></li>
                </ul>
            </div>
            <!--列表 -->
            <div class="yctc_458 ycgl_tc_1">
                <ul>
                    <li class="" id="lblRemark"></li>
                    <li class="fpgl-tc-qxjs_4">
                        <p>
                            <input class="input-butto100-hs" type="button" id="btnSubmit" value="确定" onclick="">
                        </p>
                        <p>
                            <input onclick="document.getElementById('light1').style.display = 'none'; document.getElementById('fade').style.display = 'none'" class="input-butto100-ls" type="button" value="取消"></p>
                    </li>
                </ul>
            </div>
        </div>
        <div id="fade" class="black_overlay">
        </div>
</form>
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