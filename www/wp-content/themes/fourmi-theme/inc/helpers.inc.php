<?php

function fourmi_breadcrumb() {
	global $post;

	$breadcrumb = [];

	$breadcrumb[] = [
		'link' => get_home_url('/'),
		'label' => 'Accueil',
	];

	if ($post->post_parent) {
		$parent = get_post($post->post_parent);

		if ($parent->post_parent) {
			$grandparent = get_post($parent->post_parent);
			$breadcrumb[] = [
				'link' => get_permalink($grandparent),
				'label' => $grandparent->post_title,
			];
		}

		$breadcrumb[] = [
			'link' => get_permalink($parent),
			'label' => $parent->post_title,
		];
	}

	if ($post->post_type == 'post') {
		$parent = get_post(PAGE_BLOG);
		$breadcrumb[] = [
			'link' => get_permalink($parent),
			'label' => $parent->post_title,
		];
	}

	if ($post->post_type == 'event') {
		$parent = get_post(PAGE_AGENDA);
		$breadcrumb[] = [
			'link' => get_permalink($parent),
			'label' => $parent->post_title,
		];
	}

	$breadcrumb[] = [
		'link' => get_permalink($post),
		'label' => $post->post_title,
	];

	return $breadcrumb;
}

function fourmi_breadcrumb_schema($breadcrumb) {
	$position = 0;
	$schema = [
		"@context" => "https://schema.org",
		"@type" => "BreadcrumbList",
		"itemListElement" => []
	];

	foreach ($breadcrumb as $item) {
		$schema[] = [
			"@type" => "ListItem",
			"position" => ++ $position,
			"name" => $item['label'],
			"item" => $item['link']
		];
	}

	return json_encode($schema);
}

function fourmi_image($name) {
	return get_stylesheet_directory_uri() . '/dist/img/' . $name;
}

function fourmi_image_e($name) {
	echo fourmi_image($name);
}

function fourmi_date_to_ago($date) {
	$day = 60 * 60 * 24;

	$date = [
		'timestamp' => strtotime($date),
		'string' => date('d/m/Y', strtotime($date)),
	];

	$today = [
		'timestamp' => time(),
		'string' => date('d/m/Y', time()),
	];

	$yesterday = [
		'timestamp' => time() - $day,
		'string' => date('d/m/Y', time() - $day),
	];

	if ($date['string'] == $today['string']) {
		return "Aujourd'hui";
	}
	elseif ($date['string'] == $yesterday['string']) {
		return "Hier";
	}
	else {
		$days_diff = floor(($today['timestamp'] - $date['timestamp'])/$day);
		
		if ($days_diff < 30) {
			return "Il y a " . $days_diff . " jours";
		}
		else {
			return $date['string'];
		}
	}
}

function fourmi_date_to_ago_e($date) {
	echo fourmi_date_to_ago($date);
}

function fourmi_decompose_date($date) {
	$timestamp = strtotime($date);
	$day = date('d', $timestamp);
	$month = date('m', $timestamp);
	$year = date('Y', $timestamp);
	$hours = date('H', $timestamp);
	$minutes = date('i', $timestamp);
	$daynum = date('w', $timestamp);

	$month_names = ['', 'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
	$month_names_short = ['', 'Jan', 'Fév', 'Mars', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sept', 'Oct', 'Nov', 'Déc'];
	$day_names = ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];

	$text = $day_names[intval($daynum)] . ' ' . $day . ' ' . $month_names[intval($month)];

	$date_start = [
		'time' => $hours . ':' . $minutes,
		'dmy' => $day . '/' . $month . '/' . $year,
		'text' => $text,
		'textyear' => $text . ' ' . $year,
		'datepicker' => $year . '-' . $month . '-' . $day,
		'timestamp' => $timestamp,
		'daynum' => $day,
		'monthshort' => $month_names_short[intval($month)],
		'monthyear' => $month . '-' . $year,
		'schema' => date('c', $timestamp),
	];

	return $date_start;
}