<div class="box box-socialconnect">
    
    <?php if($socialconnect_facebook_active == 'YES' || $socialconnect_google_active == 'YES' || $socialconnect_twitter_active == 'YES'|| $socialconnect_linkedin_active == 'YES') { ?>
    <div class="separator">
        <span></span>
    </div>
    <h3 class="page-heading text-center"><?php echo $heading_title; ?></h3>
    <?php } ?>
    <div class="box-content text-center">
        <?php if($socialconnect_google_active == 'YES') { ?>
        <a class="login" href="<?php echo $authUrl; ?>"><?php echo $socialconnect_buttong; ?></a>
        <?php } if($socialconnect_facebook_active == 'YES') { ?>
        <a class="box-socialconnect-a" href="<?php echo $socialconnect_url; ?>"><?php echo $socialconnect_button; ?></a>
        <?php } if($socialconnect_twitter_active == 'YES') { ?>
        <a class="box-socialconnect-twitter" href="<?php echo $socialconnect_twitter_url; ?>"><?php echo $socialconnect_twitter_button; ?></a>
        <?php } if($socialconnect_linkedin_active == 'YES') { ?>
        <a class="box-socialconnect-linkedin" href="<?php echo $socialconnect_linkedin_url; ?>"><?php echo $socialconnect_linkedin_button; ?></a>
        <?php } ?>
    </div>
</div>
<style type="text/css">
.text-center{ text-align: center}
.box-socialconnect { margin-bottom: 20px; }
.separator { background: url(image/socialconnect/line-separator.png) no-repeat 50% 0; height: 1px; position: relative;   margin: 33px 0 35px; display:none }
.separator span { background: url(image/socialconnect/circle-separator.png) no-repeat 0 0; display: block; width: 36px; height: 36px; position: absolute; left: 50%; top: 50%; margin-top: -18px; margin-left: -18px; }
</style>