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
        window.location="/Shop/TransferManagement"; 
    }

    function TransferResult(){
        window.location="/Shop/TransferManagement/TransferResult"; 
    }

    function BackResult(){
        window.location="/Shop/TransferManagement/BackResult"; 
    }
    function DrawBackResult(){
        window.location="/Shop/TransferManagement/TransferDrawBackResult"; 
    }

    function CheckFailReason(id){
        $.openWin(300, 422, '/Shop/TransferManagement/CheckDrawBackReason?id='+id);
    }

    function CheckValidateInfo(id){
        $.openWin(500, 540, '/Shop/TransferManagement/CheckValidateInfo?id='+id);
    }

    $(function(){
        GetNeedUpfile();
    })

    </script>

<body style="background: #fff;">
<?php require_once('include/nav.php')?>  
    <!--daohang-->
    
    <div class="sj-zjgl">
        <div class="zjgl-left">
            <h2 style="background: url(/Content/new_content/images/hygl.png no-repeat 22px 22px;">
                资金管理</h2>
            <ul>
                <li><a href="<?=site_url('capital')?>">账号充值</a> </li>
                <li><a href="<?=site_url('capital/transfer')?>" style="background: #eee;color: #ff9900;">转账管理</a> </li>
                <li><a href="<?=site_url('capital/fund')?>">资金管理</a> </li>
                <li><a href="<?=site_url('capital/order')?>">订单信息</a> </li>
            </ul>
        </div>
        
    <div class="zjgl-right">
<form action="<?=site_url()?>" enctype="multipart/form-data" id="fm" method="post">           
         <div class="wrap">
                <div class="navlist cmtab">
                    <span onclick="WaitTransfer()">等待转账</span> 
                    <span onclick="TransferResult()">转账结果</span>
                    <span id="backResult" onclick="BackResult()">未到账反馈</span>
                    <span class="cur" onclick="DrawBackResult()">买家已退款</span>
                </div>
                <div class="Cgbox cmqh">
                    <!-- 转账结果页面 -->
                    <div class="Flcont Flcont1">
                        <div class="cmqh">
                            <!--内容区域-->
                            <div class="h_35" style="height: 150px; font-size: 14px;">
                                <ul>
                                    <li>下方表格记录的是买家已在购物平台<label style="color: Red;">退款成功</label>的订单。对于以下情况的订单，买家有权利到购物平台进行退款：</li>
                                    <li>1、卖家长时间未转账;</li>
                                    <li>2、卖家频繁操作转账失败的订单。</li>
                                    <li>退款成功后，管理员会将订单状态变更为"已退款"。</li>
                                </ul>
                            </div>
                            <div class="Cash_state">
                                <label>
                                    订单编号：</label>
                                <input class="input_140 right_5" id="PlatformOrderNumber" name="PlatformOrderNumber" type="text" value="">
                                <label>
                                    &nbsp;&nbsp;&nbsp;&nbsp;转账截至时间：</label>
                                <input class="fpgl_1" id="BeginDate2" maxlength="16" name="BeginDate2" onclick="laydate({istime: true, format: &#39;YYYY-MM-DD hh:mm&#39;})" type="text" value="">
                                <label>
                                    ~</label>
                                <input class="fpgl_1" id="EndDate2" maxlength="16" name="EndDate2" onclick="laydate({istime: true, format: &#39;YYYY-MM-DD hh:mm&#39;})" type="text" value="">
                                <a href="javascript:void(0)" class="b_4882f0 anniu_60" onclick="Search()">查询</a>
                                <a href="javascript:void(0)" class="f90 anniu_60" onclick="location.href=&#39;/Shop/TransferManagement/TransferDrawBackResult&#39;">
                                    刷新</a>
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
                                            转账截至时间
                                        </th>
                                    </tr>
                                        <tr>
                                            <td colspan="7" align="center">
                                                <span style="width: 20px; font-weight: bolder; color: Red; font-size: 16px;">无相关记录</span>
                                            </td>
                                        </tr>
                                </tbody></table>
                            </div>
                            <!--内容区域-->
                        </div>
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