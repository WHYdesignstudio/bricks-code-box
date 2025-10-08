<?php

/**
 * Plugin Name: Bricks Code Box
 * Plugin URI:  https://github.com/WHYdesignstudio/bricks-code-box
 * Description: Fügt dem Bricks Builder ein Code-Box-Element hinzu mit Prism.js Syntax-Highlighting, Copy-Button, Zeilennummern und optionalem Titel.
 * Version:     1.0.2
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

// 2) Element-Klasse definieren
if ( class_exists('\Bricks\Element') && ! class_exists('BCB_Element_Code_Box') ) {
  class BCB_Element_Code_Box extends \Bricks\Element {
    public $category     = 'general';
    public $name         = 'bcb-code-box';
    public $icon         = 'ti-code';
    public $css_selector = '.bcb-code-box-wrapper';
    public $scripts      = [];

    public function get_label() {
      return esc_html__( 'Code Box', 'bricks-code-box' );
    }

    public function get_keywords() {
      return [ 'code', 'snippet', 'prism', 'copy', 'highlight' ];
    }

    public function set_control_groups() {
      $this->control_groups['content'] = [ 'title' => esc_html__( 'Content', 'bricks-code-box' ), 'tab' => 'content' ];
      $this->control_groups['settings'] = [ 'title' => esc_html__( 'Settings', 'bricks-code-box' ), 'tab' => 'content' ];
      $this->control_groups['labels'] = [ 'title' => esc_html__( 'Button Labels', 'bricks-code-box' ), 'tab' => 'content' ];
      $this->control_groups['style'] = [ 'title' => esc_html__( 'Style', 'bricks-code-box' ), 'tab' => 'style' ];
    }

    public function set_controls() {
      $this->controls['code'] = [
        'tab' => 'content', 'group' => 'content', 'label' => esc_html__( 'Code', 'bricks-code-box' ),
        'type' => 'textarea', 'rows' => 16, 'default' => "// your code here\n",
      ];
      $this->controls['language'] = [
        'tab' => 'content', 'group' => 'settings', 'label' => esc_html__( 'Language', 'bricks-code-box' ),
        'type' => 'select',
        'options' => [
          'markup' => 'Markup (HTML/XML)','javascript' => 'JavaScript','php' => 'PHP','css' => 'CSS','java' => 'Java','python' => 'Python','sql' => 'SQL', 'bash' => 'Bash/Shell',
        ],
        'default' => 'markup',
      ];
      $this->controls['line_numbers'] = [
        'tab' => 'content','group' => 'settings','label' => esc_html__( 'Line numbers', 'bricks-code-box' ),
        'type' => 'checkbox','default' => true,
      ];
      $this->controls['show_copy'] = [
        'tab' => 'content','group' => 'settings','label' => esc_html__( 'Show copy button', 'bricks-code-box' ),
        'type' => 'checkbox','default' => true,
      ];
      $this->controls['label_copy_de'] = [
        'tab'=>'content','group'=>'labels','label'=>esc_html__( 'Copy label (DE)', 'bricks-code-box' ),
        'type'=>'text','default'=>'📋 Kopieren',
      ];
      $this->controls['label_done_de'] = [
        'tab'=>'content','group'=>'labels','label'=>esc_html__( 'Copied label (DE)', 'bricks-code-box' ),
        'type'=>'text','default'=>'✅ Kopiert!',
      ];
      $this->controls['label_copy_en'] = [
        'tab'=>'content','group'=>'labels','label'=>esc_html__( 'Copy label (EN)', 'bricks-code-box' ),
        'type'=>'text','default'=>'📋 Copy',
      ];
      $this->controls['label_done_en'] = [
        'tab'=>'content','group'=>'labels','label'=>esc_html__( 'Copied label (EN)', 'bricks-code-box' ),
        'type'=>'text','default'=>'✅ Copied!',
      ];
      $this->controls['font_size'] = [
        'tab'=>'style','group'=>'style','label'=>esc_html__( 'Font size (px)', 'bricks-code-box' ),
        'type'=>'number','default'=>14,'unit'=>'px',
      ];
    }

    public function enqueue_scripts() {
      wp_enqueue_style('bcb-prism-theme','https://cdn.jsdelivr.net/npm/prismjs/themes/prism-tomorrow.min.css',[],null);
      wp_enqueue_style('bcb-prism-linenumbers','https://cdn.jsdelivr.net/npm/prismjs/plugins/line-numbers/prism-line-numbers.min.css',['bcb-prism-theme'],null);
      wp_enqueue_script('bcb-prism-core','https://cdn.jsdelivr.net/npm/prismjs/prism.min.js',[],null,true);
      wp_enqueue_script('bcb-prism-autoloader','https://cdn.jsdelivr.net/npm/prismjs/plugins/autoloader/prism-autoloader.min.js',['bcb-prism-core'],null,true);
      wp_enqueue_script('bcb-prism-linenumbers','https://cdn.jsdelivr.net/npm/prismjs/plugins/line-numbers/prism-line-numbers.min.js',['bcb-prism-core'],null,true);

      $css = '.bcb-code-box-wrapper{position:relative;background:#2d2d2d;color:#ccc;overflow:auto;padding:1em;border-radius:8px;}.bcb-code-box-wrapper pre{margin:0;background:transparent!important}.bcb-code-box-wrapper code{font-family:ui-monospace,Menlo,Monaco,Consolas,"Liberation Mono",monospace;font-size:var(--bcb-font-size,14px)}.bcb-code-box-wrapper .copy-btn{position:absolute;top:8px;right:8px;background:#444;color:#fff;border:none;padding:4px 10px;border-radius:4px;cursor:pointer;font-size:12px;z-index:1}.bcb-code-box-wrapper .copy-btn:hover{background:#666}';
      wp_register_style('bcb-code-box-inline', false);
      wp_enqueue_style('bcb-code-box-inline');
      wp_add_inline_style('bcb-code-box-inline', $css);

      $js = <<<JS
(function(){function initCodeBox(box){var lang=box.getAttribute('data-lang')||'markup';var showCopy=box.getAttribute('data-copy')==='1';var codeEl=box.querySelector('code');var srcTextarea=box.querySelector('textarea.bcb-code-src');if(!codeEl||!srcTextarea)return;codeEl.className='language-'+lang;codeEl.textContent=srcTextarea.value||'';if(window.Prism){Prism.highlightElement(codeEl);}var btn=box.querySelector('button.copy-btn');if(btn&&showCopy){var pageLang=(document.documentElement.lang||'').toLowerCase();var isEN=pageLang.indexOf('en')===0;var label=isEN?(box.getAttribute('data-label-en')||'📋 Copy'):(box.getAttribute('data-label-de')||'📋 Kopieren');var labelDone=isEN?(box.getAttribute('data-done-en')||'✅ Copied!'):(box.getAttribute('data-done-de')||'✅ Kopiert!');btn.textContent=label;btn.addEventListener('click',function(){var textToCopy=srcTextarea.value||'';function showCopiedMessage(){var originalText=btn.textContent;btn.textContent=labelDone;setTimeout(function(){btn.textContent=originalText;},2000);}if(navigator.clipboard&&navigator.clipboard.writeText){navigator.clipboard.writeText(textToCopy).then(showCopiedMessage).catch(showCopiedMessage);}else{var ta=document.createElement('textarea');ta.value=textToCopy;ta.style.position='fixed';ta.style.left='-9999px';document.body.appendChild(ta);ta.select();try{document.execCommand('copy');}catch(e){}document.body.removeChild(ta);showCopiedMessage();}});}}else if(btn){btn.style.display='none';}}function initAllCodeBoxes(){document.querySelectorAll('.bcb-code-box-wrapper').forEach(initCodeBox);}if(document.readyState==='loading'){document.addEventListener('DOMContentLoaded',initAllCodeBoxes);}else{initAllCodeBoxes();}if(window.bricksIsFrontend){document.addEventListener('bricks/frontend/init',initAllCodeBoxes);}})();
JS;
      wp_register_script('bcb-code-box-init', '', [], null, true);
      wp_enqueue_script('bcb-code-box-init');
      wp_add_inline_script('bcb-code-box-init', $js);
    }

    public function render() {
      $settings = $this->settings;
      $code = $settings['code'] ?? '';
      $language = $settings['language'] ?? 'markup';
      $lineNumbers = !empty($settings['line_numbers']);
      $showCopy = isset($settings['show_copy']) ? (bool)$settings['show_copy'] : true;
      $font_size = isset($settings['font_size']) ? intval($settings['font_size']) : 14;

      $root_classes = [ 'bcb-code-box-wrapper' ];
      if ( $lineNumbers ) {
        $root_classes[] = 'line-numbers';
      }

      $this->set_attribute('_root', 'class', $root_classes);
      $this->set_attribute('_root', 'style', '--bcb-font-size: ' . esc_attr($font_size) . 'px;');
      $this->set_attribute('_root', 'data-lang', esc_attr($language));
      $this->set_attribute('_root', 'data-copy', $showCopy ? '1' : '0');
      $this->set_attribute('_root', 'data-label-de', esc_attr($settings['label_copy_de'] ?? '📋 Kopieren'));
      $this->set_attribute('_root', 'data-done-de', esc_attr($settings['label_done_de'] ?? '✅ Kopiert!'));
      $this->set_attribute('_root', 'data-label-en', esc_attr($settings['label_copy_en'] ?? '📋 Copy'));
      $this->set_attribute('_root', 'data-done-en', esc_attr($settings['label_done_en'] ?? '✅ Copied!'));

      echo '<div ' . $this->render_attributes('_root') . '>';
        if ( $showCopy ) {
          echo '<button class="copy-btn" type="button"></button>';
        }
        echo '<pre><code class="language-' . esc_attr($language) . '"></code></pre>';
        echo '<textarea class="bcb-code-src" hidden>' . esc_textarea($code) . '</textarea>';
      echo '</div>';
    }
  }
}

// 3) Element registrieren (per Datei-Pfad)
add_action('init', function () {
  if ( class_exists('\Bricks\Elements') ) {
    \Bricks\Elements::register_element( plugin_dir_path(__FILE__) . 'elements/element-code-box.php' );
  }
}, 11);

