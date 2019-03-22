
    <?php require_once('include/header.php')?>
    <link href="<?=base_url()?>style/css.css" rel="stylesheet" type="text/css">
    <script src="<?=base_url()?>sstyle/iepngfix_tilebg.js" type="text/javascript"></script>
    <script src="<?=base_url()?>sstyle/jquery.jBox-2.3.min.js" type="text/javascript"></script>
    <link href="<?=base_url()?>sstyle/jbox.css" rel="stylesheet" type="text/css">

    
    <link href="<?=base_url()?>sstyle/cssOne.css" rel="stylesheet" type="text/css">
    <script src="<?=base_url()?>sstyle/jquery-1.11.2.min.js" type="text/javascript"></script>
    <script src="<?=base_url()?>sstyle/antiman.js" type="text/javascript"></script>
    <script src="<?=base_url()?>sstyle/md5.js" type="text/javascript"></script>
    <script type="text/javascript">
    document.onkeypress = function (e) {
var code;
if (!e) {
var e = window.event;
}
if (e.keyCode) {
code = e.keyCode;
}
else if (e.which) {
code = e.which;
}
if (code == 13) {
///这里是调用执行的方法
return false;
Next(1);
}
}

        var flag = 0; 
        $(document).ready(function () {
            $("#VipTask").addClass("a_on");
            $(window).load(function () {
                $("#pwd").val("");  
                $("#TempName").val("");
            });

            //初始化复购周期为任务总数
            $("input[name=PlatformNoLimit1M]").val($("#taskNum").val());
                //计算复购周期发布点
                $("#MxTable tr td input").each(function () {
                    var MxPointCount = 0;
                    $(this).parent().next().text(($(this).parent().prev().text() * $(this).val()).toFixed(2));
                    $("#MxTable tr td[class=fb3_hej]:not(:eq(0))").each(function () {
                        MxPointCount += parseFloat($(this).text());
                    });
                    $("#MxPointCount").text(MxPointCount);
                });

                 AgentSend();//默认选择代发空包 
              

            $("#sysTemplate").click(function () {
                flag = 1;
                $("input[name='Template']").attr("checked", false);
                $("#divtemplate").show();
                $("#divUsertemplate").hide();
                $('#fb_tjbg, #fb_tjbox').fadeIn(500);
                $("#fb_tjbox").height(250);

            });

            $("#btnSubmit").click(function () {
                var cnt = $("#submitCnt").val();
                if (cnt == "0") {
                    $(this).val("处理中...");
                    $("#submitCnt").val("1");
                }
                else return false;
            });

            $("#userTemplate").click(function () {
                flag = 0;
                if (parseInt('0') <= 0) {
                    alert("您没有可用的模板");
                    return false;
                }
                else {
                    $("input[name='Template']").attr("checked", false);
                    $("#divtemplate").hide();
                    $("#divUsertemplate").show();
                    $('#fb_tjbg, #fb_tjbox').fadeIn(500);
                    $("#fb_tjbox").height($("#divUsertemplate").height() + 165);
                }
            });

            //选择空包类型
            $("input[Name=rdData]").click(function () {
           
                $("#fhTable tr td[class=fb3_hej]:not(:eq(0))").text(0);
                var taskCount = $("#taskNum").val();
                var index = $(this).val();
          
                if (index == 1) {
                    $("input[name='ExpressAgentSend']").val(taskCount);
                    $("input[name='ExpressSelfSend']").val(0);
                    $("input[name='ExpressUsed']").val(0); 
                    $("input[name='ExpressAgentSend_YT']").val(0);
                    $("input[name='ExpressAgentSend_YD']").val(0);
                    $("input[name='ExpressAgentSend_QF']").val(0);
                }
                else if (index == 2) {
                    $("input[name='ExpressSelfSend']").val(taskCount);
                    $("input[name='ExpressUsed']").val(0);
                    $("input[name='ExpressAgentSend']").val(0);
                    $("input[name='ExpressAgentSend_YT']").val(0);
                    $("input[name='ExpressAgentSend_YD']").val(0);
                    $("input[name='ExpressAgentSend_QF']").val(0);
                }
                else if (index == 3) {
                 
                    $("input[name='ExpressUsed']").val(taskCount);
                    $("input[name='ExpressSelfSend']").val(0);
                    $("input[name='ExpressAgentSend']").val(0);
                    $("input[name='ExpressAgentSend_YT']").val(0);
                    $("input[name='ExpressAgentSend_YD']").val(0);
                    $("input[name='ExpressAgentSend_QF']").val(0);
           
                }
                else if (index == 4) {
                   $("input[name='ExpressAgentSend_YD']").val(taskCount);
                    $("input[name='ExpressAgentSend_YT']").val(0);
                    $("input[name='ExpressUsed']").val(0);
                    $("input[name='ExpressSelfSend']").val(0);
                    $("input[name='ExpressAgentSend']").val(0);
                    $("input[name='ExpressAgentSend_QF']").val(0);
                }
               else if (index == 5) {
                   $("input[name='ExpressAgentSend_YT']").val(taskCount);
                   $("input[name='ExpressAgentSend_YD']").val(0);
                    $("input[name='ExpressUsed']").val(0);
                    $("input[name='ExpressSelfSend']").val(0);
                    $("input[name='ExpressAgentSend']").val(0);
                    $("input[name='ExpressAgentSend_QF']").val(0);
                }
                else if (index == 6) {
                   $("input[name='ExpressAgentSend_QF']").val(taskCount);
                   $("input[name='ExpressAgentSend_YT']").val(0);
                   $("input[name='ExpressAgentSend_YD']").val(0);
                    $("input[name='ExpressUsed']").val(0);
                    $("input[name='ExpressSelfSend']").val(0);
                    $("input[name='ExpressAgentSend']").val(0);
                
                }
                var kbPointCount = 0;
                $(this).parent().next().text($(this).parent().prev().text() * taskCount);

                $("#kbPointCount").text($(this).parent().prev().text() * taskCount);
                $("#Fhmsg").html("");
            });

        
            //选择模板获得对于匹配
            $('#btnTempSave').click(function () {
              
                var id = $('input[name="Template"]:checked').val();
                var platformType = '淘宝';
                var taskCount = $("#taskNum").val();
                var hbNum=1+1;
                var djNum=1+1+1+0;
                var isSys = 0;

                if (typeof (id) == 'undefined') {
                    alert("请选择模板");
                    return false;
                }
                $.ajaxSetup({
                    async: false
                });
                $.post('/Shop/VipTask/GetTempPoint', { id: id, type: platformType, IsSys: flag }, function (result) {
                    var jsonData = eval('(' + result + ')');
                    var hbCount = 0;
                    var djCount = 0;
                    var contentCount = 0;
                    var addGoodCount = 0;
                    var tlCount = 0;
                    var fhCount = 0;
                    var LICount=0;
                    var MxCount=0;
                    $("input[name=ShopCollect]").val(Math.round(jsonData[platformType + "收藏店铺"] * taskCount));
                    $("input[name=ProductCollect]").val(Math.round(jsonData[platformType + "收藏商品"] * taskCount));


                    $("input[name=BrowseShopPNot]").val(Math.round(jsonData[platformType + "不浏览"] * taskCount));
                    $("input[name=BrowseShopP1]").val(Math.round(jsonData[platformType + "浏览店内一款其他商品"] * taskCount));
                    $("input[name=BrowseShopP2]").val(Math.round(jsonData[platformType + "浏览店内两款其他商品"] * taskCount));
                    $("input[name=BrowseShopP3]").val(Math.round(jsonData[platformType + "浏览店内三款其他商品"] * taskCount));

                    $("#LlTable tr td input").each(function () {
                       if(LICount==taskCount)
                      { $(this).val(0); }
                      else{
                        LICount += parseInt($(this).val());
                        }

                    });
                   if (LICount > taskCount)
                    { 
                        var num=LICount-taskCount;
                        $("#LlTable tr td input").each(function () {
                        if( $(this).val()>0)
                        { 
                            var value=$(this).val()-num;
                            if(value>=0)
                            {
                             $(this).val(value); 
                             return false;
                            }
                            else{
                               num=num-$(this).val();
                               $(this).val(0);           
                            }
                        }
                    });
//                    $("input[name=BrowseShopP3]").val(taskCount - (LICount - $("input[name=BrowseShopP3]").val()));            
                     }
                    else if (LICount < taskCount) { $("input[name=BrowseShopPNot]").val(taskCount - (LICount - $("input[name=BrowseShopPNot]").val())); }

                    
                    $("input[name=PlatformNoLimit1M]").val(Math.round(jsonData[platformType + "买限一个月"] * taskCount));
                    $("input[name=PlatformNoLimit3M]").val(Math.round(jsonData[platformType + "买限三个月"] * taskCount));
                    $("input[name=PlatformNoLimit6M]").val(Math.round(jsonData[platformType + "买限六个月"] * taskCount));
                    $("input[name=PlatformNoLimit1Y]").val(Math.round(jsonData[platformType + "买限一年"] * taskCount));
      
                    $("#MxTable tr td input").each(function () {
                      if(MxCount==taskCount)
                      { $(this).val(0); }
                      else
                      {
                        MxCount += parseInt($(this).val());
                      }
                    });
                    
                   if (MxCount > taskCount)
                    {  
                        var num=MxCount-taskCount;
                        $("#MxTable tr td input").each(function () {
                        if( $(this).val()>0)
                        { 
                            var value=$(this).val()-num;
                            if(value>=0)
                            {
                             $(this).val(value); 
                             return false;
                            }
                            else{
                               num=num-$(this).val();
                               $(this).val(0);           
                            }
                        }
                    });
//                     $("input[name=PlatformNoLimit1M]").val(taskCount - (MxCount - $("input[name=PlatformNoLimit1M]").val()));
                      }
                    else if (MxCount < taskCount) {
                
                    $("input[name=PlatformNoLimit1M]").val(taskCount - (MxCount - $("input[name=PlatformNoLimit1M]").val()));
                     }


                    $("input[name=ProductCompareNot]").val(Math.round(jsonData[platformType + "不货比"] * hbNum));
                    $("input[name=ProductCompare1]").val(Math.round(jsonData[platformType + "货比1家"] * hbNum));
                    $("input[name=ProductCompare2]").val(Math.round(jsonData[platformType + "货比2家"] * hbNum));
                    $("input[name=ProductCompare3]").val(Math.round(jsonData[platformType + "货比3家"] * hbNum));
                    $("input[name=ProductCompare4]").val(Math.round(jsonData[platformType + "货比4家"] * hbNum));
                    $("input[name=ProductCompare5]").val(Math.round(jsonData[platformType + "货比5家"] * hbNum));
                    $("#hbTable tr td input").each(function () {
                      if(hbCount==hbNum)
                      { 
                      $(this).val(0); }
                      else{
                        hbCount += parseInt($(this).val());}
                    });
               
                    if (hbCount > hbNum)
                    { 
                        var num=hbCount-hbNum;
                        $("#hbTable tr td input").each(function () {
                        if( $(this).val()>0)
                        { 
                            var value=$(this).val()-num;
                            if(value>=0)
                            {
                             $(this).val(value); 
                             return false;
                            }
                            else{
                                num=num-$(this).val();
                               $(this).val(0);           
                            }
                        }
                    });
//                    $("input[name=ProductCompareNot]").val(hbCount - (hbNum - $("input[name=ProductCompareNot]").val()));
                    }
                    else if (hbCount < hbNum) {
                        $("input[name=ProductCompare5]").val(hbNum - (hbCount - $("input[name=ProductCompare5]").val()));
                    }

                    $("input[name=BeforeBuyTalk]").val(Math.round(jsonData[platformType + "拍前聊"] * taskCount));

//                    $("input[name=PlatformNoAcceptPeriod]").val(Math.round(jsonData[platformType + "买限一个月"] * taskCount));

                    $("input[name=PlatformNoIdent]").val(Math.round(jsonData[platformType + "实名认证"] * taskCount));

                    $("input[name=PlatformNoSexNot]").val(Math.round(jsonData[platformType + "性别不限"] * taskCount));
                    $("input[name=PlatformNoSexMale]").val(Math.round(jsonData[platformType + "男"] * taskCount));
                    $("input[name=PlatformNoSexFemale]").val(Math.round(jsonData[platformType + "女"] * taskCount));
                    var sexNum = parseInt($("input[name=PlatformNoSexNot]").val()) + parseInt($("input[name=PlatformNoSexMale]").val()) + parseInt($("input[name=PlatformNoSexFemale]").val());
           
                  
                    if (sexNum > taskCount)
                    { 
                     $("input[name=PlatformNoSexNot]").val(taskCount - (sexNum-$("input[name=PlatformNoSexNot]").val())); }
                    else if (sexNum < taskCount) {  $("input[name=PlatformNoSexNot]").val(taskCount - (sexNum-$("input[name=PlatformNoSexNot]").val())); }
                    //年龄段
                    if (jsonData[platformType + "年龄结束"] != 'undefined' && jsonData[platformType + "年龄结束"] != null) {
                        $("input[name=PlatformNoAgeBegin]").val(jsonData[platformType + "年龄开始"]);
                        $("input[name=PlatformNoAgeEnd]").val(jsonData[platformType + "年龄结束"]);
                    }

                    $("input[name=PlatformNoLevelNot]").val(Math.round(jsonData[platformType + "不限等级"] * djNum));
                    $("input[name=PlatformNoLevel1]").val(Math.round(jsonData[platformType + "满1月1心"] * djNum));
                    $("input[name=PlatformNoLevel3]").val(Math.round(jsonData[platformType + "满3月2心"] * djNum));
                    $("input[name=PlatformNoLevel6]").val(Math.round(jsonData[platformType + "满6月3心"] * djNum));
                    $("input[name=PlatformNoLevel12]").val(Math.round(jsonData[platformType + "满12月4心"] * djNum));
                    $("input[name=PlatformNoLevel24]").val(Math.round(jsonData[platformType + "满24月5心"] * djNum));
                    $("input[name=PlatformNoLevel36]").val(Math.round(jsonData[platformType + "满36月1黄钻"] * djNum));
                    $("#djTable tr td input").each(function () {

                       if(djCount==djNum)
                      { $(this).val(0); }
                      else{
                        djCount += parseInt($(this).val())
                        };
                    });

                    if (djCount > djNum)
                    {   
                        var num=djCount-djNum;
                        $("#djTable tr td input").each(function () {
                        if( $(this).val()>0)
                        { 
                            var value=$(this).val()-num;
                            if(value>=0)
                            {
                             $(this).val(value); 
                             return false;
                            }
                            else{
                               num=num-$(this).val();
                               $(this).val(0);                 
                            }
                        }
                    });
//                    $("input[name=PlatformNoLevelNot]").val(djNum - (djCount - $("input[name=PlatformNoLevelNot]").val()));
                    
                    }
                    else if (djCount < djNum) {
                        $("input[name=PlatformNoLevelNot]").val(djNum - (djCount - $("input[name=PlatformNoLevelNot]").val()));
                    }

                    $("input[name=HighOpinionNot]").val(Math.round(jsonData[platformType + "不评"] * taskCount));
                    $("input[name=HighOpinionWord]").val(Math.round(jsonData[platformType + "文字好评"] * taskCount));
                    $("input[name=HighOpinionImg]").val(Math.round(jsonData[platformType + "晒图好评"] * taskCount));
                    $("#contentTable tr td input").each(function () {
                      if(contentCount==taskCount)
                      { $(this).val(0); }
                      else{
                        contentCount += parseInt($(this).val());
                        }
                    });
                 
                    if (contentCount > taskCount)
                    { 
                       var num=contentCount-taskCount;
                        $("#contentTable tr td input").each(function () {
                        if( $(this).val()>0)
                        { 
                            var value=$(this).val()-num;
                            if(value>=0)
                            {
                             $(this).val(value); 
                             return false;
                            }
                            else{
                               num=num-$(this).val();
                               $(this).val(0);           
                            }
                        }
                    });
//                      $("input[name=HighOpinionNot]").val(taskCount - (parseInt($("input[name=HighOpinionImg]").val()) + parseInt($("input[name=HighOpinionWord]").val())));
                      }
                    else if (contentCount < taskCount) {
                        $("input[name=HighOpinionImg]").val(taskCount - (parseInt($("input[name=HighOpinionNot]").val()) + parseInt($("input[name=HighOpinionWord]").val())));
                    }
                    $("input[name=AddToHighOpinionNot]").val(Math.round(jsonData[platformType + "不追评"] * taskCount));
                    $("input[name=AddToHighOpinionWord]").val(Math.round(jsonData[platformType + "文字追评"] * taskCount));
                    $("input[name=AddToHighOpinionImg]").val(Math.round(jsonData[platformType + "晒图追评"] * taskCount));
                    $("#AddGoodTable tr td input").each(function () {
                     if(addGoodCount==taskCount)
                      { $(this).val(0); }
                      else{
                        addGoodCount += parseInt($(this).val());}
                    });
                    if (addGoodCount > taskCount)
                    { 
                     var num=addGoodCount-taskCount;
                        $("#AddGoodTable tr td input").each(function () {
                        if( $(this).val()>0)
                        { 
                            var value=$(this).val()-num;
                            if(value>=0)
                            {
                             $(this).val(value); 
                             return false;
                            }
                            else{
                               num=num-$(this).val();
                               $(this).val(0);           
                            }
                        }
                    });
//                       $("input[name=AddToHighOpinionNot]").val(taskCount - (parseInt($("input[name=AddToHighOpinionImg]").val()) + parseInt($("input[name=AddToHighOpinionWord]").val())));
                     }
                    else if (addGoodCount < taskCount) {
                          
                        $("input[name=AddToHighOpinionImg]").val(taskCount - (parseInt($("input[name=AddToHighOpinionNot]").val()) + parseInt($("input[name=AddToHighOpinionWord]").val())));
                    }

                    $("#AddToHighOpinion").val(jsonData[platformType + "追评方向"]);
                    $("#HighOpinion").val(jsonData[platformType + "好评方向"]);



                    $("input[name=InsideShopStayNot]").val(Math.round(jsonData[platformType + "停不要求"] * taskCount));
                    $("input[name=InsideShopStay5]").val(Math.round(jsonData[platformType + "停5分钟"] * taskCount));
                    $("input[name=InsideShopStay10]").val(Math.round(jsonData[platformType + "停10分钟"] * taskCount));
                    $("input[name=InsideShopStay15]").val(Math.round(jsonData[platformType + "停15分钟"] * taskCount));
                    $("input[name=InsideShopStay20]").val(Math.round(jsonData[platformType + "停20分钟"] * taskCount));
                    $("#tlTable tr td input").each(function () {
                       if(tlCount==taskCount)
                       { 
                       $(this).val(0);
                        }
                        else{
                        tlCount += parseInt($(this).val());
                        }
                    });
 
                    if (tlCount > taskCount)
                    {   
                        var num=tlCount-taskCount;
  
                        $("#tlTable tr td input").each(function () {
                        if( $(this).val()>0)
                        { 
                            var value=$(this).val()-num;      
                            if(value>=0)
                            {
                             $(this).val(value); 
                             return false;
                            }
                          else{
                              num=num-$(this).val();
                               $(this).val(0);           
                            }
                        }});
//                      $("input[name=InsideShopStayNot]").val(taskCount - (tlCount- $("input[name=InsideShopStayNot]").val()));
                    }
                    else if (tlCount < taskCount) {
                        $("input[name=InsideShopStayNot]").val(taskCount - (tlCount- $("input[name=InsideShopStayNot]").val()));
                    }
                    var yundan = jsonData[platformType + "运单号类型"];
                    
                    if (yundan == "自发空包"&&'False'=="True") {
                        $("#rdSelfSend").attr("checked", true);
                        $("input[name=ExpressSelfSend]").val(taskCount);
                        $("input[name=ExpressAgentSend]").val(0);
                        $("input[name=ExpressUsed]").val(0);
                         $("input[name=ExpressAgentSend_YT]").val(0);
                        $("input[name=ExpressAgentSend_YD]").val(0);
                        $("input[name=ExpressAgentSend_QF]").val(0);
                    }
                    else if (yundan == "代发空包") {
//                        $("#rdExpressAgentSend").attr("checked", true);
//                        $("input[name=ExpressAgentSend]").val(taskCount);
//                        $("input[name=ExpressUsed]").val(0);
//                        $("input[name=ExpressSelfSend]").val(0);
//                        $("input[name=ExpressAgentSend_YT]").val(0);
//                        $("input[name=ExpressAgentSend_YD]").val(0);
                        $("#rdExpressAgentSend_YD").attr("checked", true);
                        $("input[name=ExpressAgentSend_YD]").val(taskCount);
                        $("input[name=ExpressAgentSend_YT]").val(0);
                        $("input[name=ExpressUsed]").val(0);
                        $("input[name=ExpressAgentSend]").val(0);
                        $("input[name=ExpressSelfSend]").val(0);
                        $("input[name=ExpressAgentSend_QF]").val(0);
                    }
                    else if (yundan == "真实单号") {
                        $("#rdExpressUsed").attr("checked", true);
                        $("input[name=ExpressUsed]").val(taskCount);
                        $("input[name=ExpressAgentSend]").val(0);
                        $("input[name=ExpressSelfSend]").val(0);
                        $("input[name=ExpressAgentSend_YT]").val(0);
                        $("input[name=ExpressAgentSend_YD]").val(0);
                        $("input[name=ExpressAgentSend_QF]").val(0);
                   
                    }
                   else if (yundan == "韵达空包") {
                      $("#rdExpressAgentSend_YD").attr("checked", true);
                        $("input[name=ExpressAgentSend_YD]").val(taskCount);
                        $("input[name=ExpressAgentSend_YT]").val(0);
                        $("input[name=ExpressAgentSend_QF]").val(0);
                        $("input[name=ExpressUsed]").val(0);
                        $("input[name=ExpressAgentSend]").val(0);
                        $("input[name=ExpressSelfSend]").val(0);

                    }
                    else if (yundan == "圆通空包") {
                       $("#rdExpressAgentSend_YT").attr("checked", true);
                        $("input[name=ExpressAgentSend_YT]").val(taskCount);
                        $("input[name=ExpressAgentSend_YD]").val(0);
                        $("input[name=ExpressUsed]").val(0);
                        $("input[name=ExpressAgentSend]").val(0);
                        $("input[name=ExpressSelfSend]").val(0);
                        $("input[name=ExpressAgentSend_QF]").val(0);
             
                    }
                    else if (yundan == "全峰空包") {
                        $("#rdExpressAgentSend_QF").attr("checked", true);
                        $("rdExpressAgentSend_QF").val(taskCount);
                        $("input[name=ExpressAgentSend_YT]").val(0);
                        $("input[name=ExpressAgentSend_YD]").val(0);
                        $("input[name=ExpressUsed]").val(0);
                        $("input[name=ExpressAgentSend]").val(0);
                        $("input[name=ExpressSelfSend]").val(0);
             
                    }
                    //                    $("input[name=ExpressSelfSend]").val(Math.round(jsonData[platformType + "自发空包"] * taskCount));
                    //                    $("input[name=ExpressAgentSend]").val(Math.round(jsonData[platformType + "代发空包"] * taskCount));
                    //                    $("input[name=ExpressUsed]").val(Math.round(jsonData[platformType + "真实运单号"] * taskCount));

                    //                    $("#fhTable tr td input").each(function () {
                    //                        fhCount += parseInt($(this).val());
                    //                    });
                    //                    if (fhCount > taskCount)
                    //                    { $("input[name=ExpressAgentSend]").val(fhCount - taskCount); }
                    //                    else if (fhCount < taskCount) {
                    //                        $("input[name=ExpressAgentSend]").val(taskCount - fhCount);
                    //                    }

                    $("#Remark").val(jsonData[platformType + "任务备注"]);
                    if (flag == 0) {
                        $("input[name=AddToPoint]").val(jsonData[platformType + "追加发布点"]);
                    } else {
                        $("input[name=AddToPoint]").val("0");
                    }

                    //获得模板配比后进行计算
                    //计算收藏发布点
                    var Shoppoint = $("input[Name=ShopCollect]").val() * $("#shopPoint").text();
                    var Pupductpoint = $("input[Name=ProductCollect]").val() * $("#productPoint").text();
                    var oneTotalPoint = Shoppoint + Pupductpoint;
                    $("#oneTotalPoint").text(parseFloat(oneTotalPoint).toFixed(2));

                    //计算旺聊发布点
                    var buyTalkPoint = $("input[Name=BeforeBuyTalk]").val() * $("#buyTalkPoint").text();
                    $("#threeTatalPoint").text(parseFloat(buyTalkPoint).toFixed(2));

                    
             
                    //计算浏览深度发布点
                    $("#LlTable tr td input").each(function () {
                        var LlPointCount = 0;
                        $(this).parent().next().text(parseFloat($(this).parent().prev().text() * $(this).val()).toFixed(2));
                        $("#LlTable tr td[class=fb3_hej]:not(:eq(0))").each(function () {
                            LlPointCount += parseFloat($(this).text());
                        });
                        $("#LIPointCount").text(parseFloat(LlPointCount).toFixed(2));
                    }); 


                      //计算复购周期发布点
                    $("#MxTable tr td input").each(function () {
                        var MxPointCount = 0;

                        $(this).parent().next().text(parseFloat($(this).parent().prev().text() * $(this).val()).toFixed(2));
                        $("#MxTable tr td[class=fb3_hej]:not(:eq(0))").each(function () {
                            MxPointCount += parseFloat($(this).text());
                        });
        
                        $("#MxPointCount").text(parseFloat(MxPointCount).toFixed(2));
                    });

                    //计算货比三家发布点
                    $("#hbTable tr td input").each(function () {
                        var hbPointCount = 0;
                        $(this).parent().next().text(parseFloat(parseFloat($(this).parent().prev().text()) * $(this).val()).toFixed(2));
                        $("#hbTable tr td[class=fb3_hej]:not(:eq(0))").each(function () {
                            hbPointCount += parseFloat($(this).text());
                        });
                        $("#hbPointCount").text(hbPointCount.toFixed(2));
                    });



                    //计算买号要求发布点
                    $("#djTable  tr td input,input[name=PlatformNoIdent],input[name=PlatformNoSexNot],input[name=PlatformNoSexMale],input[name=PlatformNoSexFemale]").each(function (i) {
                        var buyPointCount = 0;
                        var PlatformNoSexNot = 0;
                        var PlatformNoSexMale = 0;
                        var PlatformNoSexFemale = 0;
//                        var PlatformNoAcceptPeriod = 0;
                        var PlatformNoIdent = 0;
                        PlatformNoSexNot = $("input[name=PlatformNoSexNot]").val() * parseFloat($("#sexNotPoint").text());
                        PlatformNoSexMale += $("input[name=PlatformNoSexMale]").val() * parseFloat($("#sexMalePoint").text());
                        PlatformNoSexFemale += $("input[name=PlatformNoSexFemale]").val() * parseFloat($("#sexFamalePoint").text());
//                        PlatformNoAcceptPeriod += $("input[name=PlatformNoAcceptPeriod]").val() * parseFloat($("#PlatformNoAcceptPeriodPoint").text());

                        //实名认证 获取模板函数
                        if (platformType == "淘宝") {
                            PlatformNoIdent += $("input[name=PlatformNoIdent]").val() * parseFloat($("#PlatformNoIdentPoint").text());
                        }

                        //计算买号等级限制
                        if ($(this).attr("name") != "PlatformNoIdent"
                      
                        && $(this).attr("name") != "PlatformNoSexNot"
                        && $(this).attr("name") != "PlatformNoSexMale"
                        && $(this).attr("name") != "PlatformNoSexFemale") {
                            $(this).parent().next().text(parseFloat($(this).parent().prev().text() * $(this).val()).toFixed(2));
                        }
                        $("#djTable tr td[class=fb3_hej]:not(:eq(0))").each(function () {
                            buyPointCount += parseFloat($(this).text());
                        });
                        var age = $("#taskNum").val() * parseFloat($("#age").text()); //山竹2015－5－3 
                        if (parseInt($("input[name=PlatformNoAgeEnd]").val()) == 0
            && parseInt($("input[name=PlatformNoAgeBegin]").val()) == 0) {
                            age = 0
                        }
                        var totalPoint = buyPointCount + PlatformNoSexNot + PlatformNoSexMale + PlatformNoSexFemale + PlatformNoIdent + age;
                        $("#buyPointCount").text(totalPoint.toFixed(2));
                    });

                    //计算好评发布点
                    $("#contentTable  tr td input,#AddGoodTable tr td input").each(function () {
                        var hpPointCount = 0;
                        $(this).parent().next().text(parseFloat($(this).parent().prev().text() * $(this).val()).toFixed(2));
                        $("#contentTable tr td[class=fb3_hej]:not(:eq(0)),#AddGoodTable tr td[class=fb3_hej]").each(function () {
                            hpPointCount += parseFloat($(this).text());
                        });
                        $("#hpPointCount").text(hpPointCount.toFixed(2));
                    });


                    //计算停留时间发布点
                    $("#tlTable tr td input").each(function () {
                        var tlPointCount = 0;

                        $(this).parent().next().text(parseFloat($(this).parent().prev().text() * $(this).val()).toFixed(2));
                        $("#tlTable tr td[class=fb3_hej]:not(:eq(0))").each(function () {
                            tlPointCount += parseFloat($(this).text());
                        });
                        $("#tlPointCount").text(tlPointCount.toFixed(2));
                    });


                    //计算空包发布点
                    $("#fhTable tr td input[type='hidden']").each(function () {
                        var kbPointCount = 0;
                        $(this).parent().next().text(parseFloat($(this).parent().prev().text() * $(this).val()).toFixed(2));
                        $("#fhTable tr td[class=fb3_hej]:not(:eq(0))").each(function () {
                            kbPointCount += parseFloat($(this).text());
                        });
                        $("#kbPointCount").text(kbPointCount.toFixed(2));
                        $("#Fhmsg").html("");
                    });

                 var hbCount = 0;
                 var djCount = 0;
                 var contentCount = 0;
                 var addGoodCount = 0;
                 var tlCount = 0;
                 var fhCount = 0;
                 var LICount = 0;
                 var MxCount = 0;
                 var hbTotal=0;
                 var djTotal=0;
                 hbTotal=1+1;
                 djTotal=1+1+1+0;
                 var sexNum = parseInt($("input[name=PlatformNoSexNot]").val()) + parseInt($("input[name=PlatformNoSexMale]").val()) + parseInt($("input[name=PlatformNoSexFemale]").val());
                
                $("#hbTable tr td input").each(function () {
                    if ($(this).val() == "")
                    { $(this).val(0); }
                    hbCount += parseInt($(this).val());
                });

                $("#djTable tr td input").each(function () {
                    if ($(this).val() == "")
                    { $(this).val(0); }
                    djCount += parseInt($(this).val());
                });
                $("#contentTable tr td input").each(function () {
                    if ($(this).val() == "")
                    { $(this).val(0); }
                    contentCount += parseInt($(this).val());
                });
                $("#AddGoodTable tr td input").each(function () {
                    if ($(this).val() == "")
                    { $(this).val(0); }
                    addGoodCount += parseInt($(this).val());
                });
                $("#tlTable tr td input").each(function () {
                    if ($(this).val() == "")
                    { $(this).val(0); }
                    tlCount += parseInt($(this).val());
                });


               $("#LlTable tr td input").each(function () {
                    if ($(this).val() == "")
                    { $(this).val(0); }
                    LICount += parseInt($(this).val());
                });

                $("#MxTable tr td input").each(function () {
                    if ($(this).val() == "")
                    { $(this).val(0); }
                    MxCount += parseInt($(this).val());
                });
              
                //获取模板,计算剩余个数
                $("#lbShopCollectRe").text($("#taskNum").val()-$("input[Name=ShopCollect]").val());//计算店铺收藏剩余个数
                $("#lbProductCollectRe").text($("#taskNum").val()-$("input[Name=ProductCollect]").val());//计算商品收藏剩余个数
                $("#lbBeforeBuyTalkRe").text($("#taskNum").val()-$("input[Name=BeforeBuyTalk]").val());//计算旺聊剩余个数
                $("#lbProductCompareRe").text(hbTotal-hbCount);//计算货比剩余个数
//                $("#lbPlatformNoAcceptPeriodRe").text($("#taskNum").val()-$("input[Name=PlatformNoAcceptPeriod]").val());//计算接手周期剩余个数
                $("#lbPlatformNoIdentRe").text($("#taskNum").val()-$("input[Name=PlatformNoIdent]").val());//计算实名认证剩余个数
                $("#lbPlatformNoSexRe").text($("#taskNum").val()-sexNum);//计算性别剩余个数
                $("#lbPlatformNoLevelRe").text(djTotal-djCount);//计算买号等级剩余个数
                $("#lbHighOpinionRe").text($("#taskNum").val()-contentCount);//计算好评剩余个数
                $("#lbAddToHighOpinionRe").text($("#taskNum").val()-addGoodCount);//计算追平剩余个数
                $("#lbInsideShopStayRe").text($("#taskNum").val()-tlCount);//计算停留时间剩余个数
                $("#lbBrowse").text($("#taskNum").val()-LICount);//计算浏览深度剩余个数
                $("#lbPlatformNoLimit").text($("#taskNum").val()-MxCount);//计算复购周期剩余个数

                $("#lbShopCollectRes").text($("#lbShopCollectRe").text());
                $("#lbProductCollectRes").text($("#lbProductCollectRe").text());
                $("#lbBrowses").text($("#lbBrowse").text());
                $("#lbProductCompareRes").text( $("#lbProductCompareRe").text());
                $("#lbBeforeBuyTalkRes").text( $("#lbBeforeBuyTalkRe").text());
                $("#lbPlatformNoLimits").text($("#lbPlatformNoLimit").text());
                $("#lbPlatformNoSexRes").text($("#lbPlatformNoSexRe").text());
                $("#lbPlatformNoLevelRes").text($("#lbPlatformNoLevelRe").text());
                $("#lbHighOpinionRes").text($("#lbHighOpinionRe").text());
                $("#lbAddToHighOpinionRes").text($("#lbAddToHighOpinionRe").text());
                $("#lbInsideShopStayRes").text($("#lbInsideShopStayRe").text());
                });
                $('#fb_tjbg, #fb_tjbox').fadeOut(500);  
            })
        });
        

        $("input[type='text']").live("focus", function () {
            if ($(this).val() < 1) {
                if ($(this).attr("name") != "PointTempName") {
                    $(this).val(" ");
                }
            }
        });
        $("input[type='text']").live("blur", function () {
            if ($(this).val() < 1) {
                if ($(this).attr("name") != "PointTempName") {
                    $(this).val(0);
                }
            }
        });
        //没有选择模板下的计算
        //计算收藏发布点
        $("input[Name=ShopCollect],input[Name=ProductCollect]").live("keyup", function () {
            var Shoppoint = $("input[Name=ShopCollect]").val() * $("#shopPoint").text();
            var Pupductpoint = $("input[Name=ProductCollect]").val() * $("#productPoint").text();
            var oneTotalPoint = Shoppoint + Pupductpoint;
         
            $("#oneTotalPoint").text(parseFloat(oneTotalPoint).toFixed(2));
//            if ($("input[Name=ShopCollect]").val() > $("#taskNum").val())
//            { $("#SCmsg").html("<b style=\"color: Red\">温馨提示:</b> 店铺收藏个数不能大于任务总数"); }   
//            else if ($("input[Name=ProductCollect]").val() > $("#taskNum").val())
//            { $("#SCmsg").html("<b style=\"color: Red\">温馨提示:</b> 产品收藏个数不能大于任务总数"); }
//            else
//            { $("#SCmsg").html(""); }

               $("#lbShopCollectRe").text($("#taskNum").val()-$("input[Name=ShopCollect]").val());//计算店铺收藏剩余个数
               $("#lbProductCollectRe").text($("#taskNum").val()-$("input[Name=ProductCollect]").val());//计算商品收藏剩余个数
               $("#lbShopCollectRes").text( $("#lbShopCollectRe").text());
               $("#lbProductCollectRes").text( $("#lbProductCollectRe").text());
      
            
        });

        //计算旺聊发布点
        $("input[Name=BeforeBuyTalk]").live("keyup", function () {
            var buyTalkPoint = $("input[Name=BeforeBuyTalk]").val() * $("#buyTalkPoint").text();
            $("#threeTatalPoint").text(parseFloat(buyTalkPoint).toFixed(2));
//            if ($("input[Name=BeforeBuyTalk]").val()> $("#taskNum").val())
//            { $("#Wlmsg").html("<b style=\"color: Red\">温馨提示:</b> 旺聊个数不能大于任务总数"); }
//            else
//            { $("#Wlmsg").html(""); }

                $("#lbBeforeBuyTalkRe").text($("#taskNum").val()-$("input[Name=BeforeBuyTalk]").val());//计算剩余个数
                 $("#lbBeforeBuyTalkRes").text( $("#lbBeforeBuyTalkRe").text());
        });

        

                //计算深度浏览发布点
        $("#LlTable tr td input").live("keyup", function () {
            var LIPointCount = 0;
            var LICount = 0;
            $(this).parent().next().text(($(this).parent().prev().text() * $(this).val()).toFixed(2));
            $("#LlTable tr td[class=fb3_hej]:not(:eq(0))").each(function () {
                LIPointCount += parseFloat($(this).text());
            });
            $("#LIPointCount").text(LIPointCount.toFixed(2));
            $("#LlTable tr td input").each(function () {
                var value = 0;
                if ($(this).val() != "" && $(this).val() != " " && $(this).val() != null)
                { value = $(this).val(); }
                LICount += parseInt(value);
            });
          $("#lbBrowse").text($("#taskNum").val()-LICount);
          $("#lbBrowses").text($("#lbBrowse").text());
        });


              //计算复购周期发布点
        $("#MxTable tr td input").live("keyup", function () {
            var MxPointCount = 0;
            var MxCount = 0;
            $(this).parent().next().text(($(this).parent().prev().text() * $(this).val()).toFixed(2));
            $("#MxTable tr td[class=fb3_hej]:not(:eq(0))").each(function () {
                MxPointCount += parseFloat($(this).text());
            });
            $("#MxPointCount").text(MxPointCount.toFixed(2));
            $("#MxTable tr td input").each(function () {
                var value = 0;
                if ($(this).val() != "" && $(this).val() != " " && $(this).val() != null)
                { value = $(this).val(); }
                MxCount += parseInt(value);
            });
             $("#lbPlatformNoLimit").text($("#taskNum").val()-MxCount);
                  $("#lbPlatformNoLimits").text($("#lbPlatformNoLimit").text());
        });

        //计算货比三家发布点
        $("#hbTable tr td input").live("keyup", function () {
            var hbPointCount = 0;
            var hbCount = 0;
            var hbTotal=0;
             hbTotal=1+1;
            $(this).parent().next().text(parseFloat(parseFloat($(this).parent().prev().text()) * $(this).val()).toFixed(2));
            $("#hbTable tr td[class=fb3_hej]:not(:eq(0))").each(function () {
                hbPointCount += parseFloat($(this).text());
            });
            $("#hbPointCount").text(hbPointCount.toFixed(2));

            $("#hbTable tr td input").each(function () {
                var value = 0;
                if ($(this).val() != "" && $(this).val() != " " && $(this).val() !=null)
                { value=$(this).val(); }
                hbCount += parseInt(value);
            });
//            if (hbCount !=hbTotal)
//            { $("#Hbmsg").html("<b style=\"color: Red\">温馨提示:</b> 货比数量总和必须等于任务总数"); }
//            else
//            { $("#Hbmsg").html(""); }

             $("#lbProductCompareRe").text(hbTotal-hbCount);//计算剩余个数
             $("#lbProductCompareRes").text( $("#lbProductCompareRe").text());

        });

        
        //计算买号要求发布点
        $("#djTable  tr td input,input[name=PlatformNoIdent],input[name=PlatformNoSexNot],input[name=PlatformNoSexMale],input[name=PlatformNoSexFemale],input[name=PlatformNoAgeBegin],input[name=PlatformNoAgeEnd]").live("keyup", function () {
            var buyPointCount = 0;
            var PlatformNoSexNot = 0;
            var PlatformNoSexMale = 0;
            var PlatformNoSexFemale = 0;
//            var PlatformNoAcceptPeriod = 0;
            var PlatformNoIdent = 0;
             var djTotal=0;
//             djTotal=1+0;//7.30烧仙草取消
            djTotal=1+1+1+0;
            PlatformNoSexNot = $("input[name=PlatformNoSexNot]").val() * parseFloat($("#sexNotPoint").text());
            PlatformNoSexMale += $("input[name=PlatformNoSexMale]").val() * parseFloat($("#sexMalePoint").text());
            PlatformNoSexFemale += $("input[name=PlatformNoSexFemale]").val() * parseFloat($("#sexFamalePoint").text());
//            if ('淘宝== PlatformType.淘宝') {
//                PlatformNoAcceptPeriod += $("input[name=PlatformNoAcceptPeriod]").val() * parseFloat($("#PlatformNoAcceptPeriodPoint").text());

//            }

            //实名认证 计算
            if ("淘宝" == "淘宝") {
                PlatformNoIdent += $("input[name=PlatformNoIdent]").val() * parseFloat($("#PlatformNoIdentPoint").text());
            }

            if ($(this).attr("name") != "PlatformNoIdent" && $(this).attr("name") != "PlatformNoSexNot" && $(this).attr("name") != "PlatformNoSexMale" && $(this).attr("name") != "PlatformNoSexFemale") {
                if ($(this).attr("name") != "PlatformNoAgeEnd" && $(this).attr("name") != "PlatformNoAgeBegin") {
                    $(this).parent().next().text(parseFloat($(this).parent().prev().text() * $(this).val()).toFixed(2));
                }
            }
            $("#djTable tr td[class=fb3_hej]:not(:eq(0))").each(function () {
                buyPointCount += parseFloat($(this).text());
            });
            var age = $("#taskNum").val() * parseFloat($("#age").text()); //山竹2015－5－3 
            if (parseInt($("input[name=PlatformNoAgeEnd]").val()) == 0
            && parseInt($("input[name=PlatformNoAgeBegin]").val()) == 0) {
                age = 0
            }
            var totalPoint = buyPointCount + PlatformNoSexNot + PlatformNoSexMale + PlatformNoSexFemale + PlatformNoIdent + age;
            $("#buyPointCount").text(totalPoint.toFixed(2));

            var djCount = 0;
            var PlatformType = '淘宝';
            var Sex=parseInt($("input[Name=PlatformNoSexNot]").val()) + parseInt($("input[Name=PlatformNoSexMale]").val()) + parseInt($("input[Name=PlatformNoSexFemale]").val());
            $("#djTable tr td input").each(function () {
                var value = 0;
                if ($(this).val() != "" && $(this).val() != " " && $(this).val() != null)
                { value = $(this).val(); }
                djCount += parseInt(value);
            });
//            if (parseInt($("input[Name=PlatformNoAcceptPeriod]").val()) > $("#taskNum").val())
//            { $("#Bymsg").html("<b style=\"color: Red\">温馨提示:</b>接手周期个数不能大于任务总数"); }
//            else if (Sex != $("#taskNum").val() && Sex>0)
//            { $("#Bymsg").html("<b style=\"color: Red\">温馨提示:</b>性别要求总数必须等于任务总数"); }
//            else if (parseInt($("input[Name=PlatformNoIdent]").val()) > $("#taskNum").val())
//            { $("#Bymsg").html("<b style=\"color: Red\">温馨提示:</b>实名制个数不能大于任务总数"); }
//            else if (PlatformType == "淘宝" && parseInt(djCount) != $("#taskNum").val() && djCount>0) {
//                $("#Bymsg").html("<b style=\"color: Red\">温馨提示:</b>买号等级限制数量总和必须等于任务总数");
//            }
//            else
//            { $("#Bymsg").html(""); }

//             $("#lbPlatformNoAcceptPeriodRe").text($("#taskNum").val()-$("input[Name=PlatformNoAcceptPeriod]").val());//计算接手周期剩余个数
             $("#lbPlatformNoIdentRe").text($("#taskNum").val()-$("input[Name=PlatformNoIdent]").val());//计算实名认证剩余个数
             $("#lbPlatformNoSexRe").text($("#taskNum").val()-Sex);//计算性别剩余个数
             $("#lbPlatformNoLevelRe").text(djTotal-djCount);//计算买号等级剩余个数
             $("#lbPlatformNoSexRes").text($("#lbPlatformNoSexRe").text());
             $("#lbPlatformNoLevelRes").text($("#lbPlatformNoLevelRe").text());
            
        });
        //计算好评发布点
        $("#contentTable  tr td input,#AddGoodTable tr td input").live("keyup", function () {
            var hpPointCount = 0;
            var contentCount = 0;
            var addGoodCount = 0;
            $(this).parent().next().text(parseFloat($(this).parent().prev().text() * $(this).val()).toFixed(2));
            $("#contentTable tr td[class=fb3_hej]:not(:eq(0)),#AddGoodTable tr td[class=fb3_hej]").each(function () {
                hpPointCount += parseFloat($(this).text());
            });
            $("#hpPointCount").text(hpPointCount.toFixed(2));

            $("#contentTable tr td input").each(function () {
                var value = 0;
                if ($(this).val() != "" && $(this).val() != " " && $(this).val() != null)
                { value = $(this).val(); }
                contentCount += parseInt(value);
            });
            $("#AddGoodTable tr td input").each(function () {
                var value = 0;
                if ($(this).val() != "" && $(this).val() != " " && $(this).val() != null)
                { value = $(this).val(); }
                addGoodCount += parseInt(value);
            });
//            if (contentCount != $("#taskNum").val() && contentCount>0)
//            { $("#Pjmsg").html("<b style=\"color: Red\">温馨提示:</b> 好评数量总和必须等于任务总数"); }
//            else if (addGoodCount != $("#taskNum").val() && addGoodCount>0)
//           { $("#Pjmsg").html("<b style=\"color: Red\">温馨提示:</b> 追评数量总和必须等于任务总数"); }
//            else
//            { $("#Pjmsg").html(""); }
              
             $("#lbHighOpinionRe").text($("#taskNum").val()-contentCount);//计算好评剩余个数
             $("#lbAddToHighOpinionRe").text($("#taskNum").val()-addGoodCount);//计算追平剩余个数
             $("#lbHighOpinionRes").text($("#taskNum").val()-contentCount);
             $("#lbAddToHighOpinionRes").text($("#lbAddToHighOpinionRe").text());
        });
        //计算停留时间发布点
        $("#tlTable tr td input").live("keyup", function () {
            var tlPointCount = 0;
            var tlCount = 0;
            $(this).parent().next().text(parseFloat($(this).parent().prev().text() * $(this).val()).toFixed(2));
            $("#tlTable tr td[class=fb3_hej]:not(:eq(0))").each(function () {
                tlPointCount += parseFloat($(this).text());
            });
            $("#tlPointCount").text(tlPointCount.toFixed(2));
            $("#tlTable tr td input").each(function () {
                var value = 0;
                if ($(this).val() != "" && $(this).val() != " " && $(this).val() != null)
                { value = $(this).val(); }
                tlCount += parseInt(value);
            });
//            if (tlCount != $("#taskNum").val() && tlCount > 0)
//            { $("#Tlmsg").html("<b style=\"color: Red\">温馨提示:</b> 停留数量总和必须等于任务总数"); }
//            else
//            { $("#Tlmsg").html(""); }

           $("#lbInsideShopStayRe").text($("#taskNum").val()-tlCount);//计算停留时间剩余个数
           $("#lbInsideShopStayRes").text($("#lbInsideShopStayRe").text());
        });
        //计算空包发布点
        $("#fhTable tr td input").live("keyup", function () {
            var kbPointCount = 0;
            $(this).parent().next().text(parseFloat($(this).parent().prev().text() * $(this).val()).toFixed(2));
            $("#fhTable tr td[class=fb3_hej]:not(:eq(0))").each(function () {
                kbPointCount += parseFloat($(this).text());
            });
            $("#kbPointCount").text(kbPointCount.toFixed(2));
        });

      $('#rdContent').live("click",function(){
         $(this).next().val("true");
       });
      
        //数据验证 
        function Next(flag) {
            var msg = "";
            var hbCount = 0;
            var djCount = 0;
            var contentCount = 0;
            var addGoodCount = 0;
            var tlCount = 0;
            var fhCount = 0;
            var hbTotal=0; //货比剩余数量
            var djTotal=0; //买号等级剩余数量
            var LICount=0;//浏览数量
            var MxCount=0;//买限数量
            var FlagName="";
              $("#LlTable tr td input").each(function () {
                    if ($(this).val() == "")
                    { $(this).val(0); }
                    LICount += parseInt($(this).val());
                });

            $("#MxTable tr td input").each(function () {
                if ($(this).val() == "")
                { $(this).val(0); }
                MxCount += parseInt($(this).val());
            });


            $("#hbTable tr td input").each(function () {
                if ($(this).val() == "")
                { $(this).val(0); }
                hbCount += parseInt($(this).val());
            });

            $("#djTable tr td input").each(function () {
                if ($(this).val() == "")
                { $(this).val(0); }
                djCount += parseInt($(this).val());
            });
            $("#contentTable tr td input").each(function () {
                if ($(this).val() == "")
                { $(this).val(0); }
                contentCount += parseInt($(this).val());
            });
            $("#AddGoodTable tr td input").each(function () {
                if ($(this).val() == "")
                { $(this).val(0); }
                addGoodCount += parseInt($(this).val());
            });
            $("#tlTable tr td input").each(function () {
                if ($(this).val() == "")
                { $(this).val(0); }
                tlCount += parseInt($(this).val());
            });
//            $("#fhTable tr td input").each(function () {
//                if ($(this).val() == "")
//                { $(this).val(0); }
//                fhCount += parseInt($(this).val());
            //            });
           var highOpinionNot = parseInt($("input[Name=HighOpinionNot]").val()); //不评价数量
           var val=$('input:radio[name="IsSpecifyHOContents"]:checked').val();
           if(val!=null)
           {
           $("#hIsSpecify").val(val=="0"?false:true);
           }
      
            hbTotal=1+1;
            var PlatformType = '淘宝';
            if (PlatformType == "淘宝") {
                fhCount = parseInt($("input[name='ExpressSelfSend']").val()) + parseInt($("input[name='ExpressAgentSend']").val());
            }
            else {
                fhCount = parseInt($("input[name='ExpressUsed']").val()) + parseInt($("input[name='ExpressSelfSend']").val()) + parseInt($("input[name='ExpressAgentSend']").val());
            }
  
     
            if (parseInt(contentCount) != $("#taskNum").val()) {

                msg = "好评数量总和必须等于任务总数";
                FlagName="mPJ";
            }
            else if(highOpinionNot<hbTotal && val==null)
            {
              msg = "文字好评内容必须选择";
              FlagName="mPJ";
            }
           else if(highOpinionNot<hbTotal && val=="0" && $("#HighOpinion").val()=="")
            {
              msg = "选择了指定方向,必须填写方向内容";
              FlagName="mPJ";
            }
           else if ($("#pwd").val() == "") {
                msg = "安全密码不能为空";
            }
            else if ($("#pwd").val() != "") {
                var pwd = hex_md5($("#pwd").val());
                 $.ajaxSetup({
                    async: false
                });
                $.post('/Shop/VipTask/GetTradersPassword', { pwd: pwd }, function (result) {
                    if (result == "0") {
                        msg = "安全密码不正确";
                    }
                });
            }
            if (flag == 2) {
                var tName = $("#TempName").val();
                $("input[name=submitType]").val(0);
                $.ajaxSetup({
                    async: false
                });
                $.post('/Shop/VipTask/TempNameIsExists', { tempName: tName }, function (result) {
                    if (result == "True") {
                        msg = "模板名称已存在";
                    }
                });
            }
            if (flag == 1) {
                $("input[name=submitType]").val(1);

            }

            //计算消费发布点
 //           var point = parseFloat($("#oneTotalPoint").text()) + parseFloat($("#threeTatalPoint").text()) + parseFloat($("#hbPointCount").text()) + parseFloat($("#hpPointCount").text()) + parseFloat($("#tlPointCount").text()) + parseFloat($("#kbPointCount").text())+ parseFloat($("#MxPointCount").text())+ parseFloat($("#LIPointCount").text());
            var point =parseFloat($("#kbPointCount").text());
            var BasicPoint = '24';
            if ($("input[name=AddToPoint]").val() == "")
            { $("input[name=AddToPoint]").val(0); }
            $("#addPointCount").text(parseFloat($("input[name=AddToPoint]").val()) * $("#taskN").text());
            point = parseFloat(point) + parseFloat(BasicPoint)+ parseFloat($("#hpPointCount").text());
            $("#pointCount").text(parseFloat(point).toFixed(2));
            $("#totalPoint").text((parseFloat(point) + parseFloat($("#addPointCount").text())).toFixed(2));
            $("#totalPrice").text(parseFloat($("#PriceCount").text()) + parseFloat($("#lookMoney").text()));

            if (msg != "") {
                alert(msg);
                if(FlagName!="")
                {
                 window.location.hash=FlagName;
                 }
                return false;
            }
            else {
                    $.post('/Shop/VipTask/getMember', function (result) {
                        var member = eval("(" + result + ")");
                        if (parseFloat(member["Amount"]) < parseFloat($("#totalPrice").text())) {
                            $("#divMsg").text("余额不足!");
                            $("#divMsg").append(" (<a href=\"/Shop/InCome/IncomeIndex\"  target=\"_blank\"  onclick=\"javascript:void(0)\">请点击进行充值</a>)");
                            $("#btnSubmit").attr("disabled", true);
                                $("#btnSubmit").hide();
                        }
                        else if (parseFloat(member["Point"]) < parseFloat($("#totalPoint").text())) {
                            $("#divMsg").text("发布点不足");
                            $("#divMsg").append(" (<a href=\"/Member/MemberInfo/MemberDuiHuan\"   target=\"_blank\"  onclick=\"javascript:void(0)\">请点击购买发布点</a>)");
                            $("#btnSubmit").attr("disabled", true);
                            $("#btnSubmit").hide();
                        }
                        else {
                            $("#divMsg").text("");
                            $("#btnSubmit").attr("disabled", false);
                            $("#btnSubmit").show();
                        }
                    });

                $('.fb_tjbg, .fb3_tjtc').fadeIn(500);
                var pwd = hex_md5($("#pwd").val());
                $("#pwd").val(pwd);
            }
        }


        window.onload = function () {
            document.getElementsByTagName("body")[0].onkeydown = function () {
                if (event.keyCode == 8) {
                
                        var elem = event.srcElement;
                        var name = elem.nodeName;

                        if (name != 'INPUT' && name != 'TEXTAREA') {
                            if (confirm("你是否要返回上一步?") == false) {
                            event.returnValue = false;
                            return;
                            }
                        }
                        var type_e = elem.type.toUpperCase();
                        if (name == 'INPUT' && (type_e != 'TEXT' && type_e != 'TEXTAREA' && type_e != 'PASSWORD' && type_e != 'FILE')) {
                            if (confirm("你是否要返回上一步?") == false) {
                                event.returnValue = false;
                                return;
                            }
                        }
                        if (name == 'INPUT' && (elem.readOnly == true || elem.disabled == true)) {
                            if (confirm("你是否要返回上一步?") == false) {
                                event.returnValue = false;
                                return;
                            }
                        }
                  
                }
            }
        }  
      function AgentSend()//初始化默认选择代发空包
       {
               //  $("#rdExpressAgentSend_YD").attr("checked", true);
               //  $("input[name=ExpressAgentSend_YD]").val($("#taskNum").val());
                $("#rdExpressAgentSend_YT").attr("checked", true);
                $("input[name=ExpressAgentSend_YT]").val($("#taskNum").val());
                $("input[name=ExpressUsed]").val(0);
                $("input[name=ExpressSelfSend]").val(0);
                $("input[name=ExpressAgentSend_YD]").val(0);
                    //计算空包发布点
            $("#fhTable tr td input[type='hidden']").each(function () {
                var kbPointCount = 0;
                $(this).parent().next().text($(this).parent().prev().text() * $(this).val());
                $("#fhTable tr td[class=fb3_hej]:not(:eq(0))").each(function () {
                    kbPointCount += parseFloat($(this).text());
                });
                $("#kbPointCount").text(kbPointCount);
                $("#Fhmsg").html("");
            });
       }
    </script>


</head>
<body style="background: #fff;">
    <?php require_once('include/nav.php')?>
    <!--daohang-->
    
    
    
<form action="#" id="frm" method="post">        
<div class="sj-fprw" style="margin-bottom: 0px; padding-bottom: 0px;">
            <div class="tab1" style="font-size: 14px; font-family: 微软雅黑; margin-bottom: 20px;
                color: #222;">
                <div class="menu">
                    <ul>
                        <li class="off" onclick="javascript:window.location.href='<?=site_url('sales')?>'">发布任务</li>
                        <li onclick="javascript:window.location.href='<?=site_url('sales/task')?>'">发布管理</li>
                    </ul>
                </div>
            </div>
        </div>
        <!--发布第一步 内容--> 
        <div class="middle mid-980 task_info">

            <div class="tit" id="divone">
                <b style="color: #0099FF">发布任务：第三步</b></div>
            <!--发布第一步 内容 end-->
            <input id="ShopID" name="ShopID" type="hidden" value="98cf9150-7a07-4446-876a-2ce62bffb36b">
            <input id="ProductID" name="ProductID" type="hidden" value="417d32a1-46af-4ea2-9911-abe08bd90ef1">
            <input data-val="true" data-val-number="字段 BasicPoint 必须是一个数字。" data-val-required="BasicPoint 字段是必需的。" id="BasicPoint" name="BasicPoint" type="hidden" value="24">
            <input data-val="true" data-val-required="TaskPlanBeginTime 字段是必需的。" id="TaskPlanBeginTime" name="TaskPlanBeginTime" type="hidden" value="0001/1/1 0:00:00">
            <input data-val="true" data-val-required="TaskPlanEndTime 字段是必需的。" id="TaskPlanEndTime" name="TaskPlanEndTime" type="hidden" value="0001/1/1 0:00:00">
            <input id="HashPointToken" name="HashPointToken" type="hidden" value="98f13de53874cb4870fcfb49c9de55fe">
            <input data-val="true" data-val-required="IsEnableTaskPlan 字段是必需的。" id="IsEnableTaskPlan" name="IsEnableTaskPlan" type="hidden" value="True">
            <input data-val="true" data-val-number="字段 TaskPlan0ClockCount 必须是一个数字。" data-val-required="TaskPlan0ClockCount 字段是必需的。" id="TaskPlan0ClockCount" name="TaskPlan0ClockCount" type="hidden" value="0">
            <input data-val="true" data-val-number="字段 TaskPlan9ClockCount 必须是一个数字。" data-val-required="TaskPlan9ClockCount 字段是必需的。" id="TaskPlan9ClockCount" name="TaskPlan9ClockCount" type="hidden" value="0">
            <input data-val="true" data-val-number="字段 TaskPlan1030ClockCount 必须是一个数字。" data-val-required="TaskPlan1030ClockCount 字段是必需的。" id="TaskPlan1030ClockCount" name="TaskPlan1030ClockCount" type="hidden" value="1">
            <input data-val="true" data-val-number="字段 TaskPlan12ClockCount 必须是一个数字。" data-val-required="TaskPlan12ClockCount 字段是必需的。" id="TaskPlan12ClockCount" name="TaskPlan12ClockCount" type="hidden" value="1">
            <input data-val="true" data-val-number="字段 TaskPlan1330ClockCount 必须是一个数字。" data-val-required="TaskPlan1330ClockCount 字段是必需的。" id="TaskPlan1330ClockCount" name="TaskPlan1330ClockCount" type="hidden" value="1">
            <input data-val="true" data-val-number="字段 TaskPlan15ClockCount 必须是一个数字。" data-val-required="TaskPlan15ClockCount 字段是必需的。" id="TaskPlan15ClockCount" name="TaskPlan15ClockCount" type="hidden" value="0">
            <input data-val="true" data-val-number="字段 TaskPlan1630ClockCount 必须是一个数字。" data-val-required="TaskPlan1630ClockCount 字段是必需的。" id="TaskPlan1630ClockCount" name="TaskPlan1630ClockCount" type="hidden" value="0">
            <input data-val="true" data-val-number="字段 TaskPlan18ClockCount 必须是一个数字。" data-val-required="TaskPlan18ClockCount 字段是必需的。" id="TaskPlan18ClockCount" name="TaskPlan18ClockCount" type="hidden" value="0">
            <input data-val="true" data-val-number="字段 TaskPlan1930ClockCount 必须是一个数字。" data-val-required="TaskPlan1930ClockCount 字段是必需的。" id="TaskPlan1930ClockCount" name="TaskPlan1930ClockCount" type="hidden" value="0">
            <input data-val="true" data-val-number="字段 TaskPlan21ClockCount 必须是一个数字。" data-val-required="TaskPlan21ClockCount 字段是必需的。" id="TaskPlan21ClockCount" name="TaskPlan21ClockCount" type="hidden" value="0">
            <input id="TimeoutTime" name="TimeoutTime" type="hidden" value="2017-10-21 10:32:57">
            
                <input type="hidden" name="IsMobilePrice" value="False">
                <input type="hidden" id="taskNum" value="3">
                <input type="hidden" id="lookNum" value="0">
                <input type="hidden" name="WordFileName" value="">
            <div class="fb_tbale">
                <!--商品详细信息-->
                <div class="fb2_table">
                    <div class="fb2_table">
                        <div class=" fb2_tbaletop">
                            <h3>
                                商品详细信息</h3>
                            <span style="margin-left: 320Px">任务总数：<b style="color: Red">3</b><span style="margin-left: 50px"></span>
                                基本发布点：<b style="color: Red">24</b></span><a href="javascript:void(0);" class="fb2_icswon"><i class="fb2_ictog"></i></a>
                        </div>
                        <div class="fb2_sbxiis">
                            <table class="fb2_tbox" style="width: 550px;">
                                <tbody>
                                    <tr>
                                        <td>
                                            掌柜名称：
                                        </td>
                                        <td class="fb_w60">
                                            sandyjack旗舰店
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            商品名称：
                                        </td>
                                        <td class="fb_w60">
                                            SJ包包女2017新款潮明星同款单肩包韩版时尚百搭小方包真皮斜挎包
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            商品链接:
                                        </td>
                                        <td class="fb_w60 ">
                                            https://detail.tmall.com/item.htm?id=546649538073
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="bottom_none">
                                            任务类型:
                                        </td>
                                        <td class="fb_w60 bottom_none fb_lllb">
                                                <input type="hidden" name="TaskTypeCount" value=" 1"> 
                                                <label>
                                                    <input type="hidden" name="TaskType" value="0">PC：<span>1</span></label>
                                                <input type="hidden" name="TaskTypeCount" value=" 1"> 
                                                <label>
                                                    <input type="hidden" name="TaskType" value="1">无线端：<span>1</span></label>
                                                <input type="hidden" name="TaskTypeCount" value=" 1"> 
                                                <label>
                                                    <input type="hidden" name="TaskType" value="2">无线二维码：<span>1</span></label>
                                                <input type="hidden" name="TaskTypeCount" value=" 0"> 
                                                <label>
                                                    <input type="hidden" name="TaskType" value="3">促销类：<span>0</span></label>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="fb2_topimg">
                                <div class="fb2_mmm">
                                    
                                    <img src="style/UpdateImage_546649538073_TB194eNngoQMeJjy0FpXXcTxpXa_!!0-item_pic.jpg_400x400q90.jpg" width="100" height="100">
                                </div>
                            </div>
                        </div>
                        <table class="fb2_tbox fb2_rwlx fb2_rejh fb2_newsrh ">
                            <thead>
                                <tr>
                                    <td style="width: 98px;">
                                        日期
                                    </td>
                                        <input type="hidden" name="TaskPlanTime" value=" 2017/10/20 10:56:47"> 
                                        <td>
                                            10月20日
                                        </td>
                                        <input type="hidden" name="TaskPlanTime" value=" 2017/10/21 10:56:47"> 
                                        <td>
                                            10月21日
                                        </td>
                                        <input type="hidden" name="TaskPlanTime" value=" 2017/10/22 10:56:47"> 
                                        <td>
                                            10月22日
                                        </td>
                                        <input type="hidden" name="TaskPlanTime" value=" 2017/10/23 10:56:47"> 
                                        <td>
                                            10月23日
                                        </td>
                                        <input type="hidden" name="TaskPlanTime" value=" 2017/10/24 10:56:47"> 
                                        <td>
                                            10月24日
                                        </td>
                                        <input type="hidden" name="TaskPlanTime" value=" 2017/10/25 10:56:47"> 
                                        <td>
                                            10月25日
                                        </td>
                                        <input type="hidden" name="TaskPlanTime" value=" 2017/10/26 10:56:47"> 
                                        <td>
                                            10月26日
                                        </td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="width: 98px;">
                                        数量
                                    </td>
                                        <input type="hidden" name="TaskPlanCount" value="3"> 
                                        <td>
                                            <span>3</span>
                                        </td>
                                        <input type="hidden" name="TaskPlanCount" value="0"> 
                                        <td>
                                            <span>0</span>
                                        </td>
                                        <input type="hidden" name="TaskPlanCount" value="0"> 
                                        <td>
                                            <span>0</span>
                                        </td>
                                        <input type="hidden" name="TaskPlanCount" value="0"> 
                                        <td>
                                            <span>0</span>
                                        </td>
                                        <input type="hidden" name="TaskPlanCount" value="0"> 
                                        <td>
                                            <span>0</span>
                                        </td>
                                        <input type="hidden" name="TaskPlanCount" value="0"> 
                                        <td>
                                            <span>0</span>
                                        </td>
                                        <input type="hidden" name="TaskPlanCount" value="0"> 
                                        <td>
                                            <span>0</span>
                                        </td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="fb2_tbox fb2_tjiag fb2_nerenw">
                            <thead>
                                <tr>
                                    <td>
                                        价格
                                    </td>
                                    <td>
                                        任务数量
                                    </td>
                                </tr>
                            </thead>
                            <tbody>
                                    <tr>
                                        <td>
                                            <input type="hidden" name="ProductPrice" value="1">
                                            <span>1</span>
                                        </td>
                                        <input type="hidden" name="ProductPriceListCount" value="3">
                                        <td>
                                            <span>3</span>
                                        </td>
                                    </tr> 
                            </tbody>
                        </table>
                            <table class="fb2_tbox new_fb3box">
                                <tbody>
                                    <tr>
                                        <th>
                                        </th>
                                        <td>
                                            关键字:
                                        </td>
                                        <td class="new_fblbe ">
                                            <ul>
                                                    <li>
                                                        <label>
                                                            <input type="hidden" name="SearchType" value="PC淘宝">
                                                            <input type="hidden" name="SearchKey" value="款潮明星同款单肩包韩">
                                                            <input type="hidden" name="SortType" value="综合">
                                                            <input type="hidden" name="ConversionPercent" value="0">
                                                            <input type="hidden" name="KeyWordCount" value="1">
                                                            <input type="hidden" name="OtherSearch" value="-1">
                                                            <input type="hidden" name="OtherContent" value="">
                                                            <input type="hidden" name="SendProductCity" value="">
                                                            <input type="hidden" name="PriceStart" value="0">
                                                            <input type="hidden" name="PriceEnd" value="0">
                                                            <span>搜索来路：<i>PC淘宝</i></span> <span>关键字：<i>款潮明星同款单肩包韩</i></span>
                                                            <span>排序方式：<i>综合</i></span>
                                                            <span>任务数:<i>1</i></span> <span>转化率：<i>0</i>
                                                            </span><span>流量：<i>0                                                            </i></span>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label>
                                                            <input type="hidden" name="SearchType" value="移动淘宝">
                                                            <input type="hidden" name="SearchKey" value="款潮明星同款单肩包韩">
                                                            <input type="hidden" name="SortType" value="综合">
                                                            <input type="hidden" name="ConversionPercent" value="0">
                                                            <input type="hidden" name="KeyWordCount" value="1">
                                                            <input type="hidden" name="OtherSearch" value="-1">
                                                            <input type="hidden" name="OtherContent" value="">
                                                            <input type="hidden" name="SendProductCity" value="">
                                                            <input type="hidden" name="PriceStart" value="0">
                                                            <input type="hidden" name="PriceEnd" value="0">
                                                            <span>搜索来路：<i>移动淘宝</i></span> <span>关键字：<i>款潮明星同款单肩包韩</i></span>
                                                            <span>排序方式：<i>综合</i></span>
                                                            <span>任务数:<i>1</i></span> <span>转化率：<i>0</i>
                                                            </span><span>流量：<i>0                                                            </i></span>
                                                        </label>
                                                    </li>
                                            </ul>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                    </div>
                </div>
                <!--商品详细信息 END-->
                <!--收藏-->
                 
                <!--收藏 END-->
                <!--深度浏览-->
                
                <!--深度浏览 END-->
                <!--货比-->
                
                <!--货比 END-->
                <!--旺聊-->
                
                <!--旺聊 END-->
                <!--复购周期-->
                
                <!--复购周期 END-->
                <!--买号要求-->
                <!--买号要求 END-->
                <!--评价-->
                <div class="fb2_table" style="margin: 20px auto;">
                    <a name="mPJ"></a><a name="mZPJ"></a>
                    <div class=" fb2_tbaletop">
                        <h3>
                            评价</h3>
                        <span style="margin-left: 1px; position: absolute" id="Pjmsg"></span><span style="margin-left: 470px">
                            好评可分配数量：<b style="color: Red"><label id="lbHighOpinionRes">3</label></b></span>
                        <a href="javascript:void(0);" class="fb2_icswon"><i class="fb2_ictog"></i></a>
                    </div>
                    <table class="fb2_tbox fb3_huobi fb3_new_le " style="width: 100px">
                        <tbody>
                            <tr>
                                <td>
                                </td>
                            </tr>
                            <tr>
                                <td class="new_leh2">
                                    好<br>
                                    评
                                </td>
                            </tr>
                            <!--          <tr><td class="new_leh3">追<br>评</td></tr>-->
                        </tbody>
                    </table>
                    <table class="fb2_tbox fb3_huobi " id="contentTable" style="width: 748px; border-left: none;
                        border-right: none;">
                        <tbody><tr>
                            <td class="fb3_mc">
                                评价类型
                            </td>
                            <td class="fb3_fbd">
                                发布点
                            </td>
                            <td class="fb3_sl">
                                数量
                            </td>
                            <td class="fb3_hej">
                                合计
                            </td>
                        </tr>
                        <tr>
                            <td class="fb3_mc">
                                不评价：
                            </td>
                            <td class="fb3_fbd">
                                0
                            </td>
                            <td class="fb3_sl">
                                <input name="HighOpinionNot" type="text" onkeyup="value=value.replace(/[^0-9]/g,'')" placeholder="0" value="0" maxlength="3">
                            </td>
                            <td class="fb3_hej">
                                0
                            </td>
                        </tr>
                        <tr>
                            <td class="fb3_mc">
                                文字好评：
                            </td>
                            <td class="fb3_fbd">
                                1.00
                            </td>
                            <td class="fb3_sl">
                                <input name="HighOpinionWord" type="text" onkeyup="value=value.replace(/[^0-9]/g,'')" placeholder="0" value="0" maxlength="3">
                            </td>
                            <td class="fb3_hej">
                                0
                            </td>
                        </tr>
                        <tr>
                            <td class="fb3_mc">
                                晒图好评：
                            </td>
                            <td class="fb3_fbd">
                                2.00
                            </td>
                            <td class="fb3_sl">
                                <input name="HighOpinionImg" type="text" onkeyup="value=value.replace(/[^0-9]/g,'')" placeholder="0" value="0" maxlength="3">
                            </td>
                            <td class="fb3_hej">
                                0
                            </td>
                        </tr>
                    </tbody></table>
                    <!--好评方向-->
                    <table class="fb2_tbox fb3_huobi fb3_new_kuang" style="width: 850px; border-left: none;
                        border-right: none; border-top: none;">
                        <tbody>
                            <tr>
                                <td rowspan="2" class="new_k1" style="width: 95px; height: 30px">
                                    文字好评内容
                                </td>
                                <td class="new_k1" style="width: 173px; height: 30px">
                                    <input type="radio" name="IsSpecifyHOContents" id="rdRedition" value="0">指定方向
                                </td>
                                <td class="new_k2" style="width: 550px; height: 30px">
                                    <textarea id="HighOpinion" name="HighOpinionOrientation" style="height: 28px"></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td class="new_k11" style="width: 173px; height: 30px">
                                    <input type="radio" name="IsSpecifyHOContents" id="rdContent" value="1">指定内容
                                    <input type="hidden" id="hIsSpecify" name="IsSpecifyHOContent">
                                </td>
                                <td style="width: 550px; height: 30px">
                                    请在发布成功以后在发布管理页面针对具体任务设置评价内容。
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <!--好评方向 END-->
                    <div class="fb2_sphj">
                        <span class="sphj_l">合计发布点：</span> <span class="sphj_r" id="hpPointCount">0</span>
                    </div>
                </div>
                <!--评价 END-->
                <!--停留时间-->
                
                <!--停留时间 END-->
                <!--发货选择-->
                <div class="fb2_table" style="margin: 20px auto;">
                    <div class=" fb2_tbaletop">
                        <h3 style="width: 450px">
                            发货选择<a target="_blank" href="http://qqq.wkquan.com/Other/Content/NewsInfo?id=23">关于快递选项的说明</a></h3>
                        <span style="margin-left: 1px; position: absolute" id="Fhmsg"></span><a href="javascript:void(0);" class="fb2_icswon"><i class="fb2_ictog">
                            </i></a>
                    </div>
                    <table class="fb2_tbox fb3_huobi " id="fhTable">
                        <tbody><tr>
                            <td class="fb3_mc">
                                名称
                            </td>
                            <td class="fb3_fbd">
                                发布点
                            </td>
                            <td class="fb3_sl">
                                 选择类型
                            </td>
                            <td class="fb3_hej">
                                合计
                            </td>
                        </tr>
                        <tr style="display: none">
                            <td class="fb3_mc">
                                代发快递：
                            </td>
                            <td class="fb3_fbd">
                                4.00
                            </td>
                            <td class="fb3_sl">
                                
                                <input type="hidden" name="ExpressAgentSend" value="0">
                                <input type="radio" id="rdExpressAgentSend" name="rdData" value="1">
                            </td>
                            <td class="fb3_hej">0</td>
                        </tr>
                        <tr style="display: none">
                            <td class="fb3_mc">
                                韵达快递：
                            </td>
                            <td class="fb3_fbd">
                                4.00
                            </td>
                            <td class="fb3_sl">
                                
                                <input type="hidden" name="ExpressAgentSend_YD" value="0">
                                <input type="radio" id="rdExpressAgentSend_YD" name="rdData" value="4">
                            </td>
                            <td class="fb3_hej">0</td>
                        </tr>
                        <tr>
                            <td class="fb3_mc">
                                圆通快递：
                            </td>
                            <td class="fb3_fbd">
                                4.00
                            </td>
                            <td class="fb3_sl">
                                <input type="hidden" name="ExpressAgentSend_YT" value="3">
                                <input type="radio" id="rdExpressAgentSend_YT" name="rdData" value="5" checked="checked">
                            </td>
                            <td class="fb3_hej">12</td>
                        </tr>
                    </tbody></table>
                    <div class="fb2_sphj">
                        <span class="sphj_l">合计发布点：</span> <span class="sphj_r" id="kbPointCount">12</span>
                    </div>
                </div>
                <div class="fb2_table " style="margin: 20px auto;">
                    <div class=" fb2_tbaletop">
                        <h3>
                            追加发布点和备注</h3>
                        <a href="javascript:void(0);" class="fb2_icswon"><i class="fb2_ictog"></i></a>
                    </div>
                    <table class="fb2_tbox fb3_huobi fb_zja ">
                        <tbody>
                            <tr>
                                <td style="padding: 7px 3px;">
                                    <label>
                                        追加发布点：</label>
                                    </td><td class="fb2_zjt2">
                                        <input type="text" name="AddToPoint" onkeyup="value=value.replace(/[^0-9]/g,'')" placeholder="0" value="0" maxlength="5">
                                    </td>
                                
                            </tr>
                            <tr>
                                <td>
                                    <label>
                                        任 务 备 注：</label>
                                    </td><td class="fb2_zj3 fb2_zjt2">
                                        <textarea id="Remark" name="TaskRemark"></textarea>
                                    </td>
                                
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div>
                     <span class="sphj_l" style="margin-left: 560px">安全密码：</span>
                    <input id="pwd" name="TradersPassword" class="sphj_r" type="password" maxlength="25" style="width: 200px">
                </div>
                <br>
                <!--发货选择 END-->
                <!--下一步-->
                <a href="javascript:void(0);" class="next_button i3_button" onclick="return Next(1);">
                    提交</a> 
                <!--下一步 END-->
                
            </div>
        </div>
        <!--提交弹窗-->
        <div class="fb_tjbg" style="display: none">
        </div>
        <div class="fb_tjbox fb3_tjtc" style="display: none">
            <div class="fb_tjmian">
                <a href="javascript:void(0);" class="fb_tjclose ">关闭</a>
                <div class=" fb2_tbaletop" style="padding: 8px 0;">
                    <h3 style="text-align: center; width: 100%">
                        确认发布任务</h3>
                </div>
                <!--统计表格-->
                <div class="fb2_table" style="margin: 20px auto; width: 90%;">
                    <table class="fb2_tbox fb3_huobi ">
                        <thead>
                            <tr>
                                <td class="fb3_sl">
                                    任务个数
                                </td>
                                <td class="fb3_sl">
                                    担保金
                                </td>
                                <td class="fb3_sl">
                                    消耗发布点
                                </td>
                                <td class="fb3_sl">
                                    追加发布点
                                </td>
                                <td class="fb3_sl">
                                    流量费用
                                </td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="fb3_sl">
                                    <i id="taskN">3</i>
                                </td>
                                <td class="fb3_sl">
                                    <i id="PriceCount">3</i>
                                </td>
                                <td class="fb3_sl">
                                    <i id="pointCount">0</i>
                                </td>
                                <td class="fb3_sl">
                                    <i id="addPointCount">0</i>
                                </td>
                                <td class="fb3_sl">
                                    <i id="lookMoney">0</i>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="fb2_sphj">
                        <span class="sphj_l">合计消费存款：</span> <span class="sphj_r" id="totalPrice">0</span>;
                        <span class="sphj_l">合计消费发布点：</span> <span class="sphj_r" id="totalPoint">0</span>
                    </div>
                </div>
                <!--统计表格 END-->
                <!--下一步-->
                <input data-val="true" data-val-number="字段 submitType 必须是一个数字。" data-val-required="submitType 字段是必需的。" id="submitType" name="submitType" type="hidden" value="0">
                <input type="submit" class="next_button" value="确认发布" id="btnSubmit">
                <input type="hidden" id="submitCnt" value="0">
                <center>
                    <div id="divMsg" class="sphj_r">
                    </div>
                </center>
                <!--下一步 END-->
            </div>
        </div>
        <!--提交弹窗 END-->
        <!--模板弹窗-->
        <div id="fb_tjbg" class="fb_tjbg1" style="display: none;">
        </div>
        <div id="fb_tjbox" class="fb_tjbox fb3_tjtc1" style="display: none; width: 350px;
            height: 450px; margin-left: 200px">
            <div class="fb_tjmian">
                <a href="javascript:void(0);" class="fb_tjclose ">关闭</a>
                <div class=" fb2_tbaletop" style="padding: 8px 0;">
                    <h3 style="text-align: center; width: 100%">
                        选择模板</h3>
                </div>
                <div class="fb2_table" style="margin: 20px auto; width: 90%;">
                    <div id="divtemplate">
                        <h4>
                            <input type="radio" name="Template" value="1" id="one"><label style="cursor: pointer" for="one">
                                系统模版一（土豪高配版）</label><br>
                            <input type="radio" name="Template" value="2" id="two"><label style="cursor: pointer" for="two">
                                系统模版二（老朱推荐版）</label>
                            <br>
                            <input type="radio" name="Template" value="3" id="three"><label style="cursor: pointer" for="three">
                                系统模版三（屌丝省油版）</label><br>
                        </h4>
                    </div>
                    <div id="divUsertemplate">
                        <table width="360px">
                        </table>
                    </div>
                </div>
                <!--下一步-->
                <!--下一步 END-->
                <div style="margin-right: 120px; margin-top: 50px">
                    <input type="button" class="next_button" value="确认" id="btnTempSave"></div>
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


</script>
<?php require_once('include/footer.php')?>


</body></html>