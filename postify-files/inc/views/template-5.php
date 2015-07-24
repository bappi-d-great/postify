<!-- Thumb is must, author won't work -->
<div class="postify_posts template-5">
    <h3><?php echo $args['title'] ?></h3>
    <ul>
        <?php foreach( $posts as $post ) {  ?>
        <li>
            <div class="pf_items">
                <div class="pf_items_thumb">
                    <a href="<?php echo get_permalink( $post->ID ) ?>"><?php echo self::get_fallback_image( $post, $type ); ?></a>
                </div>
            </div>
        </li>
        <?php } ?>
    </ul>
</div>
<style type="text/css">
    .template-5 .pf_items{overflow: hidden}
    .template-5 .pf_items_thumb, .template-3 .pf_items_thumb img{width: 100%;}
    .template-5 .pf_items_thumb img{position: relative; top: 3px;}
    .postify_posts.template-5 ul{list-style-type: none; margin: 0 !important; padding: 0 !important}
    .postify_posts.template-5 ul li{margin: 0 !important; padding: 0 !important; width: 33%; padding: 5px !important; float: left; box-sizing: border-box;}
    .postify_posts.template-5 ul li a{text-decoration: none !important; font-weight: bold }
</style>