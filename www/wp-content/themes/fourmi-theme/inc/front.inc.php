<?php

function fourmi_add_scripts() {
    wp_enqueue_script('fourmi-js', get_stylesheet_directory_uri() . '/dist/js/scripts.min.js');
    wp_localize_script('fourmi-js', 'ajax_url', admin_url('admin-ajax.php'));
}

function fourmi_add_styles() {
    wp_enqueue_script('fourmi-vendor-js', get_stylesheet_directory_uri() . '/dist/js/vendors.min.js');
    wp_enqueue_style('fourmi-google-font', 'https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap');
    wp_enqueue_style('fourmi-style', get_stylesheet_directory_uri() . '/dist/css/style.min.css');
}

add_action('wp_footer', 'fourmi_add_scripts', 10);
add_action('wp_enqueue_scripts', 'fourmi_add_styles', 80);

// ============================================
// Disable unneeded Wordpress scripts
// ============================================
function fourmi_deregister_scripts(){
	wp_deregister_script('wp-embed');
}

function fourmi_dequeue_styles(){

}

add_action('wp_footer', 'fourmi_deregister_scripts');
add_action('wp_enqueue_scripts', 'fourmi_dequeue_styles', 80);

remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action('wp_head', 'wp_generator');

add_filter('wpcf7_autop_or_not', '__return_false');


// ============================================
// Image sizes
// ============================================
add_action('after_setup_theme', 'fourmi_add_image_sizes');
function fourmi_add_image_sizes() {
    add_image_size('fmi-full', 1680);
    add_image_size('fmi-1', 1140);
    add_image_size('fmi-2', 570);
    add_image_size('fmi-3', 380);
    add_image_size('fmi-4', 285);
}