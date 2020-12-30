<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       .
 * @since      1.0.0
 *
 * @package    Wprem_Careers
 * @subpackage Wprem_Careers/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wprem_Careers
 * @subpackage Wprem_Careers/admin
 * @author     Mareshah Logan <.>
 */
class Wprem_Careers_Admin
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
         * defined in Wprem_Careers_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Wprem_Careers_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/wprem-careers-admin.css', array(), $this->version, 'all');

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
         * defined in Wprem_Careers_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Wprem_Careers_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/wprem-careers-admin.js', array('jquery'), $this->version, false);

    }

    public function add_button()
    {
        echo '<a href="#TB_inline?width=480&height=500&inlineId=wp_career_shortcode" class="button thickbox wp_doin_media_link" title="Careers Options" id="add_div_shortcode">CA</a>';
    }

    public function wp_doin_mce_popup()
    {
        ?>
			<div id="wp_career_shortcode" style="display:none;">
				<div class="wrap wp_doin_shortcode">
					<div>
						<div style="padding:10px">
							<h3 style="display: none;color:#5A5A5A!important; font-family:Georgia,Times New Roman,Times,serif!important; font-size:1.8em!important; font-weight:normal!important;">Careers Shortcode</h3>

							<div class="field-container">
								<div class="label-desc">
									<?php
$args = array(
            'post_type' => 'wprem_careers',
            'post_status' => 'publish',
        );
        echo '<select id="wprem_careers_id"><option value="">Show All Job Postings</option>';
        $careers = get_posts($args);
        foreach ($careers as $career):
            setup_postdata($career);
            echo "<option value=" . $career->ID . ">" . $career->post_title . "</option>";
        endforeach;
        wp_reset_postdata();
        echo "</select>";
        ?>
								</div>
							</div>
							<div class="field-container">

								<div class="label-desc">
									<select id="wprem_careers_link" name="wprem_careers_link">
										<option value="">Select Link Option</option>
										<option value="no">No</option>
										<option value="internal">Internal</option>
										<option value="external">External</option>
									</select>
								</div>
								<div class="label-desc">
									<select id="wprem_careers_desc">
										<option value="">Select Description</option>
										<option value="no">No</option>
										<option value="full">Full</option>
										<option value="short">Short</option>
									</select>
								</div>
								<div class="label-desc">
									<select id="wprem_careers_layout">
										<option value="">Select Layout</option>
										<option value="list">List View</option>
										<option value="table">Tabular</option>
									</select>
								</div>

								<div class="label-desc">
									<input type="checkbox" name="searchbar" id="wprem_careers_searchbar" value="true" />
									<label for="wprem_careers_searchbar"><strong>Show Search bar</strong></label>
								</div>

								<div class="label-desc">
									<input type="checkbox" name="apply" id="wprem_careers_apply" value="true" />
									<label for="wprem_careers_apply"><strong>Show How To Apply Notice</strong></label>
								</div>
								<div class="label-desc">
									<input type="checkbox" name="posted" id="wprem_careers_posted" value="true" />
									<label for="wprem_careers_posted"><strong>Show Posted Date</strong></label>
								</div>
								<div class="label-desc">
									<input type="checkbox" name="ref" id="wprem_careers_ref" value="true" />
									<label for="wprem_careers_ref"><strong>Show Reference #</strong></label>
								</div>
								<div class="label-desc">
									<input type="checkbox" name="expiry" id="wprem_careers_exp" value="true" />
									<label for="wprem_careers_exp"><strong>Show Expiry Date</strong></label>
								</div>
								<div class="label-desc">
									<input type="checkbox" name="comp" id="wprem_careers_comp" value="true" />
									<label for="wprem_careers_comp"><strong>Show Compensation</strong></label>
								</div>
								<div class="label-desc">
									<input type="checkbox" name="type" id="wprem_careers_type" value="true" />
									<label for="wprem_careers_type"><strong>Show Job Type</strong></label>
								</div>
							</div>
						</div>
						<hr />
						<div style="padding:15px;">
							<input type="button" class="button-primary" value="Insert Job Posting" id="career-insert" />
							&nbsp;&nbsp;&nbsp;<a class="button" href="#" onclick="tb_remove(); return false;">Cancel</a>
						</div>
					</div>
				</div>
			</div>
			<?php
}

    public function content_types()
    {
        $exludefromsearch = (esc_attr(get_option('wprem_searchable_wprem-careers')) === "1") ? false : true;
        $args = array(
            'exclude_from_search' => $exludefromsearch,
            'has_archive' => false,
            'supports' => array('title', 'editor', 'thumbnail'),
            'rewrite' => array('slug' => 'careers', 'with_front' => false),
            'labels' => array(
                "name" => "Careers",
                'menu_name' => 'Careers',
                "add_new" => "Add New Job",
                "add_new_item" => "Add New Job",
                "all_items" => "All Jobs",
            ),
            "menu_icon" => "dashicons-businessman",
        );

        $career_cat_args = array(
            'has_archive' => true,
            'hierarchical' => true,
            'show_in_nav_menus' => true,
            'menu_icon' => 'dashicons-format-status',
            'rewrite' => array('slug' => 'careers-category'),
            'labels' => array('name' => __('Job Categories', 'cuztom'),
                'menu_name' => __('Job Categories', 'cuztom'),
                'add_new' => __('Add New Job Category', 'cuztom'),
                'add_new_item' => __('Add New Job Category', 'cuztom'),
                'all_items' => __('All Job Categories', 'cuztom'),
                'view' => __('View Job Categories', 'cuztom'),
                'view_item' => __('View Job Category', 'cuztom'),
                'search_items' => __('Search Job Categories', 'cuztom'),
                'not_found' => __('No Job Category Found', 'cuztom'),
                'not_found_in_trash' => __('No Job Category found in Trash', 'cuztom')),
            //'supports' => array('title', 'editor'),
            'show_in_rest' => true,
            'rest_controller_class' => 'WP_REST_Terms_Controller',
            'show_admin_column' => true,
            'admin_column_sortable' => true,
            'admin_column_filter' => true,
        );

        $career_type_args = array(
            'has_archive' => true,
            'hierarchical' => true,
            'show_in_nav_menus' => true,
            'menu_icon' => 'dashicons-format-status',
            'rewrite' => array('slug' => 'careers-type'),
            'labels' => array('name' => __('Job Types', 'cuztom'),
                'menu_name' => __('Job Types', 'cuztom'),
                'add_new' => __('Add New Job Type', 'cuztom'),
                'add_new_item' => __('Add New Job Type', 'cuztom'),
                'all_items' => __('All Job Types', 'cuztom'),
                'view' => __('View Job Types', 'cuztom'),
                'view_item' => __('View Job Type', 'cuztom'),
                'search_items' => __('Search Job Types', 'cuztom'),
                'not_found' => __('No Job Type Found', 'cuztom'),
                'not_found_in_trash' => __('No Job Type found in Trash', 'cuztom')),
            'show_in_rest' => true,
            'rest_controller_class' => 'WP_REST_Terms_Controller',
            'show_admin_column' => true,
            'admin_column_sortable' => true,
            'admin_column_filter' => true,
        );

        $career = register_cuztom_post_type('wprem_careers', $args);
        $career_category = register_cuztom_taxonomy('wprem_careers_category', 'wprem_careers', $career_cat_args);
        $career_type = register_cuztom_taxonomy('wprem_careers_type', 'wprem_careers', $career_type_args);

        $addons_arr = $addon_locations = array();

        $addons_arr = array(
            array(
                'id' => '_data_reference',
                'type' => 'text',
                'label' => 'Reference #',
                'html_attributes' => array('autocomplete' => 'off'),
            ),
            array(
                'id' => '_data_expiry_date',
                'type' => 'date',
                'label' => 'Expiry Date',
                'html_attributes' => array('autocomplete' => 'off'),
                'args' => array(
                    'date_format' => 'yy-mm-dd',
                ),
            ),
            array(
                'id' => '_data_compensation',
                'type' => 'text',
                'label' => 'Compensation',
            ),
            array(
                'id' => '_data_external_link',
                'type' => 'text',
                'label' => 'External Link',
            ),
        );

        if (defined('WPREM_LOCATIONS_CUSTOM_POST_TYPE')) {
            $addon_locations = array(
                'id' => '_data_post_locations',
                'type' => 'post_select',
                'label' => 'Location',
                'args' => array(
                    'post_type' => WPREM_LOCATIONS_CUSTOM_POST_TYPE,
                    'orderby' => 'title',
                    'order' => 'ASC',
                ));

            array_push($addons_arr, $addon_locations);

        }

        //print_r($addons_arr);

        $careerDeets = register_cuztom_meta_box(
            'data',
            'wprem_careers',
            array(
                'title' => 'Job Posting Settings',
                'fields' => $addons_arr,
            )
        );

    }

    // Create dummy options
    public function wprem_activate()
    {
        $wpremSetting = array(
            'sortAlpha' => '0',
            'showRef' => '1',
            'showExpiry' => '1',
            'showComp' => '1',
            'showType' => '1',
            'tagArchive' => 'h2',
            'tagDetail' => 'h1',
            'layout' => 'right',
            'emptyCPT' => 'Sorry, we currently have no job openings',
            'apply' => '',
            'formSelect' => '0',
        );

        if (get_option($this->plugin_name . '_options') === false) {
            add_option($this->plugin_name . '_options', $wpremSetting);
        }
    }

    public function wprem_careers_pages()
    {
        // Add documentation page.
        add_submenu_page(
            'edit.php?post_type=wprem_careers',
            apply_filters($this->plugin_name . '-settings-page-title', esc_html__('Website Premium Careers Add-on Help', 'wprem_careers')),
            apply_filters($this->plugin_name . '-settings-menu-title', esc_html__('Help', 'wprem_careers')),
            'manage_options',
            $this->plugin_name . '-help',
            array($this, 'wprem_careers_help')
        );
        // Add SEttings page
        add_submenu_page(
            'edit.php?post_type=wprem_careers',
            apply_filters($this->plugin_name . '-settings-page-title', esc_html__('Careers Add-on Options', 'wprem_careers')),
            apply_filters($this->plugin_name . '-settings-menu-title', esc_html__('Settings', 'wprem_careers')),
            'manage_options',
            $this->plugin_name . '-settings',
            array($this, 'wprem_careers_settings')
        );
        //FLBuilder::register_templates(plugin_dir_path( __FILE__ ).'/template-data/templates.dat');
    }

    public function wprem_careers_help()
    {
        include plugin_dir_path(__FILE__) . 'partials/wprem-careers-help.php';
    }

    public function wprem_careers_settings()
    {
        include plugin_dir_path(__FILE__) . 'partials/wprem-careers-settings.php';
    }

    public function validate($input)
    {
        // All checkboxes inputs
        $valid = array();

        //Cleanup
        $valid['sortAlpha'] = (isset($input['sortAlpha']) && !empty($input['sortAlpha'])) ? 1 : 0;
        $valid['showRef'] = (isset($input['showRef']) && !empty($input['showRef'])) ? 1 : 0;
        $valid['showExpiry'] = (isset($input['showExpiry']) && !empty($input['showExpiry'])) ? 1 : 0;
        $valid['showComp'] = (isset($input['showComp']) && !empty($input['showComp'])) ? 1 : 0;
        $valid['showType'] = (isset($input['showType']) && !empty($input['showType'])) ? 1 : 0;
        //$valid['showDetailPage'] = (isset($input['showDetailPage']) && !empty($input['showDetailPage'])) ? 1 : 0;
        $valid['tagArchive'] = (isset($input['tagArchive']) && !empty($input['tagArchive'])) ? $input['tagArchive'] : 'h2';
        $valid['tagDetail'] = (isset($input['tagDetail']) && !empty($input['tagDetail'])) ? $input['tagDetail'] : 'h1';
        $valid['layout'] = (isset($input['layout']) && !empty($input['layout'])) ? $input['layout'] : 'right';
        $valid['emptyCPT'] = esc_attr($input['emptyCPT']);
        $valid['apply'] = esc_attr($input['apply']);
        $valid['enableForms'] = (isset($input['enableForms']) && !empty($input['enableForms'])) ? 1 : 0;
        $valid['formSelect'] = (isset($input['formSelect']) && !empty($input['formSelect'])) ? $input['formSelect'] : '1';
        return $valid;
    }

    public function wprem_careers_options()
    {
        register_setting($this->plugin_name . '_options', $this->plugin_name . '_options', array($this, 'validate'));
    }

    public function wprem_bb_template()
    {

        if (!class_exists('FLBuilder') || !method_exists('FLBuilder', 'register_templates')) {
            echo 'asdoasdnosanpsmco[siand saci msacpmas ';
            return;
        }

        // FLBuilder::register_templates(plugins_url($this->plugin_name).'/template-data/templates.dat');
    }

}
