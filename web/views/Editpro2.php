<?php require_once('include/header.php')?> 
<script src="<?=base_url()?>style/ext/layer/layer.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>style/proadd.css"> 
<style type="text/css">
	.is-disabled
	{
	    background-color: #eef1f6;
	    border-color: #d1dbe5;
	    color: #bbb;
	    cursor: not-allowed;
	}
</style> 
<body style="background: #fff;">
   
    <?php require_once('include/nav.php')?>
    <div class="sj-zjgl">
        <?php require_once('include/member_menu.php')?>    		
	</div>
        
<form action="<?=site_url('member/editDB')?>" enctype="multipart/form-data" id="fm2" method="post">   
        <div class="yctc_458 ycgl_tc_1" id="divMain" style="width: 700px;">
            <ul>
                <li>
                    <p class="sk-zjgl_4">
                    </p>
                    <div class="errorbox" id="clientValidation1" style="display: none; width: 600px;
                        height: 25px;">
                        <ol style="list-style-type: decimal" id="clientValidationOL1">
                        </ol>
                    </div>
                </li>
                <li class="fpgl-tc-qxjs">修改商品</li>
                <?php if ($use_helper -> value):?>
                <li style="text-align: center; cursor: default; color: #888">----------------------------------------------------商品基本信息-------------------------------------------------</li>
                <li>
                    <p class="sk-zjgl_4">掌柜号：</p>
                    <input id="Upfiles" name="Upfiles" type="hidden" value="">
                    <input id="UpfileTrain" name="UpfileTrain" type="hidden" value="">
                    <input id="CopyToMob" name="CopyToMob" type="hidden" value="">
                    <input id="PlatformType" name="PlatformType" type="hidden" value="淘宝">
                    <p style="line-height: 38px;">
                    <select id="selShopList" class="select_215 is-disabled" name="PlatformNoID" onchange="ChangePlatform(this)" style="width:405px" disabled="disabled">
                        <option selected="selected" value="0">请选择</option>
                            <?php foreach($shoplist as $vs):?>
                                <option value="<?=$vs->sid?>"><?=$vs->shopname?></option>
                            <?php endforeach;?>
                    </select>
                    </p>
                </li>
                <script>
            	$("#selShopList").val("<?=$proinfo->shopid?>");
                </script>
                <li>
	                <p class="sk-zjgl_4">商品ID：</p>
	                <p style="line-height: 38px;">
	                    <input id="txtShortName" class="input_417" maxlength="50" name="ID" placeholder="请输入该产品在淘宝后台的商品ID" type="text" disabled="disabled" value="<?=$proinfo->commodity_id?>">
	                </p>
	                <p>
                    	&nbsp;&nbsp;<input onclick="getProductInfos()" class="input-butto100-ls" type="button" value="更新商品详情" style="border-radius: 0;">
                    </p>
	            </li> 
                <li>
                    <p class="sk-zjgl_4">商品链接：</p>
                    <p style="line-height: 38px;">
                        <input class="input_417 is-disabled" id="Url" maxlength="500" name="Url" placeholder="商品链接地址（完整的网址）" type="text" readonly="readonly" value="<?=$proinfo->commodity_url?>"><br>
                    </p>
                </li>
                <li>
                    <p class="sk-zjgl_4">商品名称：</p>
                    <p style="line-height: 38px;">
                        <input class="input_417 is-disabled" id="FullNameShow" maxlength="200" name="FullName" placeholder="" type="text" readonly="readonly" value="<?=$proinfo->commodity_title?>">
                    </p>
                </li>
                <li>
                    <p class="sk-zjgl_4"> 商品主图：</p>
                    <div style="margin-left: 130px;">
                        <a id="aMainProductImg" target="_blank" style="display: block;">
                            <img alt="" id="mainProductImg"  width="180" height="180" src="<?=$proinfo->commodity_image?>">
                        </a>
                        <input class="input_417" id="master_img" maxlength="200" name="master_img" placeholder="" type="hidden" readonly="readonly" value="<?=$proinfo->commodity_image?>">
                    </div>
                </li>
                <li style="text-align: center; cursor: default; color: #888">----------------------------------------------------其它商品信息-------------------------------------------------</li>
                    <li>
                        <p class="sk-zjgl_4">商品简称：</p>
                        <p style="line-height: 38px;">
                            <input id="txtShortName" class="input_417" maxlength="50" name="ShortName" placeholder="输入2-10位中文、数字、英文，简称可以帮助你快速识别商品" type="text" value="<?=$proinfo->commodity_abbreviation?>">
                        </p>
                    </li>   
                <li>
                    <p class="sk-zjgl_4"> 二维码图片：</p>
                    <div id="PCTaoBaoBrowse">
                        <div>
                            <p class="sjzc_6_tu" >
                                <a href="javascript:openBrowse('qrCode')" title="指的是该商品的二维码展示图，此图会展现在无线端二维码任务中，主要作用是让买手扫二维码进入到目标商品。"></a>
                            </p>
                            <img id="previewImage8" style="margin-left: 10px; display: none; width: 100px; height: 70px;">
                        </div>
                        <img id="previewImage1" style="margin-left: 10px; display: none; width: 100px; height: 70px;">
                    </div>
                    <p><input type="file" id="qrCode" style="display: none" name="qrcode[]"></p>
                        <div style="margin-left: 130px;">
                            <a id="qrCodeImg" target="_blank">
                                <img alt="" id="qrCodePic"  width="100" height="70"  src="<?=$proinfo->qrcode?>">
                            </a>
                        </div>
                </li>
				<li>
                    <p class="sk-zjgl_4"> 无线端商品主图：</p>
                    <div id="PCTaoBaoBrowse">
                        <div>
                            <p class="sjzc_6_tu" >
                                <a href="javascript:openBrowse('app_img')" title="指的是该商品的二维码展示图，此图会展现在无线端二维码任务中，主要作用是让买手扫二维码进入到目标商品。"></a>
                            </p>
                            <img id="previewImage8" style="margin-left: 10px; display: none; width: 100px; height: 70px;">
                        </div>
                        <img id="previewImage1" style="margin-left: 10px; display: none; width: 100px; height: 70px;">
                    </div>
                    <p><input type="file" class="through_train" id="app_img" style="display: none" name="app_img[]"></p>
                        <div style="margin-left: 130px;">
                            <a id="app_img_Img" target="_blank">
                                <img alt="" id="app_img_Pic"  width="100" height="70"  src="<?=$proinfo->app_img?>">
                            </a>
                        </div>
                </li>
                <li>
                    <p class="sk-zjgl_4"> 直通车展示图：</p>
                    <div id="PCTaoBaoBrowse">
                        <div>
                            <p class="sjzc_6_tu" >
                                <a href="javascript:openBrowse('through_train_1')" title="直通车展示图，发布直通车任务时可选"></a>
                            </p>
                            <img id="previewImage8" style="margin-left: 10px; display: none; width: 100px; height: 70px;">
                        </div>
                        <img id="previewImage1" style="margin-left: 10px; display: none; width: 100px; height: 70px;">
                    </div>
                    <p><input class="through_train" type="file" id="through_train_1" style="display: none" name="through_train_1[]"></p>
                    <div style="margin-left: 130px;">
                        <a id="through_train_1_Img" target="_blank">
                            <img alt="" id="through_train_1_Pic"  width="100" height="70"  src="<?=$proinfo->through_train_1?>">
                        </a>
                    </div>
                </li>
                <li>
                    <p class="sk-zjgl_4"> &nbsp;</p>
                    <div id="PCTaoBaoBrowse">
                        <div>
                            <p class="sjzc_6_tu" >
                                <a href="javascript:openBrowse('through_train_2')" title="直通车展示图，发布直通车任务时可选"></a>
                            </p>
                            <img id="previewImage8" style="margin-left: 10px; display: none; width: 100px; height: 70px;">
                        </div>
                        <img id="previewImage1" style="margin-left: 10px; display: none; width: 100px; height: 70px;">
                    </div>
                    <p><input class="through_train" type="file" id="through_train_2" style="display: none" name="through_train_2[]"></p>
                    <div style="margin-left: 130px;">
                        <a id="through_train_2_Img" target="_blank">
                            <img alt="" id="through_train_2_Pic"  width="100" height="70"  src="<?=$proinfo->through_train_2?>">
                        </a>
                    </div>
                </li>
                <li>
                    <p class="sk-zjgl_4"> &nbsp;</p>
                    <div id="PCTaoBaoBrowse">
                        <div>
                            <p class="sjzc_6_tu" >
                                <a href="javascript:openBrowse('through_train_3')" title="直通车展示图，发布直通车任务时可选"></a>
                            </p>
                            <img id="previewImage8" style="margin-left: 10px; display: none; width: 100px; height: 70px;">
                        </div>
                        <img id="previewImage1" style="margin-left: 10px; display: none; width: 100px; height: 70px;">
                    </div>
                    <p><input class="through_train" type="file" id="through_train_3" style="display: none" name="through_train_3[]"></p>
                    <div style="margin-left: 130px;">
                        <a id="through_train_3_Img" target="_blank">
                            <img alt="" id="through_train_3_Pic"  width="100" height="70"  src="<?=$proinfo->through_train_3?>">
                        </a>
                    </div>
                </li>
                <li>
                    <p class="sk-zjgl_4"> &nbsp;</p>
                    <div id="PCTaoBaoBrowse">
                        <div>
                            <p class="sjzc_6_tu" >
                                <a href="javascript:openBrowse('through_train_4')" title="直通车展示图，发布直通车任务时可选"></a>
                            </p>
                            <img id="previewImage8" style="margin-left: 10px; display: none; width: 100px; height: 70px;">
                        </div>
                        <img id="previewImage1" style="margin-left: 10px; display: none; width: 100px; height: 70px;">
                    </div>
                    <p><input class="through_train" type="file" id="through_train_4" style="display: none" name="through_train_4[]"></p>
                    <div style="margin-left: 130px;">
                        <a id="through_train_4_Img" target="_blank">
                            <img alt="" id="through_train_4_Pic"  width="100" height="70"  src="<?=$proinfo->through_train_4?>">
                        </a>
                    </div>
                </li>
                <?php else:?>
                	<li style="text-align: center; cursor: default; color: #888">----------------------------------------------------商品基本信息-------------------------------------------------</li>
                <li>
                    <p class="sk-zjgl_4">掌柜号：</p>
                    <input id="Upfiles" name="Upfiles" type="hidden" value="">
                    <input id="UpfileTrain" name="UpfileTrain" type="hidden" value="">
                    <input id="CopyToMob" name="CopyToMob" type="hidden" value="">
                    <input id="PlatformType" name="PlatformType" type="hidden" value="淘宝">
                    <p style="line-height: 38px;">
                    <select id="selShopList" class="select_215" name="PlatformNoID" onchange="ChangePlatform(this)" style="width:405px">
                        <option selected="selected" value="0">请选择</option>
                            <?php foreach($shoplist as $vs):?>
                                <option value="<?=$vs->sid?>"><?=$vs->shopname?></option>
                            <?php endforeach;?>
                    </select>
                    </p>
                </li>
                <script>
            	$("#selShopList").val("<?=$proinfo->shopid?>");
                </script>
                <li>
                    <p class="sk-zjgl_4">商品链接：</p>
                    <p style="line-height: 38px;">
                        <input class="input_417" id="Url" maxlength="500" name="Url" placeholder="商品链接地址（完整的网址）" type="text" value="<?=$proinfo->commodity_url?>"><br>
                    </p>
                </li>
                <li>
                    <p class="sk-zjgl_4">商品名称：</p>
                    <p style="line-height: 38px;">
                        <input class="input_417" id="FullNameShow" maxlength="200" name="FullName" placeholder="" type="text" value="<?=$proinfo->commodity_title?>">
                    </p>
                </li>
                    <li>
                        <p class="sk-zjgl_4">商品简称：</p>
                        <p style="line-height: 38px;">
                            <input id="txtShortName" class="input_417" maxlength="50" name="ShortName" placeholder="输入2-10位中文、数字、英文，简称可以帮助你快速识别商品" type="text" value="<?=$proinfo->commodity_abbreviation?>">
                        </p>
                    </li> 
                    <li>
                        <p class="sk-zjgl_4">商品ID：</p>
                        <p style="line-height: 38px;">
                            <input id="txtShortName" class="input_417" maxlength="50" name="ID" placeholder="请输入该产品在淘宝后台的商品ID" type="text" value="<?=$proinfo->commodity_id?>">
                        </p>
                    </li>     
                <li>
                    <p class="sk-zjgl_4"> 商品主图：</p>
                    <div id="PCTaoBaoBrowse">
                        <div>
                            <p class="sjzc_6_tu" >
                                <a href="javascript:openBrowse('upfilePCTaoBao')" title="商品主图。"></a>
                            </p>
                            <img id="previewImage8" style="margin-left: 10px; display: none; width: 100px; height: 70px;">
                        </div>
                        <img id="previewImage1" style="margin-left: 10px; display: none; width: 100px; height: 70px;">
                    </div>
                    <p>
                    <input type="file" id="upfilePCTaoBao" style="display: none" name="product[]" ></p>
                        <div style="margin-left: 130px;">
                            <a id="aMainProductImg" target="_blank">
                                <img alt="" id="mainProductImg"  width="100" height="70" src="<?=$proinfo->commodity_image?>">
                            </a>
                        </div>
                </li>
                <li>
                    <p class="sk-zjgl_4"> 二维码图片：</p>
                    <div id="PCTaoBaoBrowse">
                        <div>
                            <p class="sjzc_6_tu" >
                                <a href="javascript:openBrowse('qrCode')" title="指的是该商品的二维码展示图，此图会展现在无线端二维码任务中，主要作用是让买手扫二维码进入到目标商品。"></a>
                            </p>
                            <img id="previewImage8" style="margin-left: 10px; display: none; width: 100px; height: 70px;">
                        </div>
                        <img id="previewImage1" style="margin-left: 10px; display: none; width: 100px; height: 70px;">
                    </div>
                    <p><input type="file" id="qrCode" style="display: none" name="qrcode[]"></p>
                        <div style="margin-left: 130px;">
                            <a id="qrCodeImg" target="_blank">
                                <img alt="" id="qrCodePic"  width="100" height="70"  src="<?=$proinfo->qrcode?>">
                            </a>
                        </div>
                </li>  
            	<?php endif;?>              
           </ul>

    <script type="text/javascript">
	
	/*
	 * 更新商品详情
	 */
	function getProductInfos()
	{
		var $post = {
			'sid': $('select#selShopList').val(),
			'num_iid': $('input[name=ID]').val().trim(),
		};
		if ($post.sid != 0 && !isNaN($post.num_iid) && $post.num_iid != '')
		{
			public.ajax('/member/getProductInfos', $post, function(datas){
				console.log(datas);
				if (datas.status)
				{
					layer.close(layer.index);
					$('input#Url').val(datas.data.DetailUrl);
					$('input#FullNameShow').val(datas.data.Title);
					$('input#upfilePCTaoBao').val(datas.data.PicUrl);
					$('img#mainProductImg').attr('src', datas.data.PicUrl);
					$('#master_img').val(datas.data.PicUrl);
				}
				else
				{
					dialog.error(datas.message);
				}
			});
		}
		else
		{
			dialog.error('请选择对应的店铺或正确输入商品ID');
		}
	}
    	
    	
    function openBrowse(type) {
        document.getElementById(type).click();
    }
  //上传图片选择文件改变后刷新预览图
    $("#upfilePCTaoBao").change(function(e){
        //获取目标文件
        var file = e.target.files||e.dataTransfer.files;
        //如果目标文件存在
        if(file){
            //定义一个文件阅读器
            var reader = new FileReader();
            //文件装载后将其显示在图片预览里
            reader.onload=function(){
                $("#aMainProductImg").css('display','block');
                $("#mainProductImg").attr("src", this.result);
            }
            //装载文件
            reader.readAsDataURL(file[0]);
        }
    });    
    $("#qrCode").change(function(e){
        //获取目标文件
        var file = e.target.files||e.dataTransfer.files;
        //如果目标文件存在
        if(file){
            //定义一个文件阅读器
            var reader = new FileReader();
            //文件装载后将其显示在图片预览里
            reader.onload=function(){
                $("#qrCodeImg").css('display','block');
                $("#qrCodePic").attr("src", this.result);
            }
            //装载文件
            reader.readAsDataURL(file[0]);
        }
    });
    $(".through_train").change(function(e){
        //获取目标文件
        var file = e.target.files||e.dataTransfer.files;
        //如果目标文件存在
        if(file){
            //定义一个文件阅读器
            var reader = new FileReader();
            //文件装载后将其显示在图片预览里
            reader.onload=function(){
                $("#" + e.target.id + "_Img").css('display','block');
                $("#"+ e.target.id + "_Pic").attr("src", this.result);
            }
            //装载文件
            reader.readAsDataURL(file[0]);
        }
    });
    
     function clearNoNum(event, obj) {
            //响应鼠标事件，允许左右方向键移动 
            event = window.event || event;
            if (event.keyCode == 37 | event.keyCode == 39) {
                return;
            }
            //先把非数字的都替换掉，除了数字和. 
            obj.value = obj.value.replace(/[^\d.]/g, "");
            //必须保证第一个为数字而不是. 
            obj.value = obj.value.replace(/^\./g, "");
            //保证只有出现一个.而没有多个. 
            obj.value = obj.value.replace(/\.{2,}/g, ".");
            //保证.只出现一次，而不能出现两次以上 
            obj.value = obj.value.replace(".", "$#$").replace(/\./g, "").replace("$#$", ".");
        }
        function checkNum(obj) {
            //为了去除最后一个. 
            obj.value = obj.value.replace(/\.$/g, "");
        }
       
    </script>
    
<div>
        <ul>
            <li class="fpgl-tc-qxjs_4" style=" margin-left:120px">
                <p>
                    <input name="proid" type="hidden"  value="<?=$proinfo->id?>" >
                    <input class="input-butto100-hs" type="button" value="保存"  onclick="saveEdit()">
                </p>
                <p>
                    <input onclick="Cancel()" class="input-butto100-ls" type="button" value="关闭"></p>
            </li>
        </ul>
        <div class="fb_tjnn" style="width: 650px;">
            <div class="errorbox" id="clientValidation" style="display: none; width: 95%;">
                <ol style="list-style-type: decimal" id="clientValidationOL">
                </ol>
            </div>
        </div>
        <!--保存 END-->
</div>
        </div></form>

    </div>

<script language="javascript" type="text/javascript">
function saveEdit()
{
	var check_url = new RegExp(/http(s)?:\/\/([\w-]+\.)+[\w-]+(\/[\w- .\/?%&=]*)?/),
		check_desc = new RegExp(/^.{2,10}/);
	if($('select#selShopList').val() == 0)
	{
		return dialog.error('请选择商品对应的掌柜号');
	}
	if(!check_url.test($('input#Url').val()))
	{
		return dialog.error('请填写正确的商品链接');
	}
	if(!$.trim($('input#FullNameShow').val()))
	{
		return dialog.error('请填写商品名称');
	}
	if(!check_desc.test($('input[name=ShortName]').val()))
	{
		return dialog.error('请填写2-10位的商品简称');
	}
	if(!$.trim($('input[name=ID]').val()))
	{
		return dialog.error('请填写商品在淘宝后台的ID');
	}
//	if(!$('input#upfilePCTaoBao').val())
//	{
//		return dialog.error('请上传商品主图');
//	}
//	if(!$('input#qrCode').val())
//	{
//		return dialog.error('请上传二维码图片');
//	}
//	public.ajax('/member/editDB', $('#fm').serializer(), function(){
//		
//	});
	public.ajaxSubmit('fm2', function(datas){
		if(datas.status)
		{
			dialog.success(datas.message);
			location.href = '/member/product';
		}
		else
		{
			dialog.error(datas.message);
		}
	})	
}

function Cancel() {
    var type = window.location.search;
    if (type.indexOf("publish") > -1)
        history.back();
    else
        window.close();
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


</script>

    <?php require_once('include/footer.php')?>
 

</body></html>