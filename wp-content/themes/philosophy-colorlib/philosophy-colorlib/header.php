<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <!--- basic page needs
    ================================================== -->
    <meta charset="utf-8">
    <title><?php bloginfo('name'); ?></title>
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- mobile specific metas
    ================================================== -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- CSS
    ================================================== -->
    <link rel="stylesheet" href="<?php echo get_template_directory_uri();?>/css/base.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri();?>/css/vendor.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri();?>/css/main.css">

    <!-- script
    ================================================== -->
    <script src="<?php echo get_template_directory_uri();?>/js/modernizr.js"></script>
    <script src="<?php echo get_template_directory_uri();?>/js/pace.min.js"></script>

    <!-- favicons
    ================================================== -->
    <link rel="shortcut icon" href="<?php echo get_template_directory_uri();?>/favicon.ico" type="image/x-icon">
    <link rel="icon" href="<?php echo get_template_directory_uri();?>/favicon.ico" type="image/x-icon">

    <?php wp_head();?>
</head>

<body id="top">

<!-- pageheader
================================================== -->
<section class="s-pageheader s-pageheader--home">
<header class="header">
    <div class="header__content row">

        <div class="header__logo">
            <a class="logo" href="<?php echo home_url();?>">
                <img src="<?php echo get_template_directory_uri();?>/images/logo.svg" alt="Homepage">
            <?php //echo bloginfo('name'); ?>
            </a>
        </div> <!-- end header__logo -->

        <ul class="header__social">
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

        <a class="header__search-trigger" href="#0"></a>

        <div class="header__search">

            <?php get_search_form(); ?>

        </div>  <!-- end header__search -->


        <a class="header__toggle-menu" href="#0" title="Menu"><span>Menu</span></a>

<!--        <nav class="header__nav-wrap">-->
            <?php wp_my_menu(array( 'menu' => '', 'container' => 'nav', 'container_class' => 'header__nav-wrap', 'container_id' => '', 'menu_class' => 'menu', 'menu_id' => '',
            'echo' => true, 'fallback_cb' => 'wp_page_menu', 'before' => '', 'after' => '', 'link_before' => '', 'link_after' => '', 'items_wrap' => '<ul class="header__nav">%3$s</ul>', 'item_spacing' => 'preserve',
            'depth' => 0, 'walker' => '', 'theme_location' => '' )

            );?>
<!--            <h2 class="header__nav-heading h6">Site Navigation</h2>-->

<!--            <ul class="header__nav">-->
<!--                <li class="current"><a href="--><?php //echo home_url();?><!--" title="">Home</a></li>-->
<!--                <li class="has-children">-->
<!--                    <a href="#0" title="">Categories</a>-->
<!---->
<!--                    <ul class="sub-menu">-->
<!--                        --><?php //wp_list_categories('title_li=');?>
<!--                    </ul>-->
<!--                </li>-->
<!--                    <li class="has-children">-->
<!--                        <a href="#0" title="">Blog</a>-->
<!--                        <ul class="sub-menu">-->
<!--                            <li><a href="single-video.html">Video Post</a></li>-->
<!--                            <li><a href="single-audio.html">Audio Post</a></li>-->
<!--                            <li><a href="single-gallery.html">Gallery Post</a></li>-->
<!--                            <li><a href="single-standard.html">Standard Post</a></li>-->
<!--                        </ul>-->
<!--                    </li>-->
<!--                --><?php
//                $pages = get_pages();
//                foreach ( $pages as $page ) {
//                    $li = '<li><a href="' . get_page_link( $page->ID ) . '">';
//                    $li .= $page->post_title;
//                    $li .= '</a></li>';
//                    echo $li;
//                }
//                ?>
<!--            </ul> --> <!-- end header__nav -->
<!--           <a href="#0" title="Close Menu" class="header__overlay-close close-mobile-menu">Close</a>-->
<!---->
<!--        </nav>-->
        <!-- end header__nav-wrap -->

    </div> <!-- header-content -->
</header> <!-- header -->

<!--    start slider-->
    <div class="pageheader-content row">
        <div class="col-full">


            <div class="featured">

                <?php
                if (have_rows('big_header_post','option')){?>

                <?php while(have_rows('big_header_post','option')){
                the_row();
                $bg_image = get_sub_field('header_image');
                $linked_post = get_sub_field('header_post');
                ?>
                <div class="featured__column featured__column--big">

                        <div class="entry" style="background-image:url('<?php echo $bg_image;?> ');">

                            <div class="entry__content">
<!--                                <div class="entry__category" style="color:white;">-->
<!--                                    <p>Categories: </p>-->
<!--                                    <p></p>-->
<!--                                </div>-->

                                <h1><a href="<?php echo get_permalink($linked_post->ID);?>" title="">
                                        <?php echo apply_filters('the_content', $linked_post->post_content);?></a></h1>

                                <div class="entry__info">
                                    <a href="#0" class="entry__profile-pic">
                                        <img class="avatar" src="" alt="">
                                    </a>

                                    <ul class="entry__meta">
                                        <li><a href="#0"><?php echo $linked_post->post_author; ?></a></li>
                                        <li><?php echo get_the_date('F d, Y', $linked_post->ID);?></li>
                                    </ul>
                                </div>
                            </div> <!-- end entry__content -->

                        </div> <!-- end entry -->
                    <?php }?>
                    <?php }?>
                </div> <!-- end featured__big -->


                <div class="featured__column featured__column--small">

                    <?php
                    if (have_rows('header_posts','option')){?>

                    <?php while(have_rows('header_posts','option')){
                    the_row();
                    $bg_image = get_sub_field('header_image');
                    $linked_post = get_sub_field('header_post');
                    ?>
                        <div class="entry" style="background-image:url('<?php echo $bg_image;?>');">

                            <div class="entry__content">
<!--                                <div class="entry__category" style="color:white;">-->
<!--                                    <p>Categories: --><?php //the_category(' '); ?><!--</p>-->
<!--                                    <p>--><?php //the_tags("Tags: ", ", "); ?><!--</p>-->
<!--                                </div>-->
                                <h1><a href="<?php echo get_permalink($linked_post->ID);?>" title="">
                                        <?php echo apply_filters('the_content', $linked_post->post_content);?>
                                    </a>
                                </h1>

                                <div class="entry__info">
                                    <ul class="entry__meta">
                                        <li><a href="#"><?php echo $linked_post->post_author; ?></a></li>
                                        <li><?php echo get_the_date('F d, Y', $linked_post->ID);?></li>
                                    </ul>
                                </div>
                            </div> <!-- end entry__content -->

                        </div> <!-- end entry -->
                        <?php } ?>
                    <?php } ?>

                </div> <!-- end featured__small -->

            </div> <!-- end featured -->

        </div> <!-- end col-full -->
    </div> <!-- end pageheader-content row -->

</section> <!-- end s-pageheader -->
<!--    end slider-->