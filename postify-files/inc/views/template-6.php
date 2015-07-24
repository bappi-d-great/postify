<!-- Thumb is must, author won't work -->
<div class="postify_posts template-6">
    <h3><?php echo $args['title'] ?></h3>
    <ul>
        <?php foreach( $posts as $post ) {  ?>
        <li>
            <div class="pf_items">
                <div class="pf_items_thumb">
                    <a href="<?php echo get_permalink( $post->ID ) ?>"><?php echo self::get_fallback_image( $post, $type ); ?></a>
                </div>
                <div class="pf_items_title">
                    <?php echo $post->post_title ?>
                </div>
            </div>
        </li>
        <?php } ?>
    </ul>
</div>
<style type="text/css">
    .template-6 .pf_items{overflow: hidden; position: relative}
    .template-6 .pf_items_thumb, .template-3 .pf_items_thumb img{width: 100%; z-index: 99}
    .template-6 .pf_items_title{position: absolute; top: -100px; left: 0; width: 100%; z-index: 999; padding: 10px; background: rgba(0, 0, 0, 0.5); color: #fff}
    .template-6 .pf_items_thumb img{position: relative; top: 3px;}
    .postify_posts.template-6 ul{list-style-type: none; margin: 0 !important; padding: 0 !important}
    .postify_posts.template-6 ul li{margin: 0 !important; padding: 0 !important; width: 33%; padding: 5px !important; float: left; box-sizing: border-box;}
    .postify_posts.template-6 ul li a{text-decoration: none !important; font-weight: bold }
</style>
<script type="text/javascript">
jQuery(function($){
    $('.template-6 .pf_items_thumb').hoverIntent(function() {
        $(this).next('.pf_items_title').animate({
            top: 0
        });
    }, function() {
        $(this).next('.pf_items_title').animate({
            top: '-100px'
        });
    });
    
});
</script>