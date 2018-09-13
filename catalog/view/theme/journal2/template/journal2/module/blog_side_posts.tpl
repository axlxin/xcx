<div class="box side-blog side-posts" id="journal-blog-side-posts-<?php echo $module; ?>">
    <div class="box-heading"><?php echo $heading_title; ?></div>
    <div class="box-post">
    <?php foreach ($posts as $post): ?>
        <div class="side-post">
            <?php if ($post['image']): ?>
            <a class="side-post-image" href="<?php echo $post['href']; ?>"><img src="<?php echo $post['image']; ?>" alt="<?php echo $post['name']; ?>"/></a>
            <?php endif; ?>
            <div class="side-post-details">
                <a class="side-post-title" href="<?php echo $post['href']; ?>"><?php echo $post['name']; ?></a>
                <div class="comment-date">
                    <?php if(!empty($post['author'])){ ?>
                    <span class="author">Posted by <?php echo $post['author']; ?>,</span>
                    <?php } ?>
                    <span class="date"><?php echo $post['date']; ?></span>
                </div>
                <?php if(0){ ?>
                <div class="short_description"><?php echo $post['short_description']; ?></div>
                <?php } ?>
            </div>
        </div>
    <?php endforeach; ?>
    </div>
</div>
