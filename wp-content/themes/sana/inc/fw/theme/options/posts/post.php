<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}


$options = array(
	'main' => array(
		'title'   => 'LTX Post Format',
		'type'    => 'box',
		'options' => array(
			'featured'    => array(
				'label' => esc_html__( 'Featured Post', 'sana' ),
				'type'  => 'checkbox',
			),			
			'gallery'    => array(
				'label' => esc_html__( 'Gallery', 'sana' ),
				'desc' => esc_html__( 'Upload featured images for slider gallery post type', 'sana' ),
				'type'  => 'multi-upload',
			),				
		),
	),
);

