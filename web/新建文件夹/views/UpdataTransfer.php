<!DOCTYPE html>
<html><head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <script src="<?=base_url()?>style/jquery-1.8.3.js" type="text/javascript"></script>
    <script src="<?=base_url()?>style/jquery.jslides.js" type="text/javascript"></script>
    <script src="<?=base_url()?>style/open.win.js" type="text/javascript"></script>
    <script src="<?=base_url()?>style/jquery.jBox-2.3.min.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>style/jbox.css">
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>style/common.css">
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>style/index.css">
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>style/open.win.css">
    
     <link rel="stylesheet" type="text/css" href="<?=base_url()?>style/weui.css">
     <style>
.ctl_close1{ display:none;}
     .fpgl-tc-qxjs_6 {
    margin-top: 5px;
}

     .tooltip
        {
            width: 98px;
            background: #fceeda;
            float: left;
            margin-right: 5px;
            display: block;
            overflow: hidden;
            margin-right: 5px;
        }
        #tooltip
        {
            width: 290px;
            position: fixed;
            z-index: 9999;
        }
        #tooltip img
        {
            width: 290px;
            height: 380px;
        }
              
        .tip
        {
            width: 98px;
            background: #fceeda;
            float: left;
            margin-right: 5px;
            display: block;
            overflow: hidden;
            margin-right: 5px;
        }
        #tip
        {
            width: 290px;
            position: fixed;
            z-index: 9999;
        }
        #tip img
        {
            width: 290px;
            height: 380px;
        }
        .weui_uploader_status_content{
        	position: absolute;
            width: 100%;
            height: 100%;
            top: 50%;
            left: 50%;
        }
     </style>
    <script language="javascript">

        function shopChange() {
            var Typevalue = $("#PlatformType").val();
            if (Typevalue == "0")
            {
                $("#childType").show();
                $("#dlPlatformNoID").show();
            }
            if (Typevalue == "1" || Typevalue == "2") { $("#childType").hide();
               if(Typevalue=="1")
               {
                $("#dlPlatformNoID").hide();
               }
                if(Typevalue=="2")
               {
               $("#dlPlatformNoID").show();
               }
             }

        }

          function openBrowses(type) {
              if (type == "upfile1")
                  document.getElementById("upfile1").click();
          }
          
          function FinishUpload() {
              setTimeout(function () {
                  $("#sUpload1Success").hide();
              }, 1000);
          }
          
    </script>
    <style type="text/css">
        .sk-hygl_7
        {
            width: 100px;
            text-align: right;
            padding-right: 10px;
        }
        .red
        {
            color: Red;
        }
        .fbxx2 {
    width: 95%;
    overflow: hidden;
    padding: 5px;
    border-bottom: 1px dotted #989898;
    font-size: 14px;
    margin-top: 0px;
}
    </style>

</head>
<body style="background: #fff;">
    <!--列表 -->
    <div class="htyg_tc">
        <ul>
            <li class="htyg_tc_1" style="font-family: Microsoft YaHei;">提交修改单量信息</li>
            <li class="htyg_tc_2"><a href="javascript:void(0)" id="imgeColse" onclick="javascript:self.parent.$.closeWin()">
                <img src="<?=base_url()?>style/images/sj-tc.png"></a> </li>
        </ul>
    </div>
    
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
</style>
    <div class="errorbox" id="clientValidation" style="display: none;">
        <ol style="list-style-type: decimal" id="clientValidationOL">
        </ol>
    </div>
<form action="<?=site_url('member/updataTransferDB')?>" enctype="multipart/form-data" id="fm" method="post">
<div class="yctc_458 ycgl_tc_1" style="height:480px; width:90%; overflow-y:auto">
            <ul> 
                <li class="fpgl-tc-qxjs_6">
                    <p class="sk-hygl_7">单量调整为：</p>
                    <p> 
                        <input id="txtSenderTel" class="input_305" data-val="true" data-val-length-max="15" data-val-length-min="11"  maxlength="15" name="SenderTel" placeholder="每日单量需要调整为" type="text" value=""  onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')">
                        <b class="red">*</b>
                    </p>
                </li> 
                <li class="fpgl-tc-qxjs_6">
                    <p class="sk-hygl_7">需求内容介绍：</p>
                    <p>
                        <textarea name="DetailAddress" id="DetailAddress" class="input_44" style="width: 300px;height: 50px;" maxlength="200" placeholder="需求信息"></textarea>
                        <b class="red">*</b>
                    </p>
                </li>
                <li class="fpgl-tc-qxjs_6">
                    <p style="width: 50%;">
                        <input type="hidden" name="userid" value="<?=$info->id?>" >
                        <input class="input-butto100-hs" type="submit" id="btnSubmint" value="提交"  style="float: right; margin-right: 5px;">
                    </p>
                    <p style="width: 50%;">
                        <input onclick="self.parent.$.closeWin()" class="input-butto100-ls" type="button" style="height: 35px; float: left; margin-left: 5px;" value="返回"></p>
                </li>
            </ul>
        </div>
        
</form>

</body>
</html>