<?php

$context = Timber::context();
$timber_post = new FlexiblePost();

$context['post'] = $timber_post;

Timber::render(['single.twig'], $context);
