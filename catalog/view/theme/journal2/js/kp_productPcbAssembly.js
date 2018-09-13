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

        if ($this.hasClass("disabled") || $this.hasClass("selected")) {
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

// 选项组功能初始化
KP_PCB.enableOptionGroup = function () {
    $(".product-option .option-group .option-group-name").click(function () {
        var po = $(this).parents('.product-option');
        po.find(".option-group, .option-group-name").removeClass("selected");

        var option_value = $(this).data('value');
        po.find("input[type='hidden']").val(option_value);
        $(this).addClass("selected");
        $(this).parent().addClass("selected");

        if (po.data('section') == 'A') {
            KP_PCB.sectionAToRightSide(po, option_value);
        } else {
            KP_PCB.sectionBToRightSide(po, option_value);
        }
    });
};

KP_PCB.jump = function (eleId) {
    var target = $("#" + eleId);

    if (target.length > 0) {
        var top = target.offset().top;
        $('html, body').animate({scrollTop: top - 60}, 'slow');
    }
    return false;
};

KP_PCB.sectionAToRightSide = function (product_option, option_value) {
    $('.section-quote-a').find('.section-quote-tips').hide();
    $('.section-quote-a').find('[data-show="' + option_value + '"]').fadeIn();

    if (option_value == 'Smart Prototyping') {
        if (product_option.data('islogged') == '1') {
            $('.section-quote-a .section-sub-total').text(product_option.data('product-total'));
        } else {
            $('.section-quote-a .section-sub-total').text('Unknown');
        }
        $('.summary-tips-section[data-show="' + option_value + '"]').fadeIn();
    } else {
        $('.section-quote-a .section-sub-total').text('Unknown');
        $('.summary-tips-section[data-show="Smart Prototyping"]').fadeOut();
    }
};

KP_PCB.sectionBToRightSide = function (product_option, option_value) {
    if (option_value == 'Smart Prototyping') {
        $('select[name="b[estimated_type]"]').trigger('change');
    } else {
        $('.section-quote-b .section-sub-total').text('Unknown');
    }
};

KP_PCB.checkInput = function (value_type, value, extra) {
    if (value_type == 'int') {
        var range = extra.split(','), min = parseInt(range[0]), max = parseInt(range[1]), val = parseInt((value == '') ? 0 : value.replace(/[^0-9]/g, ''));
        
        if(isNaN(val)){ val = min; }
        
        if (val > max) {
            return max;
        } else if (val < min) {
            return min;
        } else {
            return val;
        }
    } else if (value_type == 'float') {
        var range = extra.split(','), min = parseFloat(range[0]), max = parseFloat(range[1]), val = parseFloat((value == '') ? 0 : value.replace(/[^0-9\.]/g, ''));
        if (val > max) {
            return max.toFixed(2);
        } else if (val < min) {
            return min.toFixed(2);
        } else {
            return val.toFixed(2);
        }
    }
};

KP_PCB.sectionAOnInput = function () {
    $('[name="a[smart_order_id]"], [name="a[smart_file_name]"]').on('keyup', function () {
        $('.section-quote-a .section-sub-total').text('Unknown');
        $('.product-option[data-section="A"]').data('product-total', 'Unknown');
    });
    
    $('[name="a[me_shipping_company]"], [name="a[me_tracking_number]"]').on('keyup', function(){
        var val = $(this).val();
        
        if(val.length>25){
            $(this).val( val.substr(0, 25) );
        }
    });

    var obj = $('#position-popover-1');

    obj.popover({
        placement: 'top',
        trigger: 'manual',
        html: 'true',
        content: '<span style="color:#FCA934;margin-right:4px;">(Optional)</span>Please input order ID and file name of the relevant PCB order.',
        viewport: {"selector": ".section-manufacturing", "padding": 10}
    });

    $('#a-option-group-smart > .option-group-name, [name="a[smart_order_id]"], [name="a[smart_file_name]"]').on('click', function () {
        if($('#a-option-group-smart .popover').length==0){
            obj.popover('show');
        }
    });

    $(document).click(function (ele) {
        var dom = $(ele.target);

        if(dom.attr('id')=='a-option-group-smart' || dom.parents('#a-option-group-smart').length>0){
            return;
        }else{
             obj.popover('hide');
        }
    });

};

KP_PCB.sectionBOnInput = function () {
    function updateSectionBPrice() {
        var price = parseFloat($('input[name="b[estimated_price]"]').val());
        var estimated_type = $('select[name="b[estimated_type]"]').val();
        var total = price;
        if (estimated_type == '1') {
            total = parseInt($('#pcb_assembly_quantity').val()) * price;
        }
        if(total==0){
            $('.section-quote-b .section-sub-total').text('Unknown');
        }else{
            $('.section-quote-b .section-sub-total').text($('.estimated-price').text() + total.toFixed(2));
        }
    }
    
    $('[name="b[me_shipping_company]"], [name="b[me_tracking_number]"]').on('keyup', function(){
        var val = $(this).val();
        
        if(val.length>25){
            $(this).val( val.substr(0, 25) );
        }
    });

    var obj = $('[name="b[estimated_price]"]');

    obj.popover({
        placement: 'top',
        trigger: 'manual',
        html: 'true',
        content: '<span style="color:#FCA934;margin-right:4px;">(Optional)</span>Please input your estimated total cost of all your components or select estimated total per board and input per board price.',
        viewport: {"selector": ".section-purchasing", "padding": 10}
    });

    $('#b-option-group-smart > .option-group-name, [name="b[estimated_type]"], [name="b[estimated_price]"]').on('click', function () {
        if($('#b-option-group-smart .popover').length==0){
            obj.popover('show');
        }
    });

    $(document).click(function (ele) {
        var dom = $(ele.target);

        if(dom.attr('id')=='b-option-group-smart' || dom.parents('#b-option-group-smart').length>0){
            return;
        }else{
             obj.popover('hide');
        }
    });

    $('input[name="b[estimated_price]"]').on('keyup', function () {
        var _this = $(this);
        setTimeout(function () {
            var realValue = KP_PCB.checkInput('float', _this.val(), _this.data('range'));
            _this.val(realValue);
            updateSectionBPrice();
        }, 1000);
    });

    $('select[name="b[estimated_type]"]').on('change', function () {
        updateSectionBPrice();
    });

    updateSectionBPrice();
};

KP_PCB.sectionCOnInput = function () {
    $('.section-assembling input[data-value-type="int"]').on('keyup', function () {
        var _this = $(this), realValue = KP_PCB.checkInput('int', _this.val(), _this.data('range'));
        _this.val(realValue);

        // no_lead_pads_per_board less than or equal to smt_pads_per_board
        if (_this.attr('name') === 'c[smt_pads_per_board]') {
            var tmpObj = $("input[name='c[no_lead_pads_per_board]']");
            var tmpObjValue = KP_PCB.checkInput('int', tmpObj.val(), tmpObj.data('range'));
            if (realValue < tmpObjValue) {
                tmpObj.val(realValue);
            }
        } else if (_this.attr('name') === 'c[no_lead_pads_per_board]') {
            var tmpObj = $("input[name='c[smt_pads_per_board]']");
            var tmpObjValue = KP_PCB.checkInput('int', tmpObj.val(), tmpObj.data('range'));
            if (realValue > tmpObjValue) {
                _this.val(tmpObjValue);
            }
        }

        if (_this.attr('id') === 'pcb_assembly_quantity') {
            //触发section D的计价
            $("#estimate_of_testing_time").trigger('keyup');
            //触发secton B的计价
            if ($('[name="b[components_supplied_by]"]').val() === 'Smart Prototyping') {
                $('select[name="b[estimated_type]"]').trigger('change');
            }
        }

        updateSectionCPrice();
    });

    $(".section-quote-c input[type='radio']").click(function () {
        var total = $(this).parents('p').find('.expedited-option-price').text();
        $(".section-quote-c .section-sub-total").text(total);
    });

    $("#bga_pitch").on('change', function () {
        var val = $(this).val();
        if (val !== 'No BGA') {
            $(".section-quote-c p[data-value='manual_without_stencil']").fadeOut();
        } else {
            $(".section-quote-c p[data-value='manual_without_stencil']").fadeIn();
        }
        
        updateSectionCPrice();
    });

    function updateSectionCPrice() {
        $.ajax({
            url: 'index.php?route=product/product_assembly/getBomAssemblyTotal',
            type: 'post',
            data: $('.section-assembling input[type=\'text\'], .section-assembling select'),
            dataType: 'json',
            beforeSend: function () {
                $(".section-quote-c .section-sub-total").empty().addClass("fa fa-spinner fa-spin");
            },
            success: function (json) {
                var recommended = json.recommended;
                $(".section-quote-c .section-sub-total").removeClass("fa fa-spinner fa-spin");
                var mark = $(".section-quote-c .mark-recommended").clone();
                $(".section-quote-c .mark-recommended").remove();
                if(json.manual_without_stencil){
                    $(".section-quote-c p[data-value='manual_without_stencil'] .expedited-option-price").text(json.manual_without_stencil);
                }
                $(".section-quote-c p[data-value='manual_with_stencil'] .expedited-option-price").text(json.manual_with_stencil);
                $(".section-quote-c p[data-value='automatic'] .expedited-option-price").text(json.automatic);

                $(".section-quote-c p[data-value='" + recommended + "'] span.fa-question-circle").before(mark);
                $(".section-quote-c p[data-value='" + recommended + "'] input[type='radio']").click();
                $('input[name="c_option_recommended"]').val(recommended);
            }
        });
    }

    updateSectionCPrice();
};

KP_PCB.sectionDOnInput = function () {
    $("#estimate_of_testing_time").on('keyup', function () {
        var seconds = KP_PCB.checkInput('int', $(this).val(), $(this).data('range')),
                pcba_quantity = parseInt($('#pcb_assembly_quantity').val());
        
        $(this).val(seconds);

        updateSectionDPrice(seconds, pcba_quantity);
    });

    function updateSectionDPrice(seconds, pcba_quantity) {
        $.ajax({
            url: 'index.php?route=product/product_assembly/getFlashingTotal',
            type: 'post',
            data: {seconds: seconds, pcba_quantity: pcba_quantity},
            dataType: 'json',
            beforeSend: function () {
                $(".section-quote-d .section-sub-total").empty().addClass("fa fa-spinner fa-spin");
            },
            success: function (json) {
                $(".section-quote-d .section-sub-total").text(json.total).removeClass("fa fa-spinner fa-spin");
            }
        });
    }

    $("#estimate_of_testing_time").trigger('keyup');
};

KP_PCB.stickQuotePanel = function () {

    var content_height = $("#product").height(), right_height = $(".quote-panel").height();
    var window_width = $(window).width();
    if (window_width >= 940) {
        $(".quote-panel").addClass("sticky-right");
    }

    $(window).scroll(function () {
        content_height = $("#product").height(), right_height = $(".quote-panel").height(), window_width = $(window).width();
        if (window_width >= 940) {
            var scrollTop = $(window).scrollTop();

            if (scrollTop > 90) {
                if (scrollTop < (content_height - right_height - 90)) {
                    $(".quote-panel").css({"top": scrollTop - 90 + "px"});
                } else {
                    $(".quote-panel").css({"top": (content_height - right_height - 90) + "px"});
                }
            } else {
                $(".quote-panel").css({"top": "0"});
            }
        }
    });

    $(window).resize(function () {
        content_height = $("#product").height(), right_height = $(".quote-panel").height(), window_width = $(window).width();
        if (window_width >= 940) {
            $(".quote-panel").addClass("sticky-right");
        } else {
            $(".quote-panel").removeClass("sticky-right");
        }
    });
};

//初始化文件上传功能
KP_PCB.enableUploadFile = function () {
    //验证文件大小
    checkImageSize = function (fileObj, sizeLimitMax) {
        var file_size = fileObj.size, result = false;

        if (file_size > 0 && file_size <= sizeLimitMax) {
            result = true;
        }

        return result;
    };

    getSuffix = function (fileObj) {
        var file_name = fileObj.name;
        var pos = file_name.lastIndexOf('.');
        var suffix = '';
        if (pos != -1) {
            suffix = file_name.substring(pos).toLowerCase();
        }
        return suffix;
    };

    //验证文件后缀
    checkImageSuffix = function (fileObj, suffixLimit) {
        var result = false;
        var suffix = getSuffix(fileObj);

        for (var i in suffixLimit) {
            if (suffixLimit[i] === suffix) {
                result = true;
                break;
            }
        }
        return result;
    };

    var timer;
    $('button[id^=\'button-upload\']').on('click', function () {
        clearInterval(timer);
        var node = this;

        if ($(node).hasClass('uploading')) {
            return;
        }

        $('#form-upload').remove();

        $('body').prepend('<form enctype="multipart/form-data" id="form-upload" style="display: none;"><input type="file" name="file" /></form>');

        $('#form-upload input[name=\'file\']').trigger('click');

        timer = setInterval(function () {
            var filename = $('#form-upload input[name=\'file\']').val();
            if (filename != '') {
                clearInterval(timer);

                var fileObj = $('#form-upload input[name=\'file\']').get(0).files[0];
                var maxSize = 10485760; //单位字节，10MB
                var suffix = ['.zip', '.rar'];
                if (!checkImageSize(fileObj, maxSize)) {
                    alert("The size of image is limited to 10MB");
                    return;
                }
                if (!checkImageSuffix(fileObj, suffix)) {
                    alert("Error File Type, only accept .zip, .rar");
                    return;
                }

                $.ajax({
                    url: 'index.php?route=tool/upload',
                    type: 'post',
                    dataType: 'json',
                    data: new FormData($('#form-upload')[0]),
                    cache: false,
                    contentType: false,
                    processData: false,
                    xhr: function () {
                        var xhr = $.ajaxSettings.xhr();
                        if (xhr.upload) {
                            //Upload progress
                            xhr.upload.addEventListener("progress", function (evt) {
                                if (evt.lengthComputable) {
                                    var percentComplete = Math.round(evt.loaded * 100 / evt.total);
                                    $(node).text('Uploading...' + percentComplete.toString() + '%');
                                } else {
                                    $(node).text("Uploading...");
                                }
                            }, false);
                        }
                        return xhr;
                    },
                    beforeSend: function () {
                        $('.upload-file-info').remove();
                        $(node).addClass('uploading');
                    },
                    complete: function () {
                        $(node).removeClass('uploading');
                        $(node).text('UPLOAD YOUR FILE');
                    },
                    success: function (json) {
                        $('.text-danger, .alert.alert-danger').remove();

                        if (json['error']) {
                            $(node).parent().append('<div class="text-danger">' + json['error'] + '</div>');
                        }

                        if (json['success']) {
                            alert(json['success']);

                            $(node).parent().find('input').attr('value', json['code']);
                            var fileNode = '<span class="upload-file-info">' + filename + '</span>';
                            $(node).after(fileNode);
                        }
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                    }
                });
            }
        }, 500);
    });
};

KP_PCB.validateForm = function(){
    var a,b;
    var result = true;
    var file = $('input[name="project_file"]').val();
    
    if(''==file){
        $('.alert.alert-danger').remove();
        $('#button-upload-file').parent().append('<div class="alert alert-danger">Please upload your relevant files.</div>');
        KP_PCB.jump('section-project-files');
        return false;
    }
    
    return result;
    
    function showErrorMsg(eleId){
        $('#'+eleId).parent().append('<div class="alert alert-danger">Please fill in these fields with correct content.</div>');
        KP_PCB.jump(eleId);
        return false;
    }
    
    if($('[name="a[pcb_supplied_by]"]').val()==='Smart Prototyping'){
        a = $('[name="a[smart_order_id]"]').val();
        b = $('[name="a[smart_file_name]"]').val();
        result = ( a.replace(/[^0-9]/g, '')=='' || b.replace(/(^\s*)|(\s*$)/g, '')=='' ) ? false : true;
        
        if(!result){
            return showErrorMsg('a-option-group-smart');
        }
    }else{
        a = $('[name="a[me_shipping_company]"]').val();
        b = $('[name="a[me_tracking_number]"]').val();
        result = ( a=='' || b.replace(/\s*/g, '')=='' ) ? false : true;
        
        if(!result){
            return showErrorMsg('a-option-group-smart');
        }
    }
    
    if($('[name="b[components_supplied_by]"]').val()==='Me'){
        a = $('[name="b[me_shipping_company]"]').val();
        b = $('[name="b[me_tracking_number]"]').val();
        result = ( a=='' || b.replace(/\s*/g, '')=='' ) ? false : true;
        
        if(!result){
            return showErrorMsg('b-option-group-smart');
        }
    }
    
    return result;
}

KP_PCB.pageInit = function () {
    this.enableSelectOptionAsButtonsList();
    this.enableOptionGroup();
    this.sectionAOnInput();
    this.sectionBOnInput();
    this.sectionCOnInput();
    this.sectionDOnInput();
    this.stickQuotePanel();
    this.enableUploadFile();

    $(".option-group-name[data-value='Smart Prototyping']").trigger('click');
};

$(function () {
    //初始化页面
    KP_PCB.pageInit();

    $('[data-toggle="popover"]').popover({
        placement: 'top',
        trigger: 'click',
        html: 'true',
        viewport: {"selector": "#container", "padding": 50}
    });

    $('[data-toggle="popover"]').on('show.bs.popover', function () {
        $('[data-toggle="popover"]').not(this).popover('hide');
    });

    $(".option-name").on("click", ".fa.fa-times", function () {
        $(this).parents(".option-name").find('[data-toggle="popover"]').popover("hide");
    });

    //左侧伸缩section开关
    $("h2.hover-pointer").click(function () {
        var _this = this;
        $(_this).siblings(".box-filler").slideToggle("normal", function () {
            var fa = $(_this).find(".fa").eq(0);
            fa.attr("class", fa.hasClass("fa-caret-down") ? "fa fa-caret-up text-pcb-blue" : "fa fa-caret-down text-pcb-blue");
            $(window).scroll();
        });
    });

    //监听popover的关闭
    $(document).click(function (ele) {
        var dom = $(ele.target);

        if (dom.hasClass("popover") || dom.parents(".popover").length > 0) {
            return;
        }

        var toggle = typeof $(ele.target).attr("data-toggle") == "undefined" ? false : true;
        if (!toggle) {
            //child span
            toggle = typeof $(ele.target).parent().attr("data-toggle") == "undefined" ? false : true;
        }

        if (toggle) {
            return;
        }
        if (!dom.hasClass("popover") && !toggle) {
            $("[data-toggle='popover']").popover('hide');
        }
    });
    
    //提交询价
    $('#btn-submit-inquiry').click(function(){
        var btn = $(this);
        var btn_text = btn.text();
        if(btn.hasClass('submitting') || !KP_PCB.validateForm()){return;}
        
        $.ajax({
            url: 'index.php?route=product/product_assembly/saveInquiry',
            type: 'post',
            data: $('#product textarea, #product input[type="text"], #product input[type="hidden"], #product input[type="radio"]:checked, #product select'),
            dataType: 'json',
            beforeSend: function () {
                $('.alert.alert-danger').remove();
                btn.addClass('submitting');
                btn.html("<span class='fa fa-spinner fa-spin'></span>");
            },
            success: function (json) {
                btn.removeClass('submitting').empty().text(btn_text);
                if(2==json.error){
                    location.replace(json.redirect);
                }
                
                if(0==json.error){
                    $('.inquiry-result-mask').addClass('show');
                }
            }
        });
    });
});


