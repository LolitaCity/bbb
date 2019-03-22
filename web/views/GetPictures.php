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
            <li class="htyg_tc_1" style="font-family: Microsoft YaHei;">
                查看任务截图 <?=$info->tasksn?>
            </li>
            <li class="htyg_tc_2">
                <a href="javascript:void(0)" id="imgeColse" onclick="javascript:self.parent.$.closeWin()">
                    <img src="<?=base_url()?>style/images/sj-tc.png" >
                </a>
            </li>
        </ul>
    </div>-->
    
    <style type="text/css">
        .fitem
        {
            font-size: 14px;
            color: Black;
            margin-left: 20px;
            margin-top: 10px;
        }
        #divList ul
        {
            overflow: hidden;
            width: 100%;
            margin-top: 6px;
            margin-left: 20px;
        }
        #divList ul li
        {
            width: 45%;
            float: left;
            font-size: 14px;
            color: Black;
        }
        #divList ul li:even
        {
            margin-left: 50px;
        }
        .Cash_bz
        {
            border-bottom: 1px dashed #ddd;
            font-size: 14px;
            height: 1px;
            margin-top: 15px;
            margin-bottom: 15px;
        }
    </style>
    <div style="overflow: auto; height: 530px; width: 98%; padding-left: 2%;">
            <div id="divList" style="margin-left: 20px">
                <ul>
                    <li>
                        <label for="FineTaskCategroy">搜索关键字：</label>
                            <span><?=$proinfo->keyword?></span>
                    </li>
                    <li style="margin-left: 50px;">
                        <label for="TaskID">发货城市：</label>
                            <span><?=$proinfo->sendaddress==''?'（无）':$proinfo->sendaddress?></span>
                    </li>
                </ul>
                <ul>
                    <li>
                        <label for="FineTaskCategroy">排序方式：</label>
                            <span><?php switch ($proinfo->order){
                                    case 1: echo '综合'; break;
                                    case 2: echo '新品'; break;
                                    case 3: echo '人气'; break;
                                    case 4: echo '销量'; break;
                                    case 5: echo '价格从低到高'; break;
                                    case 6: echo '价格从高到低'; break;
                                    default: echo '（无）'; break;
                                }?>（无）</span>
                    </li>
                    <li style="margin-left: 50px;">
                        <label for="TaskID">其他搜索：</label>
                            <span><?=$proinfo->other==''?'（无）':$proinfo->other?></span>
                    </li>
                </ul>
                <ul>
                    <li>
                        <label for="FineTaskCategroy">价格区间：</label>
                            <span><?=$proinfo->price==''?'（无）':$proinfo->price?></span>
                    </li>
                </ul>
            </div>
            <div class="Cash_bz">
            </div>
            <div style="font-size:18px;">进店搜索图：</div>
            <hr/>
            <a id="a1" href="<?=$info->tasktwoimg?>" title="点击查看大图" target="_blank"><img id="img1" src="<?=str_replace ( 'pk1172' , '18zang' ,  $info->tasktwoimg );?>" style="padding:0px;margin:0px;vertical-align:middle;"></a>
            <br /><br /><br />
             <div style="font-size:18px;">交易订单图：</div>
             <hr/>
            <a id="a1" href="<?=$info->orderimg?>" title="点击查看大图" target="_blank"><img id="img1" src="<?=str_replace ( 'pk1172' , '18zang' ,  $info->orderimg );?>" style="padding:0px;margin:0px;vertical-align:middle;"></a>
    </div>



</body></html>