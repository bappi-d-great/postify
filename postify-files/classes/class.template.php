<?php

/**
 * Protect direct access
 */
if ( ! defined( 'ABSPATH' ) ) wp_die( PF_HACK_MSG );

if( ! class_exists( 'PF_TEMPLATE' ) ) {
    
    /**
     * Class PF_TEMPLATE
     */
    class PF_TEMPLATE{
        
        /**
         * Singleton Instance of this class
         *
         * @since 1.0.0
         * @access private
         * @var OBJECT of PF_TEMPLATE class
         */
        private static $_instance;
        
        
        /**
         * Class Constructor
         */
        public function __construct() {
            
        }
        
        
        /**
         * Initializes the PF_TEMPLATE class
         *
         * Checks for an existing PF_TEMPLATE() instance
	 * and if there is none, creates an instance.
	 *
	 * @since 1.0.0
	 * @access public
	 */
        public static function get_instance() {
            
            if ( ! self::$_instance instanceof PF_TEMPLATE ) {
                self::$_instance = new PF_TEMPLATE();
            }
            
            return self::$_instance;
            
        }
        
        
        /**
         * Get fallback image
         *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return STRING featured image with image tag
	 */
        public static function get_fallback_image( $post, $type ){
            
            $featured_image = '';
	    $options = get_option( 'pf_settigns_options' );
	    $default_image = wp_get_attachment_image_src( $options['postify_upload_input'], 'postify-size' );
            
            if( has_post_thumbnail( $post->ID ) ){
                $featured_image = get_the_post_thumbnail( $post->ID, 'postify-size' );
            }else{
                $featured_image = '<img width="250" height="250" src="'.$default_image[0].'" class="attachment-thumbnail wp-post-image" alt="akismet">';
            }
            
            return apply_filters(
                                'pf_' . $type . '_thumb_image',
                                $featured_image,
                                $post,
                                $type
                                );
            
        }
        
        
        public static function use_template( $posts, $template, $type, $args ) {
            
            ob_start();
            
            include PF_FILES_DIR . '/inc/views/' . $template . '.php';
            
            $html = ob_get_contents();
            ob_end_clean();
            
            return apply_filters(
                                'pf_' . $type . '_output_html',
                                $html,
                                $posts,
                                $template,
                                $type,
                                $args
                                );
            
        }
        
        
    }
    
}