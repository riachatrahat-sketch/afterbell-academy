<?php
/**
 * Default page template.
 *
 * @package afterbell
 */

get_header();

while ( have_posts() ) :
	the_post();
	?>
	<section class="page-head">
		<div class="wrap wrap--narrow">
			<h1 class="page-head__title"><?php the_title(); ?></h1>
		</div>
	</section>
	<section class="section section--flush">
		<div class="wrap wrap--narrow">
			<div class="prose"><?php the_content(); ?></div>
		</div>
	</section>
	<?php
endwhile;

get_footer();
