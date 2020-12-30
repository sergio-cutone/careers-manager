<?php get_header(); ?>

<div class="container">
	<div class="row">
		<div class="fl-content col-md-12">
			<?php
			if ( have_posts() ) :
				while ( have_posts() ) :
					the_post();
					//get_template_part( 'content', 'single' );
					the_content();
				endwhile;
			endif;
			?>
		</div>
	</div>
</div>

<?php get_footer(); ?>
