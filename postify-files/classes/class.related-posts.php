<?php

/**
 * Protect direct access
 */
if ( ! defined( 'ABSPATH' ) ) wp_die( PF_HACK_MSG );

if( ! class_exists( 'PF_Related_Posts' ) ){
    
    /**
     * Class PF_Featured_Posts
     */
    class PF_Related_Posts extends Postify{
        
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
            
        }
        
        
        /**
         * Initializes the PF_Related_Posts class
         *
         * Checks for an existing PF_Related_Posts() instance
	 * and if there is none, creates an instance.
	 *
	 * @since 1.0.0
	 * @access public
	 */
        public static function get_instance() {
            
            if ( ! self::$_instance instanceof PF_Related_Posts ) {
                self::$_instance = new PF_Related_Posts();
            }
            
            return self::$_instance;
            
        }
        
        
        public function get_related_posts( $args ) {
            
            global $post;
            $this->_post = $post;
            
            $args['ignore_sticky_posts'] = 1;
            $args['post__not_in'] = array( $this->_post->ID );
            
            if( $args['method'] == 'tag' ) {
                if( has_tag() ) {
                    return $this->search_by_tag( $args, $this->_post->ID );
                }
            }elseif( $args['method'] == 'category' ) {
                return $this->search_by_category( $args );
            }else{
                
                $search_term = get_the_title();
                $args['s'] = $search_term;
                $q = new WP_Query( $args );
                
                if( count( $q->posts ) < $args['posts_per_page'] ){
                    
                    $search_terms = explode( ' ', $search_term );
                    foreach( $search_terms as $search_term ){
                        $args['s'] = $search_term;
                        $r = new WP_Query( $args );
                        
                        if( count( $r->posts ) > 0 ){
                            $q->posts = array_merge( $q->posts, $r->posts );
                        }
                        
                        if( count( $q->posts ) > $args['posts_per_page'] ){
                            $c = count( $q->posts );
                            for( $i = $args['posts_per_page']; $i <= $c; $i++ ){
                                unset( $q->posts[$i] );
                            }
                            break;
                        }
                    }
                    
                }
                
                if( count( $q->posts ) < 1 ){
                    if( has_tag() ) {
                        return $this->search_by_tag( $args, $this->_post->ID );
                    }
                    else{
                        return $this->search_by_category( $args );
                    }
                }
                
                return apply_filters(
                            'pf_related_posts_result',
                            $q,
                            $args
                            );
                
            }
            
            
        }
        
        public function search_by_tag( $args, $post_id ) {
                
            $tags = wp_get_post_tags( $post_id );
            $tagIDs = array();
            if ( $tags ) {
                $tagcount = count( $tags );
                for ( $i = 0; $i < $tagcount; $i++ ) {
                    $tagIDs[$i] = $tags[$i]->term_id;
                }
                $args['tag__in'] = $tagIDs;
            }
            
            return apply_filters(
                    'pf_related_posts_result',
                    new WP_Query( $args ),
                    $args
                    );
            
        }
        
        
        public function search_by_category( $args ) {
            
            $cat = get_the_category();
            $category = $cat[0]->cat_ID;
            $args['cat'] = $category;
            
            return apply_filters(
                        'pf_related_posts_result',
                        new WP_Query( $args ),
                        $args
                        );
            
        }
        
    }
    
    function PF_Related_Posts_init() {

	return PF_Related_Posts::get_instance();

    }
    
    $pf_related_posts = PF_Related_Posts_init();
    
}