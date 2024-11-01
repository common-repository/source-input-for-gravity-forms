<?php
/**
 * @package Source Input for Gravity Forms
 */
/*
Plugin Name: Source Input for Gravity Forms
Description: Track conversion source
Version: 0.1.1
Author: Lifted Logic
Author URI: https://liftedlogic.com
License: GPLv2 or later
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

Copyright 2017 Lifted Logic
*/
if ( ! defined( 'ABSPATH' ) ) {
  die();
}

define( 'GFSI_VERSION', '0.1.0' );
define( 'GFSI__MINIMUM_WP_VERSION', '3.7' );
define( 'GFSI__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

class GFSI {

  protected static $_instance = null;

  public static function get_instance() {
    if ( self::$_instance == null ) {
      self::$_instance = new self();
    }

    return self::$_instance;
  }

  public function __construct() {
    spl_autoload_register( array( $this, 'autoloader' ) );

    add_action( 'gform_loaded', array( $this, 'gform_loaded' ) );
  }
  
    public static function activate() {
      if ( ! is_plugin_active( 'gravityforms/gravityforms.php' ) && current_user_can( 'activate_plugins' ) ) {
        
      }
    }
    
    public function gform_loaded() {
      if ( ! GFSI::check_php_version() ) return;

      GFAddOn::register( 'GFSI_AddOn' );
      GF_Fields::register(new GFSI_Source_Field);
    }
    
    public function check_php_version() {
      if (!version_compare('5.3', PHP_VERSION, '<=')) {
        return false;
      }
      return true;
    }

    public static function get_plugin_dir( $path = '' ) {
      $dir = rtrim( plugin_dir_path( __FILE__ ), '/' );

      if ( ! empty( $path ) && is_string( $path ) )
        $dir .= '/' . ltrim( $path, '/' );

      return $dir;
    }

    public function autoloader( $class ) {
      if ( class_exists( $class, false ) || strpos( $class, 'GFSI' ) === false )
        return;

      $file = GFSI::get_plugin_dir("lib/{$class}.php");

      if ( file_exists( $file ) ) {
        include_once( $file );
      }
    }
}

GFSI::get_instance();
