<?php
/**
 * Created by PhpStorm.
 * User: Marek
 * Date: 2.11.2017 г.
 * Time: 11:34
 */

function q_mk_activate_plugin(){
    // if the version is less then 4.2 wp_die
    if(version_compare(get_bloginfo('version') , '4.2' , '<')){
      wp_die(__("You must update WordPress to use this plugin." , "quote-of-the-day-mk"));
    }

    global $wpdb;

    $tableName = $wpdb->prefix . "quote_mk";

    if ($wpdb->get_var('SHOW TABLES LIKE ' . $tableName) != $tableName){
        $sql = 'CREATE TABLE ' .$tableName . '(
          `id` INT NOT NULL AUTO_INCREMENT, 
          `author` VARCHAR(255) NOT NULL,
          `profession` VARCHAR(255) NOT NULL,
          `quote` TEXT NOT NULL, 
          `create_at` DATETIME NOT NULL, 
          `update_at` DATETIME NOT NULL, 
          PRIMARY KEY (`id`) 
        )';

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);

        add_option('quote_mk_database_version' , '0.1');
    }
}