<?php require_once('include/header.php')?> 
<body style="background: #fff;">
    <?php require_once('include/nav.php')?>
    <!--daohang-->
    <script type="text/javascript">
        $(document).ready(function () {
            $("#NewContentIndex").addClass("a_on");
            $("#NewMemberInfo").addClass("a_on");

        });
        function iFrameHeight() {
            var ifm = document.getElementById("iframepage");
            var subWeb = document.frames ? document.frames["iframepage"].document :ifm.contentDocument;
            if (ifm != null && subWeb != null) {
                ifm.height = subWeb.body.scrollHeight;
                if (subWeb.body.scrollHeight + 100 < 500) //以防止公告内容太少左侧菜单栏显示不全
                    $(".vip-info").height(500);
                else
                    $(".vip-info").height(subWeb.body.scrollHeight + 100);
                //$(".vip-info").height("500");
            }

        }
    </script>
    
    <div class="sj-zjgl">
        <div class="zjgl-left">
            <h2 style="background: url(<?=base_url()?>style/images/hygl.png no-repeat 22px 22px;">会员中心</h2>
            <ul>
                <li><a href="<?=site_url('member')?>" >基本资料</a></li>
                <li><a href="<?=site_url('member/store')?>" >店铺管理</a></li><!--  选中栏目 -->
                <li><a href="<?=site_url('member/product')?>">商品管理</a></li>                
                <li><a href="<?=site_url('member/notice')?>" style="background: #eee;color: #ff9900;">平台公告</a></li>
                <li><a href="<?=site_url('member/edit')?>" >调整单量</a></li>
                </li>
            </ul>
        </div>
        
    <div class="zjgl-right">
        <div class="sk-hygl">
            <div class="sk-xwxq">
                <p class="sk-xwxq_1">
                    智能助手功能介绍</p>
                <p style="color: #999;">
                    2017/8/31 16:02:42<span style="margin-left: 10px;">系统</span></p>
            </div>
            <div class="sk-xwxq_2">
                <p>
                    <iframe src="style/48.html" style="width:100%; " frameborder="0" scrolling="no" id="iframepage" name="iframepage" onload="iFrameHeight()" height="1258">
                </p>
            </div>
        </div>
    </div>

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
                        var href='http://wpa.qq.com/msgrd?v=3&amp;uin='+data+'&amp;site=在线客服&amp;menu=yes';
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
                        var href='http://wpa.qq.com/msgrd?v=3&amp;uin='+data+'&amp;site=在线客服&amp;menu=yes';
                        $("#serviceQQ").attr('href',href);
                    }
                }
            });

    });
    $(window)

</script>
<div id="online_qq_layer" style="display: none; height:50px">
    <div id="online_qq_tab">
        <a id="floatShow" style="display: none;" href="javascript:void(0);">收缩</a> 
        <a id="floatHide" style="display: block;" href="javascript:void(0);">展开</a>
    </div>
    <div id="onlineService">
        <div class="onlineMenu">
            <h3 class="tQQ">
                QQ在线客服</h3>
            <ul>
                <li class="tli zixun">在线咨询</li>
                
                <li id="consultLi" style="height:30px"><a target="_blank" style="font-size:13px" id="consultQQ" href="http://wpa.qq.com/msgrd?v=3&amp;uin=2320817656&amp;site=在线客服&amp;menu=yes"
                    title="点击可进行QQ交流">
                    <img width="25" height="17" border="0" align="absmiddle" style="vertical-align:text-bottom" src="style/images/qq_online.gif">&amp;nbsp;商家顾问</a>
                </li>
                    
                <li style="height:30px"><a target="_blank" id="serviceQQ" style="font-size:13px" href="http://wpa.qq.com/msgrd?v=3&amp;uin=800186664&amp;site=在线客服&amp;menu=yes"
                    title="点击可进行QQ交流">
                    <img width="25" height="17" border="0" align="absmiddle" style="vertical-align:text-bottom" src="style/images/qq_online.gif">&amp;nbsp;平台客服</a>
                </li>
            </ul>
        </div>
        
        
        <div class="btmbg">
        </div>
    </div>
</div>
</body>
</html>
</iframe></p></div></div></div></div></body></html>