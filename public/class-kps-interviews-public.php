<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       srs-kps-interviews
 * @since      1.0.0
 *
 * @package    Kps_Interviews
 * @subpackage Kps_Interviews/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Kps_Interviews
 * @subpackage Kps_Interviews/public
 * @author     Shriramsoft <shriramsoft@gmail.com>
 */
class Kps_Interviews_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/kps-interviews-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/kps-interviews-public.js', array( 'jquery' ), $this->version, false );

		wp_localize_script($this->plugin_name, 'interview', array(
			'ajax_url' => admin_url('admin-ajax.php'),
			'nonce'    => wp_create_nonce('interview')
		));
	}

	/**
	 * Interview form post action 
	 */
	public function the_interview_form_response()
	{



		// Check the nonce for permission.
		if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], $this->plugin['id'])) {
			die('Permission Denied');
		}

		// Get the request data.
		$request = array(
			'example' => isset($_REQUEST['example']) ? $_REQUEST['example'] : 'default'
		);

		// Define an empty response array.
		$response = array(
			'content' => print_r($_POST, true)
		);

		// Terminate the callback and return a proper response.
		//wp_die(json_encode(print_r($_POST, true)));
		wp_die(json_encode($response));



		if (isset($_POST['nds_add_user_meta_nonce']) && wp_verify_nonce($_POST['nds_add_user_meta_nonce'], 'nds_add_user_meta_form_nonce')) {

			// sanitize the input
			$nds_user_meta_key = sanitize_key($_POST['nds']['user_meta_key']);
			$nds_user_meta_value = sanitize_text_field($_POST['nds']['user_meta_value']);
			$nds_user =  get_user_by('login',  $_POST['nds']['user_select']);
			$nds_user_id = absint($nds_user->ID);

			// do the processing

			// add the admin notice
			$admin_notice = "success";

			// redirect the user to the appropriate page
			$this->custom_redirect($admin_notice, $_POST);
			exit;
		} else {
			wp_die(__('Invalid nonce specified', $this->plugin_name), __('Error', $this->plugin_name), array(
				'response' 	=> 403,
				'back_link' => 'admin.php?page=' . $this->plugin_name,

			));
		}
	}
}
