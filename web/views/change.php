<?php require_once('include/header.php')?>


    <script language="javascript" type="text/javascript">
        $(document).ready(function () {
            $("#ShopPay").addClass("#ShopPay");
        });

        function ValiTest(value) {
            $("#serviceValidation").remove();
            $("#clientValidationOL").html("");
            if (value == "0") {
                if ($.trim($("#txtPrice").val()) == '') {
                    $("<li>要兑换的金额不能为空！</li>").appendTo($("#clientValidationOL"));
                    $("#clientValidation").show();
                    return false;
                }
            }
            else if (value == "1") {
                if ($.trim($("#txtPoint").val()) == '') {
                    $("<li>要兑换的发布点不能为空！</li>").appendTo($("#clientValidationOL"));
                    $("#clientValidation").show();
                    return false;
                }
            }
            if (value == "0") {
                $("#btnSubmit1").val("处理中...");
                $("#txtDHType").val("0");
                $("#fm").submit();
                $("#btnSubmit1").removeAttr("onclick");
            }
            if (value == "1") {
                $("#btnSubmit").val("处理中...");
                $("#txtDHType").val("1");
                $("#fm").submit();
                $("#btnSubmit").removeAttr("onclick");
            }
        }
    </script>


<body style="background: #fff;">
   
    <?php require_once('include/nav.php')?>
    <!--daohang-->
    
    <div class="sj-zjgl">
        <div class="zjgl-left">
            <h2 style="background: url(<?=base_url()?>style/images/hygl.png) no-repeat 22px 22px;">资金管理</h2>
            <ul>
                <li><a href="<?=site_url('capital')?>">账号充值</a> </li>
                <li><a href="<?=site_url('capital/transfer')?>">转账管理</a> </li>
                <li><a href="<?=site_url('capital/fund')?>">资金管理</a> </li>
                <li><a href="<?=site_url('capital/order')?>">订单信息</a> </li>
            </ul>
        </div>
        
<form action="<?=site_url('capital/changeDB')?>" id="fm" method="post">    
    <div class="zjgl-right">
        <div class="errorbox" id="clientValidation" style="display: none; width: 95%; height: 25px;">
            <ol style="list-style-type: decimal" id="clientValidationOL">
            </ol>
        </div>
        <div class="menu">
            <input type="hidden" name="DHType" id="txtDHType">
            <input type="hidden" name="id" value="<?=$info->id?>">
            <ul>
                <li class="off">存款兑换发布点</li>
            </ul>
        </div>
        <div class="sk-hygl">
            <div class="yctc_458 ycgl_tc_1" style="width: 760px;">
                <ul>
                    <li>
                        <p class="sk-zjgl_4">资金余额：</p>
                        <p style="line-height: 35px;"><?=$info->Money?>元<label style="color: Red; margin-left: 20px;">(存款用于支付货款)</label></p>
                    </li>
                    <li>
                        <p class="sk-zjgl_4">可用发布点：</p>
                        <p style="line-height: 35px;">
                            <?php if($info->MinLi>1000):?><?=($info->MinLi-1000)?><?php else:?>0<?php endif;?> 点<label style="color: Red; margin-left: 20px;"><a href="" style="color: Red;text-decoration: underline; ">其中<?php if($info->MinLi>1000):?>1000<?php else:?><?=$info->MinLi?><?php endif;?>点为账户担保金</a>(发布点用于支付佣金)</label>
                        </p>
                    </li>
                    <li>
                        <p class="sk-zjgl_4">&nbsp;</p>
                        <p style="line-height: 38px;">
                            将<input id="txtPrice" maxlength="21" type="text" name="txtPrice" class="input_417" style="width: 58px;" onkeyup="if(this.value.length==1){this.value=this.value.replace(/[^1-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}" onafterpaste="if(this.value.length==1){this.value=this.value.replace(/[^1-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}">元兑换成发布点，兑换比率：<em class="red">1元 =1 点</em>
                        </p>
                    </li>
                    <li style="margin-top: 10px;">
                        <p class="sk-zjgl_4">
                            &nbsp;</p>
                        <p><input class="input-butto100-ls" type="button" id="btnSubmit1" value="提交申请" onclick="return ValiTest('0')"></p><p>
                    </p></li>
                </ul>
            </div>
        </div>
        <div class="menu">
            <ul>
                <li class="off">发布点兑换存款</li>
            </ul>
        </div>
        <div class="sk-hygl">
            <div class="yctc_458 ycgl_tc_1" style="width: 760px;">
                <ul>
                    <li>
                        <p class="sk-zjgl_4">可用发布点：</p>
                        <p style="line-height: 35px;"><?php if($info->MinLi>1000):?><?=($info->MinLi-1000)?><?php else:?>0<?php endif;?>点  &nbsp; <a href="#" style="color: Red;text-decoration: underline; ">其中<?=$info->MinLi>1000?'1000':$info->MinLi?>点作为担保金</a></p>
                    </li>·
                    <li>
                        <p class="sk-zjgl_4">资金余额：</p>
                        <p style="line-height: 35px;"><?=$info->Money?>元
                        </p>
                    </li>
                    <li>
                        <p class="sk-zjgl_4">
                            &nbsp;</p>
                        <p style="line-height: 39px;">
                            将<input id="txtPoint" maxlength="21" type="text" name="txtPoint" class="input_417" style="width: 58px;" onkeyup="if(this.value.length==1){this.value=this.value.replace(/[^1-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}" onafterpaste="if(this.value.length==1){this.value=this.value.replace(/[^1-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}">
                            个发布点兑换成账户资金，兑换比率：<em class="red">1 点 =<label id="lblMoney"></label>1.00 </em><em style="color: Red">元</em>
                        </p>
                    </li>
                    <li style="margin-top: 10px;">
                        <p class="sk-zjgl_4">&nbsp;</p>
                        <p><input class="input-butto100-ls" type="button" id="btnSubmit" value="提交申请" onclick="return ValiTest('1')"></p>
                        <p></p>
                    </li>
                </ul>
            </div>
        </div>        
        <div class="menu">
            <ul>
                <li class="off"><a href="#">申请取出取出所有发布点</a></li>
            </ul>
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