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
    <!--<script src="<?=base_url()?>style/ext/layer/layer.js" type="text/javascript"></script>-->
	<script src="/style/ext/public.js" type="text/javascript"></script>
	<script src="/style/ext/jquery.form.js" type="text/javascript"></script>
</head>
<body style="background: #fff;">
    <!--列表 -->
    <!--<div class="htyg_tc">
        <ul>
            <li class="htyg_tc_1" style="font-family: Microsoft YaHei;">发布评价任务</li>
            <li class="htyg_tc_2"><a href="javascript:void(0)" id="imgeColse" onclick="javascript:self.parent.$.closeWin()"><img src="<?=base_url()?>style/images/sj-tc.png"></a> </li>
        </ul>
    </div>-->

    <script language="javascript">
        function ok($this) {
//          var msg = '';
//          if ($("#ExpressCompany").val() == '') {
//              msg = "还没有填写快递公司名称", "提示";
//          }
//          if ($("#ExpressNumber").val() == '') {
//              msg = "请填写快递单号", "提示";
//          }
//
//          if (msg != '') {
//              $.openAlter(msg, "提示");
//          } else {
//              $("#fm").submit(); //提交表单
//          }
			$platform = '<?=PLATFORM;?>';
			if($('textarea[name=content]').val().trim() == '' && $("input[name=con_type]:checked").val() != 1)
			{
				return dialog.error('评价内容不能为空');
			}
			if($('input[name=picstatus]:checked').val() == 1 && $('input[type=file]').val() == '')
			{
				return dialog.error('您选择了图片评价,请先上传图片');
			}
			public.ajaxSubmit('fm', function(datas){
				console.log(datas);
				if(datas.status)
				{
					dialog.success(datas.message);
					var index = parent.layer.getFrameIndex(window.name), //先得到当前iframe层的索引
						$parent = window.parent.document,
						$parent_btn = $parent.getElementById("tid_" + datas.data);  //父页面对应新增按钮
						$parent_state = window.parent.document.getElementById("state_" + datas.data);  //父页面对应任务状态
					setTimeout(function(){
						parent.layer.close(index);
					}, 800);
					//更新状态信息显示,避免刷新
					$parent_btn.value = '等待评价';
					$parent_btn.style.backgroundColor = '#666';
					$parent_btn.style.cursor = 'text';
					$parent_state.text = '待评价';
				}
				else
				{
					dialog.error(datas.message);
				}
			});
        }
    </script>
    <style>
    .sk-zjgl_5 {
        margin-top: 0px;
    }
    </style>
<form action="<?=site_url('sales/addEvaluateDB')?>" id="fm" method="post" enctype="multipart/form-data"><style>
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
    <input id="TaskID" name="TaskID" type="hidden" value="<?=$info->tasksn?>">
    <input id="id" name="id" type="hidden" value="<?=$info->id?>">
    <div class=" ycgl_tc_1" style="width: 650px">
            <div class="ycgl_tc_1" style="margin-top: 10px; margin-left: 10px">
                <ul>
                		<li style="margin-top: 10px">
                            <p class="sk-zjgl_4">评价类型：</p>
                            <p style=" line-height: 35px; font-size: 16px;"><input name="con_type" type="radio" value="0" style="border: 1px solid #ccc;width: 25px;height: 25px;line-height: 35px;float: left;" checked> &nbsp; 评价内容</p>
                            <p style=" line-height: 35px; font-size: 16px; padding-left: 15px;"><input name="con_type" type="radio" value="1" style="border: 1px solid #ccc;width: 25px;height: 25px;line-height: 35px;float: left;">  &nbsp; <?=PLATFORM == 'esx' ? '五星好评（直接五星，不用写评语）': '评价要求';?></p>
                        </li>
                        <li style="margin-top: 10px" id="content_li">
                            <p class="sk-zjgl_4"><?=PLATFORM == 'esx' ? '评价内容' : '要求/内容';?>：</p>
                            <p>
                                <textarea name="content" type="text" value="" placeholder="请输入评价<?=PLATFORM == 'esx' ? '内容，买家将直接粘贴复制此内容完成评价' : '要求/内容';?>" style="border: 1px solid #ccc; width: 400px;height: 150px;line-height: 30px;float: left;"></textarea>
                               </p>
                        </li>
                        <li style="margin-top: 10px">
                            <p class="sk-zjgl_4">图片评价：</p>
                            <p style=" line-height: 35px; font-size: 16px;"><input name="picstatus" type="radio" value="1" style="border: 1px solid #ccc;width: 25px;height: 25px;line-height: 35px;float: left;" checked> &nbsp; 是</p>
                            <p style=" line-height: 35px; font-size: 16px; padding-left: 15px;"><input name="picstatus" type="radio" value="0" style="border: 1px solid #ccc;width: 25px;height: 25px;line-height: 35px;float: left;">  &nbsp; 否</p>
                        </li>
                    <div class="multipleinfo">
                        <li class="sk-zjgl_5 " style="margin-top: 10px">
                            <p class="sk-zjgl_4">评价图片：</p>
                            <p ><input name="inputimage[]" type="file" multiple="multiple" style="border: 1px solid #ccc;    width: 300px;    height: 35px;    line-height: 35px;    float: left; vertical-align: middle"></p>
                        </li>
                        <li class="sk-zjgl_5" style="margin-top: 10px">
                            <div class="d1" style="color: red; font-size: 15px; padding: 0 30px 0 20px;">
                                1. 评价类型为【评价内容】时，买家将直接复制”评价内容“列的内容完成评价，并给五星；<br />
                                2. 评价类型为【五星评价】时，要求买家只给五星，无需评语；
                            </div>
                        </li>
                        <li class="sk-zjgl_5" style="margin-top: 10px">
                            <div class="d1" style="color: red; font-size: 12px; padding: 0 30px 0 20px;">
                                温馨提醒：发布图片评价时需提供图片给到买手，请上传给到买手的用于评价的图片（一次性选择多张图片提交保存即可）~
                            </div>
                        </li>
                    </div>
                    <li class="fpgl-tc-qxjs_4">
                        <p>
                            <input class="input-butto100-hs" type="button" value="确定提交" id="btnSubmit" onclick="ok(this)">
                           <input type="hidden" id="submitCnt" value="0">
                        </p>
                        <p>
                            <input onclick="layer.close(layer.index)" class="input-butto100-ls" type="button" value="返回退出" id="bntColse">
                        </p>
                    </li>
                </ul>
            </div>
        </div>
</form>
    <script>
        $(function(){
            $("input[name=picstatus]:radio").click(function(){
                if($(this).val()==1){
                    $(".multipleinfo").slideDown(1000);
                }else{
                    $(".multipleinfo").slideUp(1000);
                }
            });
            <?php if(PLATFORM == 'esx'):?>
            $("input[name=con_type]:radio").click(function(){
                if($(this).val()==0){
                    $("#content_li").slideDown(1000);
                }else{
                    $("#content_li").val('').slideUp(1000);
                }
            });
            <?php endif;?>
        });
    </script>

</body></html>