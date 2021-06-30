<?php

/**
 * Template Name: Блочный редактор
 */

use Timber\Timber;

$context = Timber::context();
$context['post'] = Timber::get_post();
Timber::render('block-editor-gutenberg.twig', $context);