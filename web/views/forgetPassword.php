<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="renderer" content="webkit" />
    <title>重置密码</title>
    <link href="<?=base_url()?>style/source/css/common.css" rel="stylesheet" type="text/css">
    <link href="<?=base_url()?>style/source/css/index.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="<?=base_url()?>style/source/js/jquery-1.8.3.min.js"></script>
    <script src="<?=base_url()?>style/source/js/jquery.jBox-2.3.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="<?=base_url()?>style/source/js/open.win.js?v=4.1"></script>
    <link href="<?=base_url()?>style/source/css/open.win.css" rel="stylesheet" type="text/css">
    <style type="text/css">
        .cue
        {
            color: #e4393c;
            line-height: 35px;
            height: 35px;
            position: absolute;
            width: 260px;
            padding: 0 5px;
            background: #FFEBEB;
            border: 1px solid #ffbdbe;
            color: #666;
            width: 260px;
            line-height: 36px;
            background: #f7f7f7;
            border: 1px solid #dddddd;
            display: none;
        }
        .input_215
        {
            border: 1px solid #ddd;
            height: 35px;
            line-height: 35px;
            width: 322px;
        }
        .err
        {
            color: #f00;
            line-height: 35px;
            height: 35px;
            position: absolute;
            width: 260px;
            padding: 0 5px;
            background: #FFEBEB;
            border: 1px solid #ffbdbe;
            color: #e4393c;
            width: 260px;
            line-height: 36px;
            background: #FFEBEB;
            border: 1px solid #ffbdbe;
            display: none;
        }
    </style>
    
<script type="text/javascript">
var regCode = ""; //注册验证码
function createCode(){ 
    regCode = new Array();
    var codeLength = 6;//验证码的长度
    var selectChar = new Array(2,3,4,5,6,7,8,9,'A','B','C','D','E','F','G','H','J','K','L','M','N','P','Q','R','S','T','U','V','W','X','Y','Z');
    for(var i=0;i<codeLength;i++) {
       var charIndex = Math.floor(Math.random()*32);
       regCode +=selectChar[charIndex];
    }
    if(regCode.length != codeLength){
       createCode();
    }
    $("#checkRegCode").val(regCode);
}
</script>
    <script type="text/javascript">
    $(function(){
    	createCode();
    });

    
        function Ok() {
            //alert($("#LoginName").val());
            var msg = "";
            var msg2="";
            var msg1="";
            if ($.trim($("#LoginName").val()) == '') {
                msg = "登录会员名不能为空";
            }else if ($.trim($("#LoginName").val()).length != 11) {
                msg = "登录会员名格式不正确1";
            }else if (!(/^1[3|4|5|7|8]\d{9}$/.test($.trim($("#LoginName").val())))) {
                msg = "登录会员名格式不正确2";
            }
            if ($.trim($("#txtEmail").val()) == '') {
                msg1 = "邮箱不能为空";
            }else if (!chkEmail($("#txtEmail").val())) {
                msg1 = "邮箱格式不正确";
            }
           // alert(msg);
        	var inputCode = document.getElementById("code").value.toUpperCase();
            if ($.trim($("#code").val()) == '') {
                msg2 = "验证码不能为空";
            }else if ($.trim($("#code").val()).length != 6) {
                msg2 = "验证码长度不正确";
            }else if( inputCode != regCode){
                msg2 = "验证码不正确";
            }
            if (msg != "") {
                $("#Tel_error").text(msg);
                $("#Tel_error").removeClass("cue").addClass("err");
                $("#Tel_error").show();
                return false;
            }
            if (msg1 != "") {
                $("#Mail_error").text(msg1);
                $("#Mail_error").removeClass("cue").addClass("err");
                $("#Mail_error").show();
                return false;
            }
            if (msg2 != "") {
                $("#Code_error").text(msg2);
                $("#Code_error").removeClass("cue").addClass("err");
                $("#Code_error").show();
                return false;
            }
            // 提交 ajax
            $.post('<?=site_url('welcome/registerDB')?>', { email: $("#txtEmail").val(),username: $("#LoginName").val() }, function (data) {
                //alert(data);
                if(!data.status){
                    $.openAlter(data.msg,"提示");
                }else{
                    $.openAlter(data.msg,"提示",{ width: 250,height: 50 }, function () { window.parent.location = "<?=site_url()?>"; }, "关闭");
                }
            },'json');
        }

        function chkEmail(strEmail) { 
            if (!/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/.test(strEmail)) { 
                return false; 
            }else { 
                return true; 
            } 
        } 
    </script>
</head>
<body>
<form action="<?=site_url('member/registerDB')?>" enctype="multipart/form-data" id="fm" method="post">        
    <div class="index_top">
        <div class="index_top_1">
            <p class="left">
                <a href="/"><img src="<?=base_url()?>style/source/images/login.jpg"></a>
            </p>
        </div>
    </div>

    <!-- 商家注册-->
    <div class="sjzc" style="width: 1000px; height: 550px; margin-top: 40px">
        <div class="sjzc_1"> 重置密码</div>
        <div class="sjzc_2">
            <div class="sjzc_3">
                <ul>
                    <li class="sjzc_4" style="width: 100%">验证会员信息</li>
                </ul>
            </div>
            <div class="sjzc_5" style="width: 63%">
                <ul style="width: 120%">
                    <li style="width: 120%">
                        <p class="sjzc_6">  登录会员名：</p>
                        <p>
                            <input Class="input_215" class="input-validation-error" data-val="true" data-val-required="登录名不能为空" id="LoginName" maxlength="11" name="LoginName" onkeyup="value=value.replace(/[^0-9]/g,'')" placeholder="请输入注册时使用的手机号码~" type="text" value="" />
                            <label id="Tel_error" class="cue">请输入注册时填写的手机号码~</label>
                        </p>
                    </li>
                    <li style="width: 120%">
                        <p class="sjzc_6">邮箱：</p>
                        <p>
                            <input Class="input_215"  class="input-validation-error" data-val="true" data-val-required="登录名不能为空" id="txtEmail" name="Email"  placeholder="请输入注册时使用的邮箱账号~" type="text" value="" />
                            <label id="Mail_error" class="cue">请输入注册时填写的邮箱账号，收到邮件后请打开邮件中的网址重置您的密码。</label>
                        </p>
                    </li>
                    <li style="width: 120%">
                        <p class="sjzc_6">验证码：</p>
                        <p>
                            <input class="input_215" type="text" name="code" id="code" value="" placeholder="&nbsp;验证码" style=" width:100px;" />
                            <input type="button" name="" id="checkRegCode" maxlength="6" onclick="createCode();" style=" width:100px; margin-left:10px; height:37px; line-height:35px; vertical-align: bottom;" />
                            <label id="Code_error" class="cue">请输入注册时填写的邮箱账号，收到邮件后请打开邮件中的网址重置您的密码。</label>
                        </p>
                    </li>

                    <li class="sjzc_8" id="liMsg"></li>
                    <li class="sjzc_7" style="margin-left: 150px"><a href="javascript:void(0)" onclick="Ok()">提交找回</a></li>
                </ul>
            </div>
        </div>
    </div>
    <!-- 商家注册-->
</form></body>
</html>
