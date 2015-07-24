<?php

/**
 * Protect direct access
 */
if ( ! defined( 'ABSPATH' ) ) wp_die( PF_HACK_MSG );

if( ! class_exists( 'PF_Popular_Posts' ) ){
    
    /**
     * Class PF_Featured_Posts
     */
    class PF_Popular_Posts extends Postify{
        
        /**
         * Singleton Instance of this class
         *
         * @since 1.0.0
         * @access private
         * @var OBJECT of PF_Featured_Posts class
         */
        private static $_instance;
        
        private $_post;
        
        
        /**
         * Class Constructor
         */
        public function __construct() {
            
            parent::init();
            add_action( 'template_redirect', array( &$this, 'view_count_increment' ) );
            
        }
        
        
        /**
         * Initializes the PF_Popular_Posts class
         *
         * Checks for an existing PF_Popular_Posts() instance
	 * and if there is none, creates an instance.
	 *
	 * @since 1.0.0
	 * @access public
	 */
        public static function get_instance() {
            
            if ( ! self::$_instance instanceof PF_Popular_Posts ) {
                self::$_instance = new PF_Popular_Posts();
            }
            
            return self::$_instance;
            
        }
        
        
        public function view_count_increment() {
            
            global $post;
            $this->_post = $post;
            $post_types = array( 'post' );
            
            if( in_array( $this->_post->post_type, $post_types ) ) {
                $value = get_post_meta( $this->_post->ID, 'pf_view_count', true );
                if( ! $value ) $value = 0;
                $value++;
                update_post_meta( $this->_post->ID, 'pf_view_count', $value );
            }
            
        }
        
        
        public function get_popular_posts( $args ) {
            
            if( $args['method'] == 'comment_count' ){
                $args['orderby'] = 'comment_count';
            }else{
                $args['orderby'] = 'meta_value_num';
                $args['meta_key'] = 'pf_view_count';
            }
            
            $args['ignore_sticky_posts'] = 1;
            
        
            return apply_filters(
                            'pf_recent_posts_result',
                            new WP_Query( $args ),
                            $args
                            );
            
        }
        
    }
    
    function PF_Popular_Posts_init() {

	return PF_Popular_Posts::get_instance();

    }
    
    $pf_popular_posts = PF_Popular_Posts_init();
    
}