<?php require_once('include/header.php')?>  
    
    <script src="<?=base_url()?>style/md5.js" type="text/javascript"></script>
    <script src="<?=base-Url()?>style/jquery.jBox-2.3.min.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>style/jbox.css">

    <script type="text/javascript">
        var wPice = '1.00';
        $(function () {
            $("#TaskApp").addClass("#TaskApp");
            taskCount();  //计算任务数量
            setIsOtherCondition(); //设置是否启用其他搜索条件
            wordCountInput(); //数量输入设置       
            keyValueMsg();
            var productID = $("#ProductID").val();
            var platformType = '';
            QuestionInput();
            IsOpen();
            vipTime();
            //文本框输入限制
            $("input[name=SingleProductPrice],input[name=BuyProductCount],input[name=ProductPriceListCount],input[name=TaskPlanCount]").live("focus", function () {
                if ($(this).val() < 1) {
                    $(this).val(" ");
                }
            });
            $("input[name=SingleProductPrice],input[name=BuyProductCount],input[name=ProductPriceListCount],input[name=TaskPlanCount]").live("focusout", function () {
                if ($(this).val() < 1) {
                    $(this).val(0);
                }
            });
            $(".temp").hide();
        })
        //发布时间操作
        function vipTime() {
            //增加任务数
            $("#timeimgAdd").live("click", function () {
                if ($("input[name=TaskPlanType]:checked").val() != "2")
                { return false; }
                var taskNum = parseInt($(this).parent().prev().children().val());
                var appCount = parseInt($("#appCount").text());

                var taskCount = 0;
                if (taskNum < appCount) {
                    $(this).parent().prev().children().val(taskNum + 1);
                }
                $('input[name=TaskPlanCount]').each(function () {
                    var num = $(this).val();
                    taskCount += parseInt(num);
                });
                $("#taskNum2").text(appCount - taskCount);
            });
            //减少任务数
            $("#timeimgReduce").live("click", function () {
                if ($("input[name=TaskPlanType]:checked").val() != "2")
                { return false; }
                var taskNum = parseInt($(this).parent().next().children().val());
                var taskCount = 0;
                if (taskNum > 0) {
                    $(this).parent().next().children().val(taskNum - 1);
                }
                $('input[name=TaskPlanCount]').each(function () {
                    var num = $(this).val();
                    taskCount += parseInt(num);
                });
                var appCount = parseInt($("#appCount").text());
                $("#taskNum2").text(appCount - taskCount);
            });
            $("input[name=TaskPlanCount]").live("keyup", function () {
                var taskCount = 0;
                $('input[name=TaskPlanCount]').each(function () {
                    var num = $(this).val();
                    taskCount += parseInt(num);
                });
                var appCount = parseInt($("#appCount").text());
                $("#taskNum2").text(appCount - taskCount);
            });

            //选择发布类型
            colseInput();
            $("#optionContainer1 tr:eq(1) td:eq(2)").children().removeAttr("disabled").removeClass("select1");
            $("#optionContainer1 tr:eq(1) td:eq(3)").children().removeAttr("disabled").removeClass("select1");
            $("#optionContainer1 tr:eq(1) td:eq(4)").children().removeAttr("disabled").removeClass("select1");
            $("input[name=TaskPlanType]").click(function () {
                $("#setTimes").hide();
                if ($(this).val() == "0") {
                    colseInput();
                    $("#optionContainer1 tr:eq(1) td:eq(4)").children().removeAttr("disabled").removeClass("select1");
                    $("#timeimgAdd,#timeimgReduce").removeClass("a1").addClass("a2").removeAttr("href");
                }
                else if ($(this).val() == "1") {
                    colseInput();
                    $("#optionContainer1 tr:eq(1) td:eq(2)").children().removeAttr("disabled").removeClass("select1");
                    $("#optionContainer1 tr:eq(1) td:eq(3)").children().removeAttr("disabled").removeClass("select1");
                    $("#optionContainer1 tr:eq(1) td:eq(4)").children().removeAttr("disabled").removeClass("select1");
                    $("#timeimgAdd,#timeimgReduce").removeClass("a1").addClass("a2").removeAttr("href");
                }
                else if ($(this).val() == "2") {
                    $("#timeimgAdd").show();
                    $("#setTimes").show();
                    openInput();
                    $("#optionContainer1 select").removeClass("select1");
                    $("#timeimgAdd,#timeimgReduce").removeClass("a2").addClass("a1").attr("href", "javascript:void(0)");
                }
            });

            $("#setTimes").click(function () {
                //                var taskCount = '0';
                //                var taskNum2 = parseInt($("#taskNum2").text());
                //                if (taskNum2 == taskCount) {
                //                    $.openAlter("任务数不能为0，请设置完毕后再点击该按钮批量设置任务的起止时间", "提示");
                //                    return false;
                //                }
                if (parseInt($("#taskNum2").text()) != 0) {
                    $.openAlter("设置的任务数总和必须等于任务总数", "提示");
                    return false;
                }
                //             
                $("#fade").height($(document).height());
                var scrollH = $(document).scrollTop();
                var scrollL = $(document).scrollLeft();
                var topVal = ($(window).height() - 300) / 2 + scrollH;
                var leftVal = ($(window).width() - 600) / 2 + scrollL;
                $("#light10").css("top", topVal);
                $("#light10").css("left", leftVal);
                document.getElementById('light10').style.display = 'block'; document.getElementById('fade').style.display = 'block';
            });
            //是否启用任务超时
            $('input[name=IsTimeoutTimes]').live("click", function () {
                if ($(this).attr("checked")) {
                    $(this).next().val("True");
                }
                else {
                    $(this).next().val("False");
                }
            });
        }
        function SetTime() {
            var vBeginHour = $("#optionContainer10 tr:eq(1) td:eq(0)").find("select:eq(0)").val();
            var vBeginMine = $("#optionContainer10 tr:eq(1) td:eq(0)").find("select:eq(1)").val();
            var vEndHour = $("#optionContainer10 tr:eq(1) td:eq(1)").find("select:eq(0)").val();
            var vEndMine = $("#optionContainer10 tr:eq(1) td:eq(1)").find("select:eq(1)").val();
            var vOverHour = $("#optionContainer10 tr:eq(1) td:eq(2)").find("select:eq(0)").val();
            var vOverMine = $("#optionContainer10 tr:eq(1) td:eq(2)").find("select:eq(1)").val();
            var BeginTime = vBeginHour + ":" + vBeginMine;
            var EndTime = vEndHour + ":" + vEndMine;
            var OverTime = vOverHour + ":" + vOverMine;
            if (vBeginHour == '' || vBeginMine == '' || vEndHour == '' || vEndMine == '') {
                $.openAlter("开始时间和结束时间不能为空", "提示");
                return false;
            }
            if (BeginTime >= EndTime) {
                $.openAlter("结束时间必须大于开始时间", "提示");
                return false;
            }
            if (EndTime >= OverTime) {
                $.openAlter("超时取消时间必须大于结束时间", "提示");
                return false;
            }
            var cDate = new Date();
            var cHour = cDate.getHours();
            var cMime = cDate.getMinutes();
            var indexs = 0;
            if (cHour < 10) {
                cHour = "0" + cHour;
            }
            if (cMime < 10) {
                cMime = "0" + cMime;
            }
            var cTime = cHour + ":" + cMime;

            $('input[name=TaskPlanCount]').each(function () {
                if ($(this).val() > 0) {
                    if (indexs == 0 && EndTime <= cTime) {
                        $(this).parent().parent().parent().next().find("select:eq(0)").val("");
                        $(this).parent().parent().parent().next().find("select:eq(1)").val("");
                        $(this).parent().parent().parent().next().next().find("select:eq(0)").val("");
                        $(this).parent().parent().parent().next().next().find("select:eq(1)").val("");
                        $(this).parent().parent().parent().next().next().next().find("select:eq(0)").val("");
                        $(this).parent().parent().parent().next().next().next().find("select:eq(1)").val("");
                    }
                    else if (indexs == 0 && BeginTime <= cTime) {
                        if (cMime > 0 && cMime <= 15) {
                            cMime = 45
                        }
                        else if (cMime > 15 && cMime <= 30) {
                            cHour = parseInt(cHour) + 1;
                            cMime = "00";
                        }
                        else if (cMime > 30 && cMime <= 45) {
                            cHour = parseInt(cHour) + 1;
                            cMime = 15;
                        }
                        else if (cMime > 45) {
                            cHour = parseInt(cHour) + 1;
                            cMime = 30;
                        }
                        $(this).parent().parent().parent().next().find("select:eq(0)").val(cHour);
                        $(this).parent().parent().parent().next().find("select:eq(1)").val(cMime);

                        $(this).parent().parent().parent().next().next().find("select:eq(0)").val(vEndHour);
                        $(this).parent().parent().parent().next().next().find("select:eq(1)").val(vEndMine);
                        $(this).parent().parent().parent().next().next().next().find("select:eq(0)").val(vOverHour);
                        $(this).parent().parent().parent().next().next().next().find("select:eq(1)").val(vOverMine);
                    }
                    else {
                        $(this).parent().parent().parent().next().find("select:eq(0)").val(vBeginHour);
                        $(this).parent().parent().parent().next().find("select:eq(1)").val(vBeginMine);
                        $(this).parent().parent().parent().next().next().find("select:eq(0)").val(vEndHour);
                        $(this).parent().parent().parent().next().next().find("select:eq(1)").val(vEndMine);
                        $(this).parent().parent().parent().next().next().next().find("select:eq(0)").val(vOverHour);
                        $(this).parent().parent().parent().next().next().next().find("select:eq(1)").val(vOverMine);
                    }

                }
                indexs++;
            });
            $("#aColse").click();
        }
        //禁用发布时间下的所有输入框
        function colseInput() {
            var appCount = parseInt($("#appCount").text());
            $("input[name=TaskPlanCount]").attr("disabled", true);
            $("input[name=IsTimeoutTime]").attr("disabled", true);
            $("#optionContainer1 select").attr("disabled", true);
            $("#optionContainer1 select").addClass("select1");
            $("input[name=TaskPlanCount]").val(0);
            $("input[name=IsTimeoutTime]").attr("checked", false);
            $("optionContainer1 select").val(0);
            $("#taskNum2").text(0);
            $("#optionContainer1 tr:eq(1) td:eq(1)").children().children().children("input").val(appCount);
        }
        //启用发布时间下的所有输入框
        function openInput() {
            $("input[name=TaskPlanCount]").removeAttr("disabled");
            $("input[name=IsTimeoutTime]").removeAttr("disabled");
            $("select").removeAttr("disabled");
        }
        function IsOpen() {
            $("input[name=OtherContents]").live("click", function () {
                if ($(this).attr("checked")) {
                    $(this).parent().next().next().find('input').removeAttr("disabled");
                }
                else {
                    $(this).parent().next().next().find('input').attr("disabled", true);
                }
            })
            $("input[name=SendProductCitys]").live("click", function () {
                if ($(this).attr("checked")) {
                    $(this).parent().next().next().find('input').removeAttr("disabled");
                }
                else {
                    $(this).parent().next().next().find('input').attr("disabled", true);
                }
            })
            $("input[name=SearchPrice]").live("click", function () {
                if ($(this).attr("checked")) {
                    $(this).parent().next().next().find('input').removeAttr("disabled");
                    $(this).parent().next().next().next().next().find('input').removeAttr("disabled");
                }
                else {
                    $(this).parent().next().next().find('input').attr("disabled", true);
                    $(this).parent().next().next().next().next().find('input').attr("disabled", true);
                }
            })
            $("input[name=SortTypes]").live("click", function () {
                if ($(this).attr("checked")) {
                    $(this).parent().next().next().find('select').removeAttr("disabled");
                }
                else {
                    $(this).parent().next().next().find('select').attr("disabled", true);
                }
            })
        }
        function keyValueMsg() {
            //验证输入的关键字是否包含在商品信息当中
            $("input[name=SearchKey]").live("blur", function () {
                var flage = 1;
                var productName = $("#tdFullName").text().toUpperCase();
                var value = $(this).val().trim().toUpperCase();
                if (value != "") {
                    value = value.split("");
                    for (x in value) {
                        if (value[x] != "" && value[x] != " ") {
                            if (productName.indexOf(value[x]) < 0) {
                                flage = 0;
                                break;
                            }
                        }
                    }
                }
                if (flage == 0) {
                    var cSearchType = $(this).parent().parent().find('td').eq(0).find('select > option:selected').text();

                    if (cSearchType.indexOf("淘口令") < 0) {
                        $.openAlter('关键字中包含标题中没有的字符，请检查确认。', '提示', { width: 250, height: 50 }, function () { }, "确认");
                        $("#msg").html("");
                    }
                    else {
                        $("#msg").html("<b style=\"color: Red\">温馨提示:</b> 关键字中包含标题中没有的字符，请检查确认。");
                    }
                }
                else {
                    $("#msg").html("");
                }
            });
        }

        //数量输入设置
        function wordCountInput() {
            $("input[name=KeyWordCount]").live("focus", function () {
                if ($(this).val() < 1) {
                    $(this).val(" ");
                }
            });
            $("input[name=KeyWordCount]").live("focusout", function () {
                if ($(this).val() < 1) {
                    $(this).val(0);
                }
            });
        }
        //设置是否启用其他搜索条件
        function setIsOtherCondition() {
            //是否启用排序方式
            $('input[name=SortTypes]').live("click", function () {
                if ($(this).attr("checked")) {
                    $(this).next().val("True");
                }
                else {
                    $(this).next().val("False");
                }
            });
            //是否启用价格区间
            $('input[name=SearchPrice]').live("click", function () {
                if ($(this).attr("checked")) {
                    $(this).next().val("True");
                }
                else {
                    $(this).next().val("False");
                }
            });
            //是否启用发货地
            $('input[name=SendProductCitys]').live("click", function () {
                if ($(this).attr("checked")) {
                    $(this).next().val("True");
                }
                else {
                    $(this).next().val("False");
                }
            });
            //是否启用其他
            $('input[name=OtherContents]').live("click", function () {
                if ($(this).attr("checked")) {
                    $(this).next().val("True");
                }
                else {
                    $(this).next().val("False");
                }
            });
        }
        //计算任务数量
        function taskCount() {
            $('input[name=KeyWordCount]').live("keyup", function () {
                var taskTotal = 0;  //任务总数
                var pcTotal = 0;  //PC任务总数
                var appTotal = 0;  //App任务总数
                $('input[name=KeyWordCount]').each(function () {
                    if ($(this).val() != " " && $(this).val() != "" && $(this).val() != null) {
                        taskTotal += parseInt($(this).val());
                    }
                    var cSearchType = $(this).parent().parent().find('td').eq(0).find('select > option:selected').text();
                    if (cSearchType.indexOf('PC') != -1) {
                        if ($(this).val() != " " && $(this).val() != "" && $(this).val() != null) {
                            pcTotal += parseInt($(this).val());
                        }
                    }
                    else if (cSearchType.indexOf('APP') != -1 || cSearchType.indexOf('微信') != -1 || cSearchType.indexOf('手机') != -1) {
                        if ($(this).val() != " " && $(this).val() != "" && $(this).val() != null) {
                            appTotal += parseInt($(this).val());
                        }
                    }
                });
                $("#taskCount").text(taskTotal);
                $("#pcCount").text(pcTotal);
                $("#appCount").text(appTotal);
                $("#spTotalTask").text(appTotal);
                $("#spBasicMoney").text(appTotal * wPice);
                //$("#spTotalMoney").text(appTotal * wPice);
                $("#taskTotalNum").text(appTotal);
                $("#optionContainer1 tr:eq(1) td:eq(1)").children().children().children("input").val(appTotal);
                PerTotal();
                if ($(this).val() <= 0 || $(this).val() > 200) {
                    $.openAlter("数量必须大于0小于等于200的整数", "提示");
                }
            });
        }

        var rowCount = 20;  //行数序列默认从20开始  
        //添加行  
        function addRow() {
            rowCount++;
            var seartypeNum = $("input[name=SearchKey]").length;
            if (seartypeNum > 20) {
                $.openAlter("最多添加20个来路设置", "提示");
            }
            else {
                //添加行内容
                var aDlist = $("#trHideSearch").clone().html();
                var trID = 'option' + rowCount;
                var searchTypeID = 'SearchType' + rowCount;
                aDlist = aDlist.replace("已设置", '设置');
                aDlist = aDlist.replace("input-butto100-xshs", 'input-butto100-xls');
                aDlist = aDlist.replace('delRow()', "delRow(" + rowCount + ")");
                aDlist = aDlist.replace('SearchType', searchTypeID);
                var id = 'light' + rowCount;
                aDlist = aDlist.replace('light1', id);
                aDlist = aDlist.replace('light1', id);
                //                alert(aDlist)
                $('#optionContainer').find('tbody').append("<tr id=" + trID + ">" + aDlist + "</tr>");

                //添加其他搜索条件
                var alist = $("#light1").clone().html();
                alist = alist.replace('light1', id);
                alist = alist.replace('light1', id);
                $('#idSet').append("<div id=\"light" + rowCount + "\" class=\"ycgl_tc yctc_460\">" + alist + "</div>");
            }
        }

        //删除后重新计算任务数量
        function reTaskCount() {
            var taskTotal = 0;
            var pcCounts = 0;
            var appTotals = 0;
            //删除后重新计算任务数量
            $('input[name=KeyWordCount]').each(function () {
                if ($(this).val() != " " && $(this).val() != "" && $(this).val() != null) {
                    taskTotal += parseInt($(this).val());
                }
                var cSearchType = $(this).parent().parent().find('td').eq(0).find('select > option:selected').text();
                if (cSearchType.indexOf('PC') != -1) {
                    if ($(this).val() != " " && $(this).val() != "" && $(this).val() != null) {
                        pcCounts += parseInt($(this).val());
                    }
                }
                if (cSearchType.indexOf('APP') != -1 || cSearchType.indexOf('微信') != -1 || cSearchType.indexOf('手机') != -1) {
                    if ($(this).val() != " " && $(this).val() != "" && $(this).val() != null) {
                        appTotals += parseInt($(this).val());
                    }
                }
            });
            $("#taskCount").text(taskTotal);
            $("#pcCount").text(pcCounts);
            $("#appCount").text(appTotals);
            $("#spTotalTask").text($("#appCount").text());
            $("#taskTotalNum").text($("#appCount").text());
            $("#spBasicMoney").text(parseInt($("#appCount").text()) * wPice);
            $("#spTotalMoney").text(parseInt($("#appCount").text()) * wPice);

            $("#optionContainer1 tr:eq(1) td:eq(1)").children().children().children("input").val(parseInt($("#appCount").text()));
            PerTotal(); ;
        }
        //删除行  
        function delRow(rowIndex) {
            $("#option" + rowIndex).remove();
            $("#light" + rowIndex).remove(); //删除对应的其他搜索条件
            //            rowCount--;
            reTaskCount(); //删除后重新计算任务数量 
        }
        //选择商品
        function SelectProduct() {
            $.openWin(680, 850, '/Fine/VTrafficTask/SelectProduct');
        }

        function GeDocumentHeight() {
            $(".black_overlay").height(document.body.scrollHeight).width($(document).width()).appendTo($("body"));
            var scrollH = $(document).scrollTop();
            var topVal = ($(window).height() - 400) / 2 + scrollH;
            $(".yctc_460").css("top", topVal);
            $(".yctc_498").css("top", topVal);
        }

        //设置其他条件
        function SetOtherCondition(obj) {
            var id = $(obj).attr("accesskey");
            var searchType = $(obj).parent().parent().find('td').eq(0).find('select > option:selected').val();
            var cOrder = $("#" + id + " select[name='SortType']").val();
            $("#" + id + " select[name='SortType']").empty();
            $("#" + id + " select[name='SortType']").append('<option value="0">综合</option><option value="1">新品</option><option value="2">人气</option><option value="3">销量</option><option value="4">价格从低到高</option><option value="5">价格从高到低</option>');
            $("#" + id + " select[name='SortType']").val(cOrder);
            if (searchType == '0') {
                $("#" + id + " select[name='SortType'] option[value='1']").remove();
                $("#" + id + " select[name='SortType'] option[value='2']").remove();
            }
            if (searchType == '3' || searchType == '4') {
                $("#" + id + " select[name='SortType'] option[value='1']").remove();
                $("#" + id + " select[name='SortType'] option[value='2']").remove();
                $("#" + id + " select[name='SortType'] option[value='3']").remove();
            }
            GeDocumentHeight();
            document.getElementById(id).style.display = 'block'; document.getElementById('fade').style.display = 'block'

            if (!$("#" + id + " input[name='OtherContents']").attr("checked")) {
                $("#" + id + " input[name='OtherContent']").attr("disabled", true);
            }
            if (!$("#" + id + " input[name='SendProductCitys']").attr("checked")) {
                $("#" + id + " input[name='SendProductCity']").attr("disabled", true);
            }
            if (!$("#" + id + " input[name='SortTypes']").attr("checked")) {
                $("#" + id + " select[name='SortType']").attr("disabled", true);
            }
            if (!$("#" + id + " input[name='SearchPrice']").attr("checked")) {
                $("#" + id + " input[name='PriceStart']").attr("disabled", true);
                $("#" + id + " input[name='PriceEnd']").attr("disabled", true);
            }
            //var searchType = $(obj).parent().parent().find('td').eq(0).find('select > option:selected').val();
            //$.openWin(360, 440, '/Fine/VTrafficTask/OtherCondition?searchType=' + searchType);
        }
        //流量入口 选择改变事件
        function SearchTypeChange(obj) {
            var id = $(obj).attr("id");
            var typeValue = $("#" + id).val();
            var cKey = $("#" + id).parent().next().find("input[name='SearchKey']");
            var cbtn = $("#" + id).parent().next().next().next().find("input[type='button']");

            cbtn.attr("value", "设置");
            var divID = cbtn.attr("accesskey");
            $("#" + divID + "").find("input[type=checkbox]").attr("checked", false);
            $("#" + divID + "").find("select option:first").attr("selected", true);
            $("#" + divID + "").find("input[name=IsSortType]").val("False");
            $("#" + divID + "").find("input[type=text]").val("");

            if (typeValue == "2") {

                cKey.attr("placeholder", "请设置淘口令");
                cbtn.attr("class", "input-butto100-xshs1");
                cbtn.attr("disabled", "disabled");
                cKey.removeAttr("disabled");
            }
            else if (typeValue == "9") {
                cKey.attr("disabled", "disabled");
                cKey.val("");
                cKey.attr("placeholder", "");
                cbtn.attr("class", "input-butto100-xshs1");
                cbtn.attr("disabled", "disabled");
            }
            else {
                cKey.attr("placeholder", "请设置关键字");
                cbtn.attr("class", "input-butto100-xls");
                cbtn.removeAttr("disabled");
                cKey.removeAttr("disabled");
            }



            reTaskCount(); //重新继续pc和app任务数量
            var screenshotTrain = '';
            var mobileScreenshotTrain = '';
            var screenshotTianMao = '';
            var qRCode = '';
            var isTmallImgRemind = 'False';
            if ('False' == "True") {
                if (typeValue == "9") {
                    if (qRCode == "" || qRCode == null) {
                        $.openWin(220, 500, '/Fine/VMTask/SearchTypeMsg?productID=' + '' + '&IsLock=' + 'False' + '&SearchType=' + '淘宝APP二维码');
                    }
                }
                if (typeValue == "4" || typeValue == "13") {
                    var strName = "";
                    if (typeValue == "4") {
                        strName = "淘宝PC直通车";
                    }
                    else {
                        strName = "天猫PC直通车";
                    }
                    if (screenshotTrain == "" || screenshotTrain == null) {
                        $.openWin(220, 500, '/Fine/VMTask/SearchTypeMsg?productID=' + '' + '&IsLock=' + 'False' + '&SearchType=' + strName);
                    }
                }
                if (typeValue == "3" || typeValue == "11") {
                    var strName = "";
                    if (typeValue == "3") {
                        strName = "淘宝APP直通车";
                    }
                    else {
                        strName = "天猫APP直通车";
                    }
                    if (mobileScreenshotTrain == "" || mobileScreenshotTrain == null) {
                        $.openWin(220, 500, '/Fine/VMTask/SearchTypeMsg?productID=' + '' + '&IsLock=' + 'False' + '&SearchType=' + strName);
                    }
                }

                if (typeValue == "12" || typeValue == "10") {
                    if (isTmallImgRemind != "True") {
                        var strName = "";
                        if (typeValue == "12") {
                            strName = "天猫PC搜索";
                        }
                        else {
                            strName = "天猫APP搜索";
                        }
                        if (screenshotTianMao == "" || screenshotTianMao == null) {
                            var productId = '';

                            $.post('/Fine/VTrafficTask/GetIsTmallImgRemind', { productId: productId }, function (result) {

                                if (result != "1") {
                                    $.openWin(220, 500, '/Fine/VMTask/SearchTypeMsg?productID=' + '' + '&IsLock=' + 'False' + '&SearchType=' + strName);
                                }
                            });
                        }
                    }
                }
            }
        }



        //问大家改变事件
        function QuestionChange(obj) {
            var num = $(obj).val();
            var taskTotal = $("#taskTotalNum").text();
            var price = '0.30';
            $(obj).parent().next().next().text(parseFloat(num * price).toFixed(2));
            TotalTrafficMoeny();
            if (num > 0) {
                var num2 = parseInt(num) + 1;
                for (var j = num2; j <= 5; j++) {
                    $("#trQus" + j).find("input[name=Questions]").val("");
                }
                $(".temp").hide();
                for (var i = 0; i <= num; i++) {
                    $("#trQus" + i).show();
                }
            }
            else {
                $(".temp").hide();
                $("input[name=Questions]").val("");
            }
            if (parseInt(num) > parseInt(taskTotal)) {
                $.openAlter("问大家提问数量不能大于任务总数。", "提示");
                return false;
            }
        }
        function QuestionInput() {
            $("input[name=Questions]").live("blur", function () {
                var qaNum = $("#selectQA option:selected").text();
                var Counts = 0;
                $('input[name=Questions]').each(function () {
                    if ($(this).val() != " " && $(this).val() != "" && $(this).val() != null) {
                        Counts++;
                    }
                });
                if (Counts > parseInt(qaNum)) {
                    $.openAlter("问大家提问内容设置输入内容的条数必须和问大家提问数量相等。", "提示");
                    return false;
                }
                if ($(this).val().length > 0 && ($(this).val().length > 40 || $(this).val().length < 4)) {
                    $.openAlter("问大家提问内容限制输入4-40个中文字符。", "提示");
                    return false;
                }

            });
        }

        //增值业务
        function AddedServiceChange(obj) {
            var trafficPrice = 0;
            var value = parseFloat($(obj).val() / 100);
            var appCount = parseInt($("#appCount").text());
            $(obj).parent().next().text(Math.round(value * appCount));
            var txtType = $(obj).parent().prev().text().trim();
            if (txtType == "收藏商品")
                trafficPrice = '0.10';
            else if (txtType == "收藏店铺")
                trafficPrice = '0.10';
            else if (txtType == "加入购物车")
                trafficPrice = '0.10';
            else if (txtType == "问大家提问")
                trafficPrice = '0.30';
            else if (txtType == "旺旺咨询")
                trafficPrice = '0.30';
            else if (txtType == "领优惠劵")
                trafficPrice = '0.10';
            $(obj).parent().next().next().next().text(parseFloat(Math.round(value * appCount) * trafficPrice).toFixed(2));
            TotalTrafficMoeny();
        }
        //统计增值业务费用
        function TotalTrafficMoeny() {
            var money = 0;
            $("#optionContainer2 tr:gt(0):not('.temp')").each(function () {
                money += parseFloat($(this).children("td:last").text());
            });
            var totalTask = parseInt($("#spTotalTask").text());
            $("#spTotalMoney").text((parseFloat(money) + parseFloat(totalTask * wPice)).toFixed(2));
        }

        function PerTotal() {
            var trafficPrice = 0;
            $("#optionContainer2 tr:gt(0):not('.temp')").each(function () {
                var tasks = $(this).children().find('select > option:selected').text();
                var value = parseFloat(tasks / 100);
                var appCount = parseInt($("#appCount").text());
                var txtType = $(this).children("td:eq(0)").text().trim();
                if (txtType == "收藏商品")
                    trafficPrice = '0.10';
                else if (txtType == "收藏店铺")
                    trafficPrice = '0.10';
                else if (txtType == "加入购物车")
                    trafficPrice = '0.10';
                else if (txtType == "问大家提问")
                    trafficPrice = '0.30';
                else if (txtType == "旺旺咨询")
                    trafficPrice = '0.30';
                else if (txtType == "领优惠劵")
                    trafficPrice = '0.10';
                if (txtType != "问大家提问") {
                    $(this).children("td:eq(2)").text(Math.round(value * appCount));
                    $(this).children("td:last").text(parseFloat(Math.round(value * appCount) * trafficPrice).toFixed(2));
                }
            });
            TotalTrafficMoeny();
        }
        //验证表单信息是否正确录入
        function CheckNext() {
            var wordCount = 0;
            var searchKey = 0;
            var searchKey2 = 0;
            var num = 0;
            var taskTotal = 0;
            var indexRow = 0;

            var screenshotTrain = '';
            var mobileScreenshotTrain = '';
            var qRCode = '';
            $("select[name=SearchType]").find("option:selected").each(function () {
                if (indexRow > 0) {
                    return false;
                }
                if (($(this).parent().parent().parent().attr("id")) != "trHideSearch") {
                    var typeValue = $(this).val();
                    if (typeValue == "9") {
                        if (qRCode == "" || qRCode == null) {
                            $.openWin(220, 500, '/Fine/VMTask/SearchTypeMsg?productID=' + '' + '&IsLock=' + 'False' + '&SearchType=' + '淘宝APP二维码');
                            indexRow++;
                            return false;
                        }
                    }
                    if (typeValue == "4" || typeValue == "13") {
                        var strName = "";
                        if (typeValue == "4") {
                            strName = "淘宝PC直通车";
                        }
                        else {
                            strName = "天猫PC直通车";
                        }
                        if (screenshotTrain == "" || screenshotTrain == null) {
                            $.openWin(220, 500, '/Fine/VMTask/SearchTypeMsg?productID=' + '' + '&IsLock=' + 'False' + '&SearchType=' + strName);
                            indexRow++;
                            return false;
                        }
                    }

                    if (typeValue == "3" || typeValue == "11") {
                        var strName = "";
                        if (typeValue == "3") {
                            strName = "淘宝APP直通车";
                        }
                        else {
                            strName = "天猫APP直通车";
                        }
                        if (mobileScreenshotTrain == "" || mobileScreenshotTrain == null) {
                            $.openWin(220, 500, '/Fine/VMTask/SearchTypeMsg?productID=' + '' + '&IsLock=' + 'False' + '&SearchType=' + strName);
                            indexRow++;
                            return false;
                        }
                    }
                }
            });
            if (indexRow > 0)
                return false;

            var percentIndex = 0;
            $('input[name=KeyWordCount]').each(function () {
                if ($(this).val() != " " && $(this).val() != "" && $(this).val() != null) {
                    taskTotal += parseInt($(this).val());
                }
                if ($(this).val() == " " || $(this).val() == "" || $(this).val() == null) {
                    wordCount++;
                }
            });
            $('input[name=SearchKey]').each(function () {
                if ($(this).val() == " " || $(this).val() == "" || $(this).val() == null) {
                    var searchType = $(this).parent().parent().find('td').eq(0).find('select > option:selected').val();
                    if (searchType != "9")
                        searchKey++;
                }
                if ($(this).val() != " " && $(this).val() != "" && $(this).val() != null) {

                    var searchType = $(this).parent().parent().find('td').eq(0).find('select > option:selected').val();
                    if (searchType == "2") {
                        if ($(this).val().indexOf("￥") == -1) {

                            searchKey2++;
                        }
                    }
                }
            });
            $('input[name=KeyWordCount]').each(function () {
                if ($(this).val() <= 0 || $(this).val() > 200) {
                    num++;
                }
            });

            $('input[name=ConversionPercent]').each(function () {
                if (parseFloat($(this).val()) < 0 || parseFloat($(this).val()) > 200 || $(this).val() == "" || $(this).val() == " " || $(this).val() == null) {
                    percentIndex++;
                }
            });
            if ('' == null || '' == '') {
                $.openAlter("请先选定一个商品。", "提示");
                return false;
            }
            if (searchKey > 1) {
                $.openAlter("关键字不能为空", "提示");
                return false;
            }
            if (searchKey2 > 0) {
                $.openAlter("淘口令设置错误,请检查后重新设置", "提示");
                return false;
            }
            if (wordCount > 1) {
                $.openAlter("数量不能为空", "提示");
                return false;
            }
            if (num > 1) {
                $.openAlter("数量必须大于0小于等于200的整数", "提示");
                return false;
            }
            if (taskTotal > 200) {
                $.openAlter("任务总数不能超过200个", "提示");
                return false;
            }

            if (percentIndex >= 1) {
                $.openAlter("转化率输入框必须是大于等于0小于等于200", "提示");
                return false;
            }
            //            if ($("#textarea").val() == "" || $("#textarea").val() == null) {
            //                $.openAlter("备注不能为空", "提示");
            //                return false;
            //            }
            var vBeginHour = $("#optionContainer1 tr:eq(1) td:eq(2)").find("select:eq(0)").val();
            var vBeginMine = $("#optionContainer1 tr:eq(1) td:eq(2)").find("select:eq(1)").val();
            var vEndHour = $("#optionContainer1 tr:eq(1) td:eq(3)").find("select:eq(0)").val();
            var vEndMine = $("#optionContainer1 tr:eq(1) td:eq(3)").find("select:eq(1)").val();
            var vOutHour = $("#optionContainer1 tr:eq(1) td:eq(4)").find("select:eq(0)").val();
            var vOutMine = $("#optionContainer1 tr:eq(1) td:eq(4)").find("select:eq(1)").val();
            var vIsTimeout = $("#optionContainer1 tr:eq(1) td:eq(4)").find("input[name=IsTimeoutTimes]").val();
            var BeginTime = vBeginHour + ":" + vBeginMine;
            var EndTime = vEndHour + ":" + vEndMine;
            var OutTime = vOutHour + ":" + vOutMine;
            var cDate = new Date();
            var cHour = cDate.getHours();
            var cMime = cDate.getMinutes();
            if (cHour < 10) {
                cHour = "0" + cHour;
            }
            if (cMime < 10) {
                cMime = "0" + cMime;
            }
            var cTime = cHour + ":" + cMime;
            if (parseInt($("#taskNum2").text()) != 0) {
                $.openAlter("发布时间任务数量必须等于任务总数", "提示");
                return false;
            }
            //            if ($("input[name=TaskPlanType]:checked").val() == "0" && (vOutHour == '' || vOutMine == '')) {
            //                if ($("#optionContainer1 tr:eq(1) td:eq(4)").find("input[name=IsTimeoutTimes]").attr("checked")) {
            //                    $.openAlter("启用超时时间时,超时取消时间不能为空", "提示");
            //                    return false;
            //                }
            //            }
            if ($("input[name=TaskPlanType]:checked").val() == "0" && ((vOutHour != '' && vOutMine == '') || (vOutHour == '' && vOutMine != ''))) {
                $.openAlter("启用超时时间时,超时取消时间不能为空", "提示");
                return false;
            }
            if (($("input[name=TaskPlanType]:checked").val() == "1" || $("input[name=TaskPlanType]:checked").val() == "2") && BeginTime <= cTime) {
                $.openAlter("今天的开始时间必须大于当前时间", "提示");
                return false;
            }
            if ($("input[name=TaskPlanType]:checked").val() == "1" && (vBeginHour == '' || vBeginMine == '' || vEndHour == '' || vEndMine == '')) {
                $.openAlter("开始时间和结束时间不能为空", "提示");
                return false;
            }
            if ($("input[name=TaskPlanType]:checked").val() == "1" && (BeginTime >= EndTime)) {
                $.openAlter("结束时间必须大于开始时间", "提示");
                return false;
            }
            if ($("input[name=TaskPlanType]:checked").val() == "1" && (EndTime >= OutTime)) {
                //                if ($("#optionContainer1 tr:eq(1) td:eq(4)").find("input[name=IsTimeoutTimes]").attr("checked")) {
                $.openAlter("启用超时时间时,超时时间必须大于结束时间", "提示");
                return false;
                //                }
            }
            if (($("input[name=TaskPlanType]:checked").val() == "0" || $("input[name=TaskPlanType]:checked").val() == "1") && (vOutHour != '' || vOutMine != '')) {
                //                if ($("#optionContainer1 tr:eq(1) td:eq(4)").find("input[name=IsTimeoutTimes]").attr("checked") && OutTime <= cTime) 
                if (OutTime <= cTime) {
                    $.openAlter("启用超时时间时,超时时间必须大于当前时间", "提示");
                    return false;
                }
            }
            if ($("input[name=TaskPlanType]:checked").val() == "1" && ((vOutHour != '' && vOutMine == '') || (vOutHour == '' && vOutMine != ''))) {
                //                if ($("#optionContainer1 tr:eq(1) td:eq(4)").find("input[name=IsTimeoutTimes]").attr("checked")) {
                $.openAlter("启用超时时间时,超时取消时间不能为空", "提示");
                return false;
                //                }
            }
            if ($("input[name=TaskPlanType]:checked").val() == "2") {
                var timenull = 0;
                var timeBig = 0;
                var timeOut = 0;
                var timeOutBig = 0;
                $('input[name=TaskPlanCount]').each(function () {
                    var num = $(this).val();
                    if (num > 0) {
                        var vBeginHour = $(this).parent().parent().parent().next().find("select:eq(0)").val();
                        var vBeginMine = $(this).parent().parent().parent().next().find("select:eq(1)").val();
                        var vEndHour = $(this).parent().parent().parent().next().next().find("select:eq(0)").val();
                        var vEndMine = $(this).parent().parent().parent().next().next().find("select:eq(1)").val();
                        var vOutHour = $(this).parent().parent().parent().next().next().next().find("select:eq(0)").val();
                        var vOutMine = $(this).parent().parent().parent().next().next().next().find("select:eq(1)").val();
                        var BeginTime = vBeginHour + ":" + vBeginMine;
                        var EndTime = vEndHour + ":" + vEndMine;
                        var OutTime = vOutHour + ":" + vOutMine;
                        if (vBeginHour == '' || vBeginMine == '' || vEndHour == '' || vEndMine == '') {
                            timenull++;
                        }
                        else if (BeginTime != '' && EndTime != '' && BeginTime >= EndTime) {
                            timeBig++;
                        }
                        else if ((vOutHour != '' && vOutMine == '') || (vOutHour == '' && vOutMine != '')) {
//                            if ($(this).parent().parent().parent().next().next().next().find("input[name=IsTimeoutTimes]").attr("checked")) {
                                timeOut++;
//                            }
                        }
                        else if (EndTime != '' && OutTime != '' && EndTime >= OutTime) {
//                            if ($(this).parent().parent().parent().next().next().next().find("input[name=IsTimeoutTimes]").attr("checked")) {
                                timeOutBig++;
//                            }
                        }
                    }
                });

                if (parseInt(timenull) > 0) {
                    $.openAlter("开始时间和结束时间不能为空", "提示");
                    return false;
                }
                else if (parseInt(timeBig) > 0) {
                    $.openAlter("结束时间必须大于开始时间", "提示");
                    return false;
                }
                else if (parseInt(timeOut) > 0) {
                    $.openAlter("启用超时时间时,超时取消不能为空", "提示");
                    return false;
                }
                else if (parseInt(timeOutBig) > 0) {
                    $.openAlter("启用超时时间时,超时时间必须大于结束时间", "提示");
                    return false;
                }
            }
            var QAnum = $("#selectQA option:selected").text(); ;
            var taskTotal = $("#taskTotalNum").text();
            if (parseInt(QAnum) > parseInt(taskTotal)) {
                $.openAlter("问大家提问数量不能大于任务总数。", "提示");
                return false;
            }
            var QCounts = 0;
            var strLenght = 0;
            $('input[name=Questions]').each(function () {
                if ($(this).val() != " " && $(this).val() != "" && $(this).val() != null) {
                    QCounts++;
                }
                if ($(this).val().length > 0 && ($(this).val().length > 40 || $(this).val().length < 4)) {
                    strLenght++;
                }
            });
            if (QCounts != parseInt(QAnum)) {
                $.openAlter("问大家提问内容设置输入内容的条数必须和问大家提问数量相等。", "提示");
                return false;
            }
            if (strLenght > 0) {
                $.openAlter("问大家提问内容设置限制输入4-40个中文字符。", "提示");
                return false;
            }
            $("select[name='SortType']").removeAttr("disabled");
            $("input[name='PriceStart']").removeAttr("disabled");
            $("input[name='PriceEnd']").removeAttr("disabled");
            $("input[name='SendProductCity']").removeAttr("disabled");
            $("input[name='OtherContent']").removeAttr("disabled");
            $("input[name='SearchKey']").removeAttr("disabled");
            var pwd = hex_md5($("#pwd").val());
            var msg = "";
            if ($("#pwd").val() == "") {
                $.openAlter("请输入支付密码", "提示");
                return false;
            }
            else {
                $.ajaxSetup({
                    async: false
                });
                $.post('/Fine/VTrafficTask/GetTradersPassword', { pwd: pwd }, function (result) {
                    if (result == "0") {
                        msg = "安全密码不正确";
                    }
                });
                if (msg == "") {
                    $.post('/Fine/VTrafficTask/getMember', function (result) {
                        var member = eval("(" + result + ")");
                        if (parseFloat(member["Amount"]) < parseFloat($("#spTotalMoney").text())) {
                            msg = "<span id='showyue'><label>账户存款余额不足</label><a target='_blank' style='color:#337FE5;' href='/Member/MemberInfo/ShopMemberDuiHuan'>（请点击将发布点兑换为存款）</a></span>";
                        }
                    });
                }
            }
            if (msg != "") {
                $.openAlter(msg, "提示");
                return false;
            }

            $("#pwd").val(pwd);
            var cnt = $("#submitCnt").val();
            if (cnt == "0") {
                $("#btnSubmitOk").val("确认发布...");
                $("#btnSubmitOk").attr("class", "input-butto100-xxshs");

                $("#trHideSearch").remove();
                $('#frm').submit(); //提交表单
            }
            else {
                return false;
            }
        }
        //提交表单到下一步
        function submitNext() {
            $("#trHideSearch").remove();
            $('#frm').submit(); //提交表单
        }
        function setFinish(id) {
            var SortType = $("#" + id + "").find("select[name=SortType] option:selected").text();
            var PriceStart = $("#" + id + "").find("input[name=PriceStart]").val();
            var PriceEnd = $("#" + id + "").find("input[name=PriceEnd]").val();
            var SendProductCity = $("#" + id + "").find("input[name=SendProductCity]").val();
            var OtherContent = $("#" + id + "").find("input[name=OtherContent]").val();

            if ((SortType != null && $("#" + id + "").find("input[name=SortTypes]").attr("checked") == "checked") ||
          ($("#" + id + "").find("input[name=SearchPrice]").attr("checked") == "checked" && PriceStart != "" && PriceEnd != "") ||
          ($("#" + id + "").find("input[name=SendProductCitys]").attr("checked") == "checked" && SendProductCity.trim() != "") ||
          ($("#" + id + "").find("input[name=OtherContents]").attr("checked") == "checked" && OtherContent.trim() != "")) {
                $("input[accesskey=" + id + "]").val("已设置");
                $("input[accesskey=" + id + "]").attr("class", "input-butto100-xshs");
            }
            else {
                $("input[accesskey=" + id + "]").val("设置");
                $("input[accesskey=" + id + "]").attr("class", "input-butto100-xls");
            }
            document.getElementById(id).style.display = 'none'; document.getElementById('fade').style.display = 'none'
        }
    </script>


<body style="background: #fff;">
   <?php require_once('include/nav.php')?>  
    <!--daohang-->
    
    
<form action="#" id="frm" method="post">        <div id="light10" class="ycgl_tc yctc_1200" style="width: 600px; height: 300px;">
            <!--标题 -->
            <div class="htyg_tc">
                <ul>
                    <li class="htyg_tc_1">
                        <center style="margin-left: 225px">
                            一键设置时间</center>
                    </li>
                    <li class="htyg_tc_2"><a href="javascript:void(0)" id="aColse" onclick="document.getElementById('light10').style.display='none';document.getElementById('fade').style.display='none'">
                        <img src="style/sj-tc.png"></a> </li>
                </ul>
            </div>
            <!--标题 -->
            <!--滚动内容 -->
            <div class="sk-hygl-gd_gq" style="width: 600px">
                <!--表格内容 -->
                <center>
                    <div style="margin-top: 5px; text-align: left; width: 500px">
                        请设置任务的开始时间和结束时间，所设置的时间会应用到所有设置了任务数的日期。</div>
                </center>
                <center>
                    <div style="width: 500px; margin-top: 5px;">
                        <div class="fprw-pg">
                            <table id="optionContainer10">
                                <tbody><tr>
                                    <th width="231">
                                        开始时间
                                    </th>
                                    <th width="231">
                                        结束时间
                                    </th>
                                    <th width="231">
                                        超时时间 (选填)
                                    </th>
                                </tr>
                                <tr>
                                    <td>
                                        <select><option></option><option>00</option><option>01</option><option>02</option><option>03</option><option>04</option><option>05</option><option>06</option><option>07</option><option>08</option><option>09</option><option>10</option><option>11</option><option>12</option><option>13</option><option>14</option><option>15</option><option>16</option><option>17</option><option>18</option><option>19</option><option>20</option><option>21</option><option>22</option><option>23</option>
                                        </select>
                                        ：<select id="selBeginTimeM"><option></option>
                                            <option>00</option>
                                            <option>15</option>
                                            <option>30</option>
                                            <option>45</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select id="selEndTimeH"><option></option><option>00</option><option>01</option><option>02</option><option>03</option><option>04</option><option>05</option><option>06</option><option>07</option><option>08</option><option>09</option><option>10</option><option>11</option><option>12</option><option>13</option><option>14</option><option>15</option><option>16</option><option>17</option><option>18</option><option>19</option><option>20</option><option>21</option><option>22</option><option>23</option>
                                        </select>
                                        ：
                                        <select id="selEndTimeM">
                                            <option></option>
                                            <option>00</option>
                                            <option>15</option>
                                            <option>30</option>
                                            <option>45</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select id="selOverTimeH"><option></option><option>00</option><option>01</option><option>02</option><option>03</option><option>04</option><option>05</option><option>06</option><option>07</option><option>08</option><option>09</option><option>10</option><option>11</option><option>12</option><option>13</option><option>14</option><option>15</option><option>16</option><option>17</option><option>18</option><option>19</option><option>20</option><option>21</option><option>22</option><option>23</option>
                                        </select>
                                        ：
                                        <select id="selOverTimeM">
                                            <option></option>
                                            <option>00</option>
                                            <option>15</option>
                                            <option>30</option>
                                            <option>45</option>
                                        </select>
                                    </td>
                                </tr>
                            </tbody></table>
                        </div>
                    </div>
                    <div>
                        <ul>
                            <li class="fpgl-tc-qxjs_4">
                                <p style="margin-left: -250px">
                                    <input class="input-butto100-hs" type="button" onclick="SetTime()" value="确认提交">
                                    <input type="hidden" id="submitCnt" value="0">
                                </p>
                                <p style="margin-left: 80px; margin-top: -35px">
                                    <input class="input-butto100-ls" type="button" value="返回修改" onclick="document.getElementById('light10').style.display='none';document.getElementById('fade').style.display='none'"></p>
                            </li>
                        </ul>
                    </div>
                </center>
            </div>
            <!--滚动内容 -->
        </div>
        <div id="fade" class="black_overlay">
        </div>
        <!--添加弹窗 选择商品 -->
        <!--添加弹窗 其他搜索条件 -->
        <div id="light1" class="ycgl_tc yctc_460">
            <!--列表 -->
            <div class="htyg_tc">
                <ul>
                    <li class="htyg_tc_1">其他搜索条件</li>
                    <li class="htyg_tc_2"><a href="javascript:void(0)" onclick="document.getElementById('light1').style.display='none';document.getElementById('fade').style.display='none'">
                        <img src="style/sj-tc.png"></a> </li>
                </ul>
            </div>
            <!--列表 -->
            <div class="yctc_420 ycgl_tc_1">
                <ul>
                    <li>
                        <p class="fprw-xzgl_3">
                            <input type="checkbox" class="input-checkbox16" name="SortTypes">
                            <input type="hidden" name="IsSortType" value="False">
                        </p>
                        <p class="fprw-xzgl_4">
                            排序方式：</p>
                        <p>
                            
                            <select class="select_215" disabled="disabled" id="SortType" name="SortType"><option value="0">综合</option>
<option value="1">新品</option>
<option value="2">人气</option>
<option value="3">销量</option>
<option value="4">价格从低到高</option>
<option value="5">价格从高到低</option>
</select>
                        </p>
                        <p>
                        </p>
                    </li>
                    <li class="fprw-xzgl_5">
                        <p class="fprw-xzgl_3">
                            <input type="checkbox" class="input-checkbox16" name="SearchPrice">
                            <input type="hidden" name="IsSearchPrice" value="False">
                        </p>
                        <p class="fprw-xzgl_4">
                            价格区间：</p>
                        <p>
                            <input type="text" name="PriceStart" class="input_108" onkeyup="value=value.replace(/[^0-9]/g,'')" disabled="disabled" maxlength="6"></p>
                        <p class="fprw-xzgl_4">
                            ~</p>
                        <p>
                            <input type="text" name="PriceEnd" class="input_108" onkeyup="value=value.replace(/[^0-9]/g,'')" disabled="disabled" maxlength="6"></p>
                    </li>
                        <li class="fprw-xzgl_5">
                            <p class="fprw-xzgl_3">
                                <input type="checkbox" class="input-checkbox16" name="SendProductCitys">
                                <input type="hidden" name="IsSendProductCity" value="False">
                            </p>
                            <p class="fprw-xzgl_4">
                                发货地：&nbsp;&nbsp;&nbsp;</p>
                            <p>
                                <input type="text" name="SendProductCity" class="input_240" maxlength="30" disabled="disabled">
                            </p>
                        </li>
                    <li class="fprw-xzgl_5">
                        <p class="fprw-xzgl_3">
                            <input type="checkbox" class="input-checkbox16" name="OtherContents">
                            <input type="hidden" name="IsOtherContent" value="False">
                        </p>
                        <p class="fprw-xzgl_4">
                            其他：&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
                        <p>
                            <input type="text" name="OtherContent" class="input_240" maxlength="30" disabled="disabled"></p>
                    </li>
                    <li>
                        <div class="fprw-xzgl_2">
                            <input class="input-butto100-ls" onclick="setFinish('light1')" type="button" value="确定">
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div id="idSet">
        </div>
        <div id="fade" class="black_overlay">
        </div>
        <!--添加弹窗 其他搜索条件 -->
        <!--添加弹窗 转化率设置 -->
        <div id="flight" class="ycgl_tc yctc_498">
            <!--列表 -->
            <div class="htyg_tc">
                <ul>
                    <li class="htyg_tc_1">转化率设置</li>
                    <li class="htyg_tc_2"><a href="javascript:void(0)" onclick="document.getElementById('flight').style.display='none';document.getElementById('fade').style.display='none'">
                        <img src="style/sj-tc.png"></a> </li>
                </ul>
            </div>
            <!--列表 -->
            <div class="yctc_458 ycgl_tc_1">
                <ul>
                    <li class="fprw-xzgl_6"><strong class="cff3430">友情提醒：</strong>转化率过高容易触发稽查系统，建议使用流量配合把转化率控制在类目平均水平。</li>
                    <li class="fpgl-tc-qxjs_4">
                        <p>
                            <a href="javascript:void(0)">
                                <input class="input-butto100-hs" type="button" value="继续发布" onclick="submitNext()">
                            </a>
                        </p>
                        <p>
                            <input onclick="document.getElementById('flight').style.display='none';document.getElementById('fade').style.display='none'" class="input-butto100-ls" type="button" value="返回修改"></p>
                    </li>
                </ul>
            </div>
        </div>
        <div id="fade" class="black_overlay">
        </div>
        <!--添加弹窗 转化率设置 -->
        <div class="sj-fprw">
            <div class="tab1" id="tab1">
                <div class="menu">
                    <ul>
                        <li id="one2" class="off" onclick="location.href='/Fine/VTrafficTask'">
                            发布流量任务</li>
                        <li id="one1" onclick="location.href='/Fine/VTrafficTask/TaskIndex'">流量任务管理</li>
                        
                    </ul>
                </div>
            </div>
            <div style="width: 1315px; margin-left: -80px;">

            </div>
            <!-- 内容-->
            
            <!-- 切换-->
            
            <!-- 切换-->
            <input id="ProductID" name="ProductID" type="hidden" value="">
            <input data-val="true" data-val-required="PlatformType 字段是必需的。" id="PlatformType" name="PlatformType" type="hidden" value="淘宝">
            <input id="HashPointToken" name="HashPointToken" type="hidden" value="6fb21c6c50319ef12b5681ab7fb66499">
            <!-- 选定商品-->
            <div class="fprw-sdsp">
                <div class="fprw-sdsp_1">
                    <p class="left">
                        选定商品</p>
                    <p class="right">
                        <input type="button" onclick="SelectProduct()" class="input-butto100-zlsc" value="选择商品"></p>
                </div>
                <div class="fprw-sdsp_2">
                    <table style="table-layout: fixed;">
                        <tbody><tr>
                            <th width="182">
                                商品简称
                            </th>
                            <td width="700px">
                            </td>
                            <td width="208" rowspan="5">
                            </td>
                        </tr>
                        <tr>
                            <th width="182">
                                商品ID&nbsp;&nbsp;&nbsp;
                            </th>
                            <td width="700">
                            </td>
                        </tr>
                        <tr>
                            <th width="182">
                                店铺名&nbsp;&nbsp;&nbsp;
                            </th>
                            <td width="700px" id="tdShopName">
                            </td>
                        </tr>
                        <tr>
                            <th width="182">
                                商品标题
                            </th>
                            <td width="700px" id="tdFullName">
                            </td>
                        </tr>
                        <tr>
                            <th width="182">
                                商品链接
                            </th>
                            <td width="700px" style="word-wrap: break-word">
                            </td>
                        </tr>
                    </tbody></table>
                </div>
            </div>
            <!-- 选定商品-->
<!-- 任务类型-->
<!-- 标题-->
<div class="fprw-zpt">
    <div class="left fprw-pt" style="margin-top: 0px">
        来路设置</div>
    <span style="margin-left: 110px; position: absolute; font-size: 14px;" id="msg">
    </span>
    <div class="right" style="margin-top: 0px">
        <span class="fprw-pt-xts_1">总数：<em class="cff3430" id="taskCount">0</em> </span>
        <span class="fprw-pt-xts_1">PC：<em class="cff3430" id="pcCount">0</em> </span><span class="fprw-pt-xts_1">无线端：<em class="cff3430" id="appCount">0</em> </span><span>
                <input type="button" class="input-butto100-zls" onclick="addRow()" value="新增"></span>
    </div>
</div>
<!-- 标题-->
<!-- 表格-->
<div class="fprw-pg" style="margin-top: 0px;">
    <table id="optionContainer">
        <tbody><tr>
            <th width="144">
                流量入口
            </th>
            <th width="358">
                <span style="margin-left: 160px">关键字</span> <span style="margin-left: 50px"><a href="http://qqq.wkquan.com/Other/Content/NNewsInfo?id=38" target="_blank" style="text-decoration: underline; color: Red;">搜索关键字设置规范</a></span>
            </th>
            <th width="114">
                数量
            </th>
            
            <th width="180">
                其他搜索条件（可选）
            </th>
            <th width="118">
                操作
            </th>
        </tr>
        <tr>
            <td><select class="select_108" id="SearchType" name="SearchType" onchange="SearchTypeChange(this)"><option value="0">淘宝APP自然搜索</option>
<option value="2">淘宝APP淘口令</option>
<option value="3">淘宝APP直通车</option>
</select>
            </td>
            <td>
                <input type="text" name="SearchKey" class="input_300" maxlength="500" value="" placeholder="请设置关键字">
            </td>
            <td>
                <input type="text" name="KeyWordCount" class="input_60" maxlength="3" placeholder="0" value="0" onkeyup="value=value.replace(/[^0-9]/g,'')">
            </td>
            
            <td>
                <input type="button" class="input-butto100-xls" onclick="SetOtherCondition(this)" accesskey="light1" value="设置">
                
            </td>
            <td>
                <input type="button" class="input-butto100-zls" onclick="delRow()" value="删除">
            </td>
        </tr>
        <tr id="trHideSearch" style="display: none">
            <td><select class="select_108" id="SearchType" name="SearchType" onchange="SearchTypeChange(this)"><option value="0">淘宝APP自然搜索</option>
<option value="2">淘宝APP淘口令</option>
<option value="3">淘宝APP直通车</option>
</select>
            </td>
            <td>
                <input type="text" name="SearchKey" class="input_300" maxlength="500" value="" placeholder="请设置关键字">
            </td>
            <td>
                <input type="text" name="KeyWordCount" class="input_60" maxlength="3" placeholder="0" value="0" onkeyup="value=value.replace(/[^0-9]/g,'')">
            </td>
            
            <td>
                <input type="button" class="input-butto100-xls" onclick="SetOtherCondition(this)" accesskey="light1" value="设置">
            </td>
            <td>
                <input type="button" class="input-butto100-zls" onclick="delRow()" value="删除">
            </td>
        </tr>
    </tbody></table>
</div>
<!-- 表格-->
            <!-- 表格-->
            <!-- 标题-->
            <div class="fprw-kdlx_2" style="height: 60px;">
                <p style="line-height: 60px;">
                    备注信息(选填)：</p>
                <p>
                    <textarea class="textarea_1050" cols="45" id="textarea" maxlength="100" name="TaskRemark" rows="5" style="width:1000px;height:40px;"></textarea>
                    </p>
            </div>
            <div class="fprw-zpt">
                <div class="left fprw-jg">
                    <p class="fprw-jg_1">
                        发布时间</p>
                    <p class="fprw-jg_2">
                        <input class="input-radio16" style="height: 15px" type="radio" name="TaskPlanType" value="0"></p>
                    <p>
                        立即发布</p>
                    <p class="fprw-jg_3">
                        <input class="input-radio16" style="height: 15px" type="radio" name="TaskPlanType" checked="checked" value="1"></p>
                    <p>
                        今天平均发布</p>
                    <p class="fprw-jg_3">
                        <input class="input-radio16" style="height: 15px" type="radio" name="TaskPlanType" value="2"></p>
                    <p>
                        多天平均发布</p>
                    <input type="button" id="setTimes" style="width: 100px; height: 28px; line-height: 28px;
                        display: none" class="input-butto100-zls" value="一键设置时间">
                </div>
                <div class="right">
                    <span class="fprw-pt-xts_1">任务总数：<em class="cff3430" id="taskTotalNum">0</em> </span>
                </div>
            </div>
            <!-- 标题-->
            <!-- 表格-->
            <div class="fprw-pg" style="margin-top: 0px;">
                <table id="optionContainer1">
                    <tbody><tr>
                        <th width="231">
                            日期(剩余可发布数)
                        </th>
                        <th width="231">
                            任务数(<span id="taskNum2">0</span>)
                        </th>
                        <th width="231">
                            开始时间
                        </th>
                        <th width="231">
                            结束时间
                        </th>
                        <th width="231">
                            超时取消
                        </th>
                    </tr>
                        <tr>
                            <td>
                                    <span style="margin-left: -60px;">（今天）</span>
                                10月20日
                                
                                <input type="hidden" name="TaskPlanBeginTime" value="2017/10/20">
                                <input type="hidden" name="TaskPlanEndTime" value="2017/10/20">
                                <input type="hidden" name="TimeoutTime" value="2017/10/20">
                            </td>
                            <td style="padding-top: 0px; padding-bottom: 0px;">
                                <div style="height: 24px; margin-top: 8px; margin-left: 60px;">
                                    <p class="left fprw-jg_41">
                                        <a id="timeimgReduce" class="a2">- </a></p>
                                        <p class="left" style="margin-top: 2px">
                                            <input type="text" name="TaskPlanCount" value="0" placeholder="0" onkeyup="value=value.replace(/[^0-9]/g,'')" class="input_40" disabled="disabled"></p>
                                    <p class="left fprw-jg_51">
                                        <a id="timeimgAdd" class="a2">+ </a></p>
                                </div>
                            </td>
                            <td>
                                <select name="TaskPlanBeginTimeH" class=""><option></option><option>00</option><option>01</option><option>02</option><option>03</option><option>04</option><option>05</option><option>06</option><option>07</option><option>08</option><option>09</option><option>10</option><option>11</option><option>12</option><option>13</option><option>14</option><option>15</option><option>16</option><option>17</option><option>18</option><option>19</option><option>20</option><option>21</option><option>22</option><option>23</option>
                                </select>
                                ：<select name="TaskPlanBeginTimeM" class=""><option></option>
                                    <option>00</option>
                                    <option>15</option>
                                    <option>30</option>
                                    <option>45</option>
                                </select>
                            </td>
                            <td>
                                <select name="TaskPlanEndTimeH" class=""><option></option><option>00</option><option>01</option><option>02</option><option>03</option><option>04</option><option>05</option><option>06</option><option>07</option><option>08</option><option>09</option><option>10</option><option>11</option><option>12</option><option>13</option><option>14</option><option>15</option><option>16</option><option>17</option><option>18</option><option>19</option><option>20</option><option>21</option><option>22</option><option>23</option>
                                </select>
                                ：
                                <select name="TaskPlanEndTimeTimeM" class="">
                                    <option></option>
                                    <option>00</option>
                                    <option>15</option>
                                    <option>30</option>
                                    <option>45</option>
                                </select>
                            </td>
                            <td>
                                
                                <input type="hidden" class="input-checkbox16" name="IsTimeoutTime">
                                
                                <select name="TimeoutTimeH" class=""><option></option><option>00</option><option>01</option><option>02</option><option>03</option><option>04</option><option>05</option><option>06</option><option>07</option><option>08</option><option>09</option><option>10</option><option>11</option><option>12</option><option>13</option><option>14</option><option>15</option><option>16</option><option>17</option><option>18</option><option>19</option><option>20</option><option>21</option><option>22</option><option>23</option>
                                </select>
                                ：
                                <select name="TimeoutTimeM" class="">
                                    <option></option>
                                    <option>00</option>
                                    <option>15</option>
                                    <option>30</option>
                                    <option>45</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                10月21日
                                
                                <input type="hidden" name="TaskPlanBeginTime" value="2017/10/21">
                                <input type="hidden" name="TaskPlanEndTime" value="2017/10/21">
                                <input type="hidden" name="TimeoutTime" value="2017/10/21">
                            </td>
                            <td style="padding-top: 0px; padding-bottom: 0px;">
                                <div style="height: 24px; margin-top: 8px; margin-left: 60px;">
                                    <p class="left fprw-jg_41">
                                        <a id="timeimgReduce" class="a2">- </a></p>
                                        <p class="left" style="margin-top: 2px">
                                            <input type="text" name="TaskPlanCount" value="0" placeholder="0" onkeyup="value=value.replace(/[^0-9]/g,'')" class="input_40" disabled="disabled"></p>
                                    <p class="left fprw-jg_51">
                                        <a id="timeimgAdd" class="a2">+ </a></p>
                                </div>
                            </td>
                            <td>
                                <select name="TaskPlanBeginTimeH" disabled="disabled" class="select1"><option></option><option>00</option><option>01</option><option>02</option><option>03</option><option>04</option><option>05</option><option>06</option><option>07</option><option>08</option><option>09</option><option>10</option><option>11</option><option>12</option><option>13</option><option>14</option><option>15</option><option>16</option><option>17</option><option>18</option><option>19</option><option>20</option><option>21</option><option>22</option><option>23</option>
                                </select>
                                ：<select name="TaskPlanBeginTimeM" disabled="disabled" class="select1"><option></option>
                                    <option>00</option>
                                    <option>15</option>
                                    <option>30</option>
                                    <option>45</option>
                                </select>
                            </td>
                            <td>
                                <select name="TaskPlanEndTimeH" disabled="disabled" class="select1"><option></option><option>00</option><option>01</option><option>02</option><option>03</option><option>04</option><option>05</option><option>06</option><option>07</option><option>08</option><option>09</option><option>10</option><option>11</option><option>12</option><option>13</option><option>14</option><option>15</option><option>16</option><option>17</option><option>18</option><option>19</option><option>20</option><option>21</option><option>22</option><option>23</option>
                                </select>
                                ：
                                <select name="TaskPlanEndTimeTimeM" disabled="disabled" class="select1">
                                    <option></option>
                                    <option>00</option>
                                    <option>15</option>
                                    <option>30</option>
                                    <option>45</option>
                                </select>
                            </td>
                            <td>
                                
                                <input type="hidden" class="input-checkbox16" name="IsTimeoutTime" disabled="disabled">
                                
                                <select name="TimeoutTimeH" disabled="disabled" class="select1"><option></option><option>00</option><option>01</option><option>02</option><option>03</option><option>04</option><option>05</option><option>06</option><option>07</option><option>08</option><option>09</option><option>10</option><option>11</option><option>12</option><option>13</option><option>14</option><option>15</option><option>16</option><option>17</option><option>18</option><option>19</option><option>20</option><option>21</option><option>22</option><option>23</option>
                                </select>
                                ：
                                <select name="TimeoutTimeM" disabled="disabled" class="select1">
                                    <option></option>
                                    <option>00</option>
                                    <option>15</option>
                                    <option>30</option>
                                    <option>45</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                10月22日
                                
                                <input type="hidden" name="TaskPlanBeginTime" value="2017/10/22">
                                <input type="hidden" name="TaskPlanEndTime" value="2017/10/22">
                                <input type="hidden" name="TimeoutTime" value="2017/10/22">
                            </td>
                            <td style="padding-top: 0px; padding-bottom: 0px;">
                                <div style="height: 24px; margin-top: 8px; margin-left: 60px;">
                                    <p class="left fprw-jg_41">
                                        <a id="timeimgReduce" class="a2">- </a></p>
                                        <p class="left" style="margin-top: 2px">
                                            <input type="text" name="TaskPlanCount" value="0" placeholder="0" onkeyup="value=value.replace(/[^0-9]/g,'')" class="input_40" disabled="disabled"></p>
                                    <p class="left fprw-jg_51">
                                        <a id="timeimgAdd" class="a2">+ </a></p>
                                </div>
                            </td>
                            <td>
                                <select name="TaskPlanBeginTimeH" disabled="disabled" class="select1"><option></option><option>00</option><option>01</option><option>02</option><option>03</option><option>04</option><option>05</option><option>06</option><option>07</option><option>08</option><option>09</option><option>10</option><option>11</option><option>12</option><option>13</option><option>14</option><option>15</option><option>16</option><option>17</option><option>18</option><option>19</option><option>20</option><option>21</option><option>22</option><option>23</option>
                                </select>
                                ：<select name="TaskPlanBeginTimeM" disabled="disabled" class="select1"><option></option>
                                    <option>00</option>
                                    <option>15</option>
                                    <option>30</option>
                                    <option>45</option>
                                </select>
                            </td>
                            <td>
                                <select name="TaskPlanEndTimeH" disabled="disabled" class="select1"><option></option><option>00</option><option>01</option><option>02</option><option>03</option><option>04</option><option>05</option><option>06</option><option>07</option><option>08</option><option>09</option><option>10</option><option>11</option><option>12</option><option>13</option><option>14</option><option>15</option><option>16</option><option>17</option><option>18</option><option>19</option><option>20</option><option>21</option><option>22</option><option>23</option>
                                </select>
                                ：
                                <select name="TaskPlanEndTimeTimeM" disabled="disabled" class="select1">
                                    <option></option>
                                    <option>00</option>
                                    <option>15</option>
                                    <option>30</option>
                                    <option>45</option>
                                </select>
                            </td>
                            <td>
                                
                                <input type="hidden" class="input-checkbox16" name="IsTimeoutTime" disabled="disabled">
                                
                                <select name="TimeoutTimeH" disabled="disabled" class="select1"><option></option><option>00</option><option>01</option><option>02</option><option>03</option><option>04</option><option>05</option><option>06</option><option>07</option><option>08</option><option>09</option><option>10</option><option>11</option><option>12</option><option>13</option><option>14</option><option>15</option><option>16</option><option>17</option><option>18</option><option>19</option><option>20</option><option>21</option><option>22</option><option>23</option>
                                </select>
                                ：
                                <select name="TimeoutTimeM" disabled="disabled" class="select1">
                                    <option></option>
                                    <option>00</option>
                                    <option>15</option>
                                    <option>30</option>
                                    <option>45</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                10月23日
                                
                                <input type="hidden" name="TaskPlanBeginTime" value="2017/10/23">
                                <input type="hidden" name="TaskPlanEndTime" value="2017/10/23">
                                <input type="hidden" name="TimeoutTime" value="2017/10/23">
                            </td>
                            <td style="padding-top: 0px; padding-bottom: 0px;">
                                <div style="height: 24px; margin-top: 8px; margin-left: 60px;">
                                    <p class="left fprw-jg_41">
                                        <a id="timeimgReduce" class="a2">- </a></p>
                                        <p class="left" style="margin-top: 2px">
                                            <input type="text" name="TaskPlanCount" value="0" placeholder="0" onkeyup="value=value.replace(/[^0-9]/g,'')" class="input_40" disabled="disabled"></p>
                                    <p class="left fprw-jg_51">
                                        <a id="timeimgAdd" class="a2">+ </a></p>
                                </div>
                            </td>
                            <td>
                                <select name="TaskPlanBeginTimeH" disabled="disabled" class="select1"><option></option><option>00</option><option>01</option><option>02</option><option>03</option><option>04</option><option>05</option><option>06</option><option>07</option><option>08</option><option>09</option><option>10</option><option>11</option><option>12</option><option>13</option><option>14</option><option>15</option><option>16</option><option>17</option><option>18</option><option>19</option><option>20</option><option>21</option><option>22</option><option>23</option>
                                </select>
                                ：<select name="TaskPlanBeginTimeM" disabled="disabled" class="select1"><option></option>
                                    <option>00</option>
                                    <option>15</option>
                                    <option>30</option>
                                    <option>45</option>
                                </select>
                            </td>
                            <td>
                                <select name="TaskPlanEndTimeH" disabled="disabled" class="select1"><option></option><option>00</option><option>01</option><option>02</option><option>03</option><option>04</option><option>05</option><option>06</option><option>07</option><option>08</option><option>09</option><option>10</option><option>11</option><option>12</option><option>13</option><option>14</option><option>15</option><option>16</option><option>17</option><option>18</option><option>19</option><option>20</option><option>21</option><option>22</option><option>23</option>
                                </select>
                                ：
                                <select name="TaskPlanEndTimeTimeM" disabled="disabled" class="select1">
                                    <option></option>
                                    <option>00</option>
                                    <option>15</option>
                                    <option>30</option>
                                    <option>45</option>
                                </select>
                            </td>
                            <td>
                                
                                <input type="hidden" class="input-checkbox16" name="IsTimeoutTime" disabled="disabled">
                                
                                <select name="TimeoutTimeH" disabled="disabled" class="select1"><option></option><option>00</option><option>01</option><option>02</option><option>03</option><option>04</option><option>05</option><option>06</option><option>07</option><option>08</option><option>09</option><option>10</option><option>11</option><option>12</option><option>13</option><option>14</option><option>15</option><option>16</option><option>17</option><option>18</option><option>19</option><option>20</option><option>21</option><option>22</option><option>23</option>
                                </select>
                                ：
                                <select name="TimeoutTimeM" disabled="disabled" class="select1">
                                    <option></option>
                                    <option>00</option>
                                    <option>15</option>
                                    <option>30</option>
                                    <option>45</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                10月24日
                                
                                <input type="hidden" name="TaskPlanBeginTime" value="2017/10/24">
                                <input type="hidden" name="TaskPlanEndTime" value="2017/10/24">
                                <input type="hidden" name="TimeoutTime" value="2017/10/24">
                            </td>
                            <td style="padding-top: 0px; padding-bottom: 0px;">
                                <div style="height: 24px; margin-top: 8px; margin-left: 60px;">
                                    <p class="left fprw-jg_41">
                                        <a id="timeimgReduce" class="a2">- </a></p>
                                        <p class="left" style="margin-top: 2px">
                                            <input type="text" name="TaskPlanCount" value="0" placeholder="0" onkeyup="value=value.replace(/[^0-9]/g,'')" class="input_40" disabled="disabled"></p>
                                    <p class="left fprw-jg_51">
                                        <a id="timeimgAdd" class="a2">+ </a></p>
                                </div>
                            </td>
                            <td>
                                <select name="TaskPlanBeginTimeH" disabled="disabled" class="select1"><option></option><option>00</option><option>01</option><option>02</option><option>03</option><option>04</option><option>05</option><option>06</option><option>07</option><option>08</option><option>09</option><option>10</option><option>11</option><option>12</option><option>13</option><option>14</option><option>15</option><option>16</option><option>17</option><option>18</option><option>19</option><option>20</option><option>21</option><option>22</option><option>23</option>
                                </select>
                                ：<select name="TaskPlanBeginTimeM" disabled="disabled" class="select1"><option></option>
                                    <option>00</option>
                                    <option>15</option>
                                    <option>30</option>
                                    <option>45</option>
                                </select>
                            </td>
                            <td>
                                <select name="TaskPlanEndTimeH" disabled="disabled" class="select1"><option></option><option>00</option><option>01</option><option>02</option><option>03</option><option>04</option><option>05</option><option>06</option><option>07</option><option>08</option><option>09</option><option>10</option><option>11</option><option>12</option><option>13</option><option>14</option><option>15</option><option>16</option><option>17</option><option>18</option><option>19</option><option>20</option><option>21</option><option>22</option><option>23</option>
                                </select>
                                ：
                                <select name="TaskPlanEndTimeTimeM" disabled="disabled" class="select1">
                                    <option></option>
                                    <option>00</option>
                                    <option>15</option>
                                    <option>30</option>
                                    <option>45</option>
                                </select>
                            </td>
                            <td>
                                
                                <input type="hidden" class="input-checkbox16" name="IsTimeoutTime" disabled="disabled">
                                
                                <select name="TimeoutTimeH" disabled="disabled" class="select1"><option></option><option>00</option><option>01</option><option>02</option><option>03</option><option>04</option><option>05</option><option>06</option><option>07</option><option>08</option><option>09</option><option>10</option><option>11</option><option>12</option><option>13</option><option>14</option><option>15</option><option>16</option><option>17</option><option>18</option><option>19</option><option>20</option><option>21</option><option>22</option><option>23</option>
                                </select>
                                ：
                                <select name="TimeoutTimeM" disabled="disabled" class="select1">
                                    <option></option>
                                    <option>00</option>
                                    <option>15</option>
                                    <option>30</option>
                                    <option>45</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                10月25日
                                
                                <input type="hidden" name="TaskPlanBeginTime" value="2017/10/25">
                                <input type="hidden" name="TaskPlanEndTime" value="2017/10/25">
                                <input type="hidden" name="TimeoutTime" value="2017/10/25">
                            </td>
                            <td style="padding-top: 0px; padding-bottom: 0px;">
                                <div style="height: 24px; margin-top: 8px; margin-left: 60px;">
                                    <p class="left fprw-jg_41">
                                        <a id="timeimgReduce" class="a2">- </a></p>
                                        <p class="left" style="margin-top: 2px">
                                            <input type="text" name="TaskPlanCount" value="0" placeholder="0" onkeyup="value=value.replace(/[^0-9]/g,'')" class="input_40" disabled="disabled"></p>
                                    <p class="left fprw-jg_51">
                                        <a id="timeimgAdd" class="a2">+ </a></p>
                                </div>
                            </td>
                            <td>
                                <select name="TaskPlanBeginTimeH" disabled="disabled" class="select1"><option></option><option>00</option><option>01</option><option>02</option><option>03</option><option>04</option><option>05</option><option>06</option><option>07</option><option>08</option><option>09</option><option>10</option><option>11</option><option>12</option><option>13</option><option>14</option><option>15</option><option>16</option><option>17</option><option>18</option><option>19</option><option>20</option><option>21</option><option>22</option><option>23</option>
                                </select>
                                ：<select name="TaskPlanBeginTimeM" disabled="disabled" class="select1"><option></option>
                                    <option>00</option>
                                    <option>15</option>
                                    <option>30</option>
                                    <option>45</option>
                                </select>
                            </td>
                            <td>
                                <select name="TaskPlanEndTimeH" disabled="disabled" class="select1"><option></option><option>00</option><option>01</option><option>02</option><option>03</option><option>04</option><option>05</option><option>06</option><option>07</option><option>08</option><option>09</option><option>10</option><option>11</option><option>12</option><option>13</option><option>14</option><option>15</option><option>16</option><option>17</option><option>18</option><option>19</option><option>20</option><option>21</option><option>22</option><option>23</option>
                                </select>
                                ：
                                <select name="TaskPlanEndTimeTimeM" disabled="disabled" class="select1">
                                    <option></option>
                                    <option>00</option>
                                    <option>15</option>
                                    <option>30</option>
                                    <option>45</option>
                                </select>
                            </td>
                            <td>
                                
                                <input type="hidden" class="input-checkbox16" name="IsTimeoutTime" disabled="disabled">
                                
                                <select name="TimeoutTimeH" disabled="disabled" class="select1"><option></option><option>00</option><option>01</option><option>02</option><option>03</option><option>04</option><option>05</option><option>06</option><option>07</option><option>08</option><option>09</option><option>10</option><option>11</option><option>12</option><option>13</option><option>14</option><option>15</option><option>16</option><option>17</option><option>18</option><option>19</option><option>20</option><option>21</option><option>22</option><option>23</option>
                                </select>
                                ：
                                <select name="TimeoutTimeM" disabled="disabled" class="select1">
                                    <option></option>
                                    <option>00</option>
                                    <option>15</option>
                                    <option>30</option>
                                    <option>45</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                10月26日
                                
                                <input type="hidden" name="TaskPlanBeginTime" value="2017/10/26">
                                <input type="hidden" name="TaskPlanEndTime" value="2017/10/26">
                                <input type="hidden" name="TimeoutTime" value="2017/10/26">
                            </td>
                            <td style="padding-top: 0px; padding-bottom: 0px;">
                                <div style="height: 24px; margin-top: 8px; margin-left: 60px;">
                                    <p class="left fprw-jg_41">
                                        <a id="timeimgReduce" class="a2">- </a></p>
                                        <p class="left" style="margin-top: 2px">
                                            <input type="text" name="TaskPlanCount" value="0" placeholder="0" onkeyup="value=value.replace(/[^0-9]/g,'')" class="input_40" disabled="disabled"></p>
                                    <p class="left fprw-jg_51">
                                        <a id="timeimgAdd" class="a2">+ </a></p>
                                </div>
                            </td>
                            <td>
                                <select name="TaskPlanBeginTimeH" disabled="disabled" class="select1"><option></option><option>00</option><option>01</option><option>02</option><option>03</option><option>04</option><option>05</option><option>06</option><option>07</option><option>08</option><option>09</option><option>10</option><option>11</option><option>12</option><option>13</option><option>14</option><option>15</option><option>16</option><option>17</option><option>18</option><option>19</option><option>20</option><option>21</option><option>22</option><option>23</option>
                                </select>
                                ：<select name="TaskPlanBeginTimeM" disabled="disabled" class="select1"><option></option>
                                    <option>00</option>
                                    <option>15</option>
                                    <option>30</option>
                                    <option>45</option>
                                </select>
                            </td>
                            <td>
                                <select name="TaskPlanEndTimeH" disabled="disabled" class="select1"><option></option><option>00</option><option>01</option><option>02</option><option>03</option><option>04</option><option>05</option><option>06</option><option>07</option><option>08</option><option>09</option><option>10</option><option>11</option><option>12</option><option>13</option><option>14</option><option>15</option><option>16</option><option>17</option><option>18</option><option>19</option><option>20</option><option>21</option><option>22</option><option>23</option>
                                </select>
                                ：
                                <select name="TaskPlanEndTimeTimeM" disabled="disabled" class="select1">
                                    <option></option>
                                    <option>00</option>
                                    <option>15</option>
                                    <option>30</option>
                                    <option>45</option>
                                </select>
                            </td>
                            <td>
                                
                                <input type="hidden" class="input-checkbox16" name="IsTimeoutTime" disabled="disabled">
                                
                                <select name="TimeoutTimeH" disabled="disabled" class="select1"><option></option><option>00</option><option>01</option><option>02</option><option>03</option><option>04</option><option>05</option><option>06</option><option>07</option><option>08</option><option>09</option><option>10</option><option>11</option><option>12</option><option>13</option><option>14</option><option>15</option><option>16</option><option>17</option><option>18</option><option>19</option><option>20</option><option>21</option><option>22</option><option>23</option>
                                </select>
                                ：
                                <select name="TimeoutTimeM" disabled="disabled" class="select1">
                                    <option></option>
                                    <option>00</option>
                                    <option>15</option>
                                    <option>30</option>
                                    <option>45</option>
                                </select>
                            </td>
                        </tr>
                </tbody></table>
                <div class="fprw-jg_6">
                    <ul>
                        <li style="margin-left: 950px">基础费用合计：<span id="spBasicMoney">0</span>元</li>
                    </ul>
                </div>
            </div>
            <!-- 表格-->
            <!-- 标题-->
            <div class="fprw-zpt">
                <div class="left fprw-jg">
                    <p class="fprw-jg_1">
                        增值服务<span style="color: Red">（即日起，增值服务需要收取附加费用，同时要求买手上传相应截图证明）</span></p>
                </div>
            </div>
            <!-- 标题-->
            <!-- 表格-->
            <div class="fprw-pg" style="margin-top: 0px;">
                <table id="optionContainer2">
                    <tbody><tr>
                        <th width="128">
                        </th>
                        <th width="128">
                            占比
                        </th>
                        <th width="128">
                            数量
                        </th>
                        <th width="128">
                            单价
                        </th>
                        <th width="128">
                            费用
                        </th>
                    </tr>
                    <tr>
                        <td>
                            收藏商品
                        </td>
                        <td>
                            <select name="Proportion" onchange="AddedServiceChange(this)"><option>0</option><option>10</option><option>20</option><option>30</option><option>40</option><option>50</option><option>60</option><option>70</option><option>80</option><option>90</option><option>100</option>
                            </select>%
                        </td>
                        <td style="padding-top: 0px; padding-bottom: 0px;">
                            0
                        </td>
                        <td>
                            0.10元/个
                        </td>
                        <td>
                            0
                        </td>
                    </tr>
                    <tr>
                        <td>
                            收藏店铺
                        </td>
                        <td>
                            <select name="Proportion" onchange="AddedServiceChange(this)"><option>0</option><option>10</option><option>20</option><option>30</option><option>40</option><option>50</option><option>60</option><option>70</option><option>80</option><option>90</option><option>100</option>
                            </select>%
                        </td>
                        <td style="padding-top: 0px; padding-bottom: 0px;">
                            0
                        </td>
                        <td>
                            0.10元/个
                        </td>
                        <td>
                            0
                        </td>
                    </tr>
                    <tr>
                        <td>
                            加入购物车
                        </td>
                        <td>
                            <select name="Proportion" onchange="AddedServiceChange(this)"><option>0</option><option>10</option><option>20</option><option>30</option><option>40</option><option>50</option><option>60</option><option>70</option><option>80</option><option>90</option><option>100</option>
                            </select>%
                        </td>
                        <td style="padding-top: 0px; padding-bottom: 0px;">
                            0
                        </td>
                        <td>
                            0.10元/个
                        </td>
                        <td>
                            0
                        </td>
                    </tr>
                    <tr>
                        <td>
                            问大家提问
                        </td>
                        <td>
                            
                        </td>
                        <td style="padding-top: 0px; padding-bottom: 0px;">
                            <select name="Proportion" id="selectQA" onchange="QuestionChange(this)"><option>0</option><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option>
                            </select>
                        </td>
                        <td>
                            0.30元/个
                        </td>
                        <td>
                            0
                        </td>
                    </tr>
                    <tr class="temp" id="trQus0" style="background: rgb(245, 245, 245); height: 10px; display: none;">
                        <td colspan="5">
                            <center style="color: Red">
                                问大家提问内容设置</center>
                        </td>
                    </tr>
                    <tr class="temp" id="trQus1" style="background: rgb(245, 245, 245); display: none;">
                        <td>
                            提问1：
                        </td>
                        <td colspan="4">
                            <input name="Questions" style="width: 95%; height: 30px; text-align: left" class="input_60" maxlength="40" placeholder="请输入问大家提问内容，4-40字" type="text">
                        </td>
                    </tr>
                    <tr class="temp" id="trQus2" style="background: rgb(245, 245, 245); display: none;">
                        <td>
                            提问2：
                        </td>
                        <td colspan="4">
                            <input name="Questions" style="width: 95%; height: 30px; text-align: left" class="input_60" maxlength="40" placeholder="请输入问大家提问内容，4-40字" type="text">
                        </td>
                    </tr>
                    <tr class="temp" id="trQus3" style="background: rgb(245, 245, 245); display: none;">
                        <td>
                            提问3：
                        </td>
                        <td colspan="4">
                            <input name="Questions" style="width: 95%; height: 30px; text-align: left" class="input_60" maxlength="40" placeholder="请输入问大家提问内容，4-40字" type="text">
                        </td>
                    </tr>
                    <tr class="temp" id="trQus4" style="background: rgb(245, 245, 245); display: none;">
                        <td>
                            提问4：
                        </td>
                        <td colspan="4">
                            <input name="Questions" style="width: 95%; height: 30px; text-align: left" class="input_60" maxlength="40" placeholder="请输入问大家提问内容，4-40字" type="text">
                        </td>
                    </tr>
                    <tr class="temp" id="trQus5" style="background: rgb(245, 245, 245); display: none;">
                        <td>
                            提问5：
                        </td>
                        <td colspan="4">
                            <input name="Questions" style="width: 95%; height: 30px; text-align: left" class="input_60" maxlength="40" placeholder="请输入问大家提问内容，4-40字" type="text">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            旺旺咨询
                        </td>
                        <td>
                            <select name="Proportion" onchange="AddedServiceChange(this)"><option>0</option><option>10</option><option>20</option><option>30</option><option>40</option><option>50</option><option>60</option><option>70</option><option>80</option><option>90</option><option>100</option>
                            </select>%
                        </td>
                        <td style="padding-top: 0px; padding-bottom: 0px;">
                            0
                        </td>
                        <td>
                            0.30元/个
                        </td>
                        <td>
                            0
                        </td>
                    </tr>
                    <tr>
                        <td>
                            领优惠劵
                        </td>
                        <td>
                            <select name="Proportion" onchange="AddedServiceChange(this)"><option>0</option><option>10</option><option>20</option><option>30</option><option>40</option><option>50</option><option>60</option><option>70</option><option>80</option><option>90</option><option>100</option>
                            </select>%
                        </td>
                        <td style="padding-top: 0px; padding-bottom: 0px;">
                            0
                        </td>
                        <td>
                            0.10元/个
                        </td>
                        <td>
                            0
                        </td>
                    </tr>
                </tbody></table>
                
                <div class="fprw-jg_6">
                    <ul>
                        <li style="margin-left: 850px">任务总数：<span id="spTotalTask">0</span>个 <span style="margin-left: 50px">
                            总费用：</span><span id="spTotalMoney">0</span>元 </li>
                    </ul>
                </div>
            </div>
            <!-- 表格-->
            
            <div class="fprw-kdlx_6" style="width: 400px; margin-top: 20px;">
                <p>
                    支付密码：<input id="pwd" style="width: 150px; text-align: left" name="TradersPassword" type="password" maxlength="25" class="input_60">
                    <input id="btnSubmitOk" onclick="CheckNext()" class="input-butto100-ls" type="button" value="确认发布"></p>
                <input type="hidden" id="submitCnt" value="0">
            </div>
        </div>
</form>

<script language="javascript" type="text/javascript">
$(function(){
 

if(screen.width<1440)
{  
     var height = document.body.clientHeight;  

         $("#onlineService").css("margin-top", "300px"); 
         $("#online_qq_tab").css("margin-top","300px"); 
    // 拖拉事件计算foot div高度  
    $(window).scroll(function () {  
        var scrollDiff = document.body.scrollTop //  拖拉处的位移  
        $("#onlineService").css("margin-top", "300px"); 
         $("#online_qq_tab").css("margin-top","300px"); // 重计算底部位置  
    });  
}
else if(screen.width == 1024){
         $("#onlineService").css("margin-top", "260px"); 
         $("#online_qq_tab").css("margin-top","260px");

            $(window).scroll(function () {  
        var scrollDiff = document.body.scrollTop //  拖拉处的位移  
        $("#onlineService").css("margin-top", "260px"); 
         $("#online_qq_tab").css("margin-top","260px"); // 重计算底部位置  
    });  
 }
 else
 {
  $("#onlineService").css("margin-top", "420px"); 
         $("#online_qq_tab").css("margin-top","420px"); 
    // 拖拉事件计算foot div高度  
    $(window).scroll(function () {  
        var scrollDiff = document.body.scrollTop //  拖拉处的位移  
        $("#onlineService").css("margin-top", "420px"); 
         $("#online_qq_tab").css("margin-top","420px"); // 重计算底部位置  
    });  
 }
          // 拖拉事件计算foot div高度  
 
});
    $(document).ready(function () {
        var loginName='霆宇包包';
        var memberType='商家';
        var member='商家';
        if(member==memberType){
            $("#consultLi").show();
//            $("#online_qq_tab").css("margin-top","420px");
        }
        else {
            $("#consultLi").hide();
        }
        $("#online_qq_layer").show();
        
        $("#floatShow").bind("click", function () {

            $("#onlineService").animate({ width: "show", opacity: "show" }, "normal", function () {
                $("#onlineService").show();
            });

            $("#floatShow").attr("style", "display:none");
            $("#floatHide").attr("style", "display:block");
            return false;
        });

        $("#floatHide").bind("click", function () {

            $("#onlineService").animate({ width: "hide", opacity: "hide" }, "normal", function () {
                $("#onlineService").hide();
            });
            $("#floatShow").attr("style", "display:block");
            $("#floatHide").attr("style", "display:none");
            return false;
        });
    });
    $(window)

</script>

   <?php require_once('include/footer.php')?>  


</body></html>