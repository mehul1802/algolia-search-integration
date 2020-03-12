<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       krupal-algo
 * @since      1.0.0
 *
 * @package    Algolia_Search_Integration
 * @subpackage Algolia_Search_Integration/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Algolia_Search_Integration
 * @subpackage Algolia_Search_Integration/public
 * @author     krupal Patel <krupalpatel92@yahoo.com>
 */
class Algolia_Search_Integration_Public {

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
		 * defined in Algolia_Search_Integration_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Algolia_Search_Integration_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/algolia-search-integration-public.css', array(), $this->version, 'all' );

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
		 * defined in Algolia_Search_Integration_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Algolia_Search_Integration_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script('algolia-autocomplete', plugin_dir_url(__FILE__) .'js/autocomplete.min.js',  array(), false, true);
		wp_enqueue_script( 'algolia-client', plugin_dir_url(__FILE__) .'js/instantsearch.production.min.js', array(), false, true);
		wp_enqueue_script( 'algolia-search-light', plugin_dir_url(__FILE__) .'js/algoliasearchLite.min.js', array(), false, true );
		wp_register_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/algolia-search-integration-public.js', array(), false, true);
		wp_enqueue_script( $this->plugin_name);

		$algolia_setting =  get_option( $this->plugin_name );

		wp_localize_script( $this->plugin_name, 'algolia_object', 
		  	array( 
				'app_id'=> $algolia_setting['application_id'],
				'search_api_key'=> $algolia_setting['search_key'],
				'indices_name'=> $algolia_setting['indices_name'],
			) 
		  );
	}

	/* Shortcode for display shortcode */

	function algolia_search_box( $atts ) {

		$search_input = '<input type="text" name="aloglia-search" id="aloglia-search-input" placeholder="Search..">';
		return $search_input;
	}
}


