<?php

use Timber\Timber;

$context = Timber::context();
$context['posts'] = Timber::get_post();
Timber::render('index.twig', $context);