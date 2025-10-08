<?php

/**
 * Plugin Name: Bricks Code Box
 * Plugin URI:  https://github.com/WHYdesignstudio/bricks-code-box
 * Description: Fügt dem Bricks Builder ein Code-Box-Element hinzu mit Prism.js Syntax-Highlighting, Copy-Button, Zeilennummern und optionalem Titel.
 * Version:     1.0.3
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

// Stellt sicher, dass is_plugin_active im Admin-Bereich verfügbar ist
if ( is_admin() && ! function_exists('is_plugin_active') ) {
  require_once ABSPATH . 'wp-admin/includes/plugin.php';
}

// 1) Admin-Hinweis, falls Bricks nicht aktiv ist
add_action('admin_init', function () {
  if ( is_admin() && (!is_plugin_active('bricks/bricks.php') && !class_exists('\Bricks\Element')) ) {
    add_action('admin_notices', function () {
      echo '<div class="notice notice-error"><p><strong>Bricks Code Box</strong> benötigt das Bricks Theme/Plugin. Bitte aktiviere Bricks.</p></div>';
    });
  }
});

// 2) Element-Datei einbinden (verhindert Code-Duplikation)
if ( class_exists('\Bricks\Element') ) {
  require_once plugin_dir_path(__FILE__) . 'elements/element-code-box.php';
}

// 3) Element registrieren (per Datei-Pfad)
add_action('init', function () {
  if ( class_exists('\Bricks\Elements') ) {
    \Bricks\Elements::register_element( plugin_dir_path(__FILE__) . 'elements/element-code-box.php' );
  }
}, 11);