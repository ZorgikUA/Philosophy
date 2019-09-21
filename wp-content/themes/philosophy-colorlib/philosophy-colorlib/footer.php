<footer class="s-footer">

    <div class="s-footer__main">
        <div class="row">

            <div class="col-two md-four mob-full s-footer__sitelinks">

                <h4>Quick Links</h4>

                <ul class="s-footer__linklist">

                        <?php wp_list_pages('title_li='); ?>
                </ul>

            </div> <!-- end s-footer__sitelinks -->

            <div class="col-two md-four mob-full s-footer__archives">

                <h4>Categories</h4>

                <ul class="s-footer__linklist">
                    <?php wp_list_categories('title_li=');?>
                </ul>

            </div> <!-- end s-footer__archives -->

            <div class="col-two md-four mob-full s-footer__social">

                <h4>Social</h4>

                <ul class="s-footer__linklist">
                    <?php $soc_link = get_field('facebook_link','option');
                    if ($soc_link){
                        ?>
                        <li>
                            <a href="<?php echo $soc_link;?>">Facebook</a>
                        </li>
                    <?php }?>
                    <?php $soc_link = get_field('instagram_link','option');
                    if ($soc_link){
                        ?>
                        <li>
                            <a href="<?php echo $soc_link;?>">Instagram</a>
                        </li>
                    <?php }?>
                    <?php $soc_link = get_field('twitter_link','option');
                    if ($soc_link){
                        ?>
                        <li>
                            <a href="<?php echo $soc_link;?>">Twitter</a>
                        </li>
                    <?php }?>
                    <?php $soc_link = get_field('pinterest_link','option');
                    if ($soc_link){
                        ?>
                        <li>
                            <a href="<?php echo $soc_link;?>">Pinterest</a>
                        </li>
                    <?php }?>

                </ul>

            </div> <!-- end s-footer__social -->

            <div class="col-five md-full end s-footer__subscribe">
                <?php
                $linked_post = get_field('our_newsletter', 'option');?>
                <h4><?php echo $linked_post->post_title;?></h4>

                <p><?php echo $linked_post->post_content;?></p>

                <div class="subscribe-form">
                    <form id="mc-form" class="group" novalidate="true">

                        <input type="email" value="" name="EMAIL" class="email" id="mc-email" placeholder="Email Address" required="">

                        <input type="submit" name="subscribe" value="Send">

                        <label for="mc-email" class="subscribe-message"></label>

                    </form>
                </div>

            </div> <!-- end s-footer__subscribe -->

        </div>
    </div> <!-- end s-footer__main -->

    <div class="s-footer__bottom">
        <div class="row">
            <div class="col-full">
                <div class="s-footer__copyright">
                    <span><?php the_field('copyright', 'option');?></span>
                </div>

                <div class="go-top">
                    <a class="smoothscroll" title="Back to Top" href="#top"></a>
                </div>
            </div>
        </div>
    </div> <!-- end s-footer__bottom -->
    <?php wp_footer();?>
</footer> <!-- end s-footer -->

<!-- preloader
================================================== -->
<div id="preloader">
    <div id="loader">
        <div class="line-scale">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
</div>


<!-- Java Script
================================================== -->
<script src="<?php echo get_template_directory_uri();?>/js/jquery-3.2.1.min.js"></script>
<script src="<?php echo get_template_directory_uri();?>/js/plugins.js"></script>
<script src="<?php echo get_template_directory_uri();?>/js/main.js"></script>

</body>

</html>