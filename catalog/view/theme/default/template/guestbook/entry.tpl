<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title></title>
</head>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.min.js"></script>
    <link rel="stylesheet" href="catalog/view/javascript/information/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="catalog/view/javascript/information/css/login.css" />
    <script src="catalog/view/javascript/information/bootstrap/js/bootstrap.min.js"></script>
    <style type="text/css">
      .required span.required{
        content: '*';
        color:red;
        margin: 1px;

       },
       
    </style>
    <body style="background-color:rgb(242,242,242);"> 
    <form action="" method="post" enctype="multipart/form-data" class="form-horizontal" id="form_id">
        <div id="form_container2" style="padding-top: 0px;" class="required">
          <h3>Please complete your shipping address</h3>
           <span class="required">*</span><label for="firstname">First Name:</label>
           <input name="firstname" type="text" class="form-control" value="<?php echo $firstname;?>" placeholder="FirstName" id="firstname" minlength="3" maxlength="32" required />
          <span class="required">*</span><label for="lastname">Last Name:</label><input name="lastname" type="text" class="form-control" value="<?php echo $lastname;?>" placeholder="LastName" id="lastname" minlength="2" maxlength="32"  required/>
          <span class="required">*</span><label for="telephone">Your Phone Number:</label><input name="telephone" type="number" class="form-control" value="<?php echo $telephone; ?>"  placeholder="PhoneNumber" id="telephone" required />
           <label for="company">Company:</label><input name="company" type="text" class="form-control" value="<?php echo $company;?>" placeholder="Company" id="company"/>
          <span class="required">*</span><label for="address_1">Address1:</label><input name="address_1" type="text" class="form-control" value="<?php echo $address_1;?>" placeholder="Address1" id="address_1" minlength="5" maxlength="128" required/>
          <label>Address2:</label><input name="address_2" type="text" class="form-control" value="<?php echo $address_2;?>" placeholder="Address2" id="address_2" />
          <span class="required">*</span><label for="city">City:</label><input name="city" type="text" class="form-control" value="<?php echo $city;?>" placeholder="City" id="city" required />
           <!-- <label>Country</label><input type="text" class="form-control" placeholder="验证码" id="regist_vcode" /> -->
          <!--<button id="getVCode" type="button" class="btn btn-success" >获取验证码</button>-->
          <!-- <label>States</label><input id="getVCode" type="button" class="btn btn-success" value="点击发送验证码" onclick="sendCode(this)" /> -->
          <!-- <label>States</label><input type="text" class="form-control" placeholder="验证码" id="regist_vcode" /> --> 
          
            <span class="required">*</span><label for="input-country">Country:</label> 
          
              <select name="country_id" id="input-country" class="form-control" required>
                <option value=""><?php echo $text_select; ?></option>
                <?php foreach ($countries as $country) { ?>
                <?php if ($country['country_id'] == $country_id) { ?>
                <option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select>
              <?php if ($error_country) { ?>
              <div class="text-danger"><?php echo $error_country; ?></div>
              <?php } ?>
         <span class="required">*</span> <label for="input-zone">States:</label>


           
              <select name="zone_id" id="input-zone" class="form-control" required >
              </select>
              <?php if ($error_zone) { ?>
              <div class="text-danger"><?php echo $error_zone; ?></div>
              <?php } ?>
               <div class="pull-right">
              <input type="submit" value="Submit" class="btn btn-primary button" name="Submit" style="margin-top: 15px;
          margin-right: 246px;">
          <input type="button" value="Cancle" class="btn btn-primary button" name="Cancle" style="margin-top: -54px;
          margin-left: 249px; display: inline;">
        </div>
          </div>
</form>
 </body>
 <script type="text/javascript"><!--
$('select[name=\'country_id\']').on('change', function() {
  $.ajax({
    url: 'index.php?route=account/account/country&country_id=' + this.value,  //请求地址
    dataType: 'json',
    beforeSend: function() {
      $('select[name=\'country_id\']').after(' <i class="fa fa-circle-o-notch fa-spin"></i>');
    },
    complete: function() {
      $('.fa-spin').remove();
    },
    success: function(json) {
      if (json['postcode_required'] == '1') {

        $('input[name=\'postcode\']').parent().parent().addClass('required');
      } else {
        $('input[name=\'postcode\']').parent().parent().removeClass('required');
      }

      html = '<option value=""><?php echo $text_select; ?></option>';

      if (json['zone'] && json['zone'] != '') {
        for (i = 0; i < json['zone'].length; i++) {
          html += '<option value="' + json['zone'][i]['zone_id'] + '"';

          if (json['zone'][i]['zone_id'] == '<?php echo $zone_id; ?>') {
            html += ' selected="selected"';
            }

            html += '>' + json['zone'][i]['name'] + '</option>';
        }
      } else {
        html += '<option value="0" selected="selected"><?php echo $text_none; ?></option>';
      }

      $('select[name=\'zone_id\']').html(html);
    },
    error: function(xhr, ajaxOptions, thrownError) {
      alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
    }
  });
});

$('select[name=\'country_id\']').trigger('change');



//jquery ajax验证表单并提交
var address_id = "<?php echo $address_id;?>";

   $('input[name=\'Cancle\']').click(function(){
        parent.layer.closeAll('iframe');

  }) 
$.validator.setDefaults({
    submitHandler: function(form) {
      var param = $('#form_id').serialize();
       $.ajax({
        async:false,
         type:'post',
         url:"index.php?route=account/address/edit&address_id="+'<?php echo $address_id;?>',
         data:param,
         success:function()
         {
          window.parent.location.reload();
          parent.layer.closeAll('iframe'); 
          
         },
         
       })
    }
});

  $().ready(function() {
    $("#form_id").validate({
      errorPlacement:function(error,element){
        $(element).closest('form').find("label[for='" + element.attr( "id" ) + "']").append(error);
      },
       errorElement:"span",
    });
});



 
//--></script>
  
</html>