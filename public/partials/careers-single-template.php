<?php get_header();

//NOT BEING USED

$options = get_option('wprem-careers_options');

// Layout variables
$layout = $options['layout'];
$titleTag = $options['tagDetail'];
$jexp = $options['showExpiry'];
$jtype = $options['showType'];
$jcomp = $options['showComp'];
$jformS = $options['enableForms'];
$jform = $options['formSelect'];

//Post meta
$expiry_date = new DateTime();
$expiry_date->setTimestamp(get_post_meta($post->ID, '_data_expiry_date', true));
$expiry = $jexp = 1 ? "This Job Posting is Open Until: <strong>" . $expiry_date->format('l, F j o') . '</strong>' : '';

$jobTypes = wp_get_post_terms(get_the_ID(), 'wprem_careers_type', array("fields" => "all"));
//$jobType = get_post_meta($post->ID, '_data_employment_type', true);
$jobComp = get_post_meta($post->ID, '_data_compensation', true);

$gfShortcode = ($jformS == 1 ? do_shortcode('[gravityform id=' . $jform . ' title=true description=false ajax=true tabindex=49]') : '');
?>



<div class="container">
  <div class="row">

    <?php

switch ($layout) {
    case 'right': ?>

            <div class="fl-content wprem-careers-single wprem-careers-<?php echo $layout; ?>  <?php FLTheme::content_class();?>">
              <?php if (have_posts()): while (have_posts()): the_post();?>
		                <<?php echo $titleTag; ?> class="fl-post-title wprem-jobtitle wprem-<?php echo $titleTag; ?>" itemprop="headline">
		                  <?php echo get_the_title(); ?>
		                  <?php edit_post_link(_x('Edit', 'Edit post link text.', 'fl-automator'));?>
		                </<?php echo $titleTag; ?>>
		                <?php echo ($jexp = 1 ? '<span class="wprem-jobexpiry">' . $expiry . '</span>' : '') ?>
		                <?php echo ($jtype = 1 ? '<span class="wprem-jobtype">' . $jobTypes[0]->name . '</span>' : '') ?>
		                <?php echo ($jcomp = 1 ? '<span class="wprem-jobcomp">' . $jobComp . '</span>' : '') ?>
		                <?php the_content();?>

		              <?php endwhile;endif;?>
            </div>
            <div class="col-md-4"><?php echo $gfShortcode; ?></div>


            <?php break;
    case 'left': ?>

            <div class="col-md-4"><?php echo $gfShortcode; ?></div>

            <div class="fl-content wprem-careers-single wprem-careers-<?php echo $layout; ?> <?php FLTheme::content_class();?>">

              <?php if (have_posts()): while (have_posts()): the_post();?>
		                <<?php echo $titleTag; ?> class="fl-post-title wprem-jobtitle wprem-<?php echo $titleTag; ?>" itemprop="headline">
		                  <?php echo get_the_title(); ?>
		                  <?php edit_post_link(_x('Edit', 'Edit post link text.', 'fl-automator'));?>
		                </<?php echo $titleTag; ?>>
		                <?php echo ($jexp = 1 ? '<span class="wprem-jobexpiry">' . $expiry . '</span>' : '') ?>
		                <?php echo ($jtype = 1 ? '<span class="wprem-jobtype">' . $jobType . '</span>' : '') ?>
		                <?php echo ($jcomp = 1 ? '<span class="wprem-jobcomp">' . $jobComp . '</span>' : '') ?>
		                <?php the_content();?>
		              <?php endwhile;endif;?>
            </div>
           <?php break;

    case 'full': ?>
            <div class="fl-content wprem-careers-single wprem-careers-<?php echo $layout; ?>">
              <?php if (have_posts()): while (have_posts()): the_post();?>
		                <<?php echo $titleTag; ?> class="fl-post-title wprem-jobtitle wprem-<?php echo $titleTag; ?>" itemprop="headline">
		                  <?php echo get_the_title(); ?>
		                  <?php edit_post_link(_x('Edit', 'Edit post link text.', 'fl-automator'));?>
		                </<?php echo $titleTag; ?>>
		                <?php echo ($jexp = 1 ? '<span class="wprem-jobexpiry">' . $expiry . '</span>' : '') ?>
		                <?php echo ($jtype = 1 ? '<span class="wprem-jobtype">' . $jobType . '</span>' : '') ?>
		                <?php echo ($jcomp = 1 ? '<span class="wprem-jobcomp">' . $jobComp . '</span>' : '') ?>
		                <?php the_content();?>
		              <?php endwhile;endif;?>
              <hr/>
            </div>
            <div class="col-md-12"><h4>Apply Now!</h4>
            <?php echo $gfShortcode; ?></div>

            <?php break;
}
?>



  </div>
</div>

<?php get_footer();?>