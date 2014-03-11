<?php
/*

	Template Name: Notify me

*/
?>
<?php get_header(); ?>
        
        
        

    <div id="search">

    	<div class="wrapper row">
        	<?php
        
?>

<div class="inside"><h2 style="display: block;">Notify Me <i class="icon-megaphone"></i></h2>

<script type="text/javascript" style="display: none;">

	jQuery(document).ready(function() {
		
		//// WHEN USER SUBMITS OUR NOTIFICATION FORM
		jQuery('#_sf_notification_signup_form')._sf_send_user_notification();
		
	});
</script>




<!-- added by Krisz to convert search data to notification format onSubmit-->

<script type="text/javascript" style="display: none;">
function convertSData () {

var kCountry = document.getElementsByName("country")[0];
var kCity = document.getElementsByName("city")[0];
var kMaker = document.getElementsByName("maker")[0];
var kColor = document.getElementsByName("color")[0];


document.getElementById('range_7_min').value = document.getElementById('reward_min').value; //min
document.getElementById('range_7_max').value = document.getElementById('reward_max').value; //max
document.getElementById('_sf_field_8').value = kCountry.options[kCountry.selectedIndex].value; //country
document.getElementById('_sf_field_539').value = kCity.options[kCity.selectedIndex].value; //city
document.getElementById('_sf_field_442').value = kMaker.options[kMaker.selectedIndex].value; //maker
document.getElementById('_sf_field_34').value = kColor.options[kColor.selectedIndex].value; //color
		
};

</script>


	<p><em>Increase your chances for getting a high reward! Be the first to know when a car gets stolen in your neighborhood! Subscribe and get notified once a matching submission is published. (Select at least one parameter)</em></p>
<?php get_template_part('includes/search/search', 'fields');?>
<form id="_sf_notification_signup_form" action="http://platescout.com" method="post" style="display: block;" onsubmit="return convertSData('');">
    
							<input type="hidden" name="_sf_field_7" id="_sf_field_7" value="true">
							<input type="hidden" name="range_7_min" id="range_7_min" value="150">
							<input type="hidden" name="range_7_max" id="range_7_max" value="1500">
							
							<input type="hidden" name="_sf_field_8" id="_sf_field_8" value="">
							<input type="hidden" name="_sf_field_539" id="_sf_field_539" value="">

							<input type="hidden" name="_sf_field_442" id="_sf_field_442" value="">
							<input type="hidden" name="_sf_field_34" id="_sf_field_34" value="">
											
    
    </ul>
    
    <div class="clear"></div>
    <!-- .clear -->
    
    <p><input type="text" name="name" value="Your Name" onfocus="if(jQuery(this).val() == 'Your Name') { jQuery(this).val(''); }" onblur="if(jQuery(this).val() == '') { jQuery(this).val('Your Name'); }"></p>
    
    <p><input type="email" name="email" value="Email Address" onfocus="if(jQuery(this).val() == 'Email Address') { jQuery(this).val(''); }" onblur="if(jQuery(this).val() == '') { jQuery(this).val('Email Address'); }"></p>
    
    <p><input type="submit" value="Notify Me!" class="button-primary"></p>

</form>

<div class="thankyou" style="display: none;">

	<p>Thank you. You will now be notified of new published submissions matching your criteria.</p>

</div>

<div class="clear" style="display: block;"></div>
<!-- .clear --></div>



        </div>
        <!-- /#search.wrapper/ -->
    
    </div>
    <!-- /#search/ -->


        	<?php
            //////////////////////////////////////////////////////
            //// PAGE LAYOUT
            //////////////////////////////////////////////////////
			$page_layout = get_page_layout($post->ID);
			$content_class = '';
			switch($page_layout) {
				
				case 'right' :
					$content_class = 'large-8 columns';
					break;
				
				case 'left' :
					$content_class = 'large-8 columns';
					break;
				
				default :
					$content_class = 'large-12';
					break;
				
			}
		
		?>
        
        <?php
        
            //////////////////////////////////////////////////////
            //// CUSTOM HEADER
            //////////////////////////////////////////////////////
			if((get_post_meta($post->ID, 'header_title', true) != '') || get_post_meta($post->ID, 'fancy_slogan', true) != '') {
				
				/// INCLUDES CUSTOM HEADER
				get_template_part('includes/page/custom-header');
				
			}
						
			global $paged;
		
		?>
        

	
<!-- /FOOTER STARTS/ -->
<?php get_footer(); ?>