<?php
/**
 * Created by PhpStorm.
 * User: Marek
 * Date: 3.11.2017 г.
 * Time: 16:08
 */

function q_mk_admin_init (){

    // Register
    wp_register_script('q_mk_js_admin_script', plugins_url( QUOTE_MK_PLUGIN_NAME . '/admin/assets/js/admin.js'), array('jquery'));
    wp_register_style('q_mk_bootstrap', plugins_url( QUOTE_MK_PLUGIN_NAME . '/admin/assets/css/bootstrap.min.css'));
    wp_register_style('q_mk_admin_style', plugins_url( QUOTE_MK_PLUGIN_NAME . '/admin/assets/css/style-admin.css'));

    // Enqueues
    wp_enqueue_script('q_mk_js_admin_script');
    wp_enqueue_style('q_mk_bootstrap');
    wp_enqueue_style('q_mk_admin_style');
}