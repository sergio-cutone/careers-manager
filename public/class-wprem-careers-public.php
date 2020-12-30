<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       .
 * @since      1.0.0
 *
 * @package    Wprem_Careers
 * @subpackage Wprem_Careers/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Wprem_Careers
 * @subpackage Wprem_Careers/public
 * @author     Mareshah Logan <.>
 */
class Wprem_Careers_Public
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
     * @param      string    $plugin_name       The name of the plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

    }

    /**
     * Register the stylesheets for the public-facing side of the site.
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

        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/wprem-careers-public.css', array(), $this->version, 'all');

    }

    /**
     * Register the JavaScript for the public-facing side of the site.
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

        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/wprem-careers-public.js', array('jquery'), $this->version, false);

    }

    public function wprem_career_get_slugs()
    {
        global $post;

        if (is_archive()) {
            $link = get_post_type_archive_link('wprem_careers');
        } else {
            $link = get_permalink($post->ID);
        }

        if (empty($link)) {
            return false;
        } else {
            $link = str_replace(home_url('/'), '', $link);
            return $link;
        }
    }

    public function get_categories($atts, $v = false)
    {
        $vars = array('cat' => 'selected_category', 'init' => 'Categories', 'name' => 'selected_category', 'id' => 'category', 'tax' => 'wprem_careers_category', 'option' => 'wprem-careers');
        if ($v === 'type') {
            $vars = array('cat' => 'selected_jobtype', 'init' => 'Job Types', 'name' => 'selected_jobtype', 'id' => 'jobtype', 'tax' => 'wprem_careers_type', 'option' => 'wprem-career');
        }
        $selected_category = (null != filter_input(INPUT_GET, $vars['cat'])) ? sanitize_text_field(filter_input(INPUT_GET, $vars['cat'])) : false;

        // Job Category Arguments
        $args = array(
            'show_option_none' => esc_html__($vars['init'], $vars['option']),
            'orderby' => 'NAME',
            'order' => 'ASC',
            'hide_empty' => 0,
            'echo' => false,
            'hierarchical' => true,
            'name' => $vars['name'],
            'id' => $vars['id'],
            'class' => 'form-control',
            'selected' => $selected_category,
            'taxonomy' => $vars['tax'],
            'value_field' => 'slug',
            'hide_if_empty' => true,
        );

        // Display or retrieve the HTML dropdown list of job category
        return wp_dropdown_categories($args, $atts);
    }

    public function careers_shortcode($atts)
    {
        ob_start();
        global $post;
        $options = get_option($this->plugin_name . '_options');

        // Filter: Region,

        extract(shortcode_atts(array(
            'id' => '', // Single ID of career
            'posted' => '',
            'ref' => 0,
            'exp' => 0,
            'apply' => 0,
            'comp' => 0, // bool - Compensation
            'type' => '',
            'link' => 'internal',
            'desc' => 'short',
            'layout' => '',
            'searchbar' => 0,
        ), $atts));

        if($options['sortAlpha']) {
            $career['order'] = 'ASC';
            $career['orderby'] = 'title';
        } else {
            $career['order'] = 'DESC';
            $career['orderby'] = 'date';
        }

        $args = array(
            'post_type' => 'wprem_careers',
            'order' => $career['order'],
            'orderby' => $career['orderby'],
        );

        $keywords = isset($_GET["search_keywords"]) ? sanitize_text_field(filter_input(INPUT_GET, "search_keywords")) : false;
        if ($keywords) {
            $args['s'] = $keywords;
        }

        $filter_array = array();
        // - - - - - Filter by Category
        $filter_jobcat = isset($_GET["selected_category"]) ? $_GET["selected_category"] : false;
        if ($filter_jobcat && $filter_jobcat != -1) {
            $filter_array[] = array(
                'taxonomy' => 'wprem_careers_category',
                'field' => 'slug',
                'terms' => array($filter_jobcat), // Array of service categories you wish to retrieve posts from
            );
        }
        // - - - - - Filter by Job Type
        $filter_jobtype = isset($_GET["selected_jobtype"]) ? $_GET["selected_jobtype"] : false;
        if ($filter_jobtype && $filter_jobtype != -1) {
            $filter_array[] = array(
                'taxonomy' => 'wprem_careers_type',
                'field' => 'slug',
                'terms' => array($filter_jobtype), // Array of service categories you wish to retrieve posts from
            );
        }
        // - - - - - Add Filter to Query
        if (count($filter_array) >= 1) {
            $args["tax_query"] = array($filter_array);
        }

        // If ID is selected then update array Post Per Page = 1 & Post ID
        if ($id) {
            $args['p'] = $id;
        }

        $careers_out = '';
        $cq = new WP_Query($args);

        if ($searchbar == true) {
            $page_slug = $this->wprem_career_get_slugs();
            $slug = (get_option('permalink_structure')) ? $page_slug : '';

            echo '<div class="row"><form class="filters-form form-horizontal" action="' . esc_url(home_url('/')) . $slug . '" method="get"><div class="form-group">';
            $searchfilter = array();
            $searchfilter[] = '<input type="text" class="form-control" value="' . $keywords . '" placeholder="Job title, Keywords" id="keywords" name="search_keywords">';
            $searchfilter[] = $this->get_categories($atts) ? $this->get_categories($atts) : null;
            $searchfilter[] = $this->get_categories($atts, 'type') ? $this->get_categories($atts, 'type') : null;
            $searchfilter = array_filter($searchfilter);
            $col = 6;
            if (count($searchfilter) === 2) {
                $col = 4;
            } elseif (count($searchfilter) === 3) {
                $col = 3;
            }
            foreach ($searchfilter as $sf) {
                echo '<div class="col-md-' . $col . '">' . $sf . '</div>';
            }
            echo '<div class="col-md-' . $col . '"><input type="submit" value="Search" class="btn btn-block" /></div>';
            echo '</form></div>';
        }

        if ($posted == true) {
        }

        if ($exp == true) {
        }

        if ($apply == true) {
            echo '<div class="wprem-careers-applynotice"><div class="row"><div class="col-md-12">' . $options['apply'] . '</div></div></div>';
        }

        if ($cq->have_posts()) {
            echo '<div class="wprem-careers-wrap">';

            while ($cq->have_posts()): $cq->the_post();
                $postID = get_post_custom($post->ID);
                /*
                $jobDeets = $post->post_content;
                $jobType = get_post_meta($post->ID, '_data_employment_type', true);
                $jobRef = get_post_meta($post->ID, '_data_reference', true);
                $jobComp = get_post_meta($post->ID, '_data_compensation', true);
                $jobExternal = get_post_meta($post->ID, '_data_external_link', true);
                 */
                $job_title = get_the_title();
                if ($link == 'internal') {
                    // Link internally
                    $job_title = '<a href="' . get_the_permalink() . '">' . get_the_title() . '</a>';
                } elseif ($link == 'external') {
                    // Link externally
                    if (get_post_meta($post->ID, '_data_external_link', true)) {
                        $job_title = '<a href="' . get_post_meta($post->ID, '_data_external_link', true) . '" target="_blank">' . get_the_title() . ' <small><i class="fa fa-external-link" aria-hidden="true"></i></small></a>';
                    } else {
                        $job_title = '<a href="' . get_the_permalink() . '">' . get_the_title() . '</a>';
                    }
                } elseif ($link == 'none') {
                    // No Linking
                    $job_title = '' . get_the_title() . '';
                }

            echo '<div class="wprem-careers-listing wprem-careers-inner">'; // Start Row
            echo '<div class="row"><div class="col-md-12">';
            echo '<div class="title"><' . $listTag = $options['tagArchive'] . '>' . $job_title . '</' . $listTag = $options['tagArchive'] . '></div>';

            echo '<div class="row wprem-careers-data">';
            // Reference number
            if ($ref == true && get_post_meta($post->ID, '_data_reference', true)) {
                echo '<div class="col-sm-6 wprem-careers-reference"><span>Reference:</span> ' . get_post_meta($post->ID, '_data_reference', true) . '</div>';
            }
            // Date
            if ($posted == true) {
                echo '<div class="col-sm-6 wprem-careers-date-posted"><span>Posted on:</span> ' . get_the_date('l, F j o') . '</div>';
            }
            // Expired
            if ($exp == true && get_post_meta($post->ID, '_data_expiry_date', true)) {
                $expiry_date = new DateTime();
                $expiry_date->setTimestamp(get_post_meta($post->ID, '_data_expiry_date', true));
                echo '<div class="col-sm-6 wprem-careers-expiry_date"><span>Expires:</span> ' . $expiry_date->format('F j, o') . '</div>';
            }
            // Employment Type
            if ($type == true && $term_list = wp_get_post_terms($post->ID, 'wprem_careers_type', array("fields" => "names"))) {
                echo '<div class="col-sm-6 wprem-careers-employment_type"><span>Job Type:</span> ' . $term_list[0] . '</div>';
            }
            // Compensation
            if ($comp == true && get_post_meta($post->ID, '_data_compensation', true)) {
                echo '<div class="col-sm-6 wprem-careers-compensation"><span>Salary:</span> $' . number_format(get_post_meta($post->ID, '_data_compensation', true)) . '</div>';
            }
            echo '</div>';

            // Description full or excerpt
            if ($desc === 'short') {
                echo '<div class="desc-short">' . get_the_excerpt() . '</div>';
            } elseif ($desc == 'full') {
                echo '<div class="desc-full">' . apply_filters('the_content', get_the_content()) . '</div>';
            } elseif ($desc == 'none') {
                echo '<div class="desc-none"></div>';
            }
            echo '</div></div>'; // End Row
            echo '</div>';
            endwhile;
            echo '</div>'; // End wprem-careers-wrap
        } else {
            echo '<div class="row"><div class="col-md-12">' . $options['emptyCPT'] . '</div></div>';
        }
        $content = ob_get_clean();
        return $content;
    }

    public function careers_shortcodexx($atts)
    {
        // ob_start();
        global $post;

        $options = get_option($this->plugin_name . '_options');
        $listTag = $options['tagArchive'];
        $howApply = $options['apply'];

        $a = shortcode_atts(array(
            'id' => '', // Single ID of career
            'posted' => '', // Date
            'ref' => '', // Ref ID
            'exp' => '', // Expiry
            'apply' => '', // How to apply notice
            'comp' => '', // Compensation
            'type' => '', // Job type
            'link' => '', // Internal / External link
            'desc' => '', // Description
            'layout' => '', // List or Table view
            'searchbar' => '', // Searchbar
        ), $atts);

        $career['orderby'] = 'date';
        // $career['ppp'] = 999;

        $args = array(
            'post_type' => 'wprem_careers',
            'order' => 'ASC',
            'orderby' => $career['orderby'],

        );

        // If ID is selected then update array Post Per Page = 1 & Post ID
        if ($a['id']) {
            $args['p'] = $a['id'];
            // $args['posts_per_page'] = 1;
        }

        if ($a['searchbar'] == true) {

            //Get Job Location
            $selected_loc = (null != filter_input(INPUT_GET, 'selected_location') && -1 != filter_input(INPUT_GET, 'selected_location')) ? sanitize_text_field(filter_input(INPUT_GET, 'selected_location')) : '';

            if ($selected_loc != '') {
                $args['meta_query'] = array(
                    array(
                        'key' => '_data_post_locations',
                        'value' => $selected_loc,
                        'compare' => '=',
                    ),
                );
            }

            ?>
		<!-- Start Job Filters
================================================== -->
		<div class="<?php echo apply_filters('filters_form_class', $class); ?>">
		    <?php
// Get Current Page Slug
            $page_slug = $this->wprem_career_get_slugs();
            $slug = (get_option('permalink_structure')) ? $page_slug : '';

            // Merge WP_Query $args array on each $_GET element

            //Get Keyword
            $args['s'] = (null != filter_input(INPUT_GET, 'search_keywords')) ? sanitize_text_field((filter_input(INPUT_GET, 'search_keywords'))) : '';

            //Get Job Category
            $args['wprem_careers_category'] = (null != filter_input(INPUT_GET, 'selected_category') && -1 != filter_input(INPUT_GET, 'selected_category')) ? sanitize_text_field(filter_input(INPUT_GET, 'selected_category')) : '';

            //Get Job Type
            $args['wprem_careers_type'] = (null != filter_input(INPUT_GET, 'selected_jobtype') && -1 != filter_input(INPUT_GET, 'selected_jobtype')) ? sanitize_text_field(filter_input(INPUT_GET, 'selected_jobtype')) : '';

            /**
             * Job Filters Form
             *
             * - Keywords Search.
             * - Job Category Filter.
             * - Job Type Filter.
             * - Job Location Filter.
             *
             * Search jobs by category, job location, job type and keywords.
             */
            ?>

		    <form class="filters-form" action="<?php echo esc_url(home_url('/')) . $slug; ?>" method="get">
		        <div class="row">

		            <!-- Keywords Search-->
    			<div class="wprem-search-keywords col-sm-3">
        			<div class="form-group">
            			<?php

            // Append Query string With Page ID When Permalinks are not Set
            if (!get_option('permalink_structure') && !is_home() && !is_front_page()) {
                ?>
                			<input type="hidden" value="<?php echo get_the_ID(); ?>" name="page_id" >
            			<?php }?>
            			<label class="sr-only" for="keywords"><?php esc_html_e('Keywords', 'wprem-careers');?></label>
            			<input type="text" class="form-control" value="<?php echo isset($search_keyword) ? esc_attr(strip_tags($search_keyword)) : ''; ?>" placeholder="<?php _e('Search by Title', 'wprem-careers');?>" id="keywords" name="search_keywords">
        			</div>
    			</div>
		            <?php
/**
             * Template -> Category Filter:
             *
             * - Display Category Filter Dropdown.
             */
            //get_simple_job_board_template('search/category-filter.php', array('atts' => $atts));
            $selected_category = (null != filter_input(INPUT_GET, 'selected_category')) ? sanitize_text_field(filter_input(INPUT_GET, 'selected_category')) : false;

            /**
             * Creating list on non-empty job category
             *
             * Job Category Selectbox
             */

            // Job Category Arguments
            $category_args = array(
                'show_option_none' => esc_html__('Category', 'wprem-careers'),
                'orderby' => 'NAME',
                'order' => 'ASC',
                'hide_empty' => 0,
                'echo' => false,
                'hierarchical' => true,
                'name' => 'selected_category',
                'id' => 'category',
                'class' => 'form-control',
                'selected' => $selected_category,
                'taxonomy' => 'wprem_careers_category',
                'value_field' => 'slug',
            );

            // Display or retrieve the HTML dropdown list of job category
            $category_select = wp_dropdown_categories($category_args, $atts);
            ?>
    				<div class="wprem-careers-search-categories col-sm-3">
					    <div class="form-group">
					        <?php
if (isset($category_select) && (null != $category_select)) {
                echo $category_select;
            }
            ?>
					    </div>
					</div>
					<?php
/**
             * Fires after "Category" dropdown on job listing page
             *
             * @since   2.2.3
             */
            //do_action('sjb_category_filter_dropdown_after', $atts);

            /**
             * Template -> Type Filter:
             *
             * - Display Job Type Filter Dropdown.
             */

            $selected_jobtype = (null != filter_input(INPUT_GET, 'selected_jobtype')) ? sanitize_text_field(filter_input(INPUT_GET, 'selected_jobtype')) : false;

            /**
             * Creating list on non-empty job type
             *
             * Job Type Selectbox
             */
            // Job Type Arguments
            $jobtype_args = array(
                'show_option_none' => esc_html__('Job Type', 'wprem-career'),
                'orderby' => 'NAME',
                'order' => 'ASC',
                'hide_empty' => 0,
                'echo' => false,
                'name' => 'selected_jobtype',
                'id' => 'jobtype',
                'class' => 'form-control',
                'selected' => $selected_jobtype,
                'hierarchical' => true,
                'taxonomy' => 'wprem_careers_type',
                'value_field' => 'slug',
            );

            // Display or retrieve the HTML dropdown list of job type
            $jobtype_select = wp_dropdown_categories($jobtype_args, $atts);

            ?>
		            <div class="wprem-careers-search-job-type col-sm-3">
        				<div class="form-group">
				            <?php
if (null != $jobtype_select) {
                echo $jobtype_select;
            }
            ?>
        				</div>
    				</div>

					<?php
/**
             * Fires after "Job Type" dropdown on job listing page
             *
             * @since   2.2.3
             */
            //do_action('sjb_job_type_filter_dropdown_after', $atts);

            /**
             * Template -> Location Filter:
             *
             * - Display Job Location Filter Dropdown.
             */
            //get_simple_job_board_template('search/location-filter.php', array('atts' => $atts));
            /*$selected_location = ( NULL != filter_input(INPUT_GET, 'selected_location') ) ? sanitize_text_field( filter_input(INPUT_GET, 'selected_location') ) : FALSE;

            $jobloc_args = array(
            'post_type'   => WPREM_LOCATIONS_CUSTOM_POST_TYPE,
            'post_status' => 'publish'
            );

            echo '<div class="wprem-careers-search-location col-md-3"><div class="form-group"><select name="selected_location" id="location" class="form-control"><option value="-1">Location</option>';
            $locations = get_posts( $jobloc_args );

            foreach ( $locations as $location ) :
            setup_postdata( $location );
            $sel = ($selected_loc == $location->ID ? 'selected="selected"' : '');
            echo "<option ".$sel." value=".$location->ID.">".$location->post_title."</option>";
            endforeach;
            wp_reset_postdata();
            echo "</select></div></div>";*/

            /**
             * Fires after job location dropdown on job listing page.
             *
             * @since   2.2.0
             */
            //do_action('simple_job_board_job_filters_dropdowns_end', $atts);

            /**
             * Template -> Search Button:
             *
             * - Display Search Button.
             */
            ?>
		            <div class="wprem-career-search-button col-sm-3">
        				<input class="btn-search btn btn-primary btn-block" value="Search" type="submit">
        			</div>

		        </div>
		    </form>
		</div>
		<!-- ==================================================
		End Job Filters -->
		<?php
}
        $careers_out = '';
        $cq = new WP_Query($args);

        if ($cq->have_posts()) {
            $careers_out .= '<div class="wprem-careers-wrap">';

            /*if (strlen($howApply) > 0 && $a['expiry']) {
            $careers_out .= $howApply;
            }*/

            if ($a['layout'] == 'list') {
                while ($cq->have_posts()) {
                    $cq->the_post();
                    $postID = get_post_custom($post->ID);
                    $jobDeets = $post->post_content;
                    //$jobType = get_post_meta($post->ID, '_data_employment_type', true);
                    $jobRef = get_post_meta($post->ID, '_data_reference', true);
                    $jobComp = get_post_meta($post->ID, '_data_compensation', true);
                    $jobExternal = get_post_meta($post->ID, '_data_external_link', true);

                    //Get the job Type associate with it
                    $jobTypes = wp_get_post_terms(get_the_ID(), 'wprem_careers_type', array("fields" => "all"));

                    //$jobType = get_term_meta($jobTypes[0], '_data_address', true);

                    $expiry_date = new DateTime();
                    $expiry_date->setTimestamp(get_post_meta($post->ID, '_data_expiry_date', true));

                    $post_date = get_the_date('l, F j o');

                    $posted = $a['posted'] == true ? "<span class='wprem-jobposted'>Posted on: <strong>" . $post_date . "</strong></span> " : "";

                    $expiry = ($a['exp'] == true) ? '<span class="wprem-jobexpiry">Application Deadline: <strong>' . $expiry_date->format('l, F j o') . '</strong></span> ' : '';

                    $ref = $a['ref'] ? "<span class='wprem-jobref'>Reference # " . $jobRef . "</span> " : "";

                    $comp = $a['comp'] ? "<span class='wprem-jobcomp'>" . $jobComp . "</span>" : "";

                    $type = $a['type'] ? "<span class='wprem-jobtype'>" . $jobTypes[0]->name . "</span>" : "";

                    $careers_out .= '<div class="wprem-career">';
                    ?>
					<?php
$careers_out .= '<' . $listTag . '>';
                    if ($a['link'] == 'external') {
                        $careers_out .= '<a href="' . $jobExternal . '" target="_blank">' . get_the_title() . ' <small><i class="fa fa-external-link" aria-hidden="true"></i></small></a>';
                    } else if ($a['link'] == 'internal') {
                        $careers_out .= '<a href="' . get_the_permalink() . '">' . get_the_title() . '</a>';
                    } else if ($a['link'] == 'no' || $a['link'] == '') {
                        $careers_out .= get_the_title();
                    }
                    //$careers_out .= $showDetailPage == 1 ? '<a href="'.get_the_permalink().'">'.get_the_title().'</a>' : get_the_title();
                    $careers_out .= '</' . $listTag . '>';

                    $careers_out .= $posted;
                    $careers_out .= $expiry;
                    $careers_out .= $ref;
                    $careers_out .= $type;
                    $careers_out .= $comp;

                    if ($a['desc'] == 'short') {
                        $careers_out .= '<div class="wprem-jobexcerpt">' . get_the_excerpt() . ' <a href="' . get_the_permalink() . '">Read more</a><br/></div></div>';
                    } else if ($a['desc'] == 'full') {
                        $careers_out .= '<div class="wprem-jobexcerpt">' . get_the_content() . '<br/></div></div>';
                    }
                    $careers_out .= "</div>";
                }
            } else {
                $item = 1;?>
				<div class="table-responsive">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th>#</th>
								<?php
echo $a['posted'] == true ? '<th>Posted on</th>' : '';
                echo $a['ref'] == true ? '<th>Reference #</th>' : '';
                echo '<th>Program Name</th>';
                echo $a['exp'] == true ? '<th>Application Deadline</th>' : '';
                echo $a['type'] == true ? '<th>Job Type</th>' : '';
                echo $a['comp'] == true ? '<th>Salary</th>' : '';
                ?>
							</tr>
						</thead>
						<tbody>
								<?php
while ($cq->have_posts()) {
                    $cq->the_post();
                    $postID = get_post_custom($post->ID);
                    $jobDeets = $post->post_content;

                    $jobRef = get_post_meta($post->ID, '_data_reference', true);
                    $jobComp = get_post_meta($post->ID, '_data_compensation', true);
                    $jobExternal = get_post_meta($post->ID, '_data_external_link', true);

                    //Get the job Type associate with it
                    $jobTypes = wp_get_post_terms(get_the_ID(), 'wprem_careers_type', array("fields" => "all"));

                    //$jobType = get_term_meta($jobTypes[0], '_data_address', true);

                    $expiry_date = new DateTime();
                    $expiry_date->setTimestamp(get_post_meta($post->ID, '_data_expiry_date', true));

                    $post_date = get_the_date('F j o');

                    echo '<tr><th scope="row">' . $item . '</th>';
                    echo $posted = $a['posted'] == true ? '<td class="wprem-jobposted">' . $post_date . '</td>' : '';

                    echo $ref = $a['ref'] ? "<td class='wprem-jobref'>" . $jobRef . "</td> " : "";

                    //$careers_out .= $posted;
                    //$careers_out .= $ref;

                    if ($a['link'] == 'external') {
                        echo '<td class="wprem-jobtitle"><a href="' . $jobExternal . '" target="_blank">' . get_the_title() . ' <small><i class="fa fa-external-link" aria-hidden="true"></i></small></a></td>';
                    } else if ($a['link'] == 'internal') {
                        echo '<td class="wprem-jobtitle"><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></td>';
                    } else if ($a['link'] == 'no' || $a['link'] == '') {
                        echo '<td class="wprem-jobtitle">' . get_the_title() . '</td>';
                    }

                    echo $expiry = ($a['exp'] == true) ? '<td class="wprem-jobexpiry">' . $expiry_date->format('F j, o') . '</td> ' : '';

                    echo $type = $a['type'] ? "<td class='wprem-jobtype'>" . $jobTypes[0]->name . "</td>" : "";

                    echo $comp = $a['comp'] ? "<td class='wprem-jobcomp'>" . $jobComp . "</td>" : "";

                    //$careers_out .= $expiry;
                    //$careers_out .= $type;
                    //$careers_out .= $comp;

                    $item++;

                    echo '</tr>';
                }
                ?>

						</tbody>
					</table>
				</div>
  		<?php }
        } else {
            $careers_out .= $options['emptyCPT'];
        }
        return $careers_out;
        ob_clean();
        wp_reset_postdata();
    }

    public function careers_single($content)
    {
/*        global $post;

if (is_single() && $post->post_type == 'wprem_careers') {
include plugin_dir_path(__FILE__) . 'partials/careers-single-template.php';
}
//return $single_template;
wp_reset_postdata();*/

        if (is_singular('wprem_careers')) {
            ob_start();
            global $post;
            $options = get_option('wprem-careers_options');

            // Layout variables
            $layout = $options['layout'];
            $titleTag = $options['tagDetail'];
            $jref = $options['showRef'];
            $jexp = $options['showExpiry'];
            $jtype = $options['showType'];
            $jcomp = $options['showComp'];
            $jformS = $options['enableForms'];
            $jform = $options['formSelect'];
            $external = get_post_meta($post->ID, '_data_external_link', true);
            //Post meta
            $expiry_date = new DateTime();
            if (get_post_meta($post->ID, '_data_expiry_date', true)) {
                $expiry_date->setTimestamp(get_post_meta($post->ID, '_data_expiry_date', true));
            }
            $expiry = ($jexp == true) ? '<div class="col-sm-6"><span class="wprem-expiry wprem-label">Expires:</span></div><div class="col-sm-6"><span class="wprem-expirydate">' . $expiry_date->format('l, F j o') . '</span></div>' : '';

            $jobType = ($jtype == true && $term_list = wp_get_post_terms($post->ID, 'wprem_careers_type', array("fields" => "names"))) ? '<div class="col-sm-6"><span class="wprem-employment_type wprem-label">Job Type:</div><div class="col-sm-6"><span class="wprem-employmentType">' . $term_list[0] . '</span></div>' : '';

            $jobComp = ($jcomp == true && get_post_meta($post->ID, '_data_compensation', true)) ? '<div class="col-sm-6"><span class="wprem-compensation wprem-label">Compensation:</div><div class="col-sm-6"><span class="wprem-compensationamount">$' . money_format('%(#10n', get_post_meta($post->ID, '_data_compensation', true)) . '</span></div>' : '';

            //$gfShortcode = $external != '' ? '<a href="' . get_post_meta($post->ID, '_data_external_link', true) . '" class="btn btn-primary" target="_blank">Apply For This Opportunity <small><i class="fa fa-external-link" aria-hidden="true"></i></small></a>' : '<div class="wprem-career-apply-title">Apply Now</div>' . do_shortcode('[gravityform id=' . $jform . ' title=false description=false ajax=false tabindex="49" field_values="position=' . get_the_title() . '"]');
            $gfShortcode = $external != '' ? '<a href="' . get_post_meta($post->ID, '_data_external_link', true) . '" class="btn btn-primary" target="_blank">Apply For This Opportunity <small><i class="fa fa-external-link" aria-hidden="true"></i></small></a>' : (($jformS == true ? '<div class="wprem-career-apply-title">Apply Now</div>' . do_shortcode('[gravityform id=' . $jform . ' title=false description=false ajax=false tabindex="49" field_values="position=' . get_the_title() . '"]') : ''));

            setlocale(LC_MONETARY, 'en_US');

            $reference = ($jref == true && get_post_meta($post->ID, '_data_reference', true)) ? '<div class="col-sm-6"><span class="wprem-reference wprem-label">Reference: </span></div><div class="col-sm-6"><span class="wprem-referenceid">' . get_post_meta($post->ID, '_data_reference', true) . '</span></div>' : '';
            ?>
            <div class="wprem-careers-container">
                <div class="row">
                <?php
if ($layout == 'full') {
                ?>
                    <div class="col-md-12">
                <?php
} else if ($layout === 'right') {
                ?>
                    <div class="col-md-8">
                <?php
} else if ($layout == 'left') {
                ?>
                    <div class="col-md-8 col-md-push-4 order-2">
                <?php
}
            ?>
                        <div class="wprem-title">
                            <?php
echo '<' . $listTag = $options['tagDetail'] . '>';
            echo the_title();
            echo '</' . $listTag = $options['tagDetail'] . '>';
            ?>
                        </div>
                        <div class="wprem-content">
                            <?php echo get_the_content(); ?>
                        </div>
                        <div class="wprem-career-inner">
                            <div class="row">
                                <div class="col-md-12">
                                    <span class="wprem-career-opp-title wprem-block1">Opportunity Details</span>
                                </div>
                            </div>
                            <div class="row">
                                <?php echo $reference . $expiry . $jobType . $jobComp; ?>
                            </div>
                            <?php
if ($layout == 'full') {
                echo $gfShortcode;
            }
            ?>
                        </div>
                    </div>
                <?php
if ($layout === 'right') {
                ?>
                    <div class="col-md-4">
                        <div class="wprem-block2">
                            <?php echo $gfShortcode; ?>
                        </div>
                    </div>
                <?php
} else if ($layout == 'left') {
                ?>
                    <div class="col-md-4 col-md-pull-8 order-1">
                        <div class="wprem-block2">
                            <?php echo $gfShortcode; ?>
                        </div>
                    </div>
                <?php
}
            ?>
                </div>
            </div>
            <?php
$content = ob_get_clean();
        }

        //$content = ob_get_clean();
        return $content;
    }

    // /**
    // * force_template on cpt
    // * @param string $template template-location
    // * @return string
    // */
    // public function force_template( $template ) {
    //     // echo "stringaling";

    //     // check if user has set the template manually to be something different than default
    //     if ( $template !== locate_template( array( 'single.php' ) ) ) {
    //     return $template;
    //     }

    //     //array of CPT's you want this template to used
    //     $force_template_on_post_type = array( 'wprem_careers' );

    //     $template = plugin_dir_path( __FILE__ ) . 'partials/careers-single-template.php';

    //     if ( in_array( get_post_type() , $force_template_on_post_type ) ) {
    //         // $page = locate_template( array( 'tpl-full-width.php' ) );
    //     echo "stringaling";
    //     $template = plugin_dir_path( __FILE__ ) . 'partials/careers-single-template.php';

    //         // check if we can find this template
    //         if ( ! empty( $page ) ) return $page;
    //     }
    //     // if all else fails, stick with the original template
    //     return $template;
    // }

}
