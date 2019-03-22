<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title></title>
    <script src="<?=base_url()?>style/jquery-1.8.3.js" type="text/javascript"></script>
    <script src="<?=base_url()?>style/jquery.jslides.js" type="text/javascript"></script>
    <script src="<?=base_url()?>style/open.win.js" type="text/javascript"></script>
    <script src="<?=base_url()?>style/jquery.jBox-2.3.min.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>style/jbox.css">
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>style/common.css">
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>style/index.css">
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>style/open.win.css">
    
</head>
<body style="background: #fff;">
    <!--列表 -->
    <!--<div class="htyg_tc">
        <ul>
            <li class="htyg_tc_1" style="font-family: Microsoft YaHei;">查看详情</li>
            <li class="htyg_tc_2"><a href="javascript:void(0)" id="imgeColse" onclick="javascript:self.parent.$.closeWin()">
                <img src="<?=base_url()?>style/images/sj-tc.png"></a> </li>
        </ul>
    </div>-->
    
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>style/jbox(1).css">
    <script src="<?=base_url()?>style/jquery.jBox-2.3.min.js" type="text/javascript"></script>
    <script src="<?=base_url()?>style/md5.js" type="text/javascript"></script>
    <script type="text/javascript">
        
    </script>
    <style type="text/css">
        ul
        {
            font-size: 14px;
            font-family: 微软雅黑;
        }
        
        .sk-zjgl_4
        {
            width: 120px;
            margin-left: 50px;
        }
        
        img
        {
            position: relative;
            margin-top: 9px;
        }
    </style>
    <!--列表 -->
    <div class="yctc_458 ycgl_tc_1">
        <ul>
            <li>
                <p class="sk-zjgl_4">
                    淘宝会员名：</p>
                <p style="line-height: 35px;"><?=$buyerinfo->wangwang?></p>
            </li>
            <li>
                <p class="sk-zjgl_4">
                    &nbsp;性别：</p>
                <p style="line-height: 35px;"><?=$buyerinfo->sex=='0'?'男':'女'?></p>
            </li>
            <li>
                <p class="sk-zjgl_4">
                    注册时间：</p>
                <p style="line-height: 35px;"><?=@date('Y-m-d H:i:s',$buyerinfo->RegTime)?></p>
            </li>
            <li>
                <p class="sk-zjgl_4">
                    淘宝信用值：</p>
                <p style="line-height: 35px;">
                    <?php if(!isset($buyerinfo->account_info)) die('暂无该信息'); foreach(unserialize($buyerinfo->account_info) as $key=>$val):?>
                        <?php if($key=='tqz_val'):?>
                            <?php echo $val;?>
                        <?php endif;?>
                    <?php endforeach;?>
                </p>
            </li>
            <li>
                <p class="sk-zjgl_4">
                    淘宝气值：</p>
                <p style="line-height: 35px;">
                    <?php  if(!isset($buyerinfo->account_info)) die('暂无该信息'); foreach(unserialize($buyerinfo->account_info) as $key=>$val):?>
                        <?php if($key=='tqz_val'):?>
                            <?php echo $val;?>
                        <?php endif;?>
                    <?php endforeach;?>
                </p>
            </li>
            
            <li class="fpgl-tc-qxjs_4" style="position: fixed; bottom: 10px; right: 150px;">
                <p>
                    <input onclick="self.parent.$.closeWin()" class="input-butto100-ls" type="button" value="关闭"></p>
            </li>
        </ul>
    </div>



</body>
</html>