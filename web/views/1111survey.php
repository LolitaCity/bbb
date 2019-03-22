<?php require_once('include/header.php')?> 
	<link rel="stylesheet" type="text/css" href="/style/ext/layui/css/layui.css">
	<div style="padding: 5%;">
		<blockquote class="layui-elem-quote">双十一即将来临，为了向各位亲提供更优质的服务，满足大家的冲量需求，保障任务的完善，麻烦各商家针对2018-11-7至2018-11-11期间的平台单量进行预估填写，并提交至平台，预祝各位双十一大丰收！</blockquote>
		<blockquote class="layui-elem-quote">注：由于导出统计数据的表格有误，现再次向大家征集信息，麻烦各位商家耐心填写问卷，谢谢配合，预祝各位双十一大丰收。</blockquote>
		<form class="layui-form" action="javascript:;" style="padding-top: 3%;">
			<div class="layui-form-item">
			    <label class="layui-form-label">2018-11-07</label>
			    <div class="layui-input-inline">
			      <input type="text" name="estimate[]" lay-verify="number" placeholder="预估冲销单量" autocomplete="off" class="layui-input">
			    </div>
			    <div class="layui-form-mid layui-word-aux">请填写数字，并且不大于您当前每日最大单量</div>
			</div>
			<div class="layui-form-item">
			    <label class="layui-form-label">2018-11-08</label>
			    <div class="layui-input-inline">
			      <input type="text" name="estimate[]" lay-verify="number" placeholder="预估冲销单量" autocomplete="off" class="layui-input">
			    </div>
			    <div class="layui-form-mid layui-word-aux">请填写数字，并且不大于您当前每日最大单量</div>
			</div>
			<div class="layui-form-item">
			    <label class="layui-form-label">2018-11-09</label>
			    <div class="layui-input-inline">
			      <input type="text" name="estimate[]" lay-verify="number" placeholder="预估冲销单量" autocomplete="off" class="layui-input">
			    </div>
			    <div class="layui-form-mid layui-word-aux">请填写数字，并且不大于您当前每日最大单量</div>
			</div>
			<div class="layui-form-item">
			    <label class="layui-form-label">2018-11-10</label>
			    <div class="layui-input-inline">
			      <input type="text" name="estimate[]" lay-verify="number" placeholder="预估冲销单量" autocomplete="off" class="layui-input">
			    </div>
			    <div class="layui-form-mid layui-word-aux">请填写数字，并且不大于您当前每日最大单量</div>
			</div>
			<div class="layui-form-item">
			    <label class="layui-form-label">2018-11-11</label>
			    <div class="layui-input-inline">
			      <input type="text" name="estimate[]" lay-verify="number" placeholder="预估冲销单量" autocomplete="off" class="layui-input">
			    </div>
			    <div class="layui-form-mid layui-word-aux">请填写数字，并且不大于您当前每日最大单量</div>
			</div>
			<div class="layui-form-item" style="padding-top: 2%;">
			    <div class="layui-input-block">
			      <button class="layui-btn" lay-submit lay-filter="submit_num">立即提交</button>
			      <button type="reset" class="layui-btn layui-btn-primary">重置</button>
			    </div>
			</div>
		</form>
	</div>
	
	<script src="/style/ext/layui/layui.js" type="text/javascript"></script>
	<script type="text/javascript">
		$('input[name="estimate[]"]').on('keyup', function(){
			clearNoNum(this) ;
		});
		function clearNoNum(obj) 
		{
		    var patt;
		    //先把非数字的都替换掉，除了数字和.
		    obj.value = obj.value.replace(/[^\d.]/g, "");
		    //必须保证第一个为数字而不是.
		    obj.value = obj.value.replace(/^\./g, "");
		    //保证只有出现一个.而没有多个.
		    obj.value = obj.value.replace(/\.{2,}/g, ".");
		    //保证.只出现一次，而不能出现两次以上
		    obj.value = obj.value.replace(".", "$#$").replace(/\./g, "").replace("$#$", ".");
		    //只能输入小数点后两位
		    obj.value = obj.value.replace(/^(\-)*(\d+)\.(\d\d).*$/, '$1$2.$3');
		    //去掉前面的0
		    if(obj.value != 0) obj.value = obj.value.replace(/\b(0+)/gi, "");
		}
		layui.use(['form', 'layedit', 'laydate'], function(){
			var form = layui.form;
			form.on('submit(submit_num)', function(data){
				console.log(data.field) //当前容器的全部表单字段，名值对形式：{name: value}
			  public.ajax('/user/submit_survey', data.field, function(datas){
			  	 if (datas.status)
			  	 {
			  	 	dialog.success(datas.message);
			  	 	location.href = '/user';
			  	 }
			  	 else
			  	 	dialog.error(datas.message);
			  });
			  console.log(data.elem) //被执行事件的元素DOM对象，一般为button对象
			  console.log(data.form) //被执行提交的form对象，一般在存在form标签时才会返回
			  console.log(data.field) //当前容器的全部表单字段，名值对形式：{name: value}
			  return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
			});
		});
		
		location.href
		
	</script>
</body></html>