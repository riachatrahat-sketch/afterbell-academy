<?php
/**
 * Template Name: Explore categories
 *
 * @package afterbell
 */

get_header();

$ab_tracks   = get_terms( array( 'taxonomy' => 'ab_track', 'hide_empty' => false ) );
$ab_subjects = get_terms( array( 'taxonomy' => 'ab_subject', 'hide_empty' => false ) );
$ab_blurbs   = array(
	'homeschool-academics' => __( 'Core subjects taught live by grade.', 'afterbell' ),
	'tutoring'             => __( 'One learner, one tutor, your schedule.', 'afterbell' ),
	'leadership'           => __( 'Speaking, debate, business and teamwork.', 'afterbell' ),
	'enrichment'           => __( 'Clubs and hobbies that spark curiosity.', 'afterbell' ),
);
?>

<section class="page-head page-head--feature">
	<div class="wrap">
		<p class="eyebrow"><?php esc_html_e( 'Explore', 'afterbell' ); ?></p>
		<h1 class="page-head__title"><?php esc_html_e( 'Every track and subject in one place.', 'afterbell' ); ?></h1>
		<p class="page-head__text"><?php esc_html_e( 'Start with a track, then narrow by subject, age and format.', 'afterbell' ); ?></p>
	</div>
</section>

<section class="section">
	<div class="wrap">
		<div class="section__head"><h2 class="section__title"><?php esc_html_e( 'Tracks', 'afterbell' ); ?></h2></div>
		<?php if ( $ab_tracks && ! is_wp_error( $ab_tracks ) ) : ?>
			<ul class="subjects subjects--wide">
				<?php foreach ( $ab_tracks as $i => $t ) : ?>
					<li>
						<a class="subject tone-<?php echo (int) ( $i % 6 ); ?>" href="<?php echo esc_url( get_term_link( $t ) ); ?>">
							<span class="subject__name"><?php echo esc_html( $t->name ); ?></span>
							<span class="subject__count"><?php echo esc_html( isset( $ab_blurbs[ $t->slug ] ) ? $ab_blurbs[ $t->slug ] : '' ); ?></span>
							<span class="subject__count">
								<?php
								/* translators: %d: number of classes */
								echo esc_html( sprintf( _n( '%d class', '%d classes', (int) $t->count, 'afterbell' ), (int) $t->count ) );
								?>
							</span>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
	</div>
</section>

<section class="section section--tint">
	<div class="wrap">
		<div class="section__head"><h2 class="section__title"><?php esc_html_e( 'Subjects', 'afterbell' ); ?></h2></div>
		<?php if ( $ab_subjects && ! is_wp_error( $ab_subjects ) ) : ?>
			<ul class="subjects">
				<?php foreach ( $ab_subjects as $i => $t ) : ?>
					<li>
						<a class="subject tone-<?php echo (int) ( ( $i + 2 ) % 6 ); ?>" href="<?php echo esc_url( get_term_link( $t ) ); ?>">
							<span class="subject__name"><?php echo esc_html( $t->name ); ?></span>
							<span class="subject__count">
								<?php
								/* translators: %d: number of classes */
								echo esc_html( sprintf( _n( '%d class', '%d classes', (int) $t->count, 'afterbell' ), (int) $t->count ) );
								?>
							</span>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
	</div>
</section>

<section class="section">
	<div class="wrap">
		<div class="section__head"><h2 class="section__title"><?php esc_html_e( 'Browse by age', 'afterbell' ); ?></h2></div>
		<ul class="bands">
			<?php foreach ( ab_age_bands() as $key => $b ) : ?>
				<li>
					<a class="band" href="<?php echo esc_url( ab_browse_url( array( 'band' => $key ) ) ); ?>">
						<span class="band__ages"><?php echo (int) $b[0]; ?>&ndash;<?php echo (int) $b[1]; ?></span>
						<span class="band__name"><?php echo esc_html( $b[2] ); ?></span>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>

<?php
get_footer();
