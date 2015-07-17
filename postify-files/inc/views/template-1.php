<div class="postify_posts" class="template-1">
    <h3>All Posts</h3>
    <ul>
        <?php foreach( $posts as $post ) {  ?>
        <li>
            <div class="pf_items">
                <?php if( isset( $args['thumb'] ) ) { ?>
                <div class="pf_items_thumb">
                     <?php echo self::get_fallback_image( $post, $type ); ?> 
                </div>
                <?php } ?>
                <div class="pf_items_title">
                    <a href="<?php echo get_permalink( $post->ID ) ?>"><?php echo $post->post_title ?></a><br>
                    <?php if( isset( $args['author'] ) ) { ?>
                    <?php
                        printf(
                               __( 'By %s', PF_DOMAIN ),
                               get_the_author_meta( 'user_nicename' , $post->post_author )
                               );
                    ?>
                    <?php } ?>
                    <?php if( isset( $args['posted'] ) ) { ?>
                    <?php
                        printf(
                               __( 'Posted at %s', PF_DOMAIN ),
                               date_i18n( get_option( 'date_format' ), strtotime( $post->post_date ) )
                               );
                    ?>
                    <?php } ?>
                </div>
            </div>
        </li>
        <?php } ?>
    </ul>
</div>
<style>
    .pf_items{overflow: hidden}
    .pf_items_thumb{width: 50px; float: left}
    .pf_items_thumb img{position: relative; top: 3px;}
    .pf_items_title{margin-left: 60px;}
    .pf_items ul{list-style-type: none}
</style>