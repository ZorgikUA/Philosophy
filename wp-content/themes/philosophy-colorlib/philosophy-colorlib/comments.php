<div class="comments-wrap">
    <?php
    $post_id = get_the_ID();
    $list_comments =  get_comments("post_id=$post_id");
    $args = array(
        'post_id' => $post_id,
        'count' => true
    );
    $comments = get_comments($args);
    ?>
    <div id="comments" class="row">
        <div class="col-full">

            <h3 class="h2">Comments: <?php echo $comments;?></h3>
            <?php foreach($list_comments as $comment){ ?>
            <ol class="commentlist">

                <li class="depth-1 comment">

                    <div class="comment__avatar">
                        <img width="50" height="50" class="avatar" src="images/avatars/user-01.jpg" alt="">
                    </div>

                    <div class="comment__content">

                        <div class="comment__info">
                            <cite><?php echo $comment->comment_author;?></cite>

                            <div class="comment__meta">
                                <time class="comment__time"><?php echo $comment->comment_date?></time>
                                <?php
                                $link = get_comment_reply_link(array(
                                    'reply_text' => "reply",
                                    'respond_id' => 'comment',
                                    'depth' => 5,
                                    'max_depth' => 10,
                                ), 2881, 631 );

                                echo $link;
                                ?>
                            </div>
                        </div>

                        <div class="comment__text">
                            <p><?php echo $comment->comment_content?></p>
                        </div>

                    </div>

                </li> <!-- end comment level 1 -->

            </ol> <!-- end commentlist -->
            <?php } ?>