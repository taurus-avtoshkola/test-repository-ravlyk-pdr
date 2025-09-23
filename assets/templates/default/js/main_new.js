$(document).ready(function () {
  $(".gallery").slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    autoplay: true,
    arrows: true,
    infinite: false,
    dots: true,
    nextArrow:
      '<button class="slick-next_arrow slick_arrow" aria-label="РџРѕРїРµСЂРµРґРЅСЏ"><svg xmlns="http://www.w3.org/2000/svg" width="40" height="40"><path fill="transparent" stroke="hsl(0, 0%, 100%)" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.5 12.5 25 20l-7.5 7.5"/></svg></button>',
    prevArrow:
      '<button class="slick-prev_arrow slick_arrow" aria-label="РќР°СЃС‚СѓРїРЅР°"><svg xmlns="http://www.w3.org/2000/svg" width="40" height="40"><path fill="transparent" stroke="hsl(0, 0%, 100%)" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M22.5 12.5 15 20l7.5 7.5"/></svg></button>',
  });

  $(".gallery_2").slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    autoplay: true,
    arrows: true,
    infinite: false,
    dots: true,
    nextArrow:
      '<button class="slick-next_arrow slick_arrow" aria-label="РџРѕРїРµСЂРµРґРЅСЏ"><svg xmlns="http://www.w3.org/2000/svg" width="40" height="40"><path fill="transparent" stroke="hsl(0, 0%, 100%)" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.5 12.5 25 20l-7.5 7.5"/></svg></button>',
    prevArrow:
      '<button class="slick-prev_arrow slick_arrow" aria-label="РќР°СЃС‚СѓРїРЅР°"><svg xmlns="http://www.w3.org/2000/svg" width="40" height="40"><path fill="transparent" stroke="hsl(0, 0%, 100%)" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M22.5 12.5 15 20l7.5 7.5"/></svg></button>',
  });

  $(document).on("click", ".btn_gift_certificate", function (e) {
    $("#gift_certificate_pop").addClass("active");
    $("#shader").fadeIn(300);
    $("body").addClass("body--active");
    return false;
  });

  $(document).on("submit", ".gift_certificate_form", function () {
    var _this = $(this),
      _data = _this.serialize();

    $.ajax({
      url: location.href,
      beforeSend: function () {
        preloadOn();
      },
      data: "ajax=gift_certificate&" + _data,
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

          // fbq("track", "Lead");
          // dataLayer.push({
          //   event: json.event,
          // });

          $(".gift_certificate_form_part_2").addClass("active");
        }
      },
    });
    return false;
  });

  $(document).on("click", ".go_lector_package", function (e) {
    $("#pop_lector_package").addClass("active");
    $("#shader").fadeIn(300);
    $("body").addClass("body--active");
    return false;
  });

  $(document).on("submit", ".lector_package_form", function () {
    var _this = $(this),
      _data = _this.serialize();

    $.ajax({
      url: location.href,
      beforeSend: function () {
        preloadOn();
      },
      data: "ajax=lector_package&" + _data,
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

          // fbq("track", "Lead");
          // dataLayer.push({
          //   event: json.event,
          // });

          $(".lector_package_form_part_2").addClass("active");
        }
      },
    });
    return false;
  });
});
