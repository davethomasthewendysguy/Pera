<?php
/*  
Copyright 2010-2014 Arnan de Gans - AJdG Solutions (email : info@ajdg.net)
*/
?>
<style type="text/css" media="screen">
.postbox-adrotate {
	margin-bottom: 20px;
	padding: 0;
	position: relative;
	min-width: 255px;
	border: #dfdfdf 1px solid;
	background-color: #fff;
	-moz-box-shadow: inset 0 1px 0 #fff;
	-webkit-box-shadow: inset 0 1px 0 #fff;
	box-shadow: inset 0 1px 0 #fff;
	line-height: 1.5;
}

.postbox-adrotate h3 {
	margin: 0;
	padding: 7px 10px 7px 10px;
	box-shadow: #ddd 0px 1px 0px 0px;
	-moz-box-shadow: inset 0 1px 0 #ddd;
	-webkit-box-shadow: #ddd 0px 1px 0px 0px;
	display: block;
	line-height: 15px;
}

.postbox-adrotate .inside {
	margin: 10px 0px 0px 10px;
	padding: 0px 10px 10px 0px;
	min-height: 40px;
	position: relative;
	display: block;
	line-height: 16px;
}

.inside {
	padding: 6px 10px 12px;
	clear: both;
}
</style>

<?php
$banners = $groups = $schedules = $queued = 0;
$banners = $wpdb->get_var("SELECT COUNT(*) FROM `".$wpdb->prefix."adrotate` WHERE `type` != 'empty' AND `type` != 'a_empty';");
$groups = $wpdb->get_var("SELECT COUNT(*) FROM `".$wpdb->prefix."adrotate_groups` WHERE `name` != '';");
$schedules = $wpdb->get_var("SELECT COUNT(*) FROM `".$wpdb->prefix."adrotate_schedule` WHERE `name` != '';");
$queued = $wpdb->get_var("SELECT COUNT(*) FROM `".$wpdb->prefix."adrotate` WHERE `type` = 'queue';");
$data = get_option("adrotate_advert_status");
?>

<?php if($status > 0) adrotate_status($status); ?>

<div id="dashboard-widgets-wrap">
	<div id="dashboard-widgets" class="metabox-holder">

		<div id="postbox-container-1" class="postbox-container" style="width:50%;">
			<div id="normal-sortables" class="meta-box-sortables ui-sortable">
				
				<h3><?php _e('Currently', 'adrotate'); ?></h3>
				<div class="postbox-adrotate">
					<div class="inside">
						<table width="100%">
							<thead>
							<tr class="first">
								<td width="50%"><strong><?php _e('Your setup', 'adrotate'); ?></strong></td>
								<td width="50%"><strong><?php _e('Adverts that need you', 'adrotate'); ?></strong></td>
							</tr>
							</thead>
							
							<tbody>
							<tr class="first">
								<td class="first b"><a href="admin.php?page=adrotate-ads"><?php echo $banners; ?> <?php _e('Adverts', 'adrotate'); ?></a></td>
								<td class="b"><a href="admin.php?page=adrotate-ads"><?php echo $data['expiressoon']; ?> <?php _e('(Almost) Expired', 'adrotate'); ?></a></td>
							</tr>
							<tr>
								<td class="first b"><a href="admin.php?page=adrotate-groups"><?php echo $groups; ?> <?php _e('Groups', 'adrotate'); ?></a></td>
								<td class="b"><a href="admin.php?page=adrotate-ads"><?php echo $data['error']; ?> <?php _e('Have errors', 'adrotate'); ?></a></td>
							</tr>
							<tr>
								<td class="first b"><a href="admin.php?page=adrotate-schedules"><?php echo $schedules; ?> <?php _e('Schedules', 'adrotate'); ?></a></td>
								<td class="b"><a href="admin.php?page=adrotate-moderate"><?php echo $queued; ?> <?php _e('Queued', 'adrotate'); ?></a></td>
							</tr>
							</tbody>

							<thead>
							<tr class="first">
								<td colspan="2"><strong><?php _e('The last few days', 'adrotate'); ?> (<a href="<?php echo admin_url('/admin.php?page=adrotate-ads&view=fullreport');?>"><?php _e('Full report', 'adrotate'); ?></a>)</strong></td>
							</tr>
							</thead>

							<tbody>
							<tr class="first">
								<td colspan="2">
						        	<?php
						        	$adstats = $wpdb->get_results("SELECT `thetime`, SUM(`clicks`) as `clicks`, SUM(`impressions`) as `impressions` FROM `".$wpdb->prefix."adrotate_stats` GROUP BY `thetime` DESC LIMIT 5;");
						
									if($adstats) {
										$adstats = array_reverse($adstats);
										$dates = $clicks = $impressions = 0;
						
										foreach($adstats as $result) {
											if($result->clicks == null) $result->clicks = '0';
											if($result->impressions == null) $result->impressions = '0';
											
											$dates .= ',"'.date_i18n("d M", $result->thetime).'"';
											$clicks .= ','.$result->clicks;
											$impressions .= ','.$result->impressions;
										}
						
										$dates = trim($dates, ",");
										$clicks = trim($clicks, ",");
										$impressions = trim($impressions, ",");
										
										echo '<div id="chart-1" style="height:150px; width:100%;"></div>';
										adrotate_draw_graph(1, $dates, $clicks, $impressions);
									} else {
										_e('No data to show!', 'adrotate');
									} 
									?>
								</td>
							</tr>
							</tbody>
						</table>

						<div class="versions">
							<span id="adrotate-version-message"><?php _e('You are using', 'adrotate'); ?> <strong>AdRotate <?php echo ADROTATE_DISPLAY; ?></strong><?php echo ($a['status'] == 0) ? ' (Unregistered)' : '' ;?>.</span>
							<br class="clear">
						</div>
					</div>
				</div>

				<h3><?php _e('Ticket Support', 'adrotate'); ?></h3>
				<div class="postbox-adrotate">
					<div class="inside">
					<?php if($a['status'] == 1) { ?>					
						<form name="request" id="post" method="post" action="admin.php?page=adrotate">
							<?php wp_nonce_field('adrotate_nonce_support_request','adrotate_nonce_support'); ?>
							<input type="hidden" name="adrotate_updater_username" value="<?php echo $firstname." ".$lastname;?>" />
							<input type="hidden" name="adrotate_updater_email" value="<?php echo $user->user_email;?>" />
							<input type="hidden" name="adrotate_updater_version" value="<?php echo ADROTATE_DISPLAY;?>" />
						
							<p>&raquo; <?php _e('What went wrong? (if anything) or what are you trying to do?', 'adrotate'); ?><br />&raquo; <?php _e('Include error messages and/or relevant information.', 'adrotate'); ?><br />&raquo; <?php _e('Try to remember steps or actions you took that might have caused the problem.', 'adrotate'); ?></p>
						
							<p><label for="adrotate_updater_subject"><strong><?php _e('Subject:', 'adrotate'); ?></strong><br /><input tabindex="1" name="adrotate_updater_subject" type="text" class="search-input" style="width:100%;" value="" autocomplete="off" /></label></p>
							<p><label for="adrotate_updater_message"><strong><?php _e('Problem description / Question:', 'adrotate'); ?></strong><br /><textarea tabindex="2" name="adrotate_updater_message" style="width:100%; height:100px;"></textarea></label></p>
						
							<p><strong><?php _e('When you send this form the following data will be submitted:', 'adrotate'); ?></strong></p>
							<p><em><?php _e('Your name, Account email address, Your website url, WordPress version and Language.', 'adrotate'); ?><br /><?php _e('We need this information so we know who sent the report what sort of site we can expect.', 'adrotate'); ?><br /><?php _e('This information is treated as confidential and is mandatory.', 'adrotate'); ?></em></p>
						
							<p class="submit">
								<input tabindex="3" type="submit" name="adrotate_license_support_submit" class="button-primary" value="<?php _e('Email Ticket', 'adrotate'); ?>" />&nbsp;&nbsp;&nbsp;<em><?php _e('Please use english only!', 'adrotate'); ?></em>
							</p>
						
						</form>
			
					<?php } else { ?>
				
						<p><?php _e('Please register your copy of AdRotate Professional.', 'adrotate'); ?></p>
						<p class="submit">
							<?php if(adrotate_is_networked()) { ?>
								<a href="<?php echo network_admin_url('admin.php?page=adrotate'); ?>" class="button-primary"><?php _e('Register License', 'adrotate'); ?></a>
							<?php } else { ?>
								<a href="<?php echo admin_url('admin.php?page=adrotate-settings'); ?>" class="button-primary"><?php _e('Register License', 'adrotate'); ?></a>	
							<?php } ?>
							<em><?php _e('Contact your site administrator if you do not know what this means.', 'adrotate'); ?></em>
						</p>
									
					<?php }	?>
					</div>
				</div>

			</div>
		</div>

		<div id="postbox-container-3" class="postbox-container" style="width:50%;">
			<div id="side-sortables" class="meta-box-sortables ui-sortable">
						
				<h3><?php _e('AdRotate News and Developer Blog', 'adrotate'); ?></h3>
				<div class="postbox-adrotate">
					<div class="inside">
						<?php wp_widget_rss_output(array(
							'url' => array('http://feeds.feedburner.com/AdrotatePluginForWordPress', 'http://meandmymac.net/feed/', 'http://www.ajdg.net/news/rss/'), 
							'title' => 'AdRotate Development News', 
							'items' => 4, 
							'show_summary' => 1, 
							'show_author' => 0, 
							'show_date' => 1)
							); ?>
					</div>
				</div>

				<h3><?php _e('AdRotate Store', 'adrotate'); ?></h3>
				<div class="postbox-adrotate">
					<div class="inside">
						<p><h4><?php _e('Get help with installations', 'adrotate'); ?></h4> <?php _e('Not sure how to set up AdRotate? Get me to do it!', 'adrotate'); ?> <a href="https://www.adrotateplugin.com/installations/"><?php _e('More info', 'adrotate'); ?> &raquo;</a></p>
						<p><h4><?php _e('Premium Support', 'adrotate'); ?></h4> <?php _e("Stuck with AdRotate? I'll help!", 'adrotate'); ?> <a href="https://www.adrotateplugin.com/shop/category/premium-support/"><?php _e('More info', 'adrotate'); ?> &raquo;</a></p>
						<p><a href="https://www.adrotateplugin.com/shop/"><?php _e('Visit store to see all services and products', 'adrotate'); ?> &raquo;</a></p>
					</div>
				</div>

				<h3><?php _e('AdRotate is brought to you by', 'adrotate'); ?></h3>
				<div class="postbox-adrotate">
					<div class="inside">
						<p><a href="http://www.ajdg.net" title="AJdG Solutions"><img src="<?php echo WP_CONTENT_URL; ?>/plugins/adrotate-pro/images/ajdg-logo-100x60.png" alt="ajdg-logo-100x60" width="100" height="60" align="left" style="padding: 0 10px 10px 0;" /></a>
						<a href="http://www.ajdg.net" title="AJdG Solutions">AJdG Solutions</a> - <?php _e('Your one stop for Webdevelopment, consultancy and anything WordPress! If you need a custom plugin. Theme customizations or have your site moved/migrated entirely. Visit my website for details!', 'adrotate'); ?> <a href="http://www.ajdg.net" title="AJdG Solutions"><?php _e('Find out more', 'adrotate'); ?></a>!</p>

						<p><center><a href="https://twitter.com/AJdGSolutions" class="twitter-follow-button" data-show-count="false" data-size="large" data-dnt="true">Follow @AJdGSolutions</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script></center></p>
					</div>
				</div>

			</div>	
		</div>

	</div>

	<div class="clear"></div>
	<p><?php echo adrotate_trademark(); ?></p>
</div>