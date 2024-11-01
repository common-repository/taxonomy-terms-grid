<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://businessupwebsite.com
 * @since      1.0.0
 *
 * @package    Taxonomy_Terms_Grid
 * @subpackage Taxonomy_Terms_Grid/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Taxonomy_Terms_Grid
 * @subpackage Taxonomy_Terms_Grid/public
 * @author     Ivan Chernyakov <admin@businessupwebsite.com>
 */
class Taxonomy_Terms_Grid_Public {

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
		 * defined in Taxonomy_Terms_Grid_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Taxonomy_Terms_Grid_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/taxonomy-terms-grid-public.css', array(), $this->version, 'all' );

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
		 * defined in Taxonomy_Terms_Grid_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Taxonomy_Terms_Grid_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/taxonomy-terms-grid-public.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Grid shortcode
	 *
	 * @since    1.0.0
	 * @since    1.0.1 Added $classes, $exclude
	 */
	public function grid_shortcode_return( $atts, $content = null ) {

		// Attributes
		$atts = shortcode_atts( array(
			'id' => '',
		), $atts, 'terms_grid' );

		ob_start();

		if ( $atts[ 'id' ] ) {

		    // Get template content
			$grid_id = $atts[ 'id' ];
			if ( class_exists('ACF') ){
				if (get_field( 'ttg_choose_taxonomy', $grid_id )){
					$taxonomy = get_field( 'ttg_choose_taxonomy', $grid_id );
					$terms = get_terms( $taxonomy, array(
						'hide_empty' => false,
					) );
					$exclude = array();
					$exclude_list = array();
					if (get_field( 'ttg_exclude_one', $grid_id )){
						$exclude = array(1);
					}
					if (get_field( 'ttg_exclude_terms', $grid_id )){
						$exclude_list = explode( ',', get_field( 'ttg_exclude_terms', $grid_id ) );
						$exclude = array_merge( $exclude, $exclude_list );
					}
					if ( $terms ){
						// Classes
						$classes = '';
						$html = '';
						if ( get_field( 'ttg_elements_per_row', $grid_id ) ){
							if ( get_field( 'ttg_elements_per_row', $grid_id ) == '3' ){
								$classes = 'ttg-3-per-row';
							}
							else{
								$classes = 'ttg-4-per-row';
							}
						}
						$html .= '<div class="ttg-container '.$classes.'">';
						foreach ($terms as $key => $category) {
							$term_id = $category->term_id;
							if ( in_array($term_id, $exclude) ){
								continue;
							}
							$title = $category->name;
							$image = '';
							$size = array( 300,300 );
							$html .= '<a href="'.esc_url( get_term_link($term_id) ).'" class="ttg-term">';
							if ( get_field( 'ttg_thumbnail', 'category'.'_'.$term_id) ){
								$image = get_field( 'ttg_thumbnail', 'category'.'_'.$term_id);
								$cur_image = wp_get_attachment_image_src($image,$size);
								$html .= '<img src="'.esc_url( $cur_image[0] ).'">';
							}
							$html .= '<h4>'.esc_html( $title ).'</h4></a>';
						}
						$html .= '</div>';
					}
					echo $html;
				}
			}
		}

		return ob_get_clean();

	}
	
}
