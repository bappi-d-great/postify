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

		
		private $_recent_posts;
		private $_featured_posts;
		private $_popular_posts;
		private $_related_posts;
		
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
			
			$this->_recent_posts = PF_Recent_Posts_init();
			$this->_featured_posts = PF_Featured_Posts_init();
			$this->_popular_posts = PF_Popular_Posts_init();
			$this->_related_posts = PF_Related_Posts_init();

			add_shortcode( self::RECENT_POSTS_SC, array( &$this, 'process_recent_posts_sc' ) );
			add_shortcode( self::POPULAR_POSTS_SC, array( &$this, 'process_popular_posts_sc' ) );
			add_shortcode( self::FEATURED_POSTS_SC, array( &$this, 'process_featured_posts_sc' ) );
			add_shortcode( self::RELATED_POSTS_SC, array( &$this, 'process_related_posts_sc' ) );

		}


		/**
		 * Process recent posts shortcode
		 */
		public function process_recent_posts_sc( $args ) {
			
			$defaults = apply_filters(
				'pf_recent_posts_default_args',
				array(
				'numberposts' => 4,
				'category' => 0,
				'orderby' => 'post_date',
				'order' => 'DESC',
				'include' => '',
				'exclude' => '',
				'post_type' => 'post',
				'post_status' => 'publish',
				'thumb' => true,
				'show_author' => false,
				'posted' => false,
				'template' => 'template-1',
				'title' => __( 'Recent Posts', PF_DOMAIN ),
				'widget' => false,
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

			$posts = $this->_recent_posts->get_recent_posts( $args );

			return PF_TEMPLATE::use_template( $posts, $args['template'], 'recent_posts', $args );

		}
		
		
		/**
		 * Process Featured Posts shortcode
		 */
		public function process_featured_posts_sc( $args ){
			
			$defaults = apply_filters(
				'pf_featured_posts_default_args',
				array(
					'posts_per_page' => 4,
					'category' => 0,
					'orderby' => 'post_date',
					'order' => 'DESC',
					'include' => '',
					'exclude' => '',
					'post_type' => 'post',
					'post_status' => 'publish',
					'thumb' => true,
					'show_author' => false,
					'posted' => false,
					'template' => 'template-1',
					'title' => __( 'Featured Posts', PF_DOMAIN ),
					'widget' => false
				)
			);

			$args = wp_parse_args( $args, $defaults );
			
			$posts = $this->_featured_posts->get_featured_posts( $args );

			return PF_TEMPLATE::use_template( $posts->posts, $args['template'], 'recent_posts', $args );
			
		}
		
		
		/**
		 * Process popular posts shortcode
		 */
		public function process_popular_posts_sc( $args ) {
			
			$defaults = apply_filters(
				'pf_popular_posts_default_args',
				array(
					'posts_per_page' => 4,
					'category' => 0,
					'orderby' => 'post_date',
					'order' => 'DESC',
					'include' => '',
					'exclude' => '',
					'post_type' => 'post',
					'post_status' => 'publish',
					'thumb' => true,
					'show_author' => false,
					'posted' => false,
					'template' => 'template-1',
					'method' => 'comment_count',
					'title' => __( 'Popular Posts', PF_DOMAIN ),
					'widget' => false
				)
			);
			
			$args = wp_parse_args( $args, $defaults );
			
			$posts = $this->_popular_posts->get_popular_posts( $args );

			return PF_TEMPLATE::use_template( $posts->posts, $args['template'], 'recent_posts', $args );
			
		}
		
		
		/**
		 * Process related posts shortcode
		 */
		public function process_related_posts_sc( $args ) {
			
			$defaults = apply_filters(
				'pf_related_posts_default_args',
				array(
					'posts_per_page' => 4,
					'orderby' => 'post_date',
					'order' => 'DESC',
					'include' => '',
					'exclude' => '',
					'post_type' => array( 'post' ),
					'post_status' => 'publish',
					'thumb' => true,
					'show_author' => false,
					'posted' => false,
					'template' => 'template-1',
					'method' => 'tag', // tag | category | content
					'cat' => array(),
					'tag__not_in' => array(),
					'title' => __( 'Related Posts', PF_DOMAIN ),
					'widget' => false
				)
			);
			
			$args = wp_parse_args( $args, $defaults );
			
			$posts = $this->_related_posts->get_related_posts( $args );

			return PF_TEMPLATE::use_template( $posts->posts, $args['template'], 'recent_posts', $args );
			
		}

	}

	new PF_ShortCodes();

}