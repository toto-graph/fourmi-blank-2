<?php
function fourmi_widgets_init() {

	register_sidebar([
		'name' => 'Newsletter',
		'id' => 'newsletter',
	]);

}

add_action('widgets_init', 'fourmi_widgets_init');
