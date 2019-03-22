<?php require_once('include/header.php')?>  
    
    <link href="<?=base_url()?>style/css.css" rel="stylesheet" type="text/css">
    <script src="<?=base_url()?>style/iepngfix_tilebg.js" type="text/javascript"></script>
    <script src="<?=base_url()?>style/jquery.jBox-2.3.min.js" type="text/javascript"></script>
    <link href="<?=base_url()?>style/jbox.css" rel="stylesheet" type="text/css">
    <style type="text/css">
        .nav
        {
            width: 100%;
        }
        /*表格共用样式*/
        table
        {
            border: solid #ddd;
            border-width: 0px 0px 0px 0px;
            text-align: center;
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }
        th, td
        {
            padding: 10px 5px;
            line-height: 22px;
        }
        td
        {
            border: solid #ddd;
            border-width: 0px 0px 0px 0px;
            margin: 0px;
        }
        th
        {
            background: #f5f5f5;
            border-bottom: 1px solid #ddd;
            border-right: 1px solid #ddd;
            font-weight: normal;
        }
    </style>
    
    <link href="<?=base_url()?>style/cssOne.css" rel="stylesheet" type="text/css">
    <script src="<?=base_url()?>style/jquery-1.11.2.min.js" type="text/javascript"></script>
    <script src="<?=base_url()?>style/antiman.js" type="text/javascript"></script>
    <script src="<?=base_url()?>style/jquery-1.8.3.js" type="text/javascript"></script>
    <script type="text/javascript" src="<?=base_url()?>style/jquery.easyui.min.js"></script>
    
    <script type="text/javascript" src="<?=base_url()?>style/WdatePicker.js"></script>
    <link href="<?=base_url()?>style/WdatePicker.css" rel="stylesheet" type="text/css">
    <script src="<?=base_url()?>style/jquery.jBox-2.3.min.js" type="text/javascript"></script>
    <link href="<?=base_url()?>style/jbox.css" rel="stylesheet" type="text/css">
    
    <style type="text/css">
     #VipTask
        {
        background:#3b6cca; 
        color: White;
        }
    </style>
  <?php     
    unset($_SESSION['taskday']);
    if(isset($_SESSION['taskday'])){        
        $taskday = 1;
    }else{
        $_SESSION['taskday']=0;
        $taskday = 0;
    }
  ?>
    <script language="javascript" type="text/javascript">
        var ctime="";
        var isInging=0;
      function  getTaskCount(){
                var total = 0;
                var value = 0;
                $('#trTypeNum input').each(function () {
                    if ($(this).val() == "")
                    { value = 0 }   
                    else {
                        value = $(this).val();
                    }
           
                    total = total + parseInt(value);
                    $("#taskCout").text(total);
                });
        }
        function getCMinus(){
       
          var date=new Date();
          var value=date.getMinutes();
           if(value<10)
           {
              value="0"+value;
           }
           $("#startTimeM").val(value);
 
           ctime=setTimeout("getCMinus()", 1000*1);  
        };
        $(function(){
                 $("#VipTask").addClass("#VipTask");
            
        });

    function CurentTime()
    { 
        var now = new Date();  
        var year = now.getFullYear();       //年
        var month = now.getMonth() + 1;     //月
        var day = now.getDate();            //日
        var hh = now.getHours();            //时
        var mm = now.getMinutes();          //分
        var ss = now.getSeconds();           //秒
        var clock = year + "-";
        if(month < 10)
            clock += "0";
        clock += month + "-";
        if(day < 10)
            clock += "0";
        clock += day + " ";
        if(hh < 10)
            clock += "0";
        clock += hh + ":";
        if (mm < 10) clock += '0'; 
        clock += mm + ":"; 
        if (ss < 10) clock += '0'; 
        clock += ss; 
        return(clock); 
}
function getQueryString(name) { 
var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i"); 
var r = window.location.search.substr(1).match(reg); 
if (r != null) return unescape(r[2]); return null; 
} 

        $(document).ready(function () {
            $("#VipTask").addClass("a_on");
              $("input[Name=rdData]").attr("disabled","disabled");
              $("#divPlanTime").hide();
             // getTaskCount();
        
             //  dataBind();

            var isSendInfo="<?=$taskday?>";
            
         
            
            if(isSendInfo==0){ 
              //  alert('11111');
                 // $(".tablescroll_wrapper").hide();
                 // $("#divInfo").show();
     
                  // 自定义按钮
                    var submit = function (v, h, f) {
                        if (v == true) {
                             window.location.href="<?=site_url('sales')?>";
                         }else{
                        	 window.location.href="<?=site_url('daily')?>";
                         }
                    }
                    jBox.confirm("日常任务风险较高，建议发布销量任务。", "温馨提示", submit, { id: 'hahaha', top: 250,draggable:false, buttons: { '发布销量任务': true, '发布日常任务': false} });
             }        

            $("#trTypeNum input,#btnsub").bind("keyup", function () {
                var total = 0;
                var value = 0;
                $('#trTypeNum input').each(function () {
                    if ($(this).val() == "")
                    { value = 0 }
                    else {
                        value = $(this).val();
                    }
                    total = total + parseInt(value);
                    $("#taskCout").text(total);
                    $("#otherNum").text(total); 
                });
                Comm();
            });


            $("#trTypeNum input").focus(function(){
                if($(this).val()<1)
                {
                  $(this).val(" ");
                }
            });
             $("#trTypeNum input").focusout(function(){
                if($(this).val()<1||isNaN($(this).val()))
                {
                  $(this).val(0);
                }
            });

                 $("#trPlanTime input").focus(function(){
                if($(this).val()<1)
                {
                  $(this).val(" ");
                }
            });
             $("#trPlanTime input").focusout(function(){
                if($(this).val()<1||isNaN($(this).val()))
                {
                  $(this).val(0);
                }
            });

            $("#trPlanNum input,#btnsub").live("keyup", function () {
                var planCount = 0;
                $('#trPlanNum input').each(function () {
                    if ($(this).val() == "")
                    { $(this).val(0); }
                    planCount = planCount + parseInt($(this).val());
                    $("#plantaskCout").text(planCount);
                });
            });


          
             $("#trPlanTime input").live("keyup", function () {
               Comm();
            });

            $("input[Name=rdData]").click(function () {
   
                var index = $(this).val();
                 if(index>1)
                 {
                    $("input[Name=TaskPlan0ClockCount]").attr("disabled",false);
                    $("input[Name=TaskPlan9ClockCount]").attr("disabled",false);
                    $("input[Name=TaskPlan1030ClockCount]").attr("disabled",false);
                    $("input[Name=TaskPlan12ClockCount]").attr("disabled",false);
                    $("input[Name=TaskPlan1330ClockCount]").attr("disabled",false);
                    $("input[Name=TaskPlan15ClockCount]").attr("disabled",false);
                    $("input[Name=TaskPlan1630ClockCount]").attr("disabled",false);
                    $("input[Name=TaskPlan18ClockCount]").attr("disabled",false);
                    $("input[Name=TaskPlan1930ClockCount]").attr("disabled",false);
                    $("input[Name=TaskPlan21ClockCount]").attr("disabled",false);
                 }
                 else{
                     var myData=new Date();
                     var curHour=myData.getHours();
                    if(curHour>=9)
                    {
                        $("input[Name=TaskPlan0ClockCount]").attr("disabled","disabled");
                        $("input[Name=TaskPlan0ClockCount]").val(0);
                     }
                    if(curHour>=10)
                    {
                       $("input[Name=TaskPlan9ClockCount]").attr("disabled","disabled");
                       $("input[Name=TaskPlan9ClockCount]").val(0);
                     }
                    if(curHour>=12)
                    {
                       $("input[Name=TaskPlan1030ClockCount]").attr("disabled","disabled");
                       $("input[Name=TaskPlan1030ClockCount]").val(0);
                     }
                     if(curHour>=13)
                    {
                       $("input[Name=TaskPlan12ClockCount]").attr("disabled","disabled");
                       $("input[Name=TaskPlan12ClockCount]").val(0);
                     }
                    if(curHour>=15)
                    {
                      $("input[Name=TaskPlan1330ClockCount]").attr("disabled","disabled");
                      $("input[Name=TaskPlan1330ClockCount]").val(0);
                   }
                    if(curHour>=16)
                    {
                      $("input[Name=TaskPlan15ClockCount]").attr("disabled","disabled");
                      $("input[Name=TaskPlan15ClockCount]").val(0);
                   }
                    if(curHour>=18)
                    {
                     $("input[Name=TaskPlan1630ClockCount]").attr("disabled","disabled");
                     $("input[Name=TaskPlan1630ClockCount]").val(0);
                   }
                     if(curHour>=19)
                    {
                     $("input[Name=TaskPlan18ClockCount]").attr("disabled","disabled");
                     $("input[Name=TaskPlan18ClockCount]").val(0);
                   }
                    if(curHour>=21)
                    {
                     $("input[Name=TaskPlan1930ClockCount]").attr("disabled","disabled");
                      $("input[Name=TaskPlan1930ClockCount]").val(0);
                   }
                 }
                   Comm();
                  dataBind();
                $("input[Name=TaskPlanCount]").each(function () {
                    if ($(this).attr("id") == "num" + index + "") {
                        $("#num" + index + "").val($("#taskCout").text());
                    }
                    else {
                        $(this).val(0);
                    }

                });
            });

            $("#pTimeOut").click(function(){
                if($(this).attr("checked"))
                $("#spTimedisplay").show();
                else
                {
                 $("input[name=TimeoutTime]").val("");
                 $("#spTimedisplay").hide();
                 }
            });
            $("#pTime").click(function(){
            
              if($(this).attr("checked"))
              {
                var myData=new Date();
                var curHour=myData.getHours();

                if(curHour>=9)
                {
                   $("input[Name=TaskPlan0ClockCount]").attr("disabled","disabled");
                }
                 if(curHour>=10)
                {
                   $("input[Name=TaskPlan9ClockCount]").attr("disabled","disabled");
                }
                if(curHour>=12)
                {
                   $("input[Name=TaskPlan1030ClockCount]").attr("disabled","disabled");
                }
                    if(curHour>=13)
                {
                   $("input[Name=TaskPlan12ClockCount]").attr("disabled","disabled");
                }
                if(curHour>=15)
                {
                   $("input[Name=TaskPlan1330ClockCount]").attr("disabled","disabled");
                }
                 if(curHour>=16)
                {
                   $("input[Name=TaskPlan15ClockCount]").attr("disabled","disabled");
                }
                 if(curHour>=18)
                {
                   $("input[Name=TaskPlan1630ClockCount]").attr("disabled","disabled");
                }
                if(curHour>=19)
                {
                   $("input[Name=TaskPlan18ClockCount]").attr("disabled","disabled");
                }
                 if(curHour>=21)
                {
                   $("input[Name=TaskPlan1930ClockCount]").attr("disabled","disabled");
                }
              $("input[Name=rdData]").attr("disabled",false);
              $("#divPlanTime").show();
               $("#IsEnableTaskPlans").val("True");
              }
              else{
               $("input[Name=rdData]").attr("disabled","disabled");
                 $("#divPlanTime").hide();
                $("#endTimeM").val($("#startTimeM").val());
                $("#IsEnableTaskPlans").val("False");
//                 clearTimeout(ctime);
              }
            
            });

        
            $("#startTimeH,#startTimeM").click(function(){
                  var myDate = new Date();
                  var cHours=myDate.getHours();
                  var cMinutes=myDate.getMinutes();
                    if(cHours<10)
                    {
                        cHours="0"+cHours;
                    }
                    if(cMinutes<10)
                    {
                        cMinutes="0"+cMinutes;
                    }
                  var cTime=cHours+":"+cMinutes;
                  var index = $("input[Name=rdData]:checked").val();
                  var startTime=$("#startTimeH").val()+":"+$("#startTimeM").val();

                  if (index==1&&startTime >cTime&&$("#pTime").attr("checked")) {
           
                        clearTimeout(ctime);
                        isInging=1
                  }
                 if (isInging==1&&index==1&&startTime <cTime&&$("#pTime").attr("checked")) {
                          
                      dataBind();
                      isInging=0;
                  }
            });

        });

        function Comm()
        {
             var planCount = 0;
            $('#trPlanTime input').each(function () {
                if ($(this).val() == "")
                { $(this).val(0); }
                planCount += parseInt($(this).val());
            });   
            $("#otherNum").text($("#taskCout").text()-planCount);
        }

        function AddProduct() {
            $("#serviceValidation").remove();
            $("#clientValidationOL").html("");
            $("#clientValidation").hide();

    /*         $.jBox("iframe:/Shop/Product/Create", {
                title: "添加商品",
                width: 590,
                height: 670,
                top: 0,
                buttons: {},
                closed: function () {
                }
            }); */
        }
        //绑定时间控件
        function dataBind()
        {   
            var myDate = new Date();
            var cHours=0;
            var cMinus=myDate.getMinutes();
            var Hour="";
            var Minus="";
            var id = $(":radio:checked").val();
            var ckdDate =$("input[Name=rdData]:checked").val();
            $("#startTimeH").empty();
            $("#endTimeH").empty();
            $("#startTimeM").empty();
            $("#endTimeM").empty();
            $("#endTimeM").val("00");
            if(ckdDate==1)
            { 
             
              getCMinus();
              cHours=myDate.getHours();
              $("#pTime").attr("disabled",false);          
            }
            else{
            $("#pTime").attr("disabled","disabled");
           
            
             $("#startTimeM").val("00");
            
            clearTimeout(ctime);
            }
            for (var i =cHours; i <24; i++) {
            if(i<10)
            {
                Hour+= "<option>0"+i+"</option>"
             }
             else{
                Hour+= "<option>"+i+"</option>"
             }
            }

            for (var i = 0; i <60; i++) {
            if(i<10)
             {
                Minus+= "<option>0"+i+"</option>"
             }
             else{
                Minus+= "<option>"+i+"</option>"
             }
            }
            $("#startTimeH").append(Hour);
            $("#endTimeH").append(Hour);
            $("#startTimeM").append(Minus);
            $("#endTimeM").append(Minus);  
            if(ckdDate==1)
            { 
              var date=new Date();
              var value=date.getMinutes();
               if(value<10)
               {
                  value="0"+value;
               }
               $("#endTimeM").val(value);
            }
        }
        function getNextDay(d){
        d = new Date(d);
//        d = +d + 1000*60*60*24;
        d = new Date(d);
        var M=(d.getMonth()+1);
        if(d.getMonth()<10)
        {
         if((d.getMonth()+1)<10)
         {
          M="0"+(d.getMonth()+1);
          }
          else{
             M=d.getMonth()+1;
          }
        }
        if(d.getDate()<10)
        {
          return d.getFullYear()+"-"+M+"-"+"0"+d.getDate();
        }
        //return d;
        //格式化
        if(d.getDate()<10)
        {
          return d.getFullYear()+"-"+M+"-"+"0"+d.getDate();
        }
        return d.getFullYear()+"-"+M+"-"+d.getDate();
         
    }
        //数据验证
        function Next() {
           var myDate = new Date();
           var startTime=$("#startTimeH").val()+":"+$("#startTimeM").val();
           var endTime=$("#endTimeH").val()+":"+$("#endTimeM").val();
           var cHours=myDate.getHours();
           var cMinutes=myDate.getMinutes();
           if(cHours<10)
           {
              cHours="0"+cHours;
           }
           if(cMinutes<10)
           {
              cMinutes="0"+cMinutes;
           }
           var cTime=cHours+":"+cMinutes;
           var index = $("input[Name=rdData]:checked").val();

            $("input[Name=TaskPlanCount]").each(function () {
                if ($(this).attr("id") == "num" + index + "") {
                    $("#num" + index + "").val($("#taskCout").text());
                }
                else {
                    $(this).val(0);
                }
            });

            var taskCount = $("#taskCout").text();
            var plantaskCout = $("#plantaskCout").text();
            var id = $(":radio:checked").val();
          
            if($("#pTimeOut").attr("checked")&& $("input[name=TimeoutTime]").val()=="")
            { 
             $.jBox.alert("请设置任务完结时间。","提示");
                return false;
            }
           else if($("#pTimeOut").attr("checked")&&$("input[name=TimeoutTime]").val()<CurentTime())
            { 
             $.jBox.alert("任务完结时间不得早于系统当前时间。","提示");
                return false;
            }
           else  if (id == "undefined" || id == "" || id == null || id == "on" || id.length < 5) {
               $.jBox.alert("请先选择一个你要发布的商品","提示");
                return false;
            }
            else if (parseInt(taskCount) <= 0) {
                $.jBox.alert("任务类型总数必须大于0","提示");
                return false;
            }
            else if($("#IsEnableTaskPlans").val()=="True"&&$("#otherNum").text()!=0)
            {
                $.jBox.alert("任务展示数量必须等于任务类型总数","提示");
                return false;
            }
           if($("#pTimeOut").attr("checked")&& $("input[name=TimeoutTime]").val()!="")
            { 
      
                  var hous="00";
                  var planHm=new Array("00","09","10","12","13","15","16","18","19","21");
                  $('#trPlanTime input').each(function () {
                    if ($(this).val() == "")
                    { $(this).val(0); }
                    if($(this).val()>0)
                    {
                     var index=$(this).parent().index();
                 
                      hous=planHm[index-1];
                     }
                 });   

                 var date=new Date();
                 var dateNum= $("input[name=rdData]:checked").val(); 
                 var newDate=new Date(date.setDate(date.getDate()+(dateNum-1)));
                 var planTime=getNextDay(newDate);
                 var outDate=$("input[name=TimeoutTime]").val();
                 planTime=planTime+" "+hous+":00:00";
                   
                 if(outDate<planTime)
                 {
                
                 $.jBox.alert("完结时间必须大于计划时间。","提示");
                    return false;
                  }
            }
              var ckdDate =$("input[Name=rdData]:checked").val();
              var myMsg="";
              $.ajaxSetup({
               async:false
              });
            $.post('/Shop/VipTask/GetPulishNum',{taskCount:taskCount,taskTime:ckdDate },function(result){
            if(result!=null&&result!=""&&result!=''&&result!=' ')
            {
                myMsg=result;
            }
            });
            if(myMsg!="")
            {
               $.jBox.alert(myMsg,"提示");
               return false;
            }
          
        }

/*         //掌柜号搜索
        function shopChange() {
            window.location.href = "VipTaskOne?shopID=" + $("#selShopList").val() + "";
        }

        //商品查找
        function searchProduct() {
            var name = $("#ShortName").val();
            window.location.href = "VipTaskOne?shopID=" + $("#selShopList").val() + "&Name=" + name + "";
        } */

 window.onload=function(){  
    document.getElementsByTagName("body")[0].onkeydown =function(){  
        if(event.keyCode==8){  
        
            var elem = event.srcElement;  
            var name = elem.nodeName;  
              
            if(name!='INPUT' && name!='TEXTAREA'){  
                event.returnValue = false ;  
                return ;  
            }  
            var type_e = elem.type.toUpperCase();  
            if(name=='INPUT' && (type_e!='TEXT' && type_e!='TEXTAREA' && type_e!='PASSWORD' && type_e!='FILE')){  
                event.returnValue = false ;  
                return ;  
            }  
            if(name=='INPUT' && (elem.readOnly==true || elem.disabled ==true)){  
                event.returnValue = false ;  
                return ;  
            }  
           
        }  
    }  
}

 /*    function CheckStatus(id,status,isLock,IsBaseInfoComplete,IsTargetCustomerComplete,IsBuyBehaviour)
    {  
        $("#serviceValidation").remove();
        $("#clientValidationOL").html("");
        $("#clientValidation").hide();
        if(status!="正常")
        {
         if(IsBaseInfoComplete!="True")//未完善基础信息
         {
            var submit = function (v, h, f) {
                if (v == true) {
                    $("#serviceValidation").remove();
                    $("#clientValidationOL").html("");
                    $("#clientValidation").hide();
                if(isLock==true||isLock=="True"||isLock=="true")
                {
//                    $.jBox("iframe:/Shop/Product/EditImage?id="+id, {
//                        title: "编辑商品",
//                        width: 590,
//                        height: 580,
//                        top: 120,
//                        buttons: {},
//                        showScrolling:false,
//                        closed: function () {
//                        }
//                    });
                    window.location.href="/Shop/Product/EditImage?id="+id+"&type=publishtwo";
                  }
                    else
                    {
//                        $.jBox("iframe:/Shop/Product/EditProduct?id="+id, {
//                            title: "编辑商品",
//                            width: 590,
//                            height: 580,
//                            top: 120,
//                            buttons: {},                
//                            closed: function () {
//                            }
//                        });
                        window.location.href="/Shop/Product/EditProduct?id="+id+"&type=publishtwo";
                    }
                }
                else
                { }
                return true;
            };

            jBox.confirm("请先完善商品信息后，再发布任务，谢谢配合~", "提示", submit, { id: 'hahaha', showScrolling: true, buttons: { '现在完善': true, '稍后完善': false} });
         }
         if(IsBaseInfoComplete=="True"&&IsTargetCustomerComplete!="True") //完善了基础信息但未完善目标客户
         {  
             var submit = function (v, h, f) {
                if (v == true) {
                  window.location.href="/Shop/Product/TargetSet?productId="+id+"&type=publish";
                  }
                else
                { }
                return true;
            };
             jBox.confirm("请先完善目标客户信息后，再发布任务，谢谢配合~", "提示", submit, { id: 'hahaha', showScrolling: true, buttons: { '现在完善': true, '稍后完善': false} });
           
         }
            $("#"+id).attr("checked",false);
            $("input[name='ProductID']").attr("checked",false);
        }
       if(IsBuyBehaviour!="True")
       {
           var submit = function (v, h, f) {
                if (v == true) {
                  window.location.href="/Shop/Product/BuyNoBehavior?productId="+id+"&type=publish";
                  }
                else
                { }
                return true;
            };
             jBox.confirm("请先完善产品购买行为信息后，再发布任务，谢谢配合~", "提示", submit, { id: 'hahaha', showScrolling: true, buttons: { '现在完善': true, '稍后完善': false} });
       }
    } */
    </script>
<body>
    <?php require_once('include/nav.php')?>
    <!--daohang-->
    
    
<form action="#" id="fm" method="post">        
        <div class="sj-fprw" style="margin-bottom:0px;padding-bottom:0px;">
            <div class="tab1" style="font-size: 14px; font-family: 微软雅黑; margin-bottom: 20px;color:#222;">
                <div class="menu">
                    <ul>
                        <li class="off" onclick="javascript:window.location.href='<?=site_url('sales')?>'">发布任务</li>
                        <li onclick="javascript:window.location.href='<?=site_url('sales/task')?>'">发布管理</li>
                    </ul>
                </div>
           </div>
        </div>  
        <div class="middle mid-980 task_info" onkeyup="whichButton(event)">
                
            <div class="tit" id="divone">
                <b style="color: #0099FF">发布任务：第一步</b></div>
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
            <div class="errorbox" id="clientValidation" style="display: none; width: 360px;">
                <ol style="list-style-type: decimal" id="clientValidationOL">
                </ol>
            </div>
            <!--发布第一步 内容 end-->
            <!--表格内容-->
            <div class="fb_tbale" style="">
                <!--头部搜索-->
                <div class="fb_seach">
                    <div class="fb_secl">
                        <label style="float: left; display: block; margin-right: 5px;">
                            &nbsp;掌&nbsp;柜&nbsp;号：
                        </label>
                        <div class="select">
                        <!--  读取店铺数据 然后循环出来，这里不可使用的店铺不读取 -->
                            <select id="selShopList" name="ShopID" onchange="shopChange()" style="height:30px">
                                 <option selected="selected" value="98cf9150-7a07-4446-876a-2ce62bffb36b">淘宝sandyjack旗舰店</option>
                            </select>                            
                        </div>
                    </div>
                    <div class="fb_secc">
                        <span>商品查找：</span>
                        <label>
                            <input id="ShortName" name="ShortName" type="text" value="">
                             <a href="javascript:void(0)" class="icon_souw" onclick="searchProduct()"></a>
                        </label>
                    </div>
                    <div class="fb_secr">
                        <a id="add" href="<?=site_url('member/proadd')?>" target="_blank"> 商品添加</a>
                    </div>
                </div>
                <!--头部搜索 ends-->
                <!--表格-->
                <div class="tablescroll " style="margin: 20px auto;">
                    <table class="tablescroll_head fb_tbox" style="border-top-left-radius: 3px; border-top-right-radius: 3px;
                        display: block;">
                        <thead>
                            <tr>
                                <th class="th_1" style="background-color:#33cccc;width: 80px">选择</th>
                                <th class="th_2" style="background-color:#33cccc;width: 200px">简称</th>
                                <th class="th_2" style="background-color:#33cccc;width: 335px">商品名称</th>
                                <th class="th_3" style="background-color:#33cccc;width: 130px">商品状态</th>
                            </tr>
                        </thead>
                    </table>
                    <div class="tablescroll_wrapper" style="overflow-y: auto; overflow-x: hidden;">
                        <div class="tablescroll">
                            <div class="tablescroll_wrapper" style="width: 850px; height: auto; overflow-y: auto;
                                overflow-x: hidden;">
                                <div class="tablescroll"><div class="tablescroll_wrapper" style="width: 850px; height: auto; overflow-y: auto; overflow-x: hidden;"><table id="thetable" class="tablescroll_body fb_tbox fb_chekl" style="width: 850px;">
                                    <tbody>
                                        
                                            <tr class="first">
                                                <td class="th_1" style="width: 80px">
                                                    <input type="radio" name="ProductID" id="417d32a1-46af-4ea2-9911-abe08bd90ef1" value="417d32a1-46af-4ea2-9911-abe08bd90ef1" onclick="CheckStatus('417d32a1-46af-4ea2-9911-abe08bd90ef1','正常','True','True','True','True')">
                                                </td>
                                                <td class="th_2" style="width: 200px"> 豆腐包  </td>
                                                <td class="th_2" style="width: 335px">
                                                    <a title="SJ包包女2017新款潮明星同款单肩包韩版时尚百搭小方包真皮斜挎包" href="https://qqq.wkquan.com/Shop/Product/DetailsProduct/417d32a1-46af-4ea2-9911-abe08bd90ef1" target="_blank">SJ包包女2017新款潮明星同款单肩...</a>
                                                </td>
                                                <td class="th_3" style="width: 130px">正常</td>
                                            </tr>
                                            <tr class="first">
                                                <td class="th_1" style="width: 80px">
                                                    <input type="radio" name="ProductID" id="1149c149-59f5-4438-b7fb-f85c3a6a7aa1" value="1149c149-59f5-4438-b7fb-f85c3a6a7aa1" onclick="CheckStatus('1149c149-59f5-4438-b7fb-f85c3a6a7aa1','正常','True','True','True','True')">
                                                </td>
                                                <td class="th_2" style="width: 200px">   撞色包  </td>
                                                <td class="th_2" style="width: 335px">
                                                    <a title="出错啦！ - 天猫-网上商城 品牌正品 七天无理由退换货 提供发票 商城保障-天猫-上天猫，就购了" href="https://qqq.wkquan.com/Shop/Product/DetailsProduct/1149c149-59f5-4438-b7fb-f85c3a6a7aa1" target="_blank">出错啦！ - 天猫-网上商城 品牌正...</a>
                                                </td>
                                                <td class="th_3" style="width: 130px"> 正常</td>
                                            </tr>
                                            <tr class="first">
                                                <td class="th_1" style="width: 80px">
                                                    <input type="radio" name="ProductID" id="f59f7ef3-2acf-483c-9b1a-90934152ced1" value="f59f7ef3-2acf-483c-9b1a-90934152ced1" onclick="CheckStatus('f59f7ef3-2acf-483c-9b1a-90934152ced1','正常','True','True','True','True')">
                                                </td>
                                                <td class="th_2" style="width: 200px">  圆环包  </td>
                                                <td class="th_2" style="width: 335px">
                                                    <a title="包包女2017新款潮链条包小包时尚韩版单肩包女包简约百搭斜挎包女" href="https://qqq.wkquan.com/Shop/Product/DetailsProduct/f59f7ef3-2acf-483c-9b1a-90934152ced1" target="_blank">包包女2017新款潮链条包小包时尚韩...</a>
                                                </td>
                                                <td class="th_3" style="width: 130px">正常</td>
                                            </tr>
                                            <tr class="first">
                                                <td class="th_1" style="width: 80px">
                                                    <input type="radio" name="ProductID" id="bdc5c383-c38c-4b65-a533-835792c7a7b8" value="bdc5c383-c38c-4b65-a533-835792c7a7b8" onclick="CheckStatus('bdc5c383-c38c-4b65-a533-835792c7a7b8','正常','True','True','True','True')">
                                                </td>
                                                <td class="th_2" style="width: 200px">  糖果色包  </td>
                                                <td class="th_2" style="width: 335px">
                                                    <a title="包包女2017新款潮迷你手提包韩版单肩包简约链条真皮女包斜挎包" href="https://qqq.wkquan.com/Shop/Product/DetailsProduct/bdc5c383-c38c-4b65-a533-835792c7a7b8" target="_blank">包包女2017新款潮迷你手提包韩版单...</a>
                                                </td>
                                                <td class="th_3" style="width: 130px">正常</td>
                                            </tr>
                                            <tr class="first">
                                                <td class="th_1" style="width: 80px">
                                                    <input type="radio" name="ProductID" id="87ab9b6c-3caf-41fa-a767-7aeb64431d52" value="87ab9b6c-3caf-41fa-a767-7aeb64431d52" onclick="CheckStatus('87ab9b6c-3caf-41fa-a767-7aeb64431d52','正常','True','True','True','True')">
                                                </td>
                                                <td class="th_2" style="width: 200px"> 大圆环  </td>
                                                <td class="th_2" style="width: 335px">
                                                    <a title="包包女韩版2017新款潮真皮小方包马鞍包时尚百搭圆环包单肩斜挎包" href="https://qqq.wkquan.com/Shop/Product/DetailsProduct/87ab9b6c-3caf-41fa-a767-7aeb64431d52" target="_blank">包包女韩版2017新款潮真皮小方包马...</a>
                                                </td>
                                                <td class="th_3" style="width: 130px"> 正常</td>
                                            </tr>
                                    </tbody>
                                </table></div></div>
                            </div>
                        </div>
                        <center>
                        </center>
                    </div>
                    <div id="divInfo" style="display: none">
                        <center>
                                                                               温馨提示：<label class="red">该掌柜号未完善发货人信息,完善后才能选择商品。</label>
                        </center>
                    </div>
                    <!--任务类型-->
                    <div class="fb2_table" style="margin: 20px auto;">
                        <div class=" fb2_tbaletop">
                            <h3> 任务类型</h3>
                            <a href="javascript:void(0);" class="fb2_icswon"><i class="fb2_ictog"></i></a>
                        </div>
                        <table class="fb2_tbox fb2_rwlx ">
                            <thead>
                                <tr>
                                    <td>
                                        <input type="hidden" name="TaskType" value="0">PC端搜索
                                    </td>
                                    <td>
                                        <input type="hidden" name="TaskType" value="1"> 无线端搜索
                                    </td>
                                    <td>
                                        <input type="hidden" name="TaskType" value="2">无线二维码
                                    </td>
                                    <td>
                                        <input type="hidden" name="TaskType" value="3">促销类
                                    </td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr id="trTypeNum">
                                    <td>
                                        <input id="pc" name="TaskTypeCount" type="text" maxlength="3" value="0" onkeyup="value=value.replace(/[^0-9]/g,'')">
                                    </td>
                                    <td>
                                        <input id="tc" name="TaskTypeCount" type="text" maxlength="3" value="0" onkeyup="value=value.replace(/[^0-9]/g,'')">
                                    </td>
                                    <td>
                                        <input id="tm" name="TaskTypeCount" type="text" maxlength="3" value="0" onkeyup="value=value.replace(/[^0-9]/g,'')">
                                    </td>
                                    <td>
                                        <input id="cx" name="TaskTypeCount" type="text" maxlength="3" value="0" onkeyup="value=value.replace(/[^0-9]/g,'')">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="fb2_sphj">
                            <span class="sphj_l">任务合计：</span> <span class="sphj_r" id="taskCout">0</span>
                        </div>
                    </div>
                    <!--任务类型 END-->
                    <!--时间计划-->
                    <div class="fb2_table" style="margin: 20px auto;">
                        <div class=" fb2_tbaletop">
                            <h3>任务计划</h3>
                            <a href="javascript:void(0);" class="fb2_icswon"><i class="fb2_ictog"></i></a>
                            <br>
                            <span style="margin-left: 1px; position: absolute" id="LImsg"></span>
                        </div>
                        <table id="mytable" class="fb2_tbox fb2_rwlx fb2_rejh ">
                            <thead>
                                <tr>
                                    <td style="width: 98px;"> 日期</td>
                                        <input type="hidden" name="TaskPlanTime" value=" 2017/10/20 10:07:45"> 
                                        <td>
                                            10月20日
                                        </td>
                                        <input type="hidden" name="TaskPlanTime" value=" 2017/10/21 10:07:45"> 
                                        <td>
                                            10月21日
                                        </td>
                                        <input type="hidden" name="TaskPlanTime" value=" 2017/10/22 10:07:45"> 
                                        <td>
                                            10月22日
                                        </td>
                                        <input type="hidden" name="TaskPlanTime" value=" 2017/10/23 10:07:45"> 
                                        <td>
                                            10月23日
                                        </td>
                                        <input type="hidden" name="TaskPlanTime" value=" 2017/10/24 10:07:45"> 
                                        <td>
                                            10月24日
                                        </td>
                                        <input type="hidden" name="TaskPlanTime" value=" 2017/10/25 10:07:45"> 
                                        <td>
                                            10月25日
                                        </td>
                                        <input type="hidden" name="TaskPlanTime" value=" 2017/10/26 10:07:45"> 
                                        <td>
                                            10月26日
                                        </td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr id="trPlanNum" style="display: none">
                                    <td>数量</td>
                                    <td>
                                        <input type="text" id="num1" name="TaskPlanCount" placeholder="0" maxlength="3" onkeyup="value=value.replace(/[^0-9]/g,'')" value="0">
                                    </td>
                                    <td>
                                        <input type="text" id="num2" name="TaskPlanCount" placeholder="0" maxlength="3" onkeyup="value=value.replace(/[^0-9]/g,'')" value="0">
                                    </td>
                                    <td>
                                        <input type="text" id="num3" name="TaskPlanCount" placeholder="0" maxlength="3" onkeyup="value=value.replace(/[^0-9]/g,'')" value="0">
                                    </td>
                                    <td>
                                        <input type="text" id="num4" name="TaskPlanCount" placeholder="0" maxlength="3" onkeyup="value=value.replace(/[^0-9]/g,'')" value="0">
                                    </td>
                                    <td>
                                        <input type="text" id="num5" name="TaskPlanCount" placeholder="0" maxlength="3" onkeyup="value=value.replace(/[^0-9]/g,'')" value="0">
                                    </td>
                                    <td>
                                        <input type="text" id="num6" name="TaskPlanCount" placeholder="0" maxlength="3" onkeyup="value=value.replace(/[^0-9]/g,'')" value="0">
                                    </td>
                                    <td>
                                        <input type="text" id="num7" name="TaskPlanCount" placeholder="0" maxlength="3" onkeyup="value=value.replace(/[^0-9]/g,'')" value="0">
                                    </td>
                                </tr>
                                <tr id="trSeclect">
                                    <td>
                                    </td>
                                    <td>
                                        <input type="radio" name="rdData" checked="checked" value="1" disabled="disabled">
                                    </td>
                                    <td>
                                        <input type="radio" name="rdData" value="2" disabled="disabled">
                                    </td>
                                    <td>
                                        <input type="radio" name="rdData" value="3" disabled="disabled">
                                    </td>
                                    <td>
                                        <input type="radio" name="rdData" value="4" disabled="disabled">
                                    </td>
                                    <td>
                                        <input type="radio" name="rdData" value="5" disabled="disabled">
                                    </td>
                                    <td>
                                        <input type="radio" name="rdData" value="6" disabled="disabled">
                                    </td>
                                    <td>
                                        <input type="radio" name="rdData" value="7" disabled="disabled">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="fb2_sphj" style="margin-left: 55px; width: 95%">
                            <span>
                                <input type="checkbox" id="pTime">
                                <input type="hidden" id="IsEnableTaskPlans" name="IsEnableTaskPlan" value="False">发布时间计划</span>
                        </div>
                        <div>
                            <span style="margin-left: 0px">
                                <h5>
                                    <b style="color: Red">温馨提示:</b>如果不勾选发布时间计划,任务将全部即时发布;如果选择发布时间计划,任务将在计划的时间段内平均发布.</h5>
                            </span>
                        </div>
                    </div>
                    <!--时间计划 END-->
                    <!--时间点-->
                    <div class="fb2_table" id="divPlanTime" style="margin: 20px auto; display: none;">
                        <div class=" fb2_tbaletop">
                            <h3>任务展示</h3>
                            <a href="javascript:void(0);" class="fb2_icswon"><i class="fb2_ictog"></i></a>
                            <br>
                            <span style="margin-left: 1px; position: absolute" id="LImsg"></span>
                        </div>
                        <table id="mytable" class="fb2_tbox fb3_rwlx fb3_rejh ">
                            <thead>
                                <tr>
                                    <td>时间 </td>
                                    <td>
                                        0:00
                                    </td>
                                    <td>
                                        9:00
                                    </td>
                                     <td>
                                        10:30
                                    </td>
                                    <td>
                                        12:00
                                    </td>
                                       <td>
                                        13:30
                                    </td>
                                    <td>
                                        15:00
                                    </td>
                                    <td>
                                        16:30
                                    </td>
                                    <td>
                                        18:00
                                    </td>
                                    <td>
                                        19:30
                                    </td>
                                    <td>
                                        21:00
                                    </td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr id="trPlanTime">
                                    <td>数量</td>
                                    <td>
                                        <input type="text" name="TaskPlan0ClockCount" placeholder="0" maxlength="3" onkeyup="value=value.replace(/[^0-9]/g,'')" value="0">
                                    </td>
                                    <td>
                                        <input type="text" name="TaskPlan9ClockCount" placeholder="0" maxlength="3" onkeyup="value=value.replace(/[^0-9]/g,'')" value="0">
                                    </td>
                                    <td>
                                        <input type="text" name="TaskPlan1030ClockCount" placeholder="0" maxlength="3" onkeyup="value=value.replace(/[^0-9]/g,'')" value="0">
                                    </td>
                                    <td>
                                        <input type="text" name="TaskPlan12ClockCount" placeholder="0" maxlength="3" onkeyup="value=value.replace(/[^0-9]/g,'')" value="0">
                                    </td>
                                    <td>
                                        <input type="text" name="TaskPlan1330ClockCount" placeholder="0" maxlength="3" onkeyup="value=value.replace(/[^0-9]/g,'')" value="0">
                                    </td>
                                    <td>
                                        <input type="text" name="TaskPlan15ClockCount" placeholder="0" maxlength="3" onkeyup="value=value.replace(/[^0-9]/g,'')" value="0">
                                    </td>
                                    <td>
                                        <input type="text" name="TaskPlan1630ClockCount" placeholder="0" maxlength="3" onkeyup="value=value.replace(/[^0-9]/g,'')" value="0">
                                    </td>
                                    <td>
                                        <input type="text" name="TaskPlan18ClockCount" placeholder="0" maxlength="3" onkeyup="value=value.replace(/[^0-9]/g,'')" value="0">
                                    </td>
                                    <td>
                                        <input type="text" name="TaskPlan1930ClockCount" placeholder="0" maxlength="3" onkeyup="value=value.replace(/[^0-9]/g,'')" value="0">
                                    </td>
                                    <td>
                                        <input type="text" name="TaskPlan21ClockCount" placeholder="0" maxlength="3" onkeyup="value=value.replace(/[^0-9]/g,'')" value="0">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="fb2_sphj">
                            <span class="sphj_l">剩余可分配：</span> <span id="otherNum" class="sphj_r">0</span>
                        </div>
                    </div>
                    <div class="fb2_sphj" style="margin-left: 55px; width: 95%">
                        <span>
                            <input type="checkbox" id="pTimeOut">
                            <input type="hidden" id="TimeoutTime" name="IsEnableTaskPlan" value="False">超时自动取消
                       </span> 
                       <span style="margin-left: 20px; display:none" id="spTimedisplay">任务完结时间:
                            <input name="TimeoutTime" class="Wdate" ,="" style="width:150px;height:20px;" onfocus="WdatePicker({skin:'whyGreen',dateFmt:'yyyy-MM-dd HH:mm:ss'})">
                       </span>
                    </div>
                    <div>
                        <span style="margin-left: 0px">
                            <h5><b style="color: Red">温馨提示:</b>设置了超时自动取消功能的任务，在任务到结束时间并且任务状态为待接手时，任务将自动取消。</h5>
                        </span>
                    </div>
                    <!--时间点-END-->
                    <!--下一步-->
                    <input type="submit" id="btnsub" class="next_button" value="下一步" onclick="return Next();">
 
                    <!--下一步 END-->
                </div>
                <!--表格 END-->
            </div>
            <!--表格内容 END-->
        </div>
        <div id="load_content">
        </div>    
        <script src="<?=base_url()?>style/jquery.tablescroll.js" type="text/javascript"></script>
        <script src="<?=base_url()?>style/JScript1.js" type="text/javascript"></script>
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
        var loginName='<?=$info->Username?>';
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
</body>
</html>