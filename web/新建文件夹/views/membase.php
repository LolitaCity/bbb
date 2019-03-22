   <?php require_once('include/header.php')?>   
    
    <script language="javascript">
        $(document).ready(function () {
            $("#NewMemberInfo").addClass("#NewMemberInfo");
            $("#NewMemberInfo").addClass("a_on");
        });
    </script>
    <script src="<?=base_url()?>style/md5.js" type="text/javascript"></script>
    <script src="<?=base_url()?>style/jquery.jBox-2.3.min.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>style/jbox.css">

    <script type="text/javascript">
        $(function () {
            $("#btnEditPassword").click(function () {
                $.openWin(320, 500, '<?=site_url('member/editPWD')?>');
            });
        });
    </script>
    <script language="javascript">
        $(document).ready(function () {
//            $("#NewMemberInfo").addClass("a_on");
            $("#NewMember").addClass("#NewMember");
            $("#BasicData").addClass("a_on1");
        });

        $(function () {
            $("#btnTsPwd").click(function () {
                var msg = '';
                if ($("#txtNewPwds").val() == '') {
                    msg = "新支付密码不能为空", "提示";
                }
                else if ($("#txtReNewPwds").val() == '') {
                    msg = "确认新支付密码不能为空", "提示";
                }
                else if ($("#txtTsPwd2").val() == '') {
                    msg = "身份验证不能为空", "提示";
                }
                else if ($.trim($("#txtNewPwds").val()).length < 6 || $.trim($("#txtReNewPwds").val()).length > 18) {
                    msg = "支付密码长度为6-18";
                }
                else if (passwordLevel($.trim($("#txtNewPwds").val())) == 1) {
                    msg = "支付密码必须由字母、数字和标点符号至少包含两种组成";
                }
                else if ($.trim($("#txtNewPwds").val()) != $.trim($("#txtReNewPwds").val())) {
                    msg = " 支付密码和确认支付密码必须一致";
                }
                if (msg != '') {    
                    $.openAlter(msg, "提示");
                }else {  
                    var nPwd = $("#txtNewPwds").val();
                    var sfpw = $("#txtTsPwd2").val();
                    $.post('<?=site_url('member/editSafePwdDB')?>', { newSafePwd: nPwd, pwd: sfpw }, function (data) {
                   	   if(data.status){
                   	       $.openAlter("修改成功", "提示",{ width: 250,height: 50 }, function () { window.parent.location = "<?=site_url('member')?>"; }, "关闭");
                       }else{
                      	   $.openAlter(data.info, "提示");
                       }
                    }, 'json');
                }
            });
            
        });

        $(function () {
            $("#btnQQ").click(function () {
                //alert('123');
                var msg = '';
                if ($("#txtQQ").val() == '') {
                    msg = "QQ号码不能为空", "提示";
                }
                else if ($("#txtNewQQ").val() == '') {
                    msg = "新的QQ号码不能为空", "提示";
                }
                else if ($("#txtTsPwd3").val() == '') {
                    msg = "身份验证不正确", "提示";
                }
                if (msg != '') {
                    $.openAlter(msg, "提示");
                }else {
                    var qq = $("#txtNewQQ").val();
                    var sfpw = $("#txtTsPwd3").val();
                    $.post('<?=site_url('member/editQQDB')?>', { newQQ: qq, safePwd: sfpw }, function (data) {
                       	   if(data.status){
                       	       $.openAlter("修改成功", "提示",{ width: 250,height: 50 }, function () { window.parent.location = "<?=site_url('member')?>"; }, "关闭");
                           }else{
                          	   $.openAlter(data.info, "提示");
                           }
                    }, 'json');
                }
            });
            
        });
        
        $(function () {
            $("#btnWechat").click(function () {
                //alert('123');
                var msg = '';
                if ($("#newwechat").val() == '') {
                    msg = "新的微信号不能为空", "提示";
                }
                if (msg != '') {
                    $.openAlter(msg, "提示");
                }else {
                    var qq = $("#newwechat").val();
                    var sfpw = $("#wechatBtnChecked").val();
                    $.post('<?=site_url('member/editWehat')?>', { newQQ: qq, safePwd: sfpw }, function (data) {
                       	   if(data.status){
                       	       $.openAlter("修改成功", "提示",{ width: 250,height: 50 }, function () { window.parent.location = "<?=site_url('member')?>"; }, "关闭");
                           }else{
                          	   $.openAlter(data.info, "提示");
                           }
                    }, 'json');
                }
            });            
        });
        

        function passwordLevel(password) {
            var Modes = 0;
            for (i = 0; i < password.length; i++) {
                Modes |= CharMode(password.charCodeAt(i));
            }
            return bitTotal(Modes);

            //CharMode函数
            function CharMode(iN) {
                if (iN >= 48 && iN <= 57)//数字
                    return 1;
                if (iN >= 65 && iN <= 90) //大写字母
                    return 2;
                if ((iN >= 97 && iN <= 122) || (iN >= 65 && iN <= 90)) //大小写
                    return 4;
                else
                    return 8; //特殊字符
            }

            //bitTotal函数
            function bitTotal(num) {
                modes = 0;
                for (i = 0; i < 4; i++) {
                    if (num & 1) modes++;
                    num >>>= 1;
                }
                return modes;
            }
        }
    </script>

<body style="background: #fff;">
   <?php require_once('include/nav.php')?>  
    <!--daohang-->
    
    <div class="sj-zjgl">
        <div class="zjgl-left">
            <h2 style="background: url(<?=base_url()?>style/images/hygl.png) no-repeat 22px 22px;">会员中心</h2>
            <ul>
                <li><a href="<?=site_url('member')?>"  style="background: #eee;color: #ff9900;">基本资料</a></li>
                <li><a href="<?=site_url('member/store')?>" >店铺管理</a></li><!--  选中栏目 -->
                <li><a href="<?=site_url('member/product')?>">商品管理</a></li>                
                <li><a href="<?=site_url('member/notice')?>">平台公告</a></li>
                <li><a href="<?=site_url('member/edit')?>" >调整单量</a></li>
                <?php if($info->ispromoter):?>
                <li><a href="<?=site_url('member/join')?>" >邀请好友</a></li>
                <?php endif;?>
            </ul>
        </div> 
      

    <div id="fade" class="black_overlay" style="display: none;">
    </div>
    <!--添加弹窗 支付密码修改 -->
    <!--添加弹窗 登录密码修改 -->
    <div id="light2" class="ycgl_tc yctc_498" style="top: 31%; left: 32%; display: none;">
        <!--列表 -->
        <div class="htyg_tc">
            <ul>
                <li class="htyg_tc_1">支付密码修改</li>
                <li class="htyg_tc_2"><a href="javascript:void(0)" onclick="document.getElementById('light2').style.display='none';document.getElementById('fade').style.display='none'">
                    <img src="<?=base_url()?>style/images/sj-tc.png"></a> </li>
            </ul>
        </div>
        <!--列表 -->
        <div class="yctc_458 ycgl_tc_1">
            <ul>
                <li>
                    <p class="sk-hygl_7">
                        设置密码：</p>
                    <p>
                        <input type="password" maxlength="18" placeholder="请输入新的支付密码" class="input_305" id="txtNewPwds" onkeyup="this.value=this.value.replace(/^ +| +$/g,'')" value=""></p>
                </li>
                <li class="fpgl-tc-qxjs_6">
                    <p class="sk-hygl_7">
                        确认密码：</p>
                    <p>
                        <input type="password" maxlength="18" name="textfield" placeholder="请输入确认新的支付密码" class="input_305" id="txtReNewPwds" onkeyup="this.value=this.value.replace(/^ +| +$/g,'')" value=""></p>
                </li>
                <li class="fpgl-tc-qxjs_6">
                    <p class="sk-hygl_7">
                        身份验证：</p>
                    <p>
                        <input type="password" maxlength="18" name="textfield" placeholder="请输入登录密码" class="input_305" id="txtTsPwd2" value=""></p>
                </li>
                <li class="fpgl-tc-qxjs_4">
                    <p>
                        <input class="input-butto100-hs" type="button" id="btnTsPwd" value="确定提交">
                    </p>
                    <p>
                        <input onclick="document.getElementById('light2').style.display='none';document.getElementById('fade').style.display='none'" class="input-butto100-ls" type="button" value="返回修改"></p>
                </li>
            </ul>
        </div>
    </div>
    <div id="fade" class="black_overlay">
    </div>
    <!--添加弹窗 登录密码修改 -->
    <!--添加弹窗 QQ修改 -->
    <div id="light3" class="ycgl_tc yctc_498" style="top: 31%; left: 32%; display: none;">
        <!--列表 -->
        <div class="htyg_tc">
            <ul>
                <li class="htyg_tc_1">QQ修改</li>
                <li class="htyg_tc_2"><a href="javascript:void(0)" onclick="document.getElementById('light3').style.display='none';document.getElementById('fade').style.display='none'">
                    <img src="<?=base_url()?>style/images/sj-tc.png"></a> </li>
            </ul>
        </div>
        <!--列表 -->
        <div class="yctc_458 ycgl_tc_1">
            <ul>
                    <?php if($info->QQToken != ''):?>
                    <li>
                        <p class="sk-hygl_8"> 原有联系QQ：</p>
                        <p>
                            <input type="text" placeholder="请设置你的QQ号码" class="input_305" id="txtQQ" maxlength="15" value="<?=$info->QQToken?>" readonly="readonly" onkeyup="value=value.replace(/[^0-9]/g,'')"></p>
                    </li>
                    <?php endif;?>
                    <li class="fpgl-tc-qxjs_6">
                        <p class="sk-hygl_8"> 改后联系QQ：</p>
                        <p>
                            <input type="text" placeholder="请输入新的QQ号码" class="input_305" id="txtNewQQ" maxlength="15" onkeyup="value=value.replace(/[^0-9]/g,'')" value=""></p>
                    </li>
                <li class="fpgl-tc-qxjs_6">
                    <p class="sk-hygl_8"> 身份验证：</p>
                    <p>
                        <input type="password" maxlength="18" placeholder="请输入支付密码" class="input_305" id="txtTsPwd3" value=""></p>
                </li>
                <li class="fpgl-tc-qxjs_4">
                    <p>
                        <input class="input-butto100-hs" type="button" id="btnQQ" value="确定提交">
                    </p>
                    <p>
                        <input onclick="document.getElementById('light3').style.display='none';document.getElementById('fade').style.display='none'" class="input-butto100-ls" type="button" value="返回修改"></p>
                </li>
            </ul>
        </div>
    </div>
    <div id="fade" class="black_overlay">
    </div>
    <!--添加弹窗 QQ修改 -->
 <!--添加微信修改 -->
    <div id="light4" class="ycgl_tc yctc_498" style="top: 31%; left: 32%; display: none;">
        <!--列表 -->
        <div class="htyg_tc">
            <ul>
                <li class="htyg_tc_1">微信修改</li>
                <li class="htyg_tc_2"><a href="javascript:void(0)" onclick="document.getElementById('light4').style.display='none';document.getElementById('fade').style.display='none'">
                    <img src="<?=base_url()?>style/images/sj-tc.png"></a> </li>
            </ul>
        </div>
        <!--列表 -->
        <div class="yctc_458 ycgl_tc_1">
            <ul>
                    <?php if($info->wechat != ''):?>
                    <li>
                        <p class="sk-hygl_8"> 原有微信：</p>
                        <p><input type="text" placeholder="请设置你的微信号" class="input_305" id="wechat" maxlength="15" value="<?=$info->wechat?>" readonly="readonly" ></p>
                    </li>
                    <?php endif;?>
                    <li class="fpgl-tc-qxjs_6">
                        <p class="sk-hygl_8"><?=$info->wechat != ''?'更改后微信':'微信号'?> ：</p>
                        <p>
                            <input type="text" placeholder="<?=$info->wechat != ''?'请输入新的微信号':'请输入微信号'?>" class="input_305" id="newwechat" maxlength="15" value=""></p>
                    </li>
                <li class="fpgl-tc-qxjs_6">
                    <p class="sk-hygl_8"> 身份验证：</p>
                    <p>
                        <input type="password" maxlength="18" id="wechatBtnChecked" placeholder="请输入登录密码" class="input_305"  value=""></p>
                </li>
                <li class="fpgl-tc-qxjs_4">
                    <p>
                        <input class="input-butto100-hs" type="button" id="btnWechat" value="确定提交">
                    </p>
                    <p>
                        <input onclick="document.getElementById('light4').style.display='none';document.getElementById('fade').style.display='none'" class="input-butto100-ls" type="button" value="返回修改"></p>
                </li>
            </ul>
        </div>
    </div>
    <div id="fade" class="black_overlay">
    </div>
    <!--添加弹窗 微信修改 -->
    <!-- 内容-->
    <div class="zjgl-right">
        <div class="sk-hygl">
            <div class="sk-hygl_1" style="width: 550px;">
                <ul>
                    <li>
                        <p>会员名：<?=$info->Username?></p>
                    </li>
                    <li>
                        <p> 总资产：<?=$info->Money?>（账户总金额）</p>
                    </li>
                    <li>
                        <p> 保证金：<?=$info->bond?>（保证金金额）</p>
                    </li>
                    <li>
                        <p> 已发任务佣金：<?=$faburenwuyongjin?>（已发任务被接手需要消耗佣金）</p>
                    </li>
                    <li>
                        <p> 可用资产：<?=$info->Money-$info->bond-$faburenwuyongjin?>（账户中可用资产）</p>
                    </li>
                    <li>
                        <p class="sk-hygl_4"> 登录密码： 已设置</p>
                        <p class="sk-hygl_3">                            
                            <input id="btnEditPassword" class="input-butto62-zls" type="button" value="修改">
                        </p>
                    </li>
                    <li>
                        <p class="sk-hygl_4">
                              支付密码： <span><?=$info->SafePwd==''?'未设置':'已设置'?></span>
                        </p>
                        <p class="sk-hygl_3">
                            <input onclick="document.getElementById('light2').style.display='block';document.getElementById('fade').style.display='block'" class="input-butto62-zls" type="button" value="修改">
                        </p>
                    </li>
                    <li>
                        <p class="sk-hygl_4">QQ：<?=$info->QQToken?></p>
                        <p class="sk-hygl_3">
                                <input onclick="document.getElementById('light3').style.display='block';document.getElementById('fade').style.display='block'" class="input-butto62-zls" type="button" value="修改">
                        </p>
                    </li>
                    <li>
                        <p class="sk-hygl_4">微信：<?=$info->wechat?></p>
                        <p class="sk-hygl_3">
                                <input onclick="document.getElementById('light4').style.display='block';document.getElementById('fade').style.display='block'" class="input-butto62-zls" type="button" value="修改">
                        </p>
                    </li>
                </ul>
            </div>
            <div class="sk-hygl_2">
                <div class="sk-hygl_5">
                    <p class="sk-hygl_6" style="padding: 0px 30px;">
                        愉快合作第：<em><?=@ceil((@strtotime(@date('Y-m-d H:i:s'))-$info->RegTime)/(60*60*24))?></em>天<br>
                        账户存款：<em><?=$info->Money?></em>元<br>
                        账户保证金：<em><?=$info->bond?></em>个<br>
                        已发任务佣金：<em><?=$faburenwuyongjin?></em>个<br>
                        可用资产：<em><?=$info->Money-$info->bond-$faburenwuyongjin?></em>个<br>
                        绑定店铺：<em><?=$shops?></em>个<br>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <!-- 内容-->

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