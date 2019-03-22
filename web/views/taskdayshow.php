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
    <link href="<?=base_url()?>style/css.css" rel="stylesheet" type="text/css">
    <script src="<?=base_url()?>style/iepngfix_tilebg.js" type="text/javascript"></script>
    <script src="<?=base_url()?>style/jquery.jBox-2.3.min.js" type="text/javascript"></script>
    <link href="<?=base_url()?>style/jbox.css" rel="stylesheet" type="text/css">    
    <link href="<?=base_url()?>style/cssOne.css" rel="stylesheet" type="text/css">
    <link href="<?=base_url()?>style/jbox(1).css" rel="stylesheet" type="text/css">
    <script src="<?=base_url()?>style/antiman.js" type="text/javascript"></script>
    <script src="<?=base_url()?>style/jquery.kinMaxShow.min.js" type="text/javascript"></script>    
    <script src="<?=base_url()?>style/jquery.jBox.src.js" type="text/javascript"></script>
    <script src="<?=base_url()?>style/jquery.jBox-2.3.min.js" type="text/javascript"></script>
    <link href="<?=base_url()?>style/jbox.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>style/weui.css">
    <script src="<?=base_url()?>style/common.js" type="text/javascript"></script>


<body style="background: #fff;">
   <?php require_once('include/nav.php')?> 
    <!--daohang-->
    
    
<form action="<?=site_url('sales/taskStepTwo')?>" enctype="multipart/form-data" id="fm" method="post">        
        <div class="sj-fprw" style="margin-bottom: 0px; padding-bottom: 0px;">
            <input id="DocFileName" name="DocFileName" type="hidden" value="">
            <div class="tab1" style="font-size: 14px; font-family: 微软雅黑; margin-bottom: 20px;
                color: #222;">
                <div class="menu">
                    <ul>
                        <li class="off" onclick="javascript:window.location.href='<?=site_url('sales')?>'"> 发布任务</li>
                        <li onclick="javascript:window.location.href='<?=site_url('sales/task')?>'">发布管理</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="middle mid-980 task_info">
            <div class="tit" id="divone">
                <input type="hidden" id="taskNum" value="3">
                <input type="hidden" id="keyNum" value="2">
                <!--PC任务数量-->
                <input type="hidden" id="PCTaskNum" value="<?=$pcnum?>">
                <!--无线端任务数量-->
                <input type="hidden" id="WifiTaskNum" value="<?=$phonenum?>">
                <b style="color: #0099FF">发布任务：第二步</b>
             </div>
            <!--发布第一步 内容 end-->
            <!--表格内容-->
            <div class="fb_tbale ">
                <!--商品详细信息-->
                <div class="fb2_table">
                    <div class=" fb2_tbaletop">
                        <h3>商品详细信息</h3>
                    </div>
                    <div class="fb2_sbxiis" style="">
                        <table class="fb2_tbox" style="width: 550px;">
                            <tbody>
                                <tr>
                                    <td>店铺名称：</td>
                                    <td class="fb_w60"><?php foreach($shops as $s){if($s->sid==$proinfo->shopid){echo $s->shopname;}}?></td>
                                </tr>
                                <tr>
                                    <td>商品名称：</td>
                                    <td class="fb_w60"><?=$proinfo->commodity_title?></td>
                                </tr>
                                <tr>
                                    <td>商品链接:</td>
                                    <td class="fb_w60 "><?=$proinfo->commodity_url?></td>
                                </tr>
                                <tr>
                                    <td class="bottom_none">任务类型:</td>
                                    <td class="fb_w60 bottom_none fb_lllb">
                                        <input type="hidden" name="TaskTypeCount" value=" 1"> 
                                        <label><input type="hidden" name="TaskType" value="0">PC：<span><?=$pcnum?></span></label>
                                        <input type="hidden" name="TaskTypeCount" value=" 1"> 
                                        <label><input type="hidden" name="TaskType" value="1">无线端：<span><?=$phonenum?></span></label>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="fb2_topimg">
                            <div class="fb2_mmm">                                
                                <img src="<?=$proinfo->commodity_image?>"style=" max-width:100%; height:135px;">
                            </div>
                        </div>
                    </div>
                    <table class="fb2_tbox fb2_rwlx fb2_rejh fb2_newsrh " style="">
                        <thead>
                            <tr>
                                <td style="width: 98px;"> 日期</td>
                                    <?php $data=@date('Y-m-d')?>
                                    <?php for($n=0;$n<7;$n++):?>
                                        <input type="hidden" name="TaskPlanTime" value="<?=@strtotime(@date("Y-m-d",@strtotime("+".$n."day")))?>"> 
                                        <td><?=@date("m月d日",@strtotime("+".$n."day"))?> </td>
                                    <?php endfor;?>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="width: 98px;">数量</td>
                                    <input type="hidden" name="TaskPlanCount" value="<?=$all?>"> 
                                <td><span><?=$all?></span></td>
                                    <input type="hidden" name="TaskPlanCount" value="0"> 
                                <td><span>0</span></td>
                                    <input type="hidden" name="TaskPlanCount" value="0"> 
                                <td><span>0</span></td>
                                    <input type="hidden" name="TaskPlanCount" value="0"> 
                                <td><span>0</span></td>
                                    <input type="hidden" name="TaskPlanCount" value="0"> 
                                <td><span>0</span></td>
                                    <input type="hidden" name="TaskPlanCount" value="0"> 
                                <td><span>0</span></td>
                                    <input type="hidden" name="TaskPlanCount" value="0"> 
                                <td><span>0</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!--商品详细信息 END-->
                <!--价格表单-->
                <div class="fb2_table ">
                    <div class=" fb2_tbalenco">
                        <h3>商品价格</h3>
                        <span style="margin-left: -70px; position: absolute; font-size: 16px;">（此价格为加上邮费和扣减优惠券后，买手需要实际支付的金额）
                        </span><span style="margin-left: 500Px">任务总数：<b style="color: Red"><?=$all?></b></span>
                        <a href="javascript:viod(0);" class="fb_jgbdadd" id="jg_addTask"><i class="fb2_iconad">
                        </i>新增</a>
                    </div>
                    <table class="fb2_tbox fb2_tjiag" id="fb2_jgtjb">
                        <tbody>
                            <tr>
                                <td>手机专享价(<b style="color: Red" id="PNum"><?=$phonenum?></b>)</td>
                                <td>价格</td>
                                <td>任务数量</td>
                                <td class="fb2_w15">基本发布点</td>
                                <td class="fb2_w15">消耗发布点</td>
                                <td class="fb2_w15">操作</td>
                            </tr>
                            <tr id="copyinfo" style="display:none;">
                                <td>
                                    <input type="checkbox" name="IsMobilePrices">
                                    <input type="hidden" name="IsMobilePrice" value="false">
                                </td>
                                <td>
                                    <input type="text" name="ProductPrice" value="0" placeholder="0" onkeyup="clearNoNum(this)" maxlength="7">
                                </td>
                                <td>
                                    <input type="text" name="ProductPriceListCount" value="0" placeholder="0" onkeyup="value=value.replace(/[^0-9]/g,'')" maxlength="3">
                                </td>
                                <td class="fb2_w15">0</td>
                                <td class="fb2_w16">0</td>
                                <td class="fb2_w15">
                                    <a href="javascript:void(0);" class="fb_detle">删除</a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="checkbox" name="IsMobilePrices">
                                    <input type="hidden" name="IsMobilePrice" value="false">
                                </td>
                                <td>
                                    <input type="text" name="ProductPrice" value="0" placeholder="0" onkeyup="clearNoNum(this)" maxlength="7">
                                </td>
                                <td>
                                    <input type="text" name="ProductPriceListCount" value="0" placeholder="0" onkeyup="value=value.replace(/[^0-9]/g,'')" maxlength="3">
                                </td>
                                <td class="fb2_w15">0</td>
                                <td class="fb2_w16">0</td>
                                <td class="fb2_w15">
                                    <a href="javascript:void(0);" class="fb_detle">删除</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="fb2_tbox fb2_tjiag">
                        <tbody><tr>
                            <td style="width: 500px">
                                <span class="sphj_l">担保金合计：</span> <span class="sphj_r" id="taskPrice">0</span>
                            </td>
                            <td style="width: 500px">
                                <span class="sphj_l">任务数合计：</span> <span class="sphj_r" id="taskCout">0</span>
                            </td>
                            <td class="fb2_w15">                                 
                            </td>
                            <td class="fb2_w15">
                                <span class="sphj_l">合计：</span> <span class="sphj_r" id="taskPoint">0</span>
                                <input type="hidden" id="basicPoint" name="BasicPoint">
                            </td>
                            <td class="fb2_w15">
                            </td>
                        </tr>
                    </tbody></table>
                </div>
                <!--价格表单 END-->
                <!--关键字-->
                    <div class="fb2_table">
                        <div class=" fb2_tbalenco">
                            <h3>关键字</h3>
                            <span style="margin-left: -90px; position: absolute; font-size: 14px;" id="msg"><a href="http://qqq.wkquan.com/Other/Content/NNewsInfo?id=38" target="_blank" style="text-decoration: underline; color: Red;">搜索关键字设置规范</a> </span>
                            <span style="margin-left: 250px; position: absolute; font-size: 14px;">总数(PC+无线端)：<b style="color: Red"><?=$all?></b></span>
                            <span style="margin-left: 400px; position: absolute; font-size: 14px;">PC剩余：<b style="color: Red"><span id="filishNum"><?=$pcnum?></span> </b></span>
                            <span style="margin-left: 500px;position: absolute; font-size: 14px;">无线端剩余：<b style="color: Red"><span id="wifiFilishNum"><?=$phonenum?></span></b></span>
                            <a href="javascript:viod(0);" class="fb_gjzaddcs" id="gjz_add"><i class="fb2_iconad"></i>新增</a>
                        </div>
                        <table class="fb2_tbox fb2_gujz " id="fb2_gjzb">
                            <thead>
                                <tr>
                                    <td class="fb2_solu">流量入口</td>
                                    <td class="fb2_gjz"> 关键字</td>
                                    <td class="fb2_pxfs">排序方式</td>
                                    <td class="fb2_qt">其他</td>
                                    <td class="fb2_sdsl">任务数</td>
                                    <td class="fb2_zhl" style="display: none"> 转化率</td>
                                    <td class="fb2_zhl">流量</td>
                                    <td class="fb2_cz"> 操作</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr id="trSearch1" style="display: none">
                                    <td class="fb2_solu">
                                        <div class="select">
                                            <select id="selSearchTypeList" name="SearchType" onchange="shopChange(this,'417d32a1-46af-4ea2-9911-abe08bd90ef1','True')" style="height:30px">
                                                <option value="0">PC天猫</option>
                                                <option value="1">PC淘宝</option>
                                                <option value="8">PC直通车</option>
                                                <option value="2">移动天猫</option>
                                                <option value="3">淘宝APP</option>
                                                <option value="9">移动直通车</option>
                                            </select>
                                        </div>
                                    </td>
                                    <td class="fb2_gjz">
                                        <input type="text" name="SearchKey" maxlength="30">
                                    </td>
                                    <td class="fb2_pxfs">
                                        <div class="select">
                                            <select name="SortType">
                                                <option value="0">综合</option>
                                                <option value="1">销量</option>
                                                <option value="2">价格</option>
                                                <option value="3">人气</option>
                                            </select>
                                        </div>
                                    </td>
                                    <td class="fb2_qt">
                                        <div class="select">
                                            <select name="OtherSearch" onchange="otherSearchChage()">
                                                <option value="-1"></option>
                                                <option value="0">价格区间</option>
                                                    <option value="1">发货地</option>
                                                <option value="2">其他</option>
                                            </select>
                                        </div>
                                        <label>
                                            <ul class="nno_noe">
                                                <li id="linull" style=""></li>
                                                <li id="liPrice" style="display: none">
                                                    <label><input name="PriceStart" type="text" placeholder="0" value="0" maxlength="6" onkeyup="value=value.replace(/[^0-9]/g,'')"></label>
                                                    ~
                                                    <label><input name="PriceEnd" type="text" placeholder="0" value="0" maxlength="6" onkeyup="value=value.replace(/[^0-9]/g,'')"></label>
                                                </li>
                                                <li id="liAddress" style="display: none">
                                                    <input type="text" name="SendProductCity" placeholder="请输入发货地" maxlength="10"></li>
                                                <li id="liOther" style="display: none">
                                                    <input type="text" name="OtherContent" placeholder="自己输入" maxlength="10"></li>
                                            </ul>
                                        </label>
                                    </td>
                                    <td class="fb2_sdsl"><input id="pc" name="KeyWordCount" type="text" value="0" placeholder="0" maxlength="3" onkeyup="value=value.replace(/[^0-9]/g,'')"></td>
                                    <td class="fb2_zhl" style="display: none"><input id="pc" name="ConversionPercent" type="text" value="0" placeholder="0" maxlength="4" onkeyup="clearNoNum(this)"><label>%</label></td>
                                    <td class="fb2_sdsl">0</td>
                                    <td class="fb2_cz"><a href="javascript:void(0);" class="fb_detle">删除</a></td>
                                </tr>
                                    <tr id="trSearch">
                                        <td class="fb2_solu">
                                            <div class="select">
                                                <select id="selSearchTypeList1" name="SearchType" onchange="shopChange1('selSearchTypeList1','417d32a1-46af-4ea2-9911-abe08bd90ef1','True')" style="height:30px">
                                                    <option value="0">PC天猫</option>
                                                    <option value="1">PC淘宝</option>
                                                    <option value="8">PC直通车</option>
                                                    <option value="2">移动天猫</option>
                                                    <option value="3">淘宝APP</option>
                                                    <option value="9">移动直通车</option>
                                                </select>
                                            </div>
                                        </td>
                                        <td class="fb2_gjz">
                                            <input type="text" name="SearchKey" maxlength="30">
                                        </td>
                                        <td class="fb2_pxfs">
                                            <div class="select">
                                                <select name="SortType" id="selectId">
                                                    <option value="0">综合</option>
                                                    <option value="1">销量</option>
                                                    <option value="2">价格</option>
                                                    <option value="3">人气</option>
                                                    <option value="4">新品</option>
                                                </select>
                                            </div>
                                        </td>
                                        <td class="fb2_qt">
                                            <div class="select">
                                                <select name="OtherSearch" onchange="otherSearchChage()">
                                                    <option value="-1"></option>
                                                    <option value="0">价格区间</option>
                                                        <option value="1">收货地</option>
                                                    <option value="2">其他</option>
                                                </select>
                                            </div>
                                            <label>
                                                <ul class="nno_noe">
                                                    <li id="linull" style=""></li>
                                                    <li id="liPrice" style="display: none">
                                                        <label>
                                                            <input name="PriceStart" type="text" placeholder="0" value="0" maxlength="6" onkeyup="value=value.replace(/[^0-9]/g,'')"></label>
                                                        ~
                                                        <label>
                                                            <input name="PriceEnd" type="text" placeholder="0" value="0" maxlength="6" onkeyup="value=value.replace(/[^0-9]/g,'')"></label>
                                                    </li>
                                                    <li id="liAddress" style="display: none">
                                                        <input type="text" name="SendProductCity" placeholder="请输入收货地" maxlength="10"></li>
                                                    <li id="liOther" style="display: none">
                                                        <input type="text" name="OtherContent" placeholder="自己输入" maxlength="10"></li>
                                                </ul>
                                            </label>
                                        </td>
                                        <td class="fb2_sdsl">
                                            <input type="hidden" id="keyCount" value="0">
                                            <input id="pc" name="KeyWordCount" type="text" placeholder="0" value="0" maxlength="3" onkeyup="value=value.replace(/[^0-9]/g,'')">
                                        </td>
                                        <td class="fb2_zhl" style="display: none">
                                            <input id="pc" name="ConversionPercent" type="text" placeholder="0" value="0" maxlength="4" onkeyup="clearNoNum(this)"><label>%</label>
                                        </td>
                                        <td class="fb2_sdsl">0</td>
                                        <td class="fb2_cz">
                                            <a href="javascript:void(0);" class="fb_detle">删除</a>
                                        </td>
                                    </tr>
                            </tbody>
                        </table>
                        <table class="fb2_tbox fb2_gujz " border="0" width="100%">
                            <thead>
                                </thead><tbody>
                                    <tr id="trSearch1">
                                        <td class="fb2_solu" colspan="5" style="width: 44%; text-align: left">
                                            流量费用说明: PC <b>0.10</b> 元/UV;<label> 淘宝APP <b>0.20</b> 元/UV</label>   
                                        </td>                                         
                                        <td colspan="2" style="width: 15%">
                                            任务数合计: <span class="sphj_r" id="KeyNum">0</span>
                                        </td>                                        
                                        <td style="width: 20%">
                                            流量合计: <span class="sphj_r" id="LookNum">0</span>
                                        </td>
                                        <td style="width: 20%">
                                            流量费用: <span class="sphj_r" id="TotalNum">0.00</span>
                                        </td>
                                    </tr>
                                </tbody>
                            
                        </table>
                    </div>
                <!--关键字 END-->
                <!--促销类上传WORD-->
                    <span style="line-height: 32px;">无线二维码：</span>        
                    <img src="<?=$proinfo->qrcode?>" width="100" height="100">
                <!--促销类上传WORD-->
                <!--下一步-->
                <input type="submit" id="btnmit" class="next_button" value="下一步" onclick="return Next();">
                <!--下一步 END-->
            </div>
            <!--表格内容 END-->
        </div>
</form>   
<script>
function clearNoNum(obj) {
    obj.value = obj.value.replace(/[^\d.]/g, "");
    obj.value = obj.value.replace(/^\./g, "");
    obj.value = obj.value.replace(/\.{2,}/g, ".");
    obj.value = obj.value.replace(".", "$#$").replace(/\./g, "").replace("$#$", ".");
}
</script>

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