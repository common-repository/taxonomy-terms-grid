<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://businessupwebsite.com
 * @since      1.0.0
 *
 * @package    Taxonomy_Terms_Grid
 * @subpackage Taxonomy_Terms_Grid/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Taxonomy_Terms_Grid
 * @subpackage Taxonomy_Terms_Grid/admin
 * @author     Ivan Chernyakov <admin@businessupwebsite.com>
 */
class Taxonomy_Terms_Grid_Admin {

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
		 * defined in Taxonomy_Terms_Grid_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Taxonomy_Terms_Grid_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/taxonomy-terms-grid-admin.css', array(), $this->version, 'all' );

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
		 * defined in Taxonomy_Terms_Grid_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Taxonomy_Terms_Grid_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/taxonomy-terms-grid-admin.js', array( 'jquery' ), $this->version, false );

	}
	
	/**
	 * Register required plugins.
	 *
	 * @since    1.0.0
	 */
	public function taxonomy_terms_grid_register_required_plugins() {	
		$plugins = array(
			array(
				'name'      => 'Advanced Custom Fields',
				'slug'      => 'advanced-custom-fields',
				'required'  => true,
			),
		);

		$config = array(
			'id'           => 'taxonomy-terms-grid',                 // Unique ID for hashing notices for multiple instances of TGMPA.
			'default_path' => '',                      // Default absolute path to bundled plugins.
			'menu'         => 'tgmpa-install-plugins', // Menu slug.
			'parent_slug'  => 'plugins.php',            // Parent menu slug.
			'capability'   => 'manage_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
			'has_notices'  => true,                    // Show admin notices or not.
			'dismissable'  => false,                    // If false, a user cannot dismiss the nag message.
			'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
			'is_automatic' => false,                   // Automatically activate plugins after installation or not.
			'message'      => '',                      // Message to output right before the plugins table.
			'strings'      => array(
				'notice_can_install_required'     => _n_noop(
					/* translators: 1: plugin name(s). */
					'Taxonomy Terms Grid plugin requires the following plugin: %1$s.',
					'Taxonomy Terms Grid plugin requires the following plugins: %1$s.',
					'taxonomy-terms-grid'
				)
			),
		);
		tgmpa( $plugins, $config );
	}

	/**
	 * Add menu page
	 *
	 * @since 1.0.0
	 */
	public function add_page() {

		// Name
		$name = esc_html__( 'Taxonomy Grids', 'taxonomy-terms-grid' );

		add_menu_page(
			esc_html__( 'Taxonomy Grids', 'taxonomy-terms-grid' ),
			$name,
			'manage_options',
			'edit.php?post_type=ttg_grid'
		);

	}

	/**
	 * Register grid post type
	 *
	 * @since 1.0.0
	 */
	public static function grid_post_type() {

		// Name
		$name = esc_html__( 'My Grids', 'taxonomy-terms-grid' );

		// Register the post type
		register_post_type( 'ttg_grid', array(
			'labels' => array(
				'name' 					=> $name,
				'singular_name' 		=> esc_html__( 'Grid', 'taxonomy-terms-grid' ),
				'add_new' 				=> esc_html__( 'Add New', 'taxonomy-terms-grid' ),
				'add_new_item' 			=> esc_html__( 'Add New Grid', 'taxonomy-terms-grid' ),
				'edit_item' 			=> esc_html__( 'Edit Grid', 'taxonomy-terms-grid' ),
				'new_item' 				=> esc_html__( 'Add New Grid', 'taxonomy-terms-grid' ),
				'view_item' 			=> esc_html__( 'View Grid', 'taxonomy-terms-grid' ),
				'search_items' 			=> esc_html__( 'Search Grid', 'taxonomy-terms-grid' ),
				'not_found' 			=> esc_html__( 'No Grids Found', 'taxonomy-terms-grid' ),
				'not_found_in_trash' 	=> esc_html__( 'No Grids Found In Trash', 'taxonomy-terms-grid' ),
				'menu_name' 			=> esc_html__( 'My Grids', 'taxonomy-terms-grid' ),
			),
			'public' 					=> false,
			'hierarchical'          	=> false,
			'show_ui'               	=> true,
			'show_in_menu' 				=> false,
			'show_in_nav_menus'     	=> false,
			'can_export'            	=> true,
			'exclude_from_search'   	=> true,
			'capability_type' 			=> 'post',
			'rewrite' 					=> false,
			'supports' 					=> array( 'title', 'author' ),
		) );

	}

	function acf_load_taxonomy_choices( $field ) {

	    // reset choices
		$field['choices'] = get_taxonomies();

	    // return the field
		return $field;

	}

	/**
	 * Add shorcode metabox
	 *
	 * @since 1.0.0
	 */
	public static function shortcode_metabox( $post ) {

		add_meta_box(
			'grid-shortcode-metabox',
			esc_html__( 'Shortcode', 'taxonomy-terms-grid' ),
			array( 'Taxonomy_Terms_Grid_Admin', 'display_metabox' ),
			'ttg_grid',
			'side',
			'low'
		);

	}

	/**
	 * Add shorcode metabox
	 *
	 * @since 1.0.0
	 */
	public static function display_metabox( $post ) { ?>

		<input type="text" class="widefat" value='[terms_grid id="<?php echo $post->ID; ?>"]' readonly />

	<?php
	}

	/**
	 * Add acf options.
	 *
	 * @since 1.0.0
	 * @since 1.0.1 Added ttg_elements_per_row, ttg_exclude_one, ttg_exclude_terms fields
	 */
	public static function add_acf_otions( $post ) {
		if( function_exists('acf_add_local_field_group') ):

			acf_add_local_field_group(array(
				'key' => 'group_5d44b52003e48',
				'title' => 'Grid Options',
				'fields' => array(
					array(
						'key' => 'field_5d44b540cc32f',
						'label' => 'Taxonomy',
						'name' => 'ttg_choose_taxonomy',
						'type' => 'select',
						'instructions' => 'Choose taxonomy for grid',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'choices' => array(
						),
						'default_value' => array(
						),
						'allow_null' => 0,
						'multiple' => 0,
						'ui' => 0,
						'return_format' => 'value',
						'ajax' => 0,
						'placeholder' => '',
					),
					array(
						'key' => 'field_5d49f231c4e19',
						'label' => 'Elements per row',
						'name' => 'ttg_elements_per_row',
						'type' => 'select',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'choices' => array(
							3 => '3',
							4 => '4',
						),
						'default_value' => array(
						),
						'allow_null' => 0,
						'multiple' => 0,
						'ui' => 0,
						'return_format' => 'value',
						'ajax' => 0,
						'placeholder' => '',
					),
					array(
						'key' => 'field_5d49ee64d791c',
						'label' => 'Exclude id=1',
						'name' => 'ttg_exclude_one',
						'type' => 'checkbox',
						'instructions' => 'Exclude term sith id=1 (uncategorized for category)',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'choices' => array(
							'yes' => 'Yes',
						),
						'allow_custom' => 0,
						'default_value' => array(
						),
						'layout' => 'vertical',
						'toggle' => 0,
						'return_format' => 'value',
						'save_custom' => 0,
					),
					array(
						'key' => 'field_5d49f30e87dca',
						'label' => 'Exclude Terms',
						'name' => 'ttg_exclude_terms',
						'type' => 'text',
						'instructions' => 'Ex: 2,3,4,5',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
				),
				'location' => array(
					array(
						array(
							'param' => 'post_type',
							'operator' => '==',
							'value' => 'ttg_grid',
						),
					),
				),
				'menu_order' => 0,
				'position' => 'normal',
				'style' => 'default',
				'label_placement' => 'top',
				'instruction_placement' => 'label',
				'hide_on_screen' => '',
				'active' => true,
				'description' => '',
			));

			acf_add_local_field_group(array(
				'key' => 'group_5d4490dd0e78f',
				'title' => 'Taxonomy Terms Grid',
				'fields' => array(
					array(
						'key' => 'field_5d44914ed89b3',
						'label' => 'Thumbnail',
						'name' => 'ttg_thumbnail',
						'type' => 'image',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'return_format' => 'id',
						'preview_size' => 'medium',
						'library' => 'all',
						'min_width' => '',
						'min_height' => '',
						'min_size' => '',
						'max_width' => '',
						'max_height' => '',
						'max_size' => '',
						'mime_types' => '',
					),
				),
				'location' => array(
					array(
						array(
							'param' => 'taxonomy',
							'operator' => '==',
							'value' => 'all',
						),
					),
				),
				'menu_order' => 0,
				'position' => 'normal',
				'style' => 'default',
				'label_placement' => 'top',
				'instruction_placement' => 'label',
				'hide_on_screen' => '',
				'active' => true,
				'description' => '',
			));

		endif;
	}

}
