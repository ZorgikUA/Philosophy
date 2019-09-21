<article class="masonry__brick entry format-standard" data-aos="fade-up">

    <div class="entry__text">
        <div class="entry__header">

            <div class="entry__date">
                <a href="<?php the_permalink();?>"><?php the_date('d.m.Y');?></a>
            </div>

            <h1 class="entry__title"><a href="<?php $current_post_id = get_the_id(); echo get_permalink($current_post_id)?>"><?php the_title();?></a></h1>

        </div>
        <div class="entry__excerpt">
            <?php the_excerpt();?>
        </div>
        <div class="entry__meta">
            <span class="entry__meta-links">

                <?php if(get_the_tags()) : ;?>
                    <p>Tags: <?php the_tags("", " ");?></p>
                <?php endif;?>

                <?php if(get_the_category()) : ;?>
                    <p>Category: <?php the_category(" ");?></p>
                <?php endif;?>

            </span>
        </div>
    </div>

</article>
