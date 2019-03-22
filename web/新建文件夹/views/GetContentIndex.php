<?php 
$_SESSION['sellershowcontent']=1;
?>
<html>
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
 </head>
 <style>
.heightinfo{margin: 15px 15px 15px 25px; height:470px; overflow-y:scroll;}
.heightinfo::-webkit-scrollbar {    width: 5px;}/* 滚槽 */
.heightinfo::-webkit-scrollbar-track {  border-radius: 5px;}/* 滚条滑块 */
.heightinfo::-webkit-scrollbar-thumb {    border-radius: 10px;    background: #4882f0;    -webkit-box-shadow: inset 0 0 2px rgba(0,0,0,0.5);}
.heightinfo::-webkit-scrollbar-thumb:window-inactive {    background: rgba(255,0,0,0.4);}
.mybtn input{    
    width: 128px;
    height: 35px;
    background: #4882f0;
    color: #fff;
    text-align: center;
    line-height: 35px;
    cursor: pointer;
    -webkit-border-radius: 35px;
    -moz-border-radius: 35px;
    -ms-border-radius: 35px;
    -o-border-radius: 35px;
    border-radius: 35px;
    padding-left: 0px;
    border:none;
    margin:0 auto;
    outline:none;
}
.mybtn { text-align:center; position:relative;}
 </style>
 <body style="margin:0;"> 
    <p style="font-family: Microsoft YaHei;    line-height: 50px;    padding-left: 15px;    font-size: 16px;    color: #fff;    height: 50px;   background: #4882f0;">平台注意事项</p>
    <div  class="heightinfo">
    <?=$info->goods_desc?>
    </div> 
    <div class="mybtn">
        <input type="button" id="ok" value="确定">
    </div>
    <script>
    var countdown=5; 
    window.onload=function(){  
        var val = document.getElementById("ok");
    	settime(val);
    	val.onclick=function(){
    		parent.document.getElementById("ow001").style.display = "none";
    		parent.document.getElementById("ow002").style.display = "none";
    		//$ifshowcontent = 0;
    		//window.close(); //全屏情况下实现
    	}
    }
    function settime(val) { 
        if (countdown == -1) { 
            val.removeAttribute("disabled");  
            val.style.background="#4882f0"; 
            val.style.cursor="pointer";
            val.value="确定"; 
        } else { 
            val.setAttribute("disabled", true); 
            val.style.background="#222";
            val.style.cursor="unset";
            val.value="确定(" + countdown + ")"; 
            countdown--; 
        } 
        setTimeout(function() { 
            settime(val) 
        },1000) 
    } 
    </script>
 </body>
</html>