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
        function Ok() {
            //alert($("#LoginName").val());
            var password = $("#password").val();
            var checkPwd = $("#checkPwd").val();
            var userid = "<?=$user->id?>";
            var msg = "";
            var reg = new RegExp("^[a-zA-Z0-9@#$%!%^&*]+$","gi");
            if ( password != checkPwd) {
                msg = "两次输入的密码不一致";
            }else if (password.length < 6 || password.length >16  ) {
                msg = "密码应为6-16位的字符";
            }else if (password.replace(reg,"").length!=0) {
                msg = "密码应为答谢字母，小写字母以及(@ # $ % ! % ^ & * )特殊符号组成";
            }           
            if (msg != "") {
                $("#Tel_error").text(msg);
                $("#Tel_error").removeClass("cue").addClass("err");
                $("#Tel_error").show();
                return false;
            }
            // 提交 ajax
            $.post('<?=site_url('welcome/resetDB')?>', { password: $("#password").val(),userid:userid}, function (data) {
                //alert(data);
                if(!data.status){
                    $.openAlter(data.msg,"提示");
                }else{
                    $.openAlter(data.msg,"提示",{ width: 250,height: 50 }, function () { window.parent.location = "<?=site_url()?>"; }, "关闭");
                }
            },'json');
        }

    </script>
</head>
<body>
<form action="<?=site_url('member/resetDB')?>" enctype="multipart/form-data" id="fm" method="post">        
    <div class="index_top">
        <div class="index_top_1">
            <p class="left">
                <img src="<?=base_url()?>style/source/images/login.jpg">
            </p>
        </div>
    </div>

    <!-- 商家注册-->
    <div class="sjzc" style="width: 1000px; height: 550px; margin-top: 40px">
        <div class="sjzc_1"> 重置密码</div>
        <div class="sjzc_2">
            <div class="sjzc_3">
                <ul>
                    <li class="sjzc_4" style="width: 100%">填写新密码</li>
                </ul>
            </div>
            <div class="sjzc_5" style="width: 63%">
                <ul style="width: 120%">
                    <li style="width: 120%">
                        <p class="sjzc_6">密码：</p>
                        <p>
                            <input Class="input_215" class="input-validation-error" data-val="true" data-val-required="登录名不能为空" id="password" name="password" placeholder="请输入密码~" type="password" value="" />
                            <label id="Tel_error" class="cue">请输入注册时填写的手机号码~</label>
                        </p>
                    </li>
                    <li style="width: 120%">
                        <p class="sjzc_6">确认密码：</p>
                        <p>
                            <input Class="input_215"  class="input-validation-error" data-val="true" data-val-required="登录名不能为空" id="checkPwd" name="Email"  placeholder="请重新输入密码~" type="password" value="" />
                            <label id="Mail_error" class="cue">请输入注册时填写的邮箱账号，收到邮件后请打开邮件中的网址重置您的密码。</label>
                        </p>
                    </li>
                    <li class="sjzc_8" id="liMsg"></li>
                    <li class="sjzc_7" style="margin-left: 150px"><a href="javascript:void(0)" onclick="Ok()">确认修改</a></li>
                </ul>
            </div>
        </div>
    </div>
    <!-- 商家注册-->
</form></body>
</html>
