<?php

/**
 * Protect direct access
 */
if ( ! defined( 'ABSPATH' ) ) wp_die( PF_HACK_MSG );

if( ! class_exists( 'PF_Featured_Posts' ) ){
    
    /**
     * Class PF_Featured_Posts
     */
    class PF_Featured_Posts extends Postify{
        
        /**
         * Singleton Instance of this class
         *
         * @since 1.0.0
         * @access private
         * @var OBJECT of PF_Featured_Posts class
         */
        private static $_instance;
        
        
        /**
         * Class Constructor
         */
        public function __construct() {
            
            parent::init();
            
            add_action( 'add_meta_boxes', array( &$this, 'add_meta_box' ) );
            add_action( 'save_post', array( &$this, 'pf_featured_meta_cb_save' ) );
            
        }
        
        
        /**
         * Initializes the PF_Featured_Posts class
         *
         * Checks for an existing PF_Featured_Posts() instance
	 * and if there is none, creates an instance.
	 *
	 * @since 1.0.0
	 * @access public
	 */
        public static function get_instance() {
            
            if ( ! self::$_instance instanceof PF_Featured_Posts ) {
                self::$_instance = new PF_Featured_Posts();
            }
            
            return self::$_instance;
            
        }
        
        
        public function add_meta_box() {
            
            $post_types = array( 'post' );
            
            foreach ( $post_types as $post_type ) {

		add_meta_box(
                    'pf_featured_meta',
                    __( 'Featured Post', PF_DOMAIN ),
                    array( &$this, 'pf_featured_meta_cb' ),
                    $post_type,
                    'side',
                    'high'
		);
                
                
            }
            
        }
        
        
        public function pf_featured_meta_cb( $post ){
            
            wp_nonce_field( 'pf_featured_save_meta_box_data', 'pf_featured_meta_box_nonce' );
            
            $value = get_post_meta( $post->ID, 'pf_featured_meta', true );
            ?>
            <p>
                <label>
                    <input <?php echo isset( $value ) && $value == 1 ? 'checked="checked"' : '' ?> type="checkbox" name="pf_featured_meta" value="1">
                    <?php _e( 'Mark as Featured Post?', PF_DOMAIN ) ?>
                </label>
            </p>
            <?php
            
        }
        
        
        public function pf_featured_meta_cb_save( $post_id ) {
            
            if ( ! isset( $_POST['pf_featured_meta_box_nonce'] ) ) {
                    return;
            }
    
            // Verify that the nonce is valid.
            if ( ! wp_verify_nonce( $_POST['pf_featured_meta_box_nonce'], 'pf_featured_save_meta_box_data' ) ) {
                    return;
            }
    
            // If this is an autosave, our form has not been submitted, so we don't want to do anything.
            if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
                    return;
            }
    
            /* OK, it's safe for us to save the data now. */
    
            // Sanitize user input.
            $my_data = sanitize_text_field( isset( $_POST['pf_featured_meta'] ) ? $_POST['pf_featured_meta'] : 0 );
    
            // Update the meta field in the database.
            update_post_meta( $post_id, 'pf_featured_meta', $my_data );
            
        }
        
        
        public function get_featured_posts( $args ) {
            
            $args['meta_query'] = array(
                    array(
                    'key' => 'pf_featured_meta',
                    'value' => 1,
                    'compare' => '=',
                    )
            );
            $args['ignore_sticky_posts'] = 1;
            
        
            return apply_filters(
                            'pf_recent_posts_result',
                            new WP_Query( $args ),
                            $args
                            );
            
        }
        
    }
    
    function PF_Featured_Posts_init() {

	return PF_Featured_Posts::get_instance();

    }
    
    $pf_featured_posts = PF_Featured_Posts_init();
    
}