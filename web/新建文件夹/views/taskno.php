<?php require_once('include/header.php')?>     
    <script src="<?=base_url()?>style/md5.js" type="text/javascript"></script>
    <script src="<?=base_url()?>style/jquery.jBox-2.3.min.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>style/jbox.css">

    <script src="<?=base_url()?>style/laydate.js" type="text/javascript"></script>
	<link type="text/css" rel="stylesheet" href="<?=base_url()?>style/laydate.css">
	<link type="text/css" rel="stylesheet" href="<?=base_url()?>style/laydate(1).css" id="LayDateSkin">

<body style="background: #fff;">
   <?php require_once('include/nav.php')?>  
    <!--daohang-->
    
    
    <!-- 内容-->
    <div class="sj-fprw">
<form action="#" enctype="multipart/form-data" id="fm" method="post">            <!-- tab切换-->
            <div class="tab1" id="tab1">
                <div class="menu">
                    <ul>
                        <li id="one2" onclick="location.href='<?=site_url('sales')?>'">发布任务</li>
                        <li id="one3" class="off" onclick="location.href='<?=site_url('sales/taskno')?>'">未接任务</li>
                        <li id="one1" onclick="location.href='<?=site_url('sales/taskyes')?>'">已接任务</li>
                        <li id="one0" onclick="location.href='<?=site_url('sales/evaluation')?>'">评价管理</li>
                    </ul>
                </div>
                <div class="menudiv">
                    <div id="con_one_2">
    <!--                    <div class="fpgl-ss">
                            <p><input class="input-butto100-ls" style="width: 80px" type="button" value="全部取消" onclick="delAll();"></p>
                            <p><input class="input-butto100-hs" style="width:80px" type="button" value="刷新" onclick="location.reload();"></p>
                            <div class="clearfix"></div>
                        </div>
                        <script>
                            var qq = '<?/*=$info->id*/?>';
                            function delAll(){
                                $.ajax({
                                    cache: true,
                                    type: "POST",
                                    url:"<?php /*echo site_url('sales/closeTaskAll');*/?>",
                                    data: { key: qq},// 你的formid
                                    async: false,
                                    error: function(request) {
                                        alert("Connection error");
                                    },
                                    success: function(data) {
                                        alert(data);
                                        if(data == 0  ){

                                        }else{
                                            if(data==1){
                                                $.openAlter('错误的操作！','提示');
                                                window.location.href="<?/*=site_url()*/?>";
                                            }else{
                                                $.openAlter('数据出错，请重新登录后操作！','提示');
                                                window.location.href="<?/*=site_url()*/?>";
                                            }
                                        }
                                    }
                                });
                                return false;
                            }
                        </script>-->
                        <!-- 搜索-->
                        <!-- 表格-->
                        <div class="fprw-pg">
                            <table>
                                <tbody>
                                <tr align="center">
                                    <th width="100"><center>任务分类</center></th>
                                    <th width="280"><center>发布的任务数量</center></th>
                                    <th width="220"><center>店铺/商品信息</center></th>
                                    <th width="232"><center>操作</center></th>
                                </tr>
                                <?php foreach($list as $vl):?>
                                    <?php if($vl->number > ($vl->qrnumber +$vl->del)):?>
                                        <tr>
                                            <td>
                                                    <p class="fpgl-td-rw"> <?=$vl->tasktype=='1'?'销量任务':'复购任务'?></p>
                                            </td>
                                            <td>
                                                <p class="fpgl-td-rw">发布总任务：<?=$vl->number?></p>
                                                <p class="fpgl-td-rw">剩余总任务：<?=$vl->number-$vl->qrnumber?></p>
                                                <p class="fpgl-td-rw">发布时间：<?=@date('Y-m-d H:i:s',$vl->addtime)?></p>
                                            </td>
                                            <td>
                                                <p class="fpgl-td-rw">店铺名称：<?php foreach($shoplist as $vsl){ if($vl->shopid == $vsl->sid){ echo $vsl->shopname; }}?></p>
                                                <p class="fpgl-td-rw">产品名称：<?php foreach($prolist as $vpl){ if($vl->proid == $vpl->id){ echo $vpl->commodity_title; }}?></p>
                                                <p class="fpgl-td-rw">关键词：<?php echo $vl->keyword?></p>
                                            </td>
                                            <td>
                                                <?php if(($vl->number-$vl->qrnumber) > 0 ):?>
                                                    <p class="fpgl-td-mtop"><input onclick="CloseOne('<?=$vl->id?>')" class="input-butto100-zsls" type="button" value="取消任务"></p>
                                                    <p class="fpgl-td-mtop"><input onclick="hideOne('<?=$vl->id?>')" class="input-butto100-xhs" type="button" value="<?=$vl->status==1?'显示任务':'隐藏任务'?>"></p>
                                                <?php endif;?>
                                            </td>
                                        </tr>
                                    <?php endif;?>
                                <?php endforeach;?>
                                </tbody>
                            </table>
                        </div>
                        <!-- 表格-->
                        <script>
                            function CloseOne(key){
                                //$.openAlter('暂未开放！','提示');
                                //alert(key);
                                if(confirm("确认取消该任务么？")){
                                    $.post('<?=site_url('sales/CloseOne')?>', { keys: key }, function (data) {
                                        //alert(data);
                                        if(data==0){
                                            $.openAlter('任务状态修改成！','提示');
                                            setTimeout(function(){ location.reload();},1000);
                                        }else if(data ==  1){
                                            $.openAlter('请不要测试错误链接！','提示');
                                            setTimeout(function(){ location.reload();},1000);
                                        }else if(data == 2){
                                            $.openAlter('数据出错了！','提示');
                                            setTimeout(function(){ location.reload();},1000);
                                        }else if(data == 3){
                                            $.openAlter('系统现在繁忙中，请稍后重试！','提示');
                                            setTimeout(function(){ location.reload();},1000);
                                        }
                                    },'json');
                                    return false;
                                }else{
                                    $.openAlter("不取消当前任务");
                                }
                            }
                            function hideOne(key){
                               // alert(key);
                                $.post('<?=site_url('sales/hideOne')?>', { keys: key }, function (data) {
                                    if(data==0){
                                        $.openAlter('任务状态修改成！','提示');
                                        setTimeout(function(){ location.reload();},1000);
                                    }else if(data ==  1){
                                        $.openAlter('需要修改的任务获取失败！','提示');
                                        setTimeout(function(){ location.reload();},1000);
                                    }else if(data == 2){
                                        $.openAlter('数据出错了！','提示');
                                        setTimeout(function(){ location.reload();},1000);
                                    }else if(data == 3){
                                        $.openAlter('系统现在繁忙中，请稍后重试！','提示');
                                        setTimeout(function(){ location.reload();},1000);
                                    }
                                });
                                return false;
                            }

                        </script>
                    </div>
                </div>
            </div>
            <!-- tab切换-->
</form>    </div>
    <!-- 内容-->

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