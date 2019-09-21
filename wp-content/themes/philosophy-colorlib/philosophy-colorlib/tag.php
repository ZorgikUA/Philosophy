<?php get_header();?>

<!-- s-content
================================================== -->
<section class="s-content">

    <div class="row masonry-wrap">
        <div class="masonry">
            <div class="grid-sizer"></div>
            <?php $tag_ID = get_query_var('tag');?>
            <?php if(!empty($tag_id)) {
                $args = ['numberposts'=> 5, 'tag'=>$tag_ID ];
            }
            wp_reset_postdata();
            ?>
            <?php
            $posts = get_posts( $args );
            if ( have_posts() ) : foreach($posts as $post){ setup_postdata($post); ?>

                <?php get_template_part( 'article', 'none' );?>

            <?php };?>
            <?php else: ?>
            <?php endif; ?>

        </div> <!-- end masonry -->
    </div> <!-- end masonry-wrap -->

    <div class="row">
        <div class="col-full">
            <nav class="pgn">

                <?php echo my_paginate();?>

            </nav>
        </div>
    </div>

</section> <!-- s-content -->

<!-- s-extra
================================================== -->
<section class="s-extra">

    <?php get_template_part( 'footer-content', 'none' );?>

</section> <!-- end s-extra -->

<!-- s-footer
================================================== -->
<?php get_footer();?>