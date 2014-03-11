<script type="text/javascript">

	jQuery(document).ready(function() {
		
		jQuery('#submit-cart')._sf_refresh_cart(<?php echo $spot_id; ?>);
		
		jQuery('#cart-checkout').click(function(e) { jQuery(this)._sf_checkout_cart(e, <?php echo $spot_id ?>); });
		
	});

</script>

<div id="submit-cart" class="responsive-negative-margin">

    <div class="row">
    
        <div class="large-8 columns">
        
            <ul class="cart-items">
            
            	<!-- <li class="cart-item">
                
                	<span class="cart-trash"><i class="icon-trash"></i></span>
                    
                    <h4>Extra Images</h4>
                    <h5>Add up to 15 images</h5>
                    
                    <span class="price">$1</span>
                
                </li> -->
                <!-- .cart-item -->
            
            </ul>
            <!-- .cart-items -->
        
        </div>
        <!-- .large-8 -->
    
        <div class="large-4 columns cart-totals" style="display: none;">
        
            <div class="total"><?php _e('Cart Total:', 'btoa'); ?> <span>-</span></div>
            
            <p class="cart-info"><?php _e('Please check out before submitting. When checking out your submission is saved as a draft and all additionals will be made available after completing payment.', 'btoa'); ?></p>
            
            <a href="" class="button-primary" id="cart-checkout"><?php _e('Checkout now', 'btoa'); ?></a>
        
        </div>
        <!-- .large-8 -->
        
    </div>
    <!-- .row -->
    
</div>