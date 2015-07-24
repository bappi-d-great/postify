<!-- Thumb is must, author won't work -->
<div class="postify_posts template-7">
    <h3><?php echo $args['title'] ?></h3>
    <ul>
        <?php foreach( $posts as $post ) {  ?>
        <li>
            <div class="pf_items">
                
                <div class="flip-container" ontouchstart="this.classList.toggle('hover');">
                    <div class="flipper">
                        <div class="front">
                            <a href="<?php echo get_permalink( $post->ID ) ?>"><?php echo self::get_fallback_image( $post, $type ); ?></a>
                        </div>
                        <div class="back">
                            <div class="back-text">
                                <a href="<?php echo get_permalink( $post->ID ) ?>"><?php echo $post->post_title ?></a>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </li>
        <?php } ?>
    </ul>
</div>
<style type="text/css">
    .template-7 .pf_items{overflow: hidden; position: relative}
    .template-7 .pf_items_thumb, .template-3 .pf_items_thumb img{width: 100%; z-index: 99}
    .template-7 .pf_items_title{position: absolute; top: -100px; left: 0; width: 100%; z-index: 999; padding: 10px; background: rgba(0, 0, 0, 0.5); color: #fff}
    .template-7 .pf_items_thumb img{position: relative; top: 3px;}
    .postify_posts.template-7 ul{list-style-type: none; margin: 0 !important; padding: 0 !important}
    .postify_posts.template-7 ul li{margin: 0 !important; padding: 0 !important; width: 33%; padding: 5px !important; float: left; box-sizing: border-box;}
    .postify_posts.template-7 ul li a{text-decoration: none !important; font-weight: bold }
    
    /* entire container, keeps perspective */
.flip-container {
	perspective: 1000;
}
	/* flip the pane when hovered */
	.flip-container:hover .flipper, .flip-container.hover .flipper {
		transform: rotateY(180deg);
	}

.flip-container, .front, .back {
	width: 100%;
	height: 200px;
}

/* flip speed goes here */
.flipper {
	transition: 0.6s;
	transform-style: preserve-3d;

	position: relative;
}

/* hide back of pane during swap */
.front, .back {
	backface-visibility: hidden;

	position: absolute;
	top: 0;
	left: 0;
}

/* front pane, placed above back */
.front {
	z-index: 2;
	/* for firefox 31 */
	transform: rotateY(0deg);
}

/* back, initially hidden pane */
.back {
    transform: rotateY(180deg);
    background: rgba( 0, 0, 0, 0.7 );
}

.back-text{
    transform: translateY(-50%);
    position: relative;
    top: 50%;
    text-align: center;
    color: #fff;
    padding: 0 15px;
}

.back-text a{
    color: #fff !important;
}
    
</style>