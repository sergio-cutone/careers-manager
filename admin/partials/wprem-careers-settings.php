<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://www.yp.ca
 * @since      1.0.0
 *
 * @package    Wprem_Careers
 * @subpackage Wprem_Careers/admin/partials
 */


  $options = get_option($this->plugin_name.'_options');

  $wpremS = $this->plugin_name.'_options';

?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->


<?php settings_errors(); ?>

<div class="wrap wprem-careers-admin">
  <h1><span>Website</span> Premium <br> <small><?php echo esc_html(get_admin_page_title())?></small></h1>
  <p>Customize the way Job Postings look on your site.</p>
    <form method="post" action="options.php">
      <?php
        settings_fields( $this->plugin_name .'_options' );
        do_settings_sections( $this->plugin_name .'_options');
      ?>

      <h2>Layout</h2>

      <div class="wprem-careers-layout">
        <fieldset>
          <label>
            <input type="radio" name="<?php echo $wpremS; ?>[layout]" value="right" for="<?php echo $wpremS; ?>-layout" <?php checked( $options['layout'], 'right' ); ?>/>
            <div class="layout-option"></div>
          </label>
          <label>
            <input type="radio" name="<?php echo $wpremS; ?>[layout]" value="left" for="<?php echo $wpremS; ?>-layout" <?php checked( $options['layout'], 'left' ); ?>/>
            <div class="layout-option lLeft"></div>
          </label>
          <label>
            <input type="radio" name="<?php echo $wpremS; ?>[layout]" value="full" for="<?php echo $wpremS; ?>-layout" <?php checked( $options['layout'], 'full' ); ?>/>
            <div class="layout-option lCentre"></div>
          </label>
        </fieldset>
      </div>


      <h2>Display</h2>

      <fieldset class="labels-right">
        <strong>Sort Alphabetically</strong>
        <label class="wpremC-enable-switch" for="<?php echo $wpremS; ?>-sortAlpha">
          <input type="checkbox" name="<?php echo $wpremS; ?>[sortAlpha]" value="<?php echo $options['sortAlpha']?>" <?php checked($options['sortAlpha'],1);?> >
          <span class="wpremC-enable-slider"></span>
        </label>
      </fieldset>

      <fieldset class="labels-right">
        <strong>Display Reference #</strong>
        <label class="wpremC-enable-switch" for="<?php echo $wpremS; ?>-showRef">
          <input type="checkbox" name="<?php echo $wpremS; ?>[showRef]" value="<?php echo $options['showRef']?>" <?php checked($options['showRef'],1);?> >
          <span class="wpremC-enable-slider"></span>
        </label>
      </fieldset>

      <fieldset class="labels-right">
        <strong>Display Expiry Date</strong>
        <label class="wpremC-enable-switch" for="<?php echo $wpremS; ?>-showExpiry">
          <input type="checkbox" name="<?php echo $wpremS; ?>[showExpiry]" value="<?php echo $options['showExpiry']?>" <?php checked($options['showExpiry'],1);?> >
          <span class="wpremC-enable-slider"></span>
        </label>
      </fieldset>

      <fieldset class="labels-right">
        <strong>Display Compensation</strong>
        <label class="wpremC-enable-switch" for="<?php echo $wpremS; ?>-showComp">
          <input type="checkbox" name="<?php echo $wpremS; ?>[showComp]" value="<?php echo $options['showComp']?>" <?php checked($options['showComp'],1);?> >
          <span class="wpremC-enable-slider"></span>
        </label>
      </fieldset>

      <fieldset class="labels-right">
        <strong>Display Job Type</strong>
        <label class="wpremC-enable-switch" for="<?php echo $wpremS; ?>-showType">
          <input type="checkbox" name="<?php echo $wpremS; ?>[showType]" value="<?php echo $options['showType']?>" <?php checked($options['showType'],1);?> >
          <span class="wpremC-enable-slider"></span>
        </label>
      </fieldset>

      <!--<fieldset class="labels-right">
        <strong>Display Job Detail Page</strong>
        <label class="wpremC-enable-switch" for="<?php //echo $wpremS; ?>-showDetailPage">
          <input type="checkbox" name="<?php //echo $wpremS; ?>[showDetailPage]" value="<?php //echo esc_attr_e($options['showDetailPage'])?>" <?php //checked($options['showDetailPage'],1);?> >
          <span class="wpremC-enable-slider"></span>
        </label>
      </fieldset>-->


      <fieldset class="labels-right">
        <strong>Job Title HTML Tag - Listings Page</strong>
        <label for="<?php echo $wpremS; ?>-tagArchive">
          <select name="<?php echo $wpremS; ?>[tagArchive]">
            <option value="h2" <?php selected( $options['tagArchive'], 'h2' ); ?>>H2 (Default)</option>
            <option value="h3" <?php selected( $options['tagArchive'], 'h3' ); ?>>H3</option>
            <option value="h4" <?php selected( $options['tagArchive'], 'h4' ); ?>>H4</option>
            <option value="h5" <?php selected( $options['tagArchive'], 'h5' ); ?>>H5</option>
            <option value="h6" <?php selected( $options['tagArchive'], 'h6' ); ?>>H6</option>
          </select>
        </label>
      </fieldset>

      <fieldset class="labels-right">
        <strong>Job Title HTML Tag - Details Page</strong>
        <label for="<?php echo $wpremS; ?>-tagDetail">
          <select name="<?php echo $wpremS; ?>[tagDetail]">
            <option value="h1" <?php selected( $options['tagDetail'], 'h1' ); ?>>H1 (Default)</option>
            <option value="h2" <?php selected( $options['tagDetail'], 'h2' ); ?>>H2</option>
            <option value="h3" <?php selected( $options['tagDetail'], 'h3' ); ?>>H3</option>
            <option value="h4" <?php selected( $options['tagDetail'], 'h4' ); ?>>H4</option>
            <option value="h5" <?php selected( $options['tagDetail'], 'h5' ); ?>>H5</option>
            <option value="h6" <?php selected( $options['tagDetail'], 'h6' ); ?>>H6</option>
          </select>
        </label>
      </fieldset>

      <h2>Add-on Messages</h2>

      <fieldset class="empty-message">
        <strong>No Openings Message</strong>
        <p>Customize the message potential applicants see when there are no open jobs.</p>
        <?php echo wp_editor( $options['emptyCPT'], $wpremS .'-emptyCPT',
        array(
          'textarea_name' => $wpremS .'[emptyCPT]',
          'media_buttons' => false,
          'teeny' => true,
          'textarea_rows' => 8,

        )); ?>
      </fieldset>

      <hr>

      <fieldset>
        <strong>How To Apply</strong>
        <p>Add a message to instruct applicants on how to apply for positions. Leave empty if you do not want any introductory text.</p>
        <?php echo wp_editor( $options['apply'], $wpremS .'-apply',
        array(
          'textarea_name' => $wpremS .'[apply]',
          'media_buttons' => false,
          'teeny' => true,
          'textarea_rows' => 8,

        )); ?>
      </fieldset>

      <h2>Form Integration</h2>

      <fieldset class="labels-right">
        <strong>Enable Forms?</strong>
        <label class="wpremC-enable-switch forms-switch" for="<?php echo $wpremS; ?>-enableForms">
          <input type="checkbox" name="<?php echo $wpremS; ?>[enableForms]" value="<?php echo $options['enableForms']?>" <?php checked($options['enableForms'],1);?> >
          <span class="wpremC-enable-slider disable-toggle"></span>
        </label>
      </fieldset>

      <fieldset class="labels-right hidden-option <?php echo ($options['enableForms'] == true) ? '' : 'option-disabled'; ?>">
        <strong>Select Form</strong>
        <strong>Select form to use for applications</strong>

        <label for="<?php echo $wpremS; ?>-formSelect">
            <select name="<?php echo $wpremS; ?>[formSelect]">
              <option value="" <?php selected( $options['formSelect'], '' ); ?>>Select Form</option>
              <?php
              $forms = RGFormsModel::get_forms( null, 'title' );
              foreach( $forms as $form ):
                $formSelect .= '<option value="' . $form->id . '"' . selected( $options['formSelect'], $form->id ).'>' . $form->title . '</option>';
              endforeach;
              echo "$formSelect";
              ?>
            </select>
        </label>
        <p>Or <a href="admin.php?page=gf_new_form">create a new form</a>.</p>
      </fieldset>

      <h2>Shortcode Settings</h2>

      <?php submit_button('Save all changes', 'primary','submit', TRUE); ?>

    </form>
  </div>