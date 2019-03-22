<?php require_once('include/header.php')?> 
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>style/proadd.css"> 
<body style="background: #fff;">
   
    <?php require_once('include/nav.php')?>
    <!--daohang-->
    
    <div class="sj-zjgl">
        <div class="zjgl-left">
            <h2 style="background: url(<?=site_url()?>images/hygl.png) no-repeat 22px 22px;">
                会员中心</h2>
            <ul>
                <li><a href="<?=site_url('member')?>">基本资料</a></li>
                <li><a href="<?=site_url('member/store')?>" >店铺管理</a></li><!--  选中栏目 -->
                <li><a href="<?=site_url('member/product')?>" style="background: #eee;color: #ff9900;">商品管理</a></li>                
                <li><a href="<?=site_url('member/notice')?>">平台公告</a></li>
                <li><a href="<?=site_url('member/edit')?>">调整单量</a></li>
            </ul>
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
                <li class="fpgl-tc-qxjs">添加商品</li>
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
                    <input type="file" id="upfilePCTaoBao" style="display: none" name="product" ></p>
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
                    <p><input type="file" id="qrCode" style="display: none" name="qrcode"></p>
                        <div style="margin-left: 130px;">
                            <a id="qrCodeImg" target="_blank">
                                <img alt="" id="qrCodePic"  width="100" height="70"  src="<?=$proinfo->qrcode?>">
                            </a>
                        </div>
                </li>              
           </ul>

    <script type="text/javascript">
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
                    <input class="input-butto100-hs" type="submit" value="保存" >
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