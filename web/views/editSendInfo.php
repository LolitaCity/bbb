<!DOCTYPE html>
<html><head>
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
    
    <style type="text/css">
        .sk-hygl_7
        {
            width: 100px;
            text-align: right;
            padding-right: 10px;
        }
    </style>

</head>
<body style="background: #fff;">
    <!--列表 -->
    <div class="htyg_tc">
        <ul>
            <li class="htyg_tc_1" style="font-family: Microsoft YaHei;">
编辑发货人信息
</li>
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
<form action="<?=site_url('member/editShopDB')?>" id="fm" method="post">        
    <div class="yctc_458 ycgl_tc_1">
            <ul>
                <li>
                    <p class="sk-hygl_7">掌柜号：</p>
                    <p>
                        <input data-val="true" data-val-required="掌柜号必填" id="PlatformNoID" name="PlatformNoID" type="hidden" value="<?=$info->sid?>">
                        <input class="input_305" id="PlatformName" maxlength="20" name="PlatformName" placeholder="请输入掌柜号" readonly="readonly" style="background-color:#e3e3e3" type="text" value="<?=$info->manager_num?>"></p>
                </li>
                <li class="fpgl-tc-qxjs_6">
                    <p class="sk-hygl_7">发货人：</p>
                    <p>
                        <input class="input_305" data-val="true" data-val-required="发货人必填" id="SenderName" maxlength="20" name="SenderName" placeholder="请输入发货人" type="text" value="<?=$info->sendname?>">
                    </p>
                </li>
                <li class="fpgl-tc-qxjs_6">
                    <p class="sk-hygl_7"> 发货人电话：</p>
                    <p>
                        <input class="input_305" data-val="true" data-val-length="发货人电话长度不正确" data-val-length-max="15" data-val-length-min="11" data-val-required="发货人电话必填" id="SenderTel" maxlength="15" name="SenderTel" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))" onkeyup="value=value.replace(/[^\d\-]/g,'')" placeholder="请输入发货人电话" type="text" value="<?=$info->sendphone?>">
                    </p>
                </li>
                <li class="fpgl-tc-qxjs_6">
                <style>
                .fpgl-tc-qxjs_6 select{ border: 1px solid #ddd; height:35px; width:75px;}
                </style>
                    <script type="text/javascript" src="<?=base_url()?>style/area.js"></script>  
                    <p class="sk-hygl_7">省市区：</p>      
                    <p>
                       <select id="cmbProvince" name="cmbProvince"></select>  
                       <select id="cmbCity" name="cmbCity"></select>  
                       <select id="cmbArea" name="cmbArea"></select> 
                    <p>
               <script type="text/javascript">  
                    addressInit('cmbProvince', 'cmbCity', 'cmbArea','<?=$info->sendprovince?>','<?=$info->sendcity?>','<?=$info->senddistrict?>');  
               </script>  
                    </p>
                </li>
                <li class="fpgl-tc-qxjs_6">
                    <p class="sk-hygl_7">发货详细地址：</p>
                    <p>
                        <textarea name="DetailAddress" id="DetailAddress" class="input_44" style="width: 300px; height: 50px;" maxlength="200" placeholder="请输入发货详细地址"><?=$info->sendaddress?></textarea>
                    </p>
                </li>
                
                <li class="fpgl-tc-qxjs_6">
                    <p>
                        <b>温馨提示：</b></p>
                    <p>
                        发货人信息会显示在快递单上，所以请如实填写。
                    </p>
                </li>
                <li class="fpgl-tc-qxjs_6">
                    <p style="width: 50%;">
                        <input class="input-butto100-hs" type="submit" id="btnSubmint" value="提交"  style="float: right; margin-right: 5px;">
                    </p>
                    <p style="width: 50%;">
                        <input onclick="self.parent.$.closeWin()" class="input-butto100-ls" type="button" style="height: 35px; float: left; margin-left: 5px;" value="返回"></p>
                </li>
            </ul>
        </div>
</form>


</body></html>