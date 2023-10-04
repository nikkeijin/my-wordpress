<?php

/* 

################################################## 

Remove the admin bar from the top of all pages

*/
show_admin_bar(false);


/* 

################################################## 

Remove default posts type since no blog

*/
add_action('admin_menu', 'remove_default_post_type');

function remove_default_post_type()
{
    remove_menu_page('edit.php');
}
add_action( 'admin_bar_menu', 'remove_default_post_type_menu_bar', 999 );

function remove_default_post_type_menu_bar($wp_admin_bar)
{
    $wp_admin_bar->remove_node('new-post');
}
add_action('wp_dashboard_setup', 'remove_draft_widget', 999);

function remove_draft_widget()
{
    remove_meta_box('dashboard_quick_press', 'dashboard', 'side');
}


/* 

################################################## 

Remove comments in its entirety

*/
add_action( 'admin_menu', 'remove_admin_menus' );
function remove_admin_menus()
{
    remove_menu_page( 'edit-comments.php' );
}

add_action('init', 'remove_comment_support', 100);
function remove_comment_support()
{
    remove_post_type_support( 'post', 'comments' );
    remove_post_type_support( 'page', 'comments' );
}

add_action( 'wp_before_admin_bar_render', 'remove_comments_admin_bar' );
function remove_comments_admin_bar()
{
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('comments');
}


/* 

################################################## 

Hide CPT UI from admin bar

*/
function hide_cpt_ui()
{
	remove_menu_page('cptui_main_menu');
	remove_submenu_page('cptui_main_menu', 'cptui_manage_post_types');
	remove_submenu_page('cptui_main_menu', 'cptui_manage_taxonomies');
	remove_submenu_page('cptui_main_menu', 'cptui_listings');
	remove_submenu_page('cptui_main_menu', 'cptui_tools');
	remove_submenu_page('cptui_main_menu', 'cptui_support');
	remove_submenu_page('cptui_main_menu', 'cptui_main_menu');
}
//add_action('admin_menu', 'hide_cpt_ui', 11);


/* 

################################################## 

Hide ACF from admin bar

*/
//add_filter('acf/settings/show_admin', '__return_false');
