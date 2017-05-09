<h2>
	<span class="dashicons dashicons-plus-alt"></span> Creator for Standard Ad Templates
</h2>

<form action="" method="post" class="bsaNewStandardAd">
	<input type="hidden" value="adCreator" name="bsaProAction">
	<table class="bsaAdminTable form-table">
		<tbody class="bsaTbody">
		<tr>
			<th colspan="2">
				<h3><span class="dashicons dashicons-exerpt-view"></span> Create custom size for Standard Ads</h3>
			</th>
		</tr>
		<tr>
			<th scope="row"><label for="ad_width">Image Width</label></th>
			<td>
				<input id="ad_width" name="ad_width" type="number" class="regular-text" value=""> <em>px</em>
			</td>
		</tr>
		<tr>
			<th class="bsaLast" scope="row"><label for="ad_height">Image Height</label></th>
			<td class="bsaLast">
				<input id="ad_height" name="ad_height" type="number" class="regular-text" value=""> <em>px</em>
			</td>
		</tr>
		</tbody>
	</table>
	<input class="bsa_inputs_required" name="inputs_required" type="hidden" value="">
	<p class="submit">
		<input type="submit" value="Save Ad Template" class="button button-primary" id="bsa_pro_submit" name="submit">
	</p>
</form>
<script>
	(function($) {
		// - start - open page
		var bsaItemsWrap = $(".wrap");
		setTimeout(function () {
			bsaItemsWrap.fadeIn(400);
		}, 400);
		// - end - open page
	})(jQuery);
</script>