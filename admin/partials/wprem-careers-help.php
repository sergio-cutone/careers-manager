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
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class="wrap wprem-careers-admin doc-layout">
	<h1><span>Website</span> Premium<br>
	<small>Careers Add-on Documention</small></h1>
	<p>Need some help with your add-on? You've come to the right place!</p>
	<p>We've put together a few notes to help you on your way. If you have any more questions, feel free to <a href="#">contact us</a>.</p>
	<h2>Shortcodes</h2>
	<p>Fusce maximus nisi in velit viverra blandit. Ut id scelerisque ipsum. Nam condimentum vulputate arcu eget commodo. Nam eget dictum tortor, eu mattis ante. Nunc sit amet molestie nulla, sed interdum ante. Pellentesque hendrerit leo enim, at varius diam ultrices eu. Sed posuere quis lacus eu condimentum.</p>
	<pre><code>[wprem_careers]</code></pre>
	<style>
	table tr:nth-child(even) {
		background: rgba(225, 225, 225, 0.6);
	}
	table td {
	 padding: 0.5em;
	}
	table th {
	 text-align: left !important;
	}
	</style>
	<table class="table" style="width: 100%;">
		<tr>
			<th colspan="4">Shortcodes with Parameters</th>
		</tr>
		<tr>
			<th width="20%">Parameter</th>
			<td width="40%">Description</td>
			<td>Default</td>
			<td>Other Parameters</td>
		</tr>
		<tr>
			<th>id</th>
			<td>
				Displays individual job posting
			</td>
			<td></td>
			<td>To find post id number go to <a href="edit.php?post_type=wprem_careers">all job postings</a> and hover over job posting</td>
		</tr>
		<tr>
			<th>posted</th>
			<td>Displays Date Posted on job listing</td>
			<td>0</td>
			<td>1</td>
		</tr>
		<tr>
			<th>ref</th>
			<td>Displays Reference ID on job listing</td>
			<td>0</td>
			<td>1</td>
		</tr>
		<tr>
			<th>exp</th>
			<td>Displays Expiry Date on job listing</td>
			<td>0</td>
			<td>1</td>
		</tr>
		<tr>
			<th>comp</th>
			<td>Displays Compensation on job listing</td>
			<td>0</td>
			<td>1</td>
		</tr>
		<tr>
			<th>type</th>
			<td>Displays Job Type on job listing</td>
			<td>0</td>
			<td>1</td>
		</tr>
		<tr>
			<th>link</th>
			<td>Type of link on the search listings page: Internal will lead to another internal page, External will link out to the external job posting, None will disable any linking</td>
			<td>internal</td>
			<td>external, none</td>
		</tr>
		<tr>
			<th>desc</th>
			<td>Length of description shown</td>
			<td>short</td>
			<td>full, none</td>
		</tr>
		<tr>
			<th>searchbar</th>
			<td>Displays search bar</td>
			<td>0</td>
			<td>1</td>
		</tr>
	</table>
	<p><strong>Example:</strong></p>
	<pre><code>[wprem_careers id="36" link="external" searchbar="1" desc="short"]</code></pre>
	<h2>Layout Options</h2>
	<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec eleifend volutpat magna eget commodo. Phasellus consequat sit amet sapien quis ultricies. Interdum et malesuada fames ac ante ipsum primis in faucibus. Fusce ullamcorper ac est nec viverra. Phasellus nisl nulla, vehicula sed velit non, facilisis lobortis nulla. Nulla euismod quis nunc in bibendum. Curabitur nec dapibus felis.</p>
	<h2>Display Options</h2>
	<p>Cras blandit pharetra elit id facilisis. Integer imperdiet libero vel convallis rhoncus. In at nisi ante. Praesent luctus commodo nunc, condimentum tempus turpis. Vivamus et luctus tellus, in posuere lectus. In ultricies nec urna sed sollicitudin. Proin euismod faucibus pellentesque. Etiam risus ipsum, consectetur at placerat et, tempus vel ligula. Proin commodo posuere auctor. Integer elementum at turpis id fringilla. Nullam porttitor mi arcu, vitae gravida lacus iaculis in. Sed pharetra orci non volutpat lacinia.</p>
	<table>
		<tr>
			<th>Display Reference #</th>
			<td></td>
		</tr>
		<tr>
			<th>Display Expiry Date</th>
			<td></td>
		</tr>
		<tr>
			<th>Display Compensation</th>
			<td></td>
		</tr>
		<tr>
			<th>Display Job Type</th>
			<td></td>
		</tr>
		<tr>
			<th>Job Title HTML Tag - Listings Page</th>
			<td></td>
		</tr>
		<tr>
			<th>Job Title HTML Tag - Details Page</th>
			<td></td>
		</tr>
	</table>
	<h2>Add-on Messages</h2>
	<p>Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Aenean tincidunt fermentum scelerisque. Ut semper auctor sapien a dapibus. Suspendisse accumsan, magna ut iaculis varius, nisl urna volutpat enim, at tincidunt risus sapien at diam. Mauris varius, turpis non viverra suscipit, sem sapien viverra tellus, dictum ultrices tortor turpis in metus. Proin mattis ante at maximus placerat. Vivamus eget ante ac nunc tristique dignissim. Nulla sed mi tincidunt, feugiat libero nec, maximus turpis. Aenean rhoncus nulla purus. Sed congue nunc vel luctus semper. Curabitur lacinia ornare nunc, ac lacinia mi sollicitudin sit amet. Nunc cursus varius convallis. Aliquam lacinia suscipit tortor, congue porttitor leo semper et. Cras at risus quis lacus faucibus interdum quis sed velit. Donec gravida felis sodales nisl placerat tempus.</p>
  <strong>No Openings Message</strong>
  <p>Customize the message potential applicants see when there are no open jobs.</p>
  <strong>How To Apply</strong>
  <p>Add a message to instruct applicants on how to apply for positions. Leave empty if you do not want any introductory text.</p>
	<h2>Form Integration</h2>
	<p>Fusce maximus nisi in velit viverra blandit. Ut id scelerisque ipsum. Nam condimentum vulputate arcu eget commodo. Nam eget dictum tortor, eu mattis ante. Nunc sit amet molestie nulla, sed interdum ante. Pellentesque hendrerit leo enim, at varius diam ultrices eu. Sed posuere quis lacus eu condimentum.</p>
</div>