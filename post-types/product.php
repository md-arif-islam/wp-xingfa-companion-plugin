<?php

function xingfa_custom_post_product() {
	/**
	 * Post Type: Product.
	 */

	$labels = array(
		'name'               => esc_html__( 'Product', 'xingfa-companion' ),
		'singular_name'      => esc_html__( 'Product item', 'xingfa-companion' ),
		'add_new'            => esc_html__( 'Add New', 'xingfa-companion' ),
		'add_new_item'       => esc_html__( 'Add New Product item', 'xingfa-companion' ),
		'edit_item'          => esc_html__( 'Edit Product item', 'xingfa-companion' ),
		'new_item'           => esc_html__( 'New Product item', 'xingfa-companion' ),
		'view_item'          => esc_html__( 'View Product item', 'xingfa-companion' ),
		'search_items'       => esc_html__( 'Search Product items', 'xingfa-companion' ),
		'not_found'          => esc_html__( 'No product items found', 'xingfa-companion' ),
		'not_found_in_trash' => esc_html__( 'No product items found in Trash', 'xingfa-companion' ),
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
		'rewrite'            => array( "slug" => "product", "with_front" => true ),
		'supports'           => array( 'author', 'editor', 'excerpt', 'page-attributes', 'thumbnail', 'title' ),
	);

	register_post_type( 'product', $args );

	register_taxonomy( 'product-types', 'product', array(
		'label'        => esc_html__( 'Product Categories', 'xingfa-companion' ),
		'hierarchical' => true,
		'query_var'    => true,
		'show_in_rest' => true,
		'rewrite'      => array(
			'slug' => "product-types",
		),
	) );
}

add_action( 'init', 'xingfa_custom_post_product' );



function xingfa_product_add_columns( $columns ) {
	$newcolumns = array(
		'cb'                => '<input type="checkbox" />',
		'product_thumbnail' => esc_html__( 'Thumbnail', 'xingfa-companion' ),
		'title'             => esc_html__( 'Title', 'xingfa-companion' ),
		'product_types'     => esc_html__( 'Categories', 'xingfa-companion' ),
		'product_order'     => esc_html__( 'Order', 'xingfa-companion' ),
	);
	$columns    = array_merge( $newcolumns, $columns );

	return $columns;
}

// applied to the list of columns to print on the manage posts screen for a custom post type
add_filter( 'manage_edit-product_columns', "xingfa_product_add_columns" );


function xingfa_product_custom_column( $column ) {
	global $post;

	switch ( $column ) {
		case 'product_thumbnail':
			if ( has_post_thumbnail() ) {
				the_post_thumbnail( '50x50' );
			}
			break;
		case 'product_types':
			echo get_the_term_list( $post->ID, 'product-types', '', ', ', '' );
			break;
		case 'product_order':
			echo esc_attr( $post->menu_order );
			break;
	}
}


// allows to add or remove (unset) custom columns to the list post/page/custom post type pages
add_action( 'manage_posts_custom_column', "xingfa_product_custom_column" );