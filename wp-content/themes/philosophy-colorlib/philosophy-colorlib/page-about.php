

<?php get_header();?>

<!-- s-content
================================================== -->
<section class="s-content s-content--narrow">

    <div class="row">
        <?php $post_about = get_field('post_about','option');?>

       <div class="s-content__header col-full">
            <h1 class="s-content__header-title">
                <?php echo $post_about->post_title;?>
            </h1>
        </div> <!-- end s-content__header -->

        <div class="s-content__media col-full">
            <div class="s-content__post-thumb">
                <img src="images/thumbs/about/about-1000.jpg"
                     srcset="images/thumbs/about/about-2000.jpg 2000w,
                                 images/thumbs/about/about-1000.jpg 1000w,
                                 images/thumbs/about/about-500.jpg 500w"
                     sizes="(max-width: 2000px) 100vw, 2000px" alt="" >
            </div>
        </div> <!-- end s-content__media -->

        <div class="col-full s-content__main">

<!--            <p class="lead">Duis ex ad cupidatat tempor Excepteur cillum cupidatat fugiat nostrud cupidatat dolor sunt sint sit nisi est eu exercitation incididunt adipisicing veniam velit id fugiat enim mollit amet anim veniam dolor dolor irure velit commodo cillum sit nulla ullamco magna amet magna cupidatat qui labore cillum sit in tempor veniam consequat non laborum adipisicing aliqua ea nisi sint.</p>-->

            <p>
                <?php echo $post_about->post_content;?>
            </p>


            <div class="row block-1-2 block-tab-full">
                <div class="col-block">
                    <h3 class="quarter-top-margin">Who We Are.</h3>
                    <p><?php echo the_field('who_we_are','option');?></p>
                </div>

                <div class="col-block">
                    <h3 class="quarter-top-margin">Our Mission.</h3>
                    <p><?php echo the_field('our_mission','option');?></p>
                </div>

                <div class="col-block">
                    <h3 class="quarter-top-margin">Our Vision.</h3>
                    <p><?php echo the_field('our_vision','option');?></p>
                </div>

                <div class="col-block">
                    <h3 class="quarter-top-margin">Our Values.</h3>
                    <p><?php echo the_field('our_values','option');?></p>
                </div>

            </div>


        </div> <!-- end s-content__main -->

    </div> <!-- end row -->

</section> <!-- s-content -->


<!-- s-extra
================================================== -->
<section class="s-extra">

    <?php get_template_part( 'footer-content', 'none' );?>

</section> <!-- end s-extra -->


<!-- s-footer
================================================== -->
<?php get_footer();?>