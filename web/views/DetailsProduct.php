<?php require_once('include/header.php')?>  
<body style="background: #fff;">
   <?php require_once('include/nav.php')?>  
  	<div class="sj-zjgl">
        <?php require_once('include/member_menu.php')?>    		
	</div>
        
<form action="#" enctype="multipart/form-data" id="fm" method="post">        <!--表格内容 END-->
        <!--添加商品-->
        <div class="yctc_458 ycgl_tc_1" style="width: 750px;">
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
            <ul id="ulDetail">
                <li class="fpgl-tc-qxjs">商品详细信息</li>
                <li>
                    <p class="sk-zjgl_4" id="pUrl"> 店&nbsp;铺&nbsp;名：</p>
                    <label id="lblShopName" style="line-height: 35px;"><?=$proinfo->shopname?>
                    </label>
                </li>
                <li>
                    <input id="ProductID" name="ProductID" type="hidden" value="87ab9b6c-3caf-41fa-a767-7aeb64431d52">
                    <input id="Screenshot" name="Screenshot" type="hidden" value="UpdateImage_550768502134_TB1CGpRXlLN8KJjSZFPXXXoLXXa_!!0-item_pic.jpg_400x400q90.jpg">
                    <p class="sk-zjgl_4">商品简称：</p>
                    <p style="line-height: 35px;"><?=$proinfo->commodity_abbreviation?></p>
                </li>
                <li>
                    <p class="sk-zjgl_4" id="pUrl">
                        &nbsp;商品链接：</p>
                    <label id="lblUrl" style="line-height: 35px; word-break:break-all; width:540px; float:left;"><?=$proinfo->commodity_url?><a href="<?=$proinfo->commodity_url?>" target="_blank" style=" color:blue">点击查看</a></label>
                </li>
                <li>
                    <p class="sk-zjgl_4" id="pFullName">商品名称：</p>
                    <label id="lblFullName" style="line-height: 35px;"><?=$proinfo->commodity_title?></label>
                </li>
                <li>
                    <p class="sk-zjgl_4">商品ID：</p>
                    <label style="line-height: 35px;"><?=$proinfo->commodity_id?></label>
                </li>
                  <li>  
                        <p class="sk-zjgl_4">主图预览：</p>
						<?php $proinfo->commodity_image= str_replace ( 'pk1172' , '18zang' , $proinfo->commodity_image );  ?>
                        <a href="<?=$proinfo->commodity_image?>" onclick="javascript:void(0)" target="_blank" title="点击查看大图">
                            <img src="<?=$proinfo->commodity_image?>" style="width:200px; height:150px;">
                        </a></li>
                    <li style=" margin-top:25px;">
                        <p class="sk-zjgl_4">二维码图：</p>
						<?php $proinfo->qrcode= str_replace ( 'pk1172' , '18zang' , $proinfo->qrcode );  ?>
                        <a href="<?=$proinfo->qrcode?>" onclick="javascript:void(0)" target="_blank" title="点击查看大图">
                            <img src="<?=$proinfo->qrcode?>" style="width:200px; height:150px;">
                        </a>
                    </li>
                    
                    <li style=" margin-top:25px;">
                        <p class="sk-zjgl_4">直通车图片：</p>
						<?php $proinfo->through_train_1= str_replace ( 'pk1172' , '18zang' , $proinfo->through_train_1 );  ?>
                        <a href="<?=$proinfo->through_train_1?>" onclick="javascript:void(0)" target="_blank" title="点击查看大图">
                            <img src="<?=$proinfo->through_train_1?>" style="width:200px; height:150px;">
                        </a>
                    </li>
                    
                    <li style=" margin-top:25px;">
                        <p class="sk-zjgl_4"> &nbsp;</p>
						<?php $proinfo->through_train_2= str_replace ( 'pk1172' , '18zang' , $proinfo->through_train_2 );  ?>
                        <a href="<?=$proinfo->through_train_2?>" onclick="javascript:void(0)" target="_blank" title="点击查看大图">
                            <img src="<?=$proinfo->through_train_2?>" style="width:200px; height:150px;">
                        </a>
                    </li>
                    
                    <li style=" margin-top:25px;">
                        <p class="sk-zjgl_4">&nbsp;</p>
						<?php $proinfo->through_train_3= str_replace ( 'pk1172' , '18zang' , $proinfo->through_train_3 );  ?>
                        <a href="<?=$proinfo->through_train_3?>" onclick="javascript:void(0)" target="_blank" title="点击查看大图">
                            <img src="<?=$proinfo->through_train_3?>" style="width:200px; height:150px;">
                        </a>
                    </li>
                    
                    <li style=" margin-top:25px;">
                        <p class="sk-zjgl_4">&nbsp;</p>
						<?php $proinfo->through_train_4= str_replace ( 'pk1172' , '18zang' , $proinfo->through_train_4 );  ?>
                        <a href="<?=$proinfo->through_train_4?>" onclick="javascript:void(0)" target="_blank" title="点击查看大图">
                            <img src="<?=$proinfo->through_train_4?>" style="width:200px; height:150px;">
                        </a>
                    </li>
                <li class="fpgl-tc-qxjs_4" style="margin-left: 280px;">
                    <p>
                        <input onclick="window.close()" class="input-butto100-ls" type="button" value="关闭"></p>
                </li>
            </ul>
        </div>
</form>
    </div>

<style type="text/css">
        /* online */
        #online_qq_tab a, .onlineMenu h3, .onlineMenu li.tli, .newpage
        {
            background: url(<?=base_url()?>style/images/float_s.gif) no-repeat;
        }
        #onlineService, .onlineMenu, .btmbg
        {
            background: url(<?=base_url()?>style/images/float_bg.gif) no-repeat;
        }
        
        #online_qq_layer
        {
            z-index: 9999;
            position: fixed;
            right: 0px;
            top: 0;
            margin: 150px 0 0 0;
        }
        *html, *html body
        {
            background-image: url(about:blank);
            background-attachment: fixed;
        }
        *html #online_qq_layer
        {
            position: absolute;
            top: expression(eval(document.documentElement.scrollTop));
        }
        
        #online_qq_tab
        {
            width: 28px;
            float: left;
            margin: 403px 0 0 0;
            position: relative;
            z-index: 9;
        }
        #online_qq_tab a
        {
            display: block;
            height: 118px;
            line-height: 999em;
            overflow: hidden;
        }
        #online_qq_tab a#floatShow
        {
            background-position: -30px -374px;
        }
        #online_qq_tab a#floatHide
        {
            background-position: 0 -374px;
        }
        
        #onlineService
        {
            display: inline;
            margin-left: -1px;
            float: left;
            width: 130px;
            background-position: 0 0;
            padding: 10px 0 0 0;
            margin-top:400px
        }
        .onlineMenu
        {
            background-position: -262px 0;
            background-repeat: repeat-y;
            padding: 0 15px;
        }
        .onlineMenu h3
        {
            height: 36px;
            line-height: 999em;
            overflow: hidden;
            border-bottom: solid 1px #ACE5F9;
        }
        .onlineMenu h3.tQQ
        {
            background-position: 0 10px;
        }
        .onlineMenu h3.tele
        {
            background-position: 0 -47px;
        }
        .onlineMenu li
        {
            height: 36px;
            line-height: 36px;
            border-bottom: solid 1px #E6E5E4;
            text-align: center;
        }
        .onlineMenu li.tli
        {
            padding: 0 0 0 28px;
            font-size: 12px;
            text-align: left;
        }
        .onlineMenu li.zixun
        {
            background-position: 0px -131px;
        }
        .onlineMenu li.fufei
        {
            background-position: 0px -190px;
        }
        .onlineMenu li.phone
        {
            background-position: 0px -244px;
        }
        .onlineMenu li a.newpage
        {
            display: block;
            height: 36px;
            line-height: 999em;
            overflow: hidden;
            background-position: 5px -100px;
        }
        .onlineMenu li img
        {
            margin: 8px 0 0 0;
        }
        .onlineMenu li.last
        {
            border: 0;
        }
        
        .wyzx
        {
            padding: 8px 0 0 5px;
            height: 57px;
            overflow: hidden;
            background: url(<?=base_url()?>style/images/webZx_bg.jpg) no-repeat;
        }
        
        .btmbg
        {
            height: 12px;
            overflow: hidden;
            background-position: -131px 0;
        }
    </style>
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


</body></html>