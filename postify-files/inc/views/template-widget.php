<div class="postify_posts" class="template-1">
    <h3><?php echo $args['title'];  ?></h3>
    <ul>
        <?php foreach( $posts as $post ) {  ?>
        <li class="chevron">
            <div class="pf_items">
                <?php  if( $args['thumb'] ) {  ?>
                <div class="pf_items_thumb">
                     <?php echo self::get_fallback_image( $post, $type ); ?> 
                </div>
                <?php } ?>
                <?php
                    if( $args['widget'] == true || $args['widget'] != '' ){
                        $marginLeft = '60px';
                    }else{
                        $marginLeft = '170px';
                    }
                ?>
                <div class="pf_items_title" style="<?php if( $args['thumb'] ) {  ?>margin-left: <?php echo $marginLeft; ?><?php } ?>">
                    <a href="<?php echo get_permalink( $post->ID ) ?>"><?php echo $post->post_title ?></a><br>
                    <?php if( isset( $args['show_author'] ) && $args['show_author'] ) { ?>
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
    .pf_items{overflow: hidden}
    <?php if( ! $args['widget'] ) { ?>
    .pf_items_thumb{width: 160px; float: left}
    <?php }else{ ?>
    .pf_items_thumb{width: 50px; float: left}
    <?php } ?>
    .pf_items_thumb img{position: relative; top: 3px;}
    .postify_posts ul{list-style-type: none; margin: 0 !important; padding: 0 !important}
    .postify_posts ul li{margin: 0 !important; padding: 0 !important}
</style>