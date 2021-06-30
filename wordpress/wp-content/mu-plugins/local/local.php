<?php

use Local\Admin;
use Local\Gutenberg;

require __DIR__ . '/vendor/autoload.php';

Admin::wp_init();
Gutenberg::wp_init();