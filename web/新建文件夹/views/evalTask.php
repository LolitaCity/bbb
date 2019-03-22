<!DOCTYPE html>
<html><head>
    <title></title>
    <link href="<?=S_CSS;?>common.css" rel="stylesheet" type="text/css">
    <link href="<?=S_CSS;?>open.win.css" rel="stylesheet" type="text/css">
    <link href="<?=S_CSS;?>index.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="<?=S_JS;?>jquery-1.8.3.min.js"></script>
    <script type="text/javascript" src="<?=S_JS;?>open.win.js"></script>
    <link rel="stylesheet" type="text/css" href="<?=S_IMAGES;?>weui.css">
    <link rel="stylesheet" type="text/css" href="<?=SITE_URL;?>myUpload/css/upimg.css">
    <script type="text/javascript" src="<?=SITE_URL;?>myUpload/js/jquery.form.js"></script>
    <script type="text/javascript" src="<?=SITE_URL;?>myUpload/js/myUpload.js"></script>
</head>
<body style="background: #fff;">
<!--列表 -->
<div class="htyg_tc">
    <ul>
        <li class="htyg_tc_1">
            评价任务 V7704000080
        </li>
        <li class="htyg_tc_2"><a href="javascript:void(0)" id="imgeColse" onclick="javascript:self.parent.$.closeWin()">
                <img src="<?=S_IMAGES;?>sj-tc.png"></a> </li>
    </ul>
</div>


<script type="text/javascript">
    $(document).ready(function () {
        if ($("#serviceValidation").length > 0) {
            $.openAlter($("#serviceValidation").text(), "提示");
        }

        $('#uploadify').change(function () {
            $("#txtfilename").val($("#uploadify").val());
            if ($.trim($("#txtfilename").val()) != "" && $("#txtfilename").val() != null) {
                $("#aShowImg").text("");
            }
        });
    })

    function openBrowse() {
        document.getElementById("uploadify").click();
        document.getElementById("txtfilename").value = document.getElementById("uploadify").value;
    }


    function Submit() {
        var lj = $("#upfile1").val();
        var ljType=GetFileName(lj);

        if (lj == "" || lj == null) {
            $.openAlter("请上传图片", "提示");
            return false;
        }

        if (ljType != '.jpg' && ljType != '.jpeg' && ljType != '.gif' && ljType != '.bmp' && ljType != '.png') {
            $.openAlter("图片凭证格式错误,仅限格式为(*.jpg,*.jpeg,*.gif,*.bmp,*.png)的格式文件.", "提示");
            return false;
        }
        $("#btnSubmint").val("提问中...");
        $("#btnSubmint").attr("class", "input-butto100-xshs");
        $("#btnSubmint").attr("onclick", "");
        $("#fm").submit();
    }


</script>
<style type="text/css">
    .tooltip
    {
        width: 98px;
        background: #fceeda;
        float: left;
        margin-right: 5px;
        display: block;
        overflow: hidden;
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
        height: auto;
    }

    .sk-hygl_7
    {
        width: 430px;
    }
    .sk-hygl_7_r
    {
        width: 120px;
        text-align: right;
    }
    .fpgl-tc-qxjs_6 p
    {
        line-height: 15px;
    }
    .input-butto100-ls
    {
        background: #4882f0 none repeat scroll 0 0;
        border-radius: 28px;
        color: #fff;
        cursor: pointer;
        height: 28px;
        line-height: 28px;
        padding-left: 0;
        text-align: center;
        width: 128px;
    }

    #aAnswer a:hover
    {
        color: Black !important;;
    }
</style>

<form action="<?php echo $this->createUrl('task/evaltask')?>" enctype="multipart/form-data" id="fm" method="post">        <!--列表 -->
    <div class="yctc_458 ycgl_tc_1" style="margin-top: 10px; width: 580px;">

        <ul>

            <li class="fpgl-tc-qxjs_6">
                <p class="sk-hygl_7_r">
                    店铺名称：</p>
                <input id="TaskID" name="TaskID" type="hidden" value="V7704000080">
                <input id="ImgName" name="ImgName" type="hidden" value="">
                <input id="PlatformOrderNumber" name="PlatformOrderNumber" type="hidden" value="87986722374282219">
                <p class="sk-hygl_7">妮彩旗舰店</p>
            </li>
            <li class="fpgl-tc-qxjs_6">
                <p class="sk-hygl_7_r">
                    商品名称：</p>
                <p class="sk-hygl_7" style="max-height: 40px;">
                    钻石画满钻异形2017新款客厅家和万事兴梅花十字绣简约现代钻石绣
                </p>
            </li>
            <li class="fpgl-tc-qxjs_6">
                <p class="sk-hygl_7_r">
                    订单编号：</p>
                <p class="sk-hygl_7">87986722374282219</p>
            </li>
            <li class="fpgl-tc-qxjs_6">
                <p class="sk-hygl_7_r">
                    佣金：</p>
                <p class="sk-hygl_7">2.00</p>
            </li>
            <li class="fpgl-tc-qxjs_6">
                <p class="sk-hygl_7_r" style="margin-top: 14px;">
                    评价内容要求：</p>
                <p class="sk-hygl_7">
                    <textarea readonly class="input_44" cols="20" data-val="true" id="Question" maxlength="40" name="Question" rows="2" style="height: 80px; width: 400px;"></textarea>
                </p>
            </li>
            <li class="fpgl-tc-qxjs_6" style="margin-top: 10px;">
            <li class="fpgl-tc-drp3">
                <p class="sk-hygl_7_r" style="position: relative; margin-top: 30px;">
                    上传评价图片：</p>
                <p class="sjzc_6_tu_3" style="margin-left: -1px;margin-right: 10px;">
                    <a target="_blank" href="" class="tooltip"></a>
                </p>
                <p class="sjzc_6_tu" style="margin-left: 10px;">
                <div id="upimg1"></div>
                <script language="javascript">
                    $("#upimg1").upload({isMulti:true, pictureInputName:'img1',defaultimg:""});
                </script>
                </p>
            </li>

            </li>
            <li class="fpgl-tc-qxjs_6">
                <p style="width: 50%;">
                    <input class="input-butto100-hs" type="button" id="btnSubmint" value="提交" onclick="Submit();" style="float: right; margin-right: 5px; width: 127px; height: 35px;">
                </p>
                <p style="width: 50%;">
                    <input onclick="self.parent.$.closeWin()" class="input-butto100-ls" type="button" style="height: 35px; float: left; margin-left: 5px;" value="返回"></p>
            </li>
        </ul>
    </div>
    <div id="sUpload1" class="weui_loading_toast" style="display: none;">
        <div class="weui_mask_transparent">
        </div>
        <div class="weui_toast">
            <div class="weui_loading">
                <!-- :) -->
                <div class="weui_loading_leaf weui_loading_leaf_0">
                </div>
                <div class="weui_loading_leaf weui_loading_leaf_1">
                </div>
                <div class="weui_loading_leaf weui_loading_leaf_2">
                </div>
                <div class="weui_loading_leaf weui_loading_leaf_3">
                </div>
                <div class="weui_loading_leaf weui_loading_leaf_4">
                </div>
                <div class="weui_loading_leaf weui_loading_leaf_5">
                </div>
                <div class="weui_loading_leaf weui_loading_leaf_6">
                </div>
                <div class="weui_loading_leaf weui_loading_leaf_7">
                </div>
                <div class="weui_loading_leaf weui_loading_leaf_8">
                </div>
                <div class="weui_loading_leaf weui_loading_leaf_9">
                </div>
                <div class="weui_loading_leaf weui_loading_leaf_10">
                </div>
                <div class="weui_loading_leaf weui_loading_leaf_11">
                </div>
            </div>
            <p class="weui_toast_content">
                图片上传中</p>
        </div>
    </div>
    <div id="sUpload1Success" style="display: none;">
        <div class="weui_mask_transparent">
        </div>
        <div class="weui_toast">
            <i class="weui_icon_toast"></i>
            <p class="weui_toast_content">
                上传完成</p>
        </div>
    </div>
</form>


</body></html>