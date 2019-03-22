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
    	<?php require_once('include/member_menu.php')?>
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
                <?php require_once('include/page.php')?> 
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