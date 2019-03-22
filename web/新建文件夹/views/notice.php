<?php require_once('include/header.php')?>  
    <script language="javascript" type="text/javascript">
        $(document).ready(function () {
            $("#NewMember").addClass("#NewMember");
            $("#ContentIndex").addClass("a_on");
        })
    </script>

<body style="background: #fff;">
   <?php require_once('include/nav.php')?>  
    <!--daohang-->
    
    <div class="sj-zjgl">
            <div class="zjgl-left">
            <h2 style="background: url(<?=base_url()?>style/images/hygl.png no-repeat 22px 22px;">会员中心</h2>
            <ul>
                <li><a href="<?=site_url('member')?>">基本资料</a></li>
                <li><a href="<?=site_url('member/store')?>" >店铺管理</a></li><!--  选中栏目 -->
                <li><a href="<?=site_url('member/product')?>">商品管理</a></li>                
                <li><a href="<?=site_url('member/notice')?>"  style="background: #eee;color: #ff9900;">平台公告</a></li>
                <li><a href="<?=site_url('member/edit')?>" >调整单量</a></li>
                <?php if($info->ispromoter):?>
                <li><a href="<?=site_url('member/join')?>" >邀请好友</a></li>
                <?php endif;?>
            </ul>
        </div>
        
<form action="javascript:void(0)" id="fm" method="post">        
            <div class="zjgl-right">

            <div class="errorbox" id="clientValidation" style="display: none; width: 95%; height: 30px;
                margin-left: 20px">
                <ol style="list-style-type: decimal" id="clientValidationOL">
                </ol>
            </div>
            <div class="sk-hygl">
                <h2 class="fprw-pt">平台公告</h2>
                <div class="zjgl-right_2">
                    <table>
                        <tbody>
                        <tr>
                            <th>标题</th>
                            <th>时间</th>
                            <th>来自</th>
                        </tr>
                            <?php foreach($lists as $vl):?>
                            <tr>
                                <td height="33" align="center" valign="middle">
                                    <a href="<?=site_url('member/detailnotice/'.$vl->goods_id)?>" target="_blank" class="p-l-10">
                                       <span style="font-weight: bold;"><font><?=$vl->goods_name?></font></span>
                                    </a>
                                </td>
                                <td height="33" align="center" valign="middle"><?=@date('Y-m-d H:i:s',$vl->add_time)?></td>
                                <td height="33" align="center" valign="middle"> 系统 </td>
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
    <div class="yyzx_1">
        <p class="yyzx_2">
            <a href="javascript:" onclick="prePage('<?=site_url('member/notice')?>','<?=$page?>','<?=ceil($count/10)?>')"></a>
        </p>
        <p style="margin-left: 5px; margin-right: 5px;"><?=$page+1?>/<?=ceil($count/10)?></p>
        <p class="yyzx_3">
            <a href="javascript:" onclick="nextPage('<?=site_url('member/notice')?>','<?=$page?>','<?=ceil($count/10)-1?>')"></a>
        </p>
        <p style="margin-left: 12px; margin-right: 8px;">
            <input type="text" name="PageIndex" class="input_58" id="PageIndex" value="1" onkeyup="value=value.replace(/[^0-9]/g,'');submitPage(event,'<?=ceil($count/10)?>')" maxlength="9">
        </p>
        <p class="ymfw-right-zgj_7">
            <a href="javascript:" id="paRedirect" onclick="redirectPage('<?=site_url('member/notice')?>','<?=ceil($count/10)?>')"> 跳转</a></p>
    </div>
            </div>
        </div>
</form>
    </div>

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