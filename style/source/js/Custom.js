
//弹出确认信息框居中显示
function ShowLayOut(fade, light1) {
    $("#" + fade).height($(document).height());
    $("#" + fade).width($(document).width());

    var scrollH = $(document).scrollTop();
    var scrollL = $(document).scrollLeft();
    var topVal = ($(window).height() - $("#" + light1).height()) / 2 + scrollH;
    var leftVal = ($(window).width() - $("#" + light1).width()) / 2 + scrollL;
    if (topVal < 0) {
        topVal = 10;
    }
    $("#" + light1).css("left", leftVal).css("top", topVal);
}

/***************************
*
*datagrid格式化时间
*
****************************/
function formatToyyyyMMdd(value, row, index) {
    if (value != null) {
        var date = new Date(parseInt(value.replace("/Date(", "").replace(")/", ""), 10));
        return date.Format("yyyy-MM-dd hh:mm:ss");
    }
    return "";
}

/***************************
*
*格式化时间
*调用： 
*var time1 = new Date().Format("yyyy-MM-dd");
*var time2 = new Date().Format("yyyy-MM-dd HH:mm:ss"); 
*
****************************/
Date.prototype.Format = function (fmt) { //author: meizz 
    var o = {
        "M+": this.getMonth() + 1, //月份 
        "d+": this.getDate(), //日 
        "h+": this.getHours(), //小时 
        "m+": this.getMinutes(), //分 
        "s+": this.getSeconds(), //秒 
        "q+": Math.floor((this.getMonth() + 3) / 3), //季度 
        "S": this.getMilliseconds() //毫秒 
    };
    if (/(y+)/.test(fmt)) fmt = fmt.replace(RegExp.$1, (this.getFullYear() + "").substr(4 - RegExp.$1.length));
    for (var k in o)
        if (new RegExp("(" + k + ")").test(fmt)) fmt = fmt.replace(RegExp.$1, (RegExp.$1.length == 1) ? (o[k]) : (("00" + o[k]).substr(("" + o[k]).length)));
return fmt;
}

//得到文件扩展名
function GetFileName(file_name) {
    var point = file_name.lastIndexOf(".");
    var result = file_name.substr(point);
    if (result != "" && result != null)
        result = result.toLowerCase();
    return result;
}

//上传图片
function UploadImgToServer(formData, loginName, secret, sUploadId, sUploadSuccessId, auditImgId, savePath) {

    if ($("#" + sUploadSuccessId).length > 0) {
        $("#" + sUploadSuccessId).hide();
    }

    if ($("#" + sUploadId).length > 0) {
        $("#" + sUploadId).show();
    }

    if (savePath == "" || savePath == null || savePath == undefined) {
        savePath = "Audit";
    }

    $.ajax({
        type: "POST", //必须用post  
        url: "http://img.leqilucky.com:81/Upload/Upload?path=" + savePath + "&loginName=" + encodeURIComponent(loginName) + "&secret=" + secret,
        crossDomain: true,
        jsonp: "jsonp",
        jsonpCallback: "callbackjsp", //自定义的jsonp回调函数名称，默认为jQuery自动生成的随机函数名
        data: formData,
        contentType: false, //必须  
        processData: false,
        //不能用success，否则不执行  
        complete: function (data) {
            var result = eval("(" + data.responseText + ")");
            if (result.StatusCode == "200") {
                if ($("#" + sUploadId).length > 0) $("#" + sUploadId).hide();
                if ($("#" + sUploadSuccessId).length > 0) $("#" + sUploadSuccessId).show();
                if ($("#" + auditImgId).length > 0) $("#" + auditImgId).val(result.Message);
                FinishUpload(result.Message);
            }
            else {
                if ($("#" + sUploadId).length > 0) $("#" + sUploadId).hide();
                if ($("#" + sUploadSuccessId).length > 0) $("#" + sUploadSuccessId).hide();
                if ($("#" + auditImgId).length > 0) $("#" + auditImgId).val("");
                $.openAlter('上传失败:' + result.Message, '提示', { width: 250, height: 50 });
            }
        },
        error: function (data) {
            if ($("#" + sUploadSuccessId).length > 0) $("#" + sUploadSuccessId).hide();
            if ($("#" + sUploadId).length > 0) $("#" + sUploadId).hide();
            $.openAlter('上传失败！！！', '提示', { width: 250, height: 50 });
        }
    });
}

function FinishUpload() {
    //若引用该方法的页面有需处理的数据 则在调用页面重新添加该方法。
}