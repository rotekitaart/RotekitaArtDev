<?php

/**
 * The file that defines the core plugin class.
 *
 * @link          https://plugins360.com
 * @since         1.0.0
 *
 * @package       AIOVG
 * @subpackage    AIOVG/includes
 */
 
// Exit if accessed directly
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * AIOVG - The main plugin class.
 *
 * @since    1.0.0
 */
class AIOVG {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since     1.0.0
	 * @access    protected
	 * @var       AIOVG_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * Get things started.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		$this->blocks_init();
		$this->widgets_init();
		$this->set_meta_caps();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since     1.0.0
	 * @access    private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once AIOVG_PLUGIN_DIR . 'includes/class-aiovg-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once AIOVG_PLUGIN_DIR . 'includes/class-aiovg-i18n.php';
		
		/**
		 * The class responsibe for defining custom capabilities.
		 */
		 require_once AIOVG_PLUGIN_DIR . 'includes/class-aiovg-roles.php';
		
		/**
		 * The class responsible for extending the 'wp_terms_checklist' function.
		 */
		require_once AIOVG_PLUGIN_DIR . 'includes/class-aiovg-walker-terms-checklist.php';
		
		/**
		 * The file that holds the general helper functions.
		 */
		require_once AIOVG_PLUGIN_DIR . 'includes/functions.php';

		/**
		 * The classes responsible for defining all actions that occur in the admin area.
		 */
		require_once AIOVG_PLUGIN_DIR . 'admin/class-aiovg-admin.php';
		require_once AIOVG_PLUGIN_DIR . 'admin/class-aiovg-admin-welcome.php';
		require_once AIOVG_PLUGIN_DIR . 'admin/class-aiovg-admin-videos.php';
		require_once AIOVG_PLUGIN_DIR . 'admin/class-aiovg-admin-categories.php';
		require_once AIOVG_PLUGIN_DIR . 'admin/class-aiovg-admin-settings.php';
		require_once AIOVG_PLUGIN_DIR . 'admin/class-aiovg-admin-shortcode.php';

		/**
		 * The classes responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once AIOVG_PLUGIN_DIR . 'public/class-aiovg-public.php';		
		require_once AIOVG_PLUGIN_DIR . 'public/class-aiovg-public-categories.php';
		require_once AIOVG_PLUGIN_DIR . 'public/class-aiovg-public-videos.php';		
		require_once AIOVG_PLUGIN_DIR . 'public/class-aiovg-public-video.php';
		require_once AIOVG_PLUGIN_DIR . 'public/class-aiovg-public-search.php';		
		
		/**
		 * The class responsible for defining actions that occur in the gutenberg blocks.
		 */
		require_once AIOVG_PLUGIN_DIR. 'blocks/class-aiovg-blocks.php';

		/**
		 * The classes responsible for defining all actions that occur in the widgets.
		 */
		require_once AIOVG_PLUGIN_DIR . 'widgets/categories/class-aiovg-widget-categories.php';
		require_once AIOVG_PLUGIN_DIR . 'widgets/videos/class-aiovg-widget-videos.php';				
		require_once AIOVG_PLUGIN_DIR . 'widgets/video/class-aiovg-widget-video.php';
		require_once AIOVG_PLUGIN_DIR . 'widgets/search/class-aiovg-widget-search.php';			

		$this->loader = new AIOVG_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * @since     1.0.0
	 * @access    private
	 */
	private function set_locale() {

		$plugin_i18n = new AIOVG_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since     1.0.0
	 * @access    private
	 */
	private function define_admin_hooks() {

		// Hooks common to all admin pages
		$plugin_admin = new AIOVG_Admin();
				
		$this->loader->add_action( 'wp_loaded', $plugin_admin, 'manage_upgrades' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'admin_notices', $plugin_admin, 'admin_notice' );		
		$this->loader->add_action( 'wp_ajax_aiovg_dismiss_admin_notice', $plugin_admin, 'ajax_callback_dismiss_admin_notice' );		
		
		$this->loader->add_filter( 'plugin_action_links_' . AIOVG_PLUGIN_FILE_NAME, $plugin_admin, 'plugin_action_links' );
		
		// Hooks specific to the welcome page
		$plugin_admin_welcome = new AIOVG_Admin_Welcome();
		
		$this->loader->add_action( 'admin_menu', $plugin_admin_welcome, 'add_welcome_menus' );
		$this->loader->add_action( 'admin_init', $plugin_admin_welcome, 'welcome_page_redirect' );
		
		// Hooks specific to the videos page
		$plugin_admin_videos = new AIOVG_Admin_Videos();
		
		$this->loader->add_action( 'init', $plugin_admin_videos, 'register_post_type' );
		
		if ( is_admin() ) {
		
			$this->loader->add_action( 'admin_head', $plugin_admin_videos, 'remove_media_buttons' );
			$this->loader->add_action( 'post_submitbox_misc_actions', $plugin_admin_videos, 'post_submitbox_misc_actions' );
			$this->loader->add_action( 'add_meta_boxes', $plugin_admin_videos, 'add_meta_boxes' );
			$this->loader->add_action( 'save_post', $plugin_admin_videos, 'save_meta_data', 10, 2 );
			$this->loader->add_action( 'restrict_manage_posts', $plugin_admin_videos, 'restrict_manage_posts' );
			$this->loader->add_action( 'manage_aiovg_videos_posts_custom_column', $plugin_admin_videos, 'custom_column_content', 10, 2 );
			$this->loader->add_action( 'before_delete_post', $plugin_admin_videos, 'before_delete_post' );
			
			$this->loader->add_filter( 'parse_query', $plugin_admin_videos, 'parse_query' );
			$this->loader->add_filter( 'manage_edit-aiovg_videos_columns', $plugin_admin_videos, 'get_columns' );
			
		}
		
		// Hooks specific to the categories page
		$plugin_admin_categories = new AIOVG_Admin_Categories();
		
		$this->loader->add_action( 'init', $plugin_admin_categories, 'register_taxonomy' );
		$this->loader->add_action( 'aiovg_categories_add_form_fields', $plugin_admin_categories, 'add_image_field' );		
		$this->loader->add_action( 'aiovg_categories_edit_form_fields', $plugin_admin_categories, 'edit_image_field' );
		$this->loader->add_action( 'created_aiovg_categories', $plugin_admin_categories, 'save_image_field' );
		$this->loader->add_action( 'edited_aiovg_categories', $plugin_admin_categories, 'save_image_field' );		
		$this->loader->add_action( 'pre_delete_term', $plugin_admin_categories, 'pre_delete_term', 10, 2 );	
		$this->loader->add_action( 'wp_ajax_aiovg_delete_category_image', $plugin_admin_categories, 'ajax_callback_delete_category_image' );
		
		$this->loader->add_filter( "manage_edit-aiovg_categories_columns", $plugin_admin_categories, 'get_columns' );
		$this->loader->add_filter( "manage_edit-aiovg_categories_sortable_columns", $plugin_admin_categories, 'get_columns' );
		$this->loader->add_filter( "manage_aiovg_categories_custom_column", $plugin_admin_categories, 'custom_column_content', 10, 3 );		
		
		// Hooks specific to the settings page
		$plugin_admin_settings = new AIOVG_Admin_Settings();
		
		$this->loader->add_action( 'admin_menu', $plugin_admin_settings, 'add_settings_menu' );
		$this->loader->add_action( 'admin_init', $plugin_admin_settings, 'admin_init' );
		
		// Hooks specific to the shortcode builder
		$plugin_admin_shortcode = new AIOVG_Admin_Shortcode();
		
		$this->loader->add_action( 'media_buttons', $plugin_admin_shortcode, 'media_buttons', 11 );
		$this->loader->add_action( 'admin_footer', $plugin_admin_shortcode, 'admin_footer' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since     1.0.0
	 * @access    private
	 */
	private function define_public_hooks() {

		// Hooks common to all public pages
		$plugin_public = new AIOVG_Public();

		$this->loader->add_action( 'template_redirect', $plugin_public, 'template_redirect', 0 );
		$this->loader->add_action( 'init', $plugin_public, 'add_rewrites' );
		$this->loader->add_action( 'wp_loaded', $plugin_public, 'maybe_flush_rules' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );		
		$this->loader->add_action( 'wp_head', $plugin_public, 'og_metatags' );
		$this->loader->add_action( 'wp_ajax_aiovg_set_cookie', $plugin_public, 'set_cookie' );
		$this->loader->add_action( 'wp_ajax_nopriv_aiovg_set_cookie', $plugin_public, 'set_cookie' );
		
		if ( aiovg_can_use_yoast() ) {
			$this->loader->add_filter( 'wpseo_title', $plugin_public, 'wpseo_title' );
			$this->loader->add_filter( 'wpseo_metadesc', $plugin_public, 'wpseo_metadesc' );
			$this->loader->add_filter( 'wpseo_canonical', $plugin_public, 'wpseo_canonical' );
			$this->loader->add_filter( 'wpseo_opengraph_url', $plugin_public, 'wpseo_canonical' );
		} else {
			$this->loader->add_filter( 'wp_title', $plugin_public, 'wp_title', 99, 3 );
			$this->loader->add_filter( 'document_title_parts', $plugin_public, 'document_title_parts' );
		}				
		$this->loader->add_filter( 'the_title', $plugin_public, 'the_title', 99 );
		$this->loader->add_filter( 'single_post_title', $plugin_public, 'the_title', 99 );
		$this->loader->add_filter( 'term_link', $plugin_public, 'term_link', 10, 3 );
		
		// Hooks specific to the categories page
		$plugin_public_categories = new AIOVG_Public_Categories();
		
		$this->loader->add_filter( 'do_shortcode_tag', $plugin_public_categories, 'do_shortcode_tag', 10, 2 );
		
		// Hooks specific to the videos page
		$plugin_public_videos = new AIOVG_Public_Videos();
		
		// Hooks specific to the single video page
		$plugin_public_video = new AIOVG_Public_Video();
		
		$this->loader->add_action( 'template_include', $plugin_public_video, 'template_include', 999 );
		$this->loader->add_action( 'the_content', $plugin_public_video, 'the_content', 20 );
		$this->loader->add_action( 'wp_ajax_aiovg_update_views_count', $plugin_public_video, 'ajax_callback_update_views_count' );
		$this->loader->add_action( 'wp_ajax_nopriv_aiovg_update_views_count', $plugin_public_video, 'ajax_callback_update_views_count' );		
		
		// Hooks specific to the search form
		$plugin_public_search = new AIOVG_Public_Search();

	}

	/**
	 * Blocks Initializer.
	 *
	 * @since     1.5.6
	 * @access    private
	 */
	private function blocks_init() {

		$plugin_blocks = new AIOVG_Blocks();

		$this->loader->add_action( 'plugins_loaded', $plugin_blocks, 'register_block_types' );
		$this->loader->add_action( 'enqueue_block_editor_assets', $plugin_blocks, 'enqueue_block_editor_assets' );

		$this->loader->add_filter( 'block_categories', $plugin_blocks, 'block_categories' );

	}
	
	/**
	 * Add hook to register widgets.
	 *
	 * @since     1.0.0
	 * @access    private
	 */
	private function widgets_init() {
		$this->loader->add_action( 'widgets_init', $this, 'register_widgets' );
	}
	
	/**
	 * Register widgets.
	 *
	 * @since    1.0.0
	 */
	public function register_widgets() {
		
		register_widget( "AIOVG_Widget_Categories" );
		register_widget( "AIOVG_Widget_Videos" );		
		register_widget( "AIOVG_Widget_Video" );
		register_widget( "AIOVG_Widget_Search" );			
		
	}
	
	/**
	 * Map meta caps to primitive caps.
	 *
	 * @since     1.0.0
	 * @access    private
	 */
	private function set_meta_caps() {

		$plugin_roles = new AIOVG_Roles();

		$this->loader->add_filter( 'map_meta_cap', $plugin_roles, 'meta_caps', 10, 4 );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

}
