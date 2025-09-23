function scroll_to(id) {
  $("html, body").animate(
    {
      scrollTop: $("#" + id).offset().top,
    },
    800
  );
}
function scroll_to_top() {
  $("html, body").animate(
    {
      scrollTop: $("body").offset().top,
    },
    500
  );
}

function alert_mess_success(_text) {
  $("#alert").fadeIn(200);
  $("#alert").removeClass("alert_success");
  $("#alert").addClass("alert_success");
  $("#alert p").html(_text);
  setTimeout(function () {
    $("#alert").fadeOut(2000);
  }, 3000);
}

function alert_mess_failure(_text) {
  $("#alert").fadeIn(200);
  $("#alert").removeClass("alert_success");
  $("#alert p").html(_text);
  setTimeout(function () {
    $("#alert").fadeOut(2000);
  }, 3000);
}

function preloadOn() {
  $("#preload").fadeIn(200);
}

function preloadOff() {
  $("#preload").fadeOut(200);
}

function preloadChatOn() {
  $(".preload_message").fadeIn(200);
  $("#helper").addClass("helper_preload");
}

function preloadChatOff() {
  $(".preload_message").fadeOut(200);
  $("#helper").removeClass("helper_preload");
}

function getCatalogMore() {
  var _page = $("#load_more_page").val();
  var _next = parseInt(_page) + 1;
  $("#load_more_page").val(_next);

  var _category_alias = $("#category_alias").val();

  var _url = new Array();
  $(".catalog_search select").each(function () {
    var _default = $(this).attr("data-default");
    var _val = $(this).val();
    var _name = $(this).attr("name");
    if (_default != _val) {
      _url.push(_name + "-" + _val);
    }
  });

  if ($(window).width() < 992) {
    $(".sort_input_mobile select").each(function () {
      var _default = $(this).attr("data-default");
      var _val = $(this).val();
      var _name = $(this).attr("name");
      if (_default != _val) {
        _url.push(_name + "-" + _val);
      }
    });
  }

  var _search = $(".search_text").val();
  if (_search != "") {
    var _s = "?s=" + _search;
  } else {
    var _s = "";
  }
  if (_url.length > 0) {
    var _urls = _category_alias + _url.join("/") + "/" + _s;
  } else {
    var _urls = _category_alias + _s;
  }
  $.ajax({
    url: window.location.href,
    type: "POST",
    cache: false,
    data: "ajax=catalog_load_more&url=" + _urls + "&load_more=" + _next,
    success: function (_json) {
      if (_json.ack == "Success") {
        $(".js_catalog").append(_json.catalog);
      } else {
        $(".js_catalog").append(_json.catalog);
        $(".load_more").fadeOut(0);
      }

      $(".fancybox").fancybox();
      preloadOff();
    },
  });
}

function getCatalog() {
  var _category_alias = $("#category_alias").val();

  var _url = new Array();
  $(".catalog_search select").each(function () {
    var _default = $(this).attr("data-default");
    var _val = $(this).val();
    var _name = $(this).attr("name");
    if (_default != _val) {
      _url.push(_name + "-" + _val);
    }
  });

  if ($(window).width() < 992) {
    $(".sort_input_mobile select").each(function () {
      var _default = $(this).attr("data-default");
      var _val = $(this).val();
      var _name = $(this).attr("name");
      if (_default != _val) {
        _url.push(_name + "-" + _val);
      }
    });
  }

  var _search = $(".search_text").val();
  if (_search != "") {
    var _s = "?s=" + _search;
  } else {
    var _s = "";
  }
  if (_url.length > 0) {
    window.location.href = _category_alias + _url.join("/") + "/" + _s;
  } else {
    window.location.href = _category_alias + _s;
  }
  return false;
}

function getInstructorsMore() {
  var _page = $("#load_more_page").val();
  var _next = parseInt(_page) + 1;
  $("#load_more_page").val(_next);

  var _category_alias = $("#category_alias").val();

  var _url = new Array();
  $(".instructor_search select").each(function () {
    var _default = $(this).attr("data-default");
    var _val = $(this).val();
    var _name = $(this).attr("name");
    if (_default != _val) {
      _url.push(_name + "-" + _val);
    }
  });

  if ($(window).width() < 992) {
    $(".sort_input_mobile select").each(function () {
      var _default = $(this).attr("data-default");
      var _val = $(this).val();
      var _name = $(this).attr("name");
      if (_default != _val) {
        _url.push(_name + "-" + _val);
      }
    });
  }

  var _search = $(".search_text").val();
  if (_search != "") {
    var _s = "?s=" + _search;
  } else {
    var _s = "";
  }
  if (_url.length > 0) {
    var _urls = _category_alias + _url.join("/") + "/" + _s;
  } else {
    var _urls = _category_alias + _s;
  }
  $.ajax({
    url: window.location.href,
    type: "POST",
    cache: false,
    data: "ajax=instructor_load_more&url=" + _urls + "&load_more=" + _next,
    success: function (_json) {
      if (_json.ack == "Success") {
        $(".js_instructors").append(_json.instructors);
      } else {
        $(".js_instructors").append(_json.instructors);
        $(".load_more").fadeOut(0);
      }

      $(".fancybox").fancybox();
      preloadOff();
    },
  });
}

function getInstructors() {
  var _category_alias = $("#category_alias").val();

  var _url = new Array();
  $(".instructor_search select").each(function () {
    var _default = $(this).attr("data-default");
    var _val = $(this).val();
    var _name = $(this).attr("name");
    if (_default != _val) {
      _url.push(_name + "-" + _val);
    }
  });

  if ($(window).width() < 992) {
    $(".sort_input_mobile select").each(function () {
      var _default = $(this).attr("data-default");
      var _val = $(this).val();
      var _name = $(this).attr("name");
      if (_default != _val) {
        _url.push(_name + "-" + _val);
      }
    });
  }

  var _search = $(".search_text").val();
  if (_search != "") {
    var _s = "?s=" + _search;
  } else {
    var _s = "";
  }
  if (_url.length > 0) {
    window.location.href = _category_alias + _url.join("/") + "/" + _s;
  } else {
    window.location.href = _category_alias + _s;
  }
  return false;
}

$(document).ready(function () {
  var _url = window.location.href.split("/");
  $.ajaxSetup({
    url: "/" + _url[3] + "/",
    type: "GET",
    dataType: "json",
    cache: false,
  });

  if (window.location.hash != "") {
    setTimeout(function () {
      console.log(window.location.hash);
      switch (window.location.hash) {
        case "#restart":
          $(".restart_test").trigger("click");
          break;
        case "#online":
          $("#online_course").trigger("click");
          scroll_to("online_course");
          break;
        case "#freelesson":
          scroll_to("freelesson");
          break;
        case "#payonline":
          scroll_to("payonline");
          break;
        case "#testlesson":
          $(".call_webi_testlesson").trigger("click");
          break;
      }
    }, 500);
  }
  enquire.register("screen and (max-width: 992px)", {
    match: function () {
      $(".footer_menu").appendTo(".footer_block_first");
      $(".footer_subnav").appendTo(".footer_block_first");
      $(".u_holder").appendTo(".mobile_nav");
      $(".nav_menu").appendTo(".mobile_nav");
      $(".test_navigation_result").appendTo(".test_b_holder_top_mobile");
      $(".sort_input").appendTo(".sort_input_mobile");
      $(".instructor_registration").appendTo(".instructor_bottom");

      $(".et_tabs").slick({
        slidesToShow: 2,
        slidesToScroll: 1,
        autoplay: false,
        arrows: true,
        infinite: true,
        dots: true,
        centerMode: true,
        responsive: [
          {
            breakpoint: 600,
            settings: {
              slidesToShow: 1,
              slidesToScroll: 1,
              centerMode: false,
            },
          },
        ],
        nextArrow:
          '<button class="slick-next_arrow slick_arrow" aria-label="Попередня"><svg width="12" height="20" viewBox="0 0 12 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1.71436 18.5714L10.2858 10L1.71436 1.42859" stroke="#1A1A1A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></button>',
        prevArrow:
          '<button class="slick-prev_arrow slick_arrow" aria-label="Наступна"><svg width="12" height="20" viewBox="0 0 12 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M10.2857 1.42856L1.71428 9.99999L10.2857 18.5714" stroke="#1A1A1A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></button>',
      });

      $(".webi_main_sl").slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        autoplay: false,
        arrows: true,
        infinite: true,
        dots: true,
        centerMode: true,
        responsive: [
          {
            breakpoint: 600,
            settings: {
              centerMode: false,
            },
          },
        ],
        nextArrow:
          '<button class="slick-next_arrow slick_arrow" aria-label="Попередня"><svg width="12" height="20" viewBox="0 0 12 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1.71436 18.5714L10.2858 10L1.71436 1.42859" stroke="#1A1A1A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></button>',
        prevArrow:
          '<button class="slick-prev_arrow slick_arrow" aria-label="Наступна"><svg width="12" height="20" viewBox="0 0 12 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M10.2857 1.42856L1.71428 9.99999L10.2857 18.5714" stroke="#1A1A1A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></button>',
      });

      $(".test_navigation_questions").slick({
        slidesToShow: 22,
        slidesToScroll: 22,
        autoplay: false,
        arrows: true,
        infinite: false,
        dots: false,
        nextArrow:
          '<button class="slick-next_arrow slick_arrow" aria-label="Попередня"><svg width="12" height="20" viewBox="0 0 12 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1.71436 18.5714L10.2858 10L1.71436 1.42859" stroke="#1A1A1A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></button>',
        prevArrow:
          '<button class="slick-prev_arrow slick_arrow" aria-label="Наступна"><svg width="12" height="20" viewBox="0 0 12 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M10.2857 1.42856L1.71428 9.99999L10.2857 18.5714" stroke="#1A1A1A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></button>',
        responsive: [
          {
            breakpoint: 1200,
            settings: {
              slidesToShow: 18,
              slidesToScroll: 18,
            },
          },
          {
            breakpoint: 768,
            settings: {
              slidesToShow: 12,
              slidesToScroll: 12,
            },
          },
          {
            breakpoint: 560,
            settings: {
              slidesToShow: 8,
              slidesToScroll: 8,
            },
          },
        ],
      });
    },
    unmatch: function () {
      $(".footer_menu").appendTo(".footer_block_menu");
      $(".nav_menu").appendTo(".nav");
      $(".u_holder").appendTo(".header_right");
      $(".test_navigation_result").appendTo(".test_navigation");
      $(".test_navigation_questions").slick("unslick");
      $(".sort_input").appendTo(".sort_input_desktop");
      $(".instructor_registration").appendTo(".instructor_top");
      $(".et_tabs").slick("unslick");
      $(".webi_main_sl").slick("unslick");
    },
  });

  $("select").chosen();

  $(".phone").mask("+38 (999) 999-99-99");
  $(".input_date").mask("99-99-9999");

  $(".input_time").mask("99:99");

  $(document).on("change", "#change_school", function (e) {
    var _school = $(this).val();

    $.ajax({
      url: location.href,
      data: "ajax=change_school&school=" + _school,
      success: function (json) {
        window.location.reload();
      },
    });
  });

  $(document).on("keyup", ".input_number", function (e) {
    var _num = $(this).val().replace(/\D/g, "");
    $(this).val(_num);
  });

  $(document).on("change", "#e_switch", function () {});

  $("[data-active]").each(function () {
    _ids = $(this).attr("data-active").split(",");
    for (_i in _ids) {
      _option = $(this).find('option[value="' + _ids[_i] + '"]');
      _option.prop("selected", true);
    }
    $(this).trigger("chosen:updated");
  });

  $(document).on("click", "[data-chapter]", function (e) {
    var _id = $(this).attr("data-chapter");

    $("[data-chapter]").removeClass("active");
    $('[data-chapter="' + _id + '"]').addClass("active");
    $("[data-chapter-info]").removeClass("active");
    $('[data-chapter-info="' + _id + '"]').addClass("active");
    return false;
  });
  $(document).on("click", ".go_to_top", function (e) {
    scroll_to_top();
    return false;
  });

  $(document).on("click", ".restart_test", function (e) {
    var _url = window.location.href.replace("#restart", "");
    var _type = $(".test_body").attr("data-test-type");
    var _test = $(".test_body").attr("data-test");
    if (_test && _type) {
      $.ajax({
        url: location.href,
        data: "ajax=restart_test&type=" + _type + "&test=" + _test,
        success: function (json) {
          window.location.replace(_url);
        },
      });
    } else {
      window.location.replace(_url);
    }
    return false;
  });

  $(document).on("click", ".instructor_filter_call", function (e) {
    if ($(".instructor_search").hasClass("active")) {
      $(".instructor_search").removeClass("active");
    } else {
      $(".instructor_search").addClass("active");
    }
    return false;
  });

  $(document).on("click", ".pdr_i_head", function (e) {
    if ($(this).parents(".tpl_pdr_i").hasClass("active")) {
      $(this).parents(".tpl_pdr_i").removeClass("active");
    } else {
      $(this).parents(".tpl_pdr_i").addClass("active");
    }
    return false;
  });

  $(document).on("click", ".instructor_comment_head", function (e) {
    if ($(this).parents(".instructor_comment").hasClass("active")) {
      $(this).parents(".instructor_comment").removeClass("active");
    } else {
      $(this).parents(".instructor_comment").addClass("active");
    }
    return false;
  });

  $(document).on("click", ".personal_cabinet_nav", function (e) {
    if ($(this).parents(".tpl_personal_cabinet").hasClass("active")) {
      $(this).parents(".tpl_personal_cabinet").removeClass("active");
    } else {
      $(this).parents(".tpl_personal_cabinet").addClass("active");
    }
    return false;
  });

  $(document).on("click", ".road_sign_nav", function (e) {
    if ($(this).parents(".road_sign_block").hasClass("active")) {
      $(this).parents(".road_sign_block").removeClass("active");
    } else {
      $(this).parents(".road_sign_block").addClass("active");
    }
    return false;
  });

  $(document).on("click", ".content_accordion > ul > li", function (e) {
    if ($(this).hasClass("active")) {
      $(this).removeClass("active");
    } else {
      $(this).addClass("active");
    }
    return false;
  });

  $(document).on("click", ".nav_menu .nav_top .open_m", function (e) {
    if (
      $(this).parent().parent().find("ul").length > 0 &&
      $(window).width() < 992
    ) {
      if ($(this).parent().parent().hasClass("active")) {
        $(this).parent().parent().removeClass("active");
      } else {
        $(this).parent().parent().addClass("active");
      }
      return false;
    }
  });

  $(document).on("click", "[data-sign-view]", function (e) {
    var _id = $(this).attr("data-sign-view");

    $.ajax({
      url: location.href,
      data: "ajax=sign_view&id=" + _id,
      success: function (json) {
        if (json["ack"] == "Success") {
          $("#sing_pop").addClass("active");
          $("#shader").fadeIn(300);
          $("body").addClass("body--active");
          $(".sign_info").html(json.sign);
        } else {
          alert_mess_failure("Помилка, знак не знайдено");
        }
      },
    });

    return false;
  });

  $(document).on("click", "[data-marking-view]", function (e) {
    var _id = $(this).attr("data-marking-view");
    $.ajax({
      url: location.href,
      data: "ajax=marking_view&id=" + _id,
      success: function (json) {
        if (json["ack"] == "Success") {
          $("#sing_pop").addClass("active");
          $("#shader").fadeIn(300);
          $("body").addClass("body--active");
          $(".sign_info").html(json.marking);
        } else {
          alert_mess_failure("Помилка, розмітку не знайдено");
        }
      },
    });
    return false;
  });

  $(document).on("click", "[data-sign]", function (e) {
    var _id = $(this).attr("data-sign");
    $("#sing_pop").addClass("active");
    $("#shader").fadeIn(300);
    $("body").addClass("body--active");
    $(".sign_info").html($(this).html());
    return false;
  });

  $(document).on("click", "[data-marking]", function (e) {
    var _id = $(this).attr("data-marking");
    $("#sing_pop").addClass("active");
    $("#shader").fadeIn(300);
    $("body").addClass("body--active");
    $(".sign_info").html($(this).html());
    return false;
  });

  $(document).on("click", "[data-question-id]", function (e) {
    var _id = $(this).attr("data-question-id");
    $("[data-question-id]").removeClass("active");
    $('[data-question-id="' + _id + '"]').addClass("active");
    $("[data-question-holder-id]").removeClass("active");
    $('[data-question-holder-id="' + _id + '"]').addClass("active");
    setTimeout(function () {
      $(".trigger_add_favorite").attr("data-aos", "");
    }, 500);
    return false;
  });
  function block_test() {
    $("#continue_pop").addClass("active");
    $("#shader").fadeIn(300);
    $("body").addClass("body--active");
    $(".menu_nav").removeClass("active");
    $(".mobile_nav").removeClass("active");
    $("#shader_nav").fadeOut(300);
    $('[data-form="login_form"]').trigger("click");
    var _top = $(window).height() / 2 - $("#continue_pop").height() / 2;
    $("#continue_pop").css("top", _top + "px");
    $(".test_b_holder_side_left").addClass("blocked");
    $(".test_b_holder_side_right").addClass("blocked");
    $(".test_b_holder").addClass("call_continue");
  }

  function test_result() {
    var _correct_answers = $(
      ".test_navigation_questions .question_nav.correct"
    ).length;
    var _incorrect_answers = $(
      ".test_navigation_questions .question_nav.incorrect"
    ).length;
    var _total_answers = $(".test_navigation_questions .question_nav").length;

    $("#test_result_pop").addClass("active");
    $("#shader").fadeIn(200);

    var _percent = ((_correct_answers / _total_answers) * 100).toFixed(0);
    $(".policeman_message_percent span").html(_percent);
    $(".policeman_message_correct_answers span").html(_correct_answers);
    $(".policeman_message_incorrect_answers span").html(_incorrect_answers);

    $(".policeman_message_theme").html($(".block_title").html());

    if ($(".test_b_holder").hasClass("test_isput")) {
      if (_incorrect_answers > 2) {
        $(".policeman_message_percent").addClass(
          "policeman_message_percent_negative"
        );
        $(".policeman_message_percent").html("Тест не складено");
        var _status = 0;
      } else {
        $(".policeman_message_percent").addClass(
          "policeman_message_percent_positive"
        );
        $(".policeman_message_percent").html("Тест успішно складено");
        var _status = 1;
      }
      var _correct_answers = $(
        ".test_navigation_questions .question_nav.correct"
      ).length;
      var _incorrect_answers = $(
        ".test_navigation_questions .question_nav.incorrect"
      ).length;
      var _time = $(".timer_u").html();

      $.ajax({
        url: location.href,
        data:
          "ajax=end_isput&correct=" +
          _correct_answers +
          "&incorrect=" +
          _incorrect_answers +
          "&time=" +
          _time +
          "&status=" +
          _status,
        success: function (json) {},
      });
    } else {
      var _rait = _incorrect_answers / _total_answers;
      if (_rait > 0.1) {
        $(".policeman_message_percent").addClass(
          "policeman_message_percent_negative"
        );
        $(".policeman_message_percent").append(" - Тест не складено");
      } else {
        $(".policeman_message_percent").addClass(
          "policeman_message_percent_positive"
        );
        $(".policeman_message_percent").append(" - Тест успішно складено");
      }
    }
  }

  $(document).on("click", ".trigger_add_favorite", function (e) {
    $(".question.active").find(".add_favorite_hidden").trigger("click");
    $(".trigger_add_favorite").attr("data-aos", "fade-down");

    return false;
  });

  $(document).on("click", ".call_reg_master", function (e) {
    $("#master_pop").addClass("active");
    $("#shader").fadeIn(300);
    $("body").addClass("body--active");
    return false;
  });

  $(document).on("click", "[data-reg-webi]", function (e) {
    var _id = $(this).attr("data-reg-webi");
    $("#webi_pop").addClass("active");
    $("#shader").fadeIn(300);
    $("body").addClass("body--active");
    $("#webid").val(_id);
    return false;
  });

  $(document).on("submit", ".test2_form", function () {
    var _this = $(this),
      _data = _this.serialize();
    $.ajax({
      url: location.href,
      beforeSend: function () {
        preloadOn();
      },
      data: "ajax=test2&" + _data,
      success: function (json) {
        preloadOff();
        $(".error_input").removeClass("error_input");
        if (json.ack == "Failure") {
          $.each(json.errors, function (key, value) {
            $('[name="' + value + '"]').addClass("error_input");
          });
          if (json.msg.length > 0) {
            alert_mess_failure(json.msg);
          }
        } else {
          _this.css("display", "none");
          _this.next(".form_success").html(json.form_success);
          _this.next(".form_success").fadeIn(200);
        }
      },
    });
    return false;
  });

  $(document).on("submit", ".webi_in_form", function () {
    var _this = $(this),
      _data = _this.serialize();
    $.ajax({
      url: location.href,
      beforeSend: function () {
        preloadOn();
      },
      data: "ajax=webi_in&" + _data,
      success: function (json) {
        preloadOff();
        $(".error_input").removeClass("error_input");
        if (json.ack == "Failure") {
          $.each(json.errors, function (key, value) {
            $('[name="' + value + '"]').addClass("error_input");
          });
          if (json.msg.length > 0) {
            alert_mess_failure(json.msg);
          }
        } else {
          _this.css("display", "none");
          _this.next(".form_success").html(json.form_success);
          _this.next(".form_success").fadeIn(200);
        }
      },
    });
    return false;
  });

  $(document).on("submit", ".master_form", function () {
    var _this = $(this),
      _data = _this.serialize();
    $.ajax({
      url: location.href,
      beforeSend: function () {
        preloadOn();
      },
      data: "ajax=master&" + _data,
      success: function (json) {
        preloadOff();
        $(".error_input").removeClass("error_input");
        if (json.ack == "Failure") {
          $.each(json.errors, function (key, value) {
            $('[name="' + value + '"]').addClass("error_input");
          });
          if (json.msg.length > 0) {
            alert_mess_failure(json.msg);
          }
        } else {
          if (json.registration) {
            dataLayer.push({
              event: "registration_master",
            });
          }
          fbq("track", "Lead");

          _this.css("display", "none");
          window.location.replace(json.redirect);
        }
      },
    });
    return false;
  });

  $(document).on("submit", ".webi_form", function () {
    var _this = $(this),
      _data = _this.serialize();
    $.ajax({
      url: location.href,
      beforeSend: function () {
        preloadOn();
      },
      data: "ajax=webi&" + _data,
      success: function (json) {
        preloadOff();
        $(".error_input").removeClass("error_input");
        if (json.ack == "Failure") {
          $.each(json.errors, function (key, value) {
            $('[name="' + value + '"]').addClass("error_input");
          });
          if (json.msg.length > 0) {
            alert_mess_failure(json.msg);
          }
        } else {
          if (json.registration) {
            dataLayer.push({
              event: "registration_webi",
            });
          }

          _this.css("display", "none");
          _this.next(".form_success").html(json.form_success);
          _this.next(".form_success").fadeIn(200);
        }
      },
    });
    return false;
  });

  if ($("[data-order-id]").length > 0) {
    var _id = $("[data-order-id]").attr("data-order-id");
    if (_id) {
      setInterval(function () {
        if ($("[data-order-id]").length > 0) {
          $.ajax({
            type: "POST",
            url: location.href,
            data: "ajax=status_check&order=" + _id,
            success: function (json) {
              $(".status_check_h").html(json.status_check);
            },
          });
        }
      }, 3000);
    }
  }
  if ($("[data-order-id-v]").length > 0) {
    var _id = $("[data-order-id-v]").attr("data-order-id-v");
    if (_id) {
      setInterval(function () {
        if ($("[data-order-id-v]").length > 0) {
          $.ajax({
            type: "POST",
            url: location.href,
            data: "ajax=status_check_v&order=" + _id,
            success: function (json) {
              $(".status_check_hv").html(json.status_check_v);
            },
          });
        }
      }, 3000);
    }
  }

  if ($("[data-order-id-s]").length > 0) {
    var _id = $("[data-order-id-s]").attr("data-order-id-s");
    if (_id) {
      setInterval(function () {
        if ($("[data-order-id-s]").length > 0) {
          $.ajax({
            type: "POST",
            url: location.href,
            data: "ajax=status_check_s&order=" + _id,
            success: function (json) {
              $(".status_check_h").html(json.status_check);
            },
          });
        }
      }, 3000);
    }
  }

  $(document).on("change", "#promo", function (e) {
    if ($(this).prop("checked")) {
      $(".promo_holder_h").addClass("active");
    } else {
      $(".promo_holder_h").removeClass("active");
    }
    return false;
  });

  $(document).on("click", ".check_promocode", function (e) {
    var _promocode = $("#promocode").val();
    $.ajax({
      url: location.href,
      beforeSend: function () {
        preloadOn();
      },
      data: "ajax=promocode&promo=" + _promocode,
      success: function (json) {
        preloadOff();
        $(".error_input").removeClass("error_input");
        if (json.ack == "Failure") {
          $.each(json.errors, function (key, value) {
            $('[name="' + value + '"]').addClass("error_input");
          });
          if (json.msg.length > 0) {
            alert_mess_failure(json.msg);
          }
          $(".price_mid").html(json.price_mid);
        } else {
          $(".ac_promo").addClass("ac_filed");
          $(".price_mid").html(json.price_mid);
          if (json.msg.length > 0) {
            alert_mess_success(json.msg);
          }
        }
      },
    });
    return false;
  });

  $(document).on("click", ".call_review", function (e) {
    $("#review_pop").addClass("active");
    $("#shader").fadeIn(300);
    $("body").addClass("body--active");

    return false;
  });

  $(document).on("submit", ".review_form", function () {
    var _this = $(this),
      _data = _this.serialize();
    $.ajax({
      url: location.href,
      beforeSend: function () {
        preloadOn();
      },
      data: "ajax=review&" + _data,
      success: function (json) {
        preloadOff();
        $(".error_input").removeClass("error_input");
        if (json.ack == "Failure") {
          $.each(json.errors, function (key, value) {
            $('[name="' + value + '"]').addClass("error_input");
          });
          if (json.msg != "") {
            alert_mess_failure(json.msg);
          }
        } else {
          _this.css("display", "none");
          _this.next(".thanks_text_recall").fadeIn(200);
        }
      },
    });
    return false;
  });

  $(document).on("click", "[data-buy]", function (e) {
    var _product_id = $(this).attr("data-buy");
    var _count = $(this).attr("data-count");
    $.ajax({
      url: location.href,
      beforeSend: function () {
        preloadOn();
      },
      data: "ajax=fastbuy_form&product_id=" + _product_id + "&count=" + _count,
      success: function (json) {
        preloadOff();
        if (json.ack == "Success") {
          $("#fastbuy_pop").addClass("active");
          $("#shader").fadeIn(300);
          $("body").addClass("body--active");
          $("#fastbuy_pop .fastbuy_product").html(json.product);
        } else {
          alert_mess_failure("Щось пішло не так, зверніться до адміністратора");
        }
      },
    });
    return false;
  });

  $(document).on("submit", ".fastbuy_form", function () {
    var _this = $(this),
      _data = _this.serialize();
    $.ajax({
      url: location.href,
      beforeSend: function () {
        preloadOn();
      },
      data: "ajax=fastbuy&" + _data,
      success: function (json) {
        preloadOff();
        $(".error_input").removeClass("error_input");
        if (json.ack == "Failure") {
          $.each(json.errors, function (key, value) {
            $('[name="' + value + '"]').addClass("error_input");
          });
          if (json.msg.length > 0) {
            alert_mess_failure(json.msg);
          }
        } else {
          if (json.registration) {
            dataLayer.push({
              event: "fastbuy",
            });
          }
          _this.css("display", "none");
          //window.location.replace(json.redirect);

          $("#fastbuy_pop .pay_form").html(json.payform);
          $("#fastbuy_pop .pay_form form").submit();
        }
      },
    });
    return false;
  });

  $(document).on("click", ".go_city_form", function (e) {
    $("#city_form_pop").addClass("active");
    $("#shader").fadeIn(300);
    $("body").addClass("body--active");
    return false;
  });
  $(document).on("submit", ".city_form", function () {
    var _this = $(this),
      _data = _this.serialize();
    $.ajax({
      url: location.href,
      beforeSend: function () {
        preloadOn();
      },
      data: "ajax=city_form&" + _data,
      success: function (json) {
        preloadOff();
        $(".error_input").removeClass("error_input");
        if (json.ack == "Failure") {
          $.each(json.errors, function (key, value) {
            $('[name="' + value + '"]').addClass("error_input");
          });
          if (json.msg.length > 0) {
            alert_mess_failure(json.msg);
          }
        } else {
          if (json.registration) {
            dataLayer.push({
              event: "registration_city",
            });
          }
          dataLayer.push({
            event: "city_form",
          });
          fbq("track", "Lead");
          _this.css("display", "none");
          _this.next(".form_success").fadeIn(0);
        }
      },
    });
    return false;
  });

  $(document).on("click", ".go_pay_online", function (e) {
    $("#online_pop").addClass("active");
    $("#shader").fadeIn(300);
    $("body").addClass("body--active");
    return false;
  });

  $(document).on("click", ".call_video_online", function (e) {
    $(".pay_online_video").addClass("active");
    $("#shader").fadeIn(300);
    $("body").addClass("body--active");
    setTimeout(function () {
      $("#online_pop").addClass("active");
      $(".pay_online_video").removeClass("active");
    }, 85000);
    return false;
  });

  $(document).on("submit", ".smart_form", function () {
    var _this = $(this),
      _data = _this.serialize();
    $.ajax({
      url: location.href,
      beforeSend: function () {
        preloadOn();
      },
      data: "ajax=buyvideo&" + _data,
      success: function (json) {
        preloadOff();
        $(".error_input").removeClass("error_input");
        if (json.ack == "Failure") {
          $.each(json.errors, function (key, value) {
            $('[name="' + value + '"]').addClass("error_input");
          });
          if (json.msg.length > 0) {
            alert_mess_failure(json.msg);
          }
        } else {
          if (json.registration) {
            dataLayer.push({
              event: "registration_smart",
            });
          }
          if (json.event) {
            dataLayer.push({
              event: json.event,
            });
          }
          fbq("track", "Lead");
          _this.css("display", "none");
          //window.location.replace(json.redirect);

          $("#pay_form").html(json.payform);
          $("#pay_form form").submit();
        }
      },
    });
    return false;
  });

  $(document).on("submit", ".online_form", function () {
    var _this = $(this),
      _data = _this.serialize();
    $.ajax({
      url: location.href,
      beforeSend: function () {
        preloadOn();
      },
      data: "ajax=online&" + _data,
      success: function (json) {
        preloadOff();
        $(".error_input").removeClass("error_input");
        if (json.ack == "Failure") {
          $.each(json.errors, function (key, value) {
            $('[name="' + value + '"]').addClass("error_input");
          });
          if (json.msg.length > 0) {
            alert_mess_failure(json.msg);
          }
        } else {
          if (json.registration) {
            dataLayer.push({
              event: "registration_online",
            });
          }
          if (json.event) {
            // dataLayer.push({
            //   event: json.event,
            // });
          }
          // fbq("track", "Lead");
          _this.css("display", "none");
          //window.location.replace(json.redirect);

          $("#pay_form").html(json.payform);
          $("#pay_form form").submit();
        }
      },
    });
    return false;
  });

  $(document).on("click", ".subscribe_continue", function (e) {
    $.ajax({
      url: location.href,
      data: "ajax=subscribe_continue",
      success: function (json) {
        if (json.ack == "Success") {
          window.location.reload();
        } else {
          $.ajax({
            url: location.href,
            data: "ajax=subscribe_pay",
            success: function (json) {
              $("#subscribe_pay_form").html(json.payform);
              $("#subscribe_pay_form form").submit();
            },
          });
        }
      },
    });
    return false;
  });

  $(document).on("click", ".subscribe_regpay", function (e) {
    $("#regpay_pop").addClass("active");
    $("#shader").fadeIn(300);
    $("body").addClass("body--active");
    $("#continue_pop").removeClass("active");
    return false;
  });

  $(document).on("submit", ".regpay_form", function () {
    var _this = $(this),
      _data = _this.serialize();
    $.ajax({
      url: location.href,
      beforeSend: function () {
        preloadOn();
      },
      data: "ajax=regpay&" + _data,
      success: function (json) {
        preloadOff();
        $(".error_input").removeClass("error_input");
        if (json.ack == "Failure") {
          $.each(json.errors, function (key, value) {
            $('[name="' + value + '"]').addClass("error_input");
          });
          if (json.msg.length > 0) {
            alert_mess_failure(json.msg);
          }
        } else {
          fbq("track", "Lead");
          if (json.registration) {
            dataLayer.push({
              event: "registration_online",
            });
          }
          _this.css("display", "none");
          //window.location.replace(json.redirect);

          $("#pay_form").html(json.payform);
          $("#pay_form form").submit();
        }
      },
    });
    return false;
  });

  $(document).on("click", ".subscribe_edit", function (e) {
    $.ajax({
      url: location.href,
      data: "ajax=subscribe_edit",
      success: function (json) {
        window.location.reload();
      },
    });
    return false;
  });

  $(document).on("click", ".subscribe_pause", function (e) {
    $.ajax({
      url: location.href,
      data: "ajax=subscribe_pause",
      success: function (json) {
        window.location.reload();
      },
    });
    return false;
  });

  $(document).on("click", ".subscribe_cancel", function (e) {
    $.ajax({
      url: location.href,
      data: "ajax=subscribe_cancel",
      success: function (json) {
        window.location.reload();
      },
    });
    return false;
  });

  $(document).on("click", ".subscribe_new", function (e) {
    $.ajax({
      url: location.href,
      data: "ajax=subscribe_new",
      success: function (json) {
        $("#subscribe_pay_form").html(json.payform);
        $("#subscribe_pay_form form").submit();
      },
    });
    return false;
  });

  $(document).on("click", ".subscribe_pay", function (e) {
    $.ajax({
      url: location.href,
      data: "ajax=subscribe_pay",
      success: function (json) {
        $("#subscribe_pay_form").html(json.payform);
        $("#subscribe_pay_form form").submit();
      },
    });
    return false;
  });

  $(document).on("click", ".question_comment_call", function (e) {
    var _id = $(this).attr("data-question-comment-call");
    $.ajax({
      url: location.href,
      data: "ajax=question_comment&id=" + _id,
      success: function (json) {
        $(".sign_info").html(json.comment);
        $("#sing_pop").addClass("active");
        $("#shader").fadeIn(200);
      },
    });
    return false;
  });

  $(document).on("click", "[data-answer-num]", function (e) {
    var _this = $(this);
    var _answer = $(this).attr("data-answer-num");
    var _question = $(this).attr("data-answer-question");
    var _test_type = $("[data-test-type]").attr("data-test-type");
    var _test = $("[data-test]").attr("data-test");
    if (
      !$('[data-question-holder-id="' + _question + '"]').hasClass("answered")
    ) {
      $.ajax({
        url: location.href,
        data:
          "ajax=answer&aid=" +
          _answer +
          "&qid=" +
          _question +
          "&type=" +
          _test_type +
          "&test=" +
          _test,
        success: function (json) {
          $('[data-question-holder-id="' + _question + '"]').addClass(
            "answered"
          );
          if (json.ack == "Success") {
            $('[data-question-id="' + _question + '"]').addClass("correct");
            _this.addClass("correct");
          } else {
            $('[data-question-id="' + _question + '"]').addClass("incorrect");
            _this.addClass("incorrect");
            $('[data-question-holder-id="' + _question + '"]')
              .find('[data-answer-num="' + json.correct + '"]')
              .addClass("correct");
          }
          //$('.question_comment').html(json.comment);

          var _correct_answers = $(
            ".test_navigation_questions .question_nav.correct"
          ).length;
          var _incorrect_answers = $(
            ".test_navigation_questions .question_nav.incorrect"
          ).length;
          $(".test_navigation_result_correct span").html(_correct_answers);
          $(".test_navigation_result_incorrect span").html(_incorrect_answers);

          $(".test_body").animate(
            {
              scrollTop: $(".test_body").prop("scrollHeight"),
            },
            1200
          );

          var _id_now = parseInt(
            _this
              .parents("[data-question-holder-id]")
              .attr("data-question-holder-id")
          );
          var _index = $(".test_navigation_questions")
            .find('[data-question-id="' + _id_now + '"]')
            .parents("slick-slide")
            .index();
          /*
                    $('.test_navigation_questions').slick('slickGoTo', _index);
                    */

          var _allaswers = $(".test_navigation_questions .question_nav").length;
          var _max_a = Math.round(_allaswers * 0.3) - 1;
          var _correct_answers = $(
            ".test_navigation_questions .question_nav.correct"
          ).length;
          var _incorrect_answers = $(
            ".test_navigation_questions .question_nav.incorrect"
          ).length;
          var _total_answers = _correct_answers + _incorrect_answers;

          if (!json.premium && _total_answers > _max_a) {
            block_test();
          }

          var _unaswers = $(
            ".test_navigation_questions .question_nav:not(.correct):not(.incorrect)"
          ).length;
          if (_unaswers == 0) {
            test_result();
          }
          if (_test_type == 3 && _incorrect_answers > 2) {
            test_result();
          }
        },
      });
    }
    return false;
  });

  $(document).on("click", ".pass_field > span", function () {
    if ($(this).parents(".pass_field").hasClass("active")) {
      $(this).parents(".pass_field").removeClass("active");
      $(this).parents(".pass_field").find("input").prop("type", "password");
    } else {
      $(this).parents(".pass_field").addClass("active");
      $(this).parents(".pass_field").find("input").prop("type", "text");
    }
    return false;
  });

  $(document).on("click", ".faq_name", function () {
    if ($(this).parents(".faq_tpl").hasClass("active")) {
      $(this).parents(".faq_tpl").removeClass("active");
    } else {
      $(this).parents(".faq_tpl").addClass("active");
    }
    return false;
  });

  $(document).on("click", ".why_tab_top", function () {
    if ($(this).parents(".why_tab").hasClass("active")) {
      $(this).parents(".why_tab").removeClass("active");
    } else {
      $(this).parents(".why_tab").addClass("active");
    }
    return false;
  });

  $(document).on("click", ".add_recall", function () {
    $(this).parents("form").submit();
    return false;
  });

  $(document).on("click", ".instructor_setting_button", function () {
    $(this).parents("form").submit();
    return false;
  });
  $(document).on("click", ".profile_setting_button", function () {
    $(this).parents("form").submit();
    return false;
  });
  $(document).on("click", ".profile_button", function () {
    $(this).parents("form").submit();
    return false;
  });
  $(document).on("click", ".pwd_button", function () {
    $(this).parents("form").submit();
    return false;
  });

  $(document).on("click", ".login_button", function () {
    $(this).parents("form").submit();
    return false;
  });
  $(document).on("click", ".forget_button", function () {
    $(this).parents("form").submit();
    return false;
  });
  $(document).on("click", ".registration_button", function () {
    $(this).parents("form").submit();
    return false;
  });
  $(document).on("click", ".registration_fb_button", function () {
    $(this).parents("form").submit();
    return false;
  });
  $(document).on("click", ".registration_gp_button", function () {
    $(this).parents("form").submit();
    return false;
  });

  $(document).on("click", ".registration_tg_button", function () {
    $(this).parents("form").submit();
    return false;
  });

  $(document).on("click", ".instructor_button", function () {
    $(this).parents("form").submit();
    return false;
  });

  $(document).on("click", "[data-form]", function () {
    var _this = $(this);
    var _form = _this.data("form");

    $(".forms_log").find("form").removeClass("active");
    $("." + _form).addClass("active");

    var _top = $(window).height() / 2 - $("#login").height() / 2;
    $("#login").css("top", _top + "px");
    return false;
  });

  $(document).on("click", ".next_question", function (e) {
    var _id_now = $(this)
      .parents("[data-question-holder-id]")
      .attr("data-question-holder-id");
    $(".test_navigation_questions")
      .find('[data-question-id="' + _id_now + '"]')
      .parent()
      .next("li")
      .find("[data-question-id]")
      .trigger("click");

    if ($(window).width() < 992) {
      var _index =
        parseInt(
          $(".test_navigation_questions")
            .find('[data-question-id="' + _id_now + '"]')
            .parent()
            .index()
        ) + 1;
      $(".test_navigation_questions").slick("slickGoTo", _index);
    }
    setTimeout(function () {
      $(".trigger_add_favorite").attr("data-aos", "");
    }, 500);
    return false;
  });

  $(document).on("click", ".next_question_s", function (e) {
    var _id_now = $(this)
      .parents("[data-question-holder-id]")
      .attr("data-question-holder-id");
    $(".test_navigation_questions")
      .find('[data-question-id="' + _id_now + '"]')
      .parent()
      .next("li")
      .find("[data-question-id]")
      .trigger("click");

    if ($(window).width() < 992) {
      var _index =
        parseInt(
          $(".test_navigation_questions")
            .find('[data-question-id="' + _id_now + '"]')
            .parent()
            .index()
        ) + 1;
      $(".test_navigation_questions").slick("slickGoTo", _index);
    }
    setTimeout(function () {
      $(".trigger_add_favorite").attr("data-aos", "");
    }, 500);
    return false;
  });

  $(".input_phone").mask("+38 (999) 999-99-99");

  $(document).on("submit", ".instructor_recall_form", function () {
    var _this = $(this),
      _data = _this.serialize();
    $.ajax({
      url: location.href,
      beforeSend: function () {
        preloadOn();
      },
      data: "ajax=a_recall&" + _data,
      success: function (json) {
        preloadOff();
        $(".error_input").removeClass("error_input");
        if (json.ack == "Failure") {
          $.each(json.errors, function (key, value) {
            $('[name="' + value + '"]').addClass("error_input");
          });
          if (json.msg.length > 0) {
            alert_mess_failure(json.msg);
          }
        } else {
          _this.css("display", "none");
          _this.next(".thanks_text_recall").fadeIn(200);
        }
      },
    });
    return false;
  });
  $(document).on("submit", ".a_recall_form", function () {
    var _this = $(this),
      _data = _this.serialize();
    $.ajax({
      url: location.href,
      beforeSend: function () {
        preloadOn();
      },
      data: "ajax=a_recall&" + _data,
      success: function (json) {
        preloadOff();
        $(".error_input").removeClass("error_input");
        if (json.ack == "Failure") {
          $.each(json.errors, function (key, value) {
            $('[name="' + value + '"]').addClass("error_input");
          });
          if (json.msg.length > 0) {
            alert_mess_failure(json.msg);
          }
        } else {
          _this.css("display", "none");
          _this.next(".thanks_text_recall").fadeIn(200);
        }
      },
    });
    return false;
  });

  $(document).on("submit", ".subscribe_form", function () {
    var _this = $(this),
      _data = _this.serialize();
    $.ajax({
      url: location.href,
      beforeSend: function () {
        preloadOn();
      },
      data: "ajax=subscribe&" + _data,
      success: function (json) {
        preloadOff();
        $(".error_input").removeClass("error_input");
        if (json.ack == "Failure") {
          $.each(json.errors, function (key, value) {
            $('[name="' + value + '"]').addClass("error_input");
          });
          if (json.msg.length > 0) {
            alert_mess_failure(json.msg);
          }
        } else {
          _this.css("display", "none");
          _this.next(".subscribe_thanks_text").fadeIn(200);
        }
      },
    });
    return false;
  });

  if ($("#school_id").length > 0) {
    $("#i_school").val($("#school_id").val());
  }

  $(document).on("submit", ".instructor_form", function () {
    var _this = $(this),
      _data = _this.serialize();
    $.ajax({
      url: location.href,
      data: "ajax=instructor_manager&" + _data,
      beforeSend: function () {
        preloadOn();
      },
      success: function (json) {
        preloadOff();
        $(".error_input").removeClass("error_input");
        if (json.ack == "Failure") {
          $.each(json.errors, function (key, value) {
            $('[name="' + value + '"]').addClass("error_input");
            $('[name="' + value + '"]')
              .parents(".input")
              .addClass("error_input");
          });
          if (json.msg.length > 0) {
            alert_mess_failure(json.msg);
          }
        } else {
          if (json.registration) {
            dataLayer.push({
              event: "registration_instructor",
            });
          }
          _this.css("display", "none");
          _this.next(".instructor_thanks_text").fadeIn(200);
          scroll_to_top();
        }
      },
    });
    return false;
  });

  $(document).on("submit", ".instructor_form", function () {
    var _this = $(this),
      _data = _this.serialize();
    $.ajax({
      url: location.href,
      data: "ajax=instructor&" + _data,
      beforeSend: function () {
        preloadOn();
      },
      success: function (json) {
        preloadOff();
        $(".error_input").removeClass("error_input");
        if (json.ack == "Failure") {
          $.each(json.errors, function (key, value) {
            $('[name="' + value + '"]').addClass("error_input");
            $('[name="' + value + '"]')
              .parents(".input")
              .addClass("error_input");
          });
          if (json.msg.length > 0) {
            alert_mess_failure(json.msg);
          }
        } else {
          if (json.registration) {
            dataLayer.push({
              event: "registration_instructor",
            });
          }
          _this.css("display", "none");
          _this.next(".instructor_thanks_text").fadeIn(200);
          scroll_to_top();
        }
      },
    });
    return false;
  });

  $(document).on("click", ".helper_question", function () {
    var _question = $(this)
      .parents(".question")
      .attr("data-question-holder-id");
    $(".helper_chat_holder").addClass("active");
    $(".chat_main").fadeOut(0);
    $.ajax({
      url: location.href,
      beforeSend: function () {
        preloadChatOn();
      },
      data: "ajax=helper_test&question_id=" + _question,
      success: function (json) {
        preloadChatOff();
        $(".helper_messages").append(json.answer);
        $(".helper_messages").scrollTop($(".helper_messages")[0].scrollHeight);
      },
    });
    return false;
  });

  $(document).on("click", ".restart_chat", function () {
    $.ajax({
      url: location.href,
      beforeSend: function () {
        preloadChatOn();
      },
      data: "ajax=restart_chat&",
      success: function (json) {
        preloadChatOff();
        $(".helper_messages .chat_message_holder:not(.chat_main)").remove();
      },
    });
    return false;
  });

  if ($(".helper_messages").length > 0) {
    $(".helper_messages").scrollTop($(".helper_messages")[0].scrollHeight);
  }
  $(document).on("submit", "#helper", function () {
    var _this = $(this),
      _data = _this.serialize();
    _tpl = $(".user_tpl").html();
    _question = $(this).find('[name="question"]').val();

    $(this).find('[name="question"]').val("");
    $(".helper_messages").append(_tpl.replace("{text}", _question));
    $(".helper_messages").scrollTop($(".helper_messages")[0].scrollHeight);

    $.ajax({
      url: location.href,
      beforeSend: function () {
        preloadChatOn();
      },
      data: "ajax=helper&" + _data,
      success: function (json) {
        preloadChatOff();
        $(".helper_messages").append(json.answer);
        $(".helper_messages").scrollTop($(".helper_messages")[0].scrollHeight);
      },
    });
    return false;
  });

  $(document).on("click", ".close_helper", function () {
    $(".helper_chat_holder").removeClass("active");
    return false;
  });
  $(document).on("click", ".call_helper", function () {
    if ($(".helper_chat_holder").hasClass("active")) {
      $(".helper_chat_holder").removeClass("active");
    } else {
      $(".helper_chat_holder").addClass("active");
      $(".helper_messages").scrollTop($(".helper_messages")[0].scrollHeight);
    }
    return false;
  });

  function updateSchedule(_type, _date, _instructor) {
    if (_type == "") {
      var _type = $(".calendar_nav.active").attr("data-type");
    }
    if (_date == "") {
      var _date = $(".calendar_schedule_now").val();
    }
    if (_instructor == "") {
      if ($("#instructor_id").length > 0 && $("#instructor_id").val() != "") {
        var _instructor = "&instructor=" + $("#instructor_id").val();
      } else {
        var _instructor = "";
      }
    }

    // var _url = $('.calendar_schedule_url').val()+'?type='+_type+'&date='+_date+_instructor;
    $.ajax({
      url: location.href,
      data:
        "ajax=update_schedule&type=" + _type + "&date=" + _date + _instructor,
      success: function (json) {
        preloadOff();
        $(".calendar_holder").html(json.calendar);
      },
    });
  }

  function updateScheduleSchool(_type, _date, _school) {
    if (_type == "") {
      var _type = $(".calendar_nav.active").attr("data-type");
    }
    if (_date == "") {
      var _date = $(".calendar_schedule_now").val();
    }

    // var _url = $('.calendar_schedule_url').val()+'?type='+_type+'&date='+_date+_instructor;
    $.ajax({
      url: location.href,
      data:
        "ajax=update_schedule_school&type=" +
        _type +
        "&date=" +
        _date +
        _school,
      success: function (json) {
        preloadOff();
        $(".calendar_holder").html(json.calendar);
      },
    });
  }

  $(document).on("click", "[data-calendar-date]", function () {
    var _this = $(this);
    var _type = $(".calendar_nav.active").attr("data-type");
    if ($(this).parents(".calendar").length > 0) {
      _type = "week";
    }
    var _date = $(this).attr("data-calendar-date");

    if ($("#school_id").length > 0) {
      var _school = "&school=" + $("#school_id").val();
      updateScheduleSchool(_type, _date, _school);
    } else {
      if ($("#instructor_id").length > 0 && $("#instructor_id").val() != "") {
        var _instructor = "&instructor=" + $("#instructor_id").val();
      } else {
        var _instructor = "";
      }
      updateSchedule(_type, _date, _instructor);
    }
    /*
        var _url = $('.calendar_schedule_url').val()+'?type='+_type+'&date='+_date+_instructor;
        window.location.replace(_url);
*/
    return false;
  });
  $(document).on("click", "[data-type]", function () {
    var _this = $(this);
    var _date = $(".calendar_schedule_now").val();
    var _type = $(this).attr("data-type");

    if ($("#school_id").length > 0) {
      var _school = "&school=" + $("#school_id").val();
      updateScheduleSchool(_type, _date, _school);
    } else {
      if ($("#instructor_id").length > 0 && $("#instructor_id").val() != "") {
        var _instructor = "&instructor=" + $("#instructor_id").val();
      } else {
        var _instructor = "";
      }
      updateSchedule(_type, _date, _instructor);
    }
    /*
        var _url = $('.calendar_schedule_url').val()+'?type='+_type+'&date='+_date+_instructor;
        window.location.replace(_url);
        */
    return false;
  });

  $(document).on("submit", ".cdi_form", function () {
    var _this = $(this);
    var _data = $(this).serialize();
    $.ajax({
      url: location.href,
      beforeSend: function () {
        preloadOn();
      },
      data: "ajax=cdi&" + _data,
      success: function (json) {
        if (json.ack == "Success") {
          updateSchedule("", "", "");
          $("#cdi_popup").removeClass("active");
          $("#shader").fadeOut(300);
          $("body").removeClass("body--active");
        } else {
          preloadOff();
          alert_mess_failure(json.message);
        }
      },
    });
    return false;
  });

  $(document).on("click", "[data-cdi-time-manager]", function () {
    var _this = $(this);
    var _daytime = $(this).attr("data-cdi-time-manager");
    var _user = $(this).attr("data-cdi-time-user");
    $.ajax({
      url: location.href,
      beforeSend: function () {
        preloadOn();
      },
      data: "ajax=cdi_daytime_manager&daytime=" + _daytime + "&user=" + _user,
      success: function (json) {
        preloadOff();
        if (json.ack == "Success") {
          $(".cdi_form").html(json.form);
          $("#cdi_popup").addClass("active");
          $("#shader").fadeIn(300);
          $("body").addClass("body--active");
        } else {
          $(".cdi_form").html("");
        }
      },
    });
    return false;
  });
  $(document).on("change", '[name="cdi[client]"]', function (event) {
    var _this = $(this);
    var _val = $(this).val();
    var selectedOptionText = $(this).find("option:selected").text();
    var _type = $('[name="cdi[client]"]')
      .find('[data-lesson-name="' + selectedOptionText + '"]')
      .attr("data-lesson-type");
    switch (_type) {
      case "0":
        $('[name="cdi[type]"]')
          .find("option[value='" + _type + "']")
          .prop("selected", true);
        break;
      case "1":
        $('[name="cdi[type]"]')
          .find("option[value='" + _type + "']")
          .prop("selected", true);
        break;
      case "2":
        $('[name="cdi[type]"]')
          .find("option[value='" + _type + "']")
          .prop("selected", true);
        break;
      default:
        $('[name="cdi[type]"]').find("option[value='']").prop("selected", true);
        break;
    }
    $('[name="cdi[type]"]').trigger("chosen:updated");
    return false;
  });

  $(document).on("click", "[data-view-schedule]", function () {
    var _this = $(this);
    var _instructor_id = $(this).attr("data-view-schedule");
    $.ajax({
      url: location.href,
      beforeSend: function () {
        preloadOn();
      },
      data: "ajax=view_schedule&instructor_id=" + _instructor_id,
      success: function (json) {
        preloadOff();
        $(".schedule_pop").html(json.schedule);
        $(".schedule_pop").addClass("active");
        $("#shader").fadeIn(0);
      },
    });
    return false;
  });
  $(document).on("click", "#preload", function () {
    preloadOff();
    return false;
  });

  $(document).on("click", "[data-cdi-book]", function () {
    var _this = $(this);
    var _daytime = $(this).attr("data-cdi-book");
    var _instructor_id = $("#instructor_id").val();
    $.ajax({
      url: location.href,
      beforeSend: function () {
        preloadOn();
      },
      data:
        "ajax=cdi_daytime_user&daytime=" +
        _daytime +
        "&instructor_id=" +
        _instructor_id,
      success: function (json) {
        preloadOff();
        if (json.ack == "Success") {
          $(".cdi_form").html(json.form);
          $("#cdi_popup").addClass("active");
          $("#shader").fadeIn(300);
          $("body").addClass("body--active");
          $("select").chosen("updated");
          $("[data-active]").each(function () {
            _ids = $(this).attr("data-active").split(",");
            for (_i in _ids) {
              _option = $(this).find('option[value="' + _ids[_i] + '"]');
              _option.prop("selected", true);
            }
            $(this).trigger("chosen:updated");
          });
        } else {
          alert_mess_failure(json.message);
        }
      },
    });
    return false;
  });

  $(document).on("click", "[data-book-apply]", function () {
    var _this = $(this);
    var _book = $(this).attr("data-book-apply");
    $.ajax({
      url: location.href,
      beforeSend: function () {
        preloadOn();
      },
      data: "ajax=book_apply&book=" + _book,
      success: function (json) {
        preloadOff();
        if (json.ack == "Success") {
          $(".plan_lessons").html(json.plan_lessons);
        } else {
          alert_mess_failure(json.message);
        }
      },
    });
    return false;
  });
  $(document).on("click", "[data-book-cancel]", function () {
    var _this = $(this);
    var _book = $(this).attr("data-book-cancel");
    $.ajax({
      url: location.href,
      beforeSend: function () {
        preloadOn();
      },
      data: "ajax=book_cancel&book=" + _book,
      success: function (json) {
        preloadOff();
        if (json.ack == "Success") {
          $(".plan_lessons").html(json.plan_lessons);
        } else {
          alert_mess_failure(json.message);
        }
      },
    });
    return false;
  });
  $(document).on("click", "[data-book-cancel-u]", function () {
    var _this = $(this);
    var _book = $(this).attr("data-book-cancel-u");
    $.ajax({
      url: location.href,
      beforeSend: function () {
        preloadOn();
      },
      data: "ajax=book_cancel_u&book=" + _book,
      success: function (json) {
        preloadOff();
        if (json.ack == "Success") {
          $(".plan_lessons_active").html(json.plan_lessons);
        } else {
          alert_mess_failure(json.message);
        }
      },
    });
    return false;
  });

  $(document).on("click", "[data-cdi-time]", function () {
    var _this = $(this);
    var _daytime = $(this).attr("data-cdi-time");
    $.ajax({
      url: location.href,
      beforeSend: function () {
        preloadOn();
      },
      data: "ajax=cdi_daytime&daytime=" + _daytime,
      success: function (json) {
        preloadOff();
        if (json.ack == "Success") {
          $(".cdi_form").html(json.form);
          $("#cdi_popup").addClass("active");
          $("#shader").fadeIn(300);
          $("body").addClass("body--active");
          $("select").chosen("updated");
          $("[data-active]").each(function () {
            _ids = $(this).attr("data-active").split(",");
            for (_i in _ids) {
              _option = $(this).find('option[value="' + _ids[_i] + '"]');
              _option.prop("selected", true);
            }
            $(this).trigger("chosen:updated");
          });
        } else {
          alert_mess_failure(json.message);
        }
      },
    });
    return false;
  });

  $(document).on("click", "[data-cdi-week]", function () {
    var _this = $(this);
    $.ajax({
      url: location.href,
      beforeSend: function () {
        preloadOn();
      },
      data: "ajax=cdi_week",
      success: function (json) {
        if (json.ack == "Success") {
          updateSchedule("", "", "");
        } else {
          preloadOff();
          alert_mess_failure(json.message);
        }
      },
    });
    return false;
  });

  $(document).on("click", "[data-cdi-day]", function () {
    var _this = $(this);
    var _day = $(this).attr("data-cdi-day");
    var _full = $(this).attr("data-cdi-full");
    $.ajax({
      url: location.href,
      beforeSend: function () {
        preloadOn();
      },
      data: "ajax=cdi_day&day=" + _day + "&full=" + _full,
      success: function (json) {
        if (json.ack == "Success") {
          updateSchedule("", "", "");
        } else {
          preloadOff();
          alert_mess_failure(json.message);
        }
      },
    });
    return false;
  });
  $(document).on("click", ".instructor_setting_day_remove", function () {
    $(this).parent().remove();
    return false;
  });

  $(document).on("click", ".add_instructor_settings_pickup", function () {
    var _this = $(this);
    $.ajax({
      url: location.href,
      beforeSend: function () {
        preloadOn();
      },
      data: "ajax=add_instructor_settings_pickup",
      success: function (json) {
        preloadOff();
        $(".isf_holder_pickup").append(json.data);
        $("select").chosen("updated");
      },
    });
    return false;
  });

  $(document).on("click", ".add_instructor_settings", function () {
    var _this = $(this);
    $.ajax({
      url: location.href,
      beforeSend: function () {
        preloadOn();
      },
      data: "ajax=add_instructor_settings",
      success: function (json) {
        preloadOff();
        $(".isf_holder").append(json.data);
        $(".instructor_setting_form [data-active]").each(function () {
          _ids = $(this).attr("data-active").split(",");
          for (_i in _ids) {
            _option = $(this).find('option[value="' + _ids[_i] + '"]');
            _option.prop("selected", true);
          }
          $(this).trigger("chosen:updated");
        });
        $("select").chosen("updated");
      },
    });
    return false;
  });

  $(document).on("submit", ".instructor_setting_form_pickup", function () {
    var _this = $(this),
      _data = _this.serialize();
    $.ajax({
      url: location.href,
      beforeSend: function () {
        preloadOn();
      },
      data: "ajax=instructor_setting_pickup&" + _data,
      success: function (json) {
        preloadOff();
        $(".error_input").removeClass("error_input");
        if (json.ack == "Failure") {
          $.each(json.errors, function (key, value) {
            $('[name="' + value + '"]').addClass("error_input");
          });
          if (json.msg.length > 0) {
            alert_mess_failure(json.msg);
          }
        } else {
          _this.css("display", "none");
          _this.next(".instructor_setting_thanks_text").fadeIn(200);
        }
      },
    });
    return false;
  });

  $(document).on("submit", ".instructor_setting_form", function () {
    var _this = $(this),
      _data = _this.serialize();
    $.ajax({
      url: location.href,
      beforeSend: function () {
        preloadOn();
      },
      data: "ajax=instructor_setting&" + _data,
      success: function (json) {
        preloadOff();
        $(".error_input").removeClass("error_input");
        if (json.ack == "Failure") {
          $.each(json.errors, function (key, value) {
            $('[name="' + value + '"]').addClass("error_input");
          });
          if (json.msg.length > 0) {
            alert_mess_failure(json.msg);
          }
        } else {
          _this.css("display", "none");
          _this.next(".instructor_setting_thanks_text").fadeIn(200);
        }
      },
    });
    return false;
  });

  $(document).on("submit", ".profile_setting_form", function () {
    var _this = $(this),
      _data = _this.serialize();
    $.ajax({
      url: location.href,
      beforeSend: function () {
        preloadOn();
      },
      data: "ajax=profile_setting&" + _data,
      success: function (json) {
        preloadOff();
        $(".error_input").removeClass("error_input");
        if (json.ack == "Failure") {
          $.each(json.errors, function (key, value) {
            $('[name="' + value + '"]').addClass("error_input");
          });
          if (json.msg.length > 0) {
            alert_mess_failure(json.msg);
          }
        } else {
          _this.css("display", "none");
          _this.next(".profile_thanks_text").fadeIn(200);
        }
      },
    });
    return false;
  });

  $(document).on("submit", ".profile_form", function () {
    var _this = $(this),
      _data = _this.serialize();
    $.ajax({
      url: location.href,
      beforeSend: function () {
        preloadOn();
      },
      data: "ajax=profile&" + _data,
      success: function (json) {
        preloadOff();
        $(".error_input").removeClass("error_input");
        if (json.ack == "Failure") {
          $.each(json.errors, function (key, value) {
            $('[name="' + value + '"]').addClass("error_input");
          });
          if (json.msg.length > 0) {
            alert_mess_failure(json.msg);
          }
        } else {
          _this.css("display", "none");
          _this.next(".profile_thanks_text").fadeIn(200);
        }
      },
    });
    return false;
  });
  $(document).on("submit", ".pwd_form", function () {
    var _this = $(this),
      _data = _this.serialize();
    $.ajax({
      url: location.href,
      beforeSend: function () {
        preloadOn();
      },
      data: "ajax=changepwd&" + _data,
      success: function (json) {
        preloadOff();
        $(".error_input").removeClass("error_input");
        if (json.ack == "Failure") {
          $.each(json.errors, function (key, value) {
            $('[name="' + value + '"]').addClass("error_input");
          });
          if (json.msg.length > 0) {
            alert_mess_failure(json.msg);
          }
        } else {
          _this.css("display", "none");
          _this.next(".pwd_thanks_text").fadeIn();
        }
      },
    });
    return false;
  });

  $(document).on("submit", ".login_form", function () {
    var _data = $(this).serialize();
    var _this = $(this);
    $.ajax({
      url: location.href,
      beforeSend: function () {
        preloadOn();
      },
      data: "ajax=login&" + _data,
      success: function (json) {
        preloadOff();
        $(".error_input").removeClass("error_input");
        if (json.ack == "Failure") {
          $.each(json.errors, function (key, value) {
            _this.find('[name="' + value + '"]').addClass("error_input");
          });
          if (json.msg.length > 0) {
            alert_mess_failure(json.msg);
          }
        } else {
          window.location.replace(json.redirect);
        }
      },
    });

    return false;
  });

  $(document).on("submit", ".forget_form", function () {
    var _data = $(this).serialize();
    var _this = $(this);
    $.ajax({
      url: location.href,
      beforeSend: function () {
        preloadOn();
      },
      data: "ajax=forget&" + _data,
      success: function (json) {
        preloadOff();
        $(".error_input").removeClass("error_input");
        if (json.ack == "Failure") {
          $.each(json.errors, function (key, value) {
            $('[name="' + value + '"]').addClass("error_input");
          });
          if (json.msg.length > 0) {
            alert_mess_failure(json.msg);
          }
        } else {
          _this.css("display", "none");
          _this.next(".thanks_text_forget").fadeIn();
        }
      },
    });

    return false;
  });

  $(document).on("submit", ".registration_form", function () {
    var _data = $(this).serialize();
    var _this = $(this);
    $.ajax({
      url: location.href,
      beforeSend: function () {
        preloadOn();
      },
      data: "ajax=registration&" + _data,
      success: function (json) {
        preloadOff();
        $(".error_input").removeClass("error_input");
        if (json.ack == "Failure") {
          $.each(json.errors, function (key, value) {
            $('[name="' + value + '"]').addClass("error_input");
          });
          if (json.msg.length > 0) {
            alert_mess_failure(json.msg);
          }
        } else {
          dataLayer.push({
            event: json.event,
          });

          _this.css("display", "none");
          _this.next(".thanks_text_registration").fadeIn();
          window.location.replace(json.redirect);
        }
      },
    });

    return false;
  });

  $(document).on("click", ".unreg_telegram", function () {
    var _data = $(this).serialize();
    var _this = $(this);
    $.ajax({
      url: location.href,
      beforeSend: function () {
        preloadOn();
      },
      data: "ajax=unreg_telegram&" + _data,
      success: function (json) {
        preloadOff();
        if (json.ack == "Failure") {
          if (json.msg.length > 0) {
            alert_mess_failure(json.msg);
          }
        } else {
          $(".telegram_connector").fadeOut(0);
          alert_mess_success(json.msg);
        }
      },
    });

    return false;
  });

  $(document).on("submit", ".registration_tg_form", function () {
    var _data = $(this).serialize();
    var _this = $(this);
    $.ajax({
      url: location.href,
      beforeSend: function () {
        preloadOn();
      },
      data: "ajax=registration_tg&" + _data,
      success: function (json) {
        preloadOff();
        if (json.ack == "Failure") {
          if (json.msg.length > 0) {
            alert_mess_failure(json.msg);
          }
        } else {
          _this.css("display", "none");
          _this.next(".thanks_text_registration_tg").fadeIn();
        }
      },
    });

    return false;
  });

  $(document).on("submit", ".registration_fb_form", function () {
    var _data = $(this).serialize();
    var _this = $(this);
    $.ajax({
      url: location.href,
      beforeSend: function () {
        preloadOn();
      },
      data: "ajax=registration_fb&" + _data,
      success: function (json) {
        preloadOff();
        $(".error_input").removeClass("error_input");
        if (json.ack == "Failure") {
          $.each(json.errors, function (key, value) {
            $('[name="' + value + '"]').addClass("error_input");
          });
          if (json.msg.length > 0) {
            alert_mess_failure(json.msg);
          }
        } else {
          _this.css("display", "none");
          _this.next(".thanks_text_registration_fb").fadeIn();
          dataLayer.push({
            event: "registration_fb",
          });
          setTimeout(function () {
            window.location.replace(json.redirect);
          }, 2000);
        }
      },
    });

    return false;
  });
  $(document).on("submit", ".registration_gp_form", function () {
    var _data = $(this).serialize();
    var _this = $(this);
    $.ajax({
      url: location.href,
      beforeSend: function () {
        preloadOn();
      },
      data: "ajax=registration_gp&" + _data,
      success: function (json) {
        preloadOff();
        $(".error_input").removeClass("error_input");
        if (json.ack == "Failure") {
          $.each(json.errors, function (key, value) {
            $('[name="' + value + '"]').addClass("error_input");
          });
          if (json.msg.length > 0) {
            alert_mess_failure(json.msg);
          }
        } else {
          _this.css("display", "none");
          _this.next(".thanks_text_registration_gp").fadeIn();
          dataLayer.push({
            event: "registration_gp",
          });
          setTimeout(function () {
            window.location.replace(json.redirect);
          }, 2000);
        }
      },
    });

    return false;
  });

  $(document).on("submit", "#callback_body", function () {
    var _this = $(this),
      _data = _this.serialize();
    $.ajax({
      url: location.href,
      beforeSend: function () {
        preloadOn();
      },
      data: "ajax=callback_body&" + _data,
      success: function (json) {
        preloadOff();
        $(".error_input").removeClass("error_input");
        if (json.ack == "Failure") {
          $.each(json.errors, function (key, value) {
            $('[name="' + value + '"]').addClass("error_input");
          });
          alert_mess_failure(json.text);
        } else {
          _this.find('input[type="text"]').val("");
          alert_mess_success(json.text);
        }
      },
    });
    return false;
  });

  $(".fancybox").fancybox();

  /*
    $(document).on("click", ".main_banner_link", function(e) {
        $("#group_pop").addClass('active');
        $("#shader").fadeIn(300);
        $("body").addClass("body--active");
        var _top = ($(window).height()/2) - ($('#group_pop').height()/2);
        $('#group_pop').css('top',_top+'px');
        return false;
    });
*/

  $(document).on("submit", ".group_form", function () {
    var _this = $(this),
      _data = _this.serialize();
    $.ajax({
      url: location.href,
      beforeSend: function () {
        preloadOn();
      },
      data: "ajax=group&" + _data,
      success: function (json) {
        preloadOff();
        $(".error_input").removeClass("error_input");
        if (json.ack == "Failure") {
          $.each(json.errors, function (key, value) {
            $('[name="' + value + '"]').addClass("error_input");
          });
          alert_mess_failure(json.msg);
        } else {
          _this.fadeOut(0);
          _this.next(".form_success").fadeIn(200);
        }
      },
    });
    return false;
  });

  $(document).on("submit", ".webitestlesson_form", function () {
    var _this = $(this),
      _data = _this.serialize();
    $.ajax({
      url: location.href,
      beforeSend: function () {
        preloadOn();
      },
      data: "ajax=webitestlesson&" + _data,
      success: function (json) {
        preloadOff();
        $(".error_input").removeClass("error_input");
        if (json.ack == "Failure") {
          $.each(json.errors, function (key, value) {
            $('[name="' + value + '"]').addClass("error_input");
          });
          alert_mess_failure(json.text);
        } else {
          _this.fadeOut(0);
          //_this.next('.form_success').html(json.form_success);
          //_this.next('.form_success').fadeIn(200);

          fbq("track", "Lead");
          dataLayer.push({
            event: "guide",
          });
          /*
                  setTimeout(function(){
                    window.location.replace(json.redirect);
                  },200);
                  */

          $(".testlesson_form_h .testlesson_form_part_2").addClass("active");
          /*
                  $('.webitestlesson_form .form_submit').addClass('form_submit_unavailable');
                  $('.webitestlesson_form .form_submit').attr('href',json.redirect);
                  $('.webitestlesson_form .form_submit_unavailable').removeClass('form_submit');
                  $('.webitestlesson_form .testlesson_form_part_1').removeClass('active');
                  $('.webitestlesson_form .testlesson_form_part_2').addClass('active');
                  */
        }
      },
    });
    return false;
  });

  $(document).on("submit", ".testlesson_form", function () {
    var _this = $(this),
      _data = _this.serialize();
    $.ajax({
      url: location.href,
      beforeSend: function () {
        preloadOn();
      },
      data: "ajax=testlesson&" + _data,
      success: function (json) {
        preloadOff();
        $(".error_input").removeClass("error_input");
        if (json.ack == "Failure") {
          $.each(json.errors, function (key, value) {
            $('[name="' + value + '"]').addClass("error_input");
          });
          alert_mess_failure(json.text);
        } else {
          _this.fadeOut(0);
          /*
                  _this.next('.form_success').html(json.form_success);
                  _this.next('.form_success').fadeIn(200);
                  */
          fbq("track", "Lead");
          dataLayer.push({
            event: json.event,
          });
          /*
                  $('.testlesson_form .form_submit').addClass('form_submit_unavailable');
                  $('.testlesson_form .form_submit').attr('href',json.redirect);
                  $('.testlesson_form .form_submit_unavailable').removeClass('form_submit');
                  */
          $(".testlesson_form_part_2").addClass("active");
        }
      },
    });
    return false;
  });

  $(document).on("click", ".form_submit", function (event) {
    $(this).parents("form").submit();
    return false;
  });

  $(document).on("click", ".form_submit_unavailable", function (event) {
    alert_mess_failure($(this).attr("data-error-text"));
    return false;
  });

  $(document).on("click", ".input_subscribe_btn", function (event) {
    $(".form_submit_unavailable").removeClass("form_submit_unavailable");
    return false;
  });

  $(document).on("click", ".popup_close , #shader", function (e) {
    $(".popup").removeClass("active");
    $("#shader").fadeOut(300);
    $("body").removeClass("body--active");
    $(".pay_online_video").removeClass("active");
    return false;
  });
  $(document).on("click", ".call_webi_testlesson", function () {
    $("#webi_testlesson").addClass("active");
    $("#shader").fadeIn(300);
    $("body").addClass("body--active");
    return false;
  });
  $(document).on("click", ".call_smart_course", function () {
    $("#smart_course").addClass("active");
    $("#shader").fadeIn(300);
    $("body").addClass("body--active");
    return false;
  });

  $(document).on("click", ".menu_nav , #shader_nav", function (e) {
    if ($(".menu_nav").hasClass("active")) {
      $(".menu_nav").removeClass("active");
      $(".mobile_nav").removeClass("active");
      $("#shader_nav").fadeOut(300);
      $("body").removeClass("body--active");
    } else {
      $(".menu_nav").addClass("active");
      $(".mobile_nav").addClass("active");
      $("#shader_nav").fadeIn(300);
      $("body").addClass("body--active");
    }
    return false;
  });

  $(document).on("click", ".call_login", function (e) {
    $("#login").addClass("active");
    $("#shader").fadeIn(300);
    $("#continue_pop").removeClass("active");
    $("body").addClass("body--active");
    $(".menu_nav").removeClass("active");
    $(".mobile_nav").removeClass("active");
    $("#shader_nav").fadeOut(300);
    $('[data-form="login_form"]').trigger("click");

    var _top = $(window).height() / 2 - $("#login").height() / 2;
    $("#login").css("top", _top + "px");

    return false;
  });

  $(document).on("click", ".call_registration", function (e) {
    $("#login").addClass("active");
    $("#shader").fadeIn(300);
    $("#continue_pop").removeClass("active");
    $("body").addClass("body--active");
    $(".menu_nav").removeClass("active");
    $(".mobile_nav").removeClass("active");
    $("#shader_nav").fadeOut(300);
    $('[data-form="registration_form"]').trigger("click");
    var _top = $(window).height() / 2 - $("#login").height() / 2;
    $("#login").css("top", _top + "px");
    return false;
  });

  $(document).on("click", ".call_continue", function (e) {
    $("#continue_pop").addClass("active");
    $("#shader").fadeIn(300);
    $("body").addClass("body--active");
    $(".menu_nav").removeClass("active");
    $(".mobile_nav").removeClass("active");
    $("#shader_nav").fadeOut(300);
    var _top = $(window).height() / 2 - $("#continue_pop").height() / 2;
    $("#continue_pop").css("top", _top + "px");

    return false;
  });

  $(document).on("click", "[data-call-instructor]", function () {
    var _this = $(this),
      _id = _this.attr("data-call-instructor");
    _name = _this.attr("data-call-instructor-name");
    $("#call_instructor_id").val(_id);
    $("#call_instructor_name").val(_name);
    $("#call_instructor").addClass("active");
    $("#shader").fadeIn(300);
    $("body").addClass("body--active");
    return false;
  });

  $(document).on("submit", ".call_instructor_form", function () {
    var _this = $(this),
      _data = _this.serialize();
    $.ajax({
      url: location.href,
      beforeSend: function () {
        preloadOn();
      },
      data: "ajax=call_instructor&" + _data,
      success: function (json) {
        preloadOff();
        $(".error_input").removeClass("error_input");
        if (json.ack == "Failure") {
          $.each(json.errors, function (key, value) {
            $('[name="' + value + '"]').addClass("error_input");
          });
          if (json.msg.length > 0) {
            alert_mess_failure(json.msg);
          }
        } else {
          _this.css("display", "none");
          _this.next(".form_success").html(json.form_success);
          _this.next(".form_success").fadeIn(200);
          dataLayer.push({
            event: "form_instruktori",
          });
        }
      },
    });
    return false;
  });

  $(document).on("click", "[data-add-wish-instructor]", function () {
    var _this = $(this),
      _id = _this.attr("data-add-wish-instructor");
    if (_this.hasClass("active")) {
      $.ajax({
        url: location.href,
        data: "ajax=remove_favorite_instructor&id=" + _id,
        success: function (json) {
          _this.removeClass("active");
          if (_this.parents(".tpl_personal_cabinet").length > 0) {
            _this.parents(".tpl_instructor").remove();
          }
        },
      });
    } else {
      $.ajax({
        url: location.href,
        data: "ajax=add_favorite_instructor&id=" + _id,
        success: function (json) {
          _this.addClass("active");
        },
      });
    }
    return false;
  });

  $(document).on("click", "[data-add-favorite]", function () {
    var _this = $(this),
      _id = _this.attr("data-add-favorite");
    if (_this.hasClass("active")) {
      $.ajax({
        url: location.href,
        data: "ajax=remove_favorite&id=" + _id,
        success: function (json) {
          _this.removeClass("active");
          if (_this.hasClass("fav_in")) {
            _this.parents(".question").remove();
          }
        },
      });
    } else {
      $.ajax({
        url: location.href,
        data: "ajax=add_favorite&id=" + _id,
        success: function (json) {
          _this.addClass("active");
        },
      });
    }
    return false;
  });

  $(document).on("click", "[data-city-val]", function () {
    var _val = $(this).attr("data-city-val");
    var _par = $(this).parents(".ac_city");

    _par.find("input").val(_val);
    _par.addClass("ac_filed");

    _par.find(".ac_city_result").css("display", "none");
    $("#overflow_1").fadeOut();
    return false;
  });

  $(".ac_city input").on("keyup", function () {
    var _par = $(this).parent();
    _par.removeClass("ac_filed");
    $(this).removeClass("error_input");
    if ($(this).val().length >= 1) {
      jQuery.ajax({
        url: window.location.href,
        type: "POST",
        data: {
          city: $(this).val(),
          ajax: "search_city",
        },
        cache: false,
        success: function (html) {
          if (html.ack == "Failure") {
            _par.find(".ac_city_result").css("display", "none");
            $("#overflow_1").fadeOut();
            alert_mess(html.error_text);
          } else {
            _par.find(".ac_city_result").css("display", "block");
            _par.find(".ac_city_result ul").html(html.city);
            $("#overflow_1").fadeIn();
          }
        },
      });
    } else {
      _par.find(".ac_city_result").css("display", "none");
      $("#overflow_1").fadeOut();
    }
  });

  $(".ac_city input").on("focusout", function () {
    var _par = $(this).parent();
    $("#overflow_1").on("click", function () {
      _par.find(".ac_city_result").css("display", "none");
      $("#overflow_1").fadeOut();
    });
    return false;
  });

  setTimeout(function () {
    if ($(".test_navigation_questions").length > 0) {
      var _id_now = parseInt(
        $(".test_navigation_questions")
          .find(".question_nav:not(.answered):first-child")
          .attr("data-question-id")
      );
      $('[data-question-id="' + _id_now + '"]').trigger("click");

      if ($(window).width() < 992) {
        var _index =
          parseInt(
            $(".test_navigation_questions")
              .find('[data-question-id="' + _id_now + '"]')
              .parent()
              .index()
          ) + 1;
        $(".test_navigation_questions").slick("slickGoTo", _index);
      }
    }
  }, 100);

  setTimeout(function () {
    AOS.init();
  }, 500);

  $(window).on("beforeunload", function () {
    if ($("[data-start]").length > 0) {
      var _time = $("[data-start]").html();
      var _type = $("[data-test-type]").attr("data-test-type");
      var _test = $("[data-test]").attr("data-test");
      $.ajax({
        url: location.href,
        data:
          "ajax=close_test_time&test=" +
          _test +
          "&type=" +
          _type +
          "&time=" +
          _time,
        success: function (json) {},
      });
    }
  });

  function startCounter() {
    timeLimitInSeconds++;
    var minutes = Math.floor(timeLimitInSeconds / 60);
    var seconds = timeLimitInSeconds % 60;

    if (timeLimitInSeconds < 0) {
      timerElement.textContent = "00:00";
      clearInterval(timerInterval);
      return;
    }

    if (minutes < 10) {
      minutes = "0" + minutes;
    }
    if (seconds < 10) {
      seconds = "0" + seconds;
    }

    timerElement.textContent = minutes + ":" + seconds;
  }
  function startTimer() {
    timeLimitInSeconds--;
    var minutes = Math.floor(timeLimitInSeconds / 60);
    var seconds = timeLimitInSeconds % 60;

    if (timeLimitInSeconds < 0) {
      timerElement.textContent = "00:00";
      clearInterval(timerInterval);
      return;
    }

    if (minutes < 10) {
      minutes = "0" + minutes;
    }
    if (seconds < 10) {
      seconds = "0" + seconds;
    }

    timerElement.textContent = minutes + ":" + seconds;
  }
  if ($("[data-countdown]").length > 0) {
    var _exp = $("[data-countdown]").attr("data-countdown").split(":");
    var timeLimitInMinutes = _exp[0];
    var timeLimitInSeconds = timeLimitInMinutes * 60;
    var timerElement = document.getElementById("timer");
    var timerInterval = setInterval(startTimer, 1000);
  }
  if ($("[data-start]").length > 0) {
    var _exp = $("[data-start]").attr("data-start").split(":");
    var timeLimitInMinutes = parseInt(_exp[0]);
    var timeLimitInSeconds = timeLimitInMinutes * 60 + parseInt(_exp[1]);

    var timerElement = document.getElementById("timer");
    var timerInterval = setInterval(startCounter, 1000);
  }

  function startTimerBig() {
    timeLimitInSecondsBig--;
    var daysBig = Math.floor(timeLimitInSecondsBig / 86400);
    var hoursBig = Math.floor((timeLimitInSecondsBig % 86400) / 3600);
    var minutesBig = Math.floor((timeLimitInSecondsBig % 3600) / 60);
    var secondsBig = timeLimitInSecondsBig % 60;

    if (timeLimitInSecondsBig < 0) {
      $("#timer_big").html(
        '<span>00</span><span class="dsep">:</span><span>00</span><span class="dsep">:</span><span>00</span><span class="dsep">:</span><span>00</span>'
      );
      clearInterval(timerIntervalBig);
      return;
    }

    if (daysBig < 10) {
      daysBig = "0" + daysBig;
    }
    if (hoursBig < 10) {
      hoursBig = "0" + hoursBig;
    }
    if (minutesBig < 10) {
      minutesBig = "0" + minutesBig;
    }
    if (secondsBig < 10) {
      secondsBig = "0" + secondsBig;
    }

    $("#timer_big").html(
      "<span>" +
        daysBig +
        '</span><span class="dsep">:</span><span>' +
        hoursBig +
        '</span><span class="dsep">:</span><span>' +
        minutesBig +
        '</span><span class="dsep">:</span><span>' +
        secondsBig +
        "</span>"
    );
  }

  if ($("[data-countdown-big]").length > 0) {
    var _expBig = $("[data-countdown-big]")
      .attr("data-countdown-big")
      .split(":");
    var timeLimitInDaysBig = _expBig[0];
    var timeLimitInHoursBig = _expBig[1];
    var timeLimitInMinutesBig = _expBig[2];
    var timeLimitInSecondsBig =
      _expBig[0] * 86400 + _expBig[1] * 3600 + _expBig[2] * 60 + _expBig[3] * 1;
    var timerElementBig = document.getElementById("timer_big");
    var timerIntervalBig = setInterval(startTimerBig, 1000);
  }

  if ($("#instructor_photo").length > 0) {
    new AjaxUpload($("#instructor_photo"), {
      action: window.location.href + "?ajax=instructor_photo",
      name: "Filedata",
      onSubmit: function (file, ext) {
        $("#shader").fadeIn();
        if (!(ext && /^(gif|jpg|png|jpeg|JPG|PNG|JPEG)$/.test(ext))) {
          alert("Невірний формат файлу");
          $("#shader").fadeOut();
          return false;
        }
      },
      onComplete: function (file, response) {
        $("#shader").fadeOut();
        var locat = window.location.href;
        var _html_li =
          '<li><span class="link_name">' +
          file +
          '</span><input type="hidden" name="instructor[photo][]" value="' +
          response +
          '"/> <a href="#" data-remove-file-photo="' +
          response +
          '" class="remove_link">×</a></li>';
        $(".instructor_photo_container").append(_html_li);
      },
    });
  }
  $(document).on("click", "[data-remove-file-photo]", function () {
    var _file = $(this).attr("data-remove-file-photo");
    var _this = $(this);
    $.ajax({
      url: window.location.href,
      type: "POST",
      cache: false,
      data: "ajax=remove_file_photo&file=" + _file,
      success: function (_json) {
        if (_json.ack == "Success") {
          _this.parents("li").remove();
        }
      },
    });
    return false;
  });

  $(document).on("click", ".close_top_banner", function () {
    $.ajax({
      url: window.location.href,
      type: "POST",
      cache: false,
      data: "ajax=close_top_banner",
      success: function (_json) {
        $(".top_banner").remove();
        $(".topbannerblock").removeClass("topbannerblock");
      },
    });
    return false;
  });

  if ($("#instructor_car_photo").length > 0) {
    new AjaxUpload($("#instructor_car_photo"), {
      action: window.location.href + "?ajax=instructor_car_photo",
      name: "Filedata",
      onSubmit: function (file, ext) {
        $("#shader").fadeIn();
        if (!(ext && /^(gif|jpg|png|jpeg|JPG|PNG|JPEG)$/.test(ext))) {
          alert("Невірний формат файлу");
          $("#shader").fadeOut();
          return false;
        }
      },
      onComplete: function (file, response) {
        $("#shader").fadeOut();
        var locat = window.location.href;
        var _html_li =
          '<li><span class="link_name">' +
          file +
          '</span><input type="hidden" name="instructor[car_photo][]" value="' +
          response +
          '"/> <a href="#" data-remove-file-car-photo="' +
          response +
          '" class="remove_link">×</a></li>';
        $(".instructor_car_photo_container").append(_html_li);
      },
    });
  }
  $(document).on("click", "[data-remove-file-car-photo]", function () {
    var _file = $(this).attr("data-remove-car-file-photo");
    var _this = $(this);
    $.ajax({
      url: window.location.href,
      type: "POST",
      cache: false,
      data: "ajax=remove_file_car_photo&file=" + _file,
      success: function (_json) {
        if (_json.ack == "Success") {
          _this.parents("li").remove();
        }
      },
    });
    return false;
  });

  if ($("#instructor_certificate").length > 0) {
    new AjaxUpload($("#instructor_certificate"), {
      action: window.location.href + "?ajax=instructor_certificate",
      name: "Filedata",
      onSubmit: function (file, ext) {
        $("#shader").fadeIn();
        if (!(ext && /^(pdf|PDF|gif|jpg|png|jpeg|JPG|PNG|JPEG)$/.test(ext))) {
          alert("Невірний формат файлу");
          $("#shader").fadeOut();
          return false;
        }
      },
      onComplete: function (file, response) {
        $("#shader").fadeOut();
        var locat = window.location.href;
        var _html_li =
          '<li><span class="link_name">' +
          file +
          '</span><input type="hidden" name="instructor[certificate][]" value="' +
          response +
          '"/> <a href="#" data-remove-file-certificate="' +
          response +
          '" class="remove_link">×</a></li>';
        $(".instructor_certificate_container").append(_html_li);
      },
    });
  }
  $(document).on("click", "[data-remove-file-certificate]", function () {
    var _file = $(this).attr("data-remove-certificate");
    var _this = $(this);
    $.ajax({
      url: window.location.href,
      type: "POST",
      cache: false,
      data: "ajax=remove_file_certificate&file=" + _file,
      success: function (_json) {
        if (_json.ack == "Success") {
          _this.parents("li").remove();
        }
      },
    });
    return false;
  });

  $(document).on("click", ".instructor_linker_button", function () {
    var _instructor = $(".instructor_linker")
      .find('[name="instructor_linker[instructor]"]')
      .val();
    var _lessons = $(".instructor_linker")
      .find('[name="instructor_linker[lessons]"]')
      .val();
    var _link = _instructor + _lessons;
    if (_link) {
      $("#share_link").val(_link);
      $(".instructor_linker_result").addClass("active");
      $("#share_link").select();
      document.execCommand("copy");
      alert_mess_success("Посилання скопійовано");
    } else {
      alert_mess_failure("Оберіть інстріктора та кількість занять");
    }
    return false;
  });

  $(document).on("click", ".share_link_a", function () {
    $("#share_link").select();
    document.execCommand("copy");
    alert_mess_success("Посилання скопійовано");
    return false;
  });

  $(document).on("click", "[data-instructor-contact]", function () {
    var _this = $(this),
      _hash = _this.attr("data-instructor-contact");
    if (_hash != "") {
      $.ajax({
        url: location.href,
        data: "ajax=instructor_contact&id=" + _hash,
        success: function (json) {
          if (json.ack == "Success") {
            _this.attr("href", "tel:" + json.href);
            _this.html(json.phone);
            _this.attr("data-instructor-contact", "");
          } else {
            if (json.login) {
              $(".call_login").trigger("click");
            }
            alert_mess_failure(json.error_text);
          }
        },
      });
      return false;
    }
  });

  $(document).on("click", ".uncheck_block_catalog [data-uncheck]", function () {
    var _v = $(this).attr("data-uncheck");
    if (_v == "search") {
      $('[name="s"]').val("");
    } else {
      var _default = $('[name="' + _v + '"]').attr("data-default");
      $('[name="' + _v + '"]').val(_default);
    }
    getCatalog();
    return false;
  });

  $(document).on(
    "click",
    ".uncheck_block_instructors [data-uncheck]",
    function () {
      var _v = $(this).attr("data-uncheck");
      if (_v == "search") {
        $('[name="s"]').val("");
      } else {
        var _default = $('[name="' + _v + '"]').attr("data-default");
        $('[name="' + _v + '"]').val(_default);
      }
      getInstructors();
      return false;
    }
  );

  $(".friends_instructors_slider").slick({
    slidesToShow: 2,
    slidesToScroll: 1,
    autoplay: false,
    arrows: true,
    infinite: true,
    dots: false,
    responsive: [
      {
        breakpoint: 600,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1,
        },
      },
    ],
    nextArrow:
      '<button class="slick-next_arrow slick_arrow" aria-label="Попередня"><svg width="12" height="20" viewBox="0 0 12 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1.71436 18.5714L10.2858 10L1.71436 1.42859" stroke="#1A1A1A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></button>',
    prevArrow:
      '<button class="slick-prev_arrow slick_arrow" aria-label="Наступна"><svg width="12" height="20" viewBox="0 0 12 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M10.2857 1.42856L1.71428 9.99999L10.2857 18.5714" stroke="#1A1A1A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></button>',
  });

  $(".rewiev_slider").slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    centerMode: false,
    autoplay: true,
    arrows: true,
    infinite: true,
    dots: false,
    responsive: [
      {
        breakpoint: 1201,
        settings: {
          slidesToShow: 3,
          slidesToScroll: 1,
          centerPadding: "0",
          centerMode: true,
        },
      },
      {
        breakpoint: 992,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 1,
          centerMode: false,
        },
      },
      {
        breakpoint: 768,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1,
          centerMode: false,
        },
      },
    ],
    nextArrow:
      '<button class="slick-next_arrow slick_arrow" aria-label="Попередня"><svg width="12" height="20" viewBox="0 0 12 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1.71436 18.5714L10.2858 10L1.71436 1.42859" stroke="#1A1A1A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></button>',
    prevArrow:
      '<button class="slick-prev_arrow slick_arrow" aria-label="Наступна"><svg width="12" height="20" viewBox="0 0 12 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M10.2857 1.42856L1.71428 9.99999L10.2857 18.5714" stroke="#1A1A1A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></button>',
  });

  $(".instructor_gallery").slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    autoplay: true,
    arrows: true,
    infinite: true,
    dots: false,
    nextArrow:
      '<button class="slick-next_arrow slick_arrow" aria-label="Попередня"><svg width="12" height="20" viewBox="0 0 12 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1.71436 18.5714L10.2858 10L1.71436 1.42859" stroke="#1A1A1A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></button>',
    prevArrow:
      '<button class="slick-prev_arrow slick_arrow" aria-label="Наступна"><svg width="12" height="20" viewBox="0 0 12 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M10.2857 1.42856L1.71428 9.99999L10.2857 18.5714" stroke="#1A1A1A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></button>',
  });

  $(".product_gallery").slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    autoplay: true,
    arrows: true,
    infinite: true,
    dots: false,
    nextArrow:
      '<button class="slick-next_arrow slick_arrow" aria-label="Попередня"><svg width="12" height="20" viewBox="0 0 12 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1.71436 18.5714L10.2858 10L1.71436 1.42859" stroke="#1A1A1A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></button>',
    prevArrow:
      '<button class="slick-prev_arrow slick_arrow" aria-label="Наступна"><svg width="12" height="20" viewBox="0 0 12 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M10.2857 1.42856L1.71428 9.99999L10.2857 18.5714" stroke="#1A1A1A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></button>',
  });

  $(document).on("click", "[data-tab-product-nav]", function () {
    var _v = $(this).attr("data-tab-product-nav");
    $(".product_tabs_nav a").removeClass("active");
    $(".product_tab").removeClass("active");
    $(this).addClass("active");
    $('[data-product-tab="' + _v + '"]').addClass("active");
    return false;
  });
  $(document).on("click", ".lection_blocked , .gift_promo", function () {
    $("#online_pop").addClass("active");
    $("#shader").fadeIn(300);
    $("body").addClass("body--active");
    return false;
  });
  $(document).on("click", "[data-tab-instructor-nav]", function () {
    var _v = $(this).attr("data-tab-instructor-nav");
    $(".instructor_tabs_nav a").removeClass("active");
    $(".instructor_tab").removeClass("active");
    $(this).addClass("active");
    $('[data-instructor-tab="' + _v + '"]').addClass("active");

    if (_v == "2") {
      $(".instructor_gallery").slick("unslick");
      $(".instructor_gallery").slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        autoplay: true,
        arrows: true,
        infinite: true,
        dots: false,
        nextArrow:
          '<button class="slick-next_arrow slick_arrow" aria-label="Попередня"><svg width="12" height="20" viewBox="0 0 12 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1.71436 18.5714L10.2858 10L1.71436 1.42859" stroke="#1A1A1A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></button>',
        prevArrow:
          '<button class="slick-prev_arrow slick_arrow" aria-label="Наступна"><svg width="12" height="20" viewBox="0 0 12 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M10.2857 1.42856L1.71428 9.99999L10.2857 18.5714" stroke="#1A1A1A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></button>',
      });
    }
    return false;
  });
  $(document).on("click", "[data-tab-nav-click]", function () {
    var _v = $(this).attr("data-tab-nav-click");
    $("[data-tab]").removeClass("active");
    $('[data-tab="' + _v + '"]').addClass("active");
    $("[data-tab-nav-click]").removeClass("active");
    $(this).addClass("active");
    return false;
  });

  $(document).on("click", "[data-click-next-tab]", function () {
    var _v = $(this).attr("data-click-next-tab");
    $("[data-tab]").removeClass("active");
    $('[data-tab-nav-click="' + _v + '"]')
      .parents("li")
      .next("li")
      .find("[data-tab-nav-click]")
      .trigger("click");
    return false;
  });

  $(document).on("click", "[data-pc-nav]", function () {
    var _v = $(this).attr("data-pc-nav");
    var _d = $(this).attr("data-pc-nav").split("-");
    $("[data-pc-nav]").parent().removeClass("active");
    $("[data-pc]").removeClass("active");

    if (_d.length > 1) {
      //inner
      $('[data-pc-nav="' + _v + '"]')
        .parent()
        .addClass("active");
      $('[data-pc-nav="' + _d[0] + '"]')
        .parent()
        .addClass("active");
      $('[data-pc="' + _v + '"]').addClass("active");
      $('[data-pc="' + _d[0] + '"]').addClass("active");
      if ($(window).width() < 992) {
        scroll_to("pc_blocks");
      }
    } else {
      //outer
      $('[data-pc-nav="' + _v + '"]')
        .parent()
        .addClass("active");
      $('[data-pc="' + _v + '"]').addClass("active");
      $('[data-pc="' + _v + '"]')
        .find(".pc_block_inner_nav ul li:first-child a")
        .trigger("click");
    }

    return false;
  });

  function CallPrint(strid) {
    var prtContent = document.getElementById(strid);
    var prtCSS =
      '<link href="/assets/templates/default/css/print.css" rel="stylesheet">';
    var WinPrint = window.open(
      "",
      "",
      "left=50,top=50,width=1024,height=768,toolbar=0,scrollbars=1,status=0"
    );
    WinPrint.document.write('<div id="print" class="contentpane">');
    WinPrint.document.write(prtCSS);
    WinPrint.document.write(prtContent.innerHTML);
    WinPrint.document.write("</div>");
    //WinPrint.document.close();
    WinPrint.focus();
    //WinPrint.print();
    setTimeout(function () {
      WinPrint.print();
    }, 1000);
    //WinPrint.close();
    //prtContent.innerHTML=strOldOne;
  }

  function DownloadPDF(strid) {
    var element = document.getElementById(strid);

    // Додатково додаємо CSS стилі для PDF, якщо потрібно
    var opt = {
      margin: 0.5,
      filename: "certificate.pdf",
      image: { type: "jpeg", quality: 0.98 },
      html2canvas: { scale: 2 },
      jsPDF: { unit: "in", format: "a4", orientation: "portrait" },
    };

    html2pdf().set(opt).from(element).save();
    setTimeout(function () {
      $("#print-content").fadeOut(0);
    }, 200);
  }

  $(document).on("click", "[data-get-sertificate]", function () {
    var _id = $(this).attr("data-get-sertificate");
    $.ajax({
      url: location.href,
      data: "ajax=get_sertificate&id=" + _id,
      success: function (json) {
        if (json.ack == "Success") {
          $("#print-content").html(json.print);
          //CallPrint('print-content');
          $("#print-content").fadeIn(0);
          setTimeout(function () {
            DownloadPDF("print-content");
          }, 500);
        }
      },
    });
    return false;
  });

  $(document).on("click", "#print-content", function () {
    setTimeout(function () {
      DownloadPDF("print-content");
    }, 500);
    return false;
  });

  $(document).on("click", "[data-check-lection]", function () {
    var _id = $(this).attr("data-check-lection");
    var _next = $(this).attr("href");
    $.ajax({
      url: location.href,
      data: "ajax=lection_done&id=" + _id,
      success: function (json) {
        if (json.ack == "Success") {
          window.location.replace(_next);
        }
      },
    });
    return false;
  });

  $(document).on("click", ".lection_nav_mob a", function () {
    if ($(this).hasClass("active")) {
      $(this).removeClass("active");
      $(this).parent().next().removeClass("active");
    } else {
      $(this).addClass("active");
      $(this).parent().next().addClass("active");
    }
    return false;
  });
  $(document).on("click", "[data-show-theme]", function () {
    if ($(this).parents(".tpl_catalog_lection").hasClass("active")) {
      $(this).parents(".tpl_catalog_lection").removeClass("active");
    } else {
      $(this).parents(".tpl_catalog_lection").addClass("active");
    }
    return false;
  });

  $(document).on("click", "[data-category-nav]", function () {
    var _v = $(this).attr("data-category-nav");
    $("[data-category-nav]").removeClass("active");
    $(this).addClass("active");
    $("[data-category-tab]").removeClass("active");
    $('[data-category-tab="' + _v + '"]').addClass("active");
    return false;
  });

  $(document).on("click", "[data-scroll-to]", function () {
    var _v = $(this).attr("data-scroll-to");
    $("html, body").animate(
      {
        scrollTop: $("." + _v).offset().top - 200,
      },
      800
    );
    return false;
  });

  $(document).on("click", ".load_more", function () {
    preloadOn();
    switch ($(this).attr("data-type-load")) {
      case "1":
        getInstructorsMore();
        break;
      case "2":
        getCatalogMore();
        break;
    }
    return false;
  });

  $(document).on("change", ".catalog_search select", function () {
    getCatalog();
    return false;
  });
  $(document).on("focusout", ".catalog_search input.search_text", function () {
    getCatalog();
    return false;
  });
  $(document).on("submit", ".catalog_search", function (event) {
    getCatalog();
    return false;
  });

  $(document).on("change", ".instructor_search select", function () {
    getInstructors();
    return false;
  });

  $(document).on(
    "focusout",
    ".instructor_search input.search_text",
    function () {
      getInstructors();
      return false;
    }
  );

  $(document).on("submit", ".instructor_search", function (event) {
    getInstructors();
    return false;
  });

  $(document).on("change", "#i_category", function () {
    $(this).parents(".i_block_box").find("a").attr("href", $(this).val());
    window.location.replace($(this).val());
    return false;
  });

  $(document).on("keyup", ".form input", function (event) {
    if (event.which == 13) {
      $(this).parents("form").submit();
    }
    return false;
  });

  $(".review_star_list_dinamic li").hover(
    function () {
      $(this).addClass("review_star_list_dinamic--active");
      $(this).prevAll("li").addClass("review_star_list_dinamic--active");
    },
    function () {
      $(this).removeClass("review_star_list_dinamic--active");
      $(this).prevAll("li").removeClass("review_star_list_dinamic--active");
    }
  );

  $(".review_star_list_dinamic li").on("touchend click", function (event) {
    $(this)
      .parent(".review_star_list_dinamic")
      .children("li")
      .removeClass("review_star--active_btn");
    $(this)
      .parent(".review_star_list_dinamic")
      .children("li")
      .removeClass("review_star_list_dinamic--active");

    $(this).addClass("review_star--active_btn");
    $(this).prevAll("li").addClass("review_star--active_btn");

    $(".hidden_rating").val(parseInt($(this).index()) + 1);
  });

  document.querySelectorAll(".googleCity").forEach((e) => {
    const t = new google.maps.places.Autocomplete(e, {
      types: ["(cities)"],
    });
    t.addListener("place_changed", () => {
      t.getPlace();
    });
  });

  $("[data-allow]").on("keyup", function (e) {
    var _key = e.keyCode;
    if (_key != 36 && _key != 37 && _key != 39 && _key != 65 && _key != 35)
      $(this).val(
        $(this)
          .val()
          .replace(new RegExp($(this).attr("data-allow")), "")
      );
  });

  $(document).on("focusout", ".fast_count_product", function () {
    var _this = $(this);
    var _id = _this.parents(".fastbuy_product_counter").data("product-id");
    var _count = _this.val();

    $.ajax({
      url: location.href,
      data: {
        ajax: "fastbuy_form",
        product_id: _id,
        count: _count,
      },
      beforeSend: function () {
        preloadOn();
      },
      success: function (json) {
        preloadOff();
        if (json.ack == "Success") {
          $("#fastbuy_pop .fastbuy_product").html(json.product);
        } else {
          alert_mess_failure("Щось пішло не так, зверніться до адміністратора");
        }
      },
    });
  });

  $(document).on("click", ".count_plus , .count_minus", function () {
    var _this = $(this);
    var _id = _this.parents(".fastbuy_product_counter").data("product-id");
    var _val = parseInt(
      _this.parents(".fastbuy_product_counter").data("product-count")
    );

    if (_this.hasClass("count_plus")) {
      var _newVal = _val + 1;
    } else {
      var _newVal = _val - 1;
    }

    $.ajax({
      url: location.href,
      data: {
        ajax: "fastbuy_form",
        product_id: _id,
        count: _newVal,
      },
      beforeSend: function () {
        preloadOn();
      },
      success: function (json) {
        preloadOff();
        if (json.ack == "Success") {
          $("#fastbuy_pop .fastbuy_product").html(json.product);
        } else {
          alert_mess_failure("Щось пішло не так, зверніться до адміністратора");
        }
      },
    });
  });

  $(document).on("click", ".restart_game", function (event) {
    window.location.reload();
    return false;
  });

  $(document).on("click", ".info_p", function (event) {
    if ($(this).hasClass("active")) {
      $(this).removeClass("active");
    } else {
      $(this).addClass("active");
    }
    return false;
  });

  $(document).on("change", "#client_type_switch", function (event) {
    if ($(this).prop("checked")) {
      $(".client_old_form").removeClass("active");
      $(".client_new_form").addClass("active");
    } else {
      $(".client_old_form").addClass("active");
      $(".client_new_form").removeClass("active");
    }
    return false;
  });

  $(document).on("click", "[data-client-select]", function () {
    $(".client_search_result").css("display", "none");
    $("#overflow_1").fadeOut();
    $("#client_id_select").val($(this).attr("data-client-select"));
    $("#client_id_search").val($(this).html());
    return false;
  });

  $("#client_id_search").on("keyup", function () {
    if ($(this).val().length >= 2) {
      jQuery.ajax({
        url: window.location.href,
        type: "POST",
        cache: false,
        data: {
          search: $(this).val(),
          ajax: "search_client",
          school: $(this).attr("data-client-search"),
        },
        cache: false,
        success: function (json) {
          if (json.ack == "Failure") {
            $(".client_search_result").css("display", "none");
            $("#overflow_1").fadeOut();
          } else {
            $(".client_search_result").css("display", "block");
            $(".client_search_result").html(json.clients);
            $("#overflow_1").fadeIn();
          }
        },
      });
    } else {
      $(".client_search_result").css("display", "none");
      $("#overflow_1").fadeOut();
      $("#client_id_select").val("");
    }
  });

  $(document).on("click", "#overflow_1", function () {
    $(".client_search_result").css("display", "none");
    $("#overflow_1").fadeOut();
    return false;
  });

  $(document).on("change", '[name="bill[product]"]', function () {
    var _val = $(this).val();
    var _lessons = $('[name="bill[product]"]')
      .find('[value="' + _val + '"]')
      .attr("data-product-count");
    $('[name="bill[amount]"]').val(_lessons);
    return false;
  });

  $(document).on("change", "#bill_switch", function (event) {
    if ($(this).prop("checked")) {
      $('[data-bill-type="0"]').removeClass("active");
      $('[data-bill-type="1"]').addClass("active");
    } else {
      $('[data-bill-type="1"]').removeClass("active");
      $('[data-bill-type="0"]').addClass("active");
    }
    return false;
  });

  $(document).on("submit", ".manager_bill", function () {
    var _this = $(this),
      _data = _this.serialize();
    $.ajax({
      url: location.href,
      beforeSend: function () {
        preloadOn();
      },
      data: "ajax=manager_bill&" + _data,
      success: function (json) {
        preloadOff();
        $(".error_input").removeClass("error_input");
        if (json.ack == "Failure") {
          $.each(json.errors, function (key, value) {
            var _type = $('[name="' + value + '"]')
              .prop("tagName")
              .toLowerCase();
            switch (_type) {
              case "select":
                $('[name="' + value + '"]')
                  .parent()
                  .addClass("error_input");
                break;
              default:
                $('[name="' + value + '"]').addClass("error_input");
                break;
            }
          });
          if (json.msg.length > 0) {
            alert_mess_failure(json.msg);
          }
        } else {
          _this.css("display", "none");
          _this.next(".manager_bill_thanks_text").fadeIn(200);
        }
      },
    });
    return false;
  });

  if ($(window).width() > 992) {
    $(".game_left_block").draggable({
      helper: "clone", // Клон блока при перетаскивании
      revert: "invalid", // Возврат в исходное положение, если не попал в цель
    });
    // Установка правого контейнера как зоны сброса
    $(".road_sign_game_drop_zone").droppable({
      accept: ".game_left_block", // Принимает только блоки из левого контейнера
      drop: function (event, ui) {
        var droppedOn = $(event.target); // Целевая зона сброса

        if (droppedOn.find(".game_left_block").length === 0) {
          // Добавление блока в правый контейнер
          var draggable = ui.draggable;
          draggable.detach();
          $(this).append(draggable); // Добавление в правый контейнер
          var _left = draggable.attr("data-sign-game");
          var _right =
            event.target.attributes.getNamedItem("data-sign-game-r").value;
          if (_left == _right) {
            $(this).parents(".road_sign_game_right_block").addClass("correct");
          } else {
            $(this)
              .parents(".road_sign_game_right_block")
              .addClass("incorrect");
          }
        } else {
          ui.draggable.draggable("option", "revert", true);
        }
      },
    });
  } else {
    $(document).on(
      "click",
      ".road_sign_game_left .game_left_block",
      function () {
        $(".game_left_block").removeClass("active");
        $(this).addClass("active");
        return false;
      }
    );

    $(document).on("click", ".road_sign_game_drop_zone", function () {
      if ($(".game_left_block.active").length > 0) {
        if ($(this).find(".game_left_block").length > 0) {
          alert_mess_failure("Вже заповнено, оберіть інший");
        } else {
          var _left = $(".game_left_block.active").attr("data-sign-game");
          var _right = $(this).attr("data-sign-game-r");
          $(".game_left_block.active").appendTo(this);
          $(".game_left_block.active").removeClass("active");
          if (_left == _right) {
            $(this).parents(".road_sign_game_right_block").addClass("correct");
          } else {
            $(this)
              .parents(".road_sign_game_right_block")
              .addClass("incorrect");
          }
        }
      } else {
        alert_mess_failure("Спочатку оберіть знак зліва");
      }
      return false;
    });
  }
  $(".content table").wrap('<div class="table_mobile"></div>');

  setInterval(function () {
    $(".bubbly-button").addClass("animate");
    setTimeout(function () {
      $(".bubbly-button").removeClass("animate");
    }, 700);
  }, 3500);

  $(document).on("click", ".search_text_mob_btn", function () {
    $(".search_text").val($(".search_text_mob").val());
    getInstructors();
    return false;
  });
  $(document).on("keyup", ".search_text_mob", function (event) {
    if (event.which == 13) {
      $(".search_text").val($(".search_text_mob").val());
      getInstructors();
    }
    return false;
  });

  if ($(".instructors_page").length > 0) {
  }

  $(document).on("click", "[data-bill-remove]", function (e) {
    var _id = $(this).attr("data-bill-remove");
    $.ajax({
      url: location.href,
      data: "ajax=ituw_remove_row&id=" + _id,
      success: function (json) {
        if (json["ack"] == "Success") {
          alert_mess_failure(json.message);
          search_roww();
        } else {
          alert_mess_failure(json.message);
        }
      },
    });
    return false;
  });
  $(document).on("click", "[data-bill-back]", function (e) {
    var _id = $(this).attr("data-bill-back");
    $.ajax({
      url: location.href,
      data: "ajax=ituw_back_row&id=" + _id,
      success: function (json) {
        if (json["ack"] == "Success") {
          alert_mess_failure(json.message);
          search_roww();
        } else {
          alert_mess_failure(json.message);
        }
      },
    });
    return false;
  });
  $(document).on("click", "[data-bill-edit]", function (e) {
    var _id = $(this).attr("data-bill-edit");
    $.ajax({
      url: location.href,
      data: "ajax=ituw_edit_row&id=" + _id,
      success: function (json) {
        if (json["ack"] == "Success") {
          $("#row_edit_pop").addClass("active");
          $("#shader").fadeIn(300);
          $("body").addClass("body--active");
          $("#row_edit_pop form").fadeIn(0);
          $("#row_edit_pop .thanks_text").fadeOut(0);
          $("#row_edit_pop .hold_form").html(json.row_edit);

          $("select").chosen("updated");
          $("[data-active]").each(function () {
            _ids = $(this).attr("data-active").split(",");
            for (_i in _ids) {
              _option = $(this).find('option[value="' + _ids[_i] + '"]');
              _option.prop("selected", true);
            }
            $(this).trigger("chosen:updated");
          });
        } else {
          alert_mess_failure(json.message);
        }
      },
    });
    return false;
  });
  $(document).on("click", "[data-edit-row]", function (e) {
    var _id = $(this).attr("data-edit-row");
    $.ajax({
      url: location.href,
      data: "ajax=itu_edit_row&id=" + _id,
      success: function (json) {
        if (json["ack"] == "Success") {
          $("#row_edit_pop").addClass("active");
          $("#shader").fadeIn(300);
          $("body").addClass("body--active");
          $("#row_edit_pop form").fadeIn(0);
          $("#row_edit_pop .thanks_text").fadeOut(0);
          $("#row_edit_pop .hold_form").html(json.row_edit);

          $("select").chosen("updated");
          $("[data-active]").each(function () {
            _ids = $(this).attr("data-active").split(",");
            for (_i in _ids) {
              _option = $(this).find('option[value="' + _ids[_i] + '"]');
              _option.prop("selected", true);
            }
            $(this).trigger("chosen:updated");
          });
        } else {
          alert_mess_failure(json.message);
        }
      },
    });
    return false;
  });

  $(document).on("click", "[data-instructor-edit]", function (e) {
    var _id = $(this).attr("data-instructor-edit");
    $.ajax({
      url: location.href,
      data: "ajax=instructor_edit&id=" + _id,
      success: function (json) {
        if (json["ack"] == "Success") {
          $("#instructor_edit_pop").addClass("active");
          $("#shader").fadeIn(300);
          $("body").addClass("body--active");
          $("#instructor_edit_pop form").fadeIn(0);
          $("#instructor_edit_pop .thanks_text").fadeOut(0);
          $("#instructor_edit_pop .hold_form").html(json.row_edit);

          $("select").chosen("updated");
          $("[data-active]").each(function () {
            _ids = $(this).attr("data-active").split(",");
            for (_i in _ids) {
              _option = $(this).find('option[value="' + _ids[_i] + '"]');
              _option.prop("selected", true);
            }
            $(this).trigger("chosen:updated");
          });
        } else {
          alert_mess_failure(json.message);
        }
      },
    });
    return false;
  });
  $(document).on("submit", "#instructor_edit_pop form", function (e) {
    var _this = $(this),
      _data = _this.serialize();
    $.ajax({
      url: location.href,
      data: "ajax=instructor_update&" + _data,
      success: function (json) {
        if (json["ack"] == "Success") {
          _this.fadeOut(0);
          _this.next(".thanks_text").fadeIn(0);
          search_instructor();
        } else {
          alert_mess_failure(json.message);
        }
      },
    });
    return false;
  });

  $(document).on("submit", "#row_edit_pop form", function (e) {
    var _this = $(this),
      _data = _this.serialize();
    $.ajax({
      url: location.href,
      data: "ajax=itu_update_row&" + _data,
      success: function (json) {
        if (json["ack"] == "Success") {
          _this.fadeOut(0);
          _this.next(".thanks_text").fadeIn(0);
          switch (json.type) {
            case "itu":
              search_row();
              break;
            case "ituw":
              search_roww();
              break;
          }
        } else {
          alert_mess_failure(json.message);
        }
      },
    });
    return false;
  });
  function search_roww() {
    if ($("#search_roww_switch").prop("checked")) {
      var _archive = 1;
    } else {
      var _archive = 0;
    }

    jQuery.ajax({
      url: window.location.href,
      type: "POST",
      cache: false,
      data: {
        search: $("#search_roww").val(),
        ajax: "search_roww",
        school: $("#school_id").val(),
        archive: _archive,
        page: $("#page_roww").val(),
      },
      cache: false,
      success: function (json) {
        $("#row_clientsw").html(json.row_clientsw);
        $('[data-paginate="list_order_school"]').html(
          json.paginate_list_order_school
        );
      },
    });
  }
  function search_row() {
    if ($("#search_row_switch").prop("checked")) {
      var _archive = 1;
    } else {
      var _archive = 0;
    }
    jQuery.ajax({
      url: window.location.href,
      type: "POST",
      cache: false,
      data: {
        search: $("#search_row").val(),
        ajax: "search_row",
        school: $("#school_id").val(),
        archive: _archive,
        page: $("#page_row").val(),
      },
      cache: false,
      success: function (json) {
        $("#row_clients").html(json.row_clients);
        $('[data-paginate="list_schedule_school"]').html(
          json.paginate_list_schedule_school
        );
      },
    });
  }
  function search_instructor() {
    if ($("#search_instructor_switch").prop("checked")) {
      var _archive = 1;
    } else {
      var _archive = 0;
    }
    jQuery.ajax({
      url: window.location.href,
      type: "POST",
      cache: false,
      data: {
        search: $("#search_instructor").val(),
        ajax: "search_instructor",
        school: $("#school_id").val(),
        archive: _archive,
        page: $("#page_instructor").val(),
      },
      cache: false,
      success: function (json) {
        $("#row_instructors").html(json.row_instructors);
        $('[data-paginate="list_instructors_school"]').html(
          json.paginate_list_instructors_school
        );
      },
    });
  }

  $("#search_instructor").on("keyup", function () {
    $("#page_instructor").val("1");
    search_instructor();
  });
  $("#search_row").on("keyup", function () {
    $("#page_row").val("1");
    search_row();
  });
  $("#search_roww").on("keyup", function () {
    $("#page_roww").val("1");
    search_roww();
  });

  $(document).on("change", "#search_instructor_switch", function (event) {
    $("#page_instructor").val("1");
    search_instructor();
    return false;
  });
  $(document).on("change", "#search_row_switch", function (event) {
    $("#page_row").val("1");
    search_row();
    return false;
  });
  $(document).on("change", "#search_roww_switch", function (event) {
    $("#page_roww").val("1");
    search_roww();
    return false;
  });

  $(document).on("click", "[data-page]", function (event) {
    var _type = $(this).parents("[data-paginate]").attr("data-paginate");
    var _page = $(this).attr("data-page");
    switch (_type) {
      case "list_schedule_school":
        $("#page_row").val(_page);
        $("#page_instructor").val(_page);
        search_row();
        break;
      case "list_order_school":
        $("#page_roww").val(_page);
        search_roww();
        break;
      case "list_instructors_school":
        $("#page_instructor").val(_page);
        search_instructor();
        break;
    }
    return false;
  });

  $(document).on("click", ".hide_show_pc_nav", function (event) {
    if ($(this).hasClass("active")) {
      $(".pc_holder").removeClass("hidden_pc_navigation");
      $(this).removeClass("active");
    } else {
      $(".pc_holder").addClass("hidden_pc_navigation");
      $(this).addClass("active");
    }
    return false;
  });
});
