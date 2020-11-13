<?php

$context = Timber::context();
$timber_post = new FlexiblePost();

$context['post'] = $timber_post;
$context['menu_home'] = new Timber\Menu('home-nav');

Timber::render(['index.twig'], $context);
