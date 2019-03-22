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
    <script src="<?=base_url()?>style/ext/public.js?v=2..0" type="text/javascript"></script>
    <script src="<?=base_url()?>style/ext/jquery.form.js" type="text/javascript"></script>
    <script src="<?=base_url()?>style/laydate.js" type="text/javascript"></script>
    <link type="text/css" rel="stylesheet"
          href="<?=base_url()?>style/laydate.css">
    <link type="text/css" rel="stylesheet"
          href="<?=base_url()?>style/laydate(1).css" id="LayDateSkin">
</head>
<body style="background: #fff;">
    <!--列表 -->
    <!--<div class="htyg_tc">
        <ul>
            <li class="htyg_tc_1" style="font-family: Microsoft YaHei;">创建客服介入工单</li>
            <li class="htyg_tc_2">
			<a href="javascript:void(0)" id="imgeColse" onclick="javascript:self.parent.$.closeWin()">
                <img src="<?=base_url()?>style/images/sj-tc.png"></a> </li>
        </ul>
    </div>-->
    

    <!--<script src="<?=base_url()?>style/jquery-1.8.3.js" type="text/javascript"></script>-->
    <script src="<?=base_url()?>style/md5.js" type="text/javascript"></script>
    <script src="<?=base_url()?>style/Common.js" type="text/javascript"></script>
    
    <script type="text/javascript" src="<?=base_url()?>style/open.win.js"></script>

     <link rel="stylesheet" type="text/css" href="<?=base_url()?>style/weui.css">

    
    <style type="text/css">

    .fpgl-tc-qxjs_6{
        margin-top:5px;
    }
        .sk-hygl_7
        {
            line-height: 35px;
            width: 430px;
        }
        .sk-hygl_7_r
        {
            line-height: 35px;
            width: 120px;
            text-align: right;
        }
        .input-butto100-ls
        {
            background: #4882f0 none repeat scroll 0 0;
            border-radius: 28px;
            color: #fff;
            cursor: pointer;
            height: 28px;
            line-height: 28px;
            padding-left: 0;
            text-align: center;
            width: 128px;
        }
        .wenhao{ background: url(<?=base_url()?>style/images/question.png);float:left;width:16px; height:16px; position:relative; margin:5px 0px 0px 5px; display:block;}
        .wenhao:hover .dis_none{z-index:2; display: block;}
        .dis_none em{background: url(<?=base_url()?>style/images/jiantop.png);width: 7px; height: 13px; left:130px; top:-13px; display:block; position: absolute;}
        .dis_none{color: #222; display:none; padding:10px; border:1px solid #ccc; border-radius:5px; background:#fff; position:absolute; top:25px; left:-130px;  width:220px;}
    </style>
    <script type="text/javascript">

        function openBrowse() {
            document.getElementById("uploadify").click();
            document.getElementById("txtfilename").value = document.getElementById("uploadify").value;
        }


        function Submit($this) {
            //alert('1111');
            var content = $("#txtContent").val();
            var Category1ID = $("#Category1ID").val();
            var Category2ID = $("#Category2ID").val();
            var CheckDate = $("#CheckDate").val();
            var CheckNum = $("#CheckNum").val();
            var PFmoneycount = $("#PFmoneycount").val();
            var file = $("#file").val();
            msg = '';
            if (Category1ID == 0 || Category1ID == null) 
            {
            	return dialog.error('请选择工单类型');
                //msg="请选择工单类型！";
            }else  if (Category2ID == 0 || Category2ID == null)
            {
            	return dialog.error('请选择问题分类');
            	//msg="请选择问题分类！";
            }else if (Category1ID ==46)
            {
                if(CheckNum == 0 || CheckNum == '' ){
                    return dialog.error('被查单数格式错误！');
                }else if (CheckNum > 10000 )
                {
                    return dialog.error('被查单数过高，请联系客服处理！');

                }else if (CheckDate == '')
                {
                    return dialog.error('赔付工单日期不能为空');

                }else if (file == '')
                {
                    if (Category2ID==49){
                        return dialog.error('恶意退款需上传图片');
                    } else {
                        return dialog.error('赔付工单需上传excel表格，具体样式请参考模板');
                    }
                }
            }else if (content.length > 500)
            {
            	return dialog.error('备注说明不能超过500个字符');
            	//msg="备注说明不能超过500个字符！";
            }
            public.ajaxSubmit('err_fm', function(datas){
            	if(datas.status)
            	{
            		dialog.success(datas.message);
            		dialog.iframe_close();
            		var $parent_btn = window.parent.document.getElementById('scheua_' + datas.data);
            		$parent_btn.value = '已提交工单';
            		$parent_btn.style.backgroundColor = '#666';
					$parent_btn.style.cursor = 'text';
            	}
            	else
            	
            	{
            		dialog.error(datas.message);
            	}
            });        
            //alert(msg);
//          if(msg =='' )
//          {
//              $("#fm").submit(); //提交表单
//          }else{
//         	    $.openAlter(msg, "提示");
//         	    //return false;
//          }
            
        }
    </script>
    <style type="text/css">
        #radioDiv input[type='radio']
        {
            margin-bottom: 8px;
        }
    </style>
    <!--添加弹窗 取消任务 -->
<form action="<?=site_url('sales/CreateTaskErrorDB')?>" enctype="multipart/form-data" id="err_fm" method="post">       
 <div style="height: 90%">
            <input data-val="true" data-val-required="任务编号是必须的" id="TaskID" name="TaskID" type="hidden" value="<?=$taskinfo->id?>">
            <div class="yctc_458 ycgl_tc_1" style="margin-top: 10px; width: 520px; overflow-y: auto; font-family: 微软雅黑;">
                <div style="width: 450px;">
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
                </div>
                <div class="errorbox" id="clientValidation" style="display: none; width: 380px; height: 20px;
                    margin-left: 20px">
                    <ol style="list-style-type: decimal" id="clientValidationOL">
                    </ol>
                </div>
                <ul>
					<li class="fpgl-tc-qxjs_6" style="margin-top: 1px;">
                        <p class="sk-hygl_3"><font color="red">注：创建工单最多只能生成赔付工单、普通工单各一个</font></p>
                    </li>
                    <li class="fpgl-tc-qxjs_6" style="margin-top: 1px;">
                        <p class="sk-hygl_7_r">任务编号：</p>
                        <p class="sk-hygl_7" style="width: 150px">
                            <?=$taskinfo->tasksn?>
                        </p>
                    </li>
                    <li class="fpgl-tc-qxjs_6" style="margin-top: 1px">
                        <p class="sk-hygl_7_r">工单类型：</p>
                        <p class="sk-hygl_7" style="width: 150px">
                            <select class="select_215" onchange="changechild(this.options[this.selectedIndex].value)" data-val="true" data-val-required="一级分类是必须的" id="Category1ID" name="Category1ID" style="width:250px">
                            <option value="0">请选择</option>
                            <?php foreach($classify as $vc):?>
                                <?php if($vc->pid == 0):?>
                                    <option value="<?=$vc->id?>"><?=$vc->typename?></option>
                                <?php endif;?>
                            <?php endforeach;?>
                            </select>
                         </p>
                    </li>
                    <li class="fpgl-tc-qxjs_6" style="margin-top: 1px">
                        <p class="sk-hygl_7_r"> 问题分类：</p>
                        <p class="sk-hygl_7" style="width: 250px">
                            <select class="select_215" onchange="changeNum()" data-val="true" data-val-required="二级分类是必须的" id="Category2ID" name="Category2ID" style="width:250px">
                                <option  value="0" >请选择</option>
                            <?php foreach($classify as $vc):?>
                                <?php if($vc->pid != 0):?>
                                    <option class="valhide valshow<?=$vc->pid?>" value="<?=$vc->id?>"><?=$vc->typename?></option>
                                <?php endif;?>
                            <?php endforeach;?>
                            </select></p>
                        <div class="wenhao" id="divwenhao" style="display: none;">
                            <div class="dis_none" id="prompt">
                                <em></em>建议您权衡淘宝客和平台补任务两者的推广效果，<font style="color: red;">不要在发任务期间同时做淘宝推广</font>。对于因为淘宝客问题造成的损失，我们会<u>尽力协助挽回损失</u>，但是<u>不承担赔偿责任</u>。</div>
                        </div>
                    </li>
                    <script>
                     $(".valhide").hide();
                     function changechild(obj){
                        $(".valhide").hide();
                        $("#Category2ID").val('0');
                        $(".valshow"+obj).show();
                         if (obj==46){
                             document.getElementById("ShowDate").style.display="inline";
                             document.getElementById("ShowNum").style.display="inline";
                         }else {
                             document.getElementById("ShowDate").style.display="none";
                             document.getElementById("ShowNum").style.display="none";
                             document.getElementById("PFmoney").style.display="none";
                         }
                     }
                     function  changeNum(){
                         document.getElementById("CheckNum").value = '';
                     }
                     function changePF(){
                            document.getElementById("PFmoney").style.display="inline";
                            var Category2ID  =  document.getElementById("Category2ID").value;
                            var CheckNum  =  document.getElementById("CheckNum").value;
                            if(Category2ID==49){
                                document.getElementById("PFmoneycount").value = '<?=$taskinfo->orderprice?>' * CheckNum;
                                document.getElementById("pattern").innerHTML = '上传图片证据：';
                                document.getElementById("PFupload").innerHTML = '<input type="file" id="file" multiple="multiple" name="multiple[]">';
                                document.getElementById("showcount").innerHTML = "<?=$taskinfo->orderprice?> * "+CheckNum +' = '+<?=$taskinfo->orderprice?> * CheckNum +'元'
                            }else {
                                document.getElementById("PFmoneycount").value = '<?=$taskmodel->commission?>' * CheckNum;
                                document.getElementById("pattern").innerHTML = '上传excel表格：';
                                document.getElementById("PFupload").innerHTML = '<input type="file" id="file" name="multiple[]">';
                                document.getElementById("showcount").innerHTML = "<?=$taskmodel->commission?> * "+CheckNum +' = '+<?=$taskmodel->commission?> * CheckNum +'元'
                            }


                     }
                    </script>
                    <li class="fpgl-tc-qxjs_6"  id='ShowNum' style="margin-top: 1px; display: none ">
                        <p class="sk-hygl_7_r">被查单数：</p>
                        <p class="sk-hygl_7" style="width: 250px">
                            <input onchange="changePF()" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" class="laydate-icon" id="CheckNum"  maxlength="16" autoComplete="off"
                                   name="CheckNum"
                                   style="width: 118px; height: 34px; margin-left: 5px;"
                                   type="text" value=""></p>
                    </li>
                    <li class="fpgl-tc-qxjs_6"  id='ShowDate' style="margin-top: 1px; display: none; float: left ">
                        <p class="sk-hygl_7_r">被查时间：</p>
                        <p class="sk-hygl_7" style="width: 250px">
                            <input class="laydate-icon" id="CheckDate"  maxlength="16" autoComplete="off"
                                   name="CheckDate"
                                   onclick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm:ss'})"
                                   style="width: 118px; height: 34px; margin-left: 5px;"
                                   type="text" value=""></p>
                    </li>
                    <li id="PFmoney" class="fpgl-tc-qxjs_6 " style="display: none">
                        <p class="sk-hygl_7_r" style="color: Red"> 赔付金额：</p>
                        <div>
                            <input  id="PFmoneycount" name="PFmoneycount"   value="" style="display: none">
                            <p id="showcount" class="sjzc_6_tu"  style="margin-left: 2px; margin-top: 8px; width: 360px" value="">
                            </p>
                        </div>
                    </li>
                    <li id="liMsg" class="fpgl-tc-qxjs_6">
                        <p class="sk-hygl_7_r" style="color: Red"> 温馨提示：</p>
                        <div>
                            <p class="sjzc_6_tu" style="margin-left: 2px; margin-top: 8px; width: 360px">
                                可上传1-5张的图片，图片的文件大小请控制在2M以内。订单赔付除了恶意退款必须上传正确格式的excel表格。<br/>
                            </p>
                        </div>
                    </li>
                    <li class="fpgl-tc-qxjs_6" style="margin-top: 1px">
                        <p class="sk-hygl_7_r" id="pattern">上传图片证据：</p>
                        <p class="sk-hygl_7" style="width: 250px" id="PFupload">
                            <input type="file" id="file" multiple="multiple" name="multiple[]"></p>
                    </li>
                    <li class="fpgl-tc-qxjs_6" style="margin-top: 1px">
                        <p class="sk-hygl_7_r">赔付模板：</p>
                        <p class="sk-hygl_7" style="width: 250px">
                            <a href="<?=site_url('sales/DownloadDemo')?>" >点击下载excel格式赔付模板</a></p>
                    </li>
                    <li class="fpgl-tc-qxjs_6">
                        <p class="sk-hygl_7_r" style="margin-top: 5px;">  备注说明：</p>
                        <p>
                            <textarea class="input_44" cols="20" id="txtContent" maxlength="500" name="Content" placeholder="限制输入500个中文字符(选填)" rows="2" style="height: 80px; width: 300px;"></textarea>
                        </p>
                    </li>
                </ul>
            </div>
            <div class="yctc_458 ycgl_tc_1">
                <ul>
                    <li class="fpgl-tc-qxjs_6" style="margin-top: 0px;">
                        <p style="width: 50%;">
                            <input class="input-butto100-hs" type="button" id="btnSubmint" value="确认提交" onclick="Submit(this)" style="float: right; margin-right: 15px;">
                            <input type="hidden" id="submitCnt" value="0">
                        </p>
                        <p style="width: 50%;">
                            <input onclick="dialog.iframe_close(1)" class="input-butto100-ls" type="button" style="height: 35px; float: left; margin-left: -10px;" value="取消"></p>
                    </li>
                </ul>
            </div>
        </div>  
</form>


</body></html>