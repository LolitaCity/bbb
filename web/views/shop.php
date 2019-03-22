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
        //编辑发货人信息
        function editSendInfo(url)
        {
        	dialog.iframe(url, 550, 420, '编辑新店铺信息');
            //$.openWin(580, 550,url);
        }
        //提交审核资料
        function editAuditInfo(url)
        {
            $.openWin(730, 550, url);
        }
        //查看详情
        function lookDetail(url)
        {
        	dialog.iframe(url, 600, 450, '店铺信息')
            //$.openWin(670, 600, url);
        }
        //绑定店铺
        function createShop(url,height,width){
            $.openWin(height, width, url);
        }  
    </script>

<body style="background: #fff;">
    <?php require_once('include/nav.php')?>
    
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
            <ul>
                <li class="hygl-mh">
                    <p class="hygl-mh_1" style="width: 110px;"> 淘宝店铺：<span id="shop_count"><?=$count?></span> 个</p>
					<?php if(in_array($this-> session -> userdata('sellername'), ['18951252102', '13812343565', '13236338629', '15240305932', '13217658559']) || $count < $max_num):?>
						<p><input onclick="dialog.iframe('<?=site_url('member/addShop')?>', 580, 550, '提交审核资料')" class="input-butto100-xls" type="button" value="绑定新店铺"></p>-->
					<?php endif;?>
                </li>
               <!--  
                <li class="hygl-mh">
                    <p class="hygl-mh_1" style="width: 110px;"> 京东店铺：0 个</p>
                    <p><input onclick="createShop('/Shop/PlatformNo/BindPlatform?platformType=1&amp;s_u_ii=-1&amp;token=77c2',620,550)" class="input-butto100-xls" type="button" value="绑定新店铺"></p>
                </li>
                 -->
            </ul>
            <h2 class="fprw-pt"> 已绑定店铺信息(一个账号只能绑定<?=$max_num?>个店铺)</h2>
            <div class="zjgl-right_2 overfloat-n ">
                <table>
                    <thead><tr>
                        <th style="width: 15%">店铺名称</th>
                        <th style="width: 10%">所属平台</th>
                        <th style="width: 10%">审核状态</th>
                        <th style="width: 10%">使用状态</th>
                        <!--<th style="width: 33%">发货人信息</th>-->
                        <th style="width: 10%">操作按钮</th>
                       <!--  <th style="width: 10%">淘宝客推广</th>
                        <th style="width: 12%">农村淘宝推广</th> -->
                    </tr>
                    </thead>
                    <tbody id="shop_tbody">
                  	
                        <?php foreach($list as $v):?>
                        <tr id="shop_<?=$v->sid?>" class="shop_tr">
                            <td class="shop_name"><?=$v->shopname?></td>
                            <td class="shop_nature"><?=$v->type=='0'?'淘宝':'京东'?><br>（<?=$v->nature=='0'?'个人':'公司'?>）</td>
                            <td style="<?=$v->auditing=='1'?'color:green':($v->auditing=='0'?'color:blue':'color:red')?>"><?=$v->auditing=='1'?'审核通过':($v->auditing=='0'?'等待审核':'审核失败')?> <br><p style="color:orange; font-size:12px;"><?=$v->auditing=='-1'?$v->remark:''?></p></td>
                            <td style="<?=$v->status=='1'?'color:green':'color:red'?>"><?=$v->status=='1'?'可使用':'不可使用'?> </td>
                            <!--<td>
                                <div style="text-align: left">姓名：<?=$v->sendname?></div>
                                <div style="text-align: left">电话：<?=$v->sendphone?></div>
                                <div style="text-align: left; word-break: break-all;">发货地址：<?=$v->sendarea.$v->sendaddress?></div>
                            </td>-->
                            <td>
                                <div style="padding-bottom: 5px;">
                                    <input class="button-c" type="button" value="删除" onclick="delShop(<?=$v->sid?>, this)"></div>
                                    <div style="padding-bottom: 5px;"><input onclick="lookDetail('<?=site_url('member/detailShop/'.$v->sid)?>')" class="button-c" type="button" value="查看详情"></div>
                                    <?php if($v->auditing=='1'):?>
                                        <!--<div style="padding-bottom: 5px;"><input onclick="editSendInfo('<?=site_url('member/editShopOwner/'.$v->sid)?>')" class="button-c" type="button" value="编辑发货人信息"></div>-->
                                    <?php else:?>
                                        <div style="padding-bottom: 5px;"><input onclick="editSendInfo('<?=site_url('member/editShop/'.$v->sid)?>')" class="button-c" type="button" value="编辑新店铺资料"></div>
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
                </tbody></table>
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