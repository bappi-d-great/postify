<?php

/**
 * Protect direct access
 */
if ( ! defined( 'ABSPATH' ) ) wp_die( PF_HACK_MSG );

if( ! class_exists( 'PF_ShortCodes' ) ){


	/**
	 * Class PF_ShortCodes
	 */
	class PF_ShortCodes{


		/**
		 * Defining constants
		 */
		const RECENT_POSTS_SC = 'pf_recent_posts';
		const POPULAR_POSTS_SC = 'pf_popular_posts';
		const FEATURED_POSTS_SC = 'pf_featured_posts';
		const RELATED_POSTS_SC = 'pf_related_posts';


		/**
		 * Constructor
		 */
		public function __construct() {

			add_shortcode( self::RECENT_POSTS_SC, array( &$this, 'process_recent_posts_sc' ) );

		}


		/**
		 * Process recent posts shortcode
		 */
		public function process_recent_posts_sc( $args ) {
			
			$defaults = apply_filters(
				'pf_recent_posts_default_args',
				array(
					'numberposts' => 5,
				    'category' => 0,
				    'orderby' => 'post_date',
				    'order' => 'DESC',
				    'include' => '',
				    'exclude' => '',
				    'post_type' => 'post',
				    'post_status' => 'publish',
				    'thumb' => false,
				    'author' => false,
				    'posted' => false,
				    'template' => 'template-1',
				    'network' => false
				)
			);

			$args = wp_parse_args( $args, $defaults );
			
			if( isset( $args['network'] ) && $args['network'] ) {
				if( ! is_main_site() ) {
					if( ! defined( 'ALLOW_PF_IN_SUBSITE' ) || ! ALLOW_PF_IN_SUBSITE ){
						return __( 'Sorry, you don\'t have permission to use this shortcode in network mode', PF_DOMAIN );
					}
				}
			}

			$posts_obj = new PF_Recent_Posts();
			$posts = $posts_obj->get_recent_posts( $args );

			return PF_TEMPLATE::use_template( $posts, $args['template'], 'recent_posts', $args );

		}

	}

	new PF_ShortCodes();

}