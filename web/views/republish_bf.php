<?php require_once('include/header.php')?> 
	<link rel="stylesheet" type="text/css" href="/style/ext/layui/css/layui.css">
	<div style="padding: 2%;">
		<form id="republish_fm" class="layui-form" action="javascript:;" lay-filter="republish_fm">
			<ul class="layui-timeline">
			  <li class="layui-timeline-item">
			    <i class="layui-icon layui-timeline-axis">&#xe63f;</i>
			    <div class="layui-timeline-content layui-text">
			      <h3 class="layui-timeline-title">商品信息</h3>
			      <div>
			        <p>商品简称：<?=$commodity_abbreviation;?></p>
			        <p>商品ID：<?=$commodity_id;?></p>
			        <p>店铺名：<?=$shopname;?></p>
			        <p>商品标题：<?=$commodity_title;?></p>
			        <p>商品链接：<a href="<?=$commodity_url;?>"><?=$commodity_url;?></a></p>
			      </div>
			    </div>
			  </li>
			  <li class="layui-timeline-item">
			    <i class="layui-icon layui-timeline-axis">&#xe63f;</i>
			    <div class="layui-timeline-content layui-text">
			      <h3 class="layui-timeline-title">来路设置</h3>
			      <div>
			      	<div class="layui-form-item">
					    <label class="layui-form-label">流量入口</label>
					    <div class="layui-input-inline" style="width: 17%;">
					      <select name="intlet" lay-verify="required">
					        <option value=""></option>
					        <option value="1">淘宝APP自然搜索</option>
					        <option value="2">淘宝PC自然搜索</option>
					        <option value="3">淘宝APP淘口令</option>
					        <option value="4">淘宝APP直通车</option>
					        <option value="5">淘宝PC直通车</option>
					        <option value="6">淘宝APP二维码</option>
					      </select>
					    </div>
					    <label class="layui-form-label">关键词</label>
					    <div class="layui-input-inline" style="width: 17%;">
					      <input type="text" name="keyword" required  lay-verify="required" placeholder="请输入关键词" autocomplete="off" class="layui-input">
					    </div>
					    <label class="layui-form-label">数量</label>
					    <div class="layui-input-inline" style="width: 17%;">
					      <input type="text" name="number" required  lay-verify="required|number" placeholder="请输入数量" autocomplete="off" class="layui-input about_money">
					    </div>
				  	</div>
				  	<h4 class="layui-timeline-title">其它搜索条件(可选)</h4>
				  	<div class="layui-form-item">
					    <label class="layui-form-label">排序方式</label>
					    <div class="layui-input-inline" style="width: 30%;">
					      <select name="order">
					        <option value=""></option>
					        <option value="1">综合</option>
					        <option value="2">新品</option>
					        <option value="3">人气</option>
					        <option value="4">销量</option>
					        <option value="5">价格从低到高</option>
					        <option value="6">价格从高到低</option>
					      </select>
					    </div>
					    <label class="layui-form-label">价格区间</label>
						<div class="layui-input-inline" style="width: 100px;">
							<input type="text" name="price_min" placeholder="￥" autocomplete="off" class="layui-input">
						</div>
						<div class="layui-form-mid">-</div>
						<div class="layui-input-inline" style="width: 100px;">
							<input type="text" name="price_max" placeholder="￥" autocomplete="off" class="layui-input">
						</div>
				  	</div>
				  	<div class="layui-form-item">
					    <label class="layui-form-label">发货地</label>
					    <div class="layui-input-inline" style="width: 30%;">
					      <input type="text" name="sendaddress" placeholder="请输入关键词" autocomplete="off" class="layui-input">
					    </div>
					    <label class="layui-form-label">其它</label>
					    <div class="layui-input-inline" style="width: 30%;">
					      <input type="text" name="other" placeholder="请输入数量" autocomplete="off" class="layui-input">
					    </div>
			    	</div>
			      </div>
			    </div>
			  </li>
			  <li class="layui-timeline-item">
			    <i class="layui-icon layui-timeline-axis">&#xe63f;</i>
			    <div class="layui-timeline-content layui-text">
			      <h3 class="layui-timeline-title">定价类型</h3>
			      <div class="layui-form-item">
				    <label class="layui-form-label">商品单价</label>
				    <div class="layui-input-inline" style="width: 17%;">
				      <input type="text" name="price" required  lay-verify="required" placeholder="请输入关键词" autocomplete="off" class="layui-input about_money">
				    </div>
				    <label class="layui-form-label">快递费</label>
				    <div class="layui-input-inline" style="width: 17%;">
				      <input type="text" name="express" required  lay-verify="required" placeholder="请输入数量" autocomplete="off" class="layui-input about_money">
				    </div>
				    <label class="layui-form-label">拍下件数</label>
				    <div class="layui-input-inline" style="width: 17%;">
				      <input type="text" name="auction" required  lay-verify="required" placeholder="请输入数量" autocomplete="off" class="layui-input about_money">
				    </div>   
			  	  </div>
			  	  <p style="padding-left: 4.2%;">
			  	  	单任务佣金：<span id="commission_one"></span>
			  	  </p>
			  	  <p style="padding-left: 4.2%;">
			  	  	佣金总金额：<span id="commission_all"></span>
			  	  </p>
			  	  <p style="padding-left: 4.2%;">
			  	  	单任务成交金额：<span id="one_money"></span>
			  	  </p>
			  	  <p style="padding-left: 4.2%;">
			  	  	成交总金额：<span id="sum_money"></span>
			  	  </p>
			  	  <p style="padding-left: 4.2%;">
			  	  	合计：<span id="total"></span>
			  	  </p>
			    </div>
			  </li>
			  <li class="layui-timeline-item">
			    <i class="layui-icon layui-timeline-axis">&#xe63f;</i>
			    <div class="layui-timeline-content layui-text">
			      <h3 class="layui-timeline-title">发布时间</h3>
			      <div class="layui-form-item">
				    <label class="layui-form-label">发布方式</label>
				    <div class="layui-input-block">
				      <input type="radio" name="gettime" value="0" title="立即发布" lay-filter="gettime">
				      <input type="radio" name="gettime" value="1" title="今日平均发布" lay-filter="gettime">
				    </div>
				  </div>
				  <div class="layui-form-item">
				  	<div class="layui-inline">
					    <label class="layui-form-label">平均周期</label>
					    <div class="layui-input-inline">
					       <input type="text" name="average_time" class="layui-input" id="average_time" placeholder=" - ">
					    </div>
				    </div>
				    <div class="layui-inline">
				      <label class="layui-form-label">超时取消</label>
				      <div class="layui-input-inline">
				        <input name="close" type="text" class="layui-input" id="close_time">
				      </div>
				    </div>
				  </div>
			    </div>
			  </li>
			  <?php if($tasktype > 3):?>
				  <li class="layui-timeline-item">
				    <i class="layui-icon layui-timeline-axis">&#xe63f;</i>
				    <div class="layui-timeline-content layui-text">
				      <h3 class="layui-timeline-title">预约单设置</h3>
				      <div>
				      	<div class="layui-form-item">
						    <label class="layui-form-label">浏览操作</label>
						      <div class="layui-input-inline" style="width: 20%;">
						      <select name="how_browse" lay-verify="required">
						      	<option value=""></option>
						        <option value="1">加入购物车(买手需加购四款同类产品)</option>
						        <option value="2">收藏(买手需收藏五款同类产品)</option>
						        <option value="3">货比三家，截图'足迹'证明</option>
						      </select>
					      </div>
					      <label class="layui-form-label">付款时操作</label>
					      <div class="layui-input-inline" style="width: 20%;">
						      <select name="how_search" lay-verify="required">
						      	<option value=""></option>
						        <option value="1">从浏览操作中直接进入</option>
						        <option value="2">以新的关键词进入</option>
						      </select>
					      </div>
					      <label class="layui-form-label">下单关键词</label>
					      <div class="layui-input-inline" style="width: 17%;">
						      <input type="text" name="new_keyword" required  lay-verify="required" placeholder="流量入口一致" autocomplete="off" class="layui-input">
						  </div>
					  	</div>
				      </div>
				    </div>
				  </li>
			  <?php endif;?>
			  <li class="layui-timeline-item">
			    <i class="layui-icon layui-timeline-axis">&#xe63f;</i>
			    <div class="layui-timeline-content layui-text">
			      <h3 class="layui-timeline-title">其它信息</h3>
			      <!--<div class="layui-form-item">
				    <label class="layui-form-label">置顶费</label>
				    <div class="layui-input-inline" style="width: 17%;">
				      <input type="text" name="top" required  lay-verify="required" placeholder="请输入关键词" autocomplete="off" class="layui-input">
				    </div>
			  	  </div>-->
			  	  <div class="layui-form-item layui-form-text">
				    <label class="layui-form-label">备注</label>
				    <div class="layui-input-block">
				      <textarea name="remark" placeholder="请输入内容" class="layui-textarea"></textarea>
				    </div>
				  </div>
				  <div class="layui-input-block">
				      <button class="layui-btn" lay-submit="" lay-filter="submit_btn">立即提交</button>
			      </div>
			    </div>
			  </li>
			</ul>
		</form>
	</div>
	<script src="/style/ext/layui/layui.js" type="text/javascript"></script>
	<script type="text/javascript">
		price_compute(<?=$price;?>, <?=$express?>, <?=$auction?>, <?=$number?>);   //初始化价格预览
		//发布类型时间空件的初始化
		$('input#average_time').attr('disabled', <?=$gettime ? false :true;?>);
		$('input#average_time').css('cursor', '<?=$gettime ? 'pointer' :'not-allowed';?>');
		
		//绑定涉及价格的表单输入
		$('.about_money').bind('input', function(){
			clearNoNum(this);
			var $price = parseInt($('input[name=price]').val()),
				$express = parseInt($('input[name=express]').val()),
				$auction = parseInt($('input[name=auction]').val()),
				$number = parseInt($('input[name=number]').val());
			price_compute($price, $express, $auction, $number);
		})
		
		var myDate = new Date(),
			$min_time = myDate.getHours() + ':' + myDate.getMinutes() + ':' + myDate.getSeconds();
		layui.use(['form', 'laydate'], function(){
		  var form = layui.form,
		  	  laydate = layui.laydate;
		  	  
		  //平均范围控件
		  laydate.render({
		    elem: '#average_time',
		    type: 'time',
		    range: true,
		    format: 'HH:mm',
		    value: '<?=$gettime ? $start . ' - ' . $end : '' ;?>',
		    min: $min_time,
		  });
		  
		  //结束时间控件
		  laydate.render({
		    elem: '#close_time',
		    type: 'time',
		    format: 'HH:mm',
		    min: $min_time,
		  });
		  
		  //流量入口变化监听
		  form.on('select(filter)', function(data){
			  console.log(data.elem); //得到select原始DOM对象
			  console.log(data.value); //得到被选中的值
			  console.log(data.othis); //得到美化后的DOM对象
		  });
		  
		  //发布类型变化监听
		  form.on('radio(gettime)', function(data){
		      $('input#average_time').attr('disabled', data.value == 0 ? true : false);
		      $('input#average_time').val('');
		      $('input#average_time').css('cursor', data.value == 0 ? 'not-allowed' : 'pointer');
		  });
		  
		  function Appendzero(obj) 
		  {
	      	if (obj < 10) 
	      		return "0" + obj; 
      		else 
      			return obj;
	      }
		  
		  
		  //监听表单提交
		  form.on('submit(submit_btn)', function(data){
		  	console.log(data.field) //当前容器的全部表单字段，名值对形式：{name: value}
		  	if (!(data.field.gettime == 1 && !data.field.average_time))
		  	{
		  		var $average_time = data.field.average_time.split('-'),
		  			myDate = new Date(),
		  			$now = Appendzero(myDate.getHours()) + ':' + myDate.getMinutes();
		  		if (data.field.gettime == 0 || $average_time[0].trim() > $now)
		  		{
		  			if (data.field.gettime == 0 || $average_time[0].trim() < $average_time[1].trim())
			  		{
			  			console.log(data.field.close.trim());
			  			console.log($now);
			  			if (data.field.close.trim() >= $now)
			  			{
			  				if (data.field.gettime == 0 || data.field.close.trim() >= $average_time[1].trim())
				  			{
				  				data.field.taskid = <?=$_GET['taskid'];?>;
				  				data.field.commission = $('span#commission_one').html();
				  				layer.prompt({
								  formType: 1,
								  title: '请输入安全码以完成发布',
								  area: ['200px', '20px'] //自定义文本域宽高
								}, function(value, index, elem){
									data.field.TradersPassword = value;
									data.field.is_republish = 1;
								  	public.ajax("<?=site_url('sales/checkPayPasswd')?>", data.field, function(datas){
						        		if(datas.status == 1)  //资产富余且密码正确
						        		{
						        			dialog.success(datas.message);
						        			dialog.iframe_close();
						        			
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
						        			dialog.error(datas.message);
						        	});
								});
				  			}
				  			else
				  				dialog.error('超时取消时间必须大于平均周期的结束时间');
			  			}
			  			else
			  				dialog.error('超时取消时间必须大于当前时间');
			  		}
			  		else
			  			dialog.error('平均周期的结束时间必须大于开始时间');
		  		}
		  		else
		  			dialog.error('平均周期的开始时间必须大于当前时间');
		  	}
		  	else
		  		dialog.error('请设置平均周期');
		  }); 
		  
		  
		  //表单初始赋值
		  <?php
		  	$other_price = $other_price == 0 ? 0 : explode('^', $other_price);
		  ?>
		  form.val('republish_fm', {
		    "intlet": <?=$intlet;?>,
		    "keyword": '<?=$keyword;?>',
		    "number": <?=$number;?>,
		    "price": <?=$price;?>, //复选框选中状态
		    "auction": <?=$auction;?>, //开关状态
		    "express": <?=$express;?>,
		    "gettime": '<?=$gettime;?>',
		    'close': '<?=$close;?>',
		    'top': '<?=$top;?>',
		    'remark': '<?=$remark;?>',
		    'new_keyword': '<?=$new_keyword;?>',
		    'how_search': '<?=$how_search;?>',
		    'how_browse': '<?=$how_browse;?>',
		    'order': '<?=$order;?>',
		    'sendaddress': '<?=$sendaddress ? $sendaddress : '';?>',
		    'other': '<?=$other ? $other : '';?>',
		    <?php if($other_price != 0):?>
			    'price_min': <?=$other_price[0]?>,
			    'price_max': <?=$other_price[1]?>,
		    <?php endif;?>
		  })
		});
		
		
		function sortNumber(a, b)
	    {
	        return  b-a
	    }
		
		/*
		 * 获得商家任务佣金
		 */
	    function GetPricePoint(price)
	    {  
	        var point=0;
	
	        var priceinfo = '<?=$commission_gards -> value;?>';
	        var pricearr = priceinfo.split("|");
	
	        arrprice =new Array();
	        arrpoint =new Array();
	        var obj = new Array();
	        for(i=0;i<pricearr.length;i++){
	            strmenoy = '';    
	            arrprice[i]=pricearr[i].substring(0,pricearr[i].indexOf('='));
	            obj[pricearr[i].substring(pricearr[i].indexOf('=')+1)]=pricearr[i].substring(0,pricearr[i].indexOf('='));
	        }
	        arrprice=arrprice.sort(sortNumber);
	        var newobj= new Array; var ii=0;
	      	for(m=0;m<arrprice.length;m++){
	      	    for(variable in obj){
	      	    	if(obj[variable] == arrprice[m]){
	      	           arrpoint[ii++]=variable;  
	      	    	}        	
	            }	 
	    	}
	        for(k=0;k<arrprice.length;k++){ 
	           if(price < arrprice[k]){
	              point=arrpoint[k];
	           }   
	           //alert(arrpoint[k]);  
	        }      
	        if(price >= arrprice[0]){
	        	point=arrpoint[0];
	        }
	        if(price < arrprice[arrprice.length-1]){
	        	point=arrpoint[arrprice.length-1];
	        }       
	
	        return point;
	    }
	    
	    /*
	     * 清除非数字的输入
	     */
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
		    obj.value = obj.value.replace(/\b(0+)/gi, "");
		    if (!obj.value)
		    {
		    	obj.value = obj.name == 'express' ? 0 : 1;
		    }
		}
	    
	    /*
		 * 价格计算
		 */
		function price_compute($price, $express, $auction, $number)
		{
			var $commission_one = GetPricePoint($price * $auction),
				$one_money = $price * $auction + $express;
			$('span#commission_one').html($commission_one);
			$('span#commission_all').html($commission_one * $number);
			$('span#one_money').html($one_money);
			$('span#sum_money').html($one_money * $number);
			$('span#total').html($one_money * $number + $commission_one * $number);
		}
	</script>
</body></html>