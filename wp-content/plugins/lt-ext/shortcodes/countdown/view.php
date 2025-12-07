<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/**
 * Shortcode CountDown
 */

$args = get_query_var('like_sc_countdown');

$class = '';
if ( !empty($args['class']) ) $class .= ' '. esc_attr($args['class']);
if ( !empty($args['id']) ) $id = ' id="'. esc_attr($args['id']). '"'; else $id = '';

$class .= 'type-'.$args['type'];

$args['template'] = urldecode(base64_decode($args['template']));

echo '
	<div class="ltx-countdown '.esc_attr($class).'" '.$id.' data-date="'.esc_attr($args['date']).'" data-template="'.esc_attr(($args['template'])).'"></div>
';
