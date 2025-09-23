<!DOCTYPE HTML>
<html lang="en-US">
<head>
    <title>Главный менеджер</title>
    <meta charset="UTF-8">
    <script src="/assets/site/jquery.min.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <link href="/assets/site/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/site/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet">
    <link href="/assets/site/bootstrap/css/datetime.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="/assets/site/bootstrap/css/switcher.min.css">
    <link rel="stylesheet" href="/assets/site/interface.css" />
    <link rel="stylesheet" href="/assets/site/chosen/chosen.min.css" />
    <link rel="stylesheet" type="text/css" href="/assets/site/css/mm-autocomplete.css">

    

    <link href="/assets/site/fancybox/jquery.fancybox.min.css" rel="stylesheet">
    <script src="/assets/site/fancybox/jquery.fancybox.min.js"></script>

    <link href="/assets/site/css/daterangepicker.css" rel="stylesheet">
    <link href="/assets/site/bootstrap/css/colorpicker.css" rel="stylesheet">
<script src="/assets/site/js/mask.js"></script>
<script type="text/javascript" src="/assets/site/bootstrap/js/colorpicker.js"></script>
<script src="/assets/site/bootstrap/js/bootstrap-tab.js"></script>
<style>
.tt-hint{
    width: 100%!important;
}
#dataConfirmModal{
top: 20%;
left: 45%;
background: #fff;
height: 280px;
width: 250px;
border-radius: 20px;
overflow: visible;
}
#dataConfirmLabel{
    text-align: center;
}
.images_joomla li, 
.images_trs li {
    float: left;
    margin: 5px;
    position: relative;
}
.images_joomla li a,
.images_trs li a{
    position: absolute;
    bottom: 0px;
}
.alert_pop{
    display: none;
    position: fixed;
    width: 500px;
    top: 55%;
    left: 50%;
    z-index: 1050;
    margin-left: -250px;
}
.alert_pop .alert{
    box-shadow: 2px 2px 2px #999;
}
.alert_pop .close{
    width: 40px;
    line-height: 40px;
    height: 40px;
}
.has-error .chosen-choices{
    border-color: #b94a48;
    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,0.075);
    box-shadow: inset 0 1px 1px rgba(0,0,0,0.075);
}
.nav-justified > li > a{
    display: flex;
    align-items: center;
    gap: 10px;
    flex-direction: column;
    justify-content: flex-start;
}
.nav-justified > li > a span{
    height: 32px;
    display: flex;
    align-items: center;
}
.masthead{

    line-height: normal;
}
.nav-justified{
    max-height: inherit;
}
</style>
 
    <script src="/assets/site/bootstrap/js/switcher.min.js"></script>
    <script src="/assets/site/bootstrap/js/datetime.min.js"></script>
    <script src="/assets/site/chosen/chosen.jquery.min.js"></script>
    <script src="/assets/site/typeahead.min.js"></script>
    <script type="text/javascript" src="/assets/site/js/mm-autocomplete.js"></script>
    <script type="text/javascript">
        String.prototype.translit = (function(){
                var L = {
                    'А' : 'A','а' : 'a','Б' : 'B','б' : 'b','В' : 'V','в' : 'v','Г' : 'G','г' : 'g','Д' : 'D','д' : 'd','Е' : 'E','е' : 'e','Ё' : 'Yo','ё' : 'yo','Ж' : 'Zh','ж' : 'zh','З' : 'Z','з' : 'z','И' : 'I','и' : 'i','Й' : 'Y','й' : 'y','К' : 'K','к' : 'k','Л' : 'L','л' : 'l','М' : 'M','м' : 'm','Н' : 'N','н' : 'n','О' : 'O','о' : 'o','П' : 'P','п' : 'p','Р' : 'R','р' : 'r','С' : 'S','с' : 's','Т' : 'T','т' : 't','У' : 'U','у' : 'u','Ф' : 'F','ф' : 'f','Х' : 'Kh','х' : 'kh','Ц' : 'Ts','ц' : 'ts','Ч' : 'Ch','ч' : 'ch','Ш' : 'Sh','ш' : 'sh','Щ' : 'Sch','щ' : 'sch','Ъ' : '','ъ' : '','Ы' : 'Y','ы' : 'y','Ь' : "",'ь' : "",'Э' : 'E','э' : 'e','Ю' : 'Yu','ю' : 'yu','Я' : 'Ya','я' : 'ya',' ' : '-','&' : '','"' : '',"'" : '','%' : '',',' : '','.' : '','!' : '','І' : 'I','і' : 'i','Є' : 'E','є' : 'e','Ґ' : 'G','ґ' : 'g','Ї' : 'i','ї' : 'i','~' : '','`' : '',';' : '',':' : '',')' : '','(' : '','*' : '','@' : '','#' : '','$' : '','^' : '','+' : '','=' : '','?' : '', "_":"","/":''
                    },
                    r = '',
                    k;
                for (k in L) r += k;
                r = new RegExp('[' + r + ']', 'g');
                k = function(a){
                    return a in L ? L[a] : '';
                };
                return function(){
                    return this.replace(r, k);
                };
            })();
    function alert_mess(val){
        $('.alert_pop').fadeIn(100);
        $('.alert_pop .alert').html(val);
        setTimeout(function(){
            $('.alert_pop').fadeOut(100);
        },3000);
    }
        $(document).ready(function(){

  $('.fancybox').fancybox();

            $(document).on('click','.close_confirmmodal',function(){
                $('#dataConfirmModal').fadeOut(200);
                $('#dataConfirmModal').remove();
                return false;
            });
            $('a[data-confirm]').click(function(ev) {
                var href = $(this).attr('href');
                if (!$('#dataConfirmModal').length) {
                    $('body').append('<div id="dataConfirmModal" class="modal" role="dialog" aria-labelledby="dataConfirmLabel" aria-hidden="true"><div class="modal-header"><button type="button" class="close close_confirmmodal">×</button><h3 id="dataConfirmLabel">Подтвердите действие</h3></div><div class="modal-body"></div><div class="modal-footer"><button class="btn close_confirmmodal">Отмена</button><a class="btn btn-primary" id="dataConfirmOK">Удалить</a></div></div>');
                } 
                $('#dataConfirmModal').find('.modal-body').text($(this).attr('data-confirm'));
                $('#dataConfirmOK').attr('href', href);
                $('#dataConfirmModal').fadeIn(200);
                return false;
            });
            $('form').bind("keypress", function(e) {
              if (e.keyCode == 13) {               
                e.preventDefault();
                return false;
              }
            });
            //fade_out_modal
            $(".dt").datetimepicker({format: 'yyyy-MM-dd hh:mm:ss'});
            $(".dt_").datetimepicker({format: 'yyyy-MM-dd', pickTime:false});

            $("[data-active]").each(function(){
              _ids = $(this).attr("data-active").split(",");
              for (_i in _ids) {
                 _option = $(this).find("option[value='"+_ids[_i]+"']");
                 _option.prop("selected", true);
              }
              $(this).trigger("liszt:updated");
            });
            $("[data-allow]").on("keyup", function(e){
                var _key = e.keyCode;
                if (_key != 36 && _key != 37 && _key != 39 && _key != 65 && _key != 35)
                    $(this).val($(this).val().replace(new RegExp($(this).attr("data-allow")), ''));
            })

            $("[data-product-price]").on("blur", function(){
                _this = $(this);
                $.ajax({url:"index.php",data:"a=112&id=6&b=update_price&pid="+_this.attr("data-product-price")+"&price="+_this.val(), success:function(ajax){
                    _this.parents(".control-group").addClass("success");
                }})
            })

            $("[data-product-price-new]").on("blur", function(){
                _this = $(this);
                $.ajax({url:"index.php",data:"a=112&id=6&b=update_price_new&pid="+_this.attr("data-product-price-new")+"&price="+_this.val(), success:function(ajax){
                    _this.parents(".control-group").addClass("success");
                }})
            })
            $("#pagetitle").on("keyup", function (){
                $("#alias").val($(this).val().translit().toLowerCase()+'/');
            });
            //$("[title]").tooltip({placement:'bottom'});
            $("select").not(".nc").chosen();
            $('.make-switch').bootstrapSwitch('setOnLabel', '<?=$_lang["yes"];?>');
            $('.make-switch').bootstrapSwitch('setOffLabel', '<?=$_lang["no"];?>');
            $('.make-switch').bootstrapSwitch('setSizeClass', 'switch-small');
            $('.alert_pop .close').on('click',function(){
                $(this).parents('.alert_pop').fadeOut(100);
                return false;
            });
        });
    </script>
</head>
<body>
  <div class="container col-xs-12">
      <div class="logout_link">
        <a href="index.php?a=8" style="text-align:right;display:block;font-size:16px;">Вийти</a>  
      </div>
    <div class="masthead">
      <ul class="nav nav-justified">
        <li <?=($_GET['b'] == "pdr" ? 'class="active"' : '')?>><a href="<?=$url?>b=pdr">ПДР</a></li>
        <li <?=($_GET['b'] == "sign" ? 'class="active"' : '')?>><a href="<?=$url?>b=sign">Дорожні знаки</a></li>
        <li <?=($_GET['b'] == "marking" ? 'class="active"' : '')?>><a href="<?=$url?>b=marking">Дорожня розмітка</a></li>
        <li <?=($_GET['b'] == "info" ? 'class="active"' : '')?>><a href="<?=$url?>b=info">Інфо</a></li>
        <li <?=($_GET['b'] == "fine" ? 'class="active"' : '')?>><a href="<?=$url?>b=fine">Штрафи</a></li>
        <li <?=($_GET['b'] == "test" ? 'class="active"' : '')?>><a href="<?=$url?>b=test">Тести</a></li>
        <li <?=($_GET['b'] == "instructors" ? 'class="active"' : '')?>><a href="<?=$url?>b=instructors">Інструктори</a></li>
        <li <?=($_GET['b'] == "recalls" ? 'class="active"' : '')?>><a href="<?=$url?>b=recalls">Відгуки</a></li>
      </ul>
    </div>



    <? if ($_SESSION['mgrRole'] == 5): ?>
    <div class="masthead">
      <ul class="nav nav-justified">
        <li <?=($_GET['b'] == "users" ? 'class="active"' : '')?>><a href="<?=$url?>b=users">Користувачі</a></li>
        <li <?=($_GET['b'] == "webi" ? 'class="active"' : '')?>><a href="<?=$url?>b=webi">Вебінари</a></li>
        <li <?=($_GET['b'] == "webi_in" ? 'class="active"' : '')?>><a href="<?=$url?>b=webi_in">Вебінари(W)</a></li>
        <li <?=($_GET['b'] == "online" ? 'class="active"' : '')?>><a href="<?=$url?>b=online">Онлайн Курс</a></li>
        <li <?=($_GET['b'] == "lesson" ? 'class="active"' : '')?>><a href="<?=$url?>b=lesson">Тестовий урок</a></li>
      </ul>
    </div>
    <? endif ?>
    <? if (isset($_GET['w'])): ?>
      <br>
      <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong><?=$messages[$_GET['w']]?></strong>
      </div>
    <? endif ?>
    <div class="content" style="min-height: 500px;overflow:visible;">
      <?=$res['content']?>
    </div>
  </div>
</body>
<div class="alert_pop">
    <button type="button" class="close"><span aria-hidden="true">&times;</span></button>
    <div class="alert alert-success" role="alert"></div>
</div>
</html>