<?php require_once('include/header.php')?> 
<?php 
    $xxpc = array();
    $xxphone = array();
    $n=0;$m=0;
    foreach($searchtype as $key=>$val){
       if($val==2 || $val==5 || $val==7){//获取到PC端的下标存到XXPC数组中去
            $xxpc[$n++] = $key;
       }else{//获取无线端的下标存到XXPHONE数组中去
            $xxphone[$m++] = $key;
       }
    }
    $pcnum=0; $phonenum=0;$all=0;
    foreach($xxpc as $pc){
        $pcnum += $KeyWordCount[$pc];
    }
    foreach($xxphone as $phone){
        $phonenum += $KeyWordCount[$phone];
    }
    $all=$pcnum+$phonenum;
?>    
    <script src="<?=base_url()?>style/md5.js" type="text/javascript"></script>
    <script src="<?=base_url()?>style/jquery.jBox-2.3.min.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>style/jbox.css">
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>style/index.css">
	<link type="text/css" rel="stylesheet" href="<?=base_url()?>style/laydate.css">
	<link type="text/css" rel="stylesheet" href="<?=base_url()?>style/laydate(1).css" id="LayDateSkin">
	<script src="<?=base_url()?>style/laydate.js"></script>
    <style type="text/css">
        .select1 {
            background: #ddd;
            border-color: #ddd;
        }
        
        .fpgl_w120 
        {
		    background: url(images/icon.png) no-repeat 100px center;
		    padding-left: 10px;
		    border-radius: 2px;
		    line-height: 22px;
		    width: 150px;
		    height: 34px;
		    margin: 0px 5px;
		    border: 1px solid #C6C6C6;
		    outline: 0;
		}
		
		.hide
		{
			display: none!important;
		}
    </style>
    <style type="text/css">
        caption, th
        {
            text-align: center;
        }
        .input_40
        {
            border: 1px solid #ddd;
            height: 24px;
            line-height: 14px;
            text-align: center;
            width: 40px;
        }
    </style>
    <script type="text/javascript">
    var rowCount = 1;  //行数默认1行  
    //添加行  
    function addRow() {
        rowCount++;
        var singleModelValue=$("input[name=IsSingleModel]:checked").val();
        if(rowCount>15)
        {
           $.openAlter("最多只能增加15个定价类型","提示");
           return false;
        }
        var isdisabled="";
        if(singleModelValue=="True")
        {
             isdisabled="disabled=\"disabled\"";
        }
        var newRow = '<tr id="option' + rowCount + '"><td ><input type="text" name="SingleProductPrice['+rowCount+']" date="SingleProductPrice" value="0" placeholder="0" maxlength="5"  onkeyup="clearNoNum(this)" class="input_60" /></td> <td><input type="text" name="ExpressCharge[]" date="ExpressCharge" class="input_60" value="0" placeholder="0" maxlength="5" onkeyup="clearNoNum(this)" /></td> <td><input type="text" maxlength="20" name="ProductModel[]" date="ProductModel" '+isdisabled+' class="input_60" /></td> <td><input type="text" name="BuyProductCount[]" date="BuyProductCount" value="1"  placeholder="1" onkeyup="value=value.replace(/[^0-9]/g,\'\')" class="input_60" /></td><td style="padding-top: 0px; padding-bottom: 0px;"><div style="height: 24px; margin-top: 8px;"><p class="left fprw-jg_4"><a href="javascript:void(0)"  id="imgReduce"><img src="../style/images/fprw-jg.png"></a></p><p class="left" style="margin-top:2px"><input type="text" name="ProductPriceListCount[]" date="ProductPriceListCount" value="0" placeholder="0" onkeyup="value=value.replace(/[^0-9]/g,\'\')" class="input_40" /></p><p class="left fprw-jg_5"><a href="javascript:void(0)"  id="imgAdd"><img src="../style/images/fprw-jg_2.png"></a></p></div></td><td style="display:none"><input type="checkbox" class="input-checkbox16" name="IsMobilePrices" /><input  type="hidden" class="input-checkbox16" name="IsMobilePrice"  value="Flase" /></td> <td>0</td><td>0</td><td>0</td><td>0</td><td><input type="button" class="input-butto100-zls" onclick=delRow(' + rowCount + ') value="删除"><input type="hidden" id="inputcomm' + rowCount + '" name="inputcomm[]" ></td></tr>';
        $('#optionContainer').append(newRow);
    }
    //删除行  
    function delRow(rowIndex) {
        $("#option" + rowIndex).remove();
        rowCount--;
    }
    var limit_price = <?=PLATFORM == 'esx' ? 2000 : 3000;?>,
    	wainingMsg="<div style='text-align:left'>为了控制货款资金风险，平台<em style='color:red'>不允许发布</em>货款金额<em style='color:red'>超过" + limit_price + "元</em>的任务。对于高成交金额的商品，若出现恶意退款，平台会协助追回，但<em  style=\"text-decoration:underline\">不承担赔付责任</em>。请知悉！</div>";
    	
    $(function () {
         $("input[date!=SingleProductPrice][date!=BuyProductCount],select,#imgReduce,#imgAdd").live("click onpaste input",function(){
          var singlePriceNum=0;
           $('input[date=SingleProductPrice]').each(function () {
                var priceValue = $(this).val();
                var pNum = $(this).parent().next().next().next().find("input[date='BuyProductCount']").val();
                if(parseFloat(priceValue * pNum).toFixed(2)>=limit_price)
               {
                 singlePriceNum++;
               }
          });
              if (singlePriceNum > 0) {
                             $.openAlter(wainingMsg,"提示",null,null,"好的");
                return false;
            }
         })
         $("input[date=ExpressCharge]").live("keyup onpaste input", function () {
                var c = $(this);
                if (/[^\d.]/g.test(c.val())) {//替换非数字字符  
                    var temp_amount = c.val().replace(/[^\d]/g, '');
                    $(this).val(temp_amount);
                }
             
            })
        //色块切换效果
        $(".fprw-rwlx li").click(function () 
        {
            $(".fprw-rwlx li").eq($(this).index()).addClass("cur").siblings().removeClass("cur");
        })

        //单一价格时指定型号不可用
        $("input[name=IsSingleModel]").click(function () {
           // alert($(this).val());
            if ($(this).val() == 1) {
                $("input[date=ProductModel]").attr("disabled", true);
                $("input[date=ProductModel]").val("");
            }
            else
                $("input[date=ProductModel]").removeAttr("disabled");
        });
        //根据商品价格计算单任务成交金额和单任务佣金
        $("input[date=SingleProductPrice]").live("keyup blur", function () {
            var priceValue = $(this).val();
            var expressValue =0;
            var pNum = $(this).parent().next().next().next().find("input[date='BuyProductCount']").val();
             expressValue = $(this).parent().next().find("input[date='ExpressCharge']").val();

            $(this).parent().next().next().next().next().next().next().text(parseFloat(priceValue * pNum).toFixed(2));//单任务成交金额 
          
            if (priceValue > 0) {
                 priceValue=parseFloat(priceValue*pNum)+parseFloat(expressValue);
                $(this).parent().next().next().next().next().next().next().next().text(GetPricePoint(priceValue)); //单任务佣金
                $("#inputcomm"+$(this).parent().parent().attr('id').replace(/option/,'')).val(GetPricePoint(priceValue));
                //alert($(this).parent().parent().attr('id').replace('inputcomm',''));
            }
              if(parseFloat($(this).val() * pNum).toFixed(2)>=limit_price)
              {
                $.openAlter(wainingMsg,"提示",null,null,"好的");
              }
        });

            //根据快递费用计算单任务快递费和快递费总金额 
        $("input[date=ExpressCharge]").live("keyup", function () {
             var expressValue =0;
             var priceValue =0;
             var pNum=0;
             if ($(this).val() != " " && $(this).val() != "" && $(this).val() != null)
            { expressValue = $(this).val() }
             $(this).parent().next().next().next().next().next().next().next().text(parseFloat(expressValue).toFixed(2));//单任务快递费用

              pNum = $(this).parent().next().next().find("input[date='BuyProductCount']").val();
              priceValue = $(this).parent().prev().find("input[date='SingleProductPrice']").val();
              priceValue=parseFloat(priceValue*pNum)+parseFloat(expressValue);
             $(this).parent().next().next().next().next().next().next().text(GetPricePoint(priceValue)); //单任务佣金
           //  alert( GetPricePoint(priceValue) );
             //$(this).parent().next().next().next().next().next().next().next().text(GetPricePoint(priceValue)); //单任务佣金
            $("#inputcomm"+$(this).parent().parent().attr('id').replace('option','')).val(GetPricePoint(priceValue));
         
        });

        //根据拍下件数计算单任务成交金额
        $("input[date=BuyProductCount]").live("keyup blur", function () {
            var expressValue =0;
            var pNum = $(this).val();
            var priceValue = $(this).parent().prev().prev().prev().find("input[date='SingleProductPrice']").val();
             expressValue = $(this).parent().prev().prev().find("input[date=ExpressCharge]").val();
            $(this).parent().next().next().next().text(parseFloat(priceValue * pNum).toFixed(2));
             priceValue=parseFloat(priceValue*pNum)+parseFloat(expressValue);
            $(this).parent().next().next().next().next().text(parseFloat(GetPricePoint(priceValue)).toFixed(2));
            $("#inputcomm"+$(this).parent().parent().attr('id').replace('option','')).val(GetPricePoint(priceValue));


             var sngleProductPrice = $(this).parent().prev().prev().prev().find("input[date=SingleProductPrice]").val();
             if(parseFloat(sngleProductPrice * pNum).toFixed(2)>=limit_price)
              {
                $.openAlter(wainingMsg,"提示",null,null,"好的");
              }
        });
        $("input[date=ProductPriceListCount]").live("input", function () {
                var useTaskCount=0;
                $('input[date=ProductPriceListCount]').each(function () {
                    var inputNum =$.trim($(this).val());
                    useTaskCount += parseInt(inputNum);
                });
                all='<?=$all?>';
                if(parseInt(useTaskCount)>parseInt(all))
                {
                    $.openAlter("发布任务第一步所设置的任务数量为<label style='color:Red;font-weight:bold;'>"+all+"</label>。<br />该处设置的任务总数必须与之相等。","提示");
                    $(this).val('0');
                }
        });
        //根据任务数量计算合计金额
        $("input[date=ProductPriceListCount]").live("keyup", function () {
            var taskNum = 0;
            if ($(this).val() != " " && $(this).val() != "" && $(this).val() != null)
            { 
                taskNum = parseInt($(this).val()); 
            }
            var priceValue = parseFloat($(this).parent().parent().parent().next().next().text());
            var point = parseFloat($(this).parent().parent().parent().next().next().next().text());
           var expressValue = parseFloat($(this).parent().parent().parent().next().next().next().next().text());
            $(this).parent().parent().parent().next().next().next().next().next().text(parseFloat(parseFloat(priceValue + point+expressValue) * taskNum).toFixed(2));
        });
        //增加任务数
        $("#imgAdd").live("click",function(){
             var taskNum=parseInt($(this).parent().prev().children().val());
             $(this).parent().prev().children().val(taskNum+1);
                    var useTaskCount=0;
                    $('input[date=ProductPriceListCount]').each(function () {
                        var inputNum =$.trim($(this).val());
                        useTaskCount += parseInt(inputNum);
                    });
                    all='<?=$all?>';
                    if(parseInt(useTaskCount)>parseInt(all))
                    {
                        $.openAlter("发布任务第一步所设置的任务数量为<label style='color:Red;font-weight:bold;'>"+all+"</label>。<br />该处设置的任务总数必须与之相等。","提示");
                        $(this).parent().prev().children().val("0");
                    }
        });
         //减少任务数
        $("#imgReduce").live("click",function(){
         var taskNum=parseInt($(this).parent().next().children().val());
         if(taskNum>0)
         {
         $(this).parent().next().children().val(taskNum-1);
         }
        });
 
        //计算总金额和佣金
        $("#optionContainer,.input-butto100-zls").live("keyup  click", function () {
            var totalPrice = 0; //成交总金额
            var totalPoint = 0; //佣金总金额
            var totalExpress = 0; //快递费总额
            var totalCount = 0; //合计
            var taskNumCount = 0; //已分配任务数量
            var taskAppCount = 0; //已分配App任务数量
            $('input[date=SingleProductPrice]').each(function () {
                var priceValue = $(this).val();
                var pNum = $(this).parent().next().next().next().find("input[date=BuyProductCount]").val();
                var taskNum = $(this).parent().next().next().next().next().find("input[date=ProductPriceListCount]").val();
                var express=$(this).parent().next().find("input[date=ExpressCharge]").val();
                totalPrice +=parseFloat(priceValue * pNum*taskNum);
                totalPoint += parseFloat(GetPricePoint(parseFloat(priceValue*pNum)+parseFloat(express))*taskNum);
                totalExpress+=parseFloat(express *taskNum);
            });
         
            $('input[date=ProductPriceListCount]').each(function () {
                var taskNum = 0;
                if ($(this).val() != " " && $(this).val() != "" && $(this).val() != null) {
                    taskNum = parseInt($(this).val());
                    taskNumCount += taskNum;
                }
                var priceValue = parseFloat($(this).parent().next().next().text());
                var point = parseFloat($(this).parent().next().next().next().text());
                var expressValue = parseFloat($(this).parent().next().next().next().next().text());
                $(this).parent().parent().parent().next().next().next().next().next().text(parseFloat(parseFloat(priceValue + point+expressValue) * taskNum).toFixed(2));
                totalCount += parseFloat(priceValue + point+expressValue) * taskNum;
            });
             $('input[name=IsMobilePrices]').each(function () {
               var taskAppNum=0;
               if($(this).attr("checked"))
                {
                    $(this).next().val("True");
                     var tasks=$(this).parent().prev().children().children().find("input[date='ProductPriceListCount']").val();
                     if (tasks != " " && tasks != "" && tasks!= null) {
                     taskAppNum =parseInt(tasks);  
                     taskAppCount+=taskAppNum;
                     }
                }
                else {
                    $(this).next().val("False");
                }
            });
            
            $("#spTotalPrice").text(totalPrice.toFixed(2));
            $("#spTotalPoint").text(totalPoint.toFixed(2));
            $("#spTotalCount").text(totalCount.toFixed(2));
            $("#spTotalExpress").text(totalExpress.toFixed(2));
            var TaskCount="<?=$all?>";     
            var TaskAppCount="<?=$phonenum?>";     
             $("#taskNum").text(TaskCount-taskNumCount); //计算未分配的剩余任务数量
            $("#taskAppNum").text(TaskAppCount-taskAppCount); //计算未分配的剩余App任务数量
        });
        //文本框输入限制
        $("input[date=SingleProductPrice],input[date=BuyProductCount],input[date=ProductPriceListCount],input[date=TaskPlanCount],input[date=ExpressCharge]").live("focus", function () {
            if ($(this).val() < 1) {
                $(this).val(" ");
            }
        });
        $("input[date=SingleProductPrice],input[date=BuyProductCount],input[date=ProductPriceListCount],input[date=TaskPlanCount]").live("focusout", function () {
            if ($(this).val() < 1) {
                $(this).val(0);
            }
        });
          $("input[date=ExpressCharge]").live("focusout", function () {
            if ($(this).val() <=0) {
                $(this).val(0);
            }
        });
        //计算发布时间分配剩余任务数量
          vipTime();
    })

    //发布时间操作
    function vipTime()
    {
        //增加任务数
        $("#timeimgAdd").live("click",function(){
         if($("input[name=TaskPlanType]:checked").val()!="2")
         { return false; }
          var txt=($(this).parent().parent().parent().prev().text());
          if(txt.indexOf('已过期')!=-1||txt.indexOf('将过期')!=-1)
          {   return false;  }
         var taskNum=parseInt($(this).parent().prev().children().val());
         var taskCount=0;
         if(parseInt($("#taskNum2").html())>0)
         {
            $(this).parent().prev().children().val(taskNum+1);
         }else{
        	 $.openAlter('所剩余任务数量不足',"提示",null,null,"好的");
         }
         $('input[date=TaskPlanCount]').each(function () {
                var num = $(this).val();
                taskCount += parseInt(num);
            });
            $("#taskNum2").text('<?=$all?>'-taskCount);
        });
         //减少任务数
        $("#timeimgReduce").live("click",function(){
         if($("input[name=TaskPlanType]:checked").val()!="2")
         { return false; }
          var txt=($(this).parent().parent().parent().prev().text());
          if(txt.indexOf('已过期')!=-1||txt.indexOf('将过期')!=-1)
          {   return false;  }
         var taskNum=parseInt($(this).parent().next().children().val());
         var taskCount=0;
         if(taskNum>0)
         {
      	   $(this).parent().next().children().val(taskNum-1);
         }else{
        	 $.openAlter('任务数量不能为负数',"提示",null,null,"好的");
         }
           $('input[date=TaskPlanCount]').each(function () {
                var num = $(this).val();
                taskCount += parseInt(num);
            });
            $("#taskNum2").text('<?=$all?>'-taskCount);
        });
        $("input[date=TaskPlanCount]").live("keyup",function(){
          var taskCount=0;
          $('input[date=TaskPlanCount]').each(function () {
                var num = $(this).val();
                if(num=="")
                {
                num=0;
                }
                taskCount += parseInt(num);
            });
            $("#taskNum2").text('<?=$all?>'-taskCount);
        });

        //选择发布类型
         colseInput();    
        $("#optionContainer1 tr:eq(1) td:eq(2)").children().removeAttr("disabled").removeClass("select1");    
        $("#optionContainer1 tr:eq(1) td:eq(3)").children().removeAttr("disabled").removeClass("select1");  
        $("#optionContainer1 tr:eq(1) td:eq(4)").children().removeAttr("disabled").removeClass("select1"); 
        $("input[name=TaskPlanType]").click(function(){
        var singlePriceNum=0;
        	//按关键词对应的数量分开显示
        	<?php
    			foreach($KeyWordCount as $k =>$v)
    			{
    				echo "$('input[date=TaskPlanCount]').eq($k).val($v);";
    			}
			?>
           $('input[date=SingleProductPrice]').each(function () {
                var priceValue = $(this).val();
                var pNum = $(this).parent().next().next().next().find("input[date='BuyProductCount']").val();
                if(parseFloat(priceValue * pNum).toFixed(2)>=limit_price)
               {
                 singlePriceNum++;
               }
          });
              if (singlePriceNum > 0) {
                             $.openAlter(wainingMsg,"提示",null,null,"好的");
                return false;
            }

           $("#setTimes").hide();
           if($(this).val()=="0")
           { 
           	$('.set_time').not(':first').addClass('hide');
                colseInput();    
                $("#optionContainer1 tr:eq(1) td:eq(4)").children().removeAttr("disabled").removeClass("select1");
                $("#                                            ,#timeimgReduce").removeClass("a1").addClass("a2").removeAttr("href");
           }else if($(this).val()=="1"){
                colseInput();
                $('.set_time').not(':first').addClass('hide');
                $("#optionContainer1 tr:eq(1) td:eq(2)").children().removeAttr("disabled").removeClass("select1");    
                $("#optionContainer1 tr:eq(1) td:eq(3)").children().removeAttr("disabled").removeClass("select1");    
                $("#optionContainer1 tr:eq(1) td:eq(4)").children().removeAttr("disabled").removeClass("select1");
                $("#timeimgAdd,#timeimgReduce").removeClass("a1").addClass("a2").removeAttr("href");
//             $("select").removeClass("select1");
           } else if($(this).val()=="2"){
           	   $('.set_time').removeClass('hide');
               $("#timeimgAdd").show();
                  $("#setTimes").show();
                     $("#timeimgAdd,#timeimgReduce").removeClass("a2").addClass("a1").attr("href","javascript:void(0)"); 
                  openInput();
                   $("select").removeClass("select1");
            
           }
        }); 
        $("#setTimes").click(function(){
            var taskCount='1';
            var taskNum2=parseInt($("#taskNum2").text());
            if(taskNum2==taskCount)
            {
               $.openAlter("任务数不能为0，请设置完毕后再点击该按钮批量设置任务的起止时间","提示");
                return false;
            }
            if(parseInt($("#taskNum2").text())!=0)
            {
              $.openAlter("设置的任务数总和必须等于任务总数", "提示");
                 return false;
            }  
               //     $.openNewConfirmHtml($("#light1").html(),"一键设置时间",{width: 700, height: 600},function(){SetTime()},"确认提交",null,"返回修改");
                $("#fade").height($(document).height());
                var scrollH = $(document).scrollTop();
                var scrollL = $(document).scrollLeft();
                var topVal = ($(window).height() - 300) / 2 + scrollH;
                var leftVal = ($(window).width() - 600) / 2 + scrollL;
                 $("#light1").css("top",topVal);
                 $("#light1").css("left",leftVal);
                 document.getElementById('light1').style.display = 'block'; document.getElementById('fade').style.display = 'block';
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
    function SetTime()
    { 
       var vBeginHour=$("#optionContainer2 tr:eq(1) td:eq(0)").find("select:eq(0)").val();
       var vBeginMine=$("#optionContainer2 tr:eq(1) td:eq(0)").find("select:eq(1)").val();
       var vEndHour=$("#optionContainer2 tr:eq(1) td:eq(1)").find("select:eq(0)").val();
       var vEndMine=$("#optionContainer2 tr:eq(1) td:eq(1)").find("select:eq(1)").val();
       var vOverHour=$("#optionContainer2 tr:eq(1) td:eq(2)").find("select:eq(0)").val();
       var vOverMine=$("#optionContainer2 tr:eq(1) td:eq(2)").find("select:eq(1)").val();
       var BeginTime=vBeginHour+":"+vBeginMine;
       var EndTime=vEndHour+":"+vEndMine;
       var OverTime=vOverHour+":"+vOverMine;
        if(vBeginHour==''||vBeginMine==''||vEndHour==''||vEndMine=='')
            {
              $.openAlter("开始时间和结束时间不能为空", "提示");
                return false;
            }
            if(BeginTime>=EndTime)
            {
              $.openAlter("结束时间必须大于开始时间", "提示");
                return false;
            }
            if(EndTime>=OverTime)
            {
               $.openAlter("超时取消时间必须大于结束时间", "提示");
                return false;
            }
            var cDate = new Date();
            var cHour=cDate.getHours();
            var cMime=cDate.getMinutes();
            var indexs=0;
           if(cHour<10)
           {
              cHour="0"+cHour;
           }
           if(cMime<10)
           {
              cMime="0"+cMime;
           }
           var cTime=cHour+":"+cMime;
   
           $('input[date=TaskPlanCount]').each(function () {
                 if($(this).val()>0)
                 {
                if(indexs==0&&EndTime<=cTime)
                {
                  $(this).parent().parent().parent().next().find("select:eq(0)").val("");
                  $(this).parent().parent().parent().next().find("select:eq(1)").val("");
                  $(this).parent().parent().parent().next().next().find("select:eq(0)").val("");
                  $(this).parent().parent().parent().next().next().find("select:eq(1)").val("");
                  $(this).parent().parent().parent().next().next().next().find("select:eq(0)").val("");
                  $(this).parent().parent().parent().next().next().next().find("select:eq(1)").val("");
                }
                else if(indexs==0&&BeginTime<=cTime)
                {
                  if(cMime>0&&cMime<=15)
                  {
                    cMime=45
                  }
                  else if(cMime>15&&cMime<=30)
                  {  cHour=parseInt(cHour)+1;
                     cMime="00";
                  }
                  else if(cMime>30&&cMime<=45)
                  {   cHour=parseInt(cHour)+1;
                     cMime=15;
                  }
                   else if(cMime>45)
                  { 
                     cHour=parseInt(cHour)+1;
                     cMime=30;
                  }
                  $(this).parent().parent().parent().next().find("select:eq(0)").val(cHour);
                  $(this).parent().parent().parent().next().find("select:eq(1)").val(cMime);

                  $(this).parent().parent().parent().next().next().find("select:eq(0)").val(vEndHour);
                  $(this).parent().parent().parent().next().next().find("select:eq(1)").val(vEndMine);
                  $(this).parent().parent().parent().next().next().next().find("select:eq(0)").val(vOverHour);
                  $(this).parent().parent().parent().next().next().next().find("select:eq(1)").val(vOverMine);
                } else{
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
    function  colseInput()
    {
//   $("input[date=TaskPlanCount]").attr("disabled", true);
     $("input[name=IsTimeoutTime]").attr("disabled", true);
     $("select").not('.sel_action').attr("disabled", true);
     $("select").not('.sel_action').addClass("select1");
     $("input[date=TaskPlanCount]").val(0);
     $("input[name=IsTimeoutTime]").attr("checked", false);
     $("select").val(0);
      $("#taskNum2").text(0);
      $("#optionContainer1 tr:eq(1) td:eq(1)").children().children().children("input").val('<?=$all?>');    
    }
     //启用发布时间下的所有输入框
    function  openInput()
    {
//     $("input[date=TaskPlanCount]").removeAttr("disabled");
       $("input[name=IsTimeoutTime]").removeAttr("disabled");
       $("select").removeAttr("disabled");
       $("#optionContainer1 tr").each(function(){
          var txt=$(this).find("td").eq(0).text();
          if(txt.indexOf('已过期')!=-1||txt.indexOf('将过期')!=-1)
          {
            $(this).find("select,input[date=TaskPlanCount]").attr("disabled", true);
            $(this).find("a").removeClass("a1").addClass("a2").removeAttr("href");
          }
       })
    }
    function clearNoNum(obj) 
	{
	    var patt;
	    //先把非数字的都替换掉，除了数字和.
	    obj.value = obj.value.replace(/[^\d.]/g, "");
	    //必须保证第一个为数字而不是.
	    obj.value = obj.value.replace(/^\./g, "");
	    //保证只有出现一个.而没有多个.
	    obj.value = obj.value.replace(/\.{2,}/g, ".");
	    //保证.只出现一次，而不能出现两次以上
	    obj.value = obj.value.replace(".", "$#$").replace(/\./g, "").replace("$#$", ".");
	    //只能输入小数点后两位
	    obj.value = obj.value.replace(/^(\-)*(\d+)\.(\d\d).*$/, '$1$2.$3');
	    //去掉前面的0
	    obj.value = obj.value.replace(/\b(0+)/gi, "");
	}
    function sortNumber(a,b)
    {
        return  b-a
    }
    function bubbleSort(arr) {
        var i = arr.length, j;
        var tempExchangVal;
        while (i > 0) {
            for (j = 0; j < i - 1; j++) {
                if (arr[j] > arr[j + 1]) {
                    tempExchangVal = arr[j];
                    arr[j] = arr[j + 1];
                    arr[j + 1] = tempExchangVal;
                }
            }
            i--;
        }
        return arr;
    }
    //获得商家任务佣金
    function GetPricePoint(price)
    {  
        var point=0;

        var priceinfo = "<?=$arr?>";
        var pricearr = priceinfo.split("|");

        arrprice =new Array();
        arrpoint =new Array();
        var obj = new Array();
        for(i=0;i<pricearr.length;i++){
            strmenoy = '';    
            arrprice[i]=pricearr[i].substring(0,pricearr[i].indexOf('='));
            obj[pricearr[i].substring(pricearr[i].indexOf('=')+1)]=pricearr[i].substring(0,pricearr[i].indexOf('='));
        }
        arrprice=arrprice.sort(sortNumber);
        var newobj= new Array; var ii=0;
      	for(m=0;m<arrprice.length;m++){
      	    for(variable in obj){
      	    	if(obj[variable] == arrprice[m]){
      	           arrpoint[ii++]=variable;  
      	    	}        	
            }	 
    	}
        for(k=0;k<arrprice.length;k++){ 
           if(price < arrprice[k]){
              point=arrpoint[k];
           }   
           //alert(arrpoint[k]);  
        }      
        if(price >= arrprice[0]){
        	point=arrpoint[0];
        }
        if(price < arrprice[arrprice.length-1]){
        	point=arrpoint[arrprice.length-1];
        }       

        return point;
    }
         //提交表单到下一步
        
    </script>

<body style="background: #fff;">
    <?php require_once('include/nav.php')?>
    
    <!--daohang-->  
    
<form action="<?=site_url('sales/taskStepTwo')?>" id="frm" method="post">
    
        <div id="light1" class="ycgl_tc yctc_1200" style="width: 600px; height: 300px;">
            <!--标题 -->
            <div class="htyg_tc">
                <ul>
                    <li class="htyg_tc_1">
                        <center style="margin-left: 225px">一键设置时间</center>
                    </li>
                    <li class="htyg_tc_2"><a href="javascript:void(0)" id="aColse" onclick="document.getElementById('light1').style.display='none';document.getElementById('fade').style.display='none'">
                        <img src="<?=base_url()?>style/images/sj-tc.png"></a> </li>
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
                            <table id="optionContainer2">
                                <tbody><tr>
                                    <th width="231">开始平均发布时间</th>
                                    <th width="231">结束平均发布时间</th>
                                    <th width="231">超时取消时间 (选填)</th>
                                </tr>
                                <tr>
                                    <td>
                                        <select disabled="disabled" class="select1">
                                            <option></option>
                                            <option>00</option>
                                            <option>01</option>
                                            <option>02</option>
                                            <option>03</option>
                                            <option>04</option>
                                            <option>05</option>
                                            <option>06</option>
                                            <option>07</option>
                                            <option>08</option>
                                            <option>09</option>
                                            <option>10</option>
                                            <option>11</option>
                                            <option>12</option>
                                            <option>13</option>
                                            <option>14</option>
                                            <option>15</option>
                                            <option>16</option>
                                            <option>17</option>
                                            <option>18</option>
                                            <option>19</option>
                                            <option>20</option>
                                            <option>21</option>
                                            <option>22</option>
                                            <option>23</option>
                                        </select> ：
                                        <select id="selBeginTimeM" disabled="disabled" class="select1"><option></option>
                                            <option>00</option>
                                            <option>15</option>
                                            <option>30</option>
                                            <option>45</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select id="selEndTimeH" disabled="disabled" class="select1"><option></option><option>00</option><option>01</option><option>02</option><option>03</option><option>04</option><option>05</option><option>06</option><option>07</option><option>08</option><option>09</option><option>10</option><option>11</option><option>12</option><option>13</option><option>14</option><option>15</option><option>16</option><option>17</option><option>18</option><option>19</option><option>20</option><option>21</option><option>22</option><option>23</option>
                                        </select>
                                        ：
                                        <select id="selEndTimeM" disabled="disabled" class="select1">
                                            <option></option>
                                            <option>00</option>
                                            <option>15</option>
                                            <option>30</option>
                                            <option>45</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select id="selOverTimeH" disabled="disabled" class="select1"><option></option><option>00</option><option>01</option><option>02</option><option>03</option><option>04</option><option>05</option><option>06</option><option>07</option><option>08</option><option>09</option><option>10</option><option>11</option><option>12</option><option>13</option><option>14</option><option>15</option><option>16</option><option>17</option><option>18</option><option>19</option><option>20</option><option>21</option><option>22</option><option>23</option>
                                        </select>
                                        ：
                                        <select id="selOverTimeM" disabled="disabled" class="select1">
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
                                    <input class="input-butto100-ls" type="button" value="返回修改" onclick="document.getElementById('light1').style.display='none';document.getElementById('fade').style.display='none'"></p>
                            </li>
                        </ul>
                    </div>
                </center>
            </div>
            <!--滚动内容 -->
        </div>
        <div id="fade" class="black_overlay">
        </div>
        <!-- 内容-->  
        <div class="sj-fprw">
            <!--<div class="tab1" id="tab1">
                <div class="menu">
                    <ul>
                        <li id="one2" class="off" onclick="location.href='<?=site_url('sales')?>'">发布任务</li>
                        <li id="one1" onclick="location.href='<?=site_url('sales/task')?>'">任务管理</li>
                    </ul>
                </div>
            </div>-->
            <!-- 切换-->
            <div class="fprw_qh" style="margin-top: 20px">
                <ul>
                    <li class="fprw_qhys">第一步：来路设置</li>
                    <li class="fprw_qhys">第二步：价格和发布时间</li>
                    <li>第三步：快递和备注</li>
                </ul>
            </div>
            <!-- 切换-->
            <!-- 标题-->
            <div class="fprw-zpt">
                <div class="left fprw-jg">
                    <p class="fprw-jg_1">定价类型</p>
                    <p class="fprw-jg_2"><input class="input-radio16" type="radio" style="height: 15px" name="IsSingleModel" checked="checked" value="1"></p>
                    <p>单型号价格</p>
                    <p class="fprw-jg_3"><input class="input-radio16" style="height: 15px" type="radio" name="IsSingleModel" value="2"></p>
                    <p>多型号多价格</p>
                </div>
                <div class="right">
                    <span class="fprw-pt-xts_1">任务总数：<em class="cff3430"><?=$all?></em> </span>
                    <span class="fprw-pt-xts_1">PC端：<em class="cff3430"><?=$pcnum?></em> </span><span class="fprw-pt-xts_1">无线端：<em class="cff3430"><?=$phonenum?></em> </span><span>
                        <!--<input type="button" class="input-butto100-zls" onclick="addRow()" value="新增">-->
                    </span>
                </div>
            </div>
            <!-- 标题-->
            <!-- 表格-->
            <div class="fprw-pg" style="margin-top: 0px;">
                <table id="optionContainer">
                    <tbody><tr>
                        <th width="80">商品单价 </th>
                        <th width="105">
                           <p class="sk-zjgl_4" style="width: 95px;">快递费(选填)</p>
                        </th>
                        <th width="80"> 指定型号</th>
                        <th width="80"> 拍下件数</th>
                        <th width="120"> 任务数量(<span id="taskNum"><?=$all?></span>)</th>
                        <th width="80" style="display: none"> 手机专享价(<span id="taskAppNum"><?=$phonenum?></span>)</th>
                        <th width="120"> 单任务成交金额</th>
                        <th width="80">单任务佣金</th>
                        <th width="100">单任务快递费</th>
                        <th width="80">合计</th>
                        <th width="80">操作</th>
                    </tr>
                    <tr id="option0">
                        <td>
                            <input type="text" name="SingleProductPrice[]" date="SingleProductPrice" class="input_60" value="0" placeholder="0" onkeyup="clearNoNum(this)">
                        </td>
                        <td>
                            <input type="text" name="ExpressCharge[]" date="ExpressCharge" class="input_60" value="0" placeholder="0" maxlength="5" onkeyup="clearNoNum(this)">
                        </td>
                        <td>
                            <input type="text" maxlength="20" name="ProductModel[]" date="ProductModel" disabled="disabled" class="input_60">
                        </td>
                        <td>
                            <input type="text" name="BuyProductCount[]" date="BuyProductCount" value="1" placeholder="1" onkeyup="clearNoNum(this)" class="input_60">
                        </td>
                        <td>
                            <input type="text" name="ProductPriceListCount[]" date="ProductPriceListCount" readonly="readonly" placeholder="0" onkeyup="clearNoNum(this)" class="input_40" value="<?=$all?>"></p>
                        </td>
                        <!--<td style="padding-top: 0px; padding-bottom: 0px;">
                            <div style="height: 24px; margin-top: 8px;">
                                <p class="left fprw-jg_4">
                                    <a href="javascript:void(0)" id="imgReduce">
                                        <img src="<?=base_url()?>style/images/fprw-jg.png"></a></p>
                                <p class="left" style="margin-top: 2px">
                                    <input type="text" name="ProductPriceListCount[]" date="ProductPriceListCount" placeholder="0" onkeyup="value=value.replace(/[^0-9]/g,'')" class="input_40" value="<?=$all?>"></p>
                                <p class="left fprw-jg_5">
                                    <a href="javascript:void(0)" id="imgAdd">
                                        <img src="<?=base_url()?>style/images/fprw-jg_2.png"></a>
                                </p>
                            </div>
                        </td>-->
                        <td style="display: none">
                            <input type="checkbox" class="input-checkbox16" name="IsMobilePrices" value="Flase">
                            <input type="hidden" class="input-checkbox16" name="IsMobilePrice" value="False">
                        </td>
                        <td>0.00</td>
                        <td>0.00</td>
                        <td>0</td>
                        <td>0.00</td>
                        <td>
                            <input type="hidden" id="inputcomm0" name="inputcomm[]" >
                        </td>
                    </tr>
                </tbody></table>
                <div class="fprw-jg_6">
                    <ul>
                        <li style="width: 250px;">成交总金额：<span id="spTotalPrice">0.00</span>元</li>
                        <li style="width: 250px;">佣金总金额：<span id="spTotalPoint">0.00</span>元</li>
                        <li style="width: 250px;">快递费总金额 ：<span id="spTotalExpress">0.00</span>元</li>
                        <li style="width: 250px;">合计：<span id="spTotalCount">0.00</span>元</li>
                    </ul>
                </div>
            </div>
            <!-- 表格-->
            <!-- 标题-->
            <div class="fprw-zpt">
                <div class="left fprw-jg">
                    <p class="fprw-jg_1">发布时间</p>
                    <p class="fprw-jg_2"><input class="input-radio16" style="height: 15px" type="radio" name="TaskPlanType" value="0"></p>
                    <p>立即发布</p>
                    <p class="fprw-jg_3"><input class="input-radio16" style="height: 15px" type="radio" name="TaskPlanType" value="1" checked="checked"></p>
                    <p>今天平均发布</p>
                    <?php if(count($SearchKey) > 1):?>
	                    <p class="fprw-jg_3"><input class="input-radio16" style="height: 15px" type="radio" name="TaskPlanType" value="2"></p>
	                    <p>多天平均发布</p>
	                    <input type="button" id="setTimes" style="width: 100px; height: 28px; line-height: 28px;display: none" class="input-butto100-zls" value="一键设置时间">
                	<?php endif;?>
                </div>
                <div class="right">
                    <span class="fprw-pt-xts_1">任务总数：<em class="cff3430"><?=$all?></em></span>
                    <span class="fprw-pt-xts_1">PC端：<em class="cff3430"><?=$pcnum?></em></span>
                    <span class="fprw-pt-xts_1">无线端：<em class="cff3430"><?=$phonenum?></em></span>
                </div>
            </div>
            <!-- 标题-->
            <!-- 表格-->
            <div class="fprw-pg" style="margin-top: 0px;">
                <table id="optionContainer1">
                    <tbody><tr>
                        <th width="231"> 日期(剩余可发布数)</th>
                        <th width="231">任务数(<span id="taskNum2"><?=$all?></span>)</th>
                        <th width="231">开始平均发布时间</th>
                        <th width="231">结束平均发布时间</th>
                        <th width="231">超时取消时间 (选填)</th>
                        <?php if($this->session->userdata('typepage') == 5):?>
                        	<th width="231">支付时间</th>
                        <?php endif;?>
                    </tr>
                        <?php
                        	$num_day = [];
                    	?>
                    	<?php for($n= 0; $n < count($SearchKey); $n++): ?>
                    	<tr class="set_time <?=$n==0 ? '' : 'hide"';?>">
                            <td>
                                <?=@date("m月d日",@strtotime("+".$n." day"))?> 
                                <?php
                                    $daynum=0;
                                    foreach($list as $vl){
                                        if($vl->date == @strtotime(@date('Y-m-d',@strtotime("+".$n." day")))){
                                            $daynum += $vl->number-$vl->del;
                                        }
                                    }
                                    $num_day[$n] = $daynum;
                                ?>
                                <em>(</em><span id="spCount" style="color: red;"><?=($info->maxtask-$daynum)?></span><em>)</em>                       
                                <input type="hidden" name="Date[<?=$n?>]" value="<?=@date("Y-m-d",@strtotime("+".$n." day"))?>">
                            </td>
                            <td style="padding-top: 0px; padding-bottom: 0px;">
                                <div style="height: 24px; margin-top: 8px; margin-left: 60px;">
                                    <!--<p class="left fprw-jg_41"><a id="timeimgReduce" class="a2">- </a></p>-->
                                    <p class="left" style="margin-top: ; margin-left: 18%;"><input type="text" name="TaskPlanCount[<?=$n?>]" date="TaskPlanCount" value="<?=$n==0?$all:0?>" placeholder="0" onkeyup="value=value.replace(/[^0-9]/g,'')" class="input_40" readonly="readonly"></p>
                                    <!--<p class="left fprw-jg_51"><a id="timeimgAdd" class="a2">+ </a></p>-->
                                </div>
                            </td>
                            <td>
                                <select name="TaskPlanBeginTimeH[<?=$n?>]" class="">
                                    <option></option>
                                    <option value='00'>00</option>
                                    <option value='01'>01</option>
                                    <option value='02'>02</option>
                                    <option value='03'>03</option>
                                    <option value='04'>04</option>
                                    <option value='05'>05</option>
                                    <option value='06'>06</option>
                                    <option value='07'>07</option>
                                    <option value='08'>08</option>
                                    <option value='09'>09</option>
                                    <option value='10'>10</option>
                                    <option value='11'>11</option>
                                    <option value='12'>12</option>
                                    <option value='13'>13</option>
                                    <option value='14'>14</option>
                                    <option value='15'>15</option>
                                    <option value='16'>16</option>
                                    <option value='17'>17</option>
                                    <option value='18'>18</option>
                                    <option value='19'>19</option>
                                    <option value='20'>20</option>
                                    <option value='21'>21</option>
                                    <option value='22'>22</option>
                                    <option value='23'>23</option>
                                </select> ：
                                <select name="TaskPlanBeginTimeM[<?=$n?>]" class="">
                                    <option></option>
                                    <option value="00">00</option>
                                    <option value="15">15</option>
                                    <option value="30">30</option>
                                    <option value="45">45</option>
                                </select>
                            </td>
                            <td>
                                <select name="TaskPlanEndTimeH[<?=$n?>]" class="">
                                    <option></option>
                                    <option value='00'>00</option>
                                    <option value='01'>01</option>
                                    <option value='02'>02</option>
                                    <option value='03'>03</option>
                                    <option value='04'>04</option>
                                    <option value='05'>05</option>
                                    <option value='06'>06</option>
                                    <option value='07'>07</option>
                                    <option value='08'>08</option>
                                    <option value='09'>09</option>
                                    <option value='10'>10</option>
                                    <option value='11'>11</option>
                                    <option value='12'>12</option>
                                    <option value='13'>13</option>
                                    <option value='14'>14</option>
                                    <option value='15'>15</option>
                                    <option value='16'>16</option>
                                    <option value='17'>17</option>
                                    <option value='18'>18</option>
                                    <option value='19'>19</option>
                                    <option value='20'>20</option>
                                    <option value='21'>21</option>
                                    <option value='22'>22</option>
                                    <option value='23'>23</option>
                                </select> ：
                                <select name="TaskPlanEndTimeTimeM[<?=$n?>]" class="">
                                    <option></option>
                                    <option value="00">00</option>
                                    <option value="15">15</option>
                                    <option value="30">30</option>
                                    <option value="45">45</option>
                                </select>
                            </td>
                            <td>                                
                                <input type="hidden" class="input-checkbox16" name="IsTimeoutTime[$n]">                                
                                <select name="TimeoutTimeH[<?=$n?>]" class="">
                                    <option></option>
                                    <option value='00'>00</option>
                                    <option value='01'>01</option>
                                    <option value='02'>02</option>
                                    <option value='03'>03</option>
                                    <option value='04'>04</option>
                                    <option value='05'>05</option>
                                    <option value='06'>06</option>
                                    <option value='07'>07</option>
                                    <option value='08'>08</option>
                                    <option value='09'>09</option>
                                    <option value='10'>10</option>
                                    <option value='11'>11</option>
                                    <option value='12'>12</option>
                                    <option value='13'>13</option>
                                    <option value='14'>14</option>
                                    <option value='15'>15</option>
                                    <option value='16'>16</option>
                                    <option value='17'>17</option>
                                    <option value='18'>18</option>
                                    <option value='19'>19</option>
                                    <option value='20'>20</option>
                                    <option value='21'>21</option>
                                    <option value='22'>22</option>
                                    <option value='23'>23</option>
                                </select> ：
                                <select name="TimeoutTimeM[<?=$n?>]" class="">
                                    <option></option>
                                    <option value="00">00</option>
                                    <option value="15">15</option>
                                    <option value="30">30</option>
                                    <option value="45">45</option>
                                </select>
                            </td>
                            <?php if($this->session->userdata('typepage') == 5):?>
                            	<td><?=@date("m月d日",@strtotime("+".($n+1)." day"))?> 9:00:00-23:59:59</td>
                        	<?php endif;?>
                        </tr>   
                        <?php endfor;?>               
                </tbody></table>
            </div>
            <!-- 表格-->
            <?php if($this->session->userdata('typepage') == 4):?>
            <div class="fprw-zpt">
                <div class="left fprw-jg">
                    <p class="fprw-jg_1">预订单设置</p>
                </div>
            </div>
            <div class="fprw-pg" style="margin-top: 0px;">
                <table id="optionContainer">
                    <tbody><tr>
                        <th width="25%">商品定金 </th>
                        <th width="25%"> 商品尾款</th>
                        <th width="25%"> 尾款何时开始支付</th>
                        <th width="25%"> 尾款最晚支付日期</th>
                    </tr>
                    <tr id="option0">
                        <td>
                            <input type="text" name="handsel" class="input_60 reserve_info" value="0" placeholder="0" maxlength="5" onkeyup="inputHandsel(this)">
                        </td>
                        <td>
                            <input type="text" name="Payment" class="input_60 reserve_info" value="0" placeholder="0" maxlength="5" onkeyup="inputPayment(this)">
                        </td>
                        <td>
                        	<input class="fpgl_w120" id="BeginDate2" maxlength="16" name="BeginDate2" onclick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm:ss'})" type="text">
                        </td>
                        <td>
                        	<input class="fpgl_w120" id="EndDate2" maxlength="16" name="EndDate2" onclick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm:ss'})" type="text">
                        </td>
                    </tr>
                </tbody></table>
            </div>
            <?php elseif($this->session->userdata('typepage') == 5):?>
            	<div class="fprw-zpt">
                <div class="left fprw-jg">
                    <p class="fprw-jg_1">预约单设置</p>
                </div>
            </div>
            <div class="fprw-pg" style="margin-top: 0px;">
                <table id="optionContainer">
                    <tbody><tr>
                        <th width="25%">浏览操作 </th>
                        <th width="25%"> 付款时以何种方式进入商品页面</th>
                        <!--<th width="25%"> 下单关键词(下单当天显示)</th>-->
                    </tr>
                    <tr id="option0">
                        <td>
                            <select id="how_browse" class="select_100 sel_action" name="how_browse">
			                    <option value="1">加入购物车(买手需加购四款同类产品)</option>
			                    <option value="2">收藏(买手需收藏五款同类产品)</option>
			                    <option value="3">货比三家，截图'足迹'证明</option>
			                </select>
                        </td>
                        <td>
                            <select id="how_search" class="select_100 sel_action" name="how_search" disabled="disabled">
			                    <option value="1">从浏览操作中直接进入</option>
                                <!--<option value="2">以新的关键词进入</option>-->
			                </select>
                        </td>
                        <td style="display: none;">
                        	<input type="text" id="newIDSearchKey" name="new_keyword" class="input_300" maxlength="500" value="" placeholder="流量入口与上一步设置的一致，请输入新的关键词/淘口令">
                        </td>
                    </tr>
                </tbody></table>
            </div>
            <?php endif;?>
            <div class="fprw-rwlx_6 sjzc_7">
                <input type="hidden" name="proid" value="<?=$proinfo->id?>">
                <a href="javascript:void(0)" onclick="submitNext()">下一步</a></div>
        </div>
        <!-- 内容-->
</form>
<script language="javascript" type="text/javascript">
function inputHandsel($this)
{
	clearNoNum($this);
	var $handel = Number($($this).val()),
		$payment = $('input[name=Payment]'),
		$count = Number($('input[date=SingleProductPrice]').val());
	if ($count <= 1)
	{
		$('input.reserve_info').val('');
		return dialog.error('商品单价必须大于1');
	}
	if ($count <= $handel)
	{
		$('input.reserve_info').val('');
		return dialog.error('订金必须小于商品单价');
	}
	var $other = $count - $handel;
	$payment.val(isNaN($other) ? 0 : $other);
}
function inputPayment($this)
{
	clearNoNum($this);
	var $payment = Number($($this).val()),
		$handel = $('input[name=handsel]'),
		$count = Number($('input[date=SingleProductPrice]').val());
	if ($count <= 0)
	{
		$('input.reserve_info').val('');
		return dialog.error('商品单价必须大于0');
	}
	if ($count <= $payment)
	{
		$('input.reserve_info').val('');
		return dialog.error('尾款必须小于商品单价');
	}
	var $other = $count - $payment;
	$handel.val(isNaN($other) ? 0 : $other);
}
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




function submitNext() {
	
         var singleProductPrice=0;
         var singleProductCount=0;//单任务数量
         var singleProductCount1=0;//成交金额超1000元单任务数量
         var buyProductCount=0;
         var productPriceListCount=0;
         var taskSum=0;//任务数量
         var residual=0;//剩余客发布数量
         var dateMsg="";
         var platformType = '淘宝';
         var $handsel = $('input[name=handsel]').val(),
         	 $payment = $('input[name=Payment]').val(),
         	 $begin = $('input[name=BeginDate2]').val(),
         	 $end = $('input[name=EndDate2]').val(),
         	 $how_browse = $('#how_browse').val(),
         	 $how_search = $('#how_search').val(),
         	 $new_keyword = $('#newIDSearchKey').val();
         $('input[date=SingleProductPrice]').each(function () {
                if ($(this).val() <= 1) {
                    singleProductPrice++;
                }
                var priceValue = $(this).val();
                var pNum = $(this).parent().next().next().next().find("input[date='BuyProductCount']").val();
                var  expressValue = $(this).parent().next().find("input[date=ExpressCharge]").val();
              
                if(parseFloat(priceValue * pNum).toFixed(2)>=limit_price)
               {
                 singleProductCount++;
               }
               if(parseFloat(parseFloat(priceValue * pNum)+parseFloat(expressValue)).toFixed(2)>=limit_price)
               {
                 singleProductCount1++;
               }
        });
         $('input[date=BuyProductCount]').each(function () {
               if ($(this).val() <= 0) {
                    buyProductCount++;
                }
           });
         $('input[date=ProductPriceListCount]').each(function () {
                 if ($(this).val() <= 0) {
                    productPriceListCount++;
                 }
                  taskSum+=parseInt($(this).val());
           });
         //alert(taskSum);
    	 var $num_day = <?=json_encode($num_day);?>;
         $('input[date=TaskPlanCount]').each(function (index)
         {
         	
            var num = $(this).val();
            var count= (<?=$info -> maxtask;?>) - $num_day[index]; //剩余发布数量
            var day= $(this).parent().parent().parent().prev().text(); 
              if((parseInt(count)>=0&&parseInt(num)>parseInt(count))||(parseInt(num)>=1&&parseInt(num)>parseInt(count))&&platformType=="淘宝")
               {
                  residual++;
                  dateMsg=""+day+"目前剩余可发布任务数为"+count+"个，请返回修改任务数量";
               }
          });
            if (singleProductPrice > 0) {
                $.openAlter("商品单价必须大于1", "提示");
                return false;
            }
            if (buyProductCount > 0) {
                $.openAlter("拍下件数必须大于0", "提示");
                return false;
            }
              if (singleProductCount > 0) {
                $.openAlter(wainingMsg,"提示",null,null,"好的");
                return false;
            }
     
            if (productPriceListCount > 0) {
                $.openAlter("任务数量必须大于0", "提示");
                return false;
            }
//          if(taskSum!='<?=$all?>')
//          {
//              $.openAlter("定价类型任务数量必须等于任务总数", "提示");
//              return false;
//          }
//            if(parseInt($("#taskAppNum").text())!=0)
//            {
//              $.openAlter("定价类型手机专享价数量必须等于APP总数", "提示");
//                return false;
//            }
            if(parseInt($("#taskNum2").text())!=0)
            {
              $.openAlter("发布时间任务数量必须等于任务总数", "提示");
                return false;
            }  
            if(parseInt(residual)>0&&platformType=="淘宝")
             {
                   $.openAlter("少刷可以养家活口，狂刷则灰飞烟灭。销量任务系统限制店铺每天最多发布<b style=\"color:red\"> "+<?=$info->maxtask?>+" 个</b>任务，"+dateMsg+"。", "提示");
                   return false;
             }
            var vBeginHour=$("#optionContainer1 tr:eq(1) td:eq(2)").find("select:eq(0)").val();
            var vBeginMine=$("#optionContainer1 tr:eq(1) td:eq(2)").find("select:eq(1)").val();
            var vEndHour=$("#optionContainer1 tr:eq(1) td:eq(3)").find("select:eq(0)").val();
            var vEndMine=$("#optionContainer1 tr:eq(1) td:eq(3)").find("select:eq(1)").val();
            var vOutHour=$("#optionContainer1 tr:eq(1) td:eq(4)").find("select:eq(0)").val();
            var vOutMine=$("#optionContainer1 tr:eq(1) td:eq(4)").find("select:eq(1)").val(); 
//            var vIsTimeout=$("#optionContainer1 tr:eq(1) td:eq(4)").find("input[name=IsTimeoutTimes]").val(); 
           var BeginTime=vBeginHour+":"+vBeginMine;
            var EndTime=vEndHour+":"+vEndMine;
            var OutTime=vOutHour+":"+vOutMine;
            var cDate = new Date();
            var cHour=cDate.getHours();
            var cMime=cDate.getMinutes();
           if(cHour<10)
           {
              cHour="0"+cHour;
           }
           if(cMime<10)
           {
              cMime="0"+cMime;
           }
            var cTime=cHour+":"+cMime;
//           if($("input[name=TaskPlanType]:checked").val()=="0"&&(vOutHour==''||vOutMine==''))
//            {
////              if($("#optionContainer1 tr:eq(1) td:eq(4)").find("input[name=IsTimeoutTimes]").attr("checked"))
////              {
//              $.openAlter("启用超时时间时,超时取消时间不能为空", "提示");
//                return false;
////                }
//            }   
           
            if($("input[name=TaskPlanType]:checked").val()=="0"&&((vOutHour!=''&&vOutMine=='')||(vOutHour==''&&vOutMine!='')))
            {
                $.openAlter("启用超时时间时,超时取消时间不能为空", "提示");
                return false;
            }   
             if(($("input[name=TaskPlanType]:checked").val()=="1"||$("input[name=TaskPlanType]:checked").val()=="2")&&BeginTime<=cTime)
            {
              $.openAlter("今天的开始时间必须大于当前时间", "提示");
                return false;
            }
            if($("input[name=TaskPlanType]:checked").val()=="1"&&(vBeginHour==''||vBeginMine==''||vEndHour==''||vEndMine==''))
            {
              $.openAlter("开始时间和结束时间不能为空", "提示");
                return false;
            }
            if($("input[name=TaskPlanType]:checked").val()=="1"&&(BeginTime>=EndTime))
            {
              $.openAlter("结束时间必须大于开始时间", "提示");
                return false;
            }
           if($("input[name=TaskPlanType]:checked").val()=="1"&&(EndTime>=OutTime))
            {
//               if($("#optionContainer1 tr:eq(1) td:eq(4)").find("input[name=IsTimeoutTimes]").attr("checked"))
//               {
              $.openAlter("启用超时时间时,超时时间必须大于结束时间", "提示");
                return false;
//                }
            }
            if(($("input[name=TaskPlanType]:checked").val()=="0"||$("input[name=TaskPlanType]:checked").val()=="1")&&(vOutHour!=''||vOutMine!=''))
            {
//              if($("#optionContainer1 tr:eq(1) td:eq(4)").find("input[name=IsTimeoutTimes]").attr("checked")&&OutTime<=cTime)
             if(OutTime<=cTime)
              {
              $.openAlter("启用超时时间时,超时时间必须大于当前时间", "提示");
                return false;
              }
            }   
            if($("input[name=TaskPlanType]:checked").val()=="1"&&((vOutHour!=''&&vOutMine=='')||(vOutHour==''&&vOutMine!='')))
            {
//              if($("#optionContainer1 tr:eq(1) td:eq(4)").find("input[name=IsTimeoutTimes]").attr("checked"))
//              {
              $.openAlter("启用超时时间时,超时取消时间不能为空", "提示");
                return false;
//                }
            }   
             if($("input[name=TaskPlanType]:checked").val()=="2")
              {   
                 var timenull=0;
                 var timeBig=0;
                 var timeOut=0;
                 var timeOutBig=0;
                   $('input[date=TaskPlanCount]').each(function () {
                          var num = $(this).val();
                          if(num>0)
                          {
                            var vBeginHour=$(this).parent().parent().parent().next().find("select:eq(0)").val();
                            var vBeginMine=$(this).parent().parent().parent().next().find("select:eq(1)").val();
                            var vEndHour=$(this).parent().parent().parent().next().next().find("select:eq(0)").val();
                            var vEndMine=$(this).parent().parent().parent().next().next().find("select:eq(1)").val();
                            var vOutHour=$(this).parent().parent().parent().next().next().next().find("select:eq(0)").val();
                            var vOutMine=$(this).parent().parent().parent().next().next().next().find("select:eq(1)").val();
                            var BeginTime=vBeginHour+":"+vBeginMine;
                            var EndTime=vEndHour+":"+vEndMine;
                            var OutTime=vOutHour+":"+vOutMine;
                             if(vBeginHour==''||vBeginMine==''||vEndHour==''||vEndMine=='')
                             {
                               timenull++;
                             }
                             else if(BeginTime!=''&&EndTime!=''&&BeginTime>=EndTime)
                             {      
                               timeBig++;
                             }
                             else  if((vOutHour!=''&&vOutMine=='')||(vOutHour==''&&vOutMine!=''))
                             {
//                                 if($(this).parent().parent().parent().next().next().next().find("input[name=IsTimeoutTimes]").attr("checked"))
//                                 {
                                   timeOut++;
//                                  }
                             }
                             else if(EndTime!=''&&OutTime!=''&&EndTime>=OutTime)
                             {
//                                 if($(this).parent().parent().parent().next().next().next().find("input[name=IsTimeoutTimes]").attr("checked"))
//                                 {
                                   timeOutBig++;
//                                  }
                             }
                          }
                   });
              
                if(parseInt(timenull)>0)
                {
                   $.openAlter("开始时间和结束时间不能为空", "提示");
                   return false;
                }
               else if(parseInt(timeBig)>0)
               {
                 $.openAlter("结束时间必须大于开始时间", "提示");    
                 return false;
                }
                else if(parseInt(timeOut)>0)
               {
                 $.openAlter("启用超时时间时,超时取消不能为空", "提示");    
                 return false;
                } 
               else if(parseInt(timeOutBig)>0)
               {
                 $.openAlter("启用超时时间时,超时时间必须大于结束时间", "提示");    
                 return false;
                }          
              }
            var $tasktype = <?=$this->session->userdata('typepage')?>;
            if($tasktype == 4)  //预订单
            {
            	if (Number($handsel) <= 0)
				{
					return dialog.error('订金必须大于0');
				}
				if (Number($payment) <= 0)
				{
					return dialog.error('尾款必须大于0');
				}
				if (Number($payment) + Number($handsel) != Number($('input[date=SingleProductPrice]').val()))
				{
					return dialog.error('订金与尾款之和必须等于商品单价');
				}
				if($begin == '')
	            {
	            	return dialog.error('必须输入尾款开始支付时间');
	            }
	            $now = cDate.getFullYear() + '-' + (cDate.getMonth() + 1) + '-' + cDate.getDate() + ' ' + cTime + ':' + cDate.getSeconds();
	            if (new Date($begin).getTime() < new Date($now).getTime())
	            {
	            	return dialog.error('尾款开始支付时间不能早于当前时间');
	            }
	            if($end == '')
	            {
	            	return dialog.error('必须输入尾款截至支付时间');
	            }
	            if ($begin >= $end)
	            {
	            	return dialog.error('尾款开始支付时间不能晚于截至时间');
	            }
            }
            else if($tasktype == 5)  //预约单
            {
            	if ($how_search == 2 && $new_keyword == '')
            	{
            		return dialog.error('付款时选择以新的关键词进入，则新关键词必须填写');
            	}
            	if($how_search == 1 && $new_keyword != '')
            	{
            		return dialog.error('您已选择买手下单时从浏览操作中直接进入，则无需设置下单关键词');
            	}
            } 
        if($("input[name=TaskPlanType]:checked").val()=="2")
         {
              $("input[name=IsTimeoutTime]").removeAttr("disabled");
              $("select").removeAttr("disabled");
          }

        if (singleProductCount1 > 0)
        {
            $.openNewConfirm("<div style='text-align:left'>从<em style='color:red'>6月9日</em>起，对于真实成交价格<em style='color:red'>超过" + limit_price + "元</em>的订单，平台不承担恶意退款的赔付责任，请知悉并慎重考虑资金风险！</div>", "提示", { width: 250, height: 50 }, function () {   $('#frm').submit();  }, "我知道了", function () { $.self.parent.$.closeAlert() }, "返回修改");
                return false;
        }
        dialog.loadMsg('正在检测信息...');
        $.post('/member/checkProductPrice', {price: $('input[date=SingleProductPrice]').val(), proid: $('input[name=proid]').val()}, function(datas){
        	if (!datas.status)
        	{
        		dialog.confirm(datas.message, '无误', '我再看看', function(){
        			$('#frm').submit(); //提交表单
        		});
        	}
        	else
        		$('#frm').submit(); //提交表单
        }, 'JSON');
        }


</script>

    <?php require_once('include/footer.php')?>


</body></html>