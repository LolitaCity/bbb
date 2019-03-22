<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title></title>

<script src="<?=base_url()?>style/jquery-1.8.3.js"
	type="text/javascript"></script>
<script src="<?=base_url()?>style/jquery.jslides.js"
	type="text/javascript"></script>
<script src="<?=base_url()?>style/open.win.js" type="text/javascript"></script>
<script src="<?=base_url()?>style/jquery.jBox-2.3.min.js"
	type="text/javascript"></script>
	<script src="<?=base_url()?>style/ext/public.js" type="text/javascript"></script>
	<script src="<?=base_url()?>style/ext/layer/layer.js" type="text/javascript"></script>
	
	
<!-- <link href="http://v3.bootcss.com/dist/css/bootstrap.min.css" -->
<!-- 	rel="stylesheet" /> -->
<!-- <link href="data:text/css;charset=utf-8," -->
<!-- 	data-href="http://v3.bootcss.com/dist/css/bootstrap-theme.min.css" -->
<!-- 	rel="stylesheet" id="bs-theme-stylesheet" /> -->
	
	
	<link rel="stylesheet" type="text/css"
	href="<?=base_url()?>style/jbox.css">
<link rel="stylesheet" type="text/css"
	href="<?=base_url()?>style/common.css">
<link rel="stylesheet" type="text/css"
	href="<?=base_url()?>style/index.css">
<link rel="stylesheet" type="text/css"
	href="<?=base_url()?>style/open.win.css">
<link rel="stylesheet" type="text/css"
	href="<?=base_url()?>style/selectproduct.css">


<style type="text/css">
	.is-disabled
	{
	    background-color: #eef1f6;
	    border-color: #d1dbe5;
	    color: #bbb;
	    cursor: not-allowed;
	}
</style>

</head>
<body style="background: #fff;">
	<!--列表 -->
	<!--<div class="htyg_tc">
		<ul>
			<li class="htyg_tc_1" style="font-family: Microsoft YaHei;"
				onclick="alert('aa');">选择商品</li>
			<li class="htyg_tc_2">
				<i class="input-butto100-ls" style="color: #DDD; margin: 5px 10px;" id="imgeColse"
				onclick="javascript:self.parent.$.closeWin()">关闭</i></li>
		</ul>
	</div>-->

	<script language="javascript">
        function Cancel() {
            window.parent.window.jBox.close();
        }
        function searchProduct(){
            var url="<?=site_url('sales/SelectProduct/'.$infoint)?>";
            var post="?ShopID="+$('#selShopList option:selected').val()+"&SelSearch="+$('#SelSearch option:selected').val()+"&TxtSearch="+$('#TxtSearch').val();
            url = url+post;
            //alert(url);
            window.location.href=url;
        }
    </script>
	<!--添加弹窗 选择商品 -->
	<div id="light1" class="ycgl_tc yctc_840"
		style="display: block; height: 90%">
		<div class="yctc_800 ycgl_tc_1">
			<!--搜索 -->
			<p style="color: red;">
				未订购小助手或者小助手已失效的店铺将无法发布任务，如需&nbsp;<a href="/member/smartSettings.html" style="color: red;"  target="_blank">前往订购</a>
			</p>
			<br />
			<div class="fprw-xzgl">
				<p class="fprw-xzgl_1">选择店铺:</p>
				<p>
					<select class="select_215" id="selShopList" name="ShopID"
						onchange="shopChange(this)">
						<option selected="selected" value="0">所有店铺</option>
                        <?php foreach ($shops as $vs):?>
                    		<option value="<?=$vs->sid?>" <?=$vs -> api_expiration_time > time() ? '' : ($use_helper -> value ? 'disabled' : '')?>><?=$vs->shopname?></option>
                        <?php endforeach;?>
                    </select>
				</p>
				<p>
					<select class="select_215" id="SelSearch" name="SelSearch"
						style="width: 80px">
						<option value="commodity_id">商品ID</option>
						<option value="commodity_title">商品名称</option>
						<option value="commodity_abbreviation">商品简称</option>
					</select>
				</p>
				<p>
					<input class="input_305" id="TxtSearch" name="TxtSearch"
						style="width: 200px; height: 33px;" type="text"
						value="<?=$TxtSearch?>">
				</p>
				<p style="margin-right: 0px">
					<input class="input-butto100-ls" type="button" value="搜索"
						onclick="searchProduct()">
				</p>
			</div>
			<script>
        	$("#selShopList").val("<?=$shopid?>");
        	$("#SelSearch").val("<?=$serachtype==''?'commodity_id':$serachtype?>");
            </script>
			<!--搜索 -->
			<div style="overflow: auto; height: 370px">
				<div class="fprw-sdsp_2">
					<table>
						<tbody>
							<tr>
								<th width="100">选择商品</th>
								<th width="100">店铺名</th>
								<th width="100">商品简称</th>
								<th width="100">略缩图</th>
								<th width="100">商品ID</th>
								<th width="395">商品标题</th>
							</tr>
                            <?php foreach($pros as $vp):?>                                                      
                                <tr class="<?=$vp -> api_expiration_time > time() ? '' : ($use_helper -> value ? 'is-disabled' : '');?> show show<?=$vp->shopid?>">
								<td>
									<input class="input-radio16" type="radio" name="radio" <?=$vp -> api_expiration_time > time() ? '' : ($use_helper -> value ? 'disabled' : '')?> value="<?=$vp->id?>">
								</td>
								<td><?php foreach($shops as $vs){if($vs->sid == $vp->shopid){echo $vs->shopname;}}?></td>
								<td><?=$vp->commodity_abbreviation?></td>
								<td>
									<?php $vp->commodity_image= str_replace ( 'pk1172' , '18zang' ,  $vp->commodity_image); ?>
									<img width="60px" src="<?=$vp->commodity_image;?>" alt="" />
								</td>
								<td><?=$vp->commodity_id?></td>
								<td><?=$vp->commodity_title?></td>
							</tr>
                            <?php endforeach;?>                            
                        </tbody>
					</table>
				</div>
			</div>
			<div class="fprw-xzgl_2">
				<input onclick="Save()" class="input-butto100-ls" type="button"
					value="确定">
			</div>
		</div>
	</div>
	<script>
    function shopChange(obj){
    	if(obj.value==0){
        	$(".show").show();
    	}else{
    		$(".show").hide();
    		$(".show"+obj.value).show();
    	}
    }
    function check(){
        var sel = 0;
        for (var i = 0; i < document.getElementsByName("radio").length; i++){
                       　　if(document.getElementsByName("radio")[i].checked){
                        　　    sel = document.getElementsByName("radio")[i].value;
                       　　 }
            　           }
        return sel;
    }
    function Save()
    {
        var proid=check();
        if(proid==0)
        {
            alert('请先选择产品!');
        }
        else
        {
        	var url="<?=site_url('sales')?>";
            url += '?id='+"<?=$infoint?>"+"&proid="+proid;
        	public.ajax('/sales/checkBondShopNum', {proid: proid}, function(datas){
        		if (datas.status)
        		{
        			parent.location.href=url;
        		}
        		else
        		{
        			dialog.confirm(datas.message, '继续发布', '取消发布', function(){
			            parent.location.href=url;
        			})
        		}
        	});
        }
    }
</script>


</body>
</html>