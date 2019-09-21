<div class="row top">

    <div class="col-eight md-six tab-full popular">
    <h3>Popular Posts</h3>

    <div class="block-1-2 block-m-full popular__posts">
        <?php $populargb = new WP_Query( array( 'posts_per_page' => 4, 'meta_key' => 'wpb_post_views_count', 'orderby' => 'wpb_post_views_count', 'order' => 'DESC'  ) );?>
        <?php if ( $populargb->have_posts() ) : while ( $populargb->have_posts() ) : $populargb->the_post(); ?>

            <article class="col-block popular__post">
                <a href="#0" class="popular__thumb">
                    <img src="images/thumbs/small/wheel-150.jpg" alt="">
                </a>
                <h5><a href="<?php echo get_permalink(get_the_id())?>"><?php the_title();?></a></h5>
                <section class="popular__meta">
                    <span class="popular__author"><?php the_excerpt();?></span>
                    <span class="popular__date"><span>on</span> <?php echo get_the_date('d.m.Y', get_the_id());?></span>
                </section>
            </article>
        <?php endwhile;?>
            <?php wp_reset_postdata();?>
        <?php else: ?>
        <?php endif;?>
    </div> <!-- end popular_posts -->
</div> <!-- end popular -->

<div class="col-four md-six tab-full about">
<?php $post_about = get_field('post_about','option');?>
    <h3> <?php echo $post_about->post_title ?> </h3>

    <p> <?php echo $post_about->post_content ?> </p>


    <ul class="about__social">
        <?php $soc_link = get_field('facebook_link','option');
        if ($soc_link){
            ?>
            <li>
                <a href="<?php echo $soc_link;?>"><i class="fa fa-facebook" aria-hidden="true"></i></a>
            </li>
        <?php }?>

        <?php $soc_link = get_field('twitter_link','option');
        if ($soc_link){
            ?>
            <li>
                <a href="<?php echo $soc_link;?>"><i class="fa fa-twitter" aria-hidden="true"></i></a>
            </li>
        <?php }?>

        <?php $soc_link = get_field('instagram_link','option');
        if ($soc_link){
            ?>
            <li>
                <a href="<?php echo $soc_link;?>"><i class="fa fa-instagram" aria-hidden="true"></i></a>
            </li>
        <?php }?>

        <?php $soc_link = get_field('pinterest_link','option');
        if ($soc_link){
            ?>
            <li>
                <a href="<?php echo $soc_link;?>"><i class="fa fa-pinterest" aria-hidden="true"></i></a>
            </li>
        <?php }?>
    </ul> <!-- end header__social -->
</div> <!-- end about -->

</div> <!-- end row -->


<div class="row bottom tags-wrap">
    <div class="col-full tags">
        <h3>Tags</h3>

        <div class="tagcloud">
            <?php $tags = get_tags();
            foreach ($tags as $tag) {
                echo "<a href='" . get_tag_link($tag->term_id) . "'>" . $tag->name . "</a>";
            }
            ?>
        </div> <!-- end tagcloud -->
    </div> <!-- end tags -->
</div> <!-- end tags-wrap -->

