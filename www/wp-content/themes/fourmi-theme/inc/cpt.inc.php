<?php

add_action('init', 'fourmi_register_cpt', 0);
function fourmi_register_cpt() {

	register_post_type('event', [
	 	'labels'    => [
			'name'               => 'Evénements',
			'singular_name'      => 'Evénement',
			'menu_name'          => 'Evénements',
			'name_admin_bar'     => 'Evénements',
			'add_new'            => 'Ajouter',
			'add_new_item'       => 'Ajouter un nouvel événement',
			'new_item'           => 'Nouvel événement',
			'edit_item'          => 'Editer événement',
			'view_item'          => 'Voir l\'événement',
			'all_items'          => 'Tous les événements',
			'search_items'       => 'Chercher un événement',
			'not_found'          => 'Aucun événement trouvé',
			'not_found_in_trash' => 'Aucun événement trouvé',
	 	],
	 	'public' => true,
	 	'has_archive' => false,
	 	'hierarchical' => false,
	 	'menu_icon' => 'dashicons-calendar-alt',
	 	'menu_position' => 6,
	 	'taxonomies' => ['event_category'],
	 	'show_in_rest' => true,
	 	'rewrite' => ['slug' => 'agenda', 'with_front' => false],
	 	'supports' => ['title', 'thumbnail', 'excerpt'],
	]);

	register_taxonomy('event_category', 'event', [
		'label' => 'Catégories',
		'labels' => [
			'name'          => 'Catégories',
			'singular_name' => 'Catégorie',
			'all_items'     => 'Toutes les catégories',
			'edit_item'     => 'Editer la catégorie',
			'add_new_item'  => 'Ajouter une catégorie',
			'not_found'     => 'Aucune catégorie trouvée',
		],
	 	'show_in_rest' 		=> true,
		'hierarchical'      => true,
		'show_ui'           => true,
		'query_var'         => true,
		'show_admin_column' => true,
		'public'            => true,
	]);

}
