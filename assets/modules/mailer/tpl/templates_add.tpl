<form action="<?=$url?>&get=templates" method="post">
	<p>Тут храниться HTML верстка шаблона:</p>

	<input type="text" name="theme" class="theme" placeholder="'Название шаблона и тема письма" autofocus class="span12">
	<br><br>
	<textarea name="post" class="span12" id="post_text"></textarea>

	<p>&nbsp;</p>
	<input type="submit" value="Сохранить" class="btn btn-large btn-primary">
</form>

	<p>&nbsp;</p>
	<button id="fast_view" class="btn btn-large btn-success">Предпросмотр</button>
	<a href="#" class="btn btn-large btn-primary preview">Предпросмотр Отправка на почту</a>
<?=$tiny_mce;?>

<script type="text/javascript">
	$(document).ready(function(){
		$(document).on('click','#fast_view',function(){
			var _text = tinyMCE.activeEditor.getContent();

			$.ajax({
				url:"<?=$url?>&get=fast_view",
				type:"POST", 
				data:{ text: _text },
				success:function(ajax){
					$('.result').html(ajax);
	        	}
	    	});

			return false;
		});

	});

</script>


<script type="text/javascript">
$(document).ready(function(){
	$(document).on('click','.preview',function(){
		var _desc = $('#post_text').html();


		var content = tinyMCE.get('post_text').getContent();

		var _theme = $('.theme').val();
        $.ajax({url:"<?=$url?>&get=preview",type:"POST", data:{ text: content, theme: _theme }, success:function(ajax){

        }})
		return false;
	});

});
</script>
<style type="text/css">
	.result{
		width: 100%;
		min-height: 500px;
		margin-top: 5px;
	}
</style>
<div class="result"></div>