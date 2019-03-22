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
            <li class="htyg_tc_1" style="font-family: Microsoft YaHei;">查看提交审核资料</li>
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
<form action="<?=site_url('member/editShopInfoDB')?>" enctype="multipart/form-data" id="fm" method="post">
<div class="yctc_458 ycgl_tc_1" style="height:480px; width:90%; overflow-y:auto">
            <ul> 
                    <li>
                        <p class="sk-hygl_7"> 店铺类型：</p>
                        <p style="line-height: 35px;">
                            <input checked="checked" id="ChildPlatformType" name="ChildPlatformType" type="radio" value="淘宝">淘宝
                           <!--  <input id="ChildPlatformType" name="ChildPlatformType" type="radio" value="天猫">天猫 -->
                        </p>
                    </li>
                    <li class="fpgl-tc-qxjs_6">
                        <p class="sk-hygl_7"> 掌柜号：</p>
                        <p> 
                            <input id="txtPlatformNumber" class="input_305" data-val="true" data-val-required="掌柜号必填" maxlength="50" name="PlatformNoID" placeholder="请输入掌柜号" type="text" value="<?=$info->manager_num?>">
                            <b class="red">*</b>
                        </p>
                    </li>
                <li class="fpgl-tc-qxjs_6">
                    <p class="sk-hygl_7"> 店铺名：</p>
                    <p>
                        <input id="txtShopName" class="input_305" data-val="true" data-val-required="店铺名称必填" maxlength="30" name="ShopName" placeholder="请输入店铺名" type="text" value="<?=$info->shopname?>">
                        <b class="red">*</b>
                    </p>
                </li>
                <li class="fpgl-tc-qxjs_6">
                    <p class="sk-hygl_7"> 店铺性质：</p>
                    <p>
                        <select class="input_305" data-val="true" data-val-required="店铺性质必填" id="ShopNature" name="ShopNature" style="width:80px">
                            <option value="0">个人</option>
                            <option value="1">公司</option>
                        </select>
                        <b class="red">*</b>
                    </p>
                </li>
                <li class="fpgl-tc-qxjs_6">
                    <p class="sk-hygl_7">发货人：</p>
                    <p>
                        <input id="txtSenderName" class="input_305" data-val="true" data-val-required="发货人必填" maxlength="20" name="SenderName" placeholder="请输入发货人" type="text" value="<?=$info->sendname?>">
                        <b class="red">*</b>
                    </p>
                </li>
                <li class="fpgl-tc-qxjs_6">
                    <p class="sk-hygl_7">发货人手机号：</p>
                    <p>
                        <input id="txtSenderTel" class="input_305" data-val="true" data-val-length="发货人电话长度不正确" data-val-length-max="15" data-val-length-min="11" data-val-required="发货人电话必填" maxlength="15" name="SenderTel" placeholder="请输入发货人手机号" type="text" value="<?=$info->sendphone?>">
                        <b class="red">*</b>
                    </p>
                </li>
                <style>
                .fpgl-tc-qxjs_6 select{ border: 1px solid #ddd; height:35px; width:75px;}
                </style>
            <script type="text/javascript" src="<?=base_url()?>style/area.js"></script>  
                <li class="fpgl-tc-qxjs_6">
                    <p class="sk-hygl_7"> 发货省市区：</p>
                    <p><select id="cmbProvince" name="cmbProvince"></select>  
                       <select id="cmbCity" name="cmbCity"></select>  
                       <select id="cmbArea" name="cmbArea"></select>  </p>
                </li>
               <script type="text/javascript">  
                    addressInit('cmbProvince', 'cmbCity', 'cmbArea','<?=$info->sendprovince?>','<?=$info->sendcity?>','<?=$info->senddistrict?>');  
               </script>  
                <li class="fpgl-tc-qxjs_6">
                    <p class="sk-hygl_7">发货详细地址：</p>
                    <p>
                        <textarea name="DetailAddress" id="DetailAddress" class="input_44" style="width: 300px;height: 50px;" maxlength="200" placeholder="请输入发货详细地址"><?=$info->sendaddress?></textarea>
                        <b class="red">*</b>
                    </p>
                </li>
                
                <li class="fpgl-tc-qxjs_6">
                    <p class="sk-hygl_7">上传截图：</p>
                        <p><input data-val="true" data-val-required="必须上传审核截图" id="AuditImgs" name="AuditImgs" type="hidden" value=""></p>  
                           <p style="width:10px;"></p>
                           <div>
                            <p class="sjzc_6_tu" style="margin-left: 10px;">
                                <a href="javascript:openBrowses('upfile1')"></a>   
                            </p>
                              <ul>  
                                  <a target="_blank" href="<?=base_url()?>style/images/淘宝入驻示例图.png">
                                        <li class="weui_uploader_file weui_uploader_status" style=" width: 100px;height:70px; background-size: 100px 70px; background-image:url(<?=base_url()?>style/images/淘宝入驻示例图.png)">
                                            <div class="weui_uploader_status_content"> 示例</div>
                                        </li>
                                    </a>
                              </ul>
                            <div >
                                <img id="img_preview" alt="图片预览" src="<?=$info->images?>" data-holder-rendered="true" style="width:100px; height:70px; display: block;">
                            </div>
                            <input type="file" id="upfile1" name="upfile1" style="display: none" value="">
                        </div> 
                </li>
<script>
//上传图片选择文件改变后刷新预览图
$("#upfile1").change(function(e){
    //获取目标文件
    var file = e.target.files||e.dataTransfer.files;
    //如果目标文件存在
    if(file){
        //定义一个文件阅读器
        var reader = new FileReader();
        //文件装载后将其显示在图片预览里
        reader.onload=function(){
            $(".ctl_close1").css('display','block');
            $("#img_preview").attr("src", this.result);
        }
        //装载文件
        reader.readAsDataURL(file[0]);
    }
});
 </script>
                <li class="fpgl-tc-qxjs_6">
                    <p style="width: 50%;">
                        <input type="hidden" name="userid" value="<?=$info->sid?>" >
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