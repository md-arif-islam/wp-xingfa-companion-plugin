<?php

function xingfa_custom_post_certificates() {
	/**
	 * Post Type: Certificates.
	 */

	$labels = array(
		'name'               => esc_html__( 'Certificate', 'xingfa-companion' ),
		'singular_name'      => esc_html__( 'Certificate item', 'xingfa-companion' ),
		'add_new'            => esc_html__( 'Add New', 'xingfa-companion' ),
		'add_new_item'       => esc_html__( 'Add New Certificate item', 'xingfa-companion' ),
		'edit_item'          => esc_html__( 'Edit Certificate item', 'xingfa-companion' ),
		'new_item'           => esc_html__( 'New Certificate item', 'xingfa-companion' ),
		'view_item'          => esc_html__( 'View Certificate item', 'xingfa-companion' ),
		'search_items'       => esc_html__( 'Search Certificate items', 'xingfa-companion' ),
		'not_found'          => esc_html__( 'No certificate items found', 'xingfa-companion' ),
		'not_found_in_trash' => esc_html__( 'No certificate items found in Trash', 'xingfa-companion' ),
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
		'rewrite'            => array( "slug" => "certificate", "with_front" => true ),
		'supports'           => array( 'author', 'editor', 'excerpt', 'page-attributes', 'thumbnail', 'title' ),
	);

	register_post_type( 'certificate', $args );

	register_taxonomy( 'certificate-types', 'certificate', array(
		'label'        => esc_html__( 'Certificate Categories', 'xingfa-companion' ),
		'hierarchical' => true,
		'query_var'    => true,
		'show_in_rest' => true,
		'rewrite'      => array(
			'slug' => "certificate-types",
		),
	) );
}

add_action( 'init', 'xingfa_custom_post_certificates' );



function xingfa_certificates_add_columns( $columns ) {
	$newcolumns = array(
		'cb'                => '<input type="checkbox" />',
		'certificate_thumbnail' => esc_html__( 'Thumbnail', 'xingfa-companion' ),
		'title'             => esc_html__( 'Title', 'xingfa-companion' ),
		'certificate_types'     => esc_html__( 'Categories', 'xingfa-companion' ),
		'certificate_order'     => esc_html__( 'Order', 'xingfa-companion' ),
	);
	$columns    = array_merge( $newcolumns, $columns );

	return $columns;
}

// applied to the list of columns to print on the manage posts screen for a custom post type
add_filter( 'manage_edit-certificate_columns', "xingfa_certificates_add_columns" );


function xingfa_certificates_custom_column( $column ) {
	global $post;

	switch ( $column ) {
		case 'certificate_thumbnail':
			if ( has_post_thumbnail() ) {
				the_post_thumbnail( '50x50' );
			}
			break;
		case 'certificate_types':
			echo get_the_term_list( $post->ID, 'certificate-types', '', ', ', '' );
			break;
		case 'certificate_order':
			echo esc_attr( $post->menu_order );
			break;
	}
}


// allows to add or remove (unset) custom columns to the list post/page/custom post type pages
add_action( 'manage_posts_custom_column', "xingfa_certificates_custom_column" );