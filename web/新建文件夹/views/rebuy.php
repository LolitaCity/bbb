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
        var proid ="<?=$proid?>";
        if(proid !=0 ){
        	showDay();
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
    	$.openWin(680,850, "<?=site_url('sales/SelectProduct/'.$myint)?>");
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
                        <li id="one2" class="off" onclick="location.href='<?=site_url('sales')?>'">发布任务</li>
                        <li id="one1" onclick="location.href='<?=site_url('sales/task')?>'">任务管理</li>
                        <li id="one0" onclick="location.href='<?=site_url('sales/evaluation')?>'">评价管理</li>
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
                            <img src="<?=$proinfo->commodity_image?>" width="200" height="200">
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
    <div class="left fprw-pt" style="margin-top: 0px">
        店铺复购<span style="margin-left: 10px">（<em class="cff3430">针对店铺</em> --指定买过该店铺的买手接任务）</span>
    </div>
    <span style="margin-left: 110px; position: absolute; font-size: 14px;" id="msg">
    </span>
    <div class="right" style="margin-top: 0px">
        <span class="fprw-pt-xts_1">总数：<em class="cff3430" id="taskShopCount">0</em> </span>
        <span class="fprw-pt-xts_1">PC：<em class="cff3430" id="pcShopCount">0</em> </span>
        <span class="fprw-pt-xts_1">无线端：<em class="cff3430" id="appShopCount">0</em> </span>
        <span><input type="button" class="input-butto100-zls" onclick="addShopRow()" value="新增"></span>
    </div>
</div>
<!-- 标题-->
<!-- 表格-->
<div class="fprw-pg" style="margin-top: 0px;">
    <table id="optionContainerShop">
        <tbody>
        <tr>
            <th width="144">流量入口</th>
            <th width="358">
                <span style="text-align: center;">关键字</span>
            </th>
            <th width="80">数量</th>            
            <th width="180">复购周期</th>
            <th width="80">潜在用户</th>
            <th width="100">其他搜索条件（可选）</th>
            <th width="80">操作</th>
        </tr>
        <tr id="trHideShopSearch" style="display: none">
            <td>
                <select class="select_108" id="IDSearchType" name="SearchType[]" data="SearchType" onchange="SearchTypeShopChange(this)">
                    <option value="1">淘宝APP自然搜索</option>
                    <option value="2">淘宝PC自然搜索</option>
                    <option value="3">淘宝APP淘口令</option>
                    <option value="4">淘宝APP直通车</option>
                    <option value="5">淘宝PC直通车</option>
                    <option value="6">淘宝APP二维码</option>
                </select>
            </td>
            <td><input type="text" name="SearchKey[]" id='IDSearchKey' data="SearchKey" class="input_300" maxlength="500" value="" placeholder="请设置关键字"></td>
            <td><input type="text" name="KeyWordCount[]" id='IDKeyWordCount' data="KeyWordCount" class="input_60" maxlength="3" placeholder="0" value="0" onkeyup="value=value.replace(/[^0-9]/g,'')"onchange="reTaskShopCount()" ></td>
            <td>
                <select id="IDRebuyShopPeriodType" class="select_108" name="RebuyPeriodType[]" data="RebuyPeriodType" style="width:158px;">
                    <option value="2">30天以上，50天以内</option>
                </select>
            </td>
            <td><?=$counttask?></td>
            <td><input type="button" class="input-butto100-xls" onclick="SetOtherCondition(this)" accesskey="light600" value="设置"></td>
            <td>
                <input type="button" class="input-butto100-zls" onclick="delRow()" value="删除">
                <input type="hidden" id="IDdelOrder" name="order[]" value='0'>
                <input type="hidden" id="IDdelPrice" name="price[]" value='0'>
                <input type="hidden" id="IDdelAddress" name="address[]" value='0'>
                <input type="hidden" id="IDdelOther" name="other[]" value='0'>
            </td>
        </tr>
        <tr>
            <td>
                <select class="select_108" id="IDSearchType0" name="SearchType[]" data="SearchType" onchange="SearchTypeShopChange(this)">
                    <option value="1">淘宝APP自然搜索</option>
                    <option value="2">淘宝PC自然搜索</option>
                    <option value="3">淘宝APP淘口令</option>
                    <option value="4">淘宝APP直通车</option>
                    <option value="5">淘宝PC直通车</option>
                    <option value="6">淘宝APP二维码</option>
                </select>
            </td>
            <td>
                <input type="text" name="SearchKey[]" id='IDSearchKey0' data="SearchKey" class="input_300" maxlength="500" value="" placeholder="请设置关键字">
            </td>
            <td>
                <input type="text" name="KeyWordCount[]" id='IDKeyWordCount' data="KeyWordCount" class="input_60" maxlength="3" placeholder="0" value="0" onkeyup="value=value.replace(/[^0-9]/g,'')" onchange="reTaskShopCount()">
            </td>            
            <td>
                <select id="IDRebuyShopPeriodType" class="select_108" name="RebuyPeriodType[]" data="RebuyPeriodType" style="width:158px;">
                    <option value="2">30天以上，50天以内</option>
                </select>
            </td>
            <td>
                <?=$counttask?>
            </td>
              <td>
                <input type="button" class="input-butto100-xls" onclick="SetOtherCondition(this)" accesskey="light0" value="设置">
            </td>
            <td>
                <input type="button" class="input-butto100-zls" onclick="delRow()" value="删除">
                <input type="hidden" id="IDdelOrder0" name="order[]" value='0'>
                <input type="hidden" id="IDdelPrice0" name="price[]" value='0'>
                <input type="hidden" id="IDdelAddress0" name="address[]" value='0'>
                <input type="hidden" id="IDdelOther0" name="other[]" value='0'>

            </td>
        </tr>


    </tbody>
    </table>
</div>
            <div class="fprw-rwlx_6 sjzc_7">
                <a href="javascript:void(0)" onclick="CheckNext()">下一步</a></div>
            </div>
</form>
    <script>

        var rowCount = 0;
        function addShopRow() {
            rowCount++;
            var seartypeNum = $("#optionContainerShop input[data=SearchKey]").length;
            if (seartypeNum > 10) {
                $.openAlter("一次最多添加10条复购任务信息", "提示");
            }
            else {
                //添加行内容
                var aDlist = $("#trHideShopSearch").clone().html();
                var trID = 'option' + rowCount;
                aDlist = aDlist.replace("已设置", '设置');
                aDlist = aDlist.replace("input-butto100-xshs", 'input-butto100-xls');
                aDlist = aDlist.replace('delRow()', "delShopRow(" + rowCount + ")");
                
                aDlist = aDlist.replace('SearchType[]', "IDsearchType["+rowCount+"]");
                aDlist = aDlist.replace('SearchKey[]', "IDSearchKey["+rowCount+"]");
                aDlist = aDlist.replace('KeyWordCount[]', "IDRebuyShopPeriodType["+rowCount+"]");
                aDlist = aDlist.replace('RebuyPeriodType[]', "IDdelOrder["+rowCount+"]");
                aDlist = aDlist.replace('order[]', "IDdelPrice["+rowCount+"]");
                aDlist = aDlist.replace('price[]', "IDdelAddress["+rowCount+"]");
                aDlist = aDlist.replace('address[]', "IDdelOther["+rowCount+"]");
                aDlist = aDlist.replace('other[]', "IDdelOther["+rowCount+"]");
                
                aDlist = aDlist.replace('IDSearchType', "IDsearchType"+rowCount);
                aDlist = aDlist.replace('IDSearchKey', "IDSearchKey"+rowCount);
                aDlist = aDlist.replace('IDKeyWordCount', "IDKeyWordCount"+rowCount);                
                aDlist = aDlist.replace('IDRebuyShopPeriodType', "IDRebuyShopPeriodType"+rowCount);
                aDlist = aDlist.replace('IDdelOrder', "IDdelOrder"+rowCount);
                aDlist = aDlist.replace('IDdelPrice', "IDdelPrice"+rowCount);
                aDlist = aDlist.replace('IDdelAddress', "IDdelAddress"+rowCount);
                aDlist = aDlist.replace('IDdelOther', "IDdelOther"+rowCount);
                var id = 'light' + rowCount;
                aDlist = aDlist.replace('light600', id);
                aDlist = aDlist.replace('light600', id);
                $('#optionContainerShop').find('tbody').append("<tr id=" + trID + ">" + aDlist + "</tr>");

                //添加其他搜索条件
                var alist = $("#light0").clone().html();
                //alert(id);
                alist = alist.replace("light0", id);
                alist = alist.replace("light0", id);
                // alert(alist);
                $('#idSet').append("<div id=\"light" + rowCount + "\" class=\"ycgl_tc yctc_460\">" + alist + "</div>");
            }
        }
        function delShopRow(rowIndex) {
            $("#option" + rowIndex).remove();
            $("#light" + rowIndex).remove(); //删除对应的其他搜索条件
            //            rowCount--;
            reTaskShopCount(); //删除后重新计算任务数量
        }
        function setFinish(info){
            //alert(info);
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
                //alert(PriceStart+PriceEnd);
                if(checknull(PriceStart) && checknull(PriceEnd)){
                    if(PriceStart>PriceEnd){
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
    </script>
<script>
    function SetOtherCondition(obj){
        var id = $(obj).attr("accesskey");
        var searchType = $(obj).parent().parent().find('td').eq(0).find('select > option:selected').val();
        GeDocumentHeight();
        document.getElementById(id).style.display = 'block';
        document.getElementById('fade').style.display = 'block';
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
    function SearchTypeShopChange(obj) {
        var id = $(obj).attr("name");
        var typeValue = $(obj).val();
///alert(typeValue);
        var cKey = $(obj).parent().next().find("input[class='input_300']");
        var cbtn = $(obj).parent().next().next().next().find("input[type='button']");
        var sRebuyPeriodType = $(obj).parent().next().next().next().find("select");

        cbtn.attr("value", "设置");;
//    $("#"+divID+" option:first").attr("selected", 'selected');

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
            cKey.attr("placeholder", "请设置关键字");
            cbtn.attr("class", "input-butto100-xls");
            cbtn.removeAttr("disabled");
            cKey.removeAttr("disabled");
        }

        reTaskShopCount(); //重新继续pc和app任务数量
        var screenshotTrain = '';
        var mobileScreenshotTrain = '';
        var screenshotTianMao = '';
        var qRCode = '';
        var isTmallImgRemind = 'False';
    }

//alert($("#IDSearchType").val());
function CheckNext(){
    //var dodb=1;// 执行提交表单操作   
    var myarr=new Array();
	if($("input[name=proid]").val()){
		//关键词  cSearchType.indexOf('PC')
		var keyword="<?=$proinfo->commodity_title?>";	
			
		var n=0;
		$("#optionContainerShop input[class=input_300]").each(function () {
			//alert($(this).attr('id'));
		    var serchtype = $(this).attr('data').replace(/SearchType/g, "SearchType");
			var serchCount = $(this).attr('id').replace(/FineTaskCategroy/g, "SearchKey");
			
			 if($("#"+serchtype).val() != 0 ){
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
		var count = "<?=$counttask?>";
		var want = $("#taskShopCount").html();
		if(count>want){
			$("#frm").submit(); 
		}else{
			$.openAlter("您的店铺潜在用户不足，无法发布！", "提示");
		}
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

//计算所有行的任务数量 区分PC 无线端
function reTaskShopCount(){

    //alert('111111111');
    //$.openAlter("统计单钱列表的数据 Pc   无线", "提示");
    var taskTotal = 0;  //任务总数
    var pcTotal = 0;  //PC任务总数
    var appTotal = 0;  //App任务总数
    $("#optionContainerShop input[class=input_60]").each(function () {
        if ($(this).val() != " " && $(this).val() != "" && $(this).val() != null) {
            taskTotal += parseInt($(this).val());
        }
        var cSearchType = $(this).parent().parent().find('td').eq(0).find('select > option:selected').text();
        if (cSearchType.indexOf('PC') != -1) {
            if ($(this).val() != " " && $(this).val() != "" && $(this).val() != null) {
                pcTotal += parseInt($(this).val());
            }
        }else if (cSearchType.indexOf('APP') != -1 ||  cSearchType.indexOf('手机') != -1) {
            if ($(this).val() != " " && $(this).val() != "" && $(this).val() != null) {
                appTotal += parseInt($(this).val());
            }
        }

    });
    $("#taskShopCount").text(taskTotal);
    $("#pcShopCount").text(pcTotal);
    $("#appShopCount").text(appTotal);
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
</body>
</html>