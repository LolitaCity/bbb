//图片预览
function ShowPreviewImg(fileId, previewId) {
    document.getElementById(fileId).onchange = function (evt) {
        $("#" + previewId).show();
        // 如果浏览器不支持FileReader，则不处理

        if (!window.FileReader) return;

        var files = evt.target.files;

        for (var i = 0, f; f = files[i]; i++) {

            if (!f.type.match('image.*')) {

                continue;

            }


            var reader = new FileReader();

            reader.onload = (function (theFile) {

                return function (e) {

                    // img 元素

                    document.getElementById(previewId).src = e.target.result;

                };

            })(f);


            reader.readAsDataURL(f);

        }

    }
}
// 获取url参数
function request(paras) {
    var url = location.href;
    var paraString = url.substring(url.indexOf("?") + 1, url.length).split("&");
    var paraObj = {}
    for (i = 0; j = paraString[i]; i++) {
        paraObj[j.substring(0, j.indexOf("=")).toLowerCase()] = j.substring(j.indexOf("=") + 1, j.length);
    }
    var returnValue = paraObj[paras.toLowerCase()];
    if (typeof (returnValue) == "undefined") {
        return "";
    } else {
        if (returnValue.indexOf("#") != -1) {
            returnValue = returnValue.substr(0, returnValue.indexOf("#"))
        }
        return returnValue;
    }
}

function CheckDateTime(str) {
    var reg = /^(\d+)-(\d{ 1,2 })-(\d{ 1,2 }) (\d{ 1,2 }):(\d{ 1,2 }):(\d{ 1,2 })$/;
    var r = str.match(reg);
    if (r == null) return false;
    r[2] = r[2] - 1;
    var d = new Date(r[1], r[2], r[3], r[4], r[5], r[6]);
    if (d.getFullYear() != r[1]) return false;
    if (d.getMonth() != r[2]) return false;
    if (d.getDate() != r[3]) return false;
    if (d.getHours() != r[4]) return false;
    if (d.getMinutes() != r[5]) return false;
    if (d.getSeconds() != r[6]) return false;
    return true;
}

// 验证是否为手机
function IsMobile(text) {
    return (/^(13\d|15[89])-?\d{5}(\d{3}|\*{3})$/.test(text));
}

// 验证是否为电话号码
function IsTel(text) {
    //"兼容格式: 国家代码(2到3位)-区号(2到3位)-电话号码(7到8位)-分机号(3位)"
    //return (/^(([0\+]\d{2,3}-)?(0\d{2,3})-)?(\d{7,8})(-(\d{3,}))?$/.test(this.Trim()));
    return (/^(([0\+]\d{2,3}-)?(0\d{2,3})-)(\d{7,8})(-(\d{3,}))?$/.test(text));
}

function IsTelephone(obj)// 正则判断
{
    var pattern = /(^[0-9]{3,4}\-[0-9]{3,8}$)|(^[0-9]{3,8}$)|(^\([0-9]{3,4}\)[0-9]{3,8}$)|(^0{0,1}13[0-9]{9}$)/;
    if (pattern.test(obj)) {
        return true;
    }
    else {
        return false;
    }
}

// 验证是否为有效电子邮箱
function IsEmail(text) {
    var reg = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
    return reg.test(text);
}

// 邮政编码验证
function isPostCode(text) {
    var regExp = /^[1-9][0-9]{5}$/;
    
    if (regExp.test(text)) {
        return true;
    } else if (text.length != 6) {
        return false;
    } else {
        return false;
    }
}

// 是否为整型
function IsInt(text) {
    return (/^(([1-9]\d*)|\d)(\.\d{1,3})?$/).test(text.toString());
}

// 验证整型以该函数为准
function CheckInt(val) {
    return (/^[1-9]\d*$/).test(val.toString());
}

function getLocalhostPath() {
    //获取当前网址，如： http://localhost:8083/higer/share/meun.aspx
    var curWwwPath = window.document.location.href;
    //获取主机地址之后的目录，如： higer/share/meun.jsp
    var pathName = window.document.location.pathname;
    var pos = curWwwPath.indexOf(pathName);
    //获取主机地址，如： http://localhost:8083
    var localhostPaht = curWwwPath.substring(0, pos);
    //获取带"/"的项目名，如：/higer
    var projectName = pathName.substring(0, pathName.substr(1).indexOf('/') + 1);
    return localhostPaht;
}

function changeTwoDecimal_f(x) {
    if (isNaN(x)) {
        return 0.00;
    }
    
    var f_x = parseFloat(x);
    if (isNaN(f_x)) {
        alert('function:changeTwoDecimal->parameter error');
        return false;
    }
    var f_x = Math.round(x * 100) / 100;
    var s_x = f_x.toString();
    var pos_decimal = s_x.indexOf('.');
    if (pos_decimal < 0) {
        pos_decimal = s_x.length;
        s_x += '.';
    }
    while (s_x.length <= pos_decimal + 2) {
        s_x += '0';
    }
    return s_x;
}

// 验证是否为金额类型
function checkIsDecimal(price) {
    return (/^(([1-9]\d*)|\d)(\.\d{1,2})?$/).test(price.toString());
}

function isObj(str)
{
if(str==null||typeof(str)=='undefined')
return false;
return true;
}

// 去除空格
function strTrim(str) {
    if (!isObj(str))
        return "";
    str = str.replace(/^\s+|\s+$/g, '');
    return str;
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
        url: "https://img.leqilucky.com:443/Upload/Upload?path=" + savePath + "&loginName=" + encodeURIComponent(loginName) + "&secret=" + secret,
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
                FinishUpload();
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
