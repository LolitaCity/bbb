<!DOCTYPE html>
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title></title>
    <script src="<?=base_url()?>style/jquery-1.8.3.js" type="text/javascript"></script>
    <script src="<?=base_url()?>style/jquery.jslides.js" type="text/javascript"></script>
    <script src="<?=base_url()?>style/open.win.js" type="text/javascript"></script>
    <script src="<?=base_url()?>style/jquery.jBox-2.3.min.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>style/jbox.css">
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>style/common.css">
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>style/index.css">
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>style/open.win.css">
	<script src="<?=base_url()?>style/ext/public.js" type="text/javascript"></script>
    <style>
        .infobox
        {
            background-color: #fff9d7;
            border: 1px solid #e2c822;
            color: #333333;
            padding: 5px;
            padding-left: 30px;
            font-size: 13px;
            --font-weight: bold;
            margin: 0 auto;
            margin-top: 10px;
            margin-bottom: 10px;
            width: 85%;
            text-align: left;
        }
        .errorbox
        {
            background-color: #ffebe8;
            border: 1px solid #dd3c10;
            margin: 0 auto;
            margin-top: 10px;
            margin-bottom: 10px;
            color: #333333;
            padding: 5px;
            padding-left: 30px;
            font-size: 13px;
            --font-weight: bold;
            width: 85%;
        }
    </style>
</head>
<body style="background: #fff;">
    <!--列表 -->
    <!--<div class="htyg_tc">
        <ul>
            <li class="htyg_tc_1" style="font-family: Microsoft YaHei;">修改任务备注</li>
            <li class="htyg_tc_2"><a href="javascript:void(0)" id="imgeColse" onclick="javascript:self.parent.$.closeWin()"><img src="<?=base_url()?>style/images/sj-tc.png"></a></li>
        </ul>
    </div>-->
    
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>style/jbox(1).css">
    <script src="<?=base_url()?>style/jquery.jBox-2.3.min.js" type="text/javascript"></script>
    <script src="<?=base_url()?>style/md5.js" type="text/javascript"></script>

    <!--列表 -->
<form id="fm" action="javascript:;" enctype="multipart/form-data" method="post">
    <input  name="id" type="hidden" value="<?=$info->id?>">
    <input  name="type" type="hidden" value="<?=$info->type?>">
    <input  name="tasksnid" type="hidden" value="<?=$info->tasksn?>">
    <div style="width: 95%">
        </div>  
        <div class="yctc_458 ycgl_tc_1">
            <ul>
                <li>
                    <p class="sk-hygl_7">
                        任务编号：</p>
                    <p class="sk-hygl_7">
                        <label><?=$info->tasksn?></label></p>
                </li>
                <li>
                    <p class="sk-hygl_7">
                        任务备注：</p>
                    <p>
                        <textarea maxlength="100" name="TaskRemark" id="txtRemark" style="height: 60px; width: 300px"><?=$info->remark?></textarea>
                    </p>
                </li>
                <li class="fpgl-tc-qxjs_4">
                    <p>
                        <input class="input-butto100-hs" type="button" value="确定提交" onclick="submitRemark()">
                    </p>
                    <p><input onclick="self.parent.$.closeWin()" class="input-butto100-ls" type="button" value="返回修改"></p>
                </li>
            </ul>
        </div>
</form>
<script>
	
	function submitRemark()
	{
		public.ajax('<?=site_url('sales/remarkDB')?>', $('form#fm').serialize(), function(datas){
			if(datas.status)
			{
				dialog.success(datas.message);
				dialog.iframe_close();
			}
			else
			{
				dialog.error(datas.message);
			}
		});
	}
</script>


</body></html>