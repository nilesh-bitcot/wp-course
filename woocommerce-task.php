<?php
add_action( 'woocommerce_before_add_to_cart_button', 'add_slogan_text_input_box' );

function add_slogan_text_input_box() {
	global $product;
    if ( ! has_term( 'customized-product', 'product_cat', $product->get_id() ) ) {
		return;
	}
    ?>
	<div class="slogan-text-field">
		<label for="slogan_text">Enter Slogan: </label>
		<input type="text" id="slogan_text" name="slogan_text" placeholder="Enter a slogan">
        <p class="info">slogan fixed charges: +$0.15</p>
        <p class="info">each char after >15: +$0.10</p>
	</div>
    <?php
}


add_action( 'woocommerce_add_to_cart_validation', 'slogan_text_input_box_validation', 10, 2 );
function slogan_text_input_box_validation( $result, $product_id ) {

	if( has_term( 'customized-product', 'product_cat', $product_id ) && empty( $_REQUEST[ 'slogan_text' ] ) ) {
		wc_add_notice( 'Please enter a slogan', 'error' );
		return false;
	}	
	return $result;
}


/**
 * It is importaint to remove add to cart button from product loop items other wise product will be added without slogan text
 */

add_filter( 'woocommerce_loop_add_to_cart_link', 'change_add_to_cart_url_and_title_for_slogan', 25, 2 );

function change_add_to_cart_url_and_title_for_slogan( $html, $product ) {

	if( has_term( 'customized-product', 'product_cat', $product->get_id() ) ) {
		return sprintf(
			'<a href="%s" class="button">Read more</a>',
			esc_url( $product->get_permalink() )
		);
	}
	return $html;
}


add_action( 'woocommerce_before_calculate_totals', 'update_price_per_slogan_length' );

function update_price_per_slogan_length( $cart_object ) {
    foreach ( $cart_object->cart_contents as $key => $value ) {
        if( isset($value['slogan_text']) && !empty($value['slogan_text']) ){
            $custom_price = calculate_extra_slogan_cost($value);
            $price = $value['data']->get_price();
            $value['data']->set_price( $price + $custom_price );     
        }
    }
}

function calculate_extra_slogan_cost($item){
    if( isset($item['slogan_text']) && !empty($item['slogan_text']) ){
        $custom_price = 0.15;
        $len = strlen($item['slogan_text']);
        $custom_price = ($len > 15) ? $custom_price + ($len - 15) * 0.10 : $custom_price;
    }
    return $custom_price;
}

add_filter( 'woocommerce_add_cart_item_data', 'save_slogan_text_to_cart_data', 10, 3 );

function save_slogan_text_to_cart_data( $cart_item_data, $product_id, $variation_id ) {

	if( ! empty( $_POST[ 'slogan_text' ] ) ) { // here could be another validation if you need
		$cart_item_data[ 'slogan_text' ] = sanitize_text_field( $_POST[ 'slogan_text' ] );
        $cart_item_data['slogan_cost'] = calculate_extra_slogan_cost($cart_item_data);
	}

	return $cart_item_data;
}

// show Slogan text in Cart
add_filter( 'woocommerce_get_item_data', 'show_slogan_text_on_cart', 10, 2 );

function show_slogan_text_on_cart( $item_data, $cart_item ) {

	if( ! empty( $cart_item[ 'slogan_text' ] ) ) {
		$item_data[] = array(
			'key'     => 'Slogan on tshirt',
			'value'   => $cart_item[ 'slogan_text' ],
			'display' => '',
		);
        $item_data[] = array(
			'key'     => 'Extra added cost',
			'value'   => $cart_item[ 'slogan_cost' ],
			'display' => '',
		);
	}

	return $item_data;
}

add_action( 'woocommerce_checkout_create_order_line_item', 'add_slogan_text_order_item_meta', 10, 4 );

function add_slogan_text_order_item_meta( $item, $cart_item_key, $values, $order ) {

	if ( ! empty( $values[ 'slogan_text' ] ) ) {
		$item->add_meta_data( 'slogan_text', $values[ 'slogan_text' ] );
    }
    if ( ! empty( $values[ 'slogan_cost' ] ) ) {
	   $item->add_meta_data( 'slogan_cost', $values[ 'slogan_cost' ] );
	}

}


/**
 * Add cart count in menu item
 */
add_filter( 'wp_nav_menu_items', 'add_cart_count_item_to_nav_menu', 10, 2 );
function add_cart_count_item_to_nav_menu( $items, $args ) {
    // print_r($args);
    if( $args->menu->slug === 'menu-1' ){
        $items .= '<li><a class="neo_cart_menu">Cart ( '.count(wc()->cart->get_cart()).' )</a></li>';
    }        
    return $items;
}

add_filter( 'woocommerce_add_to_cart_fragments', 'cart_count_item_add_to_cart_fragment' );

function cart_count_item_add_to_cart_fragment( $fragments ) {

	$fragments[ '.neo_cart_menu' ] = '<a class="neo_cart_menu">Cart ( '.count(wc()->cart->get_cart()).' )</a>';
 	return $fragments;

 }