<?php
/*
* Plugin Name:       Royal Media
* Description:       Home base for all of Royal Media’s custom functionality.
* Version:           1.0.0
* Author:            Royal Media (Kyle Michael Sullivan)
* Author URI:        https://royalmedia.com/
* License:           GPL v3 or later
* License URI:       https://www.gnu.org/licenses/gpl-3.0.html
* Text Domain:       rmg
*/

/* CONSTANTS */
define( 'RMG_VERSION', '1.0.0' );
define( 'RMG_PATH', plugin_dir_path( __FILE__ ) );
define( 'RMG_URL', plugin_dir_url( __FILE__ ) );

/* FUNCTIONS */
// get_id_from_tag()
if( ! function_exists( 'get_id_from_tag' ) ) {
	function get_id_from_tag( $slug ) {
		return get_term_by( 'slug', $slug, 'post_tag' )->term_id;
	}
}

// is_recent()
if( ! function_exists( 'is_recent' ) ) {
	function is_recent( $updated ) {
		$duration = get_field( 'new_duration', 'options' );
		$past = strtotime( "-$duration day" );

		return $updated > $past;
	}
}

/* ENQUEUES */
// enqueue_img_alt()
if( ! function_exists( 'enqueue_img_alt' ) ) {
	function enqueue_img_alt() {
		wp_enqueue_script( 'img-alt-js',
			RMG_URL . 'img-alt.js',
			array( 'jquery' )
		);
	}
	add_action( 'wp_enqueue_scripts', 'enqueue_img_alt' );
}

// enqueue_rmg_styles()
if( ! function_exists( 'enqueue_rmg_styles' ) ) {
	function enqueue_rmg_styles() {
		wp_enqueue_style( 'rmg-style-css',
			RMG_URL . 'style.css'
		);
	}
	add_action( 'wp_enqueue_scripts', 'enqueue_rmg_styles' );
}

/* ACF */
if( function_exists( 'get_field' ) ) {
	// Add Royal Media (Theme Settings)
	if( function_exists('acf_add_options_page') ) {
		$icon = 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBzdGFuZGFsb25lPSJubyI/Pgo8IURPQ1RZUEUgc3ZnIFBVQkxJQyAiLS8vVzNDLy9EVEQgU1ZHIDIwMDEwOTA0Ly9FTiIKICJodHRwOi8vd3d3LnczLm9yZy9UUi8yMDAxL1JFQy1TVkctMjAwMTA5MDQvRFREL3N2ZzEwLmR0ZCI+CjxzdmcgdmVyc2lvbj0iMS4wIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciCiB3aWR0aD0iNTEyLjAwMDAwMHB0IiBoZWlnaHQ9IjUxMi4wMDAwMDBwdCIgdmlld0JveD0iMCAwIDUxMi4wMDAwMDAgNTEyLjAwMDAwMCIKIHByZXNlcnZlQXNwZWN0UmF0aW89InhNaWRZTWlkIG1lZXQiPgoKPGcgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoMC4wMDAwMDAsNTEyLjAwMDAwMCkgc2NhbGUoMC4xMDAwMDAsLTAuMTAwMDAwKSIKZmlsbD0iIzAwMDAwMCIgc3Ryb2tlPSJub25lIj4KPHBhdGggZD0iTTI0MCA0Mzc1IGMwIC00IDE0NjYgLTE2OTYgMTU1MiAtMTc5MSAxOCAtMjEgMTUgLTI1IC03NjcgLTkyNyAtNDMyCi00OTkgLTc4NSAtOTA5IC03ODUgLTkxMiAwIC0zIDE5NyAtNSA0MzggLTUgbDQzOSAwIDc4NCA5MDIgYzQzMSA0OTYgNzg0IDkwOQo3ODQgOTE4IDAgOSAtMzUxIDQyMiAtNzgwIDkxNyBsLTc4MCA5MDIgLTQ0MiAxIGMtMjQ0IDAgLTQ0MyAtMiAtNDQzIC01eiIvPgo8cGF0aCBkPSJNMTQyMiA0MzUzIGMzOCAtNDIgMTU0OCAtMTc4MiAxNTUxIC0xNzg3IDEgLTMgLTMyNCAtMzgyIC03MjMgLTg0MgotMzk5IC00NjAgLTc1MyAtODcwIC03ODggLTkxMCBsLTYzIC03NCA0NDMgMCA0NDMgMSA3ODQgOTAzIGM0MzIgNDk2IDc4NiA5MDcKNzg4IDkxMiAyIDYgLTM1MCA0MTggLTc4MiA5MTcgbC03ODYgOTA3IC00NDYgMCAtNDQ3IDAgMjYgLTI3eiIvPgo8cGF0aCBkPSJNMjU4MSA0MzYzIGM4IC05IDM2MiAtNDE3IDc4NyAtOTA3IDQyNSAtNDg5IDc3MSAtODkyIDc3MCAtODk2IC0yCi00IC0zNTUgLTQxNCAtNzg2IC05MTEgbC03ODMgLTkwNCA0MzMgLTMgYzIzOCAtMSA0MzggMCA0NDQgMiAxNSA2IDE1NzkgMTgwNQoxNTc5IDE4MTYgMCA0IC0zNTMgNDE2IC03ODUgOTE0IGwtNzg0IDkwNiAtNDQ0IDAgYy00MTggMCAtNDQ0IC0xIC00MzEgLTE3eiIvPgo8L2c+Cjwvc3ZnPgo=';
		acf_add_options_page(array(
			'page_title' => 'Theme Settings',
			'menu_title' => 'Royal Media',
			'menu_slug'  => 'royal-media',
			'capability' => 'edit_posts',
			'redirect'   => false,
			'icon_url'   => $icon,
			'position'   => PHP_INT_MAX
		));
	}
	
	// rmg_add_acf_field_groups
	if( ! function_exists('rmg_add_acf_field_groups') ) {
		function rmg_add_acf_field_groups() {
			if(function_exists( 'acf_add_local_field_group' ) ) {
				$acfs = glob( RMG_PATH . 'acf/*.php' );
				foreach ( $acfs as $acf ) {
					require_once $acf;
				}
			}
		}
		add_action( 'admin_init', 'rmg_add_acf_field_groups' );
	}
}

/* SHORTCODES */
// child_page_buttons()
if( ! function_exists( 'child_page_buttons' ) ) {
	function child_page_buttons( $atts ) {
		$parent_id = get_the_ID();
		if( $atts ) {
			$include = $atts[ 'include' ] ? get_id_from_tag( $atts[ 'include' ] ) : null;
			$exclude = $atts[ 'exclude' ] ? explode(',', $atts[ 'exclude' ] ) : null;
		}

		$q = new WP_Query( array(
			'post_type'    => 'page',
			'post_status'  => 'publish',
			'post_parent'  => $parent_id,
			'tag_id'       => $include ?? '',
			'post__not_in' => $exclude ?? '',
			'orderby'      => array(
				'menu_order' => 'ASC',
				'name'       => 'ASC',
			)
		) );

		if( $q->have_posts() ) :
			$output = '<div class="child-page-buttons">';
				while( $q->have_posts() ) : $q->the_post();
					$href = get_the_permalink();
					$title = get_the_title();
					$updated = strtotime( get_field( 'updated') );
					$isNew = is_recent( $updated );
					$base = 'button vc_col-sm-4';
					$className = $isNew ? "$base new" : $base;
					$output .= sprintf( '<div class="wpb_column vc_column_container vc_col-sm-4"><div class="vc_btn3-container vc_btn3-center"><a href="%1$s" class="%2$s" title="%3$s">%3$s</a></div></div>' , $href, $className, $title );
				endwhile;
			$output .= '</div>';
		endif;
		wp_reset_postdata();

		return $output;
	}
}

// updated_pages()
if( ! function_exists( 'updated_pages' ) ) {
	function updated_pages( $atts ) {
		$duration = get_field( 'new_duration', 'options' );
		$past = date( 'Ymd', strtotime( "-$duration day" ) );
		$ids = array();

		if( $atts ) {
			$include = $atts['include'] ? get_id_from_tag( $atts['include'] ) : null;
			$exclude = $atts['exclude'] ? explode(',', $atts['exclude'] ) : null;
		}

		$q = new WP_Query( array(
			'post_type'      => 'page',
			'post_status'    => 'publish',
			'tag_id'         => $include ?? '',
			'post__not_in'   => $exclude ?? '',
			'posts_per_page' => -1,
			'meta_query'     => array( array(
				'key'     => 'updated',
				'compare' => '>=',
				'value'   => $past,
				'type'    => 'DATE'
			) ),
			'orderby'      => array(
				'meta_value' => 'DESC',
				'menu_order' => 'ASC',
				'name'       => 'ASC',
			)
		) );

		while( $q->have_posts() ) : $q->the_post();
			array_push( $ids, get_the_ID() );
		endwhile;
		wp_reset_postdata();

		echo $ids ? do_shortcode( sprintf( '[jnews_element_newsticker compatible_column_notice="" newsticker_title="Recently Updated" newsticker_icon="fas fa-exclamation" post_type="page" number_post="-1" post_offset="0" include_post="%s" included_only="true" autoplay_delay="3000" enable_autoplay="true"]', implode(',', $ids) ) ) : '';
	}
}

// add_child_page_buttons()
if( function_exists( 'get_field' ) && ! function_exists( 'add_child_page_buttons' ) ) {
	function add_child_page_buttons() {
		$shortcode = 'child_page_buttons';
		if( ! shortcode_exists( $shortcode ) ) {
			add_shortcode( $shortcode, 'child_page_buttons' );
		}
	}
	add_action( 'init', 'add_child_page_buttons' );
}

// add_page_updates()
if( function_exists( 'get_field' ) && ! function_exists( 'add_page_updates' ) ) {
	function add_page_updates() {
		$shortcode = 'page_updates';
		if( ! shortcode_exists( $shortcode ) ) {
			add_shortcode( $shortcode, 'updated_pages' );
		}
	}
	add_action( 'init', 'add_page_updates' );
}