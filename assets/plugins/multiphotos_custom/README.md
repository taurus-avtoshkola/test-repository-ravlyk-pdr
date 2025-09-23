multiphotos_custom
==================

<h1>UPD</h1>
<p>На dev версии в папке assets/tvs/ добавить папку multiphotos и разместить всё содержимое, файл с плагином не обязательно</p>
<p>Далее просто добавить TV и выбрать тип multiphotos</p>
/// ========================///



<p>
Плагин аналогичен MultiPhotos, но упрощён до нельзя<br>
виджет автора данного кода<br>
http://community.modx-cms.ru/blog/fast-solution/9715.html<br>
<br>
Разбор в качестве customTV<br>
http://modx.im/blog/addons/2387.html
</p>

<p>в плагине #tv14 заменить на id параметра с выводом картинок<br>
https://github.com/64j/multiphotos_custom/blob/master/plugin.miltiphotos_custom.tpl.php#L15
</p>
<p>если не отображаются картинки, то правьте функцию <br>
thumb(src,w,h) <br>
в jquery.multiphotos.js<br>
https://github.com/64j/multiphotos_custom/blob/master/jquery.multiphotos.js#L88
