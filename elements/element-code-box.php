<?php
if ( ! defined( 'ABSPATH' ) ) exit;

if ( class_exists('\Bricks\Element') && ! class_exists('BCB_Element_Code_Box') ) {
  class BCB_Element_Code_Box extends \Bricks\Element {
    public $category     = 'general';
    public $name         = 'bcb-code-box';
    public $icon         = 'ti-split-v-alt';
    public $css_selector = '.bcb-code-box-wrapper';
    public $scripts      = [];

    public function get_label() {
      return esc_html__( 'Code Box', 'bricks-code-box' );
    }

    public function get_keywords() {
      return [ 'code', 'snippet', 'prism', 'copy', 'highlight' ];
    }

    public function set_control_groups() {
      $this->control_groups['content']  = [ 'title' => esc_html__( 'Content', 'bricks-code-box' ), 'tab' => 'content' ];
      $this->control_groups['settings'] = [ 'title' => esc_html__( 'Settings', 'bricks-code-box' ), 'tab' => 'content' ];
      $this->control_groups['labels']   = [ 'title' => esc_html__( 'Button Labels', 'bricks-code-box' ), 'tab' => 'content' ];
      $this->control_groups['style']    = [ 'title' => esc_html__( 'Style', 'bricks-code-box' ), 'tab' => 'style' ];
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
          'markup' => 'Markup (HTML/XML)','javascript' => 'JavaScript','php' => 'PHP','css' => 'CSS','java' => 'Java','python' => 'Python','sql' => 'SQL','bash' => 'Bash/Shell',
        ],
        'default' => 'markup',
      ];
      $this->controls['theme'] = [
        'tab' => 'content', 'group' => 'settings', 'label' => esc_html__( 'Prism theme', 'bricks-code-box' ),
        'type' => 'select',
        'options' => [
          'prism' => 'Default (light)',
          'prism-coy' => 'Coy (light)',
          'prism-solarizedlight' => 'Solarized Light',
          'prism-okaidia' => 'Okaidia (dark)',
          'prism-tomorrow' => 'Tomorrow (dark)',
          'prism-twilight' => 'Twilight (dark)',
          'prism-funky' => 'Funky',
        ],
        'default' => 'prism',
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
      $this->controls['max_height'] = [
        'tab'=>'style','group'=>'style','label'=>esc_html__( 'Max height (px)', 'bricks-code-box' ),
        'type'=>'number','default'=>400,'unit'=>'px',
        'description' => esc_html__( 'Set to 0 for no limit', 'bricks-code-box' ),
      ];
      $this->controls['full_height'] = [
        'tab'=>'content','group'=>'settings','label'=>esc_html__( 'Show full code (no limit)', 'bricks-code-box' ),
        'type'=>'checkbox','default'=>false,
      ];
      $this->controls['show_filename'] = [
        'tab'=>'content','group'=>'settings','label'=>esc_html__( 'Show filename', 'bricks-code-box' ),
        'type'=>'checkbox','default'=>false,
      ];
      $this->controls['filename'] = [
        'tab'=>'content','group'=>'settings','label'=>esc_html__( 'Filename', 'bricks-code-box' ),
        'type'=>'text','default'=>'',
        'required' => ['show_filename', '=', true],
      ];
    }

    public function enqueue_scripts() {
      // Nur laden wenn noch nicht geladen (Performance-Optimierung)
      if ( !wp_style_is('bcb-prism-theme', 'enqueued') ) {
        $theme = isset($this->settings['theme']) ? sanitize_text_field($this->settings['theme']) : 'prism';
        $allowed_themes = ['prism', 'prism-coy', 'prism-solarizedlight', 'prism-okaidia', 'prism-tomorrow', 'prism-twilight', 'prism-funky'];
        $theme = in_array($theme, $allowed_themes) ? $theme : 'prism';
        
        $theme_url = 'https://cdn.jsdelivr.net/npm/prismjs/themes/' . $theme . '.min.css';
        wp_enqueue_style('bcb-prism-theme', $theme_url, [], '1.29.0');
        wp_enqueue_style('bcb-prism-linenumbers','https://cdn.jsdelivr.net/npm/prismjs/plugins/line-numbers/prism-line-numbers.min.css',['bcb-prism-theme'],'1.29.0');
        wp_enqueue_script('bcb-prism-core','https://cdn.jsdelivr.net/npm/prismjs/prism.min.js',[],'1.29.0',true);
        wp_enqueue_script('bcb-prism-autoloader','https://cdn.jsdelivr.net/npm/prismjs/plugins/autoloader/prism-autoloader.min.js',['bcb-prism-core'],'1.29.0',true);
        wp_enqueue_script('bcb-prism-linenumbers','https://cdn.jsdelivr.net/npm/prismjs/plugins/line-numbers/prism-line-numbers.min.js',['bcb-prism-core'],'1.29.0',true);
      }

      // CSS nur einmal laden (Performance-Optimierung)
      if ( !wp_style_is('bcb-code-box-inline', 'enqueued') ) {
        // Layout & UX only – background/colors come from Prism theme or user CSS
        $css = '.bcb-code-box-wrapper{position:relative;display:block;width:100%;box-sizing:border-box;overflow:auto;padding:1em;border-radius:8px;max-height:var(--bcb-max-height,400px)}.bcb-code-box-wrapper.is-full{max-height:none;overflow:visible}.bcb-code-box-wrapper pre{margin:0;width:100%;box-sizing:border-box;white-space:pre-wrap;word-break:break-word;overflow-wrap:anywhere}.bcb-code-box-wrapper code{font-family:ui-monospace,Menlo,Monaco,Consolas,"Liberation Mono",monospace;font-size:var(--bcb-font-size,14px);display:block;max-width:100%;white-space:pre-wrap;word-break:break-word;overflow-wrap:anywhere}.bcb-code-box-wrapper .copy-btn{position:absolute;top:8px;right:8px;background:transparent;color:#444;border:1px solid #444;padding:4px 10px;border-radius:4px;cursor:pointer!important;font-size:12px;z-index:9999;pointer-events:auto}.bcb-code-box-wrapper .copy-btn:hover{background:transparent;border-color:#666;color:#666}.bcb-code-box-wrapper .filename{position:absolute;top:8px;left:8px;background:rgba(0,0,0,0.1);color:#666;padding:2px 8px;border-radius:4px;font-size:11px;font-family:ui-monospace,Menlo,Monaco,Consolas,"Liberation Mono",monospace;z-index:1}.bcb-code-box-wrapper.has-filename .copy-btn{right:8px;top:8px}';
        wp_register_style('bcb-code-box-inline', false);
        wp_enqueue_style('bcb-code-box-inline');
        wp_add_inline_style('bcb-code-box-inline', $css);
      }

      // JavaScript nur einmal laden (Performance-Optimierung)
      if ( !wp_script_is('bcb-code-box-init', 'enqueued') ) {
        $js = <<<JS
(function(){function initCodeBox(box){var lang=box.getAttribute('data-lang')||'markup';var showCopy=box.getAttribute('data-copy')==='1';var codeEl=box.querySelector('code');var srcTextarea=box.querySelector('textarea.bcb-code-src');if(!codeEl)return;var initial=srcTextarea&&srcTextarea.value?srcTextarea.value:codeEl.textContent||codeEl.innerText||'';codeEl.className='language-'+lang;codeEl.textContent=initial;if(window.Prism){Prism.highlightElement(codeEl);}var btn=box.querySelector('button.copy-btn');if(btn&&showCopy){var pageLang=(document.documentElement.lang||'').toLowerCase();var isEN=pageLang.indexOf('en')===0;var label=isEN?(box.getAttribute('data-label-en')||'📋 Copy'):(box.getAttribute('data-label-de')||'📋 Kopieren');var labelDone=isEN?(box.getAttribute('data-done-en')||'✅ Copied!'):(box.getAttribute('data-done-de')||'✅ Kopiert!');if(!btn.textContent){btn.textContent=label;}btn.style.cursor='pointer';btn.addEventListener('click',function(e){e.preventDefault();e.stopPropagation();var textToCopy=(srcTextarea&&srcTextarea.value)||codeEl.innerText||codeEl.textContent||'';function showCopiedMessage(){var originalText=btn.textContent;btn.textContent=labelDone;setTimeout(function(){btn.textContent=originalText;},2000);}if(navigator.clipboard&&navigator.clipboard.writeText){navigator.clipboard.writeText(textToCopy).then(showCopiedMessage).catch(function(){fallbackCopy(textToCopy);showCopiedMessage();});}else{fallbackCopy(textToCopy);showCopiedMessage();}});}else if(btn){btn.style.display='none';}}function fallbackCopy(text){var ta=document.createElement('textarea');ta.value=text;ta.setAttribute('readonly','');ta.style.position='fixed';ta.style.top='0';ta.style.left='0';ta.style.opacity='0';document.body.appendChild(ta);ta.focus();ta.select();try{document.execCommand('copy');}catch(e){}document.body.removeChild(ta);}function initAllCodeBoxes(){document.querySelectorAll('.bcb-code-box-wrapper').forEach(initCodeBox);}if(document.readyState==='loading'){document.addEventListener('DOMContentLoaded',initAllCodeBoxes);}else{initAllCodeBoxes();}if(window.bricksIsFrontend){document.addEventListener('bricks/frontend/init',initAllCodeBoxes);}})();
JS;
        wp_register_script('bcb-code-box-init', '', [], '1.0.2', true);
        wp_enqueue_script('bcb-code-box-init');
        wp_add_inline_script('bcb-code-box-init', $js);
      }
    }

    public function render() {
      $settings   = $this->settings;
      // Keep code exactly as entered; escaping happens at output (esc_html / esc_textarea)
      $code       = isset($settings['code']) ? (string) $settings['code'] : '';
      $language   = isset($settings['language']) ? sanitize_text_field($settings['language']) : 'markup';
      $lineNumbers= !empty($settings['line_numbers']);
      $showCopy   = isset($settings['show_copy']) ? (bool)$settings['show_copy'] : true;
      $font_size  = isset($settings['font_size']) ? max(8, min(32, intval($settings['font_size']))) : 14;
      $max_height = isset($settings['max_height']) ? max(0, intval($settings['max_height'])) : 400;
      $full_height = !empty($settings['full_height']);
      $show_filename = !empty($settings['show_filename']);
      $filename   = isset($settings['filename']) ? sanitize_text_field($settings['filename']) : '';
      
      // Validiere Sprache gegen erlaubte Werte
      $allowed_languages = ['markup', 'javascript', 'php', 'css', 'java', 'python', 'sql', 'bash'];
      $language = in_array($language, $allowed_languages) ? $language : 'markup';

      $root_classes = [ 'bcb-code-box-wrapper' ];
      if ( $lineNumbers ) { $root_classes[] = 'line-numbers'; }
      if ( $show_filename && !empty($filename) ) { $root_classes[] = 'has-filename'; }

      if ( $full_height ) { $root_classes[] = 'is-full'; }
      $this->set_attribute('_root', 'class', $root_classes);
      $this->set_attribute('_root', 'style', '--bcb-font-size: ' . esc_attr($font_size) . 'px; --bcb-max-height: ' . esc_attr($max_height) . 'px;');
      $this->set_attribute('_root', 'data-lang', esc_attr($language));
      $this->set_attribute('_root', 'data-copy', $showCopy ? '1' : '0');
      $this->set_attribute('_root', 'data-label-de', esc_attr(sanitize_text_field($settings['label_copy_de'] ?? '📋 Kopieren')));
      $this->set_attribute('_root', 'data-done-de', esc_attr(sanitize_text_field($settings['label_done_de'] ?? '✅ Kopiert!')));
      $this->set_attribute('_root', 'data-label-en', esc_attr(sanitize_text_field($settings['label_copy_en'] ?? '📋 Copy')));
      $this->set_attribute('_root', 'data-done-en', esc_attr(sanitize_text_field($settings['label_done_en'] ?? '✅ Copied!')));

      echo '<div ' . $this->render_attributes('_root') . '>';
        if ( $show_filename && !empty($filename) ) {
          echo '<div class="filename">' . esc_html($filename) . '</div>';
        }
        if ( $showCopy ) {
          $locale = function_exists('determine_locale') ? determine_locale() : get_locale();
          $is_en  = is_string($locale) && strpos(strtolower($locale), 'en') === 0;
          $initialLabel = $is_en ? sanitize_text_field($settings['label_copy_en'] ?? '📋 Copy') : sanitize_text_field($settings['label_copy_de'] ?? '📋 Kopieren');
          echo '<button class="copy-btn" type="button">' . esc_html($initialLabel) . '</button>';
        }
        $pre_classes = $lineNumbers ? 'line-numbers' : '';
        echo '<pre class="' . esc_attr($pre_classes) . '"><code class="language-' . esc_attr($language) . '">' . esc_html($code) . '</code></pre>';
        echo '<textarea class="bcb-code-src" hidden>' . esc_textarea($code) . '</textarea>';
      echo '</div>';
    }
  }
}


