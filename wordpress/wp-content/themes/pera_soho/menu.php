<?php
/**
 * Template Name: Menu layout
 * @package Skeleton WordPress Theme Framework
 * @subpackage skeleton
 * @author Simple Themes - www.simplethemes.com
*/

$bloginfo = get_bloginfo("wpurl")."/wp-content/themes/pera_soho/images/";
$base_url = get_bloginfo("wpurl");

get_header(); ?>

<div id="below-fold">
	<div id="restaurant-menu-nav" class="full-module white-background">><!--ABOUT US-->
		<div class="full-module-inside">
			<h3 class="uppercase center">Menu</h3>
			
			<div class="info-box margin-medium-bottom">
				<img class="full-width-image" src="<?php echo $bloginfo ;?>filigre-top.png" alt="Filigre border" />
					<nav id="food-navigation" class="main-navigation" role="navigation">
						<?php wp_nav_menu( array( 'theme_location' => 'food' ) ); ?>
					</nav>
				<img class="full-width-image" src="<?php echo $bloginfo ;?>filigre-bottom.png" alt="Filigre border" />
			</div>
			
			<div class="center-copy">
				<?php while(have_posts()) : the_post(); ?>
					<?php the_content(); ?>
				<?php endwhile; // end of the loop. ?>
			</div>
		</div>
	</div>
	<div class="full-module white-background"><!--SEPARATOR IMAGE-->
		<div class="separator-inside">
			<img src="<?php echo $bloginfo ;?>separator.png" alt="Separator" />
		</div>
	</div>
	
	<!--FORMAT THAT MENU-->
	<?php 	
		$query = "SELECT * FROM restaurant_menu WHERE meal = 0 ORDER BY meal ASC, menu_order ASC";
		$query2 = "SELECT * FROM restaurant_menu WHERE meal = 1 ORDER BY meal ASC, menu_order ASC";
		$query3 = "SELECT * FROM restaurant_menu WHERE meal = 2 ORDER BY meal ASC, menu_order ASC";
		$query4 = "SELECT * FROM restaurant_menu WHERE meal = 3 ORDER BY meal ASC, menu_order ASC";
		$query5 = "SELECT * FROM restaurant_menu WHERE meal = 4 ORDER BY meal ASC, menu_order ASC";
		$query6 = "SELECT * FROM restaurant_menu WHERE meal = 5 ORDER BY meal ASC, menu_order ASC";
		
		$result = mysql_query($query) or die("Error: ".mysql_error()); //BRUNCH
		$result2 = mysql_query($query2) or die("Error: ".mysql_error()); //LUNCH
		$result3 = mysql_query($query3) or die("Error: ".mysql_error()); //DINNER
		$result4 = mysql_query($query4) or die("Error: ".mysql_error()); //DESSERT
		$result5 = mysql_query($query5) or die("Error: ".mysql_error()); //HAPPY HOUR
		$result6 = mysql_query($query6) or die("Error: ".mysql_error()); //ROOFTOP
		
		$row_count = mysql_num_rows($result);
		$row_count2 = mysql_num_rows($result2);
		$row_count3 = mysql_num_rows($result3);
		$row_count4 = mysql_num_rows($result4);
		$row_count5 = mysql_num_rows($result5);
		$row_count6 = mysql_num_rows($result6);
	?>
	
	<?php
		$rows = [];
	
		while($row = mysql_fetch_array($result)) {
			$rows[] = $row;
		}
	?>
	
	<div id="live-menu-container">
		<div id="live-menu-brunch" class="full-module white-background live-menu"><!--BRUNCH MENU-->
			<div class="specials-module-inside">
				<div class="three-column">
					<h3 class="uppercase no-margin-bottom">Wines by the Glass</h3>
					<h4 class="uppercase">Sommelier's Selection</h4>
			
					<p class="uppercase bold medium-font no-margin">White</p>
					
					<?php 
						for ($i = 0; $i < count($rows); ++$i) {					
							//if($rows[$i]["wine_type"] == "White") {
							if($rows[$i]["menu_item_type"] == "Wine") {
								echo '<p class="smaller-font no-margin">'.$rows[$i]['menu_item'].'....'.$rows[$i]['price'].'</p>';
								echo '<p class="smaller-font">'.$rows[$i]['description'].'</p>';
							}
						}
					?>
					
					<p class="uppercase bold medium-font no-margin">Red</p>
					
					<?php 
						for ($i = 0; $i < count($rows); ++$i) {					
							//if($rows[$i]["wine_type"] == "Red") {
							if($rows[$i]["menu_item_type"] == "Wine") {
								echo '<p class="smaller-font no-margin">'.$rows[$i]['menu_item'].'....'.$rows[$i]['price'].'</p>';
								echo '<p class="smaller-font">'.$rows[$i]['description'].'</p>';
							}
						}
					?>
				</div>
				<div class="three-column">
					<h3 class="uppercase">Dips & Chips</h3>
					
					<?php
						for ($i = 0; $i < count($rows); ++$i) {
							if($rows[$i]["menu_item_type"] == "Dips and Chips") {
								echo '<p class="uppercase bold medium-font no-margin">'.$rows[$i]['menu_item'].'....'.$rows[$i]['price'].'</p>';
								echo '<p class="smaller-font">'.$rows[$i]['description'].'</p>';
							}
						}
					?>
					
					<h3 class="uppercase">Salad</h3>
				
					<?php 
						for ($i = 0; $i < count($rows); ++$i) {	
							if($rows[$i]["menu_item_type"] == "Salad") {
								echo '<p class="uppercase bold medium-font no-margin">'.$rows[$i]['menu_item'].'....'.$rows[$i]['price'].'</p>';
								echo '<p class="smaller-font">'.$rows[$i]['description'].'</p>';
							}
						}
					?>
				</div>
				<div class="three-column">
					<h3 class="uppercase">Specialty Cocktails</h3>
					
					<?php 
						for ($i = 0; $i < count($rows); ++$i) {						
							if($rows[$i]["menu_item_type"] == "Specialty Cocktails") {
								echo '<p class="uppercase bold medium-font no-margin">'.$rows[$i]['menu_item'].'....'.$rows[$i]['price'].'</p>';
								echo '<p class="smaller-font">'.$rows[$i]['description'].'</p>';
							}
						}
					?>
				</div>
				<div class="clear-both">
					<h3 class="uppercase">Mezes</h3>
					<div class="three-column">
						<?php
							//echo "COUNT: ".count($rows)/2;
							$rows2 = [];
							$j = 0;
							
							for ($i = 0; $i < count($rows); ++$i) {
								if($rows[$i]['menu_item_type'] == "Mezes") {
									$rows2[$j]["id"] = $rows[$i]["id"];
									$rows2[$j]["description"] = $rows[$i]["description"];
									$rows2[$j]["price"] = $rows[$i]["price"];
									$rows2[$j]["menu_item"] = $rows[$i]["menu_item"];
									$rows2[$j]["menu_item_type"] = $rows[$i]["menu_item_type"];
									
									$j++;
								}
							}
							
							reset($rows2);
						
						
							for ($i = 0; $i < count($rows2)/3; ++$i) {					

									echo '<p class="uppercase bold medium-font no-margin">'.$rows2[$i]['menu_item'].'....'.$rows2[$i]['price'].'</p>';
									echo '<p class="smaller-font">'.$rows2[$i]['description'].'</p>';

								$j = $i;
							}
							
							reset($rows2);
						?>
					</div>
					<div class="three-column">
						<?php 
							for ($i = $j; $i < count($rows2)/3; ++$i) {				
								echo '<p class="uppercase bold medium-font no-margin">'.$rows2[$i]['menu_item'].'....'.$rows2[$i]['price'].'</p>';
								echo '<p class="smaller-font">'.$rows2[$i]['description'].'</p>';
							}
							
							reset($rows2);
						?>
					</div>
					<div class="three-column">
						<?php 
							for ($i = $j; $i < count($rows2)/3; ++$i) {		
								echo '<p class="uppercase bold medium-font no-margin">'.$rows2[$i]['menu_item'].'....'.$rows2[$i]['price'].'</p>';
								echo '<p class="smaller-font">'.$rows2[$i]['description'].'</p>';
							}
							
							reset($rows2);
						?>
					</div>
				</div>
			
				<img src="<?php echo $bloginfo ;?>separator.png" alt="Separator" />
			
				<div class="oveflow-auto">
					<h3 class="uppercase center">Plates</h3>
					
					
					<?php 
						for ($i = 0; $i < count($rows); ++$i) {					
							if($rows[$i]["menu_item_type"] == "Plates") {
								echo '<div class="two-column">';
								echo '<p class="uppercase bold medium-font no-margin">'.$rows[$i]['menu_item'].'....'.$rows[$i]['price'].'</p>';
								echo '<p class="smaller-font">'.$rows[$i]['description'].'</p>';
								echo '</div>';
							}
						}
					?>
				</div>

				<img src="<?php echo $bloginfo ;?>separator.png" alt="Separator" />
			
				<div class="oveflow-auto">
					<h3 class="uppercase center">Sides</h3>
					<?php 
						for ($i = 0; $i < count($rows); ++$i) {					
							if($rows[$i]["menu_item_type"] == "Sides") {
								echo '<div class="three-column">';
								echo '<p class="uppercase bold medium-font no-margin">'.$rows[$i]['menu_item'].'....'.$rows[$i]['price'].'</p>';
								echo '<p class="smaller-font">'.$rows[$i]['description'].'</p>';
								echo '</div>';
							}
						}
					?>
				</div>
			
				<div class="small-module-inside white-background">
					<a href="<?php echo $base_url; ?>/wp-content/uploads/2014/06/brunch_menu.pdf"><img width="230" height="37" class="clear-both float-left margin-small-right" src="http://dev.pera.com/wp-content/themes/pera_soho/images/download-menu.png" alt="Download Menu"></a>
			
					<a href="http://www.opentable.com/pera-soho-reservations-new-york?restref=76933"><img width="230" height="37" class="float-left" src="http://dev.pera.com/wp-content/themes/pera_soho/images/make-a-reservation.png" alt="Make a Reservation"></a>
				</div>
			</div>
		</div>
		
		<?php
			$rows = [];
			
			while($row = mysql_fetch_array($result2)) {
				$rows[] = $row;
			}
		?>
		
		<div id="live-menu-lunch" class="full-module white-background live-menu"><!--LUNCH MENU-->
			<div class="specials-module-inside">
				<div class="three-column">
					<h3 class="uppercase no-margin-bottom">Wines by the Glass</h3>
					<h4 class="uppercase">Sommelier's Selection</h4>
			
					<p class="uppercase bold medium-font no-margin">White</p>
					
					<?php 
						for ($i = 0; $i < count($rows); ++$i) {					
							//if($rows[$i]["wine_type"] == "White") {
							if($rows[$i]["menu_item_type"] == "Wine") {
								echo '<p class="smaller-font no-margin">'.$rows[$i]['menu_item'].'....'.$rows[$i]['price'].'</p>';
								echo '<p class="smaller-font">'.$rows[$i]['description'].'</p>';
							}
						}
					?>
					
					<p class="uppercase bold medium-font no-margin">Red</p>
					
					<?php 
						for ($i = 0; $i < count($rows); ++$i) {					
							//if($rows[$i]["wine_type"] == "Red") {
							if($rows[$i]["menu_item_type"] == "Wine") {
								echo '<p class="smaller-font no-margin">'.$rows[$i]['menu_item'].'....'.$rows[$i]['price'].'</p>';
								echo '<p class="smaller-font">'.$rows[$i]['description'].'</p>';
							}
						}
					?>
				</div>
				<div class="three-column">
					<h3 class="uppercase">Dips & Chips</h3>
					
					<?php
						for ($i = 0; $i < count($rows); ++$i) {
							if($rows[$i]["menu_item_type"] == "Dips and Chips") {
								echo '<p class="uppercase bold medium-font no-margin">'.$rows[$i]['menu_item'].'....'.$rows[$i]['price'].'</p>';
								echo '<p class="smaller-font">'.$rows[$i]['description'].'</p>';
							}
						}
					?>
					
					<h3 class="uppercase">Salad</h3>
				
					<?php 
						for ($i = 0; $i < count($rows); ++$i) {	
							if($rows[$i]["menu_item_type"] == "Salad") {
								echo '<p class="uppercase bold medium-font no-margin">'.$rows[$i]['menu_item'].'....'.$rows[$i]['price'].'</p>';
								echo '<p class="smaller-font">'.$rows[$i]['description'].'</p>';
							}
						}
					?>
				</div>
				<div class="three-column">
					<h3 class="uppercase">Specialty Cocktails</h3>
					
					<?php 
						for ($i = 0; $i < count($rows); ++$i) {						
							if($rows[$i]["menu_item_type"] == "Specialty Cocktails") {
								echo '<p class="uppercase bold medium-font no-margin">'.$rows[$i]['menu_item'].'....'.$rows[$i]['price'].'</p>';
								echo '<p class="smaller-font">'.$rows[$i]['description'].'</p>';
							}
						}
					?>
				</div>
				<div class="clear-both">
					<h3 class="uppercase">Mezes</h3>
					<div class="three-column">
						<?php
							//echo "COUNT: ".count($rows)/2;
							$rows2 = [];
							$j = 0;
							
							for ($i = 0; $i < count($rows); ++$i) {
								if($rows[$i]['menu_item_type'] == "Mezes") {
									$rows2[$j]["id"] = $rows[$i]["id"];
									$rows2[$j]["description"] = $rows[$i]["description"];
									$rows2[$j]["price"] = $rows[$i]["price"];
									$rows2[$j]["menu_item"] = $rows[$i]["menu_item"];
									$rows2[$j]["menu_item_type"] = $rows[$i]["menu_item_type"];
									
									$j++;
								}
							}
							
							reset($rows2);
						
						
							for ($i = 0; $i < count($rows2)/3; ++$i) {					

									echo '<p class="uppercase bold medium-font no-margin">'.$rows2[$i]['menu_item'].'....'.$rows2[$i]['price'].'</p>';
									echo '<p class="smaller-font">'.$rows2[$i]['description'].'</p>';

								$j = $i;
							}
							
							reset($rows2);
						?>
					</div>
					<div class="three-column">
						<?php 
							for ($i = $j; $i < count($rows2)/3; ++$i) {				
								echo '<p class="uppercase bold medium-font no-margin">'.$rows2[$i]['menu_item'].'....'.$rows2[$i]['price'].'</p>';
								echo '<p class="smaller-font">'.$rows2[$i]['description'].'</p>';
							}
							
							reset($rows2);
						?>
					</div>
					<div class="three-column">
						<?php 
							for ($i = $j; $i < count($rows2)/3; ++$i) {		
								echo '<p class="uppercase bold medium-font no-margin">'.$rows2[$i]['menu_item'].'....'.$rows2[$i]['price'].'</p>';
								echo '<p class="smaller-font">'.$rows2[$i]['description'].'</p>';
							}
							
							reset($rows2);
						?>
					</div>
				</div>
			
				<img src="<?php echo $bloginfo ;?>separator.png" alt="Separator" />
			
				<div class="oveflow-auto">
					<h3 class="uppercase center">Plates</h3>
					
					
					<?php 
						for ($i = 0; $i < count($rows); ++$i) {					
							if($rows[$i]["menu_item_type"] == "Plates") {
								echo '<div class="two-column">';
								echo '<p class="uppercase bold medium-font no-margin">'.$rows[$i]['menu_item'].'....'.$rows[$i]['price'].'</p>';
								echo '<p class="smaller-font">'.$rows[$i]['description'].'</p>';
								echo '</div>';
							}
						}
					?>
				</div>

				<img src="<?php echo $bloginfo ;?>separator.png" alt="Separator" />
			
				<div class="oveflow-auto">
					<h3 class="uppercase center">Sides</h3>
					<?php 
						for ($i = 0; $i < count($rows); ++$i) {					
							if($rows[$i]["menu_item_type"] == "Sides") {
								echo '<div class="three-column">';
								echo '<p class="uppercase bold medium-font no-margin">'.$rows[$i]['menu_item'].'....'.$rows[$i]['price'].'</p>';
								echo '<p class="smaller-font">'.$rows[$i]['description'].'</p>';
								echo '</div>';
							}
						}
					?>
				</div>
			
				<div class="small-module-inside white-background">
					<a href="<?php echo $base_url; ?>/wp-content/uploads/2014/06/dinner_menu.pdf"><img width="230" height="37" class="clear-both float-left margin-small-right" src="http://dev.pera.com/wp-content/themes/pera_soho/images/download-menu.png" alt="Download Menu"></a>
			
					<a href="http://www.opentable.com/pera-soho-reservations-new-york?restref=76933"><img width="230" height="37" class="float-left" src="http://dev.pera.com/wp-content/themes/pera_soho/images/make-a-reservation.png" alt="Make a Reservation"></a>
				</div>
			</div>
		</div>
		
		<?php
			$rows = [];
		
			while($row = mysql_fetch_array($result3)) {
				$rows[] = $row;
			}
		?>
		
		<div id="live-menu-dinner" class="full-module white-background live-menu"><!--DINNER MENU-->
			<div class="specials-module-inside">
				<div class="three-column">
					<h3 class="uppercase no-margin-bottom">Wines by the Glass</h3>
					<h4 class="uppercase">Sommelier's Selection</h4>
			
					<p class="uppercase bold medium-font no-margin">White</p>
					
					<?php 
						for ($i = 0; $i < count($rows); ++$i) {					
							//if($rows[$i]["wine_type"] == "White") {
							if($rows[$i]["menu_item_type"] == "Wine") {
								echo '<p class="smaller-font no-margin">'.$rows[$i]['menu_item'].'....'.$rows[$i]['price'].'</p>';
								echo '<p class="smaller-font">'.$rows[$i]['description'].'</p>';
							}
						}
					?>
					
					<p class="uppercase bold medium-font no-margin">Red</p>
					
					<?php 
						for ($i = 0; $i < count($rows); ++$i) {					
							//if($rows[$i]["wine_type"] == "Red") {
							if($rows[$i]["menu_item_type"] == "Wine") {
								echo '<p class="smaller-font no-margin">'.$rows[$i]['menu_item'].'....'.$rows[$i]['price'].'</p>';
								echo '<p class="smaller-font">'.$rows[$i]['description'].'</p>';
							}
						}
					?>
				</div>
				<div class="three-column">
					<h3 class="uppercase">Dips & Chips</h3>
					
					<?php
						for ($i = 0; $i < count($rows); ++$i) {
							if($rows[$i]["menu_item_type"] == "Dips and Chips") {
								echo '<p class="uppercase bold medium-font no-margin">'.$rows[$i]['menu_item'].'....'.$rows[$i]['price'].'</p>';
								echo '<p class="smaller-font">'.$rows[$i]['description'].'</p>';
							}
						}
					?>
					
					<h3 class="uppercase">Salad</h3>
				
					<?php 
						for ($i = 0; $i < count($rows); ++$i) {	
							if($rows[$i]["menu_item_type"] == "Salad") {
								echo '<p class="uppercase bold medium-font no-margin">'.$rows[$i]['menu_item'].'....'.$rows[$i]['price'].'</p>';
								echo '<p class="smaller-font">'.$rows[$i]['description'].'</p>';
							}
						}
					?>
				</div>
				<div class="three-column">
					<h3 class="uppercase">Specialty Cocktails</h3>
					
					<?php 
						for ($i = 0; $i < count($rows); ++$i) {						
							if($rows[$i]["menu_item_type"] == "Specialty Cocktails") {
								echo '<p class="uppercase bold medium-font no-margin">'.$rows[$i]['menu_item'].'....'.$rows[$i]['price'].'</p>';
								echo '<p class="smaller-font">'.$rows[$i]['description'].'</p>';
							}
						}
					?>
				</div>
				<div class="clear-both">
					<h3 class="uppercase">Mezes</h3>
					<div class="three-column">
						<?php
							//echo "COUNT: ".count($rows)/2;
							$rows2 = [];
							$j = 0;
							
							for ($i = 0; $i < count($rows); ++$i) {
								if($rows[$i]['menu_item_type'] == "Mezes") {
									$rows2[$j]["id"] = $rows[$i]["id"];
									$rows2[$j]["description"] = $rows[$i]["description"];
									$rows2[$j]["price"] = $rows[$i]["price"];
									$rows2[$j]["menu_item"] = $rows[$i]["menu_item"];
									$rows2[$j]["menu_item_type"] = $rows[$i]["menu_item_type"];
									
									$j++;
								}
							}
							
							reset($rows2);
						
						
							for ($i = 0; $i < count($rows2)/3; ++$i) {					

									echo '<p class="uppercase bold medium-font no-margin">'.$rows2[$i]['menu_item'].'....'.$rows2[$i]['price'].'</p>';
									echo '<p class="smaller-font">'.$rows2[$i]['description'].'</p>';

								$j = $i;
							}
							
							reset($rows2);
						?>
					</div>
					<div class="three-column">
						<?php 
							for ($i = $j; $i < count($rows2)/3; ++$i) {				
								echo '<p class="uppercase bold medium-font no-margin">'.$rows2[$i]['menu_item'].'....'.$rows2[$i]['price'].'</p>';
								echo '<p class="smaller-font">'.$rows2[$i]['description'].'</p>';
							}
							
							reset($rows2);
						?>
					</div>
					<div class="three-column">
						<?php 
							for ($i = $j; $i < count($rows2)/3; ++$i) {		
								echo '<p class="uppercase bold medium-font no-margin">'.$rows2[$i]['menu_item'].'....'.$rows2[$i]['price'].'</p>';
								echo '<p class="smaller-font">'.$rows2[$i]['description'].'</p>';
							}
							
							reset($rows2);
						?>
					</div>
				</div>
			
				<img src="<?php echo $bloginfo ;?>separator.png" alt="Separator" />
			
				<div class="oveflow-auto">
					<h3 class="uppercase center">Plates</h3>
					
					
					<?php 
						for ($i = 0; $i < count($rows); ++$i) {					
							if($rows[$i]["menu_item_type"] == "Plates") {
								echo '<div class="two-column">';
								echo '<p class="uppercase bold medium-font no-margin">'.$rows[$i]['menu_item'].'....'.$rows[$i]['price'].'</p>';
								echo '<p class="smaller-font">'.$rows[$i]['description'].'</p>';
								echo '</div>';
							}
						}
					?>
				</div>

				<img src="<?php echo $bloginfo ;?>separator.png" alt="Separator" />
			
				<div class="oveflow-auto">
					<h3 class="uppercase center">Sides</h3>
					<?php 
						for ($i = 0; $i < count($rows); ++$i) {					
							if($rows[$i]["menu_item_type"] == "Sides") {
								echo '<div class="three-column">';
								echo '<p class="uppercase bold medium-font no-margin">'.$rows[$i]['menu_item'].'....'.$rows[$i]['price'].'</p>';
								echo '<p class="smaller-font">'.$rows[$i]['description'].'</p>';
								echo '</div>';
							}
						}
					?>
				</div>
			
				<div class="small-module-inside white-background">
					<a href="<?php echo $base_url; ?>/wp-content/uploads/2014/06/dinner_menu.pdf"><img width="230" height="37" class="clear-both float-left margin-small-right" src="http://dev.pera.com/wp-content/themes/pera_soho/images/download-menu.png" alt="Download Menu"></a>
			
					<a href="http://www.opentable.com/pera-soho-reservations-new-york?restref=76933"><img width="230" height="37" class="float-left" src="http://dev.pera.com/wp-content/themes/pera_soho/images/make-a-reservation.png" alt="Make a Reservation"></a>
				</div>
			</div>
		</div>
		
		<?php
			$rows = [];
		
			while($row = mysql_fetch_array($result4)) {
				$rows[] = $row;
			}
		?>
		
		<div id="live-menu-dessert" class="full-module white-background live-menu"><!--DESSERT MENU-->
			<div class="specials-module-inside">
				<div class="three-column">
					<h3 class="uppercase no-margin-bottom">Wines by the Glass</h3>
					<h4 class="uppercase">Sommelier's Selection</h4>
			
					<p class="uppercase bold medium-font no-margin">White</p>
					
					<?php 
						for ($i = 0; $i < count($rows); ++$i) {					
							//if($rows[$i]["wine_type"] == "White") {
							if($rows[$i]["menu_item_type"] == "Wine") {
								echo '<p class="smaller-font no-margin">'.$rows[$i]['menu_item'].'....'.$rows[$i]['price'].'</p>';
								echo '<p class="smaller-font">'.$rows[$i]['description'].'</p>';
							}
						}
					?>
					
					<p class="uppercase bold medium-font no-margin">Red</p>
					
					<?php 
						for ($i = 0; $i < count($rows); ++$i) {					
							//if($rows[$i]["wine_type"] == "Red") {
							if($rows[$i]["menu_item_type"] == "Wine") {
								echo '<p class="smaller-font no-margin">'.$rows[$i]['menu_item'].'....'.$rows[$i]['price'].'</p>';
								echo '<p class="smaller-font">'.$rows[$i]['description'].'</p>';
							}
						}
					?>
				</div>
				<div class="three-column">
					<h3 class="uppercase">Dips & Chips</h3>
					
					<?php
						for ($i = 0; $i < count($rows); ++$i) {
							if($rows[$i]["menu_item_type"] == "Dips and Chips") {
								echo '<p class="uppercase bold medium-font no-margin">'.$rows[$i]['menu_item'].'....'.$rows[$i]['price'].'</p>';
								echo '<p class="smaller-font">'.$rows[$i]['description'].'</p>';
							}
						}
					?>
					
					<h3 class="uppercase">Salad</h3>
				
					<?php 
						for ($i = 0; $i < count($rows); ++$i) {	
							if($rows[$i]["menu_item_type"] == "Salad") {
								echo '<p class="uppercase bold medium-font no-margin">'.$rows[$i]['menu_item'].'....'.$rows[$i]['price'].'</p>';
								echo '<p class="smaller-font">'.$rows[$i]['description'].'</p>';
							}
						}
					?>
				</div>
				<div class="three-column">
					<h3 class="uppercase">Specialty Cocktails</h3>
					
					<?php 
						for ($i = 0; $i < count($rows); ++$i) {						
							if($rows[$i]["menu_item_type"] == "Specialty Cocktails") {
								echo '<p class="uppercase bold medium-font no-margin">'.$rows[$i]['menu_item'].'....'.$rows[$i]['price'].'</p>';
								echo '<p class="smaller-font">'.$rows[$i]['description'].'</p>';
							}
						}
					?>
				</div>
				<div class="clear-both">
					<h3 class="uppercase">Mezes</h3>
					<div class="three-column">
						<?php
							//echo "COUNT: ".count($rows)/2;
							$rows2 = [];
							$j = 0;
							
							for ($i = 0; $i < count($rows); ++$i) {
								if($rows[$i]['menu_item_type'] == "Mezes") {
									$rows2[$j]["id"] = $rows[$i]["id"];
									$rows2[$j]["description"] = $rows[$i]["description"];
									$rows2[$j]["price"] = $rows[$i]["price"];
									$rows2[$j]["menu_item"] = $rows[$i]["menu_item"];
									$rows2[$j]["menu_item_type"] = $rows[$i]["menu_item_type"];
									
									$j++;
								}
							}
							
							reset($rows2);
						
						
							for ($i = 0; $i < count($rows2)/3; ++$i) {					

									echo '<p class="uppercase bold medium-font no-margin">'.$rows2[$i]['menu_item'].'....'.$rows2[$i]['price'].'</p>';
									echo '<p class="smaller-font">'.$rows2[$i]['description'].'</p>';

								$j = $i;
							}
							
							reset($rows2);
						?>
					</div>
					<div class="three-column">
						<?php 
							for ($i = $j; $i < count($rows2)/3; ++$i) {				
								echo '<p class="uppercase bold medium-font no-margin">'.$rows2[$i]['menu_item'].'....'.$rows2[$i]['price'].'</p>';
								echo '<p class="smaller-font">'.$rows2[$i]['description'].'</p>';
							}
							
							reset($rows2);
						?>
					</div>
					<div class="three-column">
						<?php 
							for ($i = $j; $i < count($rows2)/3; ++$i) {		
								echo '<p class="uppercase bold medium-font no-margin">'.$rows2[$i]['menu_item'].'....'.$rows2[$i]['price'].'</p>';
								echo '<p class="smaller-font">'.$rows2[$i]['description'].'</p>';
							}
							
							reset($rows2);
						?>
					</div>
				</div>
			
				<img src="<?php echo $bloginfo ;?>separator.png" alt="Separator" />
			
				<div class="oveflow-auto">
					<h3 class="uppercase center">Plates</h3>
					
					
					<?php 
						for ($i = 0; $i < count($rows); ++$i) {					
							if($rows[$i]["menu_item_type"] == "Plates") {
								echo '<div class="two-column">';
								echo '<p class="uppercase bold medium-font no-margin">'.$rows[$i]['menu_item'].'....'.$rows[$i]['price'].'</p>';
								echo '<p class="smaller-font">'.$rows[$i]['description'].'</p>';
								echo '</div>';
							}
						}
					?>
				</div>

				<img src="<?php echo $bloginfo ;?>separator.png" alt="Separator" />
			
				<div class="oveflow-auto">
					<h3 class="uppercase center">Sides</h3>
					<?php 
						for ($i = 0; $i < count($rows); ++$i) {					
							if($rows[$i]["menu_item_type"] == "Sides") {
								echo '<div class="three-column">';
								echo '<p class="uppercase bold medium-font no-margin">'.$rows[$i]['menu_item'].'....'.$rows[$i]['price'].'</p>';
								echo '<p class="smaller-font">'.$rows[$i]['description'].'</p>';
								echo '</div>';
							}
						}
					?>
				</div>
			
				<div class="small-module-inside white-background">
					<a href="<?php echo $base_url; ?>/wp-content/uploads/2014/06/dinner_menu.pdf"><img width="230" height="37" class="clear-both float-left margin-small-right" src="http://dev.pera.com/wp-content/themes/pera_soho/images/download-menu.png" alt="Download Menu"></a>
			
					<a href="http://www.opentable.com/pera-soho-reservations-new-york?restref=76933"><img width="230" height="37" class="float-left" src="http://dev.pera.com/wp-content/themes/pera_soho/images/make-a-reservation.png" alt="Make a Reservation"></a>
				</div>
			</div>
		</div>

		<?php
			$rows = [];
		
			while($row = mysql_fetch_array($result5)) {
				$rows[] = $row;
			}
		?>

		<div id="live-menu-happy-hour" class="full-module white-background live-menu"><!--HAPPY HOUR MENU-->
			<div class="specials-module-inside">
				<div class="three-column">
					<h3 class="uppercase no-margin-bottom">Wines by the Glass</h3>
					<h4 class="uppercase">Sommelier's Selection</h4>
			
					<p class="uppercase bold medium-font no-margin">White</p>
					
					<?php 
						for ($i = 0; $i < count($rows); ++$i) {					
							//if($rows[$i]["wine_type"] == "White") {
							if($rows[$i]["menu_item_type"] == "Wine") {
								echo '<p class="smaller-font no-margin">'.$rows[$i]['menu_item'].'....'.$rows[$i]['price'].'</p>';
								echo '<p class="smaller-font">'.$rows[$i]['description'].'</p>';
							}
						}
					?>
					
					<p class="uppercase bold medium-font no-margin">Red</p>
					
					<?php 
						for ($i = 0; $i < count($rows); ++$i) {					
							//if($rows[$i]["wine_type"] == "Red") {
							if($rows[$i]["menu_item_type"] == "Wine") {
								echo '<p class="smaller-font no-margin">'.$rows[$i]['menu_item'].'....'.$rows[$i]['price'].'</p>';
								echo '<p class="smaller-font">'.$rows[$i]['description'].'</p>';
							}
						}
					?>
				</div>
				<div class="three-column">
					<h3 class="uppercase">Dips & Chips</h3>
					
					<?php
						for ($i = 0; $i < count($rows); ++$i) {
							if($rows[$i]["menu_item_type"] == "Dips and Chips") {
								echo '<p class="uppercase bold medium-font no-margin">'.$rows[$i]['menu_item'].'....'.$rows[$i]['price'].'</p>';
								echo '<p class="smaller-font">'.$rows[$i]['description'].'</p>';
							}
						}
					?>
					
					<h3 class="uppercase">Salad</h3>
				
					<?php 
						for ($i = 0; $i < count($rows); ++$i) {	
							if($rows[$i]["menu_item_type"] == "Salad") {
								echo '<p class="uppercase bold medium-font no-margin">'.$rows[$i]['menu_item'].'....'.$rows[$i]['price'].'</p>';
								echo '<p class="smaller-font">'.$rows[$i]['description'].'</p>';
							}
						}
					?>
				</div>
				<div class="three-column">
					<h3 class="uppercase">Specialty Cocktails</h3>
					
					<?php 
						for ($i = 0; $i < count($rows); ++$i) {						
							if($rows[$i]["menu_item_type"] == "Specialty Cocktails") {
								echo '<p class="uppercase bold medium-font no-margin">'.$rows[$i]['menu_item'].'....'.$rows[$i]['price'].'</p>';
								echo '<p class="smaller-font">'.$rows[$i]['description'].'</p>';
							}
						}
					?>
				</div>
				<div class="clear-both">
					<h3 class="uppercase">Mezes</h3>
					<div class="three-column">
						<?php
							//echo "COUNT: ".count($rows)/2;
							$rows2 = [];
							$j = 0;
							
							for ($i = 0; $i < count($rows); ++$i) {
								if($rows[$i]['menu_item_type'] == "Mezes") {
									$rows2[$j]["id"] = $rows[$i]["id"];
									$rows2[$j]["description"] = $rows[$i]["description"];
									$rows2[$j]["price"] = $rows[$i]["price"];
									$rows2[$j]["menu_item"] = $rows[$i]["menu_item"];
									$rows2[$j]["menu_item_type"] = $rows[$i]["menu_item_type"];
									
									$j++;
								}
							}
							
							reset($rows2);
						
						
							for ($i = 0; $i < count($rows2)/3; ++$i) {					

									echo '<p class="uppercase bold medium-font no-margin">'.$rows2[$i]['menu_item'].'....'.$rows2[$i]['price'].'</p>';
									echo '<p class="smaller-font">'.$rows2[$i]['description'].'</p>';

								$j = $i;
							}
							
							reset($rows2);
						?>
					</div>
					<div class="three-column">
						<?php 
							for ($i = $j; $i < count($rows2)/3; ++$i) {				
								echo '<p class="uppercase bold medium-font no-margin">'.$rows2[$i]['menu_item'].'....'.$rows2[$i]['price'].'</p>';
								echo '<p class="smaller-font">'.$rows2[$i]['description'].'</p>';
							}
							
							reset($rows2);
						?>
					</div>
					<div class="three-column">
						<?php 
							for ($i = $j; $i < count($rows2)/3; ++$i) {		
								echo '<p class="uppercase bold medium-font no-margin">'.$rows2[$i]['menu_item'].'....'.$rows2[$i]['price'].'</p>';
								echo '<p class="smaller-font">'.$rows2[$i]['description'].'</p>';
							}
							
							reset($rows2);
						?>
					</div>
				</div>
			
				<img src="<?php echo $bloginfo ;?>separator.png" alt="Separator" />
			
				<div class="oveflow-auto">
					<h3 class="uppercase center">Plates</h3>
					
					
					<?php 
						for ($i = 0; $i < count($rows); ++$i) {					
							if($rows[$i]["menu_item_type"] == "Plates") {
								echo '<div class="two-column">';
								echo '<p class="uppercase bold medium-font no-margin">'.$rows[$i]['menu_item'].'....'.$rows[$i]['price'].'</p>';
								echo '<p class="smaller-font">'.$rows[$i]['description'].'</p>';
								echo '</div>';
							}
						}
					?>
				</div>

				<img src="<?php echo $bloginfo ;?>separator.png" alt="Separator" />
			
				<div class="oveflow-auto">
					<h3 class="uppercase center">Sides</h3>
					<?php 
						for ($i = 0; $i < count($rows); ++$i) {					
							if($rows[$i]["menu_item_type"] == "Sides") {
								echo '<div class="three-column">';
								echo '<p class="uppercase bold medium-font no-margin">'.$rows[$i]['menu_item'].'....'.$rows[$i]['price'].'</p>';
								echo '<p class="smaller-font">'.$rows[$i]['description'].'</p>';
								echo '</div>';
							}
						}
					?>
				</div>
			
				<div class="small-module-inside white-background">
					<a href="<?php echo $base_url; ?>/wp-content/uploads/2014/06/dinner_menu.pdf"><img width="230" height="37" class="clear-both float-left margin-small-right" src="http://dev.pera.com/wp-content/themes/pera_soho/images/download-menu.png" alt="Download Menu"></a>
			
					<a href="http://www.opentable.com/pera-soho-reservations-new-york?restref=76933"><img width="230" height="37" class="float-left" src="http://dev.pera.com/wp-content/themes/pera_soho/images/make-a-reservation.png" alt="Make a Reservation"></a>
				</div>
			</div>
		</div>
		
		<?php
			$rows = [];
		
			while($row = mysql_fetch_array($result6)) {
				$rows[] = $row;
			}
		?>
		
		<div id="live-menu-skydeck" class="full-module white-background live-menu"><!--SKYDECK MENU-->
			<div class="specials-module-inside">
				<div class="three-column">
					<h3 class="uppercase no-margin-bottom">Wines by the Glass</h3>
					<h4 class="uppercase">Sommelier's Selection</h4>
			
					<p class="uppercase bold medium-font no-margin">White</p>
					
					<?php 
						for ($i = 0; $i < count($rows); ++$i) {					
							//if($rows[$i]["wine_type"] == "White") {
							if($rows[$i]["menu_item_type"] == "Wine") {
								echo '<p class="smaller-font no-margin">'.$rows[$i]['menu_item'].'....'.$rows[$i]['price'].'</p>';
								echo '<p class="smaller-font">'.$rows[$i]['description'].'</p>';
							}
						}
					?>
					
					<p class="uppercase bold medium-font no-margin">Red</p>
					
					<?php 
						for ($i = 0; $i < count($rows); ++$i) {					
							//if($rows[$i]["wine_type"] == "Red") {
							if($rows[$i]["menu_item_type"] == "Wine") {
								echo '<p class="smaller-font no-margin">'.$rows[$i]['menu_item'].'....'.$rows[$i]['price'].'</p>';
								echo '<p class="smaller-font">'.$rows[$i]['description'].'</p>';
							}
						}
					?>
				</div>
				<div class="three-column">
					<h3 class="uppercase">Dips & Chips</h3>
					
					<?php
						for ($i = 0; $i < count($rows); ++$i) {
							if($rows[$i]["menu_item_type"] == "Dips and Chips") {
								echo '<p class="uppercase bold medium-font no-margin">'.$rows[$i]['menu_item'].'....'.$rows[$i]['price'].'</p>';
								echo '<p class="smaller-font">'.$rows[$i]['description'].'</p>';
							}
						}
					?>
					
					<h3 class="uppercase">Salads</h3>
				
					<?php 
						for ($i = 0; $i < count($rows); ++$i) {	
							if($rows[$i]["menu_item_type"] == "Salads") {
								echo '<p class="uppercase bold medium-font no-margin">'.$rows[$i]['menu_item'].'....'.$rows[$i]['price'].'</p>';
								echo '<p class="smaller-font">'.$rows[$i]['description'].'</p>';
							}
						}
					?>
				</div>
				<div class="three-column">
					<h3 class="uppercase">Specialty Cocktails</h3>
					
					<?php 
						for ($i = 0; $i < count($rows); ++$i) {						
							if($rows[$i]["menu_item_type"] == "Specialty Cocktails") {
								echo '<p class="uppercase bold medium-font no-margin">'.$rows[$i]['menu_item'].'....'.$rows[$i]['price'].'</p>';
								echo '<p class="smaller-font">'.$rows[$i]['description'].'</p>';
							}
						}
					?>
				</div>
				<div class="clear-both">
					<h3 class="uppercase">Mezes</h3>
					<div class="three-column">
						<?php
							//echo "COUNT: ".count($rows)/2;
							$rows2 = [];
							$j = 0;
							
							for ($i = 0; $i < count($rows); ++$i) {
								if($rows[$i]['menu_item_type'] == "Mezes") {
									$rows2[$j]["id"] = $rows[$i]["id"];
									$rows2[$j]["description"] = $rows[$i]["description"];
									$rows2[$j]["price"] = $rows[$i]["price"];
									$rows2[$j]["menu_item"] = $rows[$i]["menu_item"];
									$rows2[$j]["menu_item_type"] = $rows[$i]["menu_item_type"];
									
									$j++;
								}
							}
							
							reset($rows2);
						
						
							for ($i = 0; $i < count($rows2)/3; ++$i) {					

									echo '<p class="uppercase bold medium-font no-margin">'.$rows2[$i]['menu_item'].'....'.$rows2[$i]['price'].'</p>';
									echo '<p class="smaller-font">'.$rows2[$i]['description'].'</p>';

								$j = $i;
							}
							
							reset($rows2);
						?>
					</div>
					<div class="three-column">
						<?php 
							for ($i = $j; $i < count($rows2)/3; ++$i) {				
								echo '<p class="uppercase bold medium-font no-margin">'.$rows2[$i]['menu_item'].'....'.$rows2[$i]['price'].'</p>';
								echo '<p class="smaller-font">'.$rows2[$i]['description'].'</p>';
							}
							
							reset($rows2);
						?>
					</div>
					<div class="three-column">
						<?php 
							for ($i = $j; $i < count($rows2)/3; ++$i) {		
								echo '<p class="uppercase bold medium-font no-margin">'.$rows2[$i]['menu_item'].'....'.$rows2[$i]['price'].'</p>';
								echo '<p class="smaller-font">'.$rows2[$i]['description'].'</p>';
							}
							
							reset($rows2);
						?>
					</div>
				</div>
			
				<img src="<?php echo $bloginfo ;?>separator.png" alt="Separator" />
			
				<div class="oveflow-auto">
					<h3 class="uppercase center">Plates</h3>
					
					
					<?php 
						for ($i = 0; $i < count($rows); ++$i) {					
							if($rows[$i]["menu_item_type"] == "Plates") {
								echo '<div class="two-column">';
								echo '<p class="uppercase bold medium-font no-margin">'.$rows[$i]['menu_item'].'....'.$rows[$i]['price'].'</p>';
								echo '<p class="smaller-font">'.$rows[$i]['description'].'</p>';
								echo '</div>';
							}
						}
					?>
				</div>

				<img src="<?php echo $bloginfo ;?>separator.png" alt="Separator" />
			
				<div class="oveflow-auto">
					<h3 class="uppercase center">Sides</h3>
					<?php 
						for ($i = 0; $i < count($rows); ++$i) {					
							if($rows[$i]["menu_item_type"] == "Sides") {
								echo '<div class="three-column">';
								echo '<p class="uppercase bold medium-font no-margin">'.$rows[$i]['menu_item'].'....'.$rows[$i]['price'].'</p>';
								echo '<p class="smaller-font">'.$rows[$i]['description'].'</p>';
								echo '</div>';
							}
						}
					?>
				</div>
			
				<div class="small-module-inside white-background">
					<a href="<?php echo $base_url; ?>/wp-content/uploads/2014/06/dinner_menu.pdf"><img width="230" height="37" class="clear-both float-left margin-small-right" src="http://dev.pera.com/wp-content/themes/pera_soho/images/download-menu.png" alt="Download Menu"></a>
			
					<a href="http://www.opentable.com/pera-soho-reservations-new-york?restref=76933"><img width="230" height="37" class="float-left" src="http://dev.pera.com/wp-content/themes/pera_soho/images/make-a-reservation.png" alt="Make a Reservation"></a>
				</div>
			</div>
		</div>
	</div>
	
	<div class="full-module white-background"><!--SEPARATOR IMAGE-->
		<div class="separator-inside">
			<img src="<?php echo $bloginfo ;?>separator.png" alt="Separator" />
		</div>
	</div>
	
	<?php include("contact.php"); ?>
	
	<div class="full-module white-background"><!--SEPARATOR IMAGE-->
		<div class="separator-inside-bottom">
			<img src="<?php echo $bloginfo ;?>separator.png" alt="Separator" />
		</div>
	</div>
</div>

<?php
//do_action('skeleton_before_content');
//get_template_part('loop', 'index');
//do_action('skeleton_after_content');
//get_sidebar();
get_footer();
?>