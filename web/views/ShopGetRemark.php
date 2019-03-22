<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title></title>
    <script src="<?=base_url()?>style/jquery-1.8.3.js.下载" type="text/javascript"></script>
    <script src="<?=base_url()?>style/jquery.jslides.js.下载" type="text/javascript"></script>
    <script src="<?=base_url()?>style/open.win.js.下载" type="text/javascript"></script>
    <script src="<?=base_url()?>style/jquery.jBox-2.3.min.js.下载" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>style/jbox.css">
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>style/common.css">
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>style/index.css">
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>style/open.win.css">
    
</head>
<body style="background: #fff;">
    <!--列表 -->
    <div class="htyg_tc">
        <ul>
            <li class="htyg_tc_1" style="font-family: Microsoft YaHei;">查看备注</li>
            <li class="htyg_tc_2">
                <a href="javascript:void(0)" id="imgeColse" onclick="javascript:self.parent.$.closeWin()">
                    <img src="<?=base_url()?>style/images/sj-tc.png">
                </a> 
            </li>
        </ul>
    </div>
    
<form action="javascript:void(0)" enctype="multipart/form-data" id="fm" method="post">        
<div class="yctc_458 ycgl_tc_1">
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
            <ul>
                <li>
                    <p class="sk-zjgl_4">消费ID：</p>
                    <p style="line-height: 35px;"><?=$shop->shopname?></p>
                </li>
                <li>
                    <p class="sk-zjgl_4">备注：</p>
                    <p class="sk-hygl_7" style="line-height: 75px;">
                        <textarea class="input_44" cols="20" id="txtRemark" maxlength="500" name="remark" readonly="readonly" rows="2" style="width:232px;height:72px"><?=$info->beizhu?></textarea>
                    </p>
                </li>
            </ul>
        </div>
</form>
</body>
</html>