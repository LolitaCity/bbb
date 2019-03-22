<?php require_once('include/header.php')?>  
<body style="background: #fff;">
    <?php require_once('include/nav.php')?>
    <!--daohang-->   
    
        <!-- banner-->
        <div class="banner">
            <div style="display: none;">
            </div>
            <!-- 代码 开始 -->
            
                <div>
                    <ul id="slides">
                        <li style="background: url('style/images/banner.jpg') center top no-repeat; z-index: 900; display: none;">
                            <a href="#" target="_blank"></a></li>
                        <li style="background: url('style/images/banner.jpg') center top no-repeat; z-index: 800; display: block;">
                            <a href="#" target="_blank"></a></li>
                        <li style="background: url('style/images/banner.jpg') center top no-repeat; z-index: 900; display: none;">
                            <a href="#" target="_blank"></a></li>
                    </ul><ul id="pagination" style="margin-left: 470px;"><li class=""><a href="#">1</a></li><li class="current"><a href="#">2</a></li><li class=""><a href="#">3</a></li></ul>
                </div>
            <!-- 代码 结束 -->
            
            <div class="banner_login3">
                <div class="ba_w295">
                    <ul class="bg_top1">
                        <li>愉快合作第<b><?=@floor((@strtotime(@date('Y-m-d H:i:s'))-$info->RegTime)/86400)?></b>天</li>
                        <li>存款：<b><?=$info->Money?></b>元</li>
                        <li>绑定店铺：<b><?=$infocount?></b>个</li>
                        <li>可发布商品：<b><?=count($procount)?></b>个</li>
                    </ul>                   
                </div>
            </div>
            <!-- banner-->
            <!-- 内容-->
            <div class="sj-mail">
                <div class="sj-mail-left left">
                    <h2>发布任务</h2>
                    <ul>
                        <li><a href="<?=site_url('sales')?>" target="_blank">
                            <p style="margin-top: 30px; margin-left: 39px;">
                                <img src="<?=base_url()?>style/images/sj-malil-1.png"></p>
                            <p class="sj-mail-left-1">销量任务</p>
                        </a></li>
                        <li class="sj-mail-left-jx"><a href="<?=site_url('sales/evaluation')?>" target="_blank">
                            <p style="margin-top: 30px; margin-left: 43px;">
                                <img src="<?=base_url()?>style/images/sj-malil-2.png"></p>
                            <p class="sj-mail-left-1">评价管理</p>
                        </a></li>
                        <li class="sj-mail-left-jx"><a href="<?=site_url('sales/taskyes')?>">
                            <p style="margin-top: 30px; margin-left: 40px;">
                                <img src="<?=base_url()?>style/images/sj-malil-3.png"></p>
                            <p class="sj-mail-left-1">已接任务</p>
                        </a></li>
                        <li class="sj-mail-left-jx"><a href="<?=site_url('member/transferShow')?>" target="_blank">
                            <p style="margin-top: 30px; margin-left: 33px;">
                                <img src="<?=base_url()?>style/images/sj-malil-4.png"></p>
                            <p class="sj-mail-left-1">佣金说明</p>
                        </a></li>
                    </ul>
                </div>
                <div class="sj-mail-left right">
                    <h2>平台公告</h2>
                    <ul>
                        <li><a href="<?=site_url('member')?>">
                            <p style="margin-top: 30px; margin-left: 43px;">
                                <img src="<?=base_url()?>style/images/sj-malil-5.png"></p>
                            <p class="sj-mail-left-1">基本资料</p>
                        </a></li>
                        <li class="sj-mail-left-jx"><a href="<?=site_url('member/product')?>">
                            <p style="margin-top: 30px; margin-left: 42px;">
                                <img src="<?=base_url()?>style/images/sj-malil-6.png"></p>
                            <p class="sj-mail-left-1">商品列表</p>
                        </a></li>
                        <li class="sj-mail-left-jx"><a href="<?=site_url('member/notices')?>" target="_blank">
                            <p style="margin-top: 30px; margin-left: 40px;">
                                <img src="<?=base_url()?>style/images/sj-malil-7.png"></p>
                            <p class="sj-mail-left-1">所有公告</p>
                        </a></li>
                        <li class="sj-mail-left-jx"><a target="_blank" id="serviceQQ" href="http://wpa.qq.com/msgrd?v=3&uin=<?=$service1->value?>&site=在线客服&menu=yes">
                            <p style="margin-top: 30px; margin-left: 41px;">
                                <img src="<?=base_url()?>style/images/sj-malil-8.png"></p>
                            <p class="sj-mail-left-1">联系客服</p>
                        </a></li>
                    </ul>
                </div>
            </div>
            <!-- 内容-->
    
<script language="javascript" type="text/javascript">
$(function(){
	var $has_freeze = <?=$info -> Status;?>;
	console.log($has_freeze);
	if ($has_freeze)
	{
		dialog.confirm('您的账户已被冻结，任务将无法被接手，可能的原因是存在今日之前的未转账记录，请前往处理', '去处理', '取消', function(){
			location.href = '/capital/wait';
		});
	}
	$has_mark_comment_null = <?=$has_mark_comment_null;?>;
	if ($has_mark_comment_null > 0 && !sessionStorage.has_hint_mark_comment_null)
	{
		dialog.confirm('您存在店铺插旗标志信息为空的现象，这将导致插旗失败，请前往检查', '前往检查', '退出', function(){
			location.href = '/member/smartSettings.html';
		});
		sessionStorage.has_hint_mark_comment_null = 1;
	}
	var $diff_value = <?=$shop_helper_state -> residue;?>,
		$helper_pattern = <?php
			$sql = 'SELECT value from zxjy_system WHERE varname = "use_helper"';
			echo $helper_pattern = $this -> db -> query($sql) -> first_row() -> value;	
		?>;
	if ($diff_value > 0 && $diff_value <= 3 && $helper_pattern > 0)
	{
		dialog.confirm('您的智能助手即将在' + $diff_value + '天后（即<?=$shop_helper_state -> exp_time?>）过期，请及时前往续费', '去续费', '取消', function(){
			location.href = '/member/smartSettings';
		});
	}
	else if($diff_value <= 0 && $helper_pattern > 0)
	{
		$con = $helper_pattern == 1 ? '您的智能助手已过期，请及时续费，否则无法发布任务' : '您的智能助手已过期，请留意智能助手页面插旗失败的订单避免真实发货，并及时续费恢复功能';
		dialog.confirm($con, '去处理', '取消', function(){
			location.href = '/member/smartSettings';
		});
	}
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

</div>


</body></html>