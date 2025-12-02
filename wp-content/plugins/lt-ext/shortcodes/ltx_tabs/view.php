<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/**
 * ltx_tabs Shortcode
 */
$args = get_query_var('like_sc_ltx_tabs');

$class = "";
if ( !empty($atts['class']) ) $class .= ' '. esc_attr($atts['class']);
if ( !empty($atts['id']) ) $id = ' id="'. esc_attr($atts['id']). '"'; else $id = '';

?>
<div class="ltx-tabs <?php echo esc_attr( $class ); ?>" <?php echo $id; ?> >
	<div class="row">
		<div class="col-md-8 col-md-push-4" data-mh="ltx-tabs">
			<div class="blocks-large">
				<?php if ( !empty($atts['items']) ) foreach ( $atts['items'] as $key => $item ) : ?>
				<div class="block-large block-<?php echo (int) ($key); 
						$image = '';
						if ( !empty($item['image']) ) {

							$image = ltx_get_attachment_img_url( $item['image'] );
							$image = $image[0];
						}
						if ( $key == 0 ) { echo ' active';} ?>" style="background-image: url(<?php echo esc_attr( $image ); ?>)">
					<?php if ( ! empty( $item['btn_href'] ) ) : ?><a href="<?php echo esc_url( $item['btn_href'] ); ?>" class="btn btn-lg color-hover-white"><?php echo esc_html( $item['btn_header'] ); ?></a><?php endif; ?>
				</div><?php endforeach; ?>
			</div>
		</div>
		<div class="col-md-4 col-md-pull-8" data-mh="ltx-tabs">
			<div class="items">
				<?php if ( !empty($atts['items']) ) foreach ( $atts['items'] as $key => $item ) : ?>		
				<a href="#" class="item item-<?php echo (int) ($key); ?><?php if ( $key == 0 ) { echo ' active';} ?>" data-block="block-<?php echo (int) ($key); ?>">
					<span class="header"><?php echo esc_html( $item['header'] ); ?></span>
					<p><?php echo esc_html( $item['descr'] ); ?></p>
				</a><?php endforeach; ?>
			</div>
		</div>
	</div>
</div>