<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title></title>
    <script src="<?=base_url()?>style/jquery-1.8.3.js" type="text/javascript"></script>
    <script src="<?=base_url()?>style/jquery.jslides.js" type="text/javascript"></script>
    <script src="<?=base_url()?>style/open.win.js" type="text/javascript"></script>
    <script src="<?=base_url()?>style/jquery.jBox-2.3.min.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>style/jbox.css">
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>style/common.css">
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>style/index.css">
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>style/open.win.css">
	<script src="<?=base_url()?>style/ext/public.js" type="text/javascript"></script>

    
</head>
<body style="background: #fff;">
    <!--列表 -->
    <!--<div class="htyg_tc">
        <ul>
            <li class="htyg_tc_1" style="font-family: Microsoft YaHei;">登录密码修改</li>
            <li class="htyg_tc_2"><a href="javascript:void(0)" id="imgeColse" onclick="javascript:self.parent.$.closeWin()">
                <img src="<?=base_url()?>style/images/sj-tc.png"></a> </li>
        </ul>
    </div>-->
    
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>style/jbox(1).css">
    <script src="<?=base_url()?>style/jquery.jBox-2.3.min.js" type="text/javascript"></script>
    <script src="<?=base_url()?>style/md5.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(function () {
        	/*
        	 * 提交修改密码
        	 */
            $("#btnPwd").click(function () {
                var msg = '';
                if ($("#txtPassword").val() == '') {
                    msg = "新密码不能为空", "提示";
                }
                else if ($("#txtRePassword").val() == '') {                                                                                                                                                 
                    msg = "确认新密码不能为空", "提示";
                }
                else if ($("#txtTsPwd").val() == '') {
                    msg = "身份验证不能为空", "提示";
                }
                else if ($.trim($("#txtPassword").val()).length < 6 || $.trim($("#txtPassword").val()).length > 18) {
                    msg = "登录密码长度为6-18";
                }
                else if (passwordLevel($.trim($("#txtPassword").val())) == 1) {
                    msg = "登录密码必须由字母、数字和标点符号至少包含两种组成";
                }
                else if ($.trim($("#txtPassword").val()) != $.trim($("#txtRePassword").val())) {
                    msg = " 登录密码和确认登录密码必须一致";
                }

                if (msg != '') {
                	dialog.error(msg);
                    //$.openAlter(msg, "提示");
                }
                else {
                	$post = {
                		passwd: $("#txtPassword").val(),
                		save_pwd: $("#txtTsPwd").val(),
                	};
                	public.ajax('<?=base_url('member/editPwdDB')?>', $post, function(datas){
                		if(datas.status)
                		{
                			dialog.success(datas.message, 3000);
                			setTimeout(function(){
                				location.href = '/';
                			}, 3000);
                		}
                		else
                		{
                			dialog.error(datas.message);
                		}
                	});
                	
                	
//                  var nPwd = $("#txtPassword").val();
//                  var sfpw = $("#txtTsPwd").val();
//                  $.post('<?=base_url('member/editPwdDB')?>', { newPwd: nPwd, safePwd: sfpw }, function (data) {
//                      if(data.status){
//                   	    $.openAlter("修改成功", "提示",{ width: 250,height: 50 }, function () { window.parent.location = "<?=site_url('member')?>"; }, "关闭");
//                      }else{
//                      	$.openAlter(data.info, "提示");
//                      }
//                  }, 'json');
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
    <!--列表 -->
    <div class="yctc_458 ycgl_tc_1">
        <ul>
            <li>
                <p class="sk-hygl_7">设置密码：</p>
                <p>
                    <input type="password" maxlength="18" placeholder="请输入新密码" class="input_305" id="txtPassword" onkeyup="this.value=this.value.replace(/^ +| +$/g,&#39;&#39;)"></p>
            </li>
            <li class="fpgl-tc-qxjs_6">
                <p class="sk-hygl_7">确认密码：</p>
                <p>
                    <input type="password" maxlength="18" placeholder="请输入确认新密码" class="input_305" id="txtRePassword" onkeyup="this.value=this.value.replace(/^ +| +$/g,&#39;&#39;)"></p>
            </li>
            <li class="fpgl-tc-qxjs_6">
                <p class="sk-hygl_7">身份验证：</p>
                <p>
                    <input type="password" maxlength="18" placeholder="请输入支付密码" class="input_305" id="txtTsPwd"></p>
            </li>
            <li class="fpgl-tc-qxjs_4">
                <p>
                    <input class="input-butto100-hs" type="button" id="btnPwd" value="确定提交">
                </p>
                <p>
                    <input onclick="dialog.iframe_close(1)" class="input-butto100-ls" type="button" value="返回修改"></p>
            </li>
        </ul>
    </div>
</body>
</html>