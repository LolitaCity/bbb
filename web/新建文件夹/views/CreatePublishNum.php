<!DOCTYPE html>
<!-- saved from url=(0095)https://qqq.wkquan.com/Shop/PlatformNo/CreatePublishNum?id=98cf9150-7a07-4446-876a-2ce62bffb36b -->
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title></title>
    <script src="./CreatePublishNum_files/jquery-1.8.3.js.下载" type="text/javascript"></script>
    <script src="./CreatePublishNum_files/jquery.jslides.js.下载" type="text/javascript"></script>
    <script src="./CreatePublishNum_files/open.win.js.下载" type="text/javascript"></script>
    <script src="./CreatePublishNum_files/jquery.jBox-2.3.min.js.下载" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="./CreatePublishNum_files/jbox.css">
    <link rel="stylesheet" type="text/css" href="./CreatePublishNum_files/common.css">
    <link rel="stylesheet" type="text/css" href="./CreatePublishNum_files/index.css">
    <link rel="stylesheet" type="text/css" href="./CreatePublishNum_files/open.win.css">
    
    <style type="text/css">
        body
        {
            font-size: 14px;
        }
        /*上面CSS不需要*/
        .tc_w_670560
        {
            width: 670px;
            height: 570px;
            border: 1px solid #eee;
            position: relative;
        }
        .htyg_tc
        {
            background: #4882f0;
            color: #fff;
            height: 50px;
            line-height: 50px;
            font-size: 16px;
            font-weight: normal;
            padding-left: 15px;
            margin: 0px;
        }
        .tc_adjust
        {
            height: 105px;
            margin: 15px;
            border-bottom: 1px dashed #ccc;
        }
        .tc_adjust ul
        {
            background: url('/Content/new_content/img/lb_icon.png') no-repeat left 5px;
            padding-left: 30px;
            font-weight: normal;
        }
        .tc_adjust li
        {
            height: 30px;
            line-height: 30px;
            display: block;
        }
        .tc_adjust1
        {
            padding: 0px 15px;
            height: 290px;
        }
        .tc_adjust1 li
        {
            display: flex;
            flex-direction: row;
            height: 40px;
            line-height: 40px;
            padding-left: 25px;
        }
        .tc_adjust1 li label
        {
            margin-right: 10px;
            line-height: 40px;
            width: 120px;
            text-align: right;
        }
        .tc_radio
        {
            display: flex;
            flex-direction: row;
        }
        .radio_btn
        {
            background: #fff;
            display: block;
            width: 80px;
            height: 30px;
            margin-right: 10px;
            margin-top: 5px;
            line-height: 30px;
            text-align: center;
            position: relative;
            vertical-align: middle;
        }
     .radio_btn input{
        width: 100%;
        height: 100%;
        position: absolute;
        top: 0;
        left: 0;
        z-index: 100;
        opacity: 0;
        cursor: pointer;

     }
     .radio_btn span{
        width: 100%;
        height: 100%;
        display: inline-block;
        position: absolute;
        z-index: 1;
        border:1px solid #d9d9d9;
        color:#222;
        background:#fff;
        top: 0px;
        left: 0px;
         }
     .radio_btn input[type="radio"] + span{
        opacity: 1;
        cursor: pointer;
     }
     .radio_btn input[type="radio"]:hover + span{
         border:1px solid #4882f0;
     }
     .radio_btn input[type="radio"]:checked + span{
        border:1px solid #4882f0;
        background:#fff;
        color:#4882f0;
        opacity: 1;
         cursor: pointer;
     }

     .radio_btn input[type="radio"]:disabled + span{
        opacity: 1;
        background:#f7f7f7;
        border:1px solid #d9d9d9;
        color: #d9d9d9;
        z-index: 999;
        cursor:not-allowed !important;
     }
        .tc_adjust2
        {
            display: flex;
            flex-direction: row;
            justify-content: center;
        }
        .tc_adjust2 a
        {
            width: 120px;
            height: 35px;
            line-height: 35px;
            text-align: center;
            border-radius: 30px;
            margin: 30px 10px;
            position: relative;
        }
        .tc_adjust2 a:hover
        {
            opacity: 0.9;
            color:#fff;
        }
        .bg_f90
        {
            background: #f90;
            color: #fff;
        }
        .display_f90
        {
            position: absolute;
            background: #fff;
            border: 1px solid #f90;
            color: #222;
            padding: 5px 10px;
            top: -50px;
            left: 0px;
            line-height: 20px;
            border-radius: 4px;
        }
        .bg_4882f0
        {
            background: #4882f0;
            color: #fff;
        }
        .dis_black
        {
            position: relative;
        }
        .dis_black:hover .dis_black_tc
        {
            display: block;
        }
        .dis_black_tc
        {
            border-radius: 5px;
            color: #222;
            text-align: left;
            width: 200px;
            padding: 10px;
            font-size: 14px;
            line-height: 20px;
            left: -60px;
            display: none;
            background: #fff;
            position: absolute;
            top: -90px;
        }
        .icon_blue
        {
            border: 1px solid #4782ef;
        }
        .icon_gray
        {
            border: 1px solid #d9d9d9;
        }
        .dis_black_tc em
        {
            height: 7px;
            top: 80px;
            width: 12px;
            left: 50%;
            position: absolute;
            display: block;
        }
        .icon_blue em
        {
            background: url('/Content/new_content/img/display_jt_up.png');
        }
        .icon_gray em
        {
            background: url('/Content/new_content/img/gray_jt_up.png');
        }
    </style>
    <script language="javascript">
        function Ok() {
            $("#btnOk").text("确定提交...");
            $("#btnOk").removeAttr("onclick");
             var id = $("#ID").val();
             var value = $('input:radio:checked').val();
             if (value == null || value == "") {
                 $("#btnOk").text("确定提交");
                 $("#btnOk").attr("onclick", "Ok()");
                 $.openAlter("请选择调整单量", "提示");
                 return;
             }
             $.post('/Shop/PlatformNo/EditPulishNum', { id: id, num: value }, function (result) {
                 if (result.StatusCode == "200") {
                     parent.location.href = parent.location.href;
                 }
                 else {
                     $("#btnOk").text("确定提交");
                     $("#btnOk").attr("onclick", "Ok()");
                     $.openAlter(result.Message, "提示");
                 }
             }, 'json');
         }
        $(function () {
            $("input[type=radio]").click(function () {
                var id = $("#ID").val();
                num = $(this).val();
                $.post('/Shop/PlatformNo/GetPublishInfo', { id: id, num: num }, function (result) {

                    $("#spanMoney").text(result.Money);
                    $("#spExpirationData").text(result.ExpirationData);
                    $("#spanReMoney").text(result.reMoney);
                }, 'json');
            });
        });
    </script>

</head>
<body style="background: #fff;">
    <!--列表 -->
    <div class="htyg_tc">
        <ul>
            <li class="htyg_tc_1" style="font-family: Microsoft YaHei;">
调整单量
</li>
            <li class="htyg_tc_2"><a href="javascript:void(0)" id="imgeColse" onclick="javascript:self.parent.$.closeWin()">
                <img src="./CreatePublishNum_files/sj-tc.png"></a> </li>
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
<form action="https://qqq.wkquan.com/Shop/PlatformNo/CreatePublishNum" id="fm" method="post"><input id="ID" name="ID" type="hidden" value="98cf9150-7a07-4446-876a-2ce62bffb36b">        <div class="tc_w_670560">
            <div class="tc_adjust">
                <ul>
                    <li>补单量调整规则：</li>
                    <li>1、只可在原单量基础上增加单量。如需减少单量，请在当前单量到期后重新选择。</li>
                    <li>2、系统会根据所选单量统计距离到期时间应补交的费用，确认提交则立即扣费。</li>
                </ul>
            </div>
            <div class="tc_adjust1">
                <ul>
                    <li>
                        <label>
                            店铺名称：</label><p>
                                sandyjack旗舰店</p>
                    </li>
                    <li>
                        <label>
                            当前单量：</label><p>
                                10单/天</p>
                    </li>
                    <li>
                        <label>
                            到期时间：</label><p>
                                <em id="spExpirationData">
</em></p>
                    </li>
                    <li>
                        <label>
                            调整单量：</label>
                        <div class="tc_radio">
                            <span class="radio_btn dis_black">
                                    <input type="radio" name="PublishNum" value="10" disabled="">
                                <span>10单/天</span> <em for="d1">10单/天</em>
                            </span><span class="radio_btn dis_black">
                                    <input type="radio" name="PublishNum" value="30">
                                <span>30单/天</span> <em for="d2">30单/天</em>
                            </span><span class="radio_btn dis_black">
                                    <input type="radio" name="PublishNum" value="50" disabled="">
                                <span>50单/天</span> <em for="d3">50单/天</em>
                                    <div class="dis_black_tc icon_gray">
                                        <em></em>
                                        <p>
                                            该店铺的单量上限为<font class="t_red">30单/天</font>。如需开通更高的单量，请与商家顾问协商。</p>
                                    </div>
                            </span><span class="radio_btn dis_black">
                                    <input type="radio" name="PublishNum" value="100" disabled="">
                                <span>100单/天</span> <em for="d3">100单/天</em>
                                    <div class="dis_black_tc icon_gray">
                                        <em></em>
                                        <p>
                                            该店铺的单量上限为<font class="t_red">30单/天</font>。如需开通更高的单量，请与商家顾问协商。</p>
                                    </div>
                            </span>
                        </div>
                    </li>
                    <li>
                        <label>
                            新单量收费标准：</label>
                        <p>
                            <em id="spanMoney">0</em>元/月</p>
                    </li>
                    <li>
                        <label>
                            应补交费用：</label>
                        <p class="t_red">
                            <em id="spanReMoney">0</em>元</p>
                    </li>
                </ul>
            </div>
            <div class="tc_adjust2" style="margin-top: -25px">
                <a href="javascript:void(0)" id="btnOk" onclick="Ok()" class="bg_f90 dis_black">确定提交
                </a><a href="javascript:void(0)" onclick="self.parent.$.closeWin()" class="bg_4882f0">
                    取消调整 </a>
            </div>
        </div>
</form>


</body></html>