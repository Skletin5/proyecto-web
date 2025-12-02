<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/**
 * Block Icons Shortcode
 */

if ( !empty($atts['header_type']) ) $tag = 'h'.$atts['header_type']; else $tag = 'h5';

$class = '';
if ( !empty($atts['class']) ) $class .= ' '. esc_attr($atts['class']);
if ( !empty($atts['id']) ) $id = ' id="'. esc_attr($atts['id']). '"'; else $id = '';

$mid = mt_rand(1000, 2000);
$icons_count = sizeof($atts['icons']);

$row = '';
if ($atts['layout'] == 'layout-cols2' OR $atts['layout'] == 'layout-cols3' OR $atts['layout'] == 'layout-cols4' OR $atts['layout'] == 'layout-cols6') {

	$row .= ' row centered';
}

foreach ( $atts['icons'] as $item ) {

	if ( !empty($item['descr']) ) {

		$class .= ' has-descr ';

		break;
	}	
}


echo '<ul class="ltx-block-icon icons-count-'.esc_attr($icons_count).' ' . esc_attr( $class ) .' ' . esc_attr($atts['type']).' align-' . esc_attr($atts['align']) . ' ltx-icon-color-' . esc_attr($atts['icon-color']) . ' ltx-icon-type-' . esc_attr($atts['icon-type']) . ' ' . esc_attr($atts['layout']) .' '.esc_attr( $row ).'" '.$id.'>';

	$x = 0;
	foreach ( $atts['icons'] as $item ) {

		$x++;
		$li_class = '';

		if ($atts['layout'] == 'layout-cols2') {

			$li_class .= 'col-xl-6 col-lg-6 col-md-6 col-sm-12 col-ms-12 col-xs-12';
		}
			else
		if ($atts['layout'] == 'layout-cols3') {

			$li_class .= ' col-lg-4 col-md-4 col-sm-4 col-ms-4 col-xs-12';
		}
			else
		if ($atts['layout'] == 'layout-cols4') {

			if ( $icons_count == 4) {

				$li_class .= ' col-lg-3 col-md-6 col-sm-6 col-ms-12 col-xs-12';
			}
				else {

				$li_class .= ' col-lg-3 col-md-4 col-sm-6 col-ms-6 col-xs-12';
			}
		}
			else
		if ($atts['layout'] == 'layout-cols6') {

			if ( $icons_count == 6) {
				$li_class .= ' col-lg-2 col-md-4 col-sm-4 col-xs-6 matchHeight ';
			}	
				else 
			if ( $icons_count == 4) {

				$li_class .= ' col-lg-3 col-md-3 col-sm-6 col-xs-6 matchHeight ';
			}
				else 
			if ( $icons_count == 3) {

				$li_class .= ' col-lg-4 col-md-4 col-sm-4 col-xs-6 matchHeight ';
			}
		}

		if (!empty($item['bold']) AND $item['bold'] == 'bold') $li_class .= ' item-bold ';


		if ( empty($item['header'])) {

			$item['header'] = '';
		}

		$item['header'] = str_replace(array('{{', '}}'), array('<span>', '</span>'), $item['header']);

		if (!empty($item['icon_fontawesome'])) {

			$a_class = $item['icon_fontawesome'];
		}
			else
		if (!empty($item['icon_image'])) {

			$a_class = 'ltx-icon-image';
			$li_class .=  ' icon-image';
		}		
			else {

			$a_class = 'ltx-icon-text';
		}

		if ($atts['layout'] == 'layout-inline') {

			$a_class .= ' ';			
			$in_class = '';
		}
			else {

			$in_class = 'in matchHeight';
		}


		if ( $atts['type'] == 'ltx-price-grid' ) {

			$in_class = 'in';
			if ( $icons_count == 4 ) {

				$li_class = ' col-lg-3 col-md-6 col-sm-6 col-ms-12 col-xs-12 ';
			}
				else
			if ( $icons_count == 3 ) {

				$li_class = ' col-lg-4  col-md-12  col-sm-12  col-ms-12 col-xs-12';
			}
				else
			if ( $icons_count == 2 ) {

				$li_class = ' col-lg-6 col-md-6 col-sm-12  col-ms-12 col-xs-12';
			}			
		}


		if ( !empty($atts['bg']) ) {

			$a_class .= ' '.esc_attr($atts['bg']);
		}

		if ( !empty($atts['bg-col']) ) $a_class .= ' bg-'.esc_attr($atts['bg-col']);


		$href_tag1 = $href_tag2 = '';
		$div_tag1 = $div_tag2 = '';
		$image_tag = '';

		if ($atts['type'] == 'ltx-icon-ht-right' OR $atts['type'] == 'ltx-icon-ht-left' OR $atts['layout'] == 'layout-inline') {

			$div_tag1 = '<div class="block-right">';
			$div_tag2 = '</div>';

			if (!empty($item['href'])) {

				$div_tag1 = '<a href="'. esc_url( $item['href'] ) .'" class="block-right">';
				$div_tag2 = '</a>';
			}
		}


		if (empty($item['icon_text'])) $item['icon_text'] = '';
		$href_tag1 = '<span class="ltx-icon '. esc_attr( $a_class ) . '" data-mh="ltx-icon-span-'.esc_attr($atts['id']).'">' . esc_html( $item['icon_text'] );
		$href_tag2 = '</span>';

		if ( !empty($item['icon_image']) ) {

			$image = ltx_get_attachment_img_url( $item['icon_image'] );
			$image_tag = '<img src="' . $image[0] . '" class="ltx-icon-image" alt="'.esc_attr($item['header']).'">';
		}

		if ( !empty($item['header']) ) {

			if ( $atts['header_type'] == 'text-small' ) {

				$item['header'] = ' <strong class="header"> ' . wp_kses_post( nl2br($item['header']) )  .  ' </strong> ';
			}
				else {

				$item['header'] = ' <'. esc_attr($tag) .' class="header"> ' . wp_kses_post( nl2br($item['header']) )  .  ' </'. esc_attr($tag) .'> ';
			}
		}

		if ( empty($item['descr'])) $item['descr'] = '';

		if ($atts['layout'] == 'layout-cols3' AND $x == 3) {

			$li_class .= ' ';
		}		

		if ( !empty($li_class) ) $li_class = ' class="'.esc_attr($li_class).'"';

		$descr = '';
		if ( !empty($item['descr']) ) {

			$descr = '<div class="descr">'. esc_html( $item['descr'] ) . '</div>';
		}

		if (!empty($item['href'])) {

			$wrap_tag1 = 'a href="'. esc_url( $item['href'] ) .'" ';
			$wrap_tag2 = '</a>';
		}
			else {

			$wrap_tag1 = 'div ';
			$wrap_tag2 = '</div>';
		}

		echo '<li'.$li_class.' ><'.$wrap_tag1.
		' data-mh="ltx-block-icon-in-'.esc_attr($mid).'" class="'.esc_attr($in_class).'">' . $href_tag1 . $image_tag . $href_tag2 
		. $div_tag1 . $item['header'] . wp_kses_post( $descr ) . $div_tag2 . $wrap_tag2 . '</li>';
	}

echo '</ul>';


