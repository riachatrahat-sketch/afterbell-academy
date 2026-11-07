<?php
/**
 * Teacher profile.
 *
 * @package afterbell
 */

get_header();

while ( have_posts() ) :
	the_post();
	$ab_tid  = get_the_ID();
	$ab_head = ab_teacher_meta( $ab_tid, 'headline' );
	$ab_cred = ab_teacher_meta( $ab_tid, 'credential' );
	$ab_rate = ab_rating_html( $ab_tid );
	?>

	<section class="page-head page-head--feature">
		<div class="wrap tprof">
			<span class="tprof__avatar" aria-hidden="true">
				<?php
				if ( has_post_thumbnail() ) {
					the_post_thumbnail( 'thumbnail' );
				} else {
					echo esc_html( ab_initial( get_the_title() ) );
				}
				?>
			</span>
			<div>
				<p class="eyebrow"><?php esc_html_e( 'Teacher', 'afterbell' ); ?></p>
				<h1 class="page-head__title"><?php the_title(); ?></h1>
				<?php if ( $ab_head ) : ?><p class="page-head__text"><?php echo esc_html( $ab_head ); ?></p><?php endif; ?>
				<p class="tprof__chips">
					<?php if ( $ab_cred ) : ?><span class="chip-pill"><?php echo esc_html( $ab_cred ); ?></span><?php endif; ?>
					<?php echo $ab_rate; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper. ?>
				</p>
			</div>
		</div>
	</section>

	<section class="section section--flush">
		<div class="wrap wrap--narrow">
			<div class="section__head"><h2 class="section__title"><?php esc_html_e( 'About', 'afterbell' ); ?> <em><?php the_title(); ?></em></h2></div>
			<div class="prose"><?php the_content(); ?></div>
		</div>
	</section>

	<?php
	$ab_classes = new WP_Query( array(
		'post_type'      => 'ab_class',
		'posts_per_page' => 12,
		'no_found_rows'  => true,
		'meta_query'     => array( array( 'key' => '_ab_teacher_id', 'value' => $ab_tid ) ),
	) );
	if ( $ab_classes->have_posts() ) :
		?>
		<section class="section section--tint">
			<div class="wrap">
				<div class="section__head"><h2 class="section__title"><?php esc_html_e( 'Classes by', 'afterbell' ); ?> <em><?php the_title(); ?></em></h2></div>
				<div class="grid">
					<?php
					while ( $ab_classes->have_posts() ) {
						$ab_classes->the_post();
						get_template_part( 'template-parts/class-card' );
					}
					wp_reset_postdata();
					?>
				</div>
			</div>
		</section>
	<?php endif; ?>

<?php endwhile;

get_footer();
