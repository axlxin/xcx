<?php echo $header; ?>
<div id="container" class="container j-container">
  <?php if(0){ ?>
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
  <?php } ?>
<?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content">
    <h1 class="heading-title"><?php echo $heading_title; ?></h1><?php echo $content_top; ?>
    <?php if ($this->journal2->settings->get('blog_blog_feed_url')): ?>
    <a class="journal-blog-feed" href="<?php echo $this->journal2->settings->get('blog_blog_feed_url'); ?>" target="_blank"><span class="feed-text"><?php echo $this->journal2->settings->get("feed_text"); ?></span></a>
    <?php endif; ?>
    <?php if (isset($category_description) && $category_description): ?>
    <div><?php echo $category_description; ?></div>
    <?php endif; ?>
    <div class="posts-filter">
        <div class="filter"><b>Filter by:</b>
            <span class="filter-text" id='post-filter-switch'><?php echo $selected_post_filter; ?></span>
        </div>
    </div>
    <div class="post-filters-box">
        <a href="<?php echo $url_no_filter_tag; ?>" class='post-filter-item'>No filter</a>
        <?php foreach($tags as $tag){ ?>
        <a href="<?php echo $tag['href']; ?>" class='post-filter-item <?php echo $tag["selected"]; ?> '><?php echo $tag['name']; ?></a>
        <?php } ?>
    </div>
    
    <?php if ($posts): ?>
    <div class="posts main-posts blog-<?php echo $this->journal2->settings->get("config_blog_settings.posts_display", "grid"); ?>-view">
        <?php foreach ($posts as $post): ?>
        <div class="<?php echo $grid_classes; ?>">
            <a class="post-wrapper" href="<?php echo $post['href']; ?>">
                <?php if ($post['image']): ?>
                <div class="post-image"><img  src="<?php echo $post['image']; ?>" alt="<?php echo $post['name']; ?>"/></div>
                <?php endif; ?>
                <div class="post-item-details">
                    <h2><?php echo $post['name']; ?></h2>
                    <?php if(!empty($post['short_description'])){ ?>
                    <div class="post-text"><span><?php echo $post['short_description']; ?></span></div>
                    <?php } ?>
                    <div class="comment-date">
                        <span class="">Posted by <?php echo $post['author']; ?>,&nbsp;&nbsp;</span>
                        <span class=""><?php echo $post['date']; ?></span>
                        <!--<span class="p-comment"><?php echo $post['comments']; ?></span>-->
                    </div>
                    <div class="post-tags">
                        <?php echo $post['tags']; ?>
                    </div>
                </div>
            </a>
        </div>
        <?php endforeach; ?>
    </div>
    <?php echo $pagination; ?>
    <?php else: ?>
    <div class="buttons">
        <div class="right"><a href="<?php echo $continue; ?>" class="button"><?php echo $button_continue; ?></a></div>
    </div>
    <?php endif; ?>
    <?php echo $content_bottom; ?>
</div>
<script>
    Journal.equalHeight($(".posts .post-wrapper"), '.post-item-details h2 a');
    Journal.equalHeight($(".posts .post-wrapper"), '.post-text span');
</script>
<script type='text/javascript'>
    kpsm.initPostFilter();
</script>
</div>
<?php echo $footer; ?>