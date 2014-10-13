<?php
/*  
Copyright 2010-2014 Arnan de Gans - AJdG Solutions (email : info@ajdg.net)
*/
?>
<form method="post" action="admin.php?page=adrotate-ads&view=import" enctype="multipart/form-data">

<h3><?php _e('CSV Importer', 'adrotate'); ?></h3>
<table class="widefat" style="margin-top: .5em">
	<tbody>
		<tr>
			<td><label for="adrotate_csv"><input type="file" name="adrotate_csv" id="file" /> <em>Max. 4096Kb.</em></label></td>
		</tr>

	</tbody>
</table>

<p class="submit">
	<label for="adrotate_import"><input tabindex="2" type="submit" name="adrotate_import" class="button-primary" value="Import" /> <em>Click only once!</em></label>
</p>

</form>