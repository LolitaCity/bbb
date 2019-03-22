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
            <li class="htyg_tc_1" style="font-family: Microsoft YaHei;">店铺未来7天可发布数量</li>
            <li class="htyg_tc_2"><a href="javascript:void(0)" id="imgeColse" onclick="javascript:self.parent.$.closeWin()">
                <img src="<?=base_url()?>style/images/sj-tc.png"></a> </li>
        </ul>
    </div>
    
    <div class="fprw-sdsp_2" style="width: 100%">
        <table style="width: 100%">
            <tbody>
                <tr>
                    <th width="182">日期</th>
                    <th width="182">剩余可发布任务数</th>
                </tr>
                <?php for($n=0;$n<7;$n++):?>
                    <?php
                        $daynum=0;
                        foreach($list as $vl)
                        {
                           if($vl->date == @strtotime(@date('Y-m-d',@strtotime("+".$n." day")))){
                               $daynum += $vl->number - $vl->del;
                           }
                        }
                    ?>
                    <tr>
                        <td><?=@date("Y年m月d日",@strtotime("+".$n." day"))?></td>
                        <td><?=($info->maxtask-$daynum)?></td>
                    </tr>  
                <?php endfor;?>          
            </tbody>
        </table>
    </div>
</body>
</html>