<?php
/**
 * Blog post template.
 *
 * @package afterbell
 */

get_header();

while ( have_posts() ) :
	the_post();
	?>
	<section class="page-head">
		<div class="wrap wrap--narrow">
			<p class="eyebrow"><?php echo esc_html( get_the_date() ); ?></p>
			<h1 class="page-head__title"><?php the_title(); ?></h1>
		</div>
	</section>
	<section class="section section--flush">
		<div class="wrap wrap--narrow">
			<?php if ( has_post_thumbnail() ) : ?>
				<div class="class-body__img"><?php the_post_thumbnail( 'large' ); ?></div>
			<?php endif; ?>
			<div class="prose"><?php the_content(); ?></div>
		</div>
	</section>
	<?php
endwhile;

get_footer();
