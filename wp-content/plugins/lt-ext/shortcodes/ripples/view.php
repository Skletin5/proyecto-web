<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/**
 * Shortcode
 */

$args = get_query_var('like_sc_ripples');

$image = ltx_get_attachment_img_url( $args['image'] );

echo '
<div class="ltx-ripples-bg" style="background-image: url('.esc_attr($image[0]).');">
	<div class="ltx-ripples-bg-2" style="background-image: url('.esc_attr($image[0]).');"></div>
	<div class="ltx-ripples-content"><div class="container">'.do_shortcode( $content ).'</div></div>

	<svg xlmns="http://www.w3.org/2000/svg" version="1.1">
	  <filter id="turbulence" filterUnits="objectBoundingBox" x="0" y="0" width="100%" height="100%">
	    <feTurbulence id="feturbulence" type="fractalNoise" numOctaves="3" seed="2"></feTurbulence>
	    <feDisplacementMap xChannelSelector="G" yChannelSelector="B" scale="20" in="SourceGraphic"></feDisplacementMap>
	  </filter>
	</svg>
	<svg xlmns="http://www.w3.org/2000/svg" version="1.1">
	  <filter id="turbulence2" filterUnits="objectBoundingBox" x="0" y="0" width="100%" height="100%">
	    <feTurbulence id="feturbulence2" type="fractalNoise" numOctaves="30" seed="202"></feTurbulence>
	    <feDisplacementMap xChannelSelector="G" yChannelSelector="B" scale="40" in="SourceGraphic"></feDisplacementMap>
	  </filter>
	</svg>	
</div>
';



