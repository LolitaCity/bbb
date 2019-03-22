    <?php require_once('include/nav.php')?>  

    
    <script src="<?=base_url()?>style/md5.js" type="text/javascript"></script>
    <script src="<?=base_url()?>style/jquery.jBox-2.3.min.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>style/jbox.css">
  
    <script src="<?=base_url()?>style/laydate.js" type="text/javascript"></script>
    <link type="text/css" rel="stylesheet" href="<?=base_url()?>style/laydate.css">
    <link type="text/css" rel="stylesheet" href="<?=base_url()?>style/laydate(1).css" id="LayDateSkin">
    <script type="text/javascript">
        $(function () {
         
            $("#TaskApp").addClass("#TaskApp");
            if ('10' == '0') {
                $("#btnCancelAll").removeAttr('onclick');
                $("#btnCancelAll").attr("class", "input-butto100-xxshs");
            }
            if ('0' == '0') {
                $("#btnAuditAll").removeAttr('onclick');
                $("#btnAuditAll").attr("class", "input-butto100-xxshs");


            }
        });
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
        //        onload = function () {
        //            var links = document.getElementById("tab1").getElementsByTagName('li')
        //            links_len = links.length;
        //            for (var i = 0; i < links_len; i++) {
        //                links[i].onmouseover = function () {
        //                    clearInterval(iIntervalId);
        //                    this.onmouseout = function () {
        //                        iIntervalId = setInterval(Next, ScrollTime); ;
        //                    }
        //                }
        //            }
        //            document.getElementById("con_" + name_0 + "_" + links_len).parentNode.onmouseover = function () {
        //                clearInterval(iIntervalId);
        //                this.onmouseout = function () {
        //                    iIntervalId = setInterval(Next, ScrollTime); ;
        //                }
        //            }
        //            setTab(name_0, cursel_0);
        //            iIntervalId = setInterval(Next, ScrollTime);
        //        }
    </script>
    <script type="text/javascript">
        //取消任务
        function CancelTask(taskID) {
            $.openWin(320, 700, '/Fine/VTrafficTask/CancelTask?taskID=' + taskID);
        }
        //取消全部带接手任务
        function CancelAllTask() {
            if($("#status").val()!="0"&&$("#status").val()!="5"){
                $.openAlter("查询条件为<em style=\"color:red\">“待接手”</em>或<em style=\"color:red\">“隐藏任务”</em> ，才能进行一键取消任务操作。", "温馨提示");
                return false;
            }
            var status=$("#status").val();
            var beginDate=$("#BeginDate").val();
            var endDate=$("#EndDate").val();
            var selSearch = $("#selSearch").val();
            var txtSearch = $("#txtSearch").val();
            $.openWin(220, 400, '/Fine/VTrafficTask/CancelAllTask?status='+status+'&startTime='+beginDate+'&endTime='+endDate+ '&selSearch=' + selSearch + '&txtSearch=' + txtSearch);
        }
        //显示任务
        function ShowTask(taskID) {
            $.openWin(220, 500, '/Fine/VTrafficTask/ShowTask?taskID=' + taskID);
        }
        //s审核任务
        function AuditTask(taskID) {
            $.post("/Fine/VTrafficTask/IsShopLookSearchImgs", { taskID: taskID }, function (result) { 
            
            });
            $.openWin(600, 780, '/Fine/VTrafficTask/AuditTask?taskID=' + taskID);
        }
        //隐藏任务
        function HideTask(taskID) {
            $.openWin(220, 500, '/Fine/VTrafficTask/HideTask?taskID=' + taskID);
        }

        //修改备注
        function EditTaskRemark(taskID) {
            $.openWin(300, 500, '/Fine/VTrafficTask/EditRemark?taskID=' + taskID);
        }
        //查看备注
        function LookTaskRemark(taskID) {
            $.openWin(300, 500, '/Fine/VTrafficTask/LookRemark?taskID=' + taskID);
        }
        function LookQuestion(taskID) {
            $.openWin(350, 500, '/Fine/VTrafficTask/LookQuestion?taskID=' + taskID);
        }
        function EditQuestion(taskID) {
            $.openWin(380, 500, '/Fine/VTrafficTask/EditQuestion?taskID=' + taskID);
        }
        //查看京东买号信息
        function LookJdBuyNumberInfo(id) {
            $.openWin(380, 450, '/Fine/VTrafficTask/GetJDDetailInfo?id=' + id);
        }
        //查看买号信息
        function LookBuyNumberInfo(id) {

            $.openWin(380, 450, '/Fine/VTrafficTask/GetDetailInfo?id=' + id);
            //            $.openWin(380, 700, '/Fine/VTrafficTask/LookBuyNumberInfo?taskID=' + taskID);
        }
        //查看任务详情
        function GetTaskDatailInfo(taskID) {
            $.openWin(680, 700, '/Fine/VTrafficTask/GetTaskDatailInfo?taskID=' + taskID);
        }


        //查看任务日志
        function ShowOptLog(taskID) {
            $.openWin(500, 850, '/Fine/VTrafficTask/TaskOptLog?taskID=' + taskID);
        }
        //设置好评内容
        function SetCondition(id) {
            $.openWin(610, 610, '/Fine/VTrafficTask/SetCondition?id=' + id);
        }
        //设置追评内容
        function SetAddCondition(id) {
            $.openWin(610, 610, '/Fine/VTrafficTask/SetAddCondition?id=' + id);
        }
        //修改好评内容
        function EditCondition(id) {
            $.openWin(500, 600, '/Fine/VTrafficTask/EditCondition?id=' + id);
        }
        //修改晒图好评内容
        function EditImgeCondition(id) {
            $.openWin(600, 600, '/Fine/VTrafficTask/EditImgeCondition?id=' + id);
        }

        //修改追评内容
        function EditAddCondition(id) {
            $.openWin(500, 600, '/Fine/VTrafficTask/EditAddCondition?id=' + id);
        }
        //修改晒图追评内容
        function EditAddImgeCondition(id) {
            $.openWin(600, 600, '/Fine/VTrafficTask/EditAddImgeCondition?id=' + id);
        }
        //查看评价内容
        function ShowCondition(id) {
            $.openWin(440, 500, '/Fine/VTrafficTask/LookCondition?id=' + id);
        }
        //查看追评内容
        function ShowAddCondition(id) {
            $.openWin(440, 500, '/Fine/VTrafficTask/LookAddCondition?id=' + id);
        }
        //查看任务截图
        function GetPictures(id) {
            $.openWin(580, 1000, '/Fine/VTrafficTask/GetPictures?id=' + id);
        }
        //查看任务截图
        function GetAddPictures(id) {
            $.openWin(580, 1000, '/Fine/VTrafficTask/GetAddPictures?id=' + id);
        }
        //短信催评 
        function SetInfo(id, fOpinionStatus) {
            $.openWin(250, 500, '/Fine/VTrafficTask/SetInfo?id=' + id + "&fOpinionStatus=" + fOpinionStatus);
        }

        //一键审核
        function ReviewKey() {
            $.openWin(600, 780, '/Fine/VTrafficTask/APPShopAuditAll');
        }

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
<form action="#" enctype="multipart/form-data" id="fm" method="post">            <!-- tab切换-->
            <div class="tab1" id="tab1">
                <div class="menu">
                    <ul>
                        <li id="one2" onclick="location.href=&#39;/Fine/VTrafficTask&#39;">发布流量任务</li>
                        <li id="one1" class="off" onclick="location.href=&#39;/Fine/VTrafficTask/TaskIndex&#39;">
                            流量任务管理</li>
                    </ul>
                </div>
                <div class="menudiv">
                    <div id="con_one_2">
                        <div class="fpgl-ss">
                            <p>
                                <select class="select_215" id="status" name="status" style="width:110px;"><option value="-1">所有任务</option>
<option value="0">待接手</option>
<option value="1">进行中</option>
<option value="3">管理员待审核</option>
<option value="2">商家待审核</option>
<option value="6">已取消</option>
<option value="4">已完成</option>
<option value="5">隐藏任务</option>
</select>
                                <select class="select_215" id="selSearch" name="selSearch" style="width:100px;"><option value="TaskID">任务编号</option>
<option value="ProductNameShort">商品简称</option>
<option value="ProductID">商品ID</option>
<option value="PlatformNumber">掌柜号</option>
</select>
                            </p>
                            <p>
                                <input class="input_417" id="txtSearch" name="txtSearch" style="width:150px;" type="text" value=""></p>
                            <p>
                                发布时间:<input class="laydate-icon" id="BeginDate" maxlength="16" name="BeginDate" onclick="laydate({istime: true, format: &#39;YYYY-MM-DD hh:mm&#39;})" style="width:126px;height:34px;margin-left:5px;" type="text" value="">
                                ~
                                <input class="laydate-icon" id="EndDate" maxlength="16" name="EndDate" onclick="laydate({istime: true, format: &#39;YYYY-MM-DD hh:mm&#39;})" style="width:126px;height:34px;" type="text" value="">
                            </p>
                            <p>
                                <input style="width: 60px" class="input-butto100-ls" type="submit" value="查询"></p>
                            <p>
                                <input style="width:60px" class="input-butto100-hs" type="button" value="刷新" onclick="location.href=&#39;/Fine/VTrafficTask/TaskIndex&#39;"></p>
                            <p>
                                <input type="button" style="width: 90px" class="input-butto100-ls" onclick="CancelAllTask()" id="btnCancelAll" value="一键取消任务"></p>
                            <p>
                                <input class="input-butto100-xxshs" style="width:90px" type="button" value="一键审核(0)" id="btnAuditAll">
                            </p>
                        </div>
                        <!-- 搜索-->
                        <!-- 表格-->
                        <div class="fprw-pg">
                            <table>
                                <tbody><tr align="center">
                                    <th width="220">
                                        <center>
                                            任务信息</center>
                                    </th>
                                    <th width="260">
                                        <center>
                                            商品信息</center>
                                    </th>
                                    <th width="250">
                                        <center>
                                            任务详情</center>
                                    </th>
                                    <th width="220">
                                        <center>
                                            任务状态</center>
                                    </th>
                                    <th width="132">
                                        <center>
                                            操作按钮</center>
                                    </th>
                                </tr>
                                    <tr>
                                        <td>
                                            <p class="fpgl-td-rw">
                                                任务编号：S6588002684 </p>
                                            <p class="fpgl-td-rw">
                                                流量入口：淘宝APP自然搜索</p>
                                            <p class="fpgl-td-rw">
                                                任务类型：无线端</p>
                                            <p class="fpgl-td-rw">
                                                佣金：1.30</p>
                                        </td>
                                        <td class="fpgl-td-zs">
                                            <p class="fpgl-td-rw">
                                                商品简称：糖果色包
                                            </p>
                                            <p class="fpgl-td-rw">
                                                商品ID：554949688598</p>
                                            <p class="fpgl-td-rw">
                                                掌柜号：sandyjack旗舰店</p>
                                        </td>
                                        <td class="fpgl-td-zs" style="word-break: break-all">
                                            <center>
                                                <p class="fpgl-td-rw">
                                                    关键字：真皮女包</p>
                                                    <p class="fpgl-td-rw">
                                                        增值服务：                                                            <label>
                                                                旺旺咨询</label>
                                                    </p>
                                                <p class="fpgl-td-rw" style="text-align: center; font-weight: bold">
                                                </p>
                                            </center>
                                        </td>
                                        <td class="fpgl-td-zs" style="word-break: break-all">
                                            <center>
                                                <p class="fpgl-td-rw" style="text-align: center">
                                                    <strong><a href="javascript:void(0)" onclick="ShowOptLog(&#39;S6588002684&#39;)" style="color: #5ca7f5">隐藏任务</a></strong></p>
                                                <p class="fpgl-td-rw">
                                                    <strong>发布时间：</strong>2017/07/16 18:53</p>
                                            </center>
                                        </td>
                                        <td>
                                                <p class="fpgl-td-mtop">
                                                    <input onclick="CancelTask(&#39;S6588002684&#39;)" class="input-butto100-xls" type="button" value="取消任务"></p>
                                                <p class="fpgl-td-mtop">
                                                    <input onclick="ShowTask(&#39;S6588002684&#39;)" class="input-butto100-xhs" type="button" value="显示任务"></p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p class="fpgl-td-rw">
                                                任务编号：S6588002685 </p>
                                            <p class="fpgl-td-rw">
                                                流量入口：淘宝APP自然搜索</p>
                                            <p class="fpgl-td-rw">
                                                任务类型：无线端</p>
                                            <p class="fpgl-td-rw">
                                                佣金：1.30</p>
                                        </td>
                                        <td class="fpgl-td-zs">
                                            <p class="fpgl-td-rw">
                                                商品简称：糖果色包
                                            </p>
                                            <p class="fpgl-td-rw">
                                                商品ID：554949688598</p>
                                            <p class="fpgl-td-rw">
                                                掌柜号：sandyjack旗舰店</p>
                                        </td>
                                        <td class="fpgl-td-zs" style="word-break: break-all">
                                            <center>
                                                <p class="fpgl-td-rw">
                                                    关键字：真皮女包</p>
                                                    <p class="fpgl-td-rw">
                                                        增值服务：                                                            <label>
                                                                旺旺咨询</label>
                                                    </p>
                                                <p class="fpgl-td-rw" style="text-align: center; font-weight: bold">
                                                </p>
                                            </center>
                                        </td>
                                        <td class="fpgl-td-zs" style="word-break: break-all">
                                            <center>
                                                <p class="fpgl-td-rw" style="text-align: center">
                                                    <strong><a href="javascript:void(0)" onclick="ShowOptLog(&#39;S6588002685&#39;)" style="color: #5ca7f5">隐藏任务</a></strong></p>
                                                <p class="fpgl-td-rw">
                                                    <strong>发布时间：</strong>2017/07/16 18:53</p>
                                            </center>
                                        </td>
                                        <td>
                                                <p class="fpgl-td-mtop">
                                                    <input onclick="CancelTask(&#39;S6588002685&#39;)" class="input-butto100-xls" type="button" value="取消任务"></p>
                                                <p class="fpgl-td-mtop">
                                                    <input onclick="ShowTask(&#39;S6588002685&#39;)" class="input-butto100-xhs" type="button" value="显示任务"></p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p class="fpgl-td-rw">
                                                任务编号：S6588002687 </p>
                                            <p class="fpgl-td-rw">
                                                流量入口：淘宝APP自然搜索</p>
                                            <p class="fpgl-td-rw">
                                                任务类型：无线端</p>
                                            <p class="fpgl-td-rw">
                                                佣金：1.30</p>
                                        </td>
                                        <td class="fpgl-td-zs">
                                            <p class="fpgl-td-rw">
                                                商品简称：糖果色包
                                            </p>
                                            <p class="fpgl-td-rw">
                                                商品ID：554949688598</p>
                                            <p class="fpgl-td-rw">
                                                掌柜号：sandyjack旗舰店</p>
                                        </td>
                                        <td class="fpgl-td-zs" style="word-break: break-all">
                                            <center>
                                                <p class="fpgl-td-rw">
                                                    关键字：真皮女包</p>
                                                    <p class="fpgl-td-rw">
                                                        增值服务：                                                            <label>
                                                                旺旺咨询</label>
                                                    </p>
                                                <p class="fpgl-td-rw" style="text-align: center; font-weight: bold">
                                                </p>
                                            </center>
                                        </td>
                                        <td class="fpgl-td-zs" style="word-break: break-all">
                                            <center>
                                                <p class="fpgl-td-rw" style="text-align: center">
                                                    <strong><a href="javascript:void(0)" onclick="ShowOptLog(&#39;S6588002687&#39;)" style="color: #5ca7f5">隐藏任务</a></strong></p>
                                                <p class="fpgl-td-rw">
                                                    <strong>发布时间：</strong>2017/07/16 18:53</p>
                                            </center>
                                        </td>
                                        <td>
                                                <p class="fpgl-td-mtop">
                                                    <input onclick="CancelTask(&#39;S6588002687&#39;)" class="input-butto100-xls" type="button" value="取消任务"></p>
                                                <p class="fpgl-td-mtop">
                                                    <input onclick="ShowTask(&#39;S6588002687&#39;)" class="input-butto100-xhs" type="button" value="显示任务"></p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p class="fpgl-td-rw">
                                                任务编号：S6588002693 </p>
                                            <p class="fpgl-td-rw">
                                                流量入口：淘宝APP自然搜索</p>
                                            <p class="fpgl-td-rw">
                                                任务类型：无线端</p>
                                            <p class="fpgl-td-rw">
                                                佣金：1.30</p>
                                        </td>
                                        <td class="fpgl-td-zs">
                                            <p class="fpgl-td-rw">
                                                商品简称：糖果色包
                                            </p>
                                            <p class="fpgl-td-rw">
                                                商品ID：554949688598</p>
                                            <p class="fpgl-td-rw">
                                                掌柜号：sandyjack旗舰店</p>
                                        </td>
                                        <td class="fpgl-td-zs" style="word-break: break-all">
                                            <center>
                                                <p class="fpgl-td-rw">
                                                    关键字：真皮女包</p>
                                                    <p class="fpgl-td-rw">
                                                        增值服务：                                                            <label>
                                                                旺旺咨询</label>
                                                    </p>
                                                <p class="fpgl-td-rw" style="text-align: center; font-weight: bold">
                                                </p>
                                            </center>
                                        </td>
                                        <td class="fpgl-td-zs" style="word-break: break-all">
                                            <center>
                                                <p class="fpgl-td-rw" style="text-align: center">
                                                    <strong><a href="javascript:void(0)" onclick="ShowOptLog(&#39;S6588002693&#39;)" style="color: #5ca7f5">隐藏任务</a></strong></p>
                                                <p class="fpgl-td-rw">
                                                    <strong>发布时间：</strong>2017/07/16 18:53</p>
                                            </center>
                                        </td>
                                        <td>
                                                <p class="fpgl-td-mtop">
                                                    <input onclick="CancelTask(&#39;S6588002693&#39;)" class="input-butto100-xls" type="button" value="取消任务"></p>
                                                <p class="fpgl-td-mtop">
                                                    <input onclick="ShowTask(&#39;S6588002693&#39;)" class="input-butto100-xhs" type="button" value="显示任务"></p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p class="fpgl-td-rw">
                                                任务编号：S6588002694 </p>
                                            <p class="fpgl-td-rw">
                                                流量入口：淘宝APP自然搜索</p>
                                            <p class="fpgl-td-rw">
                                                任务类型：无线端</p>
                                            <p class="fpgl-td-rw">
                                                佣金：1.30</p>
                                        </td>
                                        <td class="fpgl-td-zs">
                                            <p class="fpgl-td-rw">
                                                商品简称：糖果色包
                                            </p>
                                            <p class="fpgl-td-rw">
                                                商品ID：554949688598</p>
                                            <p class="fpgl-td-rw">
                                                掌柜号：sandyjack旗舰店</p>
                                        </td>
                                        <td class="fpgl-td-zs" style="word-break: break-all">
                                            <center>
                                                <p class="fpgl-td-rw">
                                                    关键字：真皮女包</p>
                                                    <p class="fpgl-td-rw">
                                                        增值服务：                                                            <label>
                                                                旺旺咨询</label>
                                                    </p>
                                                <p class="fpgl-td-rw" style="text-align: center; font-weight: bold">
                                                </p>
                                            </center>
                                        </td>
                                        <td class="fpgl-td-zs" style="word-break: break-all">
                                            <center>
                                                <p class="fpgl-td-rw" style="text-align: center">
                                                    <strong><a href="javascript:void(0)" onclick="ShowOptLog(&#39;S6588002694&#39;)" style="color: #5ca7f5">隐藏任务</a></strong></p>
                                                <p class="fpgl-td-rw">
                                                    <strong>发布时间：</strong>2017/07/16 18:53</p>
                                            </center>
                                        </td>
                                        <td>
                                                <p class="fpgl-td-mtop">
                                                    <input onclick="CancelTask(&#39;S6588002694&#39;)" class="input-butto100-xls" type="button" value="取消任务"></p>
                                                <p class="fpgl-td-mtop">
                                                    <input onclick="ShowTask(&#39;S6588002694&#39;)" class="input-butto100-xhs" type="button" value="显示任务"></p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p class="fpgl-td-rw">
                                                任务编号：S6588002696 </p>
                                            <p class="fpgl-td-rw">
                                                流量入口：淘宝APP自然搜索</p>
                                            <p class="fpgl-td-rw">
                                                任务类型：无线端</p>
                                            <p class="fpgl-td-rw">
                                                佣金：1.30</p>
                                        </td>
                                        <td class="fpgl-td-zs">
                                            <p class="fpgl-td-rw">
                                                商品简称：糖果色包
                                            </p>
                                            <p class="fpgl-td-rw">
                                                商品ID：554949688598</p>
                                            <p class="fpgl-td-rw">
                                                掌柜号：sandyjack旗舰店</p>
                                        </td>
                                        <td class="fpgl-td-zs" style="word-break: break-all">
                                            <center>
                                                <p class="fpgl-td-rw">
                                                    关键字：真皮女包</p>
                                                    <p class="fpgl-td-rw">
                                                        增值服务：                                                            <label>
                                                                旺旺咨询</label>
                                                    </p>
                                                <p class="fpgl-td-rw" style="text-align: center; font-weight: bold">
                                                </p>
                                            </center>
                                        </td>
                                        <td class="fpgl-td-zs" style="word-break: break-all">
                                            <center>
                                                <p class="fpgl-td-rw" style="text-align: center">
                                                    <strong><a href="javascript:void(0)" onclick="ShowOptLog(&#39;S6588002696&#39;)" style="color: #5ca7f5">隐藏任务</a></strong></p>
                                                <p class="fpgl-td-rw">
                                                    <strong>发布时间：</strong>2017/07/16 18:53</p>
                                            </center>
                                        </td>
                                        <td>
                                                <p class="fpgl-td-mtop">
                                                    <input onclick="CancelTask(&#39;S6588002696&#39;)" class="input-butto100-xls" type="button" value="取消任务"></p>
                                                <p class="fpgl-td-mtop">
                                                    <input onclick="ShowTask(&#39;S6588002696&#39;)" class="input-butto100-xhs" type="button" value="显示任务"></p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p class="fpgl-td-rw">
                                                任务编号：S6588002697 </p>
                                            <p class="fpgl-td-rw">
                                                流量入口：淘宝APP自然搜索</p>
                                            <p class="fpgl-td-rw">
                                                任务类型：无线端</p>
                                            <p class="fpgl-td-rw">
                                                佣金：1.30</p>
                                        </td>
                                        <td class="fpgl-td-zs">
                                            <p class="fpgl-td-rw">
                                                商品简称：糖果色包
                                            </p>
                                            <p class="fpgl-td-rw">
                                                商品ID：554949688598</p>
                                            <p class="fpgl-td-rw">
                                                掌柜号：sandyjack旗舰店</p>
                                        </td>
                                        <td class="fpgl-td-zs" style="word-break: break-all">
                                            <center>
                                                <p class="fpgl-td-rw">
                                                    关键字：真皮女包</p>
                                                    <p class="fpgl-td-rw">
                                                        增值服务：                                                            <label>
                                                                旺旺咨询</label>
                                                    </p>
                                                <p class="fpgl-td-rw" style="text-align: center; font-weight: bold">
                                                </p>
                                            </center>
                                        </td>
                                        <td class="fpgl-td-zs" style="word-break: break-all">
                                            <center>
                                                <p class="fpgl-td-rw" style="text-align: center">
                                                    <strong><a href="javascript:void(0)" onclick="ShowOptLog(&#39;S6588002697&#39;)" style="color: #5ca7f5">隐藏任务</a></strong></p>
                                                <p class="fpgl-td-rw">
                                                    <strong>发布时间：</strong>2017/07/16 18:53</p>
                                            </center>
                                        </td>
                                        <td>
                                                <p class="fpgl-td-mtop">
                                                    <input onclick="CancelTask(&#39;S6588002697&#39;)" class="input-butto100-xls" type="button" value="取消任务"></p>
                                                <p class="fpgl-td-mtop">
                                                    <input onclick="ShowTask(&#39;S6588002697&#39;)" class="input-butto100-xhs" type="button" value="显示任务"></p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p class="fpgl-td-rw">
                                                任务编号：S6588002698 </p>
                                            <p class="fpgl-td-rw">
                                                流量入口：淘宝APP自然搜索</p>
                                            <p class="fpgl-td-rw">
                                                任务类型：无线端</p>
                                            <p class="fpgl-td-rw">
                                                佣金：1.30</p>
                                        </td>
                                        <td class="fpgl-td-zs">
                                            <p class="fpgl-td-rw">
                                                商品简称：糖果色包
                                            </p>
                                            <p class="fpgl-td-rw">
                                                商品ID：554949688598</p>
                                            <p class="fpgl-td-rw">
                                                掌柜号：sandyjack旗舰店</p>
                                        </td>
                                        <td class="fpgl-td-zs" style="word-break: break-all">
                                            <center>
                                                <p class="fpgl-td-rw">
                                                    关键字：真皮女包</p>
                                                    <p class="fpgl-td-rw">
                                                        增值服务：                                                            <label>
                                                                旺旺咨询</label>
                                                    </p>
                                                <p class="fpgl-td-rw" style="text-align: center; font-weight: bold">
                                                </p>
                                            </center>
                                        </td>
                                        <td class="fpgl-td-zs" style="word-break: break-all">
                                            <center>
                                                <p class="fpgl-td-rw" style="text-align: center">
                                                    <strong><a href="javascript:void(0)" onclick="ShowOptLog(&#39;S6588002698&#39;)" style="color: #5ca7f5">隐藏任务</a></strong></p>
                                                <p class="fpgl-td-rw">
                                                    <strong>发布时间：</strong>2017/07/16 18:53</p>
                                            </center>
                                        </td>
                                        <td>
                                                <p class="fpgl-td-mtop">
                                                    <input onclick="CancelTask(&#39;S6588002698&#39;)" class="input-butto100-xls" type="button" value="取消任务"></p>
                                                <p class="fpgl-td-mtop">
                                                    <input onclick="ShowTask(&#39;S6588002698&#39;)" class="input-butto100-xhs" type="button" value="显示任务"></p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p class="fpgl-td-rw">
                                                任务编号：S6588002703 </p>
                                            <p class="fpgl-td-rw">
                                                流量入口：淘宝APP自然搜索</p>
                                            <p class="fpgl-td-rw">
                                                任务类型：无线端</p>
                                            <p class="fpgl-td-rw">
                                                佣金：1.30</p>
                                        </td>
                                        <td class="fpgl-td-zs">
                                            <p class="fpgl-td-rw">
                                                商品简称：糖果色包
                                            </p>
                                            <p class="fpgl-td-rw">
                                                商品ID：554949688598</p>
                                            <p class="fpgl-td-rw">
                                                掌柜号：sandyjack旗舰店</p>
                                        </td>
                                        <td class="fpgl-td-zs" style="word-break: break-all">
                                            <center>
                                                <p class="fpgl-td-rw">
                                                    关键字：真皮女包</p>
                                                    <p class="fpgl-td-rw">
                                                        增值服务：                                                            <label>
                                                                旺旺咨询</label>
                                                    </p>
                                                <p class="fpgl-td-rw" style="text-align: center; font-weight: bold">
                                                </p>
                                            </center>
                                        </td>
                                        <td class="fpgl-td-zs" style="word-break: break-all">
                                            <center>
                                                <p class="fpgl-td-rw" style="text-align: center">
                                                    <strong><a href="javascript:void(0)" onclick="ShowOptLog(&#39;S6588002703&#39;)" style="color: #5ca7f5">隐藏任务</a></strong></p>
                                                <p class="fpgl-td-rw">
                                                    <strong>发布时间：</strong>2017/07/16 18:53</p>
                                            </center>
                                        </td>
                                        <td>
                                                <p class="fpgl-td-mtop">
                                                    <input onclick="CancelTask(&#39;S6588002703&#39;)" class="input-butto100-xls" type="button" value="取消任务"></p>
                                                <p class="fpgl-td-mtop">
                                                    <input onclick="ShowTask(&#39;S6588002703&#39;)" class="input-butto100-xhs" type="button" value="显示任务"></p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p class="fpgl-td-rw">
                                                任务编号：S6588002705 </p>
                                            <p class="fpgl-td-rw">
                                                流量入口：淘宝APP自然搜索</p>
                                            <p class="fpgl-td-rw">
                                                任务类型：无线端</p>
                                            <p class="fpgl-td-rw">
                                                佣金：1.30</p>
                                        </td>
                                        <td class="fpgl-td-zs">
                                            <p class="fpgl-td-rw">
                                                商品简称：糖果色包
                                            </p>
                                            <p class="fpgl-td-rw">
                                                商品ID：554949688598</p>
                                            <p class="fpgl-td-rw">
                                                掌柜号：sandyjack旗舰店</p>
                                        </td>
                                        <td class="fpgl-td-zs" style="word-break: break-all">
                                            <center>
                                                <p class="fpgl-td-rw">
                                                    关键字：真皮女包</p>
                                                    <p class="fpgl-td-rw">
                                                        增值服务：                                                            <label>
                                                                旺旺咨询</label>
                                                    </p>
                                                <p class="fpgl-td-rw" style="text-align: center; font-weight: bold">
                                                </p>
                                            </center>
                                        </td>
                                        <td class="fpgl-td-zs" style="word-break: break-all">
                                            <center>
                                                <p class="fpgl-td-rw" style="text-align: center">
                                                    <strong><a href="javascript:void(0)" onclick="ShowOptLog(&#39;S6588002705&#39;)" style="color: #5ca7f5">隐藏任务</a></strong></p>
                                                <p class="fpgl-td-rw">
                                                    <strong>发布时间：</strong>2017/07/16 18:53</p>
                                            </center>
                                        </td>
                                        <td>
                                                <p class="fpgl-td-mtop">
                                                    <input onclick="CancelTask(&#39;S6588002705&#39;)" class="input-butto100-xls" type="button" value="取消任务"></p>
                                                <p class="fpgl-td-mtop">
                                                    <input onclick="ShowTask(&#39;S6588002705&#39;)" class="input-butto100-xhs" type="button" value="显示任务"></p>
                                        </td>
                                    </tr>
                            </tbody></table>
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
            <a href="javascript:" onclick="prePage(&#39;/Fine/VTrafficTask/TaskIndex?sz=1&#39;,0,3)">
            </a>
        </p>
        <p style="margin-left: 5px; margin-right: 5px;">1/3</p>
        <p class="yyzx_3">
            <a href="javascript:" onclick="nextPage(&#39;/Fine/VTrafficTask/TaskIndex?sz=1&#39;,2,3)">
            </a>
        </p>
        <p style="margin-left: 12px; margin-right: 8px;">
            <input type="text" name="PageIndex" class="input_58" id="PageIndex" value="1" onkeyup="value=value.replace(/[^0-9]/g,&#39;&#39;);submitPage(event,3)" maxlength="9">
        </p>
        <p class="ymfw-right-zgj_7">
            <a href="javascript:" id="paRedirect" onclick="redirectPage(&#39;/Fine/VTrafficTask/TaskIndex?sz=1&#39;,3)">
                跳转</a></p>
    </div>
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
    $(document).ready(function () {
        var loginName='霆宇包包';
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