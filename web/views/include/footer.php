<div id="online_qq_layer" style="height: 50px;">
    <div id="online_qq_tab" style="margin-top: 420px;">
        <a id="floatShow" style="display: block;" href="javascript:void(0);">收缩</a> 
        <a id="floatHide" style="display: none;" href="javascript:void(0);">展开</a>
    </div>
    <div id="onlineService" style="margin-top: 420px; display: none;">
        <div class="onlineMenu">
            <ul>
                <li class="tli zixun">在线咨询</li>                
                <li id="consultLi" style="height:30px"><a target="_blank" style="font-size:13px" id="consultQQ" href="http://wpa.qq.com/msgrd?v=3&uin=<?=$service1->value?>&site=在线客服&menu=yes" title="点击可进行QQ交流">
                    <img width="25" height="17" border="0" align="absmiddle" style="vertical-align:text-bottom" src="<?=base_url()?>style/images/qq_online.gif">商家顾问</a>
                </li>                    
                <li style="height:30px"><a target="_blank" id="serviceQQ" style="font-size:13px" href="http://wpa.qq.com/msgrd?v=3&uin=<?=$service2->value?>&site=在线客服&menu=yes" title="点击可进行QQ交流">
                    <img width="25" height="17" border="0" align="absmiddle" style="vertical-align:text-bottom" src="<?=base_url()?>style/images/qq_online.gif">平台客服</a>
                </li>
            </ul>
        </div>
        <div class="btmbg">
        </div>
    </div>
</div>

<script type="text/javascript">
	$('#floatHide').on('click', function(){
		$('#onlineService').hide();
		$(this).css('display', 'none').prev().css('display', 'block');
	})
	
	$('#floatShow').on('click', function(){
		$('#onlineService').show();
		$(this).css('display', 'none').next().css('display', 'block');
	})
</script>