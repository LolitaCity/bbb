<!DOCTYPE html>
<html> 
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>二师兄刷单</title>
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
            <li class="htyg_tc_2"><a href="javascript:void(0)" id="imgeColse" onclick="javascript:self.parent.$.closeWin()"><img src="<?=base_url()?>style/images/sj-tc.png"></a></li>
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
        
        <center style="font-size: 20px">任务类型选择</center>
       <div style=" margin-left:97%; margin-top:-25px"> <a onclick="Colse()" href="javascript:void(0)">
            <img src="<?=base_url()?>style/images/close.png" class="closeicon1" onclick="Colse()" style="display: block;"></a></div>
        <br>
        <div class="fprw-rwlx">
            <ul>
                <li class="cur" >
                    <p class="fprw-rwlx_1" style="line-height: 42px"><input class="input-radio16" type="radio" name="TaskCategory" checked="checked" id="radio" value="1"></p>
                    <p style="line-height: 42px"><label for="radio">销量任务</label></p>
                </li>
                <li >
                    <p class="fprw-rwlx_1" style="line-height: 42px"><input class="input-radio16" type="radio" name="TaskCategory" id="radio2" value="3"></p>
                    <p style="line-height: 42px"><label for="radio2">复购任务</label></p>
                </li>
            </ul>
        </div>
        <div class="fprw-sdsp_2">
            <table>
                <tbody><tr>
                    <th width="35">特<br>点</th>
                    <td width="349">
                        <p class="fprw-rwlx_2" style="margin-left: 45px">安全： 兼职真实买家</p>
                        <p class="fprw-rwlx_3" style="margin-left: 90px">一人一号，永不复购</p>
                        <p class="fprw-rwlx_2 fprw-rwlx_4" style="margin-left: 30px">高权重：实名主号，三心以上</p>
                        <p class="fprw-rwlx_3" style="margin-left: 85px">可对目标客户进行定位</p>
                    </td>
                    <th width="35">特<br>点</th>
                    <td width="349">
                        <p class="fprw-rwlx_2" style="margin-left: 25px">个性化下单路径： 指定用户复购</p>
                        <p class="fprw-rwlx_2 fprw-rwlx_4" style="margin-left: 30px">全面性：包含销量任务的所有特点</p>
                    </td>
                </tr>
            </tbody></table>
        </div>
        <div class="fprw-xzgl_2">
            <input onclick="Save()" class="input-butto100-ls" type="button" value="我选好了">
        </div>
    </div>
    <!-- 任务类型-->



</body></html>