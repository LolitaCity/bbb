<?php require_once('include/header.php')?>
<script src="<?=base_url()?>style/md5.js" type="text/javascript"></script>
<script src="<?=base_url()?>style/jquery.jBox-2.3.min.js"
	type="text/javascript"></script>
<link rel="stylesheet" type="text/css"
	href="<?=base_url()?>style/jbox.css">

<script src="<?=base_url()?>style/laydate.js" type="text/javascript"></script>
<link type="text/css" rel="stylesheet"
	href="<?=base_url()?>style/laydate.css">
<link type="text/css" rel="stylesheet"
	href="<?=base_url()?>style/laydate(1).css" id="LayDateSkin">
<script type="text/javascript">
        //查看买号信息
        function LookBuyNumberInfo(id) {
			dialog.iframe('<?=site_url('sales/buyerinfo')?>' +'?buyer='+ id, 450, 380);
            //$.openWin(380, 450, '<?=site_url('sales/buyerinfo')?>' +'?buyer='+ id);
        }
        //查看任务截图
        function GetPictures(taskID) {
        	dialog.iframe('<?=site_url('sales/seepic')?>' + '?key='+ taskID, 1000, 580, '查看任务截图');
            //$.openWin(580, 1000, '<?=site_url('sales/seepic')?>' +'?key='+ taskID);
            document.getElementById('back'+taskID).style.background = "#666";
            document.getElementById('back'+taskID).value = "已查看";
        }

        function GetEvaluatePictures(taskID){
        	dialog.iframe('<?=site_url('sales/seeEvaluatePics')?>' + '?key='+ taskID, 1000, 580, '查看任务/评价截图');
            //$.openWin(580, 1000, '<?=site_url('sales/seeEvaluatePics')?>' +'?key='+ taskID);
            document.getElementById('back'+taskID).style.background = "#666";
            document.getElementById('back'+taskID).value = "已查看";
        }
    </script>

<body style="background: #fff;">
   <?php require_once('include/nav.php')?>  
    <!--daohang-->


	<!-- 内容-->
	<div class="sj-fprw">
		<form action="<?=site_url('sales/searchtask')?>"
			enctype="multipart/form-data" id="fm" method="get">
			<!-- tab切换-->
			<div class="tab1" id="tab1">
				<?php require_once('include/sale_task_menu.php')?> 
				<div class="menudiv">
					<div id="con_one_2">
						<div class="fpgl-ss">
							<p>
								<select class="select_215" id="taskCategroy" name="taskCategroy"
									style="width: 120px;">
									<option value="0">任务分类</option>
									<option value="1">销量任务</option>
									<option value="3">店铺复购任务</option>
									<option value="4">预订单</option>
									<option value="5">预约单</option>
								</select> <select class="select_215" id="status" name="status"
									style="width: 120px;">
									<option value="">全部任务</option>
									<option value="0">进行中</option>
									<option value="4">可添加评价</option>
									<option value="5">待评价</option>
									<option value="7">全部完成</option>
								</select> <select class="select_215" id="selSearch"
									name="selSearch" style="width: 120px;">
									<option value="ut.tasksn">任务编号</option>
									<option value="ut.ordersn">订单编号</option>
									<option value="ww.wangwang">买号</option>
									<option value="s.shopname">店铺名称</option>
									<option value="p.commodity_abbreviation">商品简称</option>
								</select>
							</p>
							<p>
								<input class="input_417" id="txtSearch" name="txtSearch"
									style="width: 90px;" type="text"
									value="<?=$skey=='0'?'':$txtSearch?>">
							</p>
							<p>
								发布时间: <input class="laydate-icon" id="BeginDate" maxlength="16"
									name="BeginDate"
									onclick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm:ss'})"
									style="width: 118px; height: 34px; margin-left: 5px;"
									type="text" value="<?=$skey=='0'?'':($start==0?'': date('Y-m-d H:i:s', $start))?>"> ~
								<input class="laydate-icon" id="EndDate" maxlength="16"
									name="EndDate"
									onclick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm:ss'})"
									style="width: 118px; height: 34px;" type="text"
									value="<?=$skey=='0'?'':($end==0?'': date('Y-m-d H:i:s', $end))?>">
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
							<p>
								<input id="output-btn" class="input-butto100-hs" style="width: 80px" type="button" value="导出"
									onclick="outExcel()" title="不选时间段则为全时间段查询">
							</p>
							<p></p>
							<div class="clearfix"></div>
							<script>
                     	　　    $("#taskCategroy").val("<?=$skey=='all'?'0':$types?>");
                   	　　                $("#status").val("<?=$skey=='all'?'':$status?>");
     	　　                                                    $("#selSearch").val("<?=$skey=='0'?'0':$selSearch?>");
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
	            					$from.attr('method', 'post');
	            					$from.submit();
	            				}
	            				
	            				function search()
	            				{
	            					$from = $('form#fm');
	            					$from.attr('action', '<?=site_url('sales/searchtask')?>');
	            					$from.attr('method', 'get');
	            					$from.submit();
	            				}
                           </script>
						</div>
						<!-- 搜索-->
						<!-- 表格-->
						<div class="fprw-pg">
							<table>
								<tbody>
									<tr align="center">
										<th width="100"><center>任务分类</center></th>
										<th width="280"><center>任务/订单编号</center></th>
										<th width="220"><center>买号/商品信息</center></th>
										<th width="220"><center>商品价格/发布点</center></th>
										<th width="232"><center>任务状态</center></th>
										<th width="232"><center>操作</center></th>
										<!--<th width="132"><center>
												<input class="input-butto100-hs" style="width: 100px"
													type="button" value="一键支付佣金"
													onclick="this.disabled=true;this.value='正在保存数据';GiveAll()">
											</center></th>-->
									</tr>
                                <?php foreach($list as $vl):?>
                                    <tr>
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
											<p class="fpgl-td-rw">任务编号：<?=$vl->tasksn?></p>
											<p class="fpgl-td-rw">订单编号：<?=$vl->ordersn?></p>
                                        </td>
										<td class="fpgl-td-zs">
											<p class="fpgl-td-rw"> 买号：<?=$vl->wangwang?></p>
											<!--<p class="fpgl-td-rw">
												<strong><a href="javascript:;"
													onclick="LookBuyNumberInfo('<?=$vl->userid?>')"
													style="color: #5ca7f5">查看买号信息</a></strong>
											</p>-->
											<p class="fpgl-td-rw">
                                                店铺名称：<?=$vl->shopname?>
											</p>
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
                                            			}
                                            			echo @$how_browse;
                                        			?>
                                        			/
                                        			<?php 
                                            			switch($vl -> how_search)
                                            			{
                                            				case 1: echo $how_search; break;
                                            				case 2: echo '新关键词进入'; break;
                                            			}
                                        			?>
                                        			<?= $vl -> how_search == 2 ? '[' . $vl -> new_keyword . ']' : '';?>
                                            	</p>
                                        	<?php endif;?>
											<p class="fpgl-td-rw">
												<strong>
														<a href="javascript:;"
														onclick="GetTaskDatailInfo('<?=$vl->id?>', <?=in_array($vl -> tasktype, [4, 5]) && $vl -> status < 4 ? 1 : 0;?>)"
														style="color: #5ca7f5">查看任务详情</a></strong> <strong><a
														href="javascript:;"
														onclick="TaskRemark('<?=$vl->id?>', <?=in_array($vl -> tasktype, [4, 5]) && $vl -> status < 4 ? 1 : 0;?>)"
														style="color: #5ca7f5; padding-left: 15px;">备注信息</a>
												</strong>
											</p>
										</td>
										<td class="fpgl-td-zs">
											<center>
												<p class="fpgl-td-rw"> 商品单价：<?=$vl->price?> 元</p>
												<p class="fpgl-td-rw"> 快递费：<?=$vl->express?> 元</p>
												<p class="fpgl-td-rw"> 佣金：<?=$vl->commission?> 元</p>
												<p class="fpgl-td-rw"> 置顶费：<?=$vl->top?>元</p>
											</center>
										</td>
										<td class="fpgl-td-zs">
											<p class="fpgl-td-rw" style="text-align: center">
												<strong>
                                                    <?php
                                                	if(in_array($vl -> tasktype, [4, 5]) && $vl -> status < 4)
                                            		{
                                            			switch ($vl->status) 
														{
																case 0 :
																	echo "<a href='javascript:void(0)' style='color: #5ca7f5'>正在进行</a>";
																	break;
																case 1 :
																	echo $vl -> tasktype == 4 ? "<a href='javascript:void(0)' style='color: #5ca7f5'>已付订金（{$vl -> handsel}元）</a>" : 
																		"<a href='javascript:void(0)' style='color: #5ca7f5'>浏览完毕</a>";
																	break;
																case 3 :  //暂未确定异常取消为哪个状态
																case 4 :
																	echo "<a href='javascript:void(0)' style='color: red'>超时未支付，订单取消</a>";
																	break;
														}
                                            		}
													else
													{
														switch ($vl->status) 
														{
																case 0 :
																	echo "<a href='javascript:void(0)' style='color: #5ca7f5'>正在进行</a>";
																	break;
																case 1 :
																	echo "<a href='javascript:void(0)' style='color: #5ca7f5'>待发货</a>";
																	break;
																case 2 :
																	echo "<a href='javascript:void(0)' tyle='color: #5ca7f5'>待收货</a>";
																	break;
																case 3 :
																	echo "<a href='javascript:void(0)' style='color: #5ca7f5'>收货完成</a>";
																	break;
																case 4 :
																	echo "<a id = 'state_" . $vl->id ."' href='javascript:void(0)' style='color: #5ca7f5'>可添加评价</a>";
																	break;
																case 5 :
																	echo "<a href='javascript:void(0)' style='color: #5ca7f5'>待评价</a>";
																	break;
																case 6 :
																	echo "<a id = 'state_" . $vl->id ."' href='javascript:void(0)' style='color: #5ca7f5'>确认评价</a>";
																	break;
																case 7 :
																	echo "<a href='javascript:void(0)' style='color: #5ca7f5'>全部完成</a>";
																	break;
														}
													}
													?>
                                                </strong>
											</p>
											<p class="fpgl-td-rw">
												<strong>发布时间：</strong><?=@date("Y-m-d H:i",$vl->typeaddtime)?></p>
											<p class="fpgl-td-rw">
												<strong>接手时间：</strong><?=@date('Y-m-d H:i',$vl->addtime)?></p>
											<?php if(in_array($vl->tasktype, [4,5])):?>
											<p class="fpgl-td-rw">
												<strong>付尾款时间：</strong><?=$vl->beginPay . '至' . $vl->endPay;?></p>
											<?php endif;?>
											<p class="fpgl-td-rw">
												<a href="javascript:void()" onclick="$.openAlter('','处罚原因')"><span
													style="color: red"> </span></a>
											</p>
										</td>
										<td>
											<p class="fpgl-td-mtop">
												<input id="tid_<?=$vl->id?>" style="background: #48c2f0;" onclick="republish('<?=$vl->taskid?>')" class="input-butto100-xls" type="button" value="再次发布">
											</p>
										<?php if(!property_exists($vl, 'handsel')):?>
                                            <?php if($vl->status==0):?>
                                                <p class="fpgl-td-mtop">
												<input class="input-butto100-xls" type="button" value="正在进行"
													readonly="readonly" style="cursor: text; background: #666;">
											</p>
                                            <?php elseif($vl->status==1):?>
                                                <p class="fpgl-td-mtop">
												<input
													onclick="this.disabled=true;this.value='正在保存数据';ShopFaHuo('<?=$vl->id?>')"
													class="input-butto100-xls" type="button" value="发货">
											</p>
                                            <?php elseif($vl->status==2):?>
                                                <p class="fpgl-td-mtop">
												<input class="input-butto100-xls" type="button" value="等待收货"
													readonly="readonly" style="cursor: text; background: #666;">
											</p>
                                            <?php elseif($vl->status==3):?>
                                                <p class="fpgl-td-mtop">
												<input
													onclick="this.disabled=true;this.value='正在保存数据';InfoOk('<?=$vl->id?>')"
													class="input-butto100-xls" type="button" value="确认付款">
											</p>
                                            <?php elseif($vl->status==4):?>
                                                <p class="fpgl-td-mtop">
												<input id="tid_<?=$vl->id?>"
													onclick="AddEvaluate('<?=$vl->id?>')"
													class="input-butto100-xls" type="button" value="发布评价任务">
											</p>
                                            <?php elseif($vl->status==5):?>
                                                <p class="fpgl-td-mtop">
												<input class="input-butto100-xls" type="button" value="等待评价"
													style="cursor: text; background: #666;">
											</p>
                                            <?php elseif($vl->status==6):?>
                                                <p class="fpgl-td-mtop">
												<input id="btn_OKEvaluate"
													onclick=" OKEvaluate('<?=$vl->id?>', this)"
													class="input-butto100-xls" type="button" value="确认评价">
											</p>
                                            <?php endif;?>
                                            <?php if($vl->status>0):?>
                                                <?php if($vl->status != 4 || $vl->status != 6):?>
                                                    <?php if($vl->status < 6):?>
                                            <p class="fpgl-td-mtop">
												<input onclick="<?= in_array($vl -> tasktype, [4, 5]) ? "showPreImg({$vl -> id})" : "GetPictures('{$vl->id}')"; ?>" id="back<?=$vl->id?>" style="<?=$vl->showpicbtn=='1'?'background:#666':''?>" class="input-butto100-zsls" type="button" value="<?=$vl->showpicbtn=='1'?'已查看':'查看截图'?>">
											</p>
                                                    <?php else:?>
                                                        <p
												class="fpgl-td-mtop">
												<input onclick="<?= in_array($vl -> tasktype, [4, 5]) ? "showPreImg({$vl -> id})" : "GetPictures('{$vl->id}')"; ?>" id="back<?=$vl->id?>" style="<?=$vl->showpicbtn=='1'?'background:#666':''?>" class="input-butto100-zsls" type="button" value="<?=$vl->showpicbtn=='1'?'已查看':'查看截图'?>">
											</p>
                                                    <?php endif;?>
                                                <?php endif;?>
                                            <?php endif;?>
                                        	<?php if(in_array($vl -> tasktype, [4, 5])):?>
                                        		<p class="fpgl-td-mtop">
													<input class="input-butto100-xls" onclick="showOldStatus('<?=$vl -> ordersn?>', <?=$vl -> tasktype?>)" type="button" value="查看历史状态" style="cursor: text; background: burlywood;">
												</p>
                                			<?php endif;?>
                                            <?php if($vl->complaint==1):?>    
                                                <p class="fpgl-td-mtop">
												<input  id="scheua_<?=$vl->id?>" onclick="CreateTaskError('<?=$vl->id?>')" class="input-butto100-xls" type="button"
													value="再次提交工单" readonly="readonly"
													style="cursor: text; background: #666;">
											</p>
                                            <?php else:?>
                                                <p class="fpgl-td-mtop">
												<input id="scheua_<?=$vl->id?>" onclick="CreateTaskError('<?=$vl->id?>')"
													class="input-butto100-xhs" type="button" value="客服介入">
											</p>
                                            <?php endif;?>
                                        <?php else:?>
                                        		<?php if($vl -> status == 1):?>
	                                        		<p class="fpgl-td-mtop">
														<input onclick="dialog.showImg('<?=$vl -> tasktwoimg;?>', '搜索截图')" id="back<?=$vl->id?>" class="input-butto100-zsls" type="button" value="查看搜索截图">
													</p>
													<p class="fpgl-td-mtop">
														<input onclick="dialog.showImg('<?=$vl -> browseimg;?>', '浏览截图')" id="back<?=$vl->id?>" class="input-butto100-zsls" type="button" value="<?= $vl -> tasktype == 4 ? '查看订金截图' : '查看浏览截图'?>">
													</p>
												<?php endif;?>
                                    	<?php endif;?>
                                		</td> 	
									</tr>
                                <?php endforeach;?>
                                </tbody>
							</table>
						</div>
						<?php require_once('include/page.php')?> 
						<!-- 表格-->
					</div>
				</div>
			</div>
			<!-- tab切换-->
		</form>
	</div>
	<!-- 内容-->
	<script>
		
		/*
		 * 再次发布任务
		 */
		function republish($taskid)
		{
			dialog.iframe('<?=site_url('sales/republish')?>' +'?taskid='+ $taskid, 1000, 700);
		}
		
       function TaskRemark(taskid, $type)
       {
       		dialog.iframe('<?=site_url('sales/remark')?>' +'?key='+ taskid + '&type=' + $type, 500, 280);
           //$.openWin(280, 500, '<?=site_url('sales/remark')?>' +'?key='+ taskid);
       }
       function ShopFaHuo(taskid){
           $.openWin(500, 500, '<?=site_url('sales/sendGoods')?>' +'?key='+ taskid);
       }

       function InfoOk(taskid){
           if(confirm("确认支付佣金？")){
               $.openWin(0, 0, '<?=site_url('sales/sendMoney')?>' +'?key='+ taskid);
               //$.closeWin();
               $.openAlter("支付成功！");
               location.reload();
           }else{
               $.openAlter("取消佣金支付");
           }
          // $.openWin(500, 500, '<?=site_url('sales/sendMoney')?>' +'?key='+ taskid);
       }
       
       /*
        * 查看预订单的历史状态
        */
       function showOldStatus($ordersn, $tasktype)
       {
           public.ajax('<?=site_url('sales/showPreOldStatus')?>', {ordersn: $ordersn}, function(datas){
           		public.ajaxSuccess(datas, function(){
           			$content = '接手时间：' + datas.data.addtime + '<br />';
           			$content = $content + ($tasktype == 4 ? '支付定金：' + datas.data.handsel + '<br />支付尾款：' + datas.data.payment : '支付金额：' + datas.data.orderprice) + '<br />最后支付时间：' + datas.data.updatetime;
	           		dialog.simpLog($content);
           		});
           });
       }
       
       /*
        * 查看预单的截图
        */
       function showPreImg($id)
       {
           public.ajax('<?=site_url('sales/showPreImg')?>', {id: $id}, function(datas){
           		public.ajaxSuccess(datas, function(){
	           		dialog.showImgs(datas.data);
           		});
           });
       }
       
       function OKEvaluate(taskid, $this){
       		dialog.confirm('您已审核评价，并确认支付该笔订单的佣金吗？', '确认支付', '取消', function(){
       			public.ajax('<?=site_url('sales/saveEvaluateMoney')?>', {key: taskid}, function(datas){
       				if(datas.status)
       				{
       					dialog.success(datas.message);
       					$($this).remove();
       					$('a#state_' + taskid).html('全部完成');
       					
       				}
       				else
       				{
       					dialog.error(datas.message);
       				}
       			});
       		});
//         if(confirm("确认支付佣金？")){
//      	   var url =  '<?=site_url('sales/saveEvaluateMoney')?>?key=' + taskid ;
//      	   
//      	   $.ajax({
//      		   type: 'get', async:false ,
//      		   url: url, data: {}, dataType: "json" ,
//      		   success: function(rs){
//      			           		   if(rs.IsOK){
//      			               		   alert("支付成功！"); location.reload();
//      			               		   }
//      			           		   else{
//      			           			   alert(rs.Description);  
//      			               		   }
//  			               		   
//          		   }
//      		 });
//
//      		 
//             //$.openWin(0, 0, '<?=site_url('sales/saveEvaluateMoney')?>' +'?key='+ taskid);
//             
//         }else{
//             //$.openAlter("取消佣金支付");
//         }
       }

       function  GetTaskDatailInfo(taskid, $type){
       		dialog.iframe('<?=site_url('sales/taskInfoDetail')?>' +'?key='+ taskid + '&type=' + $type, 750, 600);
           //$.openWin(680, 750, '<?=site_url('sales/taskInfoDetail')?>' +'?key='+ taskid);
       }
       function AddEvaluate(taskid){
       		return  dialog.iframe('<?=site_url('sales/AddEvaluate')?>' +'?key='+ taskid, 750, '560', '发布评价任务');
           //$.openWin(550, 750, '<?=site_url('sales/AddEvaluate')?>' +'?key='+ taskid);
       }
       function CreateTaskError(taskid)
       {
       	   dialog.iframe('<?=site_url('sales/CreateTaskError')?>' +'?key='+ taskid, 600, 500, '创建客服介入工单')
           //$.openWin(550, 600, '<?=site_url('sales/CreateTaskError')?>' +'?key='+ taskid);
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

</body>
</html>