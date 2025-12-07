<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(
	'main' => array(
		'title'   => '',
		'type'    => 'box',
		'options' => array(
			'subheader'    => array(
				'label' => esc_html__( 'Additional Header', 'sana' ),
				'desc' => esc_html__( 'Use {{ to highlight }} the word', 'sana' ),
				'type'  => 'text',
			),			
		),
	),
);

