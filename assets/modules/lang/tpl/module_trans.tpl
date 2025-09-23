<div class="container">
  <div class="pull-right menu">
    <input type="text" id="search_text" value="" placeholder="Поиск по базе переводов" />
    <a href="#myModal" class="btn btn-primary" href="#myModal" role="button" data-toggle="modal"><span class="icon icon-white icon-plus"></span> Добавить</a>
    <a href="#" class="btn btn-success" id="save"><span class="icon icon-white icon-ok"></span> Сохранить</a>
  </div>
  <h2 class="header">Управление переводами</h2>
  <form action="<?=$url?>&action=save" method="post">
      <table class="table table-hover table-bordered table-striped sectionBody">
             <thead>
              <tr>
                <td>#</td>
                <?=$table['thead']?>
              </tr>
             </thead>
             <tbody>
                <?=$table['tbody']?>
             </tbody>
      </table>
  </form>
</div>
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form action="<?=$url?>&action=add" method="post">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      <h3>Добавить перевод</h3>
    </div>
    <div class="modal-body">
      <table class="table table-hover table-bordered table-striped table-condensed">
        <?=$table['add']?>
      </table>
      <br />
      <i>Для того чтобы добавить вывод перевода необходимо вывести <b>[#<span class="red">номер строки</span>#]</b></i>
    </div>
    <div class="modal-footer">
      <input type="submit" class="btn btn-primary" value="Сохранить">
    </div>
  </form>
</div>

<script type="text/javascript">
    function search () {
          if ($.trim($("#search_text").val()).length > 0) {
            $(".sectionBody tbody").html("<tr><th colspan='{col}'><h3>Да ищем, ищем...</h3></th></tr>");
            $.ajax ({
              url    : '<?=$url?>&action=search', 
              type   : 'POST', 
              data   : 'search=' + $("#search_text").val(), 
              success: function (ajax){
                if (ajax == "")
                  $(".sectionBody tbody").html("<tr><th colspan='{col}'><h3 class='red'>Ничего не найдено!</h3></th></tr>");
                else
                  $(".sectionBody tbody").html(ajax);
            } });
          }
          return false;    
    }
    $(document).ready(function (){
        $("#search_submit").on ("click", function (){
          search();
        });
        $("#search_text").on("keyup", function (){
          if ($(this).val().length > 2)
              search();
        });
        $("#save").on ("click", function (){
           $("form:first").submit();
           return false;
        });

    });
</script>        