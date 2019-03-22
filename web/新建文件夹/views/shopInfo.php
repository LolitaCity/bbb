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
            width: 115px;
            text-align:right;
            padding-right:10px;
        }
        .ycgl_tc_1 li p
        {
            line-height:8px;
        }
    </style>

</head>
<body style="background: #fff;">
    <!--列表 -->
    <div class="htyg_tc">
        <ul>
            <li class="htyg_tc_1" style="font-family: Microsoft YaHei;">查看详情</li>
            <li class="htyg_tc_2"><a href="javascript:void(0)" id="imgeColse" onclick="javascript:self.parent.$.closeWin()">
                <img src="<?=base_url()?>style/images/sj-tc.png"></a> </li>
        </ul>
    </div>
    
    <div style="font-family: Microsoft YaHei;" class="yctc_458 ycgl_tc_1">
        <ul>
            <li>
                <p class="sk-hygl_7">店铺类型：</p>
                <p><?=$info->type=='0'?'淘宝':'京东'?></p>
            </li>
            <li class="fpgl-tc-qxjs_6">
                <p class="sk-hygl_7">掌柜号：</p>
                <p><?=$info->manager_num?></p>
            </li>
            <li class="fpgl-tc-qxjs_6">
                <p class="sk-hygl_7">店铺名：</p>
                <p><?=$info->shopname?></p>
            </li>
            <li class="fpgl-tc-qxjs_6">
                <p class="sk-hygl_7"> 店铺性质：</p>
                <p><?=$info->nature=='0'?'个人':'公司'?></p>
            </li>
            <li class="fpgl-tc-qxjs_6">
                <p class="sk-hygl_7">发货人：</p>
                <p><?=$info->sendname?></p>
            </li>
            <li class="fpgl-tc-qxjs_6">
                <p class="sk-hygl_7">发货人手机号码：</p>
                <p><?=$info->sendphone?></p>
            </li>
            <li class="fpgl-tc-qxjs_6">
                <p class="sk-hygl_7">发货省市区：</p>
                <p><?=$info->sendarea?></p>
            </li>
            <li class="fpgl-tc-qxjs_6">
                <p class="sk-hygl_7">发货详细地址：</p>
                <div><?=$info->sendaddress?></div>
            </li>
            <li class="fpgl-tc-qxjs_6">
                <p class="sk-hygl_7">查看上传的图片：</p>
                <p>
                    <a href="<?=$info->images?>"  target="_blank" title="点击查看原图">
                        <img src="<?=$info->images?>" width="135px" height="135px">
                    </a>
                </p>
            </li>
            <li class="fpgl-tc-qxjs_6">
                <p style="text-align: center; width:100%;">
                    <input onclick="self.parent.$.closeWin()" class="input-butto100-ls" type="button" value="返回"></p>
            </li>
        </ul>
    </div>

</body>
</html>