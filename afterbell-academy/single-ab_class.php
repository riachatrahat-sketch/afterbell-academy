<?php
/**
 * Single class page.
 *
 * @package afterbell
 */

get_header();

while ( have_posts() ) :
	the_post();
	$ab_id    = get_the_ID();
	$ab_terms = get_the_terms( $ab_id, 'ab_subject' );
	$ab_term  = ( $ab_terms && ! is_wp_error( $ab_terms ) ) ? $ab_terms[0] : null;
	$ab_one   = ab_is_one_to_one( $ab_id );
	$ab_tid   = ab_teacher_id( $ab_id );
	$ab_who   = ab_teacher_name( $ab_id );
	$ab_seats = (int) ab_meta( $ab_id, 'seats' );
	$ab_weeks = (int) ab_meta( $ab_id, 'weeks' );

	$ab_facts = array(
		__( 'Ages', 'afterbell' )   => ab_age_label( $ab_id ),
		__( 'Grades', 'afterbell' ) => ab_meta( $ab_id, 'grade' ),
		__( 'Class size', 'afterbell' ) => $ab_one ? __( '1-on-1', 'afterbell' ) : ( $ab_seats ? sprintf( /* translators: %d: learners */ __( 'Up to %d', 'afterbell' ), $ab_seats ) : '' ),
		__( 'Schedule', 'afterbell' ) => ab_meta( $ab_id, 'schedule' ),
	);
	$ab_rows = array(
		__( 'Format', 'afterbell' )       => $ab_one ? __( 'Live 1-on-1 lessons', 'afterbell' ) : __( 'Live group class', 'afterbell' ),
		__( 'Meets', 'afterbell' )        => ab_meta( $ab_id, 'schedule' ),
		__( 'Each session', 'afterbell' ) => ab_meta( $ab_id, 'duration' ),
		__( 'Length', 'afterbell' )       => $ab_weeks ? sprintf( /* translators: %d: weeks */ _n( '%d week', '%d weeks', $ab_weeks, 'afterbell' ), $ab_weeks ) : '',
		__( 'Where', 'afterbell' )        => __( 'Live video meetings', 'afterbell' ),
		__( 'Ages', 'afterbell' )         => ab_age_label( $ab_id ),
	);

	$ab_url = ab_meta( $ab_id, 'enroll_url' );
	if ( ! $ab_url ) {
		$ab_url = 'mailto:' . ab_contact_email() . '?subject=' . rawurlencode( 'Enrol: ' . get_the_title() );
	}
	$ab_ask      = 'mailto:' . ab_contact_email() . '?subject=' . rawurlencode( 'Question about: ' . get_the_title() );
	$ab_outcomes = array_filter( array_map( 'trim', preg_split( '/\r\n|\r|\n/', (string) ab_meta( $ab_id, 'outcomes' ) ) ) );
	$ab_prereq   = ab_meta( $ab_id, 'prerequisites' );
	$ab_needs    = ab_meta( $ab_id, 'needs_support' );
	$ab_supplies = ab_meta( $ab_id, 'supplies' );
	$ab_vet      = get_theme_mod( 'ab_vetting_text', '' );
	?>

	<section class="page-head page-head--class tone-<?php echo (int) ( $ab_id % 6 ); ?>">
		<div class="wrap">
			<p class="crumbs"><a href="<?php echo esc_url( ab_classes_url() ); ?>"><?php esc_html_e( 'All classes', 'afterbell' ); ?></a>
				<?php if ( $ab_term ) : ?> / <a href="<?php echo esc_url( get_term_link( $ab_term ) ); ?>"><?php echo esc_html( $ab_term->name ); ?></a><?php endif; ?>
			</p>
			<h1 class="page-head__title"><?php the_title(); ?></h1>
			<?php if ( has_excerpt() ) : ?>
				<p class="page-head__text"><?php echo esc_html( get_the_excerpt() ); ?></p>
			<?php endif; ?>
			<div class="class-actions">
				<form class="fav-inline" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
					<input type="hidden" name="action" value="ab_toggle_fav">
					<input type="hidden" name="post_id" value="<?php echo (int) $ab_id; ?>">
					<?php wp_nonce_field( 'ab_fav_' . $ab_id ); ?>
					<button type="submit" class="pill-btn<?php echo ab_is_fav( $ab_id ) ? ' is-on' : ''; ?>"><?php echo ab_is_fav( $ab_id ) ? esc_html__( 'Saved', 'afterbell' ) : esc_html__( 'Save', 'afterbell' ); ?></button>
				</form>
				<button type="button" class="pill-btn" data-share><?php esc_html_e( 'Share', 'afterbell' ); ?></button>
			</div>
		</div>
	</section>

	<section class="section section--flush">
		<div class="wrap class-layout">
			<article class="class-body">
				<ul class="facts-row">
					<?php foreach ( $ab_facts as $label => $value ) : ?>
						<?php if ( $value ) : ?><li><small><?php echo esc_html( $label ); ?></small><strong><?php echo esc_html( $value ); ?></strong></li><?php endif; ?>
					<?php endforeach; ?>
				</ul>

				<?php if ( $ab_who ) : ?>
					<div class="teacher">
						<span class="teacher__avatar" aria-hidden="true"><?php echo esc_html( ab_initial( $ab_who ) ); ?></span>
						<div>
							<h2 class="teacher__name"><?php echo esc_html( $ab_who ); ?></h2>
							<?php if ( $ab_tid ) : ?>
								<p class="teacher__line"><?php echo ab_rating_html( $ab_tid ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper. ?> <?php echo esc_html( ab_teacher_meta( $ab_tid, 'headline' ) ); ?></p>
								<a class="link-arrow" href="<?php echo esc_url( get_permalink( $ab_tid ) ); ?>"><?php esc_html_e( 'View full profile', 'afterbell' ); ?></a>
							<?php endif; ?>
						</div>
					</div>
					<?php if ( $ab_vet ) : ?><p class="vetting"><?php echo esc_html( $ab_vet ); ?></p><?php endif; ?>
				<?php endif; ?>

				<?php if ( $ab_outcomes ) : ?>
					<h2 class="class-h"><?php esc_html_e( 'In this class, your learner will:', 'afterbell' ); ?></h2>
					<ul class="outcomes">
						<?php foreach ( $ab_outcomes as $o ) : ?><li><?php echo esc_html( $o ); ?></li><?php endforeach; ?>
					</ul>
				<?php endif; ?>

				<?php if ( $ab_prereq ) : ?>
					<h2 class="class-h"><?php esc_html_e( 'Prerequisites', 'afterbell' ); ?></h2>
					<p><?php echo esc_html( $ab_prereq ); ?></p>
				<?php endif; ?>
				<?php if ( $ab_needs ) : ?>
					<h2 class="class-h"><?php esc_html_e( 'Learning needs support', 'afterbell' ); ?></h2>
					<p><?php echo esc_html( $ab_needs ); ?></p>
				<?php endif; ?>

				<h2 class="class-h"><?php esc_html_e( 'All about this class', 'afterbell' ); ?></h2>
				<?php if ( has_post_thumbnail() ) : ?>
					<div class="class-body__img"><?php the_post_thumbnail( 'large' ); ?></div>
				<?php endif; ?>
				<div class="prose"><?php the_content(); ?></div>

				<?php if ( $ab_supplies ) : ?>
					<h2 class="class-h"><?php esc_html_e( 'Additional details', 'afterbell' ); ?></h2>
					<p><?php echo esc_html( $ab_supplies ); ?></p>
				<?php endif; ?>
			</article>

			<aside class="enroll" aria-label="<?php esc_attr_e( 'Enroll', 'afterbell' ); ?>">
				<p class="enroll__type"><?php echo $ab_one ? esc_html__( 'Live 1-on-1 lessons', 'afterbell' ) : esc_html__( 'Live group class', 'afterbell' ); ?></p>
				<p class="enroll__price"><?php echo esc_html( ab_price( $ab_id ) ); ?> <span><?php echo esc_html( ab_price_unit( $ab_id ) ); ?></span></p>
				<dl class="enroll__list">
					<?php foreach ( $ab_rows as $label => $value ) : ?>
						<?php if ( $value ) : ?>
							<div><dt><?php echo esc_html( $label ); ?></dt><dd><?php echo esc_html( $value ); ?></dd></div>
						<?php endif; ?>
					<?php endforeach; ?>
				</dl>
				<a class="btn btn--brass btn--block" href="<?php echo esc_url( $ab_url, array( 'http', 'https', 'mailto' ) ); ?>"><?php echo $ab_one ? esc_html__( 'Book a trial session', 'afterbell' ) : esc_html__( 'See available times', 'afterbell' ); ?></a>
				<a class="btn btn--ghost btn--block" href="<?php echo esc_url( $ab_ask, array( 'mailto' ) ); ?>"><?php esc_html_e( 'Ask a question', 'afterbell' ); ?></a>
			</aside>
		</div>
	</section>

	<?php
	if ( $ab_tid ) :
		$ab_more = new WP_Query( array(
			'post_type'      => 'ab_class',
			'posts_per_page' => 4,
			'post__not_in'   => array( $ab_id ),
			'no_found_rows'  => true,
			'meta_query'     => array( array( 'key' => '_ab_teacher_id', 'value' => $ab_tid ) ),
		) );
		if ( $ab_more->have_posts() ) :
			?>
			<section class="section">
				<div class="wrap">
					<div class="section__head"><h2 class="section__title"><?php esc_html_e( 'Other classes by', 'afterbell' ); ?> <em><?php echo esc_html( $ab_who ); ?></em></h2></div>
					<div class="grid">
						<?php
						while ( $ab_more->have_posts() ) {
							$ab_more->the_post();
							get_template_part( 'template-parts/class-card' );
						}
						wp_reset_postdata();
						?>
					</div>
				</div>
			</section>
			<?php
		endif;
	endif;

	$ab_related = new WP_Query( array(
		'post_type'      => 'ab_class',
		'posts_per_page' => 4,
		'post__not_in'   => array( $ab_id ),
		'no_found_rows'  => true,
		'tax_query'      => $ab_term ? array( array( 'taxonomy' => 'ab_subject', 'field' => 'term_id', 'terms' => $ab_term->term_id ) ) : array(),
	) );
	if ( $ab_related->have_posts() ) :
		?>
		<section class="section section--tint">
			<div class="wrap">
				<div class="section__head"><h2 class="section__title"><?php esc_html_e( 'More like', 'afterbell' ); ?> <em><?php esc_html_e( 'this', 'afterbell' ); ?></em></h2></div>
				<div class="grid">
					<?php
					while ( $ab_related->have_posts() ) {
						$ab_related->the_post();
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
