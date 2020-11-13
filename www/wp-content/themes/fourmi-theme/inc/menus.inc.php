<?php

function fourmi_register_menus() {
	register_nav_menus([
		'main-header-nav' => 'Menu Principal',
		'main-header-nav-mobile' => 'Menu Mobile',
		'footer-nav-1' => 'Menu Footer #1',
		'footer-nav-2' => 'Menu Footer #2',
		'footer-nav-3' => 'Menu Footer #3',
		'home-nav' => 'Menu Accueil',
		'social' => 'Menu Social',
	]);
}

add_action('init', 'fourmi_register_menus');

function fourmi_add_options_pages() {
	acf_add_options_page([
		'page_title' 	=> 'Options',
		'menu_title'	=> 'Options',
		'menu_slug' 	=> 'options',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	]);
}

add_action('init', 'fourmi_add_options_pages');

