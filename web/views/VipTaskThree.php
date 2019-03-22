<?php require_once('include/header.php')?>
    <?php
				$xxpc = array ();
				$xxphone = array ();
				$n = 0;
				$m = 0;
				$arrKeyWordCount = explode ( '&', $KeyWordCount );
				foreach ( $searchtype as $key => $val ) {
					if ($val == 2 || $val == 5 || $val == 7) { // 获取到PC端的下标存到XXPC数组中去
						$xxpc [$n ++] = $key;
					} else { // 获取无线端的下标存到XXPHONE数组中去
						$xxphone [$m ++] = $key;
					}
				}
				$pcnum = 0;
				$phonenum = 0;
				$all = 0;
				foreach ( $xxpc as $pc ) {
					$pcnum += $arrKeyWordCount [$pc];
				}
				foreach ( $xxphone as $phone ) {
					$phonenum += $arrKeyWordCount [$phone];
				}
				$all = $pcnum + $phonenum;
				?>
<script src="<?=base_url()?>style/md5.js" type="text/javascript"></script>
<script src="<?=base_url()?>style/jquery.jBox-2.3.min.js"
	type="text/javascript"></script>
<link rel="stylesheet" type="text/css"
	href="<?=base_url()?>style/jbox.css">
<style type="text/css">
caption, th {
	text-align: center;
}

.fprw-kdlx_6 li p {
	float: left;
	font-size: 16px;
	margin-right: 10px;
}

.yctc_1200 {
	top: 10%;
	left: 5%;
	width: 1200px;
}

.fprw-kdlx_7 {
	text-align: left;
	width: 150px;
}

.input_40 {
	border: 1px solid #ddd;
	height: 24px;
	line-height: 14px;
	text-align: center;
	width: 40px;
}

.input_60 {
	border: 1px solid #ddd;
	height: 22px;
	line-height: 24px;
	text-align: Left;
	width: 60px;
}
</style>
<script language="javascript">
    
         var modey='0.00';
         var num='1';

         var platformTransfer='False';
         var selfTransfer='True';
     $(function(){
     	$money_count = parseInt($('#money_count').text());
        if(platformTransfer=="True"&&selfTransfer!="True")
        {
         $("input[name=TransferType]:eq(0)").click();
        }
        else if(platformTransfer!="True"&&selfTransfer=="True")
        {
         $("input[name=TransferType]:eq(0)").click();
        }
        var transferType = $("input[name=TransferType]:checked").val();
          if(transferType=='0')
         {    var price=parseFloat(modey*num).toFixed(2);
             $("#tdTransferMoney").html("转账费用："+modey+"元/单 * "+num+"单= <em style=\"color:red\">"+price+"</em>元");
         }
         else{
             $("#tdTransferMoney").html("转账费用：0元/单 * "+num+"单=<em style=\"color:red\">0</em>元");
         }
      $("input:radio[name=TransferType]").click(function(){
         var value=$(this).val();
         var price=parseFloat(modey*num).toFixed(2);
         if(value=='0')
         { 
             $("#tdTransferMoney").html("转账费用："+modey+"元/单 * "+num+"单= <em style=\"color:red\">"+price+"</em>元");
         }
         else{
             $("#tdTransferMoney").html("转账费用：0元/单 * "+num+"单=<em style=\"color:red\">0</em>元");
         }
      })

      if ($("#serviceValidation").length > 0) {
                var msg=$("#serviceValidation").text();
                 $("#serviceValidation").text("");
                if(msg.indexOf("发布点不足")>0)
                {
                $("#serviceValidation").append("发布点不足(<a href=\"/Member/MemberInfo/MemberDuiHuan\"   style=\"color:#4882f0\" target=\"_blank\"  onclick=\"javascript:void(0)\">请点击购买发布点</a>)");
                }
                else  if(msg.indexOf("余额不足")>0)
                {
                  $("#serviceValidation").append("余额不足(<a href=\"/Shop/InCome/NewIncomeIndex\"   style=\"color:#4882f0\" target=\"_blank\"  onclick=\"javascript:void(0)\">请点进行充值</a>)");
                }
                else
                {
                    $("#serviceValidation").append(msg);
                }
            }

            $("#txtAddToPoint").live("keydown keyup input",function(){
                var count=parseInt('<?=$all?>');
                var price=$(this).val();
                var reg = new RegExp("[^0-9]","g");  
                $(this).val(price.replace(reg,""));
                price=$(this).val();
                if(price.length > 1){
                     var reg = new RegExp("^[0]*","g"); 
                     var num = price.replace(reg,""); 
                     $(this).val(num); 
                }
                price=$(this).val();
                if(!isNaN(price))
                {
                    if(price!=""&&price!=null)
                    {
                        price=parseInt($(this).val());
                        var totalPrice=price*count;
                        $('#money_count').text($money_count + totalPrice);
                        if(totalPrice!=0)
                        {
                        	$('#top_count').text(totalPrice);
                            $("#pAddToPoint").text(count+"单*"+price+"元/单="+totalPrice+"元");
                        }
                        else
                        {
                        	$('#money_count').text($money_count);
                        	$('#top_count').text('0');
                            $("#pAddToPoint").text("0元");
                        }
                    }
                    else
                    {
                    	$('#money_count').text($money_count);
                    	$('#top_count').text('0');
                        $("#pAddToPoint").text("0元");
                    }
                }
            })
      });
        function clearNoNum(obj) {
            //先把非数字的都替换掉，除了数字和.
            obj.value = obj.value.replace(/[^\d.]/g, "");
            //必须保证第一个为数字而不是.
            obj.value = obj.value.replace(/^\./g, "");
            //保证只有出现一个.而没有多个.
            obj.value = obj.value.replace(/\.{2,}/g, ".");
            //保证.只出现一次，而不能出现两次以上
            obj.value = obj.value.replace(".", "$#$").replace(/\./g, "").replace("$#$", ".");
        }
        //点击下一步
        function submitNext() {
            var taskNum=1;
            var taskCount=0;
            var lookMoney=0;
          
            var selfMoeny=0;//自发空包减免费用
            var addPoint=$("#txtAddToPoint").val();
            var totalPoint=parseFloat($("#pointSum").text())+parseFloat(taskNum*addPoint);
            var taskSumCount=parseFloat($("#taskCounSum").text())+parseFloat(taskNum*addPoint)+parseFloat(lookMoney);
            var expressTypeValue = "";
            $("#tdAddPoint").text($("#tddToPoint").val());
              var expressType = $("input[name=ExpressNumberType]:checked").val();
              var transferType = $("input[name=TransferType]:checked").val();
              var addToPoint=$("#txtAddToPoint").val();
              /* 转账方式条件判断
                if(transferType==null)
                {
                  $.openAlter("请点击选择转账方式。","提示");
                  return fade;
                }
                */
                if(parseFloat(addToPoint)>50)
                {
                  $.openAlter("亲，平台限制置顶费用的最高金额为50元。您设置的金额数已超过50，请进行修改。","提示");
                  return false;
                }
            $("#lblSelfBag").text("0");
            if (expressType == "0")
            {
                expressTypeValue = "自发快递";
                selfMoeny=parseInt(taskNum)*-2.00;
                $("#liself").show();
                $("#lblSelfBag").text(selfMoeny);
                taskSumCount=taskSumCount+selfMoeny;
           }
           else if (expressType == "4")
            {
                expressTypeValue = "真实运单号";
                selfMoeny=parseInt(taskNum)*-2.00;
                $("#liself").show();
                $("#lblSelfBag").text(selfMoeny);
                taskSumCount=taskSumCount+selfMoeny;
           }
            else if (expressType == "1")
                expressTypeValue = "韵达快递";
            else if (expressType == "2")
                expressTypeValue = "圆通快递";
            else if (expressType == "3")
                expressTypeValue = "全峰快递";
            $("#spExpressType").text(expressTypeValue);
               if(transferType=='0')
                {
                   var modey='0.00';
                  var num='1';
                   var price=parseFloat(modey*num).toFixed(2);
                   totalPoint+=parseFloat(price);
                   taskSumCount+=parseFloat(price);
                    $("#tdTransferPoint").text("0.00");
                    $("#labProductPrice").text($("#hidProductPrice").val());
                }
                 else{
                      $("#tdTransferPoint").text("0");
                       taskSumCount-=parseFloat($("#hidProductPrice").val());
                       $("#labProductPrice").text("0");
                   }
            $("#labTaskCount").text(parseFloat(taskSumCount).toFixed(2)); 
            $("#lblTotalPoint").text(totalPoint);
            document.getElementById('light1').style.display = 'block'; document.getElementById('fade').style.display = 'block';
        }
        $(function () {
            $("input[name=AddToPoint]").live("focus", function () {
                if ($(this).val() < 1) {
                    $(this).val(" ");
                }
            });
            $("input[name=AddToPoint]").live("focusout", function () {
                if ($(this).val() < 1) {
                    $(this).val(0);
                }
            });

            //增加置顶费用
            $("#imgAdd").live("click", function () {
                var taskNum = parseInt($(this).parent().prev().children().val());
                $(this).parent().prev().children().val(taskNum + 1);

                var count=parseInt('<?=$all?>');
                var price=taskNum+1;
                if(!isNaN(price))
                {
                    if(price!=""&&price!=null)
                    {
                        var totalPrice=price*count;
                        $('#top_count').text(totalPrice);
                        $("#pAddToPoint").text(count+"单*"+price+"元/单="+totalPrice+"元");
                    }
                    else
                    {
                    	$('#top_count').text(0);
                        $("#pAddToPoint").text("0元");
                    }
                }
            });
            //减少任务数
            $("#imgReduce").live("click", function () {
                var taskNum = parseInt($(this).parent().next().children().val());
                if (taskNum > 0) {
                    $(this).parent().next().children().val(taskNum - 1);
                    var count=parseInt('<?=$all?>');
                    var price=taskNum-1;
                    if(!isNaN(price))
                    {
                        if(price!=""&&price!=null)
                        {
                            var totalPrice=price*count;
                            $("#pAddToPoint").text(count+"单*"+price+"元/单="+totalPrice+"元");
                        }
                        else
                        {
                            $("#pAddToPoint").text("0元");
                        }
                    }
                }
                else
                {
                    $("#pAddToPoint").text("0元");
                }
            });

        })
        
        //将任务信息插入数据库中
        function insertTask($post)
        {
        	public.ajax('<?=site_url('sales/taskStepDB')?>', $post, function(datas){
				if(datas.status)
				{
					dialog.success(datas.message);
        			location.href = '/sales/taskno';
				}
				else
				{
					dialog.error(datas.message);
				}
			});
        }
        
        //验证支付密码是否正确以及资产是否富余
        function btnSubmit() {
            if ($("#pwd").val() == "") 
            {
                dialog.error('支付密码不能为空');
            }
            else
            {
            	var $post = $('form#frm').serialize();
            	$post += '&top_count=' + $('#top_count').text();
            	public.ajax("<?=site_url('sales/checkPayPasswd')?>", $post, function(datas){
            		if(datas.status == 1)  //资产富余且密码正确
            		{
            			dialog.success(datas.message);
            			location.href = '/sales/taskno';
            			
            		}
            		else if(datas.status == 2)  //资产不富余
            		{
            			dialog.confirm(datas.message, '继续发布', '取消', function(){
            				insertTask($post);
            			});
            		}
            		else if(datas.status == 3)
            		{
            			dialog.confirm(datas.message, '前往充值', '取消', function(){
            				window.open('/capital');
            				dialog.confirm('若您已完成充值，可继续发布任务', '已充值，继续发布', '取消', function(){
	            				btnSubmit();
	            			});
            			});
            		}
            		else  //密码错误
            		{
            			dialog.error(datas.message);
            		}
            	});
            }
        }
        
          
    </script>

<body style="background: #fff;">
    <?php require_once('include/nav.php')?>
    <!--daohang-->


	<form action="<?=site_url('sales/taskStepDB')?>" id="frm" method="post">
		<div id="light1" class="ycgl_tc yctc_1200">
			<!--标题 -->
			<div class="htyg_tc">
				<ul>
					<li class="htyg_tc_1">确认任务信息</li>
					<li class="htyg_tc_2"><a href="javascript:void(0)"
						onclick="document.getElementById('light1').style.display='none';document.getElementById('fade').style.display='none'">
							<img src="<?=base_url()?>style/images/sj-tc.png">
					</a></li>
				</ul>
			</div>
			<!--标题 -->
			<!--滚动内容 -->
			<div class="sk-hygl-gd_gq">
				<!--表单内容 -->
				<div class="yctc_1160 ycgl_tc_1">
					<!--表格内容 -->
					<div class="fprw-sdsp_2">
						<table style="table-layout: fixed;">
							<tbody>
								<tr>
									<th width="182">店铺名&nbsp;&nbsp;&nbsp;</th>
									<td width="700">
                                    <?php
																																				
																																				foreach ( $shops as $vs ) {
																																					if ($proinfo->shopid == $vs->sid) {
																																						echo $vs->shopname;
																																					}
																																				}
																																				?>
                                </td>
									<td width="208" rowspan="4"><img
										src="<?=$proinfo->commodity_image?>" width="200" height="200">
									</td>
								</tr>
								<tr>
									<th width="182">商品标题</th>
									<td width="700">
                                   <?=$proinfo->commodity_title?>
                                </td>
								</tr>
								<tr>
									<th width="182">商品链接</th>
									<td width="700" style="word-wrap: break-word">
                                    <?=$proinfo->commodity_url?>
                                </td>
								</tr>
								<tr>
									<th width="182">任务类型</th>
									<td width="765">
										<p class="fprw-kdlx_3">
											<strong>销量任务：</strong>
										</p>
										<p class="fprw-kdlx_3">
                                        <?php
																																								$arrKeyWordCount = explode ( '&', $KeyWordCount );
																																								$searchTypearr = explode ( '&', $SearchType );
																																								foreach ( $searchTypearr as $key => $st ) {
																																									switch ($st) {
																																										case 1 :
																																											echo '淘宝APP自然搜索<em class="cff3430"> ' . intval ( $arrKeyWordCount [$key] ) . ' </em> &nbsp; ';
																																											break;
																																										case 2 :
																																											echo '淘宝PC自然搜索<em class="cff3430"> ' . intval ( $arrKeyWordCount [$key] ) . ' </em> &nbsp; ';
																																											break;
																																										case 3 :
																																											echo '淘宝APP淘口令<em class="cff3430"> ' . intval ( $arrKeyWordCount [$key] ) . ' </em> &nbsp; ';
																																											break;
																																										case 4 :
																																											echo '淘宝APP直通车<em class="cff3430"> ' . intval ( $arrKeyWordCount [$key] ) . ' </em> &nbsp; ';
																																											break;
																																										case 5 :
																																											echo '淘宝PC直通车<em class="cff3430"> ' . intval ( $arrKeyWordCount [$key] ) . ' </em> &nbsp; ';
																																											break;
																																										case 6 :
																																											echo '淘宝APP二维码<em class="cff3430"> ' . intval ( $arrKeyWordCount [$key] ) . ' </em> &nbsp; ';
																																											break;
																																										default :
																																											echo '入口设置错误';
																																									}
																																								}
																																								?>
                                    </p>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<!--表格内容 -->
					<!--表格内容 -->
					<div class="fprw-kdlx_4">
						<table>
							<tbody>
								<tr>
									<th width="182" rowspan="11">关键字设置</th>
								</tr>
								<tr>
									<th width="120">任务分类</th>
									<th width="190">流量入口</th>
									<th>关键字</th>
									<th width="90">数量</th>
									<th width="190">其他搜索条件</th>
								</tr>
                                <?php $arrSearchKey = empty($_COOKIE['SearchKey'])?array(''):explode('&',$_COOKIE['SearchKey']);?>
                                <!--<?php var_dump( $arrSearchKey )?>-->
                                <?php $arrIDorder = explode('&',$_COOKIE['IDorder']);?>
                                <?php $arrIDprice = explode('&',$_COOKIE['IDprice']);?>
                                <?php $arrIDaddress = explode('&',$_COOKIE['IDaddress']);?>
                                <?php $arrIDother = explode('&',$_COOKIE['IDother']);?>
                                
                                <?php foreach($searchTypearr as $key=>$st):?>
                                    <tr>
									<td>
                                        <?php
																																	$tasktype = $_COOKIE ['typepage'];
																																	if ($tasktype == 0) {
																																		$tasktype = $this->session->userdata ( 'typepage' );
																																	}
																																	?>
                                        <?php
                                    		switch($tasktype)
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
                                        </td>
									<td><?php
																																	
																																	switch ($st) {
																																		case 1 :
																																			echo '淘宝APP自然搜索';
																																			break;
																																		case 2 :
																																			echo '淘宝PC自然搜索';
																																			break;
																																		case 3 :
																																			echo '淘宝APP淘口令';
																																			break;
																																		case 4 :
																																			echo '淘宝APP直通车';
																																			break;
																																		case 5 :
																																			echo '淘宝PC直通车';
																																			break;
																																		case 6 :
																																			echo '淘宝APP二维码';
																																			break;
																																		default :
																																			echo '入口设置错误';
																																	}
																																	?></td>
									<td><?php echo $arrSearchKey[$key]?></td>
									<td><?php echo intval($arrKeyWordCount[$key])?></td>
									<td>
										<ul><?php if( $arrIDorder[$key] != 0):?>
                                               <li> 
                                                   <?php
																																		
																																		echo '排序方式：';
																																		switch ($arrIDorder [$key]) {
																																			case 1 :
																																				echo '综合';
																																				break;
																																			case 2 :
																																				echo '新品';
																																				break;
																																			case 3 :
																																				echo '人气';
																																				break;
																																			case 4 :
																																				echo '销量';
																																				break;
																																			case 5 :
																																				echo '价格从地到高';
																																				break;
																																			case 6 :
																																				echo '价格从高到低';
																																				break;
																																		}
																																		;
																																		?>
                                                 </li>
                                                 <?php endif;?>
                                                <?php if( $arrIDprice[$key] != 0):?><li><?php echo '价格区间：'.$arrIDprice[$key];?></li><?php endif;?>
                                                <?php if( $arrIDaddress[$key] != 0):?><li><?php echo '发货地：'.$arrIDaddress[$key];?></li><?php endif;?>
                                                <?php if( $arrIDother[$key] != 0):?><li><?php echo '其他：'.$arrIDother[$key]; ?></li><?php endif;?>
                                            </ul>
									</td>
								</tr>
                                <?php endforeach;?>
                            </tbody>
						</table>
					</div>
					<!--表格内容 -->
					<!--表格内容 -->
					<div class="fprw-kdlx_4">
						<table>
							<tbody>
								<tr>
									<th width="182" rowspan="16">成交金额</th>
								</tr>
								<tr>
									<th width="244">成交金额</th>
									<th width="244">任务数量</th>
									<th width="244">任务佣金</th>
									<th width="244">任务快递费用</th>
									<th width="244">合计</th>
								</tr>
                            <?php
																												/*
																												 * $SingleProductPrice=explode('&',$_COOKIE['SingleProductPrice']);
																												 * $ExpressCharge=explode('&',$_COOKIE['ExpressCharge']);
																												 * $BuyProductCount=explode('&',$_COOKIE['BuyProductCount']);
																												 * $ProductPriceListCount=explode('&',$_COOKIE['ProductPriceListCount']);
																												 */
																												$SingleProductPrice = array_values ( $SingleProductPrice );
																												?>
                            <?php foreach($SingleProductPrice as $key=>$spp):?>
                                <tr>
									<td><?=intval($spp)*$BuyProductCount[$key]?></td>
									<td><input type="hidden" name="ProductPriceListCount"
										value="<?=intval($ProductPriceListCount[$key])?>"><?=intval($ProductPriceListCount[$key])?>
                                    </td>
									<td><label><?=$ProCommission[$key]?></label></td>
									<td><input type="hidden" name="ExpressCharge"
										value="<?=$ExpressCharge[$key]?>"><?=$ExpressCharge[$key]?>
                                    </td>
									<td><?=(intval($spp) * intval($BuyProductCount[$key] ) + $ExpressCharge[$key] + $ProCommission[$key])*intval($ProductPriceListCount[$key])?></td>
								</tr>
                             <?php endforeach;?>
                        </tbody>
						</table>
					</div>
                    <?php
																				$paytotle = 0;
																				$gittotle = 0;
																				$expresstotle = 0;
																				$alltotle = 0;
																				for($n = 0; $n < count ( $SingleProductPrice ); $n ++) {
																					$paytotle += $SingleProductPrice [$n] * $BuyProductCount [$n] * $ProductPriceListCount [$key];
																					$gittotle += $ProCommission [$n] * $ProductPriceListCount [$key];
																					$expresstotle += $ExpressCharge [$n] * $ProductPriceListCount [$key];
																				}
																				$alltotle = $expresstotle + $gittotle;
																				?>
                    <div class="fprw-kdlx_5">
						<p>
							成交总金额：<em class="cff3430"><?=$paytotle?></em>元
						</p>
						<p>
							佣金总金额：<em class="cff3430" id="pointSum"><?=$gittotle?></em>元
						</p>
						<p>
							任务快递总费用：<em class="cff3430" id="expressSum"><?=$expresstotle?></em>元
						</p>
						<p>
							合计：<em class="cff3430" id="taskCounSum"><?=$alltotle?></em>元
						</p>
					</div>
					<!--表格内容 -->
					<!--表格内容 -->
					<div class="fprw-sdsp_2" style="margin-top: 20px;">
						<table>
							<tbody>
								<tr>
									<th>日期</th>
                                <?php foreach($TaskDate as $vtd):?>
                                    <td><?=@date('m月d日',@strtotime($vtd))?></td>
                                <?php endforeach;?>
                            </tr>
								<tr>
									<th>发布数量</th>
                                <?php for($n=0;$n<7;$n++):?>
                                    <td><?=isset($TaskPlanCount[$n])?$TaskPlanCount[$n]:0?></td>
                                <?php endfor;?>
                            </tr>
							</tbody>
						</table>
					</div>
					<!--表格内容 -->
					<!--表格内容 -->
					<div class="fprw-sdsp_2" style="margin-top: 20px;">
						<table style="width: 54%">
							<tbody>
								<tr>
									<th width="135">快递类型：</th>
									<td width="130"><span id="spExpressType"></span></td>
									<th width="130">置顶费用：</th>
									<td width="130"><em class="cff3430" id="tdAddPoint">0</em>元/单</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="fprw-kdlx_6">
						<ul>
							<li class="clear"></li>
							<li class="clear"></li>
							<li>
								<p class="fprw-kdlx_7">
									佣金： <label style="color: Red"><?=$gittotle?></label> 元
								</p>
							</li>
							<li class="clear"></li>
							<!--<li id="liself">
								<p class="fprw-kdlx_7">
									快递： <label style="color: Red"><?=$expresstotle?></label> 元
								</p>
							</li>-->
							<li id="liself">
								<p class="fprw-kdlx_7">
									置顶费： <label id="top_count" style="color: Red">0</label> 元
								</p>
							</li>
							<li class="clear"></li>
							<li>
								<p class="fprw-kdlx_7">
									合计： <label style="color: Red" id="money_count"><?=$alltotle?></label> 元
								</p>
							</li>
							<li style="color: red;">
								<?php if ($cash_deposit > 0):?>
									<p>余额预估: <?php $balance = $info -> Money - $info -> bond - $gittotle; echo '（余额）' . $info -> Money .  ' - (保证金)' . $info -> bond . ' - (佣金)' . $gittotle . ' = ' . $balance?></p>
								<?php else:?>
									<p>余额预估: <?php $balance = $info -> Money - $gittotle; echo '（余额）' . $info -> Money . ' - (佣金)' . $gittotle . ' - (置顶费)' . $gittotle . ' = ' . $balance?></p>
								<?php endif;?>
								<br />
								<p>【<?=$balance > 0 ? '余额富足，您可继续发布任务' : '当前余额不足以支付佣金，继续发布任务不会被接手，请先充值';?>】</p>
							</li>
							<li>
								<p>
									支付密码：<input id="pwd" style="width: 150px"
										name="TradersPassword" type="password" maxlength="25"
										class="input_60">
								</p>
							</li>
							<li class="clear"></li>
							<li><input id="btnSubmitOk"
								onclick="btnSubmit()"
								class="input-butto100-ls" type="button" value="确认发布"></li>
						</ul>
					</div>
					<!--表格内容 -->
				</div>
				<!--表单内容 -->
			</div>
			<!--滚动内容 -->
		</div>

		<input id="ProductID" name="ProductID" type="hidden" value="<?=$proinfo->id?>">
		<input id="ShopID" name="ShopID" type="hidden" value="<?=$proinfo->shopid?>">
		<input id="action_commission" name="action_commission" type="hidden" value="<?=$gittotle;?>">

		<div id="fade" class="black_overlay" style="height: 130%"></div>
		<!-- 内容-->
		<div class="sj-fprw">
			<div class="tab1" id="tab1">
				<div class="menu">
					<ul>
						<li id="one2" class="off"
							onclick="location.href='<?=site_url('sales')?>'">发布任务</li>
						<li id="one1"
							onclick="location.href='<?=site_url('sales/task')?>'">任务管理</li>
					</ul>
				</div>
			</div>
			<div style="width: 1315px; margin-left: -80px;">
				<style>
.infobox {
	background-color: #fff9d7;
	border: 1px solid #e2c822;
	color: #333333;
	padding: 5px;
	padding-left: 30px;
	font-size: 13px; -
	-font-weight: bold;
	margin: 0 auto;
	margin-top: 10px;
	margin-bottom: 10px;
	width: 85%;
	text-align: left;
}

.errorbox {
	background-color: #ffebe8;
	border: 1px solid #dd3c10;
	margin: 0 auto;
	margin-top: 10px;
	margin-bottom: 10px;
	color: #333333;
	padding: 5px;
	padding-left: 30px;
	font-size: 13px; -
	-font-weight: bold;
	width: 85%;
}
</style>
			</div>
			<!-- 切换-->
			<div class="fprw_qh" style="margin-top: 20px">
				<ul>
					<li class="fprw_qhys">第一步：来路设置</li>
					<li class="fprw_qhys">第二步：价格和发布时间</li>
					<li class="fprw_qhys">第三步：快递和备注</li>
				</ul>
			</div>
			<!-- 切换-->
			<!--           <div class="errorbox" id="serviceValidation">
        安全密码不正确
    </div> -->
			<!-- 标题-->
			<div class="fprw-zpt">
				<div class="left fprw-jg">
					<p>快递类型</p>
				</div>
				<div class="right">
					<span class="fprw-pt-xts_1">总数：<em class="cff3430"><?=$all?></em>
					</span> <span class="fprw-pt-xts_1">PC：<em class="cff3430"><?=$pcnum?></em>
					</span> <span class="fprw-pt-xts_1">APP：<em class="cff3430"><?=$phonenum?></em>
					</span>
				</div>
			</div>
			<!-- 标题-->
			<!-- 表格-->
			<div class="fprw-pg" style="margin-top: 0px;">
				<table>
					<tbody>
						<tr>
							<th width="200">快递类型</th>
							<th width="507">说明</th>

						</tr>
						<tr>
							<td align="center">
								<div style="margin-left: 10px">
									<p class="left fprw-kdlx" style="margin-top: 10px">
										<input class="input-radio16" id="ExpressNumberType"
											name="ExpressNumberType" checked="checked"
											style="height: 15px;" type="radio" value="0">
									</p>
									<p class="left" style="margin-top: 8px">自发快递</p>
								</div>
							</td>
							<td>快递物流信息自理。</td>
						</tr>
					</tbody>
				</table>
			</div>
			<!-- 表格-->
			<!-- 置顶费用-->
			<div class="fprw-kdlx_1">
				<p>置顶费用：</p>
				<!--<p class="left fprw-jg_4" style="margin-top: 18px;">
					<a href="javascript:void(0)" id="imgReduce"> <img
						src="<?=base_url()?>style/images/fprw-jg.png"></a>
				</p>-->
				<p class="left" style="margin-top: 1px">
					<input class="input_40" data-val="true" onchange="changedb(this);"
						data-val-number="字段 AddToPoint 必须是一个数字。"
						data-val-required="AddToPoint 字段是必需的。" id="txtAddToPoint"
						name="AddToPoint" onkeyup="value=value.replace(/[^0-9]/g,'')"
						placeholder="0" type="text" value="0" autocomplete="off">
				</p>
				<script>
function changedb(obj){
	$("#tdAddPoint").text($("#txtAddToPoint").val());
}              
</script>
				<!--<p class="left fprw-jg_5" style="margin-top: 15px;">
					<a href="javascript:void(0)" id="imgAdd"> <img
						src="<?=base_url()?>style/images/fprw-jg_2.png"></a>
				</p>-->
				<p>元/单</p>
				<p style="color: Red; margin-left: 10px;">共计：</p>
				<p id="pAddToPoint">0元</p>
				<p class="cff3430" style="float: right;">友情提示：置顶费用越高，任务越快被分配</p>
			</div>
			<!-- 置顶费用-->
			<!-- 备注信息-->
			<div class="fprw-kdlx_2">
				<p style="line-height: 38px;">任务说明：</p>
				<p>
					<textarea class="textarea_1050"  id="textarea"
						name="remark" rows="5"></textarea>
				</p>
			</div>
			<div class="fprw-rwlx_6 sjzc_7">
				<a href="javascript:void(0)" onclick="submitNext()">下一步</a>
			</div>
		</div>
		<!-- 内容-->
	</form>

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

    <?php require_once('include/nav.php')?>


</body>
</html>