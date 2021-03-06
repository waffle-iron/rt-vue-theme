<?php

function rest_theme_scripts() {

	wp_enqueue_style( 'style', get_stylesheet_uri() );

	$base_url  = esc_url_raw( home_url() );
	$base_path = rtrim( parse_url( $base_url, PHP_URL_PATH ), '/' );

	wp_enqueue_script( 'rest-theme-vue', get_template_directory_uri() . '/dist/build.js', array( 'jquery', 'wp-api' ), '1.0.0', true );
	//wp_enqueue_script( 'rest-theme-vue', 'http://localhost:8080/dist/build.js', array( 'jquery', 'wp-api' ), '1.0.0', true );
	wp_localize_script( 'rest-theme-vue', 'rtwp', array(
		'root'      => esc_url_raw( rest_url() ),
		'base_url'  => $base_url,
		'base_path' => $base_path ? $base_path . '/' : '/',
		'nonce'     => wp_create_nonce( 'wp_rest' ),
		'site_name' => get_bloginfo( 'name' ),
	) );
}

add_action( 'wp_enqueue_scripts', 'rest_theme_scripts' );

if ( function_exists( 'register_nav_menus' ) ) {
	register_nav_menus(
		array(
		'primary-menu' => __( 'Primary Menu' ),
		'secondary-menu' => __( 'Secondary Menu' ),
		)
	);
}

add_filter( 'excerpt_more', '__return_false' );

add_action( 'after_setup_theme', 'rt_theme_setup' );

function rt_theme_setup() {
	global $wp_rewrite;
	$wp_rewrite->permalink_structure = $wp_rewrite->root . 'post/%postname%/';
	$wp_rewrite->page_structure      = $wp_rewrite->root . 'page/%pagename%/';
	$wp_rewrite->front               = $wp_rewrite->root;

	add_theme_support( 'title-tag' );
}
