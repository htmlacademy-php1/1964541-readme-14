<?php if($post): ?>
<div class="post__buttons">
    <a class="post__indicator post__indicator--likes button" href="likes.php?id=<?= $post['id'] ?>" title="Лайк">
        <svg class="post__indicator-icon" width="20" height="17">
            <use xlink:href="#icon-heart"></use>
        </svg>
        <svg class="post__indicator-icon post__indicator-icon--like-active" width="20" height="17">
            <use xlink:href="#icon-heart-active"></use>
        </svg>
        <span><?= $post['likes'] ?></span>
        <span class="visually-hidden">количество лайков</span>
    </a>
    <a class="post__indicator post__indicator--comments button" href="post.php?id=<?= $post['id'] ?>" title="Комментарии">
        <svg class="post__indicator-icon" width="19" height="17">
            <use xlink:href="#icon-comment"></use>
        </svg>
        <span><?= $post['comment_sum'] ?></span>
        <span class="visually-hidden">количество комментариев</span>
    </a>
    <a class="post__indicator post__indicator--repost button" href="repost.php?id=<?= $post['id'] ?>" title="Репост">
        <svg class="post__indicator-icon" width="19" height="17">
            <use xlink:href="#icon-repost"></use>
        </svg>
        <span><?= $post['reposts_sum'] ?></span>
        <span class="visually-hidden">количество репостов</span>
    </a>
</div>
<?php endif; ?>
