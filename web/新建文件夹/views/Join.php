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
<html><head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="icon" href="http://taobao.007w.net/favicon.ico" type="image/x-icon">
<link href="<?=base_url()?>style/Join/common.css" rel="stylesheet" type="text/css">
<link href="<?=base_url()?>style/Join/user_common.css" rel="stylesheet" type="text/css">
<link href="<?=base_url()?>style/Join/open.win.css" rel="stylesheet" type="text/css">
<script src="<?=base_url()?>style/Join/jquery-1.8.3.min.js" type="text/javascript"></script>
<script src="<?=base_url()?>style/Join/jquery.jslides.js" type="text/javascript"></script>
<script type="text/javascript" src="<?=base_url()?>style/Join/open.win.js"></script>


    <title>二师兄平台</title>
    
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

<body>
   <?php require_once('include/nav.php')?>  
<!--daohang-->
    <!--会员中心-->
<style>
    .intbox{overflow: hidden;width: 100%;margin: 20px 0}
    .intbox dt,.intbox dd{float: left;margin-right: 10px;line-height: 30px;}
    .intbox dd input{border: solid #ddd 1px;height: 30px;padding-left: 10px;}
    .intbox botton{background: #bb0a0a;padding: 8px;color: #fff;cursor: pointer}
</style>
<link type="text/css" rel="stylesheet" href="<?=base_url()?>style/Join/laydate.css">
<div class="sj-zjgl">

    
    
    <link type="text/css" rel="stylesheet" href="<?=base_url()?>style/Join/user_center.css">
<style>
    .cur_tab{background: #eee;color: #1e9223;}
</style>
    <div class="d_hy">
        <div class="zjgl-left">
            <h2 style="background: url(<?=base_url()?>style/images/hygl.png) no-repeat 22px 22px;">会员中心</h2>
            <ul>
                <li><a href="<?=site_url('member')?>">基本资料</a></li>
                <li><a href="<?=site_url('member/store')?>" >店铺管理</a></li><!--  选中栏目 -->
                <li><a href="<?=site_url('member/product')?>">商品管理</a></li>                
                <li><a href="<?=site_url('member/notice')?>" >平台公告</a></li>
                <li><a href="<?=site_url('member/edit')?>" >调整单量</a></li>
                <li><a href="<?=site_url('member/join')?>" style="background: #eee;color: #ff9900;" >邀请好友</a></li>
            </ul>
        </div>
    </div>

        <div class="zjgl-right">
        <div class="sk-hygl">
            <dl class="intbox">
                <dt>请输入邀请者手机号：</dt>
                <dd><input type="text" maxlength="11" onblur="value=value.replace(/[^0-9]/g,'')" onkeyup="value=value.replace(/[^0-9]/g,'')" onpaste="value=value.replace(/[^0-9]/g,'')" value="" name="invitphon" id="invitphon"></dd>
                <dd><botton type="botton" id="createInviteUrl">生成邀请链接</botton></dd>
            </dl>
            <div class="bddf mt20">
                <table id="urlbox" style="display: none">

                </table>
            </div>
 <script>
     $('#createInviteUrl').click(function () {
         var phon=$.trim($('#invitphon').val());
         msg='';
         if (phon.length !=11) {
        	 msg="手机号只能输入11位纯数字";
         }else if (!(/^1[3|4|5|7|8]\d{9}$/.test(phon))) {
        	 msg="手机号格式不正确";
         }
         if(msg != ''){
        	 $.openAlter(msg,'提示',{width:250,height:250})
         }else{
             $.post('<?=site_url('member/JoinDB')?>',{phon:phon},function(data){
                $('#urlbox').show();
                $('#urlbox').html(data)
             },'html')
         }

     })
 </script>
            <ul style="margin-top: 20px">
                <li class="hygl-mh">
                    <p class="hygl-mh_1" style="font-size: 16px;">
                        我推荐的好友</p>
                    <!--<p id="pAddJDBuyNo">
                        <input onclick="AddJDBuyNo()" class="input-butto100-xls" type="button" value="绑定新买号"></p>-->
                </li>
            </ul>
            <div class="zjgl-right_2">
                <table>
                    <tbody><tr>
                        <th width="200">
                            手机号(登录账号)
                        </th>
                        <th width="200">
                            状态
                        </th>
                        <th width="200">
                            QQ
                        </th>
                        <th width="200">
                            每日单量
                        </th>
                        <th width="200">
                            微信号
                        </th>
                        <th width="175">
                           是否隐藏
                        </th>
                    </tr>
                    <script type="text/javascript">
                        $("#pAddBuyNo").hide();
                    </script>
                        <?php foreach($userlist as $vul):?>
                        <tr>
                                <td>
                                   <?=$vul->Username?>
                                </td>
                                <td>
                                   <?=$vul->Status==0?'正常':'冻结'?>
                                </td>
                                <td>
                                    <!--启用<br>-->
                                    <label><?=$vul->QQToken?></label>
                                </td>
                                <td>
                                    <?=$vul->maxtask?>
                                </td>
                                <td>
                                    <?=$vul->wechat?>
                                </td>
                                <td>
                                    <?=$vul->ShowStatus=='0'?'正常':'隐藏'?>
                                </td>
                            </tr>
                        <?php endforeach;?>
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
    <div class="yyzx_1">
        <p class="yyzx_2">
            <a href="javascript:" onclick="prePage('<?=site_url('member/join')?>','<?=$page?>','<?=ceil($count/10)?>')"></a>
        </p>
        <p style="margin-left: 5px; margin-right: 5px;"><?=$page+1?>/<?=ceil($count/10)?></p>
        <p class="yyzx_3">
            <a href="javascript:" onclick="nextPage('<?=site_url('member/join')?>','<?=$page?>','<?=ceil($count/10)-1?>')"></a>
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

<?php require_once('include/footer.php')?>  

</body></html>