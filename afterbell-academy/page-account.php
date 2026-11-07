<?php
/**
 * Template Name: My account
 *
 * @package afterbell
 */

if ( ! is_user_logged_in() ) {
	wp_safe_redirect( ab_login_url( ab_account_url() ) );
	exit;
}

// phpcs:ignore WordPress.Security.NonceVerification.Recommended
$ab_tab  = isset( $_GET['tab'] ) ? sanitize_key( $_GET['tab'] ) : 'classes';
$ab_tabs = array(
	'classes'      => __( 'Classes', 'afterbell' ),
	'favorites'    => __( 'Favorites', 'afterbell' ),
	'transcripts'  => __( 'Transcripts', 'afterbell' ),
	'transactions' => __( 'Transactions', 'afterbell' ),
	'learners'     => __( 'Learner profiles', 'afterbell' ),
	'messages'     => __( 'Messages', 'afterbell' ),
);
if ( ! isset( $ab_tabs[ $ab_tab ] ) ) {
	$ab_tab = 'classes';
}
$ab_learners = ab_learners();

get_header();
?>

<section class="dash-top">
	<div class="wrap dash-learners">
		<span class="learner-pill learner-pill--all"><?php esc_html_e( 'All', 'afterbell' ); ?></span>
		<?php foreach ( $ab_learners as $l ) : ?>
			<span class="learner-pill">
				<span class="learner-pill__ring" style="--p:<?php echo (int) ab_learner_progress( $l ); ?>"><?php echo esc_html( ab_initial( $l['name'] ) ); ?></span>
				<span><strong><?php echo esc_html( $l['name'] ); ?></strong><small><?php /* translators: %d: percent */ echo esc_html( sprintf( __( '%d%% complete', 'afterbell' ), ab_learner_progress( $l ) ) ); ?></small></span>
			</span>
		<?php endforeach; ?>
		<a class="learner-pill learner-pill--add" href="<?php echo esc_url( add_query_arg( 'tab', 'learners', ab_account_url() ) ); ?>"><span class="learner-pill__plus" aria-hidden="true">+</span><strong><?php esc_html_e( 'Add a learner', 'afterbell' ); ?></strong></a>
	</div>
</section>

<section class="section section--flush">
	<div class="wrap dash">
		<aside class="dash__side">
			<nav class="side-nav" aria-label="<?php esc_attr_e( 'Account sections', 'afterbell' ); ?>">
				<?php foreach ( $ab_tabs as $key => $label ) : ?>
					<a href="<?php echo esc_url( add_query_arg( 'tab', $key, ab_account_url() ) ); ?>"<?php echo $key === $ab_tab ? ' aria-current="page"' : ''; ?>><?php echo esc_html( $label ); ?></a>
				<?php endforeach; ?>
			</nav>
			<div class="side-promo">
				<strong><?php esc_html_e( 'Afterbell Membership', 'afterbell' ); ?></strong>
				<p><?php esc_html_e( 'Save more each month with Membership.', 'afterbell' ); ?></p>
				<a class="link-arrow" href="<?php echo esc_url( ab_membership_url() ); ?>"><?php esc_html_e( 'Learn how it works', 'afterbell' ); ?></a>
			</div>
		</aside>

		<div class="dash__main">
		<?php if ( 'classes' === $ab_tab ) : ?>
			<div class="dash-card">
				<h2 class="account-h"><?php esc_html_e( 'Classes for all learners', 'afterbell' ); ?></h2>
				<ul class="status-pills">
					<li class="is-on"><?php esc_html_e( 'Enrolled', 'afterbell' ); ?></li>
					<li><?php esc_html_e( 'Completed', 'afterbell' ); ?></li>
					<li><?php esc_html_e( 'Waitlisted', 'afterbell' ); ?></li>
					<li><?php esc_html_e( 'Canceled', 'afterbell' ); ?></li>
				</ul>
				<div class="empty empty--inner">
					<p><?php esc_html_e( 'No classes scheduled yet. Let\'s find the next class.', 'afterbell' ); ?></p>
					<a class="btn btn--ghost" href="<?php echo esc_url( ab_classes_url() ); ?>"><?php esc_html_e( 'Browse classes', 'afterbell' ); ?></a>
				</div>
			</div>
			<div class="dash-card">
				<h2 class="account-h"><?php esc_html_e( 'Your learners might also like...', 'afterbell' ); ?></h2>
				<ul class="chips">
					<li><a href="<?php echo esc_url( ab_browse_url( array( 'format' => 'one_to_one' ) ) ); ?>"><?php esc_html_e( 'Popular tutors', 'afterbell' ); ?></a></li>
					<li><a href="<?php echo esc_url( ab_browse_url( array( 'track' => 'homeschool-academics' ) ) ); ?>"><?php esc_html_e( 'Homeschool courses', 'afterbell' ); ?></a></li>
					<li><a href="<?php echo esc_url( ab_browse_url( array( 'track' => 'leadership' ) ) ); ?>"><?php esc_html_e( 'Leadership clubs', 'afterbell' ); ?></a></li>
					<li><a href="<?php echo esc_url( ab_browse_url( array( 'track' => 'enrichment' ) ) ); ?>"><?php esc_html_e( 'Enrichment', 'afterbell' ); ?></a></li>
				</ul>
			</div>

		<?php elseif ( 'favorites' === $ab_tab ) : ?>
			<?php
			$ab_ids = ab_favs();
			$ab_q   = $ab_ids ? new WP_Query( array( 'post_type' => 'ab_class', 'post__in' => $ab_ids, 'orderby' => 'post__in', 'posts_per_page' => 24, 'no_found_rows' => true ) ) : null;
			if ( $ab_q && $ab_q->have_posts() ) :
				?>
				<div class="grid grid--tight">
					<?php
					while ( $ab_q->have_posts() ) {
						$ab_q->the_post();
						get_template_part( 'template-parts/class-card' );
					}
					wp_reset_postdata();
					?>
				</div>
			<?php else : ?>
				<div class="empty">
					<h2><?php esc_html_e( 'No favorites yet', 'afterbell' ); ?></h2>
					<p><?php esc_html_e( 'Tap the heart on any class to save it here.', 'afterbell' ); ?></p>
					<a class="btn btn--brass" href="<?php echo esc_url( ab_classes_url() ); ?>"><?php esc_html_e( 'Browse classes', 'afterbell' ); ?></a>
				</div>
			<?php endif; ?>

		<?php elseif ( 'learners' === $ab_tab ) : ?>
			<div class="account-cols">
				<div>
					<h2 class="account-h"><?php esc_html_e( 'Your learners', 'afterbell' ); ?></h2>
					<?php if ( $ab_learners ) : ?>
						<ul class="learners">
							<?php foreach ( $ab_learners as $i => $l ) : ?>
								<li>
									<span class="teacher__avatar" aria-hidden="true"><?php echo esc_html( ab_initial( $l['name'] ) ); ?></span>
									<div>
										<strong><?php echo esc_html( $l['name'] ); ?></strong>
										<span>
											<?php
											$bits = array();
											if ( ! empty( $l['age'] ) ) {
												/* translators: %d: age */
												$bits[] = sprintf( __( 'Age %d', 'afterbell' ), (int) $l['age'] );
											}
											if ( ! empty( $l['grade'] ) ) {
												$bits[] = $l['grade'];
											}
											if ( ! empty( $l['interests'] ) ) {
												$opts   = ab_interest_options();
												$names  = array();
												foreach ( array_slice( $l['interests'], 0, 3 ) as $k ) {
													if ( isset( $opts[ $k ] ) ) {
														$names[] = $opts[ $k ];
													}
												}
												$bits[] = implode( ', ', $names );
											}
											echo esc_html( implode( ' / ', array_filter( $bits ) ) );
											?>
										</span>
									</div>
									<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
										<input type="hidden" name="action" value="ab_learner">
										<input type="hidden" name="op" value="remove">
										<input type="hidden" name="index" value="<?php echo (int) $i; ?>">
										<?php wp_nonce_field( 'ab_learner' ); ?>
										<button class="link-btn" type="submit"><?php esc_html_e( 'Remove', 'afterbell' ); ?></button>
									</form>
								</li>
							<?php endforeach; ?>
						</ul>
					<?php else : ?>
						<p><?php esc_html_e( 'Add a profile for each child so you can match classes to their age and grade.', 'afterbell' ); ?></p>
					<?php endif; ?>
				</div>
				<div class="apply">
					<h2><?php esc_html_e( 'Add a learner', 'afterbell' ); ?></h2>
					<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
						<input type="hidden" name="action" value="ab_learner">
						<input type="hidden" name="op" value="add">
						<?php wp_nonce_field( 'ab_learner' ); ?>
						<div class="field"><label for="l_name"><?php esc_html_e( 'First name', 'afterbell' ); ?></label><input type="text" id="l_name" name="l_name" required></div>
						<div class="field"><label for="l_age"><?php esc_html_e( 'Age', 'afterbell' ); ?></label><input type="number" id="l_age" name="l_age" min="3" max="18"></div>
						<div class="field"><label for="l_grade"><?php esc_html_e( 'Grade', 'afterbell' ); ?></label><input type="text" id="l_grade" name="l_grade"></div>
						<button class="btn btn--ink btn--block" type="submit"><?php esc_html_e( 'Add learner', 'afterbell' ); ?></button>
					</form>
				</div>
			</div>

		<?php elseif ( 'transcripts' === $ab_tab ) : ?>
			<div class="empty"><h2><?php esc_html_e( 'No transcripts yet', 'afterbell' ); ?></h2><p><?php esc_html_e( 'Completed courses will be listed here once enrollment is connected.', 'afterbell' ); ?></p></div>
		<?php elseif ( 'transactions' === $ab_tab ) : ?>
			<div class="empty"><h2><?php esc_html_e( 'No transactions yet', 'afterbell' ); ?></h2><p><?php esc_html_e( 'Payments and receipts will appear here once checkout is connected.', 'afterbell' ); ?></p></div>
		<?php else : ?>
			<div class="empty"><h2><?php esc_html_e( 'Messages', 'afterbell' ); ?></h2><p><?php esc_html_e( 'To contact a teacher or our team, write to us and we will pass it on.', 'afterbell' ); ?></p><a class="btn btn--brass" href="mailto:<?php echo esc_attr( ab_contact_email() ); ?>"><?php echo esc_html( ab_contact_email() ); ?></a></div>
		<?php endif; ?>
		</div>
	</div>
</section>

<?php
get_footer();
