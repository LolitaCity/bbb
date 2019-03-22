<?php require_once('include/header.php')?>  
    <script language="javascript" type="text/javascript">
     $(document).ready(function () {
            $("#NewMember").addClass("#NewMember");
              $('.switch').click(function(){
              if($(this).hasClass("switchOn"))
              {
                  $(this).next("label").text("已关闭").css("color","Gray");
           
              }
              else{
                    $(this).next("label").text("已开启").css("color","Blue");
              }
              var id=$(this).attr("id");
              var type=$(this).attr("temp");
              /* if(type=="tb")
              {
               OpenTbGuest(id);
              }
              if(type=="ct")
              {
               OpenVillage(id);
              } */
              $(this).toggleClass("switchOn");
             });
        }) 
        
        /*
         * 授权
         */
        function authorization($shopid, $userid, $state)
        {
        	if ($state == 'init')
        	{
        		var $comment = '您是否已经在服务市场购买API版本的淘宝服务?<br/>（必须为API版!!!!否则任务无法被完成）',
        			$btn1 = '重新购买',
        			$btn2 = '重新授权';
        	}
        	else
        	{
        		var $comment = '您是否需要续费或是购买API版本?<br/>（必须为API版!!!!否则任务无法被完成）',
        			$btn1 = '重新购买',
        			$btn2 = '已重购，重新授权';
        	}
        	dialog.confirm($comment, $btn1, $btn2, function(){  //去授权
        		window.open('https://fuwu.taobao.com/ser/detail.htm?service_code=FW_GOODS-1842802&tracelog=sp');
        	}, function(){  //授权
        		window.open('http://tongbu.et22.com/home/bind/8015?uid=' + $userid + '&sid=' + $shopid);
        		dialog.confirm('是否授权成功?', '授权成功', '授权遇到问题', function(){
        			location.reload();
        		}, function(){
        			window.open('http://wpa.qq.com/msgrd?v=3&uin=800185208&site=在线客服&menu=yes');
        		});
        	});
        }
		
		/*
         * 清空授权信息
         */
        function clearAuth($shopid)
        {
        	dialog.confirm('确认清除该店铺的授权信息吗?', '清除', '不了', function(){
    			public.ajax('/member/clearAuth', {sid: $shopid}, function(datas){
    				public.ajaxSuccess(datas, function(){
    					location.reload();
    				});
    			});
    		});
        }
    </script>

<body style="background: #fff;">
    <?php require_once('include/nav.php')?>
    <div class="sk-hygl_2" style="height: auto; margin-top: 2%; float: right; z-index: 999; position: absolute; right: 0px; margin-right: 1%; display: none;">
        <div class="sk-hygl_5 sk-hygl_6" style="height: auto; padding: 15px">
        	<h3 style="text-align: center;">订购须知</h3>
            <p>1.必须订购 <strong style="color: red;">API</strong> 版本;</p>
            <p>2.授权必须用  <strong style="color: red;">主账号</strong> 登陆；</p>
            <p>3.登陆授权店铺必须与平台绑定的店铺一致；</p>
        </div>
    </div>
    <div class="sj-zjgl">
        <?php require_once('include/member_menu.php')?>    		
	</div>
    <div class="zjgl-right">
<style>
    .infobox
    {
        background-color: #fff9d7;
        border: 1px solid #e2c822;
        color: #333333;
        padding: 5px;
        padding-left: 30px;
        font-size: 13px;
        --font-weight: bold;
        margin: 0 auto;
        margin-top: 10px;
        margin-bottom: 10px;
        width: 85%;
        text-align: left;
    }
    .errorbox
    {
        background-color: #ffebe8;
        border: 1px solid #dd3c10;
        margin: 0 auto;
        margin-top: 10px;
        margin-bottom: 10px;
        color: #333333;
        padding: 5px;
        padding-left: 30px;
        font-size: 13px;
        --font-weight: bold;
        width: 85%;
    }
</style>
        <div class="sk-hygl">
        	<br />
            <h2 class="fprw-pt"> 已审核通过店铺信息</h2>
            <div class="zjgl-right_2 overfloat-n ">
                <table>
                    <thead><tr>
                        <th style="width: 20%">所属平台</th>
                        <th style="width: 20%">店铺名称</th>
                        <th style="width: 20%">小助手状态</th>
                        <th style="width: 20%">服务接口有效期</th>
                        <th style="width: 20%">操作按钮</th>
                    </tr>
                    </thead>
                    <tbody id="shop_tbody">
                  	
                        <?php foreach($list as $v):?>
                        <tr id="shop_<?=$v->sid?>" class="shop_tr">
                        	<td class="shop_nature"><?=$v->type=='0'?'淘宝':'京东'?></td>
                            <td class="shop_name"><?=$v->shopname?></td>
                            <td class="order_state" style="<?=$v->api_expiration_time >= time() ? 'color:green':($v->auditing=='0'?'color:blue':'color:red')?>">
                            	<?php
                        		$now = time();
                        		$has_auth = false;
                        		if (empty($v->api_expiration_time))
                        		{
                        			echo '未订购  ' . '(<a href="/member/detailnotice/' . (PLATFORM == 'esx' ? 274 : 277) . '.html" target="_blank">查看开通教程</a>)';
                        		}
                        		elseif($v->api_expiration_time >= $now)
                        		{
                        			$has_auth = true;
                        			echo '已授权';
                        		}
                        		else
                        		{
                        			echo '已过期';
                        		}
                            	?>
                            </td>
                            <td style="<?=$v->status=='1'?'color:green':'color:red'?>">
                            	<?=empty($v -> api_expiration_time) ? '' : date('Y-m-d H:i:s', $v -> api_expiration_time);?><br />
                            </td>
                            <td>
                            	<?php if($has_auth):?>
                            		<input class="button-c" type="button" value="重新授权" onclick="authorization(<?=$v -> sid?>, '<?=PLATFORM?>', 'anew');"></div>
                        		<?php else:?>
                        			<input class="button-c" type="button" value="授权" onclick="authorization(<?=$v -> sid?>, '<?=PLATFORM?>', 'init')"></div>
                    			<?php endif;?>
                            	<?php if ($has_auth):?>
                        			<input class="button-c" type="button" value="插旗" onclick="dialog.iframe('/member/orderRemarkView?sid=<?=$v -> sid?>', 800, 480, '订单备注设置')"></div>
									<input class="button-c" type="button" value="清空授权" onclick="clearAuth(<?=$v -> sid;?>)"></div>
                    			<?php endif;?>
                            </td>
                            <!-- 
                            <td style="text-align: center">
                                 <div class="switch display_block" temp="tb">
                                      <div class="dis_black_blue"><em></em>平台将为你避开疑似淘宝客买手</div>
                                      <div class="dis_black_gray"><em></em>过滤功能已关闭！</div>
                                 </div>
                                <label style="color:Gray">已关闭</label>
                            </td>
                            <td style="text-align: center">
                                  <div class="switch display_block"  temp="ct">
                                        <div class="dis_black_blue"><em></em>平台将为你避开疑似农村淘宝买手</div>
                                        <div class="dis_black_gray"><em></em>过滤功能已关闭！</div>
                                   </div>
                                  <label style="color:Gray">已关闭</label>
                            </td>
                             -->
                        </tr>
                        <?php endforeach?>
                	</tbody>
                </table>
            </div>
            <div class="sk-hygl_5 sk-hygl_6" style="height: auto; padding: 0">
	        	<h3>订购须知</h3>
	            <p>1.必须订购 <strong style="color: red;">API</strong> 版本;</p>
	            <p>2.授权必须用  <strong style="color: red;">主账号</strong> 登陆；</p>
	            <p>3.登陆授权店铺必须与平台绑定的店铺一致；</p>
				<p>4.注：订购错了会导致买手提交不了订单，后果自负，如有不懂，联系客服;</p>
	        </div>
	        <div>
	        	----------------------------------------------------------------------------------------------------------------------------------------------------------------
	        </div>
            <h2 class="fprw-pt">订单标记失败反馈</h2>
            <div class="zjgl-right_2 overfloat-n ">
                <table>
                    <thead><tr>
                        <th style="width: 30%">订单编号</th>
                        <th style="width: 20%">店铺名称</th>
                        <th style="width: 20%">买号</th>
                        <th style="width: 10%">标记状态</th>
                        <th style="width: 20%">下单支付时间</th>
                    </tr>
                    </thead>
                    <tbody id="shop_tbody">
                  	
                        <?php foreach($mark_lose as $v):?>
                        <tr id="shop_<?=$v->id?>" class="shop_tr">
                        	<td class="shop_nature"><?=$v->ordersn;?></td>
                            <td class="shop_name"><?=$v->shopname?></td>
                            <td><?=$v -> wangwang?></td>
                            <td style="color: red">失败</td>
                            <td><?=$v->updatetime;?></td>
                        </tr>
                        <?php endforeach?>
                	</tbody>
                </table>
            </div>
 <script type="text/javascript">

        /**验证页码*/
        function validationPageIndex(t, maxCount) {
            ifPageSize(maxCount);
        }

        /**跳转到指定页*/
        function redirectPage(url, maxCount) {
            url = url.replace('.html','');
            var pageIndex = $("#PageIndex").val();
            if (ifPageSize(maxCount))
                window.location = url + "?page=" + (pageIndex - 1);
        }

        /*下一页*/
        function nextPage(url, pageIndex, maxCount) {
            if (parseInt(pageIndex) >= parseInt(maxCount)) {
                $.openAlter("没有了", "提示", { height: 210, width: 350 });
                return;
            }
            window.location = url + "?page=" + (parseInt(pageIndex) + parseInt(1));
        }

        /*上一页*/
        function prePage(url, pageIndex, maxCount) {
            if (pageIndex <= 0) {
                $.openAlter("没有了", "提示", { height: 210, width: 350 });
                return;
            }
            window.location = url + "?page=" + (pageIndex - 1);
        }

        function ifPageSize(maxCount) {

            var pageIndex = $("#PageIndex").val();
            if (pageIndex == '' || isNaN(pageIndex) || parseInt(pageIndex) < 1) {
                $.openAlter("请正确输入页码", "提示", { height: 210, width: 350 });
                return false;
            }
            if (parseInt(pageIndex) > maxCount) {
                $.openAlter("输入的页码不能大于总页码", "提示", { height: 210, width: 350 });
                return false;
            }
            return true;
        }

        function submitPage(event, maxCount) {
            var pageIndex = $("#PageIndex").val();
            if (pageIndex == '' || isNaN(pageIndex) || parseInt(pageIndex) < 1) {
                return false;
            }
            if (parseInt(pageIndex) > maxCount) {
                return false;
            }
            var e = event || window.event || arguments.callee.caller.arguments[0];
            if (e && e.keyCode == 13) { // enter 键
                //要做的事情
                $("#paRedirect").click();
            }
        }
    </script>
    <!--<div class="yyzx_1">
        <p class="yyzx_2">
            <a href="javascript:" onclick="prePage('<?=site_url('member/store')?>','<?=$page?>','<?=ceil($count/10)?>')"></a>
        </p>
        <p style="margin-left: 5px; margin-right: 5px;"><?=$page+1?>/<?=ceil($count/10)?></p>
        <p class="yyzx_3">
            <a href="javascript:" onclick="nextPage('<?=site_url('member/store')?>','<?=$page?>','<?=ceil($count/10)-1?>')"></a>
        </p>
        <p style="margin-left: 12px; margin-right: 8px;">
            <input type="text" name="PageIndex" class="input_58" id="PageIndex" value="1" onkeyup="value=value.replace(/[^0-9]/g,'');submitPage(event,'<?=ceil($count/10)?>')" maxlength="9">
        </p>
        <p class="ymfw-right-zgj_7">
            <a href="javascript:" id="paRedirect" onclick="redirectPage('<?=site_url('member/store')?>','<?=ceil($count/10)?>')">
                跳转</a></p>
    </div>-->
        </div>
    </div>

    </div>
    <!-- 删除弹窗确认 -->
    <div id="btn_delete" class="tip">
        <div class="tiptop"><span>删除内容</span><a></a></div>        
	    <div class="tipinfo">
		    <div class="tipright">
		      <p>确认删除选中数据？<br />
		              删除以后将无法恢复！请谨慎操作。</p>      
		    </div>
	    </div>        
	    <div class="tipbtn">
		    <input name="" type="button"  class="sure" value="确定"/>&nbsp;
		    <input name="" type="button"  class="cancel" value="取消" />
	    </div>    
    </div>
<script> 
	
	/*
	 * 删除商铺
	 */
    function delShop($id, $this)
    {
    	dialog.confirm('确定删除所选店铺, 删除之后对应历史数据将显示不全', '确认删除', '退出', function(){
    		public.ajax('<?=site_url('member/delShop')?>', {id: $id}, function(datas){
    			if(datas.status)
    			{
    				dialog.success(datas.message);
    				$($this).parents('.shop_tr').remove();
    				var $shop_count = $('span#shop_count');
    				$shop_count.html($shop_count.html() - 1);
    			}
    			else
    			{
    				dialog.error(datas.message);
    			}
    		});
    	});
//  	$("#btn_delete").fadeIn(180);
//  	$(".sure").attr('data_info',id);
    }
        
$(document).ready(function(){ 
	  $(".tiptop a").click(function(){
	      $(".tip").fadeOut(180);
	  });
	  $(".cancel").click(function(){
	      $(".tip").fadeOut(180);
	  });
	  $(".sure").click(function(){
		  var id=$(this).attr('data_info');	  
		  //alert(id);
	      window.location.href="<?=site_url('member/delShop')?>"+"?id="+id;
	  });

	});
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


</body></html>