<?php

/**
 * Plugin Name: Bricks Code Box
 * Plugin URI:  https://github.com/WHYdesignstudio/bricks-code-box
 * Description: Adds a Code Box element to Bricks Builder with Prism.js syntax highlighting, copy button, line numbers, and optional title.
 * Version:     1.0.5
 * Author:      Why Studio
 * Author URI:  https://why.studio/
 * Text Domain: bricks-code-box
 * Domain Path: /languages
 * Requires PHP: 7.4
 * Requires at least: 6.0
 * Update URI:  https://github.com/WHYdesignstudio/bricks-code-box
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// GitHub Updates via Plugin Update Checker
require_once __DIR__ . '/inc/plugin-update-checker/plugin-update-checker.php';
use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

$bcbUpdateChecker = PucFactory::buildUpdateChecker(
  'https://github.com/WHYdesignstudio/bricks-code-box', // Metadata URL: GitHub repo
  __FILE__,                                              // Full path to main plugin file
  'bricks-code-box'                                      // Plugin slug (unique)
);
// If your default branch is not "master", set it (e.g. "main").
$bcbUpdateChecker->setBranch('main');
// If you publish GitHub Releases with attached zip files, enable assets:
// $bcbUpdateChecker->getVcsApi()->enableReleaseAssets();

// Ensure is_plugin_active is available in admin area
if ( is_admin() && ! function_exists('is_plugin_active') ) {
  require_once ABSPATH . 'wp-admin/includes/plugin.php';
}

// 1) Admin notice if Bricks is not active
add_action('admin_init', function () {
  if ( is_admin() && (!is_plugin_active('bricks/bricks.php') && !class_exists('\Bricks\Element')) ) {
    add_action('admin_notices', function () {
      echo '<div class="notice notice-error"><p><strong>Bricks Code Box</strong> requires the Bricks Theme/Plugin. Please activate Bricks.</p></div>';
    });
  }
});

// 2) Include element file (prevents code duplication)
if ( class_exists('\Bricks\Element') ) {
  require_once plugin_dir_path(__FILE__) . 'elements/element-code-box.php';
}

// 3) Register element (by file path)
add_action('init', function () {
  if ( class_exists('\Bricks\Elements') ) {
    \Bricks\Elements::register_element( plugin_dir_path(__FILE__) . 'elements/element-code-box.php' );
  }
}, 11);