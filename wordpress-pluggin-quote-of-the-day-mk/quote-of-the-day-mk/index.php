<?php
/**
 * Plugin Name: Quote of the Day MK
 * Author: Marek
 * Description: Quote of the Day MK , provides a functionality to add Quote of the Day for any page. With the ability to add , edit and delete the quotes you like and think are suitable.
 * Version: 1.0
 * Text Domain: quote-of-the-day-mk
 */

// forbidding direct opening of the plugin
if (!function_exists('add_action')){
    echo "Not Allowed!";
    exit();
}

// Setup
define('QUOTE_MK_PLUGIN_DIR' , plugin_dir_path(__FILE__));
define('QUOTE_MK_PLUGIN_NAME' , 'quote-of-the-day-mk');


// Includes
include_once('includes/activate.php');
include_once('includes/init.php');
include_once('includes/classes/Quote_MK_Widget.class.php');
include_once('admin/includes/init.php');

// Register Widget
function register_quote_mk(){
    register_widget('Quote_MK_Widget');
}

// Hooks
register_activation_hook(__FILE__, 'q_mk_activate_plugin');
add_action('init', 'q_mk_init');
add_action('init', 'q_mk_admin_init');
add_action('init', 'checkIfCustomAdminPage'); // for removing unnecessary styles and scripts
add_action('widgets_init', 'register_quote_mk');


// Menu  items
add_action('admin_menu','q_mk_modifymenu');

require_once(QUOTE_MK_PLUGIN_DIR . 'admin/process/q_mk_list.php');
require_once(QUOTE_MK_PLUGIN_DIR . 'admin/process/q_mk_create.php');
require_once(QUOTE_MK_PLUGIN_DIR . 'admin/process/q_mk_update.php');

// Shortcodes