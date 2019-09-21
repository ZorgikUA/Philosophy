<?php /*

 * Template Name: single-image
  * * Template Post Type: post
  * */

?>


<?php get_header();?>
<!-- s-content
================================================== -->
<section class="s-content s-content--narrow s-content--no-padding-bottom">
    <?php
    if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
        <article class="row format-gallery">

            <div class="s-content__header col-full">
                <h1 class="s-content__header-title">
                    <?php the_title(); ?>
                </h1>
                <ul class="s-content__header-meta">
                    <li class="date"><?php the_date('d.m.Y');?></li>
                    <li class="cat">
                        <?php if(get_the_category()) : ;?>
                            <p>Category: <?php the_category(" ");?></p>
                        <?php endif;?>
                    </li>
                </ul>
        </div> <!-- end s-content__header -->

        <div class="s-content__media col-full">
            <div class="s-content__slider slider">
                <div class="slider__slides">
                    <div class="slider__slide">
                        <?php
                        $images = get_field('image');
                        $size = 'full'; // (thumbnail, medium, large, full or custom size)
                        if( $images ): ?>
                            <?php foreach( $images as $image ): ?>
                                <p><?php echo wp_get_attachment_image( $image['ID'], $size ); ?></p>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div> <!-- end s-content__media -->

        <div class="col-full s-content__main">

            <p class="lead"><?php $post_id = get_the_ID(); wpb_set_post_views($post_id); the_content();?></p>

            <p class="s-content__tags">
                <span>Post Tags</span>

                <span class="s-content__tag-list">
                        <?php if(get_the_tags()) : ;?>
                            <?php the_tags("", " ");?>
                        <?php endif;?>
                        <?php echo wpb_get_post_views($post_id);?>
                    </span>
            </p> <!-- end s-content__tags -->

            <div class="s-content__author">
                <img src="images/avatars/user-03.jpg" alt="">

                <div class="s-content__author-about">
                    <h4 class="s-content__author-name">
                        <a href="#0">Author: <?php echo get_the_author($post_id); ?></a>
                    </h4>
                    <!---->
                    <!--                    <p>Alias aperiam at debitis deserunt dignissimos dolorem doloribus, fuga fugiat impedit laudantium magni maxime nihil nisi quidem quisquam sed ullam voluptas voluptatum. Lorem ipsum dolor sit amet, consectetur adipisicing elit.-->
                    <!--                    </p>-->
                    <!---->
                    <!--                    <ul class="s-content__author-social">-->
                    <!--                        <li><a href="#0">Facebook</a></li>-->
                    <!--                        <li><a href="#0">Twitter</a></li>-->
                    <!--                        <li><a href="#0">GooglePlus</a></li>-->
                    <!--                        <li><a href="#0">Instagram</a></li>-->
                    <!--                    </ul>-->
                </div>
            </div>

            <div class="s-content__pagenav">
                <div class="s-content__nav">
                    <div class="s-content__prev">
                        <p><?php next_post_link('<strong>%link</strong>', 'Previous Post'); ?></p>
                    </div>
                    <div class="s-content__next">
                        <p><?php previous_post_link('<strong>%link</strong>', 'Next Post'); ?></p>
                    </div>
                </div>
            </div> <!-- end s-content__pagenav -->

        </div> <!-- end s-content__main -->

    </article>
    <?php endwhile;?>
    <?php else: ?>
    <?php endif;?>

    <!-- comments
    ================================================== -->
    <?php comments_template();?>
    <?php
    $args = array(
    'fields' => array(
    'author' => '<p class="comment-form-author"><label for="author">Имя</label> <input id="author" name="author" type="text" value="" size="30" /></p>',
    'email' => '<p class="comment-form-email"><label for="email">E-mail</label> <input id="email" name="email" type="text" value="" size="30" /></p>',
    'url' => '<p class="comment-form-url"><label for="url">Сайт</label> <input id="url" name="url" type="text" value="" size="30" /></p>'
    )

    );
    $args = array(
    // изменяем текст кнопки отправки
    'label_submit'=>'Submit',

    );
    comment_form( $args = array(), $post_id = get_the_ID());?>
    </div> <!-- end col-full -->

    </div> <!-- end row comments -->
    </div> <!-- end comments-wrap -->

</section> <!-- s-content -->


<!-- s-extra
================================================== -->
<section class="s-extra">

    <?php get_template_part( 'footer-content', 'none' );?>

</section> <!-- end s-extra -->


<!-- s-footer
================================================== -->
<?php get_footer();?>