<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}


$options = array(
	'theme_block' => array(
		'title'   => esc_html__( 'Theme Block', 'sana' ),
		'label'   => esc_html__( 'Theme Block', 'sana' ),
		'type'    => 'select',
		'choices' => array(
			'none'  => esc_html__( 'Not Assigned', 'sana' ),
			'before_footer'  => esc_html__( 'Before Footer', 'sana' ),
			'subscribe'  => esc_html__( 'Subscribe', 'sana' ),
			'top_bar'  => esc_html__( 'Top Bar', 'sana' ),
		),
		'value' => 'none',
	)
);


