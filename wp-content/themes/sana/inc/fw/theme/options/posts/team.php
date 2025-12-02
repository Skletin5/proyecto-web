<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(
	'main' => array(
		'title'   => false,
		'type'    => 'box',
		'options' => array(
			'cut'    => array(
				'label' => esc_html__( 'Short Description', 'sana' ),
				'type'  => 'textarea',
			),			
			'items' => array(
				'label' => esc_html__( 'Social Icons For List', 'sana' ),
				'type' => 'addable-box',
				'value' => array(),
				'box-options' => array(
					'icon' => array(
						'label' => esc_html__( 'Icon', 'sana' ),
						'type'  => 'icon',
					),
					'href' => array(
						'label' => esc_html__( 'Link', 'sana' ),
						'desc' => esc_html__( 'If needed', 'sana' ),
						'type' => 'text',
						'value' => '#',
					),
				),
				'template' => '{{- icon }}',
			),			
		),
	),		
);

