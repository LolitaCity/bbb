<div class="menu">
	<ul>
		<li id="one2" onclick="dialog.iframe('/sales/infoshow', 1100, 350, '任务类型选择')">发布任务</li>
		<li id="taskno" class="taskno" onclick="location.href='<?=site_url('sales/taskno')?>'">未接任务</li>
		<li id="taskyes" class="taskyes searchtask" onclick="location.href='<?=site_url('sales/taskyes')?>'">已接任务</li>
		<li id="evaluation" class="evaluation" onclick="location.href='<?=site_url('sales/evaluation')?>'">评价管理</li>
		<li id="invalidTask" class="invalidTask" onclick="location.href='<?=site_url('sales/invalidTask')?>'">无效任务</li>
	</ul>
</div>

<script type="text/javascript">
	var $method = '<?=$this -> router -> fetch_method();?>';
	$('.' + $method).addClass('off');
</script>
