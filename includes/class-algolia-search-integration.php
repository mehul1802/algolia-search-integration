<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       krupal-algo
 * @since      1.0.0
 *
 * @package    Algolia_Search_Integration
 * @subpackage Algolia_Search_Integration/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Algolia_Search_Integration
 * @subpackage Algolia_Search_Integration/includes
 * @author     krupal Patel <krupalpatel92@yahoo.com>
 */
class Algolia_Search_Integration {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Algolia_Search_Integration_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'ALGOLIA_SEARCH_INTEGRATION_VERSION' ) ) {
			$this->version = ALGOLIA_SEARCH_INTEGRATION_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'algolia-search-integration';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Algolia_Search_Integration_Loader. Orchestrates the hooks of the plugin.
	 * - Algolia_Search_Integration_i18n. Defines internationalization functionality.
	 * - Algolia_Search_Integration_Admin. Defines all hooks for the admin area.
	 * - Algolia_Search_Integration_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-algolia-search-integration-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-algolia-search-integration-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-algolia-search-integration-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-algolia-search-integration-public.php';

		$this->loader = new Algolia_Search_Integration_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Algolia_Search_Integration_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Algolia_Search_Integration_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Algolia_Search_Integration_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		 // Save/Update our plugin options
		 $this->loader->add_action('admin_init', $plugin_admin, 'options_update');

		 // Add menu item
		 $this->loader->add_action( 'admin_menu', $plugin_admin, 'add_plugin_admin_menu' );
	 
		 // Add Settings link to the plugin
		 $plugin_basename = plugin_basename( plugin_dir_path( __DIR__ ) . $this->plugin_name . '.php' );
	 
		 $this->loader->add_filter( 'plugin_action_links_' . $plugin_basename, $plugin_admin, 'add_action_links' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Algolia_Search_Integration_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

		$this->loader->add_shortcode( "algolia-search-box", $plugin_public, "algolia_search_box", $priority = 10, $accepted_args = 2 );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Algolia_Search_Integration_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

	public static function get_post_images( $post_id ) {
		$images = array();

		if ( get_post_type( $post_id ) === 'attachment' ) {
			$post_thumbnail_id = (int) $post_id;
		} else {
			$post_thumbnail_id = get_post_thumbnail_id( (int) $post_id );
		}

		if ( $post_thumbnail_id ) {
			$sizes = (array) apply_filters( 'algolia_post_images_sizes', array( 'thumbnail' ) );
			foreach ( $sizes as $size ) {
				$info = wp_get_attachment_image_src( $post_thumbnail_id, $size );
				if ( ! $info ) {
					continue;
				}

				$images[ $size ] = array(
					'url'    => $info[0],
					'width'  => $info[1],
					'height' => $info[2],
				);
			}
		}

		return (array) apply_filters( 'algolia_get_post_images', $images );
	}

	public static function get_taxonomy_tree( array $terms, $taxonomy, $separator = ' > ' ) {
		$term_ids = wp_list_pluck( $terms, 'term_id' );

		$parents = array();
		foreach ( $term_ids as $term_id ) {
			$path      = self::get_term_parents( $term_id, $taxonomy, $separator );
			$parents[] = rtrim( $path, $separator );
		}

		$terms = array();
		foreach ( $parents as $parent ) {
			$levels = explode( $separator, $parent );

			$previous_lvl = '';
			foreach ( $levels as $index => $level ) {
				$terms[ 'lvl' . $index ][] = $previous_lvl . $level;
				$previous_lvl             .= $level . $separator;

				// Make sure we have not duplicate.
				// The call to `array_values` ensures that we do not end up with an object in JSON.
				$terms[ 'lvl' . $index ] = array_values( array_unique( $terms[ 'lvl' . $index ] ) );
			}
		}

		return $terms;
	}

}
