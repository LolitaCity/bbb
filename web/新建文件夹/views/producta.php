<?php require_once('include/header.php')?>  
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>style/producta.css">

    <script type="text/javascript">



        $(function() {
            $('.fb_tjclose').each(function() {
                PIE.attach(this);
            });
        });

        //商品查找

        function searchProduct() {
            $("#fm").submit();
        }

//        $(document).ready(function () {
//            $('.fb_tjclose').click(function () {
//                window.location.href = "/Shop/Product/ProductIndex";
//            })
//        })

        $(document).ready(function() {
            $("#All").click(function() {
                if ($(this).attr("checked") == "checked") {
                    $("input[type='checkbox']").attr("checked", true);
                } else {
                    $("input[type='checkbox']").attr("checked", false);
                }
            });
        });

        function ClickCheckBox(name) {
            $("input[value=" + name + "]").click();
        }
    </script>

<body style="background: #fff;">
    <?php require_once('include/nav.php')?>
    <!--daohang-->
    
    <div class="sj-zjgl">
        <div class="zjgl-left">
            <h2 style="background: url(<?=base_url()?>style/images/hygl.png) no-repeat 22px 22px;">会员中心</h2>
            <ul>
                <li><a href="<?=site_url('member')?>">基本资料</a></li>
                <li><a href="<?=site_url('member/store')?>">店铺管理</a></li><!--  选中栏目 -->
                <li><a href="<?=site_url('member/product')?>" style="background: #eee;color: #ff9900;">商品管理</a></li>                
                <li><a href="<?=site_url('member/notice')?>">平台公告</a></li>
                <li><a href="<?=site_url('member/edit')?>">调整单量</a></li>
                <?php if($info->ispromoter):?>
                <li><a href="<?=site_url('member/join')?>" >邀请好友</a></li>
                <?php endif;?>
            </ul>
        </div>
        
<form action="<?=site_url('member/search')?>" enctype="multipart/form-data" id="fm" method="post">        
    <div class="zjgl-right">
            <div class="errorbox" id="clientValidation" style="display: none; height: 30px; margin-left: 20px;width: 95%;">
                <ol style="list-style-type: decimal" id="clientValidationOL">
                </ol>
            </div>
            <div class="sk-hygl">
                <div class="hyzx_bz">
                    <h2>添加商品</h2>
                </div>
                <div class="fpgl-ss">
                    <p>店铺名称： 
                        <select class="select_215" id="PlatformNoID" name="PlatformNoID" style="width:200px;">
                            <option selected="selected" value="0">所有</option>
                            <?php foreach($shoplist as $vs):?>
                            <option value="<?=$vs->sid?>"><?=$vs->shopname?></option>
                            <?php endforeach;?>
                        </select>
                        <script>
                        $("#PlatformNoID").val("<?=$search?$shopid:0?>");
                        </script>
                    </p>
                    <p><input class="input_417" id="Name" name="Name" placeholder="简称/名称" style="width: 180px" type="text" value="<?=$search?$proname:'';?>"></p>
                    <p><input class="input_417" id="ProductPlatformID" name="ProductPlatformID" placeholder="商品ID" style="width: 180px" type="text" value="<?=$search?$proid:'';?>"></p>
                    <p><input class="input-butto100-ls" type="submit" value="查询"></p>
                    <p><input class="input-butto100-hs" type="button" value="刷新" onclick=" Refresh() "></p>
                </div>
                <div class="fpgl-ss">
                    <p><input class="button-c" type="button" value="添加" onclick=" window.open('<?=site_url('member/proadd')?>') "></p>
                    <p><input class="button-c" type="button" value="删除" onclick=" ConfirmDelete() "></p>    
                </div>
                <div class="zjgl-right_2">
                    <table>
                        <tbody><tr>
                            <th width="70"><input type="checkbox" id="All"></th>
                            <th width="252">简称</th>
                            <th width="450">商品名称</th>
                            <th width="160">商品ID</th>
                            <th width="160">状态</th>     
                            <th width="160">操作</th>                              
                        </tr>
                            <?php foreach($product as $va):?>
                                <tr>
                                    <td>
                                        <input type="checkbox" value="<?=$va->id?>" name="<?=$va->commodity_abbreviation?>" lock="true">
                                    </td>
                                    <td align="center" onclick=" ClickCheckBox('<?=$va->id?>') ">
                                        <a href="javascript:void(0)" title="<?=$va->commodity_abbreviation?>"><?=$va->commodity_abbreviation?></a>
                                    </td>
                                    <td align="center" onclick=" ClickCheckBox('<?=$va->id?>') ">
                                        <a href="javascript:void(0)" title="<?=$va->commodity_title?>"><?=$va->commodity_title?></a>
                                    </td>
                                    <td align="center" onclick=" ClickCheckBox('<?=$va->id?>') ">
                                        <a href="javascript:void(0)" title="<?=$va->commodity_id?>"><?=$va->commodity_id?></a>
                                    </td>
                                    <td align="center" onclick=" ClickCheckBox('<?=$va->id?>') ">
                                         <a href="javascript:void(0)" title="<?=$va->status==1?'正常':'不正常'?>"><?=$va->status==1?'正常':'不正常'?>
                                            <?php if($va->status==0):?><span style="color:red; font-size:12px; display:block;">请先设置好目标买手</span><?php endif;?>
                                            <?php if($va->peostatus!=1):?><span style="color:red; font-size:12px; display:block;">请设置购买行为！</span><?php endif;?>
                                         </a>
                                    </td>
                                    <td >
                                         <a class="button-c thisbtn" href="<?=site_url('member/seepro/'.$va->id)?>" target="_blank">查看详情</a>
                                         <a class="button-c thisbtn" href="<?=site_url('member/editpro/'.$va->id)?>">编辑</a>
                                         <a class="button-c thisbtn" onclick="delinfo(<?=$va->id?>)">删除</a>
                                         <a class="button-c thisbtn" onclick="openwin(<?=$va->id?>)">目标买手</a>
                                         <a class="button-c thisbtn" onclick="openwinout(<?=$va->id?>)">购买行为</a>
                                    </td>                                  
                                </tr>
                            <?php endforeach;?>
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
    <?php if (!$search):?>
    <div class="yyzx_1">
        <p class="yyzx_2">
            <a href="javascript:" onclick="prePage('<?=site_url('member/product')?>','<?=$page?>','<?=ceil($count/10)?>')"></a>
        </p>
        <p style="margin-left: 5px; margin-right: 5px;"><?=$page+1?>/<?=ceil($count/10)?></p>
        <p class="yyzx_3">
            <a href="javascript:" onclick="nextPage('<?=site_url('member/product')?>','<?=$page?>','<?=ceil($count/10)-1?>')"></a>
        </p>
        <p style="margin-left: 12px; margin-right: 8px;">
            <input type="text" name="PageIndex" class="input_58" id="PageIndex" value="1" onkeyup="value=value.replace(/[^0-9]/g,'');submitPage(event,'<?=ceil($count/10)?>')" maxlength="9">
        </p>
        <p class="ymfw-right-zgj_7">
            <a href="javascript:" id="paRedirect" onclick="redirectPage('<?=site_url('member/product')?>','<?=ceil($count/10)?>')">
                跳转</a></p>
    </div>
    <?php endif;?>
            </div>
        </div>
<script>
    function openwin(proid){
        $.openWin(580,860,"<?=site_url('member/sitepro')?>"+'?id='+proid);
    }
    function openwinout(proid){
        $.openWin(580,860,"<?=site_url('member/setpro')?>"+'?id='+proid);
    }
</script>        
        <style>
            .thisbtn{ display:block; margin:5px 0;}
        </style>
        <div id="light1" class="ycgl_tc yctc_498">
            <!--列表 -->
            <div class="htyg_tc">
                <ul>
                    <li class="htyg_tc_1" id="lTitle"></li>
                    <li class="htyg_tc_2"><a href="javascript:void(0)" onclick=" document.getElementById('light1').style.display = 'none';document.getElementById('fade').style.display = 'none'; ">
                        <img src="<?=base_url()?>style/images/sj-tc.png"></a></li>
                </ul>
            </div>
            <!--列表 -->
            <div class="yctc_458 ycgl_tc_1">
                <ul>
                    <li class="" id="lblRemark"></li>
                    <li class="fpgl-tc-qxjs_4">
                        <p>
                            <input class="input-butto100-hs" type="button" id="btnSubmit" value="确定" onclick=" ">
                        </p>
                        <p>
                            <input onclick=" document.getElementById('light1').style.display = 'none'; document.getElementById('fade').style.display = 'none'; " class="input-butto100-ls" type="button" value="取消"></p>
                    </li>
                </ul>
            </div>
        </div>
        <div id="fade" class="black_overlay">
        </div>
</form>
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
		    <input name="" type="button" id="sure"  class="sure" value="确定"/>&nbsp;
		    <input name="" type="button"  class="cancel" value="取消" />
	    </div>    
    </div>    
    <!-- 删除弹窗确认 -->
    <div id="all_btn_delete" class="tip">
        <div class="tiptop"><span>删除内容</span><a></a></div>        
	    <div class="tipinfo">
		    <div class="tipright">
		      <p>确认删除选中数据？<br />
		              删除以后将无法恢复！请谨慎操作。</p>      
		    </div>
	    </div>        
	    <div class="tipbtn">
		    <input name="" type="button" id="allsure" class="sure" value="确定"/>&nbsp;
		    <input name="" type="button"  class="cancel" value="取消" />
	    </div>    
    </div>
    <script> 
function delinfo(id){
   $("#btn_delete").fadeIn(180);
   $("#sure").attr('data_info',id);
}
        
$(document).ready(function(){ 
	  $(".tiptop a").click(function(){
	      $(".tip").fadeOut(180);
	  });
	  $(".cancel").click(function(){
	      $(".tip").fadeOut(180);
	  });
	  $("#sure").click(function(){
		  var id=$(this).attr('data_info');	  
		  //alert(id);
	      window.location.href="<?=site_url('member/delpro')?>"+"?id="+id;
	  });
	  $("#allsure").click(function(){
		  //var id=$(this).attr('data_info');	  
		  //alert(id);
		  var aid ='';
		  var checks = $(":checkbox:checked");
		  for(n=0;n<checks.length;n++){
			  if(checks.eq(n).attr("value")!='on'){
				   aid += checks.eq(n).attr("value")+',';
			  }
		  }	
		  if(aid==''){
			  alert('请先选择需要删除的数据！');
			  $(".tip").fadeOut(180);   
	      }else{
	    	  window.location.href="<?=site_url('member/delarr')?>"+"?arr="+aid;
	      }
	  });
	});
function ConfirmDelete(){
	   $("#all_btn_delete").fadeIn(180);
}
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