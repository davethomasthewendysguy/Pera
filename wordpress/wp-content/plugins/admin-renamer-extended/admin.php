<?php
/**
 * Admin renamer extended operations.
 *
 * Managing the worpress additonal admin renamer extended operations.
 *
 * @category      Wordpress Plugins
 * @package       Plugins
 * @author        Ramon Fincken <>
 * @copyright     Yes, Open source, WebsiteFreelancers.nl
*/
if (!defined('ABSPATH')) die("Aren't you supposed to come here via WP-Admin?");

/**
 * Displays the admin page
 */
function plugin_admin_renamer_initpage() {
   if (isset ($_GET['page']) && ($_GET['page'] == 'admin_renamer_extended/admin.php' || $_GET['page'] == 'admin-renamer-extended/admin.php')) {
      require_once PLUGIN_ADMIN_RENAMER_DIR . '/form.php';
   }
}

/**
 * Additional links on the plugin page
 */
function plugin_admin_renamer_RegisterPluginLinks($links, $file) {
   if ($file == 'admin-renamer-extended/admin_renamer.php') {
      $links[] = '<a href="plugins.php?page=admin-renamer-extended/admin.php">' . __('Settings') . '</a>';
      $links[] = '<a href="http://donate.ramonfincken.com">' . __('Donate') . '</a>';
      $links[] = '<a href="http://www.mijnpress.nl">' . __('Custom WordPress coding nodig?') . '</a>';
   }
   return $links;
}

add_filter('plugin_row_meta','plugin_admin_renamer_RegisterPluginLinks', 10, 2);

/**
 * Left menu display in Plugin menu
 */
function plugin_admin_renamer_addMenu() {
   add_submenu_page("plugins.php", "Admin renamer extended", "Admin renamer extended", 10, __FILE__, 'plugin_admin_renamer_initpage');
}

add_action('admin_menu', 'plugin_admin_renamer_addMenu');

/**
 * Loading the CSS file
 */
function plugin_admin_renamer_css() {
   $admin_stylesheet_url = plugin_admin_renamer_plugin_url('styles/style.css');
   echo '<link rel="stylesheet" href="' . $admin_stylesheet_url . '" type="text/css" />';
}
add_action('admin_head', 'plugin_admin_renamer_css');

/**
 * Generating the url for current Plugin
 *
 * @param String $path
 * @return String
 */
function plugin_admin_renamer_plugin_url($path = '') {
   global $wp_version;

   if (version_compare($wp_version, '2.8', '<')) { // Using WordPress 2.7
      $folder = dirname(plugin_basename(__FILE__));
      if ('.' != $folder)
         $path = path_join(ltrim($folder, '/'), $path);
      return plugins_url($path);
   }
   return plugins_url($path, __FILE__);
}
?>