<?php get_header();?>

    <!-- s-content
================================================== -->
<section class="s-content">
    <?php $cat_ID = get_query_var('cat');?>
    <div class="row narrow">
        <div class="col-full s-content__header" data-aos="fade-up">
            <h1>Category: <?php echo get_cat_name($cat_ID);?></h1>

            <p class="lead"><?php echo category_description($cat_ID);?></p>
        </div>
    </div>

    <div class="row masonry-wrap">
        <div class="masonry">

            <div class="grid-sizer"></div>
            <?php
            $args = ['category'=>$cat_ID];
            $posts = get_posts( $args);
            foreach($posts as $post) {setup_postdata($post);?>
                <?php get_template_part( 'article', 'none' );?>
            <?php }?>
            <?php  wp_reset_postdata();?>
        </div> <!-- end masonry -->
    </div> <!-- end masonry-wrap -->

<!--    <div class="row">-->
<!--        <div class="col-full">-->
<!--            <nav class="pgn">-->
<!--                <ul>-->
<!--                    <li><a class="pgn__prev" href="#0">Prev</a></li>-->
<!--                    <li><a class="pgn__num" href="#0">1</a></li>-->
<!--                    <li><span class="pgn__num current">2</span></li>-->
<!--                    <li><a class="pgn__num" href="#0">3</a></li>-->
<!--                    <li><a class="pgn__num" href="#0">4</a></li>-->
<!--                    <li><a class="pgn__num" href="#0">5</a></li>-->
<!--                    <li><span class="pgn__num dots">…</span></li>-->
<!--                    <li><a class="pgn__num" href="#0">8</a></li>-->
<!--                    <li><a class="pgn__next" href="#0">Next</a></li>-->
<!--                </ul>-->
<!--                --><?php //if (function_exists('wp_corenavi')) wp_corenavi(); ?>
<!--            </nav>-->
<!--        </div>-->
<!--    </div>-->

</section> <!-- s-content -->


<!-- s-extra
================================================== -->
<section class="s-extra">

    <?php get_template_part( 'footer-content', 'none' );?>

</section> <!-- end s-extra -->


<!-- s-footer
================================================== -->
<?php get_footer();?>