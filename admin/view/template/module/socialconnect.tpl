<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
    <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right">
                <button type="submit" form="socialconnect-form" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
                <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
            <h1><?php echo $heading_title; ?></h1>
            <ul class="breadcrumb">
                <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
                <?php } ?>
            </ul>
        </div>
    </div>
    <div class="container-fluid">
        <?php if ($error_warning) { ?>
        <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        <?php } ?>
        


        <?php if ($error_code) { ?>
        <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_code; ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        <?php } ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
            </div>
            <div class="panel-body">
                <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="socialconnect-form" name="socialconnect-form" class="form-horizontal">
                    <div class="form-group required">
                        <label class="col-sm-2 control-label" for="socialconnect_pwdsecret"><span data-toggle="tooltip" data-html="true" data-trigger="click" title="<?php echo htmlspecialchars($entry_pwdsecret_desc); ?>"><?php echo $entry_pwdsecret; ?></span></label>
                        <div class="col-sm-10">
                            <input name="socialconnect_pwdsecret" id="socialconnect_pwdsecret" size="50" value="<?php echo $socialconnect_pwdsecret; ?>" class="form-control" />
                        </div>
                    </div>
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#facebook" data-toggle="tab"><?php echo $entry_facebook_heading; ?></a></li>
                        <li><a href="#google" data-toggle="tab"><?php echo $entry_google_heading; ?></a></li>
                        <li><a href="#linkedin" data-toggle="tab"><?php echo $entry_linkedin_heading; ?></a></li>
                        <li><a href="#twitter" data-toggle="tab"><?php echo $entry_twitter_heading; ?></a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="facebook">                            
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                  <div class="checkbox">
                                    <label id="socialconnect_facebook_active">
                                        <input <?php if($socialconnect_facebook_active == 'YES') { echo 'checked=""';} ?> name="socialconnect_facebook_active" id="socialconnect_facebook_active" type="checkbox" value="YES"> <?php echo $entry_socialconnect_activate; ?>
                                    </label>
                                  </div>
                                </div>
                            </div>
                            <div class="form-group required">
                                <label class="col-sm-2 control-label" for="socialconnect_apikey"><span data-toggle="tooltip" data-html="true" data-trigger="click" title="<?php echo htmlspecialchars($entry_apikey); ?>"><?php echo $entry_apikey; ?></span></label>
                                <div class="col-sm-10">
                                    <input name="socialconnect_apikey" id="socialconnect_apikey" size="50" value="<?php echo $socialconnect_apikey; ?>" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group required">
                                <label class="col-sm-2 control-label" for="socialconnect_apisecret"><span data-toggle="tooltip" data-html="true" data-trigger="click" title="<?php echo htmlspecialchars($entry_apisecret); ?>"><?php echo $entry_apisecret; ?></span></label>
                                <div class="col-sm-10">
                                    <input name="socialconnect_apisecret" id="socialconnect_apisecret" size="50" value="<?php echo $socialconnect_apisecret; ?>" class="form-control" />
                                </div>
                            </div>
                            <?php foreach ($languages as $language) { ?>
                            <div class="form-group required">
                                <label class="col-sm-2 control-label" for="socialconnect_button"><?php echo $entry_socialconnect_button; ?></label>
                                <div class="col-sm-10">
                                    <div class="input-group">
                                        <input class="form-control" type="text" name="socialconnect_button_<?php echo $language['language_id']; ?>" id="socialconnect_button_<?php echo $language['language_id']; ?>" size="50" value="<?php echo ${'socialconnect_button_' . $language['language_id']}; ?>" />
                                        <div class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" style="vertical-align: top;" /></div>
                                    </div>
                                </div>                                       
                            </div>
                            <?php } ?>
                        </div>
                        <div class="tab-pane" id="google">
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                  <div class="checkbox">
                                      <label id="socialconnect_google_active">
                                        <input <?php if($socialconnect_google_active == 'YES') { echo 'checked=""';} ?> name="socialconnect_google_active" id="socialconnect_google_active" type="checkbox" value="YES"> <?php echo $entry_socialconnect_activate; ?>
                                    </label>
                                  </div>
                                </div>
                            </div>
                            <div class="form-group required">
                                <label class="col-sm-2 control-label" for="socialconnect_client_id"><span data-toggle="tooltip" data-html="true" data-trigger="click" title="<?php echo htmlspecialchars($entry_socialconnect_client_id_desc); ?>"><?php echo $entry_socialconnect_client_id; ?></span></label>
                                <div class="col-sm-10">
                                    <input name="socialconnect_client_id" id="socialconnect_client_id" size="50" value="<?php echo $socialconnect_client_id; ?>" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group required">
                                <label class="col-sm-2 control-label" for="socialconnect_client_secret"><span data-toggle="tooltip" data-html="true" data-trigger="click" title="<?php echo htmlspecialchars($entry_socialconnect_client_secret_desc); ?>"><?php echo $entry_socialconnect_client_secret; ?></span></label>
                                <div class="col-sm-10">
                                    <input name="socialconnect_client_secret" id="socialconnect_client_secret" size="50" value="<?php echo $socialconnect_client_secret; ?>" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group required">
                                <label class="col-sm-2 control-label" for="socialconnect_developer_key"><span data-toggle="tooltip" data-html="true" data-trigger="click" title="<?php echo htmlspecialchars($entry_socialconnect_developer_key_desc); ?>"><?php echo $entry_socialconnect_developer_key; ?></span></label>
                                <div class="col-sm-10">
                                    <input name="socialconnect_developer_key" id="socialconnect_developer_key" size="50" value="<?php echo $socialconnect_developer_key; ?>" class="form-control" />
                                </div>
                            </div>
                            <?php foreach ($languages as $language) { ?>
                                <div class="form-group required">                                    
                                    <label class="col-sm-2 control-label" for="socialconnect_buttong"><?php echo $entry_socialconnect_button; ?></label>
                                    <div class="col-sm-10">
                                        <div class="input-group">
                                            <input class="form-control" type="text" name="socialconnect_buttong_<?php echo $language['language_id']; ?>" id="socialconnect_buttong_<?php echo $language['language_id']; ?>" size="50" value="<?php echo ${'socialconnect_buttong_' . $language['language_id']}; ?>" />
                                            <div class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" style="vertical-align: top;" /></div>
                                        </div>
                                    </div>       
                                </div>
                                <?php } ?>
                        </div>
                        <div class="tab-pane" id="twitter">
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                  <div class="checkbox">
                                      <label id="socialconnect_twitter_active">
                                        <input <?php if($socialconnect_twitter_active == 'YES') { echo 'checked=""';} ?> name="socialconnect_twitter_active" id="socialconnect_twitter_active" type="checkbox" value="YES"> <?php echo $entry_socialconnect_activate; ?>
                                    </label>
                                  </div>
                                </div>
                            </div>
                            <div class="form-group required">
                                <label class="col-sm-2 control-label" for="socialconnect_twitter_consumer_key"><span data-toggle="tooltip" data-html="true" data-trigger="click" title="<?php echo htmlspecialchars($entry_socialconnect_twitter_consumer_key_desc); ?>"><?php echo $entry_socialconnect_twitter_consumer_key; ?></span></label>
                                <div class="col-sm-10">
                                    <input name="socialconnect_twitter_consumer_key" id="socialconnect_twitter_consumer_key" size="50" value="<?php echo $socialconnect_twitter_consumer_key; ?>" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group required">
                                <label class="col-sm-2 control-label" for="socialconnect_twitter_consumer_secret"><span data-toggle="tooltip" data-html="true" data-trigger="click" title="<?php echo htmlspecialchars($entry_socialconnect_twitter_consumer_secret_desc); ?>"><?php echo $entry_socialconnect_twitter_consumer_secret; ?></span></label>
                                <div class="col-sm-10">
                                    <input name="socialconnect_twitter_consumer_secret" id="socialconnect_twitter_consumer_secret" size="50" value="<?php echo $socialconnect_twitter_consumer_secret; ?>" class="form-control" />
                                </div>
                            </div>
                            <?php foreach ($languages as $language) { ?>
                            <div class="form-group required">                                
                                <label class="col-sm-2 control-label" for="socialconnect_twitter_button"><?php echo $entry_socialconnect_button; ?></label>
                                <div class="col-sm-10">
                                    <div class="input-group">
                                        <input class="form-control" type="text" name="socialconnect_twitter_button_<?php echo $language['language_id']; ?>" id="socialconnect_twitter_button_<?php echo $language['language_id']; ?>" size="50" value="<?php echo ${'socialconnect_twitter_button_' . $language['language_id']}; ?>" />
                                        <div class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" style="vertical-align: top;" /></div>
                                    </div>
                                </div>     
                            </div>
                            <?php } ?>
                        </div>
                        <div class="tab-pane" id="linkedin">
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                  <div class="checkbox">
                                      <label id="socialconnect_linkedin_active">
                                        <input <?php if($socialconnect_linkedin_active == 'YES') { echo 'checked=""';} ?> name="socialconnect_linkedin_active" id="socialconnect_linkedin_active" type="checkbox" value="YES"> <?php echo $entry_socialconnect_activate; ?>
                                    </label>
                                  </div>
                                </div>
                            </div>
                            <div class="form-group required">
                                <label class="col-sm-2 control-label" for="socialconnect_linkedin_client_id"><span><?php echo $entry_socialconnect_linkedin_client_id; ?></span></label>
                                <div class="col-sm-10">
                                    <input name="socialconnect_linkedin_client_id" id="socialconnect_linkedin_client_id" size="50" value="<?php echo $socialconnect_linkedin_client_id; ?>" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group required">
                                <label class="col-sm-2 control-label" for="socialconnect_linkedin_client_secret"><span><?php echo $entry_socialconnect_linkedin_client_secret; ?></span></label>
                                <div class="col-sm-10">
                                    <input name="socialconnect_linkedin_client_secret" id="socialconnect_linkedin_client_secret" size="50" value="<?php echo $socialconnect_linkedin_client_secret; ?>" class="form-control" />
                                </div>
                            </div>
                            <?php foreach ($languages as $language) { ?>
                            <div class="form-group required">
                                <label class="col-sm-2 control-label" for="socialconnect_linkedin_button"><?php echo $entry_socialconnect_button; ?></label>
                                <div class="col-sm-10">
                                    <div class="input-group">
                                        <input class="form-control" type="text" name="socialconnect_linkedin_button_<?php echo $language['language_id']; ?>" id="socialconnect_linkedin_button_<?php echo $language['language_id']; ?>" size="50" value="<?php echo ${'socialconnect_linkedin_button_' . $language['language_id']}; ?>" />
                                        <div class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" style="vertical-align: top;" /></div>
                                    </div>
                                </div>        
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                    
                    
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
                        <div class="col-sm-10">
                            <select name="socialconnect_status" id="input-status" class="form-control">
                                <?php if ($socialconnect_status) { ?>
                                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                                <option value="0"><?php echo $text_disabled; ?></option>
                                <?php } else { ?>
                                <option value="1"><?php echo $text_enabled; ?></option>
                                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php echo $footer; ?>