<?php
add_filter('wpseo_post_content_for_recalculation', 'fourmi_yoast_flexibles', 10, 2);

function fourmi_yoast_flexibles($content, $post) {
	//return 'UN DEUX TROIS QUATRE CINQ';
	return $content;
}