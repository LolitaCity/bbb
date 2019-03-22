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
    
</head>
<body style="background: #fff;">
    <!--列表 -->
    <div class="htyg_tc">
        <ul>
            <li class="htyg_tc_1" style="font-family: Microsoft YaHei;">
买号购买行为
</li>
            <li class="htyg_tc_2"><a href="javascript:void(0)" id="imgeColse" onclick="javascript:self.parent.$.closeWin()">
                <img src="<?=base_url()?>style/images/sj-tc.png"></a> </li>
        </ul>
    </div>
    
    <link href="<?=base_url()?>style/cssOne.css" rel="stylesheet" type="text/css">
    <script src="<?=base_url()?>style/jquery-1.11.2.min.js" type="text/javascript"></script>
    <script src="<?=base_url()?>style/antiman.js" type="text/javascript"></script>
    <script src="<?=base_url()?>style/jquery.jBox-2.3.min.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>style/jbox.css">
    <script language="javascript" type="text/javascript">
        function changeBar(obj, operator, id) {
            var count = $("#" + id).val();
            if (count == "" || count == null) {
                $("#" + id).val("0");
                return;
            }
            if (operator == "+") {
                //用户点的+号
                //alert($(obj).parent().prev().prev().firstChild);
                $(obj).parent().prev().prev().children().eq(0).css("color", "black");  
                count++;
                if (id == "ProductCompare3" || id == "InsideShopStay10" || id == "BrowseShopP3" ) {
                    if (count >= 50) {
                        $("#" + id).val(50);
                        $(obj).css("color", "gray");
                        return;
                    }
                }
                if (count >= 100) {
                    //$.messager.alert('提示', "数量不能超过100", 'error');
                    $("#" + id).val(100);
                    $(obj).css("color", "gray");
                    count = 100;
                    //return;
                }else {
                    //count++;
                }
            }
            else {
                //用户点的-号
                $(obj).parent().next().next().children().eq(0).css("color", "black"); //先将+号的颜色恢复原状
                count--;
                if (count <= 0) {
                    //$.messager.alert('提示', "数量不能小于0", 'error');
                    $("#" + id).val(0);
                    $(obj).css("color", "gray");
                    count = 0;
                    //return;
                } else {
                    //count--;
                }
            }
            $("#" + id).val(count);
        }

        $(".fb2_table1 input").live("keyup", function () {
            var count = $(this).val();
            var id = $(this).attr("id");
            $(this).parent().prev().children().eq(0).css("color", "black");
            $(this).parent().next().children().eq(0).css("color", "black");
            if (count == "") {
                return;
            }
            if (id == "ProductCompare3") {
                if (count <= 0) {
                    $(this).parent().prev().children().eq(0).css("color", "gray");
                    return;
                }else if (count >= 50) {
                    $("#" + id).val(50);
                    $(this).parent().next().children().eq(0).css("color", "gray");
                    return;
                }else {
                    $(this).parent().prev().children().eq(0).css("color", "black");
                    $(this).parent().next().children().eq(0).css("color", "black");
                    return;
                }
            }
            if (id == "PlatformNoAcceptPeriod3") {
                if (count <= 0) {
                    $(this).parent().prev().children().eq(0).css("color", "gray");
                    return;
                } else {
                    $(this).parent().prev().children().eq(0).css("color", "black");
                    $(this).parent().next().children().eq(0).css("color", "black");
                    return;
                }
            }
            if (id == "BrowseShopP3") {
                if (count <= 0) {
                    $(this).parent().prev().children().eq(0).css("color", "gray");
                    return;
                } else if (count >= 50) {
                    $("#" + id).val(50);
                    $(this).parent().next().children().eq(0).css("color", "gray");
                    return;
                } else {
                    $(this).parent().prev().children().eq(0).css("color", "black");
                    $(this).parent().next().children().eq(0).css("color", "black");
                    return;
                }
            }
            if (id == "InsideShopStay10") {
                if (count <= 0) {
                    $(this).parent().prev().children().eq(0).css("color", "gray");
                    return;
                }else if (count >= 50) {
                    $("#" + id).val(50);
                    $(this).parent().next().children().eq(0).css("color", "gray");
                    return;
                }else {
                    $(this).parent().prev().children().eq(0).css("color", "black");
                    $(this).parent().next().children().eq(0).css("color", "black");
                    return;
                }
            }
            if (count <= 0) {
                $("#" + id).val(0);
                $(this).parent().prev().children().eq(0).css("color", "gray");
                count = 0;
            }else if (count >= 100) {
                $("#" + id).val(100);
                $(this).parent().next().children().eq(0).css("color", "gray");
                count = 100;
            } else {
                $(this).parent().prev().children().eq(0).css("color", "black");
                $(this).parent().next().children().eq(0).css("color", "black");
            }

        });

        function save() {
            $("#serviceValidation").remove();
            $("#clientValidationOL").html("");
            $("#serviceValidation").hide();
            var ShopCollect = parseInt($("#ShopCollect").val());
            if (isNaN(ShopCollect)) {
                $("<li>收藏店铺处请输入数字</li>").appendTo($("#clientValidationOL"));
                $("#clientValidation").show();
                return false;
            }
            if (ShopCollect > 100 || ShopCollect < 0) {
                $("<li>收藏店铺处比例为0-100%之间</li>").appendTo($("#clientValidationOL"));
                $("#clientValidation").show();
                return false;
            }

            var ProductCollect = parseInt($("#ProductCollect").val());
            if (isNaN(ProductCollect)) {
                $("<li>产品收藏处请输入数字</li>").appendTo($("#clientValidationOL"));
                $("#clientValidation").show();
                return false;
            }
            if (ProductCollect > 100 || ProductCollect < 0) {
                $("<li>产品收藏处比例为0-100%之间</li>").appendTo($("#clientValidationOL"));
                $("#clientValidation").show();
                return false;
            }


            var BeforeBuyTalk = parseInt($("#BeforeBuyTalk").val());
            if (isNaN(BeforeBuyTalk)) {
                $("<li>拍前聊请输入数字</li>").appendTo($("#clientValidationOL"));
                $("#clientValidation").show();
                return false;
            }
            if (BeforeBuyTalk > 100 || BeforeBuyTalk < 0) {
                $("<li>拍前聊 比例为0-100%之间</li>").appendTo($("#clientValidationOL"));
                $("#clientValidation").show();
                return false;
            }

            var ProductCompareNot = parseInt($("#ProductCompareNot").val());
            if (isNaN(ProductCompareNot)) {
                $("<li>不货比处请输入数字</li>").appendTo($("#clientValidationOL"));
                $("#clientValidation").show();
                return false;
            }
            var ProductCompare1 = parseInt($("#ProductCompare1").val());
            if (isNaN(ProductCompare1)) {
                $("<li>货比一家处请输入数字</li>").appendTo($("#clientValidationOL"));
                $("#clientValidation").show();
                return false;
            }
            var ProductCompare2 = parseInt($("#ProductCompare2").val());
            if (isNaN(ProductCompare2)) {
                $("<li>货比两家处请输入数字</li>").appendTo($("#clientValidationOL"));
                $("#clientValidation").show();
                return false;
            }
            var ProductCompare3 = parseInt($("#ProductCompare3").val());
            if (isNaN(ProductCompare3)) {
                $("<li>货比三家处请输入数字</li>").appendTo($("#clientValidationOL"));
                $("#clientValidation").show();
                return false;
            }
            if (ProductCompare3 > 50 || ProductCompare3 < 0) {
                $("<li>货比三家处比例为0-50%之间</li>").appendTo($("#clientValidationOL"));
                $("#clientValidation").show();
                return false;
            }
            if (ProductCompareNot + ProductCompare1 + ProductCompare2 + ProductCompare3 != 100) {
                $("<li>货比X家处相加比例必须为100</li>").appendTo($("#clientValidationOL"));
                $("#clientValidation").show();
                return false;
            }


            var BrowseShopPNot = parseInt($("#BrowseShopPNot").val());
            if (isNaN(BrowseShopPNot)) {
                $("<li>浏览深度(不浏览)请输入数字</li>").appendTo($("#clientValidationOL"));
                $("#clientValidation").show();
                return false;
            }
            var BrowseShopP1 = parseInt($("#BrowseShopP1").val());
            if (isNaN(BrowseShopP1)) {
                $("<li>浏览深度(店内一款)请输入数字</li>").appendTo($("#clientValidationOL"));
                $("#clientValidation").show();
                return false;
            }
            var BrowseShopP2 = parseInt($("#BrowseShopP2").val());
            if (isNaN(BrowseShopP2)) {
                $("<li>浏览深度(店内2款)请输入数字</li>").appendTo($("#clientValidationOL"));
                $("#clientValidation").show();
                return false;
            }
            var BrowseShopP3 = parseInt($("#BrowseShopP3").val());
            if (isNaN(BrowseShopP3)) {
                $("<li>浏览深度(店内3款)请输入数字</li>").appendTo($("#clientValidationOL"));
                $("#clientValidation").show();
                return false;
            }
            if (BrowseShopP3 > 50 || BrowseShopP3 < 0) {
                $("<li>浏览深度(店内3款)比例为0-50%之间</li>").appendTo($("#clientValidationOL"));
                $("#clientValidation").show();
                return false;
            }
            if (BrowseShopPNot + BrowseShopP1 + BrowseShopP2 + BrowseShopP3 != 100) {
                $("<li>浏览深度处相加比例必须为100</li>").appendTo($("#clientValidationOL"));
                $("#clientValidation").show();
                return false;
            }


            var InsideShopStayNot = parseInt($("#InsideShopStayNot").val());
            if (isNaN(InsideShopStayNot)) {
                $("<li>停留时间(不限制)处请输入数字</li>").appendTo($("#clientValidationOL"));
                $("#clientValidation").show();
                return false;
            }

            var InsideShopStay5 = parseInt($("#InsideShopStay5").val());
            if (isNaN(InsideShopStay5)) {
                $("<li>停留时间(5分钟)处请输入数字</li>").appendTo($("#clientValidationOL"));
                $("#clientValidation").show();
                return false;
            }

            var InsideShopStay10 = parseInt($("#InsideShopStay10").val());
            if (isNaN(InsideShopStay10)) {
                $("<li>停留时间(10分钟)处请输入数字</li>").appendTo($("#clientValidationOL"));
                $("#clientValidation").show();
                return false;
            }
            if (InsideShopStay10 > 50 || InsideShopStay10 < 0) {
                $("<li>停留时间(10分钟)比例为0-50%之间</li>").appendTo($("#clientValidationOL"));
                $("#clientValidation").show();
                return false;
            }
            if (InsideShopStayNot + InsideShopStay5 + InsideShopStay10 != 100) {
                $("<li>停留时间处相加比例必须为100</li>").appendTo($("#clientValidationOL"));
                $("#clientValidation").show();
                return false;
            }
            $("#fm").submit();
        }

        function DefauleSet()
        {
            $("#defauleSet").text("设置中...");
            $("#ShopCollect").val(20);
            $("#ProductCollect").val(50);
            $("#BeforeBuyTalk").val(50);
            $("#ProductCompareNot").val(10);
            $("#ProductCompare1").val(30);
            $("#ProductCompare2").val(40);
            $("#ProductCompare3").val(20);
            $("#BrowseShopPNot").val(10);
            $("#BrowseShopP1").val(50);
            $("#BrowseShopP2").val(30);
            $("#BrowseShopP3").val(10);
            $("#InsideShopStayNot").val(20);
            $("#InsideShopStay5").val(60);
            $("#InsideShopStay10").val(20);                    
            $("#defauleSet").text("使用推荐比例");
        }
       </script>
    <style type="text/css">
        /*这是新追加的*/
        
        .fb_bqx
        {
            padding: 10px 23px;
            color: #fff;
            background-color: #00b2bd;
            text-decoration: none;
            border-radius: 3px;
            text-align: center;
            float: left;
            border: 0;
            margin-right: 10px;
            cursor: pointer;
            -webkit-transition: all 0.25s ease-in;
            -ms-transition: all 0.25s ease-in;
            -moz-transition: all 0.25s ease-in;
            transition: all 0.25s ease-in;
            -o-transition: all 0.25s ease-in;
            letter-spacing: 2px;
            margin-bottom: 50px;
            font-size: larger;
        }
        .fb_bqx:hover
        {
            background: #dd4232;
            border-radius: 10px;
        }
        
        .fb_tjnn
        {
            margin-left: 150px;
        }
        
        tr
        {
            display: block; /*将tr设置为块体元素*/
            margin-top: 8px; /*设置tr间距为2px*/
        }
        
        .ulcalc
        {
            margin: 0;
            padding: 0;
            list-style-type: none;
            overflow: hidden;
            border: 1px solid #d9d9d9;
            width: 96px;
            font-size: 12px;
        }
        .ulcalc .lil
        {
            list-style-type: none;
            float: left;
            width: 24px;
            padding: 0 0px 0 0px;
            text-align: center;
            font-size: 24px;
            background-color: #e1e1e1;
            color: #a8a3a3;
            cursor: pointer;
            font-family: inherit;
            font-weight: inherit;
            font-variant: normal;
        }
        .ulcalc .lic
        {
            list-style-type: none;
            float: left;
            width: 45px;
            border-right: 1px solid #d9d9d9;
            border-left: 1px solid #d9d9d9;
            padding: 0 1px 0 0;
        }
        .ulcalc .lic .inp
        {
            width: 22px;
            border: none;
            padding: 2px 0 2px 3px;
        }
        .ulcalc .lir
        {
            list-style-type: none;
            float: left;
            width: 24px;
            text-align: center;
            font-size: 24px;
            background-color: #e1e1e1;
            cursor: pointer;
        }
        
        .fb2_table1 a
        {
            display: inline;
            width: 24px;
            height: 25px;
            color: black;
        }
        
        tr
        {
            margin-top: 30px;
        }
        
        td
        {
            border-width: 0 0 0 0;
        }
    </style>
<form action="<?=site_url('member/setproDB')?>" id="fm" method="post">        
<div class="fb2_table1" style="overflow-y: auto; width: 100%;">
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
            <div class="errorbox" id="clientValidation" style="display: none; width: 95%;">
                <ol style="list-style-type: decimal" id="clientValidationOL">
                </ol>
            </div>
            <div class="">
                <div style="margin-left: 20px;">
                    <table>
                        <tbody>
                        <tr>
                            <td align="right" style="width: 75px;">
                                <span style="font-size: 15px">收藏店铺:</span>
                            </td>
                            <td align="right" style="width: 75px;">
                                <label style="margin-left: 10px; margin-right: 5px;"></label>
                            </td>
                            <td>
                                <ul class="ulcalc">
                                    <li class="lil"><a title="减一" style="margin: 1px; text-decoration: none;" onclick="changeBar(this,'-','ShopCollect')">-</a></li>
                                    <li class="lic"><input data-val="true" data-val-number="字段 ShopCollect 必须是一个数字。" data-val-range="范围为0-100之间" data-val-range-max="100" data-val-range-min="0" data-val-required="ShopCollect 字段是必需的。" id="ShopCollect" maxlength="3" name="ShopCollect" onkeyup="value=value.replace(/[^0-9]/g,'')" style="width: 30px; border: none; padding: 5px 0 5px 0; text-align: center;" type="text" value="<?=$info->bookmark==''?'20':$info->bookmark?>"><span class="inp">%</span></li>
                                    <li class="lir"><a title="加一" style="margin: 1px; text-decoration: none;" onclick="changeBar(this,'+','ShopCollect')">+</a></li>
                                </ul>
                            </td>
                        </tr>
                        <tr>
                            <td align="right" style="width: 75px;">
                                <span style="font-size: 15px">收藏商品:</span>
                            </td>
                            <td align="right" style="width: 75px;">
                                <label style="margin-left: 10px; margin-right: 5px;"></label>
                            </td>
                            <td>
                                <ul class="ulcalc">
                                    <li class="lil"><a title="减一" style="margin: 1px; text-decoration: none;" onclick="changeBar(this,'-','ProductCollect')">-</a></li>
                                    <li class="lic"><input data-val="true" data-val-number="字段 ProductCollect 必须是一个数字。" data-val-range="范围为0-100之间" data-val-range-max="100" data-val-range-min="0" data-val-required="ProductCollect 字段是必需的。" id="ProductCollect" maxlength="3" name="ProductCollect" onkeyup="value=value.replace(/[^0-9]/g,'')" style="width: 30px; border: none; padding: 5px 0 5px 0; text-align: center;" type="text" value="<?=$info->bookmark==''?'50':$info->c_goods?>"><span class="inp">%</span></li>
                                    <li class="lir"><a title="加一" style="margin: 1px; text-decoration: none;" onclick="changeBar(this,'+','ProductCollect')">+</a></li>
                                </ul>
                            </td>
                        </tr>
                        <tr>
                            <td align="right" style="width: 75px;">
                                <span style="font-size: 15px">拍前聊:</span>
                            </td>
                            <td align="right" style="width: 72px;">
                                <label style="margin-left: 10px; margin-right: 5px;"></label>
                            </td>
                            <td>
                                <ul class="ulcalc">
                                    <li class="lil"><a title="减一" style="margin: 1px; text-decoration: none;" onclick="changeBar(this,'-','BeforeBuyTalk')">-</a></li>
                                    <li class="lic"><input data-val="true" data-val-number="字段 BeforeBuyTalk 必须是一个数字。" data-val-range="范围为0-100之间" data-val-range-max="100" data-val-range-min="0" data-val-required="BeforeBuyTalk 字段是必需的。" id="BeforeBuyTalk" maxlength="3" name="BeforeBuyTalk" onkeyup="value=value.replace(/[^0-9]/g,'')" style="width: 30px; border: none; padding: 5px 0 5px 0; text-align: center;" type="text" value="<?=$info->bookmark==''?'50':$info->talk?>"><span class="inp">%</span></li>
                                    <li class="lir"><a title="加一" style="margin: 1px; text-decoration: none;" onclick="changeBar(this,'+','BeforeBuyTalk')">+</a></li>
                                </ul>
                            </td>
                        </tr>
                        <tr>
                            <td align="right" style="width: 75px;">
                                <span style="font-size: 15px">货比X家:</span>
                            </td>
                            <td align="right" style="width: 80px;">
                                <label style="margin-left: 10px; margin-right: 5px;">不货比</label>
                            </td>
                            <?php
                            $no='10';
                            $one='30';
                            $two='40';
                            $three='20';
                                if($info->x_home!=''){
                                    $info11 = unserialize($info->x_home);
                                    $no=$info11['not'];
                                    $one=$info11['com1'];
                                    $two=$info11['com2'];
                                    $three=$info11['com3'];
                                }
                            ?>
                            <td>
                                <ul class="ulcalc">
                                    <li class="lil"><a title="减一" style="margin: 1px; text-decoration: none;" onclick="changeBar(this,'-','ProductCompareNot')">-</a></li>
                                    <li class="lic"><input data-val="true" data-val-number="字段 ProductCompareNot 必须是一个数字。" data-val-range="范围为0-100之间" data-val-range-max="100" data-val-range-min="0" data-val-required="ProductCompareNot 字段是必需的。" id="ProductCompareNot" maxlength="3" name="ProductCompareNot" onkeyup="value=value.replace(/[^0-9]/g,'')" style="width: 30px; border: none; padding: 5px 0 5px 0; text-align: center;" type="text" value="<?=$no?>"><span class="inp">%</span></li>
                                    <li class="lir"><a title="加一" style="margin: 1px; text-decoration: none;" onclick="changeBar(this,'+','ProductCompareNot')">+</a></li>
                                </ul>
                            </td>
                            <td align="right" style="width: 80px;">
                                <label style="margin-left: 15px; margin-right: 5px;">货比一家</label>
                            </td>
                            <td>
                                <ul class="ulcalc">
                                    <li class="lil"><a title="减一" style="margin: 1px; text-decoration: none;" onclick="changeBar(this,'-','ProductCompare1')">-</a></li>
                                    <li class="lic"><input data-val="true" data-val-number="字段 ProductCompare1 必须是一个数字。" data-val-range="范围为0-100之间" data-val-range-max="100" data-val-range-min="0" data-val-required="ProductCompare1 字段是必需的。" id="ProductCompare1" maxlength="3" name="ProductCompare1" onkeyup="value=value.replace(/[^0-9]/g,'')" style="width: 30px; border: none; padding: 5px 0 5px 0; text-align: center;" type="text" value="<?=$one?>"><span class="inp">%</span></li>
                                    <li class="lir"><a title="加一" style="margin: 1px; text-decoration: none;" onclick="changeBar(this,'+','ProductCompare1')">+</a></li>
                                </ul>
                            </td>
                            <td align="right" style="width: 80px;">
                                <label style="margin-left: 10px; margin-right: 5px;">货比两家</label>
                            </td>
                            <td>
                                <ul class="ulcalc">
                                    <li class="lil"><a title="减一" style="margin: 1px; text-decoration: none;" onclick="changeBar(this,'-','ProductCompare2')">-</a></li>
                                    <li class="lic"><input data-val="true" data-val-number="字段 ProductCompare2 必须是一个数字。" data-val-range="范围为0-100之间" data-val-range-max="100" data-val-range-min="0" data-val-required="ProductCompare2 字段是必需的。" id="ProductCompare2" maxlength="3" name="ProductCompare2" onkeyup="value=value.replace(/[^0-9]/g,'')" style="width: 30px; border: none; padding: 5px 0 5px 0; text-align: center;" type="text" value="<?=$two?>"><span class="inp">%</span></li>
                                    <li class="lir"><a title="加一" style="margin: 1px; text-decoration: none;" onclick="changeBar(this,'+','ProductCompare2')">+</a></li>
                                </ul>
                            </td>
                            <td align="right" style="width: 80px;">
                                <label style="margin-left: 15px; margin-right: 5px;">货比三家</label>
                            </td>
                            <td>
                                <ul class="ulcalc">
                                    <li class="lil"><a title="减一" style="margin: 1px; text-decoration: none;" onclick="changeBar(this,'-','ProductCompare3')">-</a></li>
                                    <li class="lic"><input data-val="true" data-val-number="字段 ProductCompare3 必须是一个数字。" data-val-range="范围为0-100之间" data-val-range-max="100" data-val-range-min="0" data-val-required="ProductCompare3 字段是必需的。" id="ProductCompare3" maxlength="3" name="ProductCompare3" onkeyup="value=value.replace(/[^0-9]/g,'')" style="width: 30px; border: none; padding: 5px 0 5px 0; text-align: center;" type="text" value="<?=$three?>"><span class="inp">%</span></li>
                                    <li class="lir"><a title="加一" style="margin: 1px; text-decoration: none;" onclick="changeBar(this,'+','ProductCompare3')">+</a></li>
                                </ul>
                            </td>
                        </tr>
                        <tr>
                            <td align="right" style="text-align: right; width: 75px;">
                                <span style="font-size: 15px">浏览深度:</span>
                            </td>
                            <?php
                            $noshop='10';
                            $oneshop='50';
                            $twoshop='30';
                            $threeshop='10';
                            if($info->deep!=''){
                                $info22 = unserialize($info->deep);
                                $noshop=$info22['net'];
                                $oneshop=$info22['shop1'];
                                $twoshop=$info22['shop2'];
                                $threeshop=$info22['shop3'];
                            }
                            ?>
                            <td align="right" style="width: 80px;">
                                <label style="margin-left: 2px; margin-right: 5px;">不浏览</label>
                            </td>
                            <td>
                                <ul class="ulcalc"> 
                                    <li class="lil"><a title="减一" style="margin: 1px; text-decoration: none;" onclick="changeBar(this,'-','BrowseShopPNot')">-</a></li>
                                    <li class="lic"><input data-val="true" data-val-number="字段 BrowseShopPNot 必须是一个数字。" data-val-range="范围为0-100之间" data-val-range-max="100" data-val-range-min="0" data-val-required="BrowseShopPNot 字段是必需的。" id="BrowseShopPNot" maxlength="3" name="BrowseShopPNot" onkeyup="value=value.replace(/[^0-9]/g,'')" style="width: 30px; border: none; padding: 5px 0 5px 0; text-align: center;" type="text" value="<?=$noshop?>"><span class="inp">%</span></li>
                                    <li class="lir"><a title="加一" style="margin: 1px; text-decoration: none;" onclick="changeBar(this,'+','BrowseShopPNot')">+</a></li>
                                </ul>
                            </td>
                            <td align="right" style="width: 80px;">
                                <label style="margin-left: 2px; margin-right: 5px;">店内一款</label>
                            </td>
                            <td>
                                <ul class="ulcalc">
                                    <li class="lil"><a title="减一" style="margin: 1px; text-decoration: none;" onclick="changeBar(this,'-','BrowseShopP1')">-</a></li>
                                    <li class="lic"><input data-val="true" data-val-number="字段 BrowseShopP1 必须是一个数字。" data-val-range="范围为0-100之间" data-val-range-max="100" data-val-range-min="0" data-val-required="BrowseShopP1 字段是必需的。" id="BrowseShopP1" maxlength="3" name="BrowseShopP1" onkeyup="value=value.replace(/[^0-9]/g,'')" style="width: 30px; border: none; padding: 5px 0 5px 0; text-align: center;" type="text" value="<?=$oneshop?>"><span class="inp">%</span></li>
                                    <li class="lir"><a title="加一" style="margin: 1px; text-decoration: none;" onclick="changeBar(this,'+','BrowseShopP1')">+</a></li>
                                </ul>
                            </td>
                            <td align="right" style="width: 80px;">
                                <label style="margin-left: 2px; margin-right: 5px;">店内两款</label>
                            </td>
                            <td>
                                <ul class="ulcalc">
                                    <li class="lil"><a title="减一" style="margin: 1px; text-decoration: none;" onclick="changeBar(this,'-','BrowseShopP2')">-</a></li>
                                    <li class="lic"><input data-val="true" data-val-number="字段 BrowseShopP2 必须是一个数字。" data-val-range="范围为0-100之间" data-val-range-max="100" data-val-range-min="0" data-val-required="BrowseShopP2 字段是必需的。" id="BrowseShopP2" maxlength="3" name="BrowseShopP2" onkeyup="value=value.replace(/[^0-9]/g,'')" style="width: 30px; border: none; padding: 5px 0 5px 0; text-align: center;" type="text" value="<?=$twoshop?>"><span class="inp">%</span></li>
                                    <li class="lir"><a title="加一" style="margin: 1px; text-decoration: none;" onclick="changeBar(this,'+','BrowseShopP2')">+</a></li>
                                </ul>
                            </td>
                            <td align="right" style="width: 80px;">
                                <label style="margin-left: 2px; margin-right: 5px;">店内三款</label>
                            </td>
                            <td>
                                <ul class="ulcalc">
                                    <li class="lil"><a title="减一" style="margin: 1px; text-decoration: none;" onclick="changeBar(this,'-','BrowseShopP3')">-</a></li>
                                    <li class="lic"><input data-val="true" data-val-number="字段 BrowseShopP3 必须是一个数字。" data-val-range="范围为0-100之间" data-val-range-max="100" data-val-range-min="0" data-val-required="BrowseShopP3 字段是必需的。" id="BrowseShopP3" maxlength="3" name="BrowseShopP3" onkeyup="value=value.replace(/[^0-9]/g,'')" style="width: 30px; border: none; padding: 5px 0 5px 0; text-align: center;" type="text" value="<?=$threeshop?>"><span class="inp">%</span></li>
                                    <li class="lir"><a title="加一" style="margin: 1px; text-decoration: none;" onclick="changeBar(this,'+','BrowseShopP3')">+</a></li>
                                </ul>
                            </td>
                        </tr>
                        <tr>
                            <td align="right" style="text-align: right; width: 75px;">
                                <span style="font-size: 15px">停留时间:</span>
                            </td>

                            <?php
                            $not='20';
                            $stay5='60';
                            $stay10='20';
                            if($info->sitetime!=''){
                                $info333 = unserialize($info->sitetime);
                                $not=$info333['not'];
                                $stay5=$info333['stay5'];
                                $stay10=$info333['stay10'];
                            }
                            ?>
                            <td align="right" style="width: 80px;">
                                <label style="margin-left: 2px; margin-right: 5px;">不限制</label>
                            </td>
                            <td>
                                <ul class="ulcalc">
                                    <li class="lil"><a title="减一" style="margin: 1px; text-decoration: none;" onclick="changeBar(this,'-','InsideShopStayNot')">-</a></li>
                                    <li class="lic"><input data-val="true" data-val-number="字段 InsideShopStayNot 必须是一个数字。" data-val-range="范围为0-100之间" data-val-range-max="100" data-val-range-min="0" data-val-required="InsideShopStayNot 字段是必需的。" id="InsideShopStayNot" maxlength="3" name="InsideShopStayNot" onkeyup="value=value.replace(/[^0-9]/g,'')" style="width: 30px; border: none; padding: 5px 0 5px 0; text-align: center;" type="text" value="<?=$not?>"><span class="inp">%</span></li>
                                    <li class="lir"><a title="加一" style="margin: 1px; text-decoration: none;" onclick="changeBar(this,'+','InsideShopStayNot')">+</a></li>
                                </ul>
                            </td>
                            <td align="right" style="width: 80px;">
                                <label style="margin-left: 2px; margin-right: 5px;">五分钟</label>
                            </td>
                            <td>
                                <ul class="ulcalc">
                                    <li class="lil"><a title="减一" style="margin: 1px; text-decoration: none;" onclick="changeBar(this,'-','InsideShopStay5')">-</a></li>
                                    <li class="lic"><input data-val="true" data-val-number="字段 InsideShopStay5 必须是一个数字。" data-val-range="范围为0-100之间" data-val-range-max="100" data-val-range-min="0" data-val-required="InsideShopStay5 字段是必需的。" id="InsideShopStay5" maxlength="3" name="InsideShopStay5" onkeyup="value=value.replace(/[^0-9]/g,'')" style="width: 30px; border: none; padding: 5px 0 5px 0; text-align: center;" type="text" value="<?=$stay5?>"><span class="inp">%</span></li>
                                    <li class="lir"><a title="加一" style="margin: 1px; text-decoration: none;" onclick="changeBar(this,'+','InsideShopStay5')">+</a></li>
                                </ul>
                            </td>
                            <td align="right" style="width: 80px;">
                                <label style="margin-left: 2px; margin-right: 5px;">十分钟</label>
                            </td>
                            <td>
                                <ul class="ulcalc">
                                    <li class="lil"><a title="减一" style="margin: 1px; text-decoration: none;" onclick="changeBar(this,'-','InsideShopStay10')">-</a></li>
                                    <li class="lic"><input data-val="true" data-val-number="字段 InsideShopStay10 必须是一个数字。" data-val-range="范围为0-100之间" data-val-range-max="100" data-val-range-min="0" data-val-required="InsideShopStay10 字段是必需的。" id="InsideShopStay10" maxlength="3" name="InsideShopStay10" onkeyup="value=value.replace(/[^0-9]/g,'')" style="width: 30px; border: none; padding: 5px 0 5px 0; text-align: center;" type="text" value="<?=$stay10?>"><span class="inp">%</span></li>
                                    <li class="lir"><a title="加一" style="margin: 1px; text-decoration: none;" onclick="changeBar(this,'+','InsideShopStay10')">+</a></li>
                                </ul>
                            </td>
                        </tr>
                    </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="yctc_458 ycgl_tc_1">
            <ul>
                <li class="fpgl-tc-qxjs_4" style="position: fixed; bottom: 15px; margin-left: 30px;">
                    <p><input onclick="DefauleSet()" class="input-butto100-ls" type="button" value="使用推荐比例"></p>
                    <p><input class="input-butto100-hs" type="button" value="保存" onclick="save()"></p>
                    <p><input onclick="self.parent.$.closeWin()" class="input-butto100-ls" type="button" value="取消"></p>
                </li>
            </ul>
        </div>
        <input class="input-butto100-ls" type="hidden" name="ProductID" value="<?=$info->id?>" >
</form>


</body></html>