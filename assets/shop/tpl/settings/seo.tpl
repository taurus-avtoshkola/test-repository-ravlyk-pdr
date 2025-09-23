<form action="<?=$url?>b=seo" method="post">
	<h3>SEO</h3>
	<table class="table table-bordered table condensed">



		<tr>
			<td>
				<b>SEO title Знак</b>
				<br><small class="text-muted">seo_title_sign</small>
			</td>
			<td><textarea name="seo_title_sign" class="form-control span6"><?=$modx->config['seo_title_sign']?></textarea></td>
		</tr>
		<tr>
			<td>
				<b>SEO description Знак</b>
				<br><small class="text-muted">seo_description_sign</small>
			</td>
			<td><textarea name="seo_description_sign" class="form-control span6"><?=$modx->config['seo_description_sign']?></textarea></td>
		</tr>
		<tr>
			<td>
				<b>SEO title Розмітка</b>
				<br><small class="text-muted">seo_title_marking</small>
			</td>
			<td><textarea name="seo_title_marking" class="form-control span6"><?=$modx->config['seo_title_marking']?></textarea></td>
		</tr>
		<tr>
			<td>
				<b>SEO description Розмітка</b>
				<br><small class="text-muted">seo_description_marking</small>
			</td>
			<td><textarea name="seo_description_marking" class="form-control span6"><?=$modx->config['seo_description_marking']?></textarea></td>
		</tr>
		<tr>
			<td>
				<b>SEO title ПДР Глава</b>
				<br><small class="text-muted">seo_title_pdr_chapter</small>
			</td>
			<td><textarea name="seo_title_pdr_chapter" class="form-control span6"><?=$modx->config['seo_title_pdr_chapter']?></textarea></td>
		</tr>
		<tr>
			<td>
				<b>SEO description ПДР Глава</b>
				<br><small class="text-muted">seo_description_pdr_chapter</small>
			</td>
			<td><textarea name="seo_description_pdr_chapter" class="form-control span6"><?=$modx->config['seo_description_pdr_chapter']?></textarea></td>
		</tr>

		<tr>
			<td>
				<b>SEO title ПДР Розділ</b>
				<br><small class="text-muted">seo_title_pdr_chapter_number</small>
			</td>
			<td><textarea name="seo_title_pdr_chapter_number" class="form-control span6"><?=$modx->config['seo_title_pdr_chapter_number']?></textarea></td>
		</tr>
		<tr>
			<td>
				<b>SEO description ПДР Розділ</b>
				<br><small class="text-muted">seo_description_pdr_chapter_number</small>
			</td>
			<td><textarea name="seo_description_pdr_chapter_number" class="form-control span6"><?=$modx->config['seo_description_pdr_chapter_number']?></textarea></td>
		</tr>



		<tr>
			<td>
				<b>SEO title Тест тема</b>
				<br><small class="text-muted">seo_title_test_theme</small>
			</td>
			<td><textarea name="seo_title_test_theme" class="form-control span6"><?=$modx->config['seo_title_test_theme']?></textarea></td>
		</tr>
		<tr>
			<td>
				<b>SEO description Тест тема</b>
				<br><small class="text-muted">seo_description_test_theme</small>
			</td>
			<td><textarea name="seo_description_test_theme" class="form-control span6"><?=$modx->config['seo_description_test_theme']?></textarea></td>
		</tr>


		<tr>
			<td>
				<b>SEO title Тест білет</b>
				<br><small class="text-muted">seo_title_test_ticket</small>
			</td>
			<td><textarea name="seo_title_test_ticket" class="form-control span6"><?=$modx->config['seo_title_test_ticket']?></textarea></td>
		</tr>
		<tr>
			<td>
				<b>SEO description Тест білет</b>
				<br><small class="text-muted">seo_description_test_ticket</small>
			</td>
			<td><textarea name="seo_description_test_ticket" class="form-control span6"><?=$modx->config['seo_description_test_ticket']?></textarea></td>
		</tr>



		<tr>
			<td>
				<b>SEO title Інструктор</b>
				<br><small class="text-muted">seo_title_instructor</small>
			</td>
			<td><textarea name="seo_title_instructor" class="form-control span6"><?=$modx->config['seo_title_instructor']?></textarea></td>
		</tr>
		<tr>
			<td>
				<b>SEO description Інструктор</b>
				<br><small class="text-muted">seo_description_instructor</small>
			</td>
			<td><textarea name="seo_description_instructor" class="form-control span6"><?=$modx->config['seo_description_instructor']?></textarea></td>
		</tr>



		<tr>
			<td>
				<b>SEO title Товар</b>
				<br><small class="text-muted">seo_title_product</small>
			</td>
			<td><textarea name="seo_title_product" class="form-control span6"><?=$modx->config['seo_title_product']?></textarea></td>
		</tr>
		<tr>
			<td>
				<b>SEO description Товар</b>
				<br><small class="text-muted">seo_description_product</small>
			</td>
			<td><textarea name="seo_description_product" class="form-control span6"><?=$modx->config['seo_description_product']?></textarea></td>
		</tr>
		

	</table>
	<input type="submit" value="Зберегти" class="btn btn-lg btn-primary">
</form>
<?=$tiny_mce;?>