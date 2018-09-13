<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
    <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right"></div>
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
        <?php if ($success) { ?>
        <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        <?php } ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_list; ?></h3>
            </div>
            <div class="panel-body">
                <form method="post" enctype="multipart/form-data" target="_blank" id="form-order">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
                                    <td class="text-left"><?php if ($sort == 'pai.id') { ?>
                                        <a href="<?php echo $sort_id; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_id; ?></a>
                                        <?php } else { ?>
                                        <a href="<?php echo $sort_id; ?>"><?php echo $column_id; ?></a>
                                        <?php } ?></td>
                                    <td class="text-left"><?php echo $column_date_added; ?></td>
                                    <td class="text-left"><?php echo $column_customer; ?></td>
                                    <td class="text-left"><?php echo $column_email; ?></td>
                                    <td class="text-center">Estimated Cost</td>
                                    <td class="text-left">Inquiry Details</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($inquiries) { ?>
                                <?php foreach ($inquiries as $inquiry) { ?>
                                <tr>
                                    <td class="text-center"><?php if (in_array($inquiry['id'], $selected)) { ?>
                                        <input type="checkbox" name="selected[]" value="<?php echo $inquiry['id']; ?>" checked="checked" />
                                        <?php } else { ?>
                                        <input type="checkbox" name="selected[]" value="<?php echo $inquiry['id']; ?>" />
                                        <?php } ?>
                                    </td>
                                    <td class="text-left"><?php echo $inquiry['id']; ?></td>
                                    <td class="text-left"><?php echo $inquiry['date_added']; ?></td>
                                    <td class="text-left"><?php echo $inquiry['customer']; ?></td>
                                    <td class="text-left"><?php echo $inquiry['email']; ?></td>
                                    <td class="text-center">
                                        <table class='table table-bordered'>
                                            <tbody>
                                                <tr>
                                                    <td>A. PCB Manufacturing</td>
                                                    <td><?php echo $inquiry['estimated_cost']['a']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>B. BOM Purchasing </td>
                                                    <td><?php echo $inquiry['estimated_cost']['b']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>C. PCB ASSEMBLING</td>
                                                    <td class='text-left'>
                                                        <div>Client's selected option:&nbsp;&nbsp;<?php echo $inquiry['estimated_cost']['c']['user_selected']; ?></div>
                                                        <ul>
                                                            <li>Manual without stencil:&nbsp;&nbsp;<?php echo $inquiry['estimated_cost']['c']['manual_without_stencil']; ?></li>
                                                            <li>Manual with stencil:&nbsp;&nbsp;<?php echo $inquiry['estimated_cost']['c']['manual_with_stencil']; ?></li>
                                                            <li>Automatic:&nbsp;&nbsp;<?php echo $inquiry['estimated_cost']['c']['automatic']; ?></li>
                                                        </ul>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>D. PCBA Flashing & Testing</td>
                                                    <td><?php echo $inquiry['estimated_cost']['d']; ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                    <td class="text-left">
                                        <ul>
                                            <?php foreach($inquiry['formData'] as $item){ ?>
                                            <li><?php echo $item; ?></li>
                                            <?php } ?>
                                        </ul>
                                    </td>
                                </tr>
                                <?php } ?>
                                <?php } else { ?>
                                <tr>
                                    <td class="text-center" colspan="7"><?php echo $text_no_results; ?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </form>
                <div class="row">
                    <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
                    <div class="col-sm-6 text-right"><?php echo $results; ?></div>
                </div>
            </div>
        </div>
    </div>

</div>
<?php echo $footer; ?>