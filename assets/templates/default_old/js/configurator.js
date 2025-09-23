function getPricelist(){
    
    var _outer = $('.conf_outer a.active').attr('data-outer-article');
    var _inner = $('.conf_inner a.active').attr('data-inner-article');
    var _series = $('#series').val();
    var _inner_color = $('.conf_inner a.active').attr('data-inner-color');
    var _outer_color = $('.conf_outer a.active').attr('data-outer-color');

    if(_outer !== undefined && _inner !== undefined){
        $.ajax({
            url:window.location.href, 
            type:'POST', 
            cache:false, 
            data:"ajax=pricelist&article="+_outer+"&articles="+_inner+'&inner_color='+_inner_color+'&outer_color='+_outer_color+'&series='+_series, 
            success:function(_json){
                if(_json.ack == 'Success'){
                    $('.configurator_holder_form_inner').html(_json.products_inner);
                    $('.configurator_holder_form_outer').html(_json.products_outer);
                }else{
                    $('.configurator_holder_form_inner').html('');
                    $('.configurator_holder_form_outer').html('');
                }
        }});
    }

}

function scroll_to_result(){
    $('html, body').animate({
        scrollTop: ($("#res_conf").offset().top-120)
    }, 500);
}

$(document).ready(function(){
    $(window).scroll(function(){

    });
    $(window).resize(function(){
   
    });

    var _url = window.location.href.split("/");
    $.ajaxSetup({url:"/"+_url[3]+"/",type:"GET",dataType:"json",cache:false});



    $(document).on('click', '.conf_outer a',function(){
        var _this = $(this);
        var _img = $(this).attr('data-outer-img');
        $('.conf_outer a').removeClass('active');
        _this.addClass('active');
        $('.conf_result .res_outer img').attr('src',_img);
        getPricelist();
        if($(window).width()<768){
            scroll_to_result();
        }
        return false;
    });

    $(document).on('click', '.conf_inner a',function(){
        var _this = $(this);
        var _single = $(this).attr('data-inner-single');
        var _double = $(this).attr('data-inner-double');
        var _socket = $(this).attr('data-inner-socket');
        $('.conf_inner a').removeClass('active');
        _this.addClass('active');
        $('.conf_result .conf_single .res_inner img').attr('src',_single);
        $('.conf_result .conf_double .res_inner img').attr('src',_double);
        $('.conf_result .conf_socket .res_inner img').attr('src',_socket);
        getPricelist();
        if($(window).width()<768){
            scroll_to_result();
        }
        return false;
    });


    $(document).on('click', '[data-back-color]',function(){
        var _this = $(this);
        var _color = $(this).attr('data-back-color');
        $('.conf_back_selector_holder a').removeClass('active');
        _this.addClass('active');
        $('.conf_back').css('background',_color);
        return false;
    });
    $(document).on('click', '[data-back-img]',function(){
        var _this = $(this);
        var _img = $(this).attr('data-back-img');
        $('.conf_back_selector_holder a').removeClass('active');
        _this.addClass('active');
        $('.conf_back').css('background-image','url('+_img+')');
        return false;
    });

    $('.conf_outer a').first().trigger('click');
    $('.conf_inner a').first().trigger('click');
    $('.conf_back_selector_holder a').first().trigger('click');






});