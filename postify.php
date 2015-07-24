<?php

/*
  Plugin Name: Postify
  Plugin URI: https://github.com/bappi-d-great/postify
  Description: Postify is post sharing plugin across your website - Related Posts, Popular Posts, Recent Posts, Featured Posts
  Author: bappi-d-great
  Author URI: http://www.bappi-d-great.com
  Developers: Ashok (Bappi D Great), WPMU DEV, Incsub
  Version: 1.0.0
  TextDomain: postify
  Domain Path: /lang/
  License: GNU General Public License ( Version 2 - GPLv2 )

  Copyright 2015 Incsub ( http://incsub.com )

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License ( Version 2 - GPLv2 ) as published by
  the Free Software Foundation.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */

if( ! defined( 'PF_DOMAIN' ) ) define( 'PF_DOMAIN', 'postify' );
if( ! defined( 'PF_HACK_MSG' ) ) define( 'PF_HACK_MSG', __( 'Sorry Hackers! This is not your place!', PF_DOMAIN ) );

/**
 * Protect direct access
 */
if ( ! defined( 'ABSPATH' ) ) wp_die( PF_HACK_MSG );

/**
 * Defining constants
 */
if( ! defined( 'PF_VERSION' ) ) define( 'PF_VERSION', '1.0.0' );
if( ! defined( 'PF_MENU_POSITION' ) ) define( 'PF_MENU_POSITION', '50' );
if( ! defined( 'PF_PLUGIN_DIR' ) ) define( 'PF_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
if( ! defined( 'PF_FILES_DIR' ) ) define( 'PF_FILES_DIR', PF_PLUGIN_DIR . 'postify-files' );
if( ! defined( 'PF_PLUGIN_URI' ) ) define( 'PF_PLUGIN_URI', plugins_url( '', __FILE__ ) );
if( ! defined( 'PF_FILES_URI' ) ) define( 'PF_FILES_URI', PF_PLUGIN_URI . '/postify-files' );

if( ! defined( 'ALLOW_PF_IN_SUBSITE' ) ) define( 'ALLOW_PF_IN_SUBSITE', FALSE );


if( ! class_exists( 'Postify' ) ){
	/**
	 * Class Postify
	 */

	class Postify{


		/**
		 * Singleton Instance of this class
		 *
		 * @since 1.0
		 * @access private
		 * @var OBJECT of WPFAQS class
		 */
		private static $_instance;


		/**
		 * Is multisite?
		 *
		 * @since 1.0
		 * @access public
		 * @var BOOL	true if it is a multisite, otherwise false
		 */
		public $ms;


		/**
		 * Is Post Indexer Enabled?
		 *
		 * @since 1.0
		 * @access public
		 * @var BOOL	true if PI is enabled, otherwise false
		 */
		public $pi_enabled;


		/**
		 * Is Post Indexer Enabled?
		 *
		 * @since 1.0
		 * @access public
		 * @var BOOL	true if PI is enabled, otherwise false
		 */
		public $allow_subsite;


		/**
		 * $wpdb variable
		 *
		 * @since 1.0
		 * @access protected
		 * @var OBJECT	$wpdb variable
		 */
		protected $db;
		
		
		/**
		 * Current post
		 *
		 * @since 1.0
		 * @access protected
		 * @var OBJECT	curren post
		 */
		protected $current_post;


		/**
		 * Defining class constructor
		 */
		public function __construct() {
                        
                        $this->init();
			add_action( 'init', array( &$this, 'postify_activation' ) );
                        add_action( 'wp_enqueue_scripts', array( &$this, 'postify_scripts' ) );
                        add_action( 'admin_enqueue_scripts', array( $this, 'postify_admin_scripts' ) );
                        add_action( 'admin_menu', array( &$this, 'set_postify_menu' ) );
                        add_action( 'admin_action_postify_settings_save', array( &$this, 'admin_action_postify_settings_save_cb' ) );

		}


		/**
		 * Initializes the Postify class
		 *
		 * Checks for an existing Postify() instance
		 * and if there is none, creates an instance.
		 *
		 * @since 1.0
		 * @access public
		 */
		public static function get_instance() {

			if ( ! self::$_instance instanceof Postify ) {
				self::$_instance = new Postify();
			}

			return self::$_instance;

		}
                
                
                public function init() {
                    global $wpdb, $post;
                    $this->db = $wpdb;
                    if( $post ) $this->current_post = $post;

                    if( is_multisite() ) {
                            $this->ms = true;
                            if( ALLOW_PF_IN_SUBSITE ){
                                    $this->allow_subsite = true;
                            }else{
                                    $this->allow_subsite = false;
                            }
                    }
                    else $this->ms = false;

                    if( class_exists( 'POST_INDEXER' ) ) $this->pi_enabled = true;
                    else $this->pi_enabled = false;
                }
		
		
		public function postify_activation() {
			add_image_size( 'postify-size', 250, 250, true );
		}
                
                
                public function postify_scripts() {
                    wp_enqueue_script( 'hoverIntent', PF_FILES_URI . '/assets/js/jquery.hoverIntent.minified.js', array( 'jquery' ), '1.0.0' );
                }
                
                public function postify_admin_scripts() {
                    wp_enqueue_media();
                    wp_enqueue_script( 'postify-admin', PF_FILES_URI . '/assets/js/postify-admin.js', array( 'jquery' ), '1.0.0' );
                }
                
                public function set_postify_menu() {
                    add_options_page( __( 'Postify', PF_DOMAIN ), __( 'Postify', PF_DOMAIN ), 'manage_options', 'postify_option_settings', array( $this, 'postify_option_settings' ) );
                }
                
                
                public function postify_option_settings() {
                    
                    $options = get_option( 'pf_settigns_options' );
                    
                    ?>
                    <div class="wrap">
                        <h2><?php _e( 'Postify Settings', PF_DOMAIN ) ?></h2>
                        <?php if( isset( $_REQUEST['msg'] ) && $_REQUEST['msg'] != '' ) { ?>
                        <div class="updated"><p><strong><?php echo $_REQUEST['msg'] ?></strong></p></div>
                        <?php } ?>
                        <div class="">
                            <div id="poststuff">
                                <div id="post-body" class="metabox-holder columns-2">
                                    <div id="post-body-content">
                                        <div class="postbox">
                                            <h3 class="hndle"><?php _e( 'General Settings', PF_DOMAIN ) ?></h3>
                                            <div class="inside">
                                                <div class="postify-content">
                                                    <form action="<?php echo admin_url( 'admin.php?action=postify_settings_save' ) ?>" method="post">
                                                        <?php wp_nonce_field( 'pf_featured_settings_meta_box_data', 'pf_featured_settings_box_nonce' ); ?>
                                                        <table width="100%" cellpadding="5" cellspacing="5">
                                                            <tr>
                                                                <td width='200' valign="top">
                                                                    <strong><?php _e( 'Upload default image' ) ?></strong>
                                                                </td>
                                                                <td>
                                                                    <button class="postify_upload"><?php _e( 'Upload Image', PF_DOMAIN ) ?></button><br><br>
                                                                    <input type="hidden" class="postify_upload_input" name="postify_upload_input" value="<?php echo isset( $options['postify_upload_input'] ) && $options['postify_upload_input'] != '' ? $options['postify_upload_input'] : '10' ?>">
                                                                    <?php if( isset( $options['postify_upload_input'] ) && $options['postify_upload_input'] != '' ) { ?>
                                                                    <div id="featured-footer-image-container">
                                                                        <?php $image = wp_get_attachment_image_src( $options['postify_upload_input'], 'large' ); ?>
                                                                        <img width="200" src="<?php echo $image[0] ?>" />
                                                                    </div>
                                                                    <?php }else{ ?>
                                                                    <div id="featured-footer-image-container" class="hidden">
                                                                        <img src="" width="200" />
                                                                    </div>
                                                                    <?php } ?>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                        <p>
                                                            <input type="submit" name="postify_save" value="<?php _e( 'Save Settings', PF_DOMAIN ) ?>" class="button button-primary">
                                                        </p>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                
                
                public function admin_action_postify_settings_save_cb() {
                    
                    if ( ! isset( $_POST['pf_featured_settings_box_nonce'] ) ) {
                        return;
                    }
                    
                    if ( ! wp_verify_nonce( $_POST['pf_featured_settings_box_nonce'], 'pf_featured_settings_meta_box_data' ) ) {
                        return;
                    }
                    
                    update_option( 'pf_settigns_options', $_POST );
                    
                    wp_redirect( admin_url( 'options-general.php?page=postify_option_settings&msg=' . urlencode( __( 'Settings saved.', PF_DOMAIN ) ) ) );
                    
                    
                }

	}
    
        function Postify_class_init() {

            return Postify::get_instance();
    
        }
        
	add_action( 'plugins_loaded', 'postify_init' );
	function postify_init() {

		$pf = Postify_class_init();

		require_once PF_FILES_DIR . '/classes/class.template.php';
		require_once PF_FILES_DIR . '/classes/class.featured-posts.php';
		require_once PF_FILES_DIR . '/classes/class.popular-posts.php';
		require_once PF_FILES_DIR . '/classes/class.recent-posts.php';
		require_once PF_FILES_DIR . '/classes/class.related-posts.php';
		require_once PF_FILES_DIR . '/classes/class.shortcodes.php';
                require_once PF_FILES_DIR . '/classes/class.widgets.php';

	}

}



















