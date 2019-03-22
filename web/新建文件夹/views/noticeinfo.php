
   <?php require_once('include/header.php')?>  
    <script type="text/javascript">
        $(document).ready(function () {
            $("#NewContentIndex").addClass("a_on");
            $("#NewMemberInfo").addClass("a_on");

        })

        function iFrameHeight() {

            var ifm = document.getElementById("iframepage");

            var subWeb = document.frames ? document.frames["iframepage"].document :

ifm.contentDocument;

            if (ifm != null && subWeb != null) {

                ifm.height = subWeb.body.scrollHeight;
                if (subWeb.body.scrollHeight + 100 < 500) //以防止公告内容太少左侧菜单栏显示不全
                    $(".vip-info").height(500);
                else
                    $(".vip-info").height(subWeb.body.scrollHeight + 100);
                //$(".vip-info").height("500");
            }

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
                <li><a href="<?=site_url('member/store')?>" >店铺管理</a></li><!--  选中栏目 -->
                <li><a href="<?=site_url('member/product')?>">商品管理</a></li>                
                <li><a href="<?=site_url('member/notice')?>" style="background: #eee;color: #ff9900;" >平台公告</a></li>
                <li><a href="<?=site_url('member/edit')?>" >调整单量</a></li>
                <?php if($info->ispromoter):?>
                <li><a href="<?=site_url('member/join')?>" >邀请好友</a></li>
                <?php endif;?>
            </ul>
        </div>
    
        
    <div class="zjgl-right">
        <div class="sk-hygl">
            <div class="sk-xwxq">
                <p class="sk-xwxq_1"><?=$newinfo->goods_name?></p>
                <p style="color: #999;">
                    <?=@date('Y/m/d H:i:s',$newinfo->add_time)?><span style="margin-left: 10px;">系统</span></p>
            </div>
            <div class="sk-xwxq_2">
                <?=$newinfo->goods_desc?>
            </div>
        </div>
    </div>

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
</body>
</html>