// JavaScript Document


$(document).ready(function () {



    //关闭弹框事件

    $('.fb_tjclose').click(function () {


        $('.fb_tjbg, .fb_tjbox').fadeOut(500);
        $("#pwd").val("");

    })



    //表格收缩事件


    $('.fb2_tbaletop a').click(function () {


        if ($(this).hasClass('fb2_icswon')) {

            $(this).removeClass('fb2_icswon');

            $(this).parent().siblings().slideUp(300);

        }
        else {

            $(this).addClass('fb2_icswon');

            $(this).parent().siblings().slideDown(300);

        }

    })




    //价格增加事件

    $(function () {
        var aDlist = '<tr>' +
                        '<td>' + '<input type="text"  placeholder="2">' + '</td>' +
                        '<td>' + '<input type="text"  placeholder="2">' + '</td>' +
                        '<td class="fb2_w15">' + '<a href="javascript:void(0);"  class="fb_detle">删除</a>' + '</td>' +
                  '</tr>';



        $('#jg_add').click(function () {

            $('#fb2_jgtjb').find('tbody').append(aDlist);
        });



    });


    //关键字增加事件

    $(function () {
        var aDlist = '<tr>' +
                        '<td class="fb2_solu">' + '<div class="select" > ' + '<select name="make">' + '<option value="0">PC端天猫</option>' + '</td>' + '<option value="1" selected="">移动端天猫</option>' + '<option value="2">PC端淘宝</option>' + ' <option value="3">移动端淘宝</option>' + '  </select>' + '</div>' + '<td class="fb2_gjz">' + '<input type="text">' + '</td>' + '<td class="fb2_pxfs">' + '<div class="select" > ' + '<select name="make">' + '<option value="0">综合</option>' + '<option value="1" selected="">销量</option>' + '<option value="2">价格</option>' + '<option value="3">人气</option>' + ' </select>' + '</div>' + '</td>' + '<td class="fb2_qt">' + ' <div class="select" >' + ' <select name="make">' + '<option value="0">价格区间</option>' + ' <option value="1">发货地</option>' + '<option value="2">其他</option>' + '</select>' + '</div>' + '<label>' + '<ul class="nno_noe">' + ' <li >' + '<label><input type="text"></label>' + '&nbsp;~&nbsp;' + '<label><input type="text"></label>' + '</li>' + '<li style="display:none" ><input type="text" placeholder="请输入发货地"></li>' + '<li style="display:none" ><input type="text" placeholder="自己输入"></li>' + '  </ul>' + '</label>' + '</td>' + '<td class="fb2_sdsl">' + '<input type="text">' + '</td>' + '<td class="fb2_zhl">' + '<input type="text">' + '</td>' + '<td class="fb2_cz">' + '<a href="javascript:void(0);"  class="fb_detle">删除</a>' + '</td>' + '</tr>';




        $('#gjz_add1').click(function () {

            $('#fb2_gjzb').find('tbody').append(aDlist);
        });



    });







    //			  
    //			  		 //删除事件
    //					 
    //					 $('.fb_detle').live('click',function(){
    //						 
    //						 $(this).parent().parent().remove();
    //						  
    //						 
    //						 })
    //		



});



$(document).ready(function () {


    //弹框事件
    $('.fb_secr').click(function () {


        $('.fb_tjbg, .fb_tjbox').fadeIn(500);

    })

    $('.fb_tjclose').click(function () {


        $('.fb_tjbg, .fb_tjbox').fadeOut(500);
        $('.fb_tjbg1, .fb_tjbox1').fadeOut(500);


    })
});