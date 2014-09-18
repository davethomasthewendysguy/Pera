<?php error_reporting(E_ALL); ?>

<style>
.success {
	margin:5px 5px 5px 0; padding:10px; width:500px; color:#00ae04; border:2px solid #00ae04;
}

.error {
	margin:5px 5px 5px 0; padding:10px; width:500px; color:#ae0000; border:2px solid #ae0000;
}
</style>

<?php
$url = "http://dev.pera.com/wp-admin/admin.php?page=super_plugin_keithics";

if(isset($_GET["action"])) {
	$action = $_GET["action"];
	
	if($action == "edit") {
		$id = $_GET["id"];
		$menu_item = $_GET["menu_item"];
		$menu_item_type = $_GET["menu_item_type"];
		$meal = $_GET["meal"];
		$description = $_GET["description"];
		$menu_order = $_GET["menu_order"];
	} else if($action == "save") {
		$id = $_POST["id"];
		$menu_item = $_GET["menu_item"];
		$menu_item_type = $_POST["menu_item_type"];
		$meal = $_POST["meal"];
		$description = $_POST["description"];
		$menu_order = $_POST["menu_order"];
		
		save_menu_item($id, $menu_order, $menu_item, $meal, $description, $menu_item_type);
	} else if($action == "delete") {
		$id = $_GET["id"];
		$meal = $_GET["meal"];
		$menu_order = $_GET["menu_order"];
		
		delete_menu_item($id, $meal, $menu_order);
	}
} else {
	$action = "";
}

if(isset($_GET["move"]) && isset($_GET["switch_number"]) && isset($_GET["current_number"]) && isset($_GET["id"]) && isset($_GET["meal"])) {
	$move = $_GET["move"];
	$current_order = $_GET["current_number"];
	$switch_order = $_GET["switch_number"];
	$id = $_GET["id"];
	$meal = $_GET["meal"];

	echo "Move direction: ".$move."<br />";
	echo "Current value: ".$current_order."<br />";
	echo "Switch value: ".$switch_order."<br /><br />";
	
	$query = "SELECT * FROM restaurant_menu WHERE id = ".$id;
	$result = mysql_query($query) or die("<div class='error'>Error 1: ".mysql_error()."</div>");
	$row1 = mysql_fetch_row($result);
	
	$query = "SELECT * FROM restaurant_menu WHERE menu_order = ".$switch_order." AND meal = ".$meal;
	$result = mysql_query($query) or die("<div class='error'>Error 2: ".mysql_error()."</div>");
	$row2 = mysql_fetch_row($result);
	
	$switch_id = $row2[0];
	echo "ID: ".$id."<br />";
	echo "Switch ID: ".$switch_id."<br /><br />";
	
	$result = mysql_query("UPDATE restaurant_menu SET menu_order = {$row2[4]} WHERE id = ".$id) or die("<div class='error'>Error 4: ".mysql_error()."</div>");
	$result2 = mysql_query("UPDATE restaurant_menu SET menu_order = {$row1[4]} WHERE id = ".$switch_id) or die("<div class='error'>Error 5: ".mysql_error()."</div>");
	
	if($result) { ?>
		<div class="success">
			Item updated successfully.
		</div>
	<?php }
}

//FUNKY FUNCTIONS
function save_menu_item($id, $menu_order, $menu_item = "", $meal = "", $description = "", $menu_item_type = "") {
	if($id == "" || $id == NULL) {
		
		echo "Menu item: ".$menu_item;
		
		//TODO SET CHECK FOR NULL VALUES
		$query = "SELECT MAX(menu_order) FROM restaurant_menu WHERE meal = {$meal}";
		$result = mysql_query($query) or die("<div class='error'>Error 6: ".mysql_error()."</div>");
		
		$menu_order = mysql_fetch_row($result);
		$menu_order = $menu_order[0] + 1;
	
		$query2 = "INSERT INTO restaurant_menu (menu_item, meal, description, menu_order, menu_item_type) VALUES('{$menu_item}', '{$meal}', '{$description}', {$menu_order}, '{$menu_item_type}')";
		$result2 = mysql_query($query2) or die("<div class='error'>Error 7: ".mysql_error()."</div>");
		
		if($result) { ?>
			<div class="success">
				Item added successfully.
			</div>
		<?php }
	} else {	
		$query = "UPDATE restaurant_menu SET menu_item = '{$menu_item}', meal = '{$meal}', description = '{$description}',  menu_item_type = '{$menu_item_type}' WHERE id = '".$id."'";
		$result = mysql_query($query) or die("<div class='error'>Error 8: ".mysql_error()."</div>");
		
		if($result) { ?>
			<div class="success">
				Item updated successfully.
			</div>
		<?php }
	}
}

function delete_menu_item($id, $meal, $menu_order) {
	$query = "DELETE FROM restaurant_menu WHERE id = ".$id;
	$result = mysql_query($query) or die("<div class='error'>Error 9: ".mysql_error()."</div>");
	
	$query2 = "UPDATE restaurant_menu SET menu_order = menu_order - 1 WHERE menu_order > {$menu_order} AND meal = {$meal}";
	$result2 = mysql_query($query2) or die("<div class='error'>Error 10: ".mysql_error()."</div>");
	
	if($result && $result2) { ?>
		<div class="success">
			Item deleted successfully.
		</div>
	<?php }
}

function get_menu_item($id, $menu_item, $meal, $menu_order, $description = "") { ?>
	<form action="http://dev.pera.com/wp-admin/admin.php?page=super_plugin_keithics&action=save" method="post">
	<tr class="unapproved">
		<td><input type="Submit" value="Save"></td>
		<td>
			<input name="id" value="<?php echo $id; ?>" readonly />
		</td>
		<td>
			<input type="text" name="menu_item" value="<?php echo $menu_item; ?>" />             
		</td>
		<td><input type="text" name="description" value="<?php echo $description; ?>" /></td>
		<td>
			<input type="text" name="meal" value="<?php echo $meal; ?>" /><br />
			0 = Brunch / 1 = Lunch / 2 = Dinner / 3 = Dessert / 4 = Skydeck / 5 = Happy Hour
		</td>
		<td>
			<input name="menu_item_type" value="<?php echo $menu_item_type; ?>" />
		</td>
		<td>
			<input name="menu_order" value="<?php echo $menu_order; ?>" readonly />
		</td>
	</tr>
	</form>
<?php }

function add_menu_item() { ?>
	<form action="http://dev.pera.com/wp-admin/admin.php?page=super_plugin_keithics&action=save" method="post">
	<tr class="unapproved">
		<td><input type="Submit" value="Save"> <a href="http://dev.pera.com/wp-admin/admin.php?page=super_plugin_keithics">Cancel</a></td>
		<td>
			
		</td>
		<td>
			<input type="text" name="menu_item" value="" />             
		</td>
		<td><input type="text" name="description" value="" /></td>
		<td>
			<select name="meal">
				<option selected></option>
				<option value="0">Brunch</option>
				<option value="1">Lunch</option>
				<option value="2">Dinner</option>
				<option value="3">Dessert</option>
				<option value="4">Rooftop</option>
				<option value="5">Happy Hour</option>
			</select>
		</td>
		<td>
			<select name="menu_item_type">
				<option selected></option>
				<option value="Dips and Chips">Dips & Chips</option>
				<option value="Main Plate">Main Plate</option>
				<option value="Mezes">Meze</option>
				<option value="Oven">Oven</option>
				<option value="Side">Sides</option>
				<option value="Cocktail">Specialty Cocktail</option>
				<option value="Wine">Wine</option>
			</select>
		</td>
	</tr>
	</form>
<?php }

function get_menu($meal_option) {
	if (!current_user_can('manage_options')) {
		wp_die( __('You do not have sufficient permissions to access this page.'));
	}
	
	$query = "SELECT * FROM restaurant_menu WHERE meal = '".$meal_option."' ORDER BY meal ASC, menu_order ASC";
	$result = mysql_query($query) or die();
	$row_count = mysql_num_rows($result);
	
	
	if($row_count > 0) {
		while ($row = mysql_fetch_assoc($result)) { ?>
			<tr class="unapproved">
				<td><input type="checkbox" /></td>
				<td>
					<?php echo $row["id"]; ?>
				</td>
				<td>
					<?php echo $row["menu_item"]; ?>
					<div class="row-actions">
					<!--<span class="approve"><a href="#">Approved</a></span>
					<span class="unapprove"><a href="#">Unapprove</a></span>-->
					<?php //echo $url; ?>
					<span class="edit"><a href="http://dev.pera.com/wp-admin/admin.php?page=super_plugin_keithics&action=edit&id=<?php echo $row['id']; ?>&description=<?php echo $row['description']; ?>&menu_item=<?php echo $row['menu_item']; ?>&meal=<?php echo $row['meal']; ?>&$menu_order=<?php echo $row['menu_order']; ?>&$menu_item_type=<?php echo $row['menu_item_type']; ?>">Edit</a> |</span>
					<span class="trash"> <a href="http://dev.pera.com/wp-admin/admin.php?page=super_plugin_keithics&action=delete&id=<?php echo $row['id']; ?>&meal=<?php echo $row['meal']; ?>&menu_order=<?php echo $row['menu_order']; ?>">Delete</a></span>
					</div>                 
				</td>
				<td><?php echo $row["description"]; ?></td>
				<td><?php if($row["meal"] == 0) {
						echo "<span color='#7AA3CC !important'>Brunch</span>";
					} else if($row["meal"] == 1) {
						echo "<span color='#FF6699 !important'>Lunch</span>";
					} else if($row["meal"] == 2) {
						echo "<span color='#FF9933 !important'>Dinner</span>";
					} else if($row["meal"] == 3) {
						echo "<span color='#FF9933 !important'>Dessert</span>";
					} else if($row["meal"] == 4) {
						echo "<span color='#FF9933 !important'>Rooftop</span>";
					} else if($row["meal"] == 5) {
						echo "<span color='#FF9933 !important'>Happy Hour</span>";
					}
				 ?></td>
				<td><?php echo $row["menu_item_type"]; ?></td>
				<td>
					<?php echo $row["menu_order"]; ?>
					<?php //echo "Row Count: ".$row_count; ?>
					<?php //echo "Num Rows: ".mysql_num_rows($result); ?>
					
					<div class="row-actions">
						<?php if($row["menu_order"] > 0 && $row_count > $row["menu_order"]) { ?>
							<span class="approve"><a href="http://dev.pera.com/wp-admin/admin.php?page=super_plugin_keithics&move=up&id=<?php echo $row["id"]; ?>&current_number=<?php echo $row["menu_order"]; ?>&switch_number=<?php echo $row["menu_order"] - 1; ?>&meal=<?php echo $row["meal"]; ?>">Move up</a></span>
							
							<span class="trash"><a href="http://dev.pera.com/wp-admin/admin.php?page=super_plugin_keithics&move=up&id=<?php echo $row["id"]; ?>&current_number=<?php echo $row["menu_order"]; ?>&switch_number=<?php echo $row["menu_order"] + 1; ?>&meal=<?php echo $row["meal"]; ?>">Move down</a></span>
							
						<?php } else if($row["menu_order"] == 0) { ?>
							
							<span class="trash"><a href="http://dev.pera.com/wp-admin/admin.php?page=super_plugin_keithics&move=up&id=<?php echo $row["id"]; ?>&current_number=<?php echo $row["menu_order"]; ?>&switch_number=<?php echo $row["menu_order"] + 1; ?>&meal=<?php echo $row["meal"]; ?>">Move down</a></span>
							
						<?php } else if($row_count == $row["menu_order"]) { ?>
							
							<span class="approve"> <a href="http://dev.pera.com/wp-admin/admin.php?page=super_plugin_keithics&move=up&id=<?php echo $row["id"]; ?>&current_number=<?php echo $row["menu_order"]; ?>&switch_number=<?php echo $row["menu_order"] - 1; ?>&meal=<?php echo $row["meal"]; ?>">Move up</a></span>
							
						<?php } ?>
					</div>
				</td>
			</tr>
		<?php }
	} else {
		if($empty_menu_count == 0) { ?>
			<tr>
				<td></td>
				<td></td>
				<td>No entries found</td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
		<?php $empty_menu_count = 1;
		}
	}
}
?>

<div style="clear:both;">
	<a href="http://dev.pera.com/wp-admin/admin.php?page=super_plugin_keithics&action=add">Add New</a>
</div>

<ul class="subsubsub">
    <li class="all">All |</li>
    <li class="moderated"><a href="#">Unapproved</a> |</li>
    <li class="approved"><a href="#">Approved</a></li>
</ul>

<div class="tablenav">
    <div class="tablenav-pages">
        <span class="displaying-num">1-20 of 31</span>
        <a class="page-numbers" href="#">&laquo;</a>
        <a class="page-numbers" href="#">1</a>
        <span class="page-numbers">2</span>
        <a class="page-numbers" href="#">3</a>
        <a class="page-numbers" href="#">4</a>
        <a class="page-numbers" href="#">5</a>
        <a class="page-numbers" href="#">&raquo;</a>
    </div>
    <div class="alignleft actions">
        <select name="">
            <option>Bulk Actions</option>
            <option>Delete</option>
            <option>Approve Job Post</option>
            <option>Unapprove Job Post</option>
        </select>
        <input type="submit" class="button-secondary apply" value="Apply" />
        <select name="">
            <option>Filter Jobs</option>
            <option>Approved Job Post</option>
            <option>Unapproved Job Post</option>
        </select>
        <input type="submit" class="button-secondary apply" value="Filter" />
    </div>
</div><!-- tablenav -->


<!-- data table -->
<table class="wp-list-table widefat fixed posts">
    <thead>
    <tr>
        <th width="45">#</th>
        <th width="45">ID</th>
        <th class="manage-column">Menu Item</th>
        <th class="manage-column">Description</th>
        <th class="manage-column">Meal</th>
        <th class="manage-column">Menu Item Type</th>
        <th class="manage-column">Menu Order</th>
    </tr>
    </thead>
    <tbody id="the-comment-list">
 		<?php if($action == add) {
			add_menu_item();
		} else if($action == edit) {
			get_menu_item($id, $menu_item, $meal, $menu_item_type, $menu_order, $description, $menu_item_type);
		} else {
			if($empty_menu_count == NULL) {
				$empty_menu_count = 0;
			}
		
			get_menu(0);
  			get_menu(1);
	    	get_menu(2);
	    	get_menu(3);
	    	get_menu(4);
	    	get_menu(5);
		} ?>
    </tbody>
</table>
<!-- table data end -->

<div class="tablenav">
    <div class="tablenav-pages">
        <span class="displaying-num">1-20 of 31</span>
        <span class="page-numbers">1</span>
        <a class="page-numbers" href="#">2</a>
        <a class="page-numbers" href="#">3</a>
        <a class="page-numbers" href="#">4</a>
        <a class="page-numbers" href="#">5</a>
    </div>
    <div class="alignleft actions">
        <select name="">
            <option>Bulk Actions</option>
            <option>Delete</option>
            <option>Approve Job Post</option>
            <option>Unapprove Job Post</option>
        </select>
        <input type="submit" class="button-secondary apply" value="Apply" />
        <select name="">
            <option>Filter Jobs</option>
            <option>Approved Job Post</option>
            <option>Unapproved Job Post</option>
        </select>
        <input type="submit" class="button-secondary apply" value="Filter" />
    </div>
</div><!-- tablenav -->            