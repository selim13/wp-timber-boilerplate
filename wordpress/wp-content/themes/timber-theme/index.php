<?php

use Timber\Timber;

$context = Timber::context();
$context['posts'] = Timber::get_post();
$templates = ['index.twig'];
if (is_home()) {
    $templates = ['front-page.twig', 'index.twig'];
}
Timber::render($templates, $context);