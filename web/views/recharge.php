    <?php require_once('include/header.php')?>  
    <style type="text/css">
    	.input_120 {
		    width: 120px;
		    border: 1px solid #C6C6C6;
		}
		
		.getallbtn {
		    background: #4782EF;
		    color: #FFF;
		    padding: 10px 15px;
		    display: inline-block;
		}
		
		.getallbtn:hover
		{
			color: red;
		}
    </style>
    <link type="text/css" rel="stylesheet" href="<?=base_url()?>style/laydate.css">
    <script language="javascript">
        $(document).ready(function () {
              $("#ShopPay").addClass("#ShopPay");
            if ($("#serviceValidation").length > 0) {
                $.openAlter($("#serviceValidation").html(), "提示", { width: 250, height: 50 });
            }

            var alipayNick = "霆宇";
            if(alipayNick!=""&&alipayNick!=null)
            {
                $("#txtAlipayNick").attr("disabled",true);
                $("#btnBind").hide();
                $("#btnEdit").show();
                $("#btnSave").hide();
            }
            else
            {
                $("#btnBind").show();
                $("#btnEdit").hide();
                $("#btnSave").hide();
            }
        });

        function BindAlipayNick()
        {
            var value=$.trim($("#txtAlipayNick").val());
            if(value==""||value==null)
            {
                $.openAlter("支付宝昵称请输入", "提示");
                return;
            }
            $.ajax({
                type: "post",
                url: "BindAlipayNick",
                dataType: "text",
                data: { nick: value },
                error: function (XmlHttpRequest, textStatus, errorThrown) {
                    var $errorPage = XmlHttpRequest.responseText;
                    $.openAlter($errorPage, "提示");
                },
                success: function (data) {
                    data = eval("(" + data + ")");
                    if (data.StatusCode == "301") {
    $.openAlter('会话超时,请重新登录！', '提示', { width: 250,height: 50 },function () { location.href = "";},"确定");   
                    }
                    else if(data.StatusCode == "200")
                    {
                        $.openAlter(data.Message, "提示",{ width: 250,height: 50 },function () { window.location.reload()},"确定");
                    }
                    else
                    {
                        $.openAlter(data.Message, "提示");
                    }
                }
            });
        }

        function EditAlipayNick()
        {
            $("#txtAlipayNick").attr("disabled",false);
            $("#btnBind").hide();
            $("#btnEdit").hide();
            $("#btnSave").show();
        }
        function PayFor(){
        $.openWin(735, 850, '/Shop/InCome/PayFor');
        }
    </script>


</head>
<body style="background: #fff;">
    <?php require_once('include/nav.php')?>  
    <!--daohang-->
    
    <div class="sj-zjgl">
        <div class="zjgl-left">
            <h2 style="background: url(<?=base_url()?>style/images/hygl.png) no-repeat 22px 22px;">资金管理</h2>
            <ul>
                <li><a href="<?=site_url('capital')?>" style="background: #eee;color: #ff9900;" >账号充值</a> </li>
                <li><a href="<?=site_url('capital/wait')?>" >转账管理</a> </li>
                <li><a href="<?=site_url('capital/fund')?>">资金管理</a> </li>
                <li><a href="<?=site_url('capital/order')?>">订单信息</a> </li>
            </ul>
        </div>
        
    <div class="zjgl-right">
        
        <div style="display: none;">

        </div>
        <div class="errorbox" id="clientValidation" style="display: none">
            <ol style="list-style-type: decimal" id="clientValidationOL">
            </ol>
        </div>
        <div class="sk-hygl" style="margin-left: 20px;">
			<?php if(true):?>
        	<a class="getallbtn" href="javascript:;" onclick="seeCourse()">查看充值教程</a>    
            <div class="yctc_458 ycgl_tc_1" style="width: 1100px; ">
                <ul>
                    <li>
                        <p class="sk-zjgl_4"> 帐号余额：</p>
                        <p style="line-height: 35px;">
                            <label style="font-size: 18px;"><?=$info->Money?></label>元</p>
                    </li>
                    <li>
                    	<p class="sk-zjgl_4"> 充值方式：</p>
                    	<p style="line-height: 35px; color: red;">请务必使用支付宝进行转账</p>
                    </li>
                    <li>
                    	<p class="sk-zjgl_4"> 收款支付宝：</p>
                    	<p style="line-height: 35px; color: red;"><?=ZFB_NUM?></p>
                    </li>
                    <li>
                    	<p class="sk-zjgl_4"> 收款方昵称：</p>
                    	<p style="line-height: 35px; color: red;"><?=ZFB_NICKNAME?></p>
                    </li>
                    <li>
                    	<p class="sk-zjgl_4"> 付款方昵称：</p>
                    	<p style="line-height: 35px; color: red;">
                    		<input style="height: 30px!important;" class="input_120 right_15" id="recharge_nickname" name="recharge_nickname" type="text" value="">
                			&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" onclick="saveNickname()" class="b_4882f0 anniu" style="display: inline-block!important;">保存修改</a>
                    	</p>
                    </li>
                    <li>
                    	<p class="sk-zjgl_4"> 充值金额：</p>
                    	<p style="line-height: 35px;">
                    		<input style="height: 30px!important;" class="input_120 right_15" id="recharge_money" name="recharge_money" type="text" onkeyup="value=value.replace(/[^\d]/g,'') "onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))">
                    		&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" onclick="createRechargeID()" class="b_4882f0 anniu" style="display: inline-block!important;">生成充值码</a>
                    	</p>
                    </li> 
                </ul>
                <br />
                <div id="id_table"></div>
                <br />
                <!--充值码列表-->
				<form action="" enctype="multipart/form-data" id="fm" method="get">   
					<div class="sk-hygl">
		                <div class="fpgl-ss">
		                    <p>
		                        生成时间：<input class="laydate-icon" id="BeginDate" maxlength="16" name="BeginDate" onclick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm'})" style="width:150px;height:34px;margin-left:5px; border:1px solid #C6C6C6;" type="text" value="<?=!empty($begintime)?@date('Y-m-d H:i:s',$begintime):'';?>">
		                        ~
		                        <input class="laydate-icon" id="EndDate" maxlength="16" name="EndDate" onclick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm'})" style="width:150px;height:34px; border:1px solid #C6C6C6;" type="text" value="<?=!empty($endtime)?@date('Y-m-d H:i:s',$endtime):'';?>">
		                    </p>
		                    <p id="loading2">
		                        <input class="input-butto100-ls" type="submit" id="btnSearch" value="查询" onclick="Search()" style="width: 60px;">
	                        </p>
		               </div>
		               <br />
		               <strong style="color: red;">* 未正确备注充值码、平台填写金额与实际充值金额不一致均无法自动到账</strong><br/>
					   <strong style="color: red;">*为了保障自动充值的稳定性，现最晚到账时间延迟至两分钟</strong>
		                <div class="zjgl-right_2">
		                	
		                    <table style="width: 88%;">
		                        <tbody>
		                        <tr>
		                            <th>充值码</th>
		                            <th>预充值金额</th>
		                            <th>支付宝交易号</th>
		                            <th>充值码生成时间</th>
		                            <th>自动充值到账时间</th>
		                        </tr>
		                        <?php if(count($list)==0):?>
		                            <tr>
		                                <td colspan="7" align="center"> 暂无数据</td>
		                            </tr>
		                        <?php else:?>
		                            <?php foreach($list as $vl):?>
		                            	<tr class="info_tr">
                                            <td  align="center">
                                                <span><?=$vl->id?></span>
                                            </td>
                                            <td  align="center">
                                                <span><?=$vl->payment_Money?></span>
                                            </td>
                                            <td  align="center">
                                                <span><?=!empty($vl->tradeNo) ? $vl->tradeNo : '暂无数据';?></span>
                                            </td>
                                            <td  align="center">
                                                <span><?=date('Y-m-d H:i:s', $vl ->addtime);?></span>
                                            </td>
                                            <td  align="center">
                                                <span><?=!empty($vl -> recharge_time) ? date('Y-m-d H:i:s', $vl ->recharge_time) : '暂无数据';?></span>
                                            </td>
                                       </tr>
		                            <?php endforeach;?> 
		                        <?php endif;?>                         
		                        </tbody>
		                    </table>
		                </div>
	                </div>
				</form>
				<div style="margin-right: 9%;">
					<?php require_once('include/page.php')?> 
				</div>
                <!--充值教程-->
                <div id="course" style="padding: 5%; display: none;">
                	<p>【支付宝昵称设置说明】</p>
                	<p>1、只有支付宝APP端才能查看和设置支付宝昵称；</p>
                	<p>2、前往【支付宝APP--我的--查看个人主页--添加个人资料--昵称】处进行设置/查看。</p>
                	<p>3、务必正确设置支付宝昵称后再进行充值，否则不会自动到账，设置查看请参考以下示例图：</p>
                	<br />
                	<p>
                		<img src="<?=base_url()?>style/images/recharge/recharge_1.png" alt="" width="25%"/>
                		<img src="<?=base_url()?>style/images/recharge/recharge_2.png" alt="" width="25%"/>
                	</p>
                	<br />
                	<p>
                		【充值流程】
                	</p>
                	<p>第一步：平台上操作</p>
                	<br />
                	<p>1：输入支付宝昵称；（平台操作）</p>
                	<p>2：输入充值金额；充值金额必须是500元的整数倍，否则无法充值到账（平台操作）</p>
                	<p>3：点击生成充值码，如下：（平台自动生成6位数充值码）；</p>
                	<p>
                		<img src="<?=base_url()?>style/images/recharge/recharge_3.png" alt="" width="80%"/>
                	</p>
                	<br />
                	<p>第二步：支付宝APP操作转账</p>
                	<br />
                	<p>1：按以下示例图做第一步到第三步流程操作；</p>
                	<p>2：第四步在支付宝中输入充值金额和平台充值码(6位数字)，支付成功30秒内自动充值到账。</p>
                	<p><strong style="color: red;">特别提醒:</strong> 转账备注务必正确填写，否则无法自动充值到账。如果备注填写错误或者忘记填写，请联系平台管理员手动充值，联系QQ：800185208 。支付宝转账步骤示例图：</p>
                	<p>支付宝转账步骤示例图：</p>
                	<br />
                	<p>
                		<img src="<?=base_url()?>style/images/recharge/recharge_4.png" alt="" width="25%"/>
                		<img src="<?=base_url()?>style/images/recharge/recharge_5.png" alt="" width="25%"/>
                		<img src="<?=base_url()?>style/images/recharge/recharge_6.png" alt="" width="25%"/>
                		<img src="<?=base_url()?>style/images/recharge/recharge_7.png" alt="" width="25%"/>
                	</p>
                </div>
				<?php else:?>
				<br>
				<br>
                <!--<?php echo $newinfo->goods_desc;?>-->
				<?php endif;?>
                <br>
            </div>
        </div>
    </div>
<script src="<?=base_url()?>style/laydate.js" type="text/javascript"></script>
<script language="javascript" type="text/javascript">

/*
 * 查看教程
 */
function seeCourse()
{
	layer.open({
	  type: 1,
	  shade: 0.5,
	  title: '充值教程',
	  area: ['90%', '90%'],
	  content: $('#course'),
	});
}

function saveNickname()
{
	localStorage.setItem('recharge_nickname_<?=$info -> id;?>', $('#recharge_nickname').val());
	dialog.success('保存付款方昵称成功');
}

$(function(){
	if (localStorage.getItem('recharge_nickname_<?=$info -> id;?>'))
	{
		$('#recharge_nickname').val(localStorage.getItem('recharge_nickname_<?=$info -> id;?>'));
	}
    if(screen.width<1440){  
         var height = document.body.clientHeight; 
         $("#onlineService").css("margin-top", "300px"); 
         $("#online_qq_tab").css("margin-top","300px"); 
    // 拖拉事件计算foot div高度  
    $(window).scroll(function () {  
        var scrollDiff = document.body.scrollTop //  拖拉处的位移  
        $("#onlineService").css("margin-top", "300px"); 
         $("#online_qq_tab").css("margin-top","300px"); // 重计算底部位置  
    });  
}else if(screen.width == 1024){
         $("#onlineService").css("margin-top", "260px"); 
         $("#online_qq_tab").css("margin-top","260px");

            $(window).scroll(function () {  
        var scrollDiff = document.body.scrollTop //  拖拉处的位移  
        $("#onlineService").css("margin-top", "260px"); 
         $("#online_qq_tab").css("margin-top","260px"); // 重计算底部位置  
    });  
 } else {
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

/*
 * 生成充值码
 */
function createRechargeID()
{
	var $post = {
		recharge_nickname: $('input[name=recharge_nickname]').val().trim(),
		recharge_money: $('input[name=recharge_money]').val().trim(),
	};
	if($post.recharge_money == '' || $post.recharge_nickname == '')
	{
		return dialog.error('付款方支付宝昵称或充值金额不能为空');
	}
	if(isNaN($post.recharge_money))
	{
		return dialog.error('充值金额必须为纯数字');
	}
	public.ajax('/capital/createRechargeID', $post, function(datas){
		public.ajaxSuccess(datas, function(){
			$table = '<br/><table style="width: 100%;"><tbody><tr><th>充值码</th><th>付款方支付宝昵称</th><th>充值金额</th><th>收款方支付宝昵称</th><th>收款方支付宝账号</th><th>生成时间</th></tr><tr><td align="center"><div style="word-break: break-all;"><span style="color: Red;">' + datas.data.ID + '</span></div></td><td align="center">' + datas.data.payment_nickname + '</td><td align="center"><div style="width: 70px; word-break: break-all;">' + datas.data.payment_Money + '</div></td><td align="center"><div style="width: 70px; word-break: break-all;">' + datas.data.receipt_nickname + '</div></td><td align="center"><div style="width: 100px; word-break: break-all;">' + datas.data.receipt_account + '</div></td></tr></tbody></table>';
			$('#id_table').html($table);
		})
	});
}

</script>
<?php require_once('include/footer.php')?>   
</body>
</html>