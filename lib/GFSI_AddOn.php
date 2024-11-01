<?php

GFForms::include_addon_framework();

class GFSI_AddOn extends GFAddOn {

  protected $_version = "1.0.0";
  protected $_min_gravityforms_version = "1.9";
  protected $_slug = "gravity-forms-source-input";
  protected $_path = "gravityforms-source-input/gravityforms-source-input.php";
  protected $_full_path = __FILE__;
  protected $_title = "Gravity Forms Source Input";
  protected $_short_title = "Source Input";

  private static $_instance = null;

  public static function get_instance() {
    if ( self::$_instance == null ) {
        self::$_instance = new self();
    }

    return self::$_instance;
  }

  public function init() {
    parent::init();

    wp_register_script( 'gf-source-input', $this->get_base_url() . '/../assets/js/source-input.js', array(), false, true );

    $sources = $this->build_sources($this->get_plugin_settings('sources'));

    wp_localize_script( 'gf-source-input', 'gfsiSources', apply_filters( 'gfsi_js_sources', $sources ) );
    wp_enqueue_script( 'gf-source-input' );
  }

  public function plugin_settings_fields() {
    return array(
      array(
        'title' => esc_html__( 'Source Input Settings', 'gfsi' ),
        'fields' => array(
          array(
            'type' => 'checkbox',
            'name' => 'sources',
            'label' => esc_html__( 'Sources to Track', 'gfsi' ),
            'choices' => array(
              array(
                'label' => esc_html__( 'Google AdWords', 'gfsi' ),
                'name' => 'gadwords',
                'tooltip' => esc_html__( '', 'gfsi' ),
                'default_value' => 1
              ),
              array(
                'label' => esc_html__( 'Facebook', 'gfsi' ),
                'name' => 'facebook',
                'tooltip' => esc_html__( '', 'gfsi' ),
                'default_value' => 1
              ),
              array(
                'label' => esc_html__( 'Twitter', 'gfsi' ),
                'name' => 'twitter',
                'tooltip' => esc_html__( '', 'gfsi' ),
                'default_value' => 1
              ),
              array(
                'label' => esc_html__( 'Instagram', 'gfsi' ),
                'name' => 'instagram',
                'tooltip' => esc_html__( '', 'gfsi' ),
                'default_value' => 1
              ),
              array(
                'label' => esc_html__( 'Bing', 'gfsi' ),
                'name' => 'bing',
                'tooltip' => esc_html__( '', 'gfsi' ),
                'default_value' => 1
              ),
              array(
                'label' => esc_html__( 'Pinterest', 'gfsi' ),
                'name' => 'pinterest',
                'tooltip' => esc_html__( '', 'gfsi' ),
                'default_value' => 1
              )
            )
          )
        )
      )
    );
  }

  public function is_valid_setting( $value ) {
    return true;
  }

  public function build_sources($options) {
    $sources = array();

    if ( isset( $options['gadwords'] ) && $options['gadwords'] == '1' ) {
      $sources[] = array(
        'name' => 'Google Adwords',
        'pattern' => array(
          'type'  => 'getQuery',
          'key'   => 'gclid',
          'value' => null
        )
      );
    }

    if ( isset( $options['facebook'] ) && $options['facebook'] == '1' ) {
      $sources[] = array(
        'name' => 'Facebook',
        'pattern' => array(
          'type'  => 'getQuery',
          'key'   => 'utm_source',
          'value' => 'facebook'
        )
      );
    }

    if ( isset( $options['bing'] ) && $options['bing'] == '1' ) {
      $sources[] = array(
        'name' => 'Bing',
        'pattern' => array(
          'type'  => 'getQuery',
          'key'   => 'utm_source',
          'value' => 'bing'
        )
      );
    }

    if ( isset( $options['pinterest'] ) && $options['pinterest'] == '1' ) {
      $sources[] = array(
        'name' => 'Pinterest',
        'pattern' => array(
          'type'  => 'getQuery',
          'key'   => 'utm_source',
          'value' => 'pinterest'
        )
      );
    }

    if ( isset( $options['twitter'] ) && $options['twitter'] == '1' ) {
      $sources[] = array(
        'name' => 'Twitter',
        'pattern' => array(
          'type'  => 'getQuery',
          'key'   => 'utm_source',
          'value' => 'twitter'
        )
      );
    }

    if ( isset( $options['instagram'] ) && $options['instagram'] == '1' ) {
      $sources[] = array(
        'name' => 'Instagram',
        'pattern' => array(
          'type'  => 'getQuery',
          'key'   => 'utm_source',
          'value' => 'instagram'
        )
      );
    }

    return $sources;
  }
}
