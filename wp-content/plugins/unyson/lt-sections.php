<?php

if ( !function_exists('lt_get_sections_safe') ) {

	function lt_get_sections_safe() {

		static $list;
		$default = array('top_bar', 'before_footer', 'subscribe');

		if ( empty($list) ) {

			$posts = get_posts(array(
				'post_type' => 'sections',
				'numberposts' => -1,
			));

			if ( !empty($posts) ) {

				foreach ( $posts as $post ) {

					$tid = fw_get_db_post_option($post->ID, 'theme_block');
					$list[$tid][$post->ID] = $post->post_title;
				}
			}			
		}

		foreach ( $default as $item ) {

			if ( empty($list[$item]) ) {

				$list[$item] = array();
			}
		}

		return $list;
	}
}

if ( !function_exists('alavion_get_sections') ) { function alavion_get_sections() { return lt_get_sections_safe(); } }
if ( !function_exists('aqualine_get_sections') ) { function aqualine_get_sections() { return lt_get_sections_safe(); } }
if ( !function_exists('brewis_get_sections') ) { function brewis_get_sections() { return lt_get_sections_safe(); } }
if ( !function_exists('bubulla_get_sections') ) { function bubulla_get_sections() { return lt_get_sections_safe(); } }
if ( !function_exists('calmes_get_sections') ) { function calmes_get_sections() { return lt_get_sections_safe(); } }
if ( !function_exists('crems_get_sections') ) { function crems_get_sections() { return lt_get_sections_safe(); } }
if ( !function_exists('fitmeal_get_sections') ) { function fitmeal_get_sections() { return lt_get_sections_safe(); } }
if ( !function_exists('gomoto_get_sections') ) { function gomoto_get_sections() { return lt_get_sections_safe(); } }
if ( !function_exists('holamed_get_sections') ) { function holamed_get_sections() { return lt_get_sections_safe(); } }
if ( !function_exists('hub2b_get_sections') ) { function hub2b_get_sections() { return lt_get_sections_safe(); } }
if ( !function_exists('indicana_get_sections') ) { function indicana_get_sections() { return lt_get_sections_safe(); } }
if ( !function_exists('jointup_get_sections') ) { function jointup_get_sections() { return lt_get_sections_safe(); } }
if ( !function_exists('kaffa_get_sections') ) { function kaffa_get_sections() { return lt_get_sections_safe(); } }
if ( !function_exists('lamaro_get_sections') ) { function lamaro_get_sections() { return lt_get_sections_safe(); } }
if ( !function_exists('limme_get_sections') ) { function limme_get_sections() { return lt_get_sections_safe(); } }
if ( !function_exists('mildar_get_sections') ) { function mildar_get_sections() { return lt_get_sections_safe(); } }
if ( !function_exists('mirasat_get_sections') ) { function mirasat_get_sections() { return lt_get_sections_safe(); } }
if ( !function_exists('ollis_get_sections') ) { function ollis_get_sections() { return lt_get_sections_safe(); } }
if ( !function_exists('paritime_get_sections') ) { function paritime_get_sections() { return lt_get_sections_safe(); } }
if ( !function_exists('queeny_get_sections') ) { function queeny_get_sections() { return lt_get_sections_safe(); } }
if ( !function_exists('recond_get_sections') ) { function recond_get_sections() { return lt_get_sections_safe(); } }
if ( !function_exists('sana_get_sections') ) { function sana_get_sections() { return lt_get_sections_safe(); } }
if ( !function_exists('weisber_get_sections') ) { function weisber_get_sections() { return lt_get_sections_safe(); } }
if ( !function_exists('windazo_get_sections') ) { function windazo_get_sections() { return lt_get_sections_safe(); } }

