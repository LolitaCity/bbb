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
            <li class="htyg_tc_1" style="font-family: Microsoft YaHei;">商家发货</li>
            <li class="htyg_tc_2"><a href="javascript:void(0)" id="imgeColse" onclick="javascript:self.parent.$.closeWin()"><img src="<?=base_url()?>style/images/sj-tc.png"></a> </li>
        </ul>
    </div>

    <script language="javascript">
        function ok() {
            var msg = '';
            if ($("#ExpressCompany").val() == '') {
                msg = "还没有填写快递公司名称", "提示";
            }
            if ($("#ExpressNumber").val() == '') {
                msg = "请填写快递单号", "提示";
            }

            if (msg != '') {
                $.openAlter(msg, "提示");
            } else {
                $("#fm").submit(); //提交表单
            }
        }
    </script>
    <style>
    .sk-zjgl_5 {
        margin-top: 0px;
    }
    </style>
<form action="<?=site_url('sales/sendGoodsDB')?>" id="fm" method="post"><style>
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
    <input id="TaskID" name="TaskID" type="hidden" value="<?=$info->tasksn?>">
    <input id="id" name="id" type="hidden" value="<?=$info->id?>">
    <div class="yctc_458 ycgl_tc_1" style="width: 650px">
            <div class="yctc_458 ycgl_tc_1" style="margin-top: 10px; margin-left: 10px">
                <ul>
                        <li style="margin-top: 10px">
                            <p class="sk-zjgl_4">
                                物流公司：</p>
                            <p >
                                <input id="ExpressCompany" name="ExpressCompany" type="text" value="" placeholder="请输入快递物流公司" style="border: 1px solid #ccc;
    width: 300px;
    height: 35px;
    line-height: 35px;
    float: left;">
                               </p>
                        </li>
                        <li class="sk-zjgl_5" style="margin-top: 10px">
                            <p class="sk-zjgl_4">
                                物流单号：</p>
                            <p >
                                <input id="ExpressNumber" name="ExpressNumber" type="text" value="" placeholder="请输入物流单号" style="border: 1px solid #ccc;
    width: 300px;
    height: 35px;
    line-height: 35px;
    float: left;">
                                </p>
                        </li>
                    <li class="sk-zjgl_5" style="margin-top: 10px">
                        <div class="d1" style="color: red; font-size: 12px; padding: 0 30px 0 20px;">
                            温馨提醒：快递单号作为判断买手是否按时收货的重要标准，请如实填写，谢谢合作~
                        </div>
                    </li>
                    <li class="fpgl-tc-qxjs_4">
                        <p>
                            <input class="input-butto100-hs" type="button" value="确定提交" id="btnSubmit" onclick="ok()">
                           <input type="hidden" id="submitCnt" value="0">
                        </p>
                        <p>
                            <input onclick="self.parent.$.closeWin()" class="input-butto100-ls" type="button" value="返回退出" id="bntColse"></p>
                    </li>
                </ul>
            </div>
        </div>
</form>


</body></html>