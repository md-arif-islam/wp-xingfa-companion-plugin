<?php

function xingfa_custom_post_career() {
	/**
	 * Post Type: Projects.
	 */

	$labels = array(
		'name'               => esc_html__( 'Career', 'xingfa-companion' ),
		'singular_name'      => esc_html__( 'Career item', 'xingfa-companion' ),
		'add_new'            => esc_html__( 'Add New', 'xingfa-companion' ),
		'add_new_item'       => esc_html__( 'Add New Career item', 'xingfa-companion' ),
		'edit_item'          => esc_html__( 'Edit Career item', 'xingfa-companion' ),
		'new_item'           => esc_html__( 'New Career item', 'xingfa-companion' ),
		'view_item'          => esc_html__( 'View Career item', 'xingfa-companion' ),
		'search_items'       => esc_html__( 'Search Career items', 'xingfa-companion' ),
		'not_found'          => esc_html__( 'No career items found', 'xingfa-companion' ),
		'not_found_in_trash' => esc_html__( 'No career items found in Trash', 'xingfa-companion' ),
		'parent_item_colon'  => '',
	);


	$args = array(
		'labels'             => $labels,
		'menu_icon'          => 'dashicons-groups',
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'query_var'          => true,
		'capability_type'    => 'post',
		'hierarchical'       => false,
		'menu_position'      => 30,
		'show_in_rest'       => true,
		'rewrite'            => array( "slug" => "career", "with_front" => true ),
		'supports'           => array(
			'author',
			'excerpt',
			'page-attributes',
			'title'
		),
	);


	register_post_type( 'career', $args );

	register_taxonomy( 'career-types', 'career', array(
		'label'        => esc_html__( 'Career Types', 'xingfa-companion' ),
		'hierarchical' => true,
		'query_var'    => true,
		'show_in_rest' => true,
		'rewrite'      => array(
			'slug' => "career-types",
		),
	) );

	register_taxonomy( 'career-tags', 'career', array(
		'label'        => esc_html__( 'Career Tags', 'xingfa-companion' ),
		'hierarchical' => true,
		'query_var'    => true,
		'show_in_rest' => true,
		'rewrite'      => array(
			'slug' => "career-tags",
		),
	) );
}

add_action( 'init', 'xingfa_custom_post_career' );



function xingfa_career_add_columns( $columns ) {
	$newcolumns = array(
		'cb'                => '<input type="checkbox" />',
		'title'             => esc_html__( 'Title', 'xingfa-companion' ),
		'career_types'     => esc_html__( 'Types', 'xingfa-companion' ),
		'career_tags'     => esc_html__( 'Tags', 'xingfa-companion' ),
		'career_order'     => esc_html__( 'Order', 'xingfa-companion' ),
	);
	$columns    = array_merge( $newcolumns, $columns );

	return $columns;
}

// applied to the list of columns to print on the manage posts screen for a custom post type
add_filter( 'manage_edit-career_columns', "xingfa_career_add_columns" );


function xingfa_career_custom_column( $column ) {
	global $post;

	switch ( $column ) {
		case 'career_types':
			echo get_the_term_list( $post->ID, 'career-types', '', ', ', '' );
			break;
			case 'career_tags':
			echo get_the_term_list( $post->ID, 'career-tags', '', ', ', '' );
			break;
		case 'career_order':
			echo esc_attr( $post->menu_order );
			break;
	}
}


// allows to add or remove (unset) custom columns to the list post/page/custom post type pages
add_action( 'manage_posts_custom_column', "xingfa_career_custom_column" );