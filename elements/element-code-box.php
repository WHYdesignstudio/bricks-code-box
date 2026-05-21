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
      $this->control_groups['content']  = [ 'title' => esc_html__( 'Content', 'bricks-code-box' ),        'tab' => 'content' ];
      $this->control_groups['settings'] = [ 'title' => esc_html__( 'Settings', 'bricks-code-box' ),       'tab' => 'content' ];
      $this->control_groups['labels']   = [ 'title' => esc_html__( 'Button Labels', 'bricks-code-box' ),  'tab' => 'content' ];
      $this->control_groups['style']    = [ 'title' => esc_html__( 'Style', 'bricks-code-box' ),          'tab' => 'content' ];
    }

    public function set_controls() {

      /* ── Content ─────────────────────────────────────────────────── */

      $this->controls['code'] = [
        'tab'     => 'content',
        'group'   => 'content',
        'label'   => esc_html__( 'Code', 'bricks-code-box' ),
        'type'    => 'textarea',
        'rows'    => 16,
        'default' => "// your code here\n",
      ];

      /* ── Settings ────────────────────────────────────────────────── */

      $this->controls['language'] = [
        'tab'     => 'content',
        'group'   => 'settings',
        'label'   => esc_html__( 'Language', 'bricks-code-box' ),
        'type'    => 'select',
        'options' => [
          'markup'     => 'Markup (HTML/XML)',
          'javascript' => 'JavaScript',
          'php'        => 'PHP',
          'css'        => 'CSS',
          'java'       => 'Java',
          'python'     => 'Python',
          'sql'        => 'SQL',
          'bash'       => 'Bash/Shell',
        ],
        'default' => 'markup',
      ];

      $theme_options = [
        'prism'                => 'Default (light)',
        'prism-coy'            => 'Coy (light)',
        'prism-solarizedlight' => 'Solarized Light',
        'prism-okaidia'        => 'Okaidia (dark)',
        'prism-tomorrow'       => 'Tomorrow (dark)',
        'prism-twilight'       => 'Twilight (dark)',
        'prism-funky'          => 'Funky',
      ];

      $this->controls['theme'] = [
        'tab'     => 'content',
        'group'   => 'settings',
        'label'   => esc_html__( 'Prism theme (Light)', 'bricks-code-box' ),
        'type'    => 'select',
        'options' => $theme_options,
        'default' => 'prism',
      ];

      $this->controls['theme_dark'] = [
        'tab'     => 'content',
        'group'   => 'settings',
        'label'   => esc_html__( 'Prism theme (Dark Mode)', 'bricks-code-box' ),
        'type'    => 'select',
        'options' => array_merge( [ '' => '— Same as Light —' ], $theme_options ),
        'default' => 'prism-okaidia',
        'description' => esc_html__( 'Used when <html data-brx-theme="dark"> is set.', 'bricks-code-box' ),
      ];

      $this->controls['background_color'] = [
        'tab'         => 'content',
        'group'       => 'settings',
        'label'       => esc_html__( 'Background color (optional)', 'bricks-code-box' ),
        'type'        => 'color',
        'default'     => '',
        'description' => esc_html__( 'Leave empty to use the Prism theme background.', 'bricks-code-box' ),
      ];

      $this->controls['line_numbers'] = [
        'tab'     => 'content',
        'group'   => 'settings',
        'label'   => esc_html__( 'Line numbers', 'bricks-code-box' ),
        'type'    => 'checkbox',
        'default' => true,
      ];

      $this->controls['show_copy'] = [
        'tab'     => 'content',
        'group'   => 'settings',
        'label'   => esc_html__( 'Show copy button', 'bricks-code-box' ),
        'type'    => 'checkbox',
        'default' => true,
      ];

      $this->controls['full_height'] = [
        'tab'     => 'content',
        'group'   => 'settings',
        'label'   => esc_html__( 'Show full code (no limit)', 'bricks-code-box' ),
        'type'    => 'checkbox',
        'default' => false,
      ];

      $this->controls['show_filename'] = [
        'tab'     => 'content',
        'group'   => 'settings',
        'label'   => esc_html__( 'Show filename', 'bricks-code-box' ),
        'type'    => 'checkbox',
        'default' => false,
      ];

      $this->controls['filename'] = [
        'tab'      => 'content',
        'group'    => 'settings',
        'label'    => esc_html__( 'Filename', 'bricks-code-box' ),
        'type'     => 'text',
        'default'  => '',
        'required' => [ 'show_filename', '=', true ],
      ];

      /* ── Button Labels ───────────────────────────────────────────── */

      $this->controls['label_copy_de'] = [
        'tab'     => 'content',
        'group'   => 'labels',
        'label'   => esc_html__( 'Copy label (DE)', 'bricks-code-box' ),
        'type'    => 'text',
        'default' => '📋 Kopieren',
      ];
      $this->controls['label_done_de'] = [
        'tab'     => 'content',
        'group'   => 'labels',
        'label'   => esc_html__( 'Copied label (DE)', 'bricks-code-box' ),
        'type'    => 'text',
        'default' => '✅ Kopiert!',
      ];
      $this->controls['label_copy_en'] = [
        'tab'     => 'content',
        'group'   => 'labels',
        'label'   => esc_html__( 'Copy label (EN)', 'bricks-code-box' ),
        'type'    => 'text',
        'default' => '📋 Copy',
      ];
      $this->controls['label_done_en'] = [
        'tab'     => 'content',
        'group'   => 'labels',
        'label'   => esc_html__( 'Copied label (EN)', 'bricks-code-box' ),
        'type'    => 'text',
        'default' => '✅ Copied!',
      ];

      /* ── Style ───────────────────────────────────────────────────── */

      $this->controls['copy_btn_position'] = [
        'tab'     => 'content',
        'group'   => 'style',
        'label'   => esc_html__( 'Copy button position', 'bricks-code-box' ),
        'type'    => 'select',
        'options' => [
          'right' => esc_html__( 'Top right', 'bricks-code-box' ),
          'left'  => esc_html__( 'Top left',  'bricks-code-box' ),
        ],
        'default' => 'right',
      ];
      $this->controls['copy_btn_offset_y'] = [
        'tab'     => 'content',
        'group'   => 'style',
        'label'   => esc_html__( 'Copy button offset (top, px)', 'bricks-code-box' ),
        'type'    => 'number',
        'default' => 8,
        'unit'    => 'px',
      ];
      $this->controls['copy_btn_offset_x'] = [
        'tab'     => 'content',
        'group'   => 'style',
        'label'   => esc_html__( 'Copy button offset (side, px)', 'bricks-code-box' ),
        'type'    => 'number',
        'default' => 8,
        'unit'    => 'px',
      ];
      $this->controls['copy_btn_bg'] = [
        'tab'         => 'content',
        'group'       => 'style',
        'label'       => esc_html__( 'Copy button background', 'bricks-code-box' ),
        'type'        => 'color',
        'default'     => '',
        'description' => esc_html__( 'Leave empty for transparent background.', 'bricks-code-box' ),
      ];
      $this->controls['copy_btn_color'] = [
        'tab'     => 'content',
        'group'   => 'style',
        'label'   => esc_html__( 'Copy button text color', 'bricks-code-box' ),
        'type'    => 'color',
        'default' => '',
      ];
      $this->controls['copy_btn_border_color'] = [
        'tab'     => 'content',
        'group'   => 'style',
        'label'   => esc_html__( 'Copy button border color', 'bricks-code-box' ),
        'type'    => 'color',
        'default' => '',
      ];
      $this->controls['copy_btn_font_size'] = [
        'tab'     => 'content',
        'group'   => 'style',
        'label'   => esc_html__( 'Copy button font size (px)', 'bricks-code-box' ),
        'type'    => 'number',
        'default' => 12,
        'unit'    => 'px',
      ];
      $this->controls['font_size'] = [
        'tab'     => 'content',
        'group'   => 'style',
        'label'   => esc_html__( 'Font size (px)', 'bricks-code-box' ),
        'type'    => 'number',
        'default' => 14,
        'unit'    => 'px',
      ];
      $this->controls['max_height'] = [
        'tab'         => 'content',
        'group'       => 'style',
        'label'       => esc_html__( 'Max height (px)', 'bricks-code-box' ),
        'type'        => 'number',
        'default'     => 400,
        'unit'        => 'px',
        'description' => esc_html__( 'Set to 0 for no limit', 'bricks-code-box' ),
      ];
    }

    /* ── Asset helpers ───────────────────────────────────────────────── */

    /**
     * Base URL for the plugin's local assets folder.
     * assets/prism/           → JS + line-numbers CSS
     * assets/prism/themes/    → theme CSS files
     */
    private function assets_url( string $relative ): string {
      return plugin_dir_url( dirname( __FILE__ ) ) . 'assets/prism/' . ltrim( $relative, '/' );
    }

    /** Prism version constant – bump when updating the local files. */
    const PRISM_VERSION = '1.29.0';

    /** All valid theme slugs. */
    private function allowed_themes(): array {
      return [
        'prism',
        'prism-coy',
        'prism-solarizedlight',
        'prism-okaidia',
        'prism-tomorrow',
        'prism-twilight',
        'prism-funky',
      ];
    }

    /* ── Enqueue ─────────────────────────────────────────────────────── */

    public function enqueue_scripts() {

      $allowed = $this->allowed_themes();

      /* Light theme */
      $theme = isset( $this->settings['theme'] ) ? sanitize_text_field( $this->settings['theme'] ) : 'prism';
      $theme = in_array( $theme, $allowed, true ) ? $theme : 'prism';

      /* Dark theme (empty string = "same as light", no extra stylesheet) */
      $theme_dark_raw = isset( $this->settings['theme_dark'] ) ? sanitize_text_field( $this->settings['theme_dark'] ) : '';
      $theme_dark     = ( $theme_dark_raw !== '' && in_array( $theme_dark_raw, $allowed, true ) ) ? $theme_dark_raw : '';

      /* ── Core JS (once per page) ── */
      if ( ! wp_script_is( 'bcb-prism-core', 'enqueued' ) ) {
        wp_enqueue_script(
          'bcb-prism-core',
          $this->assets_url( 'prism.min.js' ),
          [],
          self::PRISM_VERSION,
          true
        );
        wp_enqueue_script(
          'bcb-prism-autoloader',
          $this->assets_url( 'prism-autoloader.min.js' ),
          [ 'bcb-prism-core' ],
          self::PRISM_VERSION,
          true
        );
        wp_enqueue_script(
          'bcb-prism-linenumbers',
          $this->assets_url( 'prism-line-numbers.min.js' ),
          [ 'bcb-prism-core' ],
          self::PRISM_VERSION,
          true
        );
      }

      /* ── Light theme CSS (once per page) ── */
      if ( ! wp_style_is( 'bcb-prism-theme', 'enqueued' ) ) {
        wp_enqueue_style(
          'bcb-prism-theme',
          $this->assets_url( 'themes/' . $theme . '.min.css' ),
          [],
          self::PRISM_VERSION
        );
        wp_enqueue_style(
          'bcb-prism-linenumbers',
          $this->assets_url( 'prism-line-numbers.min.css' ),
          [ 'bcb-prism-theme' ],
          self::PRISM_VERSION
        );
      }

      /* ── Dark theme CSS (only when a different dark theme is chosen) ── */
      if ( $theme_dark !== '' && $theme_dark !== $theme ) {
        if ( ! wp_style_is( 'bcb-prism-theme-dark', 'enqueued' ) ) {
          wp_enqueue_style(
            'bcb-prism-theme-dark',
            $this->assets_url( 'themes/' . $theme_dark . '.min.css' ),
            [ 'bcb-prism-theme' ],
            self::PRISM_VERSION
          );
        }
      }

      /* ── Layout CSS (once per page) ── */
      if ( ! wp_style_is( 'bcb-code-box-inline', 'enqueued' ) ) {
        $css =
          '.bcb-code-box-wrapper{position:relative;display:block;width:100%;box-sizing:border-box;overflow:auto;padding:1em;border-radius:8px;max-height:var(--bcb-max-height,400px)}'
         .'.bcb-code-box-wrapper.is-full{max-height:none;overflow:visible}'
         .'.bcb-code-box-wrapper pre{margin:0;width:100%;box-sizing:border-box;white-space:pre-wrap;word-break:break-word;overflow-wrap:anywhere}'
         .'.bcb-code-box-wrapper code{font-family:ui-monospace,Menlo,Monaco,Consolas,"Liberation Mono",monospace;font-size:var(--bcb-font-size,14px);display:block;max-width:100%;white-space:pre-wrap;word-break:break-word;overflow-wrap:anywhere}'
         .'.bcb-code-box-wrapper .copy-btn{position:absolute;top:var(--bcb-btn-top,8px);right:var(--bcb-btn-offset-x,8px);left:auto;background:var(--bcb-btn-bg,transparent);color:var(--bcb-btn-color,#444);border:1px solid var(--bcb-btn-border-color,#444);padding:4px 10px;border-radius:4px;cursor:pointer!important;font-size:var(--bcb-btn-font-size,12px);z-index:9999;pointer-events:auto}'
         .'.bcb-code-box-wrapper.copy-btn-left .copy-btn{right:auto;left:var(--bcb-btn-offset-x,8px)}'
         .'.bcb-code-box-wrapper .copy-btn:hover{background:var(--bcb-btn-bg-hover,transparent);border-color:var(--bcb-btn-border-color-hover,#666);color:var(--bcb-btn-color-hover,#666)}'
         .'.bcb-code-box-wrapper .filename{position:absolute;top:8px;left:8px;background:rgba(0,0,0,0.1);color:#666;padding:2px 8px;border-radius:4px;font-size:11px;font-family:ui-monospace,Menlo,Monaco,Consolas,"Liberation Mono",monospace;z-index:1}'
         .'.bcb-code-box-wrapper.has-filename .copy-btn{right:8px;top:8px}'
         .'.bcb-code-box-wrapper.has-custom-bg,.bcb-code-box-wrapper.has-custom-bg pre[class*="language-"],.bcb-code-box-wrapper.has-custom-bg code[class*="language-"]{background:var(--bcb-bg-color,#f5f5f5)!important;background-image:none!important;box-shadow:none!important;border:none!important;outline:none!important}'
         .'.bcb-code-box-wrapper.has-custom-bg.line-numbers .line-numbers-rows > span:before{background:transparent!important;border:none!important;box-shadow:none!important}'
         .'.bcb-code-box-wrapper.has-custom-bg.line-numbers pre[class*="language-"]{padding-left:3.8em}';

        wp_register_style( 'bcb-code-box-inline', false );
        wp_enqueue_style( 'bcb-code-box-inline' );
        wp_add_inline_style( 'bcb-code-box-inline', $css );
      }

      /* ── Init JS (once per page) ── */
      if ( ! wp_script_is( 'bcb-code-box-init', 'enqueued' ) ) {
        $js = <<<'JS'
(function(){
  /* ── highlight + copy ── */
  function initCodeBox(box){
    var lang=box.getAttribute('data-lang')||'markup';
    var showCopy=box.getAttribute('data-copy')==='1';
    var codeEl=box.querySelector('code');
    var srcTA=box.querySelector('textarea.bcb-code-src');
    if(!codeEl)return;
    var initial=srcTA&&srcTA.value?srcTA.value:codeEl.textContent||codeEl.innerText||'';
    codeEl.className='language-'+lang;
    codeEl.textContent=initial;
    if(window.Prism){Prism.highlightElement(codeEl);}
    var btn=box.querySelector('button.copy-btn');
    if(btn&&showCopy){
      var pageLang=(document.documentElement.lang||'').toLowerCase();
      var isEN=pageLang.indexOf('en')===0;
      var label   =isEN?(box.getAttribute('data-label-en')||'📋 Copy')   :(box.getAttribute('data-label-de')||'📋 Kopieren');
      var labelDone=isEN?(box.getAttribute('data-done-en') ||'✅ Copied!'):(box.getAttribute('data-done-de') ||'✅ Kopiert!');
      if(!btn.textContent){btn.textContent=label;}
      btn.style.cursor='pointer';
      btn.addEventListener('click',function(e){
        e.preventDefault();e.stopPropagation();
        var text=(srcTA&&srcTA.value)||codeEl.innerText||codeEl.textContent||'';
        function flash(){var orig=btn.textContent;btn.textContent=labelDone;setTimeout(function(){btn.textContent=orig;},2000);}
        if(navigator.clipboard&&navigator.clipboard.writeText){
          navigator.clipboard.writeText(text).then(flash).catch(function(){fbCopy(text);flash();});
        }else{fbCopy(text);flash();}
      });
    }else if(btn){btn.style.display='none';}
  }

  function fbCopy(text){
    var ta=document.createElement('textarea');
    ta.value=text;ta.setAttribute('readonly','');
    ta.style.cssText='position:fixed;top:0;left:0;opacity:0';
    document.body.appendChild(ta);ta.focus();ta.select();
    try{document.execCommand('copy');}catch(e){}
    document.body.removeChild(ta);
  }

  function initAll(){document.querySelectorAll('.bcb-code-box-wrapper').forEach(initCodeBox);}

  /* ── Dark Mode theme switcher ── */
  function applyDarkTheme(){
    var isDark=document.documentElement.getAttribute('data-brx-theme')==='dark';
    var lightLink=document.getElementById('bcb-prism-theme-css');
    var darkLink =document.getElementById('bcb-prism-theme-dark-css');
    if(!darkLink)return; // no separate dark theme – nothing to do
    if(isDark){
      if(lightLink)lightLink.disabled=true;
      darkLink.disabled=false;
    }else{
      if(lightLink)lightLink.disabled=false;
      darkLink.disabled=true;
    }
  }

  /* Watch <html data-brx-theme="..."> changes */
  if(window.MutationObserver){
    new MutationObserver(function(muts){
      muts.forEach(function(m){
        if(m.type==='attributes'&&m.attributeName==='data-brx-theme'){applyDarkTheme();}
      });
    }).observe(document.documentElement,{attributes:true,attributeFilter:['data-brx-theme']});
  }

  if(document.readyState==='loading'){
    document.addEventListener('DOMContentLoaded',function(){initAll();applyDarkTheme();});
  }else{
    initAll();applyDarkTheme();
  }
  if(window.bricksIsFrontend){
    document.addEventListener('bricks/frontend/init',function(){initAll();applyDarkTheme();});
  }
})();
JS;
        wp_register_script( 'bcb-code-box-init', '', [], '1.0.4', true );
        wp_enqueue_script( 'bcb-code-box-init' );
        wp_add_inline_script( 'bcb-code-box-init', $js );
      }
    }

    /* ── Render ──────────────────────────────────────────────────────── */

    public function render() {
      $settings = $this->settings;

      $code        = isset( $settings['code'] ) ? (string) $settings['code'] : '';
      $language    = isset( $settings['language'] ) ? sanitize_text_field( $settings['language'] ) : 'markup';
      $lineNumbers = ! empty( $settings['line_numbers'] );
      $showCopy    = isset( $settings['show_copy'] ) ? (bool) $settings['show_copy'] : true;
      $font_size   = isset( $settings['font_size'] )   ? max( 8,  min( 32, intval( $settings['font_size'] ) ) )   : 14;
      $max_height  = isset( $settings['max_height'] )  ? max( 0,  intval( $settings['max_height'] ) )             : 400;
      $full_height = ! empty( $settings['full_height'] );
      $show_fn     = ! empty( $settings['show_filename'] );
      $filename    = isset( $settings['filename'] ) ? sanitize_text_field( $settings['filename'] ) : '';

      $allowed_languages = [ 'markup', 'javascript', 'php', 'css', 'java', 'python', 'sql', 'bash' ];
      $language = in_array( $language, $allowed_languages, true ) ? $language : 'markup';

      /* Classes */
      $root_classes = [ 'bcb-code-box-wrapper' ];
      if ( $lineNumbers )               { $root_classes[] = 'line-numbers'; }
      if ( $show_fn && $filename !== '' ) { $root_classes[] = 'has-filename'; }
      if ( $full_height )               { $root_classes[] = 'is-full'; }

      /* Custom background */
      $bg_raw = $settings['background_color'] ?? '';
      if ( is_array( $bg_raw ) ) { $bg_raw = (string) reset( $bg_raw ); }
      $has_custom_bg = is_string( $bg_raw ) && $bg_raw !== '';
      $bg_color      = $has_custom_bg ? sanitize_text_field( $bg_raw ) : '';
      if ( $has_custom_bg ) { $root_classes[] = 'has-custom-bg'; }

      /* Copy button */
      $btn_pos        = isset( $settings['copy_btn_position'] )  ? sanitize_text_field( $settings['copy_btn_position'] ) : 'right';
      $btn_offset_y   = isset( $settings['copy_btn_offset_y'] )  ? max( 0, intval( $settings['copy_btn_offset_y'] ) )   : 8;
      $btn_offset_x   = isset( $settings['copy_btn_offset_x'] )  ? max( 0, intval( $settings['copy_btn_offset_x'] ) )   : 8;
      $btn_font_size  = isset( $settings['copy_btn_font_size'] ) ? max( 8, min( 24, intval( $settings['copy_btn_font_size'] ) ) ) : 12;

      $btn_bg_raw  = $settings['copy_btn_bg']           ?? '';
      $btn_col_raw = $settings['copy_btn_color']        ?? '';
      $btn_brd_raw = $settings['copy_btn_border_color'] ?? '';

      $btn_bg  = is_array( $btn_bg_raw )  ? (string) reset( $btn_bg_raw )  : (string) $btn_bg_raw;
      $btn_col = is_array( $btn_col_raw ) ? (string) reset( $btn_col_raw ) : (string) $btn_col_raw;
      $btn_brd = is_array( $btn_brd_raw ) ? (string) reset( $btn_brd_raw ) : (string) $btn_brd_raw;

      if ( $btn_pos === 'left' ) { $root_classes[] = 'copy-btn-left'; }

      /* Inline style (CSS custom properties) */
      $style  = '--bcb-font-size:'   . esc_attr( $font_size )     . 'px;';
      $style .= '--bcb-max-height:'  . esc_attr( $max_height )    . 'px;';
      $style .= '--bcb-btn-top:'     . esc_attr( $btn_offset_y )  . 'px;';
      $style .= '--bcb-btn-offset-x:'. esc_attr( $btn_offset_x )  . 'px;';
      $style .= '--bcb-btn-font-size:'. esc_attr( $btn_font_size ) . 'px;';
      if ( $btn_bg  !== '' ) { $style .= '--bcb-btn-bg:'          . esc_attr( $btn_bg )  . ';--bcb-btn-bg-hover:'           . esc_attr( $btn_bg )  . ';'; }
      if ( $btn_col !== '' ) { $style .= '--bcb-btn-color:'       . esc_attr( $btn_col ) . ';--bcb-btn-color-hover:'        . esc_attr( $btn_col ) . ';'; }
      if ( $btn_brd !== '' ) { $style .= '--bcb-btn-border-color:'. esc_attr( $btn_brd ) . ';--bcb-btn-border-color-hover:' . esc_attr( $btn_brd ) . ';'; }
      if ( $has_custom_bg )  { $style .= '--bcb-bg-color:'        . esc_attr( $bg_color ) . ';'; }

      /* Root attributes */
      $this->set_attribute( '_root', 'class',        $root_classes );
      $this->set_attribute( '_root', 'style',        $style );
      $this->set_attribute( '_root', 'data-lang',    esc_attr( $language ) );
      $this->set_attribute( '_root', 'data-copy',    $showCopy ? '1' : '0' );
      $this->set_attribute( '_root', 'data-label-de', esc_attr( sanitize_text_field( $settings['label_copy_de'] ?? '📋 Kopieren' ) ) );
      $this->set_attribute( '_root', 'data-done-de',  esc_attr( sanitize_text_field( $settings['label_done_de']  ?? '✅ Kopiert!' ) ) );
      $this->set_attribute( '_root', 'data-label-en', esc_attr( sanitize_text_field( $settings['label_copy_en'] ?? '📋 Copy' ) ) );
      $this->set_attribute( '_root', 'data-done-en',  esc_attr( sanitize_text_field( $settings['label_done_en']  ?? '✅ Copied!' ) ) );

      /* Output */
      echo '<div ' . $this->render_attributes( '_root' ) . '>';

        if ( $show_fn && $filename !== '' ) {
          echo '<div class="filename">' . esc_html( $filename ) . '</div>';
        }

        if ( $showCopy ) {
          $locale       = function_exists( 'determine_locale' ) ? determine_locale() : get_locale();
          $is_en        = is_string( $locale ) && strpos( strtolower( $locale ), 'en' ) === 0;
          $initialLabel = $is_en
            ? sanitize_text_field( $settings['label_copy_en'] ?? '📋 Copy' )
            : sanitize_text_field( $settings['label_copy_de'] ?? '📋 Kopieren' );
          echo '<button class="copy-btn" type="button">' . esc_html( $initialLabel ) . '</button>';
        }

        echo '<pre class="' . esc_attr( $lineNumbers ? 'line-numbers' : '' ) . '">'
           . '<code class="language-' . esc_attr( $language ) . '">'
           . esc_html( $code )
           . '</code></pre>';

        echo '<textarea class="bcb-code-src" hidden>' . esc_textarea( $code ) . '</textarea>';

      echo '</div>';
    }
  }
}
