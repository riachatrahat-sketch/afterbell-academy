<?php
/**
 * Class catalog with filters. Also used for subject pages.
 *
 * @package afterbell
 */

get_header();

// phpcs:disable WordPress.Security.NonceVerification.Recommended
$ab_q    = isset( $_GET['q'] ) ? sanitize_text_field( wp_unslash( $_GET['q'] ) ) : '';
$ab_age  = isset( $_GET['age'] ) ? (int) $_GET['age'] : 0;
$ab_subj = isset( $_GET['subj'] ) ? sanitize_title( wp_unslash( $_GET['subj'] ) ) : '';
$ab_track = isset( $_GET['track'] ) ? sanitize_title( wp_unslash( $_GET['track'] ) ) : '';
$ab_format = isset( $_GET['format'] ) ? sanitize_key( $_GET['format'] ) : '';
$ab_price = isset( $_GET['price'] ) ? sanitize_key( $_GET['price'] ) : '';
$ab_band = isset( $_GET['band'] ) ? sanitize_key( $_GET['band'] ) : '';
$ab_sort = isset( $_GET['sort'] ) ? sanitize_key( $_GET['sort'] ) : '';
// phpcs:enable

if ( is_tax( 'ab_subject' ) ) {
	$ab_subj = get_queried_object()->slug;
}
if ( is_tax( 'ab_track' ) ) {
	$ab_track = get_queried_object()->slug;
}
$ab_tracks = get_terms( array( 'taxonomy' => 'ab_track', 'hide_empty' => false ) );
$ab_subjects = get_terms( array( 'taxonomy' => 'ab_subject', 'hide_empty' => false ) );
?>

<section class="page-head">
	<div class="wrap">
		<p class="eyebrow"><?php esc_html_e( 'Class catalog', 'afterbell' ); ?></p>
		<h1 class="page-head__title">
			<?php echo ( is_tax( 'ab_subject' ) || is_tax( 'ab_track' ) ) ? esc_html( single_term_title( '', false ) ) : esc_html__( 'Find a class or tutor', 'afterbell' ); ?>
		</h1>
		<?php if ( ( is_tax( 'ab_subject' ) || is_tax( 'ab_track' ) ) && term_description() ) : ?>
			<div class="page-head__text"><?php echo wp_kses_post( term_description() ); ?></div>
		<?php endif; ?>
	</div>
</section>

<section class="section section--flush">
	<div class="wrap">
		<form class="finder-bar" method="get" action="<?php echo esc_url( ab_classes_url() ); ?>">
			<?php if ( $ab_band ) : ?><input type="hidden" name="band" value="<?php echo esc_attr( $ab_band ); ?>"><?php endif; ?>
			<div class="finder-bar__search">
				<label class="screen-reader-text" for="f-q"><?php esc_html_e( 'Search', 'afterbell' ); ?></label>
				<input id="f-q" type="search" name="q" value="<?php echo esc_attr( $ab_q ); ?>" placeholder="<?php esc_attr_e( 'Search classes and tutors', 'afterbell' ); ?>">
				<button class="btn btn--ink" type="submit"><?php esc_html_e( 'Search', 'afterbell' ); ?></button>
			</div>
			<div class="chip-filters">
				<label class="chip-select"><span class="screen-reader-text"><?php esc_html_e( 'Track', 'afterbell' ); ?></span>
					<select name="track" data-autosubmit>
						<option value=""><?php esc_html_e( 'All tracks', 'afterbell' ); ?></option>
						<?php
						if ( $ab_tracks && ! is_wp_error( $ab_tracks ) ) {
							foreach ( $ab_tracks as $t ) {
								echo '<option value="' . esc_attr( $t->slug ) . '"' . selected( $ab_track, $t->slug, false ) . '>' . esc_html( $t->name ) . '</option>';
							}
						}
						?>
					</select>
				</label>
				<label class="chip-select"><span class="screen-reader-text"><?php esc_html_e( 'Subject', 'afterbell' ); ?></span>
					<select name="subj" data-autosubmit>
						<option value=""><?php esc_html_e( 'Subject', 'afterbell' ); ?></option>
						<?php
						if ( $ab_subjects && ! is_wp_error( $ab_subjects ) ) {
							foreach ( $ab_subjects as $t ) {
								echo '<option value="' . esc_attr( $t->slug ) . '"' . selected( $ab_subj, $t->slug, false ) . '>' . esc_html( $t->name ) . '</option>';
							}
						}
						?>
					</select>
				</label>
				<label class="chip-select"><span class="screen-reader-text"><?php esc_html_e( 'Age', 'afterbell' ); ?></span>
					<select name="age" data-autosubmit>
						<option value=""><?php esc_html_e( 'Age', 'afterbell' ); ?></option>
						<?php for ( $a = 3; $a <= 18; $a++ ) : ?>
							<option value="<?php echo (int) $a; ?>" <?php selected( $ab_age, $a ); ?>><?php /* translators: %d: age */ echo esc_html( sprintf( __( 'Age %d', 'afterbell' ), $a ) ); ?></option>
						<?php endfor; ?>
					</select>
				</label>
				<label class="chip-select"><span class="screen-reader-text"><?php esc_html_e( 'Format', 'afterbell' ); ?></span>
					<select name="format" data-autosubmit>
						<option value=""><?php esc_html_e( 'Class format', 'afterbell' ); ?></option>
						<option value="group" <?php selected( $ab_format, 'group' ); ?>><?php esc_html_e( 'Live group', 'afterbell' ); ?></option>
						<option value="one_to_one" <?php selected( $ab_format, 'one_to_one' ); ?>><?php esc_html_e( '1:1 tutoring', 'afterbell' ); ?></option>
					</select>
				</label>
				<label class="chip-select"><span class="screen-reader-text"><?php esc_html_e( 'Price', 'afterbell' ); ?></span>
					<select name="price" data-autosubmit>
						<option value=""><?php esc_html_e( 'Price', 'afterbell' ); ?></option>
						<?php
						$ab_cur = ab_currency();
						$ab_pr  = array( 'lt30' => 'Under ' . $ab_cur . '30', '30-60' => $ab_cur . '30 to ' . $ab_cur . '60', '60-100' => $ab_cur . '60 to ' . $ab_cur . '100', 'gt100' => $ab_cur . '100 and up' );
						foreach ( $ab_pr as $k => $label ) {
							echo '<option value="' . esc_attr( $k ) . '"' . selected( $ab_price, $k, false ) . '>' . esc_html( $label ) . '</option>';
						}
						?>
					</select>
				</label>
				<label class="chip-select"><span class="screen-reader-text"><?php esc_html_e( 'Sort by', 'afterbell' ); ?></span>
					<select name="sort" data-autosubmit>
						<option value=""><?php esc_html_e( 'Newest', 'afterbell' ); ?></option>
						<option value="price_asc" <?php selected( $ab_sort, 'price_asc' ); ?>><?php esc_html_e( 'Price, low to high', 'afterbell' ); ?></option>
						<option value="price_desc" <?php selected( $ab_sort, 'price_desc' ); ?>><?php esc_html_e( 'Price, high to low', 'afterbell' ); ?></option>
					</select>
				</label>
				<a class="chip-reset" href="<?php echo esc_url( ab_classes_url() ); ?>"><?php esc_html_e( 'Reset', 'afterbell' ); ?></a>
			</div>
		</form>

		<?php if ( have_posts() ) : ?>
			<p class="result-count">
				<?php
				global $wp_query;
				/* translators: %d: number of classes */
				echo esc_html( sprintf( _n( '%d class', '%d classes', (int) $wp_query->found_posts, 'afterbell' ), (int) $wp_query->found_posts ) );
				?>
			</p>
			<div class="grid">
				<?php
				while ( have_posts() ) {
					the_post();
					get_template_part( 'template-parts/class-card' );
				}
				?>
			</div>
			<?php
			the_posts_pagination( array(
				'mid_size'  => 1,
				'prev_text' => __( 'Previous', 'afterbell' ),
				'next_text' => __( 'Next', 'afterbell' ),
			) );
			?>
		<?php else : ?>
			<div class="empty">
				<h2><?php esc_html_e( 'No classes match yet', 'afterbell' ); ?></h2>
				<p><?php esc_html_e( 'Try a different age or subject, or clear the search.', 'afterbell' ); ?></p>
				<a class="btn btn--brass" href="<?php echo esc_url( ab_classes_url() ); ?>"><?php esc_html_e( 'Clear filters', 'afterbell' ); ?></a>
			</div>
		<?php endif; ?>
	</div>
</section>

<?php
get_footer();
