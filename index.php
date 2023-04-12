<?php

/**
 * Plugin Name:       Portfolio Theme Blocks
 * Description:       A collection of gutenberg blocks
 * Requires at least: 5.9
 * Requires PHP:      7.0
 * Version:           1.0.0
 * Author:            Lewis Rotchell
 * Text Domain:       portfolio-theme-blocks
 */

//Below stops someone from accessing the file directly
if (!function_exists('add_action')) {
    exit;
}

//Setup
define('PB_PLUGIN_DIR', plugin_dir_path(__FILE__));

//Includes
//glob is a function that returns an array of files
$rootFiles = glob(PB_PLUGIN_DIR . 'includes/*.php');
$subDirectoryFiles = glob(PB_PLUGIN_DIR . 'includes/**/*.php');
$allFiles = array_merge($rootFiles, $subDirectoryFiles);

foreach ($allFiles as $file) {
    include_once($file);
}

//Hooks
add_action('init', 'pb_register_blocks');
add_action('wp_enqueue_scripts', 'pb_register_scripts');
