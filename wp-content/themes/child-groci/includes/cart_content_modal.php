	  <?php	global $woocommerce; ?>
      <div class="cart-sidebar">
         <div class="cart-sidebar-header">
            <h5>
               <?php esc_html_e('My Cart','groci'); ?> <span class="text-success">(<?php echo sprintf(_n('%d item', '%d items', $woocommerce->cart->cart_contents_count, 'groci'), $woocommerce->cart->cart_contents_count);?>)</span> <a data-toggle="offcanvas" class="float-right" href="#"><i class="mdi mdi-close"></i>
               </a>
            </h5>
         </div>
         <div class="cart-sidebar-body cart_list product_list_widget">
		    <?php if (sizeof($woocommerce->cart->cart_contents)>0) {
				foreach ($woocommerce->cart->cart_contents as $cart_item_key => $cart_item){
					$_product = $cart_item['data'];
					if ($_product->exists() && $cart_item['quantity']>0){
						
					$image_src = get_the_post_thumbnail_url( $_product->get_id(), 'full' );
					$stock_status = $_product->get_stock_status();
					$percentage = ceil(100 - ($_product->get_sale_price() / $_product->get_regular_price()) * 100);
					$weight = $_product->get_weight();
					$price = $_product->get_price_html();

					?>

					<div class="cart-list-product">
					   <a class="float-right remove-cart" href="<?php echo wc_get_cart_remove_url( $cart_item_key ); ?>"><i class="mdi mdi-close"></i></a>
					   <img class="img-fluid" src="<?php echo esc_url($image_src); ?>" alt="<?php echo esc_attr($_product->get_title()); ?>">
					   <?php if( $_product->get_sale_price() && $_product->get_regular_price()){ ?>
					   <span class="badge badge-success"><?php echo esc_html($percentage); ?> <?php esc_html_e('% OFF','groci'); ?></span>
					   <?php } ?>
					   <h5><a href="<?php echo esc_url( get_permalink( intval( $cart_item['product_id'] ) ) ); ?>"><?php echo esc_html($_product->get_title()); ?></a></h5>
					   <h6><strong><span class="mdi mdi-approval"></span> <?php esc_html($stock_status); ?></strong> - <?php echo esc_html($weight); ?> <?php echo esc_html(get_option('woocommerce_weight_unit')); ?></h6>
					   <p class="offer-price mb-0"><?php echo groci_sanitize_data($price); ?></p>
					</div>
			
		
					<?php } ?>
				<?php } ?>
			<?php } else { ?>
			<div class="cart-list-product">
			  <?php esc_html_e( 'No products in the cart.', 'groci'); ?>
			</div>
			<?php } ?>
         </div>
		 <?php if ( sizeof( $woocommerce->cart->cart_contents ) > 0 ) { ?>
         <div class="cart-sidebar-footer">
            <div class="cart-store-details">
			   <?php $cart_subtotal = WC()->cart->get_cart_total(); ?>
			   <?php $cart_shipping = WC()->cart->get_cart_shipping_total(); ?>
			   
               <p><?php esc_html_e('Sub Total','groci'); ?> <strong class="float-right"><?php echo groci_sanitize_data($cart_subtotal); ?></strong></p>
               <p><?php esc_html_e('Delivery Charges','groci'); ?> <strong class="float-right text-danger"><?php echo groci_sanitize_data($cart_shipping); ?></strong></p>

            </div>
            <a href="<?php echo esc_url( wc_get_checkout_url() ); ?>"><button class="btn btn-secondary btn-lg btn-block text-left" type="button">
			<span class="float-left"><i class="mdi mdi-cart-outline"></i> <?php esc_html_e('Proceed to Checkout','groci'); ?> </span><span class="float-right"><strong><?php echo groci_sanitize_data($cart_subtotal); ?></strong> <span class="mdi mdi-chevron-right"></span></span></button></a>
         </div>
		 <?php } ?>
      </div>