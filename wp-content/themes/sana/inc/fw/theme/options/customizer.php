<?php if ( ! defined( 'FW' ) ) { die( 'Forbidden' ); }

$sana_cfg = sana_theme_config();

$options = array(
    
    'sana_customizer' => array(
        'title' => esc_html__('Sana settings', 'sana'),
        'position' => 1,
        'options' => array(

            'main_color' => array(
                'type' => 'color-picker',
                'value' => $sana_cfg['color_main'],
                'label' => esc_html__('Main Color', 'sana'),
            ),  
            'gray_color' => array(
                'type' => 'color-picker',
                'value' => $sana_cfg['color_gray'],
                'label' => esc_html__('Gray Color', 'sana'),
            ),
            'black_color' => array(
                'type' => 'color-picker',
                'value' => $sana_cfg['color_black'],
                'label' => esc_html__('Black Color', 'sana'),
            ),      
            'red_color' => array(
                'type' => 'color-picker',
                'value' => $sana_cfg['color_red'],
                'label' => esc_html__('Red Color', 'sana'),
            ),
            'white_color' => array(
                'type' => 'color-picker',
                'value' => $sana_cfg['color_white'],
                'label' => esc_html__('White Color', 'sana'),
            ),                          
            'nav_opacity' => array(
                'type'  => 'slider',
                'value' => 0,
                'properties' => array(
                    'min' => 0,
                    'max' => 1,
                    'step' => 0.05,
                ),
                'label' => esc_html__('Navbar Opacity (0 - 1)', 'sana'),
            ), 
            'nav_opacity_scroll' => array(
                'type'  => 'slider',
                'value' => 0.95,
                'properties' => array(
                    'min' => 0,
                    'max' => 1,
                    'step' => 0.05,
                ),
                'label' => esc_html__('Navbar Sticked Opacity (0 - 1)', 'sana'),
            ),
            'logo_height' => array(
                'type'  => 'slider',
                'value' => 140,
                'properties' => array(

                    'min' => 20,
                    'max' => 160,
                    'step' => 1,

                ),
                'label' => esc_html__('Logo Max Height, px', 'sana'),
            ),        
        ),
    ),
);

