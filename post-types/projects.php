<?php

function xingfa_custom_post_projects() {
	/**
	 * Post Type: Projects.
	 */

	$labels = array(
		'name'               => esc_html__( 'Project', 'xingfa-companion' ),
		'singular_name'      => esc_html__( 'Project item', 'xingfa-companion' ),
		'add_new'            => esc_html__( 'Add New', 'xingfa-companion' ),
		'add_new_item'       => esc_html__( 'Add New Project item', 'xingfa-companion' ),
		'edit_item'          => esc_html__( 'Edit Project item', 'xingfa-companion' ),
		'new_item'           => esc_html__( 'New Project item', 'xingfa-companion' ),
		'view_item'          => esc_html__( 'View Project item', 'xingfa-companion' ),
		'search_items'       => esc_html__( 'Search Project items', 'xingfa-companion' ),
		'not_found'          => esc_html__( 'No project items found', 'xingfa-companion' ),
		'not_found_in_trash' => esc_html__( 'No project items found in Trash', 'xingfa-companion' ),
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
		'rewrite'            => array( "slug" => "project", "with_front" => true ),
		'supports'           => array( 'author', 'editor', 'excerpt', 'page-attributes', 'thumbnail', 'title' ),
	);

	register_post_type( 'project', $args );

	register_taxonomy( 'project-types', 'project', array(
		'label'        => esc_html__( 'Project Categories', 'xingfa-companion' ),
		'hierarchical' => true,
		'query_var'    => true,
		'show_in_rest' => true,
		'rewrite'      => array(
			'slug' => "project-types",
		),
	) );
}

add_action( 'init', 'xingfa_custom_post_projects' );



function xingfa_projects_add_columns( $columns ) {
	$newcolumns = array(
		'cb'                => '<input type="checkbox" />',
		'project_thumbnail' => esc_html__( 'Thumbnail', 'xingfa-companion' ),
		'title'             => esc_html__( 'Title', 'xingfa-companion' ),
		'project_types'     => esc_html__( 'Categories', 'xingfa-companion' ),
		'project_order'     => esc_html__( 'Order', 'xingfa-companion' ),
	);
	$columns    = array_merge( $newcolumns, $columns );

	return $columns;
}

// applied to the list of columns to print on the manage posts screen for a custom post type
add_filter( 'manage_edit-project_columns', "xingfa_projects_add_columns" );


function xingfa_projects_custom_column( $column ) {
	global $post;

	switch ( $column ) {
		case 'project_thumbnail':
			if ( has_post_thumbnail() ) {
				the_post_thumbnail( '50x50' );
			}
			break;
		case 'project_types':
			echo get_the_term_list( $post->ID, 'project-types', '', ', ', '' );
			break;
		case 'project_order':
			echo esc_attr( $post->menu_order );
			break;
	}
}


// allows to add or remove (unset) custom columns to the list post/page/custom post type pages
add_action( 'manage_posts_custom_column', "xingfa_projects_custom_column" );