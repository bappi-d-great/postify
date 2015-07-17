<?php

/**
 * Protect direct access
 */
if ( ! defined( 'ABSPATH' ) ) wp_die( PF_HACK_MSG );

if( ! class_exists( 'PF_Recent_Posts' ) ){

	/**
	 * Class Recent_Posts
	 */
	class PF_Recent_Posts extends Postify {

		/**
		 * Singleton Instance of this class
		 *
		 * @since 1.0
		 * @access private
		 * @var OBJECT of PF_Recent_Posts class
		 */
		private static $_instance;


		/**
		 * Class constructor
		 */
		public function __construct(){

			parent::__construct();

		}


		/**
		 * Initializes the PF_Recent_Posts class
		 *
		 * Checks for an existing PF_Recent_Posts() instance
		 * and if there is none, creates an instance.
		 *
		 * @since 1.0
		 * @access public
		 */
		public static function get_instance() {

			if ( ! self::$_instance instanceof PF_Recent_Posts ) {
				self::$_instance = new PF_Recent_Posts();
			}

			return self::$_instance;

		}


		/**
		 * Get recent posts
		 *
		 * Find all recent posts
		 *
		 * @since 1.0
		 * @access public
		 *
		 * @return ARRAY Array of post objects
		 */
		public function get_recent_posts( $args = array() ){

			extract( $args );

			if( $network ){
				
				$sql = "SELECT * from " . $this->db->base_prefix . "network_posts where post_type = '". $post_type ."' ORDER BY post_date DESC LIMIT 0, " . $numberposts;

				return apply_filters(
					'pf_recent_network_posts_result',
					$this->db->get_results( $sql, OBJECT )
					);

			}

			return apply_filters(
					'pf_recent_posts_result',
					wp_get_recent_posts( $args, OBJECT )
					);


		}




	}

}