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
    
</head>
<body style="background: #fff;">
    <!--列表 -->
    <div class="htyg_tc">
        <ul>
            <li class="htyg_tc_1" style="font-family: Microsoft YaHei;">申请取出保证金</li>
            <li class="htyg_tc_2"><a href="javascript:void(0)" id="imgeColse" onclick="javascript:self.parent.$.closeWin()">
                <img src="<?=base_url()?>style/images/sj-tc.png"></a> </li>
        </ul>
    </div>
    
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>style/jbox(1).css">
    <script src="<?=base_url()?>style/jquery.jBox-2.3.min.js" type="text/javascript"></script>
    <script src="<?=base_url()?>style/md5.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(function () {
            $("#btnPwd").click(function () {
                var msg = '';
                if ($("#getname").val() == '') {
                    msg = "收款人姓名不能为空", "提示";
                }else if ($("#getnumber").val() == '') {
                    msg = "收款账号不能为空", "提示";
                }
                if($("#selectinfo option:selected").val()=='card'){
                    if($("#getnumber").val() == ''){
                        msg = "请填写银行卡所属银行", "提示";
                    }
                }
                
                if (msg != '') {
                    $.openAlter(msg, "提示");
                }else {
                    var type = $("#selectinfo option:selected").val();
                    var name = $("#getname").val();
                    var bank = $("#getbank").val();
                    var number = $("#getnumber").val();
                    $.post('<?=site_url('capital/getallDB')?>', { type: type, name: name , bank: bank, card: number }, function (data) {
                       // alert(data);
                        if(data.status){
                            $.openAlter("申请提交成功！请等待工作人员审核！", "提示",{ width: 250,height: 50 }, function () { window.parent.location = "<?=site_url('capital/fund')?>"; }, "关闭");
                        }else{
                            $.openAlter(data.info, "提示");
                        }
                    }, 'json');
                }
            });

            $("#bankid").hide();
        });
/* 
        $("#selectinfo").change(function(){
            alert('11');
        }); */
        function show_sub(obj){
            if(obj == 'card'){
                $("#bankid").show();
            }else{
                $("#bankid").hide();
            }
        }
    </script>
    <!--列表 -->
    <div class="yctc_458 ycgl_tc_1">
        <ul>
            <li>
                <p class="sk-hygl_7">类型：</p>
                <p>
                    <select name="payway" class="input_305" id="selectinfo" onchange="show_sub(this.options[this.options.selectedIndex].value)" >
                        <option value="alipay">支付宝</option>
                        <option value="card">银行卡</option>   
                    </select>    
                </p>
            </li>
            <li class="fpgl-tc-qxjs_6">
                <p class="sk-hygl_7">收款人：</p>
                <p>
                    <input type="text" maxlength="18" placeholder="请输入收款人姓名" class="input_305" id="getname"  ></p>
            </li>
            <li class="fpgl-tc-qxjs_6" id="bankid">
                <p class="sk-hygl_7">开户银行：</p>
                <p>
                    <input type="text" maxlength="18" placeholder="请输入开户银行" class="input_305" id="getbank" ></p>
            </li>
            <li class="fpgl-tc-qxjs_6">
                <p class="sk-hygl_7">收款账号：</p>
                <p><input type="text" maxlength="18" placeholder="请输入收款账号" class="input_305" id="getnumber" ></p>
            </li>
            <li class="fpgl-tc-qxjs_4">
                <p>
                    <input class="input-butto100-hs" type="button" id="btnPwd" value="确定提交">
                </p>
                <p>
                    <input onclick="self.parent.$.closeWin()" class="input-butto100-ls" type="button" value="返回修改"></p>
            </li>
        </ul>
    </div>
</body>
</html>