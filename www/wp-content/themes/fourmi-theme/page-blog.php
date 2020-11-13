<?php

/*
  Template Name: Blog
*/

$context = Timber::context();
$timber_post = new FlexiblePost();

$context['post'] = $timber_post;

global $paged;
$paged = (!isset($paged) || !$paged) ? 1 : $paged;

$context['categories'] = Timber::get_terms([
	'taxonomy' => 'category',
	'hide_empty' => 1,
]);

$context['category_active'] = isset($_GET['category']) ? filter_var($_GET['category'], FILTER_SANITIZE_STRING) : null;

if (!term_exists($context['category_active'], 'category')) {
	$context['category_active'] = null;
}

$args = [
	'post_type' => 'post',
	'post_status' => 'publish',
	'posts_per_page' => POSTS_PER_PAGE,
	'paged' => $paged,
];

if ($context['category_active']) {
	$args['tax_query'] = [[
		'taxonomy' => 'category',
		'field' => 'slug',
		'terms' => $context['category_active']
	]];
}

$context['query'] = new Timber\PostQuery($args);

Timber::render(['page-blog.twig', 'page.twig'], $context);
