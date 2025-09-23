<!DOCTYPE HTML>
<html lang="en-US">
<head>
    <title>Tongue <?=$res['version']?></title>
    <meta charset="UTF-8">
    <script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
    <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.0/css/bootstrap-combined.min.css" rel="stylesheet">
    <script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.0/js/bootstrap.min.js"></script>
    <style type="text/css">
        form {margin-bottom:0px;}
        input[type=text] {margin-bottom:0px;}
        .navbar-inner {padding:0px;}
        .container {width:80%;}
    </style>
    <script type="text/javascript">
        $(document).ready(function(){
            $("[data-active]").each(function(){
               _option = $(this).find("option[value='"+$(this).attr("data-active")+"']");
               _option.prop("selected", true);
            });
        });
    </script>
</head>
<body>
    <div class="container">
      <div class="masthead">
        <p></p>
        <div class="navbar">
          <div class="navbar-inner">
            <div class="container">
              <ul class="nav">
                <? if ($modx->config['lang_enable']) :?>
                  <li<?=$get == "" && $modx->config['lang_enable'] ? ' class="active"' : '' ?>><a href="<?=$url?>"><span class="icon icon-flag"></span> Переводы</a></li>
                <? endif ?>
                <li<?=$get == "settings" || !$modx->config['lang_enable'] ? ' class="active"' : '' ?>><a href="<?=$url?>&get=settings"><span class="icon icon-cog"></span> Настройки</a></li>
              </ul>
          </div>
        </div><!-- /.navbar -->
      <br><?=$res['content']?>
      </div>
    </div>
</body>
</html>