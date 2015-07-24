<div class="postify_posts template-4">
    <h3><?php echo $args['title'] ?></h3>
    <ul>
        <?php $i = 0; foreach( $posts as $post ) {  ?>
        <li>
            <div class="pf_items">
                <?php if( $i % 2 == 1 ) { ?>
                <div class="pf_items_title">
                    <a href="<?php echo get_permalink( $post->ID ) ?>"><?php echo $post->post_title ?></a><br>
                    <?php if( isset( $args['author'] ) && $args['author'] ) { ?>
                    <?php
                        printf(
                               __( 'By %s', PF_DOMAIN ),
                               get_the_author_meta( 'user_nicename' , $post->post_author )
                               );
                    ?>
                    <?php } ?>
                    <?php if( isset( $args['posted'] ) && $args['posted'] ) { ?>
                    <?php
                        printf(
                               __( 'Posted at %s', PF_DOMAIN ),
                               date_i18n( get_option( 'date_format' ), strtotime( $post->post_date ) )
                               );
                    ?>
                    <?php } ?>
                </div>
                <?php } ?>
                <?php  if( $args['thumb'] ) {  ?>
                <div class="pf_items_thumb">
                     <?php echo self::get_fallback_image( $post, $type ); ?> 
                </div>
                <?php } ?>
                <?php if( $i % 2 == 0 ) { ?>
                <div class="pf_items_title">
                    <a href="<?php echo get_permalink( $post->ID ) ?>"><?php echo $post->post_title ?></a><br>
                    <?php if( isset( $args['author'] ) && $args['author'] ) { ?>
                    <?php
                        printf(
                               __( 'By %s', PF_DOMAIN ),
                               get_the_author_meta( 'user_nicename' , $post->post_author )
                               );
                    ?>
                    <?php } ?>
                    <?php if( isset( $args['posted'] ) && $args['posted'] ) { ?>
                    <?php
                        printf(
                               __( 'Posted at %s', PF_DOMAIN ),
                               date_i18n( get_option( 'date_format' ), strtotime( $post->post_date ) )
                               );
                    ?>
                    <?php } ?>
                </div>
                <?php } ?>
            </div>
        </li>
        <?php $i++; } ?>
    </ul>
</div>
<style type="text/css">
    .template-4 .pf_items{overflow: hidden}
    .template-4 .pf_items_thumb, .template-3 .pf_items_thumb img{width: 100%;}
    .template-4 .pf_items_thumb img{position: relative; top: 3px;}
    .postify_posts.template-4 ul{list-style-type: none; margin: 0 !important; padding: 0 !important}
    .postify_posts.template-4 ul li{margin: 0 !important; padding: 0 !important; width: 33%; padding: 10px !important; float: left; box-sizing: border-box; height: 300px}
    .postify_posts.template-4 ul li a{text-decoration: none !important; font-weight: bold }
</style>