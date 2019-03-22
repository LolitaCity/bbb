<!DOCTYPE html>
<html><head>
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
    <script src="<?=base_url()?>style/ext/public.js" type="text/javascript"></script>
	<script src="<?=base_url()?>style/ext/jquery.form.js" type="text/javascript"></script>	
    
    <style type="text/css">
        .sk-hygl_7
        {
            width: 100px;
            text-align: right;
            padding-right: 10px;
        }
    </style>

</head>
<body style="background: #fff;">
    <!--列表 -->
    <!--<div class="htyg_tc">
        <ul>
            <li class="htyg_tc_1" style="font-family: Microsoft YaHei;">提交转账凭证信息</li>
            <li class="htyg_tc_2"><a href="javascript:void(0)" id="imgeColse" onclick="javascript:self.parent.$.closeWin()">
                <img src="<?=base_url()?>style/images/sj-tc.png"></a> </li>
        </ul>
    </div>-->
    
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
    <div class="errorbox" id="clientValidation" style="display: none;">
        <ol style="list-style-type: decimal" id="clientValidationOL">
        </ol>
    </div>
<form action="<?=site_url('capital/editTransferDB')?>" id="fm" method="post" enctype="multipart/form-data">  
    <input name='id' value="<?=$info->id?>" type="hidden">      
    <div class="yctc_458 ycgl_tc_1">
            <ul>
                <li>
                    <p class="sk-hygl_7">凭证图片：</p>
                    <p><input data-val="true" data-val-required="凭证图片"  name="fileimage[]" type="file" ></p>
                </li>
                <?php if($info->transferimg!=''):?>
                    <li>
                        <p class="sk-hygl_7">已上传的凭证：</p>
                        <p><img src="<?=$info->transferimg?>" style=" max-width:100%;"></p>
                    </li>  
                <?php endif;?>          
                
                <li class="fpgl-tc-qxjs_6">
                    <p>
                        <b>温馨提示：</b></p>
                    <p>
                        这里上传的凭证图片务必保证真实有效，否则您将会受到平台的惩罚！<br/>
                        若上传新的凭证则会把原来的凭证替换掉！
                    </p>
                </li>
                <li class="fpgl-tc-qxjs_6">
                    <p style="width: 50%;">
                        <input class="input-butto100-hs" type="button" id="btnSubmint" value="提交" onclick="submitFm()"  style="float: right; margin-right: 5px;">
                    </p>
                    <p style="width: 50%;">
                        <input onclick="dialog.iframe_close(10)" class="input-butto100-ls" type="button" style="height: 35px; float: left; margin-left: 5px;" value="返回"></p>
                </li>
            </ul>
        </div>
</form>
<script type="text/javascript">
	function submitFm()
	{
		if(!$("input[name='fileimage[]']").val())
		{
			return dialog.error('请选择凭证图');
		}
		public.ajaxSubmit('fm', function(datas){
			if(datas.status)
			{
				dialog.success(datas.message);
				$('tr#log_' + $('input[name=id]').val(), window.parent.document).remove();	
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