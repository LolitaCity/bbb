<!--[if lt IE 8]>

<script language="javascript" type="text/javascript">
$.openAlter('<div style="font-size:18px;text-align:left;line-height:30px;">hi,你当前的浏览器版本过低，可能存在安全风险，建议升级浏览器：<div><div style="margin-top:10px;color:red;font-weight:800;">谷歌Chrome&nbsp;&nbsp;,&nbsp;&nbsp;UC浏览器</div>', "提示", { width: 250, height: 50 });
$("#ow_alter002_close").remove();
</script>
<![endif]-->
<div class="index_top">
    <div class="index_top_1">

        <!-- 头部 -->

        <p class="left">
        <img src="<?=base_url()?>style/images/logo.png"></p>
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
            <div id="Open_x1" class="open1" onclick="hideshow()">
                <div id="No_x1" class="open2">
                </div>
            </div>
        <?php else:?>
            <div id="Open_x1" class="close1" onclick="hideshow()">
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
            function hideshow(){
                var div2 = document.getElementById("No_x1");
                var div1 = document.getElementById("Open_x1");
                $.ajax({
                    type: "post",
                    url: "<?=site_url('user/changeStatus')?>",
                    data: { pid: flag },
                    error: function(request){
                       alert('系统出错了！');
                    },
                    success: function (data) {
                        //alert(data);
                        var json = eval("("+data+")");
                        if(json.status){
                            if(json.staticinfo==1){ 
                                $.openAlter("亲，您当前处于“隐身”状态。您所发布的销量任务将<span style='color:red'>全部被系统隐藏</span>，买手将<span style='color:red'>无法接手您发布的任务</span>。", '提示', { width: 250, height: 50 }, null, "好的");
                                div1.className = "open1";
                                div2.className = "open2";
                                $("#sxyc").removeClass("add1");
                                $("#sxyc").addClass("add");
                                //location.reload();
                            }else{ 
                                $.openAlter('亲，您当前处于“在线”状态，您所发布的销量任务将会正常被接手。', '提示', { width: 250, height: 50 }, null, "好的");
                                div1.className = "close1";
                                div2.className = "close2";
                                $("#sxyc").removeClass("add");
                                $("#sxyc").addClass("add1");
                                //location.reload();
                            }
                        }else{
                            $.openAlter(json.info, '提示', { width: 250, height: 50 }, null, "好的");
                        }
                    }
                });
            }

        </script>
            <!--daohang-->
<div class="cpcenter">
    <div class="lside container">
        <ul class="cpmenulist">
            <li><a href="<?=site_url('user')?>" class="ShopIndex">首页</a></li>
            <li><a>销量任务管理</a><em></em>
                <ul>
                    <li><a href="<?=site_url('sales')?>">发布任务</a></li>
                    <li><a href="<?=site_url('sales/taskno')?>">未接任务</a></li>
                    <li><a href="<?=site_url('sales/taskyes')?>">已接任务</a></li>
                    <li><a href="<?=site_url('sales/evaluation')?>">评价管理</a></li>
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
                    <li><a href="<?=site_url('member/notice')?>">平台公告</a></li>
                    <li><a href="<?=site_url('member/edit')?>">调整单量</a>
                    </li>
                 </ul>
             </li>
             <li><a href="<?=site_url('customer')?>">客服工单</a></li>
          </ul>
     </div>
</div>