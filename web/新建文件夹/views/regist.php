<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>会员注册</title>
<link href="<?=base_url()?>style/source/css/common.css" rel="stylesheet" type="text/css" />
<link href="<?=base_url()?>style/source/css/open.win.css" rel="stylesheet" type="text/css">
<link href="<?=base_url()?>style/source/css/index.css" rel="stylesheet" type="text/css" />
<script src="<?=base_url()?>style/source/js/jquery-1.8.3.min.js" type="text/javascript"></script>
<script src="<?=base_url()?>style/source/js/jquery.jslides.js" type="text/javascript"></script>
<script type="text/javascript" src="<?=base_url()?>style/source/js/open.win.js"></script>
<link href="<?=base_url()?>style/source/css/regist.css" rel="stylesheet" type="text/css" />
</head>
<body>
<script type="text/javascript">
var regCode = ""; //注册验证码
function createCode(){ 
    regCode = new Array();
    var codeLength = 4;//验证码的长度
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
<div class="index_top">
	<div class="index_top_1">
		<p class="left">
		<img src="<?=base_url()?>style/source/images/login.jpg"></p>
	</div>
</div>
<div class="sjzc" style="width: 1000px; height: 550px; margin-top: 40px">
    <div class="sjzc_1">
        注册会员</div>
    <div class="sjzc_2">

        <div class="sjzc_5" style="width: 63%">
            <ul style="width: 120%">
                <li style="width: 120%">
                    <p class="sjzc_6">手机号：</p>
                    <p>
                       <input class="input_215" placeholder="请输入11位手机号码"  type="text" value="" name="phonenum" id="Phonenum" maxlength="11">
                    </p>
                </li>
                <li style="width: 120%">
                    <p class="sjzc_6">密码：</p>
                    <p>
                       <input class="input_215" placeholder="请输入密码"  type="password" value="" name="pwd" id="Pwd">
                    </p>
                </li>
                <li style="width: 120%">
                    <p class="sjzc_6">确认密码：</p>
                    <p>
                       <input class="input_215" placeholder="再一次输入密码"  type="password" value="" name="pwd2" id="Pwd2">
                    </p>
                </li>
                <li style="width: 120%">
                    <p class="sjzc_6">QQ：</p>
                    <p>
                       <input class="input_215" placeholder="请输入QQ号"  type="text" value="" name="qq" id="qq">
                    </p>
                </li>
                <li style="width: 120%">
                    <p class="sjzc_6">邮箱：</p>
                    <p>
                       <input class="input_215" placeholder="请输入邮箱账号"  type="text" value="" name="email" id="email">
                    </p>
                </li>
                <li style="width: 120%">
                    <p class="sjzc_6">验证码：</p>
                    <p>
                       <input class="input_215" type="text" name="code" id="code" value="" placeholder="&nbsp;验证码" style=" width:100px;" />
                       <input type="button" name="" id="checkRegCode" onclick="createCode();" style=" width:100px; margin-left:10px; height:37px; line-height:35px; vertical-align: bottom;" />
                    </p>
                </li>
                <!--<li>
                    <p class="sjzc_6">
                        手机验证码：</p>
                    <p>
                        <input class="input_215" id="txtCode" maxlength="6" name="Code" onkeyup="value=value.replace(/[^0-9]/g,'')" placeholder="请输入6位验证码" type="text" value="">
                    </p><p>
                        <a href="javascript:void(0)">
                            <input id="btnSendCode" class="input-butto111" type="button" disabled="disabled" value="获取验证码" onclick="sendMessage()"></a><span id="lig" style="font-size: 12px;
                                                color: Red"></span>
                    </p>
                    <label id="Code_error" class="cue" style="display: none;">
                        验证码为6为数字
                    </label>
                    <p></p>
                </li>-->
                <li class="sjzc_8" id="liMsg">
                    <input name="id" id="idkey" type="hidden" value="<?=$id?>"/>
                    <input name="key" type="hidden" id="keyphone" value="<?=$key?>"/>
                </li>
                <li class="sjzc_7" style="margin-left: 150px"><a href="javascript:void(0)" id="subbtn">立即注册</a></li>
            </ul>
        </div>
    </div>
</div>
<script src="http://cdn.bootcss.com/blueimp-md5/1.1.0/js/md5.js"></script> 
<script src="http://cdn.bootcss.com/blueimp-md5/1.1.0/js/md5.min.js"></script> 
<script type="text/javascript">
createCode();
    $(function () {
        $("#subbtn").click(function () {
        	var inputCode = document.getElementById("code").value.toUpperCase();
            var msg = '';
            if( md5($("#Phonenum").val()) != $("#keyphone").val() ){
     	        msg = "链接错误!","提示";
            }else if ($("#Pwd").val() == '') {
                msg = "密码不能为空", "提示";
            }else if ($("#Pwd2").val() == '') {
                msg = "确认密码不能为空", "提示";
            }else if ($("#Pwd").val()!=$("#Pwd2").val()){
                msg='两次输入密码信息不一致';
            }else if ($("#txtCode").val() == '') {
                msg = "验证码不能为空", "提示";
            }else if (inputCode != regCode){
            	msg = "验证码不正确", "提示";
            }else if ($("#qq").val() == '') {
                msg = "QQ号码不能为空", "提示";
            }else if (!chkEmail($("#email").val())){
                msg = "邮箱格式不正确","提示";
            }
           
            /*else if ($("#phoneCode").val() == '') {
                msg = "确认手机验证码不能为空", "提示";
            }*/
            if (msg != '') {
                $.openAlter(msg, "提示");
                createCode();
            }else {
                $.post('<?=site_url('welcome/registDB')?>', { idkey:$("#idkey").val(), email: $("#email").val(),phonenum: $("#Phonenum").val(),pwd:$("#Pwd").val(), qq: $("#qq").val() }, function (r) {
                    //alert(r);
                    if(!r.status){
                        $.openAlter(r.content,"提示");
                    }else{
                        $.openAlter(r.content, "提示",{ width: 250,height: 50 }, function () { window.parent.location = "<?=site_url()?>"; }, "关闭");
                    }
                },'json');
            }
        })
    })
    function chkEmail(strEmail) { 
        if (!/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/.test(strEmail)) { 
            return false; 
        }else { 
            return true; 
        } 
    } 
</script>
</body>
</html>