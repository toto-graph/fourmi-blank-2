<?php

Timber::$dirname = array('templates');
Timber::$autoescape = false;

class FourmiSite extends Timber\Site {

	public function __construct() {
		add_action('after_setup_theme', [$this, 'theme_supports']);
		add_filter('timber/context', [$this, 'add_to_context']);
		add_filter('timber/twig', [$this, 'add_to_twig']);
		parent::__construct();
	}

	public function add_to_context($context) {
		$context['site'] = $this;
		$context['menus'] = [
			'main-header-nav' => new Timber\Menu('main-header-nav'),
			'main-header-nav-mobile' => new Timber\Menu('main-header-nav-mobile'),
			'footer-nav-1' => new Timber\Menu('footer-nav-1'),
			'footer-nav-2' => new Timber\Menu('footer-nav-2'),
			'footer-nav-3' => new Timber\Menu('footer-nav-3'),
			'social' => new Timber\Menu('social'),
		];
		$context['links'] = [
			'contact' => get_permalink(PAGE_CONTACT),
			'agenda' => get_permalink(PAGE_AGENDA),
			'blog' => get_permalink(PAGE_BLOG),
		];
		$context['options'] = [
			'adhesion_link' => get_field('adhesion_link', 'option'),
			'contact' => get_field('contact', 'option'),
			'copyright' => get_field('copyright', 'option'),
			'google_analytics' => GOOGLE_ANALYTICS,
			'newsletter' => get_field('newsletter', 'option'),
		];
		$context['breadcrumb'] = fourmi_breadcrumb();
		$context['breadcrumb_schema'] = fourmi_breadcrumb_schema($context['breadcrumb']);
		return $context;
	}

	public function theme_supports() {
		add_theme_support('automatic-feed-links');
		add_theme_support('title-tag');
		add_theme_support('post-thumbnails');
		add_theme_support('html5', [
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		]);
	}

	public function theme_image($file) {
		return fourmi_image($file);
	}

	public function add_to_twig($twig) {
		$twig->addExtension(new Twig\Extension\StringLoaderExtension());
		$twig->addFilter(new Twig\TwigFilter('theme_image', [$this, 'theme_image']));
		return $twig;
	}
}

new FourmiSite();
