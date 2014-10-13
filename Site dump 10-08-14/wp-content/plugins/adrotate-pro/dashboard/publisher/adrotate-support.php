<?php
/*  
Copyright 2010-2013 Arnan de Gans - AJdG Solutions (email : info@ajdg.net)
*/
$user = get_userdata($current_user->ID); 
if(strlen($user->first_name) < 1) $firstname = $user->user_login;
	else $firstname = $user->first_name;
if(strlen($user->last_name) < 1) $lastname = ''; 
	else $lastname = ' '.$user->last_name;

if($a['status'] == 1) { 
?>

<form name="request" id="post" method="post" action="admin.php?page=adrotate-support">
	<?php wp_nonce_field('adrotate_email_support','adrotate_nonce'); ?>
	<input type="hidden" name="adrotate_username" value="<?php echo $firstname." ".$lastname;?>" />
	<input type="hidden" name="adrotate_email" value="<?php echo $user->user_email;?>" />
	<input type="hidden" name="adrotate_version" value="<?php echo ADROTATE_DISPLAY;?>" />

	<table class="widefat" style="margin-top: .5em">
		<thead>
			<tr>
				<th colspan="2"><?php _e('Post your ticket', 'adrotate'); ?></th>
			</tr>
		</thead>

		<tbody>
		    <tr>
				<td colspan="2">
					<label for="adrotate_subject"><input tabindex="1" name="adrotate_subject" type="text" class="search-input" size="80" value="" autocomplete="off" /> <em><?php _e('A brief title/subject.', 'adrotate'); ?></em></label>
				</td>
			</tr>
		    <tr>
				<td><textarea tabindex="2" name="adrotate_message" cols="100" rows="16"></textarea></td>
				<td>
					<p><strong><?php _e('Tell me about...', 'adrotate'); ?></strong></p>
					<p>&raquo; <?php _e('What went wrong?', 'adrotate'); ?><br />&raquo; <?php _e('What were you trying to do?', 'adrotate'); ?><br />&raquo; <?php _e('Include error messages and/or relevant information.', 'adrotate'); ?><br />&raquo; <?php _e('Try to remember steps or actions you took that might have caused the problem.', 'adrotate'); ?></p>
					<p><em><?php _e('I can only help you if you tell me about your wishes and/or questions!', 'adrotate'); ?><br /><?php _e('Please use english only!', 'adrotate'); ?></em></p>
					
					<p><strong><?php _e('When you send this form the following data will be submitted:', 'adrotate'); ?></strong></p>
					<p><em><?php _e('Your name, Account email address, Your website url, WordPress version and Language.', 'adrotate'); ?><br /><?php _e('We need this information so we know who sent the report what sort of site we can expect.', 'adrotate'); ?><br /><?php _e('This information is mandatory.', 'adrotate'); ?></em></p>
				</td>
			</tr>
		</tbody>

	</table>

	<p class="submit">
		<input tabindex="3" type="submit" name="adrotate_support_submit" class="button-primary" value="<?php _e('Submit Ticket', 'adrotate'); ?>" />
		<a href="admin.php?page=adrotate-support" class="button"><?php _e('Cancel', 'adrotate'); ?></a>
	</p>

</form>
<?php } else { ?>

	<table class="widefat" style="margin-top: .5em">
		<thead>
			<tr>
				<th colspan="2"><?php _e('Unregistered copy', 'adrotate'); ?></th>
			</tr>
		</thead>

		<tbody>
		    <tr>
				<td colspan="2">
					<?php _e('Post your ticket...', 'adrotate'); ?> <?php _e('And get help - After you register your copy of AdRotate.', 'adrotate'); ?>
				</td>
			</tr>
		</tbody>
	</table>

	<p class="submit">
		<a href="admin.php?page=adrotate-settings" class="button-primary"><?php _e('Register AdRotate', 'adrotate'); ?></a>
	</p>
				
<?php }	?>