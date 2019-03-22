<?php require_once('include/header.php')?>
<script language="javascript" type="text/javascript">

 
    window.onload=function(){
       var agent = navigator.userAgent.toLowerCase() ;
       if(agent.indexOf("chrome") <0)
        {
   	    $.openAlter("建议使用Google浏览器登录平台，其他浏览器可能有兼容性问题，无法进行某些操作。","友情提醒");
        }
    }
        //判断是否在iframe中  
        if (self != top) {
            parent.window.location.replace(window.location.href);
        }
        document.onkeypress = function (e) {
            var code;
            if (!e) {
                var e = window.event;
            }
            if (e.keyCode) {
                code = e.keyCode;
            }
            else if (e.which) {
                code = e.which;
            }            
            if (code == 13) {
                ValiTest();
            }
        }

         function ValiTest() {
            var code = 'display:none';
            $("#serviceValidation").remove();
            $("#clientValidationOL").html("");
            if($.trim($("#txtLoginName").val()) == '' || $.trim($("#txtPwd").val()) == '')
            {
            	return dialog.error('账户或密码不能为空');
            }
            $("#Password").val($("#txtPwd").val());
            public.ajax("<?=site_url('Welcome/login');?>", $('#fm').serialize(), function(datas){
            	if(datas.status)
            	{
            		dialog.success(datas.message);
            		location.href= "<?=site_url('user');?>";
            	}
            	else
            		dialog.error(datas.message);
            });
        }
         $(document).ready(function () {
            if ($("#serviceValidation").length > 0) {
               var msg=$("#serviceValidation").text().trim();
               if(msg.indexOf('您的用户名或密码错误')>-1)
               { 
                     var Num=msg.substr(msg.length-1,1);
                      msg="<div  style=\"text-align:left\"><p>用户名或密码错误！</p><p  style=\"margin-top: 5px;\">剩余<em style=\"color:red;font-weight:900\">"+(parseInt(Num)+1)+"</em>次输入机会，机会用尽后账户会自动冻结。</p><p  style=\"margin-top: 5px;\">您可以：<a  id='aPwd' href='/Login/ForgetPwd' class='aPwd' style=\" text-decoration:underline\">重置登录密码<a></p></div>";
                     $.openAlter(msg, "提示", { width: 250, height: 50 });
               }
               else
               {
                $.openAlter($("#serviceValidation").text(), "提示", { width: 250, height: 50 });
                }
            }
        }) 
        function login(){
        	$.ajax({
                cache: true,
                type: "POST",
                url:"<?=site_url('welcome/login');?>",
                data:$('#fm').serialize(),
                async: false,
                error: function(request) {
                	$.openAlter("Connection error!!!", "提示", { width: 250, height: 50 });
                },
                success: function(data) {
                    if(data){
                        alert('登录成功！');
                        window.location.href = "<?=site_url('user');?>";
                    }else{
                        $.openAlter("账号或密码错误", "提示", { width: 250, height: 50 });
                    } 
                }
            });
        	return false;
        }
        
    </script>
    <style type="text/css">
        .aPwd
        {
            color: #4882f0;
        }
        #aPwd:hover
        {
            color: #ff9900;
        }
    </style>
<body style="background: #fff;">
    <!--[if lt IE 8]>

<script language="javascript" type="text/javascript">
$.openAlter('<div style="font-size:18px;text-align:left;line-height:30px;">hi,你当前的浏览器版本过低，可能存在安全风险，建议升级浏览器：<div><div style="margin-top:10px;color:red;font-weight:800;">谷歌Chrome&nbsp;&nbsp;,&nbsp;&nbsp;UC浏览器</div>', "提示", { width: 250, height: 50 });
$("#ow_alter002_close").remove();
</script>
<![endif]-->
<style>
    .infobox
    {
        background-color: #fff9d7;
        border: 1px solid #e2c822;
        color: #333333;
        padding: 5px;
        padding-left: 30px;
        font-size: 13px;
        --font-weight: bold;
        margin: 0 auto;
        margin-top: 10px;
        margin-bottom: 10px;
        width: 85%;
        text-align: left;
    }
    .errorbox
    {
        background-color: #ffebe8;
        border: 1px solid #dd3c10;
        margin: 0 auto;
        margin-top: 10px;
        margin-bottom: 10px;
        color: #333333;
        padding: 5px;
        padding-left: 30px;
        font-size: 13px;
        --font-weight: bold;
        width: 85%;
    }
	.banner{ width:100%;}
	.banner img{width:100%;}
</style>
<form id="fm" method="post" onsubmit="return login();" >        
        <div class="index_top">
            <div class="index_top_1">
                <p class="left"><img src="<?=base_url()?>style/images/logo.png"></p>
            </div>
        </div>
        <!-- banner-->
        <div class="banner">
            <div style="display: none;">

            </div>
            <!-- 代码 开始 -->
          <div id="full-screen-slider">
                <ul id="slides">
                    <li style="background: url('<?=base_url()?>style/images/banner.jpg') center top no-repeat; z-index: 900; display: none;">
                    </li>
                    <li style="background: url('<?=base_url()?>style/images/banner.jpg') center top no-repeat; z-index: 900; display: none;">
                    </li>
                    <li style="background: url('<?=base_url()?>style/images/banner.jpg') center top no-repeat; z-index: 800; display: block;">
                    </li>
                </ul><ul id="pagination" style="margin-left: 470px;"><li class=""><a href="<?=site_url()?>">1</a></li><li class=""><a href="<?=site_url()?>">2</a></li><li class="current"><a href="<?=site_url()?>">3</a></li></ul>
            </div> <!--
			 <div class="banner">
				<img src="style/images/banner.jpg"/>
			</div>  -->
            <!-- 代码 结束 -->
            <div class="banner_login">
                <h2> 用户登录</h2>
                <ul>
                    <li class="yhdl" style="margin-top: 0px;">
                        <p>帐户：</p>
                        <p>
                            <input class="input_216" id="txtLoginName" data-val="true" data-val-length="用户名最大长度为50" data-val-length-max="50" data-val-required="Name 字段是必需的。" maxlength="50" name="Name" placeholder="请输入账户名" type="text" value="">
                        </p>
                    </li>
                    <li class="yhdl_2">
                        <p>密码：</p>
                        <p>
                            <input data-val="true" data-val-length="密码处最大长度为50" data-val-length-max="50" data-val-required="Password 字段是必需的。" id="Password" name="Password" type="hidden" value="">
                            <input type="password" class="input_216" placeholder="请输入密码" id="txtPwd" maxlength="50">
                        </p>
                    </li>
                    <li class="yhdl_2"><a href="javascript:void(0)" onclick="return ValiTest()">登 录</a></li>
                    <li class="yhdl_3" style="margin-top: 5px;">
                        <!--<a href="<?=site_url('welcome/regist')?>" id="zc">会员注册</a>-->
                    <a style="margin-left:100px" href="<?=site_url('welcome/register')?>">忘记密码</a></li>
                </ul>
            </div>
        </div>
        <!-- banner-->
</form>

</body></html>