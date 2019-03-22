<!DOCTYPE html>
<!-- saved from url=(0087)https://qqq.wkquan.com/Shop/PlatformNo/BindPlatform?platformType=0&s_u_ii=-1&token=6f77 -->
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title></title>
    <script src="style/jquery-1.8.3.js" type="text/javascript"></script>
    <script src="style/jquery.jslides.js" type="text/javascript"></script>
    <script src="style/open.win.js" type="text/javascript"></script>
    <script src="style/jquery.jBox-2.3.min.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="style/jbox.css">
    <link rel="stylesheet" type="text/css" href="style/common.css">
    <link rel="stylesheet" type="text/css" href="style/index.css">
    <link rel="stylesheet" type="text/css" href="style/open.win.css">
    
 <script type="text/javascript" src="style/Common.js"></script>
     <link rel="stylesheet" type="text/css" href="style/weui.css">
     <style>
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
        
     </style>
    <script language="javascript">
        $(document).ready(function () {
            $("#MemberInfo").addClass("a_on");
            $("#shopNum").addClass("a_on");
            $("#BindShop").addClass("a_on");
            shopChange();
            $("#Category1").click(function () {
                var value = $(this).val();
                $.post('/Shop/PlatformNo/GetVidateCode2', { cate: parseInt(value) }, function (result) {
                    $("#Category2").html(result);
                }, "json");
                $("#ShopCategroy2ID").val("");
            });
            $("#Category2").click(function () {

                var value = $("#Category2").find('option:selected').text();
                $("#ShopCategroy2ID").val(value);
                $("#shopcate2").val($("#Category2").val());

            });


        });

        function selectTag(tag, value) {
            if (tag == "tagContent0"){
                window.location="/Shop/PlatformNo/BindPlatform";
            }
            else if (tag == "tagContent1"){
                window.location="/Shop/PlatformNo";
                }
        }

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

          function checkTel(value){
        
            var isPhone = /^([0-9]{3,4}-)?[0-9]{7,8}$/;
            var isMob=/^((\+?86)|(\(\+86\)))?(13[0123456789][0-9]{8}|17[78][0-9]{8}|15[012356789][0-9]{8}|18[02356789][0-9]{8}|147[0-9]{8}|1349[0-9]{7})$/;
          
            if(isMob.test(value)||isPhone.test(value)){
                return true;
            }
            else{
                return false;
            }
    }
        function sendNum() {

            $("#serviceValidation").remove();
            $("#clientValidationOL").html("");
            $("#clientValidation").hide();

             $("#City").val($("#selCity").find('option:selected').text());
             $("#Area").val($("#selArea").find('option:selected').text());
            var value = $("#Province").find('option:selected').text();
            var Typevalue = $("#PlatformType").val();
            $("#Provinces").val(value);　

            if($("#Provinces").val()==""||$("#Provinces").val()=="请选择"||$("#City").val()==""||$("#City").val()=="请选择"||$("#Area").val()==""||$("#Area").val()=="请选择")
            {
                $("<li>请选择省市区！</li>").appendTo($("#clientValidationOL"));
                $("#clientValidation").show();
                return false;
            }

            if($("#txtPlatformNumber").val()==''&&Typevalue!="1")
            {
               $("<li>掌柜号不能不能为空！</li>").appendTo($("#clientValidationOL"));
                $("#clientValidation").show();
                return false;
            }

　　　     var arr = new Array();
            arr = $("#txtPlatformNumber").val().split(" ");
            if (arr.length != 1) {
                $("<li>掌柜号不能包含空格！</li>").appendTo($("#clientValidationOL"));
                $("#clientValidation").show();
                return false;
            }

//            var arr1 = new Array();
//            arr1 = $("#txtShopName").val().split(" ");
//            if (arr1.length != 1) {
//                $("<li>店铺名不能包含空格！</li>").appendTo($("#clientValidationOL"));
//                $("#clientValidation").show();
//                return false;
//            }

//            if ($.trim($("#YDNetNo").val()) == '' || $.trim($("#YDNetNo").val()) == null) {
//                $("<li>网点编码不能为空！</li>").appendTo($("#clientValidationOL"));
//                $("#clientValidation").show();
//                return false;
//            }

            var Typevalue = $("#PlatformType").val();
            if(Typevalue!="0")
                $("input[name='ChildPlatformType']").val("");
          var lj = $("#upfile1").val();
             var ljType=GetFileName(lj);
            if (lj == "" || lj == null) {
                    $("<li>上传截图不能为空！</li>").appendTo($("#clientValidationOL"));
                    $("#clientValidation").show();
                return false;
            }
             if (ljType != '.jpg' && ljType != '.jpeg' && ljType != '.gif' && ljType != '.bmp' && ljType != '.png') {
                    $("<li>图片凭证格式错误,仅限格式为(*.jpg,*.jpeg,*.gif,*.bmp,*.png)的格式文件..</li>").appendTo($("#clientValidationOL"));
                    $("#clientValidation").show();
                     return false;
               }
            else {
                var size = parseFloat($("#hidScreen").val());
                if (size > 4) {
                    $("<li>截图处上传的文件最大支持4M.</li>").appendTo($("#clientValidationOL"));
                    $("#clientValidation").show();
                    return;
                }
            }
            if(Typevalue=="1")
            {
             $("#txtPlatformNumber").val($("#txtShopName").val());
            }

            $("#fm").submit();
        }
        //得到文件扩展名
        function GetFileName(file_name) {
            var point = file_name.lastIndexOf("."); 
            var result = file_name.substr(point); 
            if (result != "" && result != null)
                result = result.toLowerCase();
            return result;
        }
        var isIE = /msie/i.test(navigator.userAgent) && !window.opera;
        function checkFileSizeFun(id) {
            $("#serviceValidation").remove();
            $("#clientValidationOL").html("");
            $("#clientValidation").hide();
            // 文件ID
            var uploadFileId = document.getElementById(id);
            if (isIE && !uploadFileId.files) {
                var filePath = uploadFileId.value;
                var fileSystem = new ActiveXObject("Scripting.FileSystemObject");
                var file = fileSystem.GetFile(filePath);
                // fileSize不能用var申明
                fileSize = file.Size;
            } else {
                fileSize = uploadFileId.files[0].size;
            }
            var size = fileSize / 1024 / 1024;
            size = size.toFixed(2);
            if (id == "upfile") {
                $("#hidScreen").val(size);
            }
            if (size > 4) {
                $("<li>上传的文件最大支持4M.</li>").appendTo($("#clientValidationOL"));
                $("#clientValidation").show();
                return false;
            }
        }

//        var editor;
//        KindEditor.ready(function (K) {
//            editor = K.create('#txtImge', {
//                cssPath: '～/Content/csses/kindeditor/plugins/code/prettify.css',
//                uploadJson: '/Brush/UpImge/UploadImage1',
//                fileManagerJson: '/Brush/UpImge/ProcessRequest',

//                allowFileManager: true,
//                filterMode: false,
//                items: ['image', 'multiimage', '|'],
//                afterBlur: function () { editor.sync(); }, //将编辑器的内容设置到原来的textarea控件里。
//                afterCreate: function () {
//                }
//            });
//            prettyPrint();
//        });



           $(function () {
            $("#Province").change(function () {
                GetBindData();
            });

            $("#selCity").change(function ff() {  //设置当省份下拉列表发生变化时，更新城市数据列表
                var cityId = $("#selCity").val();
                if (cityId != null && cityId != "" && cityId != undefined)
                    GetArea(cityId);
            });

            if($("#Province").val()!="")
            {
                $("#Province").val('')
            }
        });

        function GetBindData() {

            var provinceId = $("#Province").val();
            $.ajax({
                type: "post",
                url: "GetCity",
                dataType: "json",
                data: { provinceId: provinceId },
                error: function (XmlHttpRequest, textStatus, errorThrown) {
                    var $errorPage = XmlHttpRequest.responseText;
                    $("<li>" + $errorPage + "</li>").appendTo($("#clientValidationOL"));
                    $("#clientValidation").show();
                },
                success: function (data) {

                    $("#selCity").empty();
                    $.each(data, function (i, item) {
                        $("<option></option>").val(item["Key"]).text(item["Value"]).appendTo($("#selCity"));

                    });
                    var cityId = $("#selCity").val();
                    $("#selArea").empty();
                    if (cityId != null && cityId != "" && cityId != undefined) {
                        GetArea(cityId);
                    }
                }
            });
        }
         function GetArea(cityId) {
            $.ajax({
                type: "post",
                url: "GetArea",
                dataType: "json",
                data: { cityId: cityId },
                error: function (XmlHttpRequest, textStatus, errorThrown) {
                    var $errorPage = XmlHttpRequest.responseText;
                    $("<li>" + $errorPage + "</li>").appendTo($("#clientValidationOL"));
                    $("#clientValidation").show();
                },
                success: function (data) {
                    $("#selArea").empty();
                    $.each(data, function (i, item) {
                        $("<option></option>").val(item["Key"]).text(item["Value"]).appendTo($("#selArea"));
                    });
                }
            });
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
        $(function () {
            $(".closeicon1").click(function () {
                $("#previewImage1").attr("src", "");
                $("#AuditImgs").val("");
                $("#upfile1").val(""); 
                $(".ctl_close1").css("display", "none");
                $(".closeicon1").css("display", "none");
            });
        
            $('#upfile1').change(function () {
                var file = this.files[0];
                if (file == null || file == undefined) {
                    return;
                }
                var formData = new FormData();
                formData.append('img1', file);
                UploadImgToServer(formData, '霆宇包包', '11bff89c8353ee31ed16c9f0eacd247f', 'sUpload1', 'sUpload1Success', 'AuditImgs', "ImageController");
                $(".ctl_close1").show(); 
                $(".closeicon1").show(); 
            });
            if ($("#upfile1").length > 0) { ShowPreviewImg("upfile1", "previewImage1");}
        })
             //得到文件扩展名
        function GetFileName(file_name) {
            var point = file_name.lastIndexOf(".");
            var result = file_name.substr(point);
            if (result != "" && result != null)
                result = result.toLowerCase();
            return result;
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
            <li class="htyg_tc_1" style="font-family: Microsoft YaHei;">
提交审核资料
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
<form action="<?=site_url('member/addShopDB')?>" enctype="multipart/form-data" id="fm" method="post">
<input id="PlatformType" name="PlatformType" type="hidden" value="0">        
<div class="yctc_458 ycgl_tc_1" style="height:600px; width:90%; overflow-y:auto">
            <ul>
                    <li>店铺入驻条件：</li>
                     <li>淘宝店铺：日均访客<b style="color:Red">500</b>以上；每日真实成交订单达<b style="color:Red">5</b>单以上。</li>
                    <li>若店铺不符合以上条件, 即使提交审核资料, 平台一律予以拒绝, 多谢配合~</li>
                   <li><div class="fbxx2"></div></li> 
                    <li>
                        <p class="sk-hygl_7">
                            店铺类型：</p>
                        <p style="line-height: 35px;">
                            <input checked="checked" id="ChildPlatformType" name="ChildPlatformType" type="radio" value="淘宝">淘宝
                            <input id="ChildPlatformType" name="ChildPlatformType" type="radio" value="天猫">天猫
                        </p>
                    </li>
                <li class="fpgl-tc-qxjs_6">
                    <p class="sk-hygl_7">
                        掌柜号：</p>
                    <p>
                        <input id="txtPlatformNumber" class="input_305" data-val="true" data-val-required="掌柜号必填" maxlength="50" name="PlatformNoID" placeholder="请输入掌柜号" type="text" value="">
                        <b class="red">*</b>
                    </p>
                </li>
                <li class="fpgl-tc-qxjs_6">
                    <p class="sk-hygl_7">
                        店铺名：</p>
                    <p>
                        <input id="txtShopName" class="input_305" data-val="true" data-val-required="店铺名称必填" maxlength="30" name="ShopName" placeholder="请输入店铺名" type="text" value="">
                        <b class="red">*</b>
                    </p>
                </li>
                <li class="fpgl-tc-qxjs_6">
                    <p class="sk-hygl_7">
                        店铺性质：</p>
                    <p>
                        <select class="input_305" data-val="true" data-val-required="店铺性质必填" id="ShopNature" name="ShopNature" style="width:80px"><option value="0">个人</option>
<option value="1">公司</option>
</select>
                        <b class="red">*</b>
                    </p>
                </li>
                <li class="fpgl-tc-qxjs_6">
                    <p class="sk-hygl_7">
                        发货人：</p>
                    <p>
                        <input id="txtSenderName" class="input_305" data-val="true" data-val-required="发货人必填" maxlength="20" name="SenderName" placeholder="请输入发货人" type="text" value="">
                        <b class="red">*</b>
                    </p>
                </li>
                <li class="fpgl-tc-qxjs_6">
                    <p class="sk-hygl_7">
                        发货人手机号：</p>
                    <p>
                        <input id="txtSenderTel" class="input_305" data-val="true" data-val-length="发货人电话长度不正确" data-val-length-max="15" data-val-length-min="11" data-val-required="发货人电话必填" maxlength="15" name="SenderTel" placeholder="请输入发货人手机号" type="text" value="">
                        <b class="red">*</b>
                    </p>
                </li>
                <li class="fpgl-tc-qxjs_6">
                    <p class="sk-hygl_7">
                        发货省市区：</p>
                    <p>
                        <select class="input_305" id="Province" maxlength="50" name="Province" style="width:80px;"><option value="">请选择</option>
<option value="110000">北京</option>
<option value="120000">天津</option>
<option value="130000">河北省</option>
<option value="140000">山西省</option>
<option value="150000">内蒙古自治区</option>
<option value="210000">辽宁省</option>
<option value="220000">吉林省</option>
<option value="230000">黑龙江省</option>
<option value="310000">上海</option>
<option value="320000">江苏省</option>
<option value="330000">浙江省</option>
<option value="340000">安徽省</option>
<option value="350000">福建省</option>
<option value="360000">江西省</option>
<option value="370000">山东省</option>
<option value="410000">河南省</option>
<option value="420000">湖北省</option>
<option value="430000">湖南省</option>
<option value="440000">广东省</option>
<option value="450000">广西壮族自治区</option>
<option value="460000">海南省</option>
<option value="500000">重庆</option>
<option value="510000">四川省</option>
<option value="520000">贵州省</option>
<option value="530000">云南省</option>
<option value="540000">西藏自治区</option>
<option value="610000">陕西省</option>
<option value="620000">甘肃省</option>
<option value="630000">青海省</option>
<option value="640000">宁夏回族自治区</option>
<option value="650000">新疆维吾尔自治区</option>
<option value="710000">台湾省</option>
<option value="810000">香港特别行政区</option>
<option value="820000">澳门特别行政区</option>
</select>
                        <input data-val="true" data-val-required="市必填" id="City" name="City" type="hidden" value="">
                        <input data-val="true" data-val-required="区必填" id="Area" name="Area" type="hidden" value="">
                        <input id="Provinces" name="Provinces" type="hidden" value="">
                        <select id="selCity" class="input_305" style="width: 80px;">
                            <option value="">请选择</option>
                        </select>
                        <select id="selArea" class="input_305" style="width: 80px;">
                            <option value="">请选择</option>
                        </select>
                    </p>
                </li>
                <li class="fpgl-tc-qxjs_6">
                    <p class="sk-hygl_7">
                        发货详细地址：</p>
                    <p>
                        <textarea name="DetailAddress" id="DetailAddress" class="input_44" style="width: 300px;
                            height: 50px;" maxlength="200" placeholder="请输入发货详细地址"></textarea>
                        <b class="red">*</b>
                    </p>
                </li>
                
                <li class="fpgl-tc-qxjs_6">
                    <p class="sk-hygl_7">
                        上传截图：</p>
                    <p style="width: 70%;">
                        </p><p>
                            <input data-val="true" data-val-required="必须上传审核截图" id="AuditImgs" name="AuditImgs" type="hidden" value="">
                            <input type="hidden" id="hidScreen" value="0">
                         
                              </p><div>
                            <p class="sjzc_6_tu" style="margin-left: 10px;">
                                <a href="javascript:openBrowses(&#39;upfile1&#39;)"></a>   
                            </p>
                                        <p style="margin-top: 20px; margin-left: 5px">
                        <a target="_blank" href="https://qqq.wkquan.com/Login/ShopImge">
                            </a></p><ul><a target="_blank" href="https://qqq.wkquan.com/Login/ShopImge">
                                <li class="weui_uploader_file weui_uploader_status" style=" width: 100px;height:70px; background-image:url(/Content/images/淘宝入驻示例图.png)">
                                    <div class="weui_uploader_status_content">
                                        示例</div>
                                </li>
                            </a></ul><a target="_blank" href="https://qqq.wkquan.com/Login/ShopImge">
                        </a>
                    <p></p>
                            <div class="ctl_close1">
                                <img id="previewImage1" style="margin-left: -5px; width: 100px; height: 70px;; display: none; width: 100px; height: 70px;">
                                <img style=" margin-left:-30px;display: none" src="style/close.png" class="closeicon1">
                            </div>
                        </div>
                        <input type="file" id="upfile1" name="upfile1" style="display: none">
                       
                        <p></p>
                   
                    <p></p>
                </li>
                <li class="fpgl-tc-qxjs_6">
                    <p style="width: 50%;">
                        <input class="input-butto100-hs" type="button" id="btnSubmint" value="提交" onclick="sendNum()" style="float: right; margin-right: 5px;">
                    </p>
                    <p style="width: 50%;">
                        <input onclick="self.parent.$.closeWin()" class="input-butto100-ls" type="button" style="height: 35px; float: left; margin-left: 5px;" value="返回"></p>
                </li>
                <li class="fpgl-tc-qxjs_6">
                    <p>
                        <b>温馨提示：</b></p>
                    <p style="width: 70%;">
                        发货人信息会显示在快递单上，所以请如实填写。
                    </p>
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