<!DOCTYPE html>
<!-- saved from url=(0055)https://qqq.wkquan.com/Member/PlatformNOAssistant/Index -->
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title></title>
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="renderer" content="webkit">
    <script src="style/jquery-1.8.3.js" type="text/javascript"></script>
    <script src="style/jquery.jslides.js" type="text/javascript"></script>
    <script src="style/open.win.js" type="text/javascript"></script>
    <script src="style/jquery.vticker-min.js" type="text/javascript"></script>
    <link href="style/common.css" rel="stylesheet" type="text/css">
    <link href="style/index.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="style/open.win.css">
    <link rel="stylesheet" type="text/css" href="style/custom.css">
    <link rel="stylesheet" type="text/css" href="style/orderlist.css">
  
    <script language="javascript" type="text/javascript">
        $(document).ready(function () {
            var memberType='商家'
            if(memberType!="商家")
            {
              $("#aOut").click();
            }
        
            GetOANum();
            GetNoReadCnt();//未读工单数量提醒
            
            $(window).load(function(){
               // GetOnLine();//在线/离线
          
                GetSetOutNum();//未发货数量提醒

                GetNeedUpfileBase();//未到账反馈数量
            });
            
            
        });

        //未发货数量提醒
        function GetSetOutNum(){
          $.ajax({
                type: "get",
                cache:false,
                url: "/Home/GetSetOutNum",
                dataType: "json",
                error: function (XmlHttpRequest, textStatus, errorThrown) {
                    //alert("error GetSetOutNum:"+XmlHttpRequest.responseText);
                },
                success: function (data) {
                    if (parseInt(data) >0) {
                   var msg="您有" + data + "个任务已获得运单号,可进行发货了,请及时按流程发货!";
                     $("#sp").text("温馨提示: ");
                     $("#title").text(msg);
                     $("#title").attr("href","/Shop/Task/TaskIndex?status=2");
                    }
                }
            });
        }

        //在线/离线
        function GetOnLine() {
            $.ajax({
                type: "get",
                cache:false,
                url: "/Home/UpdateOnLine",
                data:{flag: 2 },
                dataType: "json",
                error: function (XmlHttpRequest, textStatus, errorThrown) {
                    //alert("error GetOnLine:"+XmlHttpRequest.responseText);
                },
                success: function (data) {
                
                    if (data == "True") {
                        //$("#pStatus").text("显示任务");
                        //$("#selectStatus").text("隐藏任务");
                        //$("#imgs").attr("src", '/Content/images/Online.png');
//                        $("#Seleline").val('1');
                  var div2 = document.getElementById("No_x1");
                   var div1 = document.getElementById("Open_x1");
                   //$("#sxyc").html("显示任务 :");
                    div1.className = "close1";
                    div2.className = "close2";
                    $("#sxyc").removeClass("add");
                    $("#sxyc").addClass("add1");
                    }
                    else {
                        //$("#pStatus").text("隐藏任务");
                        //$("#selectStatus").text("显示任务");
                        //$("#imgs").attr("src", '/Content/images/unOnline.png');
//                        $("#Seleline").val('2');
                   var div2 = document.getElementById("No_x1");
                    var div1 = document.getElementById("Open_x1");
                    //$("#sxyc").html("隐藏任务 :");
                    div1.className = "open1";
                    div2.className = "open2";
                    $("#sxyc").removeClass("add1");
                    $("#sxyc").addClass("add");
                    }
                }
            });
        }


        //编辑在线/离线
        function UpdateOnLine() {
            var div2 = document.getElementById("No_x1");
            var div1 = document.getElementById("Open_x1");
            $.ajax({
                type: "get",
                cache:false,
                url: "/Home/UpdateOnLine",
                data:{flag: 1 },
                dataType: "json",
                error: function (XmlHttpRequest, textStatus, errorThrown) {
                    //alert("error UpdateOnLine:"+XmlHttpRequest.responseText);
                },
                success: function (data) {
                    if (data == "True") {
                        //$("#sxyc").html("显示任务 :");
                        div1.className = "close1";
                        div2.className = "close2";
                        $("#sxyc").removeClass("add");
                        $("#sxyc").addClass("add1");
                        $.openAlter('亲，您当前处于“在线”状态，您所发布的销量任务将会正常被接手。', '提示', { width: 250, height: 50 }, null, "好的");
                    }
                    else if(data == "False"){
                        //$("#sxyc").html("隐藏任务 :");
                        div1.className = "open1";
                        div2.className = "open2";
                        $("#sxyc").removeClass("add1");
                        $("#sxyc").addClass("add");
                        $.openAlter('亲，您当前处于“隐身”状态。您所发布的销量任务将<span style="color:red">全部被系统隐藏</span>，买手将<span style="color:red">无法接手您发布的任务</span>。如有疑问请咨询客服QQ：800186664', '提示', { width: 250, height: 50 }, null, "好的");
                    }else if(data == "存在超时未转账订单"){
                        $.openAlter('亲，您未在转账截止时间内对“等待转账”的<br/>提现申请进行转账，系统自动将您的状态调为<br/><span style="color:red">隐藏任务</span>，不可恢复<span style="color:red">显示任务</span>状态。请立即<br/>进行转账处理。'
                        , '提示', { width: 250, height: 50 }
                        , function(){ self.parent.location = "/Shop/TransferManagement";}, "立即转账");  
                    }
                    else if(data == "存在超时未上传凭证的订单"){
                         $.openAlter('亲，您存在<span style="color:red">超时未上凭传证</span>的订单，系统已将<br/>您的状态调为“<span style="color:red">隐藏任务</span>”，不可恢复“显示<br/>任务”状态。请上传凭证后再对状态进行调<br/>整。'
                        , '提示', { width: 250, height: 50 }
                        , function(){ self.parent.location = "/Shop/TransferManagement/BackResult";}, "立即上传");  
                    }
                    else{
                        $.openAlter(data, '提示', { width: 250, height: 50 }, null, "好的");
                    }
                }
            });

        }


        function GetLine()
        {   
             var val=$("#Seleline").val();
             UpdateOnLine();
             
        }
        //未读工单提醒
        function GetNoReadCnt(){
            $.ajax({
                type: "get",
                cache:false,
                url: "/Home/GetNoReadCnt",
                dataType: "json",
                error: function (XmlHttpRequest, textStatus, errorThrown) {
                    //alert("error GetNoReadCnt:"+XmlHttpRequest.responseText);
                },
                success: function (data) {
                    if(data!=0){
         
                        var info='客服工单<strong><font color="#ff9900">('+data+')</font></strong>';
                        $("#Schedual").html(info);
                    }
                }
            });
        }
        function GetOANum()
        {
           $.post('/Fine/VTaskQA/GetQANum',{},function(result){
          if(result>0)
          {
             var info='评价任务<strong><font color=red>('+result+')</font></strong>';
             $("#VMVipTask a:eq(3)").html(info);
          }
           },"json");
        }
        function vipTask()
        {
           var submit = function (v, h, f) {
                    if (v == true)
                    {
                      location.href="/Fine/VMTask";
                     }
                    else
                     {
                          location.href="/Shop/VipTask/VipTaskOne";
                     }
                      return true;
                    };
                  // 自定义按钮
                     jBox.confirm("精刷任务已上线，真实买家，一人一号，永不复购，你不体验一下吗？", "温馨提示", submit, { id: 'hahaha', top: 250,draggable:false, buttons: { '马上体验': true, '下次再说': false} });
                     return false;
        }

        function tryVTrafficTask()
        {
            $.openConfirm(
            '<div style="text-align:left">经过观察发现，现在机器导入的流量已经不能给商品带来任何权重，而且流量的数据异常还有可能引起系统的排查。为了保障各位卖家用户的店铺安全，我们决定从即日起关闭通过机器导入的流量配合业务。如果需要流量配合的卖家，建议选择我们的淘宝APP人工流量。</div>'
            , '温馨提示'
            , { width: 250, height: 50 }
            , function () { location.href="/Fine/VTrafficTask"; }, "现在去试试"
            , function () { location.href="http://qqq.wkquan.com/Other/Content/NNewsInfo?id=68"; }, "了解详情"
            );
            return false;
        }

        function GetNeedUpfileBase(){
            $.ajax({
                type: "get",
                cache: false,
                url: "/Shop/TransferManagement/GetNeedUpfile",
                dataType: "json",
                error: function (XmlHttpRequest, textStatus, errorThrown) {
                    //alert("error GetNoReadCnt:"+XmlHttpRequest.responseText);
                },
                success: function (data) {
                    if(data!=null){
                        if(data!=0)
                        {
                            var info='转账管理<strong><font color=red> ( '+data+ ' ) </font></strong>';
                            $("#transferManagement a").html(info);
                        }
                    }
                }
            });
        }
    </script>
    <script type="text/javascript">
        $(function () {
            var div2 = document.getElementById("No_x1");
            var div1 = document.getElementById("Open_x1");
            $("#liVipTask").click(function () {
                location.href="/Shop/VipTask/VipTaskOne?flag=1"; 
                 return false;
            });
            $("#No_x1").click(function () {
                UpdateOnLine();
                //                if (div1.className == "open1") {
                //                    $("#sxyc").removeClass("add");
                //                    $("#sxyc").addClass("add1");
                //                    div1.className = "close1";
                //                    div2.className = "close2";

                //                }
                //                else {
                //                    $("#sxyc").removeClass("add1");
                //                    $("#sxyc").addClass("add");
                //                    div1.className = "open1";
                //                    div2.className = "open2";
                //                }
            });
        });
    </script>


    
    
    <script type="text/javascript" src="style/WdatePicker.js"></script><link href="style/WdatePicker.css" rel="stylesheet" type="text/css">
    <script src="style/jquery.kinMaxShow.min.js" type="text/javascript"></script>
    <script src="style/jquery-1.8.3.js" type="text/javascript"></script>
    <script src="style/jquery.jBox-2.3.min.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="style/jbox.css">
    <script src="style/jquery.jslides.js" type="text/javascript"></script>
    <script src="style/open.win.js(1)" type="text/javascript"></script>
    <link href="style/open.win(1).css" rel="stylesheet" type="text/css">
    <script src="style/laydate.js" type="text/javascript"></script><link type="text/css" rel="stylesheet" href="style/laydate.css"><link type="text/css" rel="stylesheet" href="style/laydate(1).css" id="LayDateSkin">

    <script language="javascript" type="text/javascript">
       $(document).ready(function () {
            $(".sj-nav li a").removeAttr("style");
            $("#NewMember").addClass("#NewMember");
            $("#PlatformNOAssistant").addClass("a_on");

            $("#search").click(function(){
              if($("#BeginDate").val()==""&&$("#EndDate").val()=="")
              {
                  $.openAlter("请选择下单时间。", "提示");
              }
              else{
                $('#fm').submit(); //提交表单
                }
            })
        })

        function ShowPlatformNOAssistan(PlatformNoID,PlatformType) {
            if(PlatformType=='淘宝')
            {
                $.openWin(450, 550, '/Member/PlatformNOAssistant/TBShowPlatformNOAssistant?platformNoID=' + PlatformNoID+"&platformType=" + PlatformType);
            }
            else
                $.openWin(450, 550, '/Member/PlatformNOAssistant/ShowPlatformNOAssistant?platformNoID=' + PlatformNoID+"&platformType=" + PlatformType);
        
        }

        function ShowFlagRemark(PlatformNoID,PlatformType) {
          $.openWin(480, 550, '/Member/PlatformNOAssistant/AddFlagRemark?platformNoID=' + PlatformNoID+"&platformType=" + PlatformType);
        }
        function AddPlatformNOAssistant(PlatformNoID, time,PlatformType) {
         if(PlatformType=='淘宝')
            $.openWin(430, 550, '/Member/PlatformNOAssistant/TBAddPlatformNOAssistant?platformNoID='+ PlatformNoID + "&time=" + time+"&platformType=" + PlatformType);
         else
            $.openWin(430, 550, '/Member/PlatformNOAssistant/AddPlatformNOAssistant?platformNoID='+ PlatformNoID + "&time=" + time+"&platformType=" + PlatformType);
        }
        function ShowMsg()
        {
            $.openAlter("请联系商家顾问完成智能助手的授权操作","提示");
        }
        function OpenMsg() {
            $.openWin(200,350, '/Member/PlatformNOAssistant/MsgInfo');
//            var submit = function (v, h, f) {
//                if (v == true) {
//                    window.location.href = window.location.href;
//                }
//                else {
//                    window.location.href = window.location.href;
//                }
//                return true;
//            };

//            jBox.confirm("您是否授权成功？", "提示", submit, { id: 'hahaha', showScrolling: true, top: '15%', buttons: { '授权成功': true, '授权遇到问题': false} });

        }


         //导出
        function ToExcel()
       {
           $("#exporting").show();
           $("#export").hide();
            var beginDate = $("#BeginDate").val();
            var endDate = $("#EndDate").val();
            var FlagResult=$("#FlagResult").val();
            var Condition=$("#Condition").val();
            var ConditionValue=$("#ConditionValue").val();
            $.ajax({
                    type: "post",
                    url: "/Member/PlatformNOAssistant/ToExcel",
                    dataType: "text",
                    data: { beginDate: beginDate, endDate: endDate,FlagResult:FlagResult,Condition:Condition,ConditionValue:ConditionValue},
                    error: function (XmlHttpRequest, textStatus, errorThrown) {
                        var $errorPage = XmlHttpRequest.responseText;
                        //                    alert($($errorPage).text());
                        alert($errorPage);
                        $("#exporting").hide();
                        $("#export").show();
                    },
                    success: function (data) {
                        if (data.split(':')[0] == "0") {
                            $("#exporting").hide();
                            $("#export").show();
                            window.location = '/UploadFile/Office/Export/'+data.split(':')[1];
                        } else {
                         
                             $.openAlter(data.split(':')[1],"提示");
                            $("#exporting").hide();
                            $("#export").show();
                        }
                    }
                });
       }
    </script>


</head>
<body style="background: #fff;"><div style="position: absolute; z-index: 19700; top: -1970px; left: -1970px; display: none;"><iframe src="style/My97DatePicker.html" frameborder="0" border="0" scrolling="no" style="width: 186px; height: 199px;"></iframe></div>
    <!--[if lt IE 8]>

<script language="javascript" type="text/javascript">
$.openAlter('<div style="font-size:18px;text-align:left;line-height:30px;">hi,你当前的浏览器版本过低，可能存在安全风险，建议升级浏览器：<div><div style="margin-top:10px;color:red;font-weight:800;">谷歌Chrome&nbsp;&nbsp;,&nbsp;&nbsp;UC浏览器</div>', "提示", { width: 250, height: 50 });
$("#ow_alter002_close").remove();
</script>
<![endif]-->
    <div class="index_top">
        <div class="index_top_1">
            
            <!-- 头部 -->
            
            <p class="left">
                <img src="style/logo.png"></p>
            <div id="news-container1" class="notice">
                <!--   <font class="notice_num">2</font> -->
                <ul>
                    <li>9月21日起，平台所有数据只保留<em>50</em>天，超时将永久删除，请提前做好对账工作。</li>
                
                </ul>
                <!-- <a href="" class="next"></a> -->
            </div>
            <div class="kaiguan">
                    <div id="sxyc" class="add">
                        <div class="cssPrompt">
                            <em></em>亲，您当前处于隐身状态，所发布的销量任务全部被系统隐藏，买手无法接手！
                        </div>
                        <div class="cssPrompt1">
                            <em></em>亲，您当前处于在线状态，所发布的销量任务能正常被买手接手。
                        </div>
                    </div>
                    <div id="Open_x1" class="open1">
                        <div id="No_x1" class="open2">
                        </div>
                    </div>
                <span class="csshuiyuan"><a href="javascript:void(0)"><b>霆宇包包</b></a><a id="aOut" href="javascript:void(0)" onclick="javascript:location=&#39;/Login/LogOut&#39;">退出</a></span>
            </div>
            <marquee id="mqs" direction="Left" scrollamount="4">
   <span style="color:Red" id="sp"> </span><span style="color:White"><a id="title" style="color:White"></a> </span> 
         </marquee>
            <!-- 头部 -->
               
        </div>
    </div>
    
    <!--daohang-->
    <div class="cpcenter">
        <div class="lside container">
            <ul class="cpmenulist">
                <li><a href="https://qqq.wkquan.com/Home/ShopIndex" id="ShopIndex">首页</a></li>
                <li id="VMVipTask"><a>销量任务管理</a><em></em>
                    <ul>
                        <li><a href="https://qqq.wkquan.com/Fine/VMTask/Index">发布任务</a></li>
                        <li><a href="https://qqq.wkquan.com/Fine/VTask/Index">任务管理</a></li>
                        <li><a href="https://qqq.wkquan.com/Fine/VEvaluateTask/Index">评价管理</a></li>
                    </ul>
                </li>
                <li><a id="VipTask">日常任务管理</a><em></em>
                    <ul>
                        <li id="liVipTask"><a href="https://qqq.wkquan.com/Shop/VipTask/VipTaskOne">发布任务</a></li>
                        <li><a href="https://qqq.wkquan.com/Shop/Task/TaskIndex">发布管理</a></li>
                    </ul>
                </li>
                    <li><a id="TaskApp">淘宝APP点击</a><em></em>
                        <ul>
                            <li><a href="https://qqq.wkquan.com/Fine/VTrafficTask/Index">发布流量任务</a></li>
                            <li><a href="https://qqq.wkquan.com/Fine/VTrafficTask/TaskIndex">流量任务管理</a></li>
                        </ul>
                    </li> 
                <li><a id="ShopPay">资金管理</a><em></em>
                    <ul>
                        <li><a href="https://qqq.wkquan.com/Shop/InCome/NewIncomeIndex">账号充值</a></li>
                        <li id="transferManagement"><a href="https://qqq.wkquan.com/Shop/TransferManagement/Index">转账管理</a>
                        </li>
                        <li><a href="https://qqq.wkquan.com/Member/MemberInfo/ShopMemberDuiHuan">发布点兑换</a></li>
                        <li><a href="https://qqq.wkquan.com/Member/MemberInfo/ShopGetRecordList">资金管理</a></li>
                        <li><a href="https://qqq.wkquan.com/Member/MemberInfo/FShopPayList">订单信息</a></li>
                    </ul>
                </li>
                <li><a id="NewMember" class="#NewMember">会员中心</a><em></em>
                    <ul>
                        <li><a href="https://qqq.wkquan.com/Member/MemberInfo/NewMemberInfo" id="NewMemberInfo">基本资料</a></li>
                        <li><a href="https://qqq.wkquan.com/Member/PlatformNOAssistant/Index">智能助手</a></li>
                        <li><a href="https://qqq.wkquan.com/Shop/PlatformNo/Index">店铺管理</a></li>
                        <li><a href="https://qqq.wkquan.com/Shop/Product/ProductIndex">商品管理</a></li>
                        
                        <li><a href="https://qqq.wkquan.com/Other/Content/NewContentIndex">平台公告</a></li>
                        <li><a href="https://qqq.wkquan.com/Shop/PlatformNo/PublishNumIndex">调整单量</a>
                        </li>
                    </ul>
                </li>
                <li><a href="https://qqq.wkquan.com/NewSchedual/NewSchedual/SchedualList" id="Schedual">客服工单</a></li>
            </ul>
        </div>
    </div>
    <!--daohang-->
    
    <div class="sj-zjgl">
        <div class="zjgl-left">
            <h2 style="background: url(/Content/new_content/images/hygl.png no-repeat 22px 22px;">
                会员中心</h2>
            <ul>
                <li><a href="https://qqq.wkquan.com/Member/MemberInfo/NewMemberInfo">基本资料</a>
                </li>
                <li><a href="https://qqq.wkquan.com/Member/PlatformNOAssistant/Index" style="background: #eee;color: #ff9900;">智能助手</a>
                </li>
                <li>
                    <a href="https://qqq.wkquan.com/Shop/PlatformNo/Index">店铺管理</a>
                </li>
                <li><a href="https://qqq.wkquan.com/Shop/Product/ProductIndex">商品管理</a>
                </li>
                
                <li><a href="https://qqq.wkquan.com/Other/Content/NewContentIndex">平台公告</a></li>
                <li><a href="https://qqq.wkquan.com/Shop/PlatformNo/PublishNumIndex">调整单量</a>
                </li>
            </ul>
        </div>
        
<form action="https://qqq.wkquan.com/Member/PlatformNOAssistant" id="fm" method="post">        <div class="sj_ktlc" style="margin-left: 15px">
            <div class="sj_h2">
                <b style="font-weight: bolder">淘宝店铺智能助手开通流程：</b></div>
            <ul class="sj_ktlc1">
                <li>【根据指示完成<br>
                    购买指定服务的操作】</li>
                <li>【选择开通时长，平台扣费。<br>
                    完成扣费后联系顾问进行对接】</li>
                <li class="mar_40">【对智能助手<br>
                    设置标记备注】</li>
            </ul>
            <div class="sj_ktlc2">
                <span class="w_160">联系商家顾问</span> <span class="w_250">点击开通</span> <span class="w_210">
                    开通成功</span> <span class="w_210">备注设置</span>
            </div>
        </div>
        <div class="zjgl-right">
            <div class="sk-hygl">
                <h2 class="fprw-pt">
                    <p class="left">
                        已绑定店铺信息</p>
                    <p class="zj-zlzs">
                        <a href="http://qqq.wkquan.com/Other/Content/NNewsInfo?id=48" target="_blank">智能助手功能介绍</a></p>
                </h2>
                <!-- 表格-->
                <div class="zjgl-right_2" style="height: 375px; margin-top: 10px; overflow: auto">
                    <table>
                        <tbody><tr>
                            <th width="70">
                                平台
                            </th>
                            <th width="280">
                                店铺名称
                            </th>
                            
                            <th width="80">
                                状态
                            </th>
                            <th width="140">
                                智能助手有效期
                            </th>
                            <th width="140">
                                接口有效期
                            </th>
                            <th width="202">
                                操作
                            </th>
                        </tr>
                            <tr>
                                <td>
                                    淘宝
                                </td>
                                <td>
                                    
                                    sandyjack旗舰店
                                </td>
                                
                                <td>
                                        <span>已开通 </span>
                                </td>
                                <td>
2017/10/29 23:59                                </td>
                                <td>
2018/01/03 14:11                                </td>
                                <td>
                                        <span>
                                            
                                            <input onclick="ShowFlagRemark(&#39;98cf9150-7a07-4446-876a-2ce62bffb36b&#39;,&#39;淘宝&#39;)" class="input-butto62-zls" type="button" value="备注设置">
                                        </span>
                                </td>
                            </tr>
                    </tbody></table>
                </div>
                <!-- 表格-->
                <h2 class="fprw-pt" style="margin-top: 20px;">
                    <p class="left">
                        订单标记反馈<em style="color: Red">(表格只展示在平台任务状态为“待发货”的订单记录)</em></p>
                </h2>
                <!-- 搜索-->
                <div class="fpgl-ss">
                    <p>
                        
                        <select class="select_185" id="Condition" name="Condition" style="width:150px;"><option value="Title">店铺名</option>
<option value="BuyerNick">买号</option>
<option value="PlatformOrderNumber">订单编号</option>
</select>
                    </p>
                    <p>
                        <input class="select_185" id="ConditionValue" name="ConditionValue" type="text" value="">
                        </p>
                    <p>
                        标记反馈：</p>
                    <p>
                        <select class="select_85" id="FlagResult" name="FlagResult"><option selected="selected" value="">请选择</option>
<option value="0">标记成功</option>
<option value="1">未标记</option>
</select>
                        
                    </p>
                    <p>
                        下单时间：</p>
                    <p>
                        <input class="laydate-icon" id="BeginDate" maxlength="16" name="BeginDate" onclick="laydate({istime: true, format: &#39;YYYY-MM-DD hh:mm&#39;})" style="width:80px;height:20px;" type="text" value="2017/10/10 16:28:44">
                        
                        </p>
                    <p>
                        <input class="laydate-icon" id="EndDate" maxlength="16" name="EndDate" onclick="laydate({istime: true, format: &#39;YYYY-MM-DD hh:mm&#39;})" style="width:80px;height:20px;" type="text" value="2017/10/20 16:28:44">
                        
                        </p>
                    <p>
                        <input class="input-butto62-azls" type="button" id="search" value="查询"></p>
                    <p style="margin-right: 0px;">
                        <input class="input-butto62-azhs" type="button" value="导出" id="export" onclick="ToExcel()"></p>
                </div>
                <!-- 搜索-->
                <!-- 表格-->
                    <div class="zjgl-right_2">
                        <table>
                            <tbody><tr>
                                <th width="230">
                                    店铺名称
                                </th>
                                <th width="140">
                                    买号
                                </th>
                                <th width="230">
                                    订单编号
                                </th>
                                <th width="140">
                                    标记反馈
                                </th>
                                <th width="140">
                                    下单时间
                                </th>
                            </tr>
                        </tbody></table>
                    </div>
                    <div>
                        <center>
                                <label class="red">
                                    没有找到相关数据</label> 
                        </center>
                    </div>
                    <div>
                    </div>
                <!-- 表格-->
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

        $.ajax({
                type: "get",
                cache:false,
                url: "/Home/GetConsultQQ",
                data:{id:loginName},
                dataType: "json",
                error: function (XmlHttpRequest, textStatus, errorThrown) {
                    
                },
                success: function (data) {
                    if(data!=""){
                        var href='http://wpa.qq.com/msgrd?v=3&uin='+data+'&site=在线客服&menu=yes';
                        $("#consultQQ").attr('href',href);
                    }
                }
            });
        $.ajax({
                type: "get",
                cache:false,
                url: "/Home/GetServiceQQ",
                dataType: "json",
                error: function (XmlHttpRequest, textStatus, errorThrown) {
                    
                },
                success: function (data) {
                    if(data!=""){
                        var href='http://wpa.qq.com/msgrd?v=3&uin='+data+'&site=在线客服&menu=yes';
                        $("#serviceQQ").attr('href',href);
                    }
                }
            });

    });
    $(window)

</script>
<div id="online_qq_layer" style="height: 50px;">
    <div id="online_qq_tab" style="margin-top: 420px;">
        <a id="floatShow" style="display: none;" href="javascript:void(0);">收缩</a> 
        <a id="floatHide" style="display: block;" href="javascript:void(0);">展开</a>
    </div>
    <div id="onlineService" style="margin-top: 420px;">
        <div class="onlineMenu">
            <h3 class="tQQ">
                QQ在线客服</h3>
            <ul>
                <li class="tli zixun">在线咨询</li>
                
                <li id="consultLi" style="height:30px"><a target="_blank" style="font-size:13px" id="consultQQ" href="http://wpa.qq.com/msgrd?v=3&amp;uin=3272369440&amp;site=%E5%9C%A8%E7%BA%BF%E5%AE%A2%E6%9C%8D&amp;menu=yes" title="点击可进行QQ交流">
                    <img width="25" height="17" border="0" align="absmiddle" style="vertical-align:text-bottom" src="style/images/qq_online.gif">&nbsp;商家顾问</a>
                </li>
                    
                <li style="height:30px"><a target="_blank" id="serviceQQ" style="font-size:13px" href="http://wpa.qq.com/msgrd?v=3&amp;uin=800186664&amp;site=%E5%9C%A8%E7%BA%BF%E5%AE%A2%E6%9C%8D&amp;menu=yes" title="点击可进行QQ交流">
                    <img width="25" height="17" border="0" align="absmiddle" style="vertical-align:text-bottom" src="style/images/qq_online.gif">&nbsp;平台客服</a>
                </li>
            </ul>
        </div>
        
        
        <div class="btmbg">
        </div>
    </div>
</div>


</body></html>