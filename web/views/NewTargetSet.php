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
	<script src="<?=base_url()?>style/ext/public.js" type="text/javascript"></script>

</head>
<body style="background: #fff;">
    <!--列表 -->
    <!--<div class="htyg_tc">
        <ul>
            <li class="htyg_tc_1" style="font-family: Microsoft YaHei;">目标客户设置</li>
            <li class="htyg_tc_2"><a href="javascript:void(0)" id="imgeColse" onclick="javascript:self.parent.$.closeWin()">
                <img src="<?=base_url()?>style/images/sj-tc.png"></a> </li>
        </ul>
    </div>-->
    
    <link href="<?=base_url()?>style/cssOne.css" rel="stylesheet" type="text/css">
    <script src="<?=base_url()?>style/jquery-1.11.2.min.js" type="text/javascript"></script>
    <script src="<?=base_url()?>style/antiman.js" type="text/javascript"></script>
    <script src="<?=base_url()?>style/jquery.jBox-2.3.min.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>style/jbox.css">
    <script language="javascript" type="text/javascript">
        $(document).ready(function () {
            $("input[type='text']").each(function () {
                if ($(this).val() == "" || $(this).val() == null) {
                    if ($(this).attr("id") == "PercentPlatformNoLevel1") {
                        $(this).val("80")
                    }
                    else if ($(this).attr("id") == "PercentPlatformNoLevel2") {
                        $(this).val("20")
                    }
                    //                    else if ($(this).attr("id") == "PercentPlatformNoLevel3") {
                    //                        $(this).val("10")
                    //                    }
                    else {
                        $(this).val("0");
                        $(this).parent().prev().children().eq(0).css("color", "gray");
                    }
                }
                else {
                    if ($(this).attr("id") == "PercentPlatformNoLevel1") {
                        if ($(this).val() == "50") {
                            $(this).parent().prev().children().eq(0).css("color", "gray");
                        }
                        if ($(this).val() == "100") {
                            $(this).parent().next().children().eq(0).css("color", "gray");
                        }
                    }
                    if ($(this).attr("id") == "PercentPlatformNoLevel2") {
                        if ($(this).val() == "0") {
                            $(this).parent().prev().children().eq(0).css("color", "gray");
                        }
                        if ($(this).val() == "40") {
                            $(this).parent().next().children().eq(0).css("color", "gray");
                        }
                    }
                    if ($(this).attr("id") == "PercentPlatformNoLevel3") {
                        if ($(this).val() == "0") {
                            $(this).parent().prev().children().eq(0).css("color", "gray");
                        }
                        if ($(this).val() == "20") {
                            $(this).parent().next().children().eq(0).css("color", "gray");
                        }
                    }
                    if ($(this).val() == "0") {
                        $(this).parent().prev().children().eq(0).css("color", "gray");
                    }
                    if ($(this).val() == "100") {
                        $(this).parent().next().children().eq(0).css("color", "gray");
                    }
                }
            })
        })
        function Cancel() {
            var type = window.location.search;
            if (type.indexOf("publish") > -1)
                history.back();
            else
                window.close();
        }
        function changeBar(obj, operator, id) {
            var count = $("#" + id).val();
            if (count == "" || count == null) {
                $("#" + id).val("0");
                return;
            }
            if (operator == "+") {
                //用户点的+号
                //alert($(obj).parent().prev().prev().firstChild);
                $(obj).parent().prev().prev().children().eq(0).css("color", "black");  //先将-号的颜色恢复原状
                count++;
                if (id == "PercentPlatformNoLevel1") {
                    if (count >= 100) {
                        //$.messager.alert('提示', "初级买家比例为50-70%", 'error');
                        $("#" + id).val(100);
                        $(obj).css("color", "gray");
                        return;
                    }
                }
                if (id == "PercentPlatformNoLevel2") {
                    if (count >= 40) {
                        //$.messager.alert('提示', "中等买家比例为20-40%", 'error');
                        $("#" + id).val(40);
                        $(obj).css("color", "gray");
                        return;
                    }
                }
                if (id == "PercentPlatformNoLevel3") {
                    if (count >= 20) {
                        //$.messager.alert('提示', "资深买家比例为0-20%", 'error');
                        $("#" + id).val(20);
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
                }
                else {
                    //count++;
                }
            }
            else {
                //用户点的-号

                $(obj).parent().next().next().children().eq(0).css("color", "black"); //先将+号的颜色恢复原状
                count--;
                if (id == "PercentPlatformNoLevel1") {
                    if (count <= 50) {
                        //$.messager.alert('提示', "初级买家比例为50-70%", 'error');
                        $("#" + id).val(50);
                        $(obj).css("color", "gray");
                        return;
                    }
                }
                if (id == "PercentPlatformNoLevel2") {
                    if (count <= 0) {
                        //$.messager.alert('提示', "中等买家比例为20-40%", 'error');
                        $("#" + id).val(0);
                        $(obj).css("color", "gray");
                        return;
                    }
                }
                if (count <= 0) {
                    //$.messager.alert('提示', "数量不能小于0", 'error');
                    $("#" + id).val(0);
                    $(obj).css("color", "gray");
                    count = 0;
                    //return;
                }
                else {
                    //count--;
                }
            }
            $("#" + id).val(count);

            changeColor(id, count);
        }

        $(".fb2_table1 input").live("keyup", function () {
            var count = $(this).val();
            var id = $(this).attr("id");
            $(this).parent().prev().children().eq(0).css("color", "black");
            $(this).parent().next().children().eq(0).css("color", "black");
            if (count == "") {
                return;
            }
            if (id == "PercentPlatformNoLevel1") {
                if (count <= 50) {
                    //$.messager.alert('提示', "初级买家比例为50-70%", 'error');
                    //$("#" + id).val(50);
                    $(this).parent().prev().children().eq(0).css("color", "gray");
                    return;
                }
                else if (count >= 100) {
                    //$.messager.alert('提示', "初级买家比例为50-70%", 'error');
                    $("#" + id).val(100);
                    $(this).parent().next().children().eq(0).css("color", "gray");
                    return;
                }
                else {
                    $(this).parent().prev().children().eq(0).css("color", "black");
                    $(this).parent().next().children().eq(0).css("color", "black");
                    return;
                }
            }
            if (id == "PercentPlatformNoLevel2") {
                if (count <= 0) {
                    //$.messager.alert('提示', "中等买家比例为20-40%", 'error');
                    $("#" + id).val(0);
                    $(this).parent().prev().children().eq(0).css("color", "gray");
                    return;
                }
                else if (count >= 40) {
                    //$.messager.alert('提示', "中等买家比例为20-40%", 'error');
                    $("#" + id).val(40);
                    $(this).parent().next().children().eq(0).css("color", "gray");
                    return;
                }
                else {
                    $(this).parent().prev().children().eq(0).css("color", "black");
                    $(this).parent().next().children().eq(0).css("color", "black");
                    return;
                }
            }
            if (id == "PercentPlatformNoLevel3") {
                if (count <= 0) {
                    //$.messager.alert('提示', "资深买家比例为0-20%", 'error');
                    $("#" + id).val(0);
                    $(this).parent().prev().children().eq(0).css("color", "gray");
                    return;
                }
                else if (count >= 20) {
                    //$.messager.alert('提示', "资深买家比例为0-20%", 'error');
                    $("#" + id).val(20);
                    $(this).parent().next().children().eq(0).css("color", "gray");
                    return;
                }
                else {
                    $(this).parent().prev().children().eq(0).css("color", "black");
                    $(this).parent().next().children().eq(0).css("color", "black");
                    return;
                }
            }
            if (count <= 0) {
                //$.messager.alert('提示', "数量不能小于0", 'error');
                $("#" + id).val(0);
                $(this).parent().prev().children().eq(0).css("color", "gray");
                count = 0;
            }
            else if (count >= 100) {
                //$.messager.alert('提示', "数量不能超过100", 'error');
                $("#" + id).val(100);
                $(this).parent().next().children().eq(0).css("color", "gray");
                count = 100;
            }
            else {
                $(this).parent().prev().children().eq(0).css("color", "black");
                $(this).parent().next().children().eq(0).css("color", "black");
            }
            changeColor(id, count);

        });
        function changeColor(id, count) {
            if (id == "PercentPlatformNoIdentYes") {
                $("#PercentPlatformNoIdentNot").val(100 - count);
                if (count == 0) {
                    $("#PercentPlatformNoIdentNot").parent().next().children().eq(0).css("color", "gray");
                    $("#PercentPlatformNoIdentNot").parent().prev().children().eq(0).css("color", "black");
                }
                else if (count == 100) {
                    $("#PercentPlatformNoIdentNot").parent().next().children().eq(0).css("color", "black");
                    $("#PercentPlatformNoIdentNot").parent().prev().children().eq(0).css("color", "gray");
                }
                else {
                    $("#PercentPlatformNoIdentNot").parent().next().children().eq(0).css("color", "black");
                    $("#PercentPlatformNoIdentNot").parent().prev().children().eq(0).css("color", "black");
                }
            }
            else if (id == "PercentPlatformNoIdentNot") {
                $("#PercentPlatformNoIdentYes").val(100 - count);
                if (count == 0) {
                    $("#PercentPlatformNoIdentYes").parent().next().children().eq(0).css("color", "gray");
                    $("#PercentPlatformNoIdentYes").parent().prev().children().eq(0).css("color", "black");
                }
                else if (count == 100) {
                    $("#PercentPlatformNoIdentYes").parent().next().children().eq(0).css("color", "black");
                    $("#PercentPlatformNoIdentYes").parent().prev().children().eq(0).css("color", "gray");
                }
                else {
                    $("#PercentPlatformNoIdentYes").parent().next().children().eq(0).css("color", "black");
                    $("#PercentPlatformNoIdentYes").parent().prev().children().eq(0).css("color", "black");
                }
            }
            else if (id == "PercentPlatformNoSexMale") {
                $("#PercentPlatformNoSexFemale").val(100 - count);
                if (count == 0) {
                    $("#PercentPlatformNoSexFemale").parent().next().children().eq(0).css("color", "gray");
                    $("#PercentPlatformNoSexFemale").parent().prev().children().eq(0).css("color", "black");
                }
                else if (count == 100) {
                    $("#PercentPlatformNoSexFemale").parent().next().children().eq(0).css("color", "black");
                    $("#PercentPlatformNoSexFemale").parent().prev().children().eq(0).css("color", "gray");
                }
                else {
                    $("#PercentPlatformNoSexFemale").parent().next().children().eq(0).css("color", "black");
                    $("#PercentPlatformNoSexFemale").parent().prev().children().eq(0).css("color", "black");
                }
            }
            else if (id == "PercentPlatformNoSexFemale") {
                $("#PercentPlatformNoSexMale").val(100 - count);
                if (count == 0) {
                    $("#PercentPlatformNoSexMale").parent().next().children().eq(0).css("color", "gray");
                    $("#PercentPlatformNoSexMale").parent().prev().children().eq(0).css("color", "black");
                }
                else if (count == 100) {
                    $("#PercentPlatformNoSexMale").parent().next().children().eq(0).css("color", "black");
                    $("#PercentPlatformNoSexMale").parent().prev().children().eq(0).css("color", "gray");
                }
                else {
                    $("#PercentPlatformNoSexMale").parent().next().children().eq(0).css("color", "black");
                    $("#PercentPlatformNoSexMale").parent().prev().children().eq(0).css("color", "black");
                }
            }
        }
        function save() {

            //var regions = $("input[type='checkbox']");

            $("#serviceValidation").remove();
            $("#clientValidationOL").html("");
            $("#serviceValidation").hide();


            var PercentPlatformNoSexFemale = parseInt($("#PercentPlatformNoSexFemale").val());
            if (isNaN(PercentPlatformNoSexFemale)) {
            	return dialog.error('性别(女)请输入数字');
//              $("<li>性别(女)请输入数字</li>").appendTo($("#clientValidationOL"));
//              $("#clientValidation").show();
//              return false;
            }
            var PercentPlatformNoSexMale = parseInt($("#PercentPlatformNoSexMale").val());
            if (isNaN(PercentPlatformNoSexMale)) {
            	return dialog.error('性别(男)请输入数字');
//              $("<li>性别(男)请输入数字</li>").appendTo($("#clientValidationOL"));
//              $("#clientValidation").show();
//              return false;
            }
            if (PercentPlatformNoSexMale + PercentPlatformNoSexFemale != 100) {
            	return dialog.error('性别处相加比例必须为100');
//              $("<li>性别处相加比例必须为100</li>").appendTo($("#clientValidationOL"));
//              $("#clientValidation").show();
//              return false;
            }

            var PercentPlatformNoAge18_24 = parseInt($("#PercentPlatformNoAge18_24").val());
            if (isNaN(PercentPlatformNoAge18_24)) {
            	return dialog.error('年龄(18-24)请输入数字');
//              $("<li>年龄(18-29)请输入数字</li>").appendTo($("#clientValidationOL"));
//              $("#clientValidation").show();
//              return false;
            }
            var PercentPlatformNoAge25_35 = parseInt($("#PercentPlatformNoAge25_29").val());
            if (isNaN(PercentPlatformNoAge25_35)) {
            	return dialog.error('年龄(25-35)请输入数字');
//              $("<li>年龄(30-39)请输入数字</li>").appendTo($("#clientValidationOL"));
//              $("#clientValidation").show();
//              return false;
            }
            var PercentPlatformNoAge30_34 = parseInt($("#PercentPlatformNoAge30_34").val());
            if (isNaN(PercentPlatformNoAge30_34)) {
            	return dialog.error('年龄(36-45)请输入数字');
//              $("<li>年龄(40-59)请输入数字</li>").appendTo($("#clientValidationOL"));
//              $("#clientValidation").show();
//              return false;
            }
            var PercentPlatformNoAge46_59 = parseInt($("#PercentPlatformNoAge46_59").val());
            if (isNaN(PercentPlatformNoAge46_59)) {
            	return dialog.error('年龄(46-59)请输入数字');
//              $("<li>年龄(40-59)请输入数字</li>").appendTo($("#clientValidationOL"));
//              $("#clientValidation").show();
//              return false;
            }
            console.log(PercentPlatformNoAge30_34);
            console.log(PercentPlatformNoAge25_29);
            console.log(PercentPlatformNoAge18_24);
            console.log(PercentPlatformNoAge46_59);
            if (PercentPlatformNoAge30_34 + PercentPlatformNoAge25_35 + PercentPlatformNoAge18_24 + PercentPlatformNoAge46_59 != 100) {
            	return dialog.error('年龄处相加比例必须为100');
//              $("<li>年龄处相加比例必须为100</li>").appendTo($("#clientValidationOL"));
//              $("#clientValidation").show();
//              return false;
            }
			public.ajax('<?=site_url('member/siteproDB')?>', $('#fm').serialize(), function(datas){
				public.ajaxSuccess(datas, function(){
					$('#ms_' + $('input[name=ProductID]').val(), window.parent.document).remove();
					dialog.iframe_close();
				});
			});
//          $("#fm").submit();
        }
        function defaultSetting() {
            $("#PercentPlatformNoIdentYes").val("50");
            $("#PercentPlatformNoIdentNot").val("50");
            $("#PercentPlatformNoSexMale").val("50");
            $("#PercentPlatformNoSexFemale").val("50");
            $("#PercentPlatformNoAge18_24").val("40");
            $("#PercentPlatformNoAge25_29").val("30");
            $("#PercentPlatformNoAge30_34").val("30");
            $("#PercentPlatformNoLevel1").val("50");
            $("#PercentPlatformNoLevel2").val("30");
            $("#PercentPlatformNoLevel3").val("20");
            $("#PercentPlatformNoXFLevel1").val("20");
            $("#PercentPlatformNoXFLevel2").val("20");
            $("#PercentPlatformNoXFLevel3").val("20");
            $("#PercentPlatformNoXFLevel4").val("20");
            $("#PercentPlatformNoXFLevel5").val("20");
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
            margin-left: 300px;
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
        
        td
        {
            border-width: 0 0 0 0;
        }
    </style>
<form action="<?=site_url('member/siteproDB')?>" id="fm" method="post">        
<div class="fb2_table1" style="height: 500px; overflow-y: auto; width: 100%;">
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
            <input id="ProductID" name="ProductID" type="hidden" value="<?=$info->id?>">
            <input data-val="true" data-val-number="字段 PercentPlatformNoXFLevel5 必须是一个数字。" data-val-range="范围为0-100之间" data-val-range-max="100" data-val-range-min="0" id="PercentPlatformNoXFLevel5" name="PercentPlatformNoXFLevel5" type="hidden" value="20">
            <input data-val="true" data-val-number="字段 PercentPlatformNoXFLevel4 必须是一个数字。" data-val-range="范围为0-100之间" data-val-range-max="100" data-val-range-min="0" id="PercentPlatformNoXFLevel4" name="PercentPlatformNoXFLevel4" type="hidden" value="20">
            <input data-val="true" data-val-number="字段 PercentPlatformNoIdentNot 必须是一个数字。" data-val-range="范围为0-100之间" data-val-range-max="100" data-val-range-min="0" id="PercentPlatformNoIdentNot" name="PercentPlatformNoIdentNot" type="hidden" value="0">
            <input data-val="true" data-val-number="字段 PercentPlatformNoIdentYes 必须是一个数字。" data-val-range="范围为0-100之间" data-val-range-max="100" data-val-range-min="0" id="PercentPlatformNoIdentYes" name="PercentPlatformNoIdentYes" type="hidden" value="100">
            <input data-val="true" data-val-number="字段 PercentPlatformNoLevel1 必须是一个数字。" data-val-range="范围为0-100之间" data-val-range-max="100" data-val-range-min="0" id="PercentPlatformNoLevel1" name="PercentPlatformNoLevel1" type="hidden" value="50">
            <input data-val="true" data-val-number="字段 PercentPlatformNoLevel2 必须是一个数字。" data-val-range="范围为0-100之间" data-val-range-max="100" data-val-range-min="0" id="PercentPlatformNoLevel2" name="PercentPlatformNoLevel2" type="hidden" value="30">
            <input data-val="true" data-val-number="字段 PercentPlatformNoLevel3 必须是一个数字。" data-val-range="范围为0-100之间" data-val-range-max="100" data-val-range-min="0" id="PercentPlatformNoLevel3" name="PercentPlatformNoLevel3" type="hidden" value="20">
            <input data-val="true" data-val-number="字段 PercentPlatformNoXFLevel1 必须是一个数字。" data-val-range="范围为0-100之间" data-val-range-max="100" data-val-range-min="0" id="PercentPlatformNoXFLevel1" name="PercentPlatformNoXFLevel1" type="hidden" value="20">
            <input data-val="true" data-val-number="字段 PercentPlatformNoXFLevel2 必须是一个数字。" data-val-range="范围为0-100之间" data-val-range-max="100" data-val-range-min="0" id="PercentPlatformNoXFLevel2" name="PercentPlatformNoXFLevel2" type="hidden" value="20">
            <input data-val="true" data-val-number="字段 PercentPlatformNoXFLevel3 必须是一个数字。" data-val-range="范围为0-100之间" data-val-range-max="100" data-val-range-min="0" id="PercentPlatformNoXFLevel3" name="PercentPlatformNoXFLevel3" type="hidden" value="20">
            <div class="errorbox" id="clientValidation" style="display: none; width: 90%;">
                <ol style="list-style-type: decimal" id="clientValidationOL">
                </ol>
            </div>
            
            <div class="">
                <div style="margin: 15px 30px;">
                    <table>
                        <tbody>
                        <tr>
                            <td align="right" style="width: 75px;">
                                <span style="font-size: 15px">性别:</span>
                            </td>
                            <?php
                                $man ='50';
                                $women ='50';
                                if($info->sex!=null){
                                    $sex = unserialize($info->sex);
                                    $man = $sex['man'];
                                    $women = $sex['woman'];
                                }
                            ?>
                            <td align="right" style="width: 80px;">
                                <label style="margin-left: 10px; margin-right: 5px;">男</label>
                            </td>
                            <td>
                                <ul class="ulcalc">
                                    <li class="lil"><a href="#" title="减一" style="margin: 1px; text-decoration: none;" onclick="changeBar(this,'-','PercentPlatformNoSexMale')">-</a></li>
                                    <li class="lic">
                                        <input data-val="true" data-val-number="字段 PercentPlatformNoSexMale 必须是一个数字。" data-val-range="范围为0-100之间" data-val-range-max="100" data-val-range-min="0" id="PercentPlatformNoSexMale" maxlength="3" name="PercentPlatformNoSexMale" onkeyup="value=value.replace(/[^0-9]/g,'')" style="width: 30px; border: none; padding: 5px 0 5px 0; text-align: center;" type="text" value="<?=$man?>"><span class="inp">%</span></li>
                                    <li class="lir"><a href="#" title="加一" style="margin: 1px; text-decoration: none;" onclick="changeBar(this,'+','PercentPlatformNoSexMale')">+</a></li>
                                </ul>
                            </td>
                            <td align="right" style="width: 80px;">
                                <label style="margin-left: 15px; margin-right: 5px;">女</label>
                            </td>
                            <td>
                                <ul class="ulcalc">
                                    <li class="lil"><a href="#" title="减一" style="margin: 1px; text-decoration: none;" onclick="changeBar(this,'-','PercentPlatformNoSexFemale')">-</a></li>
                                    <li class="lic">
                                        <input data-val="true" data-val-number="字段 PercentPlatformNoSexFemale 必须是一个数字。" data-val-range="范围为0-100之间" data-val-range-max="100" data-val-range-min="0" id="PercentPlatformNoSexFemale" maxlength="3" name="PercentPlatformNoSexFemale" onkeyup="value=value.replace(/[^0-9]/g,'')" style="width: 30px; border: none; padding: 5px 0 5px 0; text-align: center;" type="text" value="<?=$women?>"><span class="inp">%</span></li>
                                    <li class="lir"><a href="#" title="加一" style="margin: 1px; text-decoration: none;" onclick="changeBar(this,'+','PercentPlatformNoSexFemale')">+</a></li>
                                </ul>
                            </td>
                        </tr>
                        <tr style="margin-top: 15px">
                            <td align="right" style="text-align: right; width: 75px;">
                                <span style="font-size: 15px">年龄:</span>
                            </td>
                            <?php
                            $younger = '40';
                            $middle = '30';
                            $older = '30';
                            $older_more = '0';
                            if($info->age!=null){
                                $age = unserialize($info->age);
                                $younger = $age['younger'];
                                $middle = $age['middle'];;
                                $older = $age['older'];
                                $older_more = isset($age['older_more']) ? $age['older_more'] : 0;
                            }
                            ?>
                            <td align="right" style="width: 80px;">
                                <label style="margin-left: 2px; margin-right: 5px;">18-24</label>
                            </td>
                            <td>
                                <ul class="ulcalc">
                                    <li class="lil"><a href="#" title="减一" style="margin: 1px; text-decoration: none;" onclick="changeBar(this,'-','PercentPlatformNoAge18_24')">-</a></li>
                                    <li class="lic"><input data-val="true" data-val-number="字段 PercentPlatformNoAge18_24 必须是一个数字。" data-val-range="范围为0-100之间" data-val-range-max="100" data-val-range-min="0" id="PercentPlatformNoAge18_24" maxlength="3" name="PercentPlatformNoAge18_24" onkeyup="value=value.replace(/[^0-9]/g,'')" style="width: 30px; border: none; padding: 5px 0 5px 0; text-align: center;" type="text" value="<?=$younger?>"><span class="inp">%</span></li>
                                    <li class="lir"><a href="#" title="加一" style="margin: 1px; text-decoration: none;" onclick="changeBar(this,'+','PercentPlatformNoAge18_24')">+</a></li>
                                </ul>
                            </td>
                            <td align="right" style="width: 80px;">
                                <label style="margin-left: 2px; margin-right: 5px;">25-35</label>
                            </td>
                            <td>
                                <ul class="ulcalc">
                                    <li class="lil"><a href="#" title="减一" style="margin: 1px; text-decoration: none;" onclick="changeBar(this,'-','PercentPlatformNoAge25_29')">-</a></li>
                                    <li class="lic"><input data-val="true" data-val-number="字段 PercentPlatformNoAge25_29 必须是一个数字。" data-val-range="范围为0-100之间" data-val-range-max="100" data-val-range-min="0" id="PercentPlatformNoAge25_29" maxlength="3" name="PercentPlatformNoAge25_29" onkeyup="value=value.replace(/[^0-9]/g,'')" style="width: 30px; border: none; padding: 5px 0 5px 0; text-align: center;" type="text" value="<?=$middle?>"><span class="inp">%</span></li>
                                    <li class="lir"><a href="#" title="加一" style="margin: 1px; text-decoration: none;" onclick="changeBar(this,'+','PercentPlatformNoAge25_29')">+</a></li>
                                </ul>
                            </td>
                            <td align="right" style="width: 80px;">
                                <label style="margin-left: 2px; margin-right: 5px;">36-45</label>
                            </td>
                            <td>
                                <ul class="ulcalc">
                                    <li class="lil"><a href="#" title="减一" style="margin: 1px; text-decoration: none;" onclick="changeBar(this,'-','PercentPlatformNoAge30_34')">-</a></li>
                                    <li class="lic"><input data-val="true" data-val-number="字段 PercentPlatformNoAge30_34 必须是一个数字。" data-val-range="范围为0-100之间" data-val-range-max="100" data-val-range-min="0" id="PercentPlatformNoAge30_34" maxlength="3" name="PercentPlatformNoAge30_34" onkeyup="value=value.replace(/[^0-9]/g,'')" style="width: 30px; border: none; padding: 5px 0 5px 0; text-align: center;" type="text" value="<?=$older?>"><span class="inp">%</span></li>
                                    <li class="lir"><a href="#" title="加一" style="margin: 1px; text-decoration: none;" onclick="changeBar(this,'+','PercentPlatformNoAge30_34')">+</a></li>
                                </ul>
                            </td>
                            <td align="right" style="width: 80px;">
                                <label style="margin-left: 2px; margin-right: 5px;">46-59</label>
                            </td>
                            <td>
                                <ul class="ulcalc">
                                    <li class="lil"><a href="#" title="减一" style="margin: 1px; text-decoration: none;" onclick="changeBar(this,'-','PercentPlatformNoAge46_59')">-</a></li>
                                    <li class="lic"><input data-val="true" data-val-number="字段 PercentPlatformNoAge46_59 必须是一个数字。" data-val-range="范围为0-100之间" data-val-range-max="100" data-val-range-min="0" id="PercentPlatformNoAge46_59" maxlength="3" name="PercentPlatformNoAge46_59" onkeyup="value=value.replace(/[^0-9]/g,'')" style="width: 30px; border: none; padding: 5px 0 5px 0; text-align: center;" type="text" value="<?=$older_more?>"><span class="inp">%</span></li>
                                    <li class="lir"><a href="#" title="加一" style="margin: 1px; text-decoration: none;" onclick="changeBar(this,'+','PercentPlatformNoAge46_59')">+</a></li>
                                </ul>
                            </td>
                        </tr>
                        <?php
                            if($info->region!=''){
                                $region = unserialize($info->region);
                            }
                        ?>
                           <tr style="margin-top: 15px">
                                <td align="right" style="text-align: right; width: 65px;">
                                </td>
                                <td align="right" style="width: 80px;">
                                    <label style="margin-left: 2px; margin-right: 5px;">
                                    <input type="checkbox" <?=$info->region!=''?(isset($region['huadong'])?'checked="checked"':''):'checked="checked"'?> id="1" name="RegionIds[huadong]" value="1"></label>
                                </td>
                                <td><span>华东地区 （包括山东、江苏、安徽、浙江、福建、上海）</span></td>
                            </tr>
                           <tr style="margin-top: 15px">
                                <td align="right" style="text-align: right; width: 65px;">
                                </td>
                                <td align="right" style="width: 80px;">
                                    <label style="margin-left: 2px; margin-right: 5px;">
                                    <input type="checkbox" <?=$info->region!=''?(isset($region['huanan'])?'checked="checked"':''):'checked="checked"'?>  id="2" name="RegionIds[huanan]" value="2"></label>
                                </td>
                                <td><span>华南地区 （包括广东、广西、海南）</span></td>
                            </tr>
                           <tr style="margin-top: 15px">
                                <td align="right" style="text-align: right; width: 65px;">
                                </td>
                                <td align="right" style="width: 80px;">
                                    <label style="margin-left: 2px; margin-right: 5px;">
                                    <input type="checkbox" <?=$info->region!=''?(isset($region['huazhong'])?'checked="checked"':''):'checked="checked"'?>  id="3" name="RegionIds[huazhong]" value="3"></label>
                                </td>
                                <td><span>华中地区 （包括湖北、湖南、河南、江西）</span></td>
                            </tr>
                           <tr style="margin-top: 15px">
                                <td align="right" style="text-align: right; width: 65px;">
                                        <span style="font-size: 15px">所在地:</span>
                                </td>
                                <td align="right" style="width: 80px;">
                                    <label style="margin-left: 2px; margin-right: 5px;">
                                    <input type="checkbox" <?=$info->region!=''?(isset($region['huabei'])?'checked="checked"':''):'checked="checked"'?>  id="4" name="RegionIds[huabei]" value="4"></label>
                                </td>
                                <td><span>华北地区 （包括北京、天津、河北、山西、内蒙古）</span></td>
                            </tr>
                           <tr style="margin-top: 15px">
                                <td align="right" style="text-align: right; width: 65px;">
                                </td>
                                <td align="right" style="width: 80px;">
                                    <label style="margin-left: 2px; margin-right: 5px;">
                                    <input type="checkbox" <?=$info->region!=''?(isset($region['xibei'])?'checked="checked"':''):'checked="checked"'?>  id="5" name="RegionIds[xibei]" value="5"></label>
                                </td>
                                <td><span>西北地区 （包括宁夏、新疆、青海、陕西、甘肃）</span></td>
                            </tr>
                           <tr style="margin-top: 15px">
                                <td align="right" style="text-align: right; width: 65px;">
                                </td>
                                <td align="right" style="width: 80px;">
                                    <label style="margin-left: 2px; margin-right: 5px;">
                                    <input type="checkbox" <?=$info->region!=''?(isset($region['xinan'])?'checked="checked"':''):'checked="checked"'?>  id="6" name="RegionIds[xinan]" value="6"></label>
                                </td>
                                <td><span>西南地区 （包括四川、云南、贵州、西藏、重庆）</span></td>
                            </tr>
                           <tr style="margin-top: 15px">
                                <td align="right" style="text-align: right; width: 65px;">
                                </td>
                                <td align="right" style="width: 80px;">
                                    <label style="margin-left: 2px; margin-right: 5px;">
                                    <input type="checkbox" <?=$info->region!=''?(isset($region['dongbei'])?'checked="checked"':''):'checked="checked"'?>  id="7" name="RegionIds[dongbei]" value="7"></label>
                                </td>
                                <td><span>东北地区 （包括辽宁、吉林、黑龙江）</span></td>
                            </tr>
                           <tr style="margin-top: 15px">
                                <td align="right" style="text-align: right; width: 65px;">
                                </td>
                                <td align="right" style="width: 80px;">
                                    <label style="margin-left: 2px; margin-right: 5px;">
                                     <input type="checkbox" <?=$info->region!=''?(isset($region['gangaotai'])?'checked="checked"':''):'checked="checked"'?>  id="8" name="RegionIds[gangaotai]" value="8"></label>
                                </td>
                                <td><span>台港澳地区 （包括台湾、香港、澳门）</span></td>
                            </tr>
                        <tr style="margin-top: 25px">
                            <td align="right" style="text-align: right; width: 75px;">
                                <span style="font-size: 14px; color: Red;">温馨提示</span>
                            </td>
                            <td colspan="2">：系统将按照你设置的性别、年龄、所在地比例分配买手，请根据产品真实购买人群的实际情况进行设置。</td>
                        </tr>
                    </tbody></table>
                </div>
            </div>
        </div>
        <div class="yctc_458 ycgl_tc_1">
            <ul>
                <li class="fpgl-tc-qxjs_4" style="position: fixed; bottom: 15px; margin-left: 30px;">
                    <p><input class="input-butto100-hs" type="button" value="重置" onclick="defaultSetting()"></p>
                    <p><input class="input-butto100-hs" type="button" value="保存" onclick="save()"></p>
                    <p><input onclick="window.parent.location.reload()" class="input-butto100-ls" type="button" value="取消"></p>
                </li>
            </ul>
        </div>
</form>


</body></html>