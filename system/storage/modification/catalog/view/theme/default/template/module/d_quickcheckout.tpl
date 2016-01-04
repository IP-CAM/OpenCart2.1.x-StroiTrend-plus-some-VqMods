<script>
var config = <?php echo $json_config; ?>;
</script>
<style>
<?php echo $config['design']['custom_style']; ?>
<?php if($config['design']['only_quickcheckout']){ ?>
body > *{
	display: none
}
body > #d_quickcheckout{
	display: block;
} 
#d_quickcheckout.container #logo{
	margin: 20px 0px;
}
<?php } ?>
</style>
<div id="d_quickcheckout">
	<div id="logo" class="center-block text-center"></div>
	<?php echo $field; ?>
	<div class="row">
		<div class="col-md-12"></div>
	</div>
	<div class="qc-col-0">
		<?php echo $login; ?>
		<?php echo $payment_address; ?>
		<?php echo $shipping_address; ?>
		<?php echo $shipping_method; ?>
		<?php echo $payment_method; ?>
		<?php echo $cart; ?>
		<?php echo $payment; ?>
		<?php echo $confirm; ?>
	</div>
	<div class="row">
		<div class="qc-col-1 col-md-<?php echo $config['design']['column_width'][1] ?>">
		</div>
		<div class="col-md-<?php echo $config['design']['column_width'][4] ?>">
			<div class="row">
				<div class="qc-col-2 col-md-<?php echo  ($config['design']['column_width'][4]) ? round(($config['design']['column_width'][2] / $config['design']['column_width'][4])*12) : 0;  ?>">
    			</div>
    			<div class="qc-col-3 col-md-<?php echo ($config['design']['column_width'][4]) ? 12 - round(($config['design']['column_width'][2] / $config['design']['column_width'][4])*12) : 0; ?>">
    			</div>
				<div class="qc-col-4 col-md-12">
				</div>
			</div>
		</div>
	</div>
</div>
<script>
$(function() {
	
	$('.qc-step').each(function(){
		$(this).appendTo('.qc-col-' + $(this).attr('data-col'));	
	})
	$('.qc-step').tsort({attr:'data-row'});
<?php if($config['design']['only_quickcheckout']){ ?>
	$('body').prepend($('#d_quickcheckout'));
	$('#d_quickcheckout').addClass('container')
	$('#d_quickcheckout #logo ').prepend($('header #logo').html())
<?php } ?>
<?php if(!$config['design']['breadcrumb']) { ?>
	$('.qc-breadcrumb').hide();
<?php } ?>
})
</script>

<!-- Nova Poshta -->
<script type="text/javascript"><!--
$(function(){
  var shipping = $('input[name=shipping_method]:checked').val();
  $(document).ajaxSuccess( function(ev, xhr, settings) {
    if(settings.url.indexOf('register') > -1 || settings.url.indexOf('guest') > -1 || settings.url.indexOf('payment_address') > -1) {
        //console.log('It was download address fields' + settings.url + '.');
        
        $('div.form-group > label[for *= company]').replaceWith('<div class="checkbox"><label><input type="checkbox" name="shipping_method" value="novaposhta.novaposhta">Доставка Новой Почтой</label></div>');
        $('input[name *= company]').attr('type', 'hidden');
        
      }
  } );

  //Intercept event
  document.body.addEventListener('change', 
    function(e) {
      //console.info('Catch event "' + e.type + '" of element "' + e.target.name + '". Selected value: ' + e.target.value);
      checkEvent(e);
      //console.log(e.target.name);
    }, 
    true
  );  

  $('input[name=shipping_method]').on('change',function(){
    shipping = $('input[name=shipping_method]:checked').val();
  });

  function checkEvent(e) {
    //console.log('-call method "checkEvent(e)"');

    shipping = $('input[name=shipping_method]:checked').val();

    if (e.target.name == 'shipping_method') {
      //console.log('-delivery method changed');
      
      var ch = $('input[name=shipping_method]').prop('checked');
      //console.log($('input[name=shipping_method]:checked').val());
      if (ch) {
        shipping = e.target.value;
        //console.log("- ch is for " + shipping);
      }
      
      if (e.target.value == 'novaposhta.novaposhta' && ch) {
        $('label[for *= address-1]').html('Отделение Новой Почты'); //change field`s name  
        zone = $('select[name *= zone_id]').val();
        
        //console.log('-selected method of delivery "Nova Poshta"');
        //console.log('-selected zone`s value: ' + zone);
        
        if (zone) {
          //console.log('-get "Nova Poshta" cities and cleaning the address field');

          getData('getCities', zone);
          $('[name *= address_1], [name *= postcode]').val('');
        }
      } else {
        //console.log('-return default fields');
        
        var replacement_fields_address_1 = $('[name *= address_1]');
        var replacement_fields_city = $('[name *= city]');
        var new_input_address_1 = document.createElement('input');
        var new_input_city = document.createElement('input');
        
              new_input_address_1.setAttribute('type', 'text');
              new_input_city.setAttribute('type', 'text');
                
              copyAttributes(replacement_fields_address_1[0], new_input_address_1);
              copyAttributes(replacement_fields_city[0], new_input_city);
              
              replacement_fields_address_1.replaceWith(new_input_address_1.outerHTML); 
              replacement_fields_city.replaceWith(new_input_city.outerHTML);
              
              $('[name *= postcode]').val('');
              $('label[for *= address-1]').html('Адрес'); //change field`s name 
      }
    } else if (e.target.name.indexOf('zone') > -1 && shipping == 'novaposhta.novaposhta') {
      //console.log('-changed zone. Selected value:' + e.target.value);
      //console.log('-get "Nova Poshta" cities');

      getData('getCities', e.target.value);
    } else if (e.target.name.indexOf('city') > -1 && shipping == 'novaposhta.novaposhta') {
      //console.log('-changed city. Selected value:' + e.target.value);
      //console.log(shipping);
      //console.log('-get "Nova Poshta" warehouses');

      getData('getWarehouses', e.target.value);
      $('[name *= postcode]').val('postcode');
    } else if ((e.target.name.indexOf('account') > -1 || e.target.name.indexOf('register') > -1) && shipping == 'novaposhta.novaposhta') {
      //console.log('-changed account. Selected value:' + e.target.value);
      
      zone = $('select[name *= zone_id]').val();
        
      if (zone) {
        //console.log('-get "Nova Poshta" cities and cleaning the address field');

        $(document).ajaxStop( function() { 
          getData('getCities', zone);
        });
        $('[name *= address_1], [name *= postcode]').val('');
      }
    } 
  }       


  function getData(method, filter) {
    var input;
    
    switch(method) {
      case 'getCities':
        input = 'city';
      break;
      
      case 'getWarehouses':
        input = 'address_1';
      break;  
    }
    
    $.ajax( {
      url: 'index.php?route=module/shippingdata/getData',
      type: 'GET',
      data: '&shipping=' + shipping + '&method=' + method + '&filter=' + filter,
      dataType: 'json',
      async: false,
      global: false,
      success: function (json) {
        var html;
        var replacement_fields = $('[name *= ' + input + ']');
        var new_select = document.createElement('select');
          
        html = '<option value=""> --- Выберите --- </option>';
        for (i = 0; i < json.length; i++) { 
          html += '<option value="' + json[i]['Description'] + '">' + json[i]['Description'] + '</option>';
              }
                
              new_select.innerHTML = html;
              copyAttributes(replacement_fields[0], new_select);
              replacement_fields.replaceWith(new_select.outerHTML);             
          }
    } );
  }

  function copyAttributes(from_element, to_element) {
    if (from_element != undefined) {
      var attrs = from_element.attributes;
      //console.log('- copy attributes into a new element');
        
      for(var i = 0; i < attrs.length; i++) {
        if (attrs[i].name == 'type') {
          continue;
        }
        to_element.setAttribute(attrs[i].name, attrs[i].value);
      }
    }
  }
});

//--></script>
<!-- Nova Poshta -->
        		