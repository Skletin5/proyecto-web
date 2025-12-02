<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/**
 * Products Shortcode
 */

$args = get_query_var('like_sc_products_categories');

$query_args = array(
     'taxonomy'     => 'product_cat',
     'orderby'      => 'name',
     'show_count'   => 0,
     'pad_counts'   => 0,
     'hierarchical' => 1,
     'title_li'     => '',
     'hide_empty'   => 0
);

if ( !empty($args['ids']) ) {

	$query_args['include'] = esc_attr($args['ids']);
}

if ( !empty($args['orderby']) ) {

	$query_args['orderby'] = $args['orderby'];
}		

if ( !empty($args['limit'])) {

	$query_args['number'] = $args['limit'];
}

$cats = array();
$list = get_categories( $query_args );

foreach ($list as $cat) {

	if (esc_html($cat->name) == 'Uncategorized' OR empty($cat->name) ) continue;

	$thumbnail_id = get_term_meta( $cat->term_id, 'thumbnail_id', true ); 
    if ( !empty($thumbnail_id) ) {

    	$image = wp_get_attachment_image_src($thumbnail_id, 'sana-wc-cat');
    }
    	else {

    	$image = null;
    }

	if ($cat->category_parent == 0) {

	    $cats[$cat->term_id]['href'] = get_term_link($cat->slug, 'product_cat');
	    $cats[$cat->term_id]['name'] = $cat->name;
	    $cats[$cat->term_id]['description'] = $cat->description;
	    $cats[$cat->term_id]['image'] = $image;

	}
		else {

	    $cats[$cat->category_parent]['child'][$cat->term_id] = array(

	    	'href' => get_term_link($cat->slug, 'product_cat'),
	    	'name' => $cat->name,
	    	'image' => $image,
	    );		    
	}
}	

$cols = '';
if ( $args['columns'] == 1) {

	$cols = 'col-xs-12';
}
	else
if ( $args['columns'] == 2) {

	$cols = 'col-lg-6 col-md-6 col-sm-6 col-ms-12 col-xs-12';
}
	else
if ( $args['columns'] == 3) {

	$cols = 'col-lg-4 col-md-4 col-sm-6 col-ms-12 col-xs-12';
}
	else
if ( $args['columns'] == 4) {

	$cols = 'col-lg-3 col-md-6 col-sm-6 col-ms-12 col-xs-12';
}

if ( !empty($cats) ) {

	echo '<div class="ltx-products-cats-sc row centered">';	

	foreach ( $cats as $tid => $item ) {

		echo '<div class="'.esc_attr($cols).' item">';


		$header = fw_get_db_term_option($tid, 'product_cat', 'subheader');

		if ( !empty( $header) )  {

			$header = str_replace(array('{{', '}}'), array('<span>', '</span>'), $header);
		}
			else {

			$header = $item['name'];
		}

		echo '<a href="'.esc_url($item['href']).'">';
			
			if ( !empty($item['image']) ) {

				echo '<span class="image"><span class="ltx-border-top"></span><span class="ltx-border-bottom"></span><img src="'.esc_url($item['image'][0]).'" alt="'.esc_attr($item['name']).'"></span>';
			}
			echo '<h4 class="header">'.wp_kses_post($header).'</h4>';
/*			
			echo '<p>'.esc_html($item['description']).'</p>';

			if ( !empty( $args['more_text'] ) ) {

				echo '<span class="btn btn-xs">'.esc_html($args['more_text']).'</span>';
			}
*/			
		echo '</a>';
		echo '</div>';		
	} 

	echo '</div>';
}


