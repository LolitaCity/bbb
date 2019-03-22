    <?php require_once('include/header.php')?>  
    
    <script language="javascript">
        $(document).ready(function () {
              $("#ShopPay").addClass("#ShopPay");
            if ($("#serviceValidation").length > 0) {
                $.openAlter($("#serviceValidation").html(), "提示", { width: 250, height: 50 });
            }

            var alipayNick = "霆宇";
            if(alipayNick!=""&&alipayNick!=null)
            {
                $("#txtAlipayNick").attr("disabled",true);
                $("#btnBind").hide();
                $("#btnEdit").show();
                $("#btnSave").hide();
            }
            else
            {
                $("#btnBind").show();
                $("#btnEdit").hide();
                $("#btnSave").hide();
            }
        });

        function BindAlipayNick()
        {
            var value=$.trim($("#txtAlipayNick").val());
            if(value==""||value==null)
            {
                $.openAlter("支付宝昵称请输入", "提示");
                return;
            }
            $.ajax({
                type: "post",
                url: "BindAlipayNick",
                dataType: "text",
                data: { nick: value },
                error: function (XmlHttpRequest, textStatus, errorThrown) {
                    var $errorPage = XmlHttpRequest.responseText;
                    $.openAlter($errorPage, "提示");
                },
                success: function (data) {
                    data = eval("(" + data + ")");
                    if (data.StatusCode == "301") {
    $.openAlter('会话超时,请重新登录！', '提示', { width: 250,height: 50 },function () { location.href = "";},"确定");   
                    }
                    else if(data.StatusCode == "200")
                    {
                        $.openAlter(data.Message, "提示",{ width: 250,height: 50 },function () { window.location.reload()},"确定");
                    }
                    else
                    {
                        $.openAlter(data.Message, "提示");
                    }
                }
            });
        }

        function EditAlipayNick()
        {
            $("#txtAlipayNick").attr("disabled",false);
            $("#btnBind").hide();
            $("#btnEdit").hide();
            $("#btnSave").show();
        }
        function PayFor(){
        $.openWin(735, 850, '/Shop/InCome/PayFor');
        }
    </script>


</head>
<body style="background: #fff;">
    <?php require_once('include/nav.php')?>  
    <!--daohang-->
    
    <div class="sj-zjgl">
        <div class="zjgl-left">
            <h2 style="background: url(<?=base_url()?>style/images/hygl.png) no-repeat 22px 22px;">资金管理</h2>
            <ul>
                <li><a href="<?=site_url('capital')?>" style="background: #eee;color: #ff9900;" >账号充值</a> </li>
                <li><a href="<?=site_url('capital/wait')?>" >转账管理</a> </li>
                <li><a href="<?=site_url('capital/fund')?>">资金管理</a> </li>
                <li><a href="<?=site_url('capital/order')?>">订单信息</a> </li>
            </ul>
        </div>
        
    <div class="zjgl-right">
        
        <div style="display: none;">

        </div>
        <div class="errorbox" id="clientValidation" style="display: none">
            <ol style="list-style-type: decimal" id="clientValidationOL">
            </ol>
        </div>
        <div class="sk-hygl" style="margin-left: 20px;">
            <div class="yctc_458 ycgl_tc_1" style="width: 1100px; ">
                <ul>
                    <li>
                        <p class="sk-zjgl_4"> 帐号余额：</p>
                        <p style="line-height: 35px;">
                            <label style="font-size: 18px;"><?=$info->Money?></label>元</p>
                    </li>
                </ul>
                <?php echo $newinfo->goods_desc;?>
                <br>
            </div>
        </div>
    </div>

<script language="javascript" type="text/javascript">
$(function(){
    if(screen.width<1440){  
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
 } else {
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