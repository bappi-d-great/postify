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

	}

	add_action( 'plugins_loaded', 'postify_init' );
	function postify_init() {

		$pf = new Postify();

		require_once PF_FILES_DIR . '/classes/class.template.php';
		require_once PF_FILES_DIR . '/classes/class.featured-posts.php';
		require_once PF_FILES_DIR . '/classes/class.popular-posts.php';
		require_once PF_FILES_DIR . '/classes/class.recent-posts.php';
		require_once PF_FILES_DIR . '/classes/class.related-posts.php';
		require_once PF_FILES_DIR . '/classes/class.shortcodes.php';

	}

}



















