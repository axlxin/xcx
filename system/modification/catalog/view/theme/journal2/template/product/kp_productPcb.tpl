<?php echo $header; ?>
<?php 
require(DIR_CONFIG.'kp_productPcb_config.php'); 

function getOPtionByProductOptionId($options, $product_option_id){
    foreach ($options as $option_index => $option){
        if($product_option_id==$option['product_option_id']){
            return $option;
        }
    }
    return null;
}
?>
<div id="container" class="container bg-pcb-blue">

    <div id="product" class="row">
        <div class="xl-70">
            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
            <div class="row product-options">
                <div class="xl-100">
                    <section class="section-pcb">
                        <h3><span class="fa fa-cube"></span>&nbsp;PCB</h3>
                        <div class="box-filler">
                            <?php foreach ($options as $option_index => $option) { ?>
                                <?php if(!isset($config_PCB[$option['product_option_id']])){continue;} ?>
                                
                                <?php 
                                    if(false!==strpos($option['name'], "Dimension")){ 
                                        if(!isset($GLOBALS["pcb_order_dimension"]) && false!==strpos($options[$option_index+1]['name'], "Dimension")){
                                            $d_nextOption = $options[$option_index+1];
                                ?>
                                            <div class='row product-option'>
                                                <div class="xl-25">
                                                    <div class="option-name text-right">
                                                        <?php if($tips=($config_PCB[$option['product_option_id']]['tips'])){ ?>
                                                        <span data-toggle="popover"  title="Additional Details<span class='fa fa-times'></span>" data-content="<?php echo $tips; ?>" data-html="true" >Dimension <span class="fa fa-question-circle"></span></span>
                                                        <?php }else{ echo "Dimension"; }?>
                                                    </div>   
                                                </div>
                                                <div class="xl-75">
                                                    <div class="option option-<?php echo $option['type']; ?>">
                                                         <input style="display: none;" type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['value']; ?>" placeholder="length" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control" />
                                                        <input style="display: none;"  type="text" name="option[<?php echo $d_nextOption['product_option_id']; ?>]" value="<?php echo $d_nextOption['value']; ?>" placeholder="width" id="input-option<?php echo $d_nextOption['product_option_id']; ?>" class="form-control" /> 
                                                        <input type="text" name="slength" value="" placeholder="length" id="slength" class="form-control" /> &times;
                                                        <input type="text" name="swidth" value="" placeholder="width" id="swidth" class="form-control" />  
                                                        <select name="unitselect"   onchange="unitcalculation()"  style="padding: 3px;margin: 1px;">
                                                            <option value ="mm">mm</option>
                                                            <option value ="inch">inch</option>
                                                            <option value="mil">mil</option>
                                                       </select>
                                                       <span  id="equal" >(equals <span id="llength"> </span>&times;<span   id="lwidth"></span>mm)</span>
                                                    </div>
                                                </div>
                                                <script type="text/javascript">
                                                    $(function(){
                                                        $("input[name='option[<?php echo $option['product_option_id']; ?>]'], input[name='option[<?php echo $d_nextOption['product_option_id']; ?>]']").blur(function(){
                                                            
                                                             var val = parseFloat($(this).val());
                                                           
                                                             val = val.toFixed(2);
                                                            val = (val>500) ? 500 : val;
                                                            val = (val<10) ? 10 : val;
                                                            $(this).val(isNaN(val) ? 0 : val).trigger("keyup");
                                                            unitcalculation();
                                                        });
                                                    });
                                                    function unitcalculation(){
                                                        var flength = $("input[name='option[<?php echo $option['product_option_id']; ?>]']").val();
                                                        var fwidth = $("input[name='option[<?php echo $d_nextOption['product_option_id']; ?>]']").val();
                                                        var unitselect = $("select[name='unitselect']").val();
                                                        if (unitselect == 'mm') {
                                                            var slength = (1 * flength).toFixed(2);
                                                            var swidth = (1 * fwidth).toFixed(2);
                                                            $("#slength").attr("value",slength);
                                                            $("#swidth").attr("value",swidth);
                                                            $("#equal").hide();
                                                        }else if(unitselect == 'inch'){
                                                           
                                                            var slength = (flength/25.4).toFixed(2);
                                                            var swidth = (fwidth/25.4).toFixed(2);
                                                            $("#slength").attr("value",slength);
                                                            $("#swidth").attr("value",swidth);
                                                            $("#equal").show();
                                                            $("#llength").html(flength);
                                                            $("#lwidth").html(fwidth);
                                                        }else{
                                                             var slength = (flength/0.0254).toFixed(2);
                                                            var swidth = (fwidth/0.0254).toFixed(2);
                                                            $("#slength").attr("value",slength);
                                                            $("#swidth").attr("value",swidth);
                                                            $("#equal").show();
                                                            $("#llength").html(flength);
                                                            $("#lwidth").html(fwidth);
                                                        }
                                                    }
                                                    function antiunitcalculation(){
                                                        var flength = $("input[name='slength']").val();
                                                        var fwidth = $("input[name='swidth']").val();
                                                        var unitselect = $("select[name='unitselect']").val();
                                                        if (unitselect == 'mm') {
                                                            var slength =  (flength/1).toFixed(2);
                                                            var swidth =  (fwidth/1).toFixed(2);
                                                            $("input[name='option[<?php echo $option['product_option_id']; ?>]']").attr("value",slength);
                                                            $("input[name='option[<?php echo $d_nextOption['product_option_id']; ?>]']").attr("value",swidth);
                                                            $("input[name='option[<?php echo $option['product_option_id']; ?>]'], input[name='option[<?php echo $d_nextOption['product_option_id']; ?>]']").trigger("keyup");
                                                            $("#llength").html(slength);
                                                            $("#lwidth").html(swidth);
                                                        }else if (unitselect == 'inch') {
                                                            var slength =  (flength*25.4).toFixed(2);
                                                            var swidth =  (fwidth*25.4).toFixed(2);
                                                            $("input[name='option[<?php echo $option['product_option_id']; ?>]']").attr("value",slength);
                                                            $("input[name='option[<?php echo $d_nextOption['product_option_id']; ?>]']").attr("value",swidth);
                                                            $("input[name='option[<?php echo $option['product_option_id']; ?>]'], input[name='option[<?php echo $d_nextOption['product_option_id']; ?>]']").trigger("keyup");
                                                            $("#llength").html(slength);
                                                            $("#lwidth").html(swidth);

                                                        }else{
                                                            var slength =  (flength*0.0254).toFixed(2);
                                                            var swidth =  (fwidth*0.0254).toFixed(2);
                                                            $("input[name='option[<?php echo $option['product_option_id']; ?>]']").attr("value",slength);
                                                            $("input[name='option[<?php echo $d_nextOption['product_option_id']; ?>]']").attr("value",swidth);
                                                            $("input[name='option[<?php echo $option['product_option_id']; ?>]'], input[name='option[<?php echo $d_nextOption['product_option_id']; ?>]']").trigger("keyup");
                                                            $("#llength").html(slength);
                                                            $("#lwidth").html(swidth);

                                                        }


                                                    }
                                                    $(function(){
                                                        $("input[name='slength'], input[name='swidth']").blur(function(){
                                                            
                                                            var val =parseFloat($(this).val());
                                                           val = val.toFixed(2);
                                                            var unitselect = $("select[name='unitselect']").val();

                                                         if (unitselect == 'mm') {
                                                              val = (val>500) ? 500 : val;
                                                            val = (val<10) ? 10 : val;
                                                         }else if (unitselect == 'inch') {
                                                            val = (val>19.7) ? 19.7 : val;
                                                            val = (val<0.394) ? 0.39 : val;

                                                        }else{
                                                             val = (val>20000) ? 20000 : val;
                                                            val = (val<400) ? 400 : val;

                                                        }
                                                            
                                                            $(this).val(isNaN(val) ? 0 : val).trigger("keyup");
                                                            antiunitcalculation();
                                                        });
                                                    });
                                                    unitcalculation();
                                                </script>
                                            </div>
                                <?php 
                                            $GLOBALS["pcb_order_dimension"] = 1;
                                            continue;
                                        }else{
                                            continue;
                                        }
                                    }
                                ?>
                                
                                <div class='row product-option'>
                                    <div class="xl-25">
                                        <div class="option-name text-right" data-option-title-name="<?php echo $option['name']; ?>">
                                            <?php if($tips=($config_PCB[$option['product_option_id']]['tips'])){ ?>
                                            <span data-toggle="popover"  title="Additional Details<span class='fa fa-times'></span>" data-content="<?php echo $tips; ?>" ><?php echo $option['name']; ?> <span class="fa fa-question-circle"></span></span>
                                            <?php }else{ echo $option['name']; }?>
                                        </div>
                                    </div>
                                    <div class="xl-75">
                                        <?php if ($option['type'] == 'select') { ?>
                                        <div class="option  option-<?php echo $option['type']; ?>" <?php if($option['name']=='Panelized PCBs'){echo "style='display: inline-block;'";} ?> >
                                            <select name="option[<?php echo $option['product_option_id']; ?>]" id="input-option<?php echo $option['product_option_id']; ?>" class="hidden">
                                                <option value=""><?php echo $text_select; ?></option>
                                                <?php
                                                    $st_flag = true;
                                                    foreach ($option['product_option_value'] as $option_value) {
                                                        $selected = "";
                                                        if ( (int)$option_value['if_default'] && $st_flag ):
                                                            $st_flag = false;
                                                            $selected = "selected";
                                                        endif;
                                                ?>
                                                <option value="<?php echo $option_value['product_option_value_id']; ?>" <?php echo $selected; ?> ><?php echo $option_value['name']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                            <?php 
                                            if($option['name']=='Panelized PCBs'){ 
                                                $option_PPRows = getOPtionByProductOptionId($options, $config_Panelized_PCBs['rows']);
                                                $option_PPColums = getOPtionByProductOptionId($options, $config_Panelized_PCBs['colums']);
                                            ?>
                                            <div class="option option-text pp-required-option" data-parent-id='input-option<?php echo $option["product_option_id"]; ?>'>
                                                    <input type="text" name="option[<?php echo $config_Panelized_PCBs['rows']; ?>]" value="<?php echo $option_PPRows['value']; ?>" placeholder="Rows" id="input-option<?php echo $option_PPRows['product_option_id']; ?>" class="form-control pp-mark pp-rows-mark" /> &times;
                                                    <input type="text" name="option[<?php echo $config_Panelized_PCBs['colums']; ?>]" value="<?php echo $option_PPColums['value']; ?>" placeholder="Columns" id="input-option<?php echo $option_PPColums['product_option_id']; ?>" class="form-control pp-mark pp-colums-mark" />
                                                </div>
                                            <?php } ?>
                                        <?php }elseif($option['type'] == 'text'){ ?>
                                            <div class="option option-<?php echo $option['type']; ?>">
                                                <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['value']; ?>" placeholder="<?php echo $option['name']; ?>" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control" />
                                            </div>
                                        <?php } elseif ($option['type'] == 'radio') { ?>
                                            <div class="option option-<?php echo $option['type']; ?> option-pcb-qty">
                                                <div id="input-option<?php echo $option['product_option_id']; ?>" class="radio-list bg-pcb-blue close hidden">
                                                    <div class="text-right"><span class="fa fa-times btn-close-radio-list" style="font-size:18px;cursor: pointer"></span></div>
                                                    <?php 
                                                        $st_flag = true;
                                                        $default_text = "";
                                                        foreach ($option['product_option_value'] as $option_value) {
                                                            $checked = "";
                                                              if ( (int)$option_value['if_default'] && $st_flag ):
                                                                  $st_flag = false;
                                                                  $checked = "checked";
                                                                  $default_text = $option_value['name'];
                                                              endif;
                                                    ?>
                                                    <div class="radio">
                                                        <label><span class="fa <?php echo empty($checked) ? 'fa-square' : 'fa-check-square';?> "></span>
                                                            <input type="radio" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option_value['product_option_value_id']; ?>" <?php echo $checked;?> />
                                                            <span class='option-value-text'><?php echo $option_value['name']; ?></span>
                                                        </label>
                                                    </div>
                                                    <?php } ?>
                                                </div>
                                                <span class="radio-result"><?php echo $default_text; ?></span>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </section>
                    <section class="section-special-requirements">
                        <h3 class="hover-pointer"><span class="fa fa-caret-down text-pcb-blue"></span>&nbsp;SPECIAL REQUIREMENTS</h3>
                        <div class="box-filler" style="display: none">
                            <?php foreach ($options as $option) { ?>
                                <?php if(!isset($config_special[$option['product_option_id']])){continue;} ?>
                                <div class='row product-option'>
                                    <div class="xl-25">
                                        <div class="option-name text-right">
                                            <?php if($tips=($config_special[$option['product_option_id']]['tips'])){ ?>
                                            <span data-toggle="popover"  title="Additional Details<span class='fa fa-times'></span>" data-content="<?php echo $tips; ?>" ><?php echo $option['name']; ?> <span class="fa fa-question-circle"></span></span>
                                            <?php }else{ echo $option['name']; }?>
                                        </div> 
                                    </div>
                                    <div class="xl-75">
                                        <div class="option  option-<?php echo $option['type']; ?>">
                                            <select name="option[<?php echo $option['product_option_id']; ?>]" id="input-option<?php echo $option['product_option_id']; ?>" class="hidden">
                                                <option value=""><?php echo $text_select; ?></option>
                                                <?php 
                                                    $st_flag = true;
                                                    foreach ($option['product_option_value'] as $option_value) {
                                                        $selected = "";
                                                        if ( (int)$option_value['if_default'] && $st_flag ):
                                                            $st_flag = false;
                                                            $selected = "selected";
                                                        endif;
                                                ?>
                                                <option value="<?php echo $option_value['product_option_value_id']; ?>" <?php echo $selected; ?> ><?php echo $option_value['name']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </section>
                    <section class="section-pcb-stencil">
                        <h3 class="hover-pointer"><span class="fa fa-caret-down text-pcb-blue"></span>&nbsp;PCB STENCIL</h3>
                        <div class="box-filler" style="display: none">
                            <?php foreach ($options as $option) { ?>
                                <?php if(!isset($config_stencil[$option['product_option_id']])){continue;} ?>
                                <div class='row product-option'>
                                    <div class="xl-25">
                                        <div class="option-name text-right">
                                            <?php if($tips=($config_stencil[$option['product_option_id']]['tips'])){ ?>
                                            <span data-toggle="popover"  title="Additional Details<span class='fa fa-times'></span>" data-content="<?php echo $tips; ?>" ><?php echo $option['name']; ?> <span class="fa fa-question-circle"></span></span>
                                            <?php }else{ echo $option['name']; }?>
                                        </div>
                                    </div>
                                    <div class="xl-75">
                                        <?php if ($option['type']=='select') { ?>
                                            <?php if($config_stencil[$option['product_option_id']]['type']!='drop-select'){ ?>
                                                <div class="option  option-<?php echo $option['type']; ?>">
                                                    <select name="option[<?php echo $option['product_option_id']; ?>]" id="input-option<?php echo $option['product_option_id']; ?>" class="hidden">
                                                        <option value=""><?php echo $text_select; ?></option>
                                                        <?php 
                                                            $st_flag = true;
                                                            foreach ($option['product_option_value'] as $option_value) {
                                                                $selected = "";
                                                                if ( (int)$option_value['if_default'] && $st_flag ):
                                                                    $st_flag = false;
                                                                    $selected = "selected";
                                                                endif;
                                                        ?>
                                                        <option value="<?php echo $option_value['product_option_value_id']; ?>" <?php echo $selected; ?> ><?php echo $option_value['name']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            <?php }else{ ?>
                                                <div class="option  option-drop-select">
                                                    <select name="option[<?php echo $option['product_option_id']; ?>]" id="input-option<?php echo $option['product_option_id']; ?>">
                                                        <option value=""><?php echo $text_select; ?></option>
                                                        <?php
                                                            $st_flag = true;
                                                            foreach ($option['product_option_value'] as $option_value) {
                                                                $selected = "";
                                                                if ( (int)$option_value['if_default'] && $st_flag ):
                                                                    $st_flag = false;
                                                                    $selected = "selected";
                                                                endif;
                                                        ?>
                                                        <option value="<?php echo $option_value['product_option_value_id']; ?>" <?php echo $selected; ?> ><?php echo $option_value['name']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            <?php } ?>
                                        <?php } elseif ($option['type'] == 'radio') { ?>
                                            <div class="option option-<?php echo $option['type']; ?>">
                                                <div id="input-option<?php echo $option['product_option_id']; ?>" class="radio-list bg-pcb-blue close hidden">
                                                    <div class="text-right"><span class="fa fa-times btn-close-radio-list" style="font-size:18px;cursor: pointer"></span></div>
                                                    <?php 
                                                        $st_flag = true;
                                                        $default_text = "";
                                                        foreach ($option['product_option_value'] as $option_value) {
                                                            $checked = "";
                                                              if ( (int)$option_value['if_default'] && $st_flag ):
                                                                  $st_flag = false;
                                                                  $checked = "checked";
                                                                  $default_text = $option_value['name'];
                                                              endif;
                                                    ?>
                                                    <div class="radio">
                                                        <label><span class="fa <?php echo empty($checked) ? 'fa-square' : 'fa-check-square';?> "></span>
                                                            <input type="radio" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option_value['product_option_value_id']; ?>" <?php echo $checked;?> />
                                                            <span class='option-value-text'><?php echo $option_value['name']; ?></span>
                                                        </label>
                                                    </div>
                                                    <?php } ?>
                                                </div>
                                                <span class="radio-result"><?php echo $default_text; ?></span>
                                            </div>
                                        <?php }elseif($option['type'] == 'text'){ ?>
                                        <div class="option option-<?php echo $option['type']; ?>">
                                            <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['value']; ?>" placeholder="<?php echo $option['name']; ?>" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control" />
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </section>
                    <section class="section-gerber-file">
                        <h3><span class="fa fa-cube"></span>&nbsp;GERBER FILE</h3>
                        <div class="box-filler">
                            <?php foreach ($options as $option) { ?>
                                <?php if(!isset($config_gerber[$option['product_option_id']])){continue;} ?>
                                <?php if ($option['type'] == 'file') { ?>
                                    <div class='row product-option'>
                                        <div class="xl-100">
                                            <div class="option form-group" style="padding-left: 100px">
                                                <button type="button" id="button-upload<?php echo $option['product_option_id']; ?>" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-upload"><i class="fa fa-upload" style="margin-right:10px"></i> UPLOAD YOUR GERBER FILE</button>
                                                <span class="" style="vertical-align: bottom;">(zip or rar, max. 4 Mb)</span>
                                                <input type="hidden" name="option[<?php echo $option['product_option_id']; ?>]" value="" id="input-option<?php echo $option['product_option_id']; ?>" />
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>

                                <?php if($option['type'] == 'textarea'){ ?>
                                    <div class="row">
                                        <div class="xl-100">
                                            <div class="remark-tips form-group">If you have any other special requirements, please send email to <a href="mailto:pcb@smart-prototyping.com?subject=PCB%20Prototyping&body=Dear%20Prototyping%20Team%2C%0A%0AI%20need%3A%0A1.%20...%0A2.%20...%0A3.%20...%0A%0APlease%20find%20attached%20all%20relevant%20files%20and%20send%20me%20a%20quotation%20as%20soon%20as%20possible.%0A%0AThanks%2C%0A%3CYour%20Customer%3E">pcb@smart-prototyping.com</a>.</div>
                                        </div>
                                    </div>
                                    <div class='row product-option'>
                                        <div class="xl-100">
                                            <div class="option form-group" style="padding-left: 100px">
                                                <span class="option-name" style="vertical-align: top;"><?php echo $option['name']; ?></span>
                                                <textarea name="option[<?php echo $option['product_option_id']; ?>]" rows="5" placeholder="Please leave comment here." id="input-option<?php echo $option['product_option_id']; ?>" class="form-control"><?php echo $option['value']; ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            <?php } ?>
                        </div>
                    </section>
                    <section class="section-production-capability">
                        <h3 class="hover-pointer"><span class="fa fa-caret-down text-pcb-blue"></span>&nbsp;SPECS, DRC, PRODUCTION CAPABILITY</h3>
                        <div class="box-filler" style="display: none">
						<p> <strong>Downloads:</strong></p>
<ul>
  <li> <a target="_blank" href="https://www.smart-prototyping.com/image/data/1_services/1_electrical/100201%20-%20Gerber%20File-Name%20Definition.rar">Gerber File-Name Definition</a></li>
  <li> <a href="https://www.smart-prototyping.com/image/data/1_services/1_electrical/Smart-Prototyping_2Layer_Gerber%20with%20name%20layer.rar">2 Layer PCB CAM Job File</a></li>
  <li> <a href="https://www.smart-prototyping.com/image/data/1_services/1_electrical/Smart-Prootyping-Gerber_Generater_4-layer_1-2-15-16.rar">4 Layer PCB CAM Job File</a></li>
  <li> <a target="_blank" href="https://www.smart-prototyping.com/image/data/1_services/1_electrical/Smart%20Prototyping%20Eagle%20Rule%202016-06-12.rar">2 Layer PCB Design Rules for Eagle</a></li>
  <li><a href="https://www.smart-prototyping.com/image/data/1_services/1_electrical/Eagle%20Rule_4layer.rar" target="_blank">4 Layer PCB Design Rules for Eagle</a><br />
  </li>
  <li> <a target="_blank" href="https://www.smart-prototyping.com/image/data/1_services/1_electrical/Altium%20designer%20rules.rar">Design Rules for Altium PCB</a></li>
</ul>
<p><strong>Link:</strong> <a href="https://www.smart-prototyping.com/index.php?route=information/information&amp;information_id=9" target="_blank">PCB fabrication FAQ</a></p>
<p>&nbsp</p>
                            <table class="table-production-capability" cellspacing="0" cellpadding="0">
                                <tr align="center" style ="color: #FFFFFF;">
                                    <td width="15%" bgcolor="#2196F3"><strong>ITEMS</strong></td>
                                    <td width="15%" bgcolor="#2196F3"><strong>PRODUCTION CAPABILITY</strong></td>
                                    <td width="70%" bgcolor="#2196F3"><strong>DESCRIPTION</strong></td>
                                </tr>
                                <tr>
                                    <td bgcolor="#EEEEEE"><p>Max. Layer</p>    </td>
                                    <td bgcolor="#EEEEEE">16 Layers</td>
                                    <td bgcolor="#EEEEEE" style="text-align: left;">    FR4 accept 1 - 16 layers<br />
                                        Aluminium Base PCB: 1 layer<br />
                                        Flexible PCB: 1-2 layers<br />
                                        Rigid-Flexible PCB: 4 + 2 layers</td>
                                </tr>
                                <tr bgcolor="#FFFFFF">
                                    <td>Material Type</td>
                                    <td>4 types</td>
                                    <td style="text-align: left;">FR-4, Aluminium Base PCB, Flexible PCB, Rigid-Flexible PCB</td>
                                </tr>
                                <tr>
                                    <td bgcolor="#EEEEEE">Max. Dimension </td>
                                    <td bgcolor="#EEEEEE">500 x 500 mm</td>
                                    <td bgcolor="#EEEEEE" style="text-align: left;">The online quotation system only accepts up to 500 x 500 mm. If you require a bigger dimension, please contact us</td>
                                </tr>
                                <tr bgcolor="#FFFFFF">
                                    <td>Min. Line Width / Space </td>
                                    <td>4/4 mil</td>
                                    <td style="text-align: left;">4/4 mil, 5/5 mil, 6/6 mil (finished copper thickness 1 oz), 10/10 mil (finished copper thickness 2 oz), 15/15 mil (finished copper thickness 3 oz). We strongly suggest increasing the trace width and spacing for 2 and 3 oz. copper thickness</td>
                                </tr>
                                <tr>
                                    <td bgcolor="#EEEEEE">Min. Hole Size</td>
                                    <td bgcolor="#EEEEEE">0.2 mm</td>
                                    <td bgcolor="#EEEEEE" style="text-align: left;">Minimum mechanical via  diameter is 0.25 mm. Minimum laser via  diameter is 0.20 mm</td>
                                </tr>
                                <tr bgcolor="#FFFFFF">
                                    <td>Hole Tolerance (Mechanical Drilling)</td>
                                    <td>&#177;0.07 mm</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr bgcolor="#EEEEEE">
                                    <td>Hole Tolerance (Laser Drilling)</td>
                                    <td>&#177;0.01 mm</td>
                                    <td style="text-align: left;">The tolerance of laser drilling hole is &#177;0.01mm</td>
                                </tr>
                                <tr bgcolor="#FFFFFF">
                                    <td>Via Single-side Annular Ring</td>
                                    <td>3mil</td>
                                    <td style="text-align: left;">Minimum  via is 4 mil. Minimum Components Hole is 6 mil. Increasing via annular ring is  good for over current</td>
                                </tr>
                                <tr bgcolor="#EEEEEE">
                                    <td>Finished External Copper Thickness</td>
                                    <td>35 - 105um</td>
                                    <td style="text-align: left;">The thickness of the board including External plating and finishes</td>
                                </tr>
                                <tr>
                                    <td>Finished Internal Copper Thickness</td>
                                    <td bgcolor="#FFFFFF">17 - 70um</td>
                                    <td style="text-align: left;">The  thickness of the board including internal plating and finishes. Only applies  for multiple layers</td>
                                </tr>
                                <tr bgcolor="#EEEEEE">
                                    <td>Soldermask Type</td>
                                    <td>Photosensitive ink</td>
                                    <td style="text-align: left;">White, Black, Blue, Green, Yellow,  Red, Purple, Matt Green and Matt Black</td>
                                </tr>
                                <tr bgcolor="#FFFFFF">
                                    <td>Min. Silkcreen Letter Width</td>
                                    <td>&#8805;6 mil </td>
                                    <td style="text-align: left;">If the minimum silkscreen letter width is less than 0.15 mm, the letters on the boards may not be clear</td>
                                </tr>
                                <tr bgcolor="#EEEEEE">
                                    <td>Min. Letter Height</td>
                                    <td bgcolor="#EEEEEE">&#8805;1mm</td>
                                    <td style="text-align: left;">If the minimum silkscreen letter is less than 1 mm, the letters on the boards may not be clear due to the design</td>
                                </tr>
                                <tr bgcolor="#FFFFFF">
                                    <td>Surface Finish</td>
                                    <td>&nbsp;</td>
                                    <td style="text-align: left;">HASL, HASL Lead free, ENIG and OSP</td>
                                </tr>
                                <tr bgcolor="#EEEEEE">
                                    <td>PCB Thickness</td>
                                    <td bgcolor="#EEEEEE">0.1 - 2.4 mm</td>
                                    <td style="text-align: left;">FR4 material PCB thickness: 0.4/0.6/0.8/1.0/1.2/1.6/2.0/2.4 mm;<br />
                                        Aluminium Base PCB thickness: 1.0/1.2/1.6 mm;<br>
                                        Flexible PCB thickness: 0.1/0.15 mm </td>
                                </tr>
                                <tr bgcolor="#FFFFFF">
                                    <td>Board Thickness Tolerance</td>
                                    <td>&#177; 10%</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr bgcolor="#EEEEEE">
                                    <td>Min. Slot Milling Width </td>
                                    <td>1.0 mm</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr bgcolor="#FFFFFF">
                                    <td bgcolor="#FFFFFF">Space between Routing and Outline</td>
                                    <td bgcolor="#FFFFFF">&#8805;0.25 mm (10mil)</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr bgcolor="#EEEEEE">
                                    <td>Min. Cutted Hole diameter </td>
                                    <td>0.6 mm</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr bgcolor="#FFFFFF">
                                    <td>Panelize by V-cut space </td>
                                    <td>0 - 0.2 mm space</td>
                                    <td style="text-align: left;">If you want to separate the panel board by V-cut, keep the space between 0 - 0.2 mm</td>
                                </tr>
                                <tr bgcolor="#EEEEEE">
                                    <td>Panelize by Milling space </td>
                                    <td bgcolor="#EEEEEE">1.6 mm</td>
                                    <td style="text-align: left;">If you want to separate the panel board by Milling, make sure the milling width is over 1.6 mm</td>
                                </tr>
                                <tr bgcolor="#FFFFFF">
                                    <td>Impedance control Tolerance</td>
                                    <td>&#177;10%</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr bgcolor="#EEEEEE">
                                    <td>Impedance control Bridging</td>
                                    <td>&#8805;5mil</td>
                                    <td>&nbsp;</td>
                                </tr>
                            </table>
                        </div>
                    </section>
                </div>
            </div>
        </div>
        <div class="xl-30">
            <div class="row quote-panel">
                <div class="xl-100">
                    <section class="section-quote section-quote-pcb">
                        <h3>PCB Orders <span class="section-sub-total">$12.00</span></h3>
                        <div class="text-right"><span class='text-pcb-blue detail-switch'>DETAILS <span class='fa fa-caret-up'></span></span></div>
                        <div class="quote-list-items">
                            <?php 
                                foreach($config_PCB as $product_option_id => $pcb_item){
                                    echo sprintf("<p id='input-option%s-quote'>%s<span>-</span></p>", $product_option_id, $pcb_item['name']);
                                }
                                foreach($config_special as $product_option_id => $pcb_item){
                                    echo sprintf("<p id='input-option%s-quote'>%s<span>-</span></p>", $product_option_id, $pcb_item['name']);
                                }
                            ?>
                        </div>
                    </section>

                    <section class="section-quote section-stencil-cost">
                        <h3>Stencil Cost <span class="section-sub-total">$12.00</span></h3>
                        <div class="text-right"><span class='text-pcb-blue detail-switch'>DETAILS <span class='fa fa-caret-up'></span></span></div>
                        <div class="quote-list-items">
                            <?php 
                                foreach($config_stencil as $product_option_id => $pcb_item){
                                    echo sprintf("<p id='input-option%s-quote'>%s<span>-</span></p>", $product_option_id, $pcb_item['name']);
                                }
                            ?>
                        </div>
                    </section>

                    <section class="section-quote section-expedited-production-cost">
                        <h3>Expedited Production Cost</h3>
                        
                        <?php foreach($options as $option){ ?>
                            <?php if(!isset($config_expedited[$option['product_option_id']])){continue;} ?>

                            <div class="quote-list-items" id="input-option<?php echo $option['product_option_id']; ?>">
                            <?php 
                            $st_flag = true;
                            foreach ($option['product_option_value'] as $option_value) {
                                $checked = "";
                                
                                if ( (int)$option_value['if_default'] && $st_flag ):
                                    $st_flag = false;
                                    $checked = "checked";
                                endif;
                            ?>
                                <p data-option-value-id="<?php echo $option_value['product_option_value_id']; ?>">
                                    <label class="expedited-option"><input type="radio" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option_value['product_option_value_id']; ?>" <?php echo $checked; ?>><?php echo $option_value['name']; ?></label>
                                    <span class="expedited-option-price">
                                        <?php if ($option_value['price']) { ?>
                                        (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
                                    <?php } ?></span>
                                </p>
                            <?php } ?>
                            </div>
                        <?php } ?>
                        
                    </section>

                    
                    <!-- <section class="section-quote section-shipping-cost">
                        <h3>Shipping Cost <span class="section-sub-total">$12.00</span></h3>
                        <div class="quote-list-items">
                            <p class='countries-list' style="display: block;height: 21px;">Countrie
                                <select id="select-countries" name="country_id">
                                    <option value="">-- Please Select --</option>
                                </select>
                            </p>
                            <p class='product-weight'>Weight<span></span></p>
                            <div class="shipping-methods-list">
                                
                            </div>
                        </div>
                    </section>-->

                    <section class="section-summary">
                        <h3 class="sub-total-box">SUB TOTAL<span class="sub-total">$--.--</span></h3>
                        <div class="submit-btn-box">
                            <button id="button-pcb-cart" class="btn-submit-pcb text-pcb-blue" type="button" ><span class="fa fa-shopping-cart"></span> ADD TO CART</button>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>

</div>
<!--<div class="fluid-container bottom-banner">
    <img src="image/kp_productPcb/footer-banner-1.jpg">
    <img src="image/kp_productPcb/footer-banner-2.jpg">
</div>-->
<script type="text/javascript">
KP_PCB.banData = <?php echo json_encode($config_banRule); ?>;
KP_PCB.secondDefaultData = <?php echo json_encode($config_defaultCondition); ?>;
KP_PCB.defaultTopTrigger = <?php echo json_encode($config_defaultTopTrigger); ?>;
KP_PCB.expeditedRules = <?php echo json_encode($config_expeditedRules); ?>;
KP_PCB.panelizedPCBRules = <?php echo json_encode($config_panelizedPCBRules); ?>;
</script>
<?php echo $footer; ?>
