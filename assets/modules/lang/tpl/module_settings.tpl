<form action="<?=$res['url']?>&get=settings" method="post">
    <table class="table table-striped table-condensed">
        <tbody>
            <tr>
                <td width="200px">Мультиязычность работает?</td>
                <td>
                    <select name="lang_enable" data-active="<?=$modx->config["lang_enable"]?>">
                        <option value="1">Да</option>
                        <option value="0">Нет</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Список языков</td>
                <td><input type="text" name="lang_list" value="<?=$modx->config["lang_list"]?>"></td>
            </tr>
            <tr>
                <td>Язык по умолчанию</td>
                <td><input type="text" name="lang_default" value="<?=$modx->config["lang_default"]?>"></td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <input type="submit" value="Сохранить" class="btn btn-primary" />
                </td>
            </tr>
        </tbody>
    </table>
</form>