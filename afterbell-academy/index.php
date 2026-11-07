<?php
/**
 * Fallback template: blog index, search and archives.
 *
 * @package afterbell
 */

get_header();
?>
<section class="page-head">
	<div class="wrap">
		<h1 class="page-head__title">
			<?php
			if ( is_search() ) {
				/* translators: %s: search query */
				printf( esc_html__( 'Results for %s', 'afterbell' ), '<span>' . esc_html( get_search_query() ) . '</span>' );
			} elseif ( is_archive() ) {
				the_archive_title();
			} else {
				esc_html_e( 'Journal', 'afterbell' );
			}
			?>
		</h1>
	</div>
</section>

<section class="section section--flush">
	<div class="wrap">
		<?php if ( have_posts() ) : ?>
			<div class="grid">
				<?php while ( have_posts() ) : the_post(); ?>
					<?php if ( 'ab_class' === get_post_type() ) : ?>
						<?php get_template_part( 'template-parts/class-card' ); ?>
					<?php else : ?>
						<article class="card tone-<?php echo (int) ( get_the_ID() % 6 ); ?>">
							<div class="card__body">
								<p class="tag"><?php echo esc_html( get_the_date() ); ?></p>
								<h2 class="card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
								<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 24 ) ); ?></p>
							</div>
						</article>
					<?php endif; ?>
				<?php endwhile; ?>
			</div>
			<?php the_posts_pagination(); ?>
		<?php else : ?>
			<div class="empty">
				<h2><?php esc_html_e( 'Nothing here yet', 'afterbell' ); ?></h2>
				<p><?php esc_html_e( 'Try searching for a class instead.', 'afterbell' ); ?></p>
				<a class="btn btn--brass" href="<?php echo esc_url( ab_classes_url() ); ?>"><?php esc_html_e( 'Browse classes', 'afterbell' ); ?></a>
			</div>
		<?php endif; ?>
	</div>
</section>
<?php
get_footer();
