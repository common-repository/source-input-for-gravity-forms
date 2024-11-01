<?php

class GFSI_Source_Field extends \GF_Field {

  public $type = 'gfsi_source';

  private $addon = '';

  public function __construct( $data = array() ) {
    parent::__construct( $data );
    $this->addon = GFSI_AddOn::get_instance();
  }

  public function get_form_editor_button() {
    return array(
      'group' => 'advanced_fields',
      'text'  => __( 'Source', 'gravityforms' )
    );
  }

  public function get_form_editor_field_title() {
    return __( 'Source Field', 'gravityforms' );
  }

  public function get_form_editor_field_settings() {
    return array(
      'label_setting'
    );
  }

  public function get_source() {
    $enabled_sources = $this->addon->get_plugin_settings( 'sources' );
    $sources         = $this->addon->build_sources( $enabled_sources );
    $user_source     = '';

    foreach ( $sources as $source ) {
      if ($source['pattern']['type'] == 'getQuery' ) {
        if ( ! isset( $_GET[ $source['pattern']['key'] ] ) ) continue;

        if ( $_GET[ $source['pattern']['key'] ] == $source['pattern']['value'] || $source['pattern']['value'] === null )
          return $source['name'] . ': ' . $source['pattern']['key'] . '=' . $_GET[$source['pattern']['key']];
      }
    }

    return 'Organic';
  }

  public function get_field_input( $form, $value = '', $entry = null ) {
    $form_id = $form['id'];
    $id      = (int) $this->id;

    $input = sprintf('<input type="hidden" name="input_%1$s" class="%2$s gform_hidden" id="input_%1$s_%3$s" value="%4$s" />',
        $id,
        'gfsi_source',
        $form_id,
        $this->get_source()
    );

    return $input;
  }

  public function get_field_content( $value, $force_frontend_label, $form ) {
    $form_id       = $form['id'];
    $admin_buttons = $this->get_admin_buttons();
    $field_label   = $this->get_field_label( $force_frontend_label, $value );
    $field_id      = is_admin() || $form_id == 0 ? "input_{$this->id}" : "input_{$form_id}_{$this->id}";
    $field_content = !is_admin() ? '{FIELD}' : $field_content = sprintf("%s<label class='gfield_label' for='%s'>%s</label>{FIELD}", $admin_buttons, $field_id, esc_html($field_label));

    return $field_content;
  }

  public function get_value_entry_detail( $value, $currency = '', $use_text = false, $format = 'html', $media = 'screen' ) {
    return $value;
  }
}
