<?php require_once('include/header.php')?>  
    <script language="javascript">
        //调整补单
        function CreatePublishNum(id) {
        	$content = '<p style="padding-bottom: 2%">请选择需要申请购买的单量：</p><select class="select_215" id="selSearch" name="selSearch" style="width: 100%;">';
        	<?php
        		$options = '';
        		foreach($buy as $k => $v)
        		{
        			$options .= '<option value="' . $k .'">' . $k . '</option>';
        		}
    		?>
    		$content += '<?=$options?>' + '</select>';	
            dialog.confirm($content, '申请购买', '取消', function(){
            	public.ajax('/member/applyBuyTask', {tasknum: $('select#selSearch').val()}, function(datas){
            		if (datas.status)
            		{
            			dialog.success(datas.message);
            			$insert = '<tr><td>' + datas.data.number + '</td><td>' + datas.data.price + '</td><td>待审核</td><td>' + datas.data.addtime + '</td><td>待审核</td></tr>';
            			$('tbody#list_body').prepend($insert);
            		}
            		else
            		{
            			dialog.error(datas.message);
            		}
            	});
            });
        }
    </script>


<body style="background: #fff;">
    <?php require_once('include/nav.php')?> 
    <!--daohang-->
    
    <div class="sj-zjgl">
        <?php require_once('include/member_menu.php')?>
	</div>   
    <div class="zjgl-right" >
        <div class="bd_explain1">
            <span>购买单量说明：</span>
            <ul>
            	<?php
            		$list = '';
            		foreach($buy as $k => $v)
            		{
            			$list .= '购买' . $k . '单需花费' . $v . '元人民币；'; 
            		}
        		?>
                <li>本平台单量购买价格梯度：<?=$list?>, 从审核当日起30天内有效</li>
                <li>您的账号下拥有店铺数量：<?=$infocount?></li>
                <li>平台以单个会员进行补单（若会员下拥有不两个或以上店铺则请自行分配到店铺）。避免被淘宝查封店铺！</li>
            </ul>
        </div>
        <div style="padding-top: 2%;">
             <a href="javascript:void(0)" onclick="CreatePublishNum()" class="bord_4882f0" style="float: left;">点击购买单量</a> 
        </div>
        <div style="padding-top: 6%;">
                <table>
                    <thead>
                    	<tr>
	                        <th width="200">申请购买单量</th>
	                        <th width="200">应付金额</th>
	                        <th width="200">审核状态</th>
	                        <th width="200">提交时间</th>
	                        <th width="175">审核结果</th>
	                    </tr>
                    </thead>
                    <tbody id="list_body">
                        <?php foreach($lists as $vo):?>
                        <tr>
                            <td><?=$vo -> number?></td>
                            <td><?=$vo -> price?></td>
                            <td><?=$vo -> state?></td>
                            <td><?=date('Y-m-d H:i:s', $vo -> addtime)?></td>
                            <td>
                            	<?php
                            		switch($vo->state)
                            		{
                            			case '待审核':
                            				echo '待审核';
                            				break;
                        				case '审核通过':
                            				echo '审核通过,本次购买实际扣款' . $vo -> true_price . '元, 于' . date('Y-m-d H:i:s', $vo -> updatetime) . '开始生效';
                            				break;
                        				case '已驳回':
                            				echo '审核被驳回， 理由为：' . $vo -> reason;
                            				break;
                            		}
                        		?>
                            </td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
            </div>
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
                window.location = url + "&page=" + (pageIndex - 1);
        }

        /*下一页*/
        function nextPage(url, pageIndex, maxCount) {
            if (parseInt(pageIndex) >= parseInt(maxCount)) {
                $.openAlter("没有了", "提示", { height: 210, width: 350 });
                return;
            }
            window.location = url + "&page=" + (parseInt(pageIndex) + parseInt(1));
        }

        /*上一页*/
        function prePage(url, pageIndex, maxCount) {
            if (pageIndex <= 0) {
                $.openAlter("没有了", "提示", { height: 210, width: 350 });
                return;
            }
            window.location = url + "&page=" + (pageIndex - 1);
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
    <div class="yyzx_1">
        <p class="yyzx_2">
            <a href="javascript:" onclick="prePage('<?=site_url('member/join?BeginDate=' . @$_GET['BeginDate'])?>','<?=$page?>','<?=ceil($count/10)?>')"></a>
        </p>
        <p style="margin-left: 5px; margin-right: 5px;"><?=$page+1?>/<?=ceil($count/10)?></p>
        <p class="yyzx_3">
            <a href="javascript:" onclick="nextPage('<?=site_url('member/join?BeginDate=' . @$_GET['BeginDate'])?>','<?=$page?>','<?=ceil($count/10)-1?>')"></a>
        </p>
        <p style="margin-left: 12px; margin-right: 8px;">
            <input type="text" name="PageIndex" class="input_58" id="PageIndex" value="1" onkeyup="value=value.replace(/[^0-9]/g,'');submitPage(event,'<?=ceil($count/10)?>')" maxlength="9">
        </p>
        <p class="ymfw-right-zgj_7">
            <a href="javascript:" id="paRedirect" onclick="redirectPage('<?=site_url('member/join')?>','<?=ceil($count/10)?>')">
                跳转</a></p>
    </div>
        </div>

    </div>
    </div>

<style>
.bord_4882f0 {
    width: 120px;
    height: 30px;
	display:block;
	border-radius:5px;
    text-align: center;
	line-height:30px;
    border: 1px solid #4882f0;
    color: #4882f0;
}
.bd_table td a:hover {
    color: #fff;
}
.bord_4882f0:hover {
    background: #4882f0;
    color: #fff;
}
.a_flex {
    display: flex;
    flex-direction: row;
    justify-content: center;
}
.bd_explain1 li {
    height: 25px;
    line-height: 25px;
}
body, ul, li {
    margin: 0;
    padding: 0;
    color: #222;
    font-family: "微软雅黑";
}
.bd_explain1 span {
    padding: 10px;
    height: 35px;
    line-height: 35px;
    font-size: 14px;
    font-weight: normal;
    color: #888;
}
bd_explain2 span {
    color: #888;
    font-size: 16px;
}
    </style>
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