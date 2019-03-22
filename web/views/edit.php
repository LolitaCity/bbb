<?php require_once('include/header.php')?>  
    <script language="javascript">
        //调整补单
        function CreatePublishNum(id) {
            $.openWin("300", "650", '<?=site_url('member/updataMaxTransfer')?>');
        }
    </script>


<body style="background: #fff;">
    <?php require_once('include/nav.php')?> 
    <!--daohang-->
    
    <div class="sj-zjgl">
        <?php require_once('include/member_menu.php')?>
	</div>   
    <div class="zjgl-right" style="min-height: 650px">
        <div class="bd_explain1">
            <span>补单量调整说明：</span>
            <ul>
                <li>您的账号下当前可用每日单量为：<?=$info->maxtask?></li>
                <li>您的账号下拥有店铺数量：<?=$infocount?></li>
                <!--<li>平台以单个会员进行补单（若会员下拥有不两个或以上店铺则请自行分配到店铺）。避免被淘宝查封店铺！</li>-->
                <li><span style="color:red">每周只能申请一次</span></li>
            </ul>
        </div>
        <div class="a_flex">
             <a href="javascript:void(0)" onclick="CreatePublishNum()" class="bord_4882f0">调整单量</a> 
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