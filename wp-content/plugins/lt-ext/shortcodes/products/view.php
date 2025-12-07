<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/**
 * Products Shortcode
 */

$args = get_query_var('like_sc_products');

$query_args = array(
	'post_type' => 'product',
	'post_status' => 'publish',
	'posts_per_page' => (int)($args['per_slide']),
);

//if ( $args['layout'] == 'simple' ) {
if ( !empty($args['category_filter']) ) {

	$query_args['tax_query'] = 	array(
			array(
	            'taxonomy'  => 'product_cat',
	            'field'     => 'if', 
	            'terms'     => array(esc_attr($args['category_filter'])),
			)
    );

	$query_args['posts_per_page'] = (int)($args['per_slide']);
}
//}
$cols = 3;
if ( !empty($args['cols']) ) {

	$cols = $args['cols'];
}

$query = new WP_Query( $query_args );
$currency = get_woocommerce_currency_symbol();

if ( $query->have_posts() ) {

	if ( $args['layout'] == 'filter-headers' OR $args['layout'] == 'filter-icons' ) {

		echo '<div class="woocommerce"><div class="products products-sc products-sc-default '.esc_attr($args['layout']).'">';

		$cats = ltxGetProductsCats();
		if ( !empty($atts['category_filter']) ) {

			$cats = $cats[$atts['category_filter']]['child'];
		}

		if ( !empty($cats) AND sizeof($cats) > 1 ) {

			echo '<ul class="cats tabs-cats slider-filter">';
			foreach ($cats as $catId => $cat) {

				if ( $args['layout'] == 'filter-icons' ) {

					echo '<li><span class="img" data-filter="'.esc_attr($catId).'"><img src="'.esc_url($cat['image']).'" alt="'.esc_attr($cat['name']).'"></span><span class="cat" data-filter="'.esc_attr($catId).'">'.esc_html($cat['name']).'</span></li>';
				}	
					else {

					echo '<li><span class="cat" data-filter="'.esc_attr($catId).'">'.esc_html($cat['name']).'</span></li>';
				}
			}
			echo '</ul>';
		}

		echo '<div class="items">
			<div>
		';

		$item_class = '';
		if ( $args['rate'] == 'hidden' ) $item_class = 'products-hide-rate';

		if ( !empty($args['per_slide']) ) {

			echo '<div class="swiper-container slider-filter-container products-slider" data-cols="'.esc_attr($args['per_slide']).'" data-autoplay="0">';		
		}		

		echo '<ul class="swiper-wrapper products products-sc posts-'.esc_attr($query->post_count).' '.esc_attr($item_class).'">';

		while ( $query->have_posts() ):

			$query->the_post();

			$filter_cat = 'swiper-slide	filter-item filter-type-0';
			$product_cats = wp_get_post_terms( get_the_ID(), 'product_cat' );
			if ( $product_cats && !is_wp_error ( $product_cats ) ) {
				foreach ($product_cats as $cat) {

					$filter_cat .= ' filter-type-'.$cat->term_id;
				}
			}	

			$product = $item = wc_get_product( get_the_ID() );
		?>
		<li id="post-<?php the_ID(); ?>" <?php post_class( esc_attr( $filter_cat ) ); ?>>
				<?php
					do_action('woocommerce_before_shop_loop_item_title')					
				?>
					<h2 class="woocommerce-loop-product__title"><?php the_title(); ?></h2>
				</a>
		        <?php
      
				    $excerpt = apply_filters('the_excerpt', get_the_excerpt());

				    if ( function_exists('FW') ){

						$cut = (int) fw_get_db_settings_option( 'excerpt_wc_auto' );
				    }
				    
					if (empty($cut)) $cut = 50;

					echo '<div class="post_content entry-content">'. wp_kses_post( sana_cut_text( $excerpt, $cut ) ).'</div>';			

	        		echo '<span class="price">'.$item->get_price_html().'</span>';

					echo apply_filters( 'woocommerce_loop_add_to_cart_link',
						sprintf( '<a rel="nofollow" href="%s" data-quantity="%s" data-product_id="%s" data-product_sku="%s" class="%s btn btn-xs add_to_cart_button">%s</a>',
							esc_url( $product->add_to_cart_url() ),
							esc_attr( isset( $quantity ) ? $quantity : 1 ),
							esc_attr( $product->get_id() ),
							esc_attr( $product->get_sku() ),
							$product->is_type( 'simple' ) ? 'ajax_add_to_cart' : '',
							esc_html( $product->add_to_cart_text() )
						),

					$product );
		
		        ?>  
		    </div>   		    
		</li>

		<?php
		endwhile;

		echo '</ul>';

		if ( !empty($args['per_slide']) ) {
/*
							<div class="arrows">
					<a href="#" class="arrow-left fa fa-arrow-circle-left"></a>
					<a href="#" class="arrow-right fa fa-arrow-circle-right"></a>
				</div>			
*/
			echo '
			</div>
				';

		}		

		echo '</div></div></div></div>';
	}
		else 
	
	if ( $args['layout'] == 'simple') {

		$item_class = '';
		if ( $args['rate'] == 'hidden' ) $item_class = 'products-hide-rate';

		echo '<div class="woocommerce"><ul class="products products-sc products-sc-simple columns-'.esc_attr($cols).' posts-'.esc_attr($query->post_count).' '.esc_attr($item_class).'">';

			while ( $query->have_posts() ):

				$query->the_post();

				if ( isset($single_cat->term_id) ) $current_cat = $single_cat->term_id;
				if ( empty($current_cat) ) $current_cat = '';

				$product = $item = wc_get_product( get_the_ID() );
			?>
			<li id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

			<?php

			if ( !function_exists('is_product_sc') ) {

				function is_product_sc() {

					return true;
				}
			}

			do_action( 'woocommerce_before_shop_loop_item' );

			do_action( 'woocommerce_before_shop_loop_item_title' );

			do_action( 'woocommerce_shop_loop_item_title' );

			do_action( 'woocommerce_after_shop_loop_item_title' );

			do_action( 'woocommerce_after_shop_loop_item' );
			?>
	    
			</li>
		<?php
		endwhile;

		echo '</ul></div>';		
	}
	

	wp_reset_postdata();
}


