<?php

function xingfa_custom_post_industry_news() {
	/**
	 * Post Type: Industry_Newss.
	 */

	$labels = array(
		'name'               => esc_html__( 'Industry_News', 'xingfa-companion' ),
		'singular_name'      => esc_html__( 'Industry_News item', 'xingfa-companion' ),
		'add_new'            => esc_html__( 'Add New', 'xingfa-companion' ),
		'add_new_item'       => esc_html__( 'Add New Industry_News item', 'xingfa-companion' ),
		'edit_item'          => esc_html__( 'Edit Industry_News item', 'xingfa-companion' ),
		'new_item'           => esc_html__( 'New Industry_News item', 'xingfa-companion' ),
		'view_item'          => esc_html__( 'View Industry_News item', 'xingfa-companion' ),
		'search_items'       => esc_html__( 'Search Industry_News items', 'xingfa-companion' ),
		'not_found'          => esc_html__( 'No industry_news items found', 'xingfa-companion' ),
		'not_found_in_trash' => esc_html__( 'No industry_news items found in Trash', 'xingfa-companion' ),
		'parent_item_colon'  => '',
	);

	$args = array(
		'labels'             => $labels,
		'menu_icon'          => 'dashicons-format-gallery',
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'query_var'          => true,
		'capability_type'    => 'post',
		'hierarchical'       => false,
		'menu_position'      => 29,
		'show_in_rest'       => true,
		'rewrite'            => array( "slug" => "industry_news", "with_front" => true ),
		'supports'           => array( 'author', 'editor', 'excerpt', 'page-attributes', 'thumbnail', 'title' ),
	);

	register_post_type( 'industry_news', $args );

	register_taxonomy( 'industry_news-types', 'industry_news', array(
		'label'        => esc_html__( 'Industry_News Categories', 'xingfa-companion' ),
		'hierarchical' => true,
		'query_var'    => true,
		'show_in_rest' => true,
		'rewrite'      => array(
			'slug' => "industry_news-types",
		),
	) );
}

add_action( 'init', 'xingfa_custom_post_industry_news' );



function xingfa_industry_news_add_columns( $columns ) {
	$newcolumns = array(
		'cb'                => '<input type="checkbox" />',
		'industry_news_thumbnail' => esc_html__( 'Thumbnail', 'xingfa-companion' ),
		'title'             => esc_html__( 'Title', 'xingfa-companion' ),
		'industry_news_types'     => esc_html__( 'Categories', 'xingfa-companion' ),
		'industry_news_order'     => esc_html__( 'Order', 'xingfa-companion' ),
	);
	$columns    = array_merge( $newcolumns, $columns );

	return $columns;
}

// applied to the list of columns to print on the manage posts screen for a custom post type
add_filter( 'manage_edit-industry_news_columns', "xingfa_industry_news_add_columns" );


function xingfa_industry_news_custom_column( $column ) {
	global $post;

	switch ( $column ) {
		case 'industry_news_thumbnail':
			if ( has_post_thumbnail() ) {
				the_post_thumbnail( '50x50' );
			}
			break;
		case 'industry_news_types':
			echo get_the_term_list( $post->ID, 'industry_news-types', '', ', ', '' );
			break;
		case 'industry_news_order':
			echo esc_attr( $post->menu_order );
			break;
	}
}


// allows to add or remove (unset) custom columns to the list post/page/custom post type pages
add_action( 'manage_posts_custom_column', "xingfa_industry_news_custom_column" );