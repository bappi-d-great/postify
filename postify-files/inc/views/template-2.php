<div class="postify_posts template-2">
    <h3><?php echo $args['title'] ?></h3>
    <ul>
        <?php foreach( $posts as $post ) {  ?>
        <li>
            <div class="pf_items">
                <?php  if( $args['thumb'] ) {  ?>
                <div class="pf_items_thumb">
                     <?php echo self::get_fallback_image( $post, $type ); ?> 
                </div>
                <?php } ?>
                <div class="pf_items_title" style="<?php  if( $args['thumb'] ) {  ?>margin-left: 110px<?php } ?>">
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
            </div>
        </li>
        <?php } ?>
    </ul>
</div>
<style type="text/css">
    .template-2 .pf_items{overflow: hidden}
    .template-2 .pf_items_thumb{width: 100px; float: left}
    .template-2 .pf_items_thumb img{position: relative; top: 3px;}
    .postify_posts.template-2 ul{list-style-type: none; margin: 0 !important; padding: 0 !important}
    .postify_posts.template-2 ul li{margin: 0 !important; padding: 0 !important; width: 50%; padding-right: 15px !important; float: left; box-sizing: border-box;}
    .postify_posts.template-2 ul li a{text-decoration: none !important; font-weight: bold }
</style>