<?php
/**
 * Admin renamer extended operations.
 *
 * Managing the worpress additonal admin renamer extended operations.
 *
 * @category      Wordpress Plugins
 * @package    Plugins
 * @author        Ramon Fincken <>
 * @copyright     Yes, Open source, WebsiteFreelancers.nl
*/
if (!defined('ABSPATH')) die("Aren't you supposed to come here via WP-Admin?");
global $wpdb, $current_user;

$message = null;
$showMsg = 'none';

if(!current_user_can('remove_users'))
{
	wp_die('No permission to change usernames','You are not allowed to do this');
}

/**
 * If submiting the form
 */
if (count($_POST)) {
   // Is magic quotes on?
   if (get_magic_quotes_gpc()) {
      // Yes? Strip the added slashes
      $_POST = array_map('stripslashes', $_POST);
   }

   $oldName = htmlspecialchars(trim($_POST['plugin_admin_renamer-oldname' . intval($_GET['user_id'])]));
   $newName = htmlspecialchars(trim($_POST['plugin_admin_renamer-newname' . intval($_GET['user_id'])]));

   if (empty ($newName)) {
      $message = stripslashes($oldName) . ' NOT changed-> New name was empty!';
      $showMsg = 'block';
   } else {
      if (!validate_username($newName)) {
         $message = stripslashes($oldName) . ' NOT changed -> This username is invalid. Please enter a valid username.';
         $showMsg = 'block';
      } else {
         if (username_exists($newName)) {
            $message = stripslashes($oldName) . ' NOT changed -> This username is already registered. Please choose another one.';
            $showMsg = 'block';
         } else {
            $user_query = "UPDATE $wpdb->users SET user_login = '" . mysql_real_escape_string(stripslashes($newName)) . "' WHERE {$wpdb->users}.ID = " . intval($_GET['user_id']) . " LIMIT 1";
            $wpdb->get_results($user_query);


		if(is_multisite())
		{
			$network_site_admins = get_site_option('site_admins');

			$key = 0;
			foreach($network_site_admins as $val)
			{
				if($val == mysql_real_escape_string(stripslashes($oldName)))
				{
					// Update
					$network_site_admins[$key] = mysql_real_escape_string(stripslashes($newName));
					// Only if found .. should have one hit
					update_site_option('site_admins',$network_site_admins);
				}
				$key++;
			}
		}


            $message = 'Changed ' . stripslashes($oldName) . ' into ' . stripslashes($newName);
            $showMsg = 'block';

         }
      }
   }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
    <div class="plugin_admin_renamer-wrapper">
      <div class="plugin_admin_renamer-head">
         <div class="plugin_admin_renamer-head-left"></div>
            <div class="plugin_admin_renamer-head-mid">
            Admin renamer - Showing all admin accounts
            </div>

            <div class="plugin_admin_renamer-head-right"></div>
        </div>
        <div class="plugin_admin_renamer-save" id="plugin_admin_renamer-save" style="display:<?php echo $showMsg; ?>">
         <div class="plugin_admin_renamer-save-message">
            <?php echo @$message; ?>
         </div>
        </div>
<?php
$users = get_users('role=administrator');
foreach ($users AS $row) {
?>        <div class="plugin_admin_renamer-formarea-outer">
           <div class="plugin_admin_renamer-formarea">
           <p>Current admin username: <strong><?php echo $row->user_login; ?></strong>
           <?php

   if ($row->ID == 1) {
      echo '<br/>Warning: <strong>This is the MAIN admin or site owner!</strong>';
   }
   if ($row->ID == $current_user->ID) {
      echo '<br/>Warning: <strong>This is you! After changing your login name you might need to log in again!</strong>';
   }
?>
           </p>
             <form id="form1" name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF'].'?page='.$_GET['page'].'&user_id='.$row->ID; ?>" >
               <div class="plugin_admin_renamer-box01">
               <label>
               <a name="top"></a>
                 <input type="hidden" name="plugin_admin_renamer-oldname<?php echo $row->ID; ?>" id="plugin_admin_renamer-newCat" class="plugin_admin_renamer-ip-box" value="<?php echo $row->user_login; ?>"/>
                 <input type="text" name="plugin_admin_renamer-newname<?php echo $row->ID; ?>" id="plugin_admin_renamer-newCat" class="plugin_admin_renamer-ip-box" value="<?php echo $row->user_login; ?>"/>
               </label>
               </div>
               <div class="plugin_admin_renamer-box01">
               <input type="submit" name="button" value="Update" style="margin-top: 2px;" />
               </div>
             </form>
           </div>
   </div>
   <?php

}
?>
</body>
</html>
