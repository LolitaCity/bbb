<!--[if lt IE 8]>

<script language="javascript" type="text/javascript">
$.openAlter('<div style="font-size:18px;text-align:left;line-height:30px;">hi,你当前的浏览器版本过低，可能存在安全风险，建议升级浏览器：<div><div style="margin-top:10px;color:red;font-weight:800;">谷歌Chrome&nbsp;&nbsp;,&nbsp;&nbsp;UC浏览器</div>', "提示", { width: 250, height: 50 });
$("#ow_alter002_close").remove();
</script>
<![endif]-->
<style type="text/css">
    #box{width: 100%;height: 40px;background: red;margin:100px auto;line-height: 40px;padding:0 15px;overflow: hidden}
    #box span{color: #fff;font-size: 14px;}
    #box p{color: #fff;font-size: 14px;white-space: nowrap;display: inline-block;}
    .boxCon{width: 3000%;}
</style>
<div class="index_top">
    <div class="index_top_1">

        <!-- 头部 -->

        <p class="left">
        <a href="/user.html"><img src="<?=base_url()?>style/images/logo.png"></a>
        </p>
        <div class="kaiguan">
        <div id="sxyc" class="<?php if($info->ShowStatus):?>add<?php else:?>add1<?php endif;?>">
        <div class="cssPrompt">
        <em></em>亲，您当前处于隐身状态，所发布的销量任务全部被系统隐藏，买手无法接手！
        </div>
        <div class="cssPrompt1">
        <em></em>亲，您当前处于在线状态，所发布的销量任务能正常被买手接手。 
        </div>
        </div>
        <?php if($info->ShowStatus):?>
            <div id="Open_x1" class="open1" onclick="hideshow(<?=$info->ShowStatus?>, this)">
                <div id="No_x1" class="open2">
                </div>
            </div>
        <?php else:?>
            <div id="Open_x1" class="close1" onclick="hideshow(<?=$info->ShowStatus?>, this)">
                <div id="No_x1" class="close2">
                </div>
            </div>
        <?php endif;?>
                <span class="csshuiyuan"><a href="<?=site_url('user')?>"><b><?=$info->Username?></b></a><a id="aOut" href="<?=site_url('welcome/loginout')?>" >退出</a></span>
            </div>
            <marquee id="mqs" direction="Left" scrollamount="4">
                <span style="color:Red" id="sp"> </span><span style="color:White"><a id="title" style="color:White"></a> </span>
            </marquee>
            <!-- 头部 -->

            </div>
        </div>
        <script>
            var flag = "<?=$info->ShowStatus?>";
            function hideshow($status, $this){
                var div2 = document.getElementById("No_x1"),
                	div1 = document.getElementById("Open_x1"),
                	$msg = $status ? '是否将状态改为【显示】，修改之后您所发布的销量任务将会正常被接手' : '是否将状态改为【隐藏】，修改之后您所发布的销量任务将全部被系统隐藏，无法被接手';
                dialog.confirm($msg, '确定修改', '取消 ', function(){
                	public.ajax('<?=site_url('user/changeStatus')?>', '', function(datas){
                		if(datas.status)
                		{
                			dialog.success(datas.message);
                			div1.className = $status ? "close1" : 'open1';
                            div2.className = $status ? "close2" : 'open2';
                			$("#sxyc").toggleClass('add1');
                            $("#sxyc").toggleClass('add');
                            $($this).attr('onclick', 'hideshow(' + !$status + ', this)');
                		}
                		else
                		{
                			dialog.error(datas.message);
                		}
                	});
                });
//              $.ajax({
//                  type: "post",
//                  url: "<?=site_url('user/changeStatus')?>",
//                  data: { pid: flag },
//                  error: function(request){
//                     alert('系统出错了！');
//                  },
//                  success: function (data) {
//                      //alert(data);
//                      var json = eval("("+data+")");
//                      if(json.status){
//                          if(json.staticinfo==1){ 
//                              $.openAlter("亲，您当前处于“隐身”状态。您所发布的销量任务将<span style='color:red'>全部被系统隐藏</span>，买手将<span style='color:red'>无法接手您发布的任务</span>。", '提示', { width: 250, height: 50 }, null, "好的");
//                              div1.className = "open1";
//                              div2.className = "open2";
//                              $("#sxyc").removeClass("add1");
//                              $("#sxyc").addClass("add");
//                              //location.reload();
//                          }else{ 
//                              $.openAlter('亲，您当前处于“在线”状态，您所发布的销量任务将会正常被接手。', '提示', { width: 250, height: 50 }, null, "好的");
//                              div1.className = "close1";
//                              div2.className = "close2";
//                              $("#sxyc").removeClass("add");
//                              $("#sxyc").addClass("add1");
//                              //location.reload();
//                          }
//                      }else{
//                          $.openAlter(json.info, '提示', { width: 250, height: 50 }, null, "好的");
//                      }
//                  }
//              });
            }

        </script>
            <!--daohang-->
<div class="cpcenter">
    <div class="lside container">
        <ul class="cpmenulist">
            <li><a href="<?=site_url('user')?>" class="ShopIndex">首页</a></li>
            <li><a>销量任务管理</a><em></em>
                <ul>
                    <li><a href="javascript:;" onclick="dialog.iframe('/sales/infoshow', 1100, 350, '任务类型选择')">发布任务</a></li>
                    <li><a href="<?=site_url('sales/taskno')?>">未接任务</a></li>
                    <li><a href="<?=site_url('sales/taskyes')?>">已接任务</a></li>
                    <li><a href="<?=site_url('sales/evaluation')?>">评价管理</a></li>
                    <li><a href="<?=site_url('sales/invalidTask')?>">无效任务</a></li>
                </ul>
            </li><!--
            <li><a>日常任务管理</a><em></em>
                <ul>
                    <li><a href="<?=site_url('daily')?>">发布任务</a></li>
                    <li><a href="<?=site_url('daily/task')?>">发布管理</a></li>
                </ul>
            </li>
            <li><a>淘宝APP点击</a><em></em>
                <ul>
                    <li><a href="<?=site_url('clickapp')?>">发布流量任务</a></li>
                    <li><a href="<?=site_url('clickapp/task')?>">流量任务管理</a></li>
                </ul>
           </li> -->
           <li><a>资金管理</a><em></em>
                <ul>
                     <li><a href="<?=site_url('capital')?>">账号充值</a></li>
                     <li><a href="<?=site_url('capital/wait')?>">转账管理</a></li>
                    <!-- <li><a href="<?=site_url('capital/change')?>">发布点兑换</a></li> --> 
                     <li><a href="<?=site_url('capital/fund')?>">资金管理</a></li>
                     <li><a href="<?=site_url('capital/order')?>">订单信息</a></li>
                </ul>
            </li>
            <li><a>会员中心</a><em></em>
                <ul>
                    <li><a href="<?=site_url('member')?>">基本资料</a></li>
                    <!-- <li><a href="<?=site_url('member/intelligence')?>">智能助手</a></li> -->
                    <li><a href="<?=site_url('member/store')?>">店铺管理</a></li>
                    <li><a href="<?=site_url('member/product')?>">商品管理</a></li>
                    <li><a href="<?=site_url('member/notices')?>">平台公告</a></li>
                    <li><a href="<?=site_url('member/edit')?>">调整单量</a>
                    </li>
                 </ul>
             </li>
             <?php if($info->ispromoter):?>
             	<li><a href="<?=site_url('/member/join')?>">推荐赚佣金</a></li>
             <?php endif;?>
             <li><a href="<?=site_url('customer')?>">客服工单</a></li>
             <?php if($use_helper -> value || true):?>
            	<li><a href="<?=site_url('member/smartSettings')?>" class="ShopIndex"><?=$this -> platform == '二师兄' ? '智能助手' : '小助手';?></a></li>
            <?php endif;?>
          </ul>
     </div>
 <?php if($this -> platform == '二师兄' && 1):?>
     <div id="box">
		    <div class="boxCon">
		    	<!--<p id="begin"><strong style="color: mediumblue; size: 20px;">通知：</strong>由于双十一即将来临数据庞大，为了更好的服务于每一位商家， 二师兄特意更换了网站域名，新的登陆网址为：bbb.18zang.com ，老网址自2018-10-21 14：30：00之后将不再使用，请各位商家速速收藏新的网站，其它的内容操作仍然不变！现在是双11前期冲刺阶段，将排名靠前进行到底！</p>&nbsp;&nbsp;&nbsp;&nbsp;
				<p id=""><strong style="color: mediumblue; size: 20px;">通知：</strong>为迎接双十一的到来，满足各商家活动的需求与建议，平台决定各商家的单量可在原有单量的基础上免费加20单，如需加单冲刺的商家，可联系平台客服加单，在此，二师兄全体员工祝大家双十一丰收大吉！！! </p>&nbsp;&nbsp;&nbsp;&nbsp;-->
		    	<!--<p id=""><strong style="color: mediumblue; size: 20px;">【紧急通知】</strong>从<strong style="color: mediumblue; size: 20px;">2018年9月10号</strong>起，未开通智能助手的商家将无法发布任务，<strong style="color: mediumblue; size: 20px;">请及时前往订购服务并绑定至平台</strong></h5>，以免耽误计划</p>&nbsp;&nbsp;&nbsp;&nbsp;
		    	<p id=""><strong style="color: mediumblue; size: 20px;">【紧急通知】</strong>从<strong style="color: mediumblue; size: 20px;">2018年9月10号</strong>起，未开通智能助手的商家将无法发布任务，<strong style="color: mediumblue; size: 20px;">请及时前往订购服务并绑定至平台</strong></h5>，以免耽误计划</p>&nbsp;&nbsp;&nbsp;&nbsp;-->
		    </div>
	 </div>
<script>
    var box = document.getElementById("box");
    var begin = document.getElementById("begin");
    var beginw = getCss(begin,"width");
    var timer = window.setInterval(function(){
        box.scrollLeft++;
        var curLeft = box.scrollLeft;
        if(curLeft >= beginw){
            box.scrollLeft = 0;
        }
    },8);

    //获取元素具体样式方法
    function getCss(curEle,attr){
        var val = null,reg = null;
        if("getComputedStyle" in window){
            val = window.getComputedStyle(curEle,null)[attr];
        }else{
            if(attr === "opacity"){
                val = curEle.currentStyle["filter"];
                reg = /^alpha\(opacity=(\d+(?:\.\d+)?)\)$/i;
                val = reg.test(val)?reg.exec(val)[1]/100:1;
            }else{
                val = curEle.currentStyle[attr];
            }
        }
        reg = /^(-?\d+(\.\d+)?)(px|pt|rem|em)?$/i;
        return reg.test(val)?parseFloat(val):val;
    }
</script>
<?php endif;?>
</div>