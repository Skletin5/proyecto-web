<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(
	'main' => array(
		'title'   => false,
		'type'    => 'box',
		'options' => array(
			'header'    => array(
				'label' => esc_html__( 'Alternative Header', 'sana' ),
				'desc' => esc_html__( 'Use {{ brackets }} to headlight', 'sana' ),
				'type'  => 'text',
			),					
			'cut'    => array(
				'label' => esc_html__( 'Short Description', 'sana' ),
				'type'  => 'textarea',
			),							
			'price'    => array(
				'label' => esc_html__( 'Price', 'sana' ),
				'desc' => esc_html__( 'Use {{ brackets }} to headlight', 'sana' ),
				'type'  => 'text',
			),					
			'link'    => array(
				'label' => esc_html__( 'External Link', 'sana' ),
				'type'  => 'text',
			),		
			'header-background-image'    => array(
				'label' => esc_html__( 'Header Background Image', 'sana' ),
				'type'  => 'upload',
			),					
		),
	),
);

