<?php
/**
 * Template Name: Blog
 *
 * @package afterbell
 */

get_header();

$ab_paged = max( 1, (int) get_query_var( 'paged' ), (int) get_query_var( 'page' ) );
$ab_posts = new WP_Query( array( 'post_type' => 'post', 'posts_per_page' => 9, 'paged' => $ab_paged ) );
?>

<section class="page-head">
	<div class="wrap">
		<p class="eyebrow"><?php esc_html_e( 'Blog', 'afterbell' ); ?></p>
		<h1 class="page-head__title"><?php esc_html_e( 'Ideas for homeschooling and raising leaders', 'afterbell' ); ?></h1>
	</div>
</section>

<section class="section section--flush">
	<div class="wrap">
		<?php if ( $ab_posts->have_posts() ) : ?>
			<div class="grid">
				<?php while ( $ab_posts->have_posts() ) : $ab_posts->the_post(); ?>
					<article class="card tone-<?php echo (int) ( get_the_ID() % 6 ); ?>">
						<div class="card__body">
							<p class="tag"><?php echo esc_html( get_the_date() ); ?></p>
							<h2 class="card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
							<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 24 ) ); ?></p>
						</div>
					</article>
				<?php endwhile; wp_reset_postdata(); ?>
			</div>
			<?php
			echo wp_kses_post( paginate_links( array(
				'total'   => $ab_posts->max_num_pages,
				'current' => $ab_paged,
				'type'    => 'list',
			) ) );
			?>
		<?php else : ?>
			<div class="empty">
				<h2><?php esc_html_e( 'No articles yet', 'afterbell' ); ?></h2>
				<p><?php esc_html_e( 'Add posts in the WordPress admin and they will appear here.', 'afterbell' ); ?></p>
			</div>
		<?php endif; ?>
	</div>
</section>

<?php
get_footer();
