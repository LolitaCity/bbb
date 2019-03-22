<?php require_once('include/header.php')?>
    <script src="<?=base_url()?>style/md5.js" type="text/javascript"></script>
    <script src="<?=base_url()?>style/jquery.jBox-2.3.min.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>style/jbox.css">
    <script>
    $(document).ready(function () {
        var intinf = "<?=$myint?>";
        if(intinf==0){
     	   ChooseType();
        }else{
        	//location.reload();break;
     	   if(location.href.indexOf('#reloaded')==-1){
       		    location.href=location.href+"#reloaded";
       		    location.reload();
   		   }
        }
        IsOpen();
        var $intel = $('#IDSearchType0').val();
        console.log($intel);
        if ($intel == 4 || $intel == 5)
        {
        	$('a.selectCarImg_a0').show();
        }
    });
    function showDay(){
    	$.openWin(400, 400, '<?=site_url('sales/countSenvenDay')?>');
    }
    function ChooseType()
    {
        $.openWin(350,1100, "<?=site_url('sales/infoshow')?>");
    }
    function SelectProduct(){
    	dialog.iframe('<?=site_url('sales/SelectProduct/'.$myint)?>', 850, 640, '选择商品');
    	//$.openWin(680,850, "<?=site_url('sales/SelectProduct/'.$myint)?>");
    }
    </script>
<body style="background: #fff;">
    <?php require_once('include/nav.php')?>
    <!--daohang-->
    
    
<form action="<?=site_url('sales/taskStepOne')?>" id="frm" method="post"> 
    <input name="proid" type="hidden" value="<?=$proid=='0'?'':$proinfo->id?>">  
    <input name="pagetype" type="hidden" value="<?=$myint?>">       
    <div id="fade" class="black_overlay">
        </div>
        <!--添加弹窗 选择商品 -->
        <!--添加弹窗 其他搜索条件 -->
        <div id="light0" class="ycgl_tc yctc_460">
            <!--列表 -->
            <div class="htyg_tc">
                <ul>
                    <li class="htyg_tc_1">其他搜索条件</li>
                    <li class="htyg_tc_2"><a href="javascript:void(0)" onclick="document.getElementById('light0').style.display='none';document.getElementById('fade').style.display='none'">
                        <img src="<?=base_url()?>style/images/sj-tc.png"></a> </li>
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
                        <p class="fprw-xzgl_4">排序方式：</p>
                        <p>                            
                            <select class="select_215" disabled="disabled" id="SortType" name="SortType">
                                <option value="1">综合</option>
                                <option value="2">新品</option>
                                <option value="3">人气</option>
                                <option value="4">销量</option>
                                <option value="5">价格从低到高</option>
                                <option value="6">价格从高到低</option>
                            </select>
                        </p>
                    </li>
                    <li class="fprw-xzgl_5">
                        <p class="fprw-xzgl_3">
                            <input type="checkbox" class="input-checkbox16" name="SearchPrice">
                            <input type="hidden" name="IsSearchPrice" value="False">
                        </p>
                        <p class="fprw-xzgl_4"> 价格区间：</p>
                        <p><input type="text" name="PriceStart" class="input_108" onkeyup="value=value.replace(/[^0-9]/g,'')" disabled="disabled" maxlength="6"></p>
                        <p class="fprw-xzgl_4">~</p>
                        <p><input type="text" name="PriceEnd" class="input_108" onkeyup="value=value.replace(/[^0-9]/g,'')" maxlength="6" disabled="disabled"></p>
                    </li>
                    <li class="fprw-xzgl_5">
                        <p class="fprw-xzgl_3">
                            <input type="checkbox" class="input-checkbox16" name="SendProductCitys">
                            <input type="hidden" name="IsSendProductCity" value="False">
                        </p>
                        <p class="fprw-xzgl_4">发货地：&nbsp;&nbsp;&nbsp;</p>
                        <p><input type="text" name="SendProductCity" class="input_240" maxlength="30" disabled="disabled"></p>
                    </li>
                    <li class="fprw-xzgl_5">
                        <p class="fprw-xzgl_3">
                            <input type="checkbox" class="input-checkbox16" name="OtherContents">
                            <input type="hidden" name="IsOtherContent" value="False">
                        </p>
                        <p class="fprw-xzgl_4">其他：&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
                        <p><input type="text" name="OtherContent" class="input_240" maxlength="30" disabled="disabled"></p>
                    </li>
                    <li>
                        <div class="fprw-xzgl_2">
                            <input onclick="setFinish('light0')" class="input-butto100-ls" type="button" value="确定">
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

        <div id="fade" class="black_overlay">
        </div>
        <!--添加弹窗 转化率设置 -->
        <div class="sj-fprw">
            <div class="tab1" id="tab1">
                <div class="menu">
                    <ul>
                        <li id="one2" class="off" onclick="dialog.iframe('/sales/infoshow', 1100, 350, '任务类型选择')">发布任务</li>
                        <li id="one3" onclick="location.href='<?=site_url('sales/taskno')?>'">未接任务</li>
                        <li id="one1" onclick="location.href='<?=site_url('sales/taskyes')?>'">已接任务</li>
                        <li id="one0" onclick="location.href='<?=site_url('sales/evaluation')?>'">评价管理</li>
                        <li style="float: right;" onclick="showDay()">查看剩余可发布</li>
                    </ul>
                </div>
            </div>
            <!-- 内容-->
            
            <!-- 切换-->
            <div class="fprw_qh" style="margin-top: 20px">
                <ul>
                    <li class="fprw_qhys">第一步：来路设置</li>
                    <li>第二步：价格和发布时间</li>
                    <li style="border-right: none;">第三步：快递和备注</li>
                </ul>
            </div>
            <!-- 切换-->
            <input type="hidden" name="PlatformNoID" value="">
            <input id="ProductID" name="ProductID" type="hidden" value="">
            <input data-val="true" data-val-required="PlatformType 字段是必需的。" id="PlatformType" name="PlatformType" type="hidden" value="淘宝">
            <input data-val="true" data-val-required="MsgTaskCategory 字段是必需的。" id="MsgTaskCategory" name="MsgTaskCategory" type="hidden" value="2">
            <!-- 选定商品-->
            <div class="fprw-sdsp">
                <div class="fprw-sdsp_1">
                    <p class="left">选定商品</p>
                    <p class="right">
                        <input type="button" onclick="SelectProduct()" class="input-butto100-zlsc" value="选择商品"></p>
                </div>
                <div class="fprw-sdsp_2">
                    <table style="table-layout: fixed;">
                        <tbody><tr>
                            <th width="182">商品简称</th>
                            <td width="700"><?=$proid=='0'?'':$proinfo->commodity_abbreviation?></td>
                            <td width="208" rowspan="5">
                            <?php if($proid!='0'):?>
                            <img id="pro_img" src="<?= str_replace ( 'pk1172' , '18zang' ,  $proinfo -> app_img ? $proinfo -> app_img : $proinfo->commodity_image);?>" width="200" height="200">
                            <?php endif;?>
                            </td>
                        </tr>
                        <tr>
                            <th width="182">商品ID&nbsp;&nbsp;&nbsp;</th>
                            <td width="700"><?=$proid=='0'?'':$proinfo->commodity_id?></td>
                        </tr>
                        <tr>
                            <th width="182">店铺名&nbsp;&nbsp;&nbsp;</th>
                            <td width="700" id="tdShopName"><?php if($proid!='0'){foreach($shop as $s){if($s->sid==$proinfo->shopid){echo $s->shopname;}}}?></td>
                        </tr>
                        <tr>
                            <th width="182">商品标题 </th>
                            <td width="700" id="tdFullName"><?=$proid=='0'?'':$proinfo->commodity_title?></td>
                        </tr>
                        <tr>
                            <th width="182">商品链接</th>
                            <td width="700" style="word-wrap: break-word"><?=$proid=='0'?'':$proinfo->commodity_url?></td>
                        </tr>
                    </tbody></table>
                </div>
            </div>
            <!-- 选定商品-->
        
<!-- 浏览任务-->
<!-- 标题-->   
<div class="fprw-zpt">
    <div class="left fprw-pt" style="margin-top: 0px">来路设置</div>
    <span style="margin-left: 110px; position: absolute; font-size: 14px;" id="msg"></span>
    <div class="right" style="margin-top: 0px">
        <span class="fprw-pt-xts_1">总数：<em class="cff3430" id="taskShopCount">0</em> </span>
        <span class="fprw-pt-xts_1">PC：<em class="cff3430" id="pcShopCount">0</em> </span>
        <span class="fprw-pt-xts_1">无线端：<em class="cff3430" id="appShopCount">0</em> </span><span>
       		<input type="button" class="input-butto100-zls" onclick="addRow()" value="新增"> 	
        </span>
    </div>
</div>
<!-- 表格-->
<div class="fprw-pg" style="margin-top: 0px;">
    <table id="optionContainer">
        <tbody><tr>
            <th width="144">流量入口</th>
            <th width="358">
                关键词
                <!--<span style="margin-left: 160px">关键字</span>--> 
                <!--<span style="margin-left: 50px"><a href="#" target="_blank" style="text-decoration: underline; color: Red;">搜索关键字设置规范</a></span>-->
            </th>
            <th width="114">数量</th>            
            <th width="180">其他搜索条件（可选）</th>
            <th width="118">操作</th>
        </tr>        
        <tr id="trHideSearch" style="display: none">
            <td>
                <select class="select_108" id="IDSearchType" name="SearchType[]" onchange="SearchTypeChange(this)">
                    <option value="1">淘宝APP自然搜索</option>
                    <option value="2">淘宝PC自然搜索</option>
                    <option value="3">淘宝APP淘口令</option>
                    <option value="4">淘宝APP直通车</option>
                    <option value="5">淘宝PC直通车</option>
                    <option value="6">淘宝APP二维码</option>
                </select>
            </td>
            <td>
            	<a href="javascript:;" class="selectCarImg_a selectCarImg_a0" onclick="selectCarImg(0)" style="display: none;">[选择直通车图]</a>
            	<img class="car_img_show car_img_show0" src="" alt="" width="50" height="50" onclick="selectCarImg(0)"/>
            	<input type="text" id="IDSearchKey0" name="SearchKey[0]" class="input_300" maxlength="500" value="" placeholder="请设置关键字">	
        	</td>
            <td><input type="text" id="IDKeyWordCount" name="KeyWordCount[]" class="input_60" maxlength="3" placeholder="0" onkeyup="clearNoNum(this)"  onchange="RetaskCountGoods()"></td>            
            <td><input type="button" id="IDSiteBtn" class="input-butto100-xls" onclick="SetOtherCondition(this)" accesskey="light0" value="设置"></td>
            <td>
                <input type="button" id="IDdelBtn" class="input-butto100-zls" onclick="delRow()" value="删除">
                <input type="hidden" id="IDdelOrder" name="order[]" value='0'>
                <input type="hidden" id="IDdelPrice" name="price[]" value='0'>
                <input type="hidden" id="IDdelAddress" name="address[]" value='0'>
                <input type="hidden" id="IDdelOther" name="other[]" value='0'>
            	<input type="hidden" id="IDselCarImgInput" name="car_img[0]" class="car_img" value="">
            </td>
        </tr>
        <tr class="arg_tr">
            <td>
                <select class="select_108" id="IDSearchType0" name="SearchType[0]" onchange="SearchTypeChange(this)">
                    <option value="1">淘宝APP自然搜索</option>
                    <option value="2">淘宝PC自然搜索</option>
                    <option value="3">淘宝APP淘口令</option>
                    <option value="4">淘宝APP直通车</option>
                    <option value="5">淘宝PC直通车</option>
                    <option value="6">淘宝APP二维码</option>
                </select>
            </td>
            <td>
            	<a href="javascript:;" class="selectCarImg_a selectCarImg_a0" onclick="selectCarImg(0)" style="display: none;">[选择直通车图]</a>
            	<img class="car_img_show car_img_show0" src="" alt="" width="50" height="50" onclick="selectCarImg(0)"/>
            	<input type="text" id="IDSearchKey0" name="SearchKey[0]" class="input_300" maxlength="500" value="" placeholder="请设置关键字">	
        	</td>
            <td><input type="text" id="IDKeyWordCount0" name="KeyWordCount[0]" class="input_60" maxlength="3" placeholder="0" onkeyup="clearNoNum(this)"></td>            
            <td><input type="button" id="IDSiteBtn0" class="input-butto100-xls" onclick="SetOtherCondition(this,0)" accesskey="light0" value="设置"></td>
            <td>
                <input type="button" class="input-butto100-zls"  id="delBtn0" onclick="delRow()" value="删除">
                <input type="hidden" id="IDdelOrder0" name="order[0]" value='0'>
                <input type="hidden" id="IDdelPrice0" name="price[0]" value='0'>
                <input type="hidden" id="IDdelAddress0" name="address[0]" value='0'>
                <input type="hidden" id="IDdelOther0" name="other[0]" value='0'>
            	<input type="hidden" id="car_img" name="car_img[0]" class="car_img" value="">
            </td>            
        </tr>
        </tbody>
    </table>
</div>
<div class="select_car_img" style="display: none;">
	<div style="float: left;">
		<img src="<?= str_replace ( 'pk1172' , '18zang' ,  $proinfo->commodity_image);?>" class="img0" width="200px" height='200px' alt=""/>
	    <p>
	    	<input type="radio" name="sel_carimg" value="0" style="margin-left: 98px;" checked="checked"/>
	    </p>
	</div>
	<?php 
		if (isset($_GET['proid']))
		{
			$not_null_img = 0;
			for ($i = 1; $i < 5; $i++)
			{
				$img_name = 'through_train_' . $i;
				if ($proinfo -> $img_name)
				{
					$not_null_img++;
	?>
		<div style="float: left;">
			<img src="<?=$proinfo->$img_name?>" class="img<?=$i?>" width="200px" height='200px' alt=""/>
		    <p>
		    	<input type="radio" name="sel_carimg" value="<?=$i;?>" style="margin-left: 98px;"/>
		    </p>
		</div>
	<?php
				}
			}
		}
	?>
	<p style='text-Align:center'>
		<input id="comfirmCarImg_btn" type="button" class="input-butto100-xls" onclick="comfirmCarImg(0)" accesskey="light0" value="确定">
	</p>
</div>
<script>
function comfirmCarImg($action_line)
{
	var $check_num = $('input[name=sel_carimg]:checked').val();
	$('input[name="car_img[' + $action_line + ']"]').val($check_num);
	$('img.car_img_show' + $action_line).attr('src', $('img.img' + $check_num).attr('src'));
	$('a.selectCarImg_a' + $action_line).hide();
	$('img#pro_img').attr('src', $('img.img' + $check_num).attr('src'));	
	layer.close($open);
}
	
function selectCarImg($line)
{
	var $width = (<?=$not_null_img;?> + 1) * 200;
	$('#comfirmCarImg_btn').attr('onclick', 'comfirmCarImg(' + $line + ')');
	console.log($line);
	$open = layer.open({
	  type: 1,
	  area: [$width + 'px', '250px'],
	  closeBtn: 0,
	  shade: 0.4,
	  title: false,
	  content: $('.select_car_img'),
//	  cancel: function(){
//	    layer.msg('捕获就是从页面已经存在的元素上，包裹layer的结构', {time: 5000, icon:6});
//	  }
	});
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
	
var rowCount = 0;  //行数序列默认从20开始  
//添加行  
function addRow() {	
  rowCount++;
  var seartypeNum = $("#optionContainer input[class=input_300]").length;
  if (seartypeNum > 10) {
      $.openAlter("最多添加10个来路设置", "提示");
  }
  else {
      //添加行内容
      var aDlist = $("#trHideSearch").clone().html();
      var trID = 'option' + rowCount;
      aDlist = aDlist.replace("SearchType[]", 'SearchType['+rowCount+']');
      aDlist = aDlist.replace("SearchKey[0]", 'SearchKey['+rowCount+']');
      aDlist = aDlist.replace("KeyWordCount[]", 'KeyWordCount['+rowCount+']');
      aDlist = aDlist.replace("order[]", 'order['+rowCount+']');
      aDlist = aDlist.replace("price[]", 'price['+rowCount+']');
      aDlist = aDlist.replace("address[]", 'address['+rowCount+']');
      aDlist = aDlist.replace("other[]", 'other['+rowCount+']');
      aDlist = aDlist.replace('delRow()', "delRow(" + rowCount + ")");

      aDlist = aDlist.replace("IDSearchType", 'IDSearchType'+rowCount);
      aDlist = aDlist.replace("IDSearchKey0", 'IDSearchKey'+rowCount);
      aDlist = aDlist.replace("IDKeyWordCount", 'IDKeyWordCount'+rowCount);
      aDlist = aDlist.replace("IDSiteBtn", 'IDSiteBtn'+rowCount);
      aDlist = aDlist.replace("IDdelBtn", 'IDdelBtn'+rowCount);
      aDlist = aDlist.replace("IDdelOrder", 'IDdelOrder'+rowCount);
      aDlist = aDlist.replace("IDdelPrice", 'IDdelPrice'+rowCount);
      aDlist = aDlist.replace("IDdelAddress", 'IDdelAddress'+rowCount);
      aDlist = aDlist.replace("IDdelOther", 'IDdelOther'+rowCount);
      
      aDlist = aDlist.replace("selectCarImg(0)", 'selectCarImg(' + rowCount + ')');
      aDlist = aDlist.replace("selectCarImg(0)", 'selectCarImg(' + rowCount + ')');
      aDlist = aDlist.replace("selectCarImg_a0", 'selectCarImg_a' + rowCount);
      aDlist = aDlist.replace("car_img_show0", 'car_img_show' + rowCount);
      aDlist = aDlist.replace("car_img[0]", 'car_img['+rowCount + ']');

      var id = 'light' + rowCount;
      aDlist = aDlist.replace('light0', id);
      $('#optionContainer').find('tbody').append("<tr id=" + trID + " class='arg_tr'>" + aDlist + "</tr>");

      //添加其他搜索条件
      var alist = $("#light0").clone().html();
     //alert(id);
      alist = alist.replace("light0", id);
      alist = alist.replace("light0", id);
     // alert(alist);
 	  $('img.car_img_show' + rowCount).attr('src', '');
 	  $('input[name="car_img[' + rowCount + ']"]').val('');
      $('#idSet').append("<div id=\"light" + rowCount + "\" class=\"ycgl_tc yctc_460\">" + alist + "</div>");
      
  }
}
//删除行
function delRow(rowIndex) {
	if(rowIndex==undefined){
		$.openAlter("当前行不能删除", "提示");
	}else{
    	$("#option" + rowIndex).remove();
    	$("#light" + rowIndex).remove(); //删除对应的其他搜索条件
    	//            rowCount--;
    	//reTaskCount(); //删除后重新计算任务数量
	     RetaskCountGoods();
	}
}

//计算所有行的任务数量 区分PC 无线端
function RetaskCountGoods(){
	//$.openAlter("统计单钱列表的数据 Pc   无线", "提示");
    var taskTotal = 0;  //任务总数
    var pcTotal = 0;  //PC任务总数
    var appTotal = 0;  //App任务总数
	$("#optionContainer input[class=input_60]").each(function () {
        if ($(this).val() != " " && $(this).val() != "" && $(this).val() != null) {
            taskTotal += parseInt($(this).val());
        }
        var cSearchType = $(this).parent().parent().find('td').eq(0).find('select > option:selected').text();
        if (cSearchType.indexOf('PC') != -1) {
            if ($(this).val() != " " && $(this).val() != "" && $(this).val() != null) {
                pcTotal += parseInt($(this).val());
            }
        }else if (cSearchType.indexOf('APP') != -1 || cSearchType.indexOf('微信') != -1 || cSearchType.indexOf('手机') != -1) {
            if ($(this).val() != " " && $(this).val() != "" && $(this).val() != null) {
                appTotal += parseInt($(this).val());
            }
        }

	});
    $("#taskShopCount").text(taskTotal);
    $("#pcShopCount").text(pcTotal);
    $("#appShopCount").text(appTotal);
}
function SetOtherCondition(obj){
	 //$("#"+$(obj).attr("accesskey")).css('display','block');
     var id = $(obj).attr("accesskey");
     var searchType = $(obj).parent().parent().find('td').eq(0).find('select > option:selected').val();
     GeDocumentHeight();
     document.getElementById(id).style.display = 'block';
     document.getElementById('fade').style.display = 'block';
    // alert(id);
		//$.openAlter("显示对应的lightdiv框 通过 accesskey='light*'  *为 代表不同的行数 获取信息", "提示");
/*      if (!$("#" + id + " input[name='OtherContents']").attr("checked")) {
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
     } */
 }
 function GeDocumentHeight() {
     $(".black_overlay").height(document.body.screenHeight).width($(document).width()).appendTo($("body"));
     var scrollH = $(document).scrollTop();
     var topVal = ($(window).height() - 400) / 2 + scrollH;
     $(".yctc_460").css("top", topVal);
     $(".yctc_498").css("top", topVal);
     $(window).css('overflow–y','hidden');
     $(".black_overlay").css('position','fixed');
 }

function setFinish(info){
     var rownum = info.replace("light", ''); 
    // alert(rownum); 获取到相应的行数 然后根据行数拼接ID 添加到内容里面去
	 if(!$("#"+info).find("select[name=SortType]").prop('disabled')){		 
		 $("#IDdelOrder"+rownum).val($("#"+info).find("select[name=SortType]").find("option:selected").val());
	 }else{
		 $("#IDdelOrder"+rownum).val('0');
	 }

	 
	 if(!$("#"+info).find("input[name=PriceStart]").prop('disabled')  && !$("#"+info).find("input[name=PriceEnd]").prop('disabled') ){	
		 PriceStart	= $("#"+info).find("input[name=PriceStart]").val();
		 PriceEnd = $("#"+info).find("input[name=PriceEnd]").val();
/*		 alert(PriceStart+PriceEnd);
         if(parseInt(PriceStart)>parseInt(PriceEnd)){
             alert(PriceStart);
         }else{
             alert(PriceEnd);
         }*/

		 if(checknull(PriceStart) && checknull(PriceEnd)){
			 if(parseInt(PriceStart)>parseInt(PriceEnd)){
				 $.openAlter("区间格式错误，应为小数值^^大数值", "提示");
				 return false;
			 }else{
				 $("#IDdelPrice"+rownum).val(PriceStart+'^'+PriceEnd);
			 }
		 }else{
			 $.openAlter("请填写好价格区间", "提示");
			 return false;
		 }	
	 }else{
		 $("#IDdelPrice"+rownum).val('0');
	 }

	 
	 if(!$("#"+info).find("input[name=SendProductCity]").prop('disabled')){
		 if(checknull($("#"+info).find("input[name=SendProductCity]").val())){		 
		      $("#IDdelAddress"+rownum).val($("#"+info).find("input[name=SendProductCity]").val());
		 }else{
			 $.openAlter("请填写好发货地", "提示");
			 return false;
		 }
	 }else{
		 $("#IDdelAddress"+rownum).val('0');
	 }

	 
	 if(!$("#"+info).find("input[name=OtherContent]").prop('disabled')){
		 if(checknull($("#"+info).find("input[name=OtherContent]").val())){		 
		     $("#IDdelOther"+rownum).val($("#"+info).find("input[name=OtherContent]").val());
		 }else{
			 $.openAlter("请填写好其他条件", "提示");
			 return false;
		 }
	 }else{
		 $("#IDdelOther"+rownum).val('0');
	 }
	 
	 document.getElementById(info).style.display='none';
	 document.getElementById('fade').style.display='none';
	 //alert('siteinfo');
}
 function IsOpen() {
     $("input[name=OtherContents]").live("click", function () {
         if ($(this).attr("checked")) {
             $(this).parent().next().next().find('input').removeAttr("disabled");
         } else {
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
</script>
      
            <div class="fprw-rwlx_6 sjzc_7">
                <a href="javascript:void(0)" onclick="CheckNext()">下一步</a></div>
            </div>
</form>

<script>

//alert($("#IDSearchType").val());
function CheckNext(){
    //var dodb=1;// 执行提交表单操作   
    var myarr=new Array();
	if($("input[name=proid]").val()){
		//关键词  cSearchType.indexOf('PC')
		var keyword="<?=isset($proinfo->commodity_title) ? $proinfo->commodity_title : 'null'?>";	
			
		var n=0;
		$("#optionContainer input[class=input_300]").each(function (index) {
			var serchtype = $(this).attr('id').replace(/IDSearchKey/g, "IDSearchType"),  //流量入口
				serchCount = $(this).attr('id').replace(/IDSearchKey/g, "IDKeyWordCount"),  //任务数量
				$intlet = $("#"+serchtype).val(),  //流量入口的值
				$has_upload = false,  //当前行是否上传了文件
				$has_keyword = true, //当前行设置了关键词
				$current_row_num = parseInt(index + 1),  //当前的行数
				$this_row = $("#"+serchtype).parents('.arg_tr'),  //当前行对象
				$task_count = $this_row.find('.input_60').val();  //当前行设置的任务数
			if($intlet != 0)  //选择了流量入口
			{
				if ($intlet == 4 ||$intlet == 5)
				{
					if ($this_row.find('.car_img').val() == '')
					{
						$.openAlter('请正确上传第' + $current_row_num + '行的直通车图', "提示");
						throw new Error('系统捕获到异常现象');
					}
				}
			 	if($("#"+serchtype).val()=="3" || $("#"+serchtype).val()=="6" ){
			 		if($("#"+serchCount).val()==0){
			 			myarr[n]=2;
			 		}else{
			 			myarr[n]=1;
			 		}
				}else{
					if($(this).val() !=" " && $(this).val() != "" && $(this).val() != null){
	    				if($("#"+serchCount).val()==0){
	    			 		myarr[n]=2;
	    			 	}else{
	    			 		myarr[n]=1;
	    			 	}
	    			}else{
	    				myarr[n]=0;
	    			}
				} 
				n++;
			}			
		});
		for(i=1;i<myarr.length;i++){
			if(myarr[i]==0){
				$.openAlter("您添加的数据第（"+(i)+"）行关键字出错，请重新填写", "提示");
				return false;
			}else if(myarr[i]==2){
				$.openAlter("您添加的数据第（"+(i)+"）行任务数量不能为0，请重新填写", "提示");
				return false;
			}
		}
		$("#frm").submit();
	}else
		$.openAlter("请选择产品", "提示");
}
function checknull(info){
	if(info == undefined){
		return false;
	}
	if(info == ''){
		return false;
	}
	return true;
}

</script>
	<style>
.input-butto100-xshs1{
    width: 100px;
    height: 28px;
    /* background: #4882f0; */
    /* color: #fff; */
    text-align: center;
    line-height: 28px;
    cursor: pointer;
    -webkit-border-radius: 28px;
    -moz-border-radius: 28px;
    -ms-border-radius: 28px;
    -o-border-radius: 28px;
    border-radius: 28px;
    padding-left: 0px;
}
	</style>
<script language="javascript" type="text/javascript">
function SearchTypeChange(obj) {
    var id = $(obj).attr("name");
    var typeValue = $(obj).val();
    var cKey = $(obj).parent().next().find("input[class='input_300']");
    var cbtn = $(obj).parent().next().next().next().find("input[type='button']");
    var sRebuyPeriodType = $(obj).parent().next().next().next().find("select");
	var $parents = $(obj).parents('.arg_tr');
    	$selectCarImg_a = $parents.find('.selectCarImg_a'),
		$img = $parents.find('.car_img_show');
	$img.attr('src', '');
    cbtn.attr("value", "设置");;
//    $("#"+divID+" option:first").attr("selected", 'selected');  
	$('img#pro_img').attr('src', typeValue == 1 ? '<?=$proinfo->app_img ? $proinfo->app_img : $proinfo->commodity_image;?>' : '<?=$proinfo->commodity_image?>');
	if (typeValue == 4 || typeValue == 5)
	{
		$selectCarImg_a.css('display', '');
	}
	else
	{
		$selectCarImg_a.css('display', 'none');
	}

    if (typeValue == 3) {
        cKey.attr("placeholder", "请设置淘口令");
        cbtn.attr("class", "input-butto100-xshs1");
        cbtn.attr("disabled", "disabled");
        cKey.removeAttr("disabled");
    }else if (typeValue == 6 ) {
        cKey.attr("readonly", "readonly");
        cKey.css("background", "#ccc");
        cKey.val("");
        cKey.attr("placeholder", "");
        cbtn.attr("class", "input-butto100-xshs1");
        cbtn.attr("disabled", "disabled");
    }else {
        if (typeValue == "18" || typeValue == "19") {
            cKey.attr("placeholder", "（选填）订单搜索关键字");
            cKey.attr("maxlength", "30");
        }
        else {
            cKey.attr("placeholder", "请设置关键字");
        }
        cbtn.attr("class", "input-butto100-xls");
        cbtn.removeAttr("disabled");
        cKey.removeAttr("disabled");
    }
    
    RetaskCountGoods(); //重新继续pc和app任务数量
    var screenshotTrain = '';
    var mobileScreenshotTrain = '';
    var screenshotTianMao = '';
    var qRCode = '';
    var isTmallImgRemind = 'False';
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
 }          // 拖拉事件计算foot div高度  
 
});

</script>

    <?php require_once('include/footer.php')?>


</body></html>