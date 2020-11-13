<?php

/*
  Template Name: Contact
*/

$context = Timber::context();
$timber_post = new FlexiblePost();

$context['post'] = $timber_post;

Timber::render(['page-contact.twig'], $context);
