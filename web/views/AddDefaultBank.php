<!DOCTYPE html>
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
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
            <li class="htyg_tc_1" style="font-family: Microsoft YaHei;">修改默认转账银行卡</li>
            <li class="htyg_tc_2"><a href="javascript:void(0)" id="imgeColse" onclick="javascript:self.parent.$.closeWin()">
                <img src="<?=base_url()?>style/images/sj-tc.png"></a> </li>
        </ul>
    </div>
    
    <link href="<?=base_url()?>style/fabe.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>style/select2.css">
    <script type="text/javascript" src="<?=base_url()?>style/select2.min.js"></script>
    <script src="<?=base_url()?>style/md5.js" type="text/javascript"></script>
    <script type="text/javascript">     
    $(function () {
        $('#selBankList').select2({'width':'160px',maximumSelectionSize: 5});
        $("#selBankList").change(function(){
           var value=$(this).val().trim();
           var num= $("#aBank").text();
           $("#liMsg").hide();
           $("#liMsg").text("");
           $("#butSubmit").attr('onclick',"Submit()");
           $("#butSubmit").attr('class',"f90 anniu_fabe");
           if(parseInt(num)==0){
              $("#butSubmit").removeAttr('onclick').attr("class","b_52cc99");
          }
        });
    });
    
        function Submit() {
            var msg = "";
            var BankName = $("#selBankList").val();
            var CardNumber = $("#txtCardNumber").val();
            var AccountName = $("#txtAccountName").val();
            var Pwd = hex_md5($("#txtPwd").val());
            var txtPwd=$("#txtPwd").val();
            if(BankName=='请选择银行'){
                msg = "请选择转账银行";
            }else if (BankName == '')
                msg = "转账银行不能为空";
            else if (CardNumber == '')
                msg = "银行卡号不能为空";
            else if (CardNumber.length < 16)
                msg = "银行卡号长度不正确";
            else if (AccountName == '')
                msg = "银行卡开户人不能为空";
            else if(!isChn(AccountName))
                msg = "银行卡开户人包含了非中文字符"
            else if (txtPwd == '')
                msg = "支付密码不能为空";

            if (msg != "") {
                $.openAlter(msg, "提示");
                return false;
            }else{
                $("#fm").submit();
            }
            
        }
        function isChn(str){ 
            var reg = /^[\u4E00-\u9FA5]+$/; 
            if(!reg.test(str)){ 
                return false; 
            }  
            return true; 
        } 

        function Close() {
            self.parent.$.closeWin()
        }
    </script>
    <style type="text/css">
        .b_52cc99
        {
            background: gray;
            color: #fff;
            height: 30px;
            line-height: 30px;
            text-align: center;
            border-radius: 30px;
            display: block;
            width: 120px;
        }
        .b_52cc99:hover
        {
            color: #fff;
        }
        
        .tx_ul_span
        {
            text-align: right;
            border-bottom: 1px solid #ddd;
            font-size: 14px;
        }
        .display_block
        {
            position: relative;
        }
        .tx_ul_span img
        {
            margin-top: 4px;
            margin-right: 0px;
        }
        .tx_ul_span b
        {
            color: Red;
        }
        .dis_black_tc
        {
            border-radius: 5px;
            border: 1px solid #f90;
            width: 200px;
            padding: 10px;
            font-size: 14px;
            line-height: 20px;
            display: none;
            background: #fff;
            text-align: left;
            position: absolute;
            top: -30px;
            left: -235px;
        }
        .display_block:hover .dis_black_tc
        {
            display: block;
        }
        .dis_black_tc em
        {
            background: url('<?=base_url()?>style/images/display_jt_f90.png');
            width: 7px;
            height: 12px;
            top: 32px;
            left: 220px;
            position: absolute;
            display: block;
        }
    </style>
    <!--列表 -->
<form action="<?=site_url('capital/addBankDB')?>" id="fm" method="post">  
    <input type="hidden" name='id' value="<?=$info->id?>">      
    <div class="tc_yhk">
            <h3 class="tc_title"> 请在下方输入新的转账银行卡信息：</h3>
            <ul class="tx_ul">
                <li>
                    <label>转账银行：</label>
                    <select id="selBankList" name="BankName" style="height:auto;width:auto" tabindex="-1" class="select2-hidden-accessible" aria-hidden="true">
                        <option selected="selected" value="请选择银行">请选择银行</option>
                        <option value="中国工商银行">工商银行</option>
                        <option value="中国农业银行">农业银行</option>
                        <option value="中国银行">中国银行</option>
                        <option value="中国建设银行">建设银行</option>
                        <option value="交通银行">交通银行</option>
                        <option value="中信银行">中信银行</option>
                        <option value="中国光大银行">光大银行</option>
                        <option value="华夏银行">华夏银行</option>
                        <option value="中国民生银行">民生银行</option>
                        <option value="广发银行">广发银行</option>
                        <option value="深圳发展银行">深圳发展银行</option>
                        <option value="招商银行">招商银行</option>
                        <option value="兴业银行">兴业银行</option>
                        <option value="上海浦东发展银行">浦发银行</option>
                        <option value="恒丰银行">恒丰银行</option>
                        <option value="浙商银行">浙商银行</option>
                        <option value="渤海银行">渤海银行</option>
                        <option value="中国邮政储蓄银行">邮政储蓄</option>
                        <option value="农村商业银行">农商行</option>
						<option value="浙江民泰商业银行">浙江民泰商业银行</option>
                    </select>
                    <span class="select2 select2-container select2-container--default" dir="ltr" style="width: 160px;">
                    <span class="selection"></span>
                    <span class="dropdown-wrapper" aria-hidden="true"></span></span>
                </li>
                <p id="liMsg" style="color: Red; display: none; font-size: 12px; margin-left: 50px">
                </p>
                <li>
                    <label> 转账银行卡号：</label>
                    <input type="text" name="CardNumber" onkeyup="value=value.replace(/[^0-9]/g,'')" onpaste="value=value.replace(/[^0-9]/g,'')" onblur="value=value.replace(/[^0-9]/g,'')" maxlength="19" id="txtCardNumber" class="input_228" placeholder="请输入正确的银行卡号">
                </li>
                <li>
                    <label>银行卡开户人：</label>
                    <input type="text" maxlength="5" onpaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\u4E00-\u9FA5]/g,''))" name="AccountName" id="txtAccountName" class="input_228" placeholder="请输入正确的开户人姓名" >
                </li>
                <li>
                    <label> 支付密码：</label>
                    <input type="password" maxlength="18" name="PayWord" id="txtPwd" class="input_228" placeholder="请输入在平台设置的支付密码">
                </li>
            </ul>
            <div class="left_100">
                    <a id="butSubmit" href="javascript:void(0);" onclick="Submit()" class="f90 anniu_fabe"> 确认提交</a>
                <a href="javascript:void(0);" onclick="Close()" class="b_4882f0 anniu_fabe">返回</a>
            </div>
        </div>
</form>


</body></html>