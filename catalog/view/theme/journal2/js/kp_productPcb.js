KP_PCB = ("undefined" == typeof KP_PCB) ? {} : KP_PCB;

KP_PCB.enableSelectOptionAsButtonsList = function () {
    $('.option.option-select').each(function () {
        var $option = $(this);
        var html = '';
        html += '<ul>';

        $option.find('option').each(function () {
            var $this = $(this);
            if ($this.val()) {
                var cls = $this.prop('selected') ? 'class="selected"' : '';
                html += '<li data-value="' + $this.val() + '" ' + cls + ' ><span>' + $this.text().trim() + '</span></li>';
            }
        });

        html += '</ul>';
        $option.append($(html));
    });

    $('.option-select li').click(function () {
        var $this = $(this);
        var $option = $this.closest('.option');
        
        if($this.hasClass("disabled") || $this.hasClass("selected")){
            return;
        }

        /* trigger change on corresponding option */
        var $input = $option.find('[value="' + $this.attr('data-value') + '"]');

        var $select = $input.parent();
        var val = $select.val() == $this.attr('data-value') ? '' : $this.attr('data-value');
        $select.val(val);
        $select.trigger('change');

        /* add class to selected options */
        $option.find('[data-value]').removeClass('selected');
        $option.find('[data-value="' + $option.find('select').val() + '"]').addClass('selected');

    });
};

//开启 checkbox list
KP_PCB.enableCheckboxList = function () {
    $(".radio-result").click(function () {
        var list = $(this).siblings(".radio-list");
        if (list.hasClass("close")) {
            list.removeClass("hidden");
            setTimeout(function () {
                list.removeClass("close");
            }, 300);
        } else {
            list.addClass("close");
            setTimeout(function () {
                list.addClass("hidden");
            }, 300);
        }
    });
    
    $(".btn-close-radio-list").click(function(){
        var list = $(this).parents(".radio-list");
        list.addClass("close");
        setTimeout(function () {
            list.addClass("hidden");
        }, 300);
    });

    $("div.radio input[type='radio']").change(function () {
        var _this = this, option = $(_this).parents(".option-radio");
        option.find("div.radio .fa-check-square").attr("class", "fa fa-square");
        option.find("div.radio input[type='radio']").not(_this).prop("checked", false);

        var option_value = $(_this).siblings(".option-value-text").text();

        setTimeout(function () {
            $(_this).siblings(".fa").attr("class", "fa fa-check-square");
            $(".radio-result", option).text(option_value).trigger("click");
        }, 100);
    });
};

//监听选项变化
KP_PCB.syncOptionToQuoteSection = function () {
    var select = $(".section-pcb .option-select select, .section-special-requirements .option-select select, .section-pcb-stencil .option-select select, .section-pcb-stencil .option-drop-select select"),
            text = $(".section-pcb .option-text input[type='text'], .section-pcb-stencil .option-text input[type='text']"),
            radio = $(".section-pcb .option-radio input[type='radio'], .section-pcb-stencil .option-radio input[type='radio']");


    select.on("change", KP_PCB.updateQuote);
    text.on("keyup", KP_PCB.updateQuote);
    radio.on("change", KP_PCB.updateQuote);

    select.each(function (index, ele) {
        KP_PCB.syncToRight(ele);
    });

    text.each(function (index, ele) {
        KP_PCB.syncToRight(ele);
    });

    radio.each(function (index, ele) {
        if ($(ele).prop("checked")) {
            KP_PCB.syncToRight(ele);
        }
    });
};

//在二次更新默认值时，禁用同步更新功能
defaultRule_flag = false;

//更新右侧的价目表
KP_PCB.updateQuote = function (ele) {
    if(defaultRule_flag){
        KP_PCB.syncToRight(ele.target);
        //console.log("wait for default setting.");
        return;
    }
    
    //执行禁止规则
    KP_PCB.ruleFilter(function(){
        defaultRule_flag = true;
        KP_PCB.defaultRuleSetter(ele, function(){
            defaultRule_flag = false;
            KP_PCB.syncToRight(ele.target);
            KP_PCB.updateExpeditedProductionCost(function(){
                KP_PCB.updateProductPrice();
            });
        });
    });
};

KP_PCB.syncToRight = function (dom) {
    var target_val_name = KP_PCB.getOptionValueName(dom);
    var target_id = $(dom).attr("id");
    var target_type = dom.tagName.toLowerCase();

    if ("input" == target_type) {
        target_type = $(dom).attr("type");

        if ("radio" == target_type) {
            target_id = $(dom).parents(".radio-list").attr("id");
        }else if("text" == target_type && $(dom).hasClass("pp-mark")){
            //Panelized PCBs Rows Or Colums
            target_id = $(dom).parent(".option").attr("data-parent-id");
            var pp_rows = $(".pp-rows-mark").val(), pp_colums = $(".pp-colums-mark").val();
            target_val_name = $("#"+target_id+" option:selected").text().trim() + " (" + pp_rows + "x" + pp_colums + ")";
        }
    }
    $("p#" + target_id + "-quote > span").text(target_val_name).attr("title", target_val_name);
};

KP_PCB.getOptionValueName = function (dom) {
    var target_val_name;
    var target_type = dom.tagName.toLowerCase();

    if ("input" == target_type) {
        target_type = $(dom).attr("type");
    }

    switch (target_type) {
        case "select":
            target_val_name = $("option:checked", dom).text().trim();
            break;
        case "text":
            var val = $(dom).val();
            if (isNaN(val)) {
                val = '-';
                $(dom).val('');
            }
            target_val_name = val.trim();
            break;
        case "radio":
            target_val_name = $(dom).siblings(".option-value-text").text().trim();
            break;
        default:
            target_val_name = 'N/A';
            break;
    }
    return target_val_name;
};

//更新Expedited Production Cost价目列表的价格
KP_PCB.updateExpeditedProductionCost = function (cb) {
    var target, opiton_subtotal, opiton_unit;
    var expeditedRules = KP_PCB.expeditedRules;
    var pcb_qty = parseInt($("[name='option["+expeditedRules.qty+"]']:checked").siblings(".option-value-text").text()),
        layer = parseInt($("#input-option"+expeditedRules.layer+" option:selected").text().replace(/[^0-9]*/g,"")),
        material_option_value_id = $("#input-option"+expeditedRules.material).val();
 
    var top_rules = expeditedRules.material_options[material_option_value_id];
    
    $(".section-expedited-production-cost p[data-option-value-id]").addClass("hidden");
    $(".section-expedited-production-cost p[data-option-value-id] input[type='radio']").prop("checked", false);
    
    if(top_rules.normal){ 
        var rules = top_rules.normal, default_item = top_rules.default;
        for(var i in rules){
            target = $(".section-expedited-production-cost p[data-option-value-id='"+rules[i]+"']");
            target.removeClass("hidden");
            
            if (default_item == rules[i]) {
                target.find("input[type='radio']").prop("checked", true);
            }
            //opiton_unit = parseFloat(target.attr("data-option-price"));
            //opiton_subtotal = (opiton_unit * pcb_qty).toFixed(2);
            //target.find(".expedited-option-price").html("$" + opiton_subtotal + " <small>(" + opiton_unit + "/pc)</small>");
        }
    }else{
        var flag_update = true;
        if(layer==1){
           if(pcb_qty<=30){
                rules = top_rules.result_layer2_qty30;
            }else if(pcb_qty>30 && pcb_qty<=50){
                rules = top_rules.result_layer1_qty3050;
            }
            else if(pcb_qty>50&&pcb_qty<=100)
            {
                rules = top_rules.result_layer1_qty50100;
            }
            else if(pcb_qty>100&&pcb_qty<=300)
            {
                rules = top_rules.result_layer1_qty100300;
            }
            else if(pcb_qty>300&&pcb_qty<=1000)
            {
                rules = top_rules.result_layer1_qty3001000;
            }
            else if(pcb_qty>1000&&pcb_qty<=10000)
            {
                rules = top_rules.result_layer1_qty100010000;
            }
        }else if(layer==2){
            if(pcb_qty<=30){
                rules = top_rules.result_layer2_qty30;
            }else if(pcb_qty>30 && pcb_qty<=50){
                rules = top_rules.result_layer2_qty3050;
            }
            else if(pcb_qty>50&&pcb_qty<=100)
            {
                rules = top_rules.result_layer2_qty50100;
            }
            else if(pcb_qty>100&&pcb_qty<=300)
            {
                rules = top_rules.result_layer2_qty100300;
            }
            else if(pcb_qty>300&&pcb_qty<=1000)
            {
                rules = top_rules.result_layer2_qty3001000;
            }
            else if(pcb_qty>1000&&pcb_qty<=10000)
            {
                rules = top_rules.result_layer2_qty100010000;
            }
            // else{
            //     rules = top_rules.result_layer2_qty50;
            // }
        }else if(layer==4){
            if(pcb_qty<=30){
                rules = top_rules.result_layer4_qty30;
            }
            else if(pcb_qty>30&&pcb_qty<=100)
            {
                rules = top_rules.result_layer4_qty30100;
            }
            else if(pcb_qty>100&&pcb_qty<=500)
            {
                rules = top_rules.result_layer4_qty100500;
            }
            else if(pcb_qty>500&&pcb_qty<=1000)
            {
                rules = top_rules.result_layer4_qty5001000;
            }
             else{
                rules = top_rules.result_layer4_qtygt1000;
            }
        }else if(layer==6){
            rules = top_rules.result_layer6;
        }else if($.inArray(layer,[0,8,10,12,14,16])){
            rules = top_rules.result_layer8;
        }else{
            flag_update = false;
        }
        
        if(flag_update){
            if(rules.pre_success){
                var pre_action = KP_PCB.expeditedProductionCostPreAction(top_rules);
                var default_item = pre_action ? rules.pre_success_default : rules.pre_fail_default;
                rules = pre_action ? rules.pre_success : rules.pre_fail;
            }else{
                var default_item = rules.normal_default;
                rules = rules.normal;
            }

            for(var i in rules){
                target = $(".section-expedited-production-cost p[data-option-value-id='"+rules[i]+"']");
                target.removeClass("hidden");
                //console.log({default_item:default_item, i:i, rules:rules});
                if(default_item==rules[i]){
                    target.find("input[type='radio']").prop("checked", true);
                }
                //opiton_unit = parseFloat(target.attr("data-option-price"));
                //opiton_subtotal = (opiton_unit * pcb_qty).toFixed(2);
                //target.find(".expedited-option-price").html("$" + opiton_subtotal + " <small>(" + opiton_unit + "/pc)</small>");
            }
        }
    }
    //console.log({pcb_qty:pcb_qty, layer:layer, rules:rules});
    
    //$(".section-expedited-production-cost p[data-option-value-id]").not(".hidden").eq(0).find("[type='radio']").prop("checked", true);
    
    if(typeof cb == "function"){
        setTimeout(cb,300);
    }
};

KP_PCB.expeditedProductionCostPreAction = function(rules){
    var result = true, option_value;
    var pre_condition = rules.pre_condition;
    for(var i in pre_condition){
        if(i=="dimension_l" || i=="dimension_w"){
            option_value = parseFloat($("#input-option"+pre_condition.dimension_l[0]).val());
            //console.log({option_value:option_value});
            if(option_value>200){
                result = false;
                break;
            }
        }else{
            option_value = parseInt($("#input-option"+i).val());
            //console.log({option_value:option_value, 'pre_condition[i]':pre_condition[i]});
            if($.inArray(option_value, pre_condition[i])<0){
                result = false;
                break;
            }
        }
    }
    //console.log({result:result});
    return result;
};

//Base on journal, update price on realtime
KP_PCB.updateProductPrice = function () {
    $.ajax({
        url: 'index.php?route=journal2/ajax/price',
        type: 'post',
        data: $('#product input[type=\'text\'], #product input[type=\'hidden\'], #product input[type=\'radio\']:checked, #product input[type=\'checkbox\']:checked, #product select, #product textarea'),
        dataType: 'json',
        beforeSend: function () {
            $(".section-summary .sub-total,.section-quote-pcb .section-sub-total,.section-stencil-cost .section-sub-total,.product-weight span").empty().addClass("fa fa-spinner fa-spin");
        },
        success: function (json) {
            $(".section-summary .sub-total").text(json.price).removeClass("fa fa-spinner fa-spin");
            $(".section-quote-pcb .section-sub-total").text(json.pcb_orders_price).removeClass("fa fa-spinner fa-spin");
            $(".section-stencil-cost .section-sub-total").text(json.stencil_price).removeClass("fa fa-spinner fa-spin");
            $(".product-weight span").text(json.product_weight).removeClass("fa fa-spinner fa-spin");

            if ("" !== $("#select-countries").val()) {
                //$("#select-countries").trigger("change");
            }
        }
    });
};

//进行页面数据初始化和报价初始化
KP_PCB.pageDataInit = function () {
    var pcb_qty = parseInt($(".radio-result").text());
    
    KP_PCB.ruleFilter(function(){
        KP_PCB.updateExpeditedProductionCost(function(){
            KP_PCB.updateProductPrice();
        });
    });
    
};

//为PCB Color每个选项添加特定颜色
KP_PCB.pcbColorOPtionInit = function () {
    var colorOpts = $(".option-name[data-option-title-name='Solder Mask Color']").parents(".product-option").find(".option-select li");
    var cls;
    colorOpts.each(function (index, ele) {
        cls = $('span', ele).text();
        $(ele).addClass(cls);
    });
};

//加载countries数据
KP_PCB.countriesInit = function () {
    $.get('index.php?route=product/productpcb/getCountries', function (json) {
        if (json) {
            var select = $("#select-countries");
            for (var x in json) {
                select.append("<option value='" + json[x].country_id + "'>" + json[x].name + "</option>");
            }

            select.on("change", function () {
                var country_id = $(this).val(),
                        product_id = $("input[name='product_id']").val();
                if (country_id > 0) {
                    $.ajax({
                        url: 'index.php?route=product/productpcb/getShippingMethods',
                        type: 'post',
                        data: $('#product input[type=\'text\'], #product input[type=\'hidden\'], #product input[type=\'radio\']:checked, #product input[type=\'checkbox\']:checked, #product select, #product textarea'),
                        dataType: 'json',
                        beforeSend: function () {
                            $(".shipping-methods-list").empty().addClass("fa fa-spinner fa-spin");
                        },
                        success: function (retData) {
                            if (!retData.ocaaspro.error) {
                                var quote = retData.ocaaspro.quote;
                                var eleList = $(".shipping-methods-list");
                                eleList.removeClass("fa fa-spinner fa-spin");
                                for (var x in quote) {
                                    eleList.append("<p data-option-price='" + quote[x].cost + "'><label class='shipping-method-option'><input type='radio' name='shipping_method' value='" + quote[x].code + "'>" + quote[x].title + "</label><span class=''>" + quote[x].text + "</small></span></p>");
                                }
                            }
                        }
                    });
                } else {
                    $(".shipping-methods-list").empty();
                }

            });
        }
    });
};
//遍历option规则
KP_PCB.ruleFilter = function(cb){
    var banData = KP_PCB.banData;
    var trigger_option_value_id = $("#input-option"+banData.trigger_product_option_id+" option:selected").val();
    var rules = banData.condition[trigger_option_value_id];
    
    var level_1, level_2, select, tmp_option_value_id, selected_option_value_id;
    
    $("[id^='input-option']").siblings("ul").find("li[data-value]").removeClass("disabled hidden");

    for(var option_id in rules.disabled){
        level_1 = rules.disabled[option_id];
        if(rules.disabled.last || level_1.last){
            if(option_id=='last'){continue;}
            
            //代表此树已到末尾，没有子树了
            if(level_1.last){
                KP_PCB.ruleDisable(option_id, level_1[option_id]);
            }else{
                KP_PCB.ruleDisable(option_id, level_1);
            }
        }else{
            selected_option_value_id = $("#input-option"+option_id+" option:selected").val();
            // level_1 = rules[1270].disabled[549]
            for(var option_value_id in level_1){
                if(option_value_id!==selected_option_value_id){continue;}
                //console.log({'level_1':level_1, 'option_value_id':option_value_id});
                
                level_2 = level_1[option_value_id];
                if(level_2.last){
                     for(var tmp_option_id in level_2){
                         if(tmp_option_id=='last'){continue;}
                             
                         if( level_2[tmp_option_id] instanceof Array){
                            KP_PCB.ruleDisable(tmp_option_id, level_2[tmp_option_id]);
                         }else{
                             //text
                         }
                     }
                }else{
                    //暂时不存在更小一级的规则
                }
            }
        }
    }
    
    for(var option_id in rules.hidden){
        level_1 = rules.hidden[option_id];

        if(rules.hidden.last || level_1.last){
            if(option_id=='last'){continue;}
            
            //代表此树已到末尾，没有子树了
            if(level_1.last){
                KP_PCB.ruleHidden(option_id, level_1[option_id]);
            }else{
                KP_PCB.ruleHidden(option_id, level_1);
            }
        }else{
            selected_option_value_id = $("#input-option"+option_id+" option:selected").val();
            // level_1 = rules[1270].hidden[549]
            for(var option_value_id in level_1){
                if(option_value_id!==selected_option_value_id){continue;}
                //console.log({'level_1':level_1, 'option_value_id':option_value_id});
                
                level_2 = level_1[option_value_id];
                if(level_2.last){
                     for(var tmp_option_id in level_2){
                         if(tmp_option_id=='last'){continue;}
                             
                         if( level_2[tmp_option_id] instanceof Array){
                            KP_PCB.ruleHidden(tmp_option_id, level_2[tmp_option_id]);
                         }else{
                             //text
                             //console.log({'text':tmp_option_id});
                             KP_PCB.ruleHiddenText(tmp_option_id);
                         }
                     }
                }else{
                    //暂时不存在更小一级的规则
                }
            }
        }
    }
    
    if(typeof cb == "function"){
        setTimeout(function(){
            cb();
        },300);
    }
};

KP_PCB.ruleDisable = function (option_id, rule) {
    var select = $("#input-option" + option_id);
    var tmp_option_value_id;
    for (var x in rule) {
        tmp_option_value_id = rule[x];
        //console.log({'option_id':option_id, 'tmp_option_value_id':tmp_option_value_id});
        select.find("option[value='" + tmp_option_value_id + "']").prop("selected", false);
        select.siblings("ul").find("li[data-value='" + tmp_option_value_id + "']").addClass('disabled').removeClass("selected");
    }
};

KP_PCB.ruleHidden = function (option_id, rule) {
    var select = $("#input-option" + option_id);
    var tmp_option_value_id;
    for (var x in rule) {
        tmp_option_value_id = rule[x];
        //console.log({'option_id':option_id, 'tmp_option_value_id':tmp_option_value_id});
        select.find("option[value='" + tmp_option_value_id + "']").prop("selected", false);
        select.siblings("ul").find("li[data-value='" + tmp_option_value_id + "']").addClass('hidden').removeClass("selected");
    }
};

KP_PCB.ruleHiddenText = function (option_id) {
    var text = $("#input-option" + option_id);

    //console.log({'option_id':option_id, 'type':'text'});
    text.val(0);
    text.parent().addClass('hidden');
};

KP_PCB.defaultRuleSetter = function(ele, cb){
    var sdd = KP_PCB.secondDefaultData;
    var trigger_option_value_id, rules, target;
    
    var ele_val = parseInt($(ele.target).val());
    
    for(var i in sdd){
        //console.log({i:i, 'sdd[i]':sdd[i]});
        if($.inArray(ele_val, sdd[i][0])>-1){
            rules = sdd[i][1];
            //console.log({'defaultRule':rules});
            
            if($.inArray(i, ['condition_0', 'condition_1', 'condition_2'])<0){
                trigger_option_value_id = $("#input-option"+KP_PCB.defaultTopTrigger[0]+" option:selected").val();
                if(trigger_option_value_id==KP_PCB.defaultTopTrigger[1]){
                    for (var j in rules) {
                        target = $("#input-option" + j);
                        if (target.hasClass('radio-list')) {
                            var _this = $("[name='option[" + j + "]']").filter("[value='" + rules[j] + "']").eq(0);
                            var option = $(_this).parents(".option-radio");
                            option.find("div.radio .fa-check-square").attr("class", "fa fa-square");
                            option.find("div.radio input[type='radio']").not(_this).prop("checked", false);

                            //console.log({'radio': _this, option: option});

                            var option_value = $(_this).siblings(".option-value-text").text();
                            setTimeout(function () {
                                $(_this).siblings(".fa").attr("class", "fa fa-check-square");
                                $(_this).prop("checked", true);
                                $(".radio-result", option).text(option_value);
                            }, 100);
                        } else {
                            target.siblings("ul").find("li[data-value='"+rules[j]+"']").trigger("click");
                        }
                    }
                }
            }else{
                for (var j in rules) {
                    target = $("#input-option" + j);
                    if (target.hasClass('radio-list')) {
                        var _this = $("[name='option[" + j + "]']").filter("[value='" + rules[j] + "']").eq(0);
                        var option = $(_this).parents(".option-radio");
                        option.find("div.radio .fa-check-square").attr("class", "fa fa-square");
                        option.find("div.radio input[type='radio']").not(_this).prop("checked", false);
                        
                        //console.log({'radio': _this, option: option});

                        var option_value = $(_this).siblings(".option-value-text").text();
                        setTimeout(function () {
                            $(_this).siblings(".fa").attr("class", "fa fa-check-square");
                            $(".radio-result", option).text(option_value);
                        }, 100);
                    } else {
                        target.siblings("ul").find("li[data-value='"+rules[j]+"']").trigger("click");
                    }
                }
            }
            break;
        }
    }
    
    if(typeof cb == "function"){
        setTimeout(cb,300);
    }
};

KP_PCB.panelizedPCBsInit = function(){
    var option_id = KP_PCB.panelizedPCBRules.option_id, checked_option_value_id;
    $("#input-option"+option_id).on("change", function(){
        checked_option_value_id = $(this).val();
        $("[id^='input-option'].pp-mark").parent().removeClass("disabled hidden");
        if(KP_PCB.panelizedPCBRules.option_value_id[checked_option_value_id]){
            var hiddenRules = KP_PCB.panelizedPCBRules.option_value_id[checked_option_value_id];
            for(var i in hiddenRules){
                var text = $("#input-option" + hiddenRules[i]);
                text.val(0);
                text.parent().addClass('hidden');
            }
        }
    });
    $("#input-option"+option_id).trigger("change");
};

$(function () {
    //1. 进行事件监听和视图初始化
    KP_PCB.enableSelectOptionAsButtonsList();
    KP_PCB.enableCheckboxList();
    KP_PCB.syncOptionToQuoteSection();
    KP_PCB.pcbColorOPtionInit();
    //KP_PCB.countriesInit();
   KP_PCB.panelizedPCBsInit();

    $('[data-toggle="popover"]').popover({
        placement: 'top',
        trigger: 'click',
        html: 'true',
        viewport: { "selector": "#container", "padding": 50 }
    });
    
    $('[data-toggle="popover"]').on('show.bs.popover', function () {
         $('[data-toggle="popover"]').not(this).popover('hide');
    });

    $(".option-name").on("click", ".fa.fa-times", function(){
        $(this).parents(".option-name").find('[data-toggle="popover"]').popover("hide");
    });

    $(".detail-switch").click(function () {
        var _this = this;
        $(_this).parents(".section-quote").find(".quote-list-items").slideToggle("normal", function () {
            var fa = $(_this).find(".fa").eq(0);
            fa.attr("class", fa.hasClass("fa-caret-down") ? "fa fa-caret-up" : "fa fa-caret-down");
        });
    });

    $(".section-expedited-production-cost input[type='radio']").change(function () {
        KP_PCB.updateProductPrice();
    });

    //add to cart
    $('#button-pcb-cart').on('click', function () {
        $.ajax({
            url: 'index.php?route=checkout/cart/add',
            type: 'post',
            data: $('#product input[type=\'text\'], #product input[type=\'hidden\'], #product input[type=\'radio\']:checked, #product input[type=\'checkbox\']:checked, #product select, #product textarea'),
            dataType: 'json',
            beforeSend: function () {
                $('#button-pcb-cart').button('loading');
            },
            complete: function () {
                $('#button-pcb-cart').button('reset');
            },
            success: function (json) {
                $('.alert, .text-danger').remove();

                if (json['error']) {
                    if (json['error']['option']) {
                        for (i in json['error']['option']) {
                            var element = $('#input-option' + i.replace('_', '-'));
                            element.parent().append('<div class="text-danger">' + json['error']['option'][i] + '</div>');
                        }
                    }
                }

                if (json['success']) {
                    $('#cart-total').html(json['total']);

                    $('html, body').animate({scrollTop: 0}, 'slow');

                    $('#cart ul').load('index.php?route=common/cart/info ul li');
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    });

    //左侧伸缩section开关
    $("h3.hover-pointer").click(function () {
        var _this = this;
        $(_this).siblings(".box-filler").slideToggle("normal", function () {
            var fa = $(_this).find(".fa").eq(0);
            fa.attr("class", fa.hasClass("fa-caret-down") ? "fa fa-caret-up text-pcb-blue" : "fa fa-caret-down text-pcb-blue");
        });
    });


    var timer;
    $('button[id^=\'button-upload\']').on('click', function () {
        clearInterval(timer);
        var node = this;

        $('#form-upload').remove();

        $('body').prepend('<form enctype="multipart/form-data" id="form-upload" style="display: none;"><input type="file" name="file" /></form>');

        $('#form-upload input[name=\'file\']').trigger('click');

        timer = setInterval(function () {
            var filename = $('#form-upload input[name=\'file\']').val();
            if (filename != '') {
                clearInterval(timer);

                $.ajax({
                    url: 'index.php?route=tool/upload',
                    type: 'post',
                    dataType: 'json',
                    data: new FormData($('#form-upload')[0]),
                    cache: false,
                    contentType: false,
                    processData: false,
                    beforeSend: function () {
                        $(node).button('loading');
                        $(".show-upload-filename").remove();
                    },
                    complete: function () {
                        $(node).button('reset');
                    },
                    success: function (json) {
                        $('.text-danger').remove();

                        if (json['error']) {
                            $(node).parent().find('input').after('<div class="text-danger">' + json['error'] + '</div>');
                        }

                        if (json['success']) {
                            alert(json['success']);

                            $(node).parent().find('input').attr('value', json['code']);
                            var fileNode = '<p class="show-upload-filename" style="color: #398AE4; padding: 8px; background-color: #f5f5f5; border: 1px dashed; margin: 8px 20px 8px 0px;">'+ filename + '</p>';
                            $(node).parent().find('input').after(fileNode);
                        }
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                    }
                });
            }
        }, 500);
    });

    //进行页面数据初始化和报价初始化
    KP_PCB.pageDataInit();
    
    //监听popover的关闭
    $(document).click(function(ele){
        var dom = $(ele.target);
        
        if(dom.hasClass("popover") || dom.parents(".popover").length>0){
            return;
        }
        
        var toggle = typeof $(ele.target).attr("data-toggle") == "undefined" ? false : true;
        if(!toggle){
            //child span
            toggle = typeof $(ele.target).parent().attr("data-toggle") == "undefined" ? false : true;
        }
        
        if(toggle){return;}
        if(!dom.hasClass("popover") && !toggle ){
            $("[data-toggle='popover']").popover('hide');
        }
    });
    
});


