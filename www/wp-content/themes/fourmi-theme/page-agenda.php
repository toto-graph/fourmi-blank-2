<?php

/*
  Template Name: Agenda
*/

$context = Timber::context();
$timber_post = new FlexiblePost();

$context['post'] = $timber_post;
$context['events'] = PostEvent::get_all_events();

$context['calendar'] = [
	'id' => bin2hex(random_bytes(5)),
	'events' => [],
];

$context['categories'] = Timber::get_terms([
	'taxonomy' => 'event_category',
	'hide_empty' => 1,
]);

$context['category_active'] = isset($_GET['category']) ? filter_var($_GET['category'], FILTER_SANITIZE_STRING) : null;

if (!term_exists($context['category_active'], 'event_category')) {
	$context['category_active'] = null;
}

foreach ($context['events'] as $event) :
	$date = $event->get_date_start();
	$context['calendar']['events'][] = [
		'title' => $event->title,
		'date' => $date['datepicker'],
		'time' => $date['time'],
		'link' => $event->link,
		'id' => $event->ID,
	];
endforeach;

Timber::render(['page-agenda.twig', 'page.twig'], $context);
