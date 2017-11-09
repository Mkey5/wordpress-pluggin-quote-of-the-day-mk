<?php
/**
 * Created by PhpStorm.
 * User: Marek
 * Date: 2.11.2017 г.
 * Time: 11:49
 */

function q_mk_init(){

    // Enqueues for the frontend

    // register
    wp_register_script('q_mk_js_cookie_script', plugins_url( QUOTE_MK_PLUGIN_NAME . '/assets/js/jquery.cookie.js'), array('jquery'));
    wp_register_script('q_mk_script', plugins_url( QUOTE_MK_PLUGIN_NAME . '/assets/js/quote_mk.js'), array('jquery',
        'q_mk_js_cookie_script'));
    wp_register_style('q_mk_style', plugins_url( QUOTE_MK_PLUGIN_NAME . '/assets/css/quote_mk.css'));

    // enqueue
    wp_enqueue_script('q_mk_js_cookie_script');
    wp_enqueue_script('q_mk_script');
    wp_enqueue_style('q_mk_style');
}

function q_mk_modifymenu() {

    //this is the main item for the menu
    add_menu_page('Quote Of The Day', //page title
        'Quote Of The Day', //menu title
        'manage_options', //capabilities
        'q_mk_list', //menu slug
        'q_mk_list' //function
    );

    //this is a submenu
    add_submenu_page('q_mk_create', //parent slug
        'Add New Quote', //page title
        'Add New', //menu title
        'manage_options', //capability
        'q_mk_create', //menu slug
        'q_mk_create'); //function

    //this submenu is HIDDEN, however, we need to add it anyways
    add_submenu_page(null, //parent slug
        'Update Quote', //page title
        'Update', //menu title
        'manage_options', //capability
        'q_mk_update', //menu slug
        'q_mk_update'); //function
}