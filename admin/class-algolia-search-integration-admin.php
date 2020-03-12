<?php

require_once __DIR__.'/api-client/autoload.php';

$algolia_setting =  get_option( 'algolia-search-integration' );

global $algolia;

$algolia = \Algolia\AlgoliaSearch\SearchClient::create($algolia_setting['application_id'], $algolia_setting['admin_key']);


/**
 * The admin-specific functionality of the plugin.
 *
 * @link       krupal-algo
 * @since      1.0.0
 *
 * @package    Algolia_Search_Integration
 * @subpackage Algolia_Search_Integration/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Algolia_Search_Integration
 * @subpackage Algolia_Search_Integration/admin
 * @author     krupal Patel <krupalpatel92@yahoo.com>
 */
class Algolia_Search_Integration_Admin {

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
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/algolia-search-integration-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/algolia-search-integration-admin.js', array( 'jquery' ), $this->version, false );

	}

	public function add_plugin_admin_menu() {

		/**
		 * Add a settings page for this plugin to the Settings menu.
		 *
		 * NOTE:  Alternative menu locations are available via WordPress administration menu functions.
		 *
		 *        Administration Menus: http://codex.wordpress.org/Administration_Menus
		 *
		 * add_options_page( $page_title, $menu_title, $capability, $menu_slug, $function);
		 *
		 * @link https://codex.wordpress.org/Function_Reference/add_options_page
		 */
		add_menu_page( 'Algolia Setting', 'Algolia Setting', 'manage_options', $this->plugin_name, array($this, 'display_plugin_setup_page')
		);
	
	}

	public function add_action_links( $links ) {

		/*
		*  Documentation : https://codex.wordpress.org/Plugin_API/Filter_Reference/plugin_action_links_(plugin_file_name)
		*/
	   $settings_link = array(
		'<a href="' . admin_url( 'admin.php?page=' . $this->plugin_name ) . '">' . __( 'Settings', $this->plugin_name ) . '</a>',
	   );
	   return array_merge(  $settings_link, $links );
	
	}

	/**
	 * Render the settings page for this plugin.
	 *
	 * @since    1.0.0
	 */
	public function display_plugin_setup_page() {

		include_once( 'partials/' . $this->plugin_name . '-admin-display.php' );

	}

	/**
	 * Validate fields from admin area plugin settings form ('exopite-lazy-load-xt-admin-display.php')
	 * @param  mixed $input as field form settings form
	 * @return mixed as validated fields
	 */
	public function validate($input) {

		$valid = array();

		
		$valid['application_id'] = ( isset( $input['application_id'] ) && ! empty( $input['application_id'] ) ) ? esc_attr( $input['application_id'] ) : '';
		$valid['search_key'] = ( isset( $input['search_key'] ) && ! empty( $input['search_key'] ) ) ? esc_attr( $input['search_key'] ) : '';
		$valid['admin_key'] = ( isset( $input['admin_key'] ) && ! empty( $input['admin_key'] ) ) ? esc_attr( $input['admin_key'] ) : '';
		$valid['indices_name'] = ( isset( $input['indices_name'] ) && ! empty( $input['indices_name'] ) ) ? esc_attr( $input['indices_name'] ) : '';
		

		return $valid;

		// -- OR --

		$options = get_option( $this->plugin_name );

		
		$options['application_id'] = ( isset( $input['application_id'] ) && ! empty( $input['application_id'] ) ) ? esc_attr( $input['application_id'] ) : '';
		$options['search_key'] = ( isset( $input['search_key'] ) && ! empty( $input['search_key'] ) ) ? esc_attr( $input['search_key'] ) : '';
		$options['admin_key'] = ( isset( $input['admin_key'] ) && ! empty( $input['admin_key'] ) ) ? esc_attr( $input['admin_key'] ) : '';
		$options['indices_name'] = ( isset( $input['indices_name'] ) && ! empty( $input['indices_name'] ) ) ? esc_attr( $input['indices_name'] ) : '';
		

		return $options;

	}

	public function options_update() {

		register_setting( $this->plugin_name, $this->plugin_name, array(
		'sanitize_callback' => array( $this, 'validate' ),
		) );

	}

}

function algolia_post_to_record(WP_Post $post) {
    $shared_attributes                        = array();
		$shared_attributes['post_id']             = $post->ID;
		$shared_attributes['post_type']           = $post->post_type;
		//$shared_attributes['post_type_label']     = $this->get_admin_name();
		$shared_attributes['post_title']          = $post->post_title;
		$shared_attributes['post_excerpt']        = wp_strip_all_tags($post->post_excerpt);
		$shared_attributes['content']             = wp_strip_all_tags($post->post_content);
		$shared_attributes['post_date']           = get_post_time( 'U', false, $post );
		$shared_attributes['post_date_formatted'] = get_the_date( '', $post );
		$shared_attributes['post_modified']       = get_post_modified_time( 'U', false, $post );
		$shared_attributes['comment_count']       = (int) $post->comment_count;
		$shared_attributes['menu_order']          = (int) $post->menu_order;

		$author = get_userdata( $post->post_author );
		if ( $author ) {
			$shared_attributes['post_author'] = array(
				'user_id'      => (int) $post->post_author,
				'display_name' => $author->display_name,
				'user_url'     => $author->user_url,
				'user_login'   => $author->user_login,
			);
		}

		$shared_attributes['images'] = Algolia_Search_Integration::get_post_images( $post->ID );

		$shared_attributes['permalink']      = get_permalink( $post );
		$shared_attributes['post_mime_type'] = $post->post_mime_type;

		// Push all taxonomies by default, including custom ones.
		$taxonomy_objects = get_object_taxonomies( $post->post_type);

		$shared_attributes['taxonomies']              = array();
		$shared_attributes['taxonomies_hierarchical'] = array();
		foreach ( $taxonomy_objects as $taxonomy ) {

			$terms = wp_get_object_terms( $post->ID, $taxonomy );
			$terms = is_array( $terms ) ? $terms : array();

			if ( $taxonomy->hierarchical ) {
				$hierarchical_taxonomy_values = Algolia_Search_Integration::get_taxonomy_tree( $terms, $taxonomy );
				if ( ! empty( $hierarchical_taxonomy_values ) ) {
					$shared_attributes['taxonomies_hierarchical'][ $taxonomy ] = $hierarchical_taxonomy_values;
				}
			}

			$taxonomy_values = wp_list_pluck( $terms, 'category' );
			if ( ! empty( $taxonomy_values ) ) {
				$shared_attributes['taxonomies'][ $taxonomy ] = $taxonomy_values;
			}
		}

		$shared_attributes['is_sticky'] = is_sticky( $post->ID ) ? 1 : 0;

		if ( 'attachment' === $post->post_type ) {
			$shared_attributes['alt'] = get_post_meta( $post->ID, '_wp_attachment_image_alt', true );

			$metadata = get_post_meta( $post->ID, '_wp_attachment_metadata', true );
			$metadata = (array) apply_filters( 'wp_get_attachment_metadata', $metadata, $post->ID );

			$shared_attributes['metadata'] = $metadata;
		}

		return $shared_attributes;
}
add_filter('post_to_record', 'algolia_post_to_record');

function algolia_update_post($id, WP_Post $post, $update) {
    if (wp_is_post_revision( $id) || wp_is_post_autosave( $id )) {
        return $post;
    }

    global $algolia;

	$record = (array) apply_filters($post->post_type.'_to_record', $post);
	

    if (! isset($record['objectID'])) {
        $record['objectID'] = implode('#', [$post->post_type, $post->ID]);
	}

	// $record['post_type_label'] = 'Posts';

	// $index = $algolia->initIndex(apply_filters('algolia_index_name', $post->post_type)
	$index = $algolia->initIndex('wp_'.$post->post_type);

    if ('trash' == $post->post_status) {
        $index->deleteObject($record['objectID']);
    } else {
        $index->saveObject($record);
    }

    return $post;
}

add_action('save_post', 'algolia_update_post', 10, 3);