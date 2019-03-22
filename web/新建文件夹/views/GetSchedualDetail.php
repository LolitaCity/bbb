    <?php require_once('include/header.php')?>  
    <script src="<?=base_url()?>style/md5.js" type="text/javascript"></script>
    <script src="<?=base_url()?>style/jquery.jBox-2.3.min.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>style/jbox.css">
    
    
    <!--uploadify-->
    <style type="text/css">
        #Schedual
        {
            background: #3b6cca;
            color: White;
        }
    </style>
    <style type="text/css">
        .sk-zjgl_4
        {
            width: 180px;
        }
        
        #ulDetail li a img
        {
            width: 200px;
            height: 150px;
            margin: 5px 0px;
        }
        
        .nav
        {
            background: #0866c6;
        }
        
        body
        {
            background: white;
            font-size: 12px;
        }
        
        #liDetail table tr th
        {
            text-align: center;
        }
        
        .trCommit th
        {
            border-bottom: 1px dashed gray;
        }
        
        #tbCommit tr th
        {
            padding-left: 15px;
        }
        
        #tbCommit tr:hover th
        {
            background-color: #c8dbee;
        }
        
        #liDetail tr:hover th
        {
            background-color: #c8dbee;
        }
    </style>
    <script type="text/javascript">

        function Submit() {
            var answer = $.trim($("#Answer").val());
            if (answer == "" || answer == null) {
                $.openAlter('我想说请输入内容', '提示', { width: 450, height: 250 });
                return false;
            }
            $("#fm").submit();
        }    
        function GoBack() {
            var hidLength = $("#hidLength").val();
            hidLength = parseInt(hidLength);
            var length = window.history.length;
            length = parseInt(length);
            if (hidLength != length) {
                var i = hidLength - length;
                i = parseInt(i);
                window.history.go(-1 + i);
            }
            else {
                window.history.go(-1);
            }
        }    

    </script>


<body style="background: #fff;">
      <?php require_once('include/nav.php')?>  
    <!--daohang-->
    
    
<form action="<?=site_url('customer/sendone')?>" enctype="multipart/form-data" id="fm" method="post">        
        <!--添加商品-->
        <div class="yctc_458 ycgl_tc_22" style="width: 950px;">
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
            <input id="WorkOrderID" name="WorkOrderID" type="hidden" value="<?=$cominfo->id?>">
            <input name="sellerid" type="hidden" value="<?=$cominfo->merchantid?>">
            
            <input type="hidden" value="50" id="hidLength">
            <ul>
                <li class="fpgl-tc-qxjs" style="text-align: left; color: Black;">
                    <label>
                        工单详情</label><input onclick="GoBack()" class="input-butto100-ls" type="button" style="height: 35px;
                            margin-left: 15px;" value="返回列表">
<br>
                </li>
            </ul>
<script type="text/javascript">
    $(document).ready(function () {
        if ($("#tbCommit").find("tr").length <= 1) {
            $("#tbCommit").hide();
        }
    })
</script>
<ul id="ulDetail">
    <li id="liDetail" style="margin-top: 10px;">
        <table style="border-bottom-width: 1px; border-left-width: 1px; border-top-width: 1px;
            border-right-width: 1px;">
            <tbody><tr>
                <th width="120">
                    任务编号：
                </th>
                <th width="180">
                    <?=$cominfo->tasksn?>
                </th>
                <th width="180">
                    订单编号：
                </th>
                <th width="180">
                    <?=$cominfo->ordersn?>
                </th>
                <th width="180">
                    工单状态：
                </th>
                <th width="180">
                                        <?php switch ($cominfo->status){
                                            case 0:echo '待处理';break;
                                            case 1:echo '更进中';break;
                                            case 2:echo '待执行';break;
                                            case 3:echo '处理完成';break;
                                            case 4:echo '已撤销';break;
                                            case 5:echo '拒绝处理';break;
                                            default:echo '出错了';break;
                                        }?>
                </th>
            </tr>
            <tr>
                <th width="180">
                    工单类型：
                </th>
                <th width="180">
                    <?php foreach($type as $vt){
                        if($vt->id == $cominfo->typeid){
                            echo $vt->typename;
                        }
                    }?>
                </th>
                <th width="180">
                    问题分类：
                </th>
                <th width="250">
                    <?php foreach($type as $vt){
                        if($vt->id == $cominfo->questionid){
                            echo $vt->typename;
                        }
                    }?>
                </th>
                <th width="180">
                    提交时间：
                </th>
                <th width="180" style=" padding-right: 25px; text-align: left;">
                    <?=@date('Y-m-d H:i:s',$cominfo->addtime)?>
                </th>
            </tr>
        </tbody>
        </table>
    </li>
    <li style="margin-top: 10px;">
        <table id="tbCommit" style="border-width: 1px 1px; text-align: left;">
            <tbody><tr>
                <th style="text-align: left;">
                    沟通记录
                </th>
            </tr>
                <?php foreach($list as $info):?>
                <tr class="trCommit">
                    <th style="text-align: left; word-break: break-all;">
                        <?=$info->status=='0'?'商家':'管理员'?>： <span style="word-break: break-all;"><?=$info->content?></span><br>
                            <?php if($info->contentimg!=''):?>
                                <?php $pics=unserialize($info->contentimg)?>
                                <?php if(count($pics)!=0):?>
                                    <?php foreach($pics as $vp):?>
                                    <a href="<?=$vp?>" onclick="javascript:void(0)" target="_blank" title="点击查看大图">
                                        <img src="<?=$vp?>" style="width:200px; height:150px;">
                                    </a>
                                    <?php endforeach;?>
                                <?php endif;?>
                            <?php endif;?>                            
                        <br>
                        <?=@date('Y-m-d H:i:s',$info->addtime)?>
                    </th>
                </tr>
                <?php endforeach;?>
         
        </tbody></table>
    </li>
        <li id="commitLi">
            <ul>
                <li style="margin-top: 10px;">
                    <table style="border-width: 1px 1px; text-align: left;">
                        <tbody><tr>
                            <th colspan="3" style="text-align: left;">
                                我想说：
                            </th>
                        </tr>
                        <tr>
                            <td colspan="3" style="text-align: left;">
                                <textarea class="input_44" cols="20" id="Answer" maxlength="200" name="Answer" placeholder="请输入想说的话" rows="2" style="height: 100%; width: 100%;padding:0px 0px"></textarea>
                            </td>
                        </tr><tr>
                            <th colspan="3" style="text-align: left;">
                                上传截图：
                            </th>
                        </tr>                        
                        <tr>
                            <td colspan="3" style="text-align: left;">
                               <input type="file" multiple="multiple" name="multiple[]">
                            </td>
                        </tr>
                    </tbody></table>
                </li>
                <li style="margin-top: 0px;">
                    <table style="border-width: 1px 1px; text-align: left; border-top: 0px;">
                        <tbody><tr>
                            <td>
                                <input class="input-butto100-hs" type="button" id="btnSubmint" value="提交" onclick="Submit();" style="float: right; margin-right: 5px; width: 127px; height: 35px;">
                            </td>
                            <td>
                                <p style="width: 50%;">
                                    <input onclick="GoBack()" class="input-butto100-ls" type="button" style="height: 35px;
                                        float: left; margin-left: 5px;" value="返回列表"></p>
                            </td>
                        </tr>
                    </tbody></table>
                </li>
            </ul>
        </li>
</ul>
        </div>
    
</form>

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

</script>

<?php require_once('include/footer.php')?>


</body></html>