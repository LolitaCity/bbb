<?php
$ifshowcontent = 0;
if($showcontent==1){
     if(isset($_SESSION['sellershowcontent'])){
         if($_SESSION['sellershowcontent']==0){
             $ifshowcontent = 1;
         }
     }else{
         $ifshowcontent = 1;
     }
}
?> 
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>二师兄平台</title>
    <meta Content-Ecoding="gzip">
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="renderer" content="webkit">
    <script src="<?=base_url()?>style/jquery-1.8.3.js" type="text/javascript"></script>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    
    <script src="<?=base_url()?>style/jquery.jslides.js" type="text/javascript"></script>
    <script src="<?=base_url()?>style/open.win.js" type="text/javascript"></script>
    <script src="<?=base_url()?>style/jquery.vticker-min.js" type="text/javascript"></script>
    <link href="<?=base_url()?>style/common.css" rel="stylesheet" type="text/css">
    <link href="<?=base_url()?>style/index.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>style/open.win.css">
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>style/custom.css">
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>style/index2.css">
    <script language="javascript" type="text/javascript">
        $(document).ready(function () {
            var memberType='商家'
            if(memberType!="商家")
            {
              $("#aOut").click();
            }
        });
    </script>
    <script type="text/javascript">
        $(function () {
            var div2 = document.getElementById("No_x1");
            var div1 = document.getElementById("Open_x1");
        });
    </script>
    
    <script src="<?=base_url()?>style/jquery.kinMaxShow.min.js" type="text/javascript"></script>
 
    <script type="text/javascript">
        $(document).ready(function () {
          /*   $("#ShopIndex").addClass("ShopIndex");
            $("#Index").addClass("a_on");
            $("#kinMaxShow").kinMaxShow(); */
            var showconteng = "<?=$ifshowcontent?>";
            if(showconteng==1){
                ShowContent();
            }
        });

        function ShowContent()
        {
            $.openWin(600,800, "<?=site_url('user/showinfo')?>");
        }

    </script>  



</head>