<?php

function fourmi_get_search_results($s) {
    $items = [];

    $items['events'] = PostEvent::get_search_events($s);
    $items['articles'] = new Timber\PostQuery([
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per_page' => 9,
        'paged' => 1,
        's' => $s,
    ]);
    $items['pages'] = new Timber\PostQuery([
        'post_type' => 'page',
        'post_status' => 'publish',
        'posts_per_page' => 6,
        'paged' => 1,
        's' => $s,
    ]);
    $items['s'] = $s;

    return $items;
}


function fourmi_get_search_ajax() {
    $s = (isset($_GET['s'])) ? filter_var($_GET['s'], FILTER_SANITIZE_STRING) : '';

    $items = fourmi_get_search_results($s);
    Timber::render(['components/search-results.twig'], $items);

    exit;
}
add_action( 'wp_ajax_fourmi_get_search_ajax', 'fourmi_get_search_ajax' );
add_action( 'wp_ajax_nopriv_fourmi_get_search_ajax', 'fourmi_get_search_ajax' );
