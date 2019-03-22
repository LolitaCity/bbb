<?php require_once('include/header.php')?>  
    
    <script src="<?=base_url()?>style/laydate.js" type="text/javascript"></script>
    <link type="text/css" rel="stylesheet" href="<?=base_url()?>style/laydate.css">
    <link type="text/css" rel="stylesheet" href="<?=base_url()?>style/laydate(1).css" id="LayDateSkin">
    <script language="javascript" type="text/javascript">
        $(document).ready(function () {
            $("#MemberRecord").addClass("a_on");
        })

        function selectTag(id) {
            if (id == "0")
                window.location.href = "GetRecordList";
            else if (id == "1")
                window.location.href = "QueryStatic";
            else if (id == "2")
                window.location.href = "ShopPayList";
        }

        function Search() {
            $("#fm").submit();
        }

        function Export() {
            var beginDate = $("#BeginDate").val();
            var endDate = $("#EndDate").val();
            $("#exporting").show();
            $("#export").hide();
            //window.location.href = '/Member/MemberInfo/ToExcel?BeginDate=' + start + "&EndDate=" + end;
            $.ajax({
                    type: "post",
                    url: "/Member/MemberInfo/FToExcel",
                    dataType: "text",
                    data: { BeginDate: beginDate, EndDate: endDate},
                    error: function (XmlHttpRequest, textStatus, errorThrown) {
                        var $errorPage = XmlHttpRequest.responseText;
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
                            alert(data.split(':')[1]);
                            $("#exporting").hide();
                            $("#export").show();
                        }
                    }
                });
        }
    </script>


</head>
<body style="background: #fff;">
        <?php require_once('include/nav.php')?>  
    <!--daohang-->
    
    <div class="sj-zjgl">
        <div class="zjgl-left">
            <h2 style="background: url(<?=base_url()?>/images/hygl.png) no-repeat 22px 22px;"> 资金管理</h2>
            <ul>
                <li><a href="<?=base_url('caption')?>">账号充值</a> </li>
                <li><a href="<?=base_url('caption/')?>">转账管理</a> </li>
                <li><a href="<?=base_url('caption')?>">发布点兑换</a> </li>
                <li><a href="<?=base_url('caption')?>">资金管理</a> </li>
                <li><a href="<?=base_url('caption')?>" style="background: #eee;color: #ff9900;">订单信息</a> </li>
            </ul>
        </div>
        
<form action="https://qqq.wkquan.com/Member/MemberInfo/FShopPayList" id="fm" method="post">        <div class="zjgl-right">

            <div class="errorbox" id="clientValidation" style="display: none; width: 95%; height: 25px;">
                <ol style="list-style-type: decimal" id="clientValidationOL">
                </ol>
            </div>
            <div class="menu">
                <ul>
                  <a href="https://qqq.wkquan.com/Member/MemberInfo/FShopPayList">
                            <li class="off">销量任务订单详情信息</li></a>
                    <a href="https://qqq.wkquan.com/Member/MemberInfo/ShopPayList">
                      <li>日常单订单详情信息</li></a> 
                            <a href="https://qqq.wkquan.com/Member/MemberInfo/WxShopTaskCountList">
                                <li>流量任务详情信息</li></a>
                </ul>
            </div>
            <div style="color: Red;">
                此表格用于记录所有销量任务已支付的订单信息</div>
                <div class="sk-hygl">
                    <div class="fpgl-ss">
                        <p>
                            统计时间：<input class="laydate-icon" id="BeginDate" maxlength="16" name="BeginDate" onclick="laydate({istime: true, format: &#39;YYYY-MM-DD hh:mm&#39;})" style="width:128px;height:34px;margin-left:5px;" type="text" value="">
                            ~
                            <input class="laydate-icon" id="EndDate" maxlength="16" name="EndDate" onclick="laydate({istime: true, format: &#39;YYYY-MM-DD hh:mm&#39;})" style="width:128px;height:34px;" type="text" value="">
                        </p>
                        <p>
                            <input class="input-butto100-ls" type="button" id="btnSearch" value="查询" onclick="Search()"></p>
                        <p>
                            <input class="input-butto100-hs" id="export" type="button" value="导出" onclick="Export()">
                            <input class="input-butto100-hs" type="button" style="display: none;" id="exporting" value="导出中,请稍后..."></p>
                    </div>
                    <div class="zjgl-right_2">
                        <table style="width: 100%;">
                            <tbody><tr>
                                <th>
                                    任务号
                                </th>
                                <th>
                                    订单编号
                                </th>
                                <th>
                                    商品简称
                                </th>
                               
                                <th>
                                    掌柜号
                                </th>
                                <th>
                                    商品ID
                                </th>
                                <th>
                                    任务类型
                                </th>
                                <th>
                                    关键字
                                </th>
                               
                                <th>
                                    实际金额
                                </th>
                                <th>
                                    发布点
                                </th>
                                <th>
                                    支付时间
                                </th>
                            </tr>
                                <tr>
                                    <td align="center">
                                        <span style="color: Red;">汇总：</span>
                                    </td>
                                    <td align="center">
                                    </td>
                                    <td align="center">
                                    </td>
                                    
                                    <td align="center">
                                    </td>
                                    <td align="center">
                                    </td>
                                    <td align="center">
                                    </td>
                                    <td align="center">
                                    </td>
                                    
                                    <td align="center">
                                        <div style="color: Red; word-break: break-all;">1668.00</div>
                                    </td>
                                    <td align="center">
                                        <div style="color: Red; word-break: break-all;">143.00</div>
                                    </td>
                                    <td align="center">
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center">
                                        <div style="width: 90px; word-break: break-all;">V6588014386</div>
                                    </td>
                                    <td align="center">
                                        <div style="width: 70px; word-break: break-all;">13270078496105140</div>
                                    </td>
                                    <td align="center">
                                        <div style="width: 50px; word-break: break-all;">撞色包</div>
                                    </td>
                                   
                                    <td align="center">
                                        <div style="width: 80px; word-break: break-all;">sandyjack旗舰店
                                        </div>
                                    </td>
                                    <td align="center">
                                        <div style="width: 80px; word-break: break-all;">548850124434
                                        </div>
                                    </td><td align="center">
                                        <div style="width: 80px; word-break: break-all;">淘宝APP自然搜索
                                        </div>
                                    </td><td align="center">
                                        <div style="width: 80px; word-break: break-all;">包包2017新款
                                        </div>
                                    </td>
                                    
                                    <td align="center">
                                        <div style="width: 50px; word-break: break-all;">258.00
                                        </div>
                                    </td>
                                    <td align="center">
                                        <div style="width: 50px; word-break: break-all;">20.00
                                        </div>
                                    </td>
                                    <td align="center">
                                        <div style="width: 70px; word-break: break-all;">2017/7/7 18:22:29
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center">
                                        <div style="width: 90px; word-break: break-all;">V6588010453</div>
                                    </td>
                                    <td align="center">
                                        <div style="width: 70px; word-break: break-all;">8106717271756741</div>
                                    </td>
                                    <td align="center">
                                        <div style="width: 50px; word-break: break-all;">撞色包</div>
                                    </td>
                                   
                                    <td align="center">
                                        <div style="width: 80px; word-break: break-all;">sandyjack旗舰店
                                        </div>
                                    </td>
                                    <td align="center">
                                        <div style="width: 80px; word-break: break-all;">548850124434
                                        </div>
                                    </td><td align="center">
                                        <div style="width: 80px; word-break: break-all;">淘宝APP自然搜索
                                        </div>
                                    </td><td align="center">
                                        <div style="width: 80px; word-break: break-all;">女包
                                        </div>
                                    </td>
                                    
                                    <td align="center">
                                        <div style="width: 50px; word-break: break-all;">258.00
                                        </div>
                                    </td>
                                    <td align="center">
                                        <div style="width: 50px; word-break: break-all;">27.00
                                        </div>
                                    </td>
                                    <td align="center">
                                        <div style="width: 70px; word-break: break-all;">2017/6/14 10:22:40
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center">
                                        <div style="width: 90px; word-break: break-all;">V6588007336</div>
                                    </td>
                                    <td align="center">
                                        <div style="width: 70px; word-break: break-all;">21539522266269711</div>
                                    </td>
                                    <td align="center">
                                        <div style="width: 50px; word-break: break-all;">撞色包</div>
                                    </td>
                                   
                                    <td align="center">
                                        <div style="width: 80px; word-break: break-all;">sandyjack旗舰店
                                        </div>
                                    </td>
                                    <td align="center">
                                        <div style="width: 80px; word-break: break-all;">548850124434
                                        </div>
                                    </td><td align="center">
                                        <div style="width: 80px; word-break: break-all;">淘宝APP自然搜索
                                        </div>
                                    </td><td align="center">
                                        <div style="width: 80px; word-break: break-all;">斜挎包女
                                        </div>
                                    </td>
                                    
                                    <td align="center">
                                        <div style="width: 50px; word-break: break-all;">288.00
                                        </div>
                                    </td>
                                    <td align="center">
                                        <div style="width: 50px; word-break: break-all;">27.00
                                        </div>
                                    </td>
                                    <td align="center">
                                        <div style="width: 70px; word-break: break-all;">2017/5/31 11:12:30
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center">
                                        <div style="width: 90px; word-break: break-all;">V6588006102</div>
                                    </td>
                                    <td align="center">
                                        <div style="width: 70px; word-break: break-all;">22192091052080271</div>
                                    </td>
                                    <td align="center">
                                        <div style="width: 50px; word-break: break-all;">撞色包</div>
                                    </td>
                                   
                                    <td align="center">
                                        <div style="width: 80px; word-break: break-all;">sandyjack旗舰店
                                        </div>
                                    </td>
                                    <td align="center">
                                        <div style="width: 80px; word-break: break-all;">548850124434
                                        </div>
                                    </td><td align="center">
                                        <div style="width: 80px; word-break: break-all;">淘宝APP自然搜索
                                        </div>
                                    </td><td align="center">
                                        <div style="width: 80px; word-break: break-all;">斜挎包女
                                        </div>
                                    </td>
                                    
                                    <td align="center">
                                        <div style="width: 50px; word-break: break-all;">288.00
                                        </div>
                                    </td>
                                    <td align="center">
                                        <div style="width: 50px; word-break: break-all;">27.00
                                        </div>
                                    </td>
                                    <td align="center">
                                        <div style="width: 70px; word-break: break-all;">2017/5/22 22:40:23
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center">
                                        <div style="width: 90px; word-break: break-all;">V6588002632</div>
                                    </td>
                                    <td align="center">
                                        <div style="width: 70px; word-break: break-all;">9059620555490108</div>
                                    </td>
                                    <td align="center">
                                        <div style="width: 50px; word-break: break-all;">撞色包</div>
                                    </td>
                                   
                                    <td align="center">
                                        <div style="width: 80px; word-break: break-all;">sandyjack旗舰店
                                        </div>
                                    </td>
                                    <td align="center">
                                        <div style="width: 80px; word-break: break-all;">548850124434[del]
                                        </div>
                                    </td><td align="center">
                                        <div style="width: 80px; word-break: break-all;">淘宝PC自然搜索
                                        </div>
                                    </td><td align="center">
                                        <div style="width: 80px; word-break: break-all;">斜挎包女韩版2017新款 简约百搭
                                        </div>
                                    </td>
                                    
                                    <td align="center">
                                        <div style="width: 50px; word-break: break-all;">288.00
                                        </div>
                                    </td>
                                    <td align="center">
                                        <div style="width: 50px; word-break: break-all;">21.00
                                        </div>
                                    </td>
                                    <td align="center">
                                        <div style="width: 70px; word-break: break-all;">2017/4/22 23:14:21
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center">
                                        <div style="width: 90px; word-break: break-all;">V6588002337</div>
                                    </td>
                                    <td align="center">
                                        <div style="width: 70px; word-break: break-all;">3223583422552103</div>
                                    </td>
                                    <td align="center">
                                        <div style="width: 50px; word-break: break-all;">包包女2017新款潮豆腐包小包韩版小方包</div>
                                    </td>
                                   
                                    <td align="center">
                                        <div style="width: 80px; word-break: break-all;">sandyjack旗舰店
                                        </div>
                                    </td>
                                    <td align="center">
                                        <div style="width: 80px; word-break: break-all;">546649538073[del]
                                        </div>
                                    </td><td align="center">
                                        <div style="width: 80px; word-break: break-all;">淘宝PC自然搜索
                                        </div>
                                    </td><td align="center">
                                        <div style="width: 80px; word-break: break-all;">包包女2017新款潮 韩版 百搭小包
                                        </div>
                                    </td>
                                    
                                    <td align="center">
                                        <div style="width: 50px; word-break: break-all;">288.00
                                        </div>
                                    </td>
                                    <td align="center">
                                        <div style="width: 50px; word-break: break-all;">21.00
                                        </div>
                                    </td>
                                    <td align="center">
                                        <div style="width: 70px; word-break: break-all;">2017/4/15 16:03:13
                                        </div>
                                    </td>
                                </tr>
                        </tbody></table>
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


</script>
<?php require_once('include/header.php')?>  


</body></html>