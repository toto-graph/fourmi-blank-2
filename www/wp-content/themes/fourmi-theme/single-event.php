<?php

$context = Timber::context();
$timber_post = new PostEvent();

$context['post'] = $timber_post;

Timber::render(['single.twig'], $context);
