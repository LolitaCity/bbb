
<?php $current_action = $this->router->fetch_method();?>
    <div class="zjgl-left">
        <h2 style="background: url(<?=base_url()?>style/images/hygl.png) no-repeat 22px 22px;">会员中心</h2>
        <ul>
            <li><a class="index" href="<?=site_url('member')?>">基本资料</a></li>
            <?php if($use_helper -> value):?>
            	<li><a class="smartSettings" href="<?=site_url('member/smartSettings')?>"><?=$this -> platform == '二师兄' ? '智能助手' : '小助手';?></a></li>
            <?php endif;?>
            <li><a class="store" href="<?=site_url('member/store')?>" >店铺管理</a></li><!--  选中栏目 -->
            <li><a class="product" href="<?=site_url('member/product')?>">商品管理</a></li>                
            <li><a class="notices" href="<?=site_url('member/notices')?>">平台公告</a></li>
            <li><a class="edit" href="<?=site_url('member/edit')?>" >调整单量</a></li>
            <!--<li><a class="buyTask" href="<?=site_url('member/buyTask')?>" >单量购买</a></li>-->
            <?php if($info->ispromoter):?>
            <li><a class="join" href="<?=site_url('member/join')?>" >邀请好友</a></li>
            <?php endif;?>
        </ul>
    </div> 
	<div id="fade" class="black_overlay" style="display: none;">
<script>
	$(function()
	{
		$('.' + '<?=$current_action?>').attr('style', 'background: #eee;color: #ff9900;');
	})
</script>