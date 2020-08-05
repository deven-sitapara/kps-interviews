<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       srs-kps-interviews
 * @since      1.0.0
 *
 * @package    Kps_Interviews
 * @subpackage Kps_Interviews/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Kps_Interviews
 * @subpackage Kps_Interviews/admin
 * @author     Shriramsoft <shriramsoft@gmail.com>
 */
class Kps_Interviews_Admin
{

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;


		//add_action('init', array($this, 'register_custom_post_type'));



	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Kps_Interviews_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Kps_Interviews_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/kps-interviews-admin.css', array(), $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Kps_Interviews_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Kps_Interviews_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/kps-interviews-admin.js', array('jquery'), $this->version, false);
	}

	/** 
	 * Register custom post type Interview Candidates 
	 * 
	 * @since    1.0.0
	 */
	public function register_custom_post_type()
	{


		/**
		 * Post Type: Interviews.
		 */

		$labels = [
			"name" => __("Interviews", "twentytwenty"),
			"singular_name" => __("Interview", "twentytwenty"),
			"menu_name" => __("KPS Interviews", "twentytwenty"),
			"all_items" => __("All Interviews", "twentytwenty"),
			"add_new" => __("Add new", "twentytwenty"),
			"add_new_item" => __("Add new Interview", "twentytwenty"),
			"edit_item" => __("Edit Interview", "twentytwenty"),
			"new_item" => __("New Interview", "twentytwenty"),
			"view_item" => __("View Interview", "twentytwenty"),
			"view_items" => __("View Interviews", "twentytwenty"),
			"search_items" => __("Search Interviews", "twentytwenty"),
			"not_found" => __("No Interviews found", "twentytwenty"),
			"not_found_in_trash" => __("No Interviews found in trash", "twentytwenty"),
			"parent" => __("Parent Interview:", "twentytwenty"),
			"featured_image" => __("Featured image for this Interview", "twentytwenty"),
			"set_featured_image" => __("Set featured image for this Interview", "twentytwenty"),
			"remove_featured_image" => __("Remove featured image for this Interview", "twentytwenty"),
			"use_featured_image" => __("Use as featured image for this Interview", "twentytwenty"),
			"archives" => __("Interview archives", "twentytwenty"),
			"insert_into_item" => __("Insert into Interview", "twentytwenty"),
			"uploaded_to_this_item" => __("Upload to this Interview", "twentytwenty"),
			"filter_items_list" => __("Filter Interviews list", "twentytwenty"),
			"items_list_navigation" => __("Interviews list navigation", "twentytwenty"),
			"items_list" => __("Interviews list", "twentytwenty"),
			"attributes" => __("Interviews attributes", "twentytwenty"),
			"name_admin_bar" => __("Interview", "twentytwenty"),
			"item_published" => __("Interview published", "twentytwenty"),
			"item_published_privately" => __("Interview published privately.", "twentytwenty"),
			"item_reverted_to_draft" => __("Interview reverted to draft.", "twentytwenty"),
			"item_scheduled" => __("Interview scheduled", "twentytwenty"),
			"item_updated" => __("Interview updated.", "twentytwenty"),
			"parent_item_colon" => __("Parent Interview:", "twentytwenty"),
		];

		$args = [
			"label" => __("Interviews", "twentytwenty"),
			"labels" => $labels,
			"description" => "",
			"public" => true,
			"publicly_queryable" => true,
			"show_ui" => true,
			"show_in_rest" => true,
			"rest_base" => "",
			"rest_controller_class" => "WP_REST_Posts_Controller",
			"has_archive" => false,
			"show_in_menu" => true,
			"show_in_nav_menus" => true,
			"delete_with_user" => false,
			"exclude_from_search" => false,
			"capability_type" => "post",
			"map_meta_cap" => true,
			"hierarchical" => false,
			"rewrite" => ["slug" => "interview", "with_front" => true],
			"query_var" => true,
			"menu_icon" => "dashicons-admin-users",
			"supports" => [""],
		];

		register_post_type("interview", $args);

		// Update the columns shown on the custom post type edit.php view - so we also have custom columns
		add_filter('manage_interview_posts_columns', array($this, 'register_custom_post_type_fields'));

		// this fills in the columns that were created with each individual post's value
		add_action('manage_interview_posts_custom_column', array($this, 'fill_custom_post_type_columns'), 10, 2);

		add_filter('rwmb_meta_boxes', array($this, 'metabox_register_meta_boxes'));
	}

	/** 
	 * Register custom post type Interview Fields 
	 * 
	 * @since    1.0.0
	 */
	public function register_custom_post_type_fields()
	{

		return array(
			'cb' => '<input type="checkbox" />',
			'picture' => __('Picture'),
			'first_name' => __('First Name'),
			'last_name' => __('Last Name'),
			'email' => __('Email'),
			'hobbies' => __('Hobbies'),
			'gender' => __('Gender'),
			'date' => __('Date')
		);
	}


	public function fill_custom_post_type_columns($column, $post_id)
	{


		// Fill in the columns with meta box info associated with each post
		switch ($column) {
			case 'first_name':
				echo get_post_meta($post_id, $this->plugin_name . '_first_name', true);
				break;
			case 'last_name':
				echo get_post_meta($post_id, $this->plugin_name . '_last_name', true);
				break;
			case 'email':
				echo get_post_meta($post_id, $this->plugin_name . '_email', true);
				break;
			case 'hobbies':
				echo implode("<br>", get_post_meta($post_id, $this->plugin_name . '_hobbies'));
				break;
			case 'gender':
				echo get_post_meta($post_id, $this->plugin_name . '_gender', true);
				break;
			case 'picture':
				$thumb_id = get_post_meta($post_id, $this->plugin_name . '_picture', true);
				echo wp_get_attachment_image($thumb_id, 'thumbnail');
				break;
		}
	}



	function metabox_register_meta_boxes($meta_boxes)
	{
		$prefix =  $this->plugin_name . "_";

		$meta_boxes[] = [
			'title'      => esc_html__('Candidate Information', 'online-generator'),
			'id'         => 'candidateinfo',
			'post_types' => ['interview'],
			'context'    => 'normal',
			'priority'   => 'high',
			'fields'     => [
				[
					'type' => 'email',
					'id'   => $prefix . 'email',
					'name' => esc_html__('Email', 'online-generator'),
					'placeholder' => esc_html__('Email Address', 'online-generator'),

				],
				[
					'type'        => 'text',
					'id'          => $prefix . 'first_name',
					'name'        => esc_html__('First Name', 'online-generator'),
					'placeholder' => esc_html__('First Name', 'online-generator'),
				],
				[
					'type'        => 'text',
					'id'          => $prefix . 'last_name',
					'name'        => esc_html__('Last Name', 'online-generator'),
					'placeholder' => esc_html__('Last Name', 'online-generator'),
				],
				[
					'type'    => 'checkbox_list',
					'id'      => $prefix . 'hobbies',
					'name'    => esc_html__('Hobbies', 'online-generator'),
					'options' => [
						'tv' 	  => esc_html__('TV', 'online-generator'),
						'reading' => esc_html__('Reading', 'online-generator'),
						'coding'  => esc_html__('Coding', 'online-generator'),
						'skiing'  => esc_html__('Skiing', 'online-generator'),
					],
					'inline'  => true,

				],
				[
					'type'    => 'radio',
					'id'      => $prefix . 'gender',
					'name'    => esc_html__('Gender', 'online-generator'),
					'options' => [
						'male' 	 => esc_html__('Male', 'online-generator'),
						'female' => esc_html__('Female', 'online-generator'),

					],
					'inline'  => true,
				],
				[
					'type'             => 'image',
					'id'               => $prefix . 'picture',
					'name'             => esc_html__('Image Upload', 'online-generator'),
					'max_file_uploads' => 1,
				],

			],
		];

		return $meta_boxes;
	}
}
