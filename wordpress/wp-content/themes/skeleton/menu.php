<?php
/**
 * Template Name: Menu layout
 * @package Skeleton WordPress Theme Framework
 * @subpackage skeleton
 * @author Simple Themes - www.simplethemes.com
*/

if(!(empty($_GET["meal_option"]))) {
	$meal_option = $_GET["meal_option"];
} else {
	$meal_option == 2;
}

get_header(); ?>

<div id="content-overlay">
	<div id="restaurant-menu">			
		<h1>Restaurant Menu</h1>
		<ul class="meal-selector">
			<li><a class="menu0" href="">Breakfast</a></li>
			<li><a class="menu1" href="">Lunch</a></li>
			<li><a class="menu2" href="">Dinner</a></li>
		</ul>
		<?php 
		
		$query = "SELECT * FROM restaurant_menu WHERE meal = 0 ORDER BY meal ASC, menu_order ASC";
		$query2 = "SELECT * FROM restaurant_menu WHERE meal = 1 ORDER BY meal ASC, menu_order ASC";
		$query3 = "SELECT * FROM restaurant_menu WHERE meal = 2 ORDER BY meal ASC, menu_order ASC";
		
		$result = mysql_query($query) or die("Error: ".mysql_error());
		$result2 = mysql_query($query2) or die("Error: ".mysql_error());
		$result3 = mysql_query($query3) or die("Error: ".mysql_error());
		
		$row_count = mysql_num_rows($result);
		$row_count2 = mysql_num_rows($result2);
		$row_count3 = mysql_num_rows($result3);

		//BREAKFAST
		if($row_count > 0) { 
			if($meal_option == 0) { ?>
				<nav class="menu0">				
			<?php } else { ?>
				<nav class="menu0 hidden visuallyhidden">
			<?php } ?>
				<ul class="triple">
					<?php while($row = mysql_fetch_assoc($result)) { ?>
						<li><span style="font-size: 24px;"><?php echo $row["menu_item"]; ?></span><br />
						<?php echo $row["description"]; ?></li>
					<?php } ?>
				</ul>
			</nav>
		<?php } else {
			echo "<p style='float:left; margin-left:30px;'>Menu not currently available.</p>";
		}
		
		//LUNCH
		if($row_count2 > 0) {
			if($meal_option == 1) { ?>
				<nav class="menu1">				
			<?php } else { ?>
				<nav class="menu1 hidden visuallyhidden">
			<?php } ?>					
				<ul class="triple">
					<?php while($row = mysql_fetch_assoc($result2)) { ?>
						<li><span style="font-size: 24px;"><?php echo $row["menu_item"]; ?></span><br />
						<?php echo $row["description"]; ?></li>
					<?php } ?>
				</ul>
			</nav>
		<?php } else {
			echo "<p style='float:left; margin-left:30px;'>Menu not currently available.</p>";
		}
		
		//DINNER
		if($row_count3 > 0) {
			if($meal_option == 2) { ?>
				<nav class="menu2">				
			<?php } else { ?>
				<nav class="menu2 hidden visuallyhidden">
			<?php } ?>
				<ul class="triple">
					<?php while($row = mysql_fetch_assoc($result3)) { ?>
						<li><span style="font-size: 24px;"><?php echo $row["menu_item"]; ?></span><br />
						<?php echo $row["description"]; ?></li>
					<?php } ?>
				</ul>
			</nav>
		<?php } else {
			echo "<p style='float:left; margin-left:30px;'>Menu not currently available.</p>";
		} ?>
	</div>
</div>

<!-- LOOG -->

<!--Thumbnail Navigation-->
<!--<div id="prevthumb"></div>
<div id="nextthumb"></div>-->

<!--Arrow Navigation-->
<a id="prevslide" class="load-item"></a>
<a id="nextslide" class="load-item"></a>

<!--<div id="thumb-tray" class="load-item">
	<div id="thumb-back"></div>
	<div id="thumb-forward"></div>
</div>-->

<!--Time Bar-->
<!--<div id="progress-back" class="load-item">
	<div id="progress-bar"></div>
</div>-->

<!--Control Bar-->
<div id="controls-wrapper" class="load-item">
	<div id="controls">
		
		<a id="play-button"><img id="pauseplay" src="<?php echo get_template_directory_uri(); ?>/img/pause.png"/></a>
		
		<?php //if (is_active_sidebar('bottom-widget-area')) : ?>
			<div class="">
				<?php dynamic_sidebar('bottom-widget-area'); ?>
			</div>
		<?php //endif;?>
	</div>
</div>

<div id="below-fold2">
	<?php wp_footer();?>
</div>

<?php
//do_action('skeleton_before_content');
//get_template_part('loop', 'index');
//do_action('skeleton_after_content');
//get_sidebar();
get_footer();
?>