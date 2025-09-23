function scroll_to(id){
    $('html, body').animate({
        scrollTop: $('#'+id).offset().top
    }, 800);
}
function scroll_to_top(){
    $('html, body').animate({
        scrollTop: $("body").offset().top
    }, 500);
}

function alert_mess_success(_text) {
    $("#alert").fadeIn(200);
    $("#alert").removeClass('alert_success');
    $("#alert").addClass('alert_success');
    $("#alert p").html(_text);
    setTimeout(function(){$("#alert").fadeOut(2000);}, 3000);
}

function alert_mess_failure(_text) {
    $("#alert").fadeIn(200);
    $("#alert").removeClass('alert_success');
    $("#alert p").html(_text);
    setTimeout(function(){$("#alert").fadeOut(2000);}, 3000);
}
$(document).ready(function() {
  var _url = window.location.href.split("/");
  $.ajaxSetup({url:"/"+_url[3]+"/",type:"GET",dataType:"json",cache:false});


  $(".phone").mask("+38 (999) 999-99-99");
  


  $(document).on("click", ".go_to_top", function(e) {
      scroll_to_top();
      return false;
  });


  $(document).on("click", ".restart_test", function(e) {
      window.location.reload();
      return false;
  });
  $(document).on("click", "[data-chapter]", function(e) {
      var _id = $(this).attr('data-chapter');
      
      $('[data-chapter]').removeClass('active');
      $('[data-chapter="'+_id+'"]').addClass('active');
      $('[data-chapter-info]').removeClass('active');
      $('[data-chapter-info="'+_id+'"]').addClass('active');
      return false;
  });

  $(document).on("click", "[data-sign]", function(e) {
        var _id = $(this).attr('data-sign');
        $("#sing_pop").addClass('active');
        $("#shader").fadeIn(300);
        $("body").addClass("body--active");
        $('.sign_info').html($(this).html());
        return false;
  });

  $(document).on("click", "[data-marking]", function(e) {
        var _id = $(this).attr('data-marking');
        $("#sing_pop").addClass('active');
        $("#shader").fadeIn(300);
        $("body").addClass("body--active");
        $('.sign_info').html($(this).html());      
        return false;
  });



  $(document).on("click", "[data-question-id]", function(e) {
        var _id = $(this).attr('data-question-id');        
        $('[data-question-id]').removeClass('active');
        $('[data-question-id="'+_id+'"]').addClass('active');
        $('[data-question-holder-id]').removeClass('active');
        $('[data-question-holder-id="'+_id+'"]').addClass('active');               
        return false;
  });

  function test_result(){

    var _correct_answers = $('.test_navigation_questions .question_nav.correct').length;
    var _incorrect_answers = $('.test_navigation_questions .question_nav.incorrect').length;
    var _total_answers = $('.test_navigation_questions .question_nav').length;
    $('#test_result_pop').addClass('active');
    $('#shader').fadeIn(200);

    var _percent = (_correct_answers/_total_answers*100).toFixed(0);
    $('.policeman_message_percent span').html(_percent);
    $('.policeman_message_correct_answers span').html(_correct_answers);
    $('.policeman_message_incorrect_answers span').html(_incorrect_answers);
  }


    $(document).on("click", "[data-answer-num]", function(e) {
        var _this = $(this);
        var _answer = $(this).attr('data-answer-num');        
        var _question = $(this).attr('data-answer-question');
        var _test_type = $('[data-test-type]').attr('data-test-type'); 
        var _test = $('[data-test]').attr('data-test');      
        if(!$('[data-question-holder-id="'+_question+'"]').hasClass('answered')){
            $.ajax({
                url: location.href,
                data:"ajax=answer&aid="+_answer+"&qid="+_question+"&type="+_test_type+"&test="+_test,
                success:function(json){
                    $('[data-question-holder-id="'+_question+'"]').addClass('answered');
                    if(json.ack == 'Success'){
                      $('[data-question-id="'+_question+'"]').addClass('correct');
                      _this.addClass('correct');
                    }else{
                      $('[data-question-id="'+_question+'"]').addClass('incorrect');
                      _this.addClass('incorrect');
                      $('[data-question-holder-id="'+_question+'"]').find('[data-answer-num="'+json.correct+'"]').addClass('correct');
                    }
                    $('.question_comment').html(json.comment);

                    var _correct_answers = $('.test_navigation_questions .question_nav.correct').length;
                    var _incorrect_answers = $('.test_navigation_questions .question_nav.incorrect').length;
                    $('.test_navigation_result_correct span').html(_correct_answers);
                    $('.test_navigation_result_incorrect span').html(_incorrect_answers);
                 
                        $(".test_body").animate({
                            scrollTop: $(".test_body").prop('scrollHeight')
                        }, 1200);

                    var _unaswers = $('.test_navigation_questions .question_nav:not(.correct):not(.incorrect)').length;
                    if(_unaswers == 0){
                        test_result();
                    }
                }
            });     
        }      
        return false;
    });

    $(document).on("click", ".pass_field > span", function(){
        if($(this).parents('.pass_field').hasClass('active')){
            $(this).parents('.pass_field').removeClass('active');
            $(this).parents('.pass_field').find('input').prop('type', 'password');
        }else{
            $(this).parents('.pass_field').addClass('active');
            $(this).parents('.pass_field').find('input').prop('type', 'text');
        }
        return false;
    });

 
    
    $(document).on("click", ".profile_button", function() {
        $(this).parents('form').submit();
        return false;
    });
    $(document).on("click", ".pwd_button", function() {
        $(this).parents('form').submit();
        return false;
    });

    $(document).on("click", ".login_button", function() {
        $(this).parents('form').submit();
        return false;
    });
    $(document).on("click", ".forget_button", function() {
        $(this).parents('form').submit();
        return false;
    });
    $(document).on("click", ".registration_button", function() {
        $(this).parents('form').submit();
        return false;
    });

    $(document).on('click', '[data-form]', function(){
        var _this = $(this);
        var _form = _this.data('form');

        $('.forms_log').find('form').removeClass('active');
        $('.'+_form).addClass('active');
        return false;
    });

    $(document).on("click", ".next_question", function(e) {
        var _id_now = $(this).parents('[data-question-holder-id]').attr('data-question-holder-id');
        $('.test_navigation_questions').find('[data-question-id="'+_id_now+'"]').next('.question_nav').trigger('click');
        return false;
    });


    $(".input_phone").mask("+38 (999) 999-99-99");


    $(document).on('submit', '.profile_form', function(){
        var _this = $(this),
            _data = _this.serialize();
        $.ajax({
            url: location.href,
            data:"ajax=profile&"+_data,
            success:function(json){
                $('.error_input').removeClass('error_input');
                if(json.ack == 'Failure'){
                    $.each(json.errors, function(key, value){
                        $('[name="'+value+'"]').addClass('error_input');
                    });
                }else{
                    _this.css('display', 'none');
                    _this.next('.profile_thanks_text').fadeIn(200);
                }
            }
        });
        return false;
    });
    $(document).on('submit', '.pwd_form', function(){
        var _this = $(this),
            _data = _this.serialize();
        $.ajax({
            url: location.href,
            data:"ajax=changepwd&"+_data,
            success:function(json){
                $('.error_input').removeClass('error_input');
                if(json.ack == 'Failure'){
                    $.each(json.errors, function(key, value){
                        $('[name="'+value+'"]').addClass('error_input');
                    });
                }else{
                    _this.css('display', 'none');
                    _this.next('.pwd_thanks_text').fadeIn();
                }
            }
        });
        return false;
    });


    $(document).on('submit', '.login_form', function(){
        var _data = $(this).serialize();
        var _this = $(this);
        $.ajax({
            url: location.href,
            data:"ajax=login&"+_data,
            success:function(json){
                $('.error_input').removeClass('error_input');
                if(json.ack == 'Failure'){
                    $.each(json.errors, function(key, value){
                        _this.find('[name="'+value+'"]').addClass('error_input');
                    });
                }else{
                    window.location.replace(json.redirect);
                }
            }
        });

        return false;
    });
 
    $(document).on('submit', '.forget_form', function(){
        var _data = $(this).serialize();
        var _this = $(this);
        $.ajax({
            url: location.href,
            data:"ajax=forget&"+_data,
            success:function(json){
                $('.error_input').removeClass('error_input');
                if(json.ack == 'Failure'){
                    $.each(json.errors, function(key, value){
                        $('[name="'+value+'"]').addClass('error_input');
                    });
                }else{
                    _this.css('display', 'none');
                    _this.next('.thanks_text_forget').fadeIn();
                }
            }
        });

        return false;
    });



    $(document).on('submit', '.registration_form', function(){
        var _data = $(this).serialize();
        var _this = $(this);
        $.ajax({
            url: location.href,
            data:"ajax=registration&"+_data,
            success:function(json){
                $('.error_input').removeClass('error_input');
                if(json.ack == 'Failure'){
                    $.each(json.errors, function(key, value){
                        $('[name="'+value+'"]').addClass('error_input');
                    });
                    if(json.msg.length > 0){
                        alert_mess(json.msg);
                    }
                }else{
                    _this.css('display', 'none');
                    _this.next('.thanks_text_registration').fadeIn();
                    window.location.replace(json.redirect);
                }
            }
        });

        return false;
    });




    $(document).on('submit', '#callback_body', function(){
        var _this = $(this),
            _data = _this.serialize();
        $.ajax({
            url: location.href,
            data:"ajax=callback_body&"+_data,
            success:function(json){
                $('.error_input').removeClass('error_input');
                if(json.ack == 'Failure'){
                    $.each(json.errors, function(key, value){
                        $('[name="'+value+'"]').addClass('error_input');
                    });
                   alert_mess_failure(json.text);
                }else{

                  _this.find('input[type="text"]').val('');
                  alert_mess_success(json.text);
                }
            }
        });
        return false;
    });





    $('.fancybox').fancybox();

    $(document).on("click", ".popup_close , #shader", function(e) {
        $(".popup").removeClass('active');
        $("#shader").fadeOut(300);
        $("body").removeClass("body--active");
    return false;
    });

    $(document).on("click", ".call_login", function(e) {
        $("#login").addClass('active');
        $("#shader").fadeIn(300);
        $("body").addClass("body--active");  
        return false;
    });


    $(document).on('click', '[data-add-favorite]', function(){
        var _this = $(this),
            _id = _this.attr('data-add-favorite');
        if(_this.hasClass('active')){
            $.ajax({
                url: location.href,
                data:"ajax=remove_favorite&id="+_id,
                success:function(json){
                    _this.removeClass('active');
                    if(_this.hasClass('fav_in')){
                        _this.parents('.question').remove();
                    }
                }
            });
        }else{
            $.ajax({
                url: location.href,
                data:"ajax=add_favorite&id="+_id,
                success:function(json){
                    _this.addClass('active');
                }
            });
        }
        return false;
    });

  setTimeout(function(){
    AOS.init();
  },100);
});