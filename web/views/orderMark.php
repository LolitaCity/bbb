<?php require_once('include/header.php')?>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>style/layui/css/layui.css">
<style type="text/css">
	.is-disabled
	{
	    background-color: #eef1f6;
	    border-color: #d1dbe5;
	    color: #bbb;
	    cursor: not-allowed;
	}
</style>
<body>
	<form class="layui-form" style="padding: 5%;" lay-filter="example">
		<div class="layui-form-item">
			<label class="layui-form-label">是否标记</label>
			<div class="layui-input-block">
				<input type="checkbox" lay-filter="switch_is_mark" name="is_mark" lay-skin="switch" lay-text="标记|不标">
			</div>
		</div>
		<div class="layui-form-item">
			<label class="layui-form-label">标记</label>
			<div class="layui-input-block">
				<input type="radio" name="mark_val" value="0" title="灰色">
				<input type="radio" name="mark_val" value="1" title="红色">
				<input type="radio" name="mark_val" value="2" title="黄色">
				<input type="radio" name="mark_val" value="3" title="绿色">
				<input type="radio" name="mark_val" value="4" title="蓝色">
				<input type="radio" name="mark_val" value="5" title="紫色">
			</div>
		</div>
		<div class="layui-form-item layui-form-text">
			<label class="layui-form-label">标记信息</label>
			<div class="layui-input-block">
				<textarea name="mark_comment" placeholder="请输入内容" class="layui-textarea"></textarea>
			</div>
		</div>
		<div class="layui-form-item">
		    <div class="layui-input-block">
		    	<button class="layui-btn" lay-submit="" lay-filter="submit_set">立即提交</button>
		    </div>
	  	</div>
	  	
	  	<div class="layui-form-item">
			<label class="layui-form-label">免责说明</label>
			<div class="layui-input-block">
				插旗服务的稳定性与淘宝接口和服务器相关，因此不能保证100%能够标记成功。 对于标记失败的订单，会在【订单标记失败反馈】进行记录和提醒，请各位用户在仓库发货之前登录平台核对是否有订单标记失败。
			</div>
		</div>
	</form>
</body>
<script src="<?=base_url()?>style/layui/layui.js" type="text/javascript"></script>
<script>
var $mark_val = $('input[name=mark_val]'),
	$mark_comment = $('textarea[name=mark_comment]')
if (!<?=$mark_infos -> is_mark;?>)
{
  	$mark_val.attr('disabled', true);
  	$mark_comment.attr('disabled', true).addClass('is-disabled');
}
layui.use(['form'], function(){
  
  var form = layui.form;
  
  //监听指定开关
  form.on('switch(switch_is_mark)', function(data){
  	$mark_val.attr('disabled', !this.checked);
  	$mark_comment.attr('disabled', !this.checked);
  	if (this.checked)
  	{
  		$mark_comment.removeClass('is-disabled');	
  	}
  	else
  	{
  		$mark_comment.addClass('is-disabled');
  	}
  	form.render();
  });
  
  //监听提交
  form.on('submit(submit_set)', function(data){
  	if (data.field.mark_comment.trim() == '')
  	{
  		return dialog.error('备注信息不能为空');
  	}
  	data.field.sid = <?=$mark_infos -> sid;?>;
    public.ajax('/member/orderRemarkSave', data.field, function(datas){
    	public.ajaxSuccess(datas, function(){
    		dialog.iframe_close();
    	})
    });
	return false;
  });
 
  //表单初始赋值
  form.val('example', {
  	'is_mark': <?=$mark_infos -> is_mark;?>,
  	'mark_val': '<?=$mark_infos -> mark_val;?>',
  	'mark_comment': '<?=$mark_infos -> mark_comment;?>',
  });
});
</script>
</html>