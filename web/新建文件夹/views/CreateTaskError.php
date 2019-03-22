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
    
</head>
<body style="background: #fff;">
    <!--列表 -->
    <div class="htyg_tc">
        <ul>
            <li class="htyg_tc_1" style="font-family: Microsoft YaHei;">创建客服介入工单</li>
            <li class="htyg_tc_2">
			<a href="javascript:void(0)" id="imgeColse" onclick="javascript:self.parent.$.closeWin()">
                <img src="<?=base_url()?>style/images/sj-tc.png"></a> </li>
        </ul>
    </div>
    

    <script src="<?=base_url()?>style/jquery-1.8.3.js" type="text/javascript"></script>
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


        function Submit() {
            //alert('1111');
            var content = $("#txtContent").val();
            var Category1ID = $("#Category1ID").val();
            var Category2ID = $("#Category2ID").val();
            msg = '';
            if (Category1ID == 0 || Category1ID == null) {
                msg="请选择工单类型！";
            }else  if (Category2ID == 0 || Category2ID == null) {
            	msg="请选择问题分类！";
            }else if (content.length > 500) {
            	msg="备注说明不能超过500个字符！";
            }            
            //alert(msg);
            if(msg =='' ){
                $("#fm").submit(); //提交表单
            }else{
           	    $.openAlter(msg, "提示");
           	    //return false;
            }
            
        }
    </script>
    <style type="text/css">
        #radioDiv input[type='radio']
        {
            margin-bottom: 8px;
        }
    </style>
    <!--添加弹窗 取消任务 -->
<form action="<?=site_url('sales/CreateTaskErrorDB')?>" enctype="multipart/form-data" id="fm" method="post">       
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
                            <select class="select_215" data-val="true" data-val-required="二级分类是必须的" id="Category2ID" name="Category2ID" style="width:250px">
                                <option value="0">请选择</option>                                
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
                     }
                    </script>                    
                    <li id="liMsg" class="fpgl-tc-qxjs_6">
                        <p class="sk-hygl_7_r" style="color: Red"> 温馨提示：</p>
                        <div>
                            <p class="sjzc_6_tu" style="margin-left: 2px; margin-top: 8px; width: 360px">
                                可上传1-5张的图片，图片的文件大小请控制在2M以内。
                            </p>
                        </div>
                    </li>
                    <li class="fpgl-tc-qxjs_6" style="margin-top: 1px">
                        <p class="sk-hygl_7_r">上传证据图片：</p>
                        <p class="sk-hygl_7" style="width: 250px">
                          <input type="file" multiple="multiple" name="multiple[]"></p>
                        
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
                            <input class="input-butto100-hs" type="button" id="btnSubmint" value="确认提交" onclick="Submit()" style="float: right; margin-right: 15px;">
                            <input type="hidden" id="submitCnt" value="0">
                        </p>
                        <p style="width: 50%;">
                            <input onclick="self.parent.$.closeWin()" class="input-butto100-ls" type="button" style="height: 35px; float: left; margin-left: -10px;" value="取消"></p>
                    </li>
                </ul>
            </div>
        </div>  
</form>


</body></html>