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
    <div class="htyg_tc">
        <ul>
            <li class="htyg_tc_1" style="font-family: Microsoft YaHei;">查看任务详情</li>
            <li class="htyg_tc_2"><a href="javascript:void(0)" id="imgeColse" onclick="javascript:self.parent.$.closeWin()"><img src="<?=base_url()?>style/images/sj-tc.png"></a> </li>
        </ul>
    </div>
    
    <style type="text/css">
        .ftitle
        {
            border-bottom: 1px solid #ccc;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 10px;
            padding: 5px 0;
        }
        .fitem label
        {
            display: inline-block;
            font-size: 14px;
            width: 100px;
            text-align: right;
        }
        .fitem span
        {
            display: inline-block;
            font-size: 14px;
            width: 200px;
            text-align: left;
        }
        element.style
        {
            margin-left: 0;
            margin-right: 0;
            padding-bottom: 3px;
            padding-top: 3px;
            width: 156px;
        }
        .textbox .textbox-text
        {
            border: 0 none;
            border-radius: 5px;
            font-size: 14px;
            margin: 0;
            outline-style: none;
            padding: 4px;
            resize: none;
            vertical-align: top;
            white-space: normal;
        }
        .fitem input
        {
            width: 160px;
        }
    </style>
    <div class="yctc_458 ycgl_tc_1" style="width: 670px; height: 610px; overflow: auto">
            <div class="ftitle">任务基本信息</div>
            <div class="fitem">
                <label for="FineTaskCategroy">任务分类：</label><span><?=$task->tasktype=='3'?'复购任务':'销量任务'?></span>
                <label for="TaskID">任务编号：</label><span><?=$taskinfo->tasksn?></span>
            </div>
            <div class="fitem" >
                <label for="PlatformType">任务平台：</label><span>淘宝</span>
                <label for="PlatformOrderNumber">订单编号：</label>
                <span><?=$taskinfo->ordersn?></span>
            </div>

            <div class="fitem"  style="margin:5px 0;">
                <label for="TaskType">任务类型：</label><span>
                    <?php switch ($task->intlet){
                        case 1:
                            echo "无线端";break;
                        case 2:
                            echo "电脑端";break;
                        case 3:
                            echo "无线端";break;
                        case 4:
                            echo "无线端";break;
                        case 5:
                            echo "电脑端";break;
                        case 6:
                            echo "无线端";break;
                    }?></span>
                <label for="ProductPrice">产品价格：</label><span><?=$taskmodel->price?></span>
            </div>         
            <div class="fitem"  style="margin:5px 0;">
                <label for="BuyProductCount">拍下件数：</label><span><?=$taskmodel->auction?></span>
                <label for="ProductModel"> 型号：</label><span><?=$taskmodel->modelname?></span>
            </div>
            <div class="ftitle">搜索关键字</div>
            <div class="fitem">
                <label for="SearchKey"> 搜索关键字：</label>
                <span><?=$task->keyword?></span>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <label for="SearchType"> 搜索来路：</label>
                <span><?php switch ($task->intlet){
                        case 1:
                            echo "无线端";break;
                        case 2:
                            echo "电脑端";break;
                        case 3:
                            echo "无线端";break;
                        case 4:
                            echo "无线端";break;
                        case 5:
                            echo "电脑端";break;
                        case 6:
                            echo "无线端";break;
                    }?></span>
            </div>
            <div class="fitem">
                <label for="SearchKey">发货城市：</label>
                <span><?=$task->sendaddress?></span>
                <label for="SearchType">价格区间：</label>
                <span> <?=substr($task->price,0,strrpos($task->price,'^'));?> ~ <?=str_replace('^','',strstr($taskmodel->price,"^"))?></span>
            </div>
            <div class="fitem"  style="margin:5px 0;">
                <label for="SortType">排序方式：</label>
                <span><?php switch ($task->order){
                        case 1: echo '综合'; break;
                        case 2: echo '新品'; break;
                        case 3: echo '人气'; break;
                        case 4: echo '销量'; break;
                        case 5: echo '价格从低到高'; break;
                        case 6: echo '价格从高到低'; break;
                        default:echo '';break;
                    }?></span>
                <label for="OtherSearch">其他搜索：</label>
                <span><?=$task->other?></span>
            </div>
            <div class="fitem">
            </div>
            <div class="ftitle">任务要求</div>
            <div class="fitem">
            </div>
            <div class="fitem"  style="margin:5px 0;">
                <label for="TaskRemark"> 任务备注：</label>
                <textarea readonly="readonly" style="width: 70%; height: 60px; font-size: 14px" ><?=$task->remark?></textarea>
            </div>
             <?php if($taskinfo->status > 1):?>
                <div class="ftitle">快递信息</div>
                <div class="fitem">    
                    <label for="ExpressCompany">物流公司：</label><span><?=substr($taskinfo->expressnum,0,strrpos($taskinfo->expressnum,'&'));?></span>
                    <label for="ExpressNumber">运单编号：</label><span><?=str_replace('&','',strstr($taskinfo->expressnum,"&"))?></span>
                </div>
             <?php endif;?>
            <div class="ftitle">商品信息</div>
            <div class="fitem"  style="margin:5px 0;">
                <label for="FullName">商品全称：</label>
                <span style="width: 500px"><?=$product->commodity_title?></span>
            </div>
            <div class="fitem" style="margin:5px 0;">
                <label for="Url">商品链接：</label>
                <textarea readonly="readonly" style="width: 70%; height: 30px; font-size: 14px"><?=$product->commodity_url?></textarea>
            </div>
            <div class="fitem" style="margin:5px 0;margin-bottom: 20px;">
                <label for="FullName">商品展现图：</label>
                    <a href="<?=$product->commodity_image?>" onclick="javascript:void(0)" target="_blank" title="点击查看原图">
                        <img src="<?=$product->commodity_image?>" style="width: 110px; height:110px;padding:0px;margin:0px;vertical-align:middle;">
                    </a>
            </div>
    </div>



</body>
</html>