<?php require_once('include/header.php')?>      
  
    <script language="javascript" type="text/javascript">
     $(document).ready(function () {
            $("#NewMember").addClass("#NewMember");
              $('.switch').click(function(){
              if($(this).hasClass("switchOn"))
              {
                  $(this).next("label").text("已关闭").css("color","Gray");
           
              }
              else{
                    $(this).next("label").text("已开启").css("color","Blue");
              }
              var id=$(this).attr("id");
              var type=$(this).attr("temp");
              if(type=="tb")
              {
               OpenTbGuest(id);
              }
              if(type=="ct")
              {
               OpenVillage(id);
              }
              $(this).toggleClass("switchOn");
             });
        })
       function OpenTbGuest(id)
       {
           $.post('/Shop/PlatformNo/OpenTbGuest',{id:id},function(data){
 
           });
       }
       function OpenVillage(id)
       {
           $.post('/Shop/PlatformNo/OpenVillage',{id:id},function(data){
 
           });
       }

        //编辑发货人信息
        function editSendInfo(url)
        {
            $.openWin(580, 550,url);
        }

        //提交审核资料
        function editAuditInfo(url)
        {
            $.openWin(730, 550, url);
        }

        function sendNum() {
            var value = $("#PlatformNumber").val();
            var type = $(":radio:checked").val();
            if (value == "") {
                alert("会员名不能为空");
                return;
            }
            $.post('/Shop/PlatformNo/CreateShopNo', { taobaoNum: value, Type: type }, function (result) {

                if (result.StatusCode == "300"/*逻辑异常*/) {
                    if (result.StatusCode == "301"/*登录*/) {
                        return;
                    }
                    else {
                        alert(result.Message);
                    }
                }
                else if (result.StatusCode == "200") {
                    alert(result.Message);
                    location.href = '/Shop/PlatformNo';
                } else {
                    alert(result.Message);
                }
            }, 'json');
        }

        function PageSelectedCallback(page_id, jq) {
            alert(page_id);
            var pre_page = 2;
            if (page_id == -1 || page_id == pre_page) {
                return false;
            }
            else {
                location.href = '/Shop/PlatformNo' + "?page=" + page_id;
            }
        }

        function selectTag(tag, value) {
            if (tag == "tagContent0"){
                window.location="/Shop/PlatformNo/BindPlatform";
            }
            else if (tag == "tagContent1"){
                window.location="/Shop/PlatformNo";
                }
        }

        //查看详情
        function lookDetail(url){
            $.openWin(670, 600, url);
        }

        //绑定店铺
        function createShop(url,height,width){
            $.openWin(height, width, url);
        }

        //删除店铺
        function deleteShop(url,height,width){
            $.openWin(height, width, url);
        }
        //编辑店铺
        function editShop(id){
           $.openWin("320","450", '/Shop/PlatformNo/EditShop?id=' + id);
        }
       
       function auitNotMsg(msg)
       { 
          $.openAlter(" <div  style='word-wrap: break-word;text-align:left'>亲，您绑定的店铺审核不通过，原因：</br><em style='color:red'>"+msg+"</em></br></br><em style=\"color:red\">温馨提示:</em>请根据上方提示进行修改,再次提交审核!</div>","审核不通过原因",{width: 100, height: 50})
       }

       function GetReson(id) {
            $.ajax({
                type:"post",
                url:"/Shop/PlatformNo/GetTYReason",
                data:{id:id},
                dataType:"text",
                error:function(XmlHttpRequest, textStatus, errorThrown)
                {
                    $.openAlter(XmlHttpRequest.responseText, '提示', { width: 250, height: 50 });
                },
                success:function(data)
                {
                    data=eval("("+data+")")
                    if(data.StatusCode=="200")
                    {
                      $.openAlter("<div  style='word-wrap: break-word;text-align:left'>停用原因：</br><em style='color:red'>"+data.Message+"</em></div>", '查看停用原因');

                    }
                    else if(data.StatusCode=="301")
                    {
                $.openAlter('会话超时,请重新登录！', '提示', { width: 250,height: 50 },function () { location.href = "";},"确定");   
                    }
                    else
                    {
                        $.openAlter(data.Message, '提示');
                    }
                }
            })
        }

    </script>

<body style="background: #fff;">
   <?php require_once('include/nav.php')?>  
    <!--daohang-->
    
    <div class="sj-zjgl">
            <div class="zjgl-left">
            <h2 style="background: url(<?=base_url()?>style/images/hygl.png no-repeat 22px 22px;">会员中心</h2>
            <ul>
                <li><a href="<?=site_url('member')?>">基本资料</a></li>
                <li><a href="<?=site_url('member/store')?>" >店铺管理</a></li><!--  选中栏目 -->
                <li><a href="<?=site_url('member/product')?>" style="background: #eee;color: #ff9900;">商品管理</a></li>                
                <li><a href="<?=site_url('member/notice')?>">平台公告</a></li>
                <li><a href="<?=site_url('member/edit')?>" >调整单量</a></li>
                </li>
            </ul>
        </div>        
    <div class="zjgl-right">
        <div class="sk-hygl">
            <ul>
                <li class="hygl-mh">
                    <p class="hygl-mh_1" style="width: 110px;">
                        淘宝店铺：1 个</p>
                    <p>
                        <input onclick="createShop('/Shop/PlatformNo/BindPlatform?platformType=0&amp;s_u_ii=-1&amp;token=6f77',700,550)" class="input-butto100-xls" type="button" value="绑定新店铺"></p>
                </li>
                <li class="hygl-mh">
                    <p class="hygl-mh_1" style="width: 110px;">
                        京东店铺：0 个</p>
                    <p>
                        <input onclick="createShop('/Shop/PlatformNo/BindPlatform?platformType=1&amp;s_u_ii=-1&amp;token=77c2',620,550)" class="input-butto100-xls" type="button" value="绑定新店铺"></p>
                </li>
            </ul>
            <h2 class="fprw-pt">
                已绑定店铺信息<em style="color:Red; font-size:14px">（请根据实际情况标记店铺推广状态，可减少90%以上的淘宝客或农村淘宝佣金损失和纠纷）</em></h2>
            <div class="zjgl-right_2 overfloat-n ">
                <table>
                    <tbody><tr>
                        <th style="width: 15%">
                            店铺名称
                        </th>
                        <th style="width: 10%">
                            所属平台
                        </th>
                        <th style="width: 10%">
                            状态
                        </th>
                        <th style="width: 33%">
                            发货人信息
                        </th>
                        <th style="width: 10%">
                            操作按钮
                        </th>
                        <th style="width: 10%">
                            淘宝客推广
                        </th>
                        <th style="width: 12%">
                            农村淘宝推广
                        </th>
                    </tr>
                        <tr>
                            <td>
                                sandyjack旗舰店
                            </td>
                            <td>
                                淘宝
                                    <p>
                                        (天猫店铺)</p>
                            </td>
                            <td>
启用                            </td>
                            <td>
                                <div style="text-align: left">
                                    姓名：朱鹏</div>
                                <div style="text-align: left">
                                    电话：18627663128</div>
                                <div style="text-align: left; word-break: break-all;">
                                    发货地址：广东省广州市白云区东平老屋前街世纪公寓</div>
                            </td>
                            <td>
                                <div style="padding-bottom: 5px;">
                                    <input class="button-c" type="button" value="删除" onclick="deleteShop('/Shop/PlatformNo/Delete/98cf9150-7a07-4446-876a-2ce62bffb36b?shopName=sandyjack%E6%97%97%E8%88%B0%E5%BA%97&amp;s_u_ii=-1&amp;token=9157';,200,500)"></div>
                                    <div style="padding-bottom: 5px;">
                                        <input onclick="lookDetail('/Shop/PlatformNo/GetPlatformDetail?platformId=98cf9150-7a07-4446-876a-2ce62bffb36b')" class="button-c" type="button" value="查看详情"></div>
                                    <div style="padding-bottom: 5px;">
                                        <input onclick="editSendInfo('/Shop/PlatformNo/editSendInfo?platformId=98cf9150-7a07-4446-876a-2ce62bffb36b')" class="button-c" type="button" value="编辑发货人信息"></div>
                            </td>
                            <td style="text-align: center">
                                     <div class="switch display_block" id="98cf9150-7a07-4446-876a-2ce62bffb36b" temp="tb">
                                        <div class="dis_black_blue">
                                            <em></em>平台将为你避开疑似淘宝客买手
                                        </div>
                                        <div class="dis_black_gray">
                                            <em></em>过滤功能已关闭！
                                        </div>
                                    </div>
                                      <label style="color:Gray">已关闭</label>
                            </td>
                            <td style="text-align: center">
                                         <div class="switch display_block" id="98cf9150-7a07-4446-876a-2ce62bffb36b" temp="ct">
                                        <div class="dis_black_blue">
                                            <em></em>平台将为你避开疑似农村淘宝买手
                                        </div>
                                        <div class="dis_black_gray">
                                            <em></em>过滤功能已关闭！
                                        </div>
                                    </div>
                                      <label style="color:Gray">已关闭</label>
                            </td>
                        </tr>
                </tbody></table>
            </div>
        </div>
    </div>

    </div>

<script language="javascript" type="text/javascript">
$(function(){
 

if(screen.width<1440)
{  
     var height = document.body.clientHeight;  

         $("#onlineService").css("margin-top", "300px"); 
         $("#online_qq_tab").css("margin-top","300px"); 
    // 拖拉事件计算foot div高度  
    $(window).scroll(function () {  
        var scrollDiff = document.body.scrollTop //  拖拉处的位移  
        $("#onlineService").css("margin-top", "300px"); 
         $("#online_qq_tab").css("margin-top","300px"); // 重计算底部位置  
    });  
}
else if(screen.width == 1024){
         $("#onlineService").css("margin-top", "260px"); 
         $("#online_qq_tab").css("margin-top","260px");

            $(window).scroll(function () {  
        var scrollDiff = document.body.scrollTop //  拖拉处的位移  
        $("#onlineService").css("margin-top", "260px"); 
         $("#online_qq_tab").css("margin-top","260px"); // 重计算底部位置  
    });  
 }
 else
 {
  $("#onlineService").css("margin-top", "420px"); 
         $("#online_qq_tab").css("margin-top","420px"); 
    // 拖拉事件计算foot div高度  
    $(window).scroll(function () {  
        var scrollDiff = document.body.scrollTop //  拖拉处的位移  
        $("#onlineService").css("margin-top", "420px"); 
         $("#online_qq_tab").css("margin-top","420px"); // 重计算底部位置  
    });  
 }
          // 拖拉事件计算foot div高度  
 
});


</script>
<?php require_once('include/footer.php')?>  


</body></html>