<!DOCTYPE html>
<html> 
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title><?=$this -> platform;?></title>
    <script src="<?=base_url()?>style/jquery-1.8.3.js" type="text/javascript"></script>
    <script src="<?=base_url()?>style/jquery.jslides.js" type="text/javascript"></script>
    <script src="<?=base_url()?>style/open.win.js" type="text/javascript"></script>
    <script src="<?=base_url()?>style/jquery.jBox-2.3.min.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>style/jbox.css">
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>style/common.css">
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>style/index.css">
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>style/open.win.css">
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>style/msgtask.css">
    
</head>
<body style="background: #fff;">
    <!--列表 -->
    <div class="htyg_tc" style="display: none;">
        <ul>
            <li class="htyg_tc_1" style="font-family: Microsoft YaHei;"></li>
            <li class="htyg_tc_2" onclick="javascript:self.parent.$.closeWin()">
            	<a href="javascript:void(0)" id="imgeColse">
            		<img src="<?=base_url()?>style/images/sj-tc.png">
            	</a>
        	</li>
        </ul>
    </div>
    <script type="text/javascript">
       

        $(function () {
            $(".fprw-rwlx li").hover(function () {
                $(".fprw-rwlx li").removeClass("cur");
                $(this).addClass("cur");
            });
            $(".htyg_tc").hide();

            $(".fprw-rwlx ul li").click(function () {
                $(this).find(":radio").attr("checked", true);
            });
        })
         function Save() {
            var data = $("input[type=radio]:checked");
            if (data.length == 0) {
                $.openAlter("请选择任务类型", "提示");
                return false;
            }
            //alert(data.val());
            window.parent.location.href = "<?=site_url('sales')?>" + "?id="+data.val();
    		parent.document.getElementById("ow001").style.display = "none";
    		parent.document.getElementById("ow002").style.display = "none";
            //window.parent.window.jBox.close();
        }
        function Colse() {
           
            window.parent.location.href = "<?=site_url('user')?>";
        } 
    </script>
    <!-- 任务类型-->
    <div class="fprw-sdsp" style="margin-left: 4px">
        
        <!--<center style="font-size: 20px">任务类型选择</center>
       
       <div style=" margin-left:97%;" > 
            <img src="<?=base_url()?>style/images/close.png" class="closeicon1" onclick="javascript:self.parent.$.closeWin()" style="cursor: pointer;">
        </div>
        <br>-->
        <div class="fprw-rwlx">
            <ul>
                <li class="cur" style=" width: <?=$has_lock ? '33.33%' : '50%';?>!important;">
                    <p class="fprw-rwlx_1" style="line-height: 42px; margin-left: 20px!important;"><input class="input-radio16" type="radio" name="TaskCategory" checked="checked" id="radio" value="1"></p>
                    <p style="line-height: 42px"><label for="radio">销量任务</label></p>
                </li>
                <li style=" width: <?=$has_lock ? '33.33%' : '50%';?>!important;">
                    <p class="fprw-rwlx_1" style="line-height: 42px; margin-left: 20px!important;"><input class="input-radio16" type="radio" name="TaskCategory" id="radio5" value="5"></p>
                    <p style="line-height: 42px"><label for="radio5">预约单</label></p>
                </li>
                <!--<li style=" width: 25%!important;">
                    <p class="fprw-rwlx_1" style="line-height: 42px; margin-left: 20px!important;"><input class="input-radio16" type="radio" name="TaskCategory" id="radio3" value="3"></p>
                    <p style="line-height: 42px"><label for="radio3">复购任务</label></p>
                </li>-->
                <?php if($has_lock):?>
                <li style=" width: 33.33%!important;">
                    <p class="fprw-rwlx_1" style="line-height: 42px; margin-left: 20px!important;"><input class="input-radio16" type="radio" name="TaskCategory"  id="radio4" value="4"></p>
                    <p style="line-height: 42px"><label for="radio4">预订单（仅限大促活动使用）</label></p>
                </li>
                <?php endif;?>
                <!--<li >
                    <p class="fprw-rwlx_1" style="line-height: 42px"><input class="input-radio16" type="radio" name="TaskCategory" id="radio2" value="3"></p>
                    <p style="line-height: 42px"><label for="radio2">复购任务</label></p>
                </li>-->
            </ul>
        </div>
        <div class="fprw-sdsp_2">
            <table>
                <tbody><tr>
                    <!--<th width="35">特<br>点</th>-->
                    <td width="25%">  <!--销量任务-->
                        <p class="fprw-rwlx_2" style="margin-left: 45px">安全： 兼职真实买家</p>
                        <p class="fprw-rwlx_3" style="margin-left: 90px">一人一号</p>
                        <p class="fprw-rwlx_2 fprw-rwlx_4" style="margin-left: 30px">高权重：实名主号，三心以上</p>
                        <p class="fprw-rwlx_3" style="margin-left: 85px">可对目标客户进行定位</p>
                    </td>
                    <td width="25%">  <!--预约单-->
                        <p class="fprw-rwlx_2" style="margin-left: 45px">安全： 今日浏览，明日下单</p>
                        <p class="fprw-rwlx_3" style="margin-left: 90px">订单安全更可靠</p>
                        <p class="fprw-rwlx_2 fprw-rwlx_4" style="margin-left: 30px">高权重：多型选择，灵活要求</p>
                        <p class="fprw-rwlx_3" style="margin-left: 85px">让买家更严谨</p>
                    </td>
                    <?php if($has_lock):?>
	                    <td width="25%">  <!--预订单-->
	                        <p class="fprw-rwlx_2" style="margin-left: 45px">安全： 迎合活动条件</p>
	                        <p class="fprw-rwlx_3" style="margin-left: 90px">按商家要求时间完成订单</p>
	                        <p class="fprw-rwlx_2 fprw-rwlx_4" style="margin-left: 30px">高权重：时间限制，高要求</p>
	                        <p class="fprw-rwlx_3" style="margin-left: 85px">订单安全系数高</p>
	                    </td>
                    <?php endif;?>
                    <!--<th width="35">特<br>点</th>-->
                    <!--<td width="349">
                        <p class="fprw-rwlx_2" style="margin-left: 25px">个性化下单路径： 指定用户复购</p>
                        <p class="fprw-rwlx_2 fprw-rwlx_4" style="margin-left: 30px">全面性：包含销量任务的所有特点</p>
                    </td>-->
                </tr>
            </tbody></table>
        </div>
        <div class="fprw-xzgl_2">
            <input onclick="Save()" class="input-butto100-ls" type="button" value="我选好了">
        </div>
    </div>
    <!-- 任务类型-->



</body></html>