<?php 
echo $header;

require(DIR_CONFIG.'kp_productPcbAssembly_config.php');
?>
<div class="inquiry-result-mask">
    <div class="inquiry-result-box">
        <div class="inquiry-result-info">
            <h3 style="text-align: center;text-decoration: underline;">Thank you for the inquiry!</h3>
            <p>We’ve sent you a copy of your rough quotation. <br>
            Our team will follow up as soon as possible with a complete and formal quotation based on your uploaded files and specifications.</p>
        </div>
        <div class="inquiry-result-footer">
            <button class="btn btn-close-box" type="button" onclick="javascript:location.reload();">Close</button>
        </div>
    </div>
</div>

<div id="container" class="container bg-pcb-blue">
    <div class="row" style="height: 16px;background-color: rgb(242, 242, 242)"></div>
    <div id="product" class="row">
        <div class="xl-70">
            <img src='/image/kp_productPcb/assembly_header_banner.jpg' class='assembly-header-banner'>

            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
            <div class="row product-options">
                <div class="xl-100" style='margin-bottom: 0'>
                    <section class="section-manufacturing">
                        <h2 class='hover-pointer'><span class='section-mark text-pcb-blue'>A</span><span class="fa fa-caret-up text-pcb-blue"></span>PCB MANUFACTURING</h2>
                        <div class="box-filler">
                            <div class='row product-option' data-section='A' data-islogged='<?php echo $this->customer->isLogged() ? 1 : 0; ?>' data-product-total='Unknown'>
                                <div class="xl-25">
                                    <div class="option-name text-right">
                                        <?php if(empty($tips_assembly['pcb_supplied_by'])){ ?>
                                        <span>PCB Supplied by </span> 
                                        <?php }else{ ?>
                                        <span data-toggle="popover"  title="Additional Details<span class='fa fa-times'></span>" data-content="<?php echo $tips_assembly['pcb_supplied_by']; ?>" data-html="true" >PCB Supplied by <span class="fa fa-question-circle"></span></span>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="xl-75">
                                    <input type="hidden" name="a[pcb_supplied_by]" value="Smart Prototyping">
                                    <div class='option option-group selected' id='a-option-group-smart'>
                                        <span class='option-group-name selected' data-value='Smart Prototyping'>Smart Prototyping</span>
                                        <input type="text" name="a[smart_order_id]" value="" placeholder="Order ID"  class="form-control">
                                        <span id="position-popover-1" style="margin-right:8px">&nbsp;</span>
                                        <input type="text" name="a[smart_file_name]" value="" placeholder="File Name"  class="form-control">
                                        <div class='option-group-desc'><a href='https://www.smart-prototyping.com/PCB-Prototyping.html'>Click here</a> to place an order for PCB Manufacturing</div>
                                    </div>
                                    <div class='option option-group'>
                                        <span class='option-group-name' data-value='Me'>Me</span>
                                        <input type="text" name="a[me_shipping_company]" value="" placeholder="(Shipping Company)"  class="form-control shipping-company-a">
                                        <input type="text" name="a[me_tracking_number]" value="" placeholder="Tracking Number"  class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>


                    <section class="section-purchasing">
                        <h2 class="hover-pointer"><span class='section-mark text-pcb-blue'>B</span><span class="fa fa-caret-up text-pcb-blue"></span>BOM PURCHASING</h2>
                        <div class="box-filler" >
                            <div class='row product-option' data-section='B'>
                                <div class="xl-25">
                                    <div class="option-name text-right">
                                        <?php if(empty($tips_assembly['components_supplied_by'])){ ?>
                                        <span>Components Supplied by </span> 
                                        <?php }else{ ?>
                                        <span data-toggle="popover"  title="Additional Details<span class='fa fa-times'></span>" data-content="<?php echo $tips_assembly['components_supplied_by']; ?>" data-html="true" >Components Supplied by <span class="fa fa-question-circle"></span></span>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="xl-75">
                                    <input type="hidden" name="b[components_supplied_by]" value="Smart Prototyping">
                                    <div class='option option-group selected' id='b-option-group-smart'>
                                        <span class='option-group-name selected' data-value='Smart Prototyping'>Smart Prototyping</span>
                                        <select name='b[estimated_type]'>
                                            <option value='0'>Estimated total of all components in batch</option>
                                            <option value='1'>Estimated total of components per board</option>
                                        </select>
                                        <span class='estimated-price'><?php echo $currency_current_symbol_left; ?></span><input type="text" name="b[estimated_price]" value="0.00" placeholder="Price"  class="form-control" data-value-type='float' data-range='0.00,100000,00'>
                                        <div class='option-group-desc'>Please upload your BOM <a href="javascript:void(0);" onclick='KP_PCB.jump("section-project-files");'>below</a></div>
                                    </div>
                                    <div class='option option-group'>
                                        <span class='option-group-name' data-value='Me'>Me</span>
                                        <input type="text" name="b[me_shipping_company]" value="" placeholder="(Shipping Company)"  class="form-control shipping-company-b">
                                        <input type="text" name="b[me_tracking_number]" value="" placeholder="Tracking Number"  class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section class="section-assembling">
                        <h2 class="hover-pointer"><span class='section-mark text-pcb-blue'>C</span><span class="fa fa-caret-up text-pcb-blue"></span>PCB ASSEMBLING</h2>
                        <div class="box-filler" >
                            <div class='row product-option'>
                                <div class="xl-25">
                                    <div class="option-name text-right">
                                        <?php if(empty($tips_assembly['pcb_assembly_quantity'])){ ?>
                                        <span>PCB Assembly Quantity </span> 
                                        <?php }else{ ?>
                                        <span data-toggle="popover"  title="Additional Details<span class='fa fa-times'></span>" data-content="<?php echo $tips_assembly['pcb_assembly_quantity']; ?>" data-html="true" >PCB Assembly Quantity <span class="fa fa-question-circle"></span></span>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="xl-75">
                                    <div class="option option-text">
                                        <input id='pcb_assembly_quantity' type="text" name="c[pcb_assembly_quantity]" value="10" placeholder="PCB Assembly Quantity"  class="form-control" data-value-type='int' data-range='1,10000'>
                                    </div>
                                </div>
                            </div>
                            <div class='row product-option'>
                                <div class="xl-25">
                                    <div class="option-name text-right">
                                        <?php if(empty($tips_assembly['unique_number_of_parts'])){ ?>
                                        <span>Unique Number of Parts </span> 
                                        <?php }else{ ?>
                                        <span data-toggle="popover"  title="Additional Details<span class='fa fa-times'></span>" data-content="<?php echo $tips_assembly['unique_number_of_parts']; ?>" data-html="true" >Unique Number of Parts <span class="fa fa-question-circle"></span></span>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="xl-75">
                                    <div class="option option-text">
                                        <input type="text" name="c[unique_number_of_parts]" value="10" placeholder="Unique Number of Parts"  class="form-control" data-value-type='int' data-range='1,500'>
                                    </div>
                                </div>
                            </div>
                            <div class='row product-option'>
                                <div class="xl-25">
                                    <div class="option-name text-right">
                                        <?php if(empty($tips_assembly['smt_pads_per_board'])){ ?>
                                        <span>SMT Pads per Board </span> 
                                        <?php }else{ ?>
                                        <span data-toggle="popover"  title="Additional Details<span class='fa fa-times'></span>" data-content="<?php echo $tips_assembly['smt_pads_per_board']; ?>" data-html="true" >SMT Pads per Board <span class="fa fa-question-circle"></span></span>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="xl-75">
                                    <div class="option option-text">
                                        <input type="text" name="c[smt_pads_per_board]" value="10" placeholder="SMT Pads per Board"  class="form-control" data-value-type='int' data-range='0,5000'>
                                    </div>
                                </div>
                            </div>
                            <div class='row product-option'>
                                <div class="xl-25">
                                    <div class="option-name text-right">
                                        <?php if(empty($tips_assembly['tht_pins_per_board'])){ ?>
                                        <span>THT Pins per Board </span> 
                                        <?php }else{ ?>
                                        <span data-toggle="popover"  title="Additional Details<span class='fa fa-times'></span>" data-content="<?php echo $tips_assembly['tht_pins_per_board']; ?>" data-html="true" >THT Pins per Board <span class="fa fa-question-circle"></span></span>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="xl-75">
                                    <div class="option option-text">
                                        <input type="text" name="c[tht_pins_per_board]" value="10" placeholder="THT Pins per Board"  class="form-control" data-value-type='int' data-range='0,5000'>
                                    </div>
                                </div>
                            </div>
                            <div class='row product-option'>
                                <div class="xl-25">
                                    <div class="option-name text-right">
                                        <?php if(empty($tips_assembly['no_lead_pads_per_board'])){ ?>
                                        <span>No-Lead Pads Per Board </span> 
                                        <?php }else{ ?>
                                        <span data-toggle="popover"  title="Additional Details<span class='fa fa-times'></span>" data-content="<?php echo $tips_assembly['no_lead_pads_per_board']; ?>" data-html="true" >No-Lead Pads Per Board <span class="fa fa-question-circle"></span></span>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="xl-75">
                                    <div class="option option-text">
                                        <input type="text" name="c[no_lead_pads_per_board]" value="10" placeholder="No-Lead Pads Per Board"  class="form-control" data-value-type='int' data-range='0,5000'>
                                    </div>
                                </div>
                            </div>
                            <div class='row product-option'>
                                <div class="xl-25">
                                    <div class="option-name text-right">
                                        <?php if(empty($tips_assembly['single_double_sided'])){ ?>
                                        <span>Single/Double-sided </span> 
                                        <?php }else{ ?>
                                        <span data-toggle="popover"  title="Additional Details<span class='fa fa-times'></span>" data-content="<?php echo $tips_assembly['single_double_sided']; ?>" data-html="true" >Single/Double-sided <span class="fa fa-question-circle"></span></span>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="xl-75">
                                    <div class="option  option-select">
                                        <select name="c[single_double_sided]" class="hidden">
                                            <?php foreach ($options_value['single_double_sided'] as $option_value) { ?>
                                            <option value="<?php echo $option_value['value']; ?>" <?php echo $option_value['selected']; ?> ><?php echo $option_value['name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class='row product-option'>
                                <div class="xl-25">
                                    <div class="option-name text-right">
                                        <?php if(empty($tips_assembly['fpcb_assembly'])){ ?>
                                        <span>FPCB Assembly </span> 
                                        <?php }else{ ?>
                                        <span data-toggle="popover"  title="Additional Details<span class='fa fa-times'></span>" data-content="<?php echo $tips_assembly['fpcb_assembly']; ?>" data-html="true" >FPCB Assembly <span class="fa fa-question-circle"></span></span>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="xl-75">
                                    <div class="option  option-select">
                                        <select name="c[fpcb_assembly]" class="hidden">
                                            <?php foreach ($options_value['fpcb_assembly'] as $option_value) { ?>
                                            <option value="<?php echo $option_value['value']; ?>" <?php echo $option_value['selected']; ?> ><?php echo $option_value['name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class='row product-option'>
                                <div class="xl-25">
                                    <div class="option-name text-right">
                                        <?php if(empty($tips_assembly['bga_pitch'])){ ?>
                                        <span>BGA Pitch </span> 
                                        <?php }else{ ?>
                                        <span data-toggle="popover"  title="Additional Details<span class='fa fa-times'></span>" data-content="<?php echo $tips_assembly['bga_pitch']; ?>" data-html="true" >BGA Pitch <span class="fa fa-question-circle"></span></span>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="xl-75">
                                    <div class="option  option-select">
                                        <select id='bga_pitch' name="c[bga_pitch]" class="hidden">
                                            <?php foreach ($options_value['bga_pitch'] as $option_value) { ?>
                                            <option value="<?php echo $option_value['value']; ?>" <?php echo $option_value['selected']; ?> ><?php echo $option_value['name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section class="section-flashing">
                        <h2 class="hover-pointer"><span class='section-mark text-pcb-blue'>D</span><span class="fa fa-caret-up text-pcb-blue"></span>PCB FLASHING AND TESTING</h2>
                        <div class="box-filler" >
                            <div class='row product-option'>
                                <div class="xl-25">
                                    <div class="option-name text-right">
                                        <?php if(empty($tips_assembly['short_circuit_testing'])){ ?>
                                        <span>Short Circuit Testing </span> 
                                        <?php }else{ ?>
                                        <span data-toggle="popover"  title="Additional Details<span class='fa fa-times'></span>" data-content="<?php echo $tips_assembly['short_circuit_testing']; ?>" data-html="true" >Short Circuit Testing <span class="fa fa-question-circle"></span></span>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="xl-75">
                                    <div class="option  option-select">
                                        <select name="d[short_circuit_testing]" class="hidden">
                                            <?php foreach ($options_value['short_circuit_testing'] as $option_value) { ?>
                                            <option value="<?php echo $option_value['value']; ?>" <?php echo $option_value['selected']; ?> ><?php echo $option_value['name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class='row product-option'>
                                <div class="xl-25">
                                    <div class="option-name text-right">
                                        <?php if(empty($tips_assembly['power_on_testing'])){ ?>
                                        <span>Power On Testing </span> 
                                        <?php }else{ ?>
                                        <span data-toggle="popover"  title="Additional Details<span class='fa fa-times'></span>" data-content="<?php echo $tips_assembly['power_on_testing']; ?>" data-html="true" >Power On Testing <span class="fa fa-question-circle"></span></span>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="xl-75">
                                    <div class="option  option-select">
                                        <select name="d[power_on_testing]" class="hidden">
                                            <?php foreach ($options_value['power_on_testing'] as $option_value) { ?>
                                            <option value="<?php echo $option_value['value']; ?>" <?php echo $option_value['selected']; ?> ><?php echo $option_value['name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class='row product-option'>
                                <div class="xl-25">
                                    <div class="option-name text-right">
                                        <?php if(empty($tips_assembly['firmware_flashing'])){ ?>
                                        <span>Firmware Flashing </span> 
                                        <?php }else{ ?>
                                        <span data-toggle="popover"  title="Additional Details<span class='fa fa-times'></span>" data-content="<?php echo $tips_assembly['firmware_flashing']; ?>" data-html="true" >Firmware Flashing <span class="fa fa-question-circle"></span></span>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="xl-75">
                                    <div class="option  option-select">
                                        <select name="d[firmware_flashing]" class="hidden">
                                            <?php foreach ($options_value['firmware_flashing'] as $option_value) { ?>
                                            <option value="<?php echo $option_value['value']; ?>" <?php echo $option_value['selected']; ?> ><?php echo $option_value['name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class='row product-option'>
                                <div class="xl-25">
                                    <div class="option-name text-right">
                                        <?php if(empty($tips_assembly['functional_testing'])){ ?>
                                        <span>Functional Testing </span> 
                                        <?php }else{ ?>
                                        <span data-toggle="popover"  title="Additional Details<span class='fa fa-times'></span>" data-content="<?php echo $tips_assembly['functional_testing']; ?>" data-html="true" >Functional Testing <span class="fa fa-question-circle"></span></span>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="xl-75">
                                    <div class="option  option-select">
                                        <select name="d[functional_testing]" class="hidden">
                                            <?php foreach ($options_value['functional_testing'] as $option_value) { ?>
                                            <option value="<?php echo $option_value['value']; ?>" <?php echo $option_value['selected']; ?> ><?php echo $option_value['name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class='row product-option'>
                                <div class="xl-25">
                                    <div class="option-name text-right">
                                        <?php if(empty($tips_assembly['design_tester'])){ ?>
                                        <span>Design Tester </span> 
                                        <?php }else{ ?>
                                        <span data-toggle="popover"  title="Additional Details<span class='fa fa-times'></span>" data-content="<?php echo $tips_assembly['design_tester']; ?>" data-html="true" >Design Tester <span class="fa fa-question-circle"></span></span>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="xl-75">
                                    <div class="option  option-select">
                                        <select name="d[design_tester]" class="hidden">
                                            <?php foreach ($options_value['design_tester'] as $option_value) { ?>
                                            <option value="<?php echo $option_value['value']; ?>" <?php echo $option_value['selected']; ?> ><?php echo $option_value['name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class='row product-option'>
                                <div class="xl-25">
                                    <div class="option-name text-right">
                                        <?php if(empty($tips_assembly['build_tester'])){ ?>
                                        <span>Build Tester </span> 
                                        <?php }else{ ?>
                                        <span data-toggle="popover"  title="Additional Details<span class='fa fa-times'></span>" data-content="<?php echo $tips_assembly['build_tester']; ?>" data-html="true" >Build Tester <span class="fa fa-question-circle"></span></span>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="xl-75">
                                    <div class="option  option-select">
                                        <select name="d[build_tester]" class="hidden">
                                            <?php foreach ($options_value['build_tester'] as $option_value) { ?>
                                            <option value="<?php echo $option_value['value']; ?>" <?php echo $option_value['selected']; ?> ><?php echo $option_value['name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class='row product-option'>
                                <div class="xl-25">
                                    <div class="option-name text-right">
                                        <?php if(empty($tips_assembly['x_ray'])){ ?>
                                        <span>X-Ray </span> 
                                        <?php }else{ ?>
                                        <span data-toggle="popover"  title="Additional Details<span class='fa fa-times'></span>" data-content="<?php echo $tips_assembly['x_ray']; ?>" data-html="true" >X-Ray <span class="fa fa-question-circle"></span></span>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="xl-75">
                                    <div class="option  option-select">
                                        <select name="d[x_ray]" class="hidden">
                                            <?php foreach ($options_value['x_ray'] as $option_value) { ?>
                                            <option value="<?php echo $option_value['value']; ?>" <?php echo $option_value['selected']; ?> ><?php echo $option_value['name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class='row product-option'>
                                <div class="xl-25">
                                    <div class="option-name text-right">
                                        <?php if(empty($tips_assembly['aoi'])){ ?>
                                        <span>AOI </span> 
                                        <?php }else{ ?>
                                        <span data-toggle="popover"  title="Additional Details<span class='fa fa-times'></span>" data-content="<?php echo $tips_assembly['aoi']; ?>" data-html="true" >AOI <span class="fa fa-question-circle"></span></span>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="xl-75">
                                    <div class="option  option-select">
                                        <select name="d[aoi]" class="hidden">
                                            <?php foreach ($options_value['aoi'] as $option_value) { ?>
                                            <option value="<?php echo $option_value['value']; ?>" <?php echo $option_value['selected']; ?> ><?php echo $option_value['name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class='row product-option'>
                                <div class="xl-25">
                                    <div class="option-name text-right">
                                        <?php if(empty($tips_assembly['estimate_of_testing_time'])){ ?>
                                        <span>Estimate of Testing Time </span> 
                                        <?php }else{ ?>
                                        <span data-toggle="popover"  title="Additional Details<span class='fa fa-times'></span>" data-content="<?php echo $tips_assembly['estimate_of_testing_time']; ?>" data-html="true" >Estimate of Testing Time <span class="fa fa-question-circle"></span></span>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="xl-75">
                                    <div class="option  option-text">
                                        <input id='estimate_of_testing_time' type="text" name="d[estimate_of_testing_time]" value="0" data-value-type='int' data-range='0,3600'  class="form-control">seconds per board
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section class="section-project-files" id='section-project-files'>
                        <h2 class=""><span class='section-mark'></span><span class="fa fa-caret-up text-pcb-blue"></span>PROJECT FILES</h2>
                        <div class="box-filler" style='padding: 40px;'>
                            <div class='project-files-row'>
                                <p>Please upload all relevant files compressed as one <b>Zip</b> or <b>RAR</b></p>
                                <p>You may want to download our templates to speed up the process. <a href="https://www.smart-prototyping.com/image/data/1_services/1_electrical/BOM%20Format.xlsx">Download Here</a></p>
                            </div>
                            <div class='project-files-row'>
                                <button type='button' class='btn btn-upload' id='button-upload-file'><i class="fa fa-upload" style="margin-right:10px"></i> UPLOAD YOUR FILE</button>
                                <input type='hidden' name='project_file'>
                            </div>
                            <div class='project-files-row'>
                                <p><b>If you have any additional requirements or comments, please send an email to scm@smart-prototyping.com or write your remarks below.</b></p>
                            </div>
                            <div>
                                <textarea class='form-control' rows="5" placeholder="Please leave comment here." name='comment'></textarea>
                            </div>
                        </div>
                    </section>

                </div>
            </div>
        </div>

        <!-- start 右侧summary -->
        <div class="xl-30" style='position: relative;'>
            <div class="row quote-panel">
                <div class="xl-100">
                    <div class="quote-panel-title">Estimated Cost</div>
                    <section class="section-quote section-quote-a">
                        <h3><span class="section-quote-mark">A</span>PCB Manufacturing <span class="section-sub-total">Unknown</span></h3>
                        <div class="text-right section-quote-tips" data-show='Smart Prototyping'>Please see separate order (Already paid)</div>
                        <div class="text-right section-quote-tips" data-show='Me'>PCB will be provided by customer</div>
                    </section>
                    <section class="section-quote section-quote-b">
                        <h3><span class="section-quote-mark">B</span>BOM Purchasing <span class="section-sub-total">Unknown</span></h3>
                        <div class="text-right" data-show='Smart Prototyping'>This price is based on your own estimation</div>
                        <div class="text-right" data-show='Me'>BOM will be provided by customer </div>
                    </section>
                    <section class="section-quote section-quote-c">
                        <h3><span class="section-quote-mark">C</span>PCB Assembling <span class="section-sub-total">Unknown</span></h3>
                        <div class="text-right"><span class='text-pcb-blue detail-switch'>OPTIONS <span class='fa fa-caret-up'></span></span></div>
                        <div class="quote-list-items">
                            <p data-value="manual_without_stencil">
                                <label class="expedited-option"><input type="radio" name="c_option_summary" value="manual_without_stencil" checked="">Manual without stencil<span class='mark-recommended'>(recommended)</span><span class="fa fa-question-circle"></span></label>
                                <span class="expedited-option-price">-.--</span>
                            </p>
                            <p data-value="manual_with_stencil">
                                <label class="expedited-option"><input type="radio" name="c_option_summary" value="manual_with_stencil" >Manual with stencil<span class="fa fa-question-circle"></span></label>
                                <span class="expedited-option-price">-.--</span>
                            </p>
                            <p data-value="automatic">
                                <label class="expedited-option"><input type="radio" name="c_option_summary" value="automatic" >Automatic<span class="fa fa-question-circle"></span></label>
                                <span class="expedited-option-price">-.--</span>
                            </p>
                            <input type='hidden' name='c_option_recommended' value='manual_without_stencil'>
                        </div>
                    </section>
                    <section class="section-quote section-quote-d">
                        <h3><span class="section-quote-mark">D</span>PCB Flashing & Testing <span class="section-sub-total">Unknown</span></h3>
                        <div class="text-right">This price is based on your own estimated time</div>
                    </section>
                    <div class='expression-row'>Estimated Total is A + B + C + D + Shipping</div>
                    <div class='summary-tips-section' data-show='Smart Prototyping'>Please note: PCB Manufacturing [A] has already been paid, therefore is not included in the total you should expect to pay.</div>
                    <div class='summary-tips-section'>The Numbers above are a non-binding estimate of your project. The binding quotation will be sent to you after you submitted your inquiry and we have reviewed all project details.</div>
                    <div class="submit-btn-box">
                        <button class="btn-submit-pcb text-pcb-blue" type="button" id="btn-submit-inquiry">SUBMIT INQUIRY</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- end 右侧summary -->

    </div>
    <div class='row assembly-footer'><a href="https://www.smart-prototyping.com/PCB-Prototyping.html"><img src='/image/kp_productPcb/assembly_footer_banner.jpg' border="0" class='assembly-footer-banner'></a></div>
    <div class='row assembly-footer-sections'>
        <section class="">
            <h2 class="hover-pointer"><span class='section-mark'></span><span class="fa fa-caret-down text-pcb-blue"></span>PCB ASSEMBLY CAPABILITY</h2>
            <div class="box-filler" style='padding: 40px;display: none;'>
			
			<table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#999999">
  <tr>
    <td style="padding-left:10px;">Assembly Options</td>
    <td style="padding-left:10px;">SMT (Surface Mount Technology)  <br>
    THT (Through Hole Technology)  <br>
    SMT and THT mixed  <br>
    Single Side Assembly  <br>
    Double Side Assembly  <br>
    Manual Assembly (Without Stencil)  <br>
    Manual with Stencil Assembly  <br>
    Automatic Assembly (Pick and Place machine)</td>
  </tr>
  <tr>
    <td style="padding-left:10px;">Solder Types</td>
    <td style="padding-left:10px;">Leaded  <br>
    Lead Free (ROHS Compliant)  <br>
    No-Clean Flux is standard</td>
  </tr>
  <tr>
    <td style="padding-left:10px;">Volume</td>
    <td style="padding-left:10px;">Our minimum order quantity for PCBA is 1.   <br>
    We are capable to handle up to 1 million pcs PCBA.</td>
  </tr>
  <tr>
    <td style="padding-left:10px;">Part Types</td>
    <td style="padding-left:10px;">Passive Components as small as 0201 package  <br>
    BGA (Ball Grid Arrays) 0.3mm Pitch with X-ray Testing  <br>
    Fine Pitch Components as small as 0.3mm pitch  <br>
    All THT componrnts  <br>
    Accessories like cable, machine parts</td>
  </tr>
  <tr>
    <td style="padding-left:10px;">Component Packaging</td>
    <td style="padding-left:10px;">We accept parts in Reel, Cut Tape, Tube, Tray, Loose Parts and Bulk.   <br>
    Short-Run Prototype cut tape must be continuous and 12 in. or longer.</td>
  </tr>
  <tr>
    <td style="padding-left:10px;">Board Dimension</td>
    <td style="padding-left:10px;">Min Board Size (L x W x H): 50mm x 40mm x 0.38mm  <br>
    Max Board Size (L x W x H): 600mm x 400mm x 4.2mm<br>  
    Assembled as single unit or panels (PCBs with sizes smaller than 50mm*40mm will be assembled as panels)</td>
  </tr>
  <tr>
    <td style="padding-left:10px;">Board Shape</td>
    <td style="padding-left:10px;">Rectangular  <br>
    Round  <br>
    Slots and Cut outs  <br>
    Complex and Irregular (You need panelize the boards in an array and add break-away rails on the longer paralleled edges)</td>
  </tr>
  <tr>
    <td style="padding-left:10px;">PCB Types for Assembly</td>
    <td style="padding-left:10px;">Rigid PCB   <br>
    Aluminum PCB  <br>
    Flex PCB  <br>
    Rigid-Flex PCBs</td>
  </tr>
  <tr>
    <td style="padding-left:10px;">Lead Time</td>
    <td style="padding-left:10px;">From 8 hours to 48 hours when PCBs, components and relevant files (PCB files, Centroid file, BOM, PCBA Placement Drawing) are ready.</td>
  </tr>
  <tr>
    <td style="padding-left:10px;">Test Types</td>
    <td style="padding-left:10px;">MOI (Manual Optical Inspection)  <br>
    AOI (Automated Optical Inspection)  <br>
    X-ray Inspection  <br>
    Short Circuit Testing  <br>
    Power On Testing  <br>
    Functional Testing  <br>
    Design/Build Tester</td>
  </tr>
  <tr>
    <td style="padding-left:10px;">Supported File Formats</td>
    <td style="padding-left:10px;">ODB++, CAD ASCII, IPC-2581  <br>
    BOM: .xls, .csv, .xlsx  <br>
    Gerber (RS-274X)  <br>
    Centroid (XY, Pick-n-Place)</td>
  </tr>
</table>
			
			</div>
        </section>
        <section class="">
            <h2 class="hover-pointer"><span class='section-mark'></span><span class="fa fa-caret-down text-pcb-blue"></span>PCB ASSEMBLY FAQ</h2>
            <div class="box-filler" style='padding: 40px;display: none;'>
			<p>&nbsp;</p>
<p><strong>Q1: What do I need to send for a turnkey PCB Assembly quotation and order?</strong></p>
<p>
  A1: BOM (Bill of Materials) as an Excel, CSV or OpenOffice table with clear defined identifiers for all parts (please download our BOM format)</p>
<ul><li> Gerber files</li>
  <li> Parts placement drawing</li>
  <li> Centroid data file (This is the machine file which should include X, Y, Theta (Rotation), Side of Board (top or bottom), and Reference Designator. This is sometimes called XYRS data (X,Y, Rotation, Side), pick and place data, or simply XY data. .XLS or .CSV formats are preferred. )</li>
  <li> Other requirements or assembly instructions if applicable</li>
</ul>
  <p>&nbsp;</p>
<p><strong>Q2: What is your minimum PCB Assembly order quantity?</strong></p>
<p>
  A2: Our minimum PCB Assembly order quantity is 1. However, our minimum PCB manufacturing quantity is 5, which means you need to order at least 5 PCBs even if you only need 1 PCB to be assembled. We will delivery assembled PCBs, unused bare PCBs and unused components to you.</p>
<p>&nbsp;</p>
<p><strong>Q3: What is the lead time for a turnkey PCB Assembly order?</strong></p>
<p>
  A3: The final lead time is PCB/Stencil manufacturing time + parts delivery time + PCBA time + firmware flashing time (if requested) + functional test time (if requested). Our sales person estimates the lead time for you while preparing an official and detailed quotation. If you need expedited PCBA service, please inform us your expected date to receive your order.</p>
<p>&nbsp;</p>
<p><strong>Q4: What kind of tests do you do after PCBA?</strong></p>
<p>
  A4: We do visual inspection, basic short circuit test and power-on test (input voltage and expected current need to be offered by clients). We strongly recommend you to offer functional test procedures to ensure quality before shipment.</p>
<p>&nbsp;</p>
<p><strong>Q5: Can you solder BGA components? </strong></p>
<p>
  A5: Yes, we can solder BGAs; we also do X-Ray tests for BGA soldering.</p>
<p>&nbsp;</p>
<p><strong>Q6: Can you do double-sided PCBA?</strong></p>
<p>
  A6: Yes, we can.</p>
<p>&nbsp;</p>
<p><strong>Q7: I'd like to know if you can produce and do PCBA for flexible circuit boards.</strong></p>
<p>
  A7: Yes, we are able to produce and do PCBA for flexible circuit boards.</p>
<p>&nbsp;</p>
<p><strong>Q8: How do you source and order components?</strong></p>
<p>
  A8: Firstly, we source components from our local reliable vendors or distributors to get reasonable prices, guaranteed quality and lead time. If some of the components have to be ordered abroad, we will source and order components from DigiKey, Mouser, Future, Master or Farnell through our licensed agent.</p>
<p>&nbsp;</p>
<p><strong>Q9: Can you help me reduce BOM cost by suggesting cheaper parts with identical function?</strong></p>
<p>
  A9: Yes, we would like to do this for you if you accept alternative parts from different manufacturers. Please clearly mark them in the BOM and inform our sales person. Besides, additional cost might be charged after we evaluate the workload.</p>
<p>&nbsp;</p>
<p><strong>Q10: Can I specify the manufacturers or suppliers for components? </strong></p>
<p>
  A10: Yes, please clearly mark them in the BOM.</p>
<p>&nbsp;</p>
<p><strong>Q11: Can I send you some or all components for my PCB Assembly order?</strong></p>
<p>
  A11: Yes. However, before you send them to us, please contact us with full details of shipping information, quantities and part numbers of components and declared value for our import customs.</p>
<p>&nbsp;</p>
<p><strong>Q12: What do you do with unused parts?</strong></p>
<p>
  A12: We return all unused parts to you whether you supply parts or we supply parts. We can also keep all unused parts for you to repeat orders in the future.</p>
<p>&nbsp;</p>
<p><strong>Q13: Will you ship the used stencil to me after PCBA?</strong></p>
<p>
  A13: Yes, if you request. We can also keep the stencil for you for maximum 6 months. After 6 months, we will clear the stencils out of our storehouse.</p>
<p>&nbsp;</p>
<p></p>


			
			</div>
        </section>
    </div>
</div>
<script type="text/javascript">
    $('input.shipping-company-a').autocomplete({
        'source': function (request, response) {
            $.ajax({
                url: 'index.php?route=product/product_assembly/autocomplete&filter_name=' + encodeURIComponent(request),
                dataType: 'json',
                success: function (json) {
                    response($.map(json, function (item) {
                        return {
                            label: item['name'],
                            value: item['name']
                        };
                    }));
                }
            });
        },
        'select': function (item) {
            $('input.shipping-company-a').val(item['label']);
        }
    });
    
    $('input.shipping-company-b').autocomplete({
        'source': function (request, response) {
            $.ajax({
                url: 'index.php?route=product/product_assembly/autocomplete&filter_name=' + encodeURIComponent(request),
                dataType: 'json',
                success: function (json) {
                    response($.map(json, function (item) {
                        return {
                            label: item['name'],
                            value: item['name']
                        };
                    }));
                }
            });
        },
        'select': function (item) {
            $('input.shipping-company-b').val(item['label']);
        }
    });
    
    <?php if($this->customer->isLogged()){ ?>
    $('input[name="a[smart_file_name]"]').autocomplete({
        'source': function (request, response) {
            var order_id = $('[name="a[smart_order_id]"]').val();
            if(order_id > 0 ){
                $.ajax({
                    url: 'index.php?route=product/product_assembly/autocompleteOrderFiles&order_id=' + order_id + '&filter_name=' + encodeURIComponent(request),
                    dataType: 'json',
                    success: function (json) {
                        response($.map(json, function (item) {
                            return {
                                label: item['name'],
                                value: item['value']
                            };
                        }));
                    }
                });
            }else{
                $('.product-option[data-section="A"]').data('product-total', 'Unknown');
                $('.section-manufacturing').find('.option-group-name[data-value="Smart Prototyping"]').trigger('click');
            }
        },
        'select': function (item) {
            $('input[name="a[smart_file_name]"]').val(item['label']);
            $('.product-option[data-section="A"]').data('product-total', item['value']);
            $('.section-manufacturing').find('.option-group-name[data-value="Smart Prototyping"]').trigger('click');
        }
    });
    <?php } ?>
    
</script>
<?php echo $footer; ?>
