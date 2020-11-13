<?php

class PostEvent extends FlexiblePost {

	static function get_all_events() {
		$args = [
			'post_type' => 'event',
			'post_status' => 'publish',
			'orderby' => 'meta_value',
			'order' => 'ASC',
			'meta_key' => 'date_start',
			'nopaging' => true,
		];

		return Timber::get_posts($args, 'PostEvent');
	}

	static function get_next_events($nb = 2) {
		$args = [
			'post_type' => 'event',
			'post_status' => 'publish',
			'orderby' => 'meta_value',
			'order' => 'ASC',
			'meta_key' => 'date_start',
			'posts_per_page' => $nb,
			'meta_query' => [
				[
					'key' => 'date_start',
					'value' => date('Y/m/d', time()),
					'compare' => '>=',
					'type' => 'DATE'
				]
			]
		];

		return Timber::get_posts($args, 'PostEvent');
	}

	static function get_search_events($s = '', $nb = 3) {
		$args = [
			'post_type' => 'event',
			'post_status' => 'publish',
			'orderby' => 'meta_value',
			'order' => 'ASC',
			'meta_key' => 'date_start',
			'posts_per_page' => $nb,
			's' => $s,
			'meta_query' => [
				[
					'key' => 'date_start',
					'value' => date('Y/m/d', time()),
					'compare' => '>=',
					'type' => 'DATE'
				]
			]
		];

		return Timber::get_posts($args, 'PostEvent');
	}

	public function get_date_start() {
		$date_start = $this->get_field('date_start');

		return fourmi_decompose_date($date_start);
	}

	public function is_future() {
		$date_start = $this->get_date_start();
		return $date_start['timestamp'] > time();
	}

	public function is_past() {
		return !$this->is_future();
	}

	public function category() {
		$categories = $this->terms('event_category');

		if (!is_a($categories, 'WP_Error') && !empty($categories)) {
			return $categories[0];
		}

		return null;
	}

	public function get_schema() {
		$schema = [
			'@context' => 'https://schema.org',
			'@type' => 'Event',
			'name' => $this->title,
			'startDate' => $this->get_date_start()['schema'],
			'eventAttendanceMode' => 'https://schema.org/OfflineEventAttendanceMode',
			'eventStatus' => 'https://schema.org/EventScheduled',
			'location' => [
				'@type' => 'Place',
				'name' => $this->location,
				'address' => [
					// TODO : adresse ?
				],
			],
			'image' => [
				$this->thumbnail->src,
			],
			'description' => get_the_excerpt($this),
			'organizer' => [
				'@type' => 'Organization',
				'name' => 'Who Run The World',
				'url' => WEBSITE_URL,
				'logo' => fourmi_image('logo.png'),
			],
		];

		return $schema;
	}

}
