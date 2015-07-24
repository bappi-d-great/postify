<?php

/**
 * Protect direct access
 */
if ( ! defined( 'ABSPATH' ) ) wp_die( PF_HACK_MSG );

/**
 * Featured Posts Widget
 */
if( ! class_exists( 'Postify_Featured_Posts_Widgets' ) ) {
    
    /**
     * Class Postify_Widgets
     */
    class Postify_Featured_Posts_Widgets extends WP_Widget{
        
        private $templates;
        
        /**
	 * Register widget with WordPress.
	 */
	function __construct() {
            parent::__construct(
                'pf_featured_post', // Base ID
                __( 'Featured Posrts', PF_DOMAIN ), // Name
                array( 'description' => __( 'Postify Featured Posts Widget', PF_DOMAIN ), ) // Args
            );
            $this->templates = array(
                                    'template-widget' => __( 'Template 1', PF_DOMAIN ),
                                    'template-2' => __( 'Template 2', PF_DOMAIN ),
                                    'template-3' => __( 'Template 3', PF_DOMAIN ),
                                    'template-4' => __( 'Template 4', PF_DOMAIN ),
                                    'template-5' => __( 'Template 5', PF_DOMAIN ),
                                    'template-6' => __( 'Template 6', PF_DOMAIN ),
                                    'template-7' => __( 'Template 7', PF_DOMAIN )
                                    );
	}
        
        
        /**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
            $title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Featured Posts', PF_DOMAIN );
            $posts_per_page = ! empty( $instance['posts_per_page'] ) ? $instance['posts_per_page'] : 5;
            $show_thumb = isset( $instance['show_thumb'] ) ? $instance['show_thumb'] : 1;
            $show_author = isset( $instance['show_author'] ) ? $instance['show_author'] : 1;
            $show_posted = isset( $instance['show_posted'] ) ? $instance['show_posted'] : 1;
            $template = isset( $instance['template'] ) ? $instance['template'] : 'template-1';
            ?>
            <p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
	    </p>
            
            <p>
                <label for="<?php echo $this->get_field_id( 'posts_per_page' ); ?>"><?php _e( 'Number of Posts:', PF_DOMAIN ); ?></label> 
                <input class="widefat" id="<?php echo $this->get_field_id( 'posts_per_page' ); ?>" name="<?php echo $this->get_field_name( 'posts_per_page' ); ?>" type="text" value="<?php echo esc_attr( $posts_per_page ); ?>">
            </p>
                
            <p>
                <label for="<?php echo $this->get_field_id( 'show_thumb' ); ?>"><?php _e( 'Show Thumb:', PF_DOMAIN ); ?></label>
                <input <?php echo $show_thumb == 1 ? 'checked="checked"' : '' ?> type="radio" name="<?php echo $this->get_field_name( 'show_thumb' ); ?>" value="1"> <?php _e( 'Yes', PF_DOMAIN ) ?>
                <input <?php echo $show_thumb == 0 ? 'checked="checked"' : '' ?> type="radio" name="<?php echo $this->get_field_name( 'show_thumb' ); ?>" value="0"> <?php _e( 'NO', PF_DOMAIN ) ?>
            </p>
            
            <p>
                <label for="<?php echo $this->get_field_id( 'show_author' ); ?>"><?php _e( 'Show Author:', PF_DOMAIN ); ?></label>
                <input <?php echo $show_author == 1 ? 'checked="checked"' : '' ?> type="radio" name="<?php echo $this->get_field_name( 'show_author' ); ?>" value="1"> <?php _e( 'Yes', PF_DOMAIN ) ?>
                <input <?php echo $show_author == 0 ? 'checked="checked"' : '' ?> type="radio" name="<?php echo $this->get_field_name( 'show_author' ); ?>" value="0"> <?php _e( 'NO', PF_DOMAIN ) ?>
            </p>
            
            <p>
                <label for="<?php echo $this->get_field_id( 'show_posted' ); ?>"><?php _e( 'Show Publish Date:', PF_DOMAIN ); ?></label>
                <input <?php echo $show_posted == 1 ? 'checked="checked"' : '' ?> type="radio" name="<?php echo $this->get_field_name( 'show_posted' ); ?>" value="1"> <?php _e( 'Yes', PF_DOMAIN ) ?>
                <input <?php echo $show_posted == 0 ? 'checked="checked"' : '' ?> type="radio" name="<?php echo $this->get_field_name( 'show_posted' ); ?>" value="0"> <?php _e( 'NO', PF_DOMAIN ) ?>
            </p>
            
            <p>
                <label for="<?php echo $this->get_field_id( 'template' ); ?>"><?php _e( 'Select a template:', PF_DOMAIN ); ?></label>
                <select name="<?php echo $this->get_field_name( 'template' ); ?>">
                    <option value=""><?php _e( 'Select a template', PF_DOMAIN ) ?></option>
                    <?php foreach( $this->templates as $key => $val ) { ?>
                    <option <?php echo $template == $key ? 'selected="selected"' : '' ?> value="<?php echo $key ?>"><?php echo $val; ?></option>
                    <?php } ?>
                </select>
            </p>
            <?php 
	}
        
        
        /**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
            $instance = array();
            $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
            $instance['posts_per_page'] = ( ! empty( $new_instance['posts_per_page'] ) ) ? strip_tags( $new_instance['posts_per_page'] ) : '';
            $instance['show_thumb'] = ( ! empty( $new_instance['show_thumb'] ) ) ? strip_tags( $new_instance['show_thumb'] ) : '';
            $instance['show_author'] = ( ! empty( $new_instance['show_author'] ) ) ? strip_tags( $new_instance['show_author'] ) : '';
            $instance['show_posted'] = ( ! empty( $new_instance['show_posted'] ) ) ? strip_tags( $new_instance['show_posted'] ) : '';
            $instance['template'] = ( ! empty( $new_instance['template'] ) ) ? strip_tags( $new_instance['template'] ) : '';

            return $instance;
	}
        
        
        /**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
            echo $args['before_widget'];
            echo do_shortcode( '[pf_featured_posts
                                    posts_per_page="'.$instance['posts_per_page'].'"
                                    thumb="'.$instance['show_thumb'].'"
                                    show_author="'.$instance['show_author'].'"
                                    posted="'.$instance['show_posted'].'"
                                    template="'.$instance['template'].'"
                                    title="'.$instance['title'].'"
                                    widget="1"
                                ]' );
            echo $args['after_widget'];
	}
        
    }
    
    function register_Postify_Featured_Posts_Widgets() {
        register_widget( 'Postify_Featured_Posts_Widgets' );
    }
    add_action( 'widgets_init', 'register_Postify_Featured_Posts_Widgets' );
    
}


/**
 * Popular Posts Widget
 */
if( ! class_exists( 'Postify_Popular_Posts_Widgets' ) ) {
    
    /**
     * Class Postify_Widgets
     */
    class Postify_Popular_Posts_Widgets extends WP_Widget{
        
        private $templates;
        
        /**
	 * Register widget with WordPress.
	 */
	function __construct() {
            parent::__construct(
                'pf_popular_post', // Base ID
                __( 'Popular Posrts', PF_DOMAIN ), // Name
                array( 'description' => __( 'Postify Popular Posts Widget', PF_DOMAIN ), ) // Args
            );
            $this->templates = array(
                                    'template-widget' => __( 'Template 1', PF_DOMAIN ),
                                    'template-2' => __( 'Template 2', PF_DOMAIN ),
                                    'template-3' => __( 'Template 3', PF_DOMAIN ),
                                    'template-4' => __( 'Template 4', PF_DOMAIN ),
                                    'template-5' => __( 'Template 5', PF_DOMAIN ),
                                    'template-6' => __( 'Template 6', PF_DOMAIN ),
                                    'template-7' => __( 'Template 7', PF_DOMAIN )
                                    );
	}
        
        
        /**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
            $title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Popular Posts', PF_DOMAIN );
            $posts_per_page = ! empty( $instance['posts_per_page'] ) ? $instance['posts_per_page'] : 5;
            $method = isset( $instance['method'] ) ? $instance['method'] : 1;
            $show_thumb = isset( $instance['show_thumb'] ) ? $instance['show_thumb'] : 1;
            $show_author = isset( $instance['show_author'] ) ? $instance['show_author'] : 1;
            $show_posted = isset( $instance['show_posted'] ) ? $instance['show_posted'] : 1;
            $template = isset( $instance['template'] ) ? $instance['template'] : 'template-1';
            ?>
            <p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
	    </p>
            
            <p>
                <label for="<?php echo $this->get_field_id( 'posts_per_page' ); ?>"><?php _e( 'Number of Posts:', PF_DOMAIN ); ?></label> 
                <input class="widefat" id="<?php echo $this->get_field_id( 'posts_per_page' ); ?>" name="<?php echo $this->get_field_name( 'posts_per_page' ); ?>" type="text" value="<?php echo esc_attr( $posts_per_page ); ?>">
            </p>
                
            <p>
                <label for="<?php echo $this->get_field_id( 'method' ); ?>"><?php _e( 'Method:', PF_DOMAIN ); ?></label>
                <input <?php echo $method == 1 ? 'checked="checked"' : '' ?> type="radio" name="<?php echo $this->get_field_name( 'method' ); ?>" value="1"> <?php _e( 'Comment Count', PF_DOMAIN ) ?>
                <input <?php echo $method == 2 ? 'checked="checked"' : '' ?> type="radio" name="<?php echo $this->get_field_name( 'method' ); ?>" value="2"> <?php _e( 'View Count', PF_DOMAIN ) ?>
            </p>
            
            <p>
                <label for="<?php echo $this->get_field_id( 'show_thumb' ); ?>"><?php _e( 'Show Thumb:', PF_DOMAIN ); ?></label>
                <input <?php echo $show_thumb == 1 ? 'checked="checked"' : '' ?> type="radio" name="<?php echo $this->get_field_name( 'show_thumb' ); ?>" value="1"> <?php _e( 'Yes', PF_DOMAIN ) ?>
                <input <?php echo $show_thumb == 0 ? 'checked="checked"' : '' ?> type="radio" name="<?php echo $this->get_field_name( 'show_thumb' ); ?>" value="0"> <?php _e( 'NO', PF_DOMAIN ) ?>
            </p>
            
            <p>
                <label for="<?php echo $this->get_field_id( 'show_author' ); ?>"><?php _e( 'Show Author:', PF_DOMAIN ); ?></label>
                <input <?php echo $show_author == 1 ? 'checked="checked"' : '' ?> type="radio" name="<?php echo $this->get_field_name( 'show_author' ); ?>" value="1"> <?php _e( 'Yes', PF_DOMAIN ) ?>
                <input <?php echo $show_author == 0 ? 'checked="checked"' : '' ?> type="radio" name="<?php echo $this->get_field_name( 'show_author' ); ?>" value="0"> <?php _e( 'NO', PF_DOMAIN ) ?>
            </p>
            
            <p>
                <label for="<?php echo $this->get_field_id( 'show_posted' ); ?>"><?php _e( 'Show Publish Date:', PF_DOMAIN ); ?></label>
                <input <?php echo $show_posted == 1 ? 'checked="checked"' : '' ?> type="radio" name="<?php echo $this->get_field_name( 'show_posted' ); ?>" value="1"> <?php _e( 'Yes', PF_DOMAIN ) ?>
                <input <?php echo $show_posted == 0 ? 'checked="checked"' : '' ?> type="radio" name="<?php echo $this->get_field_name( 'show_posted' ); ?>" value="0"> <?php _e( 'NO', PF_DOMAIN ) ?>
            </p>
            
            <p>
                <label for="<?php echo $this->get_field_id( 'template' ); ?>"><?php _e( 'Select a template:', PF_DOMAIN ); ?></label>
                <select name="<?php echo $this->get_field_name( 'template' ); ?>">
                    <option value=""><?php _e( 'Select a template', PF_DOMAIN ) ?></option>
                    <?php foreach( $this->templates as $key => $val ) { ?>
                    <option <?php echo $template == $key ? 'selected="selected"' : '' ?> value="<?php echo $key ?>"><?php echo $val; ?></option>
                    <?php } ?>
                </select>
            </p>
            <?php 
	}
        
        
        /**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
            $instance = array();
            $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
            $instance['posts_per_page'] = ( ! empty( $new_instance['posts_per_page'] ) ) ? strip_tags( $new_instance['posts_per_page'] ) : '';
            $instance['show_thumb'] = ( ! empty( $new_instance['show_thumb'] ) ) ? strip_tags( $new_instance['show_thumb'] ) : '';
            $instance['show_author'] = ( ! empty( $new_instance['show_author'] ) ) ? strip_tags( $new_instance['show_author'] ) : '';
            $instance['show_posted'] = ( ! empty( $new_instance['show_posted'] ) ) ? strip_tags( $new_instance['show_posted'] ) : '';
            $instance['template'] = ( ! empty( $new_instance['template'] ) ) ? strip_tags( $new_instance['template'] ) : '';
            $instance['method'] = ( ! empty( $new_instance['method'] ) ) ? strip_tags( $new_instance['method'] ) : '';

            return $instance;
	}
        
        
        /**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
            echo $args['before_widget'];
            echo do_shortcode( '[pf_popular_posts
                                    posts_per_page="'.$instance['posts_per_page'].'"
                                    thumb="'.$instance['show_thumb'].'"
                                    show_author="'.$instance['show_author'].'"
                                    posted="'.$instance['show_posted'].'"
                                    template="'.$instance['template'].'"
                                    title="'.$instance['title'].'"
                                    method="'.$instance['method'].'"
                                    widget="1"
                                ]' );
            echo $args['after_widget'];
	}
        
    }
    
    function register_Postify_Popular_Posts_Widgets() {
        register_widget( 'Postify_Popular_Posts_Widgets' );
    }
    add_action( 'widgets_init', 'register_Postify_Popular_Posts_Widgets' );
    
}


/**
 * Recent Posts Widget
 */
if( ! class_exists( 'Postify_Recent_Posts_Widgets' ) ) {
    
    /**
     * Class Postify_Widgets
     */
    class Postify_Recent_Posts_Widgets extends WP_Widget{
        
        private $templates;
        
        /**
	 * Register widget with WordPress.
	 */
	function __construct() {
            parent::__construct(
                'pf_recent_post', // Base ID
                __( 'Recent Posts', PF_DOMAIN ), // Name
                array( 'description' => __( 'Postify Recent Posts Widget', PF_DOMAIN ), ) // Args
            );
            $this->templates = array(
                                    'template-widget' => __( 'Template 1', PF_DOMAIN ),
                                    'template-2' => __( 'Template 2', PF_DOMAIN ),
                                    'template-3' => __( 'Template 3', PF_DOMAIN ),
                                    'template-4' => __( 'Template 4', PF_DOMAIN ),
                                    'template-5' => __( 'Template 5', PF_DOMAIN ),
                                    'template-6' => __( 'Template 6', PF_DOMAIN ),
                                    'template-7' => __( 'Template 7', PF_DOMAIN )
                                    );
	}
        
        
        /**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
            $title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Recent Posts', PF_DOMAIN );
            $posts_per_page = ! empty( $instance['posts_per_page'] ) ? $instance['posts_per_page'] : 5;
            $network = isset( $instance['network'] ) ? $instance['network'] : 0;
            $show_thumb = isset( $instance['show_thumb'] ) ? $instance['show_thumb'] : 1;
            $show_author = isset( $instance['show_author'] ) ? $instance['show_author'] : 1;
            $show_posted = isset( $instance['show_posted'] ) ? $instance['show_posted'] : 1;
            $template = isset( $instance['template'] ) ? $instance['template'] : 'template-1';
            ?>
            <p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
	    </p>
            
            <p>
                <label for="<?php echo $this->get_field_id( 'posts_per_page' ); ?>"><?php _e( 'Number of Posts:', PF_DOMAIN ); ?></label> 
                <input class="widefat" id="<?php echo $this->get_field_id( 'posts_per_page' ); ?>" name="<?php echo $this->get_field_name( 'posts_per_page' ); ?>" type="text" value="<?php echo esc_attr( $posts_per_page ); ?>">
            </p>
            
            <?php if( is_multisite() ) { ?>
            <p>
                <label for="<?php echo $this->get_field_id( 'network' ); ?>"><?php _e( 'From Network:', PF_DOMAIN ); ?></label>
                <input <?php echo $network == 1 ? 'checked="checked"' : '' ?> type="radio" name="<?php echo $this->get_field_name( 'network' ); ?>" value="1"> <?php _e( 'Yes', PF_DOMAIN ) ?>
                <input <?php echo $network == 0 ? 'checked="checked"' : '' ?> type="radio" name="<?php echo $this->get_field_name( 'network' ); ?>" value="0"> <?php _e( 'No', PF_DOMAIN ) ?>
            </p>
            <?php } ?>
            
            <p>
                <label for="<?php echo $this->get_field_id( 'show_thumb' ); ?>"><?php _e( 'Show Thumb:', PF_DOMAIN ); ?></label>
                <input <?php echo $show_thumb == 1 ? 'checked="checked"' : '' ?> type="radio" name="<?php echo $this->get_field_name( 'show_thumb' ); ?>" value="1"> <?php _e( 'Yes', PF_DOMAIN ) ?>
                <input <?php echo $show_thumb == 0 ? 'checked="checked"' : '' ?> type="radio" name="<?php echo $this->get_field_name( 'show_thumb' ); ?>" value="0"> <?php _e( 'NO', PF_DOMAIN ) ?>
            </p>
            
            <p>
                <label for="<?php echo $this->get_field_id( 'show_author' ); ?>"><?php _e( 'Show Author:', PF_DOMAIN ); ?></label>
                <input <?php echo $show_author == 1 ? 'checked="checked"' : '' ?> type="radio" name="<?php echo $this->get_field_name( 'show_author' ); ?>" value="1"> <?php _e( 'Yes', PF_DOMAIN ) ?>
                <input <?php echo $show_author == 0 ? 'checked="checked"' : '' ?> type="radio" name="<?php echo $this->get_field_name( 'show_author' ); ?>" value="0"> <?php _e( 'NO', PF_DOMAIN ) ?>
            </p>
            
            <p>
                <label for="<?php echo $this->get_field_id( 'show_posted' ); ?>"><?php _e( 'Show Publish Date:', PF_DOMAIN ); ?></label>
                <input <?php echo $show_posted == 1 ? 'checked="checked"' : '' ?> type="radio" name="<?php echo $this->get_field_name( 'show_posted' ); ?>" value="1"> <?php _e( 'Yes', PF_DOMAIN ) ?>
                <input <?php echo $show_posted == 0 ? 'checked="checked"' : '' ?> type="radio" name="<?php echo $this->get_field_name( 'show_posted' ); ?>" value="0"> <?php _e( 'NO', PF_DOMAIN ) ?>
            </p>
            
            <p>
                <label for="<?php echo $this->get_field_id( 'template' ); ?>"><?php _e( 'Select a template:', PF_DOMAIN ); ?></label>
                <select name="<?php echo $this->get_field_name( 'template' ); ?>">
                    <option value=""><?php _e( 'Select a template', PF_DOMAIN ) ?></option>
                    <?php foreach( $this->templates as $key => $val ) { ?>
                    <option <?php echo $template == $key ? 'selected="selected"' : '' ?> value="<?php echo $key ?>"><?php echo $val; ?></option>
                    <?php } ?>
                </select>
            </p>
            <?php 
	}
        
        
        /**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
            $instance = array();
            $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
            $instance['posts_per_page'] = ( ! empty( $new_instance['posts_per_page'] ) ) ? strip_tags( $new_instance['posts_per_page'] ) : '';
            $instance['show_thumb'] = ( ! empty( $new_instance['show_thumb'] ) ) ? strip_tags( $new_instance['show_thumb'] ) : '';
            $instance['show_author'] = ( ! empty( $new_instance['show_author'] ) ) ? strip_tags( $new_instance['show_author'] ) : '';
            $instance['show_posted'] = ( ! empty( $new_instance['show_posted'] ) ) ? strip_tags( $new_instance['show_posted'] ) : '';
            $instance['template'] = ( ! empty( $new_instance['template'] ) ) ? strip_tags( $new_instance['template'] ) : '';
            $instance['network'] = ( ! empty( $new_instance['network'] ) ) ? strip_tags( $new_instance['network'] ) : '';

            return $instance;
	}
        
        
        /**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
            echo $args['before_widget'];
            echo do_shortcode( '[pf_recent_posts
                                    numberposts="'.$instance['posts_per_page'].'"
                                    thumb="'.$instance['show_thumb'].'"
                                    show_author="'.$instance['show_author'].'"
                                    posted="'.$instance['show_posted'].'"
                                    template="'.$instance['template'].'"
                                    title="'.$instance['title'].'"
                                    network="'.$instance['network'].'"
                                    widget="1"
                                ]' );
            echo $args['after_widget'];
	}
        
    }
    
    function register_Postify_Recent_Posts_Widgets() {
        register_widget( 'Postify_Recent_Posts_Widgets' );
    }
    add_action( 'widgets_init', 'register_Postify_Recent_Posts_Widgets' );
    
}


/**
 * Related Posts Widget
 */
if( ! class_exists( 'Postify_Related_Posts_Widgets' ) ) {
    
    /**
     * Class Postify_Widgets
     */
    class Postify_Related_Posts_Widgets extends WP_Widget{
        
        private $templates;
        
        /**
	 * Register widget with WordPress.
	 */
	function __construct() {
            parent::__construct(
                'pf_related_post', // Base ID
                __( 'Related Posts', PF_DOMAIN ), // Name
                array( 'description' => __( 'Postify Related Posts Widget (Related posts widget will work only single page)', PF_DOMAIN ), ) // Args
            );
            $this->templates = array(
                                    'template-widget' => __( 'Template 1', PF_DOMAIN ),
                                    'template-2' => __( 'Template 2', PF_DOMAIN ),
                                    'template-3' => __( 'Template 3', PF_DOMAIN ),
                                    'template-4' => __( 'Template 4', PF_DOMAIN ),
                                    'template-5' => __( 'Template 5', PF_DOMAIN ),
                                    'template-6' => __( 'Template 6', PF_DOMAIN ),
                                    'template-7' => __( 'Template 7', PF_DOMAIN )
                                    );
	}
        
        
        /**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
            $title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Related Posts', PF_DOMAIN );
            $posts_per_page = ! empty( $instance['posts_per_page'] ) ? $instance['posts_per_page'] : 5;
            $method = isset( $instance['method'] ) ? $instance['method'] : 'tag';
            $show_thumb = isset( $instance['show_thumb'] ) ? $instance['show_thumb'] : 1;
            $show_author = isset( $instance['show_author'] ) ? $instance['show_author'] : 1;
            $show_posted = isset( $instance['show_posted'] ) ? $instance['show_posted'] : 1;
            $template = isset( $instance['template'] ) ? $instance['template'] : 'template-1';
            ?>
            <p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
	    </p>
            
            <p>
                <label for="<?php echo $this->get_field_id( 'posts_per_page' ); ?>"><?php _e( 'Number of Posts:', PF_DOMAIN ); ?></label> 
                <input class="widefat" id="<?php echo $this->get_field_id( 'posts_per_page' ); ?>" name="<?php echo $this->get_field_name( 'posts_per_page' ); ?>" type="text" value="<?php echo esc_attr( $posts_per_page ); ?>">
            </p>
            
            <p>
                <label for="<?php echo $this->get_field_id( 'method' ); ?>"><?php _e( 'Method:', PF_DOMAIN ); ?></label>
                <select name="<?php echo $this->get_field_name( 'method' ); ?>">
                    <option value=""><?php _e( 'Select a Method', PF_DOMAIN ) ?></option>
                    <option <?php echo $method == 'tag' ? 'selected="selected"' : '' ?> value="tag"><?php _e( 'Tag', PF_DOMAIN ) ?></option>
                    <option <?php echo $method == 'category' ? 'selected="selected"' : '' ?> value="category"><?php _e( 'Category', PF_DOMAIN ) ?></option>
                    <option <?php echo $method == 'content' ? 'selected="selected"' : '' ?> value="content"><?php _e( 'Content', PF_DOMAIN ) ?></option>
                </select>
            </p>
            
            <p>
                <label for="<?php echo $this->get_field_id( 'show_thumb' ); ?>"><?php _e( 'Show Thumb:', PF_DOMAIN ); ?></label>
                <input <?php echo $show_thumb == 1 ? 'checked="checked"' : '' ?> type="radio" name="<?php echo $this->get_field_name( 'show_thumb' ); ?>" value="1"> <?php _e( 'Yes', PF_DOMAIN ) ?>
                <input <?php echo $show_thumb == 0 ? 'checked="checked"' : '' ?> type="radio" name="<?php echo $this->get_field_name( 'show_thumb' ); ?>" value="0"> <?php _e( 'NO', PF_DOMAIN ) ?>
            </p>
            
            <p>
                <label for="<?php echo $this->get_field_id( 'show_author' ); ?>"><?php _e( 'Show Author:', PF_DOMAIN ); ?></label>
                <input <?php echo $show_author == 1 ? 'checked="checked"' : '' ?> type="radio" name="<?php echo $this->get_field_name( 'show_author' ); ?>" value="1"> <?php _e( 'Yes', PF_DOMAIN ) ?>
                <input <?php echo $show_author == 0 ? 'checked="checked"' : '' ?> type="radio" name="<?php echo $this->get_field_name( 'show_author' ); ?>" value="0"> <?php _e( 'NO', PF_DOMAIN ) ?>
            </p>
            
            <p>
                <label for="<?php echo $this->get_field_id( 'show_posted' ); ?>"><?php _e( 'Show Publish Date:', PF_DOMAIN ); ?></label>
                <input <?php echo $show_posted == 1 ? 'checked="checked"' : '' ?> type="radio" name="<?php echo $this->get_field_name( 'show_posted' ); ?>" value="1"> <?php _e( 'Yes', PF_DOMAIN ) ?>
                <input <?php echo $show_posted == 0 ? 'checked="checked"' : '' ?> type="radio" name="<?php echo $this->get_field_name( 'show_posted' ); ?>" value="0"> <?php _e( 'NO', PF_DOMAIN ) ?>
            </p>
            
            <p>
                <label for="<?php echo $this->get_field_id( 'template' ); ?>"><?php _e( 'Select a template:', PF_DOMAIN ); ?></label>
                <select name="<?php echo $this->get_field_name( 'template' ); ?>">
                    <option value=""><?php _e( 'Select a template', PF_DOMAIN ) ?></option>
                    <?php foreach( $this->templates as $key => $val ) { ?>
                    <option <?php echo $template == $key ? 'selected="selected"' : '' ?> value="<?php echo $key ?>"><?php echo $val; ?></option>
                    <?php } ?>
                </select>
            </p>
            <?php 
	}
        
        
        /**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
            $instance = array();
            $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
            $instance['posts_per_page'] = ( ! empty( $new_instance['posts_per_page'] ) ) ? strip_tags( $new_instance['posts_per_page'] ) : '';
            $instance['show_thumb'] = ( ! empty( $new_instance['show_thumb'] ) ) ? strip_tags( $new_instance['show_thumb'] ) : '';
            $instance['show_author'] = ( ! empty( $new_instance['show_author'] ) ) ? strip_tags( $new_instance['show_author'] ) : '';
            $instance['show_posted'] = ( ! empty( $new_instance['show_posted'] ) ) ? strip_tags( $new_instance['show_posted'] ) : '';
            $instance['template'] = ( ! empty( $new_instance['template'] ) ) ? strip_tags( $new_instance['template'] ) : '';
            $instance['method'] = ( ! empty( $new_instance['method'] ) ) ? strip_tags( $new_instance['method'] ) : '';

            return $instance;
	}
        
        
        /**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
            echo $args['before_widget'];
            echo do_shortcode( '[pf_related_posts
                                    posts_per_page="'.$instance['posts_per_page'].'"
                                    thumb="'.$instance['show_thumb'].'"
                                    show_author="'.$instance['show_author'].'"
                                    posted="'.$instance['show_posted'].'"
                                    template="'.$instance['template'].'"
                                    title="'.$instance['title'].'"
                                    method="'.$instance['method'].'"
                                    widget="1"
                                ]' );
            echo $args['after_widget'];
	}
        
    }
    
    function register_Postify_Related_Posts_Widgets() {
        register_widget( 'Postify_Related_Posts_Widgets' );
    }
    add_action( 'widgets_init', 'register_Postify_Related_Posts_Widgets' );
    
}