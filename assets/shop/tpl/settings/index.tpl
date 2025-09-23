<!DOCTYPE HTML>
<html lang="en-US">
<head>
    <title><?=$_lang["shop_settings"]?></title>
    <meta charset="UTF-8">
    <script src="/assets/site/jquery.min.js"></script>
    <link href="/assets/site/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/site/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet">
    <link href="/assets/site/bootstrap/css/datetime.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/site/bootstrap/css/switcher.min.css">
    <link rel="stylesheet" href="/assets/site/interface.css" />
    <link rel="stylesheet" href="/assets/site/chosen/chosen.min.css" />
    <script src="/assets/site/bootstrap/js/bootstrap.min.js"></script>
    <script src="/assets/site/chosen/chosen.jquery.min.js"></script>
    <script src="/assets/site/bootstrap/js/switcher.min.js"></script>
    <link href="/assets/site/css/daterangepicker.css" rel="stylesheet">
    <script src="/assets/site/bootstrap/js/datetime.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/assets/site/css/mm-autocomplete.css">
    <!--графики-->
    <link href="/assets/site/css/xcharts.min.css" rel="stylesheet">
    <link href="/assets/site/css/daterangepicker.css" rel="stylesheet">
    <link href="/assets/site/bootstrap/css/colorpicker.css" rel="stylesheet">
    <style>


      .icon-time{
        background: url(/assets/site/images/clock.svg);
        display: block;
        width: 20px;
        height: 20px;
        background-size: 100%;
        margin: 5px auto;
      }
      .icon-chevron-up{
        background: url(/assets/site/images/chevron_up.svg);
        display: block;
        background-repeat:no-repeat;
        width: 20px;
        height: 15px;
        background-size: 100%;
      }
      .icon-chevron-down{
        background: url(/assets/site/images/chevron_down.svg);
        display: block;
        width: 20px;
        background-repeat:no-repeat;
        height: 15px;
        background-size: 100%;
      }
      body { background: url(/manager/media/style/MODxRE/images/body.jpg);}
      .both {clear:both;}
      .container {width:90%;}
      .jumbotron {text-align: center; background-color: transparent;}
      .jumbotron .btn {font-size: 21px; padding: 14px 24px; }
      .nav-justified {background-color: #eee; border-radius: 5px; border: 1px solid #ccc; }
      .nav-justified > li > a {margin-bottom: 0; padding-top: 15px; padding-bottom: 15px; color: #777; font-weight: bold; text-align: center; border-bottom: 1px solid #d5d5d5; background-color: #e5e5e5; /* Old browsers */ background-repeat: repeat-x; /* Repeat the gradient */ background-image: -moz-linear-gradient(top, #f5f5f5 0%, #e5e5e5 100%); /* FF3.6+ */ background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#f5f5f5), color-stop(100%,#e5e5e5)); /* Chrome,Safari4+ */ background-image: -webkit-linear-gradient(top, #f5f5f5 0%,#e5e5e5 100%); /* Chrome 10+,Safari 5.1+ */ background-image: -o-linear-gradient(top, #f5f5f5 0%,#e5e5e5 100%); /* Opera 11.10+ */ filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f5f5f5', endColorstr='#e5e5e5',GradientType=0 ); /* IE6-9 */ background-image: linear-gradient(top, #f5f5f5 0%,#e5e5e5 100%); /* W3C */ }
      .nav-justified > .active > a,
      .nav-justified > .active > a:hover,
      .nav-justified > .active > a:focus {
        background-color: #ddd;
        background-image: none;
        box-shadow: inset 0 3px 7px rgba(0,0,0,.15);
      }
      .nav-justified > li:first-child > a {
        border-radius: 5px 5px 0 0;
      }
      .nav-justified > li:last-child > a {
        border-bottom: 0;
        border-radius: 0 0 5px 5px;
      }

      @media (min-width: 768px) {
        .nav-justified {
          max-height: 52px;
        }
        .nav-justified > li > a {
          border-left: 1px solid #fff;
          border-right: 1px solid #d5d5d5;
        }
        .nav-justified > li:first-child > a {
          border-left: 0;
          border-radius: 5px 0 0 5px;
        }
        .nav-justified > li:last-child > a {
          border-radius: 0 5px 5px 0;
          border-right: 0;
        }
      }

      /* Responsive: Portrait tablets and up */
      @media screen and (min-width: 768px) {
        /* Remove the padding we set earlier */
        .masthead,
        .marketing,
        .footer {
          padding-left: 0;
          padding-right: 0;
        }
      }
      textarea {resize:vertical;}
    </style>
    <script type="text/javascript">
       
        $(document).ready(function(){
            $("[data-active]").each(function(){
              _ids = $(this).attr("data-active").split(",");
              for (_i in _ids) {
                 _option = $(this).find("option[value='"+_ids[_i]+"']");
                 _option.prop("selected", true);
              }
              $(this).trigger("liszt:updated");
            });
            $("[title]").tooltip({placement:'bottom'});
            $("select").not(".nc").chosen();
            $('.make-switch').bootstrapSwitch('setOnLabel', '<?=$_lang["yes"];?>');
            $('.make-switch').bootstrapSwitch('setOffLabel', '<?=$_lang["no"];?>');
            $('.make-switch').bootstrapSwitch('setSizeClass', 'switch-small');
        });
    </script>
</head>
<body>

  <div class="container">
    <br>
    <? if (isset($_GET['w'])): ?>
      <br>
      <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong><?=$messages[$_GET['w']]?></strong>
      </div>
    <? endif ?>
    <div class="content">
      <h3><?=$title?></h3>
       <ul class="nav nav-justified">
        <li <?=($_GET['b'] == "" ? 'class="active"' : '')?>><a href="<?=$url?>">Загальні</a></li>
        <li <?=($_GET['b'] == "payments" ? 'class="active"' : '')?>><a href="<?=$url?>b=payments">Платіжна система</a></li>
        <li <?=($_GET['b'] == "seo" ? 'class="active"' : '')?>><a href="<?=$url?>b=seo">SEO</a></li>
        <li <?=($_GET['b'] == "promo" ? 'class="active"' : '')?>><a href="<?=$url?>b=promo">PROMOCODE</a></li>
      </ul>
      <?=$res['content']?>
    </div>
  </div>
</body>
</html>