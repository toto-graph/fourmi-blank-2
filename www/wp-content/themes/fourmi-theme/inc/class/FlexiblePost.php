<?php

class FlexiblePost extends Timber\Post {

	public function get_flexibles() {
		$flexibles = $this->get_field('flexibles');

		if (empty($flexibles)) {
			return [];
		}

		foreach ($flexibles as &$flexible) :
			switch ($flexible['acf_fc_layout']) {
				case 'list-articles':
					if ($flexible['articles-type'] == 'latest') {
						$args = [
							'post_type' => 'post',
							'post_status' => 'publish',
							'posts_per_page' => 3,
						];

						$flexible['articles'] = Timber::get_posts($args);
					}
					elseif ($flexible['articles-type'] == 'custom') {
						foreach ($flexible['articles'] as &$article) {
							$article = $article['article'];
						}
					}
				break;
				case 'list-events':
					if ($flexible['events-type'] == 'next') {
						$flexible['events'] = PostEvent::get_next_events(2);
					}
					elseif ($flexible['events-type'] == 'custom') {
						foreach ($flexible['events'] as &$event) {
							$event = new PostEvent($event['event']->id);
						}
					}
				break;
			}
		endforeach;

		return $flexibles;
	}

	public function get_schema() {
		$schema = [
			'@context' => 'https://schema.org',
			'@type' => 'NewsArticle',
			'headline' => $this->title,
			'datePublished' => fourmi_decompose_date($this->date)['schema'],
			'dateModified' => fourmi_decompose_date($this->date)['schema'],
			'mainEntityOfPage' => [
				'@type' => 'WebPage',
				'@id' => $this->link,
			],
			'image' => [
				$this->thumbnail->src,
			],
			'publisher' => [
				'@type' => 'Organization',
				'name' => 'Who Run The World',
				'url' => WEBSITE_URL,
				'logo' => fourmi_image('logo.png'),
			],
			'author' => [
				'@type' => 'Person',
				'name' => 'Who Run The World',
			],
		];

		return $schema;
	}

}
