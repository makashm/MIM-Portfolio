<?php 

/**
* Registers a new post type
* @uses $wp_post_types Inserts new post type object into the list
*
* @param string  Post type key, must not exceed 20 characters
* @param array|string  See optional args description above.
* @return object|WP_Error the registered post type object, or an error object
*/
function mim_cpt() {

	$labels = array(
		'name'                => __( 'Your Portfolio', 'portfolio' ),
		'singular_name'       => __( 'Your Portfolio', 'portfolio' ),
		'add_new'             => _x( 'Add New Portfolio', 'portfolio', 'portfolio' ),
		'add_new_item'        => __( 'Add New Portfolio', 'portfolio' ),
		'edit_item'           => __( 'Edit Your Portfolio', 'portfolio' ),
		'new_item'            => __( 'New Your Portfolio', 'portfolio' ),
		'view_item'           => __( 'View Your Portfolio', 'portfolio' ),
		'search_items'        => __( 'Search Your Portfolio', 'portfolio' ),
		'not_found'           => __( 'No Your Portfolio found', 'portfolio' ),
		'not_found_in_trash'  => __( 'No Your Portfolio found in Trash', 'portfolio' ),
		'parent_item_colon'   => __( 'Parent Your Portfolio:', 'portfolio' ),
		'menu_name'           => __( 'Your Portfolio', 'portfolio' ),
	);

	$args = array(
		'labels'                   => $labels,
		'hierarchical'        => true,
		'description'         => 'description',
		'taxonomies'          => array(),
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => null,
		'menu_icon'           => null,
		'show_in_nav_menus'   => true,
		'publicly_queryable'  => true,
		'exclude_from_search' => false,
		'has_archive'         => true,
		'query_var'           => true,
		'can_export'          => true,
		'rewrite'             => true,
		'capability_type'     => 'post',
		'supports'            => array(
			'title', 'editor', 'thumbnail'
		)
	);

	register_post_type( 'portfolio', $args );

	$labels = array(
		'name'					=> _x( 'Categories', 'Taxonomy plural name', 'portfolio' ),
		'singular_name'			=> _x( 'Category', 'Taxonomy singular name', 'portfolio' ),
		'search_items'			=> __( 'Search Categories', 'portfolio' ),
		'popular_items'			=> __( 'Popular Categories', 'portfolio' ),
		'all_items'				=> __( 'All Categories', 'portfolio' ),
		'parent_item'			=> __( 'Parent Category', 'portfolio' ),
		'parent_item_colon'		=> __( 'Parent Category', 'portfolio' ),
		'edit_item'				=> __( 'Edit Category', 'portfolio' ),
		'update_item'			=> __( 'Update Category', 'portfolio' ),
		'add_new_item'			=> __( 'Add New Category', 'portfolio' ),
		'new_item_name'			=> __( 'New Category Name', 'portfolio' ),
		'add_or_remove_items'	=> __( 'Add or remove Categories', 'portfolio' ),
		'choose_from_most_used'	=> __( 'Choose from most used portfolio', 'portfolio' ),
		'menu_name'				=> __( 'Category', 'portfolio' ),
	);

	$args = array(
		'labels'            => $labels,
		'public'            => true,
		'show_in_nav_menus' => true,
		'show_admin_column' => false,
		'hierarchical'      => true,
		'show_tagcloud'     => true,
		'show_ui'           => true,
		'query_var'         => true,
		'rewrite'           => true,
		'query_var'         => true,
		'capabilities'      => array(),
	);

	register_taxonomy( 'portfolio-ctg', array( 'portfolio' ), $args );
}

add_action( 'init', 'mim_cpt' );