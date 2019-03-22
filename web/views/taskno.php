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
<form action="#" enctype="multipart/form-data" id="fm" method="get">            <!-- tab切换-->
            <div class="tab1" id="tab1">
                <?php require_once('include/sale_task_menu.php')?> 
                <div class="menudiv">
                    <div id="con_one_2">
                    	<?php if ($this -> router -> fetch_method() == 'invalidTask'):?>
                    		<div class="fpgl-ss">
								<p>
									<select class="select_215" id="taskCategroy" name="taskCategroy"
										style="width: 120px;">
										<option value="0">任务分类</option>
										<option value="1">销量任务</option>
										<!--<option value="3">店铺复购任务</option>-->
										<option value="4">预订单</option>
										<option value="5">预约单</option>
									</select>
									<select class="select_215" id="selSearch"
										name="selSearch" style="width: 120px;">
										<option value="s.shopname">店铺名称</option>
									</select>
								</p>
								<p>
									<input class="input_417" id="txtSearch" name="txtSearch"
										style="width: 90px;" type="text"
										value="<?=@$_GET['txtSearch'];?>">
								</p>
								<p>
									发布时间: <input class="laydate-icon" id="BeginDate" maxlength="16"
										name="BeginDate"
										onclick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm:ss'})"
										style="width: 118px; height: 34px; margin-left: 5px;"
										type="text" value="<?=isset($_GET['BeginDate']) ? $_GET['BeginDate'] : '';?>"> ~
									<input class="laydate-icon" id="EndDate" maxlength="16"
										name="EndDate"
										onclick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm:ss'})"
										style="width: 118px; height: 34px;" type="text"
										value="<?=isset($_GET['EndDate']) ? $_GET['EndDate'] : '';?>">
								</p>
								<p>
									<input class="input-butto100-ls" style="width: 80px"
										type="button" value="查询" onclick="search()">
								</p>
								<!--<p>
									<input class="input-butto100-hs" style="width: 80px"
										type="button" value="一键发货"
										onclick="this.disabled=true;this.value='正在保存数据';SendAll()">
								</p>-->
								<p></p>
								<div class="clearfix"></div>
								<script>
	                     	　　    $("#taskCategroy").val("<?=@$_GET['taskCategroy'];?>");
	     	　　                                                    $("#selSearch").val("<?=@$_GET['selSearch'];?>");
	       	　　                                                	 function SendAll(){
	          	　　                                                          if(confirm("确认一键发货所有已提交的订单吗？")){
	            	　　                                                        	//alert('1');
	              	　　                                                              window.location.href='<?=site_url('sales/SendAll')?>';       
	              	　　                                              }
	              	　　                              }
	       	　　                                                	 function GiveAll(){
	        	　　                                                          if(confirm("确认一键支付所有待付款的订单的佣金吗？")){
	            	　　                                                              window.location.href='<?=site_url('sales/GiveAll')?>';       
	            	　　                                              }
	            	　　                              }
	            					function outExcel()
		            				{
		            					$from = $('form#fm');
		            					$from.attr('action', '<?=site_url('sales/outExcel')?>');
		            					$from.submit();
		            				}
		            				
		            				function search()
		            				{
		            					$from = $('form#fm');
		            					$from.attr('action', '<?=site_url('sales/invalidTask')?>');
		            					$from.submit();
		            				}
	                           </script>
							</div>
                		<?php endif;?>
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
                                <!--<?php foreach($list as $vl):?>
                                    <?php if($vl->number > ($vl->qrnumber + $vl->del)):?>
                                        <tr>
                                            <td>
                                                    <p class="fpgl-td-rw"> <?=$vl->tasktype=='1'?'销量任务':'复购任务'?></p>
                                            </td>
                                            <td>
                                                <p class="fpgl-td-rw">发布总任务：<?=$vl->number?></p>
                                                <p class="fpgl-td-rw">剩余总任务：<?=$vl->number-$vl->qrnumber-$vl->del?></p>
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
                                <?php endforeach;?>-->
                                <?php foreach($list as $vl):?>
                                    <tr class="father_tab">
                                        <td>
                                            <p class="fpgl-td-rw" style="text-align: center;"> 
                                            	<?php
                                            		switch($vl->tasktype)
                                            		{
                                            			case 1:
                                            				echo '销量任务';
                                            				break;
                                        				case 3:
                                            				echo '复购任务';
                                            				break;
                                        				case 4:
                                            				echo '预订单';
                                            				break;
                                        				case 5:
                                            				echo '预约单';
                                            				break;
                                            		}	
                                        		?>
                                            </p>
                                        </td>
                                        <td>
                                            <p class="fpgl-td-rw">接手情况：<?=$vl->qrnumber . '/' . $vl->number?></p>
                                            <p class="fpgl-td-rw">发布时间：<?=@date('Y-m-d H:i:s',$vl->addtime)?></p>
                                            <?php if($vl->gettime > 0 && (time() < $vl->end || $this -> router -> fetch_method() == 'invalidTask')):?>
                                            	<p class="fpgl-td-rw">平均发布：<?=@date('Y-m-d H:i:s',$vl->start) . ' 至 ' . @date('Y-m-d H:i:s', $vl->end)?></p>
                                            	<p class="fpgl-td-rw">超时时间: <?=@date('Y-m-d H:i:s', $vl->close)?></p>
                                        	<?php else:?>
                                        		<p class="fpgl-td-rw">立即发布：<?=@date('Y-m-d H:i:s',$vl->gettime == 0 ? $vl -> start : $vl->end) . ' 至 ' . @date('Y-m-d H:i:s', $vl->close)?></p>
                                    		<?php endif;?>
                                            <?php if($vl->tasktype == 4):?>
                                            	<p class="fpgl-td-rw">订金/尾款：<?=$vl->handsel . '元/' . $vl->Payment . '元'?></p>
                                            	<p class="fpgl-td-rw">尾款支付时间：<?=$vl->beginPay . '至' . $vl->endPay;?></p>
                                        	<?php endif;?>
                                    		<?php if($vl->tasktype == 5):?>
                                            	<p class="fpgl-td-rw">预约支付时间：<?=$vl->beginPay . '至' . $vl->endPay;?></p>
                                        	<?php endif;?>
                                        </td>
                                        <td>
                                            <p class="fpgl-td-rw">店铺名称：<?=$vl->shopname?></p>
                                            <p class="fpgl-td-rw">产品名称：<?=$vl->commodity_title?></p>
                                            <p class="fpgl-td-rw">关键词：<?php echo $vl->keyword?></p>
                                            <p class="fpgl-td-rw">置顶费/单：<?php echo $vl->top?>元/单</p>
                                            <?php if($vl->tasktype == 5):?>
                                            	<p class="fpgl-td-rw">预约单设置：
                                            		<?php 
                                            			switch($vl -> how_browse)
                                            			{
                                            				case 1:
                                            					$how_browse = '加购';
                                            					$how_search = '从购物车直接进入';
                                            					break;
                                            				case 2: 
                                            					$how_browse = '收藏';
                                            					$how_search = '从收藏夹直接进入';
                                            					break;
                                            				case 3: 
                                            					$how_browse = '货比三家';
                                            					$how_search = '从足迹直接进入';
                                            					break;
															default:
															    $how_browse = '无内容';
                                            					$how_search = '无内容';
                                            			}
                                            			echo $how_browse;
                                        			?>
                                        			/
                                        			<?php 
                                            			switch($vl -> how_search)
                                            			{
                                            				case 1: echo $how_search; break;
                                            				case 2: echo '新关键词进入'; break;
                                            			}
                                        			?>
                                        			<?= $vl -> how_search == 2 ? '/' . $vl -> new_keyword : '';?>
                                            	</p>
                                        	<?php endif;?>
                                        </td>
                                        <td>
                                            <?php if(($vl->number-$vl->qrnumber) > 0 ):?>
                                            	<?php if ($this -> router -> fetch_method() != 'invalidTask'):?>
	                                            	<p class="fpgl-td-mtop"><input onclick="CloseOne('<?=$vl->mark?>', this)" class="input-butto100-zsls" type="button" value="取消任务"></p>
	                                                <p class="fpgl-td-mtop"><input onclick="hideOne('<?=$vl->id?>', <?=$vl->status?>, this)" class="input-butto100-xhs" type="button" value="<?=$vl->status==1?'点击显示任务':'点击隐藏任务'?>"></p>
                                                <?php endif;?>
                                                <p class="fpgl-td-mtop"><input onclick="GetTaskDatailInfo('<?=$vl->id?>', 0, 't')" class="input-butto100-zsls" type="button" value="查看详情"></p>                                            <?php endif;?>
                                        </td>
                                    </tr>
                            <?php endforeach;?>
                                </tbody>
                            </table>
                        </div>
                        <?php if ($this -> router -> fetch_method() == 'invalidTask'):?>
                        	<?php require_once('include/page.php')?> 
                    	<?php endif;?>
                        <!-- 表格-->
                        <script>
                        	function  GetTaskDatailInfo(taskid, $type, $tag)
                        	{
					       		dialog.iframe('<?=site_url('sales/taskInfoDetail')?>' +'?key='+ taskid + '&type=' + $type + '&tag=' + $tag, 750, 600);
					       }
                        	
                            function CloseOne(key, $this){
                                //$.openAlter('暂未开放！','提示');
                                //alert(key);
                                dialog.confirm('确认取消该任务吗？', '确认取消', '不取消了', function(){
                                	public.ajax('<?=site_url('sales/CloseOne')?>', {key: key}, function(datas){
                                		if(datas.status)
                                		{
                                			dialog.success(datas.message);
                                			$($this).parents('.father_tab').remove();
                                		}
                                		else
                                		{
                                			dialog.error(datas.message);
                                		}
                                	});
                                });
//                              if(confirm("确认取消该任务么？")){
//                                  $.post('<?=site_url('sales/CloseOne')?>', { keys: key }, function (data) {
//                                      //alert(data);
//                                      if(data==0){
//                                          $.openAlter('任务状态修改成！','提示');
//                                          setTimeout(function(){ location.reload();},1000);
//                                      }else if(data ==  1){
//                                          $.openAlter('请不要测试错误链接！','提示');
//                                          setTimeout(function(){ location.reload();},1000);
//                                      }else if(data == 2){
//                                          $.openAlter('数据出错了！','提示');
//                                          setTimeout(function(){ location.reload();},1000);
//                                      }else if(data == 3){
//                                          $.openAlter('系统现在繁忙中，请稍后重试！','提示');
//                                          setTimeout(function(){ location.reload();},1000);
//                                      }
//                                  },'json');
//                                  return false;
//                              }else{
//                                  $.openAlter("不取消当前任务");
//                              }
                            }
                            function hideOne(key, $old, $this){
                               // alert(key);
                               public.ajax('<?=site_url('sales/hideOne')?>', {keys: key}, function(datas){
                                   if(datas.status)
                                   {
                                   		dialog.success(datas.message);
                                   		$this = $($this);
                                   		$this.val($old ? '点击隐藏任务' : '点击显示任务');
                                   		$this.attr('onclick', 'hideOne(' + key + ', ' + !$old + ', this)');
                                   }
                                   else
                                   {
                                   		dialog.error(datas.message);
                                   }
                               });
//                              $.post('<?=site_url('sales/hideOne')?>', {keys: key}, function (data) {
//                                  if(data==0){
//                                      $.openAlter('任务状态修改成！','提示');
//                                      setTimeout(function(){ location.reload();},1000);
//                                  }else if(data ==  1){
//                                      $.openAlter('需要修改的任务获取失败！','提示');
//                                      setTimeout(function(){ location.reload();},1000);
//                                  }else if(data == 2){
//                                      $.openAlter('数据出错了！','提示');
//                                      setTimeout(function(){ location.reload();},1000);
//                                  }else if(data == 3){
//                                      $.openAlter('系统现在繁忙中，请稍后重试！','提示');
//                                      setTimeout(function(){ location.reload();},1000);
//                                  }
//                              });
//                              return false;
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